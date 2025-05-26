<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/profile.css') }}">
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
                </ul>
            </div>
        </div>
    </header>
    <nav class="breadcrumb">
        <a href="{{ route('home') }}">ホーム</a> &gt;
        <span class="current">{{ $user->name }} さんのプロフィール</span>
    </nav>

    <div class="container">
        @php
            $profileImage = $user->photo
                ? asset('storage/' . $user->photo)
                : asset('image/default_profile.png');
        @endphp

        <div style="display: flex; align-items: center; gap: 24px;">
            <img src="{{ $profileImage }}" alt="プロフィール画像" style="width:150px; height:150px; object-fit:cover; border-radius:50%;"><br>
            <div>
                <p class="profile-username"><strong>{{ $user->name }}</strong></p>
                <p class="profile-email">{{ $user->email }}</p>
                <p><strong  class="intro-label">自己紹介</strong><br>
                    <span class="intro-text">{{ $profile->introduction ?? '未登録' }}</span></p>
            </div>
        </div>
    </div>
</body>
</html>
