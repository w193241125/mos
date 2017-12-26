<?php

namespace App\Http\Controllers;

use Faker\Provider\zh_CN\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dayWeek = Carbon::parse(date('Y-m-d'))->dayOfWeek;//获取今天是周几

        $food = DB::table('foods')->get();
        $shop = DB::table('shops')->get();
        $menu = DB::table('menus')->get()->toArray();
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

        //$tid = [
        //  1=>'一早',
        //  2=>'一中',
        //  3=>'一晚',
        //  4=>'二早',
        //  5=>'二中',
        //  6=>'二晚',
        //  7=>'三早',
        //  8=>'三中',
        //  9=>'三晚',
        //  10=>'四早',
        //  11=>'四中',
        //  12=>'四晚',
        //  13=>'五早',
        //  14=>'五中',
        //  15=>'五晚',
        //  16=>'六早',
        //  17=>'六中',
        //  18=>'六晚',
        //];
        //dd($request->order);
        $data['total'] = 0;
        $data['food'] = '';
        $data['uid'] = 1;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['week_of_year'] = $weekOfYear;
        foreach ($request->order as $key=>$item) {
            $data['tmark'] = $key;
            if (is_array($item)){
                foreach ($item as $k=>$v) {
                        $data['sid'] = $k;
                    foreach ($v as $fid=>$price) {
                        $data['food'] .= $fid.',';
                        $data['total'] += $price;
                    }
                }
            }
            DB::table('orders')->insert($data);
            $data['total'] = 0;
            $data['food'] = '';
        }

        return redirect('home/show')->with(['message'=>'1']);
    }

    public function show()
    {
        //获取本周是今年第几周
        $date = new \DateTime;
        $weekOfYear = date_get_week_number($date);

        $food = DB::table('foods')->select(['fid','fname'])->get()->toArray();
        $order = DB::table('orders')->where('week_of_year','=',$weekOfYear)->get()->toArray();
        $type = DB::table('types')->get()->toArray();
        foreach ($order as &$item) {
            $item->list = '';
            $tmp = explode(',',trim($item->food,','));
            foreach ($food as $f) {
                foreach ($tmp as $t) {
                    if ($f->fid == $t){
                        $item->list .= $f->fname.'+';
                    }
                }
            }
            $item->list = trim($item->list,'+');
        }

        return view('show',['order'=>$order,'type'=>$type]);
    }
}
