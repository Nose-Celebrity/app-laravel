<?php

namespace App\Models;
use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\Model;
use App\Models\Genres;

class Product extends Model
{
    protected $fillable = [
        'user_id', 'title', 'body', 'photo', 'date',
    ];

    // リプライとのリレーション
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    // ジャンルとの多対多リレーション
    public function genres()
    {
        return $this->belongsToMany(Genres::class, 'product_genre', 'product_id', 'genre_id');
    }

    // 投稿者（User）とのリレーション
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hasLiked($userId)
    {
    return Redis::sismember('product:' . $this->id . ':likes_users', $userId);
    }

    public function like($userId)
    {
        Redis::sadd('product:' . $this->id . ':likes_users', $userId);
    }

    public function unlike($userId)
    {
        Redis::srem('product:' . $this->id . ':likes_users', $userId);
    }

    public function getLikesCount()
    {
        return Redis::scard('product:' . $this->id . ':likes_users');
    }

}
