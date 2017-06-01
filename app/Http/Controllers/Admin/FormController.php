<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $type = null)
    {
        $model = \App\Form::where('name', 'like', '%'.$request->input('keywords').'%');
        if( $type == 'received' ){
            $items = $model->whereHas('lottery',function($query){
                $query->where('is_received',1);
            })->paginate(20);
        }
        elseif( $type == 'invalid' ){
            $items = $model->whereHas('lottery',function($query){
                $query->where('is_invalid',1);
            })->paginate(20);
        }
        else{
            $items = $model->paginate(20);
        }



        return view('admin.form.index',[
            'items' => $items,
        ]);
    }
    public function export()
    {
        $filename = "downloads/".date("ymdhis").".csv";
        $handle = fopen($filename, 'w+');
        fputs($handle, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
        $title = ['id','姓名','手机号','性别','车牌号','店铺分公司','店铺新代理商名称','店铺','省份','城市','区','地址','是否领奖','是否失效','更改预约次数','预约日期','机油','核销时间','来源','IP','创建时间'];
        fputcsv($handle, $title);
        $items = \App\Form::all();
        foreach($items as $item){
            $form = [];
            $form[] = $item->id;
            $form[] = $item->name;
            $form[] = $item->mobile;
            $form[] = $item->sex;
            $form[] = $item->plate_number;
            $form[] = $item->shop->branch_name;
            $form[] = $item->shop->agent_name;
            $form[] = $item->shop->name;
            $form[] = $item->shop->province->name;
            $form[] = $item->shop->city->name;
            $form[] = $item->shop->area->name;
            $form[] = $item->shop->address;
            $form[] = $item->lottery->is_received == 1 ? '是' : '否';
            $form[] = $item->lottery->is_invalid == 1 ? '是' : '否';
            $form[] = $item->alter_booking_num;
            $form[] = $item->booking_date;
            $form[] = $item->oil_info;
            $form[] = $item->check_date ?: '--';
            $form[] = $item->source_from ?: '--';
            $form[] = $item->lottery->created_ip;
            $form[] = $item->created_at;
            fputcsv($handle, $form);
        }
        fclose($handle);
        $headers = array(
            'Content-Type' => 'application/csv',
            'Content-Transfer-Encoding' => 'binary; charset=utf-8',
            'Content-Disposition' => 'attachment; filename={$fileName}.txt'
        );
        return \Response::download($filename, '预约表单-'.date('Ymd').'.csv', $headers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = \App\Form::find($id);
        return view('admin.form.edit',[
            'item' => $item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'mobile' => 'required|regex:/^1[0-9]{10}/',
            'booking_date' => 'required|date',
        ]);
        if ($validator->fails()) {
            return response($validator->errors(),422);
        }
        $form = \App\Form::find($id);
        if( $form->booking_date != $request->booking_date ){
            $form->alter_booking_num += 1;
        }
        $form->mobile = $request->mobile;
        $form->booking_date = $request->booking_date;
        $form->plate_number = $request->plate_number;

        if($request->check_status == 1){
            $lottery = $form->lottery;
            $lottery->is_received = 1;
            $lottery->save();
            $form->check_date = \Carbon\Carbon::now();
        }
        elseif($request->check_status == 2){
            $lottery = $form->lottery;
            $lottery->is_received = 0;
            $lottery->is_invalid = 1;
            $lottery->save();
            $form->check_date = NULL;
        }
        $form->save();
        //重新发送短信
        if( $request->send_msg && $request->send_msg == 1 ){
            $this->sendMsg($form,'users');
            $this->sendMsg($form,'clerks');
        }
        //发送给店员
        if( $request->send_to_clerk && $request->send_to_clerk == 1 ){
            $mobile = '18621534023';
            $this->sendMsg($form,'users', $mobile);
            $this->sendMsg($form,'clerks', $mobile);
        }
        return ['ret'=>0,'url'=>route('form.index')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    protected function sendMsg($form, $to = 'users', $mobile = null)
    {
        $shop = \App\Shop::find($form->shop_id);
        if( $to == 'users' ){
            $msg_mobile = $mobile ? : $form->mobile;
            //$msg_mobile = '15618892632';
            $form_url = url('/coupon',[
                'id' => $form->id,
                'key' => substr(md5($form->mobile),5,17),
            ]);
            $msg_content = '您已成功更改免费换机油服务的预约信息，预约姓名：'.$form->name.'，预约时间：'.$form->booking_date.'，预约店铺：'.$shop->name.'（'.$shop->province->name.' '.$shop->city->name.' '.$shop->area->name.' '.$shop->address.'）。您已无法再次修改预约时间，请您按照预约日期前往门店更换机油，逾期作废，感谢您的参与！），您的预约码请点击以下地址查看：'.$form_url;
        }
        else{
            $msg_mobile = $mobile ? : $shop->contact_mobile;
            //$msg_mobile = '15618892632';
            $shop_url = url('/flow',[
                'id' => $form->shop_id,
                'key' => substr(md5($shop->contact_mobile),5,17),
            ]);
            $msg_content = '您好，'.$form->booking_date.'将有1位手机尾号为：'.substr($form->mobile,-4).'的用户光顾车之翼（'.$shop->name.'）店铺体验更换机油服务（'.$form->oil_info.'），请在用户到店后按此步骤操作：第一步：打开此链（'.$shop_url.'）；第二步：截图保存页面上的二维码；第三步：打开微信，在微信右上角的扫一扫中，打开相册扫描二维码；第四步，进入核销页面后扫描顾客提供的二维码进行核销；谢谢。';
        }

        $url = 'http://sms.zbwin.mobi/ws/sendsms.ashx?uid='.env('MSG_ID').'&pass='.env('MSG_KEY').'&mobile='.$msg_mobile.'&content='.urlencode($msg_content);
        //\Log::useDailyFiles(storage_path('logs/'.$to.'-send.log'));
        //\Log::info('mobile:'.$msg_mobile.', content:'.$msg_content);
        file_get_contents($url);
    }
}
