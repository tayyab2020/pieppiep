@extends('layouts.client')

@section('content')
    <div class="right-side">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- Starting of Dashboard area -->
                    <div class="section-padding add-product-1" style="padding: 0;">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="add-product-box">
                                    <div class="add-product-header">
                                        <h2>{{__('text.Quote Request')}}</h2>
                                        <a href="{{route('client-quotation-requests')}}" class="btn add-back-btn"><i
                                                    class="fa fa-arrow-left"></i> {{__('text.Back')}}</a>
                                    </div>
                                    <hr>

                                    <div class="form-horizontal">

                                        <?php $quote_number = $request->quote_number; ?>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">{{__('text.Quote Number')}} </label>
                                            <div class="col-sm-6">
                                                <p style="padding: 10px;" class="form-control">{{$quote_number}}</p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">{{__('text.Number of Quotations')}} </label>
                                            <div class="col-sm-6">
                                                <p style="padding: 10px;" class="form-control">{{$request->quotations_count}}</p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">{{__('text.Name')}}* </label>
                                            <div class="col-sm-6">
                                                <p style="padding: 10px;" class="form-control">{{$request->quote_name}}</p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">{{__('text.Family Name')}}* </label>
                                            <div class="col-sm-6">
                                                <p style="padding: 10px;" class="form-control">{{$request->quote_familyname}}</p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">{{__('text.Email')}}* </label>
                                            <div class="col-sm-6">
                                                <p style="padding: 10px;" class="form-control">{{$request->quote_email}}</p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4"
                                                   for="blood_group_slug">{{__('text.Contact')}}* </label>
                                            <div class="col-sm-6">
                                                <p style="padding: 10px;" class="form-control">{{$request->quote_contact}}</p>
                                            </div>
                                        </div>

                                        @if($request->cat_name != '' && $request->brand_name != '' && $request->model_name != '' && $request->type_title != '' && $request->color != '')

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_display_name">{{__('text.Category')}}* </label>
                                                <div class="col-sm-6">
                                                    <p style="padding: 10px;" class="form-control">{{$request->cat_name}}</p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_display_name">{{__('text.Brand')}}* </label>
                                                <div class="col-sm-6">
                                                    <p style="padding: 10px;" class="form-control">{{$request->brand_name}}</p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_display_name">{{__('text.Model')}}* </label>
                                                <div class="col-sm-6">
                                                    <p style="padding: 10px;" class="form-control">{{$request->model_name}}</p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_display_name">Type* </label>
                                                <div class="col-sm-6">
                                                    <p style="padding: 10px;" class="form-control">{{$request->type_title}}</p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_display_name">{{__('text.Color')}}* </label>
                                                <div class="col-sm-6">
                                                    <p style="padding: 10px;" class="form-control">{{$request->color}}</p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">{{__('text.Delivery Date')}}* </label>
                                                <div class="col-sm-6">
                                                    <p style="padding: 10px;" class="form-control">{{$request->quote_delivery ? date('d-m-Y',strtotime($request->quote_delivery)) : null}}</p>
                                                </div>
                                            </div>

                                        @else

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_display_name">{{__('text.Service')}}* </label>
                                                <div class="col-sm-6">
                                                    <p style="padding: 10px;" class="form-control">{{$request->title}}</p>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">{{__('text.Installation Date')}}* </label>
                                                <div class="col-sm-6">
                                                    <p style="padding: 10px;" class="form-control">{{$request->quote_delivery ? date('d-m-Y',strtotime($request->quote_delivery)) : null}}</p>
                                                </div>
                                            </div>

                                        @endif


                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">{{__('text.Quantity')}}* </label>
                                            <div class="col-sm-6">
                                                <p style="padding: 10px;" class="form-control">{{$request->quote_qty}}</p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">{{__('text.Zip Code')}}* </label>
                                            <div class="col-sm-6">
                                                <p style="padding: 10px;" class="form-control">{{$request->quote_zipcode}}</p>
                                            </div>
                                        </div>

                                        {{--<div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">{{__('text.Street Number')}}* </label>
                                            <div class="col-sm-6">
                                                <p style="padding: 10px;" class="form-control">{{$request->quote_street}}</p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">{{__('text.House Number')}}* </label>
                                            <div class="col-sm-6">
                                                <p style="padding: 10px;" class="form-control">{{$request->quote_house}}</p>
                                            </div>
                                        </div>--}}

                                        @foreach($q_a as $key)

                                            <div class="form-group">
                                                <label class="control-label col-sm-4"
                                                       for="blood_group_display_name">{{$key->question}}* </label>
                                                <div class="col-sm-6">
                                                    <p style="padding: 10px;" class="form-control">{{$key->answer}}</p>
                                                </div>
                                            </div>

                                        @endforeach


                                        <div class="form-group">
                                            <label class="control-label col-sm-4"
                                                   for="service_description">{{__('text.Description')}}*</label>
                                            <div class="col-sm-6">
                                                <p class="form-control" style="padding: 10px;">{{$request->quote_description}}</p>
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

                                    </div>
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
