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
use App\User;
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
    $card = Card::findOrFail($id);

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
    $card = Card::findOrFail($request->card_id);
    $card->title = $request->title;
    $card->content = $request->content;
    $card->save();

    return redirect('/boards/' . $card->board_id);
});

Route::post('/cards/{id}/updateTags', function (Request $request) {
    $card = Card::findOrFail($request->card_id);

    if (isset($request->selected_tags) && is_array($request->selected_tags) && count($request->selected_tags)) {
        // Some tags selected so update card.
        $card->tags()->sync($request->selected_tags);
    }
    else {
        // No tags selected, so remove them from card.
        $card->tags()->sync([]);
    }

    return redirect('/boards/' . $card->board_id);
});

Route::get('/boards/{id}/edit', function ($id) {
    // Boards for the nav menu
    $boards = Auth::User()->boards()->orderBy('name', 'asc')->get();

    // Find this specific board
    $board = Board::findOrFail($id);

    return view('boards.edit', [
        'board' => $board,
        'boards' => $boards,
        'page_title' => 'Edit Board - ' . $board->title
    ]);
});

Route::post('/boards/{id}/edit', function(Request $request, $id) {
    // Boards for the nav menu
    $boards = Auth::User()->boards()->orderBy('name', 'asc')->get();

    // Find this specific board
    $board = Board::findOrFail($id);

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

});

Route::post('/boards/{id}/share', function (Request $request, $id) {
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
    $board = Board::findOrFail($id);

    // Find the specific user
    $new_user = User::where('email', $request->email)->first();

    if (!$new_user) {
        return redirect('/boards/' . $request->board_id)
            ->withInput()
            ->withErrors(array('message' => 'This user doesn\'t exist'));
    }
    $can_write = ($request->can_write) ? true : false;
    $new_user->boards()->attach($request->board_id, ['is_owner' => false, 'can_write' => $can_write]);

    return redirect('/boards/' . $request->board_id);
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/boards', 'BoardController@index')->middleware('auth');
Route::get('/boards/{id}', 'BoardController@show')->middleware('auth');
Route::post('/boards/create', 'BoardController@store')->middleware('auth');
Route::post('/cards/create', 'CardController@store')->middleware('auth');
