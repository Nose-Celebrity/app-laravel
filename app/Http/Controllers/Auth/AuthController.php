<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('posts.index'); // resources/views/auth/login.blade.php を表示する
    }
}
