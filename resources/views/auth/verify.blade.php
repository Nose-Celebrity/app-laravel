<form method="POST" action="{{ route('verify.code') }}">
    @csrf
    <input type="email" name="email" placeholder="メールアドレス">
    <input type="text" name="code" placeholder="認証コード">
    <button type="submit">認証する</button>
</form>
