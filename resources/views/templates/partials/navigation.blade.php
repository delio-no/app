<nav class="navbar navbar-expand-xxl bg-light mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">Social</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">


            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @if (Auth::check())
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('user.list.comments') }}">Мои комментарии</a>
                </li><li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('book.list', ['profileId' => Auth::user()->id]) }}">Мои книги</a>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('user.list') }}">Пользователи</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                @if (Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.index', ['id' => Auth::user()->id]) }}">{{ Auth::user()->name }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/logout') }}">Выйти</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Зарегестрироваться</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Войти</a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</nav>
