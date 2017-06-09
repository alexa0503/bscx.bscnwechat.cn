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
use Illuminate\Http\Request;
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
Route::get('/code', function(Request $request){
    return ['ret'=>0,'data'=>substr(md5($request->ip),5,17)];
});
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
Route::get('/test/ip', function(Illuminate\Http\Request $request){
    $url = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$request->ip();
    $return = json_decode(file_get_contents($url));
    $province = \App\Province::where('name', $return->data->region)->first();
    if($province == null || $province->booked_limit_num >= $province->booked_num){
        return ['ret'=>1001,'msg'=>'未中奖'];
    }
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
