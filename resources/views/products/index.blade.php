<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
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
    <div class="container">
        <h1>作品一覧</h1>
        <ul class="menu" style="list-style: none; padding-left: 0;">
            <li><a class="select " href="{{ route('posts.index')}}">質問</a></li>
            <li><a class="select now" href="{{ route('products.index')}}">作品投稿</a></li>
            </ul>
        <!-- 検索フォーム -->
        <form method="GET" action="{{ route('products.index') }}">
            <input type="text" name="keyword" value="{{ request('keyword')}}" placeholder="検索内容を入力">
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
                </div>
            @empty
                <p>作品が登録されていません。</p>
            @endforelse
        </div>
    <div>
</body>
</html>
