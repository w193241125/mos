<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function show()
    {
        $order = DB::table('orders')->get();
        return view('admin.order.order', compact('order'));
    }
}
