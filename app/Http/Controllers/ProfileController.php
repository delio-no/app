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


        if (!$user) {
            abort(404);
        }

        /*$statuses = $user->statuses()->notReply()->get();*/

        $comments = $user->commentProfile()->get();


        return view('profile.index', [
            'user' => $user,
            /*'statuses' => $statuses,*/
            'profileId' => $id,
            'comments' => $comments
        ]);
    }
}
