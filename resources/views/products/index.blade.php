<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('/css/header.css')}}">
    <title>作品一覧</title>
    <style>
        .product-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .product-card {
            border: 1px solid #ccc;
            padding: 10px;
            width: 200px;
            text-align: center;
        }
        .product-card img {
            width: 100%;
            height: auto;
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
                <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('image/default_profile.png') }}"
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
        <span class="current">作品一覧</span>
    </nav>
    <div class="container">
        <h1>作品一覧</h1>
        <!-- 検索フォーム -->
        <form method="GET" action="{{ route('products.index') }}">
            <input type="text" name="keyword" value="{{ request('keyword')}}" placeholder="検索内容を入力">

        <select name="genre">
            <option value="">ジャンルを選択</option>
            @foreach ($genres as $genre)
                <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>
                    {{ $genre->genre }}
                </option>
            @endforeach
        </select>

            <button type="submit">検索</button>
        </form>

        <!-- 投稿ページへのリンク -->
        <a href="{{ route('products.create') }}">▶ 新しい制作物を投稿</a>

        <div class="product-list">
            @forelse ($products as $product)
                <div class="product-card">
                    <img src="{{ asset('storage/' . $product->photo) }}" alt="作品画像">
                    <h3>{{ $product->title }}</h3>
                    <a href="{{ route('products.show', ['id' => $product->id]) }}">詳細を見る</a>
                    @if ($product->user_id === auth()->id())
                        <a href="{{ route('products.edit',  $product->id) }}">編集</a>
                        <form method="POST" action="{{ route('products.destroy', $product->id) }}" style="display:inline;" onsubmit="return confirm('本当に削除しますか？');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">削除</button>
                        </form>
                    @endif

                </div>
            @empty
                <p>作品が登録されていません。</p>
            @endforelse
        </div>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
