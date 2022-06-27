@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-5">
            @include('user.userblock')
            <hr>

            @if(!$statuses->count())
                <p>{{ $user->name }} еще ничего не опубликовал</p>
            @else
                @foreach($statuses as $status)

                    <div class="media">
                        <div class="media-body">
                            <h4>
                                <a href="{{ route('profile.index', ['id' => $status->user->id]) }}">{{ $status->user->name }}</a>
                            </h4>
                            <p>{{ $status->body }}</p>
                            <ul class="list-inline">
                                <li class="list-inline-item">{{ $status->created_at->diffForHumans() }}</li>
                            </ul>

                            @foreach($status->replies as $replies)
                                <div class="media mt-2">
                                    <div class="media-body">

                                        <h4>
                                            <a href="{{ route('profile.index', ['id' => $replies->user->id]) }}">{{ $replies->user->name }}</a>
                                        </h4>
                                        <p>{{ $replies->body }}</p>
                                        <ul class="list-inline">
                                            <li class="list-inline-item">{{ $replies->created_at->diffForHumans() }}</li>
                                        </ul>

                                    </div>
                                </div>
                            @endforeach

                            @if(Auth::check())
                            <form method="POST" action="{{ route('status.reply', ['statusId' => $status->id]) }}"
                                  class="mb-4">
                                @csrf
                                <div class="form-group">
                            <textarea name="reply-{{ $status->id }}" id="" cols="30" rows="2"
                                      class="form-control{{ $errors->has("reply-{$status->id}") ? ' is-invalid' : '' }}"
                                      placeholder="Коммент"></textarea>
                                    @if($errors->has("reply-{$status->id}"))
                                        <div class="invalid-feedback">
                                            {{ $errors->first("reply-{$status->id}") }}
                                        </div>
                                    @endif
                                </div>
                                <input type="submit" class="btn btn-primary btn-sm mt-2" value="Ответить">
                            </form>
                            @endif
                        </div>
                    </div>
                    <hr>
                @endforeach
            @endif
        </div>
    </div>
@endsection
