<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

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

    public function hasLiked($userId)
{
    return Redis::sismember('post:' . $this->id . ':likes_users', $userId);
}

public function like($userId)
{
    Redis::sadd('post:' . $this->id . ':likes_users', $userId);
}

public function unlike($userId)
{
    Redis::srem('post:' . $this->id . ':likes_users', $userId);
}

public function getLikesCount()
{
    return Redis::scard('post:' . $this->id . ':likes_users');
}


}
