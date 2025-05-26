<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/css/post.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/header.css') }}">
    <title>質問一覧</title>
</head>
<body>
    <header class="header">
        <div class="header-left">
            <span class="site-title">情報共有サイト</span>
        </div>

        <div class="header-right">
            <form action="{{ route('posts.index') }}" method="GET" class="search-form">
                <div class="search-box">
                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="キーワードで質問を検索" class="search-input">
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
        <span class="current">質問一覧</span>
    </nav>

    <div class="container">
        <h1>質問一覧</h1>

        @forelse ($posts as $post)
            <div class="post">
                @php
                    $profileImage = $post->user && $post->user->photo
                        ? asset('storage/' . $post->user->photo)
                        : asset('image/default_profile.png');
                @endphp

                <div class="post-header">
                    <div class="profile-column">
                        <a href="{{ route('profile.show', $post->user->id) }}">
                            <img src="{{ $profileImage }}" alt="プロフィール画像" class="profile-img">
                        </a>
                    </div>
                    <div class="text-column">
                        <h3 class="post-title">{{ $post->title }}</h3>
                        <p class="user">
                            {{ $post->user->name ?? '不明なユーザー' }}（{{ $post->created_at->format('Y年m月d日 H:i') }}）
                        </p>
                    </div>
                </div>

                <p class="body">{{ $post->body }}</p>

                <a href="{{ route('posts.answer', $post->id) }}" class="detail-link">詳細・回答</a>


                @if ($post->user_id === auth()->id())
                
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="delete-form" onsubmit="return confirm('本当に削除しますか？')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="icon-button" title="削除">
                            <img src="{{ asset('image/icons/delete.png') }}" class="action-icon" alt="削除">
                        </button>
                    </form>

                    <div class="post-actions">
                        <a href="{{ route('posts.edit', $post->id) }}" class="edit-link" title="編集">
                            <img src="{{ asset('image/icons/edit.png') }}" class="action-icon" alt="編集">
                            編集する
                        </a>
                    </div>
                @endif
            </div>
        @empty
            <p class="no-posts">投稿内容がありません。</p>
        @endforelse
    </div>

    <div class="floating-button">
        <a href="{{ route('posts.create') }}" class="new-post">新しい書き込み</a>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
