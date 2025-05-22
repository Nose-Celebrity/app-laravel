<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link rel="stylesheet" href="{{asset('/css/header.css')}}">
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
    <header class="header">
        <div class="header-left">
            <span class="site-title">情報共有サイト</span>
        </div>

        <div class="header-right">
            {{-- ユーザーアイコン＆メニュー --}}
            <div class="user-menu-wrapper">
                <img src="{{ asset(Auth::user()->photo ?? 'image/default_profile.png') }}"
                    class="user-icon" alt="ユーザーアイコン" onclick="toggleUserMenu()">
                <ul class="user-menu" id="userMenu">
                    <li><a href="{{ route('profile.index') }}">マイプロフィール</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">@csrf
                            <button type="submit">ログアウト</button>
                        </form>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('user.delete') }}" onsubmit="return confirm('本当に削除しますか？');">
                            @csrf @method('DELETE')
                            <button type="submit">パスワード変更</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <nav class="breadcrumb">
        <a href="{{ route('home') }}">ホーム</a> &gt;
        <a href="{{ route('posts.index') }}">質問一覧</a> &gt;
        <span class="current">質問詳細・回答</span>
    </nav>
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
            <p>いいね数：{{ $post->getLikesCount() }}</p>
    <form action="{{ route('posts.toggleLike', $post->id) }}" method="POST">
        @csrf
        <button type="submit">
            {{ $post->hasLiked(session('user_id')) ? 'いいね解除　💔' : 'いいね　❤️' }}
        </button>
    </form>
        </div>

        <!-- 回答一覧表示 -->
        <div class="answer-section">
            <h3>回答一覧</h3>
            @foreach ($answers as $answer)
            <div class="answer" id="answer-{{ $answer->id }}">
            <h4 class="title">{{ $answer->title }}</h4>
            <p class="body">{!! $answer->makeLink($answer->body) !!}</p>
            <p class="user">{{ $answer->user->name ?? '不明なユーザー' }}</p>
            <p class="created-at">{{ $answer->created_at->format('Y年m月d日 H:i') }}</p>
            @if ($answer->user_id === auth()->id())
                <a href="{{ route('answers.edit', $answer->id) }}" class="back-link">編集</a>
                <form action="{{ route('answers.destroy', $answer->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="back-link" onclick="return confirm('本当に削除しますか？')">削除</button>
                </form>
            @endif
            <p>いいね数：{{ $answer->getLikesCount() }}</p>
            <form action="{{ route('answers.toggleLike', $answer->id) }}" method="POST">
                @csrf
                <button type="submit">
                    {{ $answer->hasLiked(session('user_id')) ? 'いいね解除　💔' : 'いいね　❤️' }}
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
<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
