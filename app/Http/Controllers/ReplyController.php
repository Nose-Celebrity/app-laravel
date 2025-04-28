<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reply;

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


}
