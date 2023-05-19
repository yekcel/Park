<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Budget;
class Alocate_budget extends Model
{
    public function budget()
    {
        return $this->belongsTo(Budget::class, 'budget_id', 'id');
    }
}
