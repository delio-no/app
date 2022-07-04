<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\Role;
use Illuminate\Support\Facades\URL;

class BookController extends Controller
{
    public function getBook($profileId, $bookId)
    {
        $book = Book::find($bookId);
        $findRole = Role::where('author_id', $book->author_id)->where('user_id', Auth::user()->id)->first();


        //валидация
        if (!(Auth::user()->id == $profileId || $findRole)) redirect(route('home'));

        $book = Book::find($bookId);

        return view('books.book', compact('book'));
    }

    public function getListBookAuthor($profileId)
    {
        $user = Role::where('author_id', $profileId)->where('user_id', Auth::user()->id)->first();


        //валидация
        if (!(Auth::user()->id == $profileId || $user)) redirect(route('home'));

        $user = User::findOrFail($profileId);
        $books = $user->hasBook()->get();

        return view('books.list', ['profileId' => $profileId, 'books' => $books, 'user' => $user]);


    }

    public function getAddBook()
    {
        return view('books.addbook');
    }

    public function addBook(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required'
        ]);

        Auth::user()->hasBook()->create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return redirect(route('home'))->with('info', 'Книга успешно добавлена');
    }

    public function getEditBook($bookId)
    {
        $book = Book::findOrFail($bookId);


        //валидация
        if (!(Auth::user()->id == $book->author_id)) redirect(route('home'));

        return view('books.editbook', compact('book'));
    }

    public function editBook(Request $request, $bookId)
    {

        $this->validate($request, [
            'name' => 'required',
            'description' => 'required'
        ]);

        $book = Book::findOrFail($bookId);

        if (!$book) return redirect()->back()->with('info', 'Книга не найдена');

        $book->update([
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ]);

        return redirect(route('home'))->with('info', 'Книга успешно изменена');
    }

    public function deleteBook($bookId)
    {

        $book = Book::findOrFail($bookId);

        if (!$book) return redirect()->back()->with('info', 'Книга не найдена');


        //валидация
        if (!(Auth::user()->id == $book->author_id)) redirect(route('home'));

        $book->delete();

        return redirect()->back()->with('info', 'Книга успешно удалена');

    }

    public function sharedBook(Request $request, $bookId)
    {
        $book = Book::find($bookId);
        return view('books.book', compact('book'));
    }

    public function genereateBookLink($bookId)
    {
        $book = Book::findOrFail($bookId);


        //валидация
        if (!(Auth::user()->id == $book->author_id)) redirect(route('home'));

        $url = URL::temporarySignedRoute('book.share', now()->addSeconds(30), ['bookId' => $bookId]);

        return view('books.generatelink', compact('url'));

    }
}
