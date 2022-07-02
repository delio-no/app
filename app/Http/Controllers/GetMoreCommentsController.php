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
            $collectionents = $user->commentHasProfile();
            $count = $collectionents->count();
            $skip = 5;
            $comments =$collectionents->skip($skip)->take($take)->get();
            $allComment = Comment::all();
            $hideButton = false;
            if($take >= $count){
                $hideButton = true;

            }

            return view('comments.listmorecomment', [ 'comments' => $comments, 'allComment' => $allComment, 'hideButton' => $hideButton])->render();

        }
    }
}
