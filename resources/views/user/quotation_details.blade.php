@extends('layouts.handyman')

@section('content')

    <div class="right-side">

        <div class="container-fluid">
            <div class="row">

                <form id="form-quote" style="padding: 0;" class="form-horizontal" action="{{route('update-details')}}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}

                    <input type="hidden" name="invoice_id" value="{{$invoices[0]->invoice_id}}">

                    <div style="margin: 0;" class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <!-- Starting of Dashboard data-table area -->
                            <div class="section-padding add-product-1" style="padding: 0;">

                                <div style="margin: 0;" class="row">
                                    <div style="padding: 0;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div style="box-shadow: none;" class="add-product-box">
                                            <div class="add-product-header products">

                                                <h2>Quotation Details</h2>

                                                <div style="background-color: black;border-radius: 10px;padding: 0 10px;">

                                                    <span class="tooltip1 save-data" style="cursor: pointer;font-size: 20px;margin-right: 10px;color: white;">
															<i class="fa fa-fw fa-save"></i>
															<span class="tooltiptext">Save</span>
                                                    </span>

                                                    <a href="{{route('customer-quotations')}}" class="tooltip1" style="cursor: pointer;font-size: 20px;color: white;">
                                                        <i class="fa fa-fw fa-close"></i>
                                                        <span class="tooltiptext">Close</span>
                                                    </a>

                                                </div>

                                            </div>
                                            <hr>
                                            <div>

                                                <div class="alert-box">

                                                </div>

                                                @include('includes.form-success')

                                                <div style="padding-bottom: 0;" class="form-horizontal">

                                                    <div style="margin: 0;background: #f5f5f5;" class="row">

                                                        <div style="justify-content: flex-end;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 first-row">

                                                        </div>

                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 second-row" style="padding-bottom: 15px;">

                                                            <table id="products_table" style="width: 100%;">
                                                                <thead>
                                                                <tr>
                                                                    <th style="padding: 5px;"></th>
                                                                    <th>Product</th>
                                                                    <th>Qty</th>
                                                                    <th>Order Date</th>
                                                                    <th>Ordered</th>
                                                                    <th>Delivery Date</th>
                                                                    <th>Supplier Delivery Date</th>
                                                                    <th>Supplier</th>
                                                                </tr>
                                                                </thead>

                                                                <tbody>

                                                                @foreach($invoices as $i => $item)

                                                                    <tr class="active">

                                                                        <td>{{$i+1}}</td>

                                                                        <td class="products">
                                                                            @if($item->item_id)

                                                                                {{$item->item . ', Item'}}

                                                                            @elseif($item->service_id)

                                                                                {{$item->service . ', Service'}}

                                                                            @else

                                                                                {{$item->product_title . ', '. $item->model . ', ' . $item->color_title}}

                                                                            @endif
                                                                        </td>
                                                                        <td>{{str_replace('.', ',',floatval($item->qty))}}</td>
                                                                        <td>
                                                                            @if(isset($item->item_id) || isset($item->service_id))

                                                                                <input style="border: 0;outline: none;width: 100%;" autocomplete="off" value="{{$item->order_date ? date('d-m-Y',strtotime($item->order_date)) : null}}" type="text" class="order_date" name="order_dates[]">

                                                                            @else

                                                                                {{$item->order_date ? date('d-m-Y',strtotime($item->order_date)) : null}}

                                                                            @endif
                                                                        </td>
                                                                        <td>

                                                                            @if(isset($item->item_id) || isset($item->service_id))

                                                                                <input type="hidden" value="{{$item->id}}" name="data_id[]">

                                                                                <select class="form-control" name="order_sent[]">

                                                                                    <option {{$item->order_sent == 0 ? 'selected' : null}} value="0">No</option>
                                                                                    <option {{$item->order_sent == 1 ? 'selected' : null}} value="1">Yes</option>

                                                                                </select>

                                                                            @else

                                                                                <input type="hidden" value="{{$item->id}}" name="order_id[]">

                                                                                {{$item->order_sent ? 'Yes' : 'No'}}

                                                                            @endif

                                                                        </td>

                                                                        <td style="padding: 0;">
                                                                            @if(isset($item->item_id) || isset($item->service_id))

                                                                                <input style="border: 0;outline: none;width: 100%;" autocomplete="off" value="{{$item->delivery_date ? date('d-m-Y',strtotime($item->delivery_date)) : null}}" type="text" class="delivery_date" name="delivery_dates[]">

                                                                            @else

                                                                                <input style="border: 0;outline: none;width: 100%;" autocomplete="off" value="{{$item->retailer_delivery_date ? date('d-m-Y',strtotime($item->retailer_delivery_date)) : null}}" type="text" class="delivery_date" name="order_delivery_dates[]">

                                                                            @endif
                                                                        </td>

                                                                        <td>{{isset($item->item_id) || isset($item->service_id) ? null : ($item->delivery_date ? date('d-m-Y',strtotime($item->delivery_date)) : null)}}</td>

                                                                        <td>
                                                                            @if(isset($item->item_id) || isset($item->service_id))

                                                                                <select class="form-control" name="suppliers[]">

                                                                                    <option value="">Select Supplier</option>

                                                                                    @foreach($suppliers as $key)

                                                                                        <option {{$item->supplier_id == $key->id ? 'selected' : null}} value="{{$key->id}}">{{$key->company_name}}</option>

                                                                                    @endforeach

                                                                                </select>

                                                                            @else

                                                                                {{$item->company_name}}

                                                                            @endif
                                                                        </td>

                                                                    </tr>

                                                                @endforeach

                                                                </tbody>

                                                            </table>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- Ending of Dashboard data-table area -->
                    </div>

                </form>

            </div>

        </div>

    </div>

    <div id="cover"></div>

    <style>

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
            min-width: 60% !important;
            height: 45%;
            overflow-y: auto;
            z-index: 10000 !important;
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
            /*-webkit-appearance: none !important;*/
            /*-moz-appearance: none !important;*/
            /*text-indent: 1px !important;*/
            /*text-overflow: '' !important;*/
            border: none !important;
            padding: 0 !important;
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

        .swal2-html-container
        {
            line-height: 2;
        }

        a.info {
            vertical-align: bottom;
            position:relative; /* Anything but static */
            width: 1.5em;
            height: 1.5em;
            text-indent: -9999em;
            display: inline-block;
            color: white;
            font-weight:bold;
            font-size:1em;
            line-height:1em;
            background-color:#628cb6;
            cursor: pointer;
            margin-top: 7px;
            -webkit-border-radius:.75em;
            -moz-border-radius:.75em;
            border-radius:.75em;
        }

        a.info:before {
            content:"i";
            position: absolute;
            top: .25em;
            left:0;
            text-indent: 0;
            display:block;
            width:1.5em;
            text-align:center;
            font-family: monospace;
        }

        .ladderband-btn
        {
            background-color: #494949 !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered
        {
            line-height: 25px;
        }

        #cover {
            background: url(<?php echo asset('assets/images/page-loader.gif'); ?>) no-repeat scroll center center #ffffff78;
            position: fixed;
            z-index: 100000;
            height: 100%;
            width: 100%;
            margin: auto;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            background-size: 8%;
            display: none;
        }

        .pac-container
        {
            z-index: 1000000;
        }

        #cus-box .select2-container--default .select2-selection--single .select2-selection__rendered
        {
            line-height: 28px;
        }

        #cus-box .select2-container--default .select2-selection--single
        {
            border:1px solid #cacaca;
        }

        #cus-box .select2-selection
        {
            height: 40px !important;
            padding-top: 5px !important;
            outline: none;
        }

        #cus-box .select2-selection__arrow
        {
            top: 7.5px !important;
        }

        #cus-box .select2-selection__clear
        {
            display: none;
        }

        .feature-tab li a[aria-expanded="false"]::before, a[aria-expanded="true"]::before
        {
            display: none;
        }

        .m-box
        {
            display: flex;
            align-items: center;
        }

        .m-input
        {
            border-radius: 5px !important;
            width: 70%;
            border: 0;
            padding: 0;
            padding-right: 5px;
            text-align: right;
            height: 30px !important;
        }

        .m-input:focus
        {
            background: #f6f6f6;
        }

        .measure-unit
        {
            width: 50%;
        }

        .select2-container--default .select2-selection--single
        {
            border: 0;
        }

        .tooltip1 {
            position: relative;
            display: inline-block;
            cursor: pointer;
            font-size: 20px;
        }

        /* Tooltip text */
        .tooltip1 .tooltiptext {
            visibility: hidden;
            width: auto;
            min-width: 60px;
            background-color: #7e7e7e;
            color: #fff;
            text-align: center;
            padding: 5px 0;
            border-radius: 6px;
            position: absolute;
            z-index: 1;
            left: 0;
            top: 55px;
            font-size: 12px;
        }

        /* Show the tooltip text when you mouse over the tooltip container */
        .tooltip1:hover .tooltiptext {
            visibility: visible;
        }

        .first-row
        {
            flex-direction: row;
            box-sizing: border-box;
            display: flex;
            background-color: rgb(151, 140, 135);
            height: 50px;
            color: white;
            font-size: 13px;
            align-items: center;
            white-space: nowrap;
            justify-content: space-between;
        }

        .second-row
        {
            padding: 25px;
            display: flex;
            flex-direction: column;
            background: #fff;
            overflow-y: hidden;
            overflow-x: auto;
        }

        table tr th
        {
            font-family: system-ui;
            font-weight: 500;
            border-bottom: 1px solid #ebebeb;
            padding-bottom: 15px;
            color: gray;
        }

        table tbody tr td
        {
            font-family: system-ui;
            font-weight: 500;
            padding: 0 10px;
            color: #3c3c3c;
        }

        table tbody tr.active td
        {
            border-top: 2px solid #cecece;
            border-bottom: 2px solid #cecece;
        }

        table tbody tr.active td:first-child
        {
            border-left: 2px solid #cecece;
            border-bottom-left-radius: 4px;
            border-top-left-radius: 4px;
        }

        table tbody tr.active td:last-child {
            border-right: 2px solid #cecece;
            border-bottom-right-radius: 4px;
            border-top-right-radius: 4px;
        }

        table {
            border-collapse:separate;
            border-spacing: 0 1em;
        }


        .modal-body table tr th
        {
            border: 1px solid #ebebeb;
            padding-bottom: 15px;
            color: gray;
        }

        .modal-body table tbody tr td
        {
            border-left: 1px solid #ebebeb;
            border-right: 1px solid #ebebeb;
            border-bottom: 1px solid #ebebeb;
        }

        .modal-body table tbody tr td:first-child
        {
            border-right: 0;
        }

        .modal-body table tbody tr td:last-child {
            border-left: 0;
        }

        .modal-body table {
            border-collapse:separate;
            border-spacing: 0;
            margin: 20px 0;
        }

        .modal-body table tbody tr td, .modal-body table thead tr th
        {
            padding: 5px 10px;
        }

    </style>

@endsection

@section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>

    <script type="text/javascript">

        $(document).ready(function() {

            $('.delivery_date').datepicker({

                format: 'dd-mm-yyyy',
                startDate: new Date(),

            });

            $('.order_date').datepicker({

                format: 'dd-mm-yyyy',
                startDate: new Date(),

            });


            $(document).on('click', '.save-data', function(){

                var flag = 0;

                $("[name='delivery_dates[]']").each(function(i, obj) {

                    if(!obj.value)
                    {
                        flag = 1;
                        $(this).parent().css('border','1px solid red');
                    }
                    else
                    {
                        $(this).parent().css('border','');
                    }

                });

                if(flag == 1)
                {
                    Swal.fire({
                        icon: 'error',
                        title: '{{__('text.Oops...')}}',
                        text: 'Delivery date should not be left empty!',
                    });
                }

                if(!flag)
                {
                    $('#form-quote').submit();
                }

            });


        });
    </script>

@endsection
