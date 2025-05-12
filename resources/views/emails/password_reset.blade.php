<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>パスワードリセット</title>
</head>
<body>
    <h2>パスワードリセットのご案内</h2>
    <p>以下のリンクをクリックしてパスワードをリセットしてください。</p>
    <a href="{{ url('password/reset', $token) }}">パスワードをリセットする</a>
</body>
</html>
