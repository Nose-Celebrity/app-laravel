<?php

namespace Database\Seeders;

use App\Models\Genres;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory(2)->create();

        // 他の Seeder クラスを登録
        $this->call([
            UsersTableSeeder::class,
            PostsTableSeeder::class,
            ProductSeeder::class,
            AnswersTableSeeder::class,
            GenresSeeder::class,
            ReplySeeder::class,
            AnswersTableSeeder::class,
        ]);
    }
}
