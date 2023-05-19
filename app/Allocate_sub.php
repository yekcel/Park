<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Allocate_sub extends Model
{
    public function subassign()
    {
        return $this->belongsTo(Subassign::class, 'subassign_id', 'id');
    }
}
