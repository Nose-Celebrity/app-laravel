<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // 質問投稿一覧画面のビューを表示
    public function index()
    {
        try {
            // 通常の取得処理
            $posts = Post::latest()->get();
        } catch (\Exception $e) {
            // DB接続エラーなどが起きた場合
            $posts = collect(); // 空のコレクションを代入
        }

        return view('posts.index', compact('posts'));
    }


    // 質問作成画面への遷移
    public function create()
    {
        return view('posts.create');
    }

    // 質問投稿コントローラー
    // 質問をDBに保存後質問一覧画面へ遷移
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',

        ]);

        Post::create([
            'user_id' => 1, // 仮のユーザーID
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
