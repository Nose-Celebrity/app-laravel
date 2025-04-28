<h1>新しい質問を書く</h1>

<form method="POST" action="{{ route('posts.store') }}">
    @csrf

    <label>タイトル：</label><br>
    <input type="text" name="title" value="{{ old('title') }}"><br><br>

    <label>内容：</label><br>
    <textarea name="body">{{ old('body') }}</textarea><br><br>

    <button type="submit">書き込む</button>
</form>
