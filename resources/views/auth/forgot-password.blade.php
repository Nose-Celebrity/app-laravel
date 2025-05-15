@extends('layouts.app')

@section('title', 'パスワードをお忘れですか？')

@section('content')

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <label for="mail_address">メールアドレス</label>
        <input id="mail_address" type="email" name="mail_address" value="{{ old('mail_address') }}" required autofocus>

        <button type="submit">再設定リンクを送信</button>
    </form>
@endsection
