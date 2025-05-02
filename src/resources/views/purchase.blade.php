@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css')}}">
@endsection

@section('content')
<div class="purchase-container">
  <div class="left-section">
    <div class="item-image"><img src="{{ asset('storage/' . $item->image) }}" alt="商品画像" style="width: 100%; height: auto; object-fit: cover;">
    </div>
    <h2 class="item-name">{{ $item->name }}</h2>
    <p class="item-price">¥{{ number_format($item->price) }}</p>

    <div class="section-divider"></div>

    <div class="form-group">
      <label for="payment">支払い方法</label>
      <select name="payment" id="payment">
        <option>選択してください</option>
        <option value="convenience">コンビニ払い</option>
        <option value="credit">カード支払い</option>
      </select>
    </div>

    <div class="section-divider"></div>

    <div class="shipping-info">
      <label>配送先</label>
      <p>〒 {{ $profile->postal ?? '未設定' }}<br>{{ $profile->address ?? '未設定' }}<br>{{ $profile->building ?? '' }}</p>
      <a href="{{ route('address.edit') }}" class="change-link">変更する</a>
    </div>
  </div>

  <div class="right-section">
    <div class="summary-box">
      <div class="summary-row">
        <span>商品代金</span>
        <span>¥{{ number_format($item->price) }}</span>
      </div>
      <div class="summary-row">
        <span>支払い方法</span>
        <span id="selected-payment">選択してください</span>
      </div>
    </div>
    <button class="buy-button">購入する</button>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const paymentSelect = document.getElementById('payment');
    const paymentDisplay = document.getElementById('selected-payment');

    if (paymentSelect && paymentDisplay) {
      paymentDisplay.textContent = paymentSelect.options[paymentSelect.selectedIndex].text;

      paymentSelect.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex].text;
        paymentDisplay.textContent = selected;
      });
    }
  });
</script>



@endsection

