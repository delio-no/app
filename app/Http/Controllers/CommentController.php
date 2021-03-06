<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use Auth;


class CommentController extends Controller
{

    public function postComment(Request $request, $profileId)
    {
        $this->validate($request, [
            'status' => 'required|max:1000',
            'header' => 'required|max:30'
        ]);


        //Если есть запись в таблице comment то применяем один алгоритм вставки, иначе используем второй алгоритм
        if (Comment::get()->has('id')) {

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
        $comment = Comment::find($commentId);

        //Если комментарий с таким id не существует, то выводим алёрт
        if (!$comment) return redirect()->back()->with('info', 'Комментарий удален');

        $this->validate($request, [
            "reply-{$commentId}" => 'required|max:1000'
        ]);


        //валидация
        if (!$comment) redirect()->route('home');

        $threadId = Comment::find($commentId)->thread_id;

        $reply = new Comment();
        $reply->body = $request->input("reply-{$comment->id}");
        $reply->profile_id = $profileId;
        $reply->thread_id = $threadId;
        $reply->user()->associate(Auth::user());

        $comment->replies()->save($reply);

        return redirect()->back()->with('info', 'Запись успешно добавлена');
    }


    //Удаление отдельного комментария
    public function deleteStatus($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        if (!$comment) return redirect()->back()->with('info', 'Комментария не существует');


        //проверка на кто удаляет комментарий
        if (!($comment->user_id == Auth::user()->id || $comment->profile_id == Auth::user()->id)) redirect(route('home'));

        $comment->delete();

        return redirect()->back();
    }


    //Удаление цепочки комментарий по thread_id
    public function deleteThread($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        if (!$comment) return redirect()->back()->with('info', 'Комментария не существует');


        //проверка на кто удаляет комментарий
        if (!($comment->user_id == Auth::user()->id || $comment->profile_id == Auth::user()->id)) redirect(route('home'));

        $thread = Comment::where('thread_id', $comment->thread_id);

        $thread->delete();

        return redirect()->back();
    }

    public function loadMoreComments(Request $request, $take)
    {
        if (!$request->ajax()) redirect(route('home'));

        $user = User::where('id', Auth::user()->id)->first();

        //создаем коллекцию комментариев с привязкой по profile_id

        $count = $user->commentHasProfile()->count();
        $skip = 5;
        $comments = $user->commentHasProfile()->skip($skip)->take($take)->get();

        $allComment = Comment::all();

        return view('comments.list', ['comments' => $comments, 'allComment' => $allComment, 'user' => $user])->render();
    }

}
