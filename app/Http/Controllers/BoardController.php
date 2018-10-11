<?php

namespace App\Http\Controllers;

use App\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BoardController extends Controller
{
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
        $board->user_id = $request->user()->id;
        $board->save();
    
        return redirect('/boards');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        // Get list of boards for existing user...
        $boards = $request->user()->boards()->orderBy('name', 'asc')->get();

        // Get requested board
        $board = Board::find($id);
        return view('boards.show', [
            'board' => $board,
            'boards' => $boards,
            'page_title' => $board->name,
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
        //
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
        //
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
