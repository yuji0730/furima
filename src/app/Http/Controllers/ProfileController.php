<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Profile;
use App\Models\Item;
use App\Models\Purchase;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // プロフィールを取得
        $profile = Profile::where('user_id', $user->id)->first();

        if (!$profile) {
            return redirect()->route('mypage.profile');
        }

        $tab = $request->query('tab', 'sell'); // デフォルトは出品商品

        $listedItems = collect(); // 空のコレクションを初期化
        $purchasedItems = collect();

        if ($tab === 'sell') {
            $listedItems = Item::where('user_id', $user->id)->get();
        } elseif ($tab === 'buy') {
            $purchasedItemIds = Purchase::where('user_id', $user->id)->pluck('item_id');
            $purchasedItems = Item::whereIn('id', $purchasedItemIds)->get();
        }

        return view('profile', compact('profile', 'listedItems', 'purchasedItems', 'tab'));
    }

    public function edit()
    {
    return view('edit');
    }


    public function update(ProfileRequest $profileRequest, AddressRequest $addressRequest)
    {
        $user = Auth::user();
        $profile = $user->profile ?? new Profile(['user_id' => $user->id]);

        $validated = array_merge(
            $profileRequest->validated(),
            $addressRequest->validated()
        );

        $profile->name = $validated['name'];
        $profile->postal = $validated['postal'] ?? null;
        $profile->address = $validated['address'] ?? null;
        $profile->building = $validated['building'] ?? null;

        if (request()->hasFile('image')) {
            if ($profile->image) {
                Storage::disk('public')->delete('' . $profile->image);
            }

            $filename = uniqid() . '.' . request()->file('image')->getClientOriginalExtension();
            request()->file('image')->storeAs('public', $filename);
            $profile->image = $filename;
        }

        $profile->save();

        return redirect('/')->with('success', 'プロフィールを更新しました');
    }


}
