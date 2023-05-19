<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Appassign;
class Allocate_app extends Model
{
    public function appassign()
    {
        return $this->belongsTo(Appassign::class, 'appassign_id', 'id');
    }
}
