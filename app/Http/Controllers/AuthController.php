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

    public function newlogin(Request $request)
    {
        //アカウント新規登録フォームへ移動
        return view('login.new_login');
    }

    public function newregistration(Request $request)
    {
        //フォーム内容の確認
        $request->validate([
            'name' => 'required',
            'mail_address' => 'required|email|unique:users,mail_address',
            'password' => 'required',
            'new_password' => 'required|same:password',
        ]);

        //アカウント作成
        $user = new User();
        $user->name = $request->input('name');
        $user->mail_address = $request->input('mail_address');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->route('posts.index')->with('success','アカウントの作成が完了しました');

    }

    public function delete(Request $request)
    {
        //アカウント削除
        $user = Auth::user();

        if (!$user) {
        return redirect()->route('showLogin')->with('danger', 'ユーザーが見つかりませんでした');
        }

        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('showLogin')->with('danger', 'アカウントを削除しました');
    }
}


