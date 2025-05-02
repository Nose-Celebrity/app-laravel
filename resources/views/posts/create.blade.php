<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    <title>post create</title>
    <style>
        button{
            display: inline-block;
            margin: 10px 0;
            border:0;
            padding: 8px 16px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
        }

        button:hover{
        background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <a class = "browser-back" href="{{ route('posts.index') }}">←</a>
        <h1>新しい質問を書く</h1>
        <form method="POST" action="{{ route('posts.store') }}">
            @csrf
            <label>タイトル：</label><br>
            <input type="text" name="title" value="{{ old('title') }}"><br><br>

            <label>内容：</label><br>
            <textarea name="body">{{ old('body') }}</textarea><br><br>

            <button type="submit">書き込む</button>
        </form>
    </div>
</body>
</html>

