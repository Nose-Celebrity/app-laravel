<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/index', function () {
    return view('index');
});
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

