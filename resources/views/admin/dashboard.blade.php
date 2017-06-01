@extends('layouts.admin')

@section('content')
@php
$shop = \App\Shop::select(\DB::raw('SUM(views) AS total'))->first();
$total = $shop->total;
$today = \Carbon\Carbon::today();
$today_booked_num = \App\Form::where('booking_date', $today->toDateString())->count();
$today_created_num = \App\Form::where('created_at', '>=', $today->toDateString())->count();
$has_received_num = \App\Form::whereHas('lottery',function($query){
        $query->where('is_received',1);
    })->count();
@endphp
    <div class="padding-md">
        <!--
        <div class="row">
            <div class="col-sm-6">
                <div class="page-title">
                    Dashboard
                </div>
                <div class="page-sub-header">
                    Welcome Back, John Doe , <i class="fa fa-map-marker text-danger"></i> London
                </div>
            </div>
            <div class="col-sm-6 text-right text-left-sm p-top-sm">
                <div class="btn-group">
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        Select Project <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                        <li><a href="index.html#">Project1</a></li>
                        <li><a href="index.html#">Project2</a></li>
                        <li><a href="index.html#">Project3</a></li>
                        <li class="divider"></li>
                        <li><a href="index.html#">Setting</a></li>
                    </ul>
                </div>

                <a class="btn btn-default"><i class="fa fa-cog"></i></a>
            </div>
        </div>
        -->
        <div class="row m-top-md">
            <div class="col-lg-6 col-sm-12">
                <div class="statistic-box bg-danger m-bottom-md">
                    <div class="statistic-title">
                        店铺总访问量
                    </div>

                    <div class="statistic-value">
                        {{$total}}
                    </div>

                    <div class="m-top-md"></div>

                    <div class="statistic-icon-background">
                        <i class="ion-eye"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-sm-12">
                <div class="statistic-box bg-purple m-bottom-md">
                    <div class="statistic-title">
                        今日预约数
                    </div>

                    <div class="statistic-value">
                        {{$today_booked_num}}
                    </div>

                    <div class="m-top-md"></div>

                    <div class="statistic-icon-background">
                        <i class="ion-person-add"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-sm-12">
                <div class="statistic-box bg-primary m-bottom-md">
                    <div class="statistic-title">
                        今日创建预约数
                    </div>

                    <div class="statistic-value">
                        {{$today_created_num}}
                    </div>

                    <div class="m-top-md"></div>

                    <div class="statistic-icon-background">
                        <i class="ion-person-add"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="statistic-box bg-info m-bottom-md">
                    <div class="statistic-title">
                        已领取预约数
                    </div>

                    <div class="statistic-value">
                        {{$has_received_num}}
                    </div>

                    <div class="m-top-md"></div>

                    <div class="statistic-icon-background">
                        <i class="ion-person-add"></i>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- ./padding-md -->
@endsection
@section('scripts')
    <!-- Flot -->
    <script src="{{asset('js/jquery.flot.min.js')}}"></script>
    <!-- Morris -->
    <script src="{{asset('js/rapheal.min.js')}}"></script>
    <script src="{{asset('js/morris.min.js')}}"></script>
    <!-- Datepicker -->
    <script src="{{asset('js/uncompressed/datepicker.js')}}"></script>
    <!-- Sparkline -->
    <script src="{{asset('js/sparkline.min.js')}}"></script>
    <!-- Skycons -->
    <script src="{{asset('js/uncompressed/skycons.js')}}"></script>
    <!-- Easy Pie Chart -->
    <script src="{{asset('js/jquery.easypiechart.min.js')}}"></script>
    <!-- Sortable -->
    <script src="{{asset('js/uncompressed/jquery.sortable.js')}}"></script>
    <!-- Owl Carousel -->
    <script src="{{asset('js/owl.carousel.min.js')}}"></script>
    <!-- Modernizr -->
    <script src="{{asset('js/modernizr.min.js')}}"></script>
    <script src="{{asset('js/simplify/simplify_dashboard.js')}}"></script>
    <script>
        $(function()	{
            $('.chart').easyPieChart({
                easing: 'easeOutBounce',
                size: '140',
                lineWidth: '7',
                barColor: '#7266ba',
                onStep: function(from, to, percent) {
                    $(this.el).find('.percent').text(Math.round(percent));
                }
            });

            $('.sortable-list').sortable();

            $('.todo-checkbox').click(function()	{

                var _activeCheckbox = $(this).find('input[type="checkbox"]');

                if(_activeCheckbox.is(':checked'))	{
                    $(this).parent().addClass('selected');
                }
                else	{
                    $(this).parent().removeClass('selected');
                }

            });
            //Delete Widget Confirmation
            $('#deleteWidgetConfirm').popup({
                vertical: 'top',
                pagecontainer: '.container',
                transition: 'all 0.3s'
            });
        });
    </script>
@endsection
