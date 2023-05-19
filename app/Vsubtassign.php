<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vsubtassign extends Model
{
    public function subassign()
    {
        return $this->belongsTo(Subassign::class, 'id', 'id');
    }
    public function subaction()
    {
        return $this->belongsTo(Subaction::class, 'action_id', 'id');
    }

    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id', 'code');
    }
}
