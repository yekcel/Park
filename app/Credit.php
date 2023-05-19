<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id', 'code');
    }
    public function spent()
    {
        return $this->hasMany(Spent::class);
    }
}
