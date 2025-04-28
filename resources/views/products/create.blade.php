<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新しい制作物を投稿</title>
</head>
<body>
    <h1>新しい制作物を投稿</h1>

    <!-- バリデーションエラー表示 -->
    @if ($errors->any())
        <div style="color:red;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf

        <label>タイトル：</label><br>
        <input type="text" name="title" value="{{ old('title') }}"><br><br>

        <label>説明：</label><br>
        <textarea name="body">{{ old('body') }}"></textarea><br><br>

        <label>制作日：</label><br>
        <input type="date" name="date" value="{{ old('date') }}"><br><br>

        <label>画像：</label><br>
        <input type="file" name="photo"><br><br>

        <button type="submit">投稿する</button>
    </form>
</body>
</html>
