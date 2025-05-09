<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Genres;

class ProductController extends Controller
{
    // 作品一覧を表示する
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword){
                $q->where('title', 'like', "%{$keyword}%")
                ->orWhere('body', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('genre')) {
            $genreId = $request->genre;
            $query->whereHas('genres', function($q) use ($genreId) {
                $q->where('genre_id', $genreId);
            });
        }

        $products = $query->latest()->get();
        $genres = Genres::all();

        return view('products.index', compact('products', 'genres'));
    }

    public function create()
    {
        $genres = Genres::all();
        return view('products.create', compact('genres'));
    }

    // 投稿された内容を保存する
    public function store(Request $request)
    {
        // バリデーション（ジャンル配列を追加）
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'photo' => 'required|image|max:2048',
            'genres' => 'required|array',
        ]);

        // アップロード画像の保存
        $path = $request->file('photo')->store('images', 'public');

        // Product レコード作成
        $product = Product::create([
            'user_id' => 1, // 仮固定（後で認証ユーザーに変更可能）
            'title' => $request->title,
            'body' => $request->body,
            'date' => now(),
            'photo' => $path,
        ]);

        // 中間テーブルにジャンルを保存（複数対応）
        $product->genres()->attach($request->genres);

        return redirect()->route('products.index')->with('success', '投稿が完了しました！');
    }


    public function show($id)
    {
        $product = Product::with('replies.user')->findOrFail($id);
        return view('products.show', compact('product'));

    }

    public function edit($id)
    {
        $product = Product::with('genres')->findOrFail($id);
        $genres = Genres::all();
        $selectedGenres = $product->genres->pluck('id')->toArray();
        return view('products.edit', compact('product', 'genres', 'selectedGenres'));
    }

    public function update(Request $request, $id)
    {
        // バリデーション
        $request->validate([
            'title' => 'required',
            'body' => 'required',
            'photo' => 'nullable|image|max:2048',
            'genres' => 'required|array',
        ]);

        // 作品の取得
        $product = Product::findOrFail($id);

        // アップロード画像の保存（新しい画像がある場合）
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('images', 'public');
            $product->photo = $path;
        }

        // 作品情報の更新
        $product->title = $request->title;
        $product->body = $request->body;
        $product->save();

        // 中間テーブルのジャンルを更新
        $product->genres()->sync($request->genres);

        return redirect()->route('products.index')->with('success', '作品が更新されました！');
    }
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->genres()->detach(); // 中間テーブルのジャンルを削除
        $product->delete();
        return redirect()->route('products.index')->with('success', '作品が削除されました！');
    }
}
