<!DOCTYPE html>
<html lang='ja'>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>パスワード変更</title>

    <link href="{{ asset('css/signin.css') }}" rel="stylesheet"> <!-- タイポを修正 -->

    <script src="{{ asset('js/app.js') }}" defer></script>

</head>

<body>
    <form class="form-signin" method="POST" action="{{ route('password.update') }}">
        @csrf
        <h1 class="h3 mb-3 font-weight-normal">パスワード変更</h1>

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


        <label for="currentmailaddress">変更したいIDのメールアドレス</label>
        <input type="mailaddress" id="currentmailaddress" name="mailaddress" class="form-control" placeholder="メールアドレス" required>

        <label for="currentPassword">現在のパスワード</label>
        <input type="password" id="currentPassword" name="password" class="form-control" placeholder="現在のパスワード" required>

        <label for="newPassword">新しいパスワード</label>
        <input type="password" id="newPassword" name="new_password" class="form-control" placeholder="新しいパスワード" required>

        <label for="newPasswordConfirmation">新しいパスワード（再入力）</label>
        <input type="password" id="newPasswordConfirmation" name="new_password_confirmation" class="form-control" placeholder="確認のため再入力" required>

        <button class="btn btn-lg btn-primary btn-block" type="submit">パスワード変更</button>
    </form>
</body>
</html>
