<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/profile.css') }}">

    <title>プロフィール</title>
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
        <span class="current">プロフィール</span>
    </nav>

    <div class="container">
        <h1>プロフィール</h1>

        @php
            $profileImage = $user->photo
                ? asset('storage/' . $user->photo)
                : asset('image/default_profile.png');
        @endphp
        <div style="display: flex; align-items: center; gap: 24px;">
            <img src="{{ $profileImage }}" alt="プロフィール画像" style="width:150px; height:150px; object-fit:cover; border-radius:50%;">
            <div>
                <p class="profile-username">{{ $user->name }}</p>
                <p class="profile-email">{{ $user->email }}</p>
            </div>
        </div>
        <p><strong>自己紹介：</strong><br>
            {{ $profile->introduction ?? '未登録' }}
        </p>
        <a href="{{ route('profile.edit') }}" class="new-post detail-link">プロフィールを編集する</a>

        <form id="delete-account-form" method="POST" action="{{route('user.delete')}}" style="display:none;">
            @csrf
            @method('DELETE')
        </form>
        <!-- アカウント削除ボタン -->
        <button onclick="confirmDelete()" class="button-user-delete">
        アカウント削除
        </button>

        <script>
            function confirmDelete() {
            if (confirm('本当にアカウントを削除しますか？この操作は取り消せません。')) {
                document.getElementById('delete-account-form').submit();
            }
        }
        </script>
    </div>
</body>
</html>
