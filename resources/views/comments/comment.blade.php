<div class="row">
    <div class="col-lg-6">
        @if( ! $comment->header == null)
            <div class="card">
                <h5 class="card-header">
                    <div class="card-header">
                        <a href="{{ route('profile.index', ['id' => $comment->user->id]) }}">{{ $comment->user->name }}</a>
                    </div>
                </h5>
                <div class="card-body">
                    <h5 class="card-title">{{ $comment->header}}</h5>
                    <p class="card-text">{{ $comment->body }}</p>

                    @if(Auth::check() && Auth::user()->id == $comment->user_id)
                        <form method="GET" action="{{ route('comment.delete', ['commentId' => $comment->id]) }}">
                            @csrf
                            <input type="submit" class="btn btn-danger btn-xs" value="Удалить">
                        </form>
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
                                      action="{{ route('comment.reply', ['commentId' => $comment->id, 'profileId' => Auth::user()->id]) }}"
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

        @foreach($comment->replies as $replies)
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
                                <p>{{ $comment->where('id', $comment->id)->first()->body }}</p>
                            </blockquote>
                        </div>
                    </div>

                    <p class="card-text mt-2">{{ $replies->body }}</p>

                    @if(Auth::check() && Auth::user()->id == $comment->user_id)
                        <form method="GET"
                              action="{{ route('comment.delete', ['commentId' => $replies->id]) }}">
                            @csrf
                            <input type="submit" class="btn btn-danger btn-xs" value="Удалить">
                        </form>
                        <p>
                            <button class="btn btn-primary mt-2" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseExample{{ $replies->id }}" aria-expanded="false"
                                    aria-controls="collapseExample">
                                Ответить
                            </button>
                        </p>
                        <div class="collapse" id="collapseExample{{ $replies->id }}">
                            <div class="card card-body">
                                <form method="POST"
                                      action="{{ route('comment.reply', ['commentId' => $replies->id, 'profileId' => Auth::user()->id]) }}"
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

    </div>
</div>
