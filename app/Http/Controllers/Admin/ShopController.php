<?php

namespace App\Http\Controllers\Admin;

use App\Models\Company;
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

    public function show(Company $company)
    {
        $shop = DB::table('shops')->where('state','!=',3)->orderBy('state')->get()->toArray();
        foreach ($shop as $k=>$v) {
            $shop[$k]->companys = json_decode($v->companys,true);
        }
        $type = [1=>'早餐', 2=>'中晚餐'];
        $company = $company->get()->toArray();
        $companys = [];
        foreach ($company as $v){
            $companys[$v['id']] = $v['company_name'];
        }
        return view('admin.shop.shop', compact(['shop','type','companys']));
    }

    public function add(Company $company)
    {
        $companys = $company->where(['state'=>1])->get()->toArray();
        return view('admin.shop.add',compact(['companys']));
    }

    public function doadd(Request $request)
    {
        $shop['type'] = $request->type;
        $shop['sname'] = $request->sname;
        $shop['address'] = $request->address;
        $shop['phone'] = $request->phone;
        $shop['state'] = $request->state;
        $shop['companys'] = json_encode($request->companys);
        $shop['limit_money'] = $request->limit_money;
        $shop['state'] = $request->state;

        $res = DB::table('shops')->insert($shop);
        if ($res){
            return redirect('admin/shop')->with(['shopMsg'=>'1']);
        } else {
            return redirect('admin/shop')->with(['shopMsg'=>'2']);
        }
    }

    public function edit(Request $request,Company $company)
    {
        $sid = $request->route('sid');
        $shop = DB::table('shops')->where('sid','=',$sid)->get()->toArray();
        $shop[0]->companys= json_decode($shop[0]->companys,true) ?? [];
        //dd($shop);
        $companys = $company->where(['state'=>1])->get()->toArray();
        return view('admin.shop.edit',['shop'=>$shop[0],'companys'=>$companys]);
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
        $data['companys'] = json_encode($request->companys);
        $data['limit_money'] = $request->limit_money;
        $res = DB::table('shops')->where('sid','=',$sid)->update($data);
        if ($res){
            return redirect('admin/shop')->with(['shopMes'=>1]);
        }else{
            return redirect('admin/shop')->with(['shopMes'=>2]);
        }

    }
}
