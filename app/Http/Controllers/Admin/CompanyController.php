<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function __construct(Request $request)
    {
        //dd($request->user());
        $this->middleware('auth');
    }

    public function show()
    {
        $company = DB::table('companys')->where('state','=',1)->get()->toArray();
        return view('admin.company.company', compact(['company']));
    }

    public function add()
    {
        return view('admin.company.add');
    }

    public function doadd(Request $request)
    {
        $company['company_name'] = $request->company_name;
        $company['code_name'] = $request->code_name;
        $company['state'] = $request->state;
        $company['config'] = $request->config ? json_encode($request->config) : '';

        $res = DB::table('companys')->insert($company);
        if ($res){
            return redirect('admin/company')->with(['companyMsg'=>'1']);
        } else {
            return redirect('admin/company')->with(['companyMsg'=>'2']);
        }
    }

    public function edit(Request $request)
    {
        $id = $request->route('id');
        $company = DB::table('companys')->where('id','=',$id)->get()->toArray();

        return view('admin.company.edit',['company'=>$company[0]]);
    }

    public function doedit(Request $request)
    {
        //dd($request);
        $id= $request->id;
        $company['company_name'] = $request->company_name;
        $company['code_name'] = $request->code_name;
        $company['state'] = $request->state;
        $company['config'] = $request->config ? json_encode($request->config) : '';


        $res = DB::table('companys')->where('id','=',$id)->update($company);
        if ($res){
            return redirect('admin/company')->with(['companyMes'=>1]);
        }else{
            return redirect('admin/company')->with(['companyMes'=>2]);
        }

    }

    public static function getCpCache()
    {
    self::cache();

        $res = Cache::get('companys');

        if ($res) return json_decode($res);

         return self::cache();

    }
    
    public static function cache()
    {

        $company = DB::table('companys')->where('state','=',1)->get()->toArray();
        dd(11);
        if ($company){
           $res =  Cache::put('companys',11);

        }
        $res = Cache::get('companys');
        dd($res);
        if ($res) return json_decode($res);

        return [];
    }
}
