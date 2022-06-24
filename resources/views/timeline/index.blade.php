@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-6">
        <form method="POST" action="{{ route('status.post') }}">
            @csrf
            <div class="form-floating">
                <textarea name="status" class="form-control{{ $errors->has('status') ? ' is-invalid' : ''}}" placeholder="Leave a comment here" id="floatingTextarea2"
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
@endsection


