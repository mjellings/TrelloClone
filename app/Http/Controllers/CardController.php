<?php

namespace App\Http\Controllers;

use App\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CardController extends Controller
{
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
        //
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
        //
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
}
