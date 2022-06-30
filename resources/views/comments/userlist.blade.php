@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-6">
            @foreach($comments as $comment)
                @if( ! $comment->header == null)
                    <div class="card">
                        <h5 class="card-header">
                            <div class="card-header">
                                <a href="{{ route('profile.index', ['id' => Auth::user()->id]) }}">{{ Auth::user()->name }}</a>
                            </div>
                        </h5>
                        <div class="card-body">
                            <h5 class="card-title">{{ $comment->header}}</h5>
                            <p class="card-text">{{ $comment->body }}</p>
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
                        </div>
                    </div>
                @endforeach

            @endforeach

        </div>
    </div>
@endsection
