<?php

namespace App\Http\Controllers;


use App\Models\Status;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class StatusController extends Controller
{

    public function postStatus(Request $request)
    {
        $this->validate($request, [
            'status' => 'required|max:1000'
        ]);

        Auth::user()->statuses()->create([
            'body' => $request->input('status')
        ]);
        return redirect()->route('home')->with('info', 'Запись успешно добавлена');
    }

    public function postReply(Request $request, $statusId)
    {
        $this->validate($request, [
            "reply-{$statusId}" => 'required|max:1000'
        ]);

        $status = Status::notReply()->find($statusId);

        if (!$status) redirect()->route('home');

        $reply = new Status();
        $reply->body = $request->input("reply-{$status->id}");
        $reply->user()->associate(Auth::user());

        $status->replies()->save($reply);

        return redirect()->back();


    }

    public function deleteStatus($statusId)
    {
        $status = Status::findOrFail($statusId);


        if (!$status) redirect()->route('home');

        $status->delete();

        return redirect()->back();
    }
}
