<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Post;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        Answer::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => auth()->id(),
            'posts_id' => $post->id,
        ]);

        return redirect()->route('posts.answer', $post);
    }

    public function show()
    {
        //
    }

    public function edit(Answer $answer)
    {
        // 本人確認
        if ($answer->user_id !== auth()->id()) {
            abort(403, 'この回答は編集できません。');
        }

        return view('posts.answers_edit', compact('answer'));
    }

    public function update(Request $request, Answer $answer)
    {
        // 本人確認
        if ($answer->user_id !== auth()->id()) {
            abort(403, 'この回答は更新できません。');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $answer->update([
            'title' => $request->title,
            'body' => $request->body,
        ]);

        return redirect()->route('posts.answer', $answer->posts_id)
                        ->with('success', '回答が更新されました！');
    }

    public function destroy(Answer $answer)
    {
        // 本人確認
        if ($answer->user_id !== auth()->id()) {
            abort(403, 'この回答は削除できません。');
        }

        $postId = $answer->posts_id;
        $answer->delete();

        return redirect()->route('posts.answer', $postId)
                        ->with('success', '回答が削除されました！');
    }

    public function toggleLike($id)
    {
        $answer = Answer::findOrFail($id);
        $userId = session('user_id');

        if ($answer->hasLiked($userId)) {
            $answer->unlike($userId);
        } else {
            $answer->like($userId);
        }

        return redirect()->back()->withFragment('answer-' . $id);
    }
}
