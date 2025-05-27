@extends('layouts.app')

@section('title', 'パスワード再設定')

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}"> @csrf

        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <label for="password">新しいパスワード</label>
        <input id="password" type="password" name="password" required>

        <label for="password_confirmation">新しいパスワード（確認）</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required>

        <button type="submit">パスワードを更新</button>
    </form>
@endsection