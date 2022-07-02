@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            @include('user.userblock')
            <hr>
            @if(Auth::check())

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
        </div>
    </div>

    <div hidden>
        {{ $startcomment = 0 }}
    </div>

    @include('comments.list')

    <div id="resources"></div>

    @if($showButton)
        <div>
            @csrf
            <input id="more_btn" type="submit" class="btn btn-success btn-sm mt-2 mb-2 col-12 "
                   value="Загрузить комменатрии">
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
                        $("#resources").html(data);
                        take += 5;
                    }
                });
            });
        })

    </script>
@endpush
