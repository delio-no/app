<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getProfile($id)
    {
        $user = User::where('id', $id)->first();
        $allComment = Comment::all();

        if (!$user) {
            abort(404);
        }


        $comments = $user->commentHasProfile()->take(5)->get();

        return view('profile.index', [
            'user' => $user,
            'profileId' => $id,
            'comments' => $comments,
            'allComment' => $allComment
        ]);
    }
}
