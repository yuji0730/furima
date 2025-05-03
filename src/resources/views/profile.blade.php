@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('content')
<div class="profile-container">
  <div class="profile-header">
    <div class="profile-box">
      @if ($profile && $profile->image)
        <img src="{{ asset('storage/' . $profile->image) }}" alt="プロフィール画像" class="profile-image">
      @else
        <div class="profile-image" style="background-color: #ddd;"></div>
      @endif
      <h2 class="username">{{ $profile ? $profile->name : '未設定' }}</h2>
      <a href="{{ route('mypage.profile') }}" class="edit-button">プロフィールを編集</a>
    </div>
  </div>

  <div class="tab-menu">
    <a href="{{ route('mypage', ['tab' => 'sell']) }}" class="tab {{ $tab === 'sell' ? 'active' : '' }}">出品した商品</a>
    <a href="{{ route('mypage', ['tab' => 'buy']) }}" class="tab {{ $tab === 'buy' ? 'active' : '' }}">購入した商品</a>
  </div>

  <div class="product-list">
  @if ($tab === 'sell')
    @foreach($listedItems as $item)
      <a href="{{ route('detail', ['item_id' => $item->id]) }}" class="product-item">
        <div class="product-image small">
          @if ($item->isSold())
            <div class="sold-badge">SOLD</div>
          @endif
          <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
        </div>
        <p class="product-name">{{ $item->name }}</p>
      </a>
    @endforeach
  @elseif ($tab === 'buy')
    @foreach($purchasedItems as $item)
      <a href="{{ route('detail', ['item_id' => $item->id]) }}" class="product-item">
        <div class="product-image small">
          <div class="sold-badge">SOLD</div>
          <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
        </div>
        <p class="product-name">{{ $item->name }}</p>
      </a>
    @endforeach
  @endif
  </div>

</div>
@endsection


