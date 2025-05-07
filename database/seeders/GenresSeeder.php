<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genres;

class GenresSeeder extends Seeder
{
    public function run()
    {
        $genres = ['Web開発', 'AI', 'ゲーム開発', 'アプリ開発', 'ネットワーク', 'セキュリティ'];

        foreach ($genres as $name) {
            Genres::create(['genre' => $name]);
        }
    }
}

