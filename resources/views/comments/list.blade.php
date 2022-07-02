@foreach($comments as $comment)
    <div hidden>
        {{ $startcomment++ }}
    </div>
    {{--@if($startcomment <= 5)--}}
        @include('comments.comment')
    {{--@endif--}}
@endforeach
