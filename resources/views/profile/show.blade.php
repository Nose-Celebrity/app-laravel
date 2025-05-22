<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/header.css') }}">
    <title>{{ $user->name }} さんのプロフィール</title>
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
        <span class="current">{{ $user->name }} さんのプロフィール</span>
    </nav>

    <div class="container">
        <h1>{{ $user->name }} さんのプロフィール</h1>

        @php
            $profileImage = $user->photo
                ? asset('storage/' . $user->photo)
                : asset('image/default_profile.png');
        @endphp
        <img src="{{ $profileImage }}" alt="プロフィール画像" style="width:150px; height:150px; object-fit:cover; border-radius:50%;"><br>

        <p><strong>ユーザー名：</strong> {{ $user->name }}</p>
        <p><strong>自己紹介：</strong><br>
            {{ $profile->introduction ?? '未登録' }}
        </p>
    </div>
</body>
</html>
