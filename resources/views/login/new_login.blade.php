<!DOCTYPE html>
<html lang='ja'>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>アカウント新規作成</title>

    <link href="{{ asset('css/signin.css') }}" rel="stylesheet"> <!-- タイポを修正 -->
    <link rel="stylesheet" href="{{asset('/css/login.css')}}">

    <script src="{{ asset('js/app.js') }}" defer></script>

</head>

<body>
    <div class="container">
        <form class="form-signin" method="POST" action="{{ route('new.registration') }}">
            @csrf
            <h1 class="h3 mb-3 font-weight-normal">アカウント新規作成</h1>

            @foreach($errors->all() as $error)
                <ul class="alert alert-danger">
                    <li>{{ $error }}</li>
                </ul>
            @endforeach

            <x-alert type="danger" :session="session('danger')"/>

            @if (session('logout'))
            <div class="alert alert-danger">
                {{ session('logout') }}
            </div>
            @endif

            <div class="floating-label">
                <input type="text" id="currentname" name="name" class="form-control" required placeholder="">
                <label for="currentname">ユーザネーム</label>
            </div>

            <div class="floating-label">
                <input type="email" id="email" name="email" class="form-control" required placeholder="">
                <label for="email">メールアドレス</label>
            </div>

            <div class="floating-label">
                <input type="password" id="currentPassword" name="password" class="form-control" required placeholder="">
                <label for="currentPassword">パスワード</label>
            </div>

            <div class="floating-label">
                <input type="password" id="newPasswordConfirmation" name="new_password" class="form-control" required placeholder="">
                <label for="newPasswordConfirmation">パスワード（再入力）</label>
            </div>


            <button class="btn btn-lg btn-primary btn-block" type="submit">新規登録</button>
        </form>
    </div>
</body>
</html>
