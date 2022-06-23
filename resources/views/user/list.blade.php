@extends('layouts.app')

@section('content')
    <h3>Список всех пользователей</h3>
    @if (!$users->count())
        <p>Пользователей нет</p>
    @endif

    <div class="row">
        <div class="col-lg-6">
            @foreach($users as $user)
            @include('user.userblock')
            @endforeach
        </div>
    </div>

@endsection
