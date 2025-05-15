<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Post;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */




    /**
     * Display the specified resource.
     */





    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        Answer::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' =>1, //仮auth()->id(),
            'posts_id' => $post->id,
        ]);

        return redirect()->route('posts.answer', $post);
    }
public function toggleLike($id)
{
    $answer = Answer::findOrFail($id);
    $userId = session('user_id');

    if ($answer->hasLiked($userId)) {
        $answer->unlike($userId);
    } else {
        $answer->like($userId);
    }

    return redirect()->back();
}
}
