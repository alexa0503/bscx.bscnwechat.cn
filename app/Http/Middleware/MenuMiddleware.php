<?php

namespace App\Http\Middleware;

use Closure;
use Menu;

class MenuMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Menu::make('menu', function ($menu) {
            $menu->add('DASHBOARD', ['url'=>'admin/dashboard','class'=>'bg-palette1']);
            //$menu1 = $menu->add('图库管理', ['url'=>'#','class'=>'openable bg-palette2']);
            //$menu1->add('查看', ['url'=>route('gallery.index'),'class'=>'bg-palette2']);
            //$menu1->add('新增', ['url'=>route('gallery.create'),'class'=>'bg-palette2']);
            $menu_form = $menu->add('预约管理', ['url'=>'#','class'=>'openable bg-palette2']);
            //$menu_form->add('未预约',['url'=>route('form.index'), 'class'=>'bg-palette2']);
            $menu_form->add('所有预约',['url'=>route('form.index'), 'class'=>'bg-palette2']);
            $menu_form->add('已领取',['url'=>route('form.index','received'), 'class'=>'bg-palette2']);
            $menu_form->add('已失效',['url'=>route('form.index','invalid'), 'class'=>'bg-palette2']);


            $setting = $menu->add('抽奖设置', ['url'=>route('setting.index'),'class'=>'openable bg-palette3']);
            $setting->add('查看所有', ['url'=>route('setting.index'),'class'=>'bg-palette3']);
            $setting->add('新增设置', ['url'=>route('setting.create'),'class'=>'bg-palette3']);

            $lottery = $menu->add('抽奖记录', ['url'=>route('lottery.index'),'class'=>'openable bg-palette4']);
            $lottery->add('中奖记录', ['url'=>route('lottery.index',['is_winned'=>1]),'class'=>'bg-palette4']);
            $lottery->add('所有记录', ['url'=>route('lottery.index'),'class'=>'bg-palette4']);

            $menu1 = $menu->add('店铺相关', ['url'=>'#','class'=>'openable bg-palette2']);
            $province = $menu1->add('省份管理', ['url'=>route('province.index'),'class'=>'openable bg-palette2']);
            $province->add('查看',['url'=>route('province.index')]);
            $province->add('添加',['url'=>route('province.create')]);

            $city = $menu1->add('城市管理', ['url'=>'#','class'=>'openable bg-palette2']);
            $city->add('查看',['url'=>route('city.index')]);
            $city->add('添加',['url'=>route('city.create')]);

            $area = $menu1->add('地区管理', ['url'=>'#','class'=>'openable bg-palette2']);
            $area->add('查看',['url'=>route('area.index')]);
            $area->add('添加',['url'=>route('area.create')]);

            $shop = $menu1->add('店铺管理', ['url'=>'#','class'=>'openable bg-palette2']);
            $shop->add('查看所有店铺',['url'=>route('shop.index')]);
            $shop->add('可查询店铺',['url'=>route('shop.index',['is_searched'=>1])]);
            $shop->add('可预约店铺',['url'=>route('shop.index',['is_subscribed'=>1])]);
            $shop->add('添加店铺',['url'=>route('shop.create')]);
        });
        return $next($request);
    }
}
