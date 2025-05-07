<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

}
