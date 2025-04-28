<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel= "stylesheet" href="{{asset('css/style.css')}}">
<title>test</title>
</head>
<body>
    <h1>掲示板一覧</h1>
    <a href="{{ route('posts.create') }}">新しい書き込み</a>
    @forelse ($posts as $post)
        <h3>{{ $post->title }}</h3>
        <p id="test1">{{ $post->body }}</p>
        <p>
            {{ $post->user->name ?? '不明なユーザー' }}（{{ $post->created_at->format('Y年m月d日 H:i') }}）
        </p>

    @empty
        <p>投稿内容がありません。</p>
    @endforelse

</body>
</html>
