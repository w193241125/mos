<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function __construct(Request $request)
    {
        //dd($request->user());
        $this->middleware('auth');
    }

    public function show(Request $request)
    {
        //获取本周是今年第几周
        $date = new \DateTime;
        $weekOfYear = date_get_week_number($date);
        $where = ['week_of_year'=>$weekOfYear];
        $orderBy = 'o.tmark';
        if ($request->tmark){
            $where['o.tmark'] = $request->tmark;
            $orderBy = 'o.uid';
        }
        if ($request->sid){
            $where['o.sid'] = $request->sid;
        }
        $tmark = $request->tmark?$request->tmark:'';
        $sid = $request->sid?$request->sid:'';

        $food = DB::table('foods')->select(['fid','fname'])->get()->toArray();
        $order = DB::table('orders as o')->leftJoin('shops as s','o.sid','=','s.sid')->join('types as t','t.tmark','=','o.tmark')->where($where)->orderBy($orderBy)->paginate(20);
        $type = DB::table('types')->get()->toArray();
        $shop = DB::table('shops')->get()->where('sid','!=',0)->toArray();

        $user = DB::table('users')->get()->toArray();
        //foreach ($order as &$item) {
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

        return view('admin.order.order', ['order'=>$order, 'food'=>$food,'user'=>$user,'thisWeek'=>$weekOfYear,'type'=>$type,'shop'=>$shop,'tmark'=>$tmark,'sid'=>$sid,]);
    }

    public function showTdate(Request $request)
    {
        //获取本周是今年第几周
        $date = new \DateTime;
        $weekOfYear = date_get_week_number($date);
        $tmark=$request->tmark;

        $food = DB::table('foods')->select(['fid','fname'])->get()->toArray();
        $order = DB::table('orders as o')->leftJoin('shops as s','o.sid','=','s.sid')->join('types as t','t.tmark','=','o.tmark')->where('week_of_year','=',$weekOfYear)->where('m.tmark','=',$tmark)->paginate(20);
        $type = DB::table('types')->get()->toArray();

        $user = DB::table('users')->get()->toArray();
        return view('admin.order.order', ['order'=>$order, 'food'=>$food,'user'=>$user,'thisWeek'=>$weekOfYear,'type'=>$type]);

    }

    public function export(Request $request)
    {

        $start = $request->route('start');
        $end = $request->route('end');

        if ($start==1 && $end==1){
            $excelName = '本周订单';
            $date = new \DateTime;
            $weekOfYear = date_get_week_number($date);

            $order = DB::table('orders as o')->leftJoin('shops as s','o.sid','=','s.sid')->join('types as t','t.tmark','=','o.tmark')->join('users as u','u.uid','=','o.uid')->where('week_of_year','=',$weekOfYear)->get()->toArray();
        } else {
            $excelName = substr($start,0,10).' 到 '.substr($end,0,10).' 的订单';
            $order = DB::table('orders as o')->leftJoin('shops as s','o.sid','=','s.sid')->join('types as t','t.tmark','=','o.tmark')->join('users as u','u.uid','=','o.uid')->orWhereBetween('created_at',[$start,$end])->get()->toArray();
        }

        $cellData[0] = ['用户名称','商家','食物','订单类型','订单时间','价格',];
        foreach ($order as $item) {
            array_push($cellData,[$item->realname,$item->sname,$item->food,$item->tname,$item->created_at,$item->total]);
        }
        //dd($cellData);
        Excel::create($excelName,function($excel) use ($cellData){
            $excel->sheet('order', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');
    }

    public function allShow(Request $request)
    {
        //获取本周是今年第几周
        $date = new \DateTime;
        $weekOfYear = date_get_week_number($date);
        $sid = $request->sid?$request->sid:'';
        $sdate = $request->date?$request->date:'';
        $start = 1;
        $end = 1;
        if ($request->date){
            $start = substr($request->date,0,10);
            $end = substr($request->date,-10);
            $order = DB::table('orders as o')->leftJoin('shops as s','o.sid','=','s.sid')->join('types as t','t.tmark','=','o.tmark')->orderBy('date')->whereBetween('date',[$start,$end])->paginate(20);
        } else {
            $order = DB::table('orders as o')->leftJoin('shops as s','o.sid','=','s.sid')->join('types as t','t.tmark','=','o.tmark')->orderBy('date')->paginate(20);
        }

        $food = DB::table('foods')->select(['fid','fname'])->get()->toArray();
        $shop = DB::table('shops')->get()->where('sid','!=',0)->toArray();
        $user = DB::table('users')->get()->toArray();

        return view('admin.order.allOrder', ['order'=>$order, 'food'=>$food,'user'=>$user,'thisWeek'=>$weekOfYear,'shop'=>$shop,'sid'=>$sid,'date'=>$sdate,'start'=>$start,'end'=>$end]);
    }

    //public function search(Request $request)
    //{
    //    $sdate = $request->date;
    //    $start = substr($request->date,0,10);
    //    $end = substr($request->date,-10);
    //    $tmark = $request->tmark?$request->tmark:'';
    //    $sid = $request->sid?$request->sid:'';
    //
    //    //获取本周是今年第几周
    //    $date = new \DateTime;
    //    $weekOfYear = date_get_week_number($date);
    //
    //    $order = DB::table('orders as o')->leftJoin('shops as s','o.sid','=','s.sid')->join('types as t','t.tmark','=','o.tmark')->orderBy('date')->whereBetween('date',[$start,$end])->paginate(20);
    //    $food = DB::table('foods')->select(['fid','fname'])->get()->toArray();
    //    $user = DB::table('users')->get()->toArray();
    //
    //    return view('admin.order.allOrder', ['order'=>$order, 'food'=>$food,'user'=>$user,'thisWeek'=>$weekOfYear,'date'=>$sdate,'tmark'=>$tmark,'sid'=>$sid,]);
    //}

    //商家获取自己的订单列表
    public function myOrder(Request $request)
    {
        $realname = Auth::user()->realname;
        $where['sname'] = $realname;
        //获取本周是今年第几周
        $date = new \DateTime;
        $weekOfYear = date_get_week_number($date);
        $where['week_of_year'] = $weekOfYear;
        $orderBy = 'o.uid';

        $tmark = $request->tmark?$request->tmark:'';
        $sid = $request->sid?$request->sid:'';
        if ($request->tmark){
            $where['o.tmark'] = $request->tmark;
            $orderBy = 'o.uid';
        }

        $food = DB::table('foods')->select(['fid','fname'])->get()->toArray();
        $order = DB::table('orders as o')->leftJoin('shops as s','o.sid','=','s.sid')->join('types as t','t.tmark','=','o.tmark')->where($where)->orderBy($orderBy)->paginate(20);
        $type = DB::table('types')->get()->toArray();
        //$shop = DB::table('shops')->get()->where('sid','!=',0)->toArray();

        $user = DB::table('users')->get()->toArray();
        //foreach ($order as &$item) {
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

        return view('admin.order.myorder', ['order'=>$order, 'food'=>$food,'user'=>$user,'thisWeek'=>$weekOfYear,'type'=>$type,'tmark'=>$tmark,'sid'=>$sid]);

    }

    public function shopExport(Request $request)
    {
        $realname = Auth::user()->realname;
        $start = $request->route('start');
        $end = $request->route('end');

        if ($start==1 && $end==1){
            $excelName = '本周订单';
            $date = new \DateTime;
            $weekOfYear = date_get_week_number($date);

            $order = DB::table('orders as o')->leftJoin('shops as s','o.sid','=','s.sid')->join('types as t','t.tmark','=','o.tmark')->join('users as u','u.uid','=','o.uid')->where(['week_of_year'=>$weekOfYear,'sname'=>$realname])->get()->toArray();
        } else {
            $excelName = substr($start,0,10).' 到 '.substr($end,0,10).' 的订单';
            $order = DB::table('orders as o')->leftJoin('shops as s','o.sid','=','s.sid')->join('types as t','t.tmark','=','o.tmark')->join('users as u','u.uid','=','o.uid')->orWhereBetween('created_at',[$start,$end])->get()->toArray();
        }

        $cellData[0] = ['用户名称','商家','食物','订单类型','订单时间','价格',];
        foreach ($order as $item) {
            array_push($cellData,[$item->realname,$item->sname,$item->food,$item->tname,$item->created_at,$item->total]);
        }
        //dd($cellData);
        Excel::create($excelName,function($excel) use ($cellData){
            $excel->sheet('order', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');
    }
}
