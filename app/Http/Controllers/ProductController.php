<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // 作品一覧を表示する
    public function index()
    {
        $products = Product::latest()->get(); // データベースから新しい順に作品を全部取る
        return view('products.index', compact('products')); // 一覧ページへデータを渡す
    }

    // 投稿フォームを表示する
    public function create()
    {
        return view('products.create'); // 投稿画面のビューを表示
    }

    // 投稿された内容を保存する
    public function store(Request $request)
{
    // バリデーション（dateは不要）
    $request->validate([
        'title' => 'required',
        'body' => 'required',
        'photo' => 'required|image|max:2048',
    ]);

    // アップロードされた画像を保存
    $path = $request->file('photo')->store('images', 'public');

    // データ保存
    Product::create([
        'user_id' => 1, // 仮固定（あとでログインユーザーにするといいね）
        'title' => $request->title,
        'body' => $request->body,
        'date' => now(), // ★ここで現在日時を自動記録（日時まで含む）
        'photo' => $path,
    ]);

    return redirect()->route('products.index')->with('success', '投稿が完了しました！');
}


    public function show($id)
    {
        $product = Product::with('replies.user')->findOrFail($id);
        return view('products.show', compact('product'));

    }
}
