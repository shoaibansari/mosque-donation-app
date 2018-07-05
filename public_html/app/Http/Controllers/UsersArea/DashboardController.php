<?php

namespace App\Http\Controllers\UsersArea;
use App\Http\Controllers\Controller;


class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view(toolbox()->userArea()->view('dashboard') );
    }
}
