<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vbudget extends Model
{
    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id', 'code');
    }
}
