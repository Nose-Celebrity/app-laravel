<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;

class PasswordResetLinkController extends Controller
{
    /**
     * パスワードリセットフォームを表示
     */
    public function create()
    {
        return view('auth.forgot-password'); // フォームビューを返す
    }

    /**
     * パスワードリセットリンクを送信
     */
    public function store(Request $request)
    {
        $request->validate([
            'mail_address' => ['required', 'email'],
        ]);

        // Laravelが使う "email" キーに mail_address をコピー
        $request->merge(['email' => $request->input('mail_address')]);

        // 送信処理
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['mail_address' => __($status)]);
    }


}
