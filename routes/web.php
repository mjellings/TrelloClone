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

Auth::routes();

// Board routes
Route::get('/boards', 'BoardController@index');
Route::get('/boards/{id}', 'BoardController@show');
Route::post('/boards/create', 'BoardController@store');
Route::get('/boards/{board}/edit', 'BoardController@edit');
Route::post('/boards/{board}/edit', 'BoardController@update');
Route::post('/boards/{board}/share', 'BoardController@share');

// Card routes
Route::post('/cards/create', 'CardController@store');
Route::get('/cards/{card}/edit', 'CardController@edit');
Route::post('/cards/{card}/edit', 'CardController@update');
Route::post('/cards/{card}/updateTags', 'CardController@updateTags');
