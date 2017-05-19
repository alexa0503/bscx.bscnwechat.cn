<!DOCTYPE html>
<html>
<head>
    <meta content="IE=11.0000" http-equiv="X-UA-Compatible">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="{{asset('css/hx.css')}}">
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
    {!! QrCode::size(400)->margin(0)->generate($qrcode); !!}
</body>
</html>
