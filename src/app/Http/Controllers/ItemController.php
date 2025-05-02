<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Like;

class ItemController extends Controller
{
    public function index(Request $request)
{
    // クエリパラメータが ?tab=mylist の場合
    if ($request->tab === 'mylist') {
        if (Auth::check()) {
            // ログイン中なら、ユーザーがいいねした商品を取得
            $items = Item::whereIn('id', Auth::user()->likes()->pluck('item_id'))->get();
        } else {
            // ゲストは空のコレクションを渡す（何も表示しない）
            $items = collect();
        }
    } else {
        // 通常の「おすすめ」表示（ログインユーザーの出品を除く）
        if (Auth::check()) {
            $items = Item::where('user_id', '!=', Auth::id())->get();
        } else {
            $items = Item::all();
        }
    }

    return view('index', compact('items'));
}




    public function exhibition()
    {
        $categories = Category::all(); // カテゴリ一覧を渡す
        return view('exhibition', compact('categories'));
    }

    public function store(ExhibitionRequest $request)
    {
        // バリデーション済みのデータを取得
        $validated = $request->validated();

        $item = new Item();
        $item->user_id = Auth::id();
        $item->name = $validated['name'];
        $item->brand = $request->input('brand'); // brandはバリデーション対象外ならこうする
        $item->description = $validated['description'];
        $item->condition = $validated['condition'];
        $item->price = $validated['price'];

        // データ保存処理などを書く
        // 画像を保存
        if ($request->hasFile('image')) {
            $filename = $request->file('image')->hashName();
            $request->file('image')->storeAs('', $filename, 'public');
            $item->image = $filename;
        }

        $item->save();

            // カテゴリー（中間テーブル）を保存
        if ($request->has('categories')) {
            $item->categories()->attach($request->input('categories'));
        }

        return redirect()->route('top')->with('success', '商品を出品しました！');
    }

    public function detail($item_id)
{
    $item = Item::with(['likes', 'comments.user', 'categories'])->findOrFail($item_id);
    return view('detail', compact('item'));
}


}
