<?php

namespace App\Http\Controllers;

use App\Posts;
use Auth;
use Illuminate\Http\Request;

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
    public function index(){
        $user = Auth::user()->name;
        // сделать выборку 5 постов из базы данных, активных и последних
        $posts = Posts::orderBy('created_at')->paginate(5);
        // вывод шаблона home.blade.php из папки resources/views
        return view('home')->withPosts($posts)->withUser($user);
    }
}
