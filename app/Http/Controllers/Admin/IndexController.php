<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    public function __construct()
    {

    }
    public function show()
    {
        return view('admin.index.index');
    }
}
