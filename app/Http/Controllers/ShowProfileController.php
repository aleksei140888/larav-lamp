<?php

namespace App\Http\Controllers;

use app\User;
use Illuminate\Http\Request;

class ShowProfileController extends Controller
{
    public function showProfile(){
        return view('user.profile', ['user' => User::findOrFail($id)]);
    }
}
