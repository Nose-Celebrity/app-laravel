<!DOCTYPE html>
<html lang='ja'>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible"
    content="IE=edge">
    <meta name='viewport'
    content='width=device-width,
    initial-scale=1.0'>
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">

    <title>ログインフォーム</title>

    <script src="{{asset('js/app.js')}}"defer></script>

</head>

<body>
    <div class="container">
        <form class="form-signin" method="POST" action="{{
            route('login') }}">
            @csrf
            <h1 class="h3 mb-3 font-weight-normal">ログイン</h1>
            @foreach($errors->all() as $error)
                <ul class="alert alert-danger">
                    <li>{{$error}}</li>
                </ul>
            @endforeach

            <x-alert type="danger" :session="session('danger')"/>



            @if (session('logout'))
            <div class="alert alert-danger">
                {{session('logout')}}
            </div>
            @endif

            <label for="inputEmail" class="sr-only">メールアドレス</label>
            <input type="email" id="inputEmail" name="mail_address" class="form-control" placeholder="Email address" required autofocus>
            <label for="inputPassword" class="sr-only">パスワード</label>
            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>

            <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>

            <a href="{{route('new.login')}}" class="btn btn-link mt-3">新規登録</a>

            <a href="{{route('password.change')}}" class="btn btn-link mt-3">パスワードを変更する</a>

        </form>

    </div>
</body>
</html>
