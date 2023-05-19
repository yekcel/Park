<?php

namespace App\Http\Controllers;

use App\Application;
use App\Action;
use App\Yeart;
use App\Vbudget;
use App\Vappassign;
use App\Vactassign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        if( Input::has('radio3')) {
            $year=$request->input('radio3');
            $request->session()->put('year',$year);

        }else{
            $year=session()->get('year');
        }



       $applications=Application::withCount([
           'Vappassign AS price_total' => function ($query) use ($year) {
               $query->select(DB::raw("SUM(price) as total"))->where([['year', '=', $year]]);
           }
       ])->withCount([
           'Vappassign AS spent_total' => function ($query) use ($year) {
               $query->select(DB::raw("SUM(sum_spent) as total"))->where([['year', '=', $year]]);
           }
       ])->get();
$vbudgets=Vbudget::where('year','=',$year)->get();
//dd($vbudgets);
        return view('applications.index', compact('applications','year','vbudgets'));
    }
    //------------------------------------------------------------------------
    public function select_year()
    {
         //  dd('hi');
        $year1=verta()->year;
       // dd($year1);
        $years=Yeart::all();
        return view('applications.select_year', compact('years','year1'));
    }
    //------------------------------------------------------------------------
    public function app(Application $application)
    {

        if (session()->has('year')) {
            $year=session()->get('year');
        }else{
            return redirect(url('/select_year'));
        }
          //   dd($year);
        $id=$application->id;

        $actions=Action::where('application_id','=',$id)->withCount([
            'Vactassign AS price_total' => function ($query) use ($year) {
                $query->select(DB::raw("SUM(price) as total"))->where([['year', '=', $year]]);
            }
        ])->withCount([
            'Vactassign AS spent_total' => function ($query) use ($year) {
                $query->select(DB::raw("SUM(sum_spent) as total"))->where([['year', '=', $year]]);
            }
        ])->get();
        $vappassigns = Vappassign::where([['year','=',$year],['application_id','=',$id]])->get();

       return view('applications.app', compact('application','actions','vappassigns','year'));
     //   return view('applications.app', compact('application','actions'));
    }
    //------------------------------------------------------------------------
    public function ajaxGetAction($id)
    {
        $actions = Action::where('application_id',$id)->pluck('name','id');
        // $credits = Credit::where('source_code', '=', Input::get('col_id'))->get();
        return view('applications.action')->with('actions', $actions);
        /*  return response()->json($credits);*/
    }
}
