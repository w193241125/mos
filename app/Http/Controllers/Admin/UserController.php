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
        $uname = $request->input('uname');
        $realname = $request->input('realname');
        $company = $request->input('company');
        $user = DB::table('users')
            ->when($state,function ($query) use ($state){
                return $query->where('state','=',$state);
            })
            ->when($uname,function ($query) use ($uname){
                return $query->where('uname','like','%'.$uname.'%');
            })
            ->when($realname,function ($query) use ($realname){
                return $query->where('realname','like','%'.$realname.'%');
            })
            ->when($company,function ($query) use ($company){
                return $query->where('company','=',$company);
            })
            ->orderBy('uid','desc')
            ->get();
        $companys = DB::table('companys')->where('state','=',1)->get()->toArray();
        $cp = [];
        foreach ($companys as $c) {
            $cp[$c->id] = $c->company_name;
        }
        return view('admin.user.user')->with([
            'user'=> $user,
            'company'=>$company,
            'companys'=>$companys,
            'uname'=>$uname,
            'realname'=>$realname,
            'cp'=>$cp,
            'state'=>$state,
        ]);
    }

    public function add()
    {
        $ny_uid = DB::table('users')->orderBy('uid','desc')->whereNotIn('state',[4])->where(['company'=>4])->first();
        $ny_uids = $ny_uid->uname ?? '无';
        $uid = DB::table('users')->orderBy('uid','desc')->whereNotIn('state',[4])->where(['company'=>1])->first();
        $uids = $uid->uname ?? '无';
        $xt_uid = DB::table('users')->orderBy('uid','desc')->whereNotIn('state',[4])->where(['company'=>5])->first();
        $xt_uids = $xt_uid->uname ?? '无';
        $companys = DB::table('companys')->where('state','=',1)->get()->toArray();
        return view('admin.user.add')->with(['uid'=> $uids,'ny_uid'=>$ny_uids,'xt_uid'=>$xt_uids,'companys'=>$companys,]);
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
        $companys = DB::table('companys')->where('state','=',1)->get()->toArray();
        return view('admin.user.edit',['user'=>$user[0],'companys'=>$companys,]);
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
