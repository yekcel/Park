<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Allocate_act extends Model
{
    public function actassign()
    {
        return $this->belongsTo(Actassign::class, 'actassign_id', 'id');
    }
}
