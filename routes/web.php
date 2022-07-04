<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//Авторизация
Auth::routes();


//Домашняя страница
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Выход из аккаунта
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');


//Страница со списком всех пользоватлей
Route::get('/user/list', [\App\Http\Controllers\ProfileController::class, 'getUsers'])->name('user.list');

//Все комментарии пользователя
Route::get('/user/list/comments', [\App\Http\Controllers\ProfileController::class, 'getComments'])->middleware('auth')->name('user.list.comments');


//Профиль пользователя
Route::get('/profile/{id}', [\App\Http\Controllers\ProfileController::class, 'getProfile'])->name('profile.index');


/*Стена пользователя*/
//Запостить коммент
Route::post('/profile/{profileId}/comment', [\App\Http\Controllers\CommentController::class, 'postComment'])->middleware('auth')->name('comment.post');

//Запостить ответный коммент
Route::post('/comment/{commentId}/profile/{profileId}/reply', [\App\Http\Controllers\CommentController::class, 'postReply'])->middleware('auth')->name('comment.reply');

//Удалить коммент
Route::get('/comment/{commentId}/delete', [\App\Http\Controllers\CommentController::class, 'deleteStatus'])->middleware('auth')->name('comment.delete');

//Удалить комменты по thread_id
Route::get('/comment/thread/{commentId}/delete/thread', [\App\Http\Controllers\CommentController::class, 'deleteThread'])->middleware('auth')->name('thread.delete');

//ajax подгрузка комментов
Route::get('/get/more/comments/{take}', [App\Http\Controllers\CommentController::class, 'loadMoreComments'])->name('load.more.comments');


/*Библиотека*/
//читать книгу
Route::get('/profile/{profileId}/list/book/{bookId}', [\App\Http\Controllers\BookController::class, 'getBook'])->middleware('auth')->name('book.show');

//список книг автора
Route::get('/profile/{profileId}/list/book', [\App\Http\Controllers\BookController::class, 'getListBookAuthor'])->middleware('auth')->name('book.list');

//страница добавления книги
Route::get('/book', [\App\Http\Controllers\BookController::class, 'getAddBook'])->middleware('auth')->name('show.book.add');

//страница изменения книги
Route::get('/book/{bookId}/edit', [\App\Http\Controllers\BookController::class, 'getEditBook'])->middleware('auth')->name('show.book.edit');

//Добавить книгу в библиотеку
Route::post('/book/add', [\App\Http\Controllers\BookController::class, 'addBook'])->middleware('auth')->name('book.add');

//Изменить книгу
Route::post('/book/{bookId}/edit', [\App\Http\Controllers\BookController::class, 'editBook'])->middleware('auth')->name('book.edit');

//Удалить книгу из библиотеки
Route::get('/book/{bookId}/delete', [\App\Http\Controllers\BookController::class, 'deleteBook'])->middleware('auth')->name('book.delete');


/*Доступ к библиотеке пользователя*/
//Дать доступ
Route::get('/profile/{userId}/author/{authorId}/role/add', [\App\Http\Controllers\RoleController::class, 'addRole'])->middleware('auth')->name('role.add');

//Забрать доступ
Route::get('/profile/{userId}/role/delete', [\App\Http\Controllers\RoleController::class, 'deleteRole'])->middleware('auth')->name('role.delete');


/*Доступ по ссылке*/
//Принимаем расшареную ссылку
Route::get('/shared/book/{bookId}', [\App\Http\Controllers\BookController::class, 'sharedBook'])->middleware('signed')->name('book.share');

//генерируем ссылку
Route::get('/shared/book/{bookId}/link', [\App\Http\Controllers\BookController::class, 'genereateBookLink'])->middleware('auth')->name('generate.book.link');

