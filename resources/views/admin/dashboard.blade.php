@extends('layouts.admin')

@section('content')

    <div class="padding-md">
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

        <div class="row m-top-md">
            <div class="col-lg-6 col-sm-12">
                <div class="statistic-box bg-danger m-bottom-md">
                    <div class="statistic-title">
                        Today Visitors
                    </div>

                    <div class="statistic-value">
                        96.7k
                    </div>

                    <div class="m-top-md">11% Higher than last week</div>

                    <div class="statistic-icon-background">
                        <i class="ion-eye"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-sm-12">
                <div class="statistic-box bg-purple m-bottom-md">
                    <div class="statistic-title">
                        Today Users
                    </div>

                    <div class="statistic-value">
                        129
                    </div>

                    <div class="m-top-md">3% Higher than last week</div>

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
                        TOTAL VISITS
                        <span class="smart-widget-option">
										<span class="refresh-icon-animated">
											<i class="fa fa-circle-o-notch fa-spin"></i>
										</span>
			                            <a href="index.html#" class="widget-toggle-hidden-option">
			                                <i class="fa fa-cog"></i>
			                            </a>
			                            <a href="index.html#" class="widget-collapse-option" data-toggle="collapse">
			                                <i class="fa fa-chevron-up"></i>
			                            </a>
			                            <a href="index.html#" class="widget-refresh-option">
			                                <i class="fa fa-refresh"></i>
			                            </a>
			                            <a href="index.html#" class="widget-remove-option">
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

                            <div class="bg-grey">
                                <div class="row">
                                    <div class="col-xs-4 text-center">
                                        <h3 class="m-top-sm">999</h3>
                                        <small class="m-bottom-sm block">Total Visits</small>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <h3 class="m-top-sm">102</h3>
                                        <small class="m-bottom-sm block">New Visits</small>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <h3 class="m-top-sm">690</h3>
                                        <small class="m-bottom-sm block">Bounce Rate</small>
                                    </div>
                                </div>
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
