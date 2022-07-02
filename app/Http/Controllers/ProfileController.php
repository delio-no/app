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
        //создаем коллекцию комментариев с привязкой по profile_id, и где header != null
        $comments = $user->commentHasProfile()->take(5)->get();
        $countComment = $user->commentHasProfile()->count();


        //Показываем кнопку подгрузки комментариев
        if ($countComment > 5) {
            $showButton = true;
        } else {
            $showButton = false;
        }

        //выкидываем 404, если юзера нету
        if (!$user) {
            abort(404);
        }


        return view('profile.index', [
            'user' => $user,
            'profileId' => $id,
            'comments' => $comments,
            'allComment' => $allComment,
            'showButton' => $showButton
        ]);
    }
}
