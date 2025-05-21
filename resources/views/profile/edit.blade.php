<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <title>プロフィール編集</title>
</head>
<body>
    <header class="header">
        <ul class="menu" style="list-style: none; padding-left: 0;">
            <li><a class="select" href="{{ route('posts.index')}}">質問</a></li>
            <li><a class="select" href="{{ route('products.index')}}">作品投稿</a></li>
            <li><a class="select now" href="{{ route('profile.index') }}">マイプロフィール</a></li>

        </ul>
    </header>

    <div class="container">
        <h1>プロフィール編集</h1>

        @if(session('success'))
            <p style="color:green;">{{ session('success') }}</p>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf

            <!-- ユーザー名 -->
            <div>
                <label for="name">ユーザー名</label><br>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <!-- 自己紹介 -->
            <div>
                <label for="introduction">自己紹介</label><br>
                <textarea name="introduction" id="introduction" rows="5" cols="50">{{ old('introduction', $profile->introduction ?? '') }}</textarea>
            </div>

            <!-- 現在のプロフィール画像 -->
            <div>
                <label>現在のプロフィール画像</label><br>
                @php
                    $profileImage = $user->photo
                        ? asset('storage/' . $user->photo)
                        : asset('image/default_profile.png');
                @endphp
                <img id="profile-preview" src="{{ $profileImage }}" alt="プロフィール画像" style="width:150px; height:150px; object-fit:cover; border-radius:50%;"><br>
            </div>

            <!-- 新しい画像選択 -->
            <div>
                <label for="photo">新しいプロフィール画像を選択</label><br>
                <input type="file" name="photo" id="photo" accept="image/*" onchange="previewProfileImage(event)">
            </div>

            <!-- 削除フラグ -->
            <input type="hidden" name="delete_photo" id="delete_photo" value="0">

            <!-- 画像削除ボタン -->
            <button type="button" onclick="deleteProfileImage()" class="new-post" style="background-color: #ff5869;">画像を削除</button>

            <br><br>
            <button type="submit" class="new-post">更新する</button>
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
