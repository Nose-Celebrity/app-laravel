<!DOCTYPE html>
<!-- test -->
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('/css/header.css')}}">
    <title>質問一覧</title>
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
                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="質問を検索" class="search-input">
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
