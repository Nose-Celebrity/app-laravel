<!DOCTYPE html>
<html lang='ja'>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>アカウント新規作成</title>

    <link href="{{ asset('css/signin.css') }}" rel="stylesheet"> <!-- タイポを修正 -->

    <script src="{{ asset('js/app.js') }}" defer></script>

</head>

<body>
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

        <label for="currentmailaddress">ユーザネーム</label>
        <input type="text" id="currentname" name="name" class="form-control" placeholder="ユーザネーム" required>

        <label for="email">メールアドレス</label>
        <input type="email" id="email" name="email" class="form-control" placeholder="メールアドレス" required>

        <label for="currentPassword">パスワード</label>
        <input type="password" id="currentPassword" name="password" class="form-control" placeholder="パスワード" required>

        <label for="newPasswordConfirmation">パスワード（再入力）</label>
        <input type="password" id="newPasswordConfirmation" name="new_password" class="form-control" placeholder="確認のため再入力" required>

        <button class="btn btn-lg btn-primary btn-block" type="submit">新規登録</button>
    </form>
</body>
</html>
