<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //データを10個作る
        \App\Models\User::factory(10)->create();

        // 他の Seeder クラスを登録
        $this->call([
        UsersTableSeeder::class,
        PostsTableSeeder::class,
        AnswersTableSeeder::class,
        ProductSeeder::class,
        ReplySeeder::class,
    ]);    }
}
