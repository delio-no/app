<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Route::get('/userlist', [\App\Http\Controllers\UserListController::class, 'showUsers'])->name('userlist');


//Профиль пользователя
Route::get('/profile/{id}', [\App\Http\Controllers\ProfileController::class, 'getProfile'])->name('profile.index');


//Стена пользователя
Route::post('/profile/{profileId}/comment/', [\App\Http\Controllers\CommentController::class, 'postComment'])->middleware('auth')->name('comment.post');
Route::post('/comment/{commentId}/profile/{profileId}/reply', [\App\Http\Controllers\CommentController::class, 'postReply'])->middleware('auth')->name('comment.reply');
Route::get('/comment/{commentId}/delete', [\App\Http\Controllers\CommentController::class, 'deleteStatus'])->middleware('auth')->name('comment.delete');
Route::get('/thread/{commentId}/delete', [\App\Http\Controllers\CommentController::class, 'deleteThread'])->middleware('auth')->name('thread.delete');
Route::get('/get/more/comments/{take}', [App\Http\Controllers\GetMoreCommentsController::class, 'getComments'])->name('get.more.comments');


//Все комментарии пользователя
Route::get('/userlistcomments', [\App\Http\Controllers\UserListCommentsController::class, 'showComments'])->middleware('auth')->name('userlistcomments');
