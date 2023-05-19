<?php

namespace App\Exports;

use App\Subaction;
use App\Vsubtassign;
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

class subBudgetExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
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
        $year=$this->year1;
        $subactions = Subaction::withCount([
            'Vsubtassign AS price_total' => function ($query) use ($year) {
                $query->select(DB::raw("SUM(sum_approved) as total"))->where([['year', '=', $year]]);
            }
        ])->get();




        return view('reports.export2', [
            'subactions' => $subactions,'d1'=> $this->d1,'d2'=> $this->d2,'year1'=> $this->year1
        ]);
    }
}
