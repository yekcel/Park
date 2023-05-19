<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Action;
use App\Cost;
use App\Spent;

class Subaction extends Model
{
    public function action()
    {
        return $this->belongsTo(Action::class, 'action_id', 'id');
    }
    public function costs()
    {
        return $this->belongsToMany(Cost::class);
    }
    public function spent()
    {
        return $this->hasMany(Spent::class);
    }
    public function vsubtassign()
    {
        return $this->hasMany(Vsubtassign::class);
    }
    public function subassign()
    {
        return $this->hasMany(Subassign::class);
    }
}
