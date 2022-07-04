<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Auth;

class RoleController extends Controller
{
    public function addRole($profileId)
    {
        Role::create([
            'user_id' => $profileId,
            'author_id' => Auth::user()->id,
        ]);
        return redirect()->back();
    }

    public function deleteRole($userId)
    {
        Role::where('user_id', $userId)->delete();
        return redirect()->back();
    }
}
