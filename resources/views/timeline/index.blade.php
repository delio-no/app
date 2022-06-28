@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form method="POST" action="{{ route('status.post') }}">
                @csrf
                <div class="form-floating">
                <textarea name="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : ''}}"
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
    </div>

    <div class="row">
        <div class="col-lg-6">
            <hr>
            {{--@dd($statuses)--}}
            @if(!$statuses->count())
                <p>Нет записей на стене</p>
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
                            <form method="GET" action="{{ route('status.delete', ['statusId' => $status->id]) }}">
                                @csrf
                                <input type="submit" class="btn btn-danger btn-xs" value="Удалить">
                            </form>

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

                                        <form method="GET" action="{{ route('status.delete', ['statusId' => $replies->id]) }}">
                                            @csrf
                                            <input type="submit" class="btn btn-danger btn-xs" value="Удалить">
                                        </form>

                                    </div>
                                </div>
                            @endforeach

                            <form method="POST" action="{{ route('status.reply', ['statusId' => $status->id]) }}"
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

                        </div>
                    </div>
                    <hr>
                @endforeach
            @endif
        </div>
    </div>
@endsection


