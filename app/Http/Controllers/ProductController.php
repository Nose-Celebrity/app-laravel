<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Reply;


class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with('replies.user')->findOrFail($id);
        return view('products.show', compact('product'));
    }

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
        // 入力された内容に問題ないかチェック（バリデーション）
        $request->validate([
            'title' => 'required',       // タイトルは必須
            'body' => 'required',         // 本文も必須
            'date' => 'required|date',    // 日付も必須、正しい日付形式
            'photo' => 'required|image|max:2048', // 画像必須、最大2MB
        ]);

        // アップロードされた画像を storage/app/public/images に保存
        $path = $request->file('photo')->store('images', 'public');

        // データベースに新しい作品データを保存
        Product::create([
            'user_id' => 1, // 仮に固定（あとでログインユーザーにすることもできる）
            'title' => $request->title,
            'body' => $request->body,
            'date' => $request->date,
            'photo' => $path, // 保存先パスを登録（例：images/abc.jpg）
        ]);

        // 保存が終わったら、作品一覧に戻る
        return redirect()->route('products.index')->with('success', '投稿が完了しました！');
    }

    //public function show($id)
    //{
    //    $product = Product::with('replies.user')->findOrFail($id);
    //    return view('products.show', compact('product'));
    //
    //}
}
