<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Reply;
class ReplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        for ($i = 1; $i <= 10; $i++) {
            for ($j = 1; $j <= 3; $j++) {
                Reply::create([
                    'user_id' => 1, // 仮ユーザー
                    'product_id' => $i,
                    'title' => "返信タイトル {$j} (商品 {$i})",
                    'body' => "これは商品 {$i} への返信 {$j} です。",
                    'date' => now()->toDateString(),
                ]);
            }
        }
    }
}
