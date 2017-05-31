<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.province.index',[
            'items' => \App\Province::paginate(20),
        ]);
    }
    public function export()
    {
        $filename = "downloads/".date("ymdhis").".csv";
        $handle = fopen($filename, 'w+');
        fputs($handle, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
        $title = ['id','名称','预订限制','已预订'];
        fputcsv($handle, $title);
        $items = \App\Province::all();
        foreach($items as $item){
            $form = [];
            $form[] = $item->id;
            $form[] = $item->name;
            $form[] = $item->booked_limit_num;
            $form[] = $item->booked_num;
            fputcsv($handle, $form);
        }
        fclose($handle);
        $headers = array(
            'Content-Type' => 'application/csv',
            'Content-Transfer-Encoding' => 'binary; charset=utf-8',
            'Content-Disposition' => 'attachment; filename={$fileName}.txt'
        );
        return \Response::download($filename, '省份-'.date('Ymd').'.csv', $headers);
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
        return view('admin.province.edit',[
            'item'=>\App\Province::find($id)
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
            'name' => 'required',
            'booked_limit_num' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response($validator->errors(),422);
        }
        $province = \App\Province::find($id);
        $province->name = $request->name;
        $province->booked_limit_num = $request->booked_limit_num;
        $province->save();
        return ['ret'=>0,'url'=>route('province.index')];
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
