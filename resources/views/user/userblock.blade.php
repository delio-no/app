<div class="d-flex">
    <div class="flex-grow-1 ms-3">

        <h4 class="mt-2">
            <a href="{{ route('profile.index', ['id' => $user->id]) }}">{{$user->name}}</a>
        </h4>
        @if(Auth::check())
            @if( !(Auth::user()->id == $user->id) )
                @if( !($roles->where('author_id', Auth::user()->id)->where('user_id', $user->id)->first()) )
                    <form method="GET"
                          action="{{ route('role.add', ['userId' => $user->id, 'authorId' => Auth::user()->id]) }}">
                        @csrf
                        <input type="submit" class="btn btn-success btn-xs" value="Дать доступ к библиотеке">
                    </form>
                @else
                    <form method="GET" action="{{ route('role.delete', ['userId' => $user->id]) }}">
                        @csrf
                        <input type="submit" class="btn btn-danger btn-xs" value="Забрать доступ к библиотеке">
                    </form>
                @endif
            @endif
            @if($roles->where('author_id', $user->id)->where('user_id', Auth::user()->id)->first())
                <a class="btn btn-primary mt-2" href="{{ route('book.list', ['profileId' => $user->id]) }}"
                   role="button">
                    Перейти к библиотеке автора
                </a>
            @endif
        @endif

    </div>
</div>

