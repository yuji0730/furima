<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;

class PurchaseController extends Controller
{
    public function purchase(Item $item)
    {

        if ($item->user_id === Auth::id()) {
            return redirect()->route('top')->with('error', '自分の商品は購入できません。');
        }

        session(['purchase_item_id' => $item->id]);

        $profile = Auth::user()->profile;

        return view('purchase', compact('item', 'profile'));
    }

    public function address()
    {
        $profile = Auth::user()->profile;

        if (!$profile) {
            return redirect()->route('mypage.profile')->with('error', 'プロフィールが未設定です。');
        }

        return view('address', compact('profile'));
    }

    public function updateAddress(AddressRequest $request)
    {
        $profile = Auth::user()->profile;

        $profile->update([
            'postal' => $request->postal,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        return redirect()->route('purchase', ['item' => session('purchase_item_id')])->with('success', '配送先を更新しました。');
    }
}
