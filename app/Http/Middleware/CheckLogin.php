<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckLogin
{

    public function handle($request, Closure $next)
    {
        Log::info('CheckLoginミドルウェア動作中: ユーザーの認証状態 → ' . (Auth::check() ? 'ログイン済み' : '未ログイン'));

        if (!Auth::check()) {
            return redirect()->route('showLogin')->with('error', 'ログインしてください');
        }

        return $next($request);
    }
}
