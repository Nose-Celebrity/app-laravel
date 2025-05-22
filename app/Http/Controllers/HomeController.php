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

    $posts = Post::with('user')->latest();
    $products = Product::with('user')->latest();

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

    return response()->view('home.index',[
        'posts' => $posts->get(),
        'products' => $products->get()
    ])
    ->header('Cache-Control','no-store,no-cache,must-revalidate')
    ->header('Pragma','no-cache')
    ->header('Expires','0');

    //return view('home.index', [
    //    'posts' => $posts->get(),
    //    'products' => $products->get()
    //]);
    //}


    }
}
