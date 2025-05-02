@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css')}}">
@endsection

@section('content')
<div class="profile-container">
  <div class="profile-header">
    <div class="profile-box">
      @if ($profile && $profile->image)
      <img src="{{ asset('storage/profile_images/' . $profile->image) }}" alt="プロフィール画像" class="profile-image">
      @else
      <div class="profile-image" style="background-color: #ddd;"></div>
      @endif
      <h2 class="username">{{ $profile ? $profile->name : '未設定' }}</h2>
      <a href="{{ route('mypage.profile') }}" class="edit-button">プロフィールを編集</a>
    </div>
  </div>

    <div class="tab-menu">
        <a href="{{ route('mypage.profile') }}?tab=sell" class="tab {{ request('tab', 'sell') === 'sell' ? 'active' : '' }}">出品した商品</a>
        <a href="{{ route('mypage.profile') }}?tab=buy" class="tab {{ request('tab') === 'buy' ? 'active' : '' }}">購入した商品</a>
    </div>

  @if ($tab === 'sell')
  <div class="items-grid">
    @foreach($listedItems as $item)
      <div class="item-card">
        <div class="item-image">商品画像</div>
        <div class="item-name">{{ $item->name }}</div>
      </div>
    @endforeach
  </div>
@elseif ($tab === 'buy')
  <div class="items-grid">
    @foreach($purchasedItems as $item)
      <div class="item-card">
        <div class="item-image">商品画像</div>
        <div class="item-name">{{ $item->name }}</div>
      </div>
    @endforeach
  </div>
@endif

</div>
@endsection

