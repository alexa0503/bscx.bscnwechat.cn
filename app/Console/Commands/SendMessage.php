<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:message {type?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send message';

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
        $type = $this->argument('type');
        $today = \Carbon\Carbon::today();
        if( $type == 'users' ){
            $forms = \App\Form::where('booking_date',$today->copy()->addDays(1)->toDateString())->get();
            foreach($forms as $form){
                $msg_content = '普利司通温馨提醒，您已预约明天到店（地址）更换机油服务，请您准时前往哦！感谢您参加普利司通春季促销活动。';
                $msg_mobile = $form->mobile;
                $url = 'http://sms.zbwin.mobi/ws/sendsms.ashx?uid='.env('MSG_ID').'&pass='.env('MSG_KEY').'&mobile='.$msg_mobile.'&content='.urlencode($msg_content);
                file_get_contents($url);
                \Log::useDailyFiles(storage_path('logs/users-send.log'));
                \Log::info('Send messages: '.$msg_content);
            }
        }
        else{
            $forms = \App\Form::where('booking_date',$today->copy()->toDateString())
                ->groupBy('shop_id')
                ->select('shop_id',\DB::raw('count(*) as total'))
                ->get();
            foreach( $forms as $form ){
                $shop = $form->shop;
                $msg_mobile = $shop->contact_mobile;
                $shop_url = url('/flow',[
                    'id' => $form->shop_id,
                    'key' => substr(md5($shop->contact_mobile),5,17),
                ]);
                $msg_content = '您好，今天将有'.$form->total.'位用户光顾车之翼（'.$shop->name.'店）店铺体验更换机油服务（4升机油+机滤+工时费），请在用户到店后按此步骤操作：第一步：打开此链（'.$shop_url.'）；第二步：截图保存页面上的二维码；第三步：打开微信，在微信右上角的扫一扫中，打开相册扫描二维码；第四步，进入核销页面后扫描顾客提供的二维码进行核销；谢谢。';

                $url = 'http://sms.zbwin.mobi/ws/sendsms.ashx?uid='.env('MSG_ID').'&pass='.env('MSG_KEY').'&mobile='.$msg_mobile.'&content='.urlencode($msg_content);
                //$this->info($msg_content.$today->copy()->toDateString());
                file_get_contents($url);
                \Log::useDailyFiles(storage_path('logs/clerks-send.log'));
                \Log::info('Send messages: '.$msg_content);
            }
        }
    }
}
