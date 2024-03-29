<!--

    Date               : 27 May 2021
    Description        : Dashboard screen
    Last Modified Date : 27 May 2021
    Last Modified Name : Sakthivel P
-->

<?php

use App\Service\GlobalConfigService;

$GlobalConfigService = new GlobalConfigService();
$GlobalConfigService = new GlobalConfigService();
$latitude = $GlobalConfigService->getGlobalConfigLatitude('latitude');
$longitude = $GlobalConfigService->getGlobalConfigLongitude('longitude');
$enddate = date('d-M-Y');
$startdate = date('d-M-Y', strtotime('-29 days'));
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
</style>
@extends('layouts.main')
@section('content')

<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7/leaflet.css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.awesome-markers/2.0.2/leaflet.awesome-markers.css">

    <!--this is new-->

    <script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
    <script src='https://api.tiles.mapbox.com/mapbox.js/v1.6.4/mapbox.js'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Leaflet.awesome-markers/2.0.2/leaflet.awesome-markers.js"></script>

    <style type="text/css">
        #map {
            width: 1300px;
            height: 400px;
        }

        /* This is new */

        button {
            width: 100px;
        }
    </style>
</head>

<body>
    <!-- This is new -->
    <div class="btn-group">
        <div class="row">
            <div class="col-xl-6 col-lg-12">
                <fieldset>
                    <h5>Date
                    </h5>
                    <div class="form-group">
                        <input type="text" id="searchDate" name="searchDate" class="form-control" placeholder="Select Date Range" value="{{$startdate}} to {{$enddate}}" />
                    </div>
                </fieldset>
            </div>


            <div class="col-xl-6 col-lg-12">
                <fieldset>
                    <h5>Province Name
                    </h5>
                    <div class="form-group">
                        <select class="form-control" autocomplete="off" style="width:100%;" id="provinceId" name="provinceId" title="Please select Province Name">
                            <option value="">Select Province</option>
                            @foreach($province as $row)
                            <option value="{{$row->provincesss_id}}">{{$row->province_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </fieldset>
            </div>

            <div class="col-md-10">
                <div class="form-group row">

                    <div class="col-md-8">
                        <button type="submit" onclick="getDashboardData();return false;" class="btn btn-info"> Search</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="weathermap">
        <div id="map"></div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#searchDate').daterangepicker({
                    format: 'DD-MMM-YYYY',
                    autoUpdateInput: false,
                    separator: ' to ',
                    startDate: moment().subtract('days', 29),
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
        });

        function getDashboardData() {
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
                success: function(result) {
                    var lat = '{{$latitude}}';
                    var log = '{{$longitude}}';
                    document.getElementById('weathermap').innerHTML = "<div id='map' style='width: 100%; height: 100%;'></div>";
                    var myIcon = L.icon({
                        iconUrl: "{{ asset('assets/images/dark-green.png')}}"
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
                    }).setView([lat, log], 4);
                    new L.Control.Zoom({
                        position: 'bottomleft'
                    }).addTo(map);
                    map._onResize();

                    L.tileLayer('http://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png', {
                        attribution: '<a href="http://www.mapbox.com/about/maps/" target="_blank">Terms &amp; Feedback</a>',
                        maxZoom: 17,
                    }).addTo(map);

                    let coordinates = [];

                    //   // populate coordinates array with all the markers
                    for (let i = 0; i < result.length; i++) {
                        coordinates.push([(result[i].latitude), (result[i].longitude), (result[i].site_name)]);
                    };

                    //   // visualize the markers on the map
                    for (let i = 0; i < coordinates.length; i++) {
                        L.marker(coordinates[i], {
                                icon: myIcon
                            }).bindPopup(coordinates[i][2])
                            .addTo(map);
                    };
                }
            });
        }
    </script>

</body>

</html>

@endsection
