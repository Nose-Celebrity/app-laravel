<?php
use App\models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AnswerController;
use App\Http\Middleware\CheckLogin;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordReset;
use Illuminate\Support\Facades\Password;

//ログイン画面へのルート設定
Route::get('/', [AuthController::class, 'showLogin'])->name('showLogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');

//パスワード変更画面へのルート設定
Route::get('/change-password', [AuthController::class, 'chLogin'])->name('password.change');
Route::post('/change-password', [AuthController::class, 'updatepassword'])->name('password.update');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');


//ログイン判定関係
// ミドルウェア適用（ログイン必須のルート）
Route::middleware(CheckLogin::class)->group(function () {
    Route::get('/index', function () {
        return view('index');
    });

    // 質問機能
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/answer', [PostController::class, 'answer'])->name('posts.answer');
    Route::post('/posts/{post}/answers', [AnswerController::class, 'store'])->name('answers.store');
    // 質問編集画面
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    // 質問更新処理
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    // 質問削除処理
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');


    // 作品機能
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::post('/products/{product}/replies', [ReplyController::class, 'store'])->name('replies.store');

    // 編集画面表示
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    // 編集内容を保存
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    // 削除
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    // ホーム画面
    Route::get('/home', function () {
        return view('home');
    })->name('home');


    // ログアウト
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/test-reset-email', function () {
    // ユーザーを取得（例としてメールアドレスを指定）
    $user = User::where('mail_address', 'kd1322303@st.kobedenshi.ac.jp')->first();

    if ($user) {
        // トークンを生成
        $token = Password::createToken($user);

        // メール送信
        Mail::to($user->mail_address)->send(new PasswordReset($token));

        return 'メールが送信されました';
    }

    return 'ユーザーが見つかりませんでした';
});
