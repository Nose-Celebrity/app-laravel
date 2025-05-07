<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' =>1 //仮auth()->id(), // ログインユーザーを取得
        ]);

        return redirect()->route('posts.index');
    }

    public function show(Post $post)
    {
        $answers = $post->answers()->latest()->get();
        return view('posts.show', compact('post', 'answers'));
    }
    public function answer(Post $post)
{
    $answers = $post->answers()->latest()->get(); // 回答を取得
    return view('posts.answer', compact('post', 'answers'));
}

}
