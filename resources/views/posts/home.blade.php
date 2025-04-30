<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ホーム画面</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <x-alert type="success" :session="session('success')"/>

        <h3>プロフィール</h3>
        <ul>
            <li>名前: {{ Auth::user()->name }}</li>
            <li>メールアドレス: {{ Auth::user()->mail_address }}</li>
        </ul>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-danger">ログアウト</button>

        </form>
        <!--
        <a href="{{route('posts.index')}}" class="btn btn-primary">掲示板</a>
        -->
    </div>
</body>
</html>
