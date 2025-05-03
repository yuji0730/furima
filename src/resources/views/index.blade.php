@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('content')
    <nav class="tabs">
        <a href="{{ route('top', ['tab' => 'recommend', 'keyword' => request('keyword')]) }}"
        class="tab {{ request('tab', 'recommend') === 'recommend' ? 'active' : '' }}">
        おすすめ
        </a>
        <a href="{{ route('top', ['tab' => 'mylist', 'keyword' => request('keyword')]) }}"
        class="tab {{ request('tab') === 'mylist' ? 'active' : '' }}">
        マイリスト
        </a>
    </nav>

    <main class="product-list">
        @foreach ($items as $item)
            <a href="/item/{{ $item->id }}" class="product-item">
                <div class="product-image small">
                    @if($item->purchase)
                        <div class="sold-badge">SOLD</div>
                    @endif
                    <img src="{{ asset('storage/' . $item->image) }}" alt="商品画像"style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <p class="product-name">{{ $item->name }}</p>
            </a>
        @endforeach
    </main>
@endsection

