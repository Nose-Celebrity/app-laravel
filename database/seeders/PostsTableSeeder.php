<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $user = User::first();

        Post::create([
            'user_id' => $user->id,
            'title' => '最初の投稿',
            'body' => 'これは最初の投稿の本文です。',
        ]);
    }
}
