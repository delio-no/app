@extends('layouts.app')
@section('content')
    <div class="card text-center">
        <div class="card-body">
            <h5 class="card-title">Доступ по ссылке</h5>
            <p class="card-text">Любому пользователю будет доступна книга по этой ссылке в течение N времени</p>
            <input name="name" type="text"
                   class="form-control" value="{{ $url }}">
        </div>
    </div>
@endsection
