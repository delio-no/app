<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserListController extends Controller
{
    public function showUsers(){
        $users = User::all();

        return view('user.list')->with('users', $users);
    }
}
