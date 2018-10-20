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

    $card = Card::find($id);
    return view('cards.edit', [
        'boards' => $boards,
        'page_title' => 'Edit Card - ' . $card->title,
        'card' => $card,
    ]);

});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/boards', 'BoardController@index')->middleware('auth');
Route::get('/boards/{id}', 'BoardController@show')->middleware('auth');
Route::post('/boards/create', 'BoardController@store')->middleware('auth');
Route::post('/cards/create', 'CardController@store')->middleware('auth');
