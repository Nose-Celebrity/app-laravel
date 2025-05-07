<?php

use App\models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AnswerController;
//ログイン画面へのルート設定
Route::get('/', [AuthController::class, 'showLogin'])->name('showLogin');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/index', function () {
    return view('index');
});

//パスワード変更画面へのルート設定
Route::get('/change-password', [AuthController::class, 'chLogin'])->name('password.change');
Route::post('/change-password', [AuthController::class, 'updatepassword'])->name('password.update');


// 質問一覧のルーティング
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
// 質問投稿へのルーティング
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');

// 作品一覧画面
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// 投稿画面を表示する
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

// 投稿内容を保存する
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// 制作詳細画面のルーティング
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

// 作品へのリプライ投稿処理
Route::post('/products/{product}/replies', [ReplyController::class, 'store'])->name('replies.store');



Route::get('home',function(){
    return view('home');
})->name('home')->middleware('auth');


Route::post('logout',[AuthController::class, 'logout'])->name('logout');

Route::post('/posts/{post}/answers', [AnswerController::class, 'store'])->name('answers.store');

// 投稿の詳細・回答ページのルート
Route::get('/posts/{post}/answer', [PostController::class, 'answer'])->name('posts.answer');
