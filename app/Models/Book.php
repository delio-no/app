<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    protected $fillable = ['name', 'description'];

    public function user(){
        return $this->belongsTo('App\Models\User', 'author_id');
    }

}
