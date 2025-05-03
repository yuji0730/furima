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
    <form action="{{ route('purchase.store', ['item' => $item->id]) }}" method="POST">
        @csrf
    <div class="form-group">
      <label for="pay">支払い方法</label>
      <select name="pay" id="pay">
        <option value="">選択してください</option>
        <option value="1" {{ old('pay') == '1' ? 'selected' : '' }}>コンビニ払い</option>
        <option value="2" {{ old('pay') == '2' ? 'selected' : '' }}>カード支払い</option>
      </select>
      @error('pay')
            <div class="error">{{ $message }}</div>
      @enderror
    </div>

    <div class="section-divider"></div>

    <div class="shipping-info">
      <label>配送先</label>
      <p>〒 {{ $profile->postal ?? '未設定' }}<br>{{ $profile->address ?? '未設定' }}<br>{{ $profile->building ?? '' }}</p>
      <a href="{{ route('address.edit', ['item' => $item->id]) }}" class="change-link">変更する</a>

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
        <span id="selected-payment">
            @switch(old('pay'))
                @case('1') コンビニ払い @break
                @case('2') カード支払い @break
                @default 選択してください
            @endswitch
        </span>
      </div>
    </div>
        <button class="buy-button" type="submit">購入する</button>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('pay');
    const display = document.getElementById('selected-payment');

    const labelMap = {
      "1": "コンビニ払い",
      "2": "カード支払い"
    };

    const updateDisplay = () => {
      display.textContent = labelMap[select.value] || "選択してください";
    };

    updateDisplay();
    select.addEventListener('change', updateDisplay);
  });
</script>

@endsection

