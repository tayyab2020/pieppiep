@extends('layouts.pdfHead')

@section('content')

    {{--<section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">@if($type == 'invoice') {{__('text.Quotation Invoice')}} @elseif($type == 'direct-invoice') {{__('text.Direct Invoice')}} @else {{__('text.Quotation')}} @endif</h1>
        </div>
    </section>--}}

    <div class="container" style="width: 100%;">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="row p-5" style="margin-right: 15px !important;">

                            <?php
                            $address = explode(',', $user->address); array_pop($address); array_pop($address); $address = implode(",",$address);
                            $client_address = explode(',', $client->address); array_pop($client_address); array_pop($client_address); $client_address = implode(",",$client_address);
                            $date = date('d-m-Y',strtotime($date));
                            ?>

                                <div class="col-md-4 col-sm-4 col-xs-12">

                                    <p style="margin: 0"><b>{{$user->name}} {{$user->family_name}}</b></p>
                                    <p style="margin: 0">{{$user->company_name}}</p>
                                    <p style="margin: 0">{{$address}}</p>
                                    <p style="margin: 0">{{$user->postcode}} {{$user->city}}</p>
                                    <p style="margin: 0">TEL: {{$user->phone}}</p>
                                    <p style="margin: 0">{{$user->email}}</p>
                                    <br>
                                    <p style="font-size: 22px;" class="font-weight-bold mb-4 m-heading"> {{__('text.Quotation')}} {{$quotation_invoice_number}}</p>
                                    <p class="text-muted" style="font-size: 15px;margin-top: 10px;">{{__('text.Created at')}}: {{$date}}</p>

                                </div>

                                <div style="text-align: center;" class="col-md-4 col-sm-4 col-xs-12">

                                    <img class="img-fluid" src="{{ $user->photo ? public_path('assets/images/'.$user->photo) : public_path('assets/images/LOGO-page-001.jpg') }}" style="width:20%;height:100%;margin-bottom: 30px;">

                                </div>

                                <div class="col-md-4 col-sm-4 col-xs-12 text-right inv-rigth" style="float: right;">

                                    <p class="mb-1 m-rest">{{$client->name}} {{$client->family_name}}</p>
                                    <p class="mb-1 m-rest">{{$client_address}}</p>
                                    <p class="mb-1 m-rest">{{$client->postcode}} {{$client->city}}</p>
                                    <p class="mb-1 m-rest">{{$client->email}}</p>

                                </div>
                        </div>

                        {{--<hr class="my-5">--}}

                        <div class="row p-5" style="font-size: 15px;padding: 2rem !important;">
                            <div class="col-md-12" style="padding: 0 !important;">
                                <table class="table" style="border: 1px solid #e5e5e5;">
                                    <thead>
                                    <tr>
                                        <th class="border-0 text-uppercase small font-weight-bold">{{__('text.Qty')}}</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Product</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Kleur - nummer</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Breedte</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Hoogte</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Montage hoogte</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Type/uitvoering</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Bediening-zijde</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">kleur ladderband</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Pakket zijde</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Montage idd/odd</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Kleur systeem</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">{{__('text.Amount')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($request->products as $i => $key)

                                        <tr>
                                            <td>{{$request->qty[$i]}}</td>
                                            <td>{{$product_titles[$i]}}</td>
                                            <td>{{$color_titles[$i]}}</td>
                                            <td>{{$request->width[$i]}} {{$request->width_unit[$i]}}</td>
                                            <td>{{$request->height[$i]}} {{$request->height_unit[$i]}}</td>
                                            <td><?php $string = ''; foreach($feature_sub_titles[$i] as $feature){ if($feature && $feature != 'empty'){ if($feature->order_no == 0){ $string .= ",".preg_replace("/\([^)]+\)/","",$feature->title); } } } ?> {{$string = substr($string, 1)}}</td>
                                            <td><?php $string = ''; foreach($feature_sub_titles[$i] as $feature){ if($feature && $feature != 'empty'){ if($feature->order_no == 1){ $string .= ",".preg_replace("/\([^)]+\)/","",$feature->title); } } } ?> {{$string = substr($string, 1)}}</td>
                                            <td><?php $string = ''; foreach($feature_sub_titles[$i] as $feature){ if($feature && $feature != 'empty'){ if($feature->order_no == 2){ $string .= ",".preg_replace("/\([^)]+\)/","",$feature->title); } } } ?> {{$string = substr($string, 1)}}</td>
                                            <td><?php $string = ''; foreach($feature_sub_titles[$i] as $feature){ if(!$feature){ if(isset($sub_titles[$i]->code)){ $string = $sub_titles[$i]->code . '<br>' . $sub_titles[$i]->size; } } } ?> {!! $string !!}</td>
                                            <td><?php $string = ''; foreach($feature_sub_titles[$i] as $feature){ if($feature && $feature != 'empty'){ if($feature->order_no == 4){ $string .= ",".preg_replace("/\([^)]+\)/","",$feature->title); } } } ?> {{$string = substr($string, 1)}}</td>
                                            <td><?php $string = ''; foreach($feature_sub_titles[$i] as $feature){ if($feature && $feature != 'empty'){ if($feature->order_no == 5){ $string .= ",".preg_replace("/\([^)]+\)/","",$feature->title); } } } ?> {{$string = substr($string, 1)}}</td>
                                            <td><?php $string = ''; foreach($feature_sub_titles[$i] as $feature){ if($feature && $feature != 'empty'){ if($feature->order_no == 6){ $string .= ",".preg_replace("/\([^)]+\)/","",$feature->title); } } } ?> {{$string = substr($string, 1)}}</td>
                                            <td>{{$request->total[$i]}}</td>
                                        </tr>

                                    @endforeach

                                    </tbody>
                                </table>
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
                                    <th class="border-0 text-uppercase small font-weight-bold">{{__('text.Subtotal')}}</th>
                                    <th class="border-0 text-uppercase small font-weight-bold">{{__('text.Grand Total')}}</th>
                                </tr>

                                </thead>

                                <tbody>

                                <tr>
                                    <td>{{$request->total_amount}}</td>
                                    <td>{{$request->total_amount}}</td>
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
