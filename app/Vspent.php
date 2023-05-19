<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vspent extends Model
{
    public function subaction()
    {
        return $this->belongsTo(Subaction::class, 'subaction_id', 'id');
    }
    public function action()
    {
        return $this->belongsTo(Action::class, 'act_id', 'id');
    }
    public function application()
    {
        return $this->belongsTo(Application::class, 'app_id', 'id');
    }
    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id', 'code');
    }
}
