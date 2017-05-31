<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShopPost;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $model = \App\Shop::where('id', '>' ,0);
        if( $request->input('keywords') != null ){
            $model->where('name', 'like', '%'.$request->input('keywords').'%');
        }
        if( $request->input('is_searched') == 1){
            $model->where('is_searched',1);
        }

        if( $request->input('is_subscribed') == 1){
            $model->where('is_subscribed',1);
        }
        $items = $model->paginate(20);
        return view('admin.shop.index',[
            'items' => $items,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provinces = \App\Province::all();

        $data = $provinces->map(function($item){
            $cities = $item->cities->map(function($item){
                $areas = $item->areas->map(function($item){
                    return ['id'=>$item->id,'name'=>$item->name];
                });
                return ['id'=>$item->id,'name'=>$item->name,'areas'=>$areas];
            });
            return ['id'=>$item->id,'name'=>$item->name,'cities'=>$cities];
        });
        return view('admin.shop.create',[
            'json_data' => json_encode($data),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShopPost $request)
    {
        \DB::beginTransaction();
        try {
            $shop = new \App\Shop;
            $shop->name = $request->input('name');
            if( (string)(int)$request->input('province') == (string)$request->input('province') ){
                $shop->province_id = $request->input('province');
            }
            else{
                $province = new \App\Province;
                $province->name = $request->input('province');
                $province->save();
                $shop->province_id = $province->id;
            }

            if( (string)(int)$request->input('city') == (string)$request->input('city') ){
                $shop->city_id = $request->input('city');
            }
            else{
                $city = new \App\City;
                $city->name = $request->input('city');
                $city->province_id = $shop->province_id;
                $city->save();
                $shop->city_id = $city->id;
            }
            if( (string)(int)$request->input('area') == (string)$request->input('area')){
                $shop->area_id = $request->input('area');
            }
            else{
                $area = new \App\Area;
                $area->name = $request->input('area');
                $area->province_id = $shop->province_id;
                $area->city_id = $shop->city_id;
                $area->save();
                $shop->area_id = $area->id;
            }

            $shop->name = $request->input('name');
            $shop->booked_limit_num = $request->input('booked_limit_num');
            $shop->code = $request->input('code');
            $shop->address = $request->input('address');
            $shop->is_searched = $request->input('is_searched');
            $shop->is_subscribed = $request->input('is_subscribed');
            $shop->contact_person = $request->input('contact_person');
            $shop->contact_mobile = $request->input('contact_mobile');
            $shop->oil_info = $request->input('oil_info');
            $shop->views = 0;
            $shop->save();

            \DB::commit();
            return ['ret'=>0, 'url'=>route('shop.index')];
        } catch (Exception $e) {
            \DB::rollBack();
            return new Response(['ret'=>1001, 'msg'=>$e->getMessage()],422);
        }
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
        $provinces = \App\Province::all();
        $item = \App\Shop::find($id);

        $data = $provinces->map(function($item){
            $cities = $item->cities->map(function($item){
                $areas = $item->areas->map(function($item){
                    return ['id'=>$item->id,'name'=>$item->name];
                });
                return ['id'=>$item->id,'name'=>$item->name,'areas'=>$areas];
            });
            return ['id'=>$item->id,'name'=>$item->name,'cities'=>$cities];
        });
        return view('admin.shop.edit',[
            'item' => $item,
            'json_data' => json_encode($data),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShopPost $request, $id)
    {
        \DB::beginTransaction();
        try {
            $shop = \App\Shop::find($id);
            $shop->name = $request->input('name');
            if( (string)(int)$request->input('province') == (string)$request->input('province') ){
                $shop->province_id = $request->input('province');
            }
            else{
                $province = new \App\Province;
                $province->name = $request->input('province');
                $province->save();
                $shop->province_id = $province->id;
            }

            if( (string)(int)$request->input('city') == (string)$request->input('city') ){
                $shop->city_id = $request->input('city');
            }
            else{
                $city = new \App\City;
                $city->name = $request->input('city');
                $city->province_id = $shop->province_id;
                $city->save();
                $shop->city_id = $city->id;
            }
            if( (string)(int)$request->input('area') == (string)$request->input('area')){
                $shop->area_id = $request->input('area');
            }
            else{
                $area = new \App\Area;
                $area->name = $request->input('area');
                $area->province_id = $shop->province_id;
                $area->city_id = $shop->city_id;
                $area->save();
                $shop->area_id = $area->id;
            }

            $shop->name = $request->input('name');
            $shop->booked_limit_num = $request->input('booked_limit_num');
            $shop->code = $request->input('code');
            $shop->address = $request->input('address');
            $shop->is_searched = $request->input('is_searched');
            $shop->is_subscribed = $request->input('is_subscribed');
            $shop->contact_person = $request->input('contact_person');
            $shop->contact_mobile = $request->input('contact_mobile');
            $shop->oil_info = $request->input('oil_info');
            //$shop->views = $request->input('views');
            $shop->save();
            \DB::commit();
            return ['ret'=>0, 'url'=>route('shop.index')];
        } catch (Exception $e) {
            \DB::rollBack();
            return new Response(['ret'=>1001, 'msg'=>$e->getMessage()],422);
        }


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
}
