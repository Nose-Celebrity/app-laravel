<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{asset('/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('/css/header.css')}}">
    <title>制作物を編集</title>
</head>
<body>
    <header class="header">
        <div class="header-left">
            <span class="site-title">情報共有サイト</span>
        </div>

        <div class="header-right">
            {{-- ユーザーアイコン＆メニュー --}}
            <div class="user-menu-wrapper">
                <img src="{{ asset(Auth::user()->photo ?? 'image/default_profile.png') }}"
                    class="user-icon" alt="ユーザーアイコン" onclick="toggleUserMenu()">
                <ul class="user-menu" id="userMenu">
                    <li><a href="{{ route('profile.index') }}">マイプロフィール</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">@csrf
                            <button type="submit">ログアウト</button>
                        </form>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('user.delete') }}" onsubmit="return confirm('本当に削除しますか？');">
                            @csrf @method('DELETE')
                            <button type="submit">パスワード変更</button>
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
        <h1>制作物を編集</h1>

        <!-- バリデーションエラー表示 -->
        @if ($errors->any())
            <div style="color:red;">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label>タイトル：</label><br>
            <input type="text" name="title" value="{{ old('title', $product->title) }}"><br><br>

            <label>説明：</label><br>
            <textarea name="body">{{ old('body', $product->body) }}</textarea><br><br>

            <label>ジャンル：</label><br>
            @foreach ($genres as $genre)
                <label>
                    <input type="checkbox" name="genres[]" value="{{ $genre->id }}"
                        {{ in_array($genre->id, $selectedGenres) ? 'checked' : '' }}>
                    {{ $genre->genre }}
                </label><br>
            @endforeach
            <br>

            <label>現在の画像：</label><br>
            <img src="{{ asset('storage/' . $product->photo) }}" alt="現在の画像" style="max-width: 300px;"><br><br>
            <label>新しい画像：</label><br>
            <input type="file" name="photo" id="photoInput" accept="image/*"><br><br>

            {{-- プレビュー表示用 --}}
            <div id="previewContainer" style="display:none;">
                <p>画像プレビュー：</p>
                <img id="imagePreview" src="#" alt ="プレビュー" style="max-width: 300px">
            </div>
            <button type="submit">更新する</button>
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
    </div>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
