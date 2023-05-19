<?php

namespace App\Http\Controllers;

use App\Action;
use App\Application;
use App\Credit;
use App\Source;
use App\Spent;
use App\Subaction;
use App\Cost;
use App\User;
use App\Company;
use App\Contract;
use App\Yeart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Hekmatinasser\Verta\Facades\Verta;

class AssignController@addapp extends Controller
{
    public function add(Subaction $subaction,Cost $cost)
{
    $users = User::all();
   $sources=Source::all();
    $yearts=Yeart::all();
    $applications=Application::all();
    // $devkinds = Devkind::all();

    return view('assigns.addtoapp', compact('users','applications','yearts','sources'));
}
    //---------------------------------------------------------------------------------------------------------------
}
