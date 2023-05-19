<?php

namespace App;
use App\Cost;
use App\Subaction;
use App\Credit;
use Illuminate\Database\Eloquent\Model;

class Spent extends Model
{
    public function company()
    {
        return $this->belongsToMany(Company::class);
    }

    public function cost()
    {
        return $this->belongsTo(Cost::class, 'cost_id', 'id');
    }
    public function subaction()
    {
        return $this->belongsTo(Subaction::class, 'subaction_id', 'id');
    }
    public function subassign()
    {
        return $this->belongsTo(Subassign::class, 'subassign_id', 'id');
    }
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }
    public function credit()
    {
        return $this->belongsTo(Credit::class, 'credit_id', 'id');
    }
}
