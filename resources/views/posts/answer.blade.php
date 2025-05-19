<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <title>投稿詳細・回答</title>
    <style>
        .answer-form input[type="text"] {
    font-size: 1.5em; /*1.5倍 */
    padding: 14px;
    width: 60%;
}

        .back-link {
            display: inline-block;
            margin: 10px 0;
            padding: 8px 16px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
        }

        .back-link:hover {
            background-color: #218838;
        }

        .post-detail {
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .answer-section {
            margin-top: 20px;
        }

        .answer {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #f0f0f0;
            border-radius: 8px;
        }

        .answer .user {
            font-size: 1em;
            color: #888;
        }

        .answer .body {
            color: #555;
        }

        .answer-form {
            margin-top: 30px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .answer-form textarea {
            width: 100%;
            height: 100px;
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .answer-form button {
            padding: 8px 16px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
        }

        .answer-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>投稿詳細・回答</h1>
        <!-- 戻るリンク -->
        <a class="back-link" href="{{ route('posts.index') }}">掲示板一覧に戻る</a>

        <!-- 投稿詳細表示 -->
        <div class="post-detail">
            <h2>{{ $post->title }}</h2>
            <p>{{ $post->body }}</p>
            <p class="user">{{ $post->user->name ?? '不明なユーザー' }}</p>
            <p class="created-at">{{ $post->created_at->format('Y年m月d日 H:i') }}</p>
        </div>

        <!-- 回答一覧表示 -->
        <div class="answer-section">
            <h3>回答一覧</h3>
            @foreach ($answers as $answer)
    <div class="answer" id="answer-{{ $answer->id }}">
    <h4 class="title">{{ $answer->title }}</h4>
    <p class="body">{{ $answer->body }}</p>
    <p class="user">{{ $answer->user->name ?? '不明なユーザー' }}</p>
    <p class="created-at">{{ $answer->created_at->format('Y年m月d日 H:i') }}</p>
    <p>👍 {{ $answer->getLikesCount() }}件のいいね</p>
    <form action="{{ route('answers.toggleLike', $answer->id) }}" method="POST">
        @csrf
        <button type="submit">
            {{ $answer->hasLiked(session('user_id')) ? 'いいね解除' : 'いいね👍' }}
        </button>
    </form>
</div>
@endforeach
        <!-- 回答フォーム -->
<div class="answer-form">
    <h3>回答を投稿</h3>
    <form action="{{ route('answers.store', $post->id) }}" method="POST">
        @csrf
        <!-- タイトル入力欄 -->
        <div>
            <label for="title">タイトル</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="タイトルを入力してください" required>
        </div>
        <!-- 回答本文入力欄 -->
        <div>
            <label for="body">回答</label>
            <textarea name="body" id="body" placeholder="回答を入力してください..." required></textarea>
        </div>
        <!-- 投稿ボタン -->
        <button type="submit">投稿</button>
    </form>
</div>

</body>
</html>
