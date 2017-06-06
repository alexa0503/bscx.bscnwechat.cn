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
$provinces = \App\Province::all();
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
                        已领取预约数(总)
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
        <div class="row">
            <div class="col-lg-12">
                <div class="smart-widget widget-dark-blue">
                    <div class="smart-widget-header">
                        各省份预约表
                        <span class="smart-widget-option">
                            <span class="refresh-icon-animated">
                                <i class="fa fa-circle-o-notch fa-spin"></i>
                            </span>
                            <a href="#" class="widget-toggle-hidden-option">
                                <i class="fa fa-cog"></i>
                            </a>
                            <a href="#" class="widget-collapse-option" data-toggle="collapse">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a href="#" class="widget-refresh-option">
                                <i class="fa fa-refresh"></i>
                            </a>
                            <a href="#" class="widget-remove-option">
                                <i class="fa fa-times"></i>
                            </a>
                        </span>
                    </div>
                    <div class="smart-widget-inner">
                        <div class="smart-widget-hidden-section">
                            <ul class="widget-color-list clearfix">
                                <li style="background-color:#20232b;" data-color="widget-dark"></li>
                                <li style="background-color:#4c5f70;" data-color="widget-dark-blue"></li>
                                <li style="background-color:#23b7e5;" data-color="widget-blue"></li>
                                <li style="background-color:#2baab1;" data-color="widget-green"></li>
                                <li style="background-color:#edbc6c;" data-color="widget-yellow"></li>
                                <li style="background-color:#fbc852;" data-color="widget-orange"></li>
                                <li style="background-color:#e36159;" data-color="widget-red"></li>
                                <li style="background-color:#7266ba;" data-color="widget-purple"></li>
                                <li style="background-color:#f5f5f5;" data-color="widget-light-grey"></li>
                                <li style="background-color:#fff;" data-color="reset"></li>
                            </ul>
                        </div>
                        <div class="smart-widget-body no-padding">
                            <div class="padding-md">
                                <div id="totalSalesChart" class="morris-chart" style="height:250px;"></div>
                            </div>
                        </div>
                    </div><!-- ./smart-widget-inner -->
                </div><!-- ./smart-widget -->
            </div><!-- ./col -->
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
            var data = [];
            @foreach($provinces as $province)
            data.push({ y: '{{$province->name}}', a: {{$province->booked_num}}, b: {{$province->booked_limit_num}} });
            @endforeach

        	//Morris Chart (Total Visits)
        	var totalVisitChart = Morris.Bar({
        	  element: 'totalSalesChart',
        	  data: data,
        	  xkey: 'y',
        	  ykeys: ['a', 'b'],
        	  labels: ['预约数', '限额'],
        	  barColors: ['#333', '#999'],
        	  grid: false,
        	  gridTextColor: '#777',
        	});

        	$(window).resize(function(e)	{
        		// Redraw All Chart
        		setTimeout(function() {
        			totalVisitChart.redraw();
        			//plotWithOptions();
        		},500);
        	});

        	$('#sidebarToggleLG').click(function()	{
        		// Redraw All Chart
        		setTimeout(function() {
        			totalVisitChart.redraw();
        			//plotWithOptions();
        		},500);
        	});

        	$('#sidebarToggleSM').click(function()	{
        		// Redraw All Chart
        		setTimeout(function() {
        			totalVisitChart.redraw();
        			//plotWithOptions();
        		},500);
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
