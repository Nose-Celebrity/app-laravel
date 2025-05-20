<?php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $resetUrl = url(route('password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
            ->subject('パスワード再設定のお知らせ')
            ->line('このメールは、あなたのアカウントのパスワード再設定のリクエストを受け取り送信しています。')
            ->line('また認証の期限は10分となっています。')
            ->action('パスワードを再設定する', $resetUrl)
            ->line('このリクエストに心当たりがない場合は、無視してください。');
    }
}
