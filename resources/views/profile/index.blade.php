<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/header.css') }}">
    <style>
        .button-user-delete{
            display: inline-block;
            margin: 10px 0;
            border:0;
            padding: 8px 16px;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
        }

        .button-user-delete:hover{
            background-color: #BA2030;
        }
    </style>
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
        <span class="current">プロフィール</span>
    </nav>

    <div class="container">
        <h1>プロフィール</h1>

        @php
            $profileImage = $user->photo
                ? asset('storage/' . $user->photo)
                : asset('image/default_profile.png');
        @endphp
        <img src="{{ $profileImage }}" alt="プロフィール画像" style="width:150px; height:150px; object-fit:cover; border-radius:50%;">
        <p><strong>ユーザー名：</strong> {{ $user->name }}</p>
        <p><strong>メールアドレス：</strong> {{ $user->mail_address }}</p>
        <p><strong>自己紹介：</strong><br>
            {{ $profile->introduction ?? '未登録' }}
        </p>
        <a href="{{ route('profile.edit') }}" class="new-post">プロフィールを編集する</a>

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
