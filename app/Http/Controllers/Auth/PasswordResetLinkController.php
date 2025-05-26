<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    /**
     * パスワードリセットフォームを表示
     */
    public function create()
    {
        return view('auth.forgot-password'); // パスワードリセットフォームの表示
    }

    /**
     * パスワードリセットリンクを送信
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'], // メールアドレスのバリデーション
        ]);

        // パスワードリセットリンク送信処理
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)]) // 成功時のメッセージ
            : back()->withErrors(['email' => __($status)]); // エラー発生時
    }
}
