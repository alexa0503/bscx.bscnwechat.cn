<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LotterySettingPost;

class LotterySettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.lotterySetting.index',[
            'items' => \App\LotterySetting::paginate(20),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.lotterySetting.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LotterySettingPost $request)
    {
        \DB::beginTransaction();
        try {
            $lottery_setting = new \App\LotterySetting;
            $lottery_setting->lottery_date = $request->lottery_date;
            $lottery_setting->winning_odds = $request->winning_odds;
            $lottery_setting->max_num = $request->max_num;
            $lottery_setting->save();
            \DB::commit();
            return ['ret'=>0, 'url'=>route('setting.index')];
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
        $item = \App\LotterySetting::find($id);
        return view('admin.lotterySetting.edit',[
            'item'=>$item
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LotterySettingPost $request, $id)
    {
        \DB::beginTransaction();
        try {
            $lottery_setting = \App\LotterySetting::find($id);
            $lottery_setting->lottery_date = empty($request->lottery_date) ? null : $request->lottery_date;
            $lottery_setting->winning_odds = $request->winning_odds;
            $lottery_setting->max_num = $request->max_num;
            $lottery_setting->save();
            \DB::commit();
            return ['ret'=>0, 'url'=>route('setting.index')];
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
