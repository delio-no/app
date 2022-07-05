<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Book;
use Closure;

class AuthorBook
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     *
     * принимаем id книги
     * ищем запись в таблице books с таким id и где колонка author_id = id авторизованного пользователя
     * если записи нет, редирект на главную
     * если есть пропускаем
     */
    public function handle(Request $request, Closure $next)
    {
        $bookId = $request->route('bookId');
        $authorId = Auth::user()->id;
        $result = Book::where('id', $bookId)->where('author_id', $authorId)->first();


        //если запись отсутсвует редирект на главную
        if(!$result) return redirect(route('home'));

        return $next($request);
    }
}
