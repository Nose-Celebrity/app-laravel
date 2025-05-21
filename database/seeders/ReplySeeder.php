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
        DB::table('replies')->insert([
            [
                'title' => 'テスト',
                'user_id' => 2,
                'product_id' => 1,
                'body' => 'テスト',
                'date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
