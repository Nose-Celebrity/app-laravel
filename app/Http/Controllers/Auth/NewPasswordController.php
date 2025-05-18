<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class NewPasswordController extends Controller
{
    /**
     * パスワードリセットフォームを表示
     */
    public function create($token)
    {
        // トークンが存在する場合、リセットフォームを表示
        return view('auth.reset-password', [
            'token' => $token,
            'email' => request()->query('email') // クエリパラメータからemailを取得
        ]);
    }

    /**
     * パスワードを更新する
     */
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // パスワードリセット処理
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                ])->save();
            }
        );

        // 成功した場合、または失敗した場合のリダイレクト処理
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('showLogin')->with('status', __('Your password has been reset!'))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
