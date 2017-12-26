<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function show()
    {
        $user = DB::table('users')->get();
        return view('admin.user.user',compact('user'));
    }
}
