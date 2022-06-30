<?php

namespace App\Http\Controllers;


use App\Models\Comment;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function postComment(Request $request, $profileId)
    {

        $this->validate($request, [
            'status' => 'required|max:1000',
            'header' => 'required|max:30'
        ]);



        Auth::user()->statuses()->create([
            'body' => $request->input('status'),
            'header' => $request->input('header'),
            'profile_id' => $profileId
        ]);



        return redirect()->back()->with('info', 'Запись успешно добавлена');
    }

    public function postReply(Request $request, $commentId, $profileId)
    {

        $this->validate($request, [
            "reply-{$commentId}" => 'required|max:1000'
        ]);

        $comment = Comment::find($commentId);

        if (!$comment) redirect()->route('home');

        $reply = new Comment();
        $reply->body = $request->input("reply-{$comment->id}");
        $reply->profile_id = $profileId;
        $reply->user()->associate(Auth::user());

        $comment->replies()->save($reply);

        return redirect()->back()->with('info', 'Запись успешно добавлена');

    }

    public function deleteStatus($commentId)
    {
        $status = Comment::findOrFail($commentId);

        if (!$status) redirect()->route('home');

        $status->delete();

        return redirect()->back();
    }

}