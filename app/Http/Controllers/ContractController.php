<?php

namespace App\Http\Controllers;

use App\Action;
use App\Credit;
use App\Source;
use App\Spent;
use App\Subaction;
use App\Cost;
use App\User;
use App\Company;
use App\Contract;
use App\Yeart;
use App\Psubspent;
use App\Vsubtassign;
use App\Conassign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;
use RealRashid\SweetAlert\Facades\Alert;

class ContractController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function add(Subaction $subaction, Cost $cost)
    {
        $level = '';
        if ($subaction->action->id == 9) {
            $level = 'پیش رشد';
        } elseif ($subaction->action->id ==10){
      $level = 'رشد';
    }elseif ($subaction->action->id==11){
$level = 'فناور';
}
        $sources = Source::all();
        $year=session('year');
        $id= $subaction->id;
        $users = User::all();
        $companies = Company::all();
        //   $sources = Source::all();
        $psubspents=Psubspent::where('subaction_id', '=',$subaction->id);
        return view('contracts.add', compact('users', 'subaction', 'cost', 'companies', 'psubspents','level'));

    }

    //---------------------------------------------------------------------------------------------------------------
    public function addContract(Request $request)
    {

        // dd(Verta::parse($request->input('give_date'))->DateTime() );
        $this->validate($request, [
            'price' => 'required|numeric',
            'paid_befor' => 'numeric',
            'tittle' => 'required',
            'give_date' => 'required',
            'start_date' => 'required',
            'company' => 'required',
           'num' => 'required',

        ], [
            'num.required' => 'وارد نمودن شماره قرارداد الزامی است!',
            'tittle.required' => 'وارد نمودن موضوع قرارداد الزامی است!',
            'company.required' => 'وارد نمودن یک شرکت الزامی است!',
            'price.required' => 'وارد نمودن مبلغ الزامی است!',
            'price.numeric' => 'برای مبلغ باید مقدار عددی وارد شود!',
            'paid_befor.numeric' => 'برای مبلغ پرداختی از سال های قبل باید مقدار عددی وارد شود!',
            'give_date.required' => 'وارد نمودن تاریخ انعقاد قرارداد الزامی است!',
            'start_date.required' => 'وارد نمودن تاریخ شروع قرارداد الزامی است!',
        ]);
$subaction=Subaction::find($request->input('subaction_id'));

        if ($subaction->action->id == 9) {
            $level = 1;
        }elseif ($subaction->action->id ==10){
            $level =2;
        }elseif ($subaction->action->id==11){
            $level = 3;
        }

        $contract = new Contract();


        $contract->tittle = $request->input('tittle');
        $contract->company_id = $request->input('company');
        $contract->date = Verta::parse($request->input('give_date'))->DateTime();
        $contract->start_date = Verta::parse($request->input('start_date'))->DateTime();
        $contract->comments = $request->input('comments');
        $contract->cost_id = $request->input('cost_id');
        $contract->subaction_id = $request->input('subaction_id');
        $contract->totalcredit = $request->input('price');
        $contract->paid_befor = $request->input('paid_befor');
        $contract->duration = $request->input('duration');
        $contract->level = $level;
        $contract->num = $request->input('num');
        $contract->motamem = 0;
        $contract->save();

       // $company=$contract->company;
      //  $company->kind=$level;
        //$company->update();



     //   dd($vsubtassigns);
        $yearts = Yeart::all();
        Alert::success('قرارداد با موفقیت ثبت شد', '');
        return redirect()->route('ShowContract', [$contract]);
       // return view('contracts.show', compact('contract','yearts'));
    }
   //------------------------------------------------------------------------------------------------------
    public function showContract(Contract $contract)
    {
        // dd('d');
        $year=session('year');
        $id=$contract->subaction_id;
        $vsubtassigns=Vsubtassign::where([['year','=',$year],['subaction_id','=',$id]])->get();
        $yearts = Yeart::all();
        return view('contracts.show', compact('contract','yearts','vsubtassigns'));
    }

    //---------------------------------------------------------------------------------------------------------------
    public function addConassign(Contract $contract, Request $request)
    {


        $this->validate($request, [
            'price' => 'required|numeric',
            'year' => 'required',
     ], [

            'year.required' => 'انتخاب سال الزامی است!',
            'price.required' => 'وارد نمودن مبلغ الزامی است!',
            'price.numeric' => 'برای مبلغ باید مقدار عددی وارد شود!',
      ]);
        if ($contract->conassign->sum('price') + $request->input('price') <= $contract->totalcredit + $contract->motamem-$contract->paid_befor) {
            $conassign = new Conassign();


            $conassign->year = $request->input('year');
            $conassign->price = $request->input('price');
            $conassign->contract_id = $request->input('contract_id');

            $conassign->save();
$contract=Contract::find($request->input('contract_id'));
            $yearts = Yeart::all();
            Alert::success('تخصیص با موفقیت انجام شد', '');
            return back();
            // return view('contracts.add2', compact('contract', 'yearts'));
        } else {
            Alert::warning('خطای مبلغ تخصیص', 'مبلغ مورد نظر از مبلغ مصوب برای این قرارداد بیشتر است ');
            return back();
        }

    }
    //---------------------------------------------------------------------------------------------------------------
    public function editConassign(Conassign $conassign, Request $request)
    {


        $this->validate($request, [
            'price' => 'required|numeric',
            'year' => 'required',
        ], [

            'year.required' => 'انتخاب سال الزامی است!',
            'price.required' => 'وارد نمودن مبلغ الزامی است!',
            'price.numeric' => 'برای مبلغ باید مقدار عددی وارد شود!',
        ]);
        $contract=$conassign->contract;

        if (($contract->conassign->sum('price')-$conassign->price)+ $request->input('price') <= $contract->totalcredit + $contract->motamem-$contract->paid_befor) {



            $conassign->year = $request->input('year');
            $conassign->price = $request->input('price');


            $conassign->update();
          //  $contract=Contract::find($request->input('contract_id'));
          //  $yearts = Yeart::all();
            Alert::success('تخصیص با موفقیت انجام شد', '');
            return back();
            // return view('contracts.add2', compact('contract', 'yearts'));
        } else {
            Alert::warning('خطای مبلغ تخصیص', 'مبلغ مورد نظر از مبلغ مصوب برای این قرارداد بیشتر است ');
            return back();
        }

    }

    //------------------------------------------------------------------------
    public function ajaxGetCredits($id)
    {
        // dd($id);
        $credits = Credit::where('source_id', $id)->pluck('name', 'id');
        // $credits = Credit::where('source_code', '=', Input::get('col_id'))->get();
        return view('contracts.credits')->with('credits', $credits);
        /*  return response()->json($credits);*/
    }
    //---------------------------------------------------------------------------------------------------------------
   /* public function conassign(Contract $contract, Request $request)
    {




            $yearts = Yeart::all();

            return view('contracts.add2', compact('contract', 'yearts'));

    }*/

//----------------------------------------------------------------------------------------------------------------------
    public function edit(Contract $contract)
    {
        $level = '';
        $subaction=$contract->subaction;
        //dd($subaction);
        if ($subaction->action->id == 9) {
            $level = 'پیش رشد';
        } elseif ($subaction->action->id ==10){
            $level = 'رشد';
        }elseif ($subaction->action->id==11){
            $level = 'فناور';
        }
        $users = User::all();
        $companies = Company::all();


        return view('contracts.edit', compact('contract','users', 'companies', 'level','subaction'));

    }
//----------------------------------------------------------------------------------------------------------------------
    public function editcontract(Request $request, Contract $contract)
{

//dd($request->input());
    // dd($deliver->id);
    $this->validate($request, [
        'price' => 'required|numeric',
        'paid_befor' => 'numeric',
        'tittle' => 'required',
        'give_date' => 'required',
        'start_date' => 'required',
        'company' => 'required',
        'num' => 'required',

    ], [
        'num.required' => 'وارد نمودن شماره قرارداد الزامی است!',
        'tittle.required' => 'وارد نمودن موضوع قرارداد الزامی است!',
        'company.required' => 'وارد نمودن یک شرکت الزامی است!',
        'price.required' => 'وارد نمودن مبلغ الزامی است!',
        'price.numeric' => 'برای مبلغ باید مقدار عددی وارد شود!',
        'paid_befor.numeric' => 'برای مبلغ پرداختی از سال های قبل باید مقدار عددی وارد شود!',
        'give_date.required' => 'وارد نمودن تاریخ انعقاد قرارداد الزامی است!',
        'start_date.required' => 'وارد نمودن تاریخ شروع قرارداد الزامی است!',
    ]);

    //dd($request->input());


    if ($contract->conassign->sum('price') <= $request->input('price') + $contract->motamem) {
        //   $contract->edited_by     = Auth::user()->id;
        $contract->tittle = $request->input('tittle');
        $contract->company_id = $request->input('company');
        $contract->date = Verta::parse($request->input('give_date'))->DateTime();
        $contract->start_date = Verta::parse($request->input('start_date'))->DateTime();
        $contract->comments = $request->input('comments');
        $contract->cost_id = $request->input('cost_id');
        //$contract->credit_id = $request->input('credit_code');
       // $contract->subaction_id = $request->input('subaction_id');
        $contract->totalcredit = $request->input('price');
        $contract->paid_befor = $request->input('paid_befor');
        $contract->duration = $request->input('duration');
        $contract->level = $request->input('level');
        $contract->num = $request->input('num');
        // $contract->motamem = 0;


        $contract->update();
        Alert::success('ویرایش قرارداد با موفقیت انجام شد', '');

        return redirect( '/subactions/'.$contract->subaction_id);

    } else {
        Alert::warning('خطای مبلغ مصوب', 'مجموع اعتبارات تخصیص یافته برای این قرارداد از مبلغ مصوب ویرایش شده بیشتر است ');
        return back();
    }


}
//----------------------------------------------------------------------------------------------------------------------
    public function motamem(Request $request, Contract $contract)
    {

//dd($request->input());
        // dd($deliver->id);
        $this->validate($request, [
            'price' => 'required|numeric',
            'year' => 'required'
        ], [
            'price.required' => 'وارد نمودن مبلغ الزامی است!',
            'price.numeric' => 'برای مبلغ باید مقدار عددی وارد شود!',
            'year.required' => 'انتخاب سال اعتبار متمم الزامی است!',
           ]);

        //dd($request->input());


        if ($contract->conassign->sum('price') <= $request->input('price') + $contract->totalcredit) {
            //   $contract->edited_by     = Auth::user()->id;
            $contract->motamem = $request->input('price');
            $contract->motamemyear = $request->input('year');



            $contract->update();
            Alert::success('متمم قرارداد با موفقیت تغییر شد', '');

            return redirect( '/subactions/'.$contract->subaction_id);

        } else {
            Alert::warning('خطای مبلغ متمم', 'مجموع اعتبارات تخصیص یافته برای این قرارداد از مجموع مبالغ مصوب و متمم بیشتر است ');
            return back();
        }


    }
    //----------------------------------------------------------------------------------------------------------------------
    public function delete(Contract $contract)
    {
        $conSpents = Spent::where([
            ['status', '<',3],
            ['contract_id', '=', $contract->id]])->first();

      // dd($conSpents);
        if ($conSpents==null){
            $contract->status =3;
            $contract->update();
            Alert::success(' قرارداد با موفقیت حذف شد', '');

            return back();

        } else {
            Alert::warning('خطای حذف قرارداد', 'به دلیل وجود پرداخت برای این قرارداد، عملیات حذف امکانپذیر نمی باشد');
            return back();
        }


    }
    //----------------------------------------------------------------------------------------------------------------------
    public function deletConassign(Conassign $conassign)
    {

        $contract=$conassign->contract;
        $conSpents = Spent::where([
            ['status', '<',3],
            ['year', '=', $conassign->year],
            ['contract_id', '=', $contract->id]])->sum('price');
if($conSpents>0){
    Alert::warning('خطای حذف تخصیص', 'به دلیل وجود پرداخت در سال مالی مربوطه برای این قرارداد، عملیات حذف امکانپذیر نمی باشد');
    return back();
}else{
    $conassign->status =3;
    $conassign->update();
    Alert::success(' تخصیص قرارداد با موفقیت حذف شد', '');
    return back();
}
        }
    }
