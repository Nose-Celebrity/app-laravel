<!DOCTYPE html>
<html lang='ja'>
<head>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible"
    content="IE=edge">
    <meta name='viewport'
    content='width=device-width,
    initial-scale=1.0'>
    <link rel="stylesheet" href="{{asset('/css/login.css')}}">

    <title>ログインフォーム</title>

    @vite(['resources/js/app.js'])

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

            <div class=floating-label>
                <input type="email" id="inputEmail" name="email" class="form-control" required placeholder="">
                <label for="inputEmail">メールアドレス</label><br>
            </div>
            <div class=floating-label>
                <input type="password" id="inputPassword" name="password" class="form-control" required placeholder="">
                <label for="inputPassword">パスワード</label><br>
            </div>

            <button class="btn btn-lg btn-primary btn-block sign_in" type="submit">サインイン</button>

            <a href="{{route('new.login')}}" class="btn btn-link mt-3">新規登録</a>

            <a href="{{route('password.change')}}" class="btn btn-link mt-3">パスワードをお忘れの場合</a>

        </form>
    </div>

    <script>
        window.addEventListener("pageshow", function(event) {
            if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
                window.location.reload();
            }
        });
    </script>

</body>
</html>
