<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ホーム</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
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
                        <form method="POST" action="{{ route('logout') }}"　style="display:none;">
                            @csrf
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
        <span class="current">ホーム</span>
    </nav>



    <main class="main-content">
        <section class="column left-column">
            <h2>質問一覧</h2>
            @foreach ($posts as $post)
                @php
                    $profileImage = $post->user && $post->user->photo
                        ? asset('storage/' . $post->user->photo)
                        : asset('image/default_profile.png');
                @endphp

                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('profile.show', $post->user->id) }}">
                            <img src="{{ $profileImage }}" alt="プロフィール画像" class="profile-img">
                        </a>
                        <div>
                            <h3>{{ $post->title }}</h3>
                            <p class="meta">{{ $post->user->name ?? '不明なユーザー' }} / {{ $post->created_at->format('Y年m月d日 H:i') }}</p>
                        </div>
                    </div>
                    <p class = "card-body">{{ $post->body }}</p>
                    <a href="{{ route('posts.answer', $post->id) }}">詳細・回答</a>
                    @if ($post->user_id === auth()->id())
                        {{-- 削除アイコン --}}
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="delete-form" onsubmit="return confirm('本当に削除しますか？')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="icon-button" title="削除">
                                <img src="{{ asset('image/icons/delete.png') }}" alt="削除" class="action-icon">
                            </button>
                        </form>

                        {{-- 編集アイコン --}}
                        <div class="post-actions">
                            <a href="{{ route('posts.edit', $post->id) }}" class="edit-link" title="編集">
                                <img src="{{ asset('image/icons/edit.png') }}" alt="編集" class="action-icon">
                                編集する
                            </a>
                        </div>
                    @endif



                </div>
            @endforeach

        </section>

        <section class="column right-column">
            <h2>作品一覧</h2>
            <div class="product-list">
            @foreach ($products as $product)
                @php
                $profileImage = $product->user && $product->user->photo
                    ? asset('storage/' . $product->user->photo)
                    : asset('image/default_profile.png');
            @endphp

            <div class="card product-card">
                {{-- 削除アイコン（右上） --}}
                @if ($product->user_id === auth()->id())
                    <div class="product-delete">
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="icon-button" title="削除">
                                <img src="{{ asset('image/icons/delete.png') }}" class="action-icon" alt="削除">
                            </button>
                        </form>
                    </div>
                @endif

                {{-- 画像 --}}
                <img src="{{ asset('storage/' . $product->photo) }}" alt="作品画像" class="product-thumbnail">

                {{-- 投稿者 --}}
                <div class="product-user">
                    <a href="{{ route('profile.show', $product->user->id) }}">
                        <img src="{{ $profileImage }}" alt="プロフィール画像" class="product-user-icon">
                    </a>
                    <span class="product-username">{{ $product->user->name ?? '不明なユーザー' }}</span>
                </div>

                {{-- タイトル --}}
                <h3 class="product-title">{{ $product->title }}</h3>

                {{-- 詳細リンク --}}
                <a href="{{ route('products.show', $product->id) }}" class="detail-link">詳細を見る</a>

                @if ($product->user_id === auth()->id())
                    <div class="product-edit">
                        <a href="{{ route('products.edit', $product->id) }}" class="icon-button" title="編集">
                            <img src="{{ asset('image/icons/edit.png') }}" class="action-icon" alt="編集">
                        </a>
                    </div>
                @endif
            </div>
            @endforeach
            </div>

        </section>
    </main>
    <div class="floating-buttons" id="floatingButtons">
        <a href="{{ route('posts.create') }}" class="action-btn">質問投稿</a>
        <a href="{{ route('products.create') }}" class="action-btn">作品投稿</a>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>



    <script>
        window.addEventListener("pageshow", function(event) {
        if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
            // ブラウザバックされた場合に強制リロード
            window.location.reload();
        }
        });
    </script>

</body>
</html>
