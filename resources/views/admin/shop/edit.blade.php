@extends('layouts.admin')
@section('content')
    <div class="smart-widget widget-purple">
		<div class="smart-widget-inner">
			<div class="smart-widget-body">
                {{ Form::open(array('route' => ['shop.update',$item->id], 'class'=>'form-horizontal', 'method'=>'PUT', 'id'=>'post-form')) }}
					<div class="form-group">
						<label for="name" class="col-lg-2 control-label">店铺名</label>
						<div class="col-lg-10">
							<input value="{{$item->name}}" name="name" type="text" class="form-control" id="name" placeholder="请输入店铺名">
                            <label class="help-block" for="" id="help-name"></label>
						</div><!-- /.col -->
					</div><!-- /form-group -->
					<div class="form-group">
						<label for="code" class="col-lg-2 control-label">唯一编号</label>
						<div class="col-lg-10">
							<input type="text" value="{{$item->code}}" name="code" class="form-control" id="code" placeholder="请输入唯一编号">
                            <label class="help-block" for="" id="help-code"></label>
						</div><!-- /.col -->
					</div><!-- /form-group -->

                    <div class="form-group">
						<label for="area" class="col-lg-2 control-label">省/市/地区</label>
						<div class="col-lg-10">
                            <div class="row">
                                <div class="col-lg-4">
                                    <select class="select2 form-control" name="province" id="province">
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <select class="select2 form-control" name="city" id="city">
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="col-lg-4">
                                    <select class="select2 form-control" name="area" id="area">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <label class="help-block" for="" id="help-area"></label>
						</div><!-- /.col -->
					</div><!-- /form-group -->


                    <div class="form-group">
						<label for="address" class="col-lg-2 control-label">详细地址</label>
						<div class="col-lg-10">
							<input type="text" value="{{$item->address}}" name="address" class="form-control" id="address" placeholder="请输入详细地址">
                            <label class="help-block" for="" id="help-address"></label>
						</div><!-- /.col -->
					</div><!-- /form-group -->

                    <div class="form-group">
						<label for="contact_person" class="col-lg-2 control-label">联系人</label>
						<div class="col-lg-10">
							<input type="text" value="{{$item->contact_person}}" name="contact_person" class="form-control" id="contact_person" placeholder="请输入联系人">
                            <label class="help-block" for="" id="help-contact_person"></label>
						</div><!-- /.col -->
					</div><!-- /form-group -->

                    <div class="form-group">
						<label for="contact_mobile" class="col-lg-2 control-label">联系电话</label>
						<div class="col-lg-10">
							<input type="text" value="{{$item->contact_mobile}}" name="contact_mobile" class="form-control" id="contact_mobile" placeholder="请输入联系电话">
                            <label class="help-block" for="" id="help-contact_mobile"></label>
						</div><!-- /.col -->
					</div><!-- /form-group -->

                    <div class="form-group">
						<label for="oil_info" class="col-lg-2 control-label">机油</label>
						<div class="col-lg-10">
                            <textarea name="oil_info" class="form-control" id="oil_info" placeholder="请输入机油信息">{{$item->oil_info}}</textarea>
                            <label class="help-block" for="" id="help-oil_info"></label>
						</div><!-- /.col -->
					</div><!-- /form-group -->



                    <div class="form-group">
						<label for="is_searched" class="col-lg-2 control-label">是否被查询</label>
						<div class="col-lg-10">
                            <select name="is_searched" id="is_searched" class="form-control">
                                <option value="1"{{$item->is_searched=='1' ? ' selected="selected"' : ''}}>是</option>
                                <option value="0"{{$item->is_searched=='0' ? ' selected="selected"' : ''}}>否</option>
                            </select>
                            <label class="help-block" for="" id="help-is_searched"></label>
						</div><!-- /.col -->
					</div><!-- /form-group -->

                    <div class="form-group">
						<label for="code" class="col-lg-2 control-label">是否可预约</label>
						<div class="col-lg-10">
                            <select name="is_subscribed" id="is_subscribed" class="form-control">
                                <option value="1"{{$item->is_subscribed=='1' ? ' selected="selected"' : ''}}>是</option>
                                <option value="0"{{$item->is_subscribed=='0' ? ' selected="selected"' : ''}}>否</option>
                            </select>
                            <label class="help-block" for="" id="help-is_subscribed"></label>
						</div><!-- /.col -->
					</div><!-- /form-group -->
                    <div class="form-group">
                        <label for="name" class="col-lg-2 control-label">预约每天限制数量</label>
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
var provinces = {!! $json_data !!};
var cities = {};
var areas = {};
$.provinceChange = function(id, callback){
    var province = $('#province').val();
    $.each(provinces,function(index,value){
        if(province == value.id){
            cities = value.cities;
            return false;
        }
        else{
            cities = {};
        }
    });
    $('#city').html('<option value=""></option>');
    $('#area').html('<option value=""></option>');
    $.each(cities, function(index,value){
        if( id == value.id){
            $('#city').append('<option value="'+value.id+'" selected="selected">'+value.name+'</option>');
        }
        else{
            $('#city').append('<option value="'+value.id+'">'+value.name+'</option>');
        }
    });
    callback && callback();
}
$.cityChange = function(id){
    var city = $('#city').val();
    $.each(cities,function(index,value){
        if(city == value.id){
            areas = value.areas;
            return false;
        }
        else{
            areas = {};
        }
    });
    $('#area').html('<option value=""></option>');
    $.each(areas, function(index,value){
        if( id == value.id){
            $('#area').append('<option value="'+value.id+'" selected="selected">'+value.name+'</option>');
        }
        else{
            $('#area').append('<option value="'+value.id+'">'+value.name+'</option>');
        }
    });
}
 $().ready(function(){
     $('.select2').select2({
 		tags: true,
 		language: "zh-CN",
 		placeholder: "请选择/输入",
 	});

    $.each(provinces,function(index,value){
        if(value.id == '{{$item->province_id}}'){
            $('#province').append('<option value="'+value.id+'" selected="selected">'+value.name+'</option>');
            $.provinceChange({{$item->city_id}},function(){
                $.cityChange({{$item->area_id}});
            });
        }
        else{
            $('#province').append('<option value="'+value.id+'">'+value.name+'</option>');
        }
    });
    $('#province').on('change', function(){
        $.provinceChange();
    })
    $('#city').on('change', function(){
        $.cityChange();
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
