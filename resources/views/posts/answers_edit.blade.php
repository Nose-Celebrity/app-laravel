<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <title>回答編集</title>
    <style>
        .back-link {
            display: inline-block;
            margin: 10px 0;
            padding: 8px 16px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            text-align: center;
        }

        .back-link:hover {
            background-color: #218838;
        }

        .edit-form {
            margin-top: 30px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        .edit-form textarea,
        .edit-form input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .edit-form button {
            padding: 8px 16px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
        }

        .edit-form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>回答編集</h1>

        <a class="back-link" href="{{ route('posts.answer', $answer->posts_id) }}">← 投稿詳細に戻る</a>

        @if ($errors->any())
            <div style="color:red;">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form class="edit-form" method="POST" action="{{ route('answers.update', $answer->id) }}">
            @csrf
            @method('PUT')

            <label for="title">タイトル：</label><br>
            <input type="text" name="title" id="title" value="{{ old('title', $answer->title) }}"><br><br>

            <label for="body">内容：</label><br>
            <textarea name="body" id="body" rows="5">{{ old('body', $answer->body) }}</textarea><br><br>

            <button type="submit">更新する</button>
        </form>
    </div>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
