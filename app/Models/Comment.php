<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['profile_id', 'thread_id', 'header', 'body'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }


    public function scopeNotReply($query)
    {
        return $query->whereNull('parent_id');


    }public function scopeNotHeader($query)
    {
        return $query->whereNull('header');
    }

    public function replies()
    {
        return $this->hasMany('App\Models\Comment', 'parent_id');
    }



}
