<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subassign extends Model
{
    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id', 'code');
    }
    public function subaction()
    {
        return $this->belongsTo(Subaction::class, 'subaction_id', 'id');
    }
    public function actassign()
    {
        return $this->belongsTo(Actassign::class, 'actassign_id', 'id');
    }
    public function allocate()
    {
        return $this->hasMany(Allocate_sub::class);
    }
    public function vsubassign()
    {
        return $this->belongsTo(Vsubtassign::class,'id', 'id');
    }

}
