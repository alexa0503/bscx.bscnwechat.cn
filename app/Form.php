<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    public function lottery()
    {
        return $this->belongsTo('App\Lottery','lottery_id');
    }
    public function shop()
    {
        return $this->belongsTo('App\Shop','shop_id');
    }
}
