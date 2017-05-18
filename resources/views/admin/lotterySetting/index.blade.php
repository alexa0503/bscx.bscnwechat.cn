@extends('layouts.admin')
@section('content')
<div class="smart-widget">
	<div class="smart-widget-inner">
		<div class="smart-widget-body">
			<table class="table table-striped">
	      		<thead>
	        		<tr>
			        	<th>ID</th>
			          	<th>中奖几率/万分比</th>
			          	<th>最大数量</th>
			          	<th>抽奖日期</th>
			          	<th>操作</th>
	        		</tr>
	      		</thead>
	      		<tbody>
                    @foreach($items as $item)
		        	<tr>
			          	<td>{{$item->id}}</td>
			          	<td>{{$item->winning_odds}}</td>
			          	<td>{{$item->max_num}}</td>
                        <td>{{$item->lottery_date ? : '所有'}}</td>
                        <td>
							<a href="{{route('setting.edit',['id'=>$item->id])}}" class="btn btn-default btn-sm">编辑</a>
							<!--<a href="{{route('setting.destroy',['id'=>$item->id])}}" class="btn destroy btn-default btn-sm">删除</a>--></td>
		        	</tr>
                    @endforeach
		      	</tbody>
		    </table>
            {!! $items->links() !!}
		</div>
	</div><!-- ./smart-widget-inner -->
</div>
@endsection
