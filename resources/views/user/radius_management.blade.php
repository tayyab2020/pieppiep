@extends('layouts.handyman')

@section('styles')

    <link href="{{asset('assets/admin/css/jquery.tagit.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/admin/css/jquery-ui.css')}}" rel="stylesheet" type="text/css">

    <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>



@endsection

@section('content')


    <div class="right-side">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- Starting of Dashboard header items area -->
                    <div class="panel panel-default admin">
                        <div class="panel-heading admin-title">{{$lang->rm}}</div>

                    </div>
                    <!-- Ending of Dashboard header items area -->

                    <!-- Starting of Dashboard Top reference + Most Used OS area -->
                    <div class="reference-OS-area">
                        <div class="donors-profile-top-bg overlay text-center wow fadeInUp"
                             style="background-image: url({{asset('assets/images/'.$gs->h_dashbg)}}); visibility: visible; animation-name: fadeInUp;z-index: auto;color: black;">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2>{{$user->name}} {{$user->family_name}}</h2>
                                        <p>{{$lang->bg}} <?php $count = count($services); $i = 1; ?>
                                            @foreach($services as $key)

                                                @if($i == $count)

                                                    {{$key->cat_name}}

                                                @else

                                                    {{$key->cat_name}},

                                                @endif

                                                <?php $i++; ?>

                                            @endforeach</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form class="form-horizontal" id="form" action="{{route('user-radius-update',$user->id)}}"
                              method="POST" enctype="multipart/form-data">
                            @include('includes.form-success')
                            @include('includes.form-error')
                            {{csrf_field()}}

                            <div class="profile-fillup-wrap wow fadeInUp"
                                 style="visibility: visible; animation-name: fadeInUp;">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">

                                            <div class="profile-filup-description-box margin-bottom-30">

                                                <div class="form-group">

                                                    <table class="table table-striped ">
                                                        <thead>
                                                        <tr>

                                                            <th width="250">{{$lang->pct}}</th>
                                                            <th>{{$lang->rt}}</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="tbody">

                                                        <tr data-id="1">

                                                            <td>

                                                                @if($terminal != '')


                                                                    <input data-id="1"
                                                                           class="required zipInput form-control"
                                                                           name="zipcode" type="text" size="7"
                                                                           maxlength="7" value="{{$terminal->zipcode}}"
                                                                           style="width:135px;font-size:18px;float: left;"
                                                                           required/>


                                                                @else

                                                                    <input data-id="1"
                                                                           class="required zipInput form-control"
                                                                           name="zipcode" type="text" size="7"
                                                                           maxlength="7" value=""
                                                                           style="width:135px;font-size:18px;float: left;"
                                                                           required/>


                                                                @endif

                                                                <button type="button" id="search"><i
                                                                        class="fa fa-search"></i></button>

                                                            </td>


                                                            <td>
                                                                <select data-id="1" name="radius" id="radius"
                                                                        class="required radiusInput form-control"
                                                                        style="width: 200px;font-size:18px;">

                                                                @if($terminal != '')


                                                                        @if($terminal->radius == 5)

                                                                            <option value="5" selected>0 - 5 km</option>
                                                                            <option value="10">0 - 10 km</option>
                                                                            <option value="20">0 - 20 km</option>
                                                                            <option value="30">0 - 30 km</option>
                                                                            <option value="40">0 - 40 km</option>
                                                                            <option value="50">0 - 50 km</option>
                                                                            <option value="100">0 - 100 km</option>
                                                                            <option value="150">0 - 150 km</option>
                                                                            <option value="200">0 - 200 km</option>
                                                                            <option value="250">0 - 250 km</option>

                                                                        @elseif($terminal->radius == 10)


                                                                            <option value="5">0 - 5 km</option>
                                                                            <option value="10" selected>0 - 10 km</option>
                                                                            <option value="20">0 - 20 km</option>
                                                                            <option value="30">0 - 30 km</option>
                                                                            <option value="40">0 - 40 km</option>
                                                                            <option value="50">0 - 50 km</option>
                                                                            <option value="100">0 - 100 km</option>
                                                                            <option value="150">0 - 150 km</option>
                                                                            <option value="200">0 - 200 km</option>
                                                                            <option value="250">0 - 250 km</option>

                                                                        @elseif($terminal->radius == 20)


                                                                            <option value="5">0 - 5 km</option>
                                                                            <option value="10">0 - 10 km</option>
                                                                            <option value="20" selected>0 - 20 km</option>
                                                                            <option value="30">0 - 30 km</option>
                                                                            <option value="40">0 - 40 km</option>
                                                                            <option value="50">0 - 50 km</option>
                                                                            <option value="100">0 - 100 km</option>
                                                                            <option value="150">0 - 150 km</option>
                                                                            <option value="200">0 - 200 km</option>
                                                                            <option value="250">0 - 250 km</option>

                                                                        @elseif($terminal->radius == 30)


                                                                            <option value="5">0 - 5 km</option>
                                                                            <option value="10">0 - 10 km</option>
                                                                            <option value="20">0 - 20 km</option>
                                                                            <option value="30" selected>0 - 30 km</option>
                                                                            <option value="40">0 - 40 km</option>
                                                                            <option value="50">0 - 50 km</option>
                                                                            <option value="100">0 - 100 km</option>
                                                                            <option value="150">0 - 150 km</option>
                                                                            <option value="200">0 - 200 km</option>
                                                                            <option value="250">0 - 250 km</option>

                                                                        @elseif($terminal->radius == 40)


                                                                            <option value="5">0 - 5 km</option>
                                                                            <option value="10">0 - 10 km</option>
                                                                            <option value="20">0 - 20 km</option>
                                                                            <option value="30">0 - 30 km</option>
                                                                            <option value="40" selected>0 - 40 km</option>
                                                                            <option value="50">0 - 50 km</option>
                                                                            <option value="100">0 - 100 km</option>
                                                                            <option value="150">0 - 150 km</option>
                                                                            <option value="200">0 - 200 km</option>
                                                                            <option value="250">0 - 250 km</option>


                                                                        @elseif($terminal->radius == 50)


                                                                            <option value="5">0 - 5 km</option>
                                                                            <option value="10">0 - 10 km</option>
                                                                            <option value="20">0 - 20 km</option>
                                                                            <option value="30">0 - 30 km</option>
                                                                            <option value="40">0 - 40 km</option>
                                                                            <option value="50" selected>0 - 50 km</option>
                                                                            <option value="100">0 - 100 km</option>
                                                                            <option value="150">0 - 150 km</option>
                                                                            <option value="200">0 - 200 km</option>
                                                                            <option value="250">0 - 250 km</option>


                                                                        @elseif($terminal->radius == 100)


                                                                            <option value="5">0 - 5 km</option>
                                                                            <option value="10">0 - 10 km</option>
                                                                            <option value="20">0 - 20 km</option>
                                                                            <option value="30">0 - 30 km</option>
                                                                            <option value="40">0 - 40 km</option>
                                                                            <option value="50">0 - 50 km</option>
                                                                            <option value="100" selected>0 - 100 km</option>
                                                                            <option value="150">0 - 150 km</option>
                                                                            <option value="200">0 - 200 km</option>
                                                                            <option value="250">0 - 250 km</option>


                                                                        @elseif($terminal->radius == 150)


                                                                            <option value="5">0 - 5 km</option>
                                                                            <option value="10">0 - 10 km</option>
                                                                            <option value="20">0 - 20 km</option>
                                                                            <option value="30">0 - 30 km</option>
                                                                            <option value="40">0 - 40 km</option>
                                                                            <option value="50">0 - 50 km</option>
                                                                            <option value="100">0 - 100 km</option>
                                                                            <option value="150" selected>0 - 150 km</option>
                                                                            <option value="200">0 - 200 km</option>
                                                                            <option value="250">0 - 250 km</option>


                                                                        @elseif($terminal->radius == 200)


                                                                            <option value="5">0 - 5 km</option>
                                                                            <option value="10">0 - 10 km</option>
                                                                            <option value="20">0 - 20 km</option>
                                                                            <option value="30">0 - 30 km</option>
                                                                            <option value="40">0 - 40 km</option>
                                                                            <option value="50">0 - 50 km</option>
                                                                            <option value="100">0 - 100 km</option>
                                                                            <option value="150">0 - 150 km</option>
                                                                            <option value="200" selected>0 - 200 km</option>
                                                                            <option value="250">0 - 250 km</option>


                                                                        @elseif($terminal->radius == 250)


                                                                            <option value="5">0 - 5 km</option>
                                                                            <option value="10">0 - 10 km</option>
                                                                            <option value="20">0 - 20 km</option>
                                                                            <option value="30">0 - 30 km</option>
                                                                            <option value="40">0 - 40 km</option>
                                                                            <option value="50">0 - 50 km</option>
                                                                            <option value="100">0 - 100 km</option>
                                                                            <option value="150">0 - 150 km</option>
                                                                            <option value="200">0 - 200 km</option>
                                                                            <option value="250" selected>0 - 250 km</option>

                                                                        @endif

                                                                    @else

                                                                        <option value="5">0 - 5 km</option>
                                                                        <option value="10">0 - 10 km</option>
                                                                        <option value="20">0 - 20 km</option>
                                                                        <option value="30">0 - 30 km</option>
                                                                        <option value="40">0 - 40 km</option>
                                                                        <option value="50">0 - 50 km</option>
                                                                        <option value="100">0 - 100 km</option>
                                                                        <option value="150">0 - 150 km</option>
                                                                        <option value="200">0 - 200 km</option>
                                                                        <option value="250">0 - 250 km</option>

                                                                    @endif

                                                                </select>


                                                            </td>

                                                        </tr>

                                                        </tbody>

                                                    </table>

                                                    <hr/>

                                                    <style>

                                                        .container {
                                                            width: 80% !important;
                                                        }

                                                        #map {
                                                            height: 100%;
                                                        }


                                                        .error {
                                                            border: 1px solid red;
                                                        }


                                                        #search {
                                                            float: left;
                                                            width: 30%;
                                                            padding: 6.8px;
                                                            background: #2196F3;
                                                            color: white;
                                                            font-size: 17px;
                                                            border: 1px solid grey;
                                                            border-left: none;
                                                            cursor: pointer;
                                                        }

                                                        #search:hover {
                                                            background: #0b7dda;
                                                        }

                                                    </style>
                                                    <div id="map" style="height: 500px; width: 100%;"></div>

                                                    @if($terminal != '')


                                                        <input type="hidden" name="postal_code" id="postal_code"
                                                               value="{{$terminal->zipcode}}" required>
                                                        <input type="hidden" name="longitude" id="longitude"
                                                               value="{{$terminal->longitude}}" required>
                                                        <input type="hidden" name="latitude" id="latitude"
                                                               value="{{$terminal->latitude}}" required>
                                                        <input type="hidden" name="terminal_city" id="terminal_city"
                                                               value="{{$terminal->city}}" required>
                                                        <input type="hidden" class="edit" value="1">




                                                    @else

                                                        <input type="hidden" name="postal_code" id="postal_code"
                                                               value="" required>
                                                        <input type="hidden" name="longitude" id="longitude" value=""
                                                               required>
                                                        <input type="hidden" name="latitude" id="latitude" value=""
                                                               required>
                                                        <input type="hidden" name="terminal_city" id="terminal_city"
                                                               value="" required>
                                                        <input type="hidden" class="edit" value="0">

                                                    @endif


                                                    <script>

                                                        $(document).ready(function () {

                                                            $("#form").submit(function (e) {

                                                                e.preventDefault(e);

                                                                var longitude = $('#longitude').val();
                                                                var latitude = $('#latitude').val();


                                                                if (longitude == "" || latitude == "") {
                                                                    Swal.fire({
                                                                        icon: 'error',
                                                                        title: '<?php echo $lang->sww; ?>',
                                                                        text: '<?php echo $lang->pcet; ?>',
                                                                    });
                                                                } else {
                                                                    $('#form').off('submit');
                                                                    $(this).submit();
                                                                }

                                                            });

                                                        });

                                                        if ($('#longitude').val() == "" || $('#latitude').val() == "") {

                                                            var latitude = 52.014689;
                                                            var longitude = 5.584757;
                                                            var terminal_city = "Veenendaal";

                                                        } else {
                                                            var longitude = parseFloat($('#longitude').val());
                                                            var latitude = parseFloat($('#latitude').val());
                                                            var terminal_city = $('#terminal_city').val();

                                                        }

                                                        var radius = $('#radius').val();

                                                        var regionData = {

                                                            1: {
                                                                latitude: latitude,
                                                                longitude: longitude,
                                                                radius: radius,
                                                                terminal_city: terminal_city
                                                            },

                                                        };


                                                        function removeNode(id) {

                                                            $('tr[data-id="' + id + '"]').addClass('hidden');
                                                            $('.zipInput[data-id="' + id + '"]').val('-1');
                                                            $('.zipInput[data-id="' + id + '"]').trigger('keypress');

                                                            delete regionData[id];
                                                            handleCircles(true);
                                                            bindListeners();
                                                        }

                                                        function handleCopy() {
                                                            var maxId = Object.keys(regionData).length;
                                                            maxId += 1;
                                                            var tpl = '<tr data-id="' + maxId + '">' + $('#template').html() + '</tr>';
                                                            var tpl = tpl.replace("[id]", maxId);
                                                            var tpl = tpl.replace("[id]", maxId);
                                                            var tpl = tpl.replace("[id]", maxId);
                                                            var tpl = tpl.replace("[id]", maxId);
                                                            $('#tbody').append(tpl);
                                                            bindListeners();
                                                        }

                                                        function bindListeners() {

                                                            $('.radiusInput').on('input', function (e) {
                                                                var id = $(this).data('id');
                                                                regionData[id].radius = parseInt($(this).val());
                                                                handleCircles(true);
                                                            });

                                                            $('#search').click(function (e) {
                                                                var obj = $('.zipInput');
                                                                var id = $('.zipInput').data('id');
                                                                var zipCode = $('.zipInput').val();


                                                                if (zipCode) {

                                                                    if (zipCode.length >= 6) {
                                                                        $.ajax({
                                                                            type: 'GET',
                                                                            url: 'https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyBNRJukOohRJ1tW0tMG4tzpDXFz68OnonM&address=' + zipCode + ',+Netherlands&sensor=false',
                                                                            success: function (data) {

                                                                                if (data.status == 'OK') {

                                                                                    $(obj).removeClass('error');

                                                                                    if (regionData[id] == undefined) {
                                                                                        regionData[id] = {
                                                                                            latitude: null,
                                                                                            longitude: null,
                                                                                            radius: 30
                                                                                        };
                                                                                    }

                                                                                    regionData[id].latitude = parseFloat(data.results[0].geometry.location.lat);
                                                                                    regionData[id].longitude = parseFloat(data.results[0].geometry.location.lng);

                                                                                    for (var i = 0; i < data.results[0].address_components.length; i++) {

                                                                                        if (data.results[0].address_components[i].types[0] == 'locality') {

                                                                                            regionData[id].terminal_city = data.results[0].address_components[i].long_name;

                                                                                        }


                                                                                    }

                                                                                    handleCircles(true);

                                                                                    clearMarkers();

                                                                                    marker = new google.maps.Marker({
                                                                                        position: new google.maps.LatLng(regionData[id].latitude, regionData[id].longitude),
                                                                                        map: map,
                                                                                    });

                                                                                    for (var region in regionData) {
                                                                                        regionData[region].marker = marker;
                                                                                    }


                                                                                    map.panTo(new google.maps.LatLng(regionData[id].latitude, regionData[id].longitude));


                                                                                    $("#latitude").val(regionData[id].latitude);
                                                                                    $("#longitude").val(regionData[id].longitude);
                                                                                    $("#terminal_city").val(regionData[id].terminal_city);
                                                                                    $("#postal_code").val(zipCode);

                                                                                } else {

                                                                                    $(obj).addClass('error');
                                                                                    $("#latitude").val("");
                                                                                    $("#longitude").val("");
                                                                                    $("#terminal_city").val("");
                                                                                    $("#postal_code").val("");

                                                                                    clearCircles();
                                                                                    clearMarkers();

                                                                                }
                                                                            }
                                                                        });
                                                                    } else {

                                                                        $(obj).addClass('error');
                                                                        $("#latitude").val("");
                                                                        $("#longitude").val("");
                                                                        $("#terminal_city").val("");
                                                                        $("#postal_code").val("");

                                                                        clearCircles();
                                                                        clearMarkers();

                                                                    }
                                                                } else {

                                                                    if (zipCode.length == 0) {
                                                                        regionData[id].circle.setMap(null);
                                                                        regionData[id].marker.setMap(null);
                                                                        delete regionData[id];
                                                                        handleCircles(true);
                                                                    }
                                                                }
                                                            });
                                                        }


                                                        $(document).ready(function () {
                                                            bindListeners();
                                                        });


                                                        var map = null;

                                                        function clearCircles() {
                                                            for (var i in regionData) {
                                                                if (regionData[i].circle !== undefined) {
                                                                    regionData[i].circle.setMap(null);
                                                                    map.panTo(new google.maps.LatLng(regionData[i].latitude, regionData[i].longitude));
                                                                }

                                                            }
                                                        }

                                                        function clearMarkers() {

                                                            for (var i in regionData) {

                                                                if (regionData[i].marker !== undefined) {
                                                                    regionData[i].marker.setMap(null);
                                                                }

                                                            }

                                                        }

                                                        function initMap() {

                                                            map = new google.maps.Map(document.getElementById('map'), {
                                                                zoom: 7,
                                                                maxZoom: 19,

                                                                center: {
                                                                    lat: regionData[1].latitude,
                                                                    lng: regionData[1].longitude
                                                                },
                                                                mapTypeId: 'roadmap'
                                                            });

                                                            marker = new google.maps.Marker({
                                                                position: new google.maps.LatLng(regionData[1].latitude, regionData[1].longitude),
                                                                map: map,
                                                            });

                                                            for (var region in regionData) {
                                                                regionData[region].marker = marker;
                                                            }

                                                            if ($(".edit").val() != 0) {
                                                                handleCircles();
                                                            }


//Add listener
// google.maps.event.addListener(map, "click", function (event) {
//     var latitude = event.latLng.lat();
//     var longitude = event.latLng.lng();

//     regionData[1].latitude = parseFloat(latitude);
//     regionData[1].longitude = parseFloat(longitude);
//     handleCircles(true);

//     radius = new google.maps.Marker({
//                 position: new google.maps.LatLng(latitude, longitude),
//                 map: map,
//             });

//     // Center of map
//     map.panTo(new google.maps.LatLng(latitude,longitude));


//     $.ajax({
//                                             type: 'GET',
//                                             url: 'https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyBNRJukOohRJ1tW0tMG4tzpDXFz68OnonM&latlng='+latitude+','+longitude+'&countryCode=Pk',
//                                             success: function (data) {
//                                                 console.log(data);

//                                             }
//                                         });

// }); //end addListener


                                                        }


                                                        function handleCircles(clear) {
                                                            if (clear == true) {
                                                                clearCircles();
                                                            }
                                                            //console.log(regionData);
                                                            var myBounds = new google.maps.LatLngBounds();
                                                            for (var region in regionData) {
                                                                regionData[region].center = {
                                                                    lat: regionData[region].latitude,
                                                                    lng: regionData[region].longitude
                                                                };
                                                                var boundData = regionData[region].center;
                                                                var regionCircle = new google.maps.Circle({
                                                                    strokeColor: '#FF0000',
                                                                    strokeOpacity: 0.8,
                                                                    strokeWeight: 1,
                                                                    fillColor: '#FF0000',
                                                                    fillOpacity: 0.25,
                                                                    map: map,
                                                                    center: regionData[region].center,
                                                                    radius: regionData[region].radius * 1000
                                                                });
                                                                regionData[region].circle = regionCircle;
                                                                myBounds.extend(boundData);
                                                            }

                                                            if (regionData) {

                                                                var zoom = 11;
                                                                map.setZoom(zoom);
                                                            }
                                                        }

                                                    </script>

                                                    <script async defer
                                                            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNRJukOohRJ1tW0tMG4tzpDXFz68OnonM&callback=initMap"></script>

                                                </div>

                                            </div>


                                            <div class="submit-area margin-bottom-30">
                                                <div class="row">
                                                    <div class="col-md-8 col-md-offset-2">
                                                        <div class="form-group text-center">
                                                            <button class="boxed-btn blog"
                                                                    type="submit">{{$lang->doupl}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <style type="text/css">
        /*!
* Datepicker for Bootstrap v1.5.0 (https://github.com/eternicode/bootstrap-datepicker)
*
* Copyright 2012 Stefan Petre
* Improvements by Andrew Rowls
* Licensed under the Apache License v2.0 (http://www.apache.org/licenses/LICENSE-2.0)
*/
        .datepicker {
            padding: 4px;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            direction: ltr;
        }

        .datepicker-inline {
            width: 220px;
        }

        .datepicker.datepicker-rtl {
            direction: rtl;
        }

        .datepicker.datepicker-rtl table tr td span {
            float: right;
        }

        .datepicker-dropdown {
            top: 0;
            left: 0;
            min-width: 60% !important;
        }

        .table-condensed {

            width: 100%;


        }

        .datepicker td, .datepicker th {

            font-size: 17px;


        }

        .datepicker-dropdown:before {
            content: '';
            display: inline-block;
            border-left: 7px solid transparent;
            border-right: 7px solid transparent;
            border-bottom: 7px solid #999999;
            border-top: 0;
            border-bottom-color: rgba(0, 0, 0, 0.2);
            position: absolute;
        }

        .datepicker-dropdown:after {
            content: '';
            display: inline-block;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-bottom: 6px solid #ffffff;
            border-top: 0;
            position: absolute;
        }

        .datepicker-dropdown.datepicker-orient-left:before {
            left: 6px;
        }

        .datepicker-dropdown.datepicker-orient-left:after {
            left: 7px;
        }

        .datepicker-dropdown.datepicker-orient-right:before {
            right: 6px;
        }

        .datepicker-dropdown.datepicker-orient-right:after {
            right: 7px;
        }

        .datepicker-dropdown.datepicker-orient-bottom:before {
            top: -7px;
        }

        .datepicker-dropdown.datepicker-orient-bottom:after {
            top: -6px;
        }

        .datepicker-dropdown.datepicker-orient-top:before {
            bottom: -7px;
            border-bottom: 0;
            border-top: 7px solid #999999;
        }

        .datepicker-dropdown.datepicker-orient-top:after {
            bottom: -6px;
            border-bottom: 0;
            border-top: 6px solid #ffffff;
        }

        .datepicker > div {
            display: none;
        }

        .datepicker table {
            margin: 0;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .datepicker td,
        .datepicker th {
            text-align: center;
            width: 20px;
            height: 20px;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            border: none;
        }

        .table-striped .datepicker table tr td,
        .table-striped .datepicker table tr th {
            background-color: transparent;
        }

        .datepicker table tr td.day:hover,
        .datepicker table tr td.day.focused {
            background: #eeeeee;
            cursor: pointer;
        }

        .datepicker table tr td.old,
        .datepicker table tr td.new {
            color: #999999;
        }

        .datepicker table tr td.disabled,
        .datepicker table tr td.disabled:hover {
            background: none;
            color: #999999;
            cursor: default;
        }

        .datepicker table tr td.highlighted {
            background: #d9edf7;
            border-radius: 0;
        }

        .datepicker table tr td.today,
        .datepicker table tr td.today:hover,
        .datepicker table tr td.today.disabled,
        .datepicker table tr td.today.disabled:hover {
            background-color: #fde19a;
            background-image: -moz-linear-gradient(to bottom, #fdd49a, #fdf59a);
            background-image: -ms-linear-gradient(to bottom, #fdd49a, #fdf59a);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#fdd49a), to(#fdf59a));
            background-image: -webkit-linear-gradient(to bottom, #fdd49a, #fdf59a);
            background-image: -o-linear-gradient(to bottom, #fdd49a, #fdf59a);
            background-image: linear-gradient(to bottom, #fdd49a, #fdf59a);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fdd49a', endColorstr='#fdf59a', GradientType=0);
            border-color: #fdf59a #fdf59a #fbed50;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            color: #000;
        }

        .datepicker table tr td.today:hover,
        .datepicker table tr td.today:hover:hover,
        .datepicker table tr td.today.disabled:hover,
        .datepicker table tr td.today.disabled:hover:hover,
        .datepicker table tr td.today:active,
        .datepicker table tr td.today:hover:active,
        .datepicker table tr td.today.disabled:active,
        .datepicker table tr td.today.disabled:hover:active,
        .datepicker table tr td.today.active,
        .datepicker table tr td.today:hover.active,
        .datepicker table tr td.today.disabled.active,
        .datepicker table tr td.today.disabled:hover.active,
        .datepicker table tr td.today.disabled,
        .datepicker table tr td.today:hover.disabled,
        .datepicker table tr td.today.disabled.disabled,
        .datepicker table tr td.today.disabled:hover.disabled,
        .datepicker table tr td.today[disabled],
        .datepicker table tr td.today:hover[disabled],
        .datepicker table tr td.today.disabled[disabled],
        .datepicker table tr td.today.disabled:hover[disabled] {
            background-color: #fdf59a;
        }

        .datepicker table tr td.today:active,
        .datepicker table tr td.today:hover:active,
        .datepicker table tr td.today.disabled:active,
        .datepicker table tr td.today.disabled:hover:active,
        .datepicker table tr td.today.active,
        .datepicker table tr td.today:hover.active,
        .datepicker table tr td.today.disabled.active,
        .datepicker table tr td.today.disabled:hover.active {
            background-color: #fbf069 \9;
        }

        .datepicker table tr td.today:hover:hover {
            color: #000;
        }

        .datepicker table tr td.today.active:hover {
            color: #fff;
        }

        .datepicker table tr td.range,
        .datepicker table tr td.range:hover,
        .datepicker table tr td.range.disabled,
        .datepicker table tr td.range.disabled:hover {
            background: #eeeeee;
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
        }

        .datepicker table tr td.range.today,
        .datepicker table tr td.range.today:hover,
        .datepicker table tr td.range.today.disabled,
        .datepicker table tr td.range.today.disabled:hover {
            background-color: #f3d17a;
            background-image: -moz-linear-gradient(to bottom, #f3c17a, #f3e97a);
            background-image: -ms-linear-gradient(to bottom, #f3c17a, #f3e97a);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#f3c17a), to(#f3e97a));
            background-image: -webkit-linear-gradient(to bottom, #f3c17a, #f3e97a);
            background-image: -o-linear-gradient(to bottom, #f3c17a, #f3e97a);
            background-image: linear-gradient(to bottom, #f3c17a, #f3e97a);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f3c17a', endColorstr='#f3e97a', GradientType=0);
            border-color: #f3e97a #f3e97a #edde34;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
        }

        .datepicker table tr td.range.today:hover,
        .datepicker table tr td.range.today:hover:hover,
        .datepicker table tr td.range.today.disabled:hover,
        .datepicker table tr td.range.today.disabled:hover:hover,
        .datepicker table tr td.range.today:active,
        .datepicker table tr td.range.today:hover:active,
        .datepicker table tr td.range.today.disabled:active,
        .datepicker table tr td.range.today.disabled:hover:active,
        .datepicker table tr td.range.today.active,
        .datepicker table tr td.range.today:hover.active,
        .datepicker table tr td.range.today.disabled.active,
        .datepicker table tr td.range.today.disabled:hover.active,
        .datepicker table tr td.range.today.disabled,
        .datepicker table tr td.range.today:hover.disabled,
        .datepicker table tr td.range.today.disabled.disabled,
        .datepicker table tr td.range.today.disabled:hover.disabled,
        .datepicker table tr td.range.today[disabled],
        .datepicker table tr td.range.today:hover[disabled],
        .datepicker table tr td.range.today.disabled[disabled],
        .datepicker table tr td.range.today.disabled:hover[disabled] {
            background-color: #f3e97a;
        }

        .datepicker table tr td.range.today:active,
        .datepicker table tr td.range.today:hover:active,
        .datepicker table tr td.range.today.disabled:active,
        .datepicker table tr td.range.today.disabled:hover:active,
        .datepicker table tr td.range.today.active,
        .datepicker table tr td.range.today:hover.active,
        .datepicker table tr td.range.today.disabled.active,
        .datepicker table tr td.range.today.disabled:hover.active {
            background-color: #efe24b \9;
        }

        .datepicker table tr td.selected,
        .datepicker table tr td.selected:hover,
        .datepicker table tr td.selected.disabled,
        .datepicker table tr td.selected.disabled:hover {
            background-color: #9e9e9e;
            background-image: -moz-linear-gradient(to bottom, #b3b3b3, #808080);
            background-image: -ms-linear-gradient(to bottom, #b3b3b3, #808080);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#b3b3b3), to(#808080));
            background-image: -webkit-linear-gradient(to bottom, #b3b3b3, #808080);
            background-image: -o-linear-gradient(to bottom, #b3b3b3, #808080);
            background-image: linear-gradient(to bottom, #b3b3b3, #808080);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#b3b3b3', endColorstr='#808080', GradientType=0);
            border-color: #808080 #808080 #595959;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            color: #fff;
            text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
        }

        .datepicker table tr td.selected:hover,
        .datepicker table tr td.selected:hover:hover,
        .datepicker table tr td.selected.disabled:hover,
        .datepicker table tr td.selected.disabled:hover:hover,
        .datepicker table tr td.selected:active,
        .datepicker table tr td.selected:hover:active,
        .datepicker table tr td.selected.disabled:active,
        .datepicker table tr td.selected.disabled:hover:active,
        .datepicker table tr td.selected.active,
        .datepicker table tr td.selected:hover.active,
        .datepicker table tr td.selected.disabled.active,
        .datepicker table tr td.selected.disabled:hover.active,
        .datepicker table tr td.selected.disabled,
        .datepicker table tr td.selected:hover.disabled,
        .datepicker table tr td.selected.disabled.disabled,
        .datepicker table tr td.selected.disabled:hover.disabled,
        .datepicker table tr td.selected[disabled],
        .datepicker table tr td.selected:hover[disabled],
        .datepicker table tr td.selected.disabled[disabled],
        .datepicker table tr td.selected.disabled:hover[disabled] {
            background-color: #808080;
        }

        .datepicker table tr td.selected:active,
        .datepicker table tr td.selected:hover:active,
        .datepicker table tr td.selected.disabled:active,
        .datepicker table tr td.selected.disabled:hover:active,
        .datepicker table tr td.selected.active,
        .datepicker table tr td.selected:hover.active,
        .datepicker table tr td.selected.disabled.active,
        .datepicker table tr td.selected.disabled:hover.active {
            background-color: #666666 \9;
        }

        .datepicker table tr td.active,
        .datepicker table tr td.active:hover,
        .datepicker table tr td.active.disabled,
        .datepicker table tr td.active.disabled:hover {
            background-color: #006dcc;
            background-image: -moz-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: -ms-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0044cc));
            background-image: -webkit-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: -o-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: linear-gradient(to bottom, #0088cc, #0044cc);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#0088cc', endColorstr='#0044cc', GradientType=0);
            border-color: #0044cc #0044cc #002a80;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            color: #fff;
            text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
        }

        .datepicker table tr td.active:hover,
        .datepicker table tr td.active:hover:hover,
        .datepicker table tr td.active.disabled:hover,
        .datepicker table tr td.active.disabled:hover:hover,
        .datepicker table tr td.active:active,
        .datepicker table tr td.active:hover:active,
        .datepicker table tr td.active.disabled:active,
        .datepicker table tr td.active.disabled:hover:active,
        .datepicker table tr td.active.active,
        .datepicker table tr td.active:hover.active,
        .datepicker table tr td.active.disabled.active,
        .datepicker table tr td.active.disabled:hover.active,
        .datepicker table tr td.active.disabled,
        .datepicker table tr td.active:hover.disabled,
        .datepicker table tr td.active.disabled.disabled,
        .datepicker table tr td.active.disabled:hover.disabled,
        .datepicker table tr td.active[disabled],
        .datepicker table tr td.active:hover[disabled],
        .datepicker table tr td.active.disabled[disabled],
        .datepicker table tr td.active.disabled:hover[disabled] {
            background-color: #0044cc;
        }

        .datepicker table tr td.active:active,
        .datepicker table tr td.active:hover:active,
        .datepicker table tr td.active.disabled:active,
        .datepicker table tr td.active.disabled:hover:active,
        .datepicker table tr td.active.active,
        .datepicker table tr td.active:hover.active,
        .datepicker table tr td.active.disabled.active,
        .datepicker table tr td.active.disabled:hover.active {
            background-color: #003399 \9;
        }

        .datepicker table tr td span {
            display: block;
            width: 23%;
            height: 54px;
            line-height: 54px;
            float: left;
            margin: 1%;
            cursor: pointer;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
        }

        .datepicker table tr td span:hover {
            background: #eeeeee;
        }

        .datepicker table tr td span.disabled,
        .datepicker table tr td span.disabled:hover {
            background: none;
            color: #999999;
            cursor: default;
        }

        .datepicker table tr td span.active,
        .datepicker table tr td span.active:hover,
        .datepicker table tr td span.active.disabled,
        .datepicker table tr td span.active.disabled:hover {
            background-color: #006dcc;
            background-image: -moz-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: -ms-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0044cc));
            background-image: -webkit-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: -o-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: linear-gradient(to bottom, #0088cc, #0044cc);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#0088cc', endColorstr='#0044cc', GradientType=0);
            border-color: #0044cc #0044cc #002a80;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            color: #fff;
            text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
        }

        .datepicker table tr td span.active:hover,
        .datepicker table tr td span.active:hover:hover,
        .datepicker table tr td span.active.disabled:hover,
        .datepicker table tr td span.active.disabled:hover:hover,
        .datepicker table tr td span.active:active,
        .datepicker table tr td span.active:hover:active,
        .datepicker table tr td span.active.disabled:active,
        .datepicker table tr td span.active.disabled:hover:active,
        .datepicker table tr td span.active.active,
        .datepicker table tr td span.active:hover.active,
        .datepicker table tr td span.active.disabled.active,
        .datepicker table tr td span.active.disabled:hover.active,
        .datepicker table tr td span.active.disabled,
        .datepicker table tr td span.active:hover.disabled,
        .datepicker table tr td span.active.disabled.disabled,
        .datepicker table tr td span.active.disabled:hover.disabled,
        .datepicker table tr td span.active[disabled],
        .datepicker table tr td span.active:hover[disabled],
        .datepicker table tr td span.active.disabled[disabled],
        .datepicker table tr td span.active.disabled:hover[disabled] {
            background-color: #0044cc;
        }

        .datepicker table tr td span.active:active,
        .datepicker table tr td span.active:hover:active,
        .datepicker table tr td span.active.disabled:active,
        .datepicker table tr td span.active.disabled:hover:active,
        .datepicker table tr td span.active.active,
        .datepicker table tr td span.active:hover.active,
        .datepicker table tr td span.active.disabled.active,
        .datepicker table tr td span.active.disabled:hover.active {
            background-color: #003399 \9;
        }

        .datepicker table tr td span.old,
        .datepicker table tr td span.new {
            color: #999999;
        }

        .datepicker .datepicker-switch {
            width: 145px;
        }

        .datepicker .datepicker-switch,
        .datepicker .prev,
        .datepicker .next,
        .datepicker tfoot tr th {
            cursor: pointer;
        }

        .datepicker .datepicker-switch:hover,
        .datepicker .prev:hover,
        .datepicker .next:hover,
        .datepicker tfoot tr th:hover {
            background: #eeeeee;
        }

        .datepicker .cw {
            font-size: 10px;
            width: 12px;
            padding: 0 2px 0 5px;
            vertical-align: middle;
        }

        .input-append.date .add-on,
        .input-prepend.date .add-on {
            cursor: pointer;
        }

        .input-append.date .add-on i,
        .input-prepend.date .add-on i {
            margin-top: 3px;
        }

        .input-daterange input {
            text-align: center;
        }

        .input-daterange input:first-child {
            -webkit-border-radius: 3px 0 0 3px;
            -moz-border-radius: 3px 0 0 3px;
            border-radius: 3px 0 0 3px;
        }

        .input-daterange input:last-child {
            -webkit-border-radius: 0 3px 3px 0;
            -moz-border-radius: 0 3px 3px 0;
            border-radius: 0 3px 3px 0;
        }

        .input-daterange .add-on {
            display: inline-block;
            width: auto;
            min-width: 16px;
            height: 18px;
            padding: 4px 5px;
            font-weight: normal;
            line-height: 18px;
            text-align: center;
            text-shadow: 0 1px 0 #ffffff;
            vertical-align: middle;
            background-color: #eeeeee;
            border: 1px solid #ccc;
            margin-left: -5px;
            margin-right: -5px;
        }


    </style>


    <style>

        .select2-container {

            height: 100%;
        }

        .select2-container--default .select2-selection--single {

            height: 100%;
            padding: 7px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {

            padding: 19px;
        }

        .select2-selection__clear {

            display: none;
        }


    </style>

    <style>

        #radius_tab {
            color: #fff;
            background: {{$gs->colors == null ? 'rgba(207, 55, 58, 0.70)':$gs->colors.'c2'}};

        }


    </style>

@endsection



@section('scripts')






    <script src="{{asset('assets/admin/js/tag-it.js')}}" type="text/javascript" charset="utf-8"></script>





    <style>

        .swal2-show {
            font-size: 17px;
        }
    </style>


@endsection
