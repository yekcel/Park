<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Subaction;
use App\Application;


class Action extends Model
{
    public function application()
{
    return $this->belongsTo(Application::class, 'application_id', 'id');
}
    public function subactions()
    {
        return $this->hasMany(Subaction::class);
    }
    public function actassign()
    {
        return $this->hasMany(Actassign::class);
    }
    public function vactassign()
    {
        return $this->hasMany(Vactassign::class);
    }
}
