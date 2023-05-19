<?php

namespace App\Exports;

use App\Spent;
use App\Spents;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class export1 implements FromView
{
    use Exportable, RegistersEventListeners;
    var $app1= null;
    var $act1= null;
    var $sact1= null;
    var $sacod1= null;
    var $sdate1= null;
    var $edate1= null;
    var $year1= null;
    var $src1= null;
    var $crdt1= null;
    var $cost1= null;
    var $ctcode1= null;

    public function __construct($app1,$act1,$sact1,$sacod1,$sdate1,$edate1,$year1,$src1,$crdt1,$cost1,$ctcode1)
    {
        $this->app1= $app1;
        $this->act1= $act1;
        $this->sact1=$sact1;
        $this->sacod1=$sacod1;
        $this->sdate1=$sdate1;
        $this->edate1=$edate1;
        $this->year1= $year1;
        $this->src1=$src1;
        $this->crdt1=$crdt1;
        $this->cost1= $cost1;
        $this->ctcode1= $ctcode1;

       }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view():View
    {
        //dd($this->act1);
        $spentfilter = Spent::OrderBy('id', 'desc');
        if (isset($this->sacod1)) {
            $sa_code = $this->sacod1;
            $spentfilter->with('Subaction')
                ->whereHas('Subaction', function ($q) use ($sa_code) {
                    $q->where([['subaction_code', '=', $sa_code]]);
                });


        } else {
            if (isset($this->sact1)) {
                $spentfilter->where([['subaction_id', '=', $this->sact1]]);
            }
            if (isset($this->act1)) {

                $actid =$this->act1;
                $spentfilter->with('Subaction')
                    ->whereHas('Subaction', function ($q) use ($actid) {
                        $q->where([['action_id', '=', $actid]]);
                    });

            }
            if (isset($this->app1)) {

                $appid = $this->app1;
                $spentfilter->with(array('Subaction', 'Subaction.Action'))
                    ->whereHas('Subaction.Action', function ($q) use ($appid) {
                        $q->where([['application_id', '=', $appid]]);
                    });

            }



            }


      //  dd($this->cost1);
        //----------------------------------------------------------------------------------------------
        if (isset($this->year1)) {
            $spentfilter->where([['year', '=',$this->year1]]);

        }
        if (isset($this->sdate1)) {
            $spentfilter->where([['spend_date', '>=',  $this->sdate1]]);

        }
        if (isset($this->edate1)) {
            $spentfilter->where([['spend_date', '<=', $this->edate1]]);

        }
        if (isset($this->cost1)) {
            $cost_code = $this->cost1;
            $spentfilter->with('Cost')
                ->whereHas('Cost', function ($q) use ($cost_code) {
                    $q->where([['cost_code', '=', $cost_code]]);
                });


        }
        //-------------------------------------------------------------------------------------------------
        if (isset($this->ctcode1)) {
            $spentfilter->where([['credit_id', '=', $this->ctcode1]]);

        } else {
            if (isset($this->crdt1)) {
                $spentfilter->where([['credit_id', '=', $this->crdt1]]);
            }
            if (isset($this->src1)) {

                    $actid = $this->src1;
                    $spentfilter->with('Credit')
                        ->whereHas('Credit', function ($q) use ($actid) {
                            $q->where([['source_id', '=', $actid]]);
                        });

                }
        }



        $exspents=$spentfilter->get();
        return view('reports.export1', [
            'exspents' => $exspents
        ]);
    }
}
