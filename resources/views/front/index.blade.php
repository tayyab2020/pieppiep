@extends('layouts.front')
@section('styles')
    <style type="text/css">
        /* Hide the list on focus of the input field */
        datalist {
            display: none;
        }
        /* specifically hide the arrow on focus */
        input::-webkit-calendar-picker-indicator {
            display: none;
        }

    </style>
@endsection
@section('content')


    <div class="hero-area overlay" style="background-image: url({{asset('assets/images/'.$gs->bgimg)}});z-index: auto;color: black;padding-top: 20px;padding-bottom: 45px;background-color: #ebebeb;">

        @if(Session::has('unsuccess'))

            <div class="alert alert-danger validation" style="position: absolute;top: 0px;width: 100%;background-color: #e53333;color: white;border: none;">

                <button type="button" class="close cl-btn" data-dismiss="alert" aria-label="Close" style="text-shadow: none;opacity: 1;"><span aria-hidden="true" style="font-size: 30px;">×</span></button>

                <ul class="text-left" style="text-align: center;font-size: 21px;list-style: none;padding-left: 0;font-weight: 600;font-family: monospace;">

                    <li>{{ Session::get('unsuccess') }}</li>

                </ul>
            </div>

        @endif

            @if(Session::has('success'))

                <div class="alert alert-success validation" style="position: absolute;top: 0px;width: 100%;border: none;">

                    <button type="button" class="close cl-btn" data-dismiss="alert" aria-label="Close" style="text-shadow: none;opacity: 1;"><span aria-hidden="true" style="font-size: 30px;">×</span></button>

                    <ul class="text-left" style="text-align: center;font-size: 21px;list-style: none;padding-left: 0;font-weight: 600;font-family: monospace;">

                        <li>{{ Session::get('success') }}</li>

                    </ul>
                </div>

            @endif

            @include('includes.form-error')


        <div class="container" style="width: 100%;">

            <div class="row" style="display: flex;justify-content: center;">

                <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12" id="quote-con">

                    <h3 class="box-heading" style="text-align: center;padding-top: 25px;color: black;/*text-shadow: 1px 2px 5px #4f4f4f;*/font-weight: 500;">{{__('text.Fill information for Quotation')}}</h3>

                    {{--<h1 style="color: black;">{{$gs->bg_title}}</h1>
                    <p>{!!$gs->bg_text!!}</p>--}}

                    <style>
                        .main-form
                        {
                            background-color: {{($gs->form_bg == null) ? (($gs->colors == null) ? '#f3bd02 !important;' : $gs->colors.' !important;') : $gs->form_bg. ' !important;' }};
                            color: {{($gs->form_col != null) ? $gs->form_col. ' !important;' : 'black !important;' }};
                            border: 1px solid {{($gs->form_ic == null) ? (($gs->colors == null) ? '#f3bd02 !important;' : $gs->colors.' !important;') : $gs->form_ic. ' !important;' }};
                        }
                    </style>

                    <div class="row o-box" style="margin: 35px 0 30px 0;display: flex;justify-content: center;">

                        <div class="btn-box col-lg-11 col-md-11 col-sm-11 col-xs-12" style="display: flex;justify-content: center;">

                            <div style="text-align: center;" class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                                <button data-id="1" class="btn btn-success p-btns">
                                    <span>Product</span> <i class="fas fa-arrow-right" style="text-decoration: none;"></i>
                                </button>

                            </div>

                            <div style="text-align: center;" class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                                <button data-id="2" class="btn btn-success p-btns">
                                    <span>Product + Dienst</span> <i class="fas fa-arrow-right" style="text-decoration: none;"></i>
                                </button>

                            </div>

                            <div style="text-align: center;" class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                                <button data-id="3" class="btn btn-success p-btns">
                                    <span>Dienst</span> <i class="fas fa-arrow-right" style="text-decoration: none;"></i>
                                </button>

                            </div>

                        </div>

                    </div>

                    <div class="main-form cbm-box" style="display: none;border-radius: 10px;box-shadow: 0px 0px 4px 0px #dbdbdb;">

                        <div id="quote-box" style="display: flex;justify-content: space-between;width: 100%;padding: 20px;">

                            <div style="width: 20%;">

                                <select class="js-data-example-ajax1 form-control quote-category" name="group" id="blood_grp">

                                    <option value="">{{__('text.Select Category')}}</option>

                                    @foreach($quote_cats as $cat)
                                        <option value="{{$cat->id}}">{{$cat->cat_name}}</option>
                                    @endforeach

                                    <option value="Diensten">Diensten</option>

                                </select>

                            </div>

                            <div class="linked-boxes" style="width: 20%;">

                                <select class="js-data-example-ajax3 form-control quote-brand" name="group" id="blood_grp">

                                    <option value="">{{__('text.Select Brand')}}</option>

                                </select>

                            </div>

                            <div class="linked-boxes" style="width: 20%;">

                                <select class="js-data-example-ajax4 quote-model form-control" name="group" id="blood_grp">

                                    <option value="">{{__('text.Select Model')}}</option>

                                </select>

                            </div>

                            <div class="linked-boxes" style="width: 20%;">

                                <input type="text" style="height: 100%;" name="model_number" class="form-control quote-model-number" placeholder="{{__('text.Model Number (Optional)')}}" />

                            </div>

                            <div class="unlinked-boxes" style="width: 60%;display: none;">

                                <select class="js-data-example-ajax0 form-control quote-service" name="group" id="blood_grp">

                                    <option value="">{{__('text.Select Service')}}</option>

                                    @if(isset($quote_services))

                                        @foreach($quote_services as $service)
                                            <option value="{{$service->id}}">{{$service->title}}</option>
                                        @endforeach

                                    @endif

                                </select>

                            </div>

                            <button href="#aanvragen" role="button" data-toggle="modal" style="height: 45px;min-width: 100px;float: right;border: 0;outline: none;font-size: 18px;" class="btn btn-primary">{{__('text.Search')}}</button>

                        </div>
                    </div>

                    <div class="header-top-area" style="border-radius: 10px;margin-top: 10px;">
                        <div class="container" style="width: 100%;">

                            <div class="row" style="display: flex;">

                                <div style="width: 100%;">
                                    <div>
                                        <ul style="display: flex;justify-content: center;">
                                            <li class="t-h" style="display: flex;align-items: center;">
                                                <img style="width: 20px;height: 20px;margin-right: 5px;" src="{{asset('assets/images/deal.png')}}">
                                                <span style="vertical-align: inherit;">{!! __('text.Your reliable partner') !!}</span>
                                            </li>
                                            <li class="c-h" style="display: flex;align-items: center;">
                                                <img style="width: 20px;height: 20px;margin-right: 5px;" src="{{asset('assets/images/deal.png')}}">
                                                <span style="vertical-align: inherit;">{!! __('text.We match supply and demand transparently') !!}</span>
                                            </li>
                                            <li class="t-h" style="display: flex;align-items: center;">
                                                <img style="width: 20px;height: 20px;margin-right: 5px;" src="{{asset('assets/images/deal.png')}}">
                                                <span style="vertical-align: inherit;">{!! __('text.We are involved in the growth of your company') !!}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="main-form p-box" style="display: none;border-radius: 10px;box-shadow: 0px 0px 4px 0px #dbdbdb;margin-top: 10px;">

                        <div id="quote-box" style="display: flex;justify-content: space-between;width: 100%;padding: 20px;">

                            <div style="width: 90%;">

                                <div class="autocomplete" style="width:100%;">
                                    <input id="productInput" class="form-control quote-product" type="text" name="product" placeholder="{{__('text.Select Product')}}">
                                </div>

                                <select style="display: none;" class="form-control all-products" name="group" id="blood_grp">

                                    @foreach($quote_products as $product)
                                        <option data-cat="{{$product->cat_name}}" value="{{$product->id}}">{{$product->title}}</option>
                                    @endforeach

                                </select>

                            </div>

                            <button href="#aanvragen" role="button" data-toggle="modal" style="height: 45px;min-width: 100px;float: right;border: 0;outline: none;font-size: 18px;" class="btn btn-primary">{{__('text.Start')}}</button>

                        </div>
                    </div>

                    <style>

                        @media (max-width: 767px)
                        {
                            .btn-box
                            {
                                display: block !important;
                            }

                            .btn-box div
                            {
                                margin: 20px 0;
                            }
                        }

                        .p-btns
                        {
                            padding: 20px 15px;
                            text-align: center;
                            font-size: 14px;
                            -webkit-transition: opacity .45s cubic-bezier(0.25,1,0.33,1);
                            transition: opacity .45s cubic-bezier(0.25,1,0.33,1);
                            color: white;
                            font-weight: 600;
                            display: inline-block;
                            width: 80%;
                            border: 0;
                            border-radius: 6px;
                            background-color: {{($gs->form_bg == null) ? (($gs->colors == null) ? '#f3bd02 !important;' : $gs->colors.' !important;') : $gs->form_bg. ' !important;' }}
                        }

                        .p-btns span
                        {
                            left: 0;
                            display: inline-block;
                            transform: translateX(0);
                            -webkit-transform: translateX(0);
                            transition: opacity .45s cubic-bezier(0.25,1,0.33,1),transform .45s cubic-bezier(0.25,1,0.33,1);
                            -webkit-transition: opacity .45s cubic-bezier(0.25,1,0.33,1),transform .45s cubic-bezier(0.25,1,0.33,1);
                            position: relative;
                        }

                        .p-btns:hover span
                        {
                            transform: translateX(-18px);
                            -webkit-transform: translateX(-18px);
                        }

                        .p-btns i
                        {
                            text-decoration: none;
                            background-color: transparent!important;
                            top: 53% !important;
                            right: 20% !important;
                            font-size: 18px;
                            line-height: 18px;
                            width: 18px;
                            position: absolute;
                            margin-top: -9px;
                            opacity: 0;
                            transition: all .45s cubic-bezier(0.25,1,0.33,1);
                            -webkit-transition: all .45s cubic-bezier(0.25,1,0.33,1);
                            display: inline-block;
                            word-spacing: 1px;
                            text-align: center;
                            vertical-align: middle;
                            max-width: 100%;
                        }

                        .p-btns:hover i
                        {
                            opacity: 1;
                        }

                        .autocomplete ::-webkit-input-placeholder {
                            text-align: center;
                        }

                        .autocomplete :-moz-placeholder { /* Firefox 18- */
                            text-align: center;
                        }

                        .autocomplete ::-moz-placeholder {  /* Firefox 19+ */
                            text-align: center;
                        }

                        .autocomplete :-ms-input-placeholder {
                            text-align: center;
                        }

                        .autocomplete {
                            position: relative;
                            display: inline-block;
                        }

                        .quote-product {
                            /*border: 1px solid transparent;*/
                            background-color: #f1f1f1;
                            padding: 10px;
                            font-size: 16px;
                        }

                        .quote-product {
                            background-color: #f1f1f1;
                            width: 100%;
                            height: 45px;
                        }

                        .autocomplete-items {
                            position: absolute;
                            border: 1px solid #d4d4d4;
                            border-bottom: none;
                            border-top: none;
                            z-index: 99;
                            /*position the autocomplete items to be the same width as the container:*/
                            top: 100%;
                            left: 0;
                            right: 0;
                            max-height: 230px;
                            overflow-x: hidden;
                            overflow-y: auto;
                        }

                        .autocomplete-items div {
                            padding: 10px;
                            cursor: pointer;
                            background-color: #fff;
                            border-bottom: 1px solid #d4d4d4;
                        }

                        /*when hovering an item:*/
                        .autocomplete-items div:hover {
                            background-color: #e9e9e9;
                        }

                        /*when navigating through the items using the arrow keys:*/
                        .autocomplete-active {
                            background-color: DodgerBlue !important;
                            color: #ffffff;
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

                    </style>

                </div>

            </div>
        </div>
    </div>
    <!-- Ending of Hero area -->


    <!-- Starting of All - sectors area -->
    <div class="section-padding all-sectors-wrap wow fadeInUp" style="background-color: white;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title pb_50 text-center">
                        <h2>{{$lang->bgs}}</h2>

                        <div class="section-borders">
                            <span></span>
                            <span class="black-border"></span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                @foreach($quote_cats as $cat)

                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                            <div class="mainflip">

                                <a href="{{url('products/?_token='.@csrf_token().'&category='.$cat->id)}}">
                                    <div class="frontside">
                                        <div class="card">
                                            <div class="card-body text-center">

                                                <p>
                                                    @if($cat->photo == NULL)

                                                        <img class=" img-fluid" src="{{asset('assets/default.jpg')}}" >

                                                    @else

                                                        <img class=" img-fluid" src="{{asset('assets/images/'.$cat->photo)}}" >

                                                    @endif

                                                </p>

                                                <h4 class="card-title" style="font-weight: 600;padding-top: 30px;font-family: monospace;font-size: 15px;">{{$cat->cat_name}}</h4>

                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <div class="backside" >
                                    <div class="card">
                                        <div class="card-body text-center mt-4">

                                            <h4 class="card-title">{{$cat->cat_name}}</h4>

                                            <p class="card-text">{!! $cat->description !!}</p>

                                            <a target="_blank" class="btn btn-primary" style="color: white !important;margin-top: 20px;" href="{{url('products/?_token='.@csrf_token().'&category='.$cat->id)}}">View</a>


                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                @endforeach

                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                            <div class="mainflip">

                                <a href="{{url('our-services')}}">
                                    <div class="frontside">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <p>
                                                    <img class=" img-fluid" src="{{asset('assets/Diensten.jpeg')}}">
                                                </p>

                                                <h4 class="card-title" style="font-weight: 600;padding-top: 30px;font-family: monospace;font-size: 15px;">{{__('text.Services')}}</h4>

                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <div class="backside" >
                                    <div class="card">
                                        <div class="card-body text-center mt-4">

                                            <h4 class="card-title">{{__('text.Services')}}</h4>

                                            <p class="card-text"></p>

                                            <a target="_blank" class="btn btn-primary" style="color: white !important;margin-top: 20px;" href="{{url('our-services')}}">View</a>


                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

            </div>
        </div>
    </div>
    <!-- Ending of All - sectors area -->

    <section id="steps" class="steps steps--en">
        <div class="row row1" style="max-width: 80%;margin-left: auto;margin-right: auto;display: flex;flex-flow: row wrap;">
            <div class="small-12 columns" style="padding-top: 20px;">
                <h2 class="hiw">{{$lang->hiwh}}</h2>

                {{--@if($language == 'eng')

                    <div id="languagePickerContainer">
                        <a class="languageSelector" onclick="changeLanguage(1)" id="dutch" title="dutch">Nederlands</a>
                        <div class="infographic__separator">·</div>
                        <a class="languageSelector languageSelector-selected" title="english" id="english" onclick="changeLanguage(0)">English</a>
                    </div>


                @else

                    <div id="languagePickerContainer">
                        <a class="languageSelector languageSelector-selected" onclick="changeLanguage(1)" id="dutch" title="dutch">Nederlands</a>
                        <div class="infographic__separator">·</div>
                        <a class="languageSelector" title="english" id="english" onclick="changeLanguage(0)">English</a>
                    </div>


                @endif--}}

            </div>
        </div>
        <div class="row steps__items row1" style="max-width: 80%;margin-left: auto;margin-right: auto;display: flex;flex-flow: row wrap;margin-top: 35px;">
            <div class="small-12 medium-6 large-3 columns">
                <div class="step"> <img src="{{asset('assets/images/Profile PNG.png')}}" class="ic-img">
                    <div class="step__header step__header_en @if($language == 'du') hide @endif"> 1. {{$hiw->heading1}}</div>
                    <div class="step__header step__header_de @if($language == 'eng') hide @endif"> 1. {{$hiw->dh1}}</div>
                    <p class="step_description step__description_en ic-p @if($language == 'du') hide @endif"> {{$hiw->desc1}} </p>
                    <p class="step_description step__description_de ic-p @if($language == 'eng') hide @endif"> {{$hiw->dd1}} </p>
                </div>
            </div>
            <div class="small-12 medium-6 large-3 columns">
                <div class="step"> <img src="{{asset('assets/images/Date PNG.png')}}" class="ic-img">
                    <div class="step__header step__header_en @if($language == 'du') hide @endif"> 2. {{$hiw->heading2}}</div>
                    <div class="step__header step__header_de @if($language == 'eng') hide @endif"> 2. {{$hiw->dh2}}</div>
                    <p class="step_description step__description_en ic-p @if($language == 'du') hide @endif"> {{$hiw->desc2}} </p>
                    <p class="step_description step__description_de ic-p @if($language == 'eng') hide @endif"> {{$hiw->dd2}} </p>
                </div>
            </div>
            <div class="small-12 medium-6 large-3 columns">
                <div class="step"> <img src="{{asset('assets/images/Send Reservation PNG.png')}}" class="ic-img">
                    <div class="step__header step__header_en @if($language == 'du') hide @endif"> 3. {{$hiw->heading3}}</div>
                    <div class="step__header step__header_de @if($language == 'eng') hide @endif"> 3. {{$hiw->dh3}}</div>
                    <p class="step_description step__description_en ic-p @if($language == 'du') hide @endif"> {{$hiw->desc3}} </p>
                    <p class="step_description step__description_de ic-p @if($language == 'eng') hide @endif"> {{$hiw->dd3}}  </p>
                </div>
            </div>
            <div class="small-12 medium-6 large-3 columns">
                <div class="step"> <img src="{{asset('assets/images/Warranty.png')}}" class="ic-img">
                    <div class="step__header step__header_en @if($language == 'du') hide @endif"> 4. {{$hiw->heading4}}</div>
                    <div class="step__header step__header_de @if($language == 'eng') hide @endif"> 4. {{$hiw->dh4}}</div>
                    <p class="step_description step__description_en ic-p @if($language == 'du') hide @endif"> {{$hiw->desc4}} </p>
                    <p class="step_description step__description_de ic-p @if($language == 'eng') hide @endif"> {{$hiw->dd4}}  </p>
                </div>
            </div>
            <div class="small-12 medium-6 large-3 columns">
                <div class="step"> <img src="{{asset('assets/images/Location PNG.png')}}" class="ic-img">
                    <div class="step__header step__header_en @if($language == 'du') hide @endif"> 5. {{$hiw->heading5}}</div>
                    <div class="step__header step__header_de @if($language == 'eng') hide @endif"> 5. {{$hiw->dh5}}</div>
                    <p class="step_description step__description_en ic-p @if($language == 'du') hide @endif"> {{$hiw->desc5}} </p>
                    <p class="step_description step__description_de ic-p @if($language == 'eng') hide @endif"> {{$hiw->dd5}}  </p>
                </div>
            </div>
            <div class="small-12 medium-6 large-3 columns">
                <div class="step"> <img src="{{asset('assets/images/Payment PNG.png')}}" class="ic-img">
                    <div class="step__header step__header_en @if($language == 'du') hide @endif"> 6. {{$hiw->heading6}}</div>
                    <div class="step__header step__header_de @if($language == 'eng') hide @endif"> 6. {{$hiw->dh6}}</div>
                    <p class="step_description step__description_en ic-p @if($language == 'du') hide @endif"> {{$hiw->desc6}} </p>
                    <p class="step_description step__description_de ic-p @if($language == 'eng') hide @endif"> {{$hiw->dd6}}  </p>
                </div>
            </div>
        </div>

    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script>

    <div style="margin-top: 50px;" class="container">
        <h2 class="heading" style="text-align: center;">{{__('text.Our Brands')}}</h2>

        <section class="customer-logos slider" style="padding-bottom: 20px;padding-top: 20px;">

            @foreach($brands as $brand)

                <div class="slide"><a target="_blank" href="{{url('products/?_token='.@csrf_token().'&brand='.$brand->id)}}"><img src="{{ asset('assets/images/'.$brand->photo) }}"></a></div>

            @endforeach

        </section>
    </div>

    <!-- Starting of blog area -->
    <div style="padding-top: 0;" class="section-padding blog-area-wrapper wow fadeInUp">

        <section id="usp" class="usp">
            <div class="row row1" style="max-width: 80%;margin-left: auto;margin-right: auto;display: flex;flex-flow: row wrap;margin-top: 35px;">
                <div class="small-12 medium-12 large-12 columns">
                    <h2 class="hiw">{{$lang->rtbh}}</h2>
                </div>
            </div>
            <div class="row usps__row row2" style="max-width: 60%;margin-left: auto;margin-right: auto;display: flex;flex-flow: row wrap;margin-top: 35px;">
                <div class="large-4 medium-8 small-11 columns">
                    <div class="usp__block">
                        <div>
                            <img src="{{asset('assets/images/Marketplace PNG.png')}}" class="ic-img">
                            <p class="usp__block__title step__header_en ic-p @if($language == 'du') hide @endif">{{$rtb->heading1}}</p>
                            <p class="usp__block__title step__header_de ic-p @if($language == 'eng') hide @endif">{{$rtb->dh1}}</p>
                        </div>
                        <span class="step__description_en @if($language == 'du') hide @endif">{{$rtb->desc1}} </span>
                        <span class="step__description_de @if($language == 'eng') hide @endif">{{$rtb->dd1}} </span>
                    </div>
                </div>
                <div class="large-4 medium-8 small-11 columns">
                    <div class="usp__block">
                        <div>
                            <img src="{{asset('assets/images/Payment PNG.png')}}" class="ic-img">
                            <p class="usp__block__title step__header_en ic-p @if($language == 'du') hide @endif">{{$rtb->heading2}}</p>
                            <p class="usp__block__title step__header_de ic-p @if($language == 'eng') hide @endif">{{$rtb->dh2}}</p>
                        </div>
                        <span class="step__description_en @if($language == 'du') hide @endif">{{$rtb->desc2}}</span>
                        <span class="step__description_de @if($language == 'eng') hide @endif">{{$rtb->dd2}}</span>
                    </div>
                </div>
                <div class="large-4 medium-8 small-11 columns">
                    <div class="usp__block">
                        <div>
                            <img src="{{asset('assets/images/Warranty.png')}}" class="ic-img">
                            <p class="usp__block__title step__header_en ic-p @if($language == 'du') hide @endif">{{$rtb->heading3}}</p>
                            <p class="usp__block__title step__header_de ic-p @if($language == 'eng') hide @endif">{{$rtb->dh3}}</p>
                        </div>
                        <span class="step__description_en @if($language == 'du') hide @endif">{{$rtb->desc3}}</span>
                        <span class="step__description_de @if($language == 'eng') hide @endif">{{$rtb->dd3}}</span>
                    </div>
                </div>
            </div>
        </section>

        <style>

            .slick-slide {
                margin: 0px 20px;
            }

            .slick-slide img {

                width: 100%;
            }

            .slick-slider
            {
                position: relative;
                display: block;
                box-sizing: border-box;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                -webkit-touch-callout: none;
                -khtml-user-select: none;
                -ms-touch-action: pan-y;
                touch-action: pan-y;
                -webkit-tap-highlight-color: transparent;
            }

            .slick-list
            {
                position: relative;
                display: block;
                overflow: hidden;
                margin: 0;
                padding: 0;
            }
            .slick-list:focus
            {
                outline: none;
            }
            .slick-list.dragging
            {
                cursor: pointer;
                cursor: hand;
            }

            .slick-slider .slick-track,
            .slick-slider .slick-list
            {
                -webkit-transform: translate3d(0, 0, 0);
                -moz-transform: translate3d(0, 0, 0);
                -ms-transform: translate3d(0, 0, 0);
                -o-transform: translate3d(0, 0, 0);
                transform: translate3d(0, 0, 0);
            }

            .slick-track
            {
                position: relative;
                top: 0;
                left: 0;
                display: block;
                margin: auto;
            }
            .slick-track:before,
            .slick-track:after
            {
                display: table;
                content: '';
            }
            .slick-track:after
            {
                clear: both;
            }
            .slick-loading .slick-track
            {
                visibility: hidden;
            }

            .slick-slide
            {
                display: none;
                float: left;
                position: relative;
                height: 140px;
                min-height: 1px;
            }
            [dir='rtl'] .slick-slide
            {
                float: right;
            }
            .slick-slide img
            {
                display: block;
            }
            .slick-slide.slick-loading img
            {
                display: none;
            }
            .slick-slide.dragging img
            {
                pointer-events: none;
            }
            .slick-initialized .slick-slide
            {
                display: flex;
                flex-direction: column;
                justify-content: center;
            }
            .slick-loading .slick-slide
            {
                visibility: hidden;
            }
            .slick-vertical .slick-slide
            {
                display: block;
                height: auto;
                border: 1px solid transparent;
            }
            .slick-arrow.slick-hidden {
                display: none;
            }

        </style>

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNRJukOohRJ1tW0tMG4tzpDXFz68OnonM&libraries=places&callback=initMap" async defer></script>

        <script type="text/javascript">

            $(document).ready(function(){

                $('.p-btns').click(function(){

                    $('.o-box').hide();
                    $('.cbm-box').show();
                    $('.p-box').show();

                    var id = $(this).data('id');

                    $('.navbar a[href="#step1"]').trigger('click');
                    $('.back').hide();

                    if(id == 1 || id == 2)
                    {
                        $('.quote-category').val('');
                        $(".quote-category").trigger('change.select2');

                        $('.quote-service').removeClass('quote_validation');
                        $('.quote-category').addClass('quote_validation');
                        $('.quote-brand').addClass('quote_validation');
                        $('.quote-model').addClass('quote_validation');

                        $('#step1').children('.well').css('height','300px');
                        $('.quote_delivery').attr("placeholder", "{{__('text.Select Delivery Date')}}");

                        $('.unlinked-boxes').hide();
                        $('.linked-boxes').show();
                    }
                    else
                    {
                        $('.quote-category').val('Diensten');
                        $(".quote-category").trigger('change.select2');

                        $('.linked-boxes').hide();
                        $('.unlinked-boxes').show();

                        $('.quote-service').addClass('quote_validation');
                        $('.quote-category').removeClass('quote_validation');
                        $('.quote-brand').removeClass('quote_validation');
                        $('.quote-model').removeClass('quote_validation');

                        $('#step1').children('.well').css('height','');

                        $('.quote_delivery').attr("placeholder", "{{__('text.Select Installation Date')}}");
                    }

                });

                $('.customer-logos').slick({
                    slidesToShow: 6,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 1500,
                    arrows: false,
                    dots: false,
                    pauseOnHover: false,
                    responsive: [{
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 4
                        }
                    }, {
                        breakpoint: 520,
                        settings: {
                            slidesToShow: 3
                        }
                    }]
                });
            });

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

            $(document).ready(function() {

                $('.topMembers').slick({
                    dots: false,
                    arrows: true,
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    responsive: [
                        {
                            breakpoint: 768,
                            settings: {
                                arrows: true,
                                centerMode: false,
                                centerPadding: '0px',
                                slidesToShow: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                arrows: false,
                                centerMode: true,
                                centerPadding: '40px',
                                slidesToShow: 1
                            }
                        }
                    ],
                    prevArrow: "<button class='slick-arrow slick-prev' data-role='none' type='button' style='display: block;'><svg class='domain-icon css-oee40j' viewBox='0 0 24 24' aria-hidden='true'><path fill='none' stroke='currentColor' stroke-width='2' d='M15 5l-7 7 7 7'></path></svg><span class='css-16q9xmc'>Prev</span></button>",
                    nextArrow: "<button class='slick-arrow slick-next' data-role='none' type='button' style='display: block;'><svg class='domain-icon css-oee40j' viewBox='0 0 24 24' aria-hidden='true'><path fill='none' stroke='currentColor' stroke-width='2' d='M9 5l7 7-7 7'></path></svg><span class='css-16q9xmc'>Next</span></button>"
                });

                function autocomplete(inp, arr, values, categories) {
                    /*the autocomplete function takes two arguments,
                    the text field element and an array of possible autocompleted values:*/
                    var currentFocus;
                    /*execute a function when someone writes in the text field:*/
                    inp.addEventListener("input", function(e) {
                        var a, b, i, val = this.value;
                        /*close any already open lists of autocompleted values*/
                        closeAllLists();
                        if (!val) { return false;}
                        currentFocus = -1;
                        /*create a DIV element that will contain the items (values):*/
                        a = document.createElement("DIV");
                        a.setAttribute("id", this.id + "autocomplete-list");
                        a.setAttribute("class", "autocomplete-items");
                        /*append the DIV element as a child of the autocomplete container:*/
                        this.parentNode.appendChild(a);
                        /*for each item in the array...*/
                        for (i = 0; i < arr.length; i++) {

                            var string = arr[i];
                            string = string.toLowerCase();
                            val = val.toLowerCase();
                            var res = string.includes(val);

                            if (res) {
                                /*create a DIV element for each matching element:*/
                                b = document.createElement("DIV");
                                /*make the matching letters bold:*/
                                /*b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                                b.innerHTML += arr[i].substr(val.length);*/
                                b.innerHTML = arr[i] + ', ' + categories[i];
                                /*insert a input field that will hold the current array item's value:*/
                                b.innerHTML += "<input type='hidden' value='" + arr[i] + "'><input type='hidden' value='" + values[i] + "'>";
                                /*execute a function when someone clicks on the item value (DIV element):*/
                                b.addEventListener("click", function(e) {
                                    /*insert the value for the autocomplete text field:*/
                                    inp.value = this.getElementsByTagName("input")[0].value;

                                    $('.quote-service').removeClass('quote_validation');
                                    $('.quote-category').addClass('quote_validation');
                                    $('.quote-brand').addClass('quote_validation');
                                    $('.quote-model').addClass('quote_validation');

                                    $('#step1').children('.well').css('height','300px');
                                    $('.quote_delivery').attr("placeholder", "{{__('text.Select Delivery Date')}}");

                                    $('.unlinked-boxes').hide();
                                    $('.linked-boxes').show();

                                    var product_id = this.getElementsByTagName("input")[1].value;
                                    var options = '';

                                    $.ajax({
                                        type: "GET",
                                        data: "id=" + product_id,
                                        url: "<?php echo url('/products-by-id')?>",
                                        success: function (data) {

                                            $('.quote-category').val(data.category_id);
                                            $(".quote-category").trigger('change.select2');

                                            var category_id = data.category_id;
                                            var brand_id = data.brand_id;
                                            var model_id = data.model_id;
                                            var options = '';

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

                                                    $.ajax({
                                                        type:"GET",
                                                        data: "id=" + model_id + "&brand_id=" + brand_id + "&cat_id=" + category_id,
                                                        url: "<?php echo url('/products-model-number-by-model')?>",
                                                        success: function(data) {

                                                            $('.quote-model-number').val(data.model_number);

                                                        }
                                                    });

                                                }
                                            });

                                            $('.navbar a[href="#step1"]').trigger('click');

                                            $('.back').hide();

                                        }

                                    });

                                    /*close the list of autocompleted values,
                                    (or any other open lists of autocompleted values:*/
                                    closeAllLists();
                                });
                                a.appendChild(b);
                            }
                        }
                    });
                    /*execute a function presses a key on the keyboard:*/
                    inp.addEventListener("keydown", function(e) {
                        var x = document.getElementById(this.id + "autocomplete-list");
                        if (x) x = x.getElementsByTagName("div");
                        if (e.keyCode == 40) {
                            /*If the arrow DOWN key is pressed,
                            increase the currentFocus variable:*/
                            currentFocus++;
                            /*and and make the current item more visible:*/
                            addActive(x);
                        } else if (e.keyCode == 38) { //up
                            /*If the arrow UP key is pressed,
                            decrease the currentFocus variable:*/
                            currentFocus--;
                            /*and and make the current item more visible:*/
                            addActive(x);
                        } else if (e.keyCode == 13) {
                            /*If the ENTER key is pressed, prevent the form from being submitted,*/
                            e.preventDefault();
                            if (currentFocus > -1) {
                                /*and simulate a click on the "active" item:*/
                                if (x) x[currentFocus].click();
                            }
                        }
                    });
                    function addActive(x) {
                        /*a function to classify an item as "active":*/
                        if (!x) return false;
                        /*start by removing the "active" class on all items:*/
                        removeActive(x);
                        if (currentFocus >= x.length) currentFocus = 0;
                        if (currentFocus < 0) currentFocus = (x.length - 1);
                        /*add class "autocomplete-active":*/
                        x[currentFocus].classList.add("autocomplete-active");
                    }
                    function removeActive(x) {
                        /*a function to remove the "active" class from all autocomplete items:*/
                        for (var i = 0; i < x.length; i++) {
                            x[i].classList.remove("autocomplete-active");
                        }
                    }
                    function closeAllLists(elmnt) {
                        /*close all autocomplete lists in the document,
                        except the one passed as an argument:*/
                        var x = document.getElementsByClassName("autocomplete-items");
                        for (var i = 0; i < x.length; i++) {
                            if (elmnt != x[i] && elmnt != inp) {
                                x[i].parentNode.removeChild(x[i]);
                            }
                        }
                    }
                    /*execute a function when someone clicks in the document:*/
                    document.addEventListener("click", function (e) {
                        closeAllLists(e.target);
                    });
                }

                /*An array containing all the country names in the world:*/
                options = [];
                texts = [];
                categories = [];

                var sel = $(".all-products");
                var length = sel.children('option').length;

                $(".all-products > option").each(function() {
                    if (this.value) options.push(this.value); texts.push(this.text); categories.push(this.getAttribute('data-cat'));
                });

                /*for (var i=0, n=length;i<n;i++) { // looping over the options
                    console.log($('.all-products option:eq(i)').text());
                    if (sel.options[i].value) options.push(sel.options[i].value);
                }

                console.log(options);*/

                autocomplete(document.getElementById("productInput"), texts, options, categories);

            });

            function changeLanguage(id)
            {
                if(id == 1)
                {

                    $('#dutch').addClass('languageSelector-selected');
                    $('#english').removeClass('languageSelector-selected');

                    $('.step__header_en').addClass('hide');
                    $('.step__header_de').removeClass('hide');

                    $('.step__description_en').addClass('hide');
                    $('.step__description_de').removeClass('hide');

                }
                else{

                    $('#english').addClass('languageSelector-selected');
                    $('#dutch').removeClass('languageSelector-selected');

                    $('.step__header_de').addClass('hide');
                    $('.step__header_en').removeClass('hide');


                    $('.step__description_de').addClass('hide');
                    $('.step__description_en').removeClass('hide');

                }
            }

        </script>

        <style type="text/css">

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


            /*.image-flip:hover .backside,
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
            }*/

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


        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <div class="section-title pb_50 text-center">
                        <h2>{{$lang->lns}}</h2>
                        <div class="section-borders">
                            <span></span>
                            <span class="black-border"></span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="owl-carousel blog-area-slider">
                        @foreach($lblogs as $lblog)
                            <a href="{{route('front.blogshow',$lblog->title)}}" class="single-blog-box">

                                <div class="blog-thumb-wrapper">
                                    @if($lblog->photo)
                                        <img src="{{asset('assets/images/'.$lblog->photo)}}" alt="Blog Image">
                                    @else
                                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG" alt="Blog Image">
                                    @endif
                                </div>

                                <div class="blog-text">

                                    <h4 style="height: auto;margin-bottom: 10px;">{{$lblog->title}}</h4>
                                    <p style="height: 120px;text-overflow: ellipsis;display: -webkit-box;width: 100%;visibility: visible;-webkit-line-clamp: 4;-webkit-box-orient: vertical;overflow: hidden;line-height: 2;font-size: 15px;">{{substr(strip_tags($lblog->details),0,250)}}</p>
                                    <span class="boxed-btn blog">{{$lang->vd}}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Ending of blog area -->

    <style>

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

        .select2-selection__clear{

            display: none;
        }

    </style>

    <script type="text/javascript">

        $(document).ready(function() {

            if(window.location.hash) {
                var hash = window.location.hash;
                $(hash).modal('toggle');
            }

        });

    </script>

    <script>

        $(".js-data-example-ajax0").select2({
            width: '100%',
            height: '200px',
            placeholder: "{{__('text.Select Service')}}",
            allowClear: true,
            "language": {
                "noResults": function(){
                    return '{{__('text.No results found')}}';
                }
            },
        });


        $(".js-data-example-ajax10").select2({
            width: '100%',
            height: '200px',
            placeholder: "{{__('text.Select Service')}}",
            allowClear: true,
            dropdownParent: $('#aanvragen'),
            "language": {
                "noResults": function(){
                    return '{{__('text.No results found')}}';
                }
            },
        });


        $(".js-data-example-ajax1").select2({
            width: '100%',
            height: '200px',
            placeholder: "{{__('text.Select Category')}}",
            allowClear: true,
            "language": {
                "noResults": function(){
                    return '{{__('text.No results found')}}';
                }
            },
        });

        $(".js-data-example-ajax3").select2({
            width: '100%',
            height: '200px',
            placeholder: "{{__('text.Select Brand')}}",
            allowClear: true,
            "language": {
                "noResults": function(){
                    return '{{__('text.No results found')}}';
                }
            },
        });

        $(".js-data-example-ajax4").select2({
            width: '100%',
            height: '200px',
            placeholder: "{{__('text.Select Model')}}",
            allowClear: true,
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

    </script>

@endsection
