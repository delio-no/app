<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['book_id' ,'user_id', 'author_id'];

    public function user(){
        return $this->belongsTo('App\Models\User', 'author_id');
    }
}
