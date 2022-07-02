<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use App\Models\Comment;

class GetMoreCommentsController extends Controller
{
    public function getComments(Request $request, $take)
    {
        if ($request->ajax()) {
            $user = User::where('id', Auth::user()->id)->first();

            //создаем коллекцию комментариев с привязкой по profile_id, и где header != null

            $count = $user->commentHasProfile()->count();
            $skip = 5;
            $comments = $user->commentHasProfile()->skip($skip)->take($take)->get();

            $allComment = Comment::all();

            return view('comments.list', ['comments' => $comments, 'allComment' => $allComment, 'user' => $user])->render();

        }
    }
}
