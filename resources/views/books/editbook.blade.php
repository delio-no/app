@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form method="POST" action="{{ route('book.edit', ['bookId' => $book->id]) }}">
                @csrf
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Название</label>
                    <input name="name" type="text"
                           class="form-control{{ $errors->has('name') ? ' is-invalid' : ''}}" value="{{ $book->name }}">
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('named') }}
                        </div>
                    @endif
                </div>
                <div class="form-floating">
                <textarea name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : ''}}"
                          placeholder="Leave a comment here" id="floatingTextarea2"
                          style="height: 800px">{{ $book->description }}</textarea>
                    <label for="floatingTextarea2">Текст книги</label>
                    @if($errors->has('description'))
                        <div class="invalid-feedback">
                            {{ $errors->first('description') }}
                        </div>
                    @endif
                </div>
                <button type="submit" class="btn mt-2 btn-primary col-12">Подтвердить изменения в книге</button>
            </form>
        </div>
    </div>
@endsection


