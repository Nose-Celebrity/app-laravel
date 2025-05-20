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
                'title' => 'Debatemate' . $i,
                'body' => 'OpenAIのAPIを用い、議論の進行やまとめを行ったり、発言内容の要約やアドバイスをしてくれるSNSです。 ' . $i . ' の説明文です。',
                'photo' => 'images/debatemate1.png',
                'date' => now()->toDateString(),
            ]);
        }
    }
}
