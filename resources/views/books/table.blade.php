<tbody>
<tr>
    <td>
        <div class="d-flex align-items-center">
            <div class="ms-3">
                <p class="fw-bold mb-1">{{ $book->user->name }}</p>
            </div>
        </div>
    </td>
    <td>
        <p class="fw-normal mb-1">{{ $book->name }}</p>
    </td>
    <td>
        <div class="btn-group">
            <a class="btn btn-primary" role="button"
               href="{{ route('book.get', ['profileId' => $user->id, 'bookId' => $book->id]) }}">Читать</a>
            @if(Auth::user()->id == $profileId)
                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="visually-hidden">Переключатель выпадающего списка</span>
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item"
                           href="{{ route('show.book.edit', ['bookId' => $book->id]) }}">Изменить</a></li>
                    <li><a class="dropdown-item" href="{{ route('generate.book.link', ['bookId' => $book->id]) }}">Дать доступ по ссылке</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                           href="">Удалить</a></li>
                </ul>
            @endif
        </div>
    </td>
</tr>


@if(Auth::user()->id == $profileId)
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Удаление</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Вы подтверждаете что хотите удалить эту книгу?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Нет</button>
                    <form method="GET" action="{{ route('book.delete', ['bookId' => $book->id]) }}">
                        @csrf
                        <input type="submit" class="btn btn-danger btn-xs" value="Подтверждаю">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endif
</tbody>
