<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>{{ $product->title }} - 詳細</title>
    <link rel="stylesheet" href="{{ asset('/css/detail.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/header.css') }}">
    <style>
        .product-image-container {
            margin-top: 12px;
            margin-bottom: 16px;
            text-align: center;
        }
        .product-image {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            border: 1px solid #ccc;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<header class="header">
    <div class="header-left">
        <span class="site-title">情報共有サイト</span>
    </div>
    <div class="header-right">
        <form action="{{ route('home') }}" method="GET" class="search-form">
            <div class="search-box">
                <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="検索キーワードを入力" class="search-input">
                <img src="{{ asset('image/icons/search.png') }}" alt="検索" class="search-icon">
            </div>
        </form>
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
    <a href="{{ route('products.index') }}">作品一覧</a> &gt;
    <span class="current">作品詳細</span>
</nav>

<div class="container">
    <a class="browser-back" href="{{ route('products.index') }}">←作品一覧に戻る</a>

    <!-- 作品詳細 -->
    <div class="post-detail">
        <div class="post-header">
            <div class="profile-column">
                <img src="{{ asset($product->user && $product->user->photo ? 'storage/' . $product->user->photo : 'image/default_profile.png') }}"
                    alt="プロフィール画像" class="profile-img">
            </div>
            <div class="info-column">
                <p class="user-name">{{ $product->user->name ?? '不明なユーザー' }}</p>
                <h2 class="post-title">{{ $product->title }}</h2>
            </div>
        </div>

        <div class="product-image-container">
            <img src="{{ asset('storage/' . $product->photo) }}" alt="作品の画像" class="product-image">
        </div>

        <p class="post-body">{{ $product->body }}</p>

        <div class="post-meta">
            <div class="meta-row">
                <div class="meta-left">
                    <p>👍：{{ $product->getLikesCount() }}</p>
                </div>
                <div class="meta-buttons">
                    <form action="{{ route('products.toggleLike', $product->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="{{ $product->hasLiked(session('user_id')) ? 'btn-unlike' : 'btn-like' }}">
                            {{ $product->hasLiked(session('user_id')) ? 'いいね解除' : 'いいね' }}
                        </button>
                    </form>
                </div>
            </div>
            <div class="meta-date-under">
                <p class="created-at">{{ $product->date }}</p>
            </div>
        </div>
    </div>

    <!-- リプライ一覧 -->
    <div class="answer-section">
        <h3>返信一覧</h3>
        @forelse ($product->replies as $reply)
            <div class="answer" id="reply-{{ $reply->id }}">
                <div class="post-header">
                    <div class="profile-column">
                        <img src="{{ asset($reply->user && $reply->user->photo ? 'storage/' . $reply->user->photo : 'image/default_profile.png') }}"
                            alt="プロフィール画像" class="profile-img">
                    </div>
                    <div class="info-column">
                        <p class="user-name">{{ $reply->user->name ?? '不明なユーザー' }}</p>
                        <h4 class="post-title">{{ $reply->title }}</h4>
                    </div>
                </div>

                <p class="post-body">{!! $reply->makeLink(e($reply->body)) !!}</p>

                <div class="post-meta">
                    <div class="meta-row">
                        <div class="meta-left">
                            <p>👍：{{ $reply->getLikesCount() }}</p>
                        </div>
                        <div class="meta-buttons">
                            <form action="{{ route('replies.toggleLike', $reply->id) }}#reply-{{ $reply->id }}" method="POST">
                                @csrf
                                <button type="submit" class="{{ $reply->hasLiked(session('user_id')) ? 'btn-unlike' : 'btn-like' }}">
                                    {{ $reply->hasLiked(session('user_id')) ? 'いいね解除' : 'いいね' }}
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="meta-date-under">
                        <p class="created-at">{{ $reply->date }}</p>
                    </div>
                </div>
            </div>
        @empty
            <p>返信はまだありません。</p>
        @endforelse
    </div>

    <!-- リプライ投稿フォーム -->
    <div class="answer-form">
        <h3>返信を書く</h3>

        @if (session('success'))
            <div style="color: green; margin-bottom: 1em;">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="color: red; margin-bottom: 1em;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('replies.store', ['product' => $product->id]) }}" method="POST">
            @csrf

            <div>
                <label for="title">タイトル:</label><br>
                <input type="text" name="title" id="title" required style="width: 100%;">
            </div>

            <div style="margin-top: 1em;">
                <label for="body">本文:</label><br>
                <textarea name="body" id="body" rows="4" required style="width: 100%;"></textarea>
            </div>

            <div style="margin-top: 1em;">
                <button type="submit">送信</button>
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
