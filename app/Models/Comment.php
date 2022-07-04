<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['profile_id', 'thread_id', 'header', 'body'];


    //обратный метод Пользователю принадлжедит коммент
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }


    //скоуп для записи где parent_id = null
    public function scopeNotReply($query)
    {
        return $query->whereNull('parent_id');

    }


    //скоуп для записи где header = null
    public function scopeNotHeader($query)
    {
        return $query->whereNull('header');
    }


    //скоуп для записи где header != null
    public function scopeNotNullHeader($query)
    {
        return $query->whereNotNull('header');
    }


    //один ко многим для parent_id
    public function replies()
    {
        return $this->hasMany('App\Models\Comment', 'parent_id');
    }


    //обратное один ко многим для parent_id
    public function reverseReplies()
    {
        return $this->belongsTo('App\Models\Comment', 'parent_id');
    }







}
