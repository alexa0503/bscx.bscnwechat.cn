<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateJackpot extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:jackpot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the jackpot';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $now = \Carbon\Carbon::now();
        //$now = new \Carbon\Carbon();
        \DB::beginTransaction();
        try{
            #超过30分钟未填写的抽奖记录返还奖池
            $count = \App\Lottery::where('is_winned',1)
                ->where('created_at', '>=', $now->toDateString())
                ->where('created_at', '<', $now->copy()->addDays(1)->toDateString())
                ->where('created_at', '<', $now->copy()->subMinutes(30)->toDateTimeString())
                ->where('is_booked', 0)
                ->where('is_invalid', 0)
                ->count();
            //当天配置
            $today_setting = \App\LotterySetting::where('lottery_date', $now->toDateString())->first();
            if( null != $today_setting){
                $today_setting->winned_num -= $count;
                $today_setting->save();
            }
            //总量
            $total_setting = \App\LotterySetting::whereNull('lottery_date')->first();

            \App\Lottery::where('is_winned',1)
                ->where('created_at', '<', $now->copy()->subMinutes(30)->toDateTimeString())
                ->where('is_booked', 0)
                ->where('is_invalid', 0)
                ->update(['is_invalid' => 1]);

            #超过预约期的返还奖池
            $amount_failure = \App\Lottery::where('is_winned',1)
                ->where('is_booked', 1)
                ->where('is_received',0)
                ->where('created_at', '<', $now->copy()->subDays(14)->toDateTimeString())
                ->where('is_invalid', 0)
                ->count();
            $total_setting->winned_num -= ($count + $amount_failure);
            $total_setting->save();

            \App\Lottery::where('is_winned',1)
                ->where('is_booked', 1)
                ->where('is_received',0)
                ->where('created_at', '<', $now->copy()->subDays(14)->toDateTimeString())
                ->where('is_invalid', 0)
                ->update(['is_invalid' => 1]);

            \DB::commit();
            $this->info('Updated jackpot successful!');
        } catch (Exception $e) {
            \DB::rollBack();
            $this->info('Updated jackpot failed!');
        }
    }
}
