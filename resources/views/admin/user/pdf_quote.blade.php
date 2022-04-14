@extends('layouts.pdfHead')

@section('content')

        {{--<section class="jumbotron text-center">
            <div class="container">
                <h1 class="jumbotron-heading">{{__('text.Quotation Request')}}</h1>
            </div>
        </section>--}}

        <div class="container" style="width: 100%;">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="row p-5" style="margin-right: 15px !important;">

                                <?php

                                $date = date('d-m-Y',strtotime($quote->created_at));

                                $quote_number = $quote->quote_number;

                                ?>

                                <div class="col-md-12 col-sm-12 col-xs-12">

                                    <img class="img-fluid" src="{{$gs1->site.'assets/images/'.$gs1->logo}}" style="width:50%; height:100%;margin-bottom: 30px;">

                                    <p class="para" style="margin-top: 20px;margin-left: 26px;">{!! $gs1->street !!}</p>

                                    <div style="margin-top: 20px;">

                                        <div style="float: left;">
                                            <p class="para">{{$gs1->site.'assets/images/'.$gs1->logo}} <br> TEL: {{$gs1->phone}}<br>BTW: NL001973883B94<br>IBAN: NL87ABNA0825957680<br>KvK-nummer: 70462623</p>
                                        </div>

                                        <div style="float: right;">

                                            @if($role != 2)

                                                <?php $delivery_address = explode(',', $quote->quote_zipcode); array_pop($delivery_address); array_pop($delivery_address); $delivery_address = implode(",",$delivery_address); ?>

                                                <p class="mb-1 m-rest">{{$quote->quote_name}} {{$quote->quote_familyname}}</p>
                                                <p class="mb-1 m-rest">{{$delivery_address}}</p>
                                                <p class="mb-1 m-rest">{{$quote->quote_city}}</p>

                                            @endif

                                        </div>
                                    </div>

                                    <br><br><br><br><br><br>
                                    <div>
                                        <p style="font-size: 22px;float: left;" class="font-weight-bold mb-4 m-heading">{{__('text.Quotation Request')}} {{$quote_number}}</p>
                                        <p style="float: right;" class="mb-1 m-rest">{{__('text.Created at')}}: {{$date}}</p>
                                    </div>

                                    <?php $quote_delivery_date = date('d-m-Y',strtotime($quote->quote_delivery)); ?>

                                    @if($quote->cat_name != '' && $quote->brand_name != '' && $quote->model_name != '' && $quote->type_title != '' && $quote->color != '')

                                        <br><br>
                                        <p class="mb-1 m-rest">{{__('text.Delivery Date')}}: {{$quote_delivery_date}}</p>

                                    @else

                                        <br><br>
                                        <p class="mb-1 m-rest">{{__('text.Installation Date')}}: {{$quote_delivery_date}}</p>

                                    @endif

                                </div>

                            </div>

                            <hr class="my-5">

                            <div class="row p-5" style="font-size: 15px;padding: 2rem !important;">
                                <div class="col-md-12" style="padding: 0px !important;padding-top: 0px;">


                                    <table class="table" style="border: 1px solid #e5e5e5;">
                                        <thead>
                                        <tr>
                                            @if($quote->cat_name != '' && $quote->brand_name != '' && $quote->model_name != ''  && $quote->type_title != '' && $quote->color != '')

                                                <th class="border-0 text-uppercase small font-weight-bold">{{__('text.Category/Item')}}</th>
                                                <th class="border-0 text-uppercase small font-weight-bold">{{__('text.Brand')}}</th>
                                                <th class="border-0 text-uppercase small font-weight-bold">{{__('text.Model')}}</th>
                                                <th class="border-0 text-uppercase small font-weight-bold">Type</th>
                                                <th class="border-0 text-uppercase small font-weight-bold">{{__('text.Color')}}</th>

                                            @else

                                                <th class="border-0 text-uppercase small font-weight-bold">{{__('text.Service')}}</th>
                                                <th class="border-0 text-uppercase small font-weight-bold">{{__('text.Description')}}</th>

                                            @endif
                                            {{--<th class="border-0 text-uppercase small font-weight-bold">Street</th>
                                            <th class="border-0 text-uppercase small font-weight-bold">House Number</th>--}}
                                        </tr>
                                        </thead>

                                        <tbody>

                                            <tr>
                                                @if($quote->cat_name != '' && $quote->brand_name != '' && $quote->model_name != '')

                                                    <td>{{$quote->cat_name}}</td>
                                                    <td>{{$quote->brand_name}}</td>
                                                    <td>{{$quote->model_name}}</td>
                                                    <td>{{$quote->type_title}}</td>
                                                    <td>{{$quote->color}}</td>

                                                @else

                                                    <td>{{$quote->title}}</td>
                                                    <td>{{$quote->quote_description}}</td>

                                                @endif

                                                {{--<td>{{$quote->quote_street}}</td>
                                                <td>{{$quote->quote_house}}</td>--}}
                                            </tr>

                                        </tbody>
                                    </table>


                                    @if(count($q_a) > 0)

                                        <div style="padding: 10px;">

                                                @foreach($q_a as $key)

                                                    <span style="color: rgba(67,67,67,0.87) !important;">{{$key->question}}: {{$key->answer}}</span>
                                                    <br>

                                                @endforeach

                                        </div>

                                    @endif

                                </div>
                            </div>

                            <style type="text/css">

                                .table td, .table th{
                                    text-align: center;
                                    vertical-align: middle;
                                }

                            </style>


                            <div class="d-flex flex-row-reverse bg-dark text-white p-4" style="background-color: #343a40 !important;display: block !important;margin: 0 !important;">

                                    <table class="table">
                                        <thead>

                                        <tr>
                                            <th class="border-0 text-uppercase small font-weight-bold">{{__('text.Description')}}</th>
                                        </tr>

                                        </thead>

                                        <tbody>

                                        <tr>
                                            <td>{{$quote->quote_description}}</td>
                                        </tr>

                                        </tbody>

                                    </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <style type="text/css">

            @media (max-width: 768px) {

                .inv-rigth{

                    margin-top: 45px;
                }

                .img-fluid{

                    width: 80% !important;
                }

                .para{
                    margin-left: 10px !important;
                }

                .m-heading{
                    text-align: center;
                }

                .m-rest{
                    text-align: center;
                }

                .m2-heading{

                    margin-top: 40px;
                }

            }

            .col-12{

                flex: 0 0 100%;
                max-width: 100%;
            }



            .card {
                position: relative;
                display: flex;
                flex-direction: column;
                min-width: 0;
                word-wrap: break-word;
                background-color: #fff;
                background-clip: border-box;
                border: 1px solid rgba(0,0,0,.125);
                border-radius: .25rem;
            }


            .p-0{

                padding: 0 !important;
            }

            .card-body {

                flex: 1 1 auto;

            }

            .p-5{

                padding: 3rem !important;
            }

            .pb-5, .py-5{

                padding-bottom: 3rem !important;

            }

            .row{

                display: block;
                margin-right: 0px;
                margin-left: 0px;

            }

            .btn-group-vertical>.btn-group:after, .btn-group-vertical>.btn-group:before, .btn-toolbar:after, .btn-toolbar:before, .clearfix:after, .clearfix:before, .container-fluid:after, .container-fluid:before, .container:after, .container:before, .dl-horizontal dd:after, .dl-horizontal dd:before, .form-horizontal .form-group:after, .form-horizontal .form-group:before, .modal-footer:after, .modal-footer:before, .modal-header:after, .modal-header:before, .nav:after, .nav:before, .navbar-collapse:after, .navbar-collapse:before, .navbar-header:after, .navbar-header:before, .navbar:after, .navbar:before, .pager:after, .pager:before, .panel-body:after, .panel-body:before, .row:after, .row:before
            {
                display:  table;
                content: " ";
            }


            .col-md-12{

                flex: 0 0 100%;
                max-width: 100%;
            }


            .font-weight-bold{

                font-weight: 700 !important;
            }

            .mb-1, .my-1{

                margin-bottom: .25rem !important;
                font-size: 15px;
            }

            p{

                margin-top: 0;
                margin-bottom: 1rem;
            }

            .mb-5, .my-5{

                margin-bottom: 3rem !important;

            }

            .mt-5, .my-5{

                margin-top: 3rem !important;
            }

            hr{

                box-sizing: content-box;
                height: 0;
                overflow: visible;
            }

            .mb-4, .my-4{

                margin-bottom: 1.5rem !important;
                font-size: 20px;
            }

            .table{

                margin-bottom: 1rem;
                background-color: transparent;
            }

            .border-0{

                border: 0 !important;
            }

            .table td, .table th{

                padding: 1.75rem !important;
                vertical-align: middle;
                text-align: center;
                border-top: 1px solid #dee2e6;
                min-width: 155px;
                width: 14%;
            }

            .text-white
            {

                color: #fff !important;


            }

            .p-4{

                padding: 1.5rem !important;
            }

            .flex-row-reverse{

                flex-direction: row-reverse !important;
            }

            .d-flex{

                display: flex !important;
            }

            .bg-dark{

                background-color: #343a40 !important;
            }



            .pb-3, .py-3{


                padding-bottom: 1rem !important;
            }



            .mb-2, .my-2{

                margin-bottom: .5rem !important;

            }


            .text-white{

                color: #fff !important;
            }

            .font-weight-light{

                font-weight: 300 !important;
            }

            .h2, h2{

                font-size: 2rem;
            }

            .mb-0, .my-0{

                margin-bottom: 0 !important;
            }

        </style>

@endsection
