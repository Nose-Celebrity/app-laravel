<?php

namespace Database\Seeders;

// database/seeders/GenreSeeder.php
use Illuminate\Database\Seeder;
use App\Models\Genres;

class GenreSeeder extends Seeder
{
    public function run()
    {
        Genres::insert([
            ['genre' => 'Web開発'],
            ['genre' => 'AI'],
            ['genre' => 'ゲーム開発'],
            ['genre' => 'アプリ開発'],
            ['genre' => 'ネットワーク'],
            ['genre' => 'セキュリティ'],
        ]);
    }
}


