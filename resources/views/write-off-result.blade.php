<!DOCTYPE html>
<html>
<head>
<meta content="IE=11.0000" http-equiv="X-UA-Compatible">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<link rel="stylesheet" type="text/css" href="css/hx.css">
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

</head>
<body>
<div class="abs {{Session::has('hx_class') ? Session('hx_class') : 'hx_fault'}}" ></div>
<div class="abs txt black"  style="top: 347px;">
    @if(Session::has('hx_msg'))
    @if(Session('hx_msg') == '1003')
	<div>此二维码已核销</div>
	<div class="line"></div>
	<div class="txt-left black adjust-bottom">如有问题请致电：</div>
	<div class="txt-left blue">18621534023或</div>
	<div class="txt-left blue">021-61321888*4321</div>
	</div>
    @elseif(Session('hx_msg') == '1004')
    <div class="black">预约时间不符</div>
	<div class="line"></div>
	<div class="txt-left" style="top: 493px; ">正确的预约时间：
	<div class="gray adjust-bottom">{{ Session('hx_booking_date') }}</div>
	<div class="txt-left blue">
	请通知消费者准确的预约时间到店。谢谢！
	</div>
    @elseif(Session('hx_msg') == '1002')
	<div>预约店铺不符，<br/>正确门店信息：{{ Session('hx_address') }}.  </div>
	<div class="line"></div>
	<div class="blue" style=" ">还请告知消费者。谢谢！</div>
    @endif
    @else
    <div>无效的链接</div>
    @endif
</div>

</body>
</html>
