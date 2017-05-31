@extends('layouts.admin')
@section('content')
<div class="smart-widget">
	<div class="smart-widget-header">
		<form class="form-inline no-margin" method="GET">
			<div class="row">
				<div class="col-md-5">
					<a href="{{route('province.export')}}" class="btn btn-default">导出</a>
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
			          	<th>名称</th>
			          	<th>预订限制</th>
			          	<th>已预订</th>
			          	<th>操作</th>
	        		</tr>
	      		</thead>
	      		<tbody>
                    @foreach($items as $item)
		        	<tr>
			          	<td>{{$item->id}}</td>
                        <td>{{$item->name}}</td>
			          	<td>{{$item->booked_limit_num}}</td>
			          	<td>{{$item->booked_num}}</td>
						<td>
							<a href="{{route('province.edit',['id'=>$item->id])}}" class="btn btn-default btn-sm">编辑</a></td>
		        	</tr>
                    @endforeach
		      	</tbody>
		    </table>
            {!! $items->links() !!}
		</div>
	</div><!-- ./smart-widget-inner -->
</div>
@endsection
