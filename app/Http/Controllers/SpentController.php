<?php

namespace App\Http\Controllers;

Use Alert;
use App\Action;
use App\Conassign;
use App\Contract;
use App\Credit;
use App\Source;
use App\Spent;
use App\Subaction;
use App\Subassign;
use App\Psubspent;
use App\Cost;
use App\User;
use App\Company;
use App\Vactassign;
use App\Vsubtassign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Support\Facades\DB;

class SpentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //------------------------------------------------------------------------------------------------------------------
    public function add(Subaction $subaction, Cost $cost)
    {
        $year=session('year');
        $id= $subaction->id;
        $users = User::all();
        $companies = Company::all();
     //   $sources = Source::all();
        $psubspents=Psubspent::where('subaction_id', '=',$subaction->id);
        $vsubtassigns=Vsubtassign::where([['year','=',$year],['subaction_id','=',$id]])->get();
        if(($vsubtassigns->sum('price')-$vsubtassigns->sum('sum_spent'))>0){
            return view('spents.add', compact('users', 'subaction', 'cost', 'companies', 'psubspents','vsubtassigns'));
    }else{
            Alert::warning('خطای نبود بودجه کافی', 'برای زیرفعالیت مورد نظر بودجه ای در نظر گرفته نشده ');
            return back();
        }



    }

//-------------------------------------------------------------------------------------------------

    public function addSpent(Request $request, Subaction $subaction)
    {
       $this->validate($request, [


            'price' => 'required|numeric',
            'spentname' => 'required',
            'give_date' => 'required',
            'credit_code' => 'required'
            //   'company'     => 'required',


        ], [
            'spentname.required' => 'وارد نمودن موضوع هزینه الزامی است!',
            //  'company.required'         => 'وارد نمودن حداقل یک شرکت الزامی است!',
            'price.required' => 'وارد نمودن مبلغ الزامی است!',
            'price.numeric' => 'برای مبلغ باید مقدار عددی وارد شود!',
            'give_date.required' => 'وارد نمودن تاریخ هزینه الزامی است!',
            'credit_code.required' => 'انتخاب نوع مصرف الزامی است'
        ]);

        $year2=Verta::parse($request->input('give_date'))->year;
        $year=intval($request->session()->get('year'));
        if ($year!=$year2){
            Alert::warning('خطای تاریخ هزینه', 'تاریخ هزینه با سال مالی انتخاب شده همخوانی ندارد ');
            return back()->withInput();
        }

        $vsubtassign = Vsubtassign::find($request->input('source_code'));
        $sum_befor = 0;
//dd($vsubtassign);
            if ($vsubtassign->sum_spent != null) {
                $sum_befor = $vsubtassign->sum_spent;
            }

            if ($sum_befor + $request->input('price') <= $vsubtassign->price) {
                $data2 = Spent::where([
                    ['doc_number', '=', $request->input('doc_number')],
                    ['cost_id', '=', $request->input('cost_id')]
                ])->first();
                if ($data2) {
                    Session::put('doc_number',$request->input('doc_number'));
                    Session::put('spentname',$request->input('spentname'));
                    Session::put('credit_code',$request->input('credit_code'));
                    Session::put('price',$request->input('price'));
                    Session::put('give_date',$request->input('give_date'));
                    Session::put('company',$request->input('company'));
                    Session::put('source_code',$request->input('source_code'));
                    Session::put('comments',$request->input('comments'));
                   // dd(Session::get('allInput')['doc_number']);
                    return view('spents.modalpage')->with('request', $request);
                } else {
                    $spent = new Spent();
                    // $spent->added_by      = Auth::user()->id;
                    $spent->name = $request->input('spentname');

                    $spent->spend_date = Verta::parse($request->input('give_date'))->formatGregorian('Y-m-d H:i');
                    $spent->year = Verta::parse($request->input('give_date'))->year;
                    $spent->doc_number=$request->input('doc_number');
                    $spent->cost_id = $request->input('cost_id');
                    $spent->credit_id = $request->input('credit_code');
                    $spent->subaction_id = $request->input('subaction_id');
                    $spent->subassign_id = $request->input('source_code');
                    $spent->price = $request->input('price');
                    $spent->comments = $request->input('comments');
                    $spent->save();
                    $comp_id = $request->input('company');
                    $spent->company()->attach($comp_id);
                    // Alert::success('Success Title', 'Success Message')->showConfirmButton('Confirm', '#3085d6');
                    alert()->success('ثبت موفق');

                    return redirect('/subactions/' . $request->input('subaction_id'));
                }


            } else {
                Alert::warning('خطای کمبود اعتبار', 'اعتبار منبع انتخاب شده برای این هزینه کافی نیست ');
                return redirect('/subactions/' . $request->input('subaction_id'));
            }

    }

    //------------------------------------------------------------------------
    public function Confirmed(Request $request)
    {
        dd($request);
        $spent = new Spent();
        // $spent->added_by      = Auth::user()->id;
        $spent->name = $request->input('spentname');

        $spent->spend_date = Verta::parse($request->input('give_date'))->formatGregorian('Y-m-d H:i');
        $spent->year = Verta::parse($request->input('give_date'))->year;
        //dd(Verta::parse($request->input('give_date'))->year);
        $spent->comments = $request->input('comments');
        $spent->cost_id = $request->input('cost_id');
        $spent->credit_id = $request->input('credit_code');
        $spent->subaction_id = $request->input('subaction_id');
        $spent->price = $request->input('price');
        $spent->save();
        $comp_id = $request->input('company');
        $spent->company()->attach($comp_id);
        // Alert::success('Success Title', 'Success Message')->showConfirmButton('Confirm', '#3085d6');
        alert()->success('ثبت موفق');

        return redirect('/subactions/' . $request->input('subaction_id'));
    }
//-------------------------------------------------------------------------------

    //------------------------------------------------------------------------


    public function ajaxGetCredits($id2)
    {
      //  dd('hi');
        $vsubtassign=Vsubtassign::find($id2);
        $id=$vsubtassign->source_code;
        $credits = Credit::where('source_id', $id)->pluck('name', 'id');
        // $credits = Credit::where('source_code', '=', Input::get('col_id'))->get();
        return view('spents.credits')->with('credits', $credits);
        /*  return response()->json($credits);*/
    }


    //--------------------------------------------------------------------------------
    public function addconSpent(Request $request,Contract $contract)
    {
       //  dd(Verta::parse($request->input('give_date'))->DateTime() );
        $this->validate($request, [

            'price' => 'required|numeric',
            'give_date' => 'required',
            //   'company'     => 'required',
            'source_code' => 'required'

        ], [

            'price.required' => 'وارد نمودن مبلغ الزامی است!',
            'price.numeric' => 'برای مبلغ باید مقدار عددی وارد شود!',
            'give_date.required' => 'وارد نمودن تاریخ هزینه الزامی است!',
            'source_code.required' => 'انتخاب منبع اعتبار الزامی است'

        ]);
        $year2=Verta::parse($request->input('give_date'))->year;
        $year=intval($request->session()->get('year'));
        if ($year!=$year2){
            Alert::warning('خطای تاریخ هزینه', 'تاریخ هزینه با سال مالی انتخاب شده همخوانی ندارد ');
            return back()->withInput();
        }
        $conassign = Conassign::where([
            ['status', '<',3],
            ['year', '=', Verta::parse($request->input('give_date'))->year],
            ['contract_id', '=', $contract->id]])->first();
        if($conassign){
        if($conassign->price!=null){
            $conassign_price=$conassign->price;
            }}else{
            Alert::warning('خطای عدم تخصیص اعتبار به قرارداد', ' برای قرارداد در سال مالی انتخاب شده اعتباری تخصیص داده نشده');
            return back()->withInput();
        }



        $conSpents = Spent::where([
            ['year', '=', Verta::parse($request->input('give_date'))->year],
          ['contract_id', '=', $contract->id]])->sum('price');
if ($conassign_price<$conSpents+$request->input('price')){
    Alert::warning('خطای کمبود اعتبار قرارداد', 'مبلغ پرداخت از اعتبار تعین شده قرار داد در این سال مالی بیشتر است');
    return back()->withInput();
}
        $vsubtassign = Vsubtassign::find($request->input('source_code'));
$source_code=$vsubtassign->source_code;
$credit=Credit::where('source_id','=',$source_code)->first();
//dd($credit->id);
       // $vsubtassigns=Vsubtassign::where([['year','=',$year],['subaction_id','=',$id]])->get();
        $sum_befor = 0;
if($vsubtassign){


        if ($vsubtassign->sum_spent != null) {
            $sum_befor = $vsubtassign->sum_spent;
        }}else{
    Alert::warning('خطای عدم اختصاص اعتبار ریزفعالیت', 'برای ریزفعالبت مورد نظر بودجه ای درنظر گرفته نشده است');
    return back()->withInput();
}

        if ($sum_befor + $request->input('price') <= $vsubtassign->price) {

                $spent = new Spent();
                // $spent->added_by      = Auth::user()->id;
                $spent->name = 'پرداخت مربوط به قرار داد شماره'.$contract->num;

                $spent->spend_date = Verta::parse($request->input('give_date'))->formatGregorian('Y-m-d H:i');
                $spent->year = Verta::parse($request->input('give_date'))->year;
                $spent->credit_id = $credit->id;
                $spent->contract_id=$contract->id;
                $spent->cost_id =$contract->cost_id;
                $spent->subaction_id = $contract->subaction_id;
                $spent->subassign_id = $vsubtassign->id;;
                $spent->price = $request->input('price');
                $spent->comments = $request->input('comments');
                $spent->save();
                $comp_id = $contract->company_id;
                $spent->company()->attach($comp_id);
                // Alert::success('Success Title', 'Success Message')->showConfirmButton('Confirm', '#3085d6');
                alert()->success('ثبت موفق');
            return back();
               // return redirect('/subactions/' . $request->input('subaction_id'));
            /*}*/


        } else {
            Alert::warning('خطای کمبود اعتبار', 'اعتبار منبع انتخاب شده برای این هزینه کافی نیست ');
            return back()->withInput();
            //return redirect('/subactions/' . $request->input('subaction_id'));
        }
      /*  $data = Vsubtassign::where([
            ['year', '=', Verta::parse($request->input('give_date'))->year],
            ['source_id', '=', $request->input('source_code')],
            ['subaction_id', '=', $request->input('subaction_id')]])->first();
        // dd( $request->input('source_code'));
        $data2 = Conassign::where([
            ['year', '=', Verta::parse($request->input('give_date'))->year],
            ['contract_id', '=', $request->input('contract_id')]])->first();

        $spent_year = Spent::where([
            ['year', '=', Verta::parse($request->input('give_date'))->year],
            ['contract_id', '=', $request->input('contract_id')]])->sum('price');

        $sum_befor = 0;
        $conassign_price = 0;

        if ($data) {

            if ($data->price_sum != null) {
                $sum_befor = $data->price_sum;
            }
            if ($data2) {
                if ($data2->price != null) {
                    $conassign_price = $data2->price;
                }

            }

            if ($sum_befor + $request->input('price') <= $data->sum_credit) {

                if ($spent_year + $request->input('price') <= $conassign_price) {
                    $spent = new Spent();
                    // $spent->added_by      = Auth::user()->id;
                    $spent->name = $request->input('spentname');
                    $spent->spend_date = Verta::parse($request->input('give_date'))->DateTime();
                    $spent->year = Verta::parse($request->input('give_date'))->year;

                    $spent->comments = $request->input('comments');
                    $spent->cost_id = $request->input('cost_id');
                    $spent->credit_id = $request->input('credit_code');
                    $spent->contract_id = $request->input('contract_id');
                    $spent->subaction_id = $request->input('subaction_id');
                    $spent->price = $request->input('price');
                    $spent->save();

                    $comp_id = $request->input('company');
                    $spent->company()->attach($comp_id);
                    Alert::success('پرداخت قرارداد با موفقیت انجام شد', 'Success Message');
                    return redirect('contracts/' . $request->input('contract_id') . '/show');
                } else {
                    Alert::warning('خطای تخصیص اعتبار', 'مبالغ هزینه از اعتبار تخیصیص یافته در سال بیشتر است ');
                    return back();
                }
            } else {
                Alert::warning('خطای کمبود اعتبار', 'اعتبار منبع مورد نظر برای این هزینه کافی نیست ');
                return back();
            }
        } else {
            Alert::warning('خطای عدم تخصیص اعتبار', 'در سال هزینه برای منبع مورد نظر اعتباری تعریف نشده است');
            return back();
        }*/

    }
    //--------------------------------------------------------------------------------
    public function edit(Spent $spent)
    {
        $users = User::all();

        $id=$spent->subaction_id;
        $vsubtassign=Vsubtassign::find($spent->subassign_id);
        $id2=$vsubtassign->source_code;
        $year=session('year');
        $companies = Company::all();
        $credits=Credit::where('source_id',$id2);
        $vsubtassigns=Vsubtassign::where([['year','=',$year],['subaction_id','=',$id]])->get();
         $subaction = $spent->subaction;

         $cost=$spent->cost;
        // dd($spent->company);
        return view('spents.editSpent', compact('spent','users', 'subaction', 'cost', 'companies', 'vsubtassigns'));
    }
    //--------------------------------------------------------------------------------
    public function editSpent(Request $request,Spent $spent)
    {
        $this->validate($request, [


            'price' => 'required|numeric',
            'spentname' => 'required',
            'give_date' => 'required',
            'credit_code' => 'required'
            //   'company'     => 'required',


        ], [
            'spentname.required' => 'وارد نمودن موضوع هزینه الزامی است!',
            //  'company.required'         => 'وارد نمودن حداقل یک شرکت الزامی است!',
            'price.required' => 'وارد نمودن مبلغ الزامی است!',
            'price.numeric' => 'برای مبلغ باید مقدار عددی وارد شود!',
            'give_date.required' => 'وارد نمودن تاریخ هزینه الزامی است!',
            'credit_code.required' => 'انتخاب نوع مصرف الزامی است'
        ]);

        $year2=Verta::parse($request->input('give_date'))->year;
        $year=intval($request->session()->get('year'));
        if ($year!=$year2){
            Alert::warning('خطای تاریخ هزینه', 'تاریخ هزینه با سال مالی انتخاب شده همخوانی ندارد ');
            return back()->withInput();
        }

        $vsubtassign = Vsubtassign::find($request->input('source_code'));
        $sum_befor = 0;

        if ($vsubtassign->sum_spent != null) {
            $sum_befor = $vsubtassign->sum_spent;
            $sum_befor= $sum_befor-$spent->price;
        }

        if ($sum_befor + $request->input('price') <= $vsubtassign->price) {

            $data2 = Spent::where([
                ['doc_number', '=', $request->input('doc_number')],
                ['cost_id', '=', $request->input('cost_id')]
            ])->first();
            if ($data2 && $spent->doc_number!=$request->input('doc_number')) {
                Session::put('doc_number', $request->input('doc_number'));
                Session::put('spentname', $request->input('spentname'));
                Session::put('credit_code', $request->input('credit_code'));
                Session::put('price', $request->input('price'));
                Session::put('give_date', $request->input('give_date'));
                Session::put('company', $request->input('company'));
                Session::put('source_code', $request->input('source_code'));
                Session::put('comments', $request->input('comments'));
                // dd(Session::get('allInput')['doc_number']);
                return view('spents.modalpage')->with('request', $request);

            } else {

                // $spent->added_by      = Auth::user()->id;
                $spent->name = $request->input('spentname');

                $spent->spend_date = Verta::parse($request->input('give_date'))->formatGregorian('Y-m-d H:i');
                  $spent->year = Verta::parse($request->input('give_date'))->year;
                $spent->doc_number=$request->input('doc_number');
                $spent->cost_id = $request->input('cost_id');
                $spent->credit_id = $request->input('credit_code');
                $spent->subaction_id = $request->input('subaction_id');
                $spent->subassign_id = $request->input('source_code');
                $spent->price = $request->input('price');
                $spent->comments = $request->input('comments');
                $spent->update();
                $comp_id = $request->input('company');
                $spent->company()->sync($comp_id);
                // Alert::success('Success Title', 'Success Message')->showConfirmButton('Confirm', '#3085d6');
                alert()->success('ثبت موفق');

                return redirect('/subactions/' . $request->input('subaction_id'));
            }


        } else {
            Alert::warning('خطای کمبود اعتبار', 'اعتبار منبع انتخاب شده برای این هزینه کافی نیست ');
            return redirect('/subactions/' . $request->input('subaction_id'));
        }


    }
        //--------------------------------------------------------------------------------
        public function deleteSpent(Spent $spent)
    {

        $spent->status=3;
        $spent->update();


        Alert::success('حذف هزینه با موفقیت انجام شد', 'Success Message');
        return back();
    }
    //--------------------------------------------------------------------------------
    public function editconSpent(Request $request,Spent $spent)
    {
        //  dd(Verta::parse($request->input('give_date'))->DateTime() );
        $this->validate($request, [

            'price' => 'required|numeric',
            'give_date' => 'required',
            //   'company'     => 'required',


        ], [

            'price.required' => 'وارد نمودن مبلغ الزامی است!',
            'price.numeric' => 'برای مبلغ باید مقدار عددی وارد شود!',
            'give_date.required' => 'وارد نمودن تاریخ هزینه الزامی است!',

        ]);
        $year2=Verta::parse($request->input('give_date'))->year;
        $year=intval($request->session()->get('year'));
        if ($year!=$year2){
            Alert::warning('خطای تاریخ هزینه', 'تاریخ هزینه با سال مالی انتخاب شده همخوانی ندارد ');
            return back()->withInput();
        }
        $contract=$spent->contract();
        $conassign = Conassign::where([
            ['status', '<',3],
            ['year', '=', Verta::parse($request->input('give_date'))->year],
            ['contract_id', '=', $contract->id]])->first();
        if($conassign){
            if($conassign->price!=null){
                $conassign_price=$conassign->price;
            }}else{
            Alert::warning('خطای عدم تخصیص اعتبار به قرارداد', ' برای قرارداد در سال مالی انتخاب شده اعتباری تخصیص داده نشده');
            return back()->withInput();
        }



        $conSpents = Spent::where([
            ['year', '=', Verta::parse($request->input('give_date'))->year],
            ['contract_id', '=', $contract->id]])->sum('price');
        if ($conassign_price<$conSpents+$request->input('price')-$spent->price){
            Alert::warning('خطای کمبود اعتبار قرارداد', 'مبلغ پرداخت از اعتبار تعین شده قرار داد در این سال مالی بیشتر است');
            return back()->withInput();
        }
        $vsubtassign = Vsubtassign::find($request->input('source_code'));
        $source_code=$vsubtassign->source_code;
        $credit=Credit::where('source_id','=',$source_code)->first();
        $sum_befor = 0;
        if($vsubtassign){


            if ($vsubtassign->sum_spent != null) {
                $sum_befor = $vsubtassign->sum_spent;
            }}else{
            Alert::warning('خطای عدم اختصاص اعتبار ریزفعالیت', 'برای ریزفعالبت مورد نظر بودجه ای درنظر گرفته نشده است');
            return back()->withInput();
        }

        if ($sum_befor + $request->input('price')-$spent->price <= $vsubtassign->price) {


            // $spent->added_by      = Auth::user()->id;
            $spent->name = 'پرداخت مربوط به قرار داد شماره'.$contract->num;

            $spent->spend_date = Verta::parse($request->input('give_date'))->formatGregorian('Y-m-d H:i');
            $spent->year = Verta::parse($request->input('give_date'))->year;
            $spent->credit_id = $credit->id;
            $spent->contract_id=$contract->id;
            $spent->cost_id =$contract->cost_id;
            $spent->subaction_id = $contract->subaction_id;
            $spent->subassign_id = $contract->subassign_id;;
            $spent->price = $request->input('price');
            $spent->comments = $request->input('comments');
            $spent->save();
            $comp_id = $contract->company_id;
            $spent->company()->sync($comp_id);
            // Alert::success('Success Title', 'Success Message')->showConfirmButton('Confirm', '#3085d6');
            alert()->success('ویرایش موفق');
            return back();
            // return redirect('/subactions/' . $request->input('subaction_id'));
            /*}*/


        } else {
            Alert::warning('خطای کمبود اعتبار', 'اعتبار منبع انتخاب شده برای این هزینه کافی نیست ');
            return back()->withInput();
            //return redirect('/subactions/' . $request->input('subaction_id'));
        }
        $data = Vsubtassign::where([
            ['year', '=', Verta::parse($request->input('give_date'))->year],
            ['source_id', '=', $request->input('source_code')],
            ['subaction_id', '=', $request->input('subaction_id')]])->first();
        // dd( $request->input('source_code'));
        $data2 = Conassign::where([
            ['year', '=', Verta::parse($request->input('give_date'))->year],
            ['contract_id', '=', $request->input('contract_id')]])->first();

        $spent_year = Spent::where([
            ['year', '=', Verta::parse($request->input('give_date'))->year],
            ['contract_id', '=', $request->input('contract_id')]])->sum('price');

        $sum_befor = 0;
        $conassign_price = 0;

        if ($data) {

            if ($data->price_sum != null) {
                $sum_befor = $data->price_sum;
            }
            if ($data2) {
                if ($data2->price != null) {
                    $conassign_price = $data2->price;
                }

            }
//dd($conassign_price);
            if ($sum_befor + $request->input('price') <= $data->sum_credit) {

                if ($spent_year + $request->input('price') <= $conassign_price) {
                    $spent = new Spent();
                    // $spent->added_by      = Auth::user()->id;
                    $spent->name = $request->input('spentname');
                    $spent->spend_date = Verta::parse($request->input('give_date'))->DateTime();
                    $spent->year = Verta::parse($request->input('give_date'))->year;

                    $spent->comments = $request->input('comments');
                    $spent->cost_id = $request->input('cost_id');
                    $spent->credit_id = $request->input('credit_code');
                    $spent->contract_id = $request->input('contract_id');
                    $spent->subaction_id = $request->input('subaction_id');
                    $spent->price = $request->input('price');
                    $spent->save();

                    $comp_id = $request->input('company');
                    $spent->company()->attach($comp_id);
                    Alert::success('پرداخت قرارداد با موفقیت انجام شد', 'Success Message');
                    return redirect('contracts/' . $request->input('contract_id') . '/show');
                } else {
                    Alert::warning('خطای تخصیص اعتبار', 'مبالغ هزینه از اعتبار تخیصیص یافته در سال بیشتر است ');
                    return back();
                }
            } else {
                Alert::warning('خطای کمبود اعتبار', 'اعتبار منبع مورد نظر برای این هزینه کافی نیست ');
                return back();
            }
        } else {
            Alert::warning('خطای عدم تخصیص اعتبار', 'در سال هزینه برای منبع مورد نظر اعتباری تعریف نشده است');
            return back();
        }

    }
        //--------------------------------------------------------------------------------

}
