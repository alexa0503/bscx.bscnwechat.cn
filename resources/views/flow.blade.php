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
<link rel="stylesheet" href="{{asset('css/swiper.css')}}">
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
<body onload="init();">
	<div class="abs page1">
		<div class="abs qrcode" style="width: 432px; height: 432px; left: 104px; top: 215px;">
            {!! QrCode::size(432)->margin(0)->generate($url); !!}
        </div>
		<div class="abs btn_view" style="width: 471px; height: 86px; left: 85px; top: 740px;  background-image: url('{{asset("0_flow/btn_view.png")}}');"></div>
	</div>


    <!-- Swiper -->
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="p2 swiper-slide">

				<div class="abs btn_swipe" style="width: 410px; height: 70px; left: 124px; top: 874px;  background-image: url('{{asset("0_flow/btn_swipe.png")}}');"></div>
				<div class="abs arrow" style="width: 32px; height: 16px; left: 430px; top: 900px;  background-image: url('{{asset("0_flow/arrow.png")}}');"></div>

			</div>
            <div class="p3 swiper-slide">

				<div class="abs btn_swipe" style="width: 410px; height: 70px; left: 124px; top: 874px;  background-image: url('{{asset("0_flow/btn_swipe.png")}}');"></div>
				<div class="abs arrow" style="width: 32px; height: 16px; left: 430px; top: 900px;  background-image: url('{{asset("0_flow/arrow.png")}}');"></div>

			</div>
            <div class="p4 swiper-slide">

				<div class="abs btn_swipe" style="width: 410px; height: 70px; left: 124px; top: 874px;  background-image: url('{{asset("0_flow/btn_swipe.png")}}');"></div>
				<div class="abs arrow" style="width: 32px; height: 16px; left: 430px; top: 900px;  background-image: url('{{asset("0_flow/arrow.png")}}');"></div>

			</div>
            <div class="p5 swiper-slide">

				<div class="abs btn_swipe" style="width: 410px; height: 70px; left: 124px; top: 874px;  background-image: url('{{asset("0_flow/btn_swipe.png")}}');"></div>
				<div class="abs arrow" style="width: 32px; height: 16px; left: 430px; top: 900px;  background-image: url('{{asset("0_flow/arrow.png")}}');"></div>

			</div>
            <div class="p6 swiper-slide">

				<div class="abs btn_back" style="width: 410px; height: 70px; left: 124px; top: 874px;  background-image: url('{{asset("0_flow/btn_back.png")}}');"></div>
				<div class="abs arrow" style="width: 32px; height: 16px; left: 430px; top: 900px;  background-image: url('{{asset("0_flow/arrow.png")}}');"></div>


			</div>
        </div>

        <!-- Add Pagination -->
       <!-- <div class="swiper-pagination"></div>-->

    </div>

    <!-- Swiper JS -->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/swiper.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>

    <script>

    </script>

</body>
</html>
