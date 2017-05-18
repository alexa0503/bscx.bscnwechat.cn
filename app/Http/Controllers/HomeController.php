<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Agent::isMobile()){
            return redirect('/h5/index.html');
        }
        else{
            return redirect('/pc/index.html');
        }
    }
    //信息提交
    public function formPost(Request $request){
        if( null == $request->session()->get('lottery.id')){
            return ['ret'=>1002,'msg'=>'您并未中奖'];
        }
        $lottery_id = $request->session()->get('lottery.id');
        $lottery = \App\Lottery::find($lottery_id);
        if( null == $lottery || $lottery->is_winned == 1 ){
            return ['ret'=>1003,'msg'=>'您并没有中奖，无法填写信息~'];
        }
        elseif( $lottery->is_booked == 1 ){
            return ['ret'=>1004, 'msg'=>'抽奖信息已失效~'];
        }
        elseif( $lottery->is_invalid == 1 ){
            return ['ret'=>1004, 'msg'=>'抽奖信息已失效~'];
        }
        $messages = [
            'name.required' => '请正确输入姓名',
            'mobile.*' => '请正确输入手机号码',
            'plate_number.*' => '请正确输入车牌号',
            'shop.*' => '请选择',
            'oil_info.*' => '请选择',
            'booking_date.*' => '请选择',
        ];
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'mobile' => 'required|numeric|max:11',
            'plate_number' => 'required|max:20',
            'shop' => 'required',
            'oil_info' => 'required',
            'booking_date' => 'required|date',
        ], $messages);
        if ($validator->fails()) {
            return ['ret'=>1001,'msg'=>$validator->errors()->toArray()];
        }
        \DB::beginTransaction();
        try {
            $form = new \App\Form;
            $form->lottery_id = $lottery_id;
            $form->name = $request->input('name');
            $form->mobile = $request->input('mobile');
            $form->plate_number = $request->input('plate_number');
            $form->shop_id = $request->input('shop');
            $form->oil_info = $request->input('oil_info');
            $form->booking_date = $request->input('booking_date');
            $form->save();
            $lottery->is_booked = 1;
            $lottery->save();
            \DB::commit();
            return ['ret'=>0, 'msg'=>''];
        } catch (Exception $e) {
            \DB::rollBack();
            return ['ret'=>1100, 'msg'=>$e->getMessage()];
        }


    }
    //店铺列表
    public function shops($type = null)
    {
        if($type == 'subscribed'){
            $shops = \App\Shop::where('is_subscribed',1)->get();
        }
        else{
            $shops = \App\Shop::where('is_searched',1)->get();
        }

        $province_ids = $shops->unique('province_id')->map(function($item){
            return $item->province_id;
        })->toArray();
        $city_ids = $shops->unique('city_id')->map(function($item){
            return $item->city_id;
        })->toArray();
        $area_ids = $shops->unique('area_id')->map(function($item){
            return $item->area_id;
        })->toArray();

        $provinces = \App\Province::whereIn('id',$province_ids)->get();
        $data = $provinces->map(function($item) use($city_ids,$area_ids){
            $cities = $item->cities->whereIn('id',$city_ids)->map(function($item) use($area_ids){
                $areas = $item->areas->whereIn('id',$area_ids)->map(function($item){
                    $shops = $item->shops->map(function($item){
                        return ['id'=>$item->id, 'name'=>$item->name,'address'=>$item->address,'oil_info'=>explode('/',$item->oil_info)];
                    });
                    return ['id'=>$item->id,'name'=>$item->name,'shops'=>$shops];
                });
                return ['id'=>$item->id,'name'=>$item->name,'areas'=>$areas];
            });
            return ['id'=>$item->id,'name'=>$item->name,'cities'=>$cities];
        });

        return $data;
    }
    //店铺详情
    public function shop(Request $request, $id)
    {
        $shop = \App\Shop::find($id);
        $shop->views += 1;
        $shop->save();
        return $shop;
    }
    //抽奖
    public function lottery(Request $request)
    {
        if( $request->session()->get('has_winned') == 1 ){
            return ['ret'=>1002,'msg'=>'已中奖'];
        }

        $now = \Carbon\Carbon::now();

        \DB::beginTransaction();
        try{
            $total_setting = \App\LotterySetting::whereNull('lottery_date')->first();
            $today_setting = \App\LotterySetting::where('lottery_date', $now->toDateString())->first();
            if( null == $total_setting || null == $today_setting ){
                $return = ['ret'=>1001,'msg'=>'未中奖'];
            }
            elseif( $total_setting->max_num <= $total_setting->winned_num ){
                $return = ['ret'=>1001,'msg'=>'未中奖'];
            }
            elseif( $today_setting->max_num <= $today_setting->winned_num ){
                $return = ['ret'=>1001,'msg'=>'未中奖'];
            }
            else{
                $seed = ceil(10000/$today_setting->winning_odds);
                $rand1 = rand(1, $seed);
                $rand2 = rand(1, $seed);

                $lottery = new \App\Lottery;
                $lottery->is_winned = $rand1 == $rand2 ? 1 : 0;
                $lottery->created_ip = $request->ip();
                $lottery->save();

                if( $rand1 == $rand2 ){
                    $request->session()->set('has_winned', 1);
                    $request->session()->set('lottery.id', $lottery->id);
                    //奖项中奖数量自增1
                    $total_setting->winned_num += 1;
                    $total_setting->save();
                    //奖项中奖数量自增1
                    $today_setting->winned_num += 1;
                    $today_setting->save();
                    $return = ['ret'=>0,'msg'=>'恭喜'];
                }
                else{
                    $return = ['ret'=>1001,'msg'=>'未中奖'];
                }
            }
            \DB::commit();
        } catch (Exception $e) {
            \DB::rollBack();
            $return = ['ret'=>1001, 'msg'=>$e->getMessage()];
        }
        return $return;
        /*
        $now = \Carbon\Carbon::now();
        $setting1 = \App\LotterySetting::whereNull('lottery_date')->first();
        $setting2 = \App\LotterySetting::where('lottery_date', $now->toDateString())->first();
        $total_amount = $setting1 == null ? 0 : $setting1->max_num;
        #当天总量,抽奖几率
        if( null == $setting2){
            $today_total_amount = 0;
            $winning_odds = 0;
        }
        else{
            $today_total_amount = $setting1->max_num;
            $winning_odds = $setting2->winning_odds;
        }


        #当天已中奖总数
        $count_winned = \App\Lottery::where('is_winned',1)
            ->where('created_at', '>=', $now->toDateString())
            ->where('created_at', '<', $now->addDays(1)->toDateString())
            ->count();
        #当天已中奖超过30分钟未填写信息数量 跨天填写信息的 bug
        $count_exceed = \App\Lottery::where('is_winned',1)
            ->where('created_at', '>=', $now->toDateString())
            ->where('created_at', '<', $now->subMinutes(30)->toDateTimeString())
            ->where('created_at', '<', $now->addDays(1)->toDateString())
            ->where('is_booked', 0)
            ->count();
        #当天已中奖且已填写信息数量
        $count_written = \App\Lottery::where('is_winned',1)
            ->where('created_at', '>=', $now->toDateString())
            ->where('created_at', '<', $now->addDays(1)->toDateString())
            ->where('is_booked', 1)
            ->count();

        #已领取奖品数量
        $amount_received = \App\Lottery::where('is_received',1)->count();
        #已填写信息未领取
        $amount_written = \App\Lottery::where('is_winned',1)
            ->where('is_booked', 1)
            ->where('is_received',0)
            ->count();
        #已中奖14天内未领取奖品数量
        $amount_failure = \App\Lottery::where('is_winned',1)
            ->where('is_booked', 1)
            ->where('is_received',0)
            ->where('created_at', '<',$now->addDays(14)->toDateTimeString())
            ->count();
        #当天奖池有效奖数量
        $current_effective = $today_total_amount - $count_winned + $count_exceed;
        #总的有效奖数量
        $total_effective = $total_amount - $amount_received - $amount_written + $amount_failure;
        */
    }
}
