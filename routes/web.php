<?php
use App\models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AnswerController;
use App\Http\Middleware\CheckLogin;

//ログイン画面へのルート設定
Route::get('/', [AuthController::class, 'showLogin'])->name('showLogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');

//パスワード変更画面へのルート設定
Route::get('/change-password', [AuthController::class, 'chLogin'])->name('password.change');
Route::post('/change-password', [AuthController::class, 'updatepassword'])->name('password.update');


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

    // 作品機能
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::post('/products/{product}/replies', [ReplyController::class, 'store'])->name('replies.store');

    // ホーム画面
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    // ログアウト
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
