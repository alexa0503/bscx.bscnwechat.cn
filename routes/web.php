<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
Route::get('/', 'HomeController@index');
#店铺的 json 数据
Route::get('/shops/{type?}', 'HomeController@shops');
Route::any('/form', 'HomeController@formPost');
Route::get('/shop/{id}', 'HomeController@shop');
Route::any('/lottery', 'HomeController@lottery');
Route::get('/flow/{id}/{key}', 'HomeController@getFlow');
Route::get('/writeoff/{id}/{key}', 'HomeController@getWriteoff');
Route::post('/writeoff', 'HomeController@postWriteoff');
Route::get('/result', 'HomeController@getWriteOffResult');
Route::get('/coupon/{id}/{key}', 'HomeController@getCoupon');
Route::get('/booking/date',function(){
    $today = \Carbon\Carbon::today();
    //$date[] = $today->toDateString();
    $date = [];
    $weeks = [
        '周日',
        '周一',
        '周二',
        '周三',
        '周四',
        '周五',
        '周六',
    ];
    for ($i=0; $i < 14; $i++) {
        $day = $today->addDays(1);
        $date[$day->toDateString()] = $day->toDateString().'/'.$weeks[$day->dayOfWeek];
    }
    return $date;
});
Route::get('/test/qr/{id}', function($id){
    $form = \App\Form::find($id);
    if( $form == null ){
        return 'no form';
    }
    $file = 'qr/'.$form->id.'.svg';
    $path = public_path($file);
    $content = url('/coupon',['id'=>$form->id,'key'=>subStr(md5($form->mobile),5,17)]);
    \QrCode::size(600)->margin(0)->generate($content, $path);
    return $content;
});
Route::get('/test/qr/flow/{id}', function($id){
    $shop = \App\Shop::find($id);
    return url('/flow',[
        'id' => $id,
        'key' => substr(md5($shop->contact_mobile),5,17),
    ]);
});
Route::get('sendsms', function(){
    $form = \App\Form::find(2);
    $shop = \App\Shop::find($form->shop_id);

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
    $form_url = url('/flow',[
        'id' => $form->id,
        'key' => substr(md5($form->mobile),5,17),
    ]);
    '感谢您参与普利司通春季促销活动，您已成功预约免费更换机油服务。预约姓名：'.$form->name.'，预约时间：'.$form->booking_date.'，预约店铺：'.$shop->name.'（'.$data['address'].'），您的预约码请点击以下地址查看：'.$form_url.'，请您务必在预约日期当天前往预约门店更换机油，逾期作废。';
    $url = 'http://sms.zbwin.mobi/ws/sendsms.ashx?uid='.env('MSG_ID').'&pass='.env('MSG_KEY').'&mobile='.$msg_mobile.'&content='.urlencode($msg_content);
    $result = file_get_contents($url);
    return $result;
});



Route::group(['middleware' => ['role:superadmin,global privileges','menu'],'prefix'=>'admin'], function () {
    Route::get('/', function () {
        return redirect('/admin/dashboard');
    });
    Route::get('/dashboard', 'Admin\IndexController@index');
    Route::resource('gallery', 'Admin\GalleryController');
    Route::get('/form/{type?}', 'Admin\FormController@index')->name('form.index');
    Route::resource('form', 'Admin\FormController',['except'=>'index']);
    Route::resource('lottery', 'Admin\LotteryController');
    Route::resource('setting', 'Admin\LotterySettingController');

    Route::get('/province/export', 'Admin\ProvinceController@export')->name('province.export');
    Route::resource('province', 'Admin\ProvinceController');
    Route::resource('city', 'Admin\CityController');
    Route::resource('area', 'Admin\AreaController');

    Route::get('/shop/export', 'Admin\FormController@export')->name('shop.export');
    Route::resource('shop', 'Admin\ShopController');
});
Route::get('/login', 'Auth\LoginController@showLoginForm');
Route::post('/login', 'Auth\LoginController@postLogin');
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/install', function(){
    if( \App\User::count() == 0){
        $role = Role::create(['name' => 'superadmin']);
        $permission = Permission::create(['name' => 'global privileges']);
        $role->givePermissionTo('global privileges');
        $user = new \App\User();
        $user->name = 'admin';
        $user->email = 'admin@admin.com';
        $user->password = bcrypt('admin@2017');
        $user->save();
        $user->givePermissionTo('global privileges');
        $user->assignRole(['superadmin']);
        $user->roles()->pluck('name');
        $user->givePermissionTo('global privileges');
    }
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
