<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Requests\LoginFormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;

class AuthController extends Controller
{
    /**
     * ログインフォームを表示
     */
    public function showLogin(): View
    {

        return view('login.login_form');
    }

    /**
     * ログイン処理
     */
    public function login(LoginFormRequest $request)
    {
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('posts.index')->with('success', 'ログイン成功しました');
        }

        return back()->withErrors([
            'login_error' => 'メールアドレスまたはパスワードが間違っています',
        ]);
    }

    /**
     * ログアウト処理
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('logout')->with('danger', 'ログアウトしました');
    }

    /**
     * パスワード変更フォーム表示
     */
    public function chlogin(Request $request)
    {
        return view('auth.forgot-password');
    }

    /**
     * パスワード変更処理
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'new_password' => 'required|min:8',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return back()->withErrors(['password' => '現在のパスワードが間違っています']);
        }

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return redirect()->route('posts.index')->with('success', 'パスワードを変更しました');
    }

    /**
     * 新規登録フォーム表示
     */
    public function newlogin(Request $request)
    {
        return view('login.new_login');
    }

    /**
     * 新規登録処理
     */
    public function newregistration(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:4',
            'new_password' => 'required|same:password',
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->route('posts.index')->with('success', 'アカウントの作成が完了しました');
    }

    /**
     * アカウント削除
     */
    public function delete(Request $request)
    {
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
