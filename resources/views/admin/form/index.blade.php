@extends('layouts.admin')
@section('content')
@php
$today = \Carbon\Carbon::today()->timestamp;
@endphp
<div class="smart-widget">

	<div class="smart-widget-header">
		<form class="form-inline no-margin" method="GET">
			<input type="hidden" name="is_searched" value="{{Request::input('is_searched')}}" />
			<input type="hidden" name="is_subscribed" value="{{Request::input('is_subscribed')}}" />
			<div class="row">
				<div class="col-md-6">
					<div class="input-group">
			            <input type="text" value="{{Request::input('keywords')}}" name="keywords" class="form-control" placeholder="请输入用户名">
			            <div class="input-group-btn">
			            	<button type="submit" class="btn btn-success no-shadow" tabindex="-1">Search</button>
			            </div> <!-- /input-group-btn -->
			        </div> <!-- /input-group -->
				</div><!-- /.col -->
				<div class="col-md-6 text-right"><a href="{{route('shop.export')}}">导出</a></div>
			</div><!-- /.row -->
		</form>
	</div>
	<div class="smart-widget-inner">
		<div class="smart-widget-body">
			<table class="table table-striped">
	      		<thead>
	        		<tr>
			        	<th>ID</th>
			        	<th>姓名</th>
			        	<th>手机号</th>
			        	<th>车牌号</th>
			        	<th>店铺</th>
			          	<th>是否领奖</th>
			          	<th>是否失效</th>
			          	<th>更改预约次数</th>
			          	<th>预约日期</th>
			          	<th>机油</th>
			          	<th>核销时间</th>
			          	<th>IP</th>
			          	<th>创建时间</th>
			          	<th>操作</th>
	        		</tr>
	      		</thead>
	      		<tbody>
                    @foreach($items as $item)
		        	<tr>
			          	<td>{{$item->id}}</td>
						<td>{{$item->name}}</td>
						<td>{{$item->mobile}}</td>
						<td>{{$item->plate_number}}</td>
						<td><a href="{{route('shop.show',$item->id)}}" title="点击查看店铺详情">{{$item->shop->name}}</a></td>
			          	<td>{{$item->lottery->is_winned == 1 ? ($item->lottery->is_received == 1 ? '是' : '否') : '--'}}</td>
			          	<td>{{$item->lottery->is_winned == 1 ? ($item->lottery->is_invalid == 1 ? '是' : '否') : '--'}}</td>
                        <td>{{$item->alter_booking_num}}</td>
						<td>{{$item->booking_date}}</td>
                        <td>{{$item->oil_info}}</td>
			          	<td>{{$item->check_date}}</td>
                        <td>{{$item->lottery->created_ip}}</td>
			          	<td>{{$item->created_at}}</td>
						<th>
							<a href="{{route('form.edit',$item->id)}}" class="btn btn-default btn-sm">更新</a></th>
		        	</tr>
                    @endforeach
		      	</tbody>
		    </table>
            {!! $items->links() !!}
		</div>
	</div><!-- ./smart-widget-inner -->
</div>
@endsection
