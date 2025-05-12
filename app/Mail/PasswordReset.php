<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class PasswordReset extends Mailable
{
    public $token;

    // コンストラクタでトークンを受け取る
    public function __construct($token)
    {
        $this->token = $token;
    }

    // メールの内容を設定
    public function build()
    {
        return $this->view('emails.password_reset') // ビューの指定
                    ->with(['token' => $this->token]); // トークンをビューに渡す
    }
}
