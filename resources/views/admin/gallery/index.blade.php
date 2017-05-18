@extends('layouts.admin')
@section('content')
    <h2 class="header-text no-margin">
        图库管理
    </h2>
    <!--<div class="gallery-filter m-top-md">
        <ul class="clearfix">
            <li class="active"><a href="gallery.html#">All</a></li>
            <li><a href="gallery.html#">Albums</a></li>
            <li><a href="gallery.html#">Friends</a></li>
            <li><a href="gallery.html#">Trips</a></li>
            <li><a href="gallery.html#">Business</a></li>
        </ul>
    </div>-->
    <div class="gallery-list js-masonry m-top-md">
        @foreach($items as $item)
        <div class="gallery-item">
            <div class="gallery-wrapper">
                <a class="gallery-remove"><i class="fa fa-times"></i></a>
                <img src="{{asset($item->cover)}}" alt="">
                <div class="gallery-title">
                    {{$item->name}}
                </div>
                <div class="gallery-overlay">
                    <a href="{{asset($item->cover)}}" class="gallery-action enlarged-photo"><i class="fa fa-search-plus fa-lg"></i></a>
                    <a href="#" class="gallery-action animation-dalay"><i class="fa fa-link fa-lg"></i></a>
                </div>
            </div>
        </div>
        @endforeach
    </div><!-- ./gallery-list -->
@endsection
@section('scripts')
<!-- Slimscroll -->
<script src="{{asset('js/jquery.slimscroll.min.js')}}"></script>

<!-- Colorbox -->
<script src="{{asset('js/jquery.colorbox.min.js')}}"></script>

<!-- Popup Overlay -->
<script src="{{asset('js/jquery.popupoverlay.min.js')}}"></script>

<!-- Mansory-->
<script src="{{asset('js/masonry.pkgd.min.js')}}"></script>

<!-- Modernizr -->
<script src="{{asset('js/modernizr.min.js')}}"></script>

<!-- Simplify -->
<script src="{{asset('js/simplify/simplify.js')}}"></script>
<script>
    $(function()	{
        $(".enlarged-photo").colorbox({
            rel:'gallery-group1',
            maxWidth: '85%'
        });

        $('.gallery-item').bind('touchstart', function(e){
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
        });

        $('#sidebarToggleLG').click(function()	{
            $('.gallery-list').masonry({
                itemSelector: '.gallery-item'
            });
        });

        $('#sidebarToggleSM').click(function()	{
            $('.gallery-list').masonry({
                itemSelector: '.gallery-item'
            });
        });

        //Delete Confirmation
        $('#deleteGalleryConfirm').popup({
            vertical: 'top',
            pagecontainer: '.container',
            transition: 'all 0.3s'
        });

        $('.gallery-remove').click(function()	{
            $('#deleteGalleryConfirm').popup('show');
            return false;
        });

        $(window).load(function()	{
            $('.gallery-list').masonry({
                itemSelector: '.gallery-item'
            });
        });
    });
</script>
@endsection
@section('popup')
<!-- Delete confirmation -->
<div class="custom-popup delete-confirmation-popup" id="deleteGalleryConfirm">
    <div class="popup-header text-center">
        <span class="fa-stack fa-4x">
          <i class="fa fa-circle fa-stack-2x"></i>
          <i class="fa fa-lock fa-stack-1x fa-inverse"></i>
        </span>
    </div>
    <div class="popup-body text-center">
        <h5>确定此操作吗？</h5>
        <strong class="block m-top-xs"><i class="fa fa-exclamation-circle m-right-xs text-danger"></i>操作无法返回</strong>

        <div class="text-center m-top-lg">
            <a class="btn btn-success m-right-sm">删除</a>
            <a class="btn btn-default deleteGalleryConfirm_close">取消</a>
        </div>
    </div>
</div>
@endsection
