@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-6">
            @include('user.userblock')
            <hr>
            @if(Auth::check())
                {{--<div class="row">
                    <div class="col-lg-6">
                        <form method="POST" action="{{ route('status.post', ['profileId' => $user->id]) }}">
                            @csrf
                            <div class="form-floating">
                                <textarea name="status"
                                          class="form-control{{ $errors->has('status') ? ' is-invalid' : ''}}"
                                          placeholder="Leave a comment here" id="floatingTextarea2"
                                          style="height: 100px"></textarea>
                                <label for="floatingTextarea2">Comments</label>
                                @if($errors->has('status'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('status') }}
                                    </div>
                                @endif
                            </div>
                            <button type="submit" class="btn mt-2 btn-primary">Написать</button>
                        </form>
                    </div>
                </div>--}}

                <form method="POST" action="{{ route('comment.post', ['profileId' => $user->id]) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Заголовок</label>
                        <input name="header" type="text"
                               class="form-control{{ $errors->has('header') ? ' is-invalid' : ''}}">
                        @if($errors->has('header'))
                            <div class="invalid-feedback">
                                {{ $errors->first('header') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-floating">
                <textarea name="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : ''}}"
                          placeholder="Leave a comment here" id="floatingTextarea2"
                          style="height: 100px"></textarea>
                        <label for="floatingTextarea2">Комментарий</label>
                        @if($errors->has('status'))
                            <div class="invalid-feedback">
                                {{ $errors->first('status') }}
                            </div>
                        @endif
                    </div>
                    <button type="submit" class="btn mt-2 btn-primary">Написать</button>
                </form>

            @endif
            <hr>



            {{--@if(!$statuses->count())
                <p>{{ $user->name }} еще ничего не опубликовал</p>
            @else
            @foreach($statuses as $status)
                    <div class="media">
                        <div class="media-body">
                            <h4>
                                <a href="{{ route('profile.index', ['id' => $status->user->id]) }}">{{ $status->user->name }}</a>
                            </h4>
                            <p>{{ $message->body }}</p>

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


                                        @if(Auth::check() && Auth::user()->id == $replies->user_id)
                                            <form method="GET"
                                                  action="{{ route('status.delete', ['statusId' => $replies->id]) }}">
                                                <input type="submit" class="btn btn-danger btn-xs" value="Удалить">
                                            </form>
                                        @endif


                                    </div>
                                </div>
                            @endforeach




                            @if(Auth::check())
                                <form method="POST"
                                      action="{{ route('status.reply', ['statusId' => $status->id, 'profileId' => $user->id]) }}"
                                      class="mb-4">
                                    @csrf
                                    <div class="form-group">
                                        <textarea name="reply-{{ $status->id }}" id="" cols="30" rows="2"
                                                  class="form-control{{ $errors->has("reply-{$status->id}") ? ' is-invalid' : '' }} mt-2"
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
                @endif--}}
        </div>
    </div>
    @include('comments.list')
@endsection
