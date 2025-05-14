<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordReset;

class PasswordResetLinkController extends Controller
{
    // パスワードリセットフォームを表示
    public function store(Request $request)
    {
        $request->validate([
        'mail_address' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
        $request->only('mail_address')
        );

            // ログを出力
        Log::info('Password reset link status: ' . $status);

        $user = User::where('mail_address', 'kd1322303@st.kobedenshi.ac.jp')->first();

    if ($user) {
        // トークンを生成
        $token = Password::createToken($user);

        // メール送信
        Mail::to($user->mail_address)->send(new PasswordReset($token));

        return 'メールが送信されました';
    }

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);

    }

    public function create(): View
    {
        return view('auth.forgot-password');
    }

}

