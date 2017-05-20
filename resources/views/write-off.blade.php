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
        <button id="scan">点我扫码</button>
    </div>
</div>
<script src="{{asset('js/jquery-2.1.1.min.js')}}"></script>
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script src="//newwx.ompchina.net/public/javascripts/weixinjssdk.js"></script>
<script>
DATAForWeixin.debug = true; // 可设置为 true 以调试

DATAForWeixin.appId = 'wx1f984cba30eb34b7',//账号的appid
DATAForWeixin.openid = '',
DATAForWeixin.sharecampaign = '普利司通',//campaign名称
/* 请修改以下文字和图片，定制分享文案 */
DATAForWeixin.setTimeLine({
    title: ' ',
    imgUrl: '',
    link: ''
});
DATAForWeixin.setAppMessage({
    title: '',
    imgUrl: '',
    desc: ' ',
    link: ''
});
DATAForWeixin.setQQ({
    title: ' ',
    imgUrl: '',
    desc: ' ',
    link: ''
});
$(document).ready(function () {
    DATAForWeixin.getWx(function (wx) {
        // 9.1.2 扫描二维码并返回结果
        $('#scan').on('click', function () {
            wx.scanQRCode({
                needResult: 0, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
                scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
                success: function (res) {
                    var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
                    var url = '{{url("/writeoff")}}';
                    var key = '{{Request::segment(2)}}';
                    var shop_id = '{{Request::segment(3)}}';
                    $.post(url,{shop_id:shop_id,key:key,result:result},function(json){
                        if(json){
                            location.href = '{{url("/result")}}';
                        }
                        else{
                            alert('扫描失败，请刷新页面重新扫描~')
                        }
                    },"JSON").fail(function(){
                        alert('扫描失败，请刷新页面重新扫描~')
                    });
                }
            });
        });
    });
});
</script>
</body>
</html>
