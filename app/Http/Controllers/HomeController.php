<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(Request $request)
{
    $keyword = $request->input('keyword');

    $posts = Post::latest();
    $products = Product::latest();

    if ($keyword) {
        $posts->where(function($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
                ->orWhere('body', 'like', "%{$keyword}%");
        });

        $products->where(function($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
                ->orWhere('body', 'like', "%{$keyword}%");
        });
    }

    return view('home.index', [
        'posts' => $posts->get(),
        'products' => $products->get()
    ]);
}


}
