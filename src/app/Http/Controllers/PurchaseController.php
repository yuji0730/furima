<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;

class PurchaseController extends Controller
{
    public function purchase(Item $item)
    {
        if ($item->user_id === Auth::id()) {
            return redirect()->route('top')->with('error', '自分の商品は購入できません。');
        }

        session(['purchase_item_id' => $item->id]);

        $defaultProfile = Auth::user()->profile;

        $purchaseAddress = session('purchase_address', [
            'postal' => $defaultProfile->postal,
            'address' => $defaultProfile->address,
            'building' => $defaultProfile->building,
        ]);

        return view('purchase', [
            'item' => $item,
            'profile' => (object) $purchaseAddress
        ]);

    }


    public function address(Item $item)
    {
        $profile = Auth::user()->profile;

        if (!$profile) {
            return redirect()->route('mypage.profile')->with('error', 'プロフィールが未設定です。');
        }

        $formData = session('purchase_address', [
            'postal' => $profile->postal,
            'address' => $profile->address,
            'building' => $profile->building,
        ]);

        return view('address', [
            'item' => $item,
            'profile' => (object) $formData,
        ]);
    }


    public function updateAddress(AddressRequest $request, Item $item)
    {

        session([
        'purchase_address' => [
            'postal' => $request->postal,
            'address' => $request->address,
            'building' => $request->building,
        ]
    ]);

        return redirect()->route('purchase', ['item' => $item->id])->with('success', '配送先を更新しました。');
    }


    public function store(PurchaseRequest $request, Item $item)
{
    $user = Auth::user();
    $profile = $user->profile;


    $address = session('purchase_address');

    if (!$address && $profile) {
        $address = [
            'postal' => $profile->postal,
            'address' => $profile->address,
            'building' => $profile->building,
        ];
    } elseif (!$address) {
        
        $address = [
            'postal' => '',
            'address' => '',
            'building' => '',
        ];
    }

    Purchase::create([
        'item_id' => $item->id,
        'user_id' => $user->id,
        'pay' => $request->pay,
        'postal' => $address['postal'],
        'address' => $address['address'],
        'building' => $address['building'],
    ]);

    session()->forget('purchase_address');

    return redirect('/')->with('success', '購入が完了しました。');
}

}
