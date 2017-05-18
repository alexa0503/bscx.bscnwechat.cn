<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    public function province()
    {
        return $this->belongsTo('App\Province');
    }
    public function city()
    {
        return $this->belongsTo('App\City');
    }
    public function shops()
    {
        return $this->hasMany('App\Shop');
    }
}
