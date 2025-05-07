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
        <textarea name="body">{{ old('body') }}</textarea><br><br>

        <label>画像：</label><br>
        <input type="file" name="photo" id="photoInput" accept="image/*"><br><br>

        {{-- プレビュー表示用 --}}
        <div id="previewContainer" style="display:none;">
            <p>画像プレビュー：</p>
            <img id="imagePreview" src="#" alt ="プレビュー" style="max-width: 300px" >
        </div>

        <label>ジャンル：</label><br>
        @foreach ($genres as $genre)
            <label>
                <input type="checkbox" name="genres[]" value="{{ $genre->id }}">
                {{ $genre->genre }}
            </label><br>
        @endforeach
        <br>


        <button type="submit">投稿する</button>
    </form>
    <script>
        // 画像プレビュー表示
        document.getElementById('photoInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const previewContainer = document.getElementById('previewContainer');
            const preview = document.getElementById('imagePreview');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    preview.src = event.target.result;
                    previewContainer.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
            else {
                previewContainer.style.display = 'none';
                preview.src = '#';
            }
        });
    </script>
</html>
