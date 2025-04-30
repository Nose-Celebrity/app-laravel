<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
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
    <h1>作品一覧</h1>
    <!-- 検索フォーム -->
    <form method="GET" action="{{ route('products.index') }}">
        <input type="text" name="keyword" value="{{ request(`keyword`)}}" placeholder="aaaaa">
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
</body>
</html>
