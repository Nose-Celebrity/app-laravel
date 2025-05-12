<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    // パスワードリセットフォームを表示
    public function create()
    {
        return view('auth.forgot-password');
    }

    // パスワードリセットリンクの送信
    public function store(Request $request)
    {
        // バリデーション: mail_address が必須で、email形式であること
        $request->validate([
            'mail_address' => ['required', 'email'],
        ]);

        // パスワードリセットリンクを送信
        $status = Password::sendResetLink([
            'mail_address' => $request->mail_address,  // ここで mail_address を使用
        ]);

        // 成功またはエラーメッセージの表示
        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['mail_address' => __($status)]);
    }
}
