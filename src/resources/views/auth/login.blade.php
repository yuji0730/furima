@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css')}}">
@endsection

@section('content')
<main class="login-container">
        <h1 class="login-title">ログイン</h1>

        <form action="{{ route('login') }}" method="POST" class="login-form">
            @csrf
            <div class="form-group">
                <label for="email">メールアドレス</label>
                <input type="email" id="email" name="email" value="{{old('email')}}" >
                @if ($errors->has('email'))
                    <div class="error">{{ $errors->first('email') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="password">パスワード</label>
                <input type="password" id="password" name="password" >
                @if ($errors->has('password'))
                    <div class="error">{{ $errors->first('password') }}</div>
                @endif
            </div>

            @error('auth')
            <div>{{ $message }}</div>
            @enderror

            <button type="submit" class="login-button">ログインする</button>
        </form>

        <p class="register-link">
            <a href="{{ route('register') }}">会員登録はこちら</a>
        </p>
    </main>
@endsection('content')

