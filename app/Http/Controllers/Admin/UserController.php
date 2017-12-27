<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show()
    {
        $user = DB::table('users')->get();
        return view('admin.user.user',compact('user'));
    }

    public function add()
    {
        return view('admin.user.add');
    }

    public function doadd(Request $request)
    {
        $data['uname'] = $request->uname;
        $data['realname'] = $request->realname;
        $password = $request->password?$request->password:'123456';
        $data['password'] = Hash::make($password);
        $data['state'] = $request->state;
        $res = DB::table('users')->insert($data);
        if ($res){
            return redirect('admin/user')->with('userMsg',1);
        }else {
            return redirect('admin/user')->with('userMsg',2);
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
        $data['state'] = $request->state;
        if (isset($request->password)){
            $data['password'] = Hash::make($request->password);
        }
        //dd($data);
        $res = DB::table('users')->where('uid','=',$request->uid)->update($data);
        if ($res){
            return redirect('admin/user')->with('userMsg',1);
        }else {
            return redirect('admin/user')->with('userMsg',2);
        }
    }

}
