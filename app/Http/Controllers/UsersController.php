<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    //

    public function store(Request $request)
    {
        $this->validate($request, [
            'uname' => 'required|max:50',
            'password' => 'required|confirmed|min:6'
        ]);
        return;
    }
}
