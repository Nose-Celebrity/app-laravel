<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reply;

use Illuminate\Support\Facades\Redis;
class ReplyController extends Controller
{
    public function store(Request $request, $productID)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        Reply::create([
            'user_id' => auth()->id() ?? 1,
            'product_id' => $productID,
            'title' => $request->title,
            'body' => $request->body,
            'date' => now(),
        ]);

        return redirect()->route('products.show', $productID)->with('success', '返信が投稿されました！');    }

        public function toggleLike($id)
{
    $reply = Reply::findOrFail($id);
    $userId = session('user_id'); // 認証しているなら auth()->id() でもOK

    if ($reply->hasLiked($userId)) {
        $reply->unlike($userId);
    } else {
        $reply->like($userId);
    }

    return redirect()->back()->withFragment('reply-' . $id);
}
}


