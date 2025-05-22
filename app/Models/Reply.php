<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;
class Reply extends Model
{
    //
    protected $fillable = [
        'user_id', 'product_id', 'title', 'body', 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }



public function getLikesCount()
{
    return Redis::scard("reply:likes:{$this->id}");
}

public function hasLiked($userId)
{
    return Redis::sismember("reply:likes:{$this->id}", $userId);
}

public function like($userId)
{
    Redis::sadd("reply:likes:{$this->id}", $userId);
}

public function unlike($userId)
{
    Redis::srem("reply:likes:{$this->id}", $userId);
}

}
