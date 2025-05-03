@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/exhibition.css')}}">
@endsection

@section('content')
<div class="container">
    <h2 class="title">商品の出品</h2>

    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- 商品画像 -->
        <div class="form-section">
            <label class="section-label">商品画像</label>
            <input type="file" name="image" id="image" style="display: none;">
            <button type="button" class="select-button" onclick="document.getElementById('image').click();">画像を選択する</button>
            @error('image')
                <div style="color:red;">{{ $message }}</div>
            @enderror
            <div id="image-preview" class="image-preview"></div>
        </div>

        <!-- 商品の詳細 -->
        <div class="form-section">
            <h3 class="section-title">商品の詳細</h3>

            <label class="sub-label">カテゴリー</label>
            <div class="category-list">
                @foreach ($categories as $category)
                    <label class="category-checkbox">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}" style="display: none;">
                        {{ $category->name }}
                    </label>
                @endforeach
            </div>
            @error('categories')
                <div style="color:red;">{{ $message }}</div>
            @enderror

            <label class="sub-label">商品の状態</label>
            <select class="form-select" name="condition">
                <option disabled {{ old('condition') ? '' : 'selected' }}>選択してください</option>
                <option value="1" {{ old('condition') == 1 ? 'selected' : '' }}>良好</option>
                <option value="2" {{ old('condition') == 2 ? 'selected' : '' }}>目立った傷や汚れなし</option>
                <option value="3" {{ old('condition') == 3 ? 'selected' : '' }}>やや傷や汚れあり</option>
                <option value="4" {{ old('condition') == 4 ? 'selected' : '' }}>状態が悪い</option>
            </select>
            @error('condition')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- 商品名と説明 -->
        <div class="form-section">
            <h3 class="section-title">商品名と説明</h3>

            <label class="sub-label">商品名</label>
            <input type="text" class="form-input" name="name" value="{{ old('name') }}">
            @error('name')
                <div style="color:red;">{{ $message }}</div>
            @enderror

            <label class="sub-label">ブランド名</label>
            <input type="text" class="form-input" name="brand" value="{{ old('brand') }}">

            <label class="sub-label">商品の説明</label>
            <textarea class="form-textarea" name="description">{{ old('description') }}</textarea>
            @error('description')
                <div style="color:red;">{{ $message }}</div>
            @enderror

            <label class="sub-label">販売価格</label>
            <input type="number" class="form-input no-spinner" name="price" placeholder="¥" min="0" value="{{ old('price') }}">
            @error('price')
                <div style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- 出品ボタン -->
        <div class="form-section">
            <button type="submit" class="submit-button">出品する</button>
        </div>
    </form>
</div>

{{-- 画像プレビュー用のJS --}}
<script>
    document.getElementById('image').addEventListener('change', function(e) {
        const preview = document.getElementById('image-preview');
        preview.innerHTML = '';
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const img = document.createElement('img');
                img.src = event.target.result;
                img.style.maxWidth = '200px';
                preview.appendChild(img);
            }
            reader.readAsDataURL(file);
        }
    });
</script>

<script>
    document.querySelectorAll('.category-checkbox').forEach(label => {
        label.addEventListener('click', function(e) {
            const checkbox = label.querySelector('input[type="checkbox"]');
            checkbox.checked = !checkbox.checked;
            label.classList.toggle('active', checkbox.checked);
        });
    });
</script>

@endsection

