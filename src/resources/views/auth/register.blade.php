@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/register.css')}}">
@endsection

@section('content')
<main class="form-container">
    <h1>会員登録</h1>
    <form action="/register" method="post">
        @csrf
        <label for="username">ユーザー名</label>
        <input type="text" id="name" name="name" value="{{old('name')}}" />
        @error('name')
        {{ $message }}
        @enderror

        <label for="email">メールアドレス</label>
        <input type="email" id="email" name="email" value="{{old('email')}}" />
        @error('email')
        {{ $message }}
        @enderror

        <label for="password">パスワード</label>
        <input type="password" id="password" name="password"  />
        @error('password')
        {{ $message }}
        @enderror

        <label for="confirm-password">確認用パスワード</label>
        <input type="password" id="password_confirmation" name="password_confirmation" />
        @error('password_confirmation')
        {{ $message }}
        @enderror

        <button type="submit">登録する</button>
    </form>

    <p class="login-link"><a href="login">ログインはこちら</a></p>
</main>
@endsection('content')
