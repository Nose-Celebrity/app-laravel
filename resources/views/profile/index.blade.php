<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <title>プロフィール</title>
</head>
<body>
    <header class="header">
        <ul class="menu" style="list-style: none; padding-left: 0;">
            <li><a class="select" href="{{ route('posts.index')}}">質問</a></li>
            <li><a class="select" href="{{ route('products.index')}}">作品投稿</a></li>
        </ul>
    </header>

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
    </div>
</body>
</html>
