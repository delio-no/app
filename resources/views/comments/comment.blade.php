<div class="row">
    <div class="col-lg-12">

        @if(! $comment->header == null )
            <div class="card">
                <h5 class="card-header">
                    <div class="card-header">
                        <a href="{{ route('profile.index', ['id' => $comment->user->id]) }}">{{ $comment->user->name }}</a>
                    </div>
                </h5>
                <div class="card-body">
                    <h5 class="card-title">{{ $comment->header}}</h5>
                    <p class="card-text">{{ $comment->body }}</p>

                    @if(Auth::check())
                        @if(Auth::user()->id == $comment->user_id || Auth::user()->id == $comment->profile_id)
                            <form method="GET" action="{{ route('thread.delete', ['commentId' => $comment->id]) }}">
                                @csrf
                                <input type="submit" class="btn btn-danger btn-xs" value="Удалить">
                            </form>
                        @endif
                    @endif

                    @if(Auth::check())

                        <p>
                            <button class="btn btn-primary mt-2" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseExample{{ $comment->id }}" aria-expanded="false"
                                    aria-controls="collapseExample">
                                Ответить
                            </button>
                        </p>
                        <div class="collapse" id="collapseExample{{ $comment->id }}">
                            <div class="card card-body">
                                <form method="POST"
                                      action="{{ route('comment.reply', ['commentId' => $comment->id, 'profileId' => $user->id]) }}"
                                      class="mb-4">
                                    @csrf
                                    <div class="form-group">
                                        <textarea name="reply-{{ $comment->id }}" id="" cols="30"
                                                  rows="2"
                                                  class="form-control{{ $errors->has(" reply-{$comment->id}") ? ' is-invalid' : '' }} mt-2"
                                                  placeholder="Коммент"></textarea>

                                        @if($errors->has("reply-{$comment->id}"))
                                            <div class="invalid-feedback">
                                                {{ $errors->first("reply-{$comment->id}") }}
                                            </div>
                                        @endif

                                    </div>
                                    <input type="submit" class="btn btn-primary btn-sm mt-2"
                                           value="Ответить">
                                </form>
                            </div>
                        </div>

                    @endif

                </div>
            </div>
        @endif


        @if($comment->header == null)

            <div class="card">
                <h5 class="card-header">
                    <div class="card-header">
                        <a href="{{ route('profile.index', ['id' => $comment->user->id]) }}">{{ $comment->user->name }}</a>
                    </div>
                </h5>
                <div class="card-body">
                    <div class="card">
                        <div class="card-header">
                            Quote {{ $comment->reverseReplies->user->name }}
                        </div>
                        <div class="card-body">
                            <blockquote class="blockquote mb-0">
                                <p>{{--{{ $comment->where('id', $comment->reverseReplies->parent_id)->first()->body }}--}}</p>
                                <p>{{ $comment->reverseReplies->body }}</p>
                            </blockquote>
                        </div>
                    </div>

                    <p class="card-text mt-2">{{ $comment->body }}</p>

                    @if(Auth::check())
                        @if(Auth::user()->id == $comment->user_id || Auth::user()->id == $comment->profile_id)

                            <form method="GET"
                                  action="{{ route('comment.delete', ['commentId' => $comment->id]) }}">
                                @csrf
                                <input type="submit" class="btn btn-danger btn-xs"
                                       value="Удалить">
                            </form>
                        @endif


                        <p>
                            <button class="btn btn-primary mt-2" type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapseExample{{ $comment->id }}"
                                    aria-expanded="false"
                                    aria-controls="collapseExample">
                                Ответить
                            </button>
                        </p>
                        <div class="collapse" id="collapseExample{{ $comment->id }}">
                            <div class="card card-body">
                                <form method="POST"
                                      action="{{ route('comment.reply', ['commentId' => $comment->id, 'profileId' => $user->id]) }}"
                                      class="mb-4">
                                    @csrf
                                    <div class="form-group">
                                        <textarea name="reply-{{ $comment->id }}" id="" cols="30"
                                                  rows="2"
                                                  class="form-control{{ $errors->has(" reply-{$comment->id}") ? ' is-invalid' : '' }} mt-2"
                                                  placeholder="Коммент"></textarea>

                                        @if($errors->has("reply-{$comment->id}"))
                                            <div class="invalid-feedback">
                                                {{ $errors->first("reply-{$comment->id}") }}
                                            </div>
                                        @endif

                                    </div>
                                    <input type="submit" class="btn btn-primary btn-sm mt-2"
                                           value="Ответить">
                                </form>
                            </div>
                        </div>

                    @endif
                </div>
            </div>
        @endif

    </div>
</div>


<!--                                                                                           -->


{{-- <div class="row">
    <div class="col-lg-12">

        <h1>
            debug: {{ $comment->belongReplies->id }}
        </h1>

        <!--    показываем все сообщения где header != null    -->

        <div class="card">
            <h5 class="card-header">
                <div class="card-header">
                    <a href="{{ route('profile.index', ['id' => $comment->user->id]) }}">{{ $comment->user->name }}</a>
                </div>
            </h5>
            <div class="card-body">
                <h5 class="card-title">{{ $comment->header}}</h5>
                <p class="card-text">{{ $comment->body }}</p>

                @if(Auth::check())
                    @if(Auth::user()->id == $comment->user_id || Auth::user()->id == $comment->profile_id)
                        <form method="GET" action="{{ route('thread.delete', ['commentId' => $comment->id]) }}">
                            @csrf
                            <input type="submit" class="btn btn-danger btn-xs" value="Удалить">
                        </form>
                    @endif
                @endif

                <p>
                    @if(Auth::check())

                        <button class="btn btn-primary mt-2" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseExample{{ $comment->id }}" aria-expanded="false"
                                aria-controls="collapseExample">
                            Ответить
                        </button>

                    @endif

                    @if($allComment->where('thread_id', $comment->thread_id)->count() > 1)

                        <button class="btn btn-primary mt-2" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseExample1{{ $comment->id }}" aria-expanded="false"
                                aria-controls="collapseExample1">
                            Обсудить
                        </button>

                    @endif
                </p>
                @if(Auth::check())

                    <div class="collapse" id="collapseExample{{ $comment->id }}">
                        <div class="card card-body">
                            <form method="POST"
                                  action="{{ route('comment.reply', ['commentId' => $comment->id, 'profileId' => $user->id]) }}"
                                  class="mb-4">
                                @csrf
                                <div class="form-group">
                                        <textarea name="reply-{{ $comment->id }}" id="" cols="30"
                                                  rows="2"
                                                  class="form-control{{ $errors->has(" reply-{$comment->id}") ? ' is-invalid' : '' }} mt-2"
                                                  placeholder="Коммент"></textarea>

                                    @if($errors->has("reply-{$comment->id}"))
                                        <div class="invalid-feedback">
                                            {{ $errors->first("reply-{$comment->id}") }}
                                        </div>
                                    @endif

                                </div>
                                <input type="submit" class="btn btn-primary btn-sm mt-2"
                                       value="Ответить">
                            </form>
                        </div>
                    </div>

                @endif


                <div class="collapse" id="collapseExample1{{ $comment->id }}">
                    <div class="card card-body">


                        <!--Создаем коллекцию сообщенией по thread_id и перебираем все сообщения по привязке parent_id-->
                        @foreach($comment->where('thread_id', $comment->thread_id)->get() as $commentThread)
                            @foreach($commentThread->replies as $replies)
                                <div class="card">
                                    <h5 class="card-header">
                                        <div class="card-header">
                                            <a href="{{ route('profile.index', ['id' => $replies->user->id]) }}">{{ $replies->user->name }}</a>
                                        </div>
                                    </h5>
                                    <div class="card-body">
                                        <div class="card">
                                            <div class="card-header">
                                                Quote {{ $replies->user->name }}
                                            </div>
                                            <div class="card-body">
                                                <blockquote class="blockquote mb-0">
                                                    <p>{{ $comment->where('id', $replies->parent_id)->first()->body }}</p>
                                                </blockquote>
                                            </div>
                                        </div>

                                        <p class="card-text mt-2">{{ $replies->body }}</p>

                                        @if(Auth::check())
                                            @if(Auth::user()->id == $replies->user_id || Auth::user()->id == $replies->profile_id)

                                                <form method="GET"
                                                      action="{{ route('comment.delete', ['commentId' => $replies->id]) }}">
                                                    @csrf
                                                    <input type="submit" class="btn btn-danger btn-xs"
                                                           value="Удалить">
                                                </form>
                                            @endif


                                            <p>
                                                <button class="btn btn-primary mt-2" type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseExample{{ $replies->id }}"
                                                        aria-expanded="false"
                                                        aria-controls="collapseExample">
                                                    Ответить
                                                </button>
                                            </p>
                                            <div class="collapse" id="collapseExample{{ $replies->id }}">
                                                <div class="card card-body">
                                                    <form method="POST"
                                                          action="{{ route('comment.reply', ['commentId' => $replies->id, 'profileId' => $user->id]) }}"
                                                          class="mb-4">
                                                        @csrf
                                                        <div class="form-group">
                                        <textarea name="reply-{{ $replies->id }}" id="" cols="30"
                                                  rows="2"
                                                  class="form-control{{ $errors->has(" reply-{$replies->id}") ? ' is-invalid' : '' }} mt-2"
                                                  placeholder="Коммент"></textarea>

                                                            @if($errors->has("reply-{$replies->id}"))
                                                                <div class="invalid-feedback">
                                                                    {{ $errors->first("reply-{$replies->id}") }}
                                                                </div>
                                                            @endif

                                                        </div>
                                                        <input type="submit" class="btn btn-primary btn-sm mt-2"
                                                               value="Ответить">
                                                    </form>
                                                </div>
                                            </div>

                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endforeach

                    </div>
                </div>

            </div>
        </div>
    </div>
</div> --}}


