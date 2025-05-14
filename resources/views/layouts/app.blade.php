<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'パスワード再設定')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
</head>
<body>
    <main class="container">
        <h1>@yield('title', 'パスワード再設定')</h1>

        @if (session('status'))
            <article style="background: #d4edda; padding: 1em; border-radius: 5px;">
                {{ session('status') }}
            </article>
        @endif

        @if ($errors->any())
            <article style="background: #f8d7da; padding: 1em; border-radius: 5px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </article>
        @endif

        @yield('content')
    </main>
</body>
</html>
