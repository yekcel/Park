<?php

namespace App\Http\Controllers;

use App\Application;
use App\Action;
use App\Exports\subBudgetExport;
use App\Exports\subCreditExport;
use App\Exports\vahedsfanExport;
use App\Exports\vahedspishExport;
use App\Exports\vahedsroshdExport;
use App\Subaction;
use App\Contract;
use App\Exports\export1;
use App\Source;
use App\Spent;
use App\Vappassign;
use App\Yeart;
use Hekmatinasser\Verta\Facades\Verta;
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
Use Alert;

class ExportController extends Controller
{
    //----------------------------------------------------------------------------------------------------------------------
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function export1(Request $request)
    {


        //dd('hi');
        $app1= null;
        $act1= null;
        $sact1= null;
        $sacod1= null;
        $sdate1= null;
        $edate1= null;
        $year1= null;
        $src1= null;
        $crdt1= null;
        $cost1= null;
        $ctcode1= null;
        $spentfilter = Spent::OrderBy('id', 'desc');
        //---------------
        if ($request->input('sacod1') != null) {
            $sacod1= $request->input('sacod1');
        } else {
            if ($request->input('app1') != null) {
                if ($request->input('act1') != null) {
                    if ($request->input('sact1') != null) {
                        $sact1= $request->input('sact1');

                    } else {
                        $act1= $request->input('act1');

                    }
                } else {
                    $app1= $request->input('app1');

                }
            }

        }

        //--------------
        if ($request->input('year1') != null) {
            $year1= $request->input('year1');

        }
        if ($request->input('sdate1') != null) {
            $sdate1= Verta::parse($request->input('sdate1'))->DateTime();

        }
        if ($request->input('edate1') != null) {
            $edate1=Verta::parse($request->input('edate1'))->DateTime();

        }
        if ($request->input('cost1') != null) {
            $cost1= $request->input('cost1');


        }
        //----------------
        if ($request->input('ctcode1') != null) {
            $ctcode1= $request->input('ctcode1');

        } else {
            if ($request->input('src1') != null) {
                if ($request->input('crdt1') != null) {
                    $crdt1= $request->input('crdt1');
                } else {
                    $src1= $request->input('src1');

                }
            }
        }
        return Excel::download(new export1($app1,$act1,$sact1,$sacod1,$sdate1,$edate1,$year1,$src1,$crdt1,$cost1,$ctcode1), 'report1.xlsx');
    }
    //------------------------------------------------------------------------------------------------------
    public function export2(Request $request)
    {


        //dd('hi');
        $d1= null;
        $d2= null;
        $year1= null;


        //----------------------------------------------------------------------------------------------
        if ($request->input('d1') != null) {
        $d1= $request->input('d1');
    }
        if ($request->input('d2') != null) {
            $d2= $request->input('d2');
        }
        if ($request->input('year1') != null) {
            $year1= $request->input('year1');
        }
        //dd('asdasdasd');
        return Excel::download(new subBudgetExport($d1,$d2,$year1), 'SubBudget.xlsx');
    }
    //------------------------------------------------------------------------------------------------------
    public function subcredit(Request $request)
    {


        //dd('hi');
        $d1= null;
        $d2= null;
        $year1= null;


        //----------------------------------------------------------------------------------------------
        if ($request->input('d1') != null) {
            $d1= $request->input('d1');
        }
        if ($request->input('d2') != null) {
            $d2= $request->input('d2');
        }
        if ($request->input('year1') != null) {
            $year1= $request->input('year1');
        }
        //dd('asdasdasd');
        return Excel::download(new subCreditExport($d1,$d2,$year1), 'SubCredit.xlsx');
    }
    //------------------------------------------------------------------------------------------------------
    public function vahedsfan(Request $request)
    {


        //dd('hi');
        $d1= null;
        $d2= null;
        $year1= null;


        //----------------------------------------------------------------------------------------------
        if ($request->input('d1') != null) {
            $d1= $request->input('d1');
        }
        if ($request->input('d2') != null) {
            $d2= $request->input('d2');
        }
        if ($request->input('year1') != null) {
            $year1= $request->input('year1');
        }
        //dd('asdasdasd');
        return Excel::download(new vahedsfanExport($d1,$d2,$year1), 'techUnit.xlsx');
    }
    //------------------------------------------------------------------------------------------------------
    public function vahedspish(Request $request)
    {


        //dd('hi');
        $d1= null;
        $d2= null;
        $year1= null;


        //----------------------------------------------------------------------------------------------
        if ($request->input('d1') != null) {
            $d1= $request->input('d1');
        }
        if ($request->input('d2') != null) {
            $d2= $request->input('d2');
        }
        if ($request->input('year1') != null) {
            $year1= $request->input('year1');
        }
        //dd('asdasdasd');
        return Excel::download(new vahedspishExport($d1,$d2,$year1), 'priUnit.xlsx');
    }
    //------------------------------------------------------------------------------------------------------
    public function vahedsroshd(Request $request)
    {


        //dd('hi');
        $d1= null;
        $d2= null;
        $year1= null;


        //----------------------------------------------------------------------------------------------
        if ($request->input('d1') != null) {
            $d1= $request->input('d1');
        }
        if ($request->input('d2') != null) {
            $d2= $request->input('d2');
        }
        if ($request->input('year1') != null) {
            $year1= $request->input('year1');
        }
        //dd('asdasdasd');
        return Excel::download(new vahedsroshdExport($d1,$d2,$year1), 'growUnit.xlsx');
    }
}
