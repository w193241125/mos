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
        $shop = DB::table('shops')->where('state','!=',3)->get();
        return view('admin.food.add',['shop'=>$shop]);
    }

    public function doadd(Request $request)
    {
        $food['fname'] = $request->fname;
        $food['price'] = $request->price;
        $food['state'] = $request->state;
        $food['sid'] = $request->sid;

        $res = DB::table('foods')->insert($food);
        if ($res){
            return redirect('admin/food')->with(['foodMsg'=>'1']);
        } else {
            return redirect('admin/food')->with(['foodMsg'=>'2']);
        }
    }

    public function edit(Request $request)
    {
        $fid = $request->route('fid');
        $food = DB::table('foods')->where('fid','=',$fid)->get()->toArray();
        $shop = DB::table('shops')->where('state','!=',3)->get()->toArray();
        return view('admin.food.edit',['food'=>$food[0],'shop'=>$shop]);
    }

    public function doedit(Request $request)
    {
        //dd($request);
        $fid= $request->fid;
        $data['fname'] = $request->fname;
        $data['sid'] = $request->sid;
        $data['state'] = $request->state;
        $data['price'] = $request->price;
        $res = DB::table('foods')->where('fid','=',$fid)->update($data);
        if ($res){
            return redirect('admin/food')->with(['foodMes'=>1]);
        }else{
            return redirect('admin/food')->with(['foodMes'=>2]);
        }

    }
}
