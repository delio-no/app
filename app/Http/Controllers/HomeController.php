<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()) {

            $user = User::where('id', Auth::user()->id)->first();

            $comments = $user->commentProfile()->get();

            $statuses = Comment::notReply()->where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();

            return view('timeline.index', ['statuses' => $statuses, 'comments' => $comments, 'profileId' => Auth::user()->id]);
        }

        return view('home');
    }
}
