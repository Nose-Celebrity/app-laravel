<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductGenre extends Model
{
    //
    protected $fillable = [
        'id', 'product_id', 'genre_id'
    ];
    public function genre()
    {
        return $this->belongsTo(Genres::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
