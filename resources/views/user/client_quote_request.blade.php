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

    <script type="text/javascript" src="{{asset('assets/admin/js/nicEdit.js')}}"></script>
    <script type="text/javascript">
        //<![CDATA[
        bkLib.onDomLoaded(function () {
            nicEditors.allTextAreas()
        });
        //]]>
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
