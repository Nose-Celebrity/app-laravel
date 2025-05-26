<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>制作物を編集</title>
    <link rel="stylesheet" href="{{ asset('/css/imput.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/header.css') }}">
</head>
<body>
    <header class="header">
        <div class="header-left">
            <span class="site-title">情報共有サイト</span>
        </div>
        <div class="header-right">
            <div class="user-menu-wrapper">
                <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('image/default_profile.png') }}"
                    class="user-icon" alt="ユーザーアイコン" onclick="toggleUserMenu()">
                <ul class="user-menu" id="userMenu">
                    <li><a href="{{ route('profile.index') }}">マイプロフィール</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">ログアウト</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <nav class="breadcrumb">
        <a href="{{ route('home') }}">ホーム</a> &gt;
        <a href="{{ route('products.index') }}">作品一覧</a> &gt;
        <span class="current">作品編集</span>
    </nav>

    <div class="container">
        <a class="browser-back" href="{{ route('products.index') }}">← 作品一覧に戻る</a>
        <h1>制作物を編集</h1>

        @if ($errors->any())
            <div class="error-messages">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group title-group">
                <label for="title">タイトル：</label>
                <input type="text" id="title" name="title" value="{{ old('title', $product->title) }}" class="title-input">
            </div>

            <div class="form-group body-group">
                <label for="body">説明：</label>
                <textarea id="body" name="body" class="body-textarea">{{ old('body', $product->body) }}</textarea>
            </div>

            <div class="form-group">
                <div class="file-button-wrapper">
                    <label for="photoInput" class="file-label">
                        <img src="{{ asset('image/icons/photo.png') }}" alt="画像アイコン" class="file-icon">
                        画像を選択
                    </label>
                    <input type="file" name="photo" id="photoInput" accept="image/*" class="file-input-hidden">
                </div>

                <div id="current-edit-previewContainer">
                    <p>現在登録済みの画像</p>
                    <img src="{{ asset('storage/' . $product->photo) }}" alt="現在の画像" class="image-preview">
                </div>

                <div id="edit-previewContainer" style="display:none;">
                    <p>変更後の画像</p>
                    <img id="imagePreview" src="#" alt="プレビュー" class="image-preview">
                </div>
            </div>

            <div class="form-group genre-group">
                <label>ジャンル：</label><br>
                @foreach ($genres as $genre)
                    <div class="genre-checkbox">
                        <input type="checkbox" id="genre_{{ $genre->id }}" name="genres[]" value="{{ $genre->id }}"
                            {{ in_array($genre->id, $selectedGenres) ? 'checked' : '' }}>
                        <label for="genre_{{ $genre->id }}">{{ $genre->genre }}</label>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="submit-button">更新する</button>
        </form>

        <script>
            document.getElementById('photoInput').addEventListener('change', function(event) {
                const file = event.target.files[0];
                const previewContainer = document.getElementById('edit-previewContainer');
                const preview = document.getElementById('imagePreview');
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        preview.src = event.target.result;
                        previewContainer.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                } else {
                    previewContainer.style.display = 'none';
                    preview.src = '#';
                }
            });
        </script>
    </div>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
