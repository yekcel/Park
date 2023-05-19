<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id', 'code');
    }
    public function appassign()
    {
        return $this->hasMany(Appassign::class);
    }
    public function allocate()
    {
        return $this->hasMany(Alocate_budget::class);
    }
}
