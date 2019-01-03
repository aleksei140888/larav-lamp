<?php

namespace App\Http\Controllers;

use Auth;
use App\Posts;
use App\User;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostFormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class UserController extends Controller
{
    public function profile(Request $request, $id){
        return view('user/profile')->withUser(Auth::user());
    }

    public function user_posts(Request $request){
        $user_id = Auth::user()->id;
        $post = Posts::where('user_id', $user_id);
        $posts = Posts::where('user_id', $user_id)->get();

        $user = Auth::user();
        if(!$post){
            return redirect('/')->withErrors('запрошенная страница не найдена');
        }
        return view('user/user_posts')->withUser($user)->withPosts($posts);
    }
}
