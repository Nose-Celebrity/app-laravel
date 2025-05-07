<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Post extends Model
{
    protected $fillable = ['user_id', 'title', 'body'];

    // ユーザーテーブルとのリレーションを追加
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'posts_id');
    }
}
