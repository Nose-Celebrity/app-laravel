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
            'user_id' => auth()->id(),
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

    public function edit(Post $post)
    {
        // 投稿者以外は403
        if ($post->user_id !== auth()->id()) {
            abort(403, 'この投稿は編集できません。');
        }

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        // 投稿者以外は403
        if ($post->user_id !== auth()->id()) {
            abort(403, 'この投稿は更新できません。');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $post->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        // 投稿者以外は403
        if ($post->user_id !== auth()->id()) {
            abort(403, 'この投稿は削除できません。');
        }

        $post->delete();
        return redirect()->route('posts.index');
    }

    
}
