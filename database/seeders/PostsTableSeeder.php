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

        Post::create([
            'user_id' => 4,
            'title' => '初めて学ぶのにおすすめのプログラミング言語は何ですか？',
            'body' => 'こんにちは！初めてでしたら、PythonかJavaScriptがよくおすすめされますね。Pythonは文法が比較的シンプルで読みやすく、JavaScriptはウェブブラウザで結果をすぐ確認できるので、動いている実感を得やすいです。何を作りたいかによっても変わってくるので、目標から逆算するのも良いですよ。',
        ]);

        // トピック2
        Post::create([
            'user_id' => 3,
            'title' => 'Webアプリ開発に適した言語の選び方を教えてください。（例：Python, Ruby, PHP, JavaScriptなど）',
            'body' => '', // こちらは回答がないため空文字としています。null にする場合は Post モデルの $fillable 設定やDB定義を確認してください。
        ]);
    }
}
