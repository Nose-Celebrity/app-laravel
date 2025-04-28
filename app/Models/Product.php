<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'user_id', 'title', 'body', 'photo', 'date',
    ];

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

}
