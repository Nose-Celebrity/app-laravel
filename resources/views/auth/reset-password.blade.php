@extends('layouts.app')

@section('title', 'パスワード再設定')

@section('content')
<form method="POST" action="{{ route('password.update') }}">
    @csrf

    <input type="hidden" name="token" value="{{ $request->route('token') }}">
    <input type="hidden" name="email" value="{{ $request->email }}">

    <label for="password">新しいパスワード</label>
    <input id="password" type="password" name="password" required>

    <label for="password_confirmation">新しいパスワード（確認）</label>
    <input id="password_confirmation" type="password" name="password_confirmation" required>

    <button type="submit">パスワードを更新</button>
</form>
@endsection
