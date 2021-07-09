<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    public function __construct(Request $request)
    {

        //dd($request->user());
        $this->middleware('auth');
    }
    public function show()
    {
        $date1 = date('Y-m-01',strtotime('last month'));
        $date2 = date('Y-m-d');
        $sql = "select uname,tmark,`date`,COUNT(*) co, total from orders WHERE ostate=1 AND date BETWEEN '{$date1}' AND '{$date2}' group by uname,tmark,`date` having co>1 ";
        $res = DB::select($sql);
        return view('admin.index.index',['repeat'=>$res]);
    }
}
