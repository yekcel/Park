<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    public function subactions()
    {
        return $this->belongsToMany(Subaction::class);
    }
    public function spent()
    {
        return $this->hasMany(Spent::class);
    }
    public function contract()
    {
        return $this->hasMany(Contract::class);
    }
}
