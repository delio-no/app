<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use Auth;

class UserListCommentsController extends Controller
{
    public function showComments()
    {

        $comments = Comment::where('user_id', Auth::user()->id)->get();

        return view('comments.userlist')->with('comments', $comments);
    }
}
