<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

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
        if(\Agent::isMobile()){
            return redirect('/h5/index.html');
        }
        else{
            return redirect('/pc/index.html');
        }
    }
    //信息提交
    public function formPost(Request $request){

        if( null == $request->session()->get('lottery.id')){
            return ['ret'=>1002,'msg'=>['error'=>'您并未中奖']];
        }
        $lottery_id = $request->session()->get('lottery.id');
        $lottery = \App\Lottery::find($lottery_id);

        if( null == $lottery || $lottery->is_winned != 1 ){
            return ['ret'=>1003,'msg'=>['error'=>'您并没有中奖，无法填写信息~']];
        }
        elseif( $lottery->is_booked == 1 ){
            return ['ret'=>1004, 'msg'=>['error'=>'抽奖信息已失效~']];
        }
        elseif( $lottery->is_invalid == 1 ){
            return ['ret'=>1004, 'msg'=>['error'=>'抽奖信息已失效~']];
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
            'mobile' => 'required|regex:/^1[0-9]{10}$/i',
            'plate_number' => ['regex:/^(京|津|沪|瑜|冀|豫|云|辽|黑|湘|皖|鲁|苏|赣|浙|粤|鄂|桂|甘|晋|蒙|陕|吉|闽|贵|青|藏|川|宁|新|琼)[a-z][a-z|0-9]{5,6}$/i'],
            //'plate_number' => 'required|max:8',
            'shop' => 'required',
            'oil_info' => 'required',
            'booking_date' => 'required|date',
        ], $messages);
        if ($validator->fails()) {
            return ['ret'=>1001,'msg'=>$validator->errors()->toArray()];
        }

        \DB::beginTransaction();
        try {
            $count_plate_number = \App\Form::where('plate_number',$request->input('plate_number'))->count();
            if( $count_plate_number > 0){
                \DB::commit();
                return ['ret'=>1007,'msg'=>['plate_number'=>'该车牌号码已经被使用过了。']];
            }

            $count = \App\Form::where('mobile',$request->input('mobile'))->count();
            if( $count > 0){
                \DB::commit();
                return ['ret'=>1002,'msg'=>['mobile'=>'该手机号码已获得过免费换机油服务，请更换手机号码重新参与活动。']];
            }

            $shop = \App\Shop::find($request->input('shop'));
            $province = $shop->province;
            if( null == $shop || $province->booked_limit_num <= $province->booked_num ){
                \DB::commit();
                return ['ret'=>1005, 'msg'=>['shop'=>'该门店已经无法预约了']];
            }
            $count = \App\Form::where('shop_id',$request->input('shop'))
                ->where('booking_date',$request->input('booking_date'))
                ->count();
            //门店限制
            $more_limit_shops = [174];

            if( (!in_array($request->input('shop'),$more_limit_shops) && $count >= 4) || (in_array($request->input('shop'),$more_limit_shops) && $count >= 10 ) ){
                return ['ret'=>1006, 'msg'=>['shop'=>'该门店当天的预约数已满了']];
            }
            $form = new \App\Form;
            $form->lottery_id = $lottery_id;
            $form->name = $request->input('name');
            $form->mobile = $request->input('mobile');
            $form->plate_number = $request->input('plate_number');
            $form->shop_id = $request->input('shop');
            $form->oil_info = $request->input('oil_info');
            $form->booking_date = $request->input('booking_date');
            $form->sex = $request->input('sex');
            $form->save();
            $lottery->is_booked = 1;
            $lottery->save();


            $data = $form->toArray();
            $data['shop_name'] = $shop->name;
            $data['address'] = $shop->province->name.' '.$shop->city->name.' '.$shop->area->name.' '.$shop->address;

            $file = 'qr/'.$form->id.'.svg';
            $path = public_path($file);
            $content = url('/coupon',['id'=>$form->id,'key'=>substr(md5($form->mobile),5,17)]);
            \QrCode::size(600)->margin(0)->generate($content, $path);
            $data['qr_code'] = url($file);
            //发送短信
            //用户短信
            $msg_mobile = $form->mobile;
            $form_url = url('/coupon',[
                'id' => $form->id,
                'key' => substr(md5($form->mobile),5,17),
            ]);
            $msg_content = '感谢您参与普利司通春季促销活动，您已成功预约免费更换机油服务。预约姓名：'.$form->name.'，预约时间：'.$form->booking_date.'，预约店铺：'.$shop->name.'（'.$data['address'].'），您的预约码请点击以下地址查看：'.$form_url.'，请您务必在预约日期当天前往预约门店更换机油，逾期作废。';
            $url = 'http://sms.zbwin.mobi/ws/sendsms.ashx?uid='.env('MSG_ID').'&pass='.env('MSG_KEY').'&mobile='.$msg_mobile.'&content='.urlencode($msg_content);
            file_get_contents($url);
            //店铺短信
            if( env('APP_ENV') == 'dev' ){
                $msg_mobile = '15618892632';
                //$msg_mobile = '13816214832';
            }
            else{
                $msg_mobile = $shop->contact_mobile;
            }
            $shop_url = url('/flow',[
                'id' => $form->shop_id,
                'key' => substr(md5($shop->contact_mobile),5,17),
            ]);
            $msg_content = '您好，'.$form->booking_date.'将有1位手机尾号为：'.substr($form->mobile,-4).'的用户光顾车之翼（'.$shop->name.'）店铺体验更换机油服务（'.$form->oil_info.'），请在用户到店后按此步骤操作：第一步：打开此链（'.$shop_url.'）；第二步：截图保存页面上的二维码；第三步：打开微信，在微信右上角的扫一扫中，打开相册扫描二维码；第四步，进入核销页面后扫描顾客提供的二维码进行核销；谢谢。';
            $url = 'http://sms.zbwin.mobi/ws/sendsms.ashx?uid='.env('MSG_ID').'&pass='.env('MSG_KEY').'&mobile='.$msg_mobile.'&content='.urlencode($msg_content);
            file_get_contents($url);
            $province->booked_num += 1;
            $province->save();
            $request->session()->put('has_winned', null);
            $request->session()->put('lottery.id', null);
            \DB::commit();
            return ['ret'=>0, 'msg'=>'','data'=>$data];
        } catch (Exception $e) {
            \DB::rollBack();
            return ['ret'=>1100, 'msg'=>['error'=>$e->getMessage()]];
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
        /*
        if($type == 'subscribed'){
            $provinces = \App\Province::whereIn('id',$province_ids)
                ->whereRaw('booked_limit_num > booked_num')
                ->get();
        }
        else{
            $provinces = \App\Province::whereIn('id',$province_ids)
                ->get();
        }
        */
        $provinces = \App\Province::whereIn('id',$province_ids)
            ->get();

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
        return ['ret'=>0,'data'=>$shop];
    }
    //抽奖
    public function lottery(Request $request)
    {
        if( $request->session()->get('has_winned') == 1){
            $lottery = \App\Lottery::find($request->session()->get('lottery.id'));
            $now = \Carbon\Carbon::now()->timestamp;
            $invalid_at = $lottery->created_at->addMinutes(30)->timestamp;

            if( $lottery->is_booked == 1){
                $request->session()->put('has_winned', null);
                $request->session()->put('lottery.id', null);
            }
            elseif( $now < $invalid_at){
                return ['ret'=>0,'msg'=>'恭喜'];
            }
        }
        
        $url = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$request->ip();
        $return = json_decode(file_get_contents($url));
        $province = \App\Province::where('name', $return->data->region)->first();
        if($province == null || $province->booked_limit_num >= $province->booked_num){
            return ['ret'=>1001,'msg'=>'未中奖'];
        }

        $now = \Carbon\Carbon::now();

        \DB::beginTransaction();
        try{
            $total_setting = \App\LotterySetting::whereNull('lottery_date')->first();
            $today_setting = \App\LotterySetting::where('lottery_date', $now->toDateString())->first();

            $lottery = new \App\Lottery;
            $lottery->is_winned = 0;
            if( null == $total_setting || null == $today_setting ){
                $return = ['ret'=>1001,'msg'=>'未中奖'];
            }
            elseif( $total_setting->max_num <= $total_setting->winned_num ){
                $return = ['ret'=>1002,'msg'=>'未中奖'];
            }
            elseif( $today_setting->max_num <= $today_setting->winned_num ){
                $return = ['ret'=>1003,'msg'=>'未中奖'];
            }
            else{
                if( $today_setting->winning_odds == 0 ){
                    $return = ['ret'=>1004,'msg'=>'未中奖'];
                }
                else{
                    $seed = ceil(10000/$today_setting->winning_odds);
                    $rand1 = rand(1, $seed);
                    $rand2 = rand(1, $seed);
                    $lottery->is_winned = $rand1 == $rand2 ? 1 : 0;
                }
                $return = ['ret'=>1004,'msg'=>'未中奖'];
            }
            $lottery->created_ip = $request->ip();
            $lottery->save();
            if( $lottery->is_winned == 1 ){
                //奖项中奖数量自增1
                $total_setting->winned_num += 1;
                $total_setting->save();
                //奖项中奖数量自增1
                $today_setting->winned_num += 1;
                $today_setting->save();
                $request->session()->put('has_winned', 1);
                $request->session()->put('lottery.id', $lottery->id);
                $return = ['ret'=>0,'msg'=>'恭喜'.$lottery->id];
            }
            \DB::commit();
        } catch (Exception $e) {
            \DB::rollBack();
            $return = ['ret'=>1005, 'msg'=>$e->getMessage()];
        }
        return $return;
    }
    public function getWriteOff(Request $request,$id,$key)
    {
        $shop = \App\Shop::find($id);
        if( null == $shop){
            return 'invalid  url';
        }
        $keyy = substr(md5($shop->contact_mobile),5,17);
        if( $keyy != $key){
            return 'invalid  url';
        }
        else{
            return view ('write-off',[
                'shop' => $shop
            ]);
        }
    }
    public function postWriteOff(Request $request)
    {
        try {
            $shop_id = $request->input('shop_id');
            $key = $request->input('key');
            $result = decrypt($request->input('result'));
        } catch (DecryptException $e) {
            return view ('write-off-result',[
                'hx_class' => 'hx_fault',
                'ret' => 1001,
            ]);
        }

        $form = \App\Form::find($result['id']);
        $today = \Carbon\Carbon::today();
        if( null == $form || $form->lottery == null){
            //店铺不匹配
            $hx_class = 'hx_fault';
            $ret = 1100;
        }
        elseif( $form->lottery->is_invalid == 1 ){
            //该领奖券已经失效
            return ['ret'=>1005];
            $hx_class = 'hx_fault';
            $ret = 1005;
        }
        elseif( $form->shop_id != $shop_id ){
            //店铺不匹配
            $hx_class = 'hx_fault';
            $ret = 1002;
        }
        elseif( $form->lottery->is_received == 1){
            //此二维码已核销
            $hx_class = 'hx_fault';
            $ret = 1003;
        }
        elseif( $form->booking_date != $today->toDateString()){
            //预约时间不符
            $hx_class = 'hx_fault';
            $ret = 1004;
        }
        else{
            $form->check_date = \Carbon\Carbon::now();
            $form->save();
            $lottery = $form->lottery;
            $lottery->is_received = 1;
            $lottery->save();
            $hx_class = 'hx_success';
            $ret = 0;
        }
        if( $ret == 0){
            return view('write-off-success',[
                'form' => $form
            ]);
        }
        elseif( $ret == 1003){
            return view ('write-off-failed',[
                'hx_class' => $hx_class,
                'ret' => $ret,
                'form' => $form,
            ]);
        }
        else{
            return view ('write-off-result',[
                'hx_class' => $hx_class,
                'ret' => $ret,
                'form' => $form,
            ]);
        }
    }
    public function getWriteOffResult(Request $request)
    {
        if( null != \Session::get('hx_id') && \Session::get('hx_ret') == 0 ){
            $form = \App\Form::find(\Session::get('hx_id'));
            return view('write-off-success',[
                'form' => $form
            ]);
        }
        return view('write-off-result');
    }
    public function getCoupon(Request $request,$id,$key)
    {
        $form = \App\Form::find($id);
        $keyy = substr(md5($form->mobile),5,17);
        if( null == $form && $keyy == $key){
            return 'invalid url';
            //return view ('write-off');
        }
        $result = [
            'id' => $id,
            'key' => $key,
        ];
        return view('coupon',[
            'result' => \Crypt::encrypt($result),
        ]);
    }
    public function getFlow(Request $request, $id, $key)
    {
        $shop = \App\Shop::find($id);
        if( null == $shop){
            return 'invalid  url';
        }
        $keyy = substr(md5($shop->contact_mobile),5,17);
        if( $keyy != $key){
            return 'invalid  url';
        }
        $url = url('/writeoff',[
            'id' => $id,
            'key' => $keyy,
        ]);
        return view('flow',[
            'url' => $url,
        ]);
    }
}
