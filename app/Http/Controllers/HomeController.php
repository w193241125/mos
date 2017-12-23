<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

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
        $menu = DB::table('menus as m')->leftJoin('foods as f', 'm.fid', '=', 'f.fid')->join('shops as s', 's.sid', '=', 'm.sid')->join('types as t','t.tid','=','mtype')->get();
        $type = DB::table('types')->get();
        //$dayType = DB::table('menus')->select('mtype')->distinct()->orderBy('mtype', 'asc')->get();
        //dd($menu);
        //return view('home',compact('menu'));
        return view('home', ['menu' => $menu, 'food' => $food, 'shop' => $shop, 'dayWeek' => $dayWeek,'type'=>$type]);
    }

    public function upd(Request $request)
    {
        //$mtype = [
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
        //foreach ($mtype as $k=>$v){
        //    $date['tid'] = $k;
        //    $date['tname']=$v;
        //DB::table('types')->insert($date);
        //}
        dd($request);
        $food = '';
        $total = 0;
        $day = ['B', 'L', 'D', 'O'];
        $week = ['Mon', 'Tues', 'Wed', 'Thur', 'Fri', 'Sat'];
        foreach ($day as $d) {
            foreach ($week as $w) {
                $key = $w . $d;
                if (isset($request->$key)) {
                    switch ($key) {
                        case 'MonB':
                            $otype = 1;
                            $oweek = 1;
                            break;
                        case 'MonL':
                            $otype = 2;
                            $oweek = 1;
                            break;
                        case 'MonD':
                            $otype = 3;
                            $oweek = 1;
                            break;
                        case 'TuesB':
                            $otype = 1;
                            $oweek = 2;
                            break;
                        case 'TuesL':
                            $otype = 2;
                            $oweek = 2;
                            break;
                        case 'TuesD':
                            $otype = 3;
                            $oweek = 2;
                            break;
                        case 'WedB':
                            $otype = 1;
                            $oweek = 3;
                            break;
                        case 'WedL':
                            $otype = 2;
                            $oweek = 3;
                            break;
                        case 'WedD':
                            $otype = 3;
                            $oweek = 3;
                            break;
                        case 'ThurB':
                            $otype = 1;
                            $oweek = 4;
                            break;
                        case 'ThurL':
                            $otype = 2;
                            $oweek = 4;
                            break;
                        case 'ThurD':
                            $otype = 3;
                            $oweek = 4;
                            break;
                        case 'FriB':
                            $otype = 1;
                            $oweek = 5;
                            break;
                        case 'FriL':
                            $otype = 2;
                            $oweek = 5;
                            break;
                        case 'FriD':
                            $otype = 3;
                            $oweek = 5;
                            break;
                        case 'SatB':
                            $otype = 1;
                            $oweek = 6;
                            break;
                        case 'SatL':
                            $otype = 2;
                            $oweek = 6;
                            break;
                        case 'SatD':
                            $otype = 3;
                            $oweek = 6;
                            break;

                    }

                    $data['sid'] = $request->$key['shop'];
                    foreach ($request->$key['food'] as $k => $item) {
                        $food = $food . ',' . $k;
                        $total += $item;
                    }
                    $data['food'] = trim($food, ',');
                    $data['uid'] = 1;
                    $data['oweek'] = $oweek;
                    $data['otype'] = $otype;
                    $data['total'] = $total;
                    DB::table('orders')->insert($data);
                    $food = '';
                    $total = 0;
                }
            }
        }
    }
}
