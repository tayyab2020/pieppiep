@extends('layouts.admin')

@section('content')
    <div class="right-side">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- Starting of Dashboard area -->
                    <div class="section-padding add-product-1">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="add-product-box">
                                    <div class="add-product-header">
                                        <h2>View / Edit Quote Request</h2>
                                        <a href="{{route('quotation-requests')}}" class="btn add-back-btn"><i
                                                class="fa fa-arrow-left"></i> Back</a>
                                    </div>
                                    <hr>
                                    <form class="form-horizontal" action="{{route('user.quote')}}" method="POST"
                                          enctype="multipart/form-data">

                                        @include('includes.form-error')
                                        @include('includes.form-success')

                                        {{csrf_field()}}

                                        <input type="hidden" name="quote_id" value="{{$request->id}}">

                                        <?php $quote_number = $request->quote_number; ?>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">Quote
                                                Number </label>
                                            <div class="col-sm-6">
                                                <input class="form-control" value="{{$quote_number}}"
                                                       name="quote_number" id="quote_number" readonly type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">Number of
                                                Quotations </label>
                                            <div class="col-sm-6">
                                                <input class="form-control" value="{{$request->quotations_count}}"
                                                       type="number" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">Email* </label>
                                            <div class="col-sm-6">
                                                <input class="form-control" value="{{$request->quote_email}}"
                                                       name="quote_email" id="quote_email" placeholder="Enter Email"
                                                       required="" type="email" readonly>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">Name* </label>
                                            <div class="col-sm-6">
                                                <input class="form-control" value="{{$request->quote_name}}"
                                                       name="quote_name" id="quote_name" placeholder="Enter Name"
                                                       required="" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">Family
                                                Name* </label>
                                            <div class="col-sm-6">
                                                <input class="form-control" value="{{$request->quote_familyname}}"
                                                       name="quote_familyname" id="quote_familyname"
                                                       placeholder="Enter Family Name" required="" type="text">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="control-label col-sm-4"
                                                   for="blood_group_slug">Contact* </label>
                                            <div class="col-sm-6">
                                                <input class="form-control" value="{{$request->quote_contact}}"
                                                       name="quote_contact" id="quote_contact"
                                                       placeholder="Enter Contact Number" required="" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4"
                                                   for="blood_group_slug">Quantity* </label>
                                            <div class="col-sm-6">
                                                <input class="form-control" value="{{$request->quote_qty}}"
                                                       name="quote_qty" id="quote_qty"
                                                       required="" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4"
                                                   for="blood_group_slug">{{$request->quote_service == 0 ? 'Installation Date' : 'Delivery Date'}}* </label>
                                            <div class="col-sm-6">
                                                <input class="form-control" value="{{$request->quote_delivery ? date('d-m-Y',strtotime($request->quote_delivery)) : null}}"
                                                       name="quote_delivery" id="quote_delivery"
                                                       required="" type="text">
                                            </div>
                                        </div>

                                        @if($request->quote_service != 0 && $request->quote_brand != 0 && $request->quote_model != 0)

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_display_name">Category* </label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" name="quote_service" id="quote_service"
                                                            required="">
                                                        @foreach($categories as $key)

                                                            <option @if($request->quote_service == $key->id) selected
                                                                    @endif value="{{$key->id}}">{{$key->cat_name}}</option>

                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4"
                                                       for="blood_group_display_name">Brand* </label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" name="quote_service" id="quote_service"
                                                            required="">
                                                        @foreach($brands as $key)

                                                            <option @if($request->quote_brand == $key->id) selected
                                                                    @endif value="{{$key->id}}">{{$key->cat_name}}</option>

                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4"
                                                       for="blood_group_display_name">Model* </label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" name="quote_service" id="quote_service"
                                                            required="">
                                                        @foreach($models as $key)

                                                            <option @if($request->quote_model == $key->id) selected
                                                                    @endif value="{{$key->id}}">{{$key->cat_name}}</option>

                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">Model Number </label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" value="{{$request->quote_model_number}}"
                                                           name="quote_model_number" id="quote_model_number"
                                                           placeholder="Enter Model Number" required="" type="text">
                                                </div>
                                            </div>

                                        @else

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_display_name">Service* </label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" name="quote_service1" id="quote_service1"
                                                            required="">
                                                        @foreach($services as $key)

                                                            <option @if($request->quote_service1 == $key->id) selected
                                                                    @endif value="{{$key->id}}">{{$key->title}}</option>

                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                        @endif


                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">Zip
                                                Code* </label>
                                            <div class="col-sm-6">
                                                <input class="form-control" value="{{$request->quote_zipcode}}"
                                                       name="quote_zipcode" id="quote_zipcode"
                                                       placeholder="Enter Zip Code" required="" type="text">
                                            </div>
                                        </div>

                                        {{--<div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">Street Number* </label>
                                            <div class="col-sm-6">
                                                <input class="form-control" value="{{$request->quote_street}}"
                                                       name="quote_street" id="quote_street"
                                                       placeholder="Enter Street Number" required="" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">House Number* </label>
                                            <div class="col-sm-6">
                                                <input class="form-control" value="{{$request->quote_house}}"
                                                       name="quote_house" id="quote_house"
                                                       placeholder="Enter House Number" required="" type="text">
                                            </div>
                                        </div>--}}

                                        @foreach($q_a as $key)

                                            <div class="form-group">
                                                <label class="control-label col-sm-4"
                                                       for="blood_group_slug">{{$key->question}}* </label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" value="{{$key->answer}}" required=""
                                                           type="text">
                                                </div>
                                            </div>

                                        @endforeach


                                        <div class="form-group">
                                            <label class="control-label col-sm-4"
                                                   for="service_description">Description*</label>
                                            <div class="col-sm-6">
                                                <textarea class="form-control" name="quote_description"
                                                          id="quote_description" rows="5" style="resize: vertical;"
                                                          placeholder="Enter Description of Job">{{$request->quote_description}}</textarea>
                                            </div>
                                        </div>


                                        <hr>
                                        {{--<div class="add-product-footer">
                                            <button type="submit" style="outline: none;" class="btn add-product_btn">EDIT</button>
                                        </div>--}}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Ending of Dashboard area -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script type="text/javascript" src="{{asset('assets/admin/js/nicEdit.js')}}"></script>
    <script type="text/javascript">
        //<![CDATA[
        bkLib.onDomLoaded(function () {
            nicEditors.allTextAreas()
        });
        //]]>
    </script>

    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdCPSjhOgaYXo6twWkseoaSHc2Ipob024&libraries=places&callback=initMap"
        async defer></script>

    <script type="text/javascript">

        function initMap() {

            var input = document.getElementById('quote_zipcode');

            var options = {
                componentRestrictions: {country: "nl"}
            };

            var autocomplete = new google.maps.places.Autocomplete(input, options);


            // Set the data fields to return when the user selects a place.
            autocomplete.setFields(
                ['address_components', 'geometry', 'icon', 'name']);


            autocomplete.addListener('place_changed', function () {

                var place = autocomplete.getPlace();


                if (!place.geometry) {

                    // User entered the name of a Place that was not suggested and
                    // pressed the Enter key, or the Place Details request failed.
                    window.alert("No details available for input: '" + place.name + "'");
                    return;
                }

                var city = '';

                for (var i = 0; i < place.address_components.length; i++) {

                    if (place.address_components[i].types[0] == 'locality') {
                        city = place.address_components[i].long_name;
                    }

                }


                if (city == '') {
                    for (var i = 0; i < place.address_components.length; i++) {
                        if (place.address_components[i].types[0] == 'administrative_area_level_2') {
                            var city = place.address_components[i].long_name;
                        }
                    }
                }

            });
        }

    </script>

    <style type="text/css">

        .swal2-show {
            padding: 40px;
            width: 30%;

        }

        .swal2-header {
            font-size: 23px;
        }

        .swal2-content {
            font-size: 18px;
        }

        .swal2-actions {
            font-size: 16px;
        }

    </style>


    <script src="{{asset('assets/admin/js/jquery152.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/jqueryui.min.js')}}"></script>

@endsection
