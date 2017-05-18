<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    public function form()
    {
        return $this->hasOne('App\Form');
    }
}
