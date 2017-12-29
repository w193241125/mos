<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function show()
    {
        //获取本周是今年第几周
        $date = new \DateTime;
        $weekOfYear = date_get_week_number($date);

        $food = DB::table('foods')->select(['fid','fname'])->get()->toArray();
        $order = DB::table('orders as o')->leftJoin('shops as s','o.sid','=','s.sid')->join('types as t','t.tmark','=','o.tmark')->where('week_of_year','=',$weekOfYear)->paginate(20);
        $type = DB::table('types')->get()->toArray();

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

        return view('admin.order.order', ['order'=>$order, 'food'=>$food,'user'=>$user,'thisWeek'=>$weekOfYear]);
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

    public function allShow()
    {
        //获取本周是今年第几周
        $date = new \DateTime;
        $weekOfYear = date_get_week_number($date);

        $food = DB::table('foods')->select(['fid','fname'])->get()->toArray();
        $order = DB::table('orders as o')->leftJoin('shops as s','o.sid','=','s.sid')->join('types as t','t.tmark','=','o.tmark')->orderBy('created_at')->paginate(20);
        $type = DB::table('types')->get()->toArray();

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

        return view('admin.order.allOrder', ['order'=>$order, 'food'=>$food,'user'=>$user,'thisWeek'=>$weekOfYear]);
    }

    public function search(Request $request)
    {
        $sdate = $request->date;
        //dd($request);
        $start = substr($request->date,0,10).' 00:00:00';
        $end = substr($request->date,-10).' 23:59:59';
        //dd($start);

        $res = DB::table('orders')->whereBetween('created_at',[$start,$end])->get();
        //获取本周是今年第几周
        $date = new \DateTime;
        $weekOfYear = date_get_week_number($date);

        $food = DB::table('foods')->select(['fid','fname'])->get()->toArray();
        $order = DB::table('orders as o')->leftJoin('shops as s','o.sid','=','s.sid')->join('types as t','t.tmark','=','o.tmark')->orderBy('created_at')->whereBetween('created_at',[$start,$end])->paginate(20);
        $type = DB::table('types')->get()->toArray();

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

        return view('admin.order.allOrder', ['order'=>$order, 'food'=>$food,'user'=>$user,'thisWeek'=>$weekOfYear,'start'=>$start,'end'=>$end,'date'=>$sdate]);
    }
}
