<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function showTimeLimited()
    {
        $timeLimited = DB::table('time_limited')->get();
        return view('admin.setting.timelimited',['timeLimited'=>$timeLimited]);
    }
    public function timeLimitedAdd()
    {
        return view('admin.setting.add');
    }
    public function timeLimitedDoAdd(Request $request)
    {
        $data['time_mark'] = $request->time_mark;
        $data['time_limited'] = $request->time_limited;
        $re = DB::table('time_limited')->where(['time_mark'=>$data['time_mark']])->get();
        //dd($re);

        if (count($re)!=0){return redirect('admin/setting/timelimited')->with(['timeLimitedMsg'=>2]);}
        $res = DB::table('time_limited')->insert($data);
        $timeLimited = DB::table('time_limited')->get();
        if (!$res){
            return redirect('admin/setting/timelimited')->with(['timeLimitedMsg'=>2]);
        }
        return redirect('admin/setting/timelimited')->with(['timeLimitedMsg'=>1]);
    }
    public function timeLimitedEdit(Request $request)
    {
        $id = $request->route('id');
        $timeLimited = DB::table('time_limited')->find($id);
        return view('admin.setting.edit',['timeLimited'=>$timeLimited]);
    }
    public function timeLimitedDoEdit(Request $request)
    {
        $id = $request->id;
        $data['time_mark'] = $request->time_mark;
        $data['time_limited'] = $request->time_limited;
        $res = DB::table('time_limited')->where('id','=',$id)->update($data);
        if (!$res){ return redirect('admin/setting/timelimited')->with(['timeLimitedMsg'=>2]);}
        return redirect('admin/setting/timelimited')->with(['timeLimitedMsg'=>1]);
    }

    public function timeLimitedDel(Request $request)
    {
        return json_encode('别闹，不能删~',200);
        $id = $request->id;
        $res = DB::table('time_limited')->delete($id);
        if ($res){
            return json_encode('删除成功',200);
        }else{
            return json_encode('删除失败',300);
        }
    }
}
