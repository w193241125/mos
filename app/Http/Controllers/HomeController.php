<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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
        $menu = DB::table('menus as m')->leftJoin('foods as f','m.fid','=','f.fid')->join('shops as s','s.sid','=','m.sid')->orderBy('mtype')->get();
        $week = DB::table('menus')->select('mweek')->distinct()->orderBy('mweek','asc')->get();
        //dd($menu);
        //return view('home',compact('menu'));
        return view('home',['menu'=>$menu,'food'=>$food, 'shop'=>$shop,'week'=>$week,'dayWeek'=>$dayWeek]);
    }

    public function upd(Request $request)
    {
        dd($request);
    }
}
