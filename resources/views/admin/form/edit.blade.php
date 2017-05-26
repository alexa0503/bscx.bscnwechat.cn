@extends('layouts.admin')
@section('content')
    <div class="smart-widget widget-purple">
		<div class="smart-widget-inner">
			<div class="smart-widget-body">
                {{ Form::open(array('route' => ['form.update',$item->id], 'class'=>'form-horizontal', 'method'=>'PUT', 'id'=>'post-form')) }}
                    <div class="form-group">
                        <label for="" class="col-lg-2 control-label">姓名</label>
                        <div class="col-lg-10">
                            <input type="text" value="{{$item->name}}" class="form-control" disabled="disabled">
                            <label class="help-block" for="" id="help-lottery_date"></label>
                        </div><!-- /.col -->
                    </div><!-- /form-group -->
                    <div class="form-group">
                        <label for="mobile" class="col-lg-2 control-label">手机</label>
                        <div class="col-lg-10">
                            <input type="text" value="{{$item->mobile}}" class="form-control" name="mobile" id="mobile">
                            <label class="help-block" for="" id="help-mobile"></label>
                        </div><!-- /.col -->
                    </div><!-- /form-group -->
                    <div class="form-group">
                        <label for="" class="col-lg-2 control-label">车牌</label>
                        <div class="col-lg-10">
                            <input type="text" value="{{$item->plate_number}}" name="plate_number" class="form-control">
                        </div><!-- /.col -->
                    </div><!-- /form-group -->
                    <div class="form-group">
                        <label for="" class="col-lg-2 control-label">店铺</label>
                        <div class="col-lg-10">
                            <input type="text" value="{{$item->shop->name}}" class="form-control" disabled="disabled">
                        </div><!-- /.col -->
                    </div><!-- /form-group -->
                    <div class="form-group">
						<label for="booking_date" class="col-lg-2 control-label">预约日期</label>
						<div class="col-lg-10">
							<input type="text" value="{{$item->booking_date}}" name="booking_date" class="form-control datepicker" id="booking_date" placeholder="请输入抽奖日期">
                            <label class="help-block" for="" id="help-lottery_date"></label>
						</div><!-- /.col -->
					</div><!-- /form-group -->
                    <div class="form-group">
                        <label for="send_msg" class="col-lg-2 control-label">短信发送</label>
                        <div class="col-lg-10">
                            <div class="custom-checkbox">
								<input type="checkbox" value="1" name="send_msg" id="chk1">
								<label for="chk1"></label>
							</div>
                            <label class="help-block" for="" id="help-send"></label>
                        </div><!-- /.col -->
                    </div><!-- /form-group -->
                    <div class="form-group">
                        <label for="send_to_clerk" class="col-lg-2 control-label">发送给工作人员</label>
                        <div class="col-lg-10">
                            <div class="custom-checkbox">
								<input type="checkbox" value="1" name="send_to_clerk" id="chk2">
								<label for="chk2"></label>
							</div>
                            <label class="help-block" for="" id="help-send"></label>
                        </div><!-- /.col -->
                    </div><!-- /form-group -->
                    <div class="form-group">
						<label for="check_status" class="col-lg-2 control-label">表单状态</label>
						<div class="col-lg-10">
							<select name="check_status" class="form-control">
                                <option value="">保持现有状态</option>
                                <option value="1">更改为已核销</option>
                                <option value="2">更改为失效</option>
                            </select>
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
