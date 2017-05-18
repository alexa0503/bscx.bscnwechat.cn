<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>登录 - {{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/font-awesome.4.6.0.css')}}">
    <!-- ionicons -->
    <link rel="icon" type="image/png" href="{{asset('favicon.png')}}">
    <!-- Simplify -->
    <link href="{{asset('css/simplify.min.css')}}" rel="stylesheet"><!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
<body class="overflow-hidden light-background">
<div class="wrapper no-navigation preload">
    <div class="sign-in-wrapper">
        <div class="sign-in-inner">
            <div class="login-brand text-center">
                <i class="fa fa-database m-right-xs"></i> {{env('PAGE_TITLE')}}<!-- <strong class="text-skin">Admin--></strong>
            </div>

            <form method="post" action="{{url('login')}}" id="login-form">
                {!! csrf_field() !!}
                <div class="form-group m-bottom-md">
                    <input type="text" name="name" class="form-control" value="{{Request::input('name')}}" placeholder="输入您的用户名" tabindex="1">
                    <label class="help-block"></label>
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="输入您的密码" tabindex="2">
                    <label class="help-block"></label>
                </div>

                <div class="form-group">
                    <div class="custom-checkbox">
                        <input type="checkbox" value="1" name="remember" id="chkRemember" tabindex="3" {{ old('remember') ? 'checked' : '' }}>
                        <label for="chkRemember"></label>
                    </div>
                    下次自动登录
                </div>

                <div class="m-top-md p-top-sm">
                    <a href="#" class="btn btn-success block" id="sign-in">登录</a>
                </div>

                <!--<div class="m-top-md p-top-sm">
                    <div class="font-12 text-center m-bottom-xs">
                        <a href="#" class="font-12">Forgot password ?</a>
                    </div>
                    <div class="font-12 text-center m-bottom-xs">Do not have an account?</div>
                    <a href="#" class="btn btn-default block">Create an accounts</a>
                </div>-->
            </form>
        </div><!-- ./sign-in-inner -->
    </div><!-- ./sign-in-wrapper -->
</div><!-- /wrapper -->

<a href="" id="scroll-to-top" class="hidden-print"><i class="icon-chevron-up"></i></a>

<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- Jquery -->
<script src="{{asset('js/jquery-2.1.1.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{asset('js/jquery.slimscroll.min.js')}}"></script>
<!-- Popup Overlay -->
<script src="{{asset('js/jquery.popupoverlay.min.js')}}"></script>
<!-- Modernizr -->
<script src="{{asset('js/modernizr.min.js')}}"></script>
<!--form-->
<script src="{{asset('js/jquery.form.js')}}"></script>
<!-- Simplify -->
<script src="{{asset('js/simplify/simplify.js')}}"></script>
<script>
    $().ready(function(){
        $('#sign-in').on('click',function(){
            $('#login-form').ajaxSubmit({
                //dataType: 'json',
                success: function() {
                    $('#login-form').modal('hide');
                    //$('#login-form .form-group .help-block').empty();
                    //$('#login-form .form-group').removeClass('has-error');
                    location.reload(true);
                },
                error: function(xhr){
                    if (xhr.status == 200){
                        $('#login-form').modal('hide');
                        location.reload(true);
                    }
                    var json = jQuery.parseJSON(xhr.responseText);
                    var keys = Object.keys(json);
                    $('#login-form .form-group .help-block').empty();
                    $('#login-form .form-group').removeClass('has-error');
                    $('#login-form .form-group').each(function(){
                        var name = $(this).find('select').attr('name') || $(this).find('input,textarea').attr('name');
                        if( $.inArray(name, keys) != -1){
                            $(this).addClass('has-error');
                            $(this).find('.help-block').html(json[name]);
                        }
                    })
                }
            });
            return false;
        });
    });
</script>
</body>
</html>
