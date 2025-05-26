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
        // UsersTableSeederで作成されたユーザーIDを取得
        $userIds = User::pluck('id')->toArray();

        // ユーザーが存在しない場合はエラーメッセージを表示して終了
        if (empty($userIds)) {
            echo "ユーザーが存在しません。UserSeederを先に実行してください。\n";
            return;
        }

        $questions = [
            '初めて学ぶのにおすすめのプログラミング言語は何ですか？',
            'Webアプリ開発に適した言語の選び方を教えてください。（例：Python, Ruby, PHP, JavaScriptなど）',
            '機械学習・AI開発を始めたいのですが、どの言語から学ぶべきでしょうか？',
            'Go言語の将来性についてどう思いますか？',
            'Rustの将来性についてどう思いますか？',
            '複数の言語を習得するメリットとデメリットを知りたいです。',
            'フレームワークやライブラリの選定基準についてアドバイスをお願いします。',
            '原因不明のバグに遭遇しています。効果的なデバッグ方法を教えてください。',
            'コードのパフォーマンスが思うように改善しません。ボトルネックの見つけ方や最適化のコツはありますか？',
            '大規模プロジェクトでのGitを使ったバージョン管理で、コンフリクトを減らす工夫はありますか？',
            'API連携でエラーが発生し、解決できません。（使用API、エラーコードなど詳細希望）',
            'テストコードの書き方が分からず、品質担保に不安があります。TDDの進め方など教えてほしいです。',
            '既存コードの仕様が複雑で、改修に時間がかかってしまいます。リファクタリングの進め方について相談させてください。',
            '新しい技術のキャッチアップが追いつかず、自分のスキルが陳腐化しないか不安です。',
            '開発プロジェクトの納期が厳しく、プレッシャーを感じています。メンタルヘルスの保ち方は？',
            '自分の書いたコードが原因で、本番環境で重大な障害を起こさないか心配です。',
            'チームメンバーとの技術的な意見の対立をどう解決すれば良いでしょうか？',
            '個人開発でアプリをリリースしたいのですが、アイデアが本当に受け入れられるか不安です。',
            'プログラミング学習を続けていますが、なかなか実力がついている実感がありません。モチベーション維持のコツは？',
        ];

        foreach ($questions as $question) {
            Post::create([
                'user_id' => $userIds[array_rand($userIds)], // 取得したユーザーIDからランダムに選択
                'title' => $question,
                'body' => '', // 質問なのでbodyは空に
            ]);
        }
    }
}