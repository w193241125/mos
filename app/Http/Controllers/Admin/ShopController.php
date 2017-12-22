<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function show()
    {
        $shop = DB::table('shops')->get();
        return view('admin.shop.shop', compact('shop'));
    }
}
