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
    <div class="abs" ></div>
    <div class="abs txt black"  style="top: 347px;">
        <div>核销</div>
        <div class="line"></div>
        <button id="scan">核销</button>
    </div>
</div>
<script src="{{asset('js/jquery-2.1.1.min.js')}}"></script>
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" charset="utf-8">
    wx.config({!! \EasyWeChat::js()->config(array('scanQRCode'), false); !!});
$().ready(function(){
    wx.ready(function(){
        $('#scan').on('click', function () {
            wx.scanQRCode({
                needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
                scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
                success: function (res) {
                    var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
                    var url = '{{url("/writeoff")}}';
                    var key = '{{Request::segment(2)}}';
                    var shop_id = '{{Request::segment(3)}}';
                    alert(url);
                    $.post(url,{shop_id:shop_id,key:key,result:result},function(json){
                        if(json){
                            location.href = '{{url("/result")}}';
                        }
                        else{
                            alert('扫描失败，请刷新页面重新扫描~')
                        }
                    });
                }
            });
        });
    });
});
</script>
</body>
</html>
