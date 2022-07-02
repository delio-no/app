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



