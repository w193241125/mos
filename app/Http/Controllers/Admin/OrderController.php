<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function show()
    {
        //获取本周是今年第几周
        $date = new \DateTime;
        $weekOfYear = date_get_week_number($date);

        $food = DB::table('foods')->select(['fid','fname'])->get()->toArray();
        $order = DB::table('orders as o')->leftJoin('shops as s','o.sid','=','s.sid')->join('types as t','t.tmark','=','o.tmark')->where('week_of_year','=',$weekOfYear)->get()->toArray();
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

        return view('admin.order.order', ['order'=>$order, 'food'=>$food]);
    }
}
