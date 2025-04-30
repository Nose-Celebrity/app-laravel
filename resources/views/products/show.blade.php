<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>{{ $product->title }} - 詳細</title>
    <style>
        .container {
            width: 90%;
            max-width: 800px;
            margin: auto;
        }

        .card {
            border: 1px solid #ccc;
            padding: 1em;
            margin-bottom: 2em;
        }

        .scroll-box {
            max-height: 300px;
            overflow-y: auto;
            border-top: 1px solid #eee;
            padding-top: 1em;
        }

        .reply {
            border-bottom: 1px solid #ddd;
            margin-bottom: 1em;
            padding-bottom: 0.5em;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        .edit-link {
            float: right;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- 作品詳細 -->
        <div class="card">
            <img src="{{ asset('storage/' . $product->photo) }}" alt="作品の画像">
            <p>{{ $product->body }}</p>
            <small>投稿日: {{ $product->date }}</small>
        </div>

        <!-- リプライ一覧 -->
        <div class="card">
            <h3>返信一覧</h3>
            <div class="scroll-box">
                @forelse ($product->replies as $reply)
                    <div class="reply">
                        <strong>{{ $reply->title }}</strong>
                        <p>{{ $reply->body }}</p>
                        <small>投稿日: {{ $reply->date }}</small>
                    </div>
                @empty
                    <p>返信はまだありません。</p>
                @endforelse
            </div>
        </div>

        <!-- 返信フォーム -->
        <div class="card">
            <h3>返信を書く</h3>

            {{-- 成功メッセージ --}}
            @if (session('success'))
                <div style="color: green; margin-bottom: 1em;">
                    {{ session('success') }}
                </div>
            @endif

            {{-- バリデーションエラー表示 --}}
            @if ($errors->any())
                <div style="color: red; margin-bottom: 1em;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('replies.store', ['product' => $product->id]) }}" method="POST">
                @csrf

                <div>
                    <label for="title">タイトル:</label><br>
                    <input type="text" name="title" id="title" required style="width: 100%;">
                </div>

                <div style="margin-top: 1em;">
                    <label for="body">本文:</label><br>
                    <textarea name="body" id="body" rows="4" required style="width: 100%;"></textarea>
                </div>

                <div style="margin-top: 1em;">
                    <button type="submit">送信</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
