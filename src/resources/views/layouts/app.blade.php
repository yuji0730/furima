<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css" />
    <link rel="stylesheet" href="{{ asset('css/common.css')}}">
    @yield('css')
</head>

<body>
    <header class="header">
    <div class="header-left">
        <a href="/" class="logo-link">
            <img src="{{ asset('storage/logo.svg') }}" alt="ロゴ" class="logo">
        </a>
    </div>
    <div class="search-container">
        <form class="search-form">
            <input type="text" placeholder="なにをお探しですか？" class="search-input">
        </form>
    </div>
    <div class="header-right">
        @guest
            <a href="{{ route('login') }}" class="header-link">ログイン</a>
        @else
            <form action="/logout" method="POST">
                @csrf
                <button class="header-link">ログアウト</button>
            </form>
        @endguest
            <a href="{{ route('mypage') }}" class="header-link">マイページ</a>

        <a href="{{ route('sell') }}" class="header-button 出品">出品</a>
    </div>
    </header>


    @yield('content')
</body>
</html>
