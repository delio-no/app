<div class="d-flex">
    <!--    <div class="flex-shrink-0">
            <img src="..." alt="...">
        </div>-->
    <div class="flex-grow-1 ms-3">
        <h4 class="mt-2">
            <li><a href="{{ route('profile', [`name` => $user->name]) }}">{{$user->name}}</a></li>
        </h4>
    </div>
</div>
