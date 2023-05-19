<?php

namespace App\Exports;

use App\Report1;
use Maatwebsite\Excel\Concerns\FromCollection;

class Report1 implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Report1::all();
    }
}
