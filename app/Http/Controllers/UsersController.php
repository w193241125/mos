<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public function show()
    {
        return view('user');
    }

    public function reset(Request $request)
    {
        $uid = $request->uid;
        $oldPass = $request->old_pass;
        $newPass = $request->password;
        $confirmPass = $request->password_confirmation;

        $user = DB::table('users')->where('uid','=',$uid)->get()->toArray();
        //dd(Hash::check($oldPass,$user[0]->password));
        //dd($user);
        if( Hash::check($oldPass,$user[0]->password) && $confirmPass==$newPass){
            $data['password'] = Hash::make($newPass);
            $res = DB::table('users')->where('uid','=',$uid)->update($data);
            if ($res){
                return redirect('user')->with('resetMsg',1);
            }else{
                return redirect('user')->with('resetMsg',2);
            }
        }else {
            return redirect('user')->with('resetMsg',2);
        }
    }
}
