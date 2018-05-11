<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function __construct(Request $request)
    {
        //dd($request->user());
        $this->middleware('auth');
    }

    public function show(Request $request)
    {
        $where = [];
        if ($request->mweek){
            $where['m.mweek'] = $request->mweek;
        }
        if ($request->sid){
            $where['m.sid'] = $request->sid;
        }
        if(Auth::user()->state==4){
            $where['s.sname'] = Auth::user()->realname;
        }
        $menu = DB::table('menus as m')->leftJoin('shops as s','s.sid','=','m.sid')->join('types as t','t.tmark','=','m.tmark')->where('m.sid','!=',0)->where($where)->orderBy('m.tmark')->get();
        $tmp = '';
        foreach ($menu as &$item) {
            if ($item->fid) {
                $arr = explode(',', $item->fid);
                $res = DB::table('foods')->whereIn('fid', $arr)->get(['fname'])->toArray();
                foreach ($res as $re) {
                    $tmp .= $re->fname . ',';
                }

            }
                $item->list = $tmp;
                $tmp = '';
        }
        $shop = DB::table('shops')->where('sid','!=',0)->where('state','=',1)->get();
        return view('admin.menu.menu',['menu'=>$menu,'shop'=>$shop]);
    }

    public function add()
    {
        $where['state'] = 1;
        if(Auth::user()->state==4){
            $where['sname'] = Auth::user()->realname;
        }
        $shop = DB::table('shops')->where('sid','!=',0)->where($where)->get();
        $type = DB::table('types')->get();
        return view('admin.menu.add',['shop'=>$shop,'type'=>$type,]);

    }

    public function doadd(Request $request)
    {
        if (Auth::user()->state == 4){
            $s = DB::table('shops')->select('sid')->where('sname','=',Auth::user()->realname)->get()->toArray();
            if ($s[0]->sid != $request->sid){
                return back()->with(['error'=>'服务器繁忙,请稍后再试!']);
            }
        }
        $data['fid'] = $request->fid?implode(',',$request->fid):'';
        $data['tmark'] = $request->tmark;
        $data['mstate'] = $request->mstate;
        $data['sid'] = $request->sid;
        $data['mweek'] = $request->mweek?$request->mweek:1;

        $re = DB::table('menus')->where(['tmark'=>$data['tmark'],'mweek'=>$data['mweek'],'sid'=>$data['sid']])->get()->toArray();
        //dd($re);
        if ($re){
            return back()->with(['error'=>'设置的时间已存在!']);
        }

        $res = DB::table('menus')->insert($data);
        if ($res){
            return json_encode(['menuMsg'=>1]);
        } else {
            return json_encode(['menuMsg'=>2]);
        }
    }

    public function edit(Request $request)
    {
        $type = DB::table('types')->get();
        $mid = $request->route('mid');
        $menu = DB::table('menus')->where('mid','=',$mid)->get()->toArray();
        //dd($menu);

        $where['state'] = 1;
        if(Auth::user()->state==4){
            $where['sname'] = Auth::user()->realname;
        }
        $shop = DB::table('shops')->where('sid','!=',0)->where($where)->get()->toArray();
        $food = DB::table('foods')->where('sid','=',$menu[0]->sid)->orderBy('price','desc')->get();
        $fidArr = explode(',',$menu[0]->fid);
        //dd($shop);
        return view('admin.menu.edit',['menu'=>$menu[0],'shop'=>$shop,'food'=>$food,'fidArr'=>$fidArr,'type'=>$type]);
    }

    public function doedit(Request $request)
    {
        if (Auth::user()->state == 4){
            $s = DB::table('shops')->select('sid')->where('sname','=',Auth::user()->realname)->get()->toArray();
            if ($s[0]->sid != $request->sid){
                return back()->with(['error'=>'服务器繁忙,请稍后再试!']);
            }
        }
        //dd($request);
        $data['fid'] = $request->fid?implode(',',$request->fid):'';
        $data['tmark'] = $request->tmark;
        $data['mweek'] = $request->mweek?$request->mweek:1;
        $data['sid'] = $request->sid;
        $data['mstate'] = $request->mstate;
        $mid= $request->mid;
        $res = DB::table('menus')->where('mid','=',$mid)->update($data);

        if ($res){
            return redirect('admin/menu')->with(['menuMes'=>1]);
        }else{
            return redirect('admin/menu')->with(['menuMes'=>2]);
        }

    }

    public function ajaxReq(Request $request)
    {
        //$shop = DB::table('shops')->get();
        //$type = DB::table('types')->get();

        $sid = $request->route('sid');
        $food = DB::table('foods')->where(['sid'=>$sid,'fstate'=>1])->orderByDesc('price')->get();
        $msg = json_encode($food,true);
        return $msg;
    }

    public function fingMenuOfCurrentTime(Request $request)
    {
        $sid = $request->route('sid');
        $tmark = $request->route('tmark');
        $mweek = $request->route('mweek');
        $menu = DB::table('menus')->where(['sid'=>$sid,'tmark'=>$tmark,'mweek'=>$mweek])->get()->toArray();
        //return(json_encode($menu));
        $tmp = '';
        foreach ($menu as &$item) {

            $arr = explode(',',$item->fid);
            $res = DB::table('foods')->whereIn('fid', $arr)->get(['fname'])->toArray();
            foreach ($res as $re) {
                $tmp .= $re->fname . ',';
            }
            //foreach ($arr as $fid) {
            //    $res = DB::table('foods')->where('fid','=',$fid)->get(['fname'])->toArray();
            //    $tmp .= $res[0]->fname.',';
            //}
            $item->list = $tmp;
            $tmp = '';
        }
        $msg = json_encode($menu,true);
        return $msg;
    }

    //一键设置早餐菜单
    public function setBreakfast()
    {
        //shops表当前早餐商家id为4 ,若更改商家,则需要修改where 条件 todo
        $id_arr = DB::table('foods')->select(['fid'])->where(['sid'=>4,'fstate'=>1])->get();
        $id = '';
        foreach ($id_arr as $item) {
            $id .= $item->fid.',';
        }
        $id = trim($id,',');
        $update = DB::table('menus')->where('sid','=',4)->update(['fid'=>$id]);
        echo json_encode(['menuMsg'=>1]);

    }
    //删除菜单
    public function delMenu(Request $request)
    {
        $mid = $request->mid;
        $res = DB::table('menus')->where('mid','=',$mid)->delete();
        if ($res){
            echo json_encode(['menuMsg'=>1]);
        }else{
            echo json_encode(['menuMsg'=>2]);
        }
    }
}
