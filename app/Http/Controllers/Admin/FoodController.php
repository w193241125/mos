<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class FoodController extends Controller
{
    public function show()
    {
        $food = DB::table('foods as f')->leftJoin('shops as s','s.sid','=','f.sid')->get();
        return view('admin.food.food', compact('food'));
    }

    public function add()
    {
        $shop = DB::table('shops')->get();
        return view('admin.food.add',['shop'=>$shop]);
    }

    public function doadd(Request $request)
    {
        $food['fname'] = $request->fname;
        $food['price'] = $request->price;
        $food['state'] = $request->state;

        $res = DB::table('food')->insert($food);
        if ($res){
            return redirect('admin/food')->with(['message'=>'1']);
        } else {
            return redirect('admin/food')->with(['message'=>'2']);
        }
    }
}
