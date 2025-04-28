<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;


class User extends Model
{
    use HasFactory,Notifiable;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'password',
        'locked_flg',
        'error_count',
    ];

    protected $hidden = [
        'password'
    ];
}
