<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
        $dayWeek = Carbon::parse(date('Y-m-d'))->dayOfWeek;//获取今天是周几
        //获取本周是今年第几周
        $date = new \DateTime;
        $weekOfYear = date_get_week_number($date);
        if ($dayWeek==7 || $dayWeek === 0){$weekOfYear = date_get_week_number($date)-1;}
        $where = ['week_of_year'=>$weekOfYear,'year'=>date('Y',time())];
        $orderBy = 'o.uid';
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
        $order = DB::table('orders as o')->leftJoin('shops as s','o.sid','=','s.sid')->join('types as t','t.tmark','=','o.tmark')->where($where)->where('ostate','=',1)->orderBy($orderBy)->paginate(20);
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
        $dayWeek = Carbon::parse(date('Y-m-d'))->dayOfWeek;//获取今天是周几
        //获取本周是今年第几周
        $date = new \DateTime;
        $weekOfYear = date_get_week_number($date);
        if ($dayWeek==7 || $dayWeek === 0){$weekOfYear = date_get_week_number($date)-1;}
        $tmark=$request->tmark;

        $food = DB::table('foods')->select(['fid','fname'])->get()->toArray();
        $order = DB::table('orders as o')->leftJoin('shops as s','o.sid','=','s.sid')->join('types as t','t.tmark','=','o.tmark')->where('week_of_year','=',$weekOfYear)->where('ostate','=',1)->where('m.tmark','=',$tmark)->paginate(20);
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

            $order = DB::table('orders as o')->leftJoin('shops as s','o.sid','=','s.sid')->join('types as t','t.tmark','=','o.tmark')->join('users as u','u.uid','=','o.uid')->where('week_of_year','=',$weekOfYear)->where('ostate','=',1)->get()->toArray();
        } else {
            $excelName = substr($start,0,10).' 到 '.substr($end,0,10).' 的订单';
            $order = DB::table('orders as o')->leftJoin('shops as s','o.sid','=','s.sid')->join('types as t','t.tmark','=','o.tmark')->join('users as u','u.uid','=','o.uid')->orWhereBetween('date',[$start,$end])->where('ostate','=',1)->get()->toArray();
        }

        $cellData[0] = ['用户编号','用户名称','商家','食物','订单类型','订单时间','价格',];
        foreach ($order as $item) {
            array_push($cellData,[$item->uname,$item->realname,$item->sname,$item->food,$item->tname,$item->date,$item->total]);
        }
        //dd($cellData);
        Excel::create($excelName,function($excel) use ($cellData){
            $excel->sheet('order', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');
    }

    //所有订单展示
    public function allShow(Request $request)
    {
        $dayWeek = Carbon::parse(date('Y-m-d'))->dayOfWeek;//获取今天是周几
        //获取本周是今年第几周
        $date = new \DateTime;
        $weekOfYear = date_get_week_number($date);
        if ($dayWeek==7 || $dayWeek === 0){$weekOfYear = date_get_week_number($date)-1;}
        $sid = $request->sid?$request->sid:'';
        $sdate = $request->date?$request->date:'';
        $uname = $request->uname?$request->uname:'';
        $name = $request->name?$request->name:'';
        $start = 1;
        $end = 1;
        $where = [];
        if ($uname){
            $id = DB::table('users')->select('uid')->where(['uname'=>$uname])->get();
            $uid = $id[0]->uid;
            array_push($where,['o.uid','=',$uid]);
        }
        if ($name){
            $id = DB::table('users')->select('uid')->where('realname','like',"%$name%")->get();
            $uid = $id[0]->uid;
            array_push($where,['o.uid','=',$uid]);
        }

        !empty($request->sid)?array_push($where,['o.sid','=',$request->sid]): array_push($where,['o.sid','!=',0]);
        if ($request->date){
            $start = substr($request->date,0,10);
            $end = substr($request->date,-10);
            $order = DB::table('orders as o')->leftJoin('shops as s','o.sid','=','s.sid')->join('types as t','t.tmark','=','o.tmark')->orderBy('date')->whereBetween('date',[$start,$end])->where($where)->where('ostate','=',1)->paginate(20);

        } else {

            $order = DB::table('orders as o')->leftJoin('shops as s','o.sid','=','s.sid')->join('types as t','t.tmark','=','o.tmark')->orderBy('date')->where($where)->where('ostate','=',1)->paginate(20);

        }

        $food = DB::table('foods')->select(['fid','fname'])->get()->toArray();
        $shop = DB::table('shops')->get()->where('sid','!=',0)->toArray();
        $user = DB::table('users')->get()->toArray();

        return view('admin.order.allOrder', ['order'=>$order, 'food'=>$food,'user'=>$user,'thisWeek'=>$weekOfYear,'shop'=>$shop,'sid'=>$sid,'date'=>$sdate,'start'=>$start,'end'=>$end,'uname'=>$uname,'name'=>$name]);
    }


    //商家获取自己的订单列表
    public function myOrder(Request $request)
    {
        $dayWeek = Carbon::parse(date('Y-m-d'))->dayOfWeek;//获取今天是周几
        $realname = Auth::user()->realname;
        $where['sname'] = $realname;
        //获取本周是今年第几周
        $date = new \DateTime;
        $weekOfYear = date_get_week_number($date);
        if ($dayWeek==7 || $dayWeek === 0){$weekOfYear = date_get_week_number($date)-1;}
        $where['week_of_year'] = $weekOfYear;
        $where['year'] = date('Y',time());
        $where['ostate'] = 1;
        $orderBy = ' o.uid ';

        $sdate = $request->date?$request->date:'';
        $tmark = $request->tmark?$request->tmark:'';
        $start = '';
        $end = '';

        if ($request->start&&$request->end){
            unset($where['week_of_year']);
            $start = $request->start;
            $end = $request->end;
            $where[] = ['date','>=',$start];
            $where[] = ['date','<=',$end];
            $orderBy = ' o.date ';
        }

        if ($request->tmark&&$request->date){
            $where[]= ['o.tmark','=',$request->tmark];
            $orderBy = ' o.date ';
        }

        if($request->tmark&& !$request->date){
            $where[] = ['o.tmark','=',$request->tmark];
            $orderBy = ' o.uid ';
        }
        $order = DB::table('orders as o')->leftJoin('shops as s','o.sid','=','s.sid')->join('types as t','t.tmark','=','o.tmark')->where($where)->orderBy('o.uid')->orderBy('o.tmark')->paginate(20);


        $food = DB::table('foods')->select(['fid','fname'])->get()->toArray();
        $type = DB::table('types')->get()->toArray();
        $user = DB::table('users')->get()->toArray();

        return view('admin.order.myorder', ['order'=>$order, 'food'=>$food,'user'=>$user,'thisWeek'=>$weekOfYear,'type'=>$type,'tmark'=>$tmark,'date'=>$sdate,'start'=>$start,'end'=>$end]);

    }
    //商家导出自己的excel


    public function shopExport(Request $request)
    {
        $dayWeek = Carbon::parse(date('Y-m-d'))->dayOfWeek;//获取今天是周几
        $realname = Auth::user()->realname;
        $start = $request->route('start');
        $end = $request->route('end');

        if ($start==1 && $end==1 || $start == 0 || $end == 0){
            $excelName = '本周订单';
            $date = new \DateTime;
            $weekOfYear = date_get_week_number($date);
            if ($dayWeek==7 || $dayWeek === 0){$weekOfYear = date_get_week_number($date)-1;}

            $order = DB::table('orders as o')->leftJoin('shops as s','o.sid','=','s.sid')->join('types as t','t.tmark','=','o.tmark')->join('users as u','u.uid','=','o.uid')->where(['week_of_year'=>$weekOfYear,'sname'=>$realname,'ostate'=>1])->get()->toArray();
        } else {
            $excelName = substr($start,0,10).' 到 '.substr($end,0,10).' 的订单';
            $order = DB::table('orders as o')->leftJoin('shops as s','o.sid','=','s.sid')->join('types as t','t.tmark','=','o.tmark')->join('users as u','u.uid','=','o.uid')->orWhereBetween('date',[$start,$end])->where(['ostate'=>1,'sname'=>$realname])->get()->toArray();
        }

        $cellData[0] = ['用户编号','商家','食物','订单类型','订单时间','价格',];
        foreach ($order as $item) {
            array_push($cellData,[$item->uname,$item->sname,$item->food,$item->tname,$item->date,$item->total]);
        }
        //dd($cellData);
        Excel::create($excelName,function($excel) use ($cellData){
            $excel->sheet('order', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');
    }

    //订单统计
    public function dayOrder(Request $request)
    {
        $dayWeek = Carbon::parse(date('Y-m-d'))->dayOfWeek;//获取今天是周几
        $state = Auth::user()->state;
        $sname = Auth::user()->realname;

        //获取本周是今年第几周
        $date = new \DateTime;
        $weekOfYear = date_get_week_number($date);
        if ($dayWeek==7 || $dayWeek === 0){$weekOfYear = date_get_week_number($date)-1;}
        $where['week_of_year'] = $weekOfYear;
        $sdate = $request->date?$request->date:' ';
        $edate = $request->dates?$request->dates:' ';
        $tdate = $request->dates?$request->date.'到'.$request->dates:'本周';
        $sid = $request->sid?$request->sid:'';

        $where = " week_of_year = $weekOfYear and ostate=1 and year=".date('Y',time());

        $start = '';
        $end = '';
        if ($request->date){
            $start = $request->date;
            $end = $request->dates;
            $where = " `date`>='$start' AND `date`<='$end' and ostate=1 ";
        }
        if ($state == 4){
            $sid = DB::table('shops')->select('sid')->where('sname','=',$sname)->get();
            $where .= " and o.sid={$sid[0]->sid} ";
        }
        if ($request->sid){
            $where .= " and o.sid = $sid ";
        }
        if ($request->company){
            $where .= " and u.company = $request->company ";
        }
        $shop = DB::table('shops')->get()->where('sid','!=',0)->toArray();
        $dayOrder = DB::select("select count(o.oid) as num,sum(o.total) as total,s.sname,o.sid from orders as o LEFT JOIN shops as s ON s.sid=o.sid JOIN users as u ON u.uid=o.uid where {$where}  GROUP BY o.sid");

        return view('admin.order.dayOrder',['dayOrder'=>$dayOrder,'shop'=>$shop, 'date'=>$sdate,'dates'=>$edate,'start'=>$start,'end'=>$end,'sid'=>$sid,'tdate'=>$tdate,'company'=>$request->company,]);
    }

    //处理早餐订单订单为分类统计
    public function countBySort()
    {
        ////获取本周是今年第几周
        $state = Auth::user()->state;
        if ($state==3){
            $sid = '';
            $date = date('Y-m-d',time());//获取今天天日期
            $edate = date('Y-m-d',time()+86400);//获取明天天日期

            $today_order = DB::table('orders')->where(['date'=>$date,'sid'=>4,'ostate'=>1])->get()->toArray();
            $today_order7 = DB::table('orders')->where(['date'=>$date,'sid'=>7,'ostate'=>1])->get()->toArray();
            $next_order = DB::table('orders')->where(['date'=>$edate,'sid'=>4,'ostate'=>1])->get()->toArray();
            $next_order7 = DB::table('orders')->where(['date'=>$edate,'sid'=>7,'ostate'=>1])->get()->toArray();
            $food_arr_today = [];
            foreach ($today_order as $o) {
                $food_arr_tmp = explode('+',$o->food);
                foreach ($food_arr_tmp as $f) {
                    array_push($food_arr_today,$f);
                }
            }
            $food_arr_today7 = [];
            foreach ($today_order7 as $o) {
                $food_arr_tmp7 = explode('+',$o->food);
                foreach ($food_arr_tmp7 as $f) {
                    array_push($food_arr_today7,$f);
                }
            }

            $food_arr_next = [];
            foreach ($next_order as $o) {
                $food_arr_tmp = explode('+',$o->food);
                foreach ($food_arr_tmp as $f) {
                    array_push($food_arr_next,$f);
                }
            }

            $food_arr_next7 = [];
            foreach ($next_order7 as $o) {
                $food_arr_tmp7 = explode('+',$o->food);
                foreach ($food_arr_tmp7 as $f) {
                    array_push($food_arr_next7,$f);
                }
            }

            $food_count_today = array_count_values($food_arr_today);
            $food_count_today7 = array_count_values($food_arr_today7);
            $food_count_next7 = array_count_values($food_arr_next7);
            $food_count_next = array_count_values($food_arr_next);

            return view('admin.order.countbysort',['food_count_today'=>$food_count_today,'food_count_next'=>$food_count_next,'food_count_today7'=>$food_count_today7,'food_count_next7'=>$food_count_next7]);
        }elseif($state==4){
            $sname = Auth::user()->realname;
            $sidObj = DB::table('shops')->where(['sname'=>$sname])->get();
            $sid = $sidObj[0]->sid;
            $date = date('Y-m-d',time());//获取今天天日期
            $edate = date('Y-m-d',time()+86400);//获取明天天日期

            $today_order = DB::table('orders')->where(['date'=>$date,'sid'=>$sid,'ostate'=>1])->get()->toArray();
            $next_order = DB::table('orders')->where(['date'=>$edate,'sid'=>$sid,'ostate'=>1])->get()->toArray();
            $food_arr_today = [];
            foreach ($today_order as $o) {
                $food_arr_tmp = explode('+',$o->food);
                foreach ($food_arr_tmp as $f) {
                    array_push($food_arr_today,$f);
                }
            }

            $food_arr_next = [];
            foreach ($next_order as $o) {
                $food_arr_tmp = explode('+',$o->food);
                foreach ($food_arr_tmp as $f) {
                    array_push($food_arr_next,$f);
                }
            }

            $food_count_today = array_count_values($food_arr_today);
            $food_count_next = array_count_values($food_arr_next);

            return view('admin.order.countbysort',['food_count_today'=>$food_count_today,'food_count_next'=>$food_count_next]);
        }

    }
    
    //批量取消本周订单 todo
    public function cancelOrder(Request $request)
    {
        $tmark = $request->tmark;
        $tmarkArr = [
            'A'=>1,
            'B'=>1,
            'C'=>1,
            'D'=>2,
            'E'=>2,
            'F'=>2,
            'G'=>3,
            'H'=>3,
            'I'=>3,
            'J'=>4,
            'K'=>4,
            'L'=>4,
            'M'=>5,
            'N'=>5,
            'O'=>5,
            'P'=>6,
            'Q'=>6,
            'R'=>6,
            'S'=>0,
            'T'=>0,
            'U'=>0,
        ];
        $morningArr = ['A','D','G','J','M','P','S',];
        $noonArr    = ['B','E','H','K','N','Q','T',];
        $eveningArr = ['C','F','I','L','O','R','U',];
        $dayWeek = Carbon::parse(date('Y-m-d'))->dayOfWeek;//获取今天是周几
        $today = date('Y-m-d');//获取今天日期
        $time_now = date('His',time());
        switch ($dayWeek){
            case '1':
                if ($tmark=='A'||$tmark=='B'||$tmark=='C'){$date=$today;}
                if ($tmark=='D'||$tmark=='E'||$tmark=='F'){$date=date("Y-m-d",strtotime("+1 day"));}
                if ($tmark=='G'||$tmark=='H'||$tmark=='I'){$date=date("Y-m-d",strtotime("+2 day"));}
                if ($tmark=='J'||$tmark=='K'||$tmark=='L'){$date=date("Y-m-d",strtotime("+3 day"));}
                if ($tmark=='M'||$tmark=='N'||$tmark=='O'){$date=date("Y-m-d",strtotime("+4 day"));}
                if ($tmark=='P'||$tmark=='Q'||$tmark=='R'){$date=date("Y-m-d",strtotime("+5 day"));}
                if ($tmark=='S'||$tmark=='T'||$tmark=='U'){$date=date("Y-m-d",strtotime("+6 day"));}
                break;
            case '2':
                if ($tmark=='D'||$tmark=='E'||$tmark=='F'){$date=$today;}
                if ($tmark=='G'||$tmark=='H'||$tmark=='I'){$date=date("Y-m-d",strtotime("+1 day"));}
                if ($tmark=='J'||$tmark=='K'||$tmark=='L'){$date=date("Y-m-d",strtotime("+2 day"));}
                if ($tmark=='M'||$tmark=='N'||$tmark=='O'){$date=date("Y-m-d",strtotime("+3 day"));}
                if ($tmark=='P'||$tmark=='Q'||$tmark=='R'){$date=date("Y-m-d",strtotime("+4 day"));}
                if ($tmark=='S'||$tmark=='T'||$tmark=='U'){$date=date("Y-m-d",strtotime("+5 day"));}
                break;
            case '3':
                if ($tmark=='G'||$tmark=='H'||$tmark=='I'){$date=$today;}
                if ($tmark=='J'||$tmark=='K'||$tmark=='L'){$date=date("Y-m-d",strtotime("+1 day"));}
                if ($tmark=='M'||$tmark=='N'||$tmark=='O'){$date=date("Y-m-d",strtotime("+2 day"));}
                if ($tmark=='P'||$tmark=='Q'||$tmark=='R'){$date=date("Y-m-d",strtotime("+3 day"));}
                if ($tmark=='S'||$tmark=='T'||$tmark=='U'){$date=date("Y-m-d",strtotime("+4 day"));}
            break;
            case '4':
                if ($tmark=='J'||$tmark=='K'||$tmark=='L'){$date=$today;}
                if ($tmark=='M'||$tmark=='N'||$tmark=='O'){$date=date("Y-m-d",strtotime("+1 day"));}
                if ($tmark=='P'||$tmark=='Q'||$tmark=='R'){$date=date("Y-m-d",strtotime("+2 day"));}
                if ($tmark=='S'||$tmark=='T'||$tmark=='U'){$date=date("Y-m-d",strtotime("+3 day"));}
            break;
            case '5':
                if ($tmark=='M'||$tmark=='N'||$tmark=='O'){$date=$today;}
                if ($tmark=='P'||$tmark=='Q'||$tmark=='R'){$date=date("Y-m-d",strtotime("+1 day"));}
                if ($tmark=='S'||$tmark=='T'||$tmark=='U'){$date=date("Y-m-d",strtotime("+2 day"));}
            break;
            case '6':
                if ($tmark=='P'||$tmark=='Q'||$tmark=='R'){$date=$today;}
                if ($tmark=='S'||$tmark=='T'||$tmark=='U'){$date=date("Y-m-d",strtotime("+1 day"));}
            break;
            case '7':
                if ($tmark=='S'||$tmark=='T'||$tmark=='U'){$date=$today;}
            break;
            case '0':
                if ($tmark=='S'||$tmark=='T'||$tmark=='U'){$date=$today;}
            break;

        }
//if($time_now>1){
//    $returnArr = ['msg'=>(in_array($tmark,$morningArr)),'code'=>300];
//    return json_encode($returnArr);
//}
        /*
         * 周日的$dayWeek值为0, 所以以下判断都是基于此.(周日去取消周一到周六的餐的操作, 在这里不会有判断, 也不会有返回值, 在前台直接返回error函数的内容)
         * */
        if($tmarkArr[$tmark]<$dayWeek && $dayWeek!=0 && $tmarkArr[$tmark]!=0){//所有在今天之前的订单都不能取消(周一到周六的操作)
            //不能取消
            $returnArr = ['msg'=>'时间已过无法取消1','code'=>300];
            return json_encode($returnArr);
        }elseif ($tmarkArr[$tmark]==$dayWeek){//当天的和周日,按今天三餐时间判断是否能够取消(周日的操作只走这里)
            //分时段
            if ($time_now<103000 && in_array($tmark,$noonArr)){
                //取消中午订餐
                $where = ['tmark'=>$tmark,'date'=>$date];
                DB::table('orders')->where($where)->update(['ostate'=>2]);
                $returnArr = ['msg'=>'取消成功..','code'=>200];
                return json_encode($returnArr);
            }elseif ($time_now<163000 && in_array($tmark,$eveningArr)){
                //取消晚上订餐
                $where = ['tmark'=>$tmark,'date'=>$date];
                DB::table('orders')->where($where)->update(['ostate'=>2]);
                $returnArr = ['msg'=>'取消成功...','code'=>200];
                return json_encode($returnArr);
            }elseif($time_now<070000 && in_array($tmark,$morningArr)){
                //取消早上订餐
                $where = ['tmark'=>$tmark,'date'=>$date];
                DB::table('orders')->where($where)->update(['ostate'=>2]);
                $returnArr = ['msg'=>'取消成功.','code'=>200];
                return json_encode($returnArr);
            }else{
                //不能取消
                $returnArr = ['msg'=>'时间已过无法取消2','code'=>300];
                return json_encode($returnArr);
            }

        }elseif ($tmarkArr[$tmark]>$dayWeek && $dayWeek!=0){//除周日外, 大于今天的都可以取消
            //取消订餐
            $where = ['tmark'=>$tmark,'date'=>$date];
            DB::table('orders')->where($where)->update(['ostate'=>2]);
            $returnArr = ['msg'=>'取消成功','code'=>200];
            return json_encode($returnArr);
        }elseif($dayWeek!=0 && $tmark==0){//所有周日之前的都可以取消周日的(操作周日的)
            //取消订餐
            $where = ['tmark'=>$tmark,'date'=>$date];
            DB::table('orders')->where($where)->update(['ostate'=>2]);
            $returnArr = ['msg'=>'取消成功','code'=>200];
            return json_encode($returnArr);
        }
    }

    //获取兄弟公司订单
    public function getCompanyOrder(Request $request)
    {
        $dayWeek = Carbon::parse(date('Y-m-d'))->dayOfWeek;//获取今天是周几
        //获取本周是今年第几周
        $date = new \DateTime;
        $weekOfYear = date_get_week_number($date);
        if ($dayWeek==7 || $dayWeek === 0){$weekOfYear = date_get_week_number($date)-1;}
        $where = ['o.week_of_year'=>$weekOfYear,'o.year'=>date('Y',time())];
        $orderBy = 'o.uid';
        if ($request->tmark){
            $where['o.tmark'] = $request->tmark;
            $orderBy = 'o.uid';
        }
        if ($request->sid){
            $where['o.sid'] = $request->sid;
        }
        $rdate = $request->input('date');
        $tmark = $request->tmark?$request->tmark:'';
        $sid = $request->sid?$request->sid:'';
        $query = DB::table('orders as o');
        $order = $query
            ->leftJoin('users as u','o.uid','=','u.uid')
            ->where($where)->where('ostate','=',1)
            ->whereIn('u.company',[2,3])
            ->when($rdate,function ($query) use ($rdate){
                $start = substr($rdate,0,10);
                $end = substr($rdate,-10);
                return $query->whereBetween('date',[$start,$end]);
            })
            ->orderBy($orderBy)
            ->paginate(20);
        //类别
        $type = DB::table('types')->get()->toArray();
        foreach ($type as $t) {
            $types[$t->tmark] = $t->tname;
        }
        //商家搜索条件
        $shop = DB::table('shops')->get()->where('sid','!=',0)->toArray();
        foreach ($shop as $s) {
            $shops[$s->sid] = $s->sname;
        }
        //用户名
        $user = DB::table('users')->get()->toArray();
        return view('admin.order.companyOrder', ['order'=>$order,'user'=>$user,'thisWeek'=>$weekOfYear,'type'=>$type,'types'=>$types,'shop'=>$shop,'tmark'=>$tmark,'sid'=>$sid,'shops'=>$shops,'rdate'=>$rdate,]);
    }
}
