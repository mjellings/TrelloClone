<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Card;
use App\Board;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

Route::get('/', function () {
    $boards = array();
    if(Auth::check()){
        $boards = Auth::User()->boards()->orderBy('name', 'asc')->get();
    }
    return view('welcome', [
        'boards' => $boards,
        'page_title' => 'welcome',
    ]);
});

Route::get('/cards/{id}/edit', function($id) {
    // Boards for the nav menu
    $boards = Auth::User()->boards()->orderBy('name', 'asc')->get();

    // Retrieve full tags list
    $tags = Tag::orderBy('label', 'asc')->get();

    $current_tags = array();

    // Find existing card
    $card = Card::find($id);

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

});

Route::post('/cards/{id}/edit', function (Request $request) {
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
    $card = Card::find($request->card_id);
    $card->title = $request->title;
    $card->content = $request->content;
    $card->save();

    return redirect('/boards/' . $card->board_id);
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/boards', 'BoardController@index')->middleware('auth');
Route::get('/boards/{id}', 'BoardController@show')->middleware('auth');
Route::post('/boards/create', 'BoardController@store')->middleware('auth');
Route::post('/cards/create', 'CardController@store')->middleware('auth');
