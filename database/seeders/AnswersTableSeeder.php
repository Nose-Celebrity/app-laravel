<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Answer;
use App\Models\Post;
use App\Models\User;

class AnswersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $post = Post::first();
        $user = User::first();

        Answer::create([
            'posts_id' => $post->id,
            'user_id' => $user->id,
            'title' => '最初の回答',
            'body' => 'これは回答の本文です。',
        ]);
    }
}
