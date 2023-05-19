<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vappassign extends Model
{
    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id', 'id');
    }
    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id', 'code');
    }
}
