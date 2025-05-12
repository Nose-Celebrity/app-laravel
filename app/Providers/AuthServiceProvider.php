<?php

namespace App\Providers;

use Illuminate\Auth\Passwords\PasswordBrokerManager;
use Illuminate\Auth\Passwords\DatabaseTokenRepository;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * ボードされたポリシーの登録
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // パスワードリセットのトークンテーブル名を変更
        Password::createTokenRepository(function ($app) {
            return new DatabaseTokenRepository(
                $app['db']->connection(), // データベース接続
                'password_reset_tokens'   // 使用するカスタムテーブル名
            );
        });
    }
}
