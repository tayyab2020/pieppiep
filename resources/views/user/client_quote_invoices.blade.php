@extends('layouts.client')

@section('content')


    <div class="right-side">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- Starting of Dashboard data-table area -->
                    <div class="section-padding add-product-1" style="padding: 0;">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="add-product-box">
                                    <div class="add-product-header products">
                                        @if(Route::currentRouteName() == 'client-quotations' || Route::currentRouteName() == 'client-new-quotations' || Route::currentRouteName() == 'client-custom-quotations')
                                            <h2>{{__('text.Quotations')}}</h2>
                                        @else
                                            <h2>{{__('text.Quotation Invoices')}}</h2>
                                        @endif
                                    </div>
                                    <hr>
                                    <div>
                                        @include('includes.form-success')
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table id="example" class="table table-striped table-hover products dt-responsive dataTable no-footer dtr-inline" role="grid" aria-describedby="product-table_wrapper_info" style="width: 100%;margin-top: 55px !important;" width="100%" cellspacing="0">
                                                    <thead>

                                                    <tr role="row">

                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending">ID</th>

                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending" id="client">@if(Route::currentRouteName() == 'client-quotations' || Route::currentRouteName() == 'client-new-quotations' || Route::currentRouteName() == 'client-custom-quotations') {{__('text.Quotation Number')}} @else {{__('text.Invoice Number')}} @endif</th>

                                                        @if(Route::currentRouteName() != 'client-custom-quotations')

                                                            <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 239px;" aria-sort="ascending" aria-label="Donor's Photo: activate to sort column descending" id="photo">{{__('text.Request Number')}}</th>

                                                        @endif

                                                        {{--<th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending" id="client">Handyman</th>--}}

                                                        {{--<th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending" id="handyman">Tax</th>

                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 95px;" aria-label="City: activate to sort column ascending" id="serv">Subtotal</th>--}}

                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="rate">{{__('text.Grand Total')}}</th>

                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="rate">{{__('text.Current Stage')}}</th>

                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="client">{{__('text.Accepted Date')}}</th>

                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="client">{{__('text.Delivery Date')}}</th>

                                                        @if(Route::currentRouteName() == 'client-quotations' || Route::currentRouteName() == 'client-new-quotations')

                                                            <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="client">{{__('text.Time Remaining')}}</th>

                                                        @endif

                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="date">{{__('text.Action')}}</th>


                                                    </thead>

                                                    <tbody>
                                                    <?php $i=0;  ?>

                                                    @foreach($invoices as $key)

                                                        <tr role="row" class="odd">

                                                            <td>{{$key->invoice_id}}</td>

                                                            @if(Route::currentRouteName() == 'client-custom-quotations')

                                                                <td><a href="{{ url('/aanbieder/aangepaste-offerte/'.$key->invoice_id) }}">QUO# {{$key->quotation_invoice_number}}</a></td>

                                                            @else

                                                                <td>
                                                                    @if(Route::currentRouteName() == 'client-quotations' || Route::currentRouteName() == 'client-new-quotations')

                                                                        <a href="{{ url('/aanbieder/offerte/'.$key->invoice_id) }}">QUO# {{$key->quotation_invoice_number}}</a></td>

                                                                @else

                                                                    <span>INV# {{$key->invoice_number}}</span></td>

                                                                @endif

                                                                @if($key->quote_request_id)

                                                                    <?php $requested_quote_number = $key->quote_number; ?>

                                                                    <td><a href="{{ url('/aanbieder/bekijk-offerte-aanvraag/'.$key->id) }}">{{$requested_quote_number}}</a></td>

                                                                @else

                                                                    <td></td>

                                                                @endif

                                                            @endif

                                                            {{--<td>{{$key->name}} {{$key->family_name}}</td>--}}

                                                            {{--<td>{{$key->tax}}</td>

                                                            <td>{{$key->subtotal}}</td>--}}

                                                            <td>{{number_format((float)$key->grand_total, 2, ',','.')}}</td>

                                                            @if($key->quote_request_id)

                                                                <?php

                                                                $date = strtotime($key->invoice_date);
                                                                $date = date('d-m-Y',$date);

                                                                if($key->accept_date)
                                                                {
                                                                    $accept_date = strtotime($key->accept_date);
                                                                    $accept_date = date('d-m-Y',$accept_date);

                                                                    $cal_accept_date = strtotime($key->accept_date);
                                                                    $cal_accept_date = date('Y-m-d H:i:s',$cal_accept_date);
                                                                }
                                                                else{
                                                                    $accept_date = '-';
                                                                    $cal_accept_date = '-';
                                                                }

                                                                $current_date = date('d-m-Y H:i:s', time());

                                                                if($key->delivery_date)
                                                                {
                                                                    $delivery_date = strtotime($key->delivery_date);
                                                                    $delivery_date = date('d-m-Y',$delivery_date);

                                                                    $cal_delivery_date = strtotime($key->delivery_date);
                                                                    $cal_delivery_date = date('Y-m-d H:i:s',$cal_delivery_date);
                                                                }
                                                                else{

                                                                    $delivery_date = '-';
                                                                    $cal_delivery_date = '-';

                                                                }

                                                                ?>

                                                            @endif

                                                            <td class="current-stage">

                                                                @if(Route::currentRouteName() == 'client-quotations' || Route::currentRouteName() == 'client-new-quotations' || Route::currentRouteName() == 'client-custom-quotations')

                                                                    @if($key->status == 3)

                                                                        @if($key->customer_received)

                                                                            <span class="btn btn-success">{{__('text.Goods Received')}}</span>

                                                                        @elseif($key->retailer_delivered)

                                                                            <span class="btn btn-success">{{__('text.Goods Delivered')}}</span>

                                                                        @elseif($key->invoice_sent)

                                                                            <span class="btn btn-success">{{__('text.Invoice Generated')}}</span>

                                                                        @else

                                                                            <span class="btn btn-success">Paid</span>

                                                                        @endif

                                                                    @elseif($key->status == 2)

                                                                        @if($key->customer_received)

                                                                            <span class="btn btn-success">{{__('text.Goods Received')}}</span>

                                                                        @elseif($key->retailer_delivered)

                                                                            <span class="btn btn-success">{{__('text.Goods Delivered')}}</span>

                                                                        @elseif($key->invoice_sent)

                                                                            <span class="btn btn-success">{{__('text.Invoice Generated')}}</span>

                                                                        @elseif($key->accepted)

                                                                            @if(!$key->quote_request_id || Route::currentRouteName() == 'client-custom-quotations')

                                                                                <span class="btn btn-success">{{__('text.Quotation Accepted')}}</span>

                                                                            @else

                                                                                <a class="btn btn-success pay_now" onclick="PayNow(this)" data-id="{{$key->invoice_id}}" href="javascript:void(0)">{{__('text.Pay Now')}}</a>

                                                                            @endif

                                                                        @else

                                                                            <span class="btn btn-primary1">{{__('text.Closed')}}</span>

                                                                        @endif

                                                                    @else

                                                                        @if($key->ask_customization)

                                                                            <span class="btn btn-info">{{__('text.Asking for Review')}}</span>

                                                                        @else

                                                                            @if(Route::currentRouteName() == 'client-custom-quotations')

                                                                                <a class="btn btn-primary1" href="{{ url('/aanbieder/eigen-offerte/accepteren-offerte/'.$key->invoice_id) }}">{{__('text.Accept')}}</a>

                                                                            @else

                                                                                @if($key->quote_request_id)

                                                                                    <a class="btn btn-primary1" onclick="accept(this)" data-date="{{$delivery_date != '-' ? $delivery_date : null}}" data-id="{{$key->invoice_id}}" href="javascript:void(0)">{{__('text.Accept')}}</a>

                                                                                @else

                                                                                    <a class="btn btn-primary1" href="{{route('accept-new-quotation', ['id' => $key->invoice_id])}}">{{__('text.Accept')}}</a>

                                                                                @endif

                                                                            @endif

                                                                        @endif

                                                                    @endif

                                                                @else

                                                                    @if($key->received)

                                                                        <span class="btn btn-success">{{__('text.Goods Received')}}</span>

                                                                    @elseif($key->delivered)

                                                                        <span class="btn btn-success">{{__('text.Goods Delivered')}}</span>

                                                                    @else

                                                                        <span class="btn btn-success">{{__('text.Invoice Generated')}}</span>

                                                                    @endif

                                                                @endif

                                                            </td>

                                                            <td class="accept_date">

                                                                @if($key->quote_request_id)

                                                                    <input type="hidden" id="accept_date" value="{{$cal_accept_date}}">
                                                                    {{$accept_date}}

                                                                @else

                                                                    {{$key->accept_date ? date('d-m-Y',strtotime($key->accept_date)) : null}}

                                                                @endif

                                                            </td>

                                                            <td class="delivery_date">

                                                                @if($key->quote_request_id)

                                                                    <input type="hidden" id="delivery_date" value="{{$cal_delivery_date}}">
                                                                    {{$delivery_date}}

                                                                @endif

                                                            </td>

                                                            @if(Route::currentRouteName() == 'client-quotations' || Route::currentRouteName() == 'client-new-quotations')

                                                                @if($key->quote_request_id && !$key->paid)

                                                                    <td class="interval"></td>

                                                                @else

                                                                    <td></td>

                                                                @endif

                                                            @endif

                                                            <td class="action_td">
                                                                <div class="dropdown">
                                                                    <button style="outline: none;" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">{{__('text.Action')}}
                                                                        <span class="caret"></span></button>
                                                                    <ul class="dropdown-menu">

                                                                        @if(Route::currentRouteName() == 'client-custom-quotations')

                                                                            <li><a href="{{ url('/aanbieder/aangepaste-offerte/'.$key->invoice_id) }}">{{__('text.View')}}</a></li>
                                                                            <li><a href="{{ url('/aanbieder/download-client-custom-quotation/'.$key->invoice_id) }}">{{__('text.Download PDF')}}</a></li>

                                                                            @if($key->status != 2 && $key->status != 3)

                                                                                <li><a onclick="ask(this)" data-id="{{$key->invoice_id}}" data-text="{{$key->review_text}}" data-url="{{ url('/aanbieder/aangepaste-offerte/ask-customization/') }}" href="javascript:void(0)">{{__('text.Ask Again')}}</a></li>

                                                                                <li><a href="{{ url('/aanbieder/eigen-offerte/accepteren-offerte/'.$key->invoice_id) }}">{{__('text.Accept')}}</a></li>

                                                                            @endif

                                                                            @if($key->delivered == 1 && $key->received == 0)

                                                                                <li><a href="{{ url('/aanbieder/custom-mark-received/'.$key->invoice_id) }}">{{__('text.Mark as received')}}</a></li>

                                                                            @endif

                                                                        @else

                                                                            @if(Route::currentRouteName() == 'client-quotations' || Route::currentRouteName() == 'client-new-quotations')

                                                                                <li><a href="{{ url('/aanbieder/offerte/'.$key->invoice_id) }}">{{__('text.View')}}</a></li>
                                                                                <li><a href="{{ url('/aanbieder/download-client-quote-invoice/'.$key->invoice_id) }}">{{__('text.Download PDF')}}</a></li>

                                                                            @endif

                                                                            @if(Route::currentRouteName() == 'client-quotations-invoices')

                                                                                @if($key->paid)

                                                                                    <li><a href="{{ url('/aanbieder/download-service-fee-invoice/'.$key->invoice_id) }}">Download Service Fee PDF</a></li>

                                                                                @endif

                                                                            @endif

                                                                            @if($key->quote_request_id)

                                                                                <li><a href="{{ url('/aanbieder/bekijk-offerte-aanvraag/'.$key->id) }}">{{__('text.View Request')}}</a></li>

                                                                            @endif

                                                                            @if($key->invoice_sent)

                                                                                <li><a href="{{ url('/aanbieder/download-invoice-pdf/'.$key->invoice_id) }}">Download Invoice PDF</a></li>

                                                                            @endif

                                                                            @if($key->status != 0 && $key->status != 2 && $key->status != 3)

                                                                                <li><a onclick="ask(this)" data-id="{{$key->invoice_id}}" data-text="{{$key->review_text}}" data-url="{{ url('/aanbieder/ask-customization/') }}" href="javascript:void(0)">{{__('text.Ask Again')}}</a></li>

                                                                                @if($key->quote_request_id)

                                                                                    <li><a onclick="accept(this)" data-date="{{$delivery_date != '-' ? $delivery_date : null}}" data-id="{{$key->invoice_id}}" href="javascript:void(0)">{{__('text.Accept')}}</a></li>

                                                                                @else

                                                                                    <li><a href="{{route('accept-new-quotation', ['id' => $key->invoice_id])}}">{{__('text.Accept')}}</a></li>

                                                                                @endif

                                                                            @endif

                                                                            @if($key->quote_request_id && $key->status == 2)

                                                                                <li><a class="pay_now" onclick="PayNow(this)" data-id="{{$key->invoice_id}}" href="javascript:void(0)">{{__('text.Pay Now')}}</a></li>

                                                                            @endif

                                                                            @if($key->retailer_delivered == 1 && $key->customer_received == 0)

                                                                                <li><a href="{{ url('/aanbieder/mark-received/'.$key->invoice_id) }}">{{__('text.Mark as received')}}</a></li>

                                                                            @endif

                                                                        @endif

                                                                    </ul>
                                                                </div>
                                                            </td>

                                                        </tr>

                                                    @endforeach
                                                    </tbody>
                                                </table></div></div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Ending of Dashboard data-table area -->
            </div>
        </div>
    </div>

    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">

            <form id="accept-form" method="post" action="{{url('/aanbieder/accept-quotation/')}}">

                <input type="hidden" name="_token" value="{{@csrf_token()}}">

                <div class="modal-content">

                    <div class="modal-header">
                        <button style="font-size: 32px;background-color: white !important;color: black !important;" type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 style="margin: 10px 0;" id="myModalLabel">{{__('text.Select Delivery Date')}}</h3>
                    </div>

                    <div class="modal-body" id="myWizard">

                        <h5 style="color: #f52c2c;font-family: sans-serif;font-size: 15px;">Note: By accepting this offer we charge you {{$service_fee}} euro service fee</h5>

                        <input type="hidden" name="invoice_id" id="invoice_id">
                        <label>{{__('text.Delivery Date')}} <span style="color: red;">*</span></label>
                        <input style="height: 45px;margin-bottom: 20px" type="text" name="delivery_date" id="delivery_date_picker" class="form-control" placeholder="{{__('text.Select Delivery Date')}}" required autocomplete="off">

                        <div id="main" style="display: inline-block;width: 100%;">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="section over-hide z-bigger">

                                        <div class="section over-hide z-bigger">
                                            <div class="container pb-5">
                                                <div class="row justify-content-center pb-5">

                                                    <div id="delivery_box">

{{--                                                        <div class="col-12 pt-5">--}}
{{--                                                            <h4 style="color: black;text-align: center;" class="mb-4 pb-2">{{__('text.Do you want this address to be updated in your profile?')}}</h4>--}}
{{--                                                        </div>--}}

{{--                                                        <div class="col-12 pb-5" style="display: flex;justify-content: space-around;margin-top: 20px;">--}}

{{--                                                            <input class="checkbox-tools" type="radio" name="update" id="tool-2" value="0" checked>--}}
{{--                                                            <label class="for-checkbox-tools" for="tool-2">--}}
{{--                                                                {{__('text.No')}}--}}
{{--                                                            </label>--}}

{{--                                                            <input class="checkbox-tools" type="radio" name="update" id="tool-3" value="1">--}}
{{--                                                            <label class="for-checkbox-tools" for="tool-3">--}}
{{--                                                                {{__('text.Yes')}}--}}
{{--                                                            </label>--}}

{{--                                                        </div>--}}

                                                        <div style="text-align: left;">
                                                            <label>{{__('text.Delivery Address')}} <span style="color: red;">*</span></label>
                                                            <input style="height: 45px;margin-bottom: 20px" type="search" name="delivery_address" id="delivery_address" class="form-control" placeholder="" required autocomplete="off">
                                                            <input type="hidden" id="check_address" value="0">
                                                            <input id="postcode" name="postcode" type="hidden">
                                                            <input name="city" id="city" type="hidden">
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" aria-label="Close" style="border: 0;outline: none;background-color: #e5e5e5 !important;color: black !important;" class="btn back">{{__('text.Close')}}</button>
                        <button type="button" style="border: 0;outline: none;background-color: #5cb85c !important;color: white;" class="btn btn-primary submit-btn">{{__('text.Continue')}}</button>
                    </div>

                </div>

            </form>

        </div>
    </div>


    <div id="myModal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">

            <form id="ask-form" method="post" action="">

                <input type="hidden" name="_token" value="{{@csrf_token()}}">

                <div class="modal-content">

                    <div class="modal-header">
                        <button style="font-size: 32px;background-color: white !important;color: black !important;" type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 style="margin: 10px 0;" id="myModalLabel">{{__('text.Mention Review Reason')}}</h3>
                    </div>

                    <div class="modal-body" id="myWizard">

                        <input type="hidden" name="invoice_id" id="invoice_id1">

                        <label>{{__('text.Review Reason')}} <span style="color: red;">*</span></label>

                        <textarea rows="5" style="resize: vertical;" type="text" name="review_text" id="review_text" class="form-control" required autocomplete="off"></textarea>

                    </div>

                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" aria-label="Close" style="border: 0;outline: none;background-color: #e5e5e5 !important;color: black !important;" class="btn back">{{__('text.Close')}}</button>
                        <button type="submit" style="border: 0;outline: none;background-color: #5cb85c !important;color: white;" class="btn btn-primary">{{__('text.Continue')}}</button>
                    </div>

                </div>

            </form>

        </div>
    </div>


    <form id="pay_form" method="post" action="{{url('/aanbieder/pay-quotation/')}}">

        <input type="hidden" name="_token" value="{{@csrf_token()}}">

        <input type="hidden" name="pay_invoice_id" id="pay_invoice_id">

    </form>

    <style type="text/css">

        /*!
* Datepicker for Bootstrap v1.5.0 (https://github.com/eternicode/bootstrap-datepicker)
*
* Copyright 2012 Stefan Petre
* Improvements by Andrew Rowls
* Licensed under the Apache License v2.0 (http://www.apache.org/licenses/LICENSE-2.0)
*/
        .datepicker {
            padding: 4px;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            direction: ltr;
        }
        .datepicker-inline {
            width: 220px;
        }
        .datepicker.datepicker-rtl {
            direction: rtl;
        }
        .datepicker.datepicker-rtl table tr td span {
            float: right;
        }
        .datepicker-dropdown {
            top: 0;

            min-width: 19.3% !important;
        }

        .table-condensed{

            width: 100%;


        }

        .datepicker td, .datepicker th
        {

            font-size: 17px;


        }
        .datepicker-dropdown:before {
            content: '';
            display: inline-block;
            border-left: 7px solid transparent;
            border-right: 7px solid transparent;
            border-bottom: 7px solid #999999;
            border-top: 0;
            border-bottom-color: rgba(0, 0, 0, 0.2);
            position: absolute;
        }
        .datepicker-dropdown:after {
            content: '';
            display: inline-block;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-bottom: 6px solid #ffffff;
            border-top: 0;
            position: absolute;
        }
        .datepicker-dropdown.datepicker-orient-left:before {
            left: 6px;
        }
        .datepicker-dropdown.datepicker-orient-left:after {
            left: 7px;
        }
        .datepicker-dropdown.datepicker-orient-right:before {
            right: 6px;
        }
        .datepicker-dropdown.datepicker-orient-right:after {
            right: 7px;
        }
        .datepicker-dropdown.datepicker-orient-bottom:before {
            display: none;
            top: -7px;
        }
        .datepicker-dropdown.datepicker-orient-bottom:after {
            display: none;
            top: -6px;
        }
        .datepicker-dropdown.datepicker-orient-top:before {
            display: none;
            bottom: -7px;
            border-bottom: 0;
            border-top: 7px solid #999999;
        }
        .datepicker-dropdown.datepicker-orient-top:after {
            display: none;
            bottom: -6px;
            border-bottom: 0;
            border-top: 6px solid #ffffff;
        }
        .datepicker > div {
            display: none;
        }
        .datepicker table {
            margin: 0;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        .datepicker td,
        .datepicker th {
            text-align: center;
            width: 20px;
            height: 20px;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            border: none;
        }
        .table-striped .datepicker table tr td,
        .table-striped .datepicker table tr th {
            background-color: transparent;
        }
        .datepicker table tr td.day:hover,
        .datepicker table tr td.day.focused {
            background: #eeeeee;
            cursor: pointer;
        }
        .datepicker table tr td.old,
        .datepicker table tr td.new {
            color: #999999;
        }
        .datepicker table tr td.disabled,
        .datepicker table tr td.disabled:hover {
            background: none;
            color: #999999;
            cursor: default;
        }
        .datepicker table tr td.highlighted {
            background: #d9edf7;
            border-radius: 0;
        }
        .datepicker table tr td.today,
        .datepicker table tr td.today:hover,
        .datepicker table tr td.today.disabled,
        .datepicker table tr td.today.disabled:hover {
            background-color: #fde19a;
            background-image: -moz-linear-gradient(to bottom, #fdd49a, #fdf59a);
            background-image: -ms-linear-gradient(to bottom, #fdd49a, #fdf59a);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#fdd49a), to(#fdf59a));
            background-image: -webkit-linear-gradient(to bottom, #fdd49a, #fdf59a);
            background-image: -o-linear-gradient(to bottom, #fdd49a, #fdf59a);
            background-image: linear-gradient(to bottom, #fdd49a, #fdf59a);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fdd49a', endColorstr='#fdf59a', GradientType=0);
            border-color: #fdf59a #fdf59a #fbed50;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            color: #000;
        }
        .datepicker table tr td.today:hover,
        .datepicker table tr td.today:hover:hover,
        .datepicker table tr td.today.disabled:hover,
        .datepicker table tr td.today.disabled:hover:hover,
        .datepicker table tr td.today:active,
        .datepicker table tr td.today:hover:active,
        .datepicker table tr td.today.disabled:active,
        .datepicker table tr td.today.disabled:hover:active,
        .datepicker table tr td.today.active,
        .datepicker table tr td.today:hover.active,
        .datepicker table tr td.today.disabled.active,
        .datepicker table tr td.today.disabled:hover.active,
        .datepicker table tr td.today.disabled,
        .datepicker table tr td.today:hover.disabled,
        .datepicker table tr td.today.disabled.disabled,
        .datepicker table tr td.today.disabled:hover.disabled,
        .datepicker table tr td.today[disabled],
        .datepicker table tr td.today:hover[disabled],
        .datepicker table tr td.today.disabled[disabled],
        .datepicker table tr td.today.disabled:hover[disabled] {
            background-color: #fdf59a;
        }
        .datepicker table tr td.today:active,
        .datepicker table tr td.today:hover:active,
        .datepicker table tr td.today.disabled:active,
        .datepicker table tr td.today.disabled:hover:active,
        .datepicker table tr td.today.active,
        .datepicker table tr td.today:hover.active,
        .datepicker table tr td.today.disabled.active,
        .datepicker table tr td.today.disabled:hover.active {
            background-color: #fbf069 \9;
        }
        .datepicker table tr td.today:hover:hover {
            color: #000;
        }
        .datepicker table tr td.today.active:hover {
            color: #fff;
        }
        .datepicker table tr td.range,
        .datepicker table tr td.range:hover,
        .datepicker table tr td.range.disabled,
        .datepicker table tr td.range.disabled:hover {
            background: #eeeeee;
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
        }
        .datepicker table tr td.range.today,
        .datepicker table tr td.range.today:hover,
        .datepicker table tr td.range.today.disabled,
        .datepicker table tr td.range.today.disabled:hover {
            background-color: #f3d17a;
            background-image: -moz-linear-gradient(to bottom, #f3c17a, #f3e97a);
            background-image: -ms-linear-gradient(to bottom, #f3c17a, #f3e97a);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#f3c17a), to(#f3e97a));
            background-image: -webkit-linear-gradient(to bottom, #f3c17a, #f3e97a);
            background-image: -o-linear-gradient(to bottom, #f3c17a, #f3e97a);
            background-image: linear-gradient(to bottom, #f3c17a, #f3e97a);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f3c17a', endColorstr='#f3e97a', GradientType=0);
            border-color: #f3e97a #f3e97a #edde34;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
        }
        .datepicker table tr td.range.today:hover,
        .datepicker table tr td.range.today:hover:hover,
        .datepicker table tr td.range.today.disabled:hover,
        .datepicker table tr td.range.today.disabled:hover:hover,
        .datepicker table tr td.range.today:active,
        .datepicker table tr td.range.today:hover:active,
        .datepicker table tr td.range.today.disabled:active,
        .datepicker table tr td.range.today.disabled:hover:active,
        .datepicker table tr td.range.today.active,
        .datepicker table tr td.range.today:hover.active,
        .datepicker table tr td.range.today.disabled.active,
        .datepicker table tr td.range.today.disabled:hover.active,
        .datepicker table tr td.range.today.disabled,
        .datepicker table tr td.range.today:hover.disabled,
        .datepicker table tr td.range.today.disabled.disabled,
        .datepicker table tr td.range.today.disabled:hover.disabled,
        .datepicker table tr td.range.today[disabled],
        .datepicker table tr td.range.today:hover[disabled],
        .datepicker table tr td.range.today.disabled[disabled],
        .datepicker table tr td.range.today.disabled:hover[disabled] {
            background-color: #f3e97a;
        }
        .datepicker table tr td.range.today:active,
        .datepicker table tr td.range.today:hover:active,
        .datepicker table tr td.range.today.disabled:active,
        .datepicker table tr td.range.today.disabled:hover:active,
        .datepicker table tr td.range.today.active,
        .datepicker table tr td.range.today:hover.active,
        .datepicker table tr td.range.today.disabled.active,
        .datepicker table tr td.range.today.disabled:hover.active {
            background-color: #efe24b \9;
        }
        .datepicker table tr td.selected,
        .datepicker table tr td.selected:hover,
        .datepicker table tr td.selected.disabled,
        .datepicker table tr td.selected.disabled:hover {
            background-color: #9e9e9e;
            background-image: -moz-linear-gradient(to bottom, #b3b3b3, #808080);
            background-image: -ms-linear-gradient(to bottom, #b3b3b3, #808080);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#b3b3b3), to(#808080));
            background-image: -webkit-linear-gradient(to bottom, #b3b3b3, #808080);
            background-image: -o-linear-gradient(to bottom, #b3b3b3, #808080);
            background-image: linear-gradient(to bottom, #b3b3b3, #808080);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#b3b3b3', endColorstr='#808080', GradientType=0);
            border-color: #808080 #808080 #595959;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            color: #fff;
            text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
        }
        .datepicker table tr td.selected:hover,
        .datepicker table tr td.selected:hover:hover,
        .datepicker table tr td.selected.disabled:hover,
        .datepicker table tr td.selected.disabled:hover:hover,
        .datepicker table tr td.selected:active,
        .datepicker table tr td.selected:hover:active,
        .datepicker table tr td.selected.disabled:active,
        .datepicker table tr td.selected.disabled:hover:active,
        .datepicker table tr td.selected.active,
        .datepicker table tr td.selected:hover.active,
        .datepicker table tr td.selected.disabled.active,
        .datepicker table tr td.selected.disabled:hover.active,
        .datepicker table tr td.selected.disabled,
        .datepicker table tr td.selected:hover.disabled,
        .datepicker table tr td.selected.disabled.disabled,
        .datepicker table tr td.selected.disabled:hover.disabled,
        .datepicker table tr td.selected[disabled],
        .datepicker table tr td.selected:hover[disabled],
        .datepicker table tr td.selected.disabled[disabled],
        .datepicker table tr td.selected.disabled:hover[disabled] {
            background-color: #808080;
        }
        .datepicker table tr td.selected:active,
        .datepicker table tr td.selected:hover:active,
        .datepicker table tr td.selected.disabled:active,
        .datepicker table tr td.selected.disabled:hover:active,
        .datepicker table tr td.selected.active,
        .datepicker table tr td.selected:hover.active,
        .datepicker table tr td.selected.disabled.active,
        .datepicker table tr td.selected.disabled:hover.active {
            background-color: #666666 \9;
        }
        .datepicker table tr td.active,
        .datepicker table tr td.active:hover,
        .datepicker table tr td.active.disabled,
        .datepicker table tr td.active.disabled:hover {
            background-color: #006dcc;
            background-image: -moz-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: -ms-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0044cc));
            background-image: -webkit-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: -o-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: linear-gradient(to bottom, #0088cc, #0044cc);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#0088cc', endColorstr='#0044cc', GradientType=0);
            border-color: #0044cc #0044cc #002a80;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            color: #fff;
            text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
        }
        .datepicker table tr td.active:hover,
        .datepicker table tr td.active:hover:hover,
        .datepicker table tr td.active.disabled:hover,
        .datepicker table tr td.active.disabled:hover:hover,
        .datepicker table tr td.active:active,
        .datepicker table tr td.active:hover:active,
        .datepicker table tr td.active.disabled:active,
        .datepicker table tr td.active.disabled:hover:active,
        .datepicker table tr td.active.active,
        .datepicker table tr td.active:hover.active,
        .datepicker table tr td.active.disabled.active,
        .datepicker table tr td.active.disabled:hover.active,
        .datepicker table tr td.active.disabled,
        .datepicker table tr td.active:hover.disabled,
        .datepicker table tr td.active.disabled.disabled,
        .datepicker table tr td.active.disabled:hover.disabled,
        .datepicker table tr td.active[disabled],
        .datepicker table tr td.active:hover[disabled],
        .datepicker table tr td.active.disabled[disabled],
        .datepicker table tr td.active.disabled:hover[disabled] {
            background-color: #0044cc;
        }
        .datepicker table tr td.active:active,
        .datepicker table tr td.active:hover:active,
        .datepicker table tr td.active.disabled:active,
        .datepicker table tr td.active.disabled:hover:active,
        .datepicker table tr td.active.active,
        .datepicker table tr td.active:hover.active,
        .datepicker table tr td.active.disabled.active,
        .datepicker table tr td.active.disabled:hover.active {
            background-color: #003399 \9;
        }
        .datepicker table tr td span {
            display: block;
            width: 23%;
            height: 54px;
            line-height: 54px;
            float: left;
            margin: 1%;
            cursor: pointer;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
        }
        .datepicker table tr td span:hover {
            background: #eeeeee;
        }
        .datepicker table tr td span.disabled,
        .datepicker table tr td span.disabled:hover {
            background: none;
            color: #999999;
            cursor: default;
        }
        .datepicker table tr td span.active,
        .datepicker table tr td span.active:hover,
        .datepicker table tr td span.active.disabled,
        .datepicker table tr td span.active.disabled:hover {
            background-color: #006dcc;
            background-image: -moz-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: -ms-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0044cc));
            background-image: -webkit-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: -o-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: linear-gradient(to bottom, #0088cc, #0044cc);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#0088cc', endColorstr='#0044cc', GradientType=0);
            border-color: #0044cc #0044cc #002a80;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            color: #fff;
            text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
        }
        .datepicker table tr td span.active:hover,
        .datepicker table tr td span.active:hover:hover,
        .datepicker table tr td span.active.disabled:hover,
        .datepicker table tr td span.active.disabled:hover:hover,
        .datepicker table tr td span.active:active,
        .datepicker table tr td span.active:hover:active,
        .datepicker table tr td span.active.disabled:active,
        .datepicker table tr td span.active.disabled:hover:active,
        .datepicker table tr td span.active.active,
        .datepicker table tr td span.active:hover.active,
        .datepicker table tr td span.active.disabled.active,
        .datepicker table tr td span.active.disabled:hover.active,
        .datepicker table tr td span.active.disabled,
        .datepicker table tr td span.active:hover.disabled,
        .datepicker table tr td span.active.disabled.disabled,
        .datepicker table tr td span.active.disabled:hover.disabled,
        .datepicker table tr td span.active[disabled],
        .datepicker table tr td span.active:hover[disabled],
        .datepicker table tr td span.active.disabled[disabled],
        .datepicker table tr td span.active.disabled:hover[disabled] {
            background-color: #0044cc;
        }
        .datepicker table tr td span.active:active,
        .datepicker table tr td span.active:hover:active,
        .datepicker table tr td span.active.disabled:active,
        .datepicker table tr td span.active.disabled:hover:active,
        .datepicker table tr td span.active.active,
        .datepicker table tr td span.active:hover.active,
        .datepicker table tr td span.active.disabled.active,
        .datepicker table tr td span.active.disabled:hover.active {
            background-color: #003399 \9;
        }
        .datepicker table tr td span.old,
        .datepicker table tr td span.new {
            color: #999999;
        }
        .datepicker .datepicker-switch {
            width: 145px;
        }
        .datepicker .datepicker-switch,
        .datepicker .prev,
        .datepicker .next,
        .datepicker tfoot tr th {
            cursor: pointer;
        }
        .datepicker .datepicker-switch:hover,
        .datepicker .prev:hover,
        .datepicker .next:hover,
        .datepicker tfoot tr th:hover {
            background: #eeeeee;
        }
        .datepicker .cw {
            font-size: 10px;
            width: 12px;
            padding: 0 2px 0 5px;
            vertical-align: middle;
        }
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

        .btn-primary1
        {
            background-color: darkcyan;
            border-color: darkcyan;
            color: white !important;
        }

        .dropdown-menu
        {
            left: -65px;
        }

        select {
            -webkit-appearance: none !important;
            -moz-appearance: none !important;
            text-indent: 1px !important;
            text-overflow: '' !important;
        }

        /* Custom dropdown */
        .custom-dropdown {
            position: relative;
            display: inline-block;
            vertical-align: middle;
            margin: 10px; /* demo only */
        }

        .custom-dropdown select {
            background-color: #1abc9c;
            color: #fff;
            font-size: inherit;
            padding: .5em;
            padding-right: 2.5em;
            border: 0;
            margin: 0;
            border-radius: 3px;
            text-indent: 0.01px;
            text-overflow: '';
            -webkit-appearance: button; /* hide default arrow in chrome OSX */
            outline: none;
        }

        .custom-dropdown::before,
        .custom-dropdown::after {
            content: "";
            position: absolute;
            pointer-events: none;
        }

        .custom-dropdown::after { /*  Custom dropdown arrow */
            content: "\25BC";
            height: 1em;
            font-size: .625em;
            line-height: 1;
            right: 1.2em;
            top: 50%;
            margin-top: -.5em;
        }

        .custom-dropdown::before { /*  Custom dropdown arrow cover */
            width: 2em;
            right: 0;
            top: 0;
            bottom: 0;
            border-radius: 0 3px 3px 0;
        }

        .custom-dropdown select[disabled] {
            color: rgba(0,0,0,.3);
        }

        .custom-dropdown select[disabled]::after {
            color: rgba(0,0,0,.1);
        }

        .custom-dropdown::before {
            background-color: rgba(0,0,0,.15);
        }

        .custom-dropdown::after {
            color: rgba(0,0,0,.4);
        }

        .text-left{

            font-size: 18px !important;
            text-align: center !important;

        }

        .swal2-popup{

            width: 25% !important;
            height: 330px !important;
        }

        .swal2-icon.swal2-warning{

            width: 20% !important;
            height: 82px !important;
        }

        .swal2-title{

            font-size: 27px !important;
        }

        .swal2-content{

            font-size: 18px !important;
        }

        .swal2-actions{

            font-size: 13px !important;
        }

    </style>


    <style type="text/css">

        table.dataTable thead>tr>th.sorting_asc, table.dataTable thead>tr>th.sorting_desc, table.dataTable thead>tr>th.sorting, table.dataTable thead>tr>td.sorting_asc, table.dataTable thead>tr>td.sorting_desc, table.dataTable thead>tr>td.sorting{

            padding-right: 0;
            padding-left: 0;
            text-align: center;
            border-top: 1px solid black !important;
            border-bottom: 1px solid black !important;
        }

        #img{

            width: 100% !important;
            display: block !important;
        }

        #photo{
            width: 250px !important;
        }

        #client{
            width: 230px !important;
        }

        #handyman{
            width: 230px !important;
        }

        #serv{
            width: 170px !important;
        }

        #rate{
            width: 175px !important;
        }

        #service{
            width: 151px !important;
        }

        #date{
            width: 158px !important;
        }

        #amount{
            width: 160px !important;
        }

        #status{
            width: 77px !important;
        }

        .table.products > tbody > tr > td
        {

            text-align: center;

        }


    </style>

    <style>

        .pac-container
        {
            z-index: 1000000;
        }

        @media (min-width: 1200px)
        {
            .container
            {
                width: 100%;
            }
        }

        .for-checkbox-tools
        {
            display: flex !important;
            flex-direction: column;
            justify-content: center;
        }

        @media (max-width: 800px)
        {
            .pb-5
            {
                flex-direction: column;
                align-items: center;
            }

            .for-checkbox-tools
            {
                margin: 15px 0px !important;
            }
        }


        @import url('https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&subset=devanagari,latin-ext');


        :root {
            --white: #ffffff;
            --light: #f0eff3;
            --black: #000000;
            --dark-blue: #1f2029;
            --dark-light: #353746;
            --red: #da2c4d;
            --yellow: #f8ab37;
            --grey: #ecedf3;
        }

        /* #Primary
        ================================================== */

        .over-hide {
            overflow: hidden;
        }
        .z-bigger {
            z-index: 100 !important;
        }

        ::selection {
            color: var(--white);
            background-color: var(--black);
        }
        ::-moz-selection {
            color: var(--white);
            background-color: var(--black);
        }
        mark{
            color: var(--white);
            background-color: var(--black);
        }
        .section {
            position: relative;
            width: 100%;
            display: block;
            text-align: center;
            margin: 0 auto;
        }

        .background-color{
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: var(--dark-blue);
            z-index: 1;
            -webkit-transition: all 300ms linear;
            transition: all 300ms linear;
        }
        .checkbox:checked ~ .background-color{
            background-color: var(--white);
        }


        [type="checkbox"]:checked,
        [type="checkbox"]:not(:checked),
        [type="radio"]:checked,
        [type="radio"]:not(:checked){
            position: absolute;
            left: -9999px;
            width: 0;
            height: 0;
            visibility: hidden;
        }
        .checkbox:checked + label,
        .checkbox:not(:checked) + label{
            position: relative;
            width: 70px;
            display: inline-block;
            padding: 0;
            margin: 0 auto;
            text-align: center;
            margin: 17px 0;
            margin-top: 100px;
            height: 6px;
            border-radius: 4px;
            background-image: linear-gradient(298deg, #5CB85C, #5CB85C);
            z-index: 100 !important;
        }
        .checkbox:checked + label:before,
        .checkbox:not(:checked) + label:before {
            position: absolute;
            font-family: 'unicons';
            cursor: pointer;
            top: -17px;
            z-index: 2;
            font-size: 20px;
            line-height: 40px;
            text-align: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            -webkit-transition: all 300ms linear;
            transition: all 300ms linear;
        }
        .checkbox:not(:checked) + label:before {
            content: '\eac1';
            left: 0;
            color: var(--grey);
            background-color: var(--dark-light);
            box-shadow: 0 4px 4px rgba(0,0,0,0.15), 0 0 0 1px rgba(26,53,71,0.07);
        }
        .checkbox:checked + label:before {
            content: '\eb8f';
            left: 30px;
            color: var(--yellow);
            background-color: var(--dark-blue);
            box-shadow: 0 4px 4px rgba(26,53,71,0.25), 0 0 0 1px rgba(26,53,71,0.07);
        }

        .checkbox:checked ~ .section .container .row .col-12 p{
            color: var(--dark-blue);
        }


        .checkbox-tools:checked + label,
        .checkbox-tools:not(:checked) + label{
            position: relative;
            display: inline-block;
            padding: 20px;
            width: 300px;
            font-size: 14px;
            line-height: 2;
            letter-spacing: 1px;
            margin: 0 auto;
            margin-left: 5px;
            margin-right: 5px;
            margin-bottom: 25px;
            text-align: center;
            border-radius: 4px;
            overflow: hidden;
            cursor: pointer;
            text-transform: uppercase;
            color: var(--white);
            -webkit-transition: all 300ms linear;
            transition: all 300ms linear;
        }
        .checkbox-tools:not(:checked) + label{
            background-color: var(--dark-light);
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
        }
        .checkbox-tools:checked + label{
            background-color: transparent;
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }
        .checkbox-tools:not(:checked) + label:hover{
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }
        .checkbox-tools:checked + label::before,
        .checkbox-tools:not(:checked) + label::before{
            position: absolute;
            content: '';
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 4px;
            background-image: linear-gradient(298deg, #5CB85C, #5CB85C);
            z-index: -1;
        }
        .checkbox-tools:checked + label .uil,
        .checkbox-tools:not(:checked) + label .uil{
            font-size: 24px;
            line-height: 24px;
            display: block;
            padding-bottom: 10px;
        }

        .checkbox:checked ~ .section .container .row .col-12 .checkbox-tools:not(:checked) + label{
            background-color: var(--light);
            color: var(--dark-blue);
            box-shadow: 0 1x 4px 0 rgba(0, 0, 0, 0.05);
        }

        .checkbox-budget:checked + label,
        .checkbox-budget:not(:checked) + label{
            position: relative;
            display: inline-block;
            padding: 0;
            padding-top: 20px;
            padding-bottom: 20px;
            width: 260px;
            font-size: 52px;
            line-height: 52px;
            font-weight: 700;
            letter-spacing: 1px;
            margin: 0 auto;
            margin-left: 5px;
            margin-right: 5px;
            margin-bottom: 10px;
            text-align: center;
            border-radius: 4px;
            overflow: hidden;
            cursor: pointer;
            text-transform: uppercase;
            -webkit-transition: all 300ms linear;
            transition: all 300ms linear;
            -webkit-text-stroke: 1px var(--white);
            text-stroke: 1px var(--white);
            -webkit-text-fill-color: transparent;
            text-fill-color: transparent;
            color: transparent;
        }
        .checkbox-budget:not(:checked) + label{
            background-color: var(--dark-light);
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
        }
        .checkbox-budget:checked + label{
            background-color: transparent;
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }
        .checkbox-budget:not(:checked) + label:hover{
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }
        .checkbox-budget:checked + label::before,
        .checkbox-budget:not(:checked) + label::before{
            position: absolute;
            content: '';
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border-radius: 4px;
            background-image: linear-gradient(138deg, #5CB85C, #5CB85C);
            z-index: -1;
        }
        .checkbox-budget:checked + label span,
        .checkbox-budget:not(:checked) + label span{
            position: relative;
            display: block;
        }
        .checkbox-budget:checked + label span::before,
        .checkbox-budget:not(:checked) + label span::before{
            position: absolute;
            content: attr(data-hover);
            top: 0;
            left: 0;
            width: 100%;
            overflow: hidden;
            -webkit-text-stroke: transparent;
            text-stroke: transparent;
            -webkit-text-fill-color: var(--white);
            text-fill-color: var(--white);
            color: var(--white);
            -webkit-transition: max-height 0.3s;
            -moz-transition: max-height 0.3s;
            transition: max-height 0.3s;
        }
        .checkbox-budget:not(:checked) + label span::before{
            max-height: 0;
        }
        .checkbox-budget:checked + label span::before{
            max-height: 100%;
        }

        .checkbox:checked ~ .section .container .row .col-xl-10 .checkbox-budget:not(:checked) + label{
            background-color: var(--light);
            -webkit-text-stroke: 1px var(--dark-blue);
            text-stroke: 1px var(--dark-blue);
            box-shadow: 0 1x 4px 0 rgba(0, 0, 0, 0.05);
        }

        .checkbox-booking:checked + label,
        .checkbox-booking:not(:checked) + label{
            position: relative;
            display: -webkit-inline-flex;
            display: -ms-inline-flexbox;
            display: inline-flex;
            -webkit-align-items: center;
            -moz-align-items: center;
            -ms-align-items: center;
            align-items: center;
            -webkit-justify-content: center;
            -moz-justify-content: center;
            -ms-justify-content: center;
            justify-content: center;
            -ms-flex-pack: center;
            text-align: center;
            padding: 0;
            padding: 6px 25px;
            font-size: 14px;
            line-height: 30px;
            letter-spacing: 1px;
            margin: 0 auto;
            margin-left: 6px;
            margin-right: 6px;
            margin-bottom: 16px;
            text-align: center;
            border-radius: 4px;
            cursor: pointer;
            color: var(--white);
            text-transform: uppercase;
            background-color: var(--dark-light);
            -webkit-transition: all 300ms linear;
            transition: all 300ms linear;
        }
        .checkbox-booking:not(:checked) + label::before{
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1);
        }
        .checkbox-booking:checked + label::before{
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }
        .checkbox-booking:not(:checked) + label:hover::before{
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }
        .checkbox-booking:checked + label::before,
        .checkbox-booking:not(:checked) + label::before{
            position: absolute;
            content: '';
            top: -2px;
            left: -2px;
            width: calc(100% + 4px);
            height: calc(100% + 4px);
            border-radius: 4px;
            z-index: -2;
            background-image: linear-gradient(138deg, #5CB85C, #5CB85C);
            -webkit-transition: all 300ms linear;
            transition: all 300ms linear;
        }
        .checkbox-booking:not(:checked) + label::before{
            top: -1px;
            left: -1px;
            width: calc(100% + 2px);
            height: calc(100% + 2px);
        }
        .checkbox-booking:checked + label::after,
        .checkbox-booking:not(:checked) + label::after{
            position: absolute;
            content: '';
            top: -2px;
            left: -2px;
            width: calc(100% + 4px);
            height: calc(100% + 4px);
            border-radius: 4px;
            z-index: -2;
            background-color: var(--dark-light);
            -webkit-transition: all 300ms linear;
            transition: all 300ms linear;
        }
        .checkbox-booking:checked + label::after{
            opacity: 0;
        }
        .checkbox-booking:checked + label .uil,
        .checkbox-booking:not(:checked) + label .uil{
            font-size: 20px;
        }
        .checkbox-booking:checked + label .text,
        .checkbox-booking:not(:checked) + label .text{
            position: relative;
            display: inline-block;
            -webkit-transition: opacity 300ms linear;
            transition: opacity 300ms linear;
        }
        .checkbox-booking:checked + label .text{
            opacity: 0.6;
        }
        .checkbox-booking:checked + label .text::after,
        .checkbox-booking:not(:checked) + label .text::after{
            position: absolute;
            content: '';
            width: 0;
            left: 0;
            top: 50%;
            margin-top: -1px;
            height: 2px;
            background-image: linear-gradient(138deg, #5CB85C, #5CB85C);
            z-index: 1;
            -webkit-transition: all 300ms linear;
            transition: all 300ms linear;
        }
        .checkbox-booking:not(:checked) + label .text::after{
            width: 0;
        }
        .checkbox-booking:checked + label .text::after{
            width: 100%;
        }

        .checkbox:checked ~ .section .container .row .col-12 .checkbox-booking:not(:checked) + label,
        .checkbox:checked ~ .section .container .row .col-12 .checkbox-booking:checked + label{
            background-color: var(--light);
            color: var(--dark-blue);
        }
        .checkbox:checked ~ .section .container .row .col-12 .checkbox-booking:checked + label::after,
        .checkbox:checked ~ .section .container .row .col-12 .checkbox-booking:not(:checked) + label::after{
            background-color: var(--light);
        }
    </style>

@endsection


@section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNRJukOohRJ1tW0tMG4tzpDXFz68OnonM&libraries=places&callback=initMap" async defer></script>

    <script type="text/javascript">

        function initMap() {

            var input = document.getElementById('delivery_address');

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
                    var string = $('#delivery_address').val().substring(0, $('#delivery_address').val().indexOf(',')); //first string before comma

                    if(string)
                    {
                        var is_number = $('#delivery_address').val().match(/\d+/);

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
                    $('#delivery_address').val('');
                    $('#postcode').val('');
                    $("#city").val('');

                    $("#address-error").remove();
                    $('#delivery_address').parent().append('<small id="address-error" style="color: red;display: block;padding-right: 30px;">{{__('text.Kindly write your full address with house/building number so system can detect postal code and city from it!')}}</small>');
                }

            });
        }

        $(document).ready(function() {

            $('.submit-btn').click(function(){
                var date = $('#delivery_date_picker').val();
                var delivery_address = $('#delivery_address').val();
                var flag = 0;

                if(!date)
                {
                    $('#delivery_date_picker').css('border','1px solid red');
                    flag = 1;
                }
                else
                {
                    $('#delivery_date_picker').css('border','');
                }

                if(!delivery_address)
                {
                    $('#delivery_address').css('border','1px solid red');
                    flag = 1;
                }
                else
                {
                    $('#delivery_address').css('border','');
                }

                if(flag == 0)
                {
                    $('#accept-form').submit();
                }
            });

            $("#delivery_address").on('input',function(e){
                $(this).next('input').val(0);
            });

            $("#delivery_address").focusout(function(){

                var check = $(this).next('input').val();

                if(check == 0)
                {
                    $(this).val('');
                    $('#postcode').val('');
                    $("#city").val('');
                }
            });

            var todayDate = new Date().getDate();
            var endD = new Date(new Date().setDate(todayDate + 1));

            $('#delivery_date_picker').datepicker({

                format: 'dd-mm-yyyy',
                startDate: endD,

            });

        });

        function ask(e)
        {
            var invoice_id = $(e).data('id');
            var url = $(e).data('url');
            var text = $(e).data('text');

            $('#invoice_id1').val(invoice_id);
            $('#ask-form').attr('action', url);
            $('#review_text').val(text);

            $('#myModal1').modal('toggle');
        }

        function accept(e)
        {
            var invoice_id = $(e).data('id');
            var delivery_date = $(e).data('date');

            $('#invoice_id').val(invoice_id);

            $("#delivery_date_picker").val(delivery_date);
            $("#tool-1").prop("checked", true);
            $("#tool-2").prop("checked", true);

            $("#delivery_address").val('');
            $('#postcode').val('');
            $("#city").val('');

            $('#myModal').modal('toggle');
        }

        function PayNow(e)
        {
            var invoice_id = $(e).data('id');

            $('#pay_invoice_id').val(invoice_id);

            var check = $(e).parent().parent().parent().parent().prev().text();

            if(check !== 'Expired')
            {
                $('#pay_form').submit();
            }
        }

        $('.interval').each(function(i, obj) {

            const second = 1000,
                minute = second * 60,
                hour = minute * 60,
                day = hour * 24;

            var p = $(this);
            var current_stage = p.parent().find('.current-stage');
            var accept_date = $(this).prev().prev().children('input').val();
            var delivery_date = $(this).prev().children('input').val();

            if(accept_date !== '-' && delivery_date !== '-')
            {
                var now1 = new Date(accept_date.toString('M d, Y HH:mm:ss'));
                now1.setHours(now1.getHours()+6);
                now1 = now1.getTime();

                accept_date = accept_date.toString('M d, Y HH:mm:ss');
                var countDown_accept = new Date(accept_date).getTime();

                var end_date = delivery_date.toString('M d, Y HH:mm:ss');
                var countDown_delivery = new Date(end_date).getTime();

                var dif = countDown_delivery - countDown_accept;

                (function () {

                    var end = delivery_date.toString('M d, Y HH:mm:ss');
                    var countDown = new Date(end).getTime();

                    var x = setInterval(function() {

                        var now = new Date().getTime();
                        var distance = countDown - now;

                        if(Math.floor(dif / (day)) >= 3)
                        {
                            var interval = (Math.floor(distance / (day)) - 2) + 'd ' + Math.floor((distance % (day)) / (hour)) + 'h ' + Math.floor((distance % (hour)) / (minute)) + 'm ' + Math.floor((distance % (minute)) / second) + 's';

                            //do something later when date is reached
                            if ((Math.floor(distance / (day)) - 2) < 0) {

                                p.next().find('.pay_now').css('cursor', 'not-allowed').css('background', 'white');
                                current_stage.children('a').addClass('disabled');
                                p.text('Expired');
                                clearInterval(x);

                            }
                            else
                            {
                                p.text(interval);
                            }
                        }
                        else
                        {
                            var distance1 = now1 - now;

                            var interval = '0d ' + Math.floor((distance1 % (day)) / (hour)) + 'h ' + Math.floor((distance1 % (hour)) / (minute)) + 'm ' + Math.floor((distance1 % (minute)) / second) + 's';

                            //do something later when date is reached
                            if (Math.floor((distance1 % (day)) / (hour)) <= 0 && Math.floor((distance1 % (hour)) / (minute)) <= 0 && Math.floor((distance1 % (minute)) / second) <= 0) {

                                p.next().find('.pay_now').css('cursor', 'not-allowed').css('background', 'white');
                                current_stage.children('a').addClass('disabled');
                                p.text('Expired');
                                clearInterval(x);

                            }
                            else
                            {
                                p.text(interval);
                            }
                        }

                        //seconds
                    }, 0)
                }());
            }
            else
            {
                p.text('-');
            }

        });

        $('#example').DataTable({
            order: [[0, 'desc']],
            "oLanguage": {
                "sLengthMenu": "<?php echo __('text.Show') . ' _MENU_ ' . __('text.records'); ?>",
                "sSearch": "<?php echo __('text.Search') . ':' ?>",
                "sInfo": "<?php echo __('text.Showing') . ' _START_ ' . __('text.to') . ' _END_ ' . __('text.of') . ' _TOTAL_ ' . __('text.items'); ?>",
                "oPaginate": {
                    "sPrevious": "<?php echo __('text.Previous'); ?>",
                    "sNext": "<?php echo __('text.Next'); ?>"
                },
                "sEmptyTable": '<?php echo __('text.No data available in table'); ?>'
            }
        });
    </script>

@endsection
