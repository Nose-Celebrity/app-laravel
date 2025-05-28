<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/css/imput.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/header.css') }}">
    <title>プロフィール編集</title>
</head>
<body>
    <header class="header">
        <div class="header-left">
            <span class="site-title">情報共有サイト</span>
        </div>

        <div class="header-right">
            {{-- ユーザーアイコン＆メニュー --}}
            <div class="user-menu-wrapper">
                <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('image/default_profile.png') }}"
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
        <a href="{{ route('profile.index') }}">プロフィール</a> &gt;
        <span class="current">プロフィール編集</span>
    </nav>

    <div class="container">
        <h1>プロフィール編集</h1>

        @if(session('success'))
            <p style="color:green;">{{ session('success') }}</p>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf

            <!-- ユーザー名 -->
            <div class="form-group title-group">
                <label for="name">ユーザー名</label>
                <input class="title-input" type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <!-- 自己紹介 -->
            <div class="form-group body-group">
                <label for="introduction">自己紹介</label>
                <textarea class ="body-textarea" name="introduction" id="introduction" rows="5" cols="50">{{ old('introduction', $profile->introduction ?? '') }}</textarea>
            </div>

            <!-- 現在のプロフィール画像 -->
            <div>
                <label>現在のプロフィール画像</label>
                @php
                    $profileImage = $user->photo
                        ? asset('storage/' . $user->photo)
                        : asset('image/default_profile.png');
                @endphp
                <img id="profile-preview" src="{{ $profileImage }}" alt="プロフィール画像" style="width:150px; height:150px; object-fit:cover; border-radius:50%;"><br>
            </div>

            <!-- 新しい画像選択 -->
            
            <label>新しいプロフィール画像を選択</label>
            <input type="file" name="photo" id="photo" accept="image/*" onchange="previewProfileImage(event)">
            

            <!-- 削除フラグ -->
            <input type="hidden" name="delete_photo" id="delete_photo" value="0">

            <!-- 画像削除ボタン -->
            <button type="button" onclick="deleteProfileImage()" class="button-user-delete ">画像を削除</button>

            
            <button type="submit" class="submit-button">更新する</button>
        </form>
    </div>

    <script>
        function previewProfileImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('profile-preview');
                output.src = reader.result;
                document.getElementById('delete_photo').value = '0';  // 削除フラグ解除
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function deleteProfileImage() {
            const defaultImage = "{{ asset('image/default_profile.png') }}";
            document.getElementById('profile-preview').src = defaultImage;
            document.getElementById('photo').value = ""; // ファイル選択をクリア
            document.getElementById('delete_photo').value = '1'; // 削除フラグON
        }
    </script>
</body>
</html>
