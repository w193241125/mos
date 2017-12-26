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

    public function add()
    {
        return view('admin.shop.add');
    }

    public function doadd(Request $request)
    {
        $shop['sname'] = $request->sname;
        $shop['address'] = $request->address;
        $shop['phone'] = $request->phone;
        $shop['state'] = $request->state;
        $shop['limit_money'] = $request->limit_money;
        $shop['state'] = $request->state;

        $res = DB::table('shops')->insert($shop);
        if ($res){
            return redirect('admin/shop')->with(['shopMsg'=>'1']);
        } else {
            return redirect('admin/shop')->with(['shopMsg'=>'2']);
        }
    }
}
