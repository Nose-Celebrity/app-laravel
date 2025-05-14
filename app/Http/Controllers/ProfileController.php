<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * プロフィール表示
     */
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile; // Userモデルのリレーション

        return view('profile.index', compact('user', 'profile'));
    }

    /**
     * プロフィール編集フォーム
     */
    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile;

        return view('profile.edit', compact('user', 'profile'));
    }

    /**
     * プロフィール更新処理
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'introduction' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();
        $user->name = $request->input('name');

        // 削除ボタンが押された場合
        if ($request->input('delete_photo') === '1') {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = null;
        }

        // 新規画像が選択された場合
        if ($request->hasFile('photo')) {
            // もし前の画像があれば削除
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            $photoPath = $request->file('photo')->store('profile_photos', 'public');
            $user->photo = $photoPath;
        }

        $user->save();

        $profile = $user->profile ?? new UserProfile(['user_id' => $user->id]);
        $profile->introduction = $request->input('introduction');
        $profile->save();

        return redirect()->route('profile.index')->with('success', 'プロフィールを更新しました');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        $profile = $user->profile;

        return view('profile.show', compact('user', 'profile'));
    }



}
