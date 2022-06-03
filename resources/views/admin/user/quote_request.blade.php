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

                                        @if($request->quote_service != 0 && $request->quote_brand != 0 && $request->quote_type != 0 && $request->quote_color != 0)

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

                                            @if($request->quote_model != '')

                                                <div class="form-group">
                                                    <label class="control-label col-sm-4"
                                                        for="blood_group_display_name">Model </label>
                                                    <div class="col-sm-6">
                                                        <select class="form-control" name="quote_service" id="quote_service" required="">
                                                            
                                                            @foreach($models as $key)

                                                                <option @if($quote_model->model == $key->model) selected @endif value="{{$key->id}}">{{$key->model}}</option>

                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                            @endif

                                            <div class="form-group">
                                                <label class="control-label col-sm-4"
                                                       for="blood_group_display_name">Type* </label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" name="quote_type" id="quote_type"
                                                            required="">
                                                        @foreach($types as $key)

                                                            <option @if($request->quote_type == $key->id) selected
                                                                    @endif value="{{$key->id}}">{{$key->cat_name}}</option>

                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4"
                                                       for="blood_group_display_name">Color* </label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" name="quote_color" id="quote_color"
                                                            required="">
                                                        @foreach($colors as $key)

                                                            <option @if($quote_color->title == $key->title) selected
                                                                    @endif value="{{$key->id}}">{{$key->title}}</option>

                                                        @endforeach
                                                    </select>
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

                                        @if($request->measure == 'M1' || $request->measure == 'Custom Sized')

                                            <section class="attributes_table active" style="width: 80%;padding: 20px;margin: 50px auto auto auto;border: 1px solid #adadad;border-radius: 10px;">

                                                <h3 style="border-bottom: 1px solid #b9b9b9;margin-bottom: 30px;padding-bottom: 10px;text-align: center;">Dimensions</h3>

                                                <div class="header-div">
                                                    <div class="headings" style="width: 50%;">Description</div>
                                                    <div class="headings" style="width: 25%;">Width</div>
                                                    <div class="headings" style="width: 25%;">Height</div>
                                                </div>

                                                @foreach($request->dimensions as $key)

                                                    <div class="attribute-content-div">

                                                        <div class="attribute full-res" style="width: 50%;">
                                                            <div style="display: flex;align-items: center;">
                                                                <div style="width: 100%;"><textarea class="form-control attribute_description" style="width: 90%;border-radius: 7px;resize: vertical;height: 80px;outline: none;" name="attribute_description[]">{{$key->description}}</textarea></div>
                                                            </div>
                                                        </div>

                                                        <div class="attribute width-box" style="width: 25%;">

                                                            <div class="m-box">
                                                                <input value="{{str_replace('.', ',',floatval($key->width))}}" style="border: 1px solid #ccc;" id="width" class="form-control width m-input" maskedformat="9,1" autocomplete="off" name="width[]" type="text">
                                                                <input style="border: 0;outline: none;" value="cm" readonly="" type="text" name="width_unit[]" class="measure-unit">
                                                            </div>

                                                        </div>

                                                        <div class="attribute height-box" style="width: 25%;">

                                                            <div class="m-box">
                                                                <input value="{{str_replace('.', ',',floatval($key->height))}}" style="border: 1px solid #ccc;" id="height" class="form-control height m-input" maskedformat="9,1" autocomplete="off" name="height[]" type="text">
                                                                <input style="border: 0;outline: none;" value="cm" readonly="" type="text" name="height_unit[]" class="measure-unit">
                                                            </div>

                                                        </div>

                                                    </div>

                                                @endforeach

                                            </section>

                                        @endif

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
        bkLib.onDomLoaded(function() {
            nicEditors.editors.push(
                new nicEditor().panelInstance(
                    document.getElementById('quote_description')
                )
            );
        });
        //]]>
    </script>

    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNRJukOohRJ1tW0tMG4tzpDXFz68OnonM&libraries=places&callback=initMap"
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

        .attributes_table
        {
            display: none;
        }

        .attributes_table.active
        {
            display: block;
        }

        .m-box {
            display: flex;
            align-items: center;
        }

        .m-input {
            border-radius: 5px !important;
            width: 70%;
            border: 0;
            padding: 0 5px;
            text-align: left;
            height: 40px !important;
        }

        .m-input:focus{
            background: #f6f6f6;
        }

        .measure-unit {
            width: 50%;
        }

        .header-div, .content-div, .attribute-content-div
        {
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        .header-div .headings
        {
            font-family: system-ui;
            font-weight: 500;
            border-bottom: 1px solid #ebebeb;
            padding-bottom: 15px;
            color: gray;
            height: 40px;
        }

        .content-div, .attribute-content-div
        {
            margin-top: 15px;
            flex-flow: wrap;
            /*border-bottom: 1px solid #d0d0d0;*/
            padding-bottom: 10px;
        }

        .content-div .content {
            font-family: system-ui;
            font-weight: 500;
            padding: 0;
            color: #3c3c3c;
            height: 40px;
            display: flex;
            align-items: center;
        }

        .content-div.active .content {
            border-top: 2px solid #cecece;
            border-bottom: 2px solid #cecece;
        }

        .content-div.active .content:first-child {
            border-left: 2px solid #cecece;
            border-bottom-left-radius: 4px;
            border-top-left-radius: 4px;
        }

        .content-div.active .last-content {
            border-right: 2px solid #cecece;
            border-bottom-right-radius: 4px;
            border-top-right-radius: 4px;
        }

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
