<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        for ($i = 1; $i <= 10; $i++) {
            Product::create([
                'user_id' => 1, // 仮のユーザーID（usersテーブルに1人登録しておいてね）
                'title' => '制作物タイトル ' . $i,
                'body' => 'これは制作物 ' . $i . ' の説明文です。',
                'photo' => 'https://via.placeholder.com/150',
                'date' => now()->toDateString(),
            ]);
        }
    }
}
