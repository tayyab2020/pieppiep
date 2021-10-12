@extends('layouts.pdfHead')

@section('content')

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

                                <div class="row p-5" style="margin-right: 15px !important;">

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <img class="img-fluid" src="{{ $user->photo ? public_path('assets/images/'.$user->photo) : public_path('assets/images/LOGO-page-001.jpg') }}" style="width:20%;height:100%;margin-bottom: 30px;">
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12 text-right inv-rigth" style="float: right;">
                                        @if($role != 'retailer') <p style="font-size: 22px;" class="font-weight-bold mb-4 m-heading"> OF: {{$quotation_invoice_number}}</p> @endif
                                        <p style="font-size: 22px;" class="font-weight-bold mb-4 m-heading"> @if($role == 'retailer') OF: {{$quotation_invoice_number}} @elseif($role == 'supplier') ORB: {{$order_number}} @elseif($role == 'invoice') FA: {{$order_number}} @else OR: {{$order_number}}@endif</p>
                                    </div>

                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12">

                                    <p style="margin: 0"><b>{{$user->name}} {{$user->family_name}}</b></p>
                                    <p style="margin: 0">{{$user->company_name}}</p>
                                    <p style="margin: 0">{{$address}}</p>
                                    <p style="margin: 0">{{$user->postcode}} {{$user->city}}</p>
                                    <p style="margin: 0">TEL: {{$user->phone}}</p>
                                    <p style="margin: 0">{{$user->email}}</p>

                                </div>

                                <div class="col-md-6 col-sm-6 col-xs-12 text-right inv-rigth" style="float: right;">

                                    <p style="font-size: 22px;" class="font-weight-bold mb-4 m-heading">Customer Details</p>
                                    <p class="mb-1 m-rest">{{$client->name}} {{$client->family_name}}</p>
                                    <p class="mb-1 m-rest">{{$client_address}}</p>
                                    <p class="mb-1 m-rest">{{$client->postcode}} {{$client->city}}</p>
                                    <p class="mb-1 m-rest">{{$client->email}}</p>
                                    <br>
                                    <p class="text-muted" style="font-size: 15px;margin-top: 40px;margin-bottom: 0;">{{__('text.Created at')}} {{$date}}</p>
                                    <p class="text-muted" style="font-size: 15px;margin: 0;">Client ID {{sprintf('%04u', $client->id)}}</p>

                                </div>

                        </div>

                        {{--<hr class="my-5">--}}

                        @foreach($request->products as $i => $key)

                            <div class="row p-5" style="font-size: 15px;padding: 2rem !important;border-bottom: 2px solid black !important;">
                                <div class="col-md-12" style="padding: 0 !important;">

                                    <table class="table table1">

                                        <tbody>

                                        <?php $cols = array_chunk($feature_sub_titles[$i], 3); ?>

                                        <tr>
                                            <td style="border: 0 !important;"><p class="text-muted" style="font-size: 20px;width: auto !important;padding: 10px !important;font-weight: bold;">{{$product_titles[$i]}}</p></td>
                                        </tr>

                                        <tr>
                                            <td style="border-bottom: 1px solid #dee2e6;">{{__('text.Color Number')}}: {{$color_titles[$i]}}</td>
                                            <td style="border-bottom: 1px solid #dee2e6;">{{__('text.Width')}}: {{$request->width[$i]}} {{$request->width_unit[$i]}}</td>
                                            <td style="border-bottom: 1px solid #dee2e6;">{{__('text.Height')}}: {{$request->height[$i]}} {{$request->height_unit[$i]}}</td>
                                        </tr>

                                        @foreach($cols as $f => $col)

                                            <tr>

                                                @foreach($col as $feature)

                                                    @if($role == 'retailer')

                                                        <?php

                                                        $childsafe_answer = 'childsafe_answer'.$request->row_id[$i]; $childsafe_answer = $request->$childsafe_answer ? ($request->$childsafe_answer == 1 || $request->$childsafe_answer == 3 ? 'Is childsafe'.'<br>' : 'Not childsafe'.'<br>') : null;

                                                        if($childsafe_answer)
                                                        {
                                                            $string = 'Childsafe: ' . $childsafe_answer;
                                                        }
                                                        elseif(!$feature)
                                                        {
                                                            if(isset($sub_titles[$i]->code))
                                                            {
                                                                $string = 'Ladderband: ' . $sub_titles[$i]->code . ', ' . $sub_titles[$i]->size;
                                                            }
                                                            else
                                                            {
                                                                $string = 'Ladderband: No';
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $comment = 'comment-'.$request->row_id[$i].'-'.$feature->f_id;
                                                            $comment = $request->$comment ? ', '.$request->$comment : null;
                                                            $string = $feature->main_title.": ".preg_replace("/\([^)]+\)/","",$feature->title).$comment;
                                                            /*$string = substr($string, 4);*/
                                                        }

                                                        ?>

                                                    @else

                                                        <?php

                                                        $childsafe_answer = $key->childsafe_answer != 0 ? ($key->childsafe_answer == 1 || $key->childsafe_answer == 3 ? 'Is childsafe'.'<br>' : 'Not childsafe'.'<br>') : null;

                                                        if($childsafe_answer)
                                                        {
                                                            $string = 'Childsafe: ' . $childsafe_answer;
                                                        }
                                                        elseif(!$feature)
                                                        {
                                                            if(isset($sub_titles[$i]->code))
                                                            {
                                                                $string = 'Ladderband: ' . $sub_titles[$i]->code . ', ' . $sub_titles[$i]->size;
                                                            }
                                                            else
                                                            {
                                                                $string = 'Ladderband: No';
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $comment = $comments[$i][$f-1] ? ', '.$comments[$i][$f-1] : null;
                                                            $string = $feature->main_title.": ".preg_replace("/\([^)]+\)/","",$feature->title).$comment;
                                                            /*$string = substr($string, 4);*/
                                                        }

                                                        ?>

                                                    @endif

                                                    <td style="border-bottom: 1px solid #dee2e6;">{!! $string !!}</td>

                                                @endforeach

                                            </tr>

                                        @endforeach

                                        </tbody>
                                    </table>

                                    <table style="display: table;width: 100%;">

                                        <thead>
                                        <tr>
                                            <th style="width: 60% !important;font-size: 22px;font-weight: 500;">Product</th>
                                            <th style="width: 10% !important;font-size: 22px;">{{__('text.Qty')}}</th>
                                            <th style="width: 15% !important;font-size: 22px;text-align: center;font-weight: 500;">Prijs</th>
                                            <th style="width: 15% !important;font-size: 22px;text-align: center;font-weight: 500;">Totaal</th>
                                        </tr>
                                        </thead>

                                        <tbody>

                                        <tr>
                                            <td style="font-size: 20px;padding: 5px;">{{$product_titles[$i] . ', ' . $model_titles[$i] . ', ' . $color_titles[$i] . ', afm. ' . $request->width[$i] . $request->width_unit[$i] . 'x' . $request->height[$i] . $request->height_unit[$i] . ' bxh'}}</td>
                                            <td style="font-size: 20px;padding: 5px;">{{$request->qty[$i]}}</td>
                                            <td style="font-size: 20px;padding: 5px;text-align: center;">{{str_replace('.', ',',$request->total[$i])}}</td>
                                            <td style="font-size: 20px;padding: 5px;text-align: center;">{{number_format((float)($request->rate[$i] - str_replace(',', '.',$request->labor_impact[$i])), 2, ',', '.')}}</td>
                                        </tr>

                                        <?php
                                        $arb_qty = (str_replace(',', '.',$request->width[$i])/100) * $request->qty[$i];
                                        $arb_price = str_replace(',', '.',$request->labor_impact[$i]) / $arb_qty;
                                        $arb_price = number_format((float)($arb_price), 2, ',', '.');
                                        $arb_qty = str_replace('.', ',',$arb_qty);
                                        ?>

                                        <tr>
                                            <td style="font-size: 20px;padding: 5px;">Inclusief € {{str_replace(',', '.',abs($request->total_discount[$i]))}} korting <br> Installatie {{$product_titles[$i]}} per meter</td>
                                            <td style="font-size: 20px;padding: 5px;">{{$arb_qty}}</td>
                                            <td style="font-size: 20px;padding: 5px;text-align: center;">{{$arb_price}}</td>
                                            <td style="font-size: 20px;padding: 5px;text-align: center;">{{$request->labor_impact[$i]}}</td>
                                        </tr>

                                        </tbody>

                                    </table>

                                    <table style="display: table;width: 100%;margin-top: 30px;">

                                        <thead>
                                        <tr>
                                            <th style="width: 20% !important;font-size: 22px;">Totaal korting</th>
                                            <th style="width: 20% !important;font-size: 22px;font-weight: 500;text-align: center;">Exclusief BTW</th>
                                            <th style="width: 25% !important;font-size: 22px;text-align: center;font-weight: 500;">BTW</th>
                                            <th style="width: 35% !important;font-size: 22px;">Te betalen</th>
                                        </tr>
                                        </thead>

                                        <tbody>

                                        <tr>
                                            <?php
                                            $ex_vat = ($request->rate[$i]/121)*100;
                                            $vat = $request->rate[$i] - $ex_vat;
                                            $vat = number_format((float)($vat), 2, ',', '.');
                                            $ex_vat = number_format((float)($ex_vat), 2, ',', '.');
                                            ?>
                                            <td style="font-size: 20px;padding: 5px;">€ {{str_replace(',', '.',abs($request->total_discount[$i]))}}</td>
                                            <td style="font-size: 20px;padding: 5px;text-align: center;">€ {{$ex_vat}}</td>
                                            <td style="font-size: 20px;padding: 5px;text-align: center;">€ {{$vat}}</td>
                                            <td style="font-size: 20px;padding: 5px;text-align: right;">€ {{str_replace('.', ',',$request->rate[$i])}}</td>
                                        </tr>

                                        </tbody>

                                    </table>

                                </div>
                            </div>

                        @endforeach

                        <div class="row p-5" style="padding: 2rem !important;">
                            <div class="col-md-12" style="padding: 0 !important;">

                                <table style="display: table;width: 100%;margin-top: 30px;">

                                    <tbody>

                                    <tr>
                                        <td style="width: 40%;padding: 5px;">
                                            <div style="display: inline-block;width: 100%;">
                                                <span style="width: 50% !important;display: inline-block;text-align: left;font-size: 20px;font-weight: 500;">Invoer:</span>
                                                <span style="width: 50% !important;display: inline-block;text-align: right;font-size: 18px;">{{$date}}</span>
                                            </div>
                                        </td>
                                        <td style="width: 60%;padding: 5px;padding-left: 20px;">
                                            <div style="display: inline-block;width: 100%;">
                                                <span style="width: 50% !important;display: inline-block;text-align: left;font-size: 20px;font-weight: 500;">TOTAALPRIJS EX. BTW</span>
                                                <span style="width: 50% !important;display: inline-block;text-align: right;font-size: 18px;">€ {{str_replace('.', ',',($request->net_amount))}}</span>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="width: 40%;padding: 5px;">
                                            <div style="display: inline-block;width: 100%;">
                                                <span style="width: 50% !important;display: inline-block;text-align: left;font-size: 20px;font-weight: 500;">Planning verzending:</span>
                                                <span style="width: 50% !important;display: inline-block;text-align: right;font-size: 18px;">@if($role == 'supplier' || $role == 'invoice') {{$request->delivery_date[$i]}} @endif</span>
                                            </div>
                                        </td>
                                        <td style="width: 60%;padding: 5px;padding-left: 20px;">
                                            <div style="display: inline-block;width: 100%;">
                                                <span style="width: 50% !important;display: inline-block;text-align: left;font-size: 20px;font-weight: 500;">BTW 21% over € {{str_replace('.', ',',($request->net_amount))}}</span>
                                                <span style="width: 50% !important;display: inline-block;text-align: right;font-size: 18px;">€ {{str_replace('.', ',',($request->tax_amount))}}</span>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="width: 40%;font-size: 20px;padding: 5px;"></td>
                                        <td style="width: 60%;font-size: 20px;padding: 5px;padding-left: 20px;">
                                            <div style="display: inline-block;width: 100%;">
                                                <span style="width: 50% !important;display: inline-block;text-align: left;font-size: 20px;font-weight: 500;">Totaal incl btw</span>
                                                <span style="width: 50% !important;display: inline-block;text-align: right;font-size: 18px;">€ {{str_replace('.', ',',($request->total_amount))}}</span>
                                            </div>
                                        </td>
                                    </tr>

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

                        {{--@if($role == 'retailer' || $role == 'invoice')

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

                        @endif--}}

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

        .table1 tbody tr:first-child td
        {
            border-top: 0 !important;
        }

        .table1 th
        {
            border-bottom: 1px solid #dee2e6 !important;
        }

        .table td, .table th{
            padding: 1.75rem !important;
            vertical-align: middle;
            text-align: center;
            border-top: 1px solid #dee2e6;
        }

        .text-white
        {
            color: #fff !important;
        }

        .p-4
        {
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

        .pb-3, .py-3
        {
            padding-bottom: 1rem !important;
        }

        .mb-2, .my-2
        {
            margin-bottom: .5rem !important;
        }


        .text-white
        {
            color: #fff !important;
        }

        .font-weight-light
        {
            font-weight: 300 !important;
        }

        .h2, h2
        {
            font-size: 2rem;
        }

        .mb-0, .my-0
        {
            margin-bottom: 0 !important;
        }

    </style>

@endsection
