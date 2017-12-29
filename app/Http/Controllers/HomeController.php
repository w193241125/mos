<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        //dd($request->user());
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $dayWeek = Carbon::parse(date('Y-m-d'))->dayOfWeek;//获取今天是周几

        $food = DB::table('foods')->orderBy('price','desc')->get();
        $shop = DB::table('shops')->get();
        $menu = DB::table('menus')->where('mweek','=',1)->get()->toArray();
        foreach ($menu as &$v) {
            $v->food = explode(',',trim($v->fid,','));
        }
        $type = DB::table('types')->get();
        //$dayType = DB::table('menus')->select('tid')->distinct()->orderBy('tid', 'asc')->get();
        //dd($menu);
        //return view('home',compact('menu'));
        return view('home', ['menu' => $menu, 'food' => $food, 'shop' => $shop, 'dayWeek' => $dayWeek,'type'=>$type]);
    }

    public function upd(Request $request)
    {
        $date = new \DateTime;
        //$date->setDate(2017, 12, 31);
        //$date->setDate(2018, 1, 1);
        $weekOfYear = date_get_week_number($date);
        //dd($weekOfYear);
        //dd($request);
        $data['uid'] = Auth::user()->uid;
        $data['total'] = 0;
        $data['food'] = '';
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['week_of_year'] = $weekOfYear;
        if (isset($request->shop)){
            foreach ($request->shop as $mark=>$shop) {
                if ($shop == 0){
                    DB::table('orders')->where(['uid'=>$data['uid'],'tmark'=>$mark])->delete();
                }
            }
        }

        if (isset($request->order)){
            foreach ($request->order as $key=>$item) {
            $data['tmark'] = $key;
            if (is_array($item)){
                foreach ($item as $k=>$v) {
                    $data['sid'] = $k;
                    foreach ($v as $fid=>$price) {
                        $re = DB::table('foods')->where('fid','=',$fid)->get()->toArray();
                        //dd($re[0]->fname);
                        $data['food'] .= $re[0]->fname.'+';
                        $data['total'] += $price;
                    }
                }
            }

            $data['food'] = trim($data['food'],'+');
            $res = DB::table('orders')->where('tmark','=',$data['tmark'])->where('week_of_year','=',$weekOfYear)->where('uid','=',$data['uid'])->get()->toArray();
            if ($res){
                DB::table('orders')->where('oid','=',$res[0]->oid)->update($data);
            } else {
                DB::table('orders')->insert($data);
            }
            $data['total'] = 0;
            $data['food'] = '';
        }
        }
        return redirect('home/show')->with(['message'=>'1']);
    }

    public function show()
    {
        $uid = Auth::user()->uid;
        //获取本周是今年第几周
        $date = new \DateTime;
        $weekOfYear = date_get_week_number($date);

        $food = DB::table('foods')->select(['fid','fname'])->get()->toArray();
        $order = DB::table('orders')->where(['week_of_year'=>$weekOfYear,'uid'=>$uid])->get()->toArray();
        $type = DB::table('types')->get()->toArray();
        //foreach ($order as &$item) {
        //
        //    $item->list = '';
        //    $tmp = explode(',',trim($item->food,','));
        //    foreach ($food as $f) {
        //        foreach ($tmp as $t) {
        //            if ($f->fid == $t){
        //                $item->list .= $f->fname.'+';
        //            }
        //        }
        //    }
        //    $item->list = trim($item->list,'+');
        //}

        return view('show',['order'=>$order,'type'=>$type]);
    }
}
