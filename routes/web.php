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

Auth::routes();

// Board routes
Route::get('/boards', 'BoardController@index')->middleware('auth');
Route::get('/boards/{id}', 'BoardController@show')->middleware('auth');
Route::post('/boards/create', 'BoardController@store')->middleware('auth');
Route::get('/boards/{board}/edit', 'BoardController@edit')->middleware('auth');
Route::post('/boards/{board}/edit', 'BoardController@update')->middleware('auth');
Route::post('/boards/{board}/share', 'BoardController@share')->middleware('auth');

// Card routes
Route::post('/cards/create', 'CardController@store')->middleware('auth');
Route::get('/cards/{card}/edit', 'CardController@edit')->middleware('auth');
Route::post('/cards/{card}/edit', 'CardController@update')->middleware('auth');
Route::post('/cards/{card}/updateTags', 'CardController@updateTags')->middleware('auth');
