<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use App\Models\Role;


class ProfileController extends Controller
{
    public function getProfile(Request $request, $id)
    {

        $allComment = Comment::all();
        $roles = Role::all();

        //создаем коллекцию комментариев с привязкой по profile_id
        $user = User::where('id', $id)->first();
        $comments = $user->commentHasProfile()->take(5)->get();


        //Показываем кнопку подгрузки комментариев
        $countComment = $user->commentHasProfile()->count();
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
            'showButton' => $showButton,
            'roles' => $roles
        ]);
    }

    public function getComments()
    {

        $comments = Comment::where('user_id', Auth::user()->id)->get();

        return view('comments.userlist')->with('comments', $comments);
    }

    public function getUsers()
    {
        $users = User::all();
        $roles = Role::all();

        return view('user.list', ['users' => $users, 'roles' => $roles]);
    }
}
