@extends('layouts.admin')

@section('content')
       <div class="right-side">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <!-- Starting of Dashboard header items area -->
                        <div class="panel panel-default admin">
                          <div class="panel-heading admin-title">Admin Dashboard!</div>
                              <div class="panel-body dashboard-body">
                                  <div class="dashboard-header-area">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                            <a href="{{route('admin-user-index')}}" class="title-stats title-blue">
                                                <div class="icon"><i class="fa fa-newspaper-o fa-5x"></i></div>
                                                <div class="number">{{count($users)}}</div>
                                                <h4>Total Handymen!</h4>
                                                <span class="title-view-btn">View All</span>
                                            </a>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                            <a href="{{route('admin-cat-index')}}" class="title-stats title-green">
                                                <div class="icon"><i class="fa fa-sitemap fa-5x"></i></div>
                                                <div class="number">{{count($cats)}}</div>
                                                <h4>Total Services!</h4>
                                                <span class="title-view-btn">View All</span>
                                            </a>
                                        </div>
                                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                            <a href="{{route('admin-adv-index')}}" class="title-stats title-gray">
                                                <div class="icon"><i class="fa fa-link fa-5x"></i></div>
                                                <div class="number">{{count($ads)}}</div>
                                                <h4>Total Ads!</h4>
                                                <span class="title-view-btn">View All</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Ending of Dashboard header items area -->
                        
                    <!-- Starting of Dashboard Top reference + Most Used OS area -->
                    <div class="reference-OS-area">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="panel panel-default admin top-reference-area">
                                    <div class="panel-heading">Top Referrals</div>
                                    <div class="panel-body">
                                        <div id="chartContainer-topReference"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="panel panel-default admin top-reference-area">
                                    <div class="panel-heading">Most Used OS</div>
                                    <div class="panel-body">
                                        <div id="chartContainer-os"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Ending of Dashboard Top reference + Most Used OS area -->

                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

<script type="text/javascript">
        var chart1 = new CanvasJS.Chart("chartContainer-topReference",
            {
                exportEnabled: true,
                animationEnabled: true,

                legend: {
                    cursor: "pointer",
                    horizontalAlign: "right",
                    verticalAlign: "center",
                    fontSize: 16,
                    padding: {
                        top: 20,
                        bottom: 2,
                        right: 20,
                    },
                },
                data: [
                    {
                        type: "pie",
                        showInLegend: true,
                        legendText: "",
                        toolTipContent: "{name}: <strong>{#percent%} (#percent%)</strong>",
                        indexLabel: "#percent%",
                        indexLabelFontColor: "white",
                        indexLabelPlacement: "inside",
                        dataPoints: [
                                @foreach($referrals as $browser)
                                    {y:{{$browser->total_count}}, name: "{{$browser->referral}}"},
                                @endforeach
                        ]
                    }
                ]
            });
        chart1.render();

        var chart = new CanvasJS.Chart("chartContainer-os",
            {
                exportEnabled: true,
                animationEnabled: true,
                legend: {
                    cursor: "pointer",
                    horizontalAlign: "right",
                    verticalAlign: "center",
                    fontSize: 16,
                    padding: {
                        top: 20,
                        bottom: 2,
                        right: 20,
                    },
                },
                data: [
                    {
                        type: "pie",
                        showInLegend: true,
                        legendText: "",
                        toolTipContent: "{name}: <strong>{#percent%} (#percent%)</strong>",
                        indexLabel: "#percent%",
                        indexLabelFontColor: "white",
                        indexLabelPlacement: "inside",
                        dataPoints: [
                            @foreach($browsers as $browser)
                                {y:{{$browser->total_count}}, name: "{{$browser->referral}}"},
                            @endforeach
                        ]
                    }
                ]
            });
        chart.render();    
</script>
@endsection