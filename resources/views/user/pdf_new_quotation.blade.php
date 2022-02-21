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
                                    @if($role != 'retailer') <p style="font-size: 22px;" class="font-weight-bold mb-4 m-heading"> OF: {{$quotation_invoice_number}}</p> @endif

                                    @if($role != 'supplier2')
                                        <p style="font-size: 22px;" class="font-weight-bold mb-4 m-heading"> @if($role == 'retailer') OF: {{$quotation_invoice_number}} @elseif($role == 'supplier') ORB: {{$order_number}} @elseif($role == 'invoice') FA: {{$order_number}} @else OR: {{$order_number}}@endif</p>
                                    @endif

                                    <p class="text-muted" style="font-size: 15px;margin-top: 10px;">{{__('text.Created at')}}: {{$date}}</p>

                                </div>

                                <div style="text-align: center;" class="col-md-4 col-sm-4 col-xs-12">

                                    <img class="img-fluid" src="{{ $user->compressed_photo ? public_path('assets/images/'.$user->compressed_photo) : public_path('assets/images/LOGO-page-001.jpg') }}" style="width:20%;height:100%;margin-bottom: 30px;">

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
                                <table class="table table1" style="border: 1px solid #e5e5e5;">
                                    <thead>
                                    <tr>
                                        <th class="border-0 text-uppercase small font-weight-bold">{{__('text.Qty')}}</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Product</th>
                                        @if($role == 'supplier2')

                                            <th class="border-0 text-uppercase small font-weight-bold">Supplier</th>
                                            <th class="border-0 text-uppercase small font-weight-bold">Order Number</th>

                                        @endif
                                        <th class="border-0 text-uppercase small font-weight-bold">Kleur - nummer</th>
                                        @if($form_type == 2)
                                            <th class="border-0 text-uppercase small font-weight-bold">Breedte</th>
                                            <th class="border-0 text-uppercase small font-weight-bold">Hoogte</th>
                                        @endif
                                        <th class="border-0 text-uppercase small font-weight-bold">Montage hoogte</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Type/uitvoering</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Bediening-zijde</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">kleur ladderband</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Pakket zijde</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Montage idd/odd</th>
                                        <th class="border-0 text-uppercase small font-weight-bold">Kleur systeem</th>

                                        @if($role == 'retailer')

                                            <th class="border-0 text-uppercase small font-weight-bold">{{__('text.Amount')}}</th>

                                        @elseif($role == 'supplier' || $role == 'invoice')

                                            @if($role == 'invoice')

                                                <th class="border-0 text-uppercase small font-weight-bold">{{__('text.Amount')}}</th>

                                            @endif

                                            <th class="border-0 text-uppercase small font-weight-bold">Delivery Date</th>

                                        @endif

                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($request->products as $i => $key)

                                        <tr>
                                            <td>{{$request->qty[$i]}}</td>
                                            <td>{{$product_titles[$i]}}</td>
                                            @if($role == 'supplier2')

                                                <td>{{$suppliers[$i]->name . ' ' . $suppliers[$i]->family_name}}</td>
                                                <td>{{$order_numbers[$i]}}</td>

                                            @endif
                                            <td>{{$color_titles[$i]}}</td>

                                            @if($form_type == 2)

                                                <td>{{$request->width[$i]}} {{$request->width_unit[$i]}}</td>
                                                <td>{{$request->height[$i]}} {{$request->height_unit[$i]}}</td>

                                            @endif

                                            @if($role == 'retailer' || $role == 'supplier2')

                                                <td><?php $childsafe_answer = 'childsafe_answer'.$request->row_id[$i]; $childsafe_answer = isset($request->$childsafe_answer) ? ($request->$childsafe_answer == 1 || $request->$childsafe_answer == 3 ? 'Is childsafe'.'<br>' : 'Not childsafe'.'<br>') : null; ?> {!! $childsafe_answer !!} <?php $string = ''; foreach($feature_sub_titles[$i] as $f => $feature){ if($feature){ if($feature->order_no == 0){ $comment = 'comment-'.$request->row_id[$i].'-'.$feature->f_id; $comment = isset($request->$comment) ? ($request->$comment ? ', '.$request->$comment : null) : null; $string .= "<br>".preg_replace("/\([^)]+\)/","",$feature->title).$comment; } } } ?> {!! substr($string, 4) !!}</td>
                                                <td><?php $string = ''; foreach($feature_sub_titles[$i] as $f => $feature){ if($feature){ if($feature->order_no == 1){ $comment = 'comment-'.$request->row_id[$i].'-'.$feature->f_id; $comment = isset($request->$comment) ? ($request->$comment ? ', '.$request->$comment : null) : null; $string .= "<br>".preg_replace("/\([^)]+\)/","",$feature->title).$comment; } } } ?> {!! substr($string, 4) !!}</td>
                                                <td><?php $string = ''; foreach($feature_sub_titles[$i] as $f => $feature){ if($feature){ if($feature->order_no == 2){ $comment = 'comment-'.$request->row_id[$i].'-'.$feature->f_id; $comment = isset($request->$comment) ? ($request->$comment ? ', '.$request->$comment : null) : null; $string .= "<br>".preg_replace("/\([^)]+\)/","",$feature->title).$comment; } } } ?> {!! substr($string, 4) !!}</td>
                                                <td><?php $string = ''; foreach($feature_sub_titles[$i] as $f => $feature){ if(!$feature){ if(isset($sub_titles[$i]->code)){ $string = $sub_titles[$i]->code . '<br>' . $sub_titles[$i]->size; } } } ?> {!! $string !!}</td>
                                                <td><?php $string = ''; foreach($feature_sub_titles[$i] as $f => $feature){ if($feature){ if($feature->order_no == 4){ $comment = 'comment-'.$request->row_id[$i].'-'.$feature->f_id; $comment = isset($request->$comment) ? ($request->$comment ? ', '.$request->$comment : null) : null; $string .= "<br>".preg_replace("/\([^)]+\)/","",$feature->title).$comment; } } } ?> {!! substr($string, 4) !!}</td>
                                                <td><?php $string = ''; foreach($feature_sub_titles[$i] as $f => $feature){ if($feature){ if($feature->order_no == 5){ $comment = 'comment-'.$request->row_id[$i].'-'.$feature->f_id; $comment = isset($request->$comment) ? ($request->$comment ? ', '.$request->$comment : null) : null; $string .= "<br>".preg_replace("/\([^)]+\)/","",$feature->title).$comment; } } } ?> {!! substr($string, 4) !!}</td>
                                                <td><?php $string = ''; foreach($feature_sub_titles[$i] as $f => $feature){ if($feature){ if($feature->order_no == 6){ $comment = 'comment-'.$request->row_id[$i].'-'.$feature->f_id; $comment = isset($request->$comment) ? ($request->$comment ? ', '.$request->$comment : null) : null; $string .= "<br>".preg_replace("/\([^)]+\)/","",$feature->title).$comment; } } } ?> {!! substr($string, 4) !!}</td>

                                                @if($role == 'retailer')

                                                    <td>{{round($request->rate[$i])}}</td>

                                                @endif

                                            @else

                                                <td><?php $childsafe_answer = $key->childsafe_answer != 0 ? ($key->childsafe_answer == 1 || $key->childsafe_answer == 3 ? 'Is childsafe'.'<br>' : 'Not childsafe'.'<br>') : null; ?> {!! $childsafe_answer !!} <?php $string = ''; foreach($feature_sub_titles[$i] as $f => $feature){ if($feature){ if($feature->order_no == 0){ $comment = isset($comments[$i][$f]) ? ($comments[$i][$f] ? ', '.$comments[$i][$f] : null) : null; $string .= "<br>".preg_replace("/\([^)]+\)/","",$feature->title).$comment; } } } ?> {!! substr($string, 4) !!}</td>
                                                <td><?php $string = ''; foreach($feature_sub_titles[$i] as $f => $feature){ if($feature){ if($feature->order_no == 1){ $comment = isset($comments[$i][$f]) ? ($comments[$i][$f] ? ', '.$comments[$i][$f] : null) : null; $string .= "<br>".preg_replace("/\([^)]+\)/","",$feature->title).$comment; } } } ?> {!! substr($string, 4) !!}</td>
                                                <td><?php $string = ''; foreach($feature_sub_titles[$i] as $f => $feature){ if($feature){ if($feature->order_no == 2){ $comment = isset($comments[$i][$f]) ? ($comments[$i][$f] ? ', '.$comments[$i][$f] : null) : null; $string .= "<br>".preg_replace("/\([^)]+\)/","",$feature->title).$comment; } } } ?> {!! substr($string, 4) !!}</td>
                                                <td><?php $string = ''; foreach($feature_sub_titles[$i] as $f => $feature){ if(!$feature){ if(isset($sub_titles[$i]->code)){ $string = $sub_titles[$i]->code . '<br>' . $sub_titles[$i]->size; } } } ?> {!! $string !!}</td>
                                                <td><?php $string = ''; foreach($feature_sub_titles[$i] as $f => $feature){ if($feature){ if($feature->order_no == 4){ $comment = isset($comments[$i][$f]) ? ($comments[$i][$f] ? ', '.$comments[$i][$f] : null) : null; $string .= "<br>".preg_replace("/\([^)]+\)/","",$feature->title).$comment; } } } ?> {!! substr($string, 4) !!}</td>
                                                <td><?php $string = ''; foreach($feature_sub_titles[$i] as $f => $feature){ if($feature){ if($feature->order_no == 5){ $comment = isset($comments[$i][$f]) ? ($comments[$i][$f] ? ', '.$comments[$i][$f] : null) : null; $string .= "<br>".preg_replace("/\([^)]+\)/","",$feature->title).$comment; } } } ?> {!! substr($string, 4) !!}</td>
                                                <td><?php $string = ''; foreach($feature_sub_titles[$i] as $f => $feature){ if($feature){ if($feature->order_no == 6){ $comment = isset($comments[$i][$f]) ? ($comments[$i][$f] ? ', '.$comments[$i][$f] : null) : null; $string .= "<br>".preg_replace("/\([^)]+\)/","",$feature->title).$comment; } } } ?> {!! substr($string, 4) !!}</td>

                                                @if($role == 'invoice')

                                                    <td>{{round($request->rate[$i])}}</td>

                                                @endif

                                                @if($role == 'supplier' || $role == 'invoice')

                                                    <td>{{$request->delivery_date[$i]}}</td>

                                                @endif

                                            @endif

                                        </tr>

                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if($form_type == 1)

                            @foreach($request->products as $i => $key)

                                <h2 style="text-align: center;display: inline-block;width: 100%;margin-top: 50px;">{{$product_titles[$i]}} Calculations</h2>

                                <table style="border: 1px solid #dee2e6;" class="table table1">

                                    <tbody>

                                    <?php $calculator_row = 'calculator_row'.$request->row_id[$i]; $calculator_row = $request->$calculator_row; ?>

                                    @if($request->measure[$i] == 'M1')

                                        <tr class="header">
                                            <td class="headings" style="width: 3%;">Sr.No</td>
                                            <td class="headings" style="width: 22%;">Description</td>
                                            <td class="headings" style="width: 13%;">Width</td>
                                            <td class="headings" style="width: 13%;">Height</td>
                                            <td class="headings" style="width: 13%;">Cutting lose</td>
                                            <td class="headings" style="width: 13%;">Turn</td>
                                            <td class="headings" style="width: 13%;">Max Width</td>
                                            <td class="headings" style="width: 10%;">Total</td>
                                        </tr>

                                    @else

                                        <tr class="header">
                                            <td class="headings" style="width: 3%;">Sr.No</td>
                                            <td class="headings" style="width: 22%;">Description</td>
                                            <td class="headings" style="width: 13%;">Width</td>
                                            <td class="headings" style="width: 13%;">Height</td>
                                            <td class="headings" style="width: 13%;">Cutting lose</td>
                                            <td class="headings" style="width: 13%;">Total</td>
                                            <td class="headings" style="width: 13%;">Box quantity</td>
                                            <td class="headings" style="width: 10%;">Total boxes</td>
                                        </tr>

                                    @endif

                                    @foreach($calculator_row as $c => $cal)

                                        <?php

                                        $description = 'attribute_description'.$request->row_id[$i];
                                        $width = 'width'.$request->row_id[$i];
                                        $height = 'height'.$request->row_id[$i];
                                        $cutting_lose = 'cutting_lose_percentage'.$request->row_id[$i];
                                        $box_quantity_supplier = 'box_quantity_supplier'.$request->row_id[$i];
                                        $box_quantity = 'box_quantity'.$request->row_id[$i];
                                        $total_boxes = 'total_boxes'.$request->row_id[$i];
                                        $max_width = 'max_width'.$request->row_id[$i];
                                        $turn = 'turn'.$request->row_id[$i];

                                        ?>

                                        <tr>

                                            <td>{{$cal}}</td>
                                            <td>{{$request->$description[$c]}}</td>
                                            <td>{{$request->$width[$c]}}</td>
                                            <td>{{$request->$height[$c]}}</td>
                                            <td>{{$request->$cutting_lose[$c]}}</td>

                                            @if($request->measure[$i] == 'M1')

                                                <td>{{$request->$turn[$c] == 0 ? 'No' : 'Yes'}}</td>
                                                <td>{{str_replace('.', ',',$request->$max_width[$c])}}</td>

                                            @else

                                                <td>{{str_replace('.', ',',$request->$total_boxes[$c])}}</td>
                                                <td>{{str_replace('.', ',',$request->$box_quantity_supplier[$c])}}</td>

                                            @endif

                                            <td>{{str_replace('.', ',',$request->$box_quantity[$c])}}</td>

                                        </tr>

                                    @endforeach

                                    </tbody>
                                </table>

                            @endforeach

                        @endif

                        <style type="text/css">

                            .table td, .table th{
                                text-align: center;
                                vertical-align: middle;
                            }

                        </style>

                        @if($role == 'retailer' || $role == 'invoice')

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

                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <style type="text/css">

        body
        {
            background-color: #f5f5f5;
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
            background-color: #f5f5f5;
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

</body>
</html>
