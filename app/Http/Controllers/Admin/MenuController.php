<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function show()
    {
        $menu = DB::table('menus as m')->leftJoin('shops as s','s.sid','=','m.sid')->join('types as t','t.tmark','=','m.tmark')->get();
        return view('admin.menu.menu',compact('menu'));
    }

    public function add()
    {
        $shop = DB::table('shops')->get();
        $type = DB::table('types')->get();
        return view('admin.menu.add',['shop'=>$shop,'type'=>$type,]);

    }

    public function doadd(Request $request)
    {
        $data['fid'] = implode(',',$request->fid);
        $data['tmark'] = $request->tmark;
        $data['mweek'] = $request->mweek;
        $data['sid'] = $request->sid;

        $re = DB::table('menus')->where('tmark','=',$data['tmark'])->where('mweek','=',$data['mweek'])->get();
        if ($re){
            return back()->with(['error'=>'设置的时间已存在!']);
        }
        $res = DB::table('menus')->insert($data);
        if ($res){
            return redirect('admin/menu')->with(['menuMsg'=>1]);
        } else {
            return redirect('admin/menu')->with(['menuMsg'=>2]);
        }
    }

    public function ajaxReq(Request $request)
    {
        //$shop = DB::table('shops')->get();
        //$type = DB::table('types')->get();

        $sid = $request->route('sid');
        $food = DB::table('foods')->where('sid','=',$sid)->get();
        $msg = json_encode($food,true);
        return $msg;
    }
}
