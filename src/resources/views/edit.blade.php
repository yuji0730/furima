@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/edit.css')}}">
@endsection

@section('content')
<main class="profile-container">
    <h1 class="title">プロフィール設定</h1>

    @php
     $profile = Auth::check() ? Auth::user()->profile : null; // ユーザーに紐づくプロフィール情報
    @endphp

    <form class="profile-form" action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

        <div class="avatar-section">
        @if ($profile && $profile->image)
            <img src="{{ Storage::url($profile->image) }}" class="avatar-img" alt="プロフィール画像">
        @else
            <div class="avatar"></div>
        @endif

        <label class="image-button">
            画像を選択する
            <input type="file" name="image" accept="image/*" hidden>
        </label>
        </div>

        <label for="name">ユーザー名</label>
        <input type="text" id="name" name="name" value="{{ old('name', $profile->name ?? '') }}">
        @if ($errors->has('name'))
            <div class="error">{{ $errors->first('name') }}</div>
        @endif

        <label for="postal">郵便番号</label>
        <input type="text" id="postal" name="postal" value="{{ old('postal', $profile->postal ?? '') }}">
        @if ($errors->has('postal'))
            <div class="error">{{ $errors->first('postal') }}</div>
        @endif

        <label for="address">住所</label>
        <input type="text" id="address" name="address" value="{{ old('address', $profile->address ?? '') }}">
        @if ($errors->has('address'))
            <div class="error">{{ $errors->first('address') }}</div>
        @endif

        <label for="building">建物名</label>
        <input type="text" id="building" name="building" value="{{ old('building', $profile->building ?? '') }}">
        @if ($errors->has('building'))
            <div class="error">{{ $errors->first('building') }}</div>
        @endif

        <button type="submit" class="submit-button">更新する</button>
    </form>

</main>
@endsection
