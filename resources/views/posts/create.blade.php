<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('/css/header.css')}}">
    <title>質問投稿</title>
    <style>
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

        button:hover{
        background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="header-left">
            <span class="site-title">情報共有サイト</span>
        </div>

        <div class="header-right">
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
    <nav class="breadcrumb">
        <a href="{{ route('home') }}">ホーム</a> &gt;
        <a href="{{ route('posts.index') }}">質問一覧</a> &gt;
        <span class="current">質問投稿</span>
    </nav>
    <div class="container">
        <a class = "browser-back" href="{{ route('posts.index') }}">←</a>
        <h1>新しい質問を書く</h1>
        <form method="POST" action="{{ route('posts.store') }}">
            @csrf
            <label>タイトル：</label><br>
            <input type="text" name="title" value="{{ old('title') }}"><br><br>

            <label>内容：</label><br>
            <textarea name="body">{{ old('body') }}</textarea><br><br>

            <button type="submit">書き込む</button>
        </form>
    </div>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>

