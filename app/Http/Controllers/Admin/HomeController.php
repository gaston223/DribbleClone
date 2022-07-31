<?php

namespace App\Http\Controllers\Admin;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //dd(Auth::check());
        return view('home');
    }
}
