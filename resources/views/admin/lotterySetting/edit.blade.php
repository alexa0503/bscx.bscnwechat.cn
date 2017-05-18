@extends('layouts.admin')
@section('content')
    <div class="smart-widget widget-purple">
		<div class="smart-widget-inner">
			<div class="smart-widget-body">
                {{ Form::open(array('route' => ['setting.update',$item->id], 'class'=>'form-horizontal', 'method'=>'PUT', 'id'=>'post-form')) }}
					<div class="form-group">
						<label for="winning_odds" class="col-lg-2 control-label">中奖几率</label>
						<div class="col-lg-10">
							<input value="{{$item->winning_odds}}" name="winning_odds" type="text" class="form-control" id="winning_odds" placeholder="请输入中奖几率/万分比">
                            <label class="help-block" for="" id="help-winning_odds"></label>
						</div><!-- /.col -->
					</div><!-- /form-group -->

                    <div class="form-group">
						<label for="max_num" class="col-lg-2 control-label">最大数量</label>
						<div class="col-lg-10">
							<input type="text" value="{{$item->max_num}}" name="max_num" class="form-control" id="max_num" placeholder="请输入最大数量">
                            <label class="help-block" for="" id="help-max_num"></label>
						</div><!-- /.col -->
					</div><!-- /form-group -->

                    <div class="form-group">
						<label for="lottery_date" class="col-lg-2 control-label">抽奖日期</label>
						<div class="col-lg-10">
							<input type="text" value="{{$item->lottery_date}}" name="lottery_date" class="form-control datepicker" id="lottery_date" placeholder="请输入抽奖日期">
                            <label class="help-block" for="" id="help-lottery_date"></label>
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
    $('.datepicker').datepicker({
        format:'yyyy-mm-dd'
    });
    $('#post-form').ajaxForm({
        dataType: 'json',
        success: function(json) {
            $('#post-form').modal('hide');
            location.href= json.url;
        },
        error: function(xhr){
            var json = jQuery.parseJSON(xhr.responseText);
            if (xhr.status == 200){
                $('#login-form').modal('hide');
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
