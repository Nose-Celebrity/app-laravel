<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>{{ $product->title }} - 詳細</title>
        <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
        <link rel="stylesheet" href="{{asset('/css/header.css')}}">

    <style>
        .container {
            width: 90%;
            max-width: 800px;
            margin: auto;
        }

        .card {
            border: 1px solid #ccc;
            padding: 1em;
            margin-bottom: 2em;
        }

        .scroll-box {
            max-height: 300px;
            overflow-y: auto;
            border-top: 1px solid #eee;
            padding-top: 1em;
        }

        .reply {
            border-bottom: 1px solid #ddd;
            margin-bottom: 1em;
            padding-bottom: 0.5em;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        .edit-link {
            float: right;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-left">
            <span class="site-title">情報共有サイト</span>
        </div>

        <div class="header-right">
            {{-- 検索フォーム --}}
            <form action="{{ route('home') }}" method="GET" class="search-form">
                <div class="search-box">
                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="検索キーワードを入力" class="search-input">
                    <img src="{{ asset('image/icons/search.png') }}" alt="検索" class="search-icon">
                </div>
            </form>

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
        <a class="browser-back" href="{{ route('products.index') }}">←</a>
        <!-- 作品詳細 -->
        <div class="card">
            <img src="{{ asset('storage/' . $product->photo) }}" alt="作品の画像">
            <p>{{ $product->body }}</p>
            <small>投稿日: {{ $product->date }}</small>
                <div style="margin-top: 10px;">
        <form action="{{ route('products.toggleLike', $product->id) }}" method="POST">
    @csrf
    <button type="submit">
        {{ $product->hasLiked(session('user_id')) ? 'いいね解除　💔' : 'いいね　❤️' }}
    </button>
</form>
<span>いいね数：{{ $product->getLikesCount() }}</span>
    </div>

        </div>

        <!-- リプライ一覧 -->
        <div class="card">
            <h3>返信一覧</h3>
            <div class="scroll-box">
                @forelse ($product->replies as $reply)
                    <div class="reply">
                        <strong>{{ $reply->title }}</strong>
                        <p>{!! $reply->makeLink(e($reply->body)) !!}</p>
                        <small>投稿日: {{ $reply->date }}</small>
            <div id="reply-{{ $reply->id }}">
    <!-- リプライ内容 -->

    <form action="{{ route('replies.toggleLike', $reply->id) }}#reply-{{ $reply->id }}" method="POST" style="margin-top: 5px;">
        @csrf
        <button type="submit">
            {{ $reply->hasLiked(session('user_id')) ? 'いいね解除 💔' : 'いいね ❤️' }}
        </button>
    </form>
    <span>いいね数：{{ $reply->getLikesCount() }}</span>
</div>
        @emptyはまだありません。</p>
                @endforelse
            </div>
        </div>

        <!-- 返信フォーム -->
        <div class="card">
            <h3>返信を書く</h3>

            {{-- 成功メッセージ --}}
            @if (session('success'))
                <div style="color: green; margin-bottom: 1em;">
                    {{ session('success') }}
                </div>
            @endif

            {{-- バリデーションエラー表示 --}}
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
