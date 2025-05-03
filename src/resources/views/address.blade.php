@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css')}}">
@endsection

@section('content')
<div class="address-edit-container">
    <h1 class="title">住所の変更</h1>

    <form action="{{ route('address.update', ['item' => $item->id]) }}" method="POST" class="address-form">
        @csrf

        <input type="hidden" name="item_id" value="{{ $item->id }}">

        <div class="form-group">
            <label for="postal">郵便番号</label>
            <input type="text" id="postal" name="postal" class="form-control" value="{{ old('postal', $profile->postal) }}">
            @error('postal')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" id="address" name="address" class="form-control" value="{{ old('address', $profile->address) }}">
            @error('address')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" id="building" name="building" class="form-control" value="{{ old('building', $profile->building) }}">
            @error('building')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="submit-btn">更新する</button>
    </form>
</div>
@endsection

