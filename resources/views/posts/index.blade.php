<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    <title>質問一覧</title>
    <style>
        .new-post {
            display: inline-block;
            margin: 10px 0;
            padding: 8px 16px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
        }

        .new-post:hover {
            background-color: #0056b3;
        }

        .post {
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .post h3 {
            margin-top: 0;
            color: #555;
        }

        .user{
            text-align: right;
            font-size: 1em;
            color: #999;
        }

        .body {
            color: #666;
        }


        .no-posts {
            text-align: center;

            font-size: 1em;
            color: #888;
        }

        button{
            display: inline-block;
            margin: 10px 0;
            border:0;
            padding: 8px 16px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
        }
    </style>
</head>
<body>
    <header class="header">
        <ul class="menu" style="list-style: none; padding-left: 0;">
            <li><a class="select now" href="{{ route('posts.index')}}">質問</a></li>
            <li><a class="select " href="{{ route('products.index')}}">作品投稿</a></li>
            <!-- 自分のプロフィール -->
            <li><a class="select" href="{{ route('profile.index') }}">マイプロフィール</a></li>
        </ul>
    </header>
    <div class="container">
        <h1>質問一覧</h1>
        <a class = "new-post" href="{{ route('posts.create') }}">新しい書き込み</a>
        @forelse ($posts as $post)
            <div class="post">

                <!-- 投稿者のプロフィール画像 -->
                @php
                    $profileImage = $post->user && $post->user->photo
                        ? asset('storage/' . $post->user->photo)
                        : asset('image/default_profile.png');
                @endphp
                <a href="{{ route('profile.show', $post->user->id) }}">
                    <img src="{{ $profileImage }}" alt="プロフィール画像" style="width:50px; height:50px; object-fit:cover; border-radius:50%; float:left; margin-right:10px;">
                </a>

                <!-- タイトル・本文 -->
                <h3>{{ $post->title }}</h3>
                <p class="body">{{ $post->body }}</p>

                <!-- 投稿者情報 -->
                <p class="user">
                    {{ $post->user->name ?? '不明なユーザー' }}（{{ $post->created_at->format('Y年m月d日 H:i') }}）
                </p>

                <!-- 詳細・編集・削除 -->
                <a href="{{ route('posts.answer', $post->id) }}" class="new-post">詳細・回答へ</a>
                @if ($post->user_id === auth()->id())
                    <a href="{{ route('posts.edit', $post->id) }}" class="new-post">編集</a>

                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="new-post" onclick="return confirm('本当に削除しますか？')">削除</button>
                    </form>
                @endif

            </div>
        @empty
            <p class="no-posts">投稿内容がありません。</p>
        @endforelse

    </div>


</body>
</html>
