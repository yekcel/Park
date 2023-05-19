<?php

namespace App\Http\Controllers;

use App\Action;
use App\Subaction;
use App\Cost;
use App\Spent;
use App\Credit;
use App\Source;
use App\Contract;
use App\Yeart;
use App\Vsubtassign;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class SubactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function app(Subaction $subaction)
    {

        if (session()->has('year')) {
            $year=session()->get('year');
        }else{
            return redirect(url('/select_year'));
        }
        $id= $subaction->id;
        //$costs=Cost::all();
        $costinfs = Cost::withCount([
            'Spent AS price_total' => function ($query) use($year,$id) {
                $query->select(DB::raw("SUM(price) as total"))->where([['year', '=', $year],['subaction_id','=',$id],['status','=',1]]);
            }
        ])->get();
        $spents=Spent::where([['subaction_id', '=',$id],['year', '=',$year]])->OrderBy('id', 'desc')->paginate(20);
       // dd($spents);
        $contracts=Contract::where('subaction_id', '=',$id)->OrderBy('id', 'desc')->paginate(20);
        $vsubtassigns=Vsubtassign::where([['year','=',$year],['subaction_id','=',$id]])->get();
$yearts=Yeart::all();
        return view('subactions.app', compact('subaction','spents','contracts','yearts','vsubtassigns','costinfs'));
    }
}
