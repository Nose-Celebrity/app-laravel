<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['posts_id', 'user_id', 'title', 'body'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'posts_id');
    }
    public function answer(Post $post)
    {
        // 正しいリレーションを使って回答を取得
        $answers = $post->answers()->latest()->get();
        return view('posts.answer', compact('post', 'answers'));
    }


}
