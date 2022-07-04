@extends('layouts.app')
@section('content')
            <p class="text-center fs-1">{{ $book->name }}</p>
            <p class="text-center fs-5">{{ $book->description }}</p>
@endsection
