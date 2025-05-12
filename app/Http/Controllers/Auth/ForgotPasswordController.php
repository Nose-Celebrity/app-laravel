<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * パスワードリセットリンクの送信処理
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendResetLinkEmail(Request $request)
    {
        // バリデーション
        $request->validate(['email' => 'required|email']);

        // パスワードリセットリンク送信
        $response = Password::sendResetLink(
            $request->only('email')
        );

        if ($response == Password::RESET_LINK_SENT) {
            return back()->with('status', 'パスワードリセットリンクが送信されました。');
        } else {
            // エラーメッセージを表示
            return back()->withErrors(['email' => '指定されたメールアドレスは登録されていません。']);
        }
    }
}
