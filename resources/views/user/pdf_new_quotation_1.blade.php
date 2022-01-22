<!DOCTYPE html>
<html lang="en">

<head>
</head>

<body>
<div class="dashboard-wrapper">
    <div class="container" style="width: 100%;">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="row p-5">

                            <?php
                            $address = explode(',', $user->address); array_pop($address); array_pop($address); $address = implode(",",$address);
                            $client_address = explode(',', $client->address); array_pop($client_address); array_pop($client_address); $client_address = implode(",",$client_address);
                            $date = date('d-m-Y',strtotime($date));
                            ?>

                                <div class="row p-5">

                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <img class="img-fluid" src="{{ $user->compressed_photo ? public_path('assets/images/'.$user->compressed_photo) : public_path('assets/images/LOGO-page-001.jpg') }}" style="width:40%;height:100%;margin-bottom: 30px;">
                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12 text-right inv-rigth" style="float: right;">
                                        {{--<p style="margin: 0"><b>{{$user->name}} {{$user->family_name}}</b></p>--}}
                                        <p style="margin: 0">{{$user->company_name}}</p>
                                        <p style="margin: 0">{{$address}}</p>
                                        <p style="margin: 0">{{$user->postcode}} {{$user->city}}</p>
                                        <p style="margin: 0">TEL: {{$user->phone}}</p>
                                        <p style="margin: 0">{{$user->email}}</p>
                                    </div>

                                </div>

                                <div class="row p-5">

                                    <div class="col-md-6 col-sm-6 col-xs-12">

                                    <p style="font-size: 22px;" class="font-weight-bold mb-4 m-heading">Customer Details</p>
                                    <p style="font-size: 18px;" class="mb-1 m-rest">{{$client->name}} {{$client->family_name}}</p>
                                    <p style="font-size: 18px;" class="mb-1 m-rest">{{$client_address}}</p>
                                    <p style="font-size: 18px;" class="mb-1 m-rest">{{$client->postcode}} {{$client->city}}</p>
                                    <p style="font-size: 18px;" class="mb-1 m-rest">{{$client->email}}</p>
                                    <br>
                                    <br>
                                    @if($role != 'retailer') <p style="font-size: 22px;" class="font-weight-bold mb-4 m-heading"> OF: {{$quotation_invoice_number}}</p> @endif
                                    <p style="font-size: 22px;" class="font-weight-bold mb-4 m-heading"> @if($role == 'retailer') OF: {{$quotation_invoice_number}} @elseif($role == 'supplier') ORB: {{$order_number}} @elseif($role == 'invoice') FA: {{$order_number}} @else OR: {{$order_number}}@endif</p>

                                    </div>

                                    <div class="col-md-6 col-sm-6 col-xs-12 text-right inv-rigth" style="float: right;">
                                        <br><br><br><br><br>
                                        <p class="text-muted" style="font-size: 15px;margin-top: 40px;margin-bottom: 0;">{{__('text.Created at')}} {{$date}}</p>
                                        {{--<p class="text-muted" style="font-size: 15px;margin: 0;">Client ID {{sprintf('%04u', $client->id)}}</p>--}}
                                    </div>

                                </div>

                        </div>

                        {{--<hr class="my-5">--}}

                        @foreach($request->products as $i => $key)

                            <div class="row p-5" style="font-size: 15px;padding: 2rem !important;border-bottom: 2px solid black !important;">
                                <div class="col-md-12" style="padding: 0 !important;">

                                    <?php
                                    $arb_qty = $request->width[$i] == 0 ? 0 : (str_replace(',', '.',$request->width[$i])/100) * $request->qty[$i];
                                    $arb_price = $request->labor_impact[$i] == 0 ? 0 : str_replace(',', '.',$request->labor_impact[$i]) / $arb_qty;
                                    $arb_price = number_format((float)($arb_price), 2, ',', '.');
                                    $arb_qty = number_format((float)($arb_qty), 2, ',', '.');
                                    $arb_discount = str_replace(',', '.',$request->price_before_labor[$i]) * ($request->discount[$i] == 0 ? 0 : $request->discount[$i]/100);
                                    $arb = $request->rate[$i] - $arb_discount;
                                    $arb = number_format((float)($arb), 2, ',', '.');
                                    $arb_discount = number_format((float)($arb_discount), 2, ',', '.');
                                    $art_labor_discount = str_replace(',', '.',$request->labor_impact[$i]) * ($request->labor_discount[$i] == 0 ? 0 : $request->labor_discount[$i]/100);
                                    $art = str_replace(',', '.',$request->labor_impact[$i]) - $art_labor_discount;
                                    $art = number_format((float)($art), 2, ',', '.');
                                    $art_labor_discount = number_format((float)($art_labor_discount), 2, ',', '.');
                                    ?>

                                    <table style="display: table;width: 100%;">

                                        <thead>
                                        <tr>
                                            <th style="width: 60% !important;font-size: 20px;font-weight: 500;">Product</th>
                                            <th style="width: 10% !important;font-size: 20px;font-weight: 500;">{{__('text.Qty')}}</th>
                                            <th style="width: 15% !important;font-size: 20px;text-align: center;font-weight: 500;">Prijs</th>
                                            <th style="width: 15% !important;font-size: 20px;text-align: center;font-weight: 500;">Totaal</th>
                                        </tr>
                                        </thead>

                                        <tbody>

                                        <tr>
                                            <td style="font-size: 20px;padding: 5px;">{{$product_titles[$i] . ', ' . $model_titles[$i] . ', ' . $color_titles[$i] . ', afm. ' . $request->width[$i] . $request->width_unit[$i] . 'x' . $request->height[$i] . $request->height_unit[$i] . ' bxh'}}</td>
                                            <td style="font-size: 20px;padding: 5px;">{{$request->qty[$i]}}</td>
                                            <td style="font-size: 20px;padding: 5px;text-align: center;">{{number_format((float)($request->total[$i]), 2, ',', '.')}}</td>
                                            <td style="font-size: 20px;padding: 5px;text-align: center;">{{$arb}}</td>
                                        </tr>

                                        @if($arb_discount != 0)

                                            <tr>
                                                <td style="font-size: 20px;padding: 5px;">Inclusief € {{$arb_discount}} korting</td>
                                                <td style="font-size: 20px;padding: 5px;"></td>
                                                <td style="font-size: 20px;padding: 5px;text-align: center;"></td>
                                                <td style="font-size: 20px;padding: 5px;text-align: center;"></td>
                                            </tr>

                                        @endif

                                        <tr>
                                            <td style="font-size: 20px;padding: 5px;">Installatie {{$product_titles[$i]}} per meter</td>
                                            <td style="font-size: 20px;padding: 5px;">{{$arb_qty}}</td>
                                            <td style="font-size: 20px;padding: 5px;text-align: center;">{{$arb_price}}</td>
                                            <td style="font-size: 20px;padding: 5px;text-align: center;">{{$art}}</td>
                                        </tr>

                                        @if($art_labor_discount != 0)

                                            <tr>
                                                <td style="font-size: 20px;padding: 5px;">Inclusief € {{$art_labor_discount}} korting</td>
                                                <td style="font-size: 20px;padding: 5px;"></td>
                                                <td style="font-size: 20px;padding: 5px;text-align: center;"></td>
                                                <td style="font-size: 20px;padding: 5px;text-align: center;"></td>
                                            </tr>

                                        @endif

                                        </tbody>

                                    </table>

                                    <table class="table table1">

                                        <tbody>

                                        <?php

                                        if($role == 'retailer') {

                                            $childsafe_answer = 'childsafe_answer'.$request->row_id[$i]; $childsafe_answer = $request->$childsafe_answer ? ($request->$childsafe_answer == 1 || $request->$childsafe_answer == 3 ? 'Is childsafe'.'<br>' : 'Not childsafe'.'<br>') : null;

                                        }
                                        else {

                                            $childsafe_answer = $key->childsafe_answer != 0 ? ($key->childsafe_answer == 1 || $key->childsafe_answer == 3 ? 'Is childsafe'.'<br>' : 'Not childsafe'.'<br>') : null;

                                        }

                                        if($childsafe_answer)
                                        {
                                            $data = array (
                                                'childsafe' => 1,
                                                'childsafe_answer' => $childsafe_answer,
                                            );
                                            array_push($feature_sub_titles[$i],$data);
                                        }

                                        $cols = array_chunk($feature_sub_titles[$i], 3);
                                        ?>

                                        <!--<tr>
                                            <td style="border: 0 !important;"><p class="text-muted" style="font-size: 20px;width: auto !important;padding: 10px !important;font-weight: bold;">{{$product_titles[$i]}}</p></td>
                                        </tr>

                                        <tr>
                                            <td style="text-align: left !important;">{{__('text.Color Number')}}: {{$color_titles[$i]}}</td>
                                            <td style="text-align: left !important;">{{__('text.Width')}}: {{$request->width[$i]}} {{$request->width_unit[$i]}}</td>
                                            <td style="text-align: left !important;">{{__('text.Height')}}: {{$request->height[$i]}} {{$request->height_unit[$i]}}</td>
                                        </tr>-->

                                        <?php $d = 1; ?>

                                        @foreach($cols as $f => $col)

                                            <tr>

                                                @foreach($col as $x => $feature)

                                                    @if($role == 'retailer')

                                                        <?php

                                                        if(!$feature)
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
                                                            if($feature['childsafe'])
                                                            {
                                                                $string = 'Childsafe: ' . $feature['childsafe_answer'];
                                                            }
                                                            else {
                                                                $comment = 'comment-'.$request->row_id[$i].'-'.$feature->f_id;
                                                                $comment = $request->$comment ? ', '.$request->$comment : null;
                                                                $string = $feature->main_title.": ".preg_replace("/\([^)]+\)/","",$feature->title).$comment;
                                                                /*$string = substr($string, 4);*/
                                                            }
                                                        }

                                                        ?>

                                                    @else

                                                        <?php

                                                        if(!$feature)
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
                                                            if($feature['childsafe'])
                                                            {
                                                                $string = 'Childsafe: ' . $feature['childsafe_answer'];
                                                            }
                                                            else {

                                                                $comment = $comments[$i][$d-1] ? ', '.$comments[$i][$d-1] : null;
                                                                $string = $feature->main_title.": ".preg_replace("/\([^)]+\)/","",$feature->title).$comment;
                                                                /*$string = substr($string, 4);*/

                                                            }
                                                        }

                                                        ?>

                                                    @endif

                                                    <td style="text-align: left !important;">{!! $string !!}</td>

                                                        @if(count($feature_sub_titles[$i]) == $d)

                                                            <?php $rem = 3 - ($x+1); ?>

                                                        @else

                                                            <?php $rem = 0; ?>

                                                        @endif

                                                        @for($p = 0;$p < $rem;$p++)

                                                            <td></td>

                                                        @endfor

                                                        <?php $d = $d + 1; ?>

                                                @endforeach

                                            </tr>

                                        @endforeach

                                        </tbody>
                                    </table>

                                    <table style="display: table;width: 100%;margin-top: 30px;">

                                        <thead>
                                        <tr>
                                            <th style="width: 20% !important;font-size: 20px;">Totaal korting</th>
                                            <th style="width: 20% !important;font-size: 20px;font-weight: 500;text-align: center;">Exclusief BTW</th>
                                            <th style="width: 25% !important;font-size: 20px;text-align: center;font-weight: 500;">BTW</th>
                                            <th style="width: 35% !important;font-size: 20px;text-align: right;">Bedrag inc. btw</th>
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
                                            <td style="font-size: 20px;padding: 5px;">€ {{str_replace('-', '',number_format((float)(str_replace(',', '.',$request->total_discount[$i])), 2, ',', '.'))}}</td>
                                            <td style="font-size: 20px;padding: 5px;text-align: center;">€ {{$ex_vat}}</td>
                                            <td style="font-size: 20px;padding: 5px;text-align: center;">€ {{$vat}}</td>
                                            <td style="font-size: 20px;padding: 5px;text-align: right;">€ {{number_format((float)($request->rate[$i]), 2, ',', '.')}}</td>
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
                                                <span style="width: 50% !important;display: inline-block;text-align: right;font-size: 18px;">€ {{number_format((float)(str_replace(',', '.',$request->net_amount)), 2, ',', '.')}}</span>
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
                                                <span style="width: 50% !important;display: inline-block;text-align: left;font-size: 20px;font-weight: 500;">BTW 21% over € {{number_format((float)(str_replace(',', '.',$request->net_amount)), 2, ',', '.')}}</span>
                                                <span style="width: 50% !important;display: inline-block;text-align: right;font-size: 18px;">€ {{number_format((float)(str_replace(',', '.',$request->tax_amount)), 2, ',', '.')}}</span>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="width: 40%;font-size: 20px;padding: 5px;"></td>
                                        <td style="width: 60%;font-size: 20px;padding: 5px;padding-left: 20px;">
                                            <div style="display: inline-block;width: 100%;">
                                                <span style="width: 50% !important;display: inline-block;text-align: left;font-size: 20px;font-weight: 500;">Te betalen</span>
                                                <span style="width: 50% !important;display: inline-block;text-align: right;font-size: 18px;">€ {{number_format((float)(str_replace(',', '.',$request->total_amount)), 2, ',', '.')}}</span>
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

                    </div>
                </div>
            </div>
        </div>
    </div>


    <style type="text/css">

        body
        {
            background-color: #ffffff;
            font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
            font-size: 14px;
            line-height: 1.42857143;
            color: #333;
            margin: 0;
            display: block;
        }

        *
        {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        html
        {
            font-size: 10px;
            -webkit-tap-highlight-color: rgba(0,0,0,0);
            font-family: sans-serif;
            -webkit-text-size-adjust: 100%;
        }

        :after, :before
        {
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        .dashboard-wrapper
        {
            background-color: #ffffff;
        }

        .container{
            padding-right:15px;
            padding-left:15px;
            margin-right:auto;
            margin-left:auto;
        }

        .btn-group-vertical>.btn-group:after, .btn-toolbar:after, .clearfix:after, .container-fluid:after, .container:after, .dl-horizontal dd:after, .form-horizontal .form-group:after, .modal-footer:after, .modal-header:after, .nav:after, .navbar-collapse:after, .navbar-header:after, .navbar:after, .pager:after, .panel-body:after, .row:after
        {
            clear: both;
        }

        .col-xs-12
        {
            width: 100%;
        }

        .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9
        {
            float: left;
        }

        .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9
        {
            position: relative;
            min-height: 1px;
            padding-left: 15px;
            padding-right: 15px;
        }

        img
        {
            max-width: 100%;
            height: auto;
            vertical-align: middle;
            border: 0;
        }

        .text-right
        {
            text-align: right;
        }

        .text-muted
        {
            color: #777;
        }

        .table
        {
            width: 100%;
            max-width: 100%;
        }

        table
        {
            border-spacing: 0;
            border-collapse: collapse;
        }

        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th
        {
            line-height: 1.42857143;
            vertical-align: top;
            border-top: 1px solid #ddd;
        }

        td, th
        {
            padding: 0;
        }

        th
        {
            text-align: left;
        }

        @media (min-width: 768px)
        {
            .col-sm-6
            {
                width: 50%;
            }

            .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9
            {
                float: left;
            }
        }

        @media (min-width: 992px)
        {
            .col-md-6
            {
                width: 50%;
            }

            .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9
            {
                float: left;
            }
        }

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
            width: 100%;
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

</div>

</body>
</html>
