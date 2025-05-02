@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')
<nav class="tabs">
        <a href="{{ route('top') }}" class="tab {{ request()->routeIs('top') && request()->tab != 'mylist' ? 'active' : '' }}">おすすめ</a>
        <a href="{{ route('top') }}?tab=mylist" class="tab {{ request()->routeIs('top') && request()->tab == 'mylist' ? 'active' : '' }}">マイリスト</a>
    </nav>

    <main class="product-list">
        @foreach ($items as $item)
            <a href="/item/{{ $item->id }}" class="product-item">
                <div class="product-image">
                    <img src="{{ asset('storage/' . $item->image) }}" alt="商品画像"style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <p class="product-name">{{ $item->name }}</p>
            </a>
        @endforeach
    </main>
@endsection('content')

