<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genres extends Model
{
    protected $fillable = ['genre'];

    // プロダクトとの多対多リレーション
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_genre', 'genre_id', 'product_id');
    }

}
