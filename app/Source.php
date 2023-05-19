<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{

    public function budget()
    {
        return $this->hasMany(Budget::class);
    }
    public function vbudget()
    {
        return $this->hasMany(Vbudget::class);
    }
    public function credit()
    {
        return $this->belongsTo(Credit::class, 'credit_id', 'id');
    }
}
