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
            Product::create([
                'user_id' => 2, // 仮のユーザーID（usersテーブルに1人登録しておいてね）
                'title' => 'Debatemate',
                'body' => 'OpenAIのAPIを用い、議論の進行やまとめを行ったり、発言内容の要約やアドバイスをしてくれるSNSです。',
                'photo' => 'images/debatemate1.png',
                'date' => today(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    }
}
