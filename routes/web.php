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
Route::post('/status', [\App\Http\Controllers\StatusController::class, 'postStatus'])->middleware('auth')->name('status.post');
Route::post('/status/{statusId}/replay', [\App\Http\Controllers\StatusController::class, 'postReply'])->middleware('auth')->name('status.reply');
