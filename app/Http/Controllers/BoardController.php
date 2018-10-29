<?php

namespace App\Http\Controllers;

use App\Board;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class BoardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get list of boards for existing user...
        $boards = $request->user()->boards()->orderBy('name', 'asc')->get();

        return view('boards.index', [
            'boards' => $boards,
            'page_title' => 'Current Boards',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required|max:255',
        ]);
    
        if ($validator->fails()) {
            return redirect('/boards')
                ->withInput()
                ->withErrors($validator);
        }
    
        $board = new Board;
        $board->name = $request->name;
        $board->description = $request->description;
        $board->status = '';
        // $board->user_id = $request->user()->id;
        $board->save();

        $request->user()->boards()->attach($board->id, ['is_owner' => true, 'can_write' => true]);

        return redirect('/boards');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        // Get list of boards for existing user...
        $boards = $request->user()->boards()->orderBy('name', 'asc')->get();

        // Get requested board
        $board = $request->user()->boards()->findOrFail($id);
        
        $shared_users = array();


        /* if ($board->user_id !== $request->user()->id) {
            return redirect('/boards')->withErrors(['You do not have permission to view that board!']);
        } else { 
            return view('boards.show', [
                'board' => $board,
                'boards' => $boards,
                'page_title' => $board->name,
            ]);
        } */

        return view('boards.show', [
            'board' => $board,
            'boards' => $boards,
            'page_title' => $board->name,
            'shared_users' => $shared_users
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function edit(Board $board)
    {
        // Boards for the nav menu
        $boards = Auth::User()->boards()->orderBy('name', 'asc')->get();

        // Find this specific board
        //$board = Board::findOrFail($id);

        return view('boards.edit', [
            'board' => $board,
            'boards' => $boards,
            'page_title' => 'Edit Board - ' . $board->title
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Board $board)
    {
        // Boards for the nav menu
        $boards = Auth::User()->boards()->orderBy('name', 'asc')->get();

        // Find this specific board
        // $board = Board::findOrFail($id);

        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'required',
        ]);

        // Redirect if validation fails
        if ($validator->fails()) {
            return redirect('/boards/' . $request->board_id . '/edit')
                ->withInput()
                ->withErrors($validator);
        }

        $board->name = $request->name;
        $board->description = $request->description;
        $board->save();

        return redirect('/boards/');
    }

    /**
     * Share board with another user
     */
    public function share(Request $request, Board $board)
    {
        // Boards for the nav menu
        $boards = Auth::User()->boards()->orderBy('name', 'asc')->get();


        // Validation rules
        $validator = Validator::make($request->all(), [
            'email' => 'required|max:255',
        ]);

        // Redirect if validation fails
        if ($validator->fails()) {
            return redirect('/boards/' . $request->board_id)
                ->withInput()
                ->withErrors($validator);
        }

        // Find this specific board
        //$board = Board::findOrFail($id);

        // Find the specific user
        $new_user = User::where('email', $request->email)->first();

        if (!$new_user) {
            return redirect('/boards/' . $request->board_id)
                ->withInput()
                ->withErrors(array('message' => 'This user doesn\'t exist'));
        }
        $can_write = ($request->can_write) ? true : false;
        $new_user->boards()->attach($request->board_id, ['is_owner' => false, 'can_write' => $can_write]);

        $mail_title = Auth::User()->name . ' has shared a new board with you';
        $mail_content = 'A new board called ' . $board->name . ' has been shared with you.';

        Mail::send('emails.share', ['title' => $mail_title, 'content' => $mail_content], function ($message) use ($new_user) {
            $message->from('matt.jellings@gmail.com', 'Matt J');
            $message->subject('New shared board');
            $message->to($new_user->email);
        });

        return redirect('/boards/' . $request->board_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board)
    {
        //
    }
}
