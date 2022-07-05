<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Role;
use Closure;

class Reader
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     *
     * принимаем profileId из $request
     * ищем запись в таблице roles с таким profileId и где колонка $userId = id авторизованного пользователя
     * если записи нет, редирект на главную
     * если запись есть или profileId = id авторизованного пользователя, то пропускаем
     */
    public function handle(Request $request, Closure $next)
    {

        $profileId = $request->route('profileId');
        $userId = Auth::user()->id;
        $result = Role::where('author_id', $profileId)->where('user_id', $userId)->first();


        //если запись отсутсвует редирект на главную
        if (!($profileId == $userId || $result)) return redirect(route('home'));

        return $next($request);
    }
}
