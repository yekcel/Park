<?php

namespace App;

use App\Spent;
use Illuminate\Database\Eloquent\Model;


class Company extends Model
{
    public function spent()
    {
        return $this->belongsToMany(Spent::class);
    }
}
