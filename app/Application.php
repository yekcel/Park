<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    public function action()
    {
        return $this->hasMany(Action::class);
    }
    public function appassign()
    {
        return $this->hasMany(Appassign::class);
    }
    public function vappassign()
    {
        return $this->hasMany(Vappassign::class);
    }

}
