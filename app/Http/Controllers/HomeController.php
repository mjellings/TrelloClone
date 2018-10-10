<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Board;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $boards = $request->user()->boards()->get();
        return view('home', [
            'boards' => $boards,
        ]);
    }
}
