<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    <title>質問編集</title>
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
        <h1>質問を編集する</h1>
        </h1>
        <form method="POST" action="{{ route('posts.update') }}">
            @csrf
            @method('PUT')
            <label>タイトル：</label><br>
            <input type="text" name="title" value="{{ old('title', $post->title) }}"><br><br>

            <label>内容：</label><br>
            <textarea name="body">{{ old('body', $post->body) }}</textarea><br><br>

            <button type="submit">更新する</button>
        </form>
    </div>
</body>
</html>

