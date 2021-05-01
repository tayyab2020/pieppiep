@extends('layouts.pdfHead')

@section('content')

    {{--<section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">@if($type == 'invoice') Quotation Invoice @else Quotation @endif</h1>
        </div>
    </section>--}}

    <div class="container" style="width: 100%;">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="row p-5" style="margin-right: 15px !important;">

                            <div class="col-md-4 col-sm-4 col-xs-12">

                                <img class="img-fluid" src="{{ public_path('assets/images/'.$gs->logo) }}" style="width:50%; height:100%;margin-bottom: 30px;">

                            </div>


                            <div class="col-md-6 col-sm-6 col-xs-12 text-right inv-rigth" style="float: right;">

                                <p class="para" style="margin-top: 20px;margin-left: 26px;">{!! $gs->street  !!}<br>TEL: {{$gs->phone}}<br>BTW: NL001973883B94<br>IBAN: NL87ABNA0825957680<br>KvK-nummer: 70462623</p>

                            </div>
                        </div>

                        <hr style="margin: 0;" class="my-5">

                        @if($type == 'invoice')

                            <div class="row pb-5 p-5" style="margin-right: 15px !important;">

                                <?php
                                $client_address = explode(',', $quote->address); array_pop($client_address); array_pop($client_address); $client_address = implode(",",$client_address);
                                $handyman_address = explode(',', $invoice[0]->address); array_pop($handyman_address); array_pop($handyman_address); $handyman_address = implode(",",$handyman_address);
                                ?>

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <p class="font-weight-bold mb-4 m-heading">{{__('text.Client Information')}}</p>
                                        <p class="mb-1 m-rest">{{$quote->quote_name}} {{$quote->quote_familyname}}</p>
                                        <p class="mb-1 m-rest">{{$client_address}}</p>
                                        <p class="mb-1 m-rest">{{$quote->postcode}} {{$quote->city}}</p>
                                        <p class="mb-1 m-rest">{{$quote->quote_email}}</p>
                                        <p class="mb-1 m-rest">{{$quote->quote_contact}}</p>
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12 text-right m2-heading" style="float: right;">
                                        <p class="font-weight-bold mb-4 m-heading">{{__('text.Handyman Information')}}</p>
                                        <p class="mb-1 m-rest">{{$invoice[0]->company_name}}</p>
                                        <p class="mb-1 m-rest">{{$handyman_address}}</p>
                                        <p class="mb-1 m-rest">{{$invoice[0]->postcode}} {{$invoice[0]->city}}</p>
                                        <p class="mb-1 m-rest">{{$invoice[0]->tax_number}}</p>
                                        <p class="mb-1 m-rest">{{$invoice[0]->registration_number}}</p>
                                    </div>

                            </div>

                        @endif

                        <div class="row pb-5 p-5" style="margin-right: 15px !important;">

                            <?php $date = date('d-m-Y',strtotime($quote->created_at)); $delivery_address = explode(',', $quote->quote_zipcode); array_pop($delivery_address); array_pop($delivery_address); $delivery_address = implode(",",$delivery_address); ?>

                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    {{--<p class="font-weight-bold mb-4 m-heading">Quote Information</p>--}}

                                    @if(!isset($handyman_role))

                                        <p class="font-weight-bold mb-4 m-heading">{{__('text.Delivery Address')}}</p>
                                        <p class="mb-1 m-rest">{{$delivery_address}}</p>
                                        <p class="mb-1 m-rest">{{$quote->quote_postcode}} {{$quote->quote_city}}</p>
                                        <br>

                                    @endif

                                    <div>
                                        <p style="font-size: 22px;float: left;" class="font-weight-bold mb-4 m-heading">@if($type == 'invoice') {{__('text.Quotation Invoice')}} @else {{__('text.Quotation')}} @endif {{$quotation_invoice_number}}</p>
                                        <p style="float: right;" class="mb-1 m-rest">{{__('text.Created at')}}: {{$date}}</p>
                                    </div>
                                    <br><br>
                                    <p class="mb-1 m-rest">{{__('text.Requested Quote Number')}}: {{$requested_quote_number}}</p>

                                    <?php $quote_delivery_date = date('d-m-Y',strtotime($quote->quote_delivery)); ?>

                                    @if($quote->quote_service != 0 && $quote->quote_brand != 0 && $quote->quote_model != 0)

                                        <p class="mb-1 m-rest">{{__('text.Delivery Date')}}: {{$quote_delivery_date}}</p>

                                    @else

                                        <p class="mb-1 m-rest">{{__('text.Installation Date')}}: {{$quote_delivery_date}}</p>

                                    @endif

                                </div>

                        </div>

                        <div class="row p-5" style="font-size: 15px;padding: 2rem !important;">
                            <div class="col-md-12" style="padding: 0px !important;padding-top: 50px;">
                                <table class="table" style="border: 1px solid #e5e5e5;">
                                    <thead>
                                    <tr>
                                        {{--<th class="border-0 text-uppercase small font-weight-bold">{{__('text.Category/Item')}}</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">{{__('text.Brand')}}</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">{{__('text.Model')}}</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">{{__('text.Model Number')}}</th>--}}
                                        <th class="border-0 text-uppercase small font-weight-bold">{{__('text.Title')}}</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">{{__('text.Qty')}}</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">{{__('text.Cost')}}</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">{{__('text.Amount')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @if($type == 'invoice' || $type == 'delivery-address-edit')

                                        @foreach($invoice as $x => $key)

                                            <tr>
                                                {{--<td>{{$key->service}}</td>
                                                <td>{{$key->brand}}</td>
                                                <td>{{$key->model}}</td>
                                                <td>{{(isset($invoice[$x]->b_i_id) && isset($invoice[$x]->m_i_id)) ? ($quote->quote_service == $invoice[$x]->s_i_id && $quote->quote_brand == $invoice[$x]->b_i_id && $quote->quote_model == $invoice[$x]->m_i_id ? $quote->quote_model_number : null) : null}}</td>--}}
                                                <td>{{$key->product_title}}</td>
                                                <td>{{number_format((float)$key->qty, 2, ',', '.')}}</td>
                                                <td>{{number_format((float)$key->rate, 2, ',', '.')}}</td>
                                                <td>{{number_format((float)$key->amount, 2, ',', '.')}}</td>
                                            </tr>

                                        @endforeach

                                    @else

                                        @foreach($request->item as $i => $key)

                                            <tr>
                                                {{--<td>{{$request->service_title[$i]}}</td>
                                                <td>{{$request->brand_title[$i]}}</td>
                                                <td>{{$request->model_title[$i]}}</td>
                                                <td>{{(isset($request->brand[$i]) && isset($request->model[$i])) ? ($quote->quote_service == $request->item[$i] && $quote->quote_brand == $request->brand[$i] && $quote->quote_model == $request->model[$i] ? $quote->quote_model_number : null) : null}}</td>--}}
                                                <td>{{$request->productInput[$i]}}</td>
                                                <td>{{$request->qty[$i]}}</td>
                                                <td>{{$request->cost[$i]}}</td>
                                                <td>{{$request->amount[$i]}}</td>
                                            </tr>

                                        @endforeach

                                    @endif

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if($type == 'invoice' || $type == 'delivery-address-edit')

                            @if($invoice[0]->other_info)

                                <div class="row pb-5 p-5">
                                    <div class="col-md-12 col-sm-12 col-xs-12" style="border: 1px solid #e3e3e3;padding: 20px;">
                                        <p class="font-weight-bold mb-4 m-heading">{{__('text.Description')}}</p>
                                        <p class="mb-1 m-rest">{{$invoice[0]->other_info}}</p>
                                    </div>
                                </div>

                            @endif


                        @else

                            @if($request->other_info)

                                <div class="row pb-5 p-5">
                                    <div class="col-md-12 col-sm-12 col-xs-12" style="border: 1px solid #e3e3e3;padding: 20px;">
                                        <p class="font-weight-bold mb-4 m-heading">{{__('text.Description')}}</p>
                                        <p class="mb-1 m-rest">{{$request->other_info}}</p>
                                    </div>
                                </div>

                            @endif

                        @endif


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
                                    @if($type == 'invoice' || $type == 'delivery-address-edit')
                                        <th class="border-0 text-uppercase small font-weight-bold">{{__('text.VAT')}}({{$invoice[0]->vat_percentage}}%)</th>
                                    @else
                                        <th class="border-0 text-uppercase small font-weight-bold">{{__('text.VAT')}}({{$request->vat_percentage}}%)</th>
                                    @endif
                                    <th class="border-0 text-uppercase small font-weight-bold">{{__('text.Subtotal')}}</th>
                                    <th class="border-0 text-uppercase small font-weight-bold">{{__('text.Grand Total')}}</th>
                                </tr>

                                </thead>

                                <tbody>

                                @if($type == 'invoice' || $type == 'delivery-address-edit')

                                    <tr>
                                        <td>{{number_format((float)$invoice[0]->tax, 2, ',', '.')}}</td>
                                        <td>{{number_format((float)$invoice[0]->sub_total, 2, ',', '.')}}</td>
                                        <td>{{number_format((float)$invoice[0]->grand_total, 2, ',', '.')}}</td>
                                    </tr>

                                @else

                                    <tr>
                                        <td>{{$request->tax_amount}}</td>
                                        <td>{{$request->sub_total}}</td>
                                        <td>{{number_format((float)$request->grand_total, 2, ',', '.')}}</td>
                                    </tr>

                                @endif

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
