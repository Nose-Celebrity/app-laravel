<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\User; // Userモデルを使用するため追加
use App\Models\Genres;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // UsersTableSeederなどで作成されたユーザーIDを取得
        $userIds = User::pluck('id')->toArray();

        // ユーザーが存在しない場合はエラーメッセージを表示して終了
        if (empty($userIds)) {
            echo "ユーザーが存在しません。UserSeederを先に実行してください。\n";
            return;
        }

        // 製品タイトルリスト
        $titles = [
            'Debatemate',
            'QUALITY TAG CHECKER',
            'スマート乗り換えナビゲーター',
            'オトコト',
        ];

        // 製品説明文リスト ($main のような役割)
        $bodies = [
            'OpenAIのAPIを用い、議論の進行やまとめを行ったり、発言内容の要約やアドバイスをしてくれるSNSです。',
            '洗濯表示をカメラで撮影するだけで、記号の意味をまとめて確認できるWEBアプリです。インストール不要で、手間なくすぐに利用できます。',
            '地図上で直感的に乗り換えルートを把握できるアプリのモックアップです。洗練されたUIで最適なルート、時間、運賃を表示し、スマートな移動をサポートします。',
            '手軽に使える音声ログ出力アプリ。AIが音声を文字起こしし、記録の手間を省きます。Web会議に参加させずにバックグラウンドで利用可能です。',
        ];

        // 製品画像パスリスト
        $photos = [
            'images/debatemate1.png',
            'images/quality_tag_checker.png',
            'images/smart_navigator.png',
            'images/otokoto.png',
        ];

        // 各製品をループ処理で作成
        foreach ($titles as $index => $title) {
            Product::create([
                'user_id' => $userIds[array_rand($userIds)], // 取得したユーザーIDからランダムに選択
                'title' => $title,
                'body' => $bodies[$index] ?? '本文が設定されていません。', // 対応する本文を設定
                'photo' => $photos[$index] ?? 'images/default.png', // 対応する画像を設定 (なければデフォルト)
                'date' => today(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
