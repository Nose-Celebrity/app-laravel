<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/css/detail.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/header.css') }}">
    <title>投稿詳細・回答</title>
</head>
<body>
<header class="header">
    <div class="header-left">
        <span class="site-title">情報共有サイト</span>
    </div>

    <div class="header-right">
        <div class="user-menu-wrapper">
            <img src="{{ asset(Auth::user()->photo ?? 'image/default_profile.png') }}"                class="user-icon" alt="ユーザーアイコン" onclick="toggleUserMenu()">
            <ul class="user-menu" id="userMenu">
                <li><a href="{{ route('profile.index') }}">マイプロフィール</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">@csrf
                        <button type="submit">ログアウト</button>
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
    <a class="browser-back" href="{{ route('posts.index') }}">← 質問一覧に戻る</a>

    @php
        $postUserImage = $post->user && $post->user->photo
            ? asset('storage/' . $post->user->photo)
            : asset('image/default_profile.png');
    @endphp

    <!-- 投稿カード -->
    <div class="post-detail">
        <div class="post-header">
            <div class="profile-column">
                <a href="{{ route('profile.show', $post->user->id) }}">
                    <img src="{{ $postUserImage }}" alt="プロフィール画像" class="profile-img">
                </a>
            </div>
            <div class="info-column">
                <p class="user-name">{{ $post->user->name ?? '不明なユーザー' }}</p>
                <h2 class="post-title">{{ $post->title }}</h2>
            </div>
        </div>

        <p class="post-body">{{ $post->body }}</p>

        <div class="post-meta">
            <div class="meta-row">
                <div class="meta-left">
                    <p>👍：{{ $post->getLikesCount() }}</p>
                </div>
                <div class="meta-buttons">
                    <form action="{{ route('posts.toggleLike', $post->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="{{ $post->hasLiked(session('user_id')) ? 'btn-unlike' : 'btn-like' }}">
                            {{ $post->hasLiked(session('user_id')) ? 'いいね解除' : 'いいね' }}
                        </button>
                    </form>
                </div>
            </div>
            <div class="meta-date-under">
                <p class="created-at">{{ $post->created_at->format('Y年m月d日 H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- 回答一覧 -->
    <div class="answer-section">
        <h3>回答一覧</h3>
        @foreach ($answers as $answer)
            @php
                $answerUserImage = $answer->user && $answer->user->photo
                    ? asset('storage/' . $answer->user->photo)
                    : asset('image/default_profile.png');
            @endphp

            <div class="answer" id="answer-{{ $answer->id }}">
                <div class="post-header">
                    <div class="profile-column">
                        <a href="{{ route('profile.show', $answer->user->id) }}">
                            <img src="{{ $answerUserImage }}" alt="プロフィール画像" class="profile-img">
                        </a>
                    </div>
                    <div class="info-column">
                        <p class="user-name">{{ $answer->user->name ?? '不明なユーザー' }}</p>
                        <h4 class="post-title">{{ $answer->title }}</h4>
                    </div>
                </div>

                <p class="post-body">{!! $answer->makeLink($answer->body) !!}</p>

                <div class="post-meta">
                    <div class="meta-row">
                        <div class="meta-left">
                            <p>👍：{{ $answer->getLikesCount() }}</p>
                        </div>
                        <div class="meta-buttons">
                            <form action="{{ route('answers.toggleLike', $answer->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="{{ $answer->hasLiked(session('user_id')) ? 'btn-unlike' : 'btn-like' }}">
                                    {{ $answer->hasLiked(session('user_id')) ? 'いいね解除' : 'いいね' }}
                                </button>
                            </form>
                            @if ($answer->user_id === auth()->id())
                                <a href="{{ route('answers.edit', $answer->id) }}" class="back-link">編集</a>
                                <form action="{{ route('answers.destroy', $answer->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="back-link" onclick="return confirm('本当に削除しますか？')">削除</button>
                                </form>
                            @endif
                        </div>
                    </div>
                    <div class="meta-date-under">
                        <p class="created-at">{{ $answer->created_at->format('Y年m月d日 H:i') }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- 回答投稿フォーム -->
    <div class="answer-form">
        <h3>回答を投稿</h3>
        <form action="{{ route('answers.store', $post->id) }}" method="POST">
            @csrf
            <div>
                <label for="title">タイトル</label>
                <input type="text" name="title" id="title" placeholder="タイトルを入力してください" required>
            </div>
            <div>
                <label for="body">回答</label>
                <textarea name="body" id="body" placeholder="回答を入力してください..." required></textarea>
            </div>
            <button type="submit">投稿</button>
        </form>
    </div>
</div>

<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
