<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\UserProfile;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'mail_address',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * パスワードリセット通知を送信
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * メールアドレスを返すメソッド（mail_address列を使用）
     */
// App\Models\User.php

    public function getEmailForPasswordReset()
    {
        return $this->mail_address;
    }


    /**
     * ユーザープロフィールとのリレーション
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }
        public function getAuthIdentifierName()
    {
        return 'mail_address';
    }
    // mail_address を email として参照できるようにする
    public function getEmailAttribute()
    {
        return $this->mail_address;
    }

}
