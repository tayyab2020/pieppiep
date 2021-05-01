@extends('layouts.front')

@section('content')

    <main class="container container1">

        <!-- Left Column / Headphones Image -->
        <div class="left-column">

            <!-- Product Description -->
            <div style="border: 0;width: 90%;margin: auto;" class="product-description">
                <h1>{{$product->brand_name}} {{$product->model_name}} {{$product->model_number}}</h1>

            </div>

            @if($product->photo)

                <img src="{{asset('assets/images/'.$product->photo)}}" class="active">

            @elseif(file_exists('assets/images/'.$product->article_code.'.jpeg'))

                <img src="{{asset('assets/images/'.$product->article_code.'.jpeg')}}" class="active">

            @else

                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG" class="active">

            @endif

        </div>


        <!-- Right Column -->
        <div class="right-column">

            <!-- Product Configuration -->
            <div class="product-configuration">

                <ul style="border: 0;" class="nav nav-tabs">
                    <li style="margin-bottom: 0;" class="active"><a data-toggle="tab" href="#menu1">{{__('text.Specification')}}</a></li>
                    <li style="margin-bottom: 0;"><a data-toggle="tab" href="#description">{{__('text.Description')}}</a></li>
                </ul>

                <div style="padding: 20px 15px;border: 1px solid #24232329;min-height: 453px;" class="tab-content">

                    <div id="menu1" class="tab-pane fade in active">

                    <?php if($product->color){ $colors = explode(',',$product->color); }else{ $colors = []; } ?>

                    @if($colors)

                        <!-- Product Color -->
                            <div class="product-color">

                                <span style="padding: 0;display: flex;align-items: center;" class="col-lg-5">{{__('text.Colors')}}</span>

                                <div class="col-lg-7 color-choose">

                                    {{$product->color}}

                                    {{--@foreach($colors as $color)

                                        <div>
                                            <input data-image="{{$color}}" type="radio" id="{{$color}}" name="color" value="{{$color}}" checked>
                                            <label for="{{$color}}"><span></span></label>
                                        </div>

                                    @endforeach--}}

                                </div>

                            </div>

                    @endif

                    <!-- Cable Configuration -->
                        <div class="product-description">

                            <span style="padding: 0;display: flex;align-items: center;" class="col-lg-5">{{__('text.Category')}}</span>

                            <p class="col-lg-7" style="color: black;">{{$product->cat_name}}</p>

                        </div>

                        <div class="product-description">

                            <span style="padding: 0;display: flex;align-items: center;" class="col-lg-5">{{__('text.Brand')}}</span>

                            <p class="col-lg-7" style="color: black;">{{$product->brand_name}}</p>

                        </div>

                        <div class="product-description">

                            <span style="padding: 0;display: flex;align-items: center;" class="col-lg-5">{{__('text.Model')}}</span>

                            <p class="col-lg-7" style="color: black;">{{$product->model_name}}</p>

                        </div>


                        @if($product->model_number)

                            <div class="product-description">

                                <span style="padding: 0;display: flex;align-items: center;" class="col-lg-5">{{__('text.Model Number')}}</span>

                                <p class="col-lg-7" style="color: black;">{{$product->model_number}}</p>

                            </div>

                        @endif


                        @if($product->size)

                            <div class="product-description">

                                <span style="padding: 0;display: flex;align-items: center;" class="col-lg-5">{{__('text.Sizes')}}</span>

                                <p class="col-lg-7" style="color: black;">{{$product->size}} {{$product->measure}}</p>

                            </div>

                        @endif


                        @if($product->floor_type)

                            <div class="product-description">

                                <span style="padding: 0;display: flex;align-items: center;" class="col-lg-5">{{__('text.Floor Type')}}</span>

                                <p class="col-lg-7" style="color: black;">{{$product->floor_type}}</p>

                            </div>

                        @endif


                        @if($product->floor_type2)

                            <div class="product-description">

                                <span style="padding: 0;display: flex;align-items: center;" class="col-lg-5">{{__('text.Floor Type')}} 2</span>

                                <p class="col-lg-7" style="color: black;">{{$product->floor_type2}}</p>

                            </div>

                        @endif


                        @if($product->supplier)

                            <div class="product-description">

                                <span style="padding: 0;display: flex;align-items: center;" class="col-lg-5">{{__('text.Supplier')}}</span>

                                <p class="col-lg-7" style="color: black;">{{$product->supplier}}</p>

                            </div>

                        @endif


                        <?php $estimated_prices = explode(',',$product->estimated_price); ?>


                        @if($product->estimated_price)


                            @if(strtolower($product->additional_info) == 'per piece' || strtolower($product->additional_info) == 'per stuk')

                                <?php $sizes = explode(',',$product->size); ?>

                                <div class="product-description">

                                    <span style="padding: 0;display: flex;align-items: center;" class="col-lg-5">{{__('text.Estimated Price')}}</span>

                                    <p class="col-lg-7" style="color: black;">@foreach($sizes as $i => $size) {{$size}}{{$product->measure}} &nbsp;&nbsp; € {{$estimated_prices[$i]}}, &nbsp;&nbsp; -{{strtolower($product->additional_info)}} <br> @endforeach</p>

                                </div>

                            @else

                                <?php $additional_info = explode(',',$product->additional_info); ?>

                                <div class="product-description">

                                    <span style="padding: 0;display: flex;align-items: center;" class="col-lg-5">{{__('text.Estimated Price')}}</span>

                                    <p class="col-lg-7" style="color: black;">@foreach($additional_info as $i => $key) {{$key}} &nbsp;&nbsp; € {{$estimated_prices[$i]}} {{$product->measure ? ' / '.$product->measure : null}} <br> @endforeach</p>

                                </div>

                            @endif


                        @endif


                        <div style="margin-top: 20px;margin-bottom: 20px;" class="input-group col-lg-5 col-md-5 col-sm-5 col-xs-8">

                            <span class="input-group-btn">
                                <button style="background-color: #f3f3f3 !important;border: 1px solid #e1e1e1 !important;" type="button" class="quantity-left-minus btn btn-danger btn-number" data-type="minus" data-field="">
                                    <span style="color: grey;" class="glyphicon glyphicon-minus"></span>
                                </button>
                            </span>

                            <input placeholder="{{__('text.Quantity')}}" style="border: 1px solid #d9d9d9;text-align: center;" type="text" id="quantity" name="quantity" class="form-control input-number" maskedFormat="9,1" autocomplete="off" min="1" max="100">

                            <span class="input-group-btn">
                                <button style="background-color: #f3f3f3 !important;border: 1px solid #e1e1e1 !important;" type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-field="">
                                    <span style="color: grey;" class="glyphicon glyphicon-plus"></span>
                                </button>
                            </span>

                        </div>

                        <div class="product-description">

                            <span style="padding: 0;display: flex;align-items: center;font-size: 20px;" class="col-lg-5">{{__('text.Including Waste?')}}</span>

                            <div class="col-lg-7">

                                <label class="switch">
                                    <input class="quote-waste" name="waste" id="waste" type="checkbox">
                                    <span class="slider round"></span>
                                </label>

                            </div>

                        </div>

                        <div style="margin-top: 20px;text-align: center;">
                            <button data-id="{{$product->id}}" href="#aanvragen" role="button" data-toggle="modal" style="height: 45px;min-width: 100px;border: 0;outline: none;font-size: 18px;width: 100%;background-color: #5cb85c !important;border-color: #4cae4c !important;" class="btn btn-success start-btn">{{__('text.Start')}}</button>
                        </div>

                    </div>

                    <div id="description" class="tab-pane fade">
                        {!! $product->description !!}
                    </div>

                    </div>
                </div>

        </div>
    </main>

    <style type="text/css">

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        #menu1 .product-description, #menu1 .product-color
        {
            display: flex;
            justify-content: space-between;
        }

        .terms .checkmark-checkbox:after
        {
            left: 4px !important;
            top: 1.5px !important;
        }

        .container-checkbox {
            display: flex;
            position: relative;
            padding-left: 30px;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 22px;
            font-weight: 300;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            align-items: center;
            font-family: sans-serif;
            color: #353535;
        }

        /* Hide the browser's default radio button */
        .container-checkbox input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        /* Create a custom radio button */
        .checkmark-checkbox {
            position: absolute;
            /*top: 6.5px;*/
            left: 0;
            height: 20px;
            width: 20px;
            background-color: transparent;
            border: 1px solid #e5e5e5;
            border-radius: 2px;
        }

        /* On mouse-over, add a grey background color */
        .container-checkbox:hover input ~ .checkmark-checkbox {
            background-color: #ccc;
        }

        /* When the radio button is checked, add a blue background */
        .container-checkbox input:checked ~ .checkmark-checkbox {
            background-color: #2196F3;
        }

        /* Create the indicator (the dot/circle - hidden when not checked) */
        .checkmark-checkbox:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the indicator (dot/circle) when checked */
        .container-checkbox input:checked ~ .checkmark-checkbox:after {
            display: block;
        }

        /* Style the indicator (dot/circle) */
        .container-checkbox .checkmark-checkbox:after {
            left: 7px;
            top: 3.5px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }

        .pac-container
        {
            z-index: 1000000;
        }

        #quote-box .select2
        {
            /*width: 70% !important;
            float: left;*/
            border: 1px solid lightgrey;
        }

        @media (max-width: 1020px)
        {
            .t-h
            {
                display: none !important;
            }

            .c-h
            {
                border: 0 !important;
            }
        }

        @media (max-width: 500px)
        {

            .box-heading
            {
                font-size: 20px;
            }

            #quote-box
            {
                flex-wrap: wrap;
            }

            #quote-box div
            {
                width: 100% !important;
                margin: 5px;
                height: 45px;
            }

            #quote-box button
            {
                width: 100%;
                margin-top: 20px;
            }
        }

        @media (max-width: 767px)
        {
            #quote-con
            {
                margin-bottom: 30px;
            }
        }

        .well
        {
            box-shadow: none;
            margin-bottom: 0;
            background-color: #ffffff;
            border: 0;
            overflow-y: auto;
        }

        .well .select2
        {
            border: 1px solid #e1e1e1;
        }

        .team_style2 .team_common
        {
            border: 0;
            box-shadow: 2px 2px 5px 1px #d7d7d7;
        }

        @media (max-width: 890px) {
            .next1 {
                right: 35px !important;
            }
        }

        @media (max-width: 550px) {
            .next1 {
                width: 10% !important;
            }
        }

        @media (max-width: 450px) {
            .next1 {
                width: 12% !important;
            }
        }

    </style>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdCPSjhOgaYXo6twWkseoaSHc2Ipob024&libraries=places&callback=initMap" async defer></script>

    <script type="text/javascript">

        function initMap() {

            var input = document.getElementById('quote-zipcode');

            var options = {
                componentRestrictions: {country: "nl"}
            };

            var autocomplete = new google.maps.places.Autocomplete(input,options);

            // Set the data fields to return when the user selects a place.
            autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);


            autocomplete.addListener('place_changed', function() {

                var flag = 0;

                var place = autocomplete.getPlace();


                if (!place.geometry) {

                    // User entered the name of a Place that was not suggested and
                    // pressed the Enter key, or the Place Details request failed.
                    window.alert("{{__('text.No details available for input: ')}}" + place.name);
                    return;
                }
                else
                {
                    var string = $('#quote-zipcode').val().substring(0, $('#quote-zipcode').val().indexOf(',')); //first string before comma

                    if(string)
                    {
                        var is_number = $('#quote-zipcode').val().match(/\d+/);

                        if(is_number === null)
                        {
                            flag = 1;
                        }
                    }
                }

                var city = '';
                var postal_code = '';


                for(var i=0; i < place.address_components.length; i++)
                {
                    if(place.address_components[i].types[0] == 'postal_code')
                    {
                        postal_code = place.address_components[i].long_name;
                    }

                    if(place.address_components[i].types[0] == 'locality')
                    {
                        city = place.address_components[i].long_name;
                    }

                }


                if(city == '')
                {
                    for(var i=0; i < place.address_components.length; i++)
                    {
                        if(place.address_components[i].types[0] == 'administrative_area_level_2')
                        {
                            city = place.address_components[i].long_name;

                        }
                    }
                }


                if(postal_code == '' || city == '')
                {
                    flag = 1;
                }

                if(!flag)
                {
                    $('#check_address').val(1);
                    $("#address-error").remove();
                    $('#postcode').val(postal_code);
                    $("#city").val(city);
                }
                else
                {
                    $('#quote-zipcode').val('');
                    $('#postcode').val('');
                    $("#city").val('');

                    $("#address-error").remove();
                    $('#quote-zipcode').parent().append('<small id="address-error" style="color: red;display: block;margin-top: 10px;padding-left: 5px;">{{__('text.Kindly write your full address with house/building number so system can detect postal code and city from it!')}}</small>');
                }

            });
        }


    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

    <script type="text/javascript">

        $(document).ready(function() {

            $('.quote-waste').change(function() {

                var check = $(this).is(":checked");

                if(check)
                {
                    check = 1;
                }
                else
                {
                    check = 0;
                }

                $('#quote_waste').val(check);

            });

            $("#quantity").keypress(function(e){

                e = e || window.event;
                var charCode = (typeof e.which == "undefined") ? e.keyCode : e.which;
                var val = String.fromCharCode(charCode);

                if (!val.match(/^[0-9]*\,?[0-9]*$/))  // For characters validation
                {
                    e.preventDefault();
                    return false;
                }

                if(e.which == 44)
                {
                    if(this.value.indexOf(',') > -1)
                    {
                        e.preventDefault();
                        return false;
                    }
                }

                var num = $(this).attr("maskedFormat").toString().split(',');
                var regex = new RegExp("^\\d{0," + num[0] + "}(\\,\\d{0," + num[1] + "})?$");
                if (!regex.test(this.value)) {
                    this.value = this.value.substring(0, this.value.length - 1);
                }

            });

            $("#quantity").on('focusout',function(e){
                if($(this).val().slice($(this).val().length - 1) == ',')
                {
                    var val = $(this).val();
                    val = val + '00';
                    $(this).val(val);
                }
            });

            $("#quantity").on('input',function(e) {

                var max = parseInt($(this).attr('max'));
                var min = parseInt($(this).attr('min'));
                var value = $(this).val();
                value = value.toString();
                value = value.replace(/\,/g, '.');
                value = parseFloat(value);

                if (value > max)
                {
                    $(this).val(max);
                }
                else if (value < min)
                {
                    $(this).val(min);
                }

                $('.quote_quantity').val($(this).val());
            });

            $('.modal-body').find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

                //update progress
                var step = $(e.target).data('step');
                var percent = (parseInt(step) / 5) * 100;

                $('.progress-bar').css({width: percent + '%'});
                $('.progress-bar').text("{{__('text.Step')}} " + step);

                //e.relatedTarget // previous tab

            });


            $('.start-btn').click(function(){

                $('.quote_delivery').attr("placeholder", "{{__('text.Select Delivery Date')}}");
                var product_id = $(this).data('id');
                var options = '';

                $.ajax({
                    type: "GET",
                    data: "id=" + product_id,
                    url: "<?php echo url('/products-by-id')?>",
                    success: function (data) {

                        $('.quote-category').val(data.category_id);
                        $(".quote-category").trigger('change.select2');

                        $('.quote-service').removeClass('quote_validation');
                        $('.quote-category').addClass('quote_validation');
                        $('.quote-brand').addClass('quote_validation');
                        $('.quote-model').addClass('quote_validation');

                        $('.navbar a[href="#step1"]').trigger('click');

                        $('.back').hide();
                        $('.next-submit').hide();
                        $('.next').show();

                        $('.quote_delivery').attr("placeholder", "{{__('text.Select Delivery Date')}}");

                        $('.unlinked-boxes').hide();
                        $('.linked-boxes').show();

                        var category_id = data.category_id;
                        var brand_id = data.brand_id;
                        var model_id = data.model_id;
                        var model_number = data.model_number;
                        var options = '';

                        $('.quote-model-number').val(model_number);

                        $.ajax({
                            type: "GET",
                            data: "id=" + category_id,
                            url: "<?php echo url('get-questions')?>",

                            success: function (data) {

                                $('#step2').children('.well').empty();

                                var index_count = 0;

                                $.each(data, function (index, val) {

                                    if (data.length == index + 1) {
                                        $('#step2').children('.well').append('<div style="margin-bottom: 20px;"></div>');
                                    } else {
                                        $('#step2').children('.well').append('<div style="margin-bottom: 40px;"></div>');
                                    }

                                    var last = $('#step2').children('.well').children().last('div');

                                    last.append('<h3 style="text-align: center;color: #4b4b4b;margin-bottom: 20px;">' + val.title + '</h3><input type="hidden" name="questions[]" value="' + val.title + '">');

                                    if (val.predefined == 1) {

                                        last.append('<div class="checkbox_validation"><input name="predefined' + index + '" type="hidden" value="1"></div>');

                                        $.each(val.answers, function (index1, val1) {

                                            last.children('div').append('<hr>\n' +
                                                '                                        <label class="container-checkbox">' + val1.title + '\n' +
                                                '                                        <input name="answers' + index + '[]" type="checkbox" value="' + val1.title + '">\n' +
                                                '                                        <span class="checkmark-checkbox"></span>\n' +
                                                '                                        </label>');

                                        });
                                    } else {
                                        if (val.placeholder) {
                                            var placeholder = val.placeholder;
                                        } else {
                                            var placeholder = '';
                                        }

                                        last.append('<input name="predefined' + index + '" type="hidden" value="0">\n' +
                                            '<textarea name="answers' + index + '" style="resize: vertical;" rows="1" class="form-control quote_validation" placeholder="' + placeholder + '"></textarea>');
                                    }

                                    index_count = index;

                                });

                                $('#step2').children('.well').append('<input type="hidden" name="index_count" value="' + index_count + '">');

                                /*$('#step2').children('div').children('h3').
                                console.log(data);*/
                            }
                        });

                        $.ajax({
                            type: "GET",
                            data: "id=" + category_id,
                            url: "<?php echo url('/products-brands-by-category')?>",
                            success: function (data) {

                                $.each(data, function (index, value) {

                                    var opt = '<option value="' + value.id + '" >' + value.cat_name + '</option>';

                                    options = options + opt;

                                });

                                $('.quote-model').find('option')
                                    .remove()
                                    .end()
                                    .append('<option value="">Select Model</option>');

                                $('.quote-brand').find('option')
                                    .remove()
                                    .end()
                                    .append('<option value="">Select Brand</option>' + options);

                                $('.quote-brand').val(brand_id);
                                $(".quote-brand").trigger('change.select2');


                                var options = '';

                                $.ajax({
                                    type: "GET",
                                    data: "id=" + brand_id,
                                    url: "<?php echo url('/products-models-by-brands')?>",
                                    success: function (data) {

                                        $.each(data, function (index, value) {

                                            var opt = '<option value="' + value.id + '" >' + value.cat_name + '</option>';

                                            options = options + opt;

                                        });

                                        $('.quote-model').find('option')
                                            .remove()
                                            .end()
                                            .append('<option value="">Select Model</option>' + options);

                                        $('.quote-model').val(model_id);
                                        $(".quote-model").trigger('change.select2');

                                    }
                                });

                            }
                        });

                    }

                });

            });

        });

    </script>

    <style type="text/css">

        @media only screen and (max-width: 767px)
        {
            .subscribe-newsletter-wrapper
            {
                padding-top: 40px;
            }
        }

        .slick-slide
        {
            outline: none;
        }

        @media (min-width: 1200px){

            .slick-slide
            {
                padding: 0 20px;
            }

        }

        @media (min-width: 1250px){

            .slick-slide
            {
                padding: 0 30px;
            }

        }

        .slick-arrow{position:absolute;top:50%;-webkit-transform:translateY(-50%);-ms-transform:translateY(-50%);transform:translateY(-50%);background:rgba(#fff,0.8);text-align:center;cursor:pointer;z-index:1;width:48px;height:48px;background:#fff;color:#3c475b;border:0;border-radius:50%;box-shadow:0 1px 3px 0 rgba(30,41,61,0.1),0 1px 2px 0 rgba(30,41,61,0.2);opacity:0.9;}

        .slick-arrow:before
        {
            display: none;
        }

        .slick-arrow:hover , .slick-arrow:focus
        {
            outline: none;
            background: #fff;
        }

        .slick-prev:hover, .slick-prev:focus, .slick-next:hover, .slick-next:focus
        {
            color: #0ea800;
        }

        .form-control:focus
        {
            border-color: #66afe9 !important;
        }

        #team {
            background: #eee !important;
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background-color: #108d6f;
            border-color: #108d6f;
            box-shadow: none;
            outline: none;
        }

        .btn-primary {
            color: #fff;
            background-color: #007b5e;
            border-color: #007b5e;
        }

        section {
            padding: 60px 0;
        }

        section .section-title {
            text-align: center;
            color: #007b5e;
            margin-bottom: 50px;
            text-transform: uppercase;
        }

        .card {
            border: none;
            position: relative;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-clip: border-box;
            border-radius: .25rem;
        }

        .card-body
        {
            -webkit-box-flex:1;
            flex:1 1 auto;
            padding:1.25rem;
        }


        .image-flip:hover .backside,
        .image-flip.hover .backside {
            -webkit-transform: rotateY(0deg);
            -moz-transform: rotateY(0deg);
            -o-transform: rotateY(0deg);
            -ms-transform: rotateY(0deg);
            transform: rotateY(0deg);
            border-radius: .25rem;
        }

        .image-flip:hover .frontside,
        .image-flip.hover .frontside {
            -webkit-transform: rotateY(180deg);
            -moz-transform: rotateY(180deg);
            -o-transform: rotateY(180deg);
            transform: rotateY(180deg);
        }

        .mainflip {
            -webkit-transition: 1s;
            -webkit-transform-style: preserve-3d;
            -ms-transition: 1s;
            -moz-transition: 1s;
            -moz-transform: perspective(1000px);
            -moz-transform-style: preserve-3d;
            -ms-transform-style: preserve-3d;
            transition: 1s;
            transform-style: preserve-3d;
            position: relative;
            border: 1px solid #fff;
        }



        .frontside {
            position: relative;
            -webkit-transform: rotateY(0deg);
            -ms-transform: rotateY(0deg);
            z-index: 2;
            margin-bottom: 30px;
        }

        .backside {
            position: absolute;
            top: 0;
            left: 0;
            -webkit-transform: rotateY(-180deg);
            -moz-transform: rotateY(-180deg);
            -o-transform: rotateY(-180deg);
            -ms-transform: rotateY(-180deg);
            transform: rotateY(-180deg);
            -webkit-box-shadow: 5px 7px 9px -4px rgb(158, 158, 158);
            -moz-box-shadow: 5px 7px 9px -4px rgb(158, 158, 158);
            box-shadow: 5px 7px 9px -4px rgb(158, 158, 158);


        }


        .frontside,
        .backside {
            -webkit-backface-visibility: hidden;
            -moz-backface-visibility: hidden;
            -ms-backface-visibility: hidden;
            backface-visibility: hidden;
            -webkit-transition: 1s;
            -webkit-transform-style: preserve-3d;
            -moz-transition: 1s;
            -moz-transform-style: preserve-3d;
            -o-transition: 1s;
            -o-transform-style: preserve-3d;
            -ms-transition: 1s;
            -ms-transform-style: preserve-3d;
            transition: 1s;
            transform-style: preserve-3d;
            padding-top: 20px;
            border:1px solid #ffffff;
            border-radius: 5%;
            width: 100%;
            background-color: #f2f4f4;
            /*background-image: linear-gradient(141deg, #d9d9d9 0%, #edf0f1 51%, #aad9ea 75%);*/
            background-image: linear-gradient(141deg, #e7e7e700 0%,  #d6ebf2a1 75%);
            opacity: 0.8;
        }

        .frontside .card,
        .backside .card {
            min-height: 312px;
        }

        .backside .card a {
            font-size: 18px;
            color: #007b5e !important;
        }

        .frontside .card .card-title,
        .backside .card .card-title {
            color: #2b2b2b !important;

        }

        .frontside .card .card-body img {
            width: 85%;
            height: 200px;
            border-radius: 7%;
        }

        .steps{

            background: #f5f5f5;

        }

        @media screen and (min-width: 1024px){

            .steps{

                padding: 3rem;

            }

        }


        .column,.columns{-ms-flex:1 1 0px;flex:1 1 0px;padding-right:.3125rem;padding-left:.3125rem;min-width:initial}




        .hiw{-ms-flex-positive:2;flex-grow:2;color:#444;text-align:center;-ms-flex-align:center;align-items:center;font-family:"Lato",sans-serif;font-size:2.25rem;font-weight:700;line-height:1.25;padding-bottom:2.25rem;margin:0;text-align:center;font-size:2rem}



        @media screen and (min-width: 30em){

            .hiw{

                font-size: 38px;

            }

        }

        @media screen and (min-width: 64em){

            .hiw{

                padding-bottom: 38px;

            }

        }


        #languagePickerContainer{left:0;right:0;margin:.625rem auto;display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;-ms-flex-pack:center;justify-content:center;z-index:999;padding-bottom:1rem;margin-top:-2rem}

        .languageSelector{font-size:1em;margin-right:4%;margin:0 1%;color:#666;font-weight:400;cursor:pointer}


        .infographic__separator{content:"\B7";font-family:"Fira Sans";font-size:2.25rem;line-height:1rem;color:#666}

        .languageSelector-selected{color: <?php if($gs->btn_bg == null) { if($gs->colors == null){ echo '#f3bd02 !important;'; } else {   echo $gs->colors.' !important;'; }} else { echo $gs->btn_bg. ' !important;'; } ?>}

        .steps__items {
            justify-content: center;
        }

        .steps__items{text-align:center;font-family:"Lato",sans-serif}



        .large-3{-ms-flex:0 0 30%;flex:0 0 30%;max-width:30%}

        @media print, screen and (max-width: 1600px){

            .row1{

                max-width: 100% !important;
            }

        }


        @media print, screen and (max-width: 1300px){

            .medium-6{-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%}

        }


        @media print, screen and (max-width: 760px){

            .small-12{-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%}

        }

        .step{margin-bottom:2.5625rem;margin-left:.9375rem;margin-right:.9375rem}

        @media screen and (min-width: 480px){
            .step img {
                max-height: 5.375rem;
                min-height: 80px;
            }
        }

        .step img {
            max-width: 100%;
            max-height: 80px;
        }


        .ic-img{display:inline-block;vertical-align:middle;max-width:100%;height:auto;-ms-interpolation-mode:bicubic}



        .steps--en .step__header_en{display:block}

        .step__header{font-weight:700;font-size:20px;color:#444;margin-top: 20px;}


        @media screen and (min-width: 30em){

            .step__header{

                font-size: 20px;
                margin-top: 20px;

            }


        }




        .steps--en .step__description_en{

            display: block;
        }

        @media screen and (min-width: 480px){

            .steps__items p{

                font-size: 17px;
            }
        }

        .steps__items p{

            font-size: 17px;
            color: #999;
        }




        .ic-p{margin-bottom:1rem;font-size:inherit;line-height:1.6;text-rendering:optimizeLegibility}


        #usp{

            background: #fff;
        }

        .usp{padding-top:3rem;padding-bottom:3rem;background-color:#F3F3F3}

        .large-12{-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%}

        @media screen and (min-width: 30em)
        {
            .usps__row{

                padding: 1.25rem;
            }
        }

        .usps__row{-ms-flex-pack:center;justify-content:center}



        .small-11{-ms-flex:0 0 91.66667%;flex:0 0 91.66667%;max-width:91.66667%;margin-bottom: 20px;}


        @media print, screen and (min-width: 30em)
        {
            .medium-8{-ms-flex:0 0 66.66667%;flex:0 0 66.66667%;max-width:66.66667%;margin-bottom: 20px;}
        }

        @media print, screen and (min-width: 64em)
        {
            .large-4{-ms-flex:0 0 33.33333%;flex:0 0 33.33333%;max-width:33.33333%}
        }




        @media screen and (min-width: 64em)
        {
            .usp__block{min-height:26rem;padding:1.525rem}
        }


        .usp__block {
            box-shadow: 0px 0px 5px 4px #f3f3f3;
            border: 1px solid #dddddd;
            min-height: 42rem;
        }



        @media screen and (min-width: 1024px)
        {

            .usp__block
            {
                min-height: 42rem;
            }
        }


        .usp__block{height: 100%;text-align:center;font-family:"Lato", sans-serif;border:solid;border-width:thin;border-color:#ccc;margin:0.1875rem;padding:1.525rem 1.525rem 2.525rem;min-width:8.25rem;background-color:#fff}


        .usp__block div{

            min-height: 7rem;
        }

        .usp__block div{display:block;text-decoration:none;color:#666;padding-top:0.5rem;font-weight:600;min-height:9rem;margin-bottom: 20px;}

        .usp__block img {
            max-width: 100%;
            height: 80px;
            padding-bottom:0.5rem;
        }


        .usp__block__title{margin-top:0;margin-bottom:0;font-size:20px;color:#444}

        @media screen and (min-width: 30em)
        {
            .usp__block span{

                font-size: 13px;
            }
        }

        .usp__block span{font-weight:300;color:#666;font-size:15px;word-break: break-word;}




        @media print, screen and (max-width: 1600px){

            .row2{

                max-width: 80% !important;
            }

        }

        @media print, screen and (max-width: 1200px){

            .row2{

                max-width: 90% !important;
            }

        }

    </style>

    <style>

        .cd-filters .select2-container--default .select2-selection--single
        {
            border: 1px solid #aaa !important;
            border-radius: 4px !important;
        }

        .select2-container{

            height: 100%;
        }

        .select2-container--default .select2-selection--single{

            height: 100%;
            padding: 7px;
            border: none;
            border-radius: 0;
            outline: none;

        }

        .select2-container--default .select2-selection--single .select2-selection__arrow{

            padding: 19px;
        }

        .cd-filters .select2-selection__clear{
            position: relative;
            right: 5px;
            top: 1px;
            z-index: 1000;
            display: block !important;
        }

        .select2-selection__clear
        {
            display: none;
        }

    </style>

    <style type="text/css">

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

    <style type="text/css">

        .select2-container {

            height: 100%;
        }

        .select2-container--default .select2-selection--single {

            height: 100%;
            padding: 11px;
            border: none;
            border-radius: 0;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {

            padding: 26px;
        }

        .cd-filters .select2-selection__clear {
            position: relative;
            right: 5px;
            top: 1px;
            z-index: 1000;
            display: block !important;
        }

        .select2-selection__clear
        {
            display: none;
        }

        [type="radio"]:checked,
        [type="radio"]:not(:checked) {
            position: absolute;
            left: -9999px;
        }

        [type="radio"]:checked + label,
        [type="radio"]:not(:checked) + label {
            position: relative;
            padding-left: 28px;
            cursor: pointer;
            line-height: 20px;
            display: inline-block;
            color: #666;
        }

        [type="radio"]:checked + label:before,
        [type="radio"]:not(:checked) + label:before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 18px;
            height: 18px;
            border: 1px solid #ddd;
            border-radius: 100%;
            background: #fff;
        }

        [type="radio"]:checked + label:after,
        [type="radio"]:not(:checked) + label:after {
            content: '';
            width: 12px;
            height: 12px;
            background: #c33131;
            position: absolute;
            top: 3px;
            left: 3px;
            border-radius: 100%;
            -webkit-transition: all 0.2s ease;
            transition: all 0.2s ease;
        }

        [type="radio"]:not(:checked) + label:after {
            opacity: 0;
            -webkit-transform: scale(0);
            transform: scale(0);
        }

        [type="radio"]:checked + label:after {
            opacity: 1;
            -webkit-transform: scale(1);
            transform: scale(1);
        }

        .color-choose label
        {
            padding-left: 10px !important;
            padding-top: 10px;
        }

        .color-choose div:first-child label
        {
            padding-left: 0 !important;
        }

        .color-choose label:before, .color-choose label:after
        {
            display: none;
        }

    </style>

    <script>

        $(document).ready(function(){

            $(".js-data-example-ajax10").select2({
                width: '100%',
                height: '200px',
                placeholder: "Select Service",
                allowClear: true,
                dropdownParent: $('#aanvragen'),
                "language": {
                    "noResults": function(){
                        return '{{__('text.No results found')}}';
                    }
                },
            });

            $(".js-data-example-ajax2").select2({
                width: '100%',
                height: '200px',
                placeholder: "{{__('text.Select Category')}}",
                allowClear: true,
                dropdownParent: $('#aanvragen'),
                "language": {
                    "noResults": function(){
                        return '{{__('text.No results found')}}';
                    }
                },
            });

            $(".js-data-example-ajax5").select2({
                width: '100%',
                height: '200px',
                placeholder: "{{__('text.Select Brand')}}",
                allowClear: true,
                dropdownParent: $('#aanvragen'),
                "language": {
                    "noResults": function(){
                        return '{{__('text.No results found')}}';
                    }
                },

            });

            $(".js-data-example-ajax6").select2({
                width: '100%',
                height: '200px',
                placeholder: "{{__('text.Select Model')}}",
                allowClear: true,
                dropdownParent: $('#aanvragen'),
                "language": {
                    "noResults": function(){
                        return '{{__('text.No results found')}}';
                    }
                },

            });

            var quantity=0;

            $('.quantity-right-plus').click(function(e){

                // Stop acting like a button
                e.preventDefault();
                // Get the field name

                var quantity = $('#quantity').val();
                quantity = quantity.toString();
                quantity = quantity.replace(/\,/g, '.');
                quantity = parseFloat(quantity);

                // If is not undefined

                var max = parseFloat($('#quantity').attr('max')).toFixed(2);
                var new_qty = quantity + 1;

                if (new_qty <= max)
                {
                    quantity = new_qty;
                    quantity = parseFloat(quantity).toFixed(2);
                    quantity = quantity.toString();
                    quantity = quantity.replace(/\./g, ',');

                    $('#quantity').val(quantity);
                    $('.quote_quantity').val(quantity);
                }
                else
                {
                    max = max.toString();
                    max = max.replace(/\./g, ',');

                    $('#quantity').val(max);
                    $('.quote_quantity').val(max);
                }

                // Increment

            });

            $('.quantity-left-minus').click(function(e){
                // Stop acting like a button
                e.preventDefault();
                // Get the field name
                var quantity = $('#quantity').val();
                quantity = quantity.toString();
                quantity = quantity.replace(/\,/g, '.');
                quantity = parseFloat(quantity);

                // If is not undefined

                // Increment
                if(quantity>0){

                    var min = parseFloat($('#quantity').attr('min')).toFixed(2);
                    var new_qty = quantity - 1;

                    if (new_qty >= min)
                    {
                        quantity = new_qty;
                        quantity = parseFloat(quantity).toFixed(2);
                        quantity = quantity.toString();
                        quantity = quantity.replace(/\./g, ',');

                        $('#quantity').val(quantity);
                        $('.quote_quantity').val(quantity);
                    }
                    else
                    {
                        min = min.toString();
                        min = min.replace(/\./g, ',');

                        $('#quantity').val(min);
                        $('.quote_quantity').val(min);
                    }
                }
            });

        });

    </script>

    <style>

        .product-configuration .nav-tabs>li.active>a, .product-configuration .nav-tabs>li.active>a:focus, .product-configuration .nav-tabs>li.active>a:hover
        {
            background-color: #e5e5e5;
            border-bottom: 0;
        }

        .product-configuration .nav-tabs>li>a
        {
            color: black;
            border: 1px solid #24232329;
            border-bottom: 0;
        }

        .container1 {
            max-width: 100%;
            width: 90%;
            margin: 0 auto;
            padding: 55px 15px;
            display: flex;
        }

        /* Columns */
        .left-column {
            width: 45%;
            position: relative;
            text-align: center;
        }

        .right-column {
            width: 55%;
        }

        /* Left Column */
        .left-column img {
            width: 90%;
            opacity: 0;
            transition: all 0.3s ease;
            height: 450px;
            box-shadow: 2px 2px 8px 0 rgb(0 0 0 / 20%);
        }

        .left-column img.active {
            opacity: 1;
        }

        /* Product Description */
        .product-description {
            /*border-bottom: 1px solid #E1E8EE;
            margin-bottom: 20px;*/
        }
        .product-description #top-heading {
            font-size: 12px;
            color: #358ED7;
            letter-spacing: 1px;
            text-transform: uppercase;
            text-decoration: none;
        }
        .product-description h1 {
            font-weight: 300;
            font-size: 25px;
            color: #43484D;
            letter-spacing: -2px;
            text-align: left;
        }
        .product-description p {
            font-size: 16px;
            font-weight: 300;
            color: #86939E;
            line-height: 24px;
        }

        /* Product Color */
        .product-color {
            margin-bottom: 20px;
        }

        .color-choose div {
            display: inline-block;
        }

        .color-choose input[type="radio"] {
            display: none;
        }

        .color-choose input[type="radio"] + label span {
            display: inline-block;
            width: 40px;
            height: 40px;
            margin: -1px 4px 0 0;
            vertical-align: middle;
            cursor: pointer;
            border-radius: 50%;
        }

        .color-choose input[type="radio"] + label span {
            border: 2px solid #FFFFFF;
            box-shadow: 0 1px 3px 0 rgba(0,0,0,0.33);
        }

        .color-choose input[type="radio"]#red + label span {
            background-color: #C91524;
        }
        .color-choose input[type="radio"]#Red + label span {
            background-color: #C91524;
        }
        .color-choose input[type="radio"]#blue + label span {
            background-color: #314780;
        }
        .color-choose input[type="radio"]#Blue + label span {
            background-color: #314780;
        }
        .color-choose input[type="radio"]#black + label span {
            background-color: #323232;
        }
        .color-choose input[type="radio"]#Black + label span {
            background-color: #323232;
        }
        .color-choose input[type="radio"]#yellow + label span {
            background-color: #eded1d;
        }
        .color-choose input[type="radio"]#Yellow + label span {
            background-color: #eded1d;
        }
        .color-choose input[type="radio"]#green + label span {
            background-color: #0fdb0f;
        }
        .color-choose input[type="radio"]#Green + label span {
            background-color: #0fdb0f;
        }
        .color-choose input[type="radio"]#white + label span {
            background-color: white;
        }
        .color-choose input[type="radio"]#White + label span {
            background-color: white;
        }
        .color-choose input[type="radio"]#brown + label span {
            background-color: brown;
        }
        .color-choose input[type="radio"]#Brown + label span {
            background-color: brown;
        }
        .color-choose input[type="radio"]#gray + label span {
            background-color: gray;
        }
        .color-choose input[type="radio"]#Gray + label span {
            background-color: gray;
        }

        .color-choose input[type="radio"]:checked + label span {
            /*background-image: url(https://designmodo.com/demo/product-page/images/check-icn.svg);*/
            background-repeat: no-repeat;
            background-position: center;
        }

        /* Cable Configuration */
        .cable-choose {
            margin-bottom: 20px;
        }

        .cable-choose button {
            border: 2px solid #E1E8EE;
            border-radius: 6px;
            padding: 13px 20px;
            font-size: 14px;
            color: #5E6977;
            background-color: #fff;
            cursor: pointer;
            transition: all .5s;
        }

        .cable-choose button:hover,
        .cable-choose button:active,
        .cable-choose button:focus {
            border: 2px solid #86939E;
            outline: none;
        }

        .cable-config {
            border-bottom: 1px solid #E1E8EE;
            margin-bottom: 20px;
        }

        .cable-config a {
            color: #358ED7;
            text-decoration: none;
            font-size: 12px;
            position: relative;
            margin: 10px 0;
            display: inline-block;
        }
        .cable-config a:before {
            content: "?";
            height: 15px;
            width: 15px;
            border-radius: 50%;
            border: 2px solid rgba(53, 142, 215, 0.5);
            display: inline-block;
            text-align: center;
            line-height: 16px;
            opacity: 0.5;
            margin-right: 5px;
        }

        /* Product Price */
        .product-price {
            display: flex;
            align-items: center;
        }

        .product-price span {
            font-size: 22px;
            font-weight: 300;
            color: #43474D;
            margin-right: 20px;
        }

        .cart-btn {
            display: inline-block;
            background-color: #7DC855;
            border-radius: 6px;
            font-size: 16px;
            color: #FFFFFF;
            text-decoration: none;
            padding: 12px 30px;
            transition: all .5s;
        }
        .cart-btn:hover {
            background-color: #64af3d;
        }

        /* Responsive */
        @media (max-width: 940px) {
            .container1 {
                flex-direction: column;
            }

            .right-column
            {
                margin: 25px 0;
            }

            .left-column,
            .right-column {
                width: 100%;
                min-height: auto;
            }

            .left-column img {
                width: 300px;
                right: 0;
                top: -65px;
                left: initial;
                height: auto;
            }
        }

        @media (max-width: 535px) {
            .left-column img {
                width: 100%;
                top: -85px;
            }

            .left-column .product-description
            {
                width: 100% !important;
            }
        }
    </style>



@endsection
