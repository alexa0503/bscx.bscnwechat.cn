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
<title>普利司通</title>

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
<div class="abs enter_3" style="width: 640px; height: 1039px; left: 0px; top: 0px;  background-image: url('{{asset("hx_enter/enter_3.png")}}');"></div>
<div class="abs enter_2" style="width: 521px; height: 700px; left: 60px; top: 156px;  background-image: url('{{asset("hx_enter/enter_2.png")}}');"></div>
<div class="abs enter_1" style="width: 373px; height: 110px; left: 133px; top: 456px;  background-image: url('{{asset("hx_enter/enter_1.png")}}');"></div>

<form action="{{url("/writeoff")}}" method="post" id="form-writeoff">
    {{ csrf_field() }}
    <input type="hidden" value="{{Request::segment(3)}}" name="key" />
    <input type="hidden" value="{{Request::segment(2)}}" name="shop_id" />
    <input type="hidden" value="" name="result" id="input-result" />
</form>
<script src="{{asset('js/jquery-2.1.1.min.js')}}"></script>
<script src="//res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript" charset="utf-8">
    wx.config({!! \EasyWeChat::js()->config(array('scanQRCode'), false); !!});
$().ready(function(){
    $('.enter_1').on('click', function () {
        var result = 'eyJpdiI6IkhVbjVBMHhjTHBBXC96WlVOeTZWQ0JRPT0iLCJ2YWx1ZSI6IlwvV3FFR1YzMmNQR0puM0sremFcL244NEpMSjN0dUY0MWZpNXVpVmIxTGdMMVZYMlhUa282cjVjMDMydXh0YWdFN2FXV2hUQ1lxamVDejc2OVlOUzlwNnc9PSIsIm1hYyI6IjVhNzhlMDdlM2JiYzEyYWY1ZjVjZjFhYjg4ODkyNDFkMTVjNDc3MmFmYmU3M2E1YjlhNDc4NDI1M2JiOWFlYmMifQ';
        $.when($('#input-result').val(result)).then($('#form-writeoff').submit());
    });
    wx.ready(function(){
        $('.enter_1').on('click', function () {
            wx.scanQRCode({
                needResult: 1, // 默认为0，扫描结果由微信处理，1则直接返回扫描结果，
                scanType: ["qrCode","barCode"], // 可以指定扫二维码还是一维码，默认二者都有
                success: function (res) {
                    var result = res.resultStr; // 当needResult 为 1 时，扫码返回的结果
                    $.when($('#input-result').val(result)).then($('#form-writeoff').submit());
                    /*
                    var url = '{{url("/writeoff")}}';
                    var key = '{{Request::segment(3)}}';
                    var shop_id = '{{Request::segment(2)}}';
                    //$('.line').html(url+'{shop_id:'+shop_id+',key:'+key+',result:'+result+'}')
                    $.post(url,{shop_id:shop_id,key:key,result:result},function(json){
                        if(json){
                            location.href = '{{url("/result")}}';
                        }
                        else{
                            alert('扫描失败，请刷新页面重新扫描~')
                        }
                    });
                    */
                }
            });
        });
    });
});
</script>
</body>
</html>
