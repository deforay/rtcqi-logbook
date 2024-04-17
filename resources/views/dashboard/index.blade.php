<?php
$enddate = date('d-M-Y');
$startdate = date('d-M-Y', strtotime('-179 days'));
?>

<style>
    .middle {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
    }

    .nav.nav-tabs.nav-top-border .nav-item a.nav-link.active {
        border-top: 3px solid #1e9ff2;
    }

    .nav.nav-tabs.nav-top-border .nav-item a {
        color: #1e9ff2;
    }

    #map {
        height: 100%;
        width: 100%;
        z-index: 1;
    }
</style>
@extends('layouts.main')
@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
<div class="content-wrapper">
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Dashboard</h3>
        </div>
        @if($errors->any())
        <div class="alert alert-success alert-dismissible fade show ml-5 mr-5 mt-4" role="alert" id="show_alert_index">
            <div class="text-center" style="font-size: 18px;"><b>
                    {{$errors->first()}}</b></div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div>
        <script>
            $('#show_alert_index').delay(3000).fadeOut();
        </script>
        @endif

    </div>
    <div class="content-body">
        <!-- Charts section start -->
        <div class="row">
            <div class="col-xl-4 col-lg-6 col-12">
                <div class="card pull-up">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="media-body text-left">
                                    <h3 class="info">{{$total}}</h3>
                                    <h6>Overall Audits</h6>
                                </div>
                                <div>
                                    <i class="icon-list info font-large-2 float-right"></i>
                                </div>
                            </div>
                            <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-12">
                <div class="card pull-up">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="media-body text-left">
                                    <h3 class="warning">{{$monthly}}</h3>
                                    <h6>No. of Page Summaries (Last 12 Months)</h6>
                                </div>
                                <div>
                                    <i class="icon-list warning font-large-2 float-right"></i>
                                </div>
                            </div>
                            <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-6 col-12">
                <div class="card pull-up">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="media-body text-left">
                                    <h3 class="success">{{$siteMonthly}}</h3>
                                    <h6>No. of Sites Audits (Last 12 Months)</h6>
                                </div>
                                <div>
                                    <i class="icon-map success font-large-2 float-right"></i>
                                </div>
                            </div>
                            <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                                <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<section id="vector-maps">
    <!-- <div class="row">
        <div class="col-12 mt-3 mb-1">
            <h4 class="text-uppercase">Monthly Reports</h4>

        </div>
    </div> -->

    <div class="row">
        <div class="col-12">
            <div class="card box-shadow-0">
                <div class="card-content">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-4 col-lg-4 col-sm-12 mb-4 pl-1">
                                        <div class="media">
                                            <div class="media-body">
                                                <span class="text-bold-500">Date Range </span>
                                                <input type="text" id="searchDate" name="searchDate" class="form-control" placeholder="Select Date Range" value="{{$startdate}} to {{$enddate}}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-sm-12 mb-4 pl-1">
                                        <div class="media">
                                            <div class="media-body">
                                                <span class="text-bold-500">Province </span>
                                                <select class="form-control" autocomplete="off" style="width:100%;" id="provinceId" name="provinceId" title="Please select Province Name">
                                                    <option value="">Select Province</option>
                                                    @foreach($province as $row)
                                                    <option value="{{$row->province_id}}">{{$row->province_name}}</option>
                                                    @endforeach
                                                </select>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-4 col-sm-12 mb-4 pl-1">
                                        <div class="media">
                                            <div class="media-body">
                                                <button type="submit" onclick="getDashboardData();return false;" class="btn btn-info mt-4"> Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-lg-12">
                            <div id="monthly-report-map" class="height-500">

                                <div id="map">

                                </div>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--  Charts section end -->

<div class="row">
    <div id="recent-transactions" class="col-12">
        <div class="card">
            <!-- <div class="card-headers">
                <h4 class="card-title">Sitewise Report</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

            </div> -->
            <div class="card-content">
                <div class="table-responsive" id="trendList">

                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div id="recent-transactions" class="col-12">
        <div class="card">
            <div class="card-headers">
                <h4 class="card-title">Recent Monthly Logbook Entries</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a class="btn btn-sm btn-danger box-shadow-2 round btn-min-width pull-right" href="/monthlyreport" target="_blank">View More</a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content">
                <div class="table-responsive">
                    <table id="recent-orders" class="table table-hover table-xl mb-0">
                        <thead>
                            <tr>
                                <th class="border-top-0">Month/Year</th>
                                <th class="border-top-0">Site Name</th>
                                <th class="border-top-0">Site Type</th>
                                <th class="border-top-0">Date Of Collection</th>
                                <th class="border-top-0">Start Date</th>
                                <th class="border-top-0">End Date</th>
                                <th class="border-top-0">Total Tests</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $row)
                            <?php
                            $date = $row->date_of_data_collection;
                            $month = $row->reporting_month;
                            $startDate = $row->start_test_date;
                            $endDate = $row->end_test_date;
                            $date_of_collection = date('d-F-Y', strtotime($date));
                            $start_date = date('d-F-Y', strtotime($startDate));
                            $end_date = date('d-F-Y', strtotime($endDate));
                            $report_month = date('F-Y', strtotime($month));
                            ?>
                            <tr>
                                <td class="text-truncate">{{$report_month}}</td>
                                <td class="text-truncate">{{$row->site_name}}</td>
                                <td class="text-truncate">{{$row->site_type_name}}</td>
                                <td class="text-truncate">{{$date_of_collection}}</td>
                                <td class="text-truncate">{{$start_date}}</td>
                                <td class="text-truncate">{{$end_date}}</td>
                                <td class="text-truncate">{{$row->total_test}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-content">
        <div class="row" style="padding:10px;">
            <div class="col-12">
                <h4 class="text-uppercase">Monthly Reports - Last 12 months</h4>
                <div id="lastTwelveMonthlyChart"></div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-content">
        <div class="row" style="padding:10px;">
            <div class="col-12">
                <h4 class="text-uppercase">Sites Reporting - Last 12 months</h4>
                <div id="sitewiseMonthlyChart"></div>
            </div>
        </div>
    </div>
</div>
<!-- todo uncommented -->
<!-- <div class="row">
            <div class="col-12" >
                <h4 class="text-uppercase">Test Wise Monthly Reports - Last 12 months</h4>
                <div id="testwiseMonthlyChart"></div>
            </div>
        </div> -->
</div>
</div>

<script src="{{ asset('app-assets/vendors/js/charts/apexcharts/apexcharts.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#searchDate').daterangepicker({
                format: 'DD-MMM-YYYY',
                autoUpdateInput: false,
                separator: ' to ',
                startDate: moment().subtract('days', 179),
                endDate: moment(),
                maxDate: moment(),
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    'Last 7 Days': [moment().subtract('days', 6), moment()],
                    'Last 30 Days': [moment().subtract('days', 29), moment()],
                    'Last 60 Days': [moment().subtract('days', 59), moment()],
                    'Last 180 Days': [moment().subtract('days', 179), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')],
                    'Last 3 Months': [moment().subtract(3, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'Last 6 Months': [moment().subtract(6, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'Last 9 Months': [moment().subtract(9, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'Last 12 Months': [moment().subtract(12, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                    'Last 18 Months': [moment().subtract(18, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                }
            },
            function(start, end) {
                startDate = start.format('YYYY-MM-DD');
                endDate = end.format('YYYY-MM-DD');
                $('input[name="searchDate"]').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('DD-MMM-YYYY') + ' to ' + picker.endDate.format('DD-MMM-YYYY'));
                });
            });
        getDashboardData();
        getSitewiseReport();
    });

    function getDashboardData() {
        getSitewiseReport();
        let searchDate = $('#searchDate').val() || '';
        let provinceId = $('#provinceId').val() || '';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/getDashboardData') }}",
            method: 'post',
            dataType: 'json',
            data: {
                searchDate: searchDate,
                provinceId: provinceId,
            },
            error: function(e) {
                console.log(JSON.stringify(e));
            },
            success: function(result) {
                var lat = '{{$latitude}}';
                var log = '{{$longitude}}';
                var zoomLevel = '{{$mapZoomLevel}}';

                document.getElementById('monthly-report-map').innerHTML = "<div id='map' style='width: 100%; height: 100%;'></div>";
                var myIcon = L.icon({
                    iconUrl: "{{ asset('assets/images/location.svg')}}"
                });
                var map = L.map('map', {
                    zoomControl: false,
                    scrollWheelZoom: true,
                    inertia: false,
                    zoomAnimation: false,
                    minZoom: 3,
                    maxBounds: [
                        [-90.0, -180.0],
                        [90.0, 180.0]
                    ]
                }).setView([lat, log], zoomLevel);
                new L.Control.Zoom({
                    position: 'topleft'
                }).addTo(map);
                map._onResize();

                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                let coordinates = [];

                // populate coordinates array with all the markers
                //console.log(result.length);
                for (let i = 0; i < result.length; i++) {
                    coordinates.push(Object.values(result[i]));
                };

                // visualize the markers on the map
                for (let i = 0; i < coordinates.length; i++) {
                    L.marker([coordinates[i][0], coordinates[i][1]], {
                            icon: myIcon
                        }).bindPopup(coordinates[i][2])
                        .addTo(map);
                };
            }
        });
    }

    var options = {
        series: [{
            name: 'Count',
            data: [<?php
                    foreach ($monthWiseCount['period'] as $date) {
                        $callCount = (isset($monthWiseCount['data'][$date]) && trim($monthWiseCount['data'][$date]) != '') ? $monthWiseCount['data'][$date] : 0;
                        echo $callCount . ",";
                    }
                    ?>]
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
            }
        },
        dataLabels: {
            enabled: true
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: [
                <?php foreach ($monthWiseCount['period'] as $res) { ?> '<?php echo $res; ?>',
                <?php } ?>
            ]
        },
        yaxis: {
            min: 0,
            title: {
                text: 'Total'
            }
        },

    };

    var chart = new ApexCharts(document.querySelector("#lastTwelveMonthlyChart"), options);
    chart.render();

    var options = {
        series: [{
            name: 'Count',
            data: [<?php
                    foreach ($siteWiseMonthlyCount['period'] as $date) {
                        $callCount = (isset($siteWiseMonthlyCount['data'][$date]) && trim($siteWiseMonthlyCount['data'][$date]) != '') ? $siteWiseMonthlyCount['data'][$date] : 0;
                        echo $callCount . ",";
                    }
                    ?>]
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
            }
        },
        dataLabels: {
            enabled: true
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: [
                <?php foreach ($siteWiseMonthlyCount['period'] as $res) { ?> '<?php echo $res; ?>',
                <?php } ?>
            ]
        },
        yaxis: {
            min: 0,
            title: {
                text: 'Total'
            }
        },

    };

    var chart = new ApexCharts(document.querySelector("#sitewiseMonthlyChart"), options);
    chart.render();

    var options = {
        series: [{
            name: 'Count',
            data: [<?php
                    foreach ($testWiseMonthlyCount['period'] as $date) {
                        $callCount = (isset($testWiseMonthlyCount['data'][$date]) && trim($testWiseMonthlyCount['data'][$date]) != '') ? $testWiseMonthlyCount['data'][$date] : 0;
                        echo $callCount . ",";
                    }
                    ?>]
        }],
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
            }
        },
        dataLabels: {
            enabled: true
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        xaxis: {
            categories: [
                <?php foreach ($testWiseMonthlyCount['period'] as $res) { ?> '<?php echo $res; ?>',
                <?php } ?>
            ]
        },
        yaxis: {
            min: 0,
            title: {
                text: 'Total'
            }
        },

    };

    var chart = new ApexCharts(document.querySelector("#testwiseMonthlyChart"), options);
    chart.render();


    function getSitewiseReport() {
        $.blockUI();
        $("#mailDiv").hide();
        let searchDate = $('#searchDate').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/getSiteWiseReport') }}",
            method: 'post',
            data: {
                searchDate: searchDate,
                provinceId: $("#provinceId").val(),
                comingFrom: 'dashboard',
            },
            success: function(result) {
                $("#trendList").html(result);
                $.unblockUI();
            }
        });
    }
</script>
@endsection
