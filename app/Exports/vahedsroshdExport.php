<?php

namespace App\Exports;

use App\Conassign;
use App\Spent;
use App\Contract;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class vahedsroshdExport implements FromView
{
    var $d1= null;
    var $d2= null;
    var $year1= null;
    public function __construct($d1,$d2,$year1)
    {
        $this->d1= $d1;
        $this->d2= $d2;
        $this->year1=$year1;


    }
    public function view():View
    {
        $contracts = Contract::where([['level', '=', 2], ['status', '=', 1]])->OrderBy('id', 'desc')
            ->with('Conassign')->with('Spent')->get();




        return view('reports.vahedsroshdExport', [
            'contracts' => $contracts,'d1'=> $this->d1,'d2'=> $this->d2,'year1'=> $this->year1
        ]);
    }
}
