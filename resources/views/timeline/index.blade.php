@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form method="POST" action="{{ route('comment.post', ['profileId' => Auth::user()->id]) }}">
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
        </div>
    </div>
    <hr>

    <div hidden>
        {{ $startcomment = 0 }}
    </div>

    @include('comments.list')

    <div id="resources">

    </div>










    {{--{!! $comments->links() !!}--}}
    @if($showButton && !$hideButton)
    <div>
        @csrf
        <input id="more_btn" type="submit" class="btn btn-success btn-sm mt-2 mb-2 col-12 " value="Загрузить комменатрии">
    </div>
    @endif








@endsection

@push('scripts')

    <script>
        $(function () {
            var take = 5;
            $('#more_btn').click(function (e) {
                e.preventDefault();
                $.ajax({
                    url: "/get/more/comments/" + take,
                    type: "GET",
                    success: function (data) {
                            $("#resources").html(data)
                                take += 5;
                    }
                });
            });
        })


        /*$(document).ready(function () {
            $(document).on('click', '.pagination a', function (event) {
                event.preventDefault();
                let page = $(this).attr('href').split('page=')[1]
                getMoreComments(page);
            });
        });

        function getMoreComments(page) {
            $.ajax({
                url:"/get/more/comments?page="+page,
                success:function (res) {
                    $('#resources_container').html(res);
                }
            })
        }*/


    </script>

@endpush

{{--@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-6">
            <form method="POST" action="{{ route('status.post', ['profileId' => Auth::user()->id]) }}">
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
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <hr>

            @if(!$statuses->count())
                <p>Нет записей на стене</p>
            @else
                @foreach($statuses as $status)
                    <div class="media">
                        <div class="media-body">
                            <h3>
                                <a href="{{ route('profile.index', ['id' => $status->user->id]) }}">{{ $status->user->name }}</a>
                            </h3>
                            <h4>
                                Заголовок: {{ $status->header}}
                            </h4>

                            <p>{{ $status->body }}</p>
                            <ul class="list-inline">
                                <li class="list-inline-item">{{ $status->created_at->diffForHumans() }}</li>
                            </ul>
                            <form method="GET" action="{{ route('status.delete', ['statusId' => $status->id]) }}">
                                @csrf
                                <input type="submit" class="btn btn-danger btn-xs" value="Удалить">
                            </form>

                            <p>
                                <button class="btn btn-primary mt-2" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseExample{{ $status->id }}" aria-expanded="false"
                                        aria-controls="collapseExample">
                                    Ответить
                                </button>
                            </p>
                            <div class="collapse" id="collapseExample{{ $status->id }}">
                                <div class="card card-body">
                                    <form method="POST"
                                          action="{{ route('status.reply', ['statusId' => $status->id, 'profileId' => Auth::user()->id]) }}"
                                          class="mb-4">
                                        @csrf
                                        <div class="form-group">
                                            <textarea name="reply-{{ $status->id }}" id="" cols="30"
                                                      rows="2"
                                                      class="form-control{{ $errors->has("reply-{$status->id}") ? ' is-invalid' : '' }} mt-2"
                                                      placeholder="Коммент"></textarea>

                                            @if($errors->has("reply-{$status->id}"))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first("reply-{$status->id}") }}
                                                </div>
                                            @endif

                                        </div>
                                        <input type="submit" class="btn btn-primary btn-sm mt-2"
                                               value="Ответить">
                                    </form>
                                </div>
                            </div>

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

                                        <form method="GET"
                                              action="{{ route('status.delete', ['statusId' => $replies->id]) }}">
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
                                                      action="{{ route('status.reply', ['statusId' => $replies->id, 'profileId' => Auth::user()->id]) }}"
                                                      class="mb-4">
                                                    @csrf
                                                    <div class="form-group">
                                                        <textarea name="reply-{{ $replies->id }}" id="" cols="30"
                                                                  rows="2"
                                                                  class="form-control{{ $errors->has("reply-{$replies->id}") ? ' is-invalid' : '' }} mt-2"
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

                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <hr>
                @endforeach
            @endif
        </div>
    </div>
@endsection--}}


