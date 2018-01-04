<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        if (!empty($request->mweek)){
            $mweek = $request->mweek;
            $menu = DB::table('menus as m')->leftJoin('shops as s','s.sid','=','m.sid')->join('types as t','t.tmark','=','m.tmark')->where('m.sid','!=',0)->where('m.mweek','=',$mweek)->orderBy('m.tmark')->get();
        }else{
            $menu = DB::table('menus as m')->leftJoin('shops as s','s.sid','=','m.sid')->join('types as t','t.tmark','=','m.tmark')->where('m.sid','!=',0)->orderBy('m.tmark')->get();
        }
        $tmp = '';
        foreach ($menu as &$item) {
            if ($item->fid) {
                $arr = explode(',', $item->fid);
                foreach ($arr as $fid) {
                    $res = DB::table('foods')->where('fid', '=', $fid)->get(['fname'])->toArray();
                    $tmp .= $res[0]->fname . ',';
                }
            }
                $item->list = $tmp;
                $tmp = '';
        }

        return view('admin.menu.menu',compact('menu'));
    }

    public function add()
    {
        $shop = DB::table('shops')->where('sid','!=',0)->where('state','=',1)->get();
        $type = DB::table('types')->get();
        return view('admin.menu.add',['shop'=>$shop,'type'=>$type,]);

    }

    public function doadd(Request $request)
    {
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
        $shop = DB::table('shops')->where('sid','!=',0)->get()->toArray();
        $food = DB::table('foods')->where('sid','=',$menu[0]->sid)->orderBy('price','desc')->get();
        $fidArr = explode(',',$menu[0]->fid);
        //dd($shop);
        return view('admin.menu.edit',['menu'=>$menu[0],'shop'=>$shop,'food'=>$food,'fidArr'=>$fidArr,'type'=>$type]);
    }

    public function doedit(Request $request)
    {
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
        $food = DB::table('foods')->where('sid','=',$sid)->orderByDesc('price')->get();
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
            foreach ($arr as $fid) {
                $res = DB::table('foods')->where('fid','=',$fid)->get(['fname'])->toArray();
                $tmp .= $res[0]->fname.',';
            }
            $item->list = $tmp;
            $tmp = '';
        }
        $msg = json_encode($menu,true);
        return $msg;
    }
}
