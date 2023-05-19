<?php

namespace App\Http\Controllers;
use App\Action;
use App\Subaction;
use App\Vactassign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ActionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function app(Action $action)
    {
        if (session()->has('year')) {
            $year=session()->get('year');
        }else{
            return redirect(url('/select_year'));
        }
        $id=$action->id;

        $subactions=Subaction::where('action_id','=',$id)->withCount([
            'Vsubtassign AS price_total' => function ($query) use ($year) {
                $query->select(DB::raw("SUM(price) as total"))->where([['year', '=', $year]]);
            }
        ])->withCount([
            'Vsubtassign AS spent_total' => function ($query) use ($year) {
                $query->select(DB::raw("SUM(sum_spent) as total"))->where([['year', '=', $year]]);
            }
        ])->get();
        if (session()->has('year')) {
            $year=session()->get('year');
        }else{
            return redirect(url('/select_year'));
        }
$vactassigns=Vactassign::where([['year','=',$year],['action_id','=',$id]])->get();

       return view('actions.app', compact('action','subactions','vactassigns'));
   //     return view('actions.app', compact('action','subactions'));
    }
    //------------------------------------------------------------------------
    public function ajaxGetSubaction($id)
    {
        $subactions = Subaction::where('action_id',$id)->pluck('name','id');
        // $credits = Credit::where('source_code', '=', Input::get('col_id'))->get();
        return view('actions.subaction')->with('subactions', $subactions);
        /*  return response()->json($credits);*/
    }
}
