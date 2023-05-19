<?php

namespace App\Http\Controllers;

use App\Application;
use App\Action;
use App\Subaction;
use App\Contract;
use App\Exports\export1;
use App\Source;
use App\Spent;
use App\Company;
use App\Vappassign;
use App\Vsubbedget;
use App\Vsubcredit;
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



class ReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('reports.index');
    }

    //-------------------------------------------------------------------------------------------------------------------
    public function spent_subaction(Request $request)
    {
        //   dd('hi');
        $applications = Application::all();
        $sources = Source::all();
        $yearts = Yeart::all();
        $spentfilter = Spent::OrderBy('id', 'desc')->where('status', '=', 1);
        //----------------------------------------------------------------------------------------------
        if ($request->input('subaction_code') != null) {
            $sa_code = $request->input('subaction_code');
            $spentfilter->with('Subaction')
                ->whereHas('Subaction', function ($q) use ($sa_code) {
                    $q->where([['subaction_code', '=', $sa_code]]);
                });


        } else {
            if ($request->input('appin') != null) {
                if ($request->input('actin') != null) {
                    if ($request->input('sain') != null) {
                        $spentfilter->where([['subaction_id', '=', $request->input('sain')]]);

                    } else {
                        $actid = $request->input('actin');
                        $spentfilter->with('Subaction')
                            ->whereHas('Subaction', function ($q) use ($actid) {
                                $q->where([['action_id', '=', $actid]]);
                            });

                    }
                } else {
                    $appid = $request->input('appin');
                    $spentfilter->with(array('Subaction', 'Subaction.Action'))
                        ->whereHas('Subaction.Action', function ($q) use ($appid) {
                            $q->where([['application_id', '=', $appid]]);
                        });

                }
            }

        }
        //----------------------------------------------------------------------------------------------
        if ($request->input('year') != null) {
            $spentfilter->where([['year', '=', $request->input('year')]]);

        }
        if ($request->input('give_date') != null) {
            $spentfilter->where([['spend_date', '>=', Verta::parse($request->input('give_date'))->DateTime()]]);

        }
        if ($request->input('start_date') != null) {
            $spentfilter->where([['spend_date', '<=', Verta::parse($request->input('start_date'))->DateTime()]]);

        }
        if ($request->input('cost') != null) {
            $cost_code = $request->input('cost');
            $spentfilter->with('Cost')
                ->whereHas('Cost', function ($q) use ($cost_code) {
                    $q->where([['cost_code', '=', $cost_code]]);
                });


        }
        //-------------------------------------------------------------------------------------------------
        if ($request->input('credit_code') != null) {
            $spentfilter->where([['credit_id', '=', $request->input('credit_code')]]);

        } else {
            if ($request->input('source_code') != null) {
                if ($request->input('credit') != null) {
                    $spentfilter->where([['credit_id', '=', $request->input('credit')]]);
                } else {
                    $actid = $request->input('source_code');
                    $spentfilter->with('Credit')
                        ->whereHas('Credit', function ($q) use ($actid) {
                            $q->where([['source_id', '=', $actid]]);
                        });

                }
            }
        }

        $spents = $spentfilter->paginate(20);
        //   $exspents=$spentfilter->get();

        $app1 = $request->input('appin');
        $act1 = $request->input('actin');
        $sact1 = $request->input('sain');
        $sacod1 = $request->input('subaction_code');
        $sdate1 = $request->input('give_date');
        $edate1 = $request->input('start_date');
        $year1 = $request->input('year');
        $src1 = $request->input('source_code');
        $crdt1 = $request->input('credit');
        $cost1 = $request->input('cost');
        $ctcode1 = $request->input('credit_code');

        return view('reports.spentReport', compact('applications', 'spents', 'sources', 'yearts', 'app1', 'act1', 'sact1', 'sacod1', 'sdate1', 'edate1', 'year1', 'src1', 'crdt1', 'cost1', 'ctcode1'));
    }

    //---------------------------------------------------------------------------------------------------------------------------------------
    public function fanavar_pish(Request $request)
    {
        $year = 1398;
        $seas = 1;
        $contractfilter = Contract::OrderBy('id', 'desc')->where([['level', '=', 1], ['status', '=', 1]]);
        if ($request->input('year') != null) {
            $year = $request->input('year');
        }
        $contractfilter->with('Conassign');
        /*  ->whereHas('Conassign', function ($q) use ($year) {
             $q->where([['year', '=', $year]]);
         });*/
        $date1 = verta();

        $date2 = verta();
        if ($request->input('season') != null) {
            $seas = $request->input('season');
        }
        if ($seas == 1) {

            $date1->year = $year;
            $date1->month = 1;
            $date1->day = 1;
            $date2->hour = 0;
            $date2->minute = 0;


            $date2->year = $year;
            $date2->month = 3;
            $date2->day = 31;
            $date2->hour = 23;
            $date2->minute = 59;

        } elseif ($seas == 2) {
            $date1->year = $year;
            $date1->month = 4;
            $date1->day = 1;

            $date2->year = $year;
            $date2->month = 6;
            $date2->day = 31;
            $date2->hour = 23;
            $date2->minute = 59;
        } elseif ($seas == 3) {
            $date1->year = $year;
            $date1->month = 7;
            $date1->day = 1;

            $date2->year = $year;
            $date2->month = 9;
            $date2->day = 30;
            $date2->hour = 23;
            $date2->minute = 59;
        } elseif ($seas == 4) {
            $date1->year = $year;
            $date1->month = 10;
            $date1->day = 1;

            $date2->year = $year;
            $date2->month = 13;
            $date2->day = 1;
            $date2->hour = 0;
            $date2->minute = 0;
        }


        //   $d1= Verta::parse($date1)->DateTime();
        $d1 = $date1->formatGregorian('Y-m-d H:i');
        $d2 = $date2->formatGregorian('Y-m-d H:i');
        $contractfilter->with('Spent');
        /* ->whereHas('Spent', function ($q) use ($d1) {
             $q->where([['spend_date', '>=', $d1]]);
         });
     $contractfilter->with('Spent')
         ->whereHas('Spent', function ($q) use ($d2) {
             $q->where([['spend_date', '>=', $d2]]);
         });*/
        $contracts = $contractfilter->paginate(20);
        $year1 = $year;
        $season1 = $request->input('season');
        $yearts = Yeart::all();

        return view('reports.3monthFanavarPish', compact('contracts', 'yearts', 'year1', 'season1', 'd1', 'd2'));
    }

    //---------------------------------------------------------------------------------------------------------------------------------------
    public function roshd(Request $request)
    {
        $year = 1398;
        $seas = 1;
        $contractfilter = Contract::OrderBy('id', 'desc')->where([['level', '=', 2], ['status', '=', 1]]);
        if ($request->input('year') != null) {
            $year = $request->input('year');
        }
        $contractfilter->with('Conassign');
        /*  ->whereHas('Conassign', function ($q) use ($year) {
             $q->where([['year', '=', $year]]);
         });*/
        $date1 = verta();

        $date2 = verta();
        if ($request->input('season') != null) {
            $seas = $request->input('season');
        }
        if ($seas == 1) {

            $date1->year = $year;
            $date1->month = 1;
            $date1->day = 1;
            $date2->hour = 0;
            $date2->minute = 0;


            $date2->year = $year;
            $date2->month = 3;
            $date2->day = 31;
            $date2->hour = 23;
            $date2->minute = 59;

        } elseif ($seas == 2) {
            $date1->year = $year;
            $date1->month = 4;
            $date1->day = 1;

            $date2->year = $year;
            $date2->month = 6;
            $date2->day = 31;
            $date2->hour = 23;
            $date2->minute = 59;
        } elseif ($seas == 3) {
            $date1->year = $year;
            $date1->month = 7;
            $date1->day = 1;

            $date2->year = $year;
            $date2->month = 9;
            $date2->day = 30;
            $date2->hour = 23;
            $date2->minute = 59;
        } elseif ($seas == 4) {
            $date1->year = $year;
            $date1->month = 10;
            $date1->day = 1;

            $date2->year = $year;
            $date2->month = 13;
            $date2->day = 1;
            $date2->hour = 0;
            $date2->minute = 0;
        }


        //   $d1= Verta::parse($date1)->DateTime();
        $d1 = $date1->formatGregorian('Y-m-d H:i');
        $d2 = $date2->formatGregorian('Y-m-d H:i');
        $contractfilter->with('Spent');
        /* ->whereHas('Spent', function ($q) use ($d1) {
             $q->where([['spend_date', '>=', $d1]]);
         });
     $contractfilter->with('Spent')
         ->whereHas('Spent', function ($q) use ($d2) {
             $q->where([['spend_date', '>=', $d2]]);
         });*/
        $contracts = $contractfilter->paginate(20);
        $year1 = $year;
        $season1 = $request->input('season');
        $yearts = Yeart::all();

        return view('reports.3monthRoshd', compact('contracts', 'yearts', 'year1', 'season1', 'd1', 'd2'));
    }

    //---------------------------------------------------------------------------------------------------------------------------------------
    public function fanavar(Request $request)
    {
        $year = 1398;
        $seas = 1;
        $contractfilter = Contract::OrderBy('id', 'desc')->where([['level', '=', 3], ['status', '=', 1]]);
        if ($request->input('year') != null) {
            $year = $request->input('year');
        }
        $contractfilter->with('Conassign');
        /*  ->whereHas('Conassign', function ($q) use ($year) {
             $q->where([['year', '=', $year]]);
         });*/
        $date1 = verta();

        $date2 = verta();
        if ($request->input('season') != null) {
            $seas = $request->input('season');
        }
        if ($seas == 1) {

            $date1->year = $year;
            $date1->month = 1;
            $date1->day = 1;
            $date2->hour = 0;
            $date2->minute = 0;


            $date2->year = $year;
            $date2->month = 3;
            $date2->day = 31;
            $date2->hour = 23;
            $date2->minute = 59;

        } elseif ($seas == 2) {
            $date1->year = $year;
            $date1->month = 4;
            $date1->day = 1;

            $date2->year = $year;
            $date2->month = 6;
            $date2->day = 31;
            $date2->hour = 23;
            $date2->minute = 59;
        } elseif ($seas == 3) {
            $date1->year = $year;
            $date1->month = 7;
            $date1->day = 1;

            $date2->year = $year;
            $date2->month = 9;
            $date2->day = 30;
            $date2->hour = 23;
            $date2->minute = 59;
        } elseif ($seas == 4) {
            $date1->year = $year;
            $date1->month = 10;
            $date1->day = 1;

            $date2->year = $year;
            $date2->month = 13;
            $date2->day = 1;
            $date2->hour = 0;
            $date2->minute = 0;
        }


        //   $d1= Verta::parse($date1)->DateTime();
        $d1 = $date1->formatGregorian('Y-m-d H:i');
        $d2 = $date2->formatGregorian('Y-m-d H:i');
        $contractfilter->with('Spent');
        /* ->whereHas('Spent', function ($q) use ($d1) {
             $q->where([['spend_date', '>=', $d1]]);
         });
     $contractfilter->with('Spent')
         ->whereHas('Spent', function ($q) use ($d2) {
             $q->where([['spend_date', '>=', $d2]]);
         });*/
        $contracts = $contractfilter->paginate(20);
        $year1 = $year;
        $season1 = $request->input('season');
        $yearts = Yeart::all();

        return view('reports.3monthFanavar', compact('contracts', 'yearts', 'year1', 'season1', 'd1', 'd2'));
    }

//------------------------------------------------------------------------------------------------------------------------------------------
    public function appspent(Request $request)
    {
        $year = 1398;


        if ($request->input('yearip') != null) {
            $year = $request->input('yearip');

        }
        $applications = Application::withCount([
            'Vappassign AS price_total' => function ($query) use ($year) {
                $query->select(DB::raw("SUM(price) as total"))->where([['year', '=', $year]]);
            }
        ])->withCount([
            'Vappassign AS spent_total' => function ($query) use ($year) {
                $query->select(DB::raw("SUM(sum_spent) as total"))->where([['year', '=', $year]]);
            }
        ])->get();

        // dd($applications);

        $year1 = $year;

        $yearts = Yeart::all();

        return view('reports.Apps', compact('applications', 'yearts', 'year1'));
    }

//------------------------------------------------------------------------------------------------------------------------------------------
    public function actspent(Request $request)
    {
        $year = 1398;


        if ($request->input('yearip') != null) {
            $year = $request->input('yearip');

        }
        $actions = Action::withCount([
            'Vactassign AS price_total' => function ($query) use ($year) {
                $query->select(DB::raw("SUM(price) as total"))->where([['year', '=', $year]]);
            }
        ])->withCount([
            'Vactassign AS spent_total' => function ($query) use ($year) {
                $query->select(DB::raw("SUM(sum_spent) as total"))->where([['year', '=', $year]]);
            }
        ])->get();

        // dd($applications);

        $year1 = $year;

        $yearts = Yeart::all();

        return view('reports.Acts', compact('actions', 'yearts', 'year1'));
    }

    //------------------------------------------------------------------------------------------------------------------------------------------
    public function subactspent(Request $request)
    {
        $year = 1398;


        if ($request->input('yearip') != null) {
            $year = $request->input('yearip');

        }
        $subactions = Subaction::withCount([
            'Vsubtassign AS price_total' => function ($query) use ($year) {
                $query->select(DB::raw("SUM(price) as total"))->where([['year', '=', $year]]);
            }
        ])->withCount([
            'Vsubtassign AS spent_total' => function ($query) use ($year) {
                $query->select(DB::raw("SUM(sum_spent) as total"))->where([['year', '=', $year]]);
            }
        ])->get();

        // dd($applications);

        $year1 = $year;

        $yearts = Yeart::all();

        return view('reports.SubActs', compact('subactions', 'yearts', 'year1'));
    }

    //------------------------------------------------------------------------------------------------------------------------------------------
    public function person(Request $request)
    {
        $year = 1397;


        if ($request->input('year') != null) {
            $year = $request->input('year');
        }

        $date1 = verta();
        $date2 = verta();

        $date1->year = $year;
        $date1->month = 1;
        $date1->day = 1;
        $date1->hour = 0;
        $date1->minute = 0;

        $date2->year = $year;
        $date2->month = 9;
        $date2->day = 30;
        $date2->hour = 23;
        $date2->minute = 59;

        $d1 = $date1->formatGregorian('Y-m-d H:i');
        $d2 = $date2->formatGregorian('Y-m-d H:i');

        $subactions = Subaction::all();
        $yearts = Yeart::all();
        $spents = Spent::all();
        return view('reports.PersonReport', compact('subactions', 'yearts', 'spents', 'd1', 'd2'));
    }

    //------------------------------------------------------------------------------------------------------------------------------------------
    public function support(Request $request)
    {
        $year = 1397;


        if ($request->input('year') != null) {
            $year = $request->input('year');
        }

        $date1 = verta();
        $date2 = verta();

        $date1->year = $year;
        $date1->month = 1;
        $date1->day = 1;
        $date2->hour = 0;
        $date2->minute = 0;

        $date2->year = $year;
        $date2->month = 9;
        $date2->day = 30;
        $date2->hour = 23;
        $date2->minute = 59;

        $d1 = $date1->formatGregorian('Y-m-d H:i');
        $d2 = $date2->formatGregorian('Y-m-d H:i');

        $subactions = Subaction::all();
        $yearts = Yeart::all();
        $spents = Spent::all();
        return view('reports.2SupportReport', compact('subactions', 'yearts', 'spents', 'd1', 'd2'));
    }

    //------------------------------------------------------------------------------------------------------------------------------------------
    public function research(Request $request)
    {
        $year = 1397;


        if ($request->input('year') != null) {
            $year = $request->input('year');
        }

        $date1 = verta();
        $date2 = verta();

        $date1->year = $year;
        $date1->month = 1;
        $date1->day = 1;
        $date2->hour = 0;
        $date2->minute = 0;

        $date2->year = $year;
        $date2->month = 9;
        $date2->day = 30;
        $date2->hour = 23;
        $date2->minute = 59;

        $d1 = $date1->formatGregorian('Y-m-d H:i');
        $d2 = $date2->formatGregorian('Y-m-d H:i');

        $subactions = Subaction::withCount([
            'Vsubtassign AS credit_total' => function ($query) use ($year) {
                $query->select(DB::raw("SUM(sum_credit) as total"))->where([['year', '=', $year]]);
            }
        ])->withCount([
            'Spent AS spent_count' => function ($query) use ($d2, $d1) {
                $query->select(DB::raw("COUNT(price) as total"))->where([['spend_date', '>=', $d1], ['spend_date', '<=', $d2]]);
            }
        ])->get();
        $yearts = Yeart::all();
        $spents = Spent::all();
        $applications = Application::all();
        return view('reports.ResearchReport', compact('applications', 'subactions', 'yearts', 'spents', 'd1', 'd2'));
    }

    //------------------------------------------------------------------------------------------------------------------------------------------
    public function commercialization(Request $request)
    {
        $year = 1397;


        if ($request->input('year') != null) {
            $year = $request->input('year');
        }

        $date1 = verta();
        $date2 = verta();

        $date1->year = $year;
        $date1->month = 1;
        $date1->day = 1;
        $date2->hour = 0;
        $date2->minute = 0;

        $date2->year = $year;
        $date2->month = 9;
        $date2->day = 30;
        $date2->hour = 23;
        $date2->minute = 59;

        $d1 = $date1->formatGregorian('Y-m-d H:i');
        $d2 = $date2->formatGregorian('Y-m-d H:i');

        $subactions = Subaction::withCount([
            'Vsubtassign AS credit_total' => function ($query) use ($year) {
                $query->select(DB::raw("SUM(sum_credit) as total"))->where([['year', '=', $year]]);
            }
        ])->withCount([
            'Spent AS spent_count' => function ($query) use ($d2, $d1) {
                $query->select(DB::raw("COUNT(price) as total"))->where([['spend_date', '>=', $d1], ['spend_date', '<=', $d2]]);
            }
        ])->get();
        $yearts = Yeart::all();
        $spents = Spent::all();

        return view('reports.CommercializationReport', compact('subactions', 'yearts', 'spents', 'd1', 'd2'));
    }

    //------------------------------------------------------------------------------------------------------------------------------------------
    public function fspishroshd(Request $request)
    {
        $year = 1397;

        if ($request->input('year') != null) {
            $year = $request->input('year');
        }

        $date1 = verta();
        $date2 = verta();

        $date1->year = $year;
        $date1->month = 1;
        $date1->day = 1;
        $date2->hour = 0;
        $date2->minute = 0;

        $date2->year = $year;
        $date2->month = 9;
        $date2->day = 30;
        $date2->hour = 23;
        $date2->minute = 59;

        $d1 = $date1->formatGregorian('Y-m-d H:i');
        $d2 = $date2->formatGregorian('Y-m-d H:i');

        $subactions = Subaction::withCount([
            'Vsubtassign AS credit_total' => function ($query) use ($year) {
                $query->select(DB::raw("SUM(price) as total"))->where([['year', '=', $year]]);
            }
        ])->withCount([
            'Spent AS spent_count' => function ($query) use ($d2, $d1) {
                $query->select(DB::raw("COUNT(price) as total"))->where([['spend_date', '>=', $d1], ['spend_date', '<=', $d2], ['status', '=', 1]]);
            }
        ])->get();
        $yearts = Yeart::all();
        $spents = Spent::all();
        $applications = Application::all();
        return view('reports.fspish', compact('applications', 'subactions', 'yearts', 'spents', 'd1', 'd2'));
    }

    //-------------------------------------------------------------------------------------------------------------------
    public function spent_company(Request $request)
    {
        //   dd('hi');
        $applications = Application::all();
        $sources = Source::all();
        $companies = Company::all();
        $yearts = Yeart::all();
        $company = Company::first();
        $company_code = $company->id;

        $spentfilter = Spent::withCount('company')->OrderBy('id', 'desc')->where('status', '=', 1);
        //----------------------------------------------------------------------------------------------
        if ($request->input('company') != null) {
            $company_code = $request->input('company');
            $company = Company::where([['id', '=', $company_code]])->first();


            //   dd($company->id);
        }

        $spentfilter->with('Company')
            ->whereHas('Company', function ($q) use ($company_code) {
                $q->where([['companies.id', '=', $company_code]]);
            });
        if ($request->input('subaction_code') != null) {
            $sa_code = $request->input('subaction_code');
            $spentfilter->with('Subaction')
                ->whereHas('Subaction', function ($q) use ($sa_code) {
                    $q->where([['subaction_code', '=', $sa_code]]);
                });


        } else {
            if ($request->input('appin') != null) {
                if ($request->input('actin') != null) {
                    if ($request->input('sain') != null) {
                        $spentfilter->where([['subaction_id', '=', $request->input('sain')]]);

                    } else {
                        $actid = $request->input('actin');
                        $spentfilter->with('Subaction')
                            ->whereHas('Subaction', function ($q) use ($actid) {
                                $q->where([['action_id', '=', $actid]]);
                            });

                    }
                } else {
                    $appid = $request->input('appin');
                    $spentfilter->with(array('Subaction', 'Subaction.Action'))
                        ->whereHas('Subaction.Action', function ($q) use ($appid) {
                            $q->where([['application_id', '=', $appid]]);
                        });

                }
            }

        }
        //----------------------------------------------------------------------------------------------
        if ($request->input('year') != null) {
            $spentfilter->where([['year', '=', $request->input('year')]]);

        }
        if ($request->input('give_date') != null) {
            $spentfilter->where([['spend_date', '>=', Verta::parse($request->input('give_date'))->DateTime()]]);

        }
        if ($request->input('start_date') != null) {
            $spentfilter->where([['spend_date', '<=', Verta::parse($request->input('start_date'))->DateTime()]]);

        }
        if ($request->input('cost') != null) {
            $cost_code = $request->input('cost');
            $spentfilter->with('Cost')
                ->whereHas('Cost', function ($q) use ($cost_code) {
                    $q->where([['cost_code', '=', $cost_code]]);
                });


        }
        //-------------------------------------------------------------------------------------------------
        if ($request->input('credit_code') != null) {
            $spentfilter->where([['credit_id', '=', $request->input('credit_code')]]);

        } else {
            if ($request->input('source_code') != null) {
                if ($request->input('credit') != null) {
                    $spentfilter->where([['credit_id', '=', $request->input('credit')]]);
                } else {
                    $actid = $request->input('source_code');
                    $spentfilter->with('Credit')
                        ->whereHas('Credit', function ($q) use ($actid) {
                            $q->where([['source_id', '=', $actid]]);
                        });

                }
            }
        }

        $spents = $spentfilter->get();
        //   $exspents=$spentfilter->get();

        $app1 = $request->input('appin');
        $act1 = $request->input('actin');
        $sact1 = $request->input('sain');
        $sacod1 = $request->input('subaction_code');
        $sdate1 = $request->input('give_date');
        $edate1 = $request->input('start_date');
        $year1 = $request->input('year');
        $src1 = $request->input('source_code');
        $crdt1 = $request->input('credit');
        $cost1 = $request->input('cost');
        $ctcode1 = $request->input('credit_code');
//dd($spents);
        return view('reports.CompanySpentReport', compact('companies', 'company', 'applications', 'spents', 'sources', 'yearts', 'app1', 'act1', 'sact1', 'sacod1', 'sdate1', 'edate1', 'year1', 'src1', 'crdt1', 'cost1', 'ctcode1'));
    }

    //------------------------------------------------------------------------------------------------------------------------------------------
    public function subbudget(Request $request)
    {
         $v=verta();
        $year =  $v->year;


        if ($request->input('yearip') != null) {
            $year = $request->input('yearip');

        }
        $date1 = verta();
        $date2 = verta();

        $date1->year = $year;
        $date1->month = 1;
        $date1->day = 1;
        $date2->hour = 0;
        $date2->minute = 0;

        $date2->year = $year;
        $date2->month = 12;
        $date2->day = 29;
        $date2->hour = 23;
        $date2->minute = 59;

        $d1 = $date1->formatGregorian('Y-m-d H:i');
        $d2 = $date2->formatGregorian('Y-m-d H:i');
        $subactions = Subaction::withCount([
            'Vsubtassign AS price_total' => function ($query) use ($year) {
                $query->select(DB::raw("SUM(sum_approved) as total"))->where([['year', '=', $year]]);
            }
        ])->get();

        // dd($applications);

        $year1 = $year;

        $yearts = Yeart::all();
        if ($request->input('give_date') != null) {
          $d1= Verta::parse($request->input('give_date'))->formatGregorian('Y-m-d H:i');
         }
        if ($request->input('start_date') != null) {
            $d2= Verta::parse($request->input('start_date'))->formatGregorian('Y-m-d H:i');
        }
        //   return view('reports.SubActs', compact('subactions','yearts','year1'));
       // dd($d1);
        return view('reports.subbudget', compact('subactions', 'yearts', 'year1', 'd1', 'd2'));
    }

    //------------------------------------------------------------------------------------------------------------------------------------------
    public function subcredit(Request $request)
    {
        $v=verta();
        $year =  $v->year;


        if ($request->input('yearip') != null) {
            $year = $request->input('yearip');

        }
        $date1 = verta();
        $date2 = verta();

        $date1->year = $year;
        $date1->month = 1;
        $date1->day = 1;
        $date2->hour = 0;
        $date2->minute = 0;

        $date2->year = $year;
        $date2->month = 12;
        $date2->day = 29;
        $date2->hour = 23;
        $date2->minute = 59;

        $d1 = $date1->formatGregorian('Y-m-d H:i');
        $d2 = $date2->formatGregorian('Y-m-d H:i');


        $year1 = $year;

        $yearts = Yeart::all();
        if ($request->input('give_date') != null) {
            $d1= Verta::parse($request->input('give_date'))->formatGregorian('Y-m-d H:i');
        }
        if ($request->input('start_date') != null) {
            $d2= Verta::parse($request->input('start_date'))->formatGregorian('Y-m-d H:i');
        }

        //   return view('reports.SubActs', compact('subactions','yearts','year1'));
        //  $v=Vsubcredit::first(1)->get();
        //dd($v);
        $subactions = Subaction::all();
        $vsubcredits = Vsubcredit::where([['year', '=', $year], ['spend_date', '>=', $d1], ['spend_date', '<=', $d2]])->groupBy('year', 'credit_id', 'cost', 'subaction')
            ->selectRaw('sum(price) as sum,year,credit_name,cost,subaction,sub_id,cost_id')
            ->get();

        //dd($vsubcredits);
        return view('reports.subcredit', compact('vsubcredits', 'subactions', 'yearts', 'year1', 'd1', 'd2'));
    }
    //--------------------------------------------------------------------
    public function pishreport(Request $request)
    {
        $v=verta();
        $year =  $v->year;

$contractfilter = Contract::OrderBy('id', 'desc')->where([['level', '=', 1], ['status', '=', 1]]);
if ($request->input('year')!=null)
{
$year = $request->input('year');
}

$contractfilter->with('Conassign');
/*  ->whereHas('Conassign', function ($q) use ($year) {
     $q->where([['year', '=', $year]]);
 });*/
$date1 = verta();

$date2 = verta();
        $date1->year = $year;
        $date1->month = 1;
        $date1->day = 1;
        $date2->hour = 0;
        $date2->minute = 0;

        $date2->year = $year;
        $date2->month = 12;
        $date2->day = 29;
        $date2->hour = 23;
        $date2->minute = 59;

        $d1 = $date1->formatGregorian('Y-m-d H:i');
        $d2 = $date2->formatGregorian('Y-m-d H:i');

$contractfilter->with('Spent');

$contracts = $contractfilter->paginate(20);
$year1 = $year;

$yearts = Yeart::all();
        if ($request->input('give_date') != null) {
            $d1= Verta::parse($request->input('give_date'))->formatGregorian('Y-m-d H:i');
        }
        if ($request->input('start_date') != null) {
            $d2= Verta::parse($request->input('start_date'))->formatGregorian('Y-m-d H:i');
        }
return view('reports.vahedspish', compact('contracts', 'yearts', 'year1', 'd1', 'd2'));
} //--------------------------------------------------------------------
    public function roshdreport(Request $request)
    {
        $v=verta();
        $year =  $v->year;

        $contractfilter = Contract::OrderBy('id', 'desc')->where([['level', '=', 2], ['status', '=', 1]]);
        if ($request->input('year')!=null)
        {
            $year = $request->input('year');
        }

        $contractfilter->with('Conassign');
        /*  ->whereHas('Conassign', function ($q) use ($year) {
             $q->where([['year', '=', $year]]);
         });*/
        $date1 = verta();

        $date2 = verta();
        $date1->year = $year;
        $date1->month = 1;
        $date1->day = 1;
        $date2->hour = 0;
        $date2->minute = 0;

        $date2->year = $year;
        $date2->month = 12;
        $date2->day = 29;
        $date2->hour = 23;
        $date2->minute = 59;

        $d1 = $date1->formatGregorian('Y-m-d H:i');
        $d2 = $date2->formatGregorian('Y-m-d H:i');

        $contractfilter->with('Spent');

        $contracts = $contractfilter->paginate(20);
        $year1 = $year;

        $yearts = Yeart::all();
        if ($request->input('give_date') != null) {
            $d1= Verta::parse($request->input('give_date'))->formatGregorian('Y-m-d H:i');
        }
        if ($request->input('start_date') != null) {
            $d2= Verta::parse($request->input('start_date'))->formatGregorian('Y-m-d H:i');
        }
        return view('reports.vahedsroshd', compact('contracts', 'yearts', 'year1', 'd1', 'd2'));
    }
    //--------------------------------------------------------------------
    public function fanreport(Request $request)
    {
        $v=verta();
        $year =  $v->year;

        $contractfilter = Contract::OrderBy('id', 'desc')->where([['level', '=', 3], ['status', '=', 1]]);
        if ($request->input('year')!=null)
        {
            $year = $request->input('year');
        }

        $contractfilter->with('Conassign');
        /*  ->whereHas('Conassign', function ($q) use ($year) {
             $q->where([['year', '=', $year]]);
         });*/
        $date1 = verta();

        $date2 = verta();
        $date1->year = $year;
        $date1->month = 1;
        $date1->day = 1;
        $date2->hour = 0;
        $date2->minute = 0;

        $date2->year = $year;
        $date2->month = 12;
        $date2->day = 29;
        $date2->hour = 23;
        $date2->minute = 59;

        $d1 = $date1->formatGregorian('Y-m-d H:i');
        $d2 = $date2->formatGregorian('Y-m-d H:i');

        $contractfilter->with('Spent');

        $contracts = $contractfilter->paginate(20);
        $year1 = $year;

        $yearts = Yeart::all();
        if ($request->input('give_date') != null) {
            $d1= Verta::parse($request->input('give_date'))->formatGregorian('Y-m-d H:i');
        }
        if ($request->input('start_date') != null) {
            $d2= Verta::parse($request->input('start_date'))->formatGregorian('Y-m-d H:i');
        }
        return view('reports.vahedsfan', compact('contracts', 'yearts', 'year1', 'd1', 'd2'));
    }
}
