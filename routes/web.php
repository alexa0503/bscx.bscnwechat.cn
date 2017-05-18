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
    Route::resource('province', 'Admin\ProvinceController');
    Route::resource('city', 'Admin\CityController');
    Route::resource('area', 'Admin\AreaController');
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
