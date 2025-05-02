@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css')}}">
@endsection

@section('content')
<main class="product-container">
<div class="product-main">
    <div class="product-image">
        <img src="{{ asset('storage/' . $item->image) }}" alt="商品画像" style="width: 100%; height: 100%; object-fit: cover;">
    </div>

    <div class="product-details">
        <h1 class="product-title">{{ $item->name }}</h1>
        <p class="product-brand">{{ $item->brand }}</p>
        <p class="product-price">¥{{ number_format($item->price) }} <span class="tax">(税込)</span></p>

        <div class="product-actions">
            <div class="icons">
                <div class="icon-item">
                    @auth
                        <span
                            id="like-icon"
                            data-liked="{{ $item->likes->contains('user_id', auth()->id()) ? 'true' : 'false' }}"
                            style="cursor: pointer; color: {{ $item->likes->contains('user_id', auth()->id()) ? 'gold' : 'gray' }};">
                            ☆
                        </span>
                    @else
                        <span style="color: gray;" title="ログインが必要です">☆</span>
                    @endauth
                    <span id="like-count">{{ $item->likes->count() }}</span>
                </div>

                <div class="icon-item">
                    <span>💬</span>
                    <span>{{ count($item->comments ?? []) }}</span>
                </div>
            </div>
            <a href="{{ route('purchase', ['item' => $item->id]) }}">
                <button class="buy-button product-aligned">購入手続きへ</button>
            </a>
        </div>

        <section class="product-description">
            <h2>商品説明</h2>
            <p>{{ $item->description }}</p>
        </section>

        <section class="product-info">
            <h2>商品の情報</h2>
            <p>カテゴリー　  @foreach ($item->categories as $category)
                                <span class="category">{{ $category->name }}</span>
                            @endforeach</p>
            @php
            $conditions = [1 => '良好', 2 => '目立った傷や汚れなし', 3 => 'やや傷や汚れあり', 4 => '状態が悪い'];
            @endphp

            <p>商品の状態：{{ $conditions[$item->condition] ?? '不明' }}</p>

        </section>

        <section class="product-comments">
            <h2>コメント({{ count($item->comments ?? []) }})</h2>

            @foreach($item->comments ?? [] as $comment)
                <div class="comment">
                    <div class="avatar"></div>
                    <div class="comment-content">
                        <p class="comment-user">{{ $comment->user->name }}</p>
                        <div class="comment-text-wrapper">
                            <p class="comment-text">{{ $comment->comment }}</p>
                        </div>
                    </div>
                </div>
            @endforeach


            <form class="comment-form product-aligned" method="POST" action="{{ route('comment.store') }}">
                @csrf
                <input type="hidden" name="item_id" value="{{ $item->id }}">
                <label for="comment">商品へのコメント</label>
                <textarea id="comment" name="comment"></textarea>
                @error('comment')
                    <div style="color:red;">{{ $message }}</div>
                @enderror
                <button type="submit" class="comment-submit">コメントを送信する</button>
            </form>

        </section>
    </div>
</div>
</main>

<script>
document.getElementById('like-icon').addEventListener('click', function () {
    fetch("{{ route('like.toggle') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            item_id: {{ $item->id }}
        })
    })
    .then(response => response.json())
    .then(data => {
        const icon = document.getElementById('like-icon');
        const count = document.getElementById('like-count');

        if (data.status === 'liked') {
            icon.style.color = 'gold';
        } else {
            icon.style.color = 'gray';
        }

        count.textContent = data.likes_count;
    });
});
</script>

@endsection('content')
