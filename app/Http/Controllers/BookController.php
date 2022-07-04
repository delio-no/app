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

        if (Auth::user()->id == $profileId || $findRole) {
            $book = Book::find($bookId);
            return view('books.book', compact('book'));
        }

        return redirect(route('home'));
    }

    public function getListBookAuthor($profileId)
    {
        $findRole = Role::where('author_id', $profileId)->where('user_id', Auth::user()->id)->first();

        if (Auth::user()->id == $profileId || $findRole) {
            $user = User::findOrFail($profileId);

            $books = $user->hasBook()->get();

            return view('books.list', ['profileId' => $profileId, 'books' => $books, 'user' => $user]);
        }

        return redirect(route('home'));
    }

    public function getAddBook()
    {
        return view('books.addbook');
    }

    public function getEditBook($bookId)
    {
        $book = Book::findOrFail($bookId);

        if (Auth::user()->id == $book->author_id) {
            return view('books.editbook', compact('book'));
        }

        return redirect(route('home'));
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

    public function deleteBook($bookId)
    {

        $book = Book::findOrFail($bookId);

        if (!$book) return redirect()->back()->with('info', 'Книга не найдена');

        if (Auth::user()->id == $book->author_id) {
            $book->delete();

            return redirect()->back()->with('info', 'Книга успешно удалена');
        }

        return redirect(route('home'));
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

    public function sharedBook(Request $request, $bookId)
    {
            $book = Book::find($bookId);
            return view('books.book', compact('book'));
    }

    public function genereateBookLink($bookId)
    {
        $book = Book::findOrFail($bookId);

        if (Auth::user()->id == $book->author_id) {
            $url = URL::temporarySignedRoute('book.share', now()->addSeconds(30), ['bookId' => $bookId]);
            return view('books.generatelink', compact('url'));
        }

        return redirect(route('home'));
    }
}
