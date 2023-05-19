<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appassign extends Model
{
    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id', 'id');
    }
    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id', 'code');
    }
    public function budget()
    {
        return $this->belongsTo(Budget::class, 'budget_id', 'id');
    }
    public function actassign()
    {
        return $this->hasMany(Actassign::class);
    }
    public function allocate()
    {
        return $this->hasMany(Allocate_app::class);
    }
}
