<?php

namespace App\Exports;
use App\Vsubcredit;
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

class subCreditExport implements FromView
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
        $year=$this->year1;
        $d1=$this->d1;
        $d2=$this->d2;
        $subactions = Subaction::all();
        $vsubcredits = Vsubcredit::where([['year', '=', $year], ['spend_date', '>=', $d1], ['spend_date', '<=', $d2]])->groupBy('year', 'credit_id', 'cost', 'subaction')
            ->selectRaw('sum(price) as sum,year,credit_name,cost,subaction,sub_id,cost_id')
            ->get();



        return view('reports.subCreditExport', [
            'subactions' => $subactions,'vsubcredits'=>$vsubcredits,'d1'=> $this->d1,'d2'=> $this->d2,'year1'=> $this->year1
        ]);
    }
}
