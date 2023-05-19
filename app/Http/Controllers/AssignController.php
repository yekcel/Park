<?php

namespace App\Http\Controllers;

use App\Actassign;
use App\Action;
use App\Application;
use App\Appassign;
use App\Alocate_budget;
use App\Allocate_app;
use App\Allocate_act;
use App\Allocate_sub;
use App\Budget;
use App\Source;
use App\Spent;
use App\Subaction;
use App\Subassign;
use App\Cost;
use App\User;
use App\Yeart;
use Illuminate\Database\QueryException;
use RealRashid\SweetAlert\Facades\Alert;
use App\Contract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;


class AssignController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //======================صفحه تصویب بودجه====================================
    public function add2bud()
    {
        $users = User::all();
        $yearts=Yeart::all();
        $sources=Source::all();

        // $devkinds = Devkind::all();

        return view('assigns.budgetadd', compact('users','yearts','sources'));
    }
    //===================================صفحه تصویب بودجه برنامه==========================================
    public function add2app(Subaction $subaction,Cost $cost)
    {
        $users = User::all();
        $yearts=Yeart::all();
        $sources=Source::all();
        $applications=Application::all();
        // $devkinds = Devkind::all();

        return view('assigns.addtoapp', compact('users','subaction','applications','yearts','sources'));
    }

    //-----------------------تصویب بودجه کلی----------------------------------------------------------
    public function addtobud(Request $request)
    {

        //   dd($request->input('application'));
        $this->validate($request, [
            'approved_price'     => 'required|numeric',
            'year'     => 'required',
            'source_code'     => 'required',
            'give_date'     => 'required',
            'sup'     => 'required',

        ], [

            'year.required'           => 'وارد نمودن سال الزامی است!',
            'approved_price.required'           => 'وارد نمودن مبلغ الزامی است!',
            'approved_price.numeric'            => 'برای مبلغ باید مقدار عددی وارد شود!',
            'give_date.required'       => 'وارد نمودن تاریخ تصویب اعتبار الزامی است!',
            'source_code.required'       => 'انتخاب منبع اعتبار الزامی است!',
            'sup.required'       => 'انتخاب تامین کننده الزامی است!',

        ]);

        $budget= new Budget();

        // $spent->added_by      = Auth::user()->id;

        $budget->source_id             = $request->input('source_code');
        $budget->date                =Verta::parse($request->input('give_date'))->DateTime();
        $budget->approved_price          =$request->input('approved_price');
        $budget->year            = $request->input('year');
        $budget->comments             =$request->input('comments');
        $budget->supplier             =$request->input('sup');
        // $budget->save();
        try {
            $budget->save();

        }
        catch (QueryException $x) {
            //  dd('hi');
            Alert::warning('خطای تکرار یک منبع درآمد در سال', ' از هر منبع درآمد در یک سال فقط یک بار می توان تعریف نمود');
            return back();
        }

        // dd($request);
        Alert::success('ثبت موفق', 'ثبت بودجه جدید با موفقیت انجام شد');
        return redirect('/assigns');

    }
    //-----------------------اختصاص بودجه کلی----------------------------------------------------------
    public function allocate_bud(Budget $budget,Request $request)
    {

        //dd($request->input('price'));
        $this->validate($request, [
            'price' => 'required|numeric',
            'give_date' => 'required',

        ], [


            'price.required' => 'وارد نمودن مبلغ الزامی است!',
            'price.numeric' => 'برای مبلغ باید مقدار عددی وارد شود!',
            'give_date.required' => 'وارد نمودن تاریخ تخصیص اعتبار الزامی است!',


        ]);
        $old_price = $budget->price;
        if ($old_price + $request->input('price') <= $budget->approved_price) {

            $budget->price=$old_price + $request->input('price');
            $budget->update();
            $allocate = new Alocate_budget;

            // $spent->added_by      = Auth::user()->id;
            $allocate->budget_id = $budget->id;
            $allocate->allocate_price = $request->input('price');
            $allocate->allocate_date = Verta::parse($request->input('give_date'))->DateTime();
            $allocate->comments = $request->input('comments');
            $allocate->save();
            Alert::success('ثبت موفق', 'تخصیص با موفقیت انجام شد');
            return back();
        }else{
            Alert::danger('ثبت ناموفق', 'جمع مبالغ تخصیص یافته از مبلغ مصوب بیشتر است');
            return back();
        }


        // dd($request);
        Alert::success('ثبت موفق', 'ثبت بودجه جدید با موفقیت انجام شد');
        return redirect('/assigns');

    }
    //------------------تصویب بودجه برنامه---------------------------------------------
    public function addtoapp(Budget $budget,  Request $request)
    {
        //   dd($request->input('application'));

        $this->validate($request, [
            'price'     => 'required|numeric',

        ], [
            'price.required'           => 'وارد نمودن مبلغ الزامی است!',
            'price.numeric'            => 'برای مبلغ باید مقدار عددی وارد شود!',
        ]);
        if($budget->appassign()->sum('approved_price')+$request->input('price')<= $budget->approved_price) {
            $appassign= new Appassign();

            // $spent->added_by      = Auth::user()->id;
            $appassign->application_id             = $request->input('application');
            //   $appassign->source_id             = $request->input('source');
            //  $appassign->date                =Verta::parse($request->input('give_date'))->DateTime();
            $appassign->approved_price          =$request->input('price');
            // $appassign->year            = $request->input('year');
            $appassign->comments             =$request->input('comments');
            $appassign->budget_id             =$request->input('budget');
            $appassign->price          =0;
            $appassign->save();

            Alert::success('ثبت موفق', ' ثبت بودجه مصوب برنامه با موفقیت انجام شد');
        }else{
            Alert::error('ثبت ناموفق', 'مجموع بودجه های برنامه ها نباید از کل بودجه مصوب بیشتر باشد');
        }

        return redirect('/assigns/budgetshow/'.$request->input('budget'));

    }
    //-----------------------اختصاص اعتبار به برنامه----------------------------------------------------------
    public function allocate_app(Appassign $appassign,Request $request)
    {

        //   dd($request->input('application'));
        $this->validate($request, [
            'price' => 'required|numeric',
            'give_date' => 'required',

        ], [


            'price.required' => 'وارد نمودن مبلغ الزامی است!',
            'price.numeric' => 'برای مبلغ باید مقدار عددی وارد شود!',
            'give_date.required' => 'وارد نمودن تاریخ تخصیص اعتبار الزامی است!',


        ]);
        $old_price = $appassign->price;
        $sum_budget_price=$appassign->budget->appassign()->sum('price');
        if ($sum_budget_price + $request->input('price') <= $appassign->budget->price) {
            if ($old_price + $request->input('price') <= $appassign->approved_price) {

                $appassign->price=$old_price + $request->input('price');
                $appassign->update();
                $allocate = new Allocate_app;

                // $spent->added_by      = Auth::user()->id;
                $allocate->appassign_id = $appassign->id;
                $allocate->allocate_price = $request->input('price');
                $allocate->allocate_date = Verta::parse($request->input('give_date'))->DateTime();
                $allocate->comments = $request->input('comments');
                $allocate->save();
                Alert::success('ثبت موفق', 'تخصیص با موفقیت انجام شد');
                return back();
            }else{
                Alert::error('ثبت ناموفق', 'جمع مبالغ تخصیص یافته از بودجه مصوب بیشتر است');
                return back();
            }}else{
            Alert::error('ثبت ناموفق', 'جمع مبالغ تخصیص یافته به برنامه ها از مبلغ اختصاص یافته به بودجه کل بیشتر است');
            return back();
        }


        // dd($request);
        Alert::success('ثبت موفق', 'ثبت بودجه جدید با موفقیت انجام شد');
        return redirect('/assigns');

    }
    //----------------------------تصویب بودجه فعالیت------------------------------------------------------
    public function add2act(Appassign $appassign,Request $request)
    {

        //   dd($request->input('application'));
        $this->validate($request, [
            'price'     => 'required|numeric',


        ], [
            'price.required'           => 'وارد نمودن مبلغ الزامی است!',
            'price.numeric'            => 'برای مبلغ باید مقدار عددی وارد شود!',


        ]);
        if($appassign->actassign()->sum('approved_price')+$request->input('price')<= $appassign->approved_price) {
            $actassign = new Actassign();

            // $spent->added_by      = Auth::user()->id;
            $actassign->action_id = $request->input('action');
            // $actassign->source_id = $request->input('source');
            $actassign->appassign_id = $request->input('appassign');
            $actassign->approved_price = $request->input('price');
            // $actassign->year = $request->input('year');
            $actassign->comments = $request->input('comments');
            $actassign->price=0;
            $actassign->save();
            Alert::success('ثبت موفق', 'ثبت بودجه مصوب فعالیت با موفقیت انجام شد');
        }else{
            Alert::warning('ثبت ناموفق', 'مجموع اعتبارات فعالیت ها نباید از اعتبار برنامه بیشتر باشد');
        }
        // dd($request);

        return redirect('/assigns/showAppassign/'.$request->input('appassign'));

    }
    //-----------------------اختصاص اعتبار به فعالیت----------------------------------------------------------
    public function allocate_act(Actassign $actassign,Request $request)
    {

        //   dd($request->input('application'));
        $this->validate($request, [
            'price' => 'required|numeric',
            'give_date' => 'required',

        ], [


            'price.required' => 'وارد نمودن مبلغ الزامی است!',
            'price.numeric' => 'برای مبلغ باید مقدار عددی وارد شود!',
            'give_date.required' => 'وارد نمودن تاریخ تخصیص اعتبار الزامی است!',


        ]);
        $old_price = $actassign->price;
        $sum_budget_price=$actassign->appassign->actassign()->sum('price');
        if ($sum_budget_price + $request->input('price') <= $actassign->appassign->price) {
            if ($old_price + $request->input('price') <= $actassign->approved_price) {

                $actassign->price=$old_price + $request->input('price');
                $actassign->update();
                $allocate = new Allocate_act;

                // $spent->added_by      = Auth::user()->id;
                $allocate->actassign_id = $actassign->id;
                $allocate->allocate_price = $request->input('price');
                $allocate->allocate_date = Verta::parse($request->input('give_date'))->DateTime();
                $allocate->comments = $request->input('comments');
                $allocate->save();
                Alert::success('ثبت موفق', 'تخصیص با موفقیت انجام شد');
                return back();
            }else{
                Alert::error('ثبت ناموفق', 'جمع مبالغ تخصیص یافته از بودجه مصوب بیشتر است');
                return back();
            }}else{
            Alert::error('ثبت ناموفق', 'جمع مبالغ تخصیص یافته به فعالیت ها از مبلغ اختصاص یافته به بودجه کل بیشتر است');
            return back();
        }


        // dd($request);
        Alert::success('ثبت موفق', 'ثبت بودجه جدید با موفقیت انجام شد');
        return redirect('/assigns');

    }
    //------------------------------------تصویب بودجه ریزفعالیت------------------------------------
    public function add2sub(Actassign $actassign,Request $request)
    {

        //   dd($request->input('application'));
        $this->validate($request, [
            'price'     => 'required|numeric',


        ], [
            'price.required'           => 'وارد نمودن مبلغ الزامی است!',
            'price.numeric'            => 'برای مبلغ باید مقدار عددی وارد شود!',


        ]);
        if($actassign->subassign()->sum('approved_price')+$request->input('price')<= $actassign->approved_price) {
            $subassign = new Subassign();

            // $spent->added_by      = Auth::user()->id;
            $subassign->subaction_id = $request->input('subactionip');
            // $subassign->source_id = $request->input('sourceip');
            $subassign->actassign_id = $request->input('actassignip');
            $subassign->approved_price = $request->input('price');
            // $subassign->year = $request->input('yearip');
            $subassign->comments = $request->input('comments');
            $subassign->price =0;
            $subassign->save();
            Alert::success('ثبت موفق', 'ثبت بودجه مصوب ریز فعالیت با موفقیت انجام شد');
        }else{
            Alert::warning('ثبت ناموفق', 'مجموع بودجه های ریز فعالیت ها نباید از بودجه فعالیت بیشتر باشد');
        }
        // dd($request);

        return redirect('/assigns/showact/'.$actassign->id);

    }
//-----------------------اختصاص اعتبار به ریزفعالیت----------------------------------------------------------
    public function allocate_sub(Subassign $subassign,Request $request)
    {

        //   dd($request->input('application'));
        $this->validate($request, [
            'price' => 'required|numeric',
            'give_date' => 'required',

        ], [


            'price.required' => 'وارد نمودن مبلغ الزامی است!',
            'price.numeric' => 'برای مبلغ باید مقدار عددی وارد شود!',
            'give_date.required' => 'وارد نمودن تاریخ تخصیص اعتبار الزامی است!',


        ]);
        $old_price = $subassign->price;
        $sum_budget_price=$subassign->actassign->subassign()->sum('price');
        if ($sum_budget_price + $request->input('price') <= $subassign->actassign->price) {
            if ($old_price + $request->input('price') <= $subassign->approved_price) {

                $subassign->price=$old_price + $request->input('price');
                $subassign->update();
                $allocate = new Allocate_sub;

                // $spent->added_by      = Auth::user()->id;
                $allocate->subassign_id = $subassign->id;
                $allocate->allocate_price = $request->input('price');
                $allocate->allocate_date = Verta::parse($request->input('give_date'))->DateTime();
                $allocate->comments = $request->input('comments');
                $allocate->save();
                Alert::success('ثبت موفق', 'تخصیص با موفقیت انجام شد');
                return back();
            }else{
                Alert::error('ثبت ناموفق', 'جمع مبالغ تخصیص یافته از بودجه مصوب بیشتر است');
                return back();
            }}else{
            Alert::error('ثبت ناموفق', 'جمع مبالغ تخصیص یافته به ریز فعالیت ها از مبلغ اختصاص یافته به بودجه کل بیشتر است');
            return back();
        }


        // dd($request);
        Alert::success('ثبت موفق', 'ثبت بودجه جدید با موفقیت انجام شد');
        return redirect('/assigns');

    }
    //-======================نمایش صفحه بودجه ها===========================================================
    public function budgetindex()
    {
        //   dd('hi');
        $budgets=Budget::all();

        return view('assigns.budgetIndex', compact('budgets'));
    }
    //----------------------------------نمایش بودجه و اختصاص اعتبار به برنامه ها------------------------------------------------
    public function showbudget(Budget $budget)
    {
        //   dd('hi');
        $id=$budget->id;
        $applications=Application::all();
        $appassigns=Appassign::where('budget_id', '=',$id);
        // $actassigns
        return view('assigns.showbudget', compact('budget','applications','appassigns'));
    }
    //-----------------------------صفحه نمایش اعتبار برنامه و اختصاص اعتبار به فعالیت---------------------
    public function showappas(Application $application,Appassign $appassign)
    {
        //   dd('hi');
        $id=$appassign->id;
        $actions=Action::all();
        $actassigns=Actassign::where('appassign_id', '=',$id);
        // $actassigns
        return view('assigns.showAppas', compact('application','actions','appassign','actassigns'));
    }
    //------------------------------------------------------------------------------------------------------
    public function index()
    {
        //   dd('hi');
        $appassigns=Appassign::all();
        return view('assigns.index', compact('appassigns'));
    }





    //---------------------------------------------------------------------------------------------------------
    public function showact(Actassign $actassign)
    {
        //   dd('hi');
        $id=$actassign->id;
        $subactions=Subaction::all();
        $subassigns=Subassign::where('actassign_id', '=',$id);
        // $actassigns
        return view('assigns.showact', compact('actassign','subactions','subactions'));
    }


    //-------------------------------صفحه ویرایش بودجه --------------------------------------------------------
    public function editbudget(Budget $budget)
    {
        $users = User::all();
        $yearts=Yeart::all();
        $sources=Source::all();
        return view('assigns.editBudget', compact('budget','users','yearts','sources'));

    }
    //--------------------------------------------------عملیات ویرایش بودجه--------------------------------
    public function editbud(Budget $budget,Request $request)
    {
        $this->validate($request, [
            'price'     => 'required|numeric',
            'year'     => 'required',
            'source_code'     => 'required',
            'give_date'     => 'required',
            'sup'     => 'required',

        ], [

            'year.required'           => 'وارد نمودن سال الزامی است!',
            'price.required'           => 'وارد نمودن مبلغ الزامی است!',
            'price.numeric'            => 'برای مبلغ باید مقدار عددی وارد شود!',
            'give_date.required'       => 'وارد نمودن تاریخ تصویب اعتبار الزامی است!',
            'source_code.required'       => 'انتخاب منبع اعتبار الزامی است!',
            'sup.required'       => 'انتخاب تامین کننده الزامی است!',

        ]);
        if(0<$budget->appassign()->sum('price')){
            if($request->input('year')!=$budget->year) {
                Alert::warning('خطای ویرایش بودجه', ' با توجه به اختصاص اعتبار به فعالیت های این بودجه تغییر سال مالی امکانپذیر نمی باشد');
                return back()->withInput();
            }
        }
        if($request->input('price')<$budget->appassign()->sum('approved_price')){
            Alert::warning('خطای ویرایش بودجه', ' مبلغ بودجه نمی تواند کمتر از مجموع مبالغ مصوب به برنامه ها باشد');
            return back()->withInput();
        }
        if($request->input('price')<$budget->price){
            Alert::warning('خطای ویرایش بودجه', ' مبلغ بودجه نمی تواند کمتر از اعتبارات تخصیص یافته به بودجه باشد');
            return back()->withInput();;
        }

        if($budget->source_id==$request->input('source_code')){

        }
        else{

        }
        //  $budget= new Budget();

        // $spent->added_by      = Auth::user()->id;

        $budget->source_id             = $request->input('source_code');
        $budget->date                =Verta::parse($request->input('give_date'))->DateTime();
        $budget->approved_price          =$request->input('price');
        $budget->year            = $request->input('year');
        $budget->comments             =$request->input('comments');
        $budget->supplier             =$request->input('sup');
        try {
            $budget->update();
        }
        catch (QueryException $x) {
            Alert::warning('خطای تکرار یک منبع درآمد در سال', ' از هر منبع درآمد در یک سال فقط یک بار می توان تعریف نمود');
            return back()->withInput();;
        }

        // dd($request);
        Alert::success(' ویرایش بودجه', 'ویرایش بودجه  با موفقیت انجام شد');
        return redirect('/assigns');

    }

    //-------------------------------------------------عملیات ویرایش بودجه مصوب برنامه-----------------------------------------------------
    public function editAppAssign(Appassign $appassign,Request $request)
    {

        $this->validate($request, [
            'price'     => 'required|numeric',

        ], [
            'price.required'           => 'وارد نمودن مبلغ الزامی است!',
            'price.numeric'            => 'برای مبلغ باید مقدار عددی وارد شود!',
        ]);
        $budget=$appassign->budget;
        // dd($budget->id);
        if($request->input('price')<$appassign->price){
            Alert::warning('خطای ویرایش بودجه', ' مبلغ مصوب برنامه نمی تواند کمتر از اعتبارات تخصیص یافته به برنامه باشد');
            return back();
        }
        if($appassign->actassign()->sum('approved_price')>$request->input('price')){
            Alert::warning('خطای ویرایش بودجه', ' مبلغ مصوب برنامه نمی تواند کمتر از مجموع مبالغ مصوب فعالیت هایش باشد باشد');
            return back();
        }
        if(($budget->appassign()->sum('approved_price')-$appassign->approved_price)+$request->input('price')<= $budget->approved_price) {



            $appassign->approved_price          =$request->input('price');

            $appassign->comments             =$request->input('comments');

            $appassign->update();

            Alert::success('ثبت موفق', 'ویرایش بودجه مصوب برنامه با موفقیت انجام شد');
        }else{
            Alert::warning('ثبت ناموفق', 'مجموع مبالغ مصوب برنامه ها نباید از مبلغ کل بودجه مصوب بیشتر باشد');
        }

        return redirect('/assigns/budgetshow/'.$budget->id);

        // $spent->added_by      = Auth::user()->id;




    }
    //-====================================================================================================

    public function editActAssign(Appassign $appassign,Actassign $actassign,Request $request)
    {
        // dd('hi');
        $this->validate($request, [
            'price'     => 'required|numeric',

        ], [
            'price.required'           => 'وارد نمودن مبلغ الزامی است!',
            'price.numeric'            => 'برای مبلغ باید مقدار عددی وارد شود!',
        ]);
        if($request->input('price')<$actassign->price){
            Alert::warning('خطای ویرایش بودجه', ' مبلغ مصوب فعالیت نمی تواند کمتر از اعتبارات تخصیص یافته به فعالیت باشد');
            return back();
        }
        if($actassign->subassign()->sum('approved_price')>$request->input('price')){
            Alert::warning('خطای ویرایش بودجه', ' مبلغ مصوب فعالیت نمی تواند کمتر از مجموع مبالغ مصوب ریزفعالیت هایش باشد باشد');
            return back();
        }
        if(($appassign->actassign()->sum('approved_price')-$actassign->approved_price)+$request->input('price')<= $appassign->approved_price) {



            $actassign->approved_price          =$request->input('price');

            $actassign->comments             =$request->input('comments');

            $actassign->update();

            Alert::success('ثبت موفق', 'ویرایش اعتبار فعالیت با موفقیت انجام شد');
        }else{
            Alert::warning('ثبت ناموفق', 'مجموع اعتبارات فعالیت ها نباید از اعتبار کل برنامه بیشتر باشد');
        }
        return redirect('/assigns/showAppassign/'.$appassign->id);
    }
    //-====================================================================================================
    public function editSubAssign(Actassign $actassign,Subassign $subassign,Request $request)
    {
        // dd('hi');
        $this->validate($request, [
            'price'     => 'required|numeric',

        ], [
            'price.required'           => 'وارد نمودن مبلغ الزامی است!',
            'price.numeric'            => 'برای مبلغ باید مقدار عددی وارد شود!',
        ]);
        if($request->input('price')<$subassign->price){
            Alert::warning('خطای ویرایش بودجه', ' مبلغ مصوب ریزفعالیت نمی تواند کمتر از اعتبارات تخصیص یافته به ریزفعالیت باشد');
            return back();
        }
        if(($actassign->subassign()->sum('approved_price')-$subassign->approved_price)+$request->input('price')<= $actassign->approved_price) {



            $subassign->approved_price           =$request->input('price');

            $subassign->comments             =$request->input('comments');

            $subassign->update();

            Alert::success('ثبت موفق', 'ویرایش اعتبار ریزفعالیت با موفقیت انجام شد');
        }else{
            Alert::warning('ثبت ناموفق', 'مجموع اعتبارات ریز فعالیت ها نباید از اعتبار کل فعالیت بیشتر باشد');
        }
        return redirect('/assigns/showact/'.$actassign->id);
    }
    //----------------------- ویرایش اختصاص بودجه کلی----------------------------------------------------------
    public function editallocate_bud(Alocate_budget $alocate_budget,Request $request)
    {

        //   dd($request->input('application'));
        $this->validate($request, [
            'price' => 'required|numeric',
            'give_date' => 'required',
        ], [
            'price.required' => 'وارد نمودن مبلغ الزامی است!',
            'price.numeric' => 'برای مبلغ باید مقدار عددی وارد شود!',
            'give_date.required' => 'وارد نمودن تاریخ تخصیص اعتبار الزامی است!',
        ]);

        $budget=$alocate_budget->budget;
        //  dd($budget);
        $old_price = $budget->price;
        $old_allocate=$old_price - $alocate_budget->allocate_price;
        // dd($old_allocate, $old_price,$alocate_budget->allocate_price);
        if($request->input('price')+$old_allocate<$budget->appassign()->sum('price')){
            Alert::warning('خطای ویرایش تخصیص', ' مبلغ بودجه نمی تواند از مجموع مبالغ اختصاص داده شده به برنامه ها کمتر باشد');
            return back();
        }

        if ($old_allocate + $request->input('price') <= $budget->approved_price) {
            $budget->price=$old_allocate + $request->input('price');
            $budget->update();

            $alocate_budget->allocate_price = $request->input('price');
            $alocate_budget->allocate_date = Verta::parse($request->input('give_date'))->DateTime();
            $alocate_budget->comments = $request->input('comments');
            $alocate_budget->update();
            Alert::success('ویرایش موفق', 'ویرایش تخصیص با موفقیت انجام شد');
            return back();
        }else{
            Alert::error('zzzثبت ناموفق', 'جمع مبالغ تخصیص یافته از مبلغ مصوب بیشتر است');
            return back();
        }

    }
    //----------------------- دیلیت اختصاص بودجه کلی----------------------------------------------------------
    public function deleteallocate_bud(Alocate_budget $alocate_budget)
    {
        $budget=$alocate_budget->budget;
        $old_price = $budget->price;
        $old_allocate=$old_price - $alocate_budget->allocate_price;
        // dd($old_allocate, $old_price,$alocate_budget->allocate_price);
        if($old_allocate<$budget->appassign()->sum('price')){
            Alert::error('خطای حذف تخصیص', 'مبلغ بودجه نمی تواند از مجموع مبالغ اختصاص داده شده به برنامه ها کمتر باشد');
            return back();
        }
        $budget->price=$old_allocate ;
        $budget->update();

        $alocate_budget->delete();
        Alert::success('حذف موفق', 'حذف تخصیص با موفقیت انجام شد');
        return back();



    }
    //----------------------- ویرایش اختصاص بودجه کلی----------------------------------------------------------
    public function editallocate_app(Allocate_app $allocate_app,Request $request)
    {

        //   dd($request->input('application'));
        $this->validate($request, [
            'price' => 'required|numeric',
            'give_date' => 'required',
        ], [
            'price.required' => 'وارد نمودن مبلغ الزامی است!',
            'price.numeric' => 'برای مبلغ باید مقدار عددی وارد شود!',
            'give_date.required' => 'وارد نمودن تاریخ تخصیص اعتبار الزامی است!',
        ]);

        $appassign=$allocate_app->appassign;
        //  dd($appassign);
        $old_price = $appassign->price;
        $old_allocate=$old_price - $allocate_app->allocate_price;
        //dd($old_allocate, $old_price,$allocate_app->allocate_price);
        if($request->input('price')+$old_allocate<$appassign->actassign()->sum('price')){
            Alert::warning('خطای ویرایش تخصیص', ' مبلغ تخصیص نمی تواند از مجموع مبالغ اختصاص داده شده به فعالیت ها کمتر باشد');
            return back();
        }
        if ($old_allocate + $request->input('price') <= $appassign->budget->price) {
            if ($old_allocate + $request->input('price') <= $appassign->approved_price) {
                $appassign->price=$old_allocate + $request->input('price');
                $appassign->update();

                $allocate_app->allocate_price = $request->input('price');
                $allocate_app->allocate_date = Verta::parse($request->input('give_date'))->DateTime();
                $allocate_app->comments = $request->input('comments');
                $allocate_app->update();
                Alert::success('ویرایش موفق', 'ویرایش تخصیص با موفقیت انجام شد');
                return back();
            }else{
                Alert::error('ثبت ناموفق', 'جمع مبالغ تخصیص یافته از مبلغ مصوب بیشتر است');
                return back();
            }}else{
            Alert::error('ثبت ناموفق', 'جمع مبالغ تخصیص یافته از اعتبار اختصاص یافته بودجه بیشتر است');
            return back();
        }

    }
    //----------------------- دیلیت اختصاص بودجه کلی----------------------------------------------------------
    public function deleteallocate_app(Allocate_app $allocate_app)
    {
        $appassign=$allocate_app->appassign;
        $old_price = $appassign->price;
        $old_allocate=$old_price - $allocate_app->allocate_price;
        // dd($old_allocate, $old_price,$alocate_budget->allocate_price);
        if($old_allocate<$appassign->actassign()->sum('price')){
            Alert::error('خطای حذف تخصیص', 'مبلغ اختصاص داده شده به برنامه نمی تواند از مجموع مبالغ اختصاص داده شده به فعالیت هایش کمتر باشد');
            return back();
        }
        $appassign->price=$old_allocate ;
        $appassign->update();

        $allocate_app->delete();
        Alert::success('حذف موفق', 'حذف تخصیص با موفقیت انجام شد');
        return back();



    }
    //----------------------- ویرایش اختصاص بودجه کلی----------------------------------------------------------
    public function editallocate_act(Allocate_act $allocate_act,Request $request)
    {

        $this->validate($request, [
            'price' => 'required|numeric',
            'give_date' => 'required',
        ], [
            'price.required' => 'وارد نمودن مبلغ الزامی است!',
            'price.numeric' => 'برای مبلغ باید مقدار عددی وارد شود!',
            'give_date.required' => 'وارد نمودن تاریخ تخصیص اعتبار الزامی است!',
        ]);

        $actassign=$allocate_act->actassign;

        $old_price = $actassign->price;
        $old_allocate=$old_price - $allocate_act->allocate_price;
        //dd($old_allocate, $old_price,$allocate_app->allocate_price);
        if($request->input('price')+$old_allocate<$actassign->subassign()->sum('price')){
            Alert::warning('خطای ویرایش تخصیص', ' مبلغ تخصیص نمی تواند از مجموع مبالغ اختصاص داده شده به فعالیت ها کمتر باشد');
            return back();
        }
        if ($old_allocate + $request->input('price') <= $actassign->appassign->price) {
            if ($old_allocate + $request->input('price') <= $actassign->approved_price) {
                $actassign->price=$old_allocate + $request->input('price');
                $actassign->update();

                $allocate_act->allocate_price = $request->input('price');
                $allocate_act->allocate_date = Verta::parse($request->input('give_date'))->DateTime();
                $allocate_act->comments = $request->input('comments');
                $allocate_act->update();
                Alert::success('ویرایش موفق', 'ویرایش تخصیص با موفقیت انجام شد');
                return back();
            }else{
                Alert::error('ثبت ناموفق', 'جمع مبالغ تخصیص یافته از مبلغ مصوب بیشتر است');
                return back();
            }}else{
            Alert::error('ثبت ناموفق', 'جمع مبالغ تخصیص یافته به فعالیت ها از اعتبار اختصاص یافته به برنامه بیشتر است');
            return back();
        }

    }
    //----------------------- دیلیت اختصاص بودجه کلی----------------------------------------------------------
    public function deleteallocate_act(Allocate_act $allocate_act)
    {
        $actassign=$allocate_act->actassign;
        $old_price = $actassign->price;
        $old_allocate=$old_price - $allocate_act->allocate_price;
        // dd($old_allocate, $old_price,$alocate_budget->allocate_price);
        if($old_allocate<$actassign->subassign()->sum('price')){
            Alert::error('خطای حذف تخصیص', 'مبلغ اختصاص داده شده به فعالیت نمی تواند از مجموع مبالغ اختصاص داده شده به ریزفعالیت هایش کمتر باشد');
            return back();
        }
        $actassign->price=$old_allocate ;
        $actassign->update();

        $allocate_act->delete();
        Alert::success('حذف موفق', 'حذف تخصیص با موفقیت انجام شد');
        return back();



    }
    //----------------------- ویرایش اختصاص بودجه کلی----------------------------------------------------------
    public function editallocate_sub(Allocate_sub $allocate_sub,Request $request)
    {

        $this->validate($request, [
            'price' => 'required|numeric',
            'give_date' => 'required',
        ], [
            'price.required' => 'وارد نمودن مبلغ الزامی است!',
            'price.numeric' => 'برای مبلغ باید مقدار عددی وارد شود!',
            'give_date.required' => 'وارد نمودن تاریخ تخصیص اعتبار الزامی است!',
        ]);

        $subassign=$allocate_sub->subassign;

        $old_price = $subassign->price;
        $old_allocate=$old_price - $allocate_sub->allocate_price;
        //dd($old_allocate, $old_price,$allocate_app->allocate_price);
        if($request->input('price')+$old_allocate<$subassign->vsubassign->sum_spent){
            Alert::warning('خطای ویرایش تخصیص', ' مبلغ تخصیص نمی تواند از مجموع مبالغ اختصاص داده شده به فعالیت ها کمتر باشد');
            return back();
        }
        if ($old_allocate + $request->input('price') <= $subassign->actassign->price) {
            if ($old_allocate + $request->input('price') <= $subassign->approved_price) {
                $subassign->price=$old_allocate + $request->input('price');
                $subassign->update();

                $allocate_sub->allocate_price = $request->input('price');
                $allocate_sub->allocate_date = Verta::parse($request->input('give_date'))->DateTime();
                $allocate_sub->comments = $request->input('comments');
                $allocate_sub->update();
                Alert::success('ویرایش موفق', 'ویرایش تخصیص با موفقیت انجام شد');
                return back();
            }else{
                Alert::error('ثبت ناموفق', 'جمع مبالغ تخصیص یافته از مبلغ مصوب بیشتر است');
                return back();
            }}else{
            Alert::error('ثبت ناموفق', 'جمع مبالغ تخصیص یافته از اعتبار اختصاص یافته به ریزفعالیت بیشتر است');
            return back();
        }

    }
    //----------------------- دیلیت اختصاص بودجه کلی----------------------------------------------------------
    public function deleteallocate_sub(Allocate_sub $allocate_sub)
    {
        $subassign=$allocate_sub->subassign;
        $old_price = $subassign->price;
        $old_allocate=$old_price - $allocate_sub->allocate_price;
        // dd($old_allocate, $old_price,$alocate_budget->allocate_price);
        $sum_spent=$subassign->vsubassign->sum_spent?$subassign->vsubassign->sum_spent:0;
        // dd($sum_spent);
        if($old_allocate<$sum_spent){
            Alert::error('خطای حذف تخصیص', 'مبلغ اختصاص داده شده به ریز فعالیت نمی تواند از مجموع مبالغ هزینه هایش کمتر باشد');
            return back();
        }
        $subassign->price=$old_allocate ;
        $subassign->update();

        $allocate_sub->delete();
        Alert::success('حذف موفق', 'حذف تخصیص با موفقیت انجام شد');
        return back();



    }
    //-====================================================================================================

}
