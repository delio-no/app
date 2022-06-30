<form method="POST"
      action="{{ route('comment.reply', ['statusId' => $replies->id, 'profileId' => Auth::user()->id]) }}"
      class="mb-4">
    @csrf
    <div class="form-group">
        <textarea name="reply-{{ $replies->id }}" id="" cols="30"
                  rows="2"
                  class="form-control{{ $errors->has(" reply-{$replies->id}") ? ' is-invalid' : '' }} mt-2"
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
