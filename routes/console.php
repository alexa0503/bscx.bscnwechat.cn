<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');
Artisan::command('update:provinces', function(){
    $province_booked_nums = [];
    $forms = \App\Form::whereHas('lottery',function($query){
        $query->where('is_invalid',0);
    })->get();
    $count = 0;
    foreach($forms as $form){
        if( !isset($province_booked_nums[$form->shop->province_id])){
            $province_booked_nums[$form->shop->province_id] = 0;
        }
        $province_booked_nums[$form->shop->province_id] += 1;
        $count += 1;
    }
    foreach( $province_booked_nums as $id=>$province_booked_num){
        $province = \App\Province::find($id);
        $province->booked_num = $province_booked_num;
        $province->save();
        $this->info($province->name.'('.$id.'): '.$province_booked_num);
    }
    $this->info('总有效预约数量: '.$count);

    /*
    $num1 = \App\Lottery::where('is_winned',1)
        ->where('is_booked', 1)
        ->where('is_received',0)
        ->where('created_at', '>=', $now->copy()->subDays(14)->toDateTimeString())
        ->where('is_invalid', 0)
        ->count();

    $num2 = \App\Lottery::where('is_winned',1)
        ->where('is_booked', 1)
        ->where('is_received',1)
        ->where('is_invalid', 0)
        ->count();
    */
})->describe('Update province\'s booked num');
