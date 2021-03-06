<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class HomeController extends Controller
{
    protected $max_drink = 4;
    protected $day_type = [
            1=>['A','B','C'],
            2=>['D','E','F'],
            3=>['G','H','I'],
            4=>['J','K','L'],
            5=>['M','N','O'],
            6=>['P','Q','R'],
            7=>['S','T','U'],
            0=>['S','T','U'],
        ];
    protected $time_type = [
        'A'=>1,'D'=>1,'G'=>1,'J'=>1,'M'=>1,'P'=>1,'S'=>1,
        'B'=>2,'E'=>2,'H'=>2,'K'=>2,'N'=>2,'Q'=>2,'T'=>2,
        'C'=>3,'F'=>3,'I'=>3,'L'=>3,'O'=>3,'R'=>3,'U'=>3,
    ];
    protected $week_type = [
        'A'=>1,'D'=>2,'G'=>3,'J'=>4,'M'=>5,'P'=>6,'S'=>0,
        'B'=>1,'E'=>2,'H'=>3,'K'=>4,'N'=>5,'Q'=>6,'T'=>0,
        'C'=>1,'F'=>2,'I'=>3,'L'=>4,'O'=>5,'R'=>6,'U'=>0,
    ];
    protected $week_name = [
        'A'=>'星期一早上','D'=>'星期二早上','G'=>'星期三早上','J'=>'星期四早上','M'=>'星期五早上','P'=>'星期六早上','S'=>'星期天早上',
        'B'=>'星期一中午','E'=>'星期二中午','H'=>'星期三中午','K'=>'星期四中午','N'=>'星期五中午','Q'=>'星期六中午','T'=>'星期天中午',
        'C'=>'星期一晚上','F'=>'星期二晚上','I'=>'星期三晚上','L'=>'星期四晚上','O'=>'星期五晚上','R'=>'星期六晚上','U'=>'星期天晚上',
    ];
    protected $money_limited = [];
    //获得本周日期
    protected $day_add = [
        1=>['A'=>0,'D'=>1,'G'=>2,'J'=>3,'M'=>4,'P'=>5,'S'=>6,
        'B'=>0,'E'=>1,'H'=>2,'K'=>3,'N'=>4,'Q'=>5,'T'=>6,
        'C'=>0,'F'=>1,'I'=>2,'L'=>3,'O'=>4,'R'=>5,'U'=>6,],
        2=>['D'=>0,'G'=>1,'J'=>2,'M'=>3,'P'=>4,'S'=>5,
        'E'=>0,'H'=>1,'K'=>2,'N'=>3,'Q'=>4,'T'=>5,
        'F'=>0,'I'=>1,'L'=>2,'O'=>3,'R'=>4,'U'=>5,],
        3=>['G'=>0,'J'=>1,'M'=>2,'P'=>3,'S'=>4,
        'H'=>0,'K'=>1,'N'=>2,'Q'=>3,'T'=>4,
        'I'=>0,'L'=>1,'O'=>2,'R'=>3,'U'=>4,],
        4=>['J'=>0,'M'=>1,'P'=>2,'S'=>3,
        'K'=>0,'N'=>1,'Q'=>2,'T'=>3,
        'L'=>0,'O'=>1,'R'=>2,'U'=>3,],
        5=>['M'=>0,'P'=>1,'S'=>2,
        'N'=>0,'Q'=>1,'T'=>2,
        'O'=>0,'R'=>1,'U'=>2,],
        6=>['P'=>0,'S'=>1,
        'Q'=>0,'T'=>1,
        'R'=>0,'U'=>1,],
        0=>['S'=>0,
        'T'=>0,
        'U'=>0,],
        7=>['S'=>0,
        'T'=>0,
        'U'=>0,]
    ];
    //获得下周日期
    protected $day_add_nextweek = [
        0=>['A'=>1,'D'=>2,'G'=>3,'J'=>4,'M'=>5,'P'=>6,'S'=>7,
            'B'=>1,'E'=>2,'H'=>3,'K'=>4,'N'=>5,'Q'=>6,'T'=>7,
            'C'=>1,'F'=>2,'I'=>3,'L'=>4,'O'=>5,'R'=>6,'U'=>7,],
        5=>['A'=>3,'D'=>4,'G'=>5,'J'=>6,'M'=>7,'P'=>8,'S'=>9,
            'B'=>3,'E'=>4,'H'=>5,'K'=>6,'N'=>7,'Q'=>8,'T'=>9,
            'C'=>3,'F'=>4,'I'=>5,'L'=>6,'O'=>7,'R'=>8,'U'=>9,],
        6=>['A'=>2,'D'=>3,'G'=>4,'J'=>5,'M'=>6,'P'=>7,'S'=>8,
            'B'=>2,'E'=>3,'H'=>4,'K'=>5,'N'=>6,'Q'=>7,'T'=>8,
            'C'=>2,'F'=>3,'I'=>4,'L'=>5,'O'=>6,'R'=>7,'U'=>8,],
        7=>['A'=>1,'D'=>2,'G'=>3,'J'=>4,'M'=>5,'P'=>6,'S'=>7,
            'B'=>1,'E'=>2,'H'=>3,'K'=>4,'N'=>5,'Q'=>6,'T'=>7,
            'C'=>1,'F'=>2,'I'=>3,'L'=>4,'O'=>5,'R'=>6,'U'=>7,],
    ];
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $weekOfYear = date('W',time());//获取本周是今年的第几周, 每周从周一开始,
        //dd(Carbon::parse(date('Y-m-d',time())));
        $fmods = fmod($weekOfYear,2);
        $dayWeek = Carbon::parse(date('Y-m-d',time()))->dayOfWeek;//获取今天是周几
        $food = DB::table('foods')->orderBy('price','desc')->where('fstate','=',1)->get();
        $shop = DB::table('shops')->where('state','!=',2)->get()->toArray();
        foreach ($shop as $k=>$v) {
            $shop[$k]->companys = json_decode($v->companys,true);
        }
        $menu = DB::table('menus')->where(['mweek'=>1,'mstate'=>1])->get()->toArray();
        $time_limited = DB::table('time_limited')->get()->toArray();

        foreach ($menu as &$v) {
            $v->food = explode(',',trim($v->fid,','));
        }
        if ($fmods==1){
            $limit = 21;
        }else{
            $limit = 21;//双休，周日点餐需要修改这limit,为21
        }
        $type = DB::table('types')->limit($limit)->get();

        return view('home', ['menu' => $menu, 'food' => $food, 'shop' => $shop, 'dayWeek' => $dayWeek,'type'=>$type,'fmods'=>$fmods,'timelimited'=>$time_limited,'max_drink'=>$this->max_drink]);
    }

    public function upd(Request $request)
    {
        if(Auth::user()->state==2){die('您已被禁止访问,请联系管理员~');}
        $dayWeek = Carbon::parse(date('Y-m-d',time()))->dayOfWeek;//获取今天是周几

        //获取每天禁止点餐时间
        $time_limited = DB::table('time_limited')->get()->toArray();
        $t_limit = [];
        foreach ($time_limited as $item) {
            $t_limit[$item->time_mark] = $item->time_limited;//  [1 => "07:00"]
        }

        //获取商家，并构建商家限额数组
        $sop = DB::table('shops')->where('state','!=',2)->get();
        foreach ($sop as $item) {
            $money_limit[$item->sid] = $item->limit_money;
        }

        $weekOfYear = date('W',time());
        $data['uid'] = Auth::user()->uid;
        $data['cid'] = Auth::user()->company;
        $data['uname'] = $uname = Auth::user()->uname;
        $data['total'] = 0;
        $data['food'] = '';
//        $data['created_at'] = date('Y-m-d H:i:s');
        $data['week_of_year'] = $weekOfYear;

        if (isset($request->shop)){
            foreach ($request->shop as $mark=>$shop) {
                if ($shop == 0){
                    $res = DB::table('orders')->where(['tmark'=>$mark,'week_of_year'=>$weekOfYear,'uid'=>$data['uid'],'ostate'=>1, 'year'=>date('Y',time())])->get()->toArray();
                    //取消点餐
                    DB::table('orders')->where(['uid'=>$data['uid'],'tmark'=>$mark,'week_of_year'=>$weekOfYear,'year'=>date('Y',time())])->update(['ostate'=>2,'delete_at'=>date('Y-m-d H:i:s',time())]);
                }
            }
        }

        $fail_tmark = [];//失败加锁导致的点餐
        if (isset($request->order)){
            $dayWeek = Carbon::parse(date('Y-m-d',time()))->dayOfWeek;//获取今天是周几
            $today = date('Y-m-d');//获取今天日期


            foreach ($request->order as $key=>$item) {
                $data['tmark'] = $key;
                $data['date']=date("Y-m-d",strtotime("+".$this->day_add[$dayWeek][$key]." day"));

                if (is_array($item)){
                    $m=0; //用于判断是否同一餐点了2家餐厅
                    $sid = '';
                    foreach ($item as $k=>$v) {
                        $data['sid'] = $k;
                        $drink = 0;
                        foreach ($v as $fid=>$price) {
                            $re = DB::table('foods')->where('fid','=',$fid)->get()->toArray();
                            if ($re[0]->ftype==3){
                                $drink ++;
                                if ($drink >$this->max_drink){
                                    return redirect('home/show')->with(['error_msg'=>$this->week_name[$data['tmark']].'开始点的餐都失败了哦，每餐不能点超过2个饮料']);
                                }
                            }
                            if ($m>0){
                                if ($sid != $re[0]->sid){
                                    return redirect('home/showNextWeek')->with(['error_msg'=>'同一餐不能同时点2家哦！']);
                                };
                            }
                            $sid = $re[0]->sid;
                            $data['food'] .= $re[0]->fname.'+';
                            $data['total'] += $price;
                        }
                        $m++;
                    }
                }


                // 判断点餐时间是否超时
                if ($dayWeek == $this->week_type[$data['tmark']]  &&  time() > strtotime($t_limit[$this->time_type[$data['tmark']]]) ){
                    return redirect('home/show')->with(['error_msg'=>'点餐失败，超过点餐时限']);
                }elseif($dayWeek > $this->week_type[$data['tmark']] && $this->week_type[$data['tmark']] != 0){//排除周日的
                    return redirect('home/show')->with(['error_msg'=>'点餐失败，不能点今天之前的餐']);
                }

                //判断点餐金额是否超额度 todo
                if ($money_limit[$data['sid']]<$data['total']){
                    return redirect('home/show')->with(['error_msg'=>'点餐失败，点餐金额超过限额']);
                }

                $data['food'] = trim($data['food'],'+');
                $data['year'] = date('Y',time());
                $res = DB::table('orders')->where(['tmark'=>$data['tmark'],'week_of_year'=>$weekOfYear,'uid'=>$data['uid'],'ostate'=>1, 'year'=>date('Y',time()),'date'=>$data['date']])->get()->toArray();



                $redis_key  = $data['uname'].'_'.$data['tmark'];

                //加锁，避免重复
                $r_get = Redis::setnx($redis_key, 'live');

                if ($r_get){
                    $redis_res = Redis::expire($redis_key,  '5');//加锁5秒不能重复点，防止重复订单
                }else{
                    $fail_tmark[] = $data['tmark'];
                    $data['total'] = 0;
                    $data['food'] = '';
                    continue;
                }

                if ($res){
                    DB::table('orders')->where('oid','=',$res[0]->oid)->update($data);
                } else {
                    DB::table('orders')->insert($data);
                }
                $data['total'] = 0;
                $data['food'] = '';
            }
        }

        $msg_err = '';
        if ($fail_tmark){
            foreach ($fail_tmark as $v)
            $msg_err .= $this->week_name[$v].',';
        }

        if ($msg_err){
            return redirect('home/show')->with(['error_msg'=>$msg_err.'可能点餐失败，请自行查看，若已成功，请忽略']);
        }else{
            return redirect('home/show')->with(['message'=>'点餐成功']);
        }

    }

    public function show()
    {
        $uid = Auth::user()->uid;
        //获取本周是今年第几周
        $weekOfYear = date('W',time());
        $year = date('Y',time());
        $order = DB::table('orders')->where(['week_of_year'=>$weekOfYear,'uid'=>$uid, 'year'=>$year])->where('ostate','=',1)->get()->toArray();
        $type = DB::table('types')->get()->toArray();
        return view('show',['order'=>$order,'type'=>$type]);
    }

    public function nextWeekIndex()
    {
        //$date = new \DateTime;
        //$weekOfYear = date_get_week_number($date) +1;
        $weekOfYear = date('W',time())+1;
        $fmods = fmod($weekOfYear,2);

        $dayWeek = Carbon::parse(date('Y-m-d',time()))->dayOfWeek;//获取今天是周几
        $food = DB::table('foods')->orderBy('price','desc')->where('fstate','=',1)->get();
        $shop = DB::table('shops')->where('state','!=',2)->get()->toArray();
        foreach ($shop as $k=>$v) {
            $shop[$k]->companys = json_decode($v->companys,true);
        }
        $menu = DB::table('menus')->where(['mweek'=>2,'mstate'=>1])->get()->toArray();
        foreach ($menu as &$v) {
            $v->food = explode(',',trim($v->fid,','));
        }
        if ($fmods==1){
            $limit = 21; //双休
        }else{
            $limit = 21;
        }
        $type = DB::table('types')->limit($limit)->get();

        return view('nextweek', ['menu' => $menu, 'food' => $food, 'shop' => $shop, 'dayWeek' => $dayWeek,'type'=>$type,'fmods'=>$fmods,'max_drink'=>$this->max_drink]);
    }

    public function updNextWeek(Request $request)
    {
        if(Auth::user()->state==2){die('您已被禁止访问,请联系管理员~');}
        $dayWeek = Carbon::parse(date('Y-m-d',time()))->dayOfWeek;//获取今天是周几
        if($dayWeek == 1 || $dayWeek==2 || $dayWeek==3 || $dayWeek==4){
            die('现在不能点下周的餐哦~');
        }
        $weekOfYear = date('W',time());
        $data['uid'] = Auth::user()->uid;
        $data['cid'] = Auth::user()->company;
        $data['uname'] = $uname = Auth::user()->uname;
        $data['total'] = 0;
        $data['food'] = '';
        $data['week_of_year'] = $weekOfYear + 1;// 设置周数为下周*
        //if ($dayWeek==7 || $dayWeek==0){$data['week_of_year'] = $weekOfYear;}//周日是新一周的开始
        //判断是否取消订餐
        if (isset($request->shop)){
            foreach ($request->shop as $mark=>$shop) {
                //取消点餐
                if ($shop == 0){
                    if (!empty($res)){
                        // 都城早餐--周日特殊处理。
                        if ($this->time_type[$mark]==1 && $dayWeek == 6 &&  $this->week_type[$mark] == 0 ){
                             if ($res[0]->sid == '16'){
                                if (strtotime(date('Y-m-d 13:00:00')) < time()){
                                    return redirect('home/show')->with(['error_msg'=>'别闹，超过点餐时限你没法取消都城早餐']);
                                }
                            }
                        }
                    }
                    $res=DB::table('orders')->where(['uid'=>$data['uid'],'tmark'=>$mark,'week_of_year'=>$data['week_of_year'],'year'=>date('Y',time())])->update(['ostate'=>2,'delete_at'=>date('Y-m-d H:i:s',time())]);
                }
            }
        }
        //获取商家，并构建商家限额数组
        $sop = DB::table('shops')->where('state','!=',2)->get();
        foreach ($sop as $item) {
            $money_limit[$item->sid] = $item->limit_money;
        }

        if (isset($request->order)){
            $dayWeek = Carbon::parse(date('Y-m-d',time()))->dayOfWeek;//获取今天是周几

            $fail_tmark = [];//加锁导致失败的点餐

            foreach ($request->order as $key=>$item) {
                $data['tmark'] = $key;
                $data['date']=date("Y-m-d",strtotime("+".$this->day_add_nextweek[$dayWeek][$key]." day"));
                if (is_array($item)){
                    $m = 0;
                    $sid = '';
                    foreach ($item as $k=>$v) {
                        $data['sid'] = $k;
                        $drink = 0;
                        foreach ($v as $fid=>$price) {
                            $re = DB::table('foods')->where('fid','=',$fid)->get()->toArray();
                            if ($re[0]->ftype==3){
                                $drink ++;
                                if ($drink > $this->max_drink){
                                    return redirect('home/showNextWeek')->with(['error_msg'=>$this->week_name[$data['tmark']].'开始点的餐都失败了哦，每餐不能点超过2个饮料']);
                                }
                            }
                            if ($m>0){
                                if ($sid != $re[0]->sid){
                                    return redirect('home/showNextWeek')->with(['error_msg'=>'同一餐不能同时点2家哦！']);
                                };
                            }
                            $sid = $re[0]->sid;
                            $data['food'] .= $re[0]->fname.'+';
                            $data['total'] += $price;
                        }
                        $m++;
                    }
                }
                //判断点餐金额是否超额度 todo
                if ($money_limit[$data['sid']] < $data['total']){
                    return redirect('home/showNextWeek')->with(['error_msg'=>'点餐失败，点餐金额超过限额']);
                }

                $data['food'] = trim($data['food'],'+');
                $data['year'] = date('Y',time());
                $res = DB::table('orders')->where(['tmark'=>$data['tmark'],'week_of_year'=>$data['week_of_year'],'uid'=>$data['uid'],'ostate'=>1,'date'=>$data['date']])->get()->toArray();


                $redis_key  = $data['uname'].'_nextweek_'.$data['tmark'];

                //加锁，避免重复
                $r_get = Redis::setnx($redis_key, 'live');

                if ($r_get){
                    $redis_res = Redis::expire($redis_key,  '5');//加锁5秒不能重复点，防止重复订单
                }else{
                    $fail_tmark[] = $data['tmark'];
                    $data['total'] = 0;
                    $data['food'] = '';
                    continue;
                }


                if ($res){
                    DB::table('orders')->where('oid','=',$res[0]->oid)->update($data);
                } else {
                    //$data['created_at'] = date('Y-m-d H:i:s',time());
                    DB::table('orders')->insert($data);
                }
                $data['total'] = 0;
                $data['food'] = '';
            }
        }

        $msg_err = '';
        if ($fail_tmark){
            foreach ($fail_tmark as $v)
            $msg_err .= $this->week_name[$v].',';
        }

        if ($msg_err){
            return redirect('home/showNextWeek')->with(['error_msg'=>$msg_err.'可能点餐失败，请自行查看，若已成功，请忽略']);
        }else{
            return redirect('home/showNextWeek')->with(['message'=>'点餐成功']);
        }
    }

    public function showNextWeek()
    {
        $uid = Auth::user()->uid;
        //获取本周是今年第几周
        $weekOfYear = date('W',time())+1;
        $fmods = fmod($weekOfYear,2);
        $year = date('Y',time());
        $order = DB::table('orders')->where(['week_of_year'=>$weekOfYear,'uid'=>$uid, 'year'=>$year])->where('ostate','=',1)->get()->toArray();
        $type = DB::table('types')->get()->toArray();
        return view('showNextWeek',['order'=>$order,'type'=>$type,'fmods'=>$fmods]);
    }

    public function jishubu()
    {
        $name = [16=>'何海平',17=>'闵小明',19=>'刘冠生',20=>'杨南峰',83=>'郭志昊',84=>'吴顺',96=>'姚秋号',130=>'李锦明',44=>'范文彬','158'=>'李志鹏','123'=>'王军',];
        $uname = array_keys($name);
        //获取本周是今年第几周
        $weekOfYear = date('W',time());
        $order = DB::table('orders')->where(['week_of_year'=>$weekOfYear,'year'=>date('Y',time())])->whereIn('uname',$uname)->where('ostate','=',1)->get()->toArray();
        $type = DB::table('types')->get()->toArray();
        return view('jishubu',['order'=>$order,'type'=>$type, 'name'=>$name, 'uname'=>$uname]);
    }
}
