<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LikeController extends Controller
{
    // LikeController.php
public function toggle(Request $request)
{
    $itemId = $request->input('item_id');
    $user = auth()->user();

    $like = \App\Models\Like::where('user_id', $user->id)->where('item_id', $itemId)->first();

    if ($like) {
        $like->delete(); // いいね解除
        $status = 'unliked';
    } else {
        \App\Models\Like::create([
            'user_id' => $user->id,
            'item_id' => $itemId,
        ]);
        $status = 'liked';
    }

    return response()->json([
        'status' => $status,
        'likes_count' => \App\Models\Item::find($itemId)->likes()->count(),
    ]);
}

}
