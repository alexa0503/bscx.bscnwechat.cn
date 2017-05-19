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
<div class="abs hx_fault" ></div>
<div class="abs txt black"  style="top: 347px;">
	<div>此二维码已核销</div>
	<div class="line"></div>
	<div class="txt-left black adjust-bottom">如有问题请致电：</div>
	<div class="txt-left blue">18621534023或</div>
	<div class="txt-left blue">021-61321888*4321</div>
	</div>
</div>

</body>
</html>
