@extends('layouts.admin')
@section('content')
<div class="smart-widget">
	<div class="smart-widget-header">
		<form class="form-inline no-margin" method="GET">
			<input type="hidden" name="is_searched" value="{{Request::input('is_searched')}}" />
			<input type="hidden" name="is_subscribed" value="{{Request::input('is_subscribed')}}" />
			<div class="row">
				<div class="col-md-5">
					<div class="input-group">
			            <input type="text" value="{{Request::input('keywords')}}" name="keywords" class="form-control" placeholder="请输入店名">
			            <div class="input-group-btn">
			            	<button type="submit" class="btn btn-success no-shadow" tabindex="-1">Search</button>
			            </div> <!-- /input-group-btn -->
			        </div> <!-- /input-group -->
				</div><!-- /.col -->
			</div><!-- /.row -->
		</form>
	</div>
	<div class="smart-widget-inner">
		<div class="smart-widget-body">
			<table class="table table-striped">
	      		<thead>
	        		<tr>
			        	<th>ID</th>
			          	<th>分公司</th>
			          	<th>新代理商名称</th>
			          	<th>店铺名</th>
			          	<th>编号</th>
			          	<th>省/市/区</th>
			          	<th>地址</th>
			          	<th>联系人/联系电话</th>
			          	<th>机油</th>
			          	<th>查询状态</th>
			          	<th>预订状态</th>
			          	<th>限制预订数</th>
			          	<th>浏览数</th>
			          	<th>操作</th>
	        		</tr>
	      		</thead>
	      		<tbody>
                    @foreach($items as $item)
		        	<tr>
			          	<td>{{$item->id}}</td>
			          	<td>{{$item->branch_name}}</td>
			          	<td>{{$item->agent_name}}</td>
			          	<td>{{$item->name}}</td>
			          	<td>{{$item->code}}</td>
			          	<td>{{$item->province->name}}/{{$item->city->name}}/{{$item->area->name}}</td>
                        <td>{{$item->address}}</td>
                        <td>{{$item->contact_person}}/{{$item->contact_mobile}}</td>
                        <td>{{$item->oil_info}}</td>
                        <td>{{$item->is_searched == 1 ? '是' : '否'}}</td>
                        <td>{{$item->is_subscribed == 1 ? '是' : '否'}}</td>
                        <td>{{$item->booked_limit_num}}</td>
                        <td>{{$item->views}}</td>
                        <td>
							<a href="{{route('shop.edit',['id'=>$item->id])}}" class="btn btn-default btn-sm">编辑</a>
							<!--<a href="{{route('shop.destroy',['id'=>$item->id])}}" class="btn destroy btn-default btn-sm">删除</a>--></td>
		        	</tr>
                    @endforeach
		      	</tbody>
		    </table>
            {!! $items->links() !!}
		</div>
	</div><!-- ./smart-widget-inner -->
</div>
@endsection
