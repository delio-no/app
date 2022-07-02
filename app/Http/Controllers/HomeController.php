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
            $allComment = Comment::all();

            //создаем коллекцию комментариев с привязкой по profile_id
            $comments = $user->commentHasProfile()->take(5)->get();

           /*$count = $user->commentHasProfile()->count();
            dd($count);*/

            $countComment = $user->commentHasProfile()->count();


            //Показываем кнопку
            if ($countComment > 5) {
                $showButton = true;
            } else {
                $showButton = false;
            }


            return view('timeline.index', ['comments' => $comments,
                'profileId' => Auth::user()->id,
                'allComment' => $allComment,
                'showButton' => $showButton,
                'user' => $user]);
        }

        return view('home');
    }


}
