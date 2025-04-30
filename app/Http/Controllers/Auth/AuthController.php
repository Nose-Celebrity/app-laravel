<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller // 修正
{
    /**
     * @return View
     */
    public function showLogin()
    {
        return view('login.login_form');
    }

    /**
     * @param LoginFormRequest $request
     * @return
     */
    public function login(LoginFormRequest $request)
    {
        $credentials = [
            'password' => $request->input('password'),
            'mail_address' => $request->input('mail_address'),
        ];

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();

            //成功したらホーム画面に移動
            return redirect()->route('posts.index')->with('success','ログイン成功しました');
            //            return redirect()->route('posts.index')->with('success','ログイン成功しました');
            //            return redirect()->route('home')->with('success','ログイン成功しました');

        }

        return back()->withErrors([
            'login_error' => 'パスワードが間違ってます',
        ]);
    }

    /**
 * ユーザーをアプリケーションからログアウトさせる
 *
 * @param  \Illuminate\Http\Request  $request
 * @return
 */
public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login.show')->with('danger','ログアウトしました');
    }
}
