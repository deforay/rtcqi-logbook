<!--
    Author             : Prasath M
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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

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
                    var map = L.map('map').setView([lat, log], 4);
                    mapLink =
                        '<a href="http://openstreetmap.org">OpenStreetMap</a>';
                    L.tileLayer(
                        'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; ' + mapLink + ' Contributors',
                            maxZoom: 17,
                        }).addTo(map);

                    let coordinates = [];

                    //   // populate coordinates array with all the markers
                    for (let i = 0; i < result.length; i++) {
                        coordinates.push([(result[i].site_latitude), (result[i].site_longitude), (result[i].site_name)]);
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