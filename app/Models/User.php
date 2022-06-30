<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    #Пользователю принадлжедит коммент
    public function hasComment()
    {
        return $this->hasMany('App\Models\Comment', 'user_id');

    }


    #Профилю принадлежит комментарий
    public function commentHasProfile()
    {
        return $this->hasMany('App\Models\Comment', 'profile_id');
    }


    #Пользователю принадлежит книга
    public function hasBook()
    {
        return $this->hasMany('App\Models\Book', 'author_id');
    }



}

