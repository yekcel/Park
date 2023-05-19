<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    public function cost()
    {
        return $this->belongsTo(Cost::class, 'cost_id', 'id');
    }

    public function spent()
    {
        return $this->hasMany(Spent::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
    public function credit()
    {
        return $this->belongsTo(Credit::class, 'credit_id', 'id');
    }
    public function subaction()
    {
        return $this->belongsTo(Subaction::class, 'subaction_id', 'id');
    }
    public function conassign()
    {
        return $this->hasMany(Conassign::class);
    }
    public function subassign()
    {
        return $this->belongsTo(Subassign::class, 'subassign_id', 'id');
    }
}
