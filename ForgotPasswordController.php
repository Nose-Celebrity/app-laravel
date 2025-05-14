<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Log;

class ForgotPasswordController extends Controller
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
        // バリデーション
        $request->validate([
            'mail_address' => ['required', 'email'],
        ]);

        // パスワードリセットリンクの送信
        $status = Password::sendResetLink([
        'email' => $request->input('mail_address')
        ]);

        // ログ出力（リセットリンク送信の状態をログに記録）
        Log::info('Password reset link status: ' . $status);

        // メール送信が成功した場合、セッションにステータスを保存してリダイレクト
        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])  // 成功
            : back()->withErrors(['mail_address' => __($status)]);  // エラー
    }
}
