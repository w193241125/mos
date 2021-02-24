<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function __construct(Request $request)
    {
        //dd($request->user());
        $this->middleware('auth');
    }

    public function show()
    {
        $shop = DB::table('shops')->where('state','!=',3)->get();
        $type =[1=>'早餐',2=>'中晚餐'];
        return view('admin.shop.shop', compact(['shop','type']));
    }

    public function add()
    {
        return view('admin.shop.add');
    }

    public function doadd(Request $request)
    {
        $shop['type'] = $request->type;
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

    public function edit(Request $request)
    {
        $sid = $request->route('sid');
        $shop = DB::table('shops')->where('sid','=',$sid)->get()->toArray();
        //dd($shop);
        return view('admin.shop.edit',['shop'=>$shop[0]]);
    }

    public function doedit(Request $request)
    {
        //dd($request);
        $sid= $request->sid;
        $data['type'] = $request->type;
        $data['sname'] = $request->sname;
        $data['address'] = $request->address;
        $data['phone'] = $request->phone;
        $data['state'] = $request->state;
        $data['limit_money'] = $request->limit_money;
        $res = DB::table('shops')->where('sid','=',$sid)->update($data);
        if ($res){
            return redirect('admin/shop')->with(['shopMes'=>1]);
        }else{
            return redirect('admin/shop')->with(['shopMes'=>2]);
        }

    }
}
