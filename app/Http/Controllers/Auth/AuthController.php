<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;

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




    public function chlogin(Request $request)
    {
        //パスワード変更フォームへ移動
        return view('login.change_password');
    }

    public function updatePassword(Request $request)
    {
        //フォーム内容の確認
        $request->validate([
            'mailaddress' => 'required',
            'password' => 'required',
            'new_password' => 'required',
        ]);

        //ユーザ情報の取得
        $user = Auth::user();

        $user = User::where('mail_address',$request->input('mailaddress'))->first();


        if(!Hash::check($request->input('password'),$user->password)){
            return back()->withErrors(['password' => '現在のパスワードが間違っています']);
        }
            $user->password = Hash::make($request->input('new_password'));

            $user -> save();

            return redirect()->route('posts.index')->with('success','パスワードを変更しました');
    }
}


