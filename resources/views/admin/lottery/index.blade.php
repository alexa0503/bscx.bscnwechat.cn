@extends('layouts.admin')
@section('content')
<div class="smart-widget">
	<div class="smart-widget-inner">
		<div class="smart-widget-body">
			<table class="table table-striped">
	      		<thead>
	        		<tr>
			        	<th>ID</th>
			          	<th>是否获奖</th>
			          	<th>是否预约</th>
			          	<th>是否领奖</th>
			          	<th>是否失效</th>
			          	<th>预约表单</th>
			          	<th>IP</th>
			          	<th>创建时间</th>
	        		</tr>
	      		</thead>
	      		<tbody>
                    @foreach($items as $item)
		        	<tr>
			          	<td>{{$item->id}}</td>
			          	<td>{{$item->is_winned == 1 ? '是' : '否'}}</td>
			          	<td>{{$item->is_winned == 1 ? ($item->is_booked == 1 ? '是' : '否') : '--'}}</td>
			          	<td>{{$item->is_winned == 1 ? ($item->is_received == 1 ? '是' : '否') : '--'}}</td>
			          	<td>{{$item->is_winned == 1 ? ($item->is_invalid == 1 ? '是' : '否') : '--'}}</td>
			          	<td>{!! $item->form == null ? '--' : '<a href="'.route('form.show',$item->form->id).'">查看</a>' !!}</td>
                        <td>{{$item->created_ip}}</td>
			          	<td>{{$item->created_at}}</td>
		        	</tr>
                    @endforeach
		      	</tbody>
		    </table>
            {!! $items->links() !!}
		</div>
	</div><!-- ./smart-widget-inner -->
</div>
@endsection
