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
    $keyword = $request->input('keyword');

    if ($request->tab === 'mylist') {
        if (Auth::check()) {
            $likedItemIds = Auth::user()->likes()->pluck('item_id');

            $items = Item::whereIn('id', $likedItemIds)
                    ->when($keyword, function ($query) use ($keyword) {
                    $query->where('name', 'like', "%{$keyword}%");
                    })->get();
        } else {
            $items = collect();
        }
    } else {
        $items = Item::when(Auth::check(), function ($query) {
                            $query->where('user_id', '!=', Auth::id());
                        })
                        ->when($keyword, function ($query) use ($keyword) {
                            $query->where('name', 'like', "%{$keyword}%");
                        })
                        ->get();
    }

    return view('index', compact('items'));
}


    public function exhibition()
    {
        $categories = Category::all();
        return view('exhibition', compact('categories'));
    }

    public function store(ExhibitionRequest $request)
    {

        $validated = $request->validated();

        $item = new Item();
        $item->user_id = Auth::id();
        $item->name = $validated['name'];
        $item->brand = $request->input('brand');
        $item->description = $validated['description'];
        $item->condition = $validated['condition'];
        $item->price = $validated['price'];

        if ($request->hasFile('image')) {
            $filename = $request->file('image')->hashName();
            $request->file('image')->storeAs('', $filename, 'public');
            $item->image = $filename;
        }

        $item->save();

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
