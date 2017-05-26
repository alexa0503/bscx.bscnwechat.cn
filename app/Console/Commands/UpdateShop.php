<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateShop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:shop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $contents = \Storage::get('bscx.csv');
        $lines = explode("\n", $contents);
        $i = 0;
        foreach($lines as $v){
            $arr = explode(",", $v);
            $count = \App\Shop::where('name', $arr[2])->count();
            if($count > 1 || $count == 0){
                continue;
            }
            $shop = \App\Shop::where('name', $arr[2])->first();
            $shop->branch_name = $arr[0];
            $shop->agent_name = $arr[1];
            $shop->save();
            $this->info($shop->name.','.$shop->branch_name.','.$shop->agent_name);
            ++$i;

            //echo $arr[0],$arr[1],$arr[2],$arr[3],$arr[4],$arr[5],$arr[6],$arr[7],"\n";
            //continue;
            /*
            $count = \App\Shop::where('name', $arr[1])->count();
            if($count > 0){
                continue;
            }
            $shop = new \App\Shop;
            $shop->code = $arr[0];
            $shop->name = $arr[1];
            $province = \App\Province::where('name', $arr[2])->first();
            if(null == $province){
                $province = new \App\Province;
                $province->name = $arr[2];
                $province->save();
            }


            $city = \App\City::where('name', $arr[3])->first();
            if(null == $city){
                $city = new \App\City;
                $city->name = $arr[3];
                $city->province_id = $province->id;
                $city->save();
            }

            $area = \App\Area::where('name', $arr[4])->first();
            if(null == $area){
                $area = new \App\Area;
                $area->name = $arr[4];
                $area->province_id = $province->id;
                $area->city_id = $city->id;
                $area->save();
            }

            $shop->province_id = $province->id;
            $shop->city_id = $city->id;
            $shop->area_id = $area->id;
            $shop->is_subscribed = 1;
            $shop->address = $arr[5];
            $shop->contact_mobile = $arr[6];
            $shop->oil_info = $arr[7];
            $shop->save();
            */

        }
        $this->info("总共有$i 家店铺更新成功");
        //$contents = file_get_contents('csv');
    }
}
