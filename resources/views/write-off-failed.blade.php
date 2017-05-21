<!DOCTYPE html>
<html>
<head>
<meta content="IE=11.0000" http-equiv="X-UA-Compatible">
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link rel="stylesheet" type="text/css" href="{{asset('css/hx_flow.css')}}">
<title></title>

<!--移动端版本兼容 -->
<script type="text/javascript">
         var ww =  parseInt(window.screen.width);
         var hh =  parseInt(window.screen.height);
		 var phoneWidth= (ww>hh)?hh:ww;
         var phoneScale = phoneWidth/640;
         var ua = navigator.userAgent;
         if (/Android (\d+\.\d+)/.test(ua)){
                   var version = parseFloat(RegExp.$1);
                   if(version>2.3){
                            document.write('<meta name="viewport" content="width=640, minimum-scale = '+phoneScale+', maximum-scale = '+phoneScale+', target-densitydpi=device-dpi">');
                   }else{
                            document.write('<meta name="viewport" content="width=640, target-densitydpi=device-dpi">');
                   }
         } else {
                   document.write('<meta name="viewport" content="width=640, user-scalable=no, target-densitydpi=device-dpi">');
         }
</script>
<!--移动端版本兼容 end -->

<script src="{{asset('js/jquery.min.js')}}"></script>
</head>
<body>
    <div class="abs fault_5" style="width: 522px; height: 808px; left: 60px; top: 88px;  background-image: url('hx_fault/fault_5.png');"></div>


    <div class="abs center fault_4" style="width: 360px; height: 110px; left: 138px; top: 239px;   ">
    此二维码已于{{$form->check_date}}核销完成。
    </div>
    <div class="abs fault_4" style="width: 360px; height: 110px; left: 130px; top: 320px; color:#238cef;">
    核销信息
    </div>
    <div class="abs information" style="left: 130px;top: 371px; ">
    		<div class="flw info-line t1" style="">
    			<div class="info-name ">预约人: </div>
    			<div class="info info1" style="width: 307px; left: 242px; top: 322px;  ">{{$form->name}}</div>
    			<div class="clear"></div>
    		</div>
    		<div class="flw info-line t2" >

    			<div class="info-name ">手机号码：</div>
    			<div class="info info2" style="width: 307px; left: 242px; top: 405px;  ">{{$form->mobile}}</div>
    			<div class="clear"></div>
    		</div>
    		<div class="flw info-line t3" >
    			<div class="info-name ">车牌号：</div>
    			<div class="info info3" style="width: 307px; height: 34px; left: 242px; top: 364px;  ">{{$form->plate_number}}</div>
    			<div class="clear"></div>
    		</div>
    		<div class="flw info-line t4" >

    			<div class="info-name ">预约门店：</div>
    			<div class="info info4" style="width: 307px; left: 242px; top: 447px;  ">{{$form->shop->name}}</div>
    			<div class="clear"></div>

    		</div>
    		<div class="flw info-line t5" >

    			<div class="info-name ">预约地址：</div>
    			<div class="info info5" style="width: 307px; left: 242px; top: 489px;  ">{{$form->shop->province->name}} {{$form->shop->city->name}} {{$form->shop->area->name}} {{$form->shop->address}}</div>
    			<div class="clear"></div>

    		</div>
    		<div class="flw info-line t6" >

    			<div class="info-name ">预约日期：</div>
    			<div class="info info6" style="width: 307px; left: 242px; top: 531px;  ">{{$form->booking_date}}</div>
    			<div class="clear"></div>
    		</div>
    		<div class="flw info-line t7" >
    			<div class="info-name ">机油型号： </div>
    			<div class="info info7" style="width: 307px; left: 242px; top: 573px;  ">{{$form->oil_info}}</div>
    			<div class="clear"></div>
    		</div>
    		<div class="flw t8" style="width:400px; height:100%;">
    <div class="fault_2" style="width: 218px; height: 29px; left: 120px; top: 737px;  background-image: url('{{asset("hx_fault/fault_2.png")}}');"></div>
    <div class="fault_1" style="margin-top:15px;width: 255px; height: 59px; left: 119px; top: 780px;  background-image: url('{{asset("hx_fault/fault_1.png")}}');"></div>

    		</div>
    	<div>

</body>
</html>
