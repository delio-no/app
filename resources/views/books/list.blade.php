@extends('layouts.app')
@section('content')
    <div class="col-lg-12">
        <table class="table align-middle mb-0 bg-white">
            <thead class="bg-light">
            <tr>
                <th>Автор книги</th>
                <th>Название книги</th>
                <th>Действие</th>
            </tr>
            </thead>
            @foreach($books as $book)
                @include('books.table')
            @endforeach

        </table>
        <a class="btn btn-success mt-2 col-12" href="{{ route('show.book.add') }}" role="button">
            Добавить книгу
        </a>
    </div>
@endsection

