<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>質問投稿</title>
    <link rel="stylesheet" href="{{ asset('/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/imput.css') }}">
</head>
<body>
    <header class="header">
        <div class="header-left">
            <span class="site-title">情報共有サイト</span>
        </div>
        <div class="header-right">
            <div class="user-menu-wrapper">
                <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('image/default_profile.png') }}"
                    class="user-icon" alt="ユーザーアイコン" onclick="toggleUserMenu()">
                <ul class="user-menu" id="userMenu">
                    <li><a href="{{ route('profile.index') }}">マイプロフィール</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
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
        <span class="current">質問投稿</span>
    </nav>

    <div class="container">
        <a class="browser-back" href="{{ route('posts.index') }}">← 質問一覧に戻る</a>
        <h1>新しい質問を書く</h1>

        <form method="POST" action="{{ route('posts.store') }}">
            @csrf

            <div class="form-group title-group">
                <label for="title">タイトル：</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" class="title-input">
            </div>

            <div class="form-group body-group">
                <label for="body">内容：</label>
                <textarea id="body" name="body" class="body-textarea">{{ old('body') }}</textarea>
            </div>

            <button type="submit" class="submit-button">質問を書き込む</button>
        </form>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
