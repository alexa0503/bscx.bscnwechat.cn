<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    public function area()
    {
        return $this->belongsTo('App\Area');
    }
    public function city()
    {
        return $this->belongsTo('App\City');
    }
    public function province()
    {
        return $this->belongsTo('App\Province');
    }

}
