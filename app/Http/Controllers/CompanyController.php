<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Company;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
Use Alert;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $companies=Company::OrderBy('name','asc')->paginate(20);
        //dd('hi');
        return view('companies.index',compact('companies'));
    }
    //------------------------------------------------------------------------------------------------------------------
    public function add()
    {
       // $users = User::all();
        // $devkinds = Devkind::all();

     //   return view('works.add', compact('users'));
        return view('companies.add');
    }
    //------------------------------------------------------------------------------------------------------------------
    public function addCompany(Request $request)
    {
        $this->validate($request, [
            'nameip'    => 'required',
            'bossip'    => 'required',
       ], [
            'nameip.required'       => 'وارد نمودن نام واحد الزامی است!',
            'bossip.required'           => 'وارد نمودن نام مدیر واحد الزامی است!',
        ]);
        $company =new Company();
        $company->name=$request->input('nameip');
        $company->kind=$request->input('level');
        $company->boss=$request->input('bossip');
        $company->phone=$request->input('phoneip');
        $company->accont_number=$request->input('accip');
        $company->status=0;
        $company->save();
        Alert::success('ثبت موفق', 'واحد فناور با موفقیت ثبت شد');
        return redirect('/companies');
    }
    //------------------------------------------------------------------------------------------------------------------
    public function edit(Company $company)
    {

        return view('companies.edit',compact('company'));
    }
    //------------------------------------------------------------------------------------------------------------------
    public function editCompany(Request $request,Company $company)
    {
        $this->validate($request, [
            'nameip'    => 'required',
            'bossip'    => 'required',
        ], [
            'nameip.required'       => 'وارد نمودن نام واحد الزامی است!',
            'bossip.required'           => 'وارد نمودن نام مدیر واحد الزامی است!',
        ]);

        $company->name=$request->input('nameip');
        $company->kind=$request->input('level');
        $company->boss=$request->input('bossip');
        $company->phone=$request->input('phoneip');
        $company->accont_number=$request->input('accip');
        $company->status=0;
        $company->update();
        Alert::success('ثبت موفق', 'ویرایش واحد فناور با موفقیت ثبت شد');
        return redirect('/companies');
    }
}
