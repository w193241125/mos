<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class FoodController extends Controller
{
    public function show()
    {
        $food = DB::table('foods')->get();
        return view('admin.food.food', compact('food'));
    }
}
