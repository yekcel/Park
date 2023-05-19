<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actassign extends Model
{
    public function action()
    {
        return $this->belongsTo(Action::class, 'action_id', 'id');
    }
    public function appassign()
    {
        return $this->belongsTo(Appassign::class, 'appassign_id', 'id');
    }
    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id', 'code');
    }
    public function subassign()
    {
        return $this->hasMany(Subassign::class);
    }
    public function allocate()
    {
        return $this->hasMany(Allocate_act::class);
    }
}
