<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vactassign extends Model
{
    public function action()
    {
        return $this->belongsTo(Action::class, 'action_id', 'id');
    }
    public function appassign()
    {
        return $this->belongsTo(Appassign::class, 'appassign_id', 'code');
    }
    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id', 'code');
    }
}
