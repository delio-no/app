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


        //Если есть запись в таблице comment то применяем один метод вставки, иначе используем второй метод
        if (Comment::whereRaw('id = (select max(`id`) from comments)')->count() > 0) {

            //генерируем thread_id
            $lastCreate = Comment::orderBy('created_at', 'desc')->first();
            $thread_id = $lastCreate->id + 1;


            Auth::user()->hasComment()->create([
                'body' => $request->input('status'),
                'header' => $request->input('header'),
                'profile_id' => $profileId,
                'thread_id' => $thread_id
            ]);


        } else {
            Auth::user()->hasComment()->create([
                'body' => $request->input('status'),
                'header' => $request->input('header'),
                'profile_id' => $profileId
            ]);

            //ищем thread_id  обновляем его
            $afterInsert = Comment::whereRaw('id = (select max(`id`) from comments)')->first();
            $thread_id = $afterInsert->id;
            $afterInsert->thread_id = $thread_id;
            $afterInsert->update();
        }

        return redirect()->back()->with('info', 'Запись успешно добавлена');
    }


    //Вставка ответного комментария
    public function postReply(Request $request, $commentId, $profileId)
    {

        //Если комментарий с таким id существует, то делаем встаку, иначе выводим алёрт
        if (Comment::where('id', $commentId)->count() > 0) {
            $this->validate($request, [
                "reply-{$commentId}" => 'required|max:1000'
            ]);



            $comment = Comment::find($commentId);
            $threadId = Comment::find($commentId)->thread_id;

            if (!$comment) redirect()->route('home');

            $reply = new Comment();
            $reply->body = $request->input("reply-{$comment->id}");
            $reply->profile_id = $profileId;
            $reply->thread_id = $threadId;
            $reply->user()->associate(Auth::user());

            $comment->replies()->save($reply);

            return redirect()->back()->with('info', 'Запись успешно добавлена');
        } else {
            return redirect()->back()->with('info', 'Комментарий удален');
        }

    }


    //Удаление отдельного комментария
    public function deleteStatus($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        if (!$comment) redirect()->route('home');

        $comment->delete();

        return redirect()->back();
    }


    //Удаление цепочки комментарий по thread_id
    public function deleteThread($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        if (!$comment) redirect()->route('home');

        $thread = Comment::where('thread_id', $comment->thread_id) ;

        /*dd($thread);*/

        $thread->delete();


        return redirect()->back();
    }

}
