<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function postStatus(Request $request){
        $this->validate($request, [
            'status' => 'required|max:1000'
        ]);

        Auth::user()->statuses()->create([
                'body' => $request->input('status')
            ]);
        return redirect()->route('home')->with('info', 'Запись успешно добавлена');
    }
}