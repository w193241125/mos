<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(Request $request)
    {
        //dd($request->user());
        $this->middleware('auth');
    }

    public function show(Request $request)
    {
        $state = $request->input('state');
        $user = DB::table('users')
            ->when($state,function ($query) use ($state){
                return $query->where('state','=',$state);
            })
            ->orderBy('uid','desc')
            ->get();
        return view('admin.user.user',compact('user'));
    }

    public function add()
    {
        $uid = DB::table('users')->orderBy('uid','desc')->whereNotIn('state',[4])->first();
        if( is_numeric($uid->uname)){
            $uids = $uid->uname + 1;
        }else{
            $uids = substr($uid->uname,1) + 1;
            $uids = str_pad($uids,2,"0",STR_PAD_LEFT);
            $uids = $uid->uname[0].$uids;
        }
        return view('admin.user.add')->with('uid', $uids);
    }

    public function doadd(Request $request)
    {
        $data['uname'] = $request->uname;
        $data['company'] = $request->company;
        $data['realname'] = $request->realname;
        $password = $request->password?$request->password:'123456';
        $data['password'] = Hash::make($password);
        $data['state'] = $request->state;

        if ($data['state']==3 && Auth::user()->uname != 350){
            return redirect('admin/user')->with('userMsgErr','只有超级管理员才能设置管理员');
        }

        $res = DB::table('users')->insert($data);
        if ($res){
            return redirect('admin/user')->with('userMsg','操作成功！');
        }else {
            return redirect('admin/user')->with('userMsgErr','操作失败或未更改！');
        }
    }
    public function edit(Request $request)
    {
        $user = DB::table('users')->where('uid','=',$request->uid)->get()->toArray();
        return view('admin.user.edit',['user'=>$user[0]]);
    }

    public function doedit(Request $request)
    {
        $data['uname'] = $request->uname;
        $data['realname'] = $request->realname;
        $data['company'] = $request->company;
        $data['state'] = $request->state;
        if ($data['state']==3 && Auth::user()->uname != 350){
            return redirect('admin/user')->with('userMsgErr','只有超级管理员才能设置管理员');
        }
        if ($request->uid == 1){
            return redirect('admin/user')->with('userMsgErr','无法更改超级管理员信息');
        }
        if (isset($request->password)){
            $data['password'] = Hash::make($request->password);
        }
        //dd($data);
        $res = DB::table('users')->where('uid','=',$request->uid)->update($data);
        if ($res){
            return redirect('admin/user')->with('userMsg','操作成功！');
        }else {
            return redirect('admin/user')->with('userMsgErr','操作失败或未更改！');
        }
    }

    public function ajaxReq(Request $request)
    {
        $cid = $request->route('cid');
        $user = DB::table('users')->select(['uname'])->where(['company'=>$cid])->orderByDesc('uid','desc')->first();
        $users = json_decode(json_encode($user),true);
        if( is_numeric($users['uname'])){
            $uids = $users['uname'] + 1;
        }else{
            $uids = substr($users['uname'],1) + 1;
            $uids = str_pad($uids,2,"0",STR_PAD_LEFT);
            $uids = $users['uname'][0].$uids;
        }
        $msg = json_encode($uids,true);
        return $msg;
    }

}
