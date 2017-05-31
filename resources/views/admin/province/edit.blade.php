@extends('layouts.admin')
@section('content')
    <div class="smart-widget widget-purple">
		<div class="smart-widget-inner">
			<div class="smart-widget-body">
                {{ Form::open(array('route' => ['province.update',$item->id], 'class'=>'form-horizontal', 'method'=>'PUT', 'id'=>'post-form')) }}
					<div class="form-group">
						<label for="name" class="col-lg-2 control-label">店铺名</label>
						<div class="col-lg-10">
							<input value="{{$item->name}}" name="name" type="text" class="form-control" id="name" placeholder="请输入店铺名">
                            <label class="help-block" for="" id="help-name"></label>
						</div><!-- /.col -->
					</div><!-- /form-group -->

                    <div class="form-group">
                        <label for="name" class="col-lg-2 control-label">限制数量</label>
                        <div class="col-lg-10">
                            <input value="{{$item->booked_limit_num}}" name="booked_limit_num" type="text" class="form-control" id="name" placeholder="请输入预约每天限制数量">
                            <label class="help-block" for="" id="help-name"></label>
                        </div><!-- /.col -->
                    </div><!-- /form-group -->
					<div class="form-group">
						<div class="col-lg-offset-2 col-lg-10">
							<button type="submit" class="btn btn-success btn-sm">提交</button>
						</div><!-- /.col -->
					</div><!-- /form-group -->
				{{ Form::close() }}
			</div>
		</div><!-- ./smart-widget-inner -->
	</div>
@endsection
@section('scripts')
<!--form-->
<script src="{{asset('js/jquery.form.js')}}"></script>
<script>
 $().ready(function(){

    $('#post-form').ajaxForm({
        dataType: 'json',
        success: function(json) {
            $('#post-form').modal('hide');
            location.href= json.url;
        },
        error: function(xhr){
            var json = jQuery.parseJSON(xhr.responseText);
            if (xhr.status == 200){
                $('#post-form').modal('hide');
                location.href= json.url;
            }
            $('.help-block').html('');
            $.each(json, function(index,value){
                $('#'+index).parents('.form-group').addClass('has-error');
                $('#help-'+index).html(value);
                //$('#'+index).next('.help-block').html(value);
            });
        }
    });
 })
</script>
@endsection
