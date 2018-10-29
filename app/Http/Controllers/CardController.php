<?php

namespace App\Http\Controllers;

use App\Card;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CardController extends Controller
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
    public function index()
    {
        //
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
            'board_id' => 'required',
            'title' => 'required|max:255',
            'content' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect('/boards/' . $request->board_id)
                ->withInput()
                ->withErrors($validator);
        }
    
        /*
        $board = new Board;
        $board->name = $request->name;
        $board->description = $request->description;
        $board->status = '';
        $board->user_id = $request->user()->id;
        $board->save();
        */

        $card = new Card;
        $card->board_id = $request->board_id;
        $card->user_id = $request->user()->id;
        $card->title = $request->title;
        $card->content = $request->content;
        $card->save();

        return redirect('/boards/' . $request->board_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function edit(Card $card)
    {
        // Boards for the nav menu
        $boards = Auth::User()->boards()->orderBy('name', 'asc')->get();

        // Retrieve full tags list
        $tags = Tag::orderBy('label', 'asc')->get();

        $current_tags = array();

        // Find existing card
        //$card = Card::findOrFail($id);

        foreach ($card->tags as $tag) {
            $current_tags[] = $tag->id;
        }

        return view('cards.edit', [
            'boards' => $boards,
            'page_title' => 'Edit Card - ' . $card->title,
            'card' => $card,
            'tags' => $tags,
            'current_tags' => $current_tags
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Card $card)
    {
        // Boards for the nav menu
        $boards = Auth::User()->boards()->orderBy('name', 'asc')->get();

        // Validation rules
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        // Redirect if validation fails
        if ($validator->fails()) {
            return redirect('/cards/' . $request->card_id . '/edit')
                ->withInput()
                ->withErrors($validator);
        }

        // Find existing card
        //$card = Card::findOrFail($request->card_id);
        $card->title = $request->title;
        $card->content = $request->content;
        $card->save();

        return redirect('/boards/' . $card->board_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        //
    }

    /**
     * Update tags linked to a card.
     * 
     */
    public function updateTags(Request $request, Card $card)
    {

        if (isset($request->selected_tags) && is_array($request->selected_tags) && count($request->selected_tags)) {
            // Some tags selected so update card.
            $card->tags()->sync($request->selected_tags);
        }
        else {
            // No tags selected, so remove them from card.
            $card->tags()->sync([]);
        }
    
        return redirect('/boards/' . $card->board_id);
    }
}
