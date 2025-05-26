<?php
use App\models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\CheckLogin;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordReset;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;


//ログイン画面へのルート設定
    Route::middleware('guest')->group(function(){
        Route::get('/', [AuthController::class, 'showLogin'])->name('showLogin');
        Route::post('/login', [AuthController::class, 'login'])->name('login');
    });

//パスワード変更画面へのルート設定
Route::get('/change-password', [AuthController::class, 'chLogin'])->name('password.change');
Route::post('/change-password', [AuthController::class, 'updatepassword'])->name('password.update');

//アカウント新規作成
Route::get('/new_login', [AuthController::class, 'newlogin'])->name('new.login');
Route::post('/new_login', [AuthController::class, 'newregistration'])->name('new.registration');

// パスワードリセットリクエスト表示
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');

// パスワードリセットリンク送信
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

// トークン付きパスワードリセットフォーム表示
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');

// パスワードの再設定
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');

// ユーザーのアカウント削除ルート
Route::delete('/user/delete', [AuthController::class, 'delete'])->name('user.delete');

// ログアウト
Route::post('/logout',function(){
    Auth::logout();
    return redirect()->route('showLogin')->with('success','ログアウトしました');
})->name('logout');


//ログイン判定関係
// ミドルウェア適用（ログイン必須のルート）
Route::middleware(CheckLogin::class)->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // プロフィール機能
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/users/{id}/profile', [ProfileController::class, 'show'])->name('profile.show');

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
    // 回答編集・更新・削除ルート
    Route::get('/answers/{answer}/edit', [AnswerController::class, 'edit'])->name('answers.edit');
    Route::put('/answers/{answer}', [AnswerController::class, 'update'])->name('answers.update');
    Route::delete('/answers/{answer}', [AnswerController::class, 'destroy'])->name('answers.destroy');

    // 編集画面表示
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    // 編集内容を保存
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
    // 削除
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::delete('/products/{id}', [ProductController::class, 'destroyhome'])->name('products.destroyhome');

});

//いいね機能
Route::post('/answers/{answer}/like', [AnswerController::class, 'toggleLike'])->name('answers.toggleLike');
Route::post('/posts/{post}/toggle-like', [PostController::class, 'toggleLike'])->name('posts.toggleLike');
Route::post('/products/{id}/toggle-like', [ProductController::class, 'toggleLike'])->name('products.toggleLike');
Route::post('/replies/{reply}/toggle-like', [ReplyController::class, 'toggleLike'])->name('replies.toggleLike');
