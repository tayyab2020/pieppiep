@extends('layouts.admin')

@section('content')

    <div class="right-side">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- Starting of Dashboard data-table area -->
                    <div class="section-padding add-product-1">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="add-product-box">
                                    <div class="add-product-header products">

                                        @if(Route::currentRouteName() == 'view-quotation')

                                            <h2>Quotation</h2>

                                        @else

                                            <h2>Edit Quotation</h2>

                                        @endif

                                    </div>
                                    <hr>
                                    <div>
                                        @include('includes.form-success')

                                        @if(Route::currentRouteName() != 'view-quotation')

                                            <form class="form-horizontal" action="{{route('store-quotation')}}" method="POST" enctype="multipart/form-data">
                                                {{csrf_field()}}

                                                <input type="hidden" name="quote_id" value="{{$quotation[0]->quote_id}}">

                                        @endif

                                        <?php $requested_quote_number = $quotation[0]->quote_number; ?>

                                        <div class="row" style="margin: 0;margin-top: 30px;margin-bottom: 20px;">
                                            <div class="col-md-4" style="margin: 10px 0px;">
                                                <div class="form-group" style="margin: 0;">
                                                    <label>Request Number</label>
                                                    <input type="text" value="{{$requested_quote_number}}" class="form-control" @if(Route::currentRouteName() == 'view-quotation') readonly @endif>
                                                </div>
                                            </div>

                                            <div class="col-md-4" style="margin: 10px 0px;">
                                                <div class="form-group" style="margin: 0;">
                                                    <label>Quotation Number</label>
                                                    <input type="text" value="QUO# {{$quotation[0]->quotation_invoice_number}}" class="form-control" @if(Route::currentRouteName() == 'view-quotation') readonly @endif>
                                                </div>
                                            </div>

                                            <div class="col-md-4" style="margin: 10px 0px;">
                                                <div class="form-group" style="margin: 0;">
                                                    <label>Estimated Date</label>
                                                    <input type="text" name="date" value="{{$quotation[0]->estimated_date}}" class="form-control estimate_date" autocomplete="off" required @if(Route::currentRouteName() == 'view-quotation') disabled @endif>
                                                </div>
                                            </div>

                                            <div class="col-md-4" style="margin: 10px 0px;">
                                                <div class="form-group" style="margin: 0;">
                                                    <label>Delivery Date</label>
                                                    <input type="text" name="delivery_date" value="{{$quotation[0]->delivery_date}}" class="form-control delivery_date" autocomplete="off" required disabled>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="margin: 0;">
                                            <div class="col-sm-12">

                                                    <div class="row" style="margin: 0;margin-top: 35px;">
                                                        <div class="col-md-12 col-sm-12" style="border: 1px solid #e5e5e5;padding: 0;">
                                                            <div class="table-responsive">
                                                                <table class="table table-hover table-white items-table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th style="width: 40px;">#</th>
                                                                        <th class="col-sm-6">Product/Service/Item</th>
                                                                        <th class="col-md-3">Description</th>
                                                                        <th style="width:100px;">Cost</th>
                                                                        <th style="width:120px;">Qty</th>
                                                                        <th style="width: 120px;">Amount</th>
                                                                        <th> </th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                    @foreach($quotation as $i => $temp)

                                                                        <input type="hidden" name="data_id[]" value="{{$temp->data_id}}">

                                                                            <tr>
                                                                                <td>{{$i + 1}}</td>
                                                                                <td>
                                                                                    <input name="productInput[]" class="form-control" type="text" value="{{$temp->product_title}}" required @if(Route::currentRouteName() == 'view-quotation') readonly @endif>
                                                                                </td>
                                                                                <td>
                                                                                    <textarea style="resize: vertical;" rows="1" name="description[]" class="form-control" @if(Route::currentRouteName() == 'view-quotation') readonly @endif>{{$temp->data_description}}</textarea>
                                                                                </td>
                                                                                <td>
                                                                                    <input name="cost[]" class="form-control" type="text" value="{{$temp->rate}}" required @if(Route::currentRouteName() == 'view-quotation') readonly @endif>
                                                                                </td>
                                                                                <td>
                                                                                    <input name="qty[]" class="form-control" type="text" value="{{$temp->qty}}" required @if(Route::currentRouteName() == 'view-quotation') readonly @endif>
                                                                                </td>
                                                                                <td>
                                                                                    <input name="amount[]" class="form-control" readonly="" value="{{$temp->amount}}" type="text" @if(Route::currentRouteName() == 'view-quotation') readonly @endif>
                                                                                </td>

                                                                                @if(Route::currentRouteName() != 'view-quotation')

                                                                                    @if($i == 0)

                                                                                        <td style="text-align: center;"><a href="javascript:void(0)" class="text-success font-18 add-row" title="Add"><i class="fa fa-plus"></i></a></td>

                                                                                    @else

                                                                                        <td style="text-align: center;"><a href="javascript:void(0)" class="text-danger font-18 remove-row" title="Remove"><i class="fa fa-trash-o"></i></a></td>

                                                                                    @endif

                                                                                @else

                                                                                    <td></td>

                                                                                @endif
                                                                            </tr>

                                                                    @endforeach

                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                            <div class="table-responsive">
                                                                <table class="table table-hover table-white" style="margin-bottom: 0;">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td class="text-right">Sub Total</td>
                                                                        <td style="text-align: right; padding-right: 30px;width: 230px">
                                                                            <input class="form-control text-right" value="{{$temp->subtotal}}" name="sub_total" id="sub_total" readonly="" style="border: 0;background: transparent;box-shadow: none;padding: 0;padding-right: 4px;cursor: default;" type="text">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="5" class="text-right">Tax ({{$temp->vat_percentage}}%)</td>
                                                                        <td style="text-align: right; padding-right: 30px;width: 230px">
                                                                            <input type="hidden" name="vat_percentage" id="vat_percentage" value="{{$temp->vat_percentage}}">
                                                                            <input class="form-control text-right" value="{{$temp->tax}}" name="tax_amount" id="tax_amount" readonly="" style="border: 0;background: transparent;box-shadow: none;padding: 0;padding-right: 4px;cursor: default;" type="text">
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="5" style="text-align: right; font-weight: bold">
                                                                            Grand Total
                                                                        </td>
                                                                        <td id="grand_total_cell" style="text-align: right; padding-right: 30px; font-weight: bold; font-size: 16px;width: 230px">
                                                                            € {{$temp->grand_total}}
                                                                        </td>
                                                                        <input class="form-control text-right" value="{{$temp->grand_total}}" name="grand_total" id="grand_total" type="hidden">
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row" style="margin: 0;margin-top: 30px;margin-bottom: 20px;">
                                                        <div class="col-md-12" style="padding: 0;">
                                                            <div class="form-group" style="margin: 0;">
                                                                <label>Other Information</label>
                                                                <textarea name="other_info" class="form-control" rows="4" @if(Route::currentRouteName() == 'view-quotation') readonly @endif>{{$temp->description}}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @if(Route::currentRouteName() != 'view-quotation')

                                                        <div class="submit-section" style="text-align: center;margin-bottom: 20px;">
                                                            <button style="width: 100px;font-size: 20px;border-radius: 25px;" class="btn btn-primary submit-btn">Update</button>
                                                        </div>

                                                        </div></div>

                                                        </form>

                                                    @else

                                                        </div></div>

                                                    @endif


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


    <style type="text/css">

        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th
        {
            padding: 25px 10px;
            vertical-align: middle;
        }

        .select2-selection
        {
            height: 35px !important;
            padding-top: 3px;
            outline: none;
            border-color: #cacaca !important;
        }

        .select2-selection__arrow
        {
            top: 4.5px !important;
        }

        .select2-selection__clear
        {
            display: none;
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

    </style>



@endsection

@section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

    <script type="text/javascript">

        $(document).ready(function() {

            $('.estimate_date').datepicker({

                format: 'dd-mm-yyyy',
                startDate: new Date(),

            });

            $(".js-data-example-ajax").select2({
                width: '100%',
                height: '200px',
                placeholder: "{{__('text.Select category placeholder')}}",
                allowClear: true,
            });

            $(".js-data-example-ajax1").select2({
                width: '100%',
                height: '200px',
                placeholder: "{{__('text.Select Brand placeholder')}}",
                allowClear: true,
            });

            $(".js-data-example-ajax2").select2({
                width: '100%',
                height: '200px',
                placeholder: "Select Model",
                allowClear: true,
            });

            $(".js-data-example-ajax").change(function(){

                var current = $(this);

                var id = current.val();

                $.ajax({
                    type:"GET",
                    data: "id=" + id ,
                    url: "<?php echo url('/get-quotation-data')?>",
                    success: function(data) {

                        current.parent().children('input').val(data.cat_name);
                        current.parent().next('td').next('td').next('td').children('input').val(data.rate);

                        var vat_percentage = parseInt($('#vat_percentage').val());
                        vat_percentage = vat_percentage + 100;
                        var cost = current.parent().next('td').next('td').next('td').children('input').val();
                        var qty = current.parent().next('td').next('td').next('td').next('td').children('input').val();

                        var amount = cost * qty;

                        amount = parseFloat(amount).toFixed(2);

                        current.parent().next('td').next('td').next('td').next('td').next('td').children('input').val(amount);

                        var amounts = [];
                        $("input[name='amount[]']").each(function() {
                            amounts.push($(this).val());
                        });

                        var grand_total = 0;

                        for (let i = 0; i < amounts.length; ++i) {

                            if(isNaN(parseInt(amounts[i])))
                            {
                                amounts[i] = 0;
                            }

                            grand_total = (parseFloat(amounts[i]) + parseFloat(grand_total)).toFixed(2);
                        }

                        var vat = grand_total/vat_percentage * 100;
                        vat = grand_total - vat;
                        vat = parseFloat(vat).toFixed(2);

                        var sub_total = grand_total - vat;
                        sub_total = parseFloat(sub_total).toFixed(2);

                        $('#sub_total').val(sub_total);
                        $('#tax_amount').val(vat);
                        $('#grand_total').val(grand_total);

                        $('#grand_total_cell').text('€ ' + grand_total);
                    }
                });

            });

            $(".add-row").click(function(){

                var rowCount = $('.items-table tr').length;

                $(".items-table").append('<tr>\n' +
                    '                                                                        <td>'+rowCount+'</td>\n' +
                    '                                                                        <td>\n' +
                    '                                                                             <input name="productInput[]" class="form-control" type="text" required>\n' +
                    '                                                                        </td>\n'+
                    '                                                                        <td>\n' +
                    '                                                                            <textarea style="resize: vertical;" rows="1" name="description[]" class="form-control"></textarea>\n' +
                    '                                                                        </td>\n' +
                    '                                                                        <td>\n' +
                    '                                                                            <input name="cost[]" class="form-control" type="text" required>\n' +
                    '                                                                        </td>\n' +
                    '                                                                        <td>\n' +
                    '                                                                            <input name="qty[]" class="form-control" type="text" required>\n' +
                    '                                                                        </td>\n' +
                    '                                                                        <td>\n' +
                    '                                                                            <input name="amount[]" class="form-control" readonly="" type="text">\n' +
                    '                                                                        </td>\n' +
                    '                                                                        <td style="text-align: center;"><a href="javascript:void(0)" class="text-danger font-18 remove-row" title="Remove"><i class="fa fa-trash-o"></i></a></td>\n' +
                    '                                                                    </tr>');


                $(".js-data-example-ajax").change(function(){

                    var current = $(this);

                    var id = current.val();

                    $.ajax({
                        type:"GET",
                        data: "id=" + id ,
                        url: "<?php echo url('/get-quotation-data')?>",
                        success: function(data) {

                            current.parent().children('input').val(data.cat_name);
                            current.parent().next('td').next('td').next('td').children('input').val(data.rate);

                            var vat_percentage = parseInt($('#vat_percentage').val());
                            vat_percentage = vat_percentage + 100;
                            var cost = current.parent().next('td').next('td').next('td').children('input').val();
                            var qty = current.parent().next('td').next('td').next('td').next('td').children('input').val();

                            var amount = cost * qty;

                            amount = parseFloat(amount).toFixed(2);

                            current.parent().next('td').next('td').next('td').next('td').next('td').children('input').val(amount);

                            var amounts = [];
                            $("input[name='amount[]']").each(function() {
                                amounts.push($(this).val());
                            });

                            var grand_total = 0;

                            for (let i = 0; i < amounts.length; ++i) {

                                if(isNaN(parseInt(amounts[i])))
                                {
                                    amounts[i] = 0;
                                }

                                grand_total = (parseFloat(amounts[i]) + parseFloat(grand_total)).toFixed(2);
                            }

                            var vat = grand_total/vat_percentage * 100;
                            vat = grand_total - vat;
                            vat = parseFloat(vat).toFixed(2);

                            var sub_total = grand_total - vat;
                            sub_total = parseFloat(sub_total).toFixed(2);

                            $('#sub_total').val(sub_total);
                            $('#tax_amount').val(vat);
                            $('#grand_total').val(grand_total);

                            $('#grand_total_cell').text('€ ' + grand_total);
                        }
                    });

                });


                $('.estimate_date').datepicker({

                    format: 'dd-mm-yyyy',
                    startDate: new Date(),

                });

                $(".js-data-example-ajax").select2({
                    width: '100%',
                    height: '200px',
                    placeholder: "{{__('text.Select category placeholder')}}",
                    allowClear: true,
                });

                $(".js-data-example-ajax1").select2({
                    width: '100%',
                    height: '200px',
                    placeholder: "{{__('text.Select Brand placeholder')}}",
                    allowClear: true,
                });

                $(".js-data-example-ajax2").select2({
                    width: '100%',
                    height: '200px',
                    placeholder: "Select Model",
                    allowClear: true,
                });

                $(".remove-row").click(function(){

                    var rowCount = $('.items-table tr').length;

                    $(this).parent().parent().remove();

                    $(".items-table tbody tr").each(function(index) {
                        $(this).children('td:first-child').text(index+1);
                    });

                    var vat_percentage = parseInt($('#vat_percentage').val());
                    vat_percentage = vat_percentage + 100;

                    var amounts = [];
                    $("input[name='amount[]']").each(function() {
                        amounts.push($(this).val());
                    });

                    var grand_total = 0;

                    for (let i = 0; i < amounts.length; ++i) {

                        if(isNaN(parseInt(amounts[i])))
                        {
                            amounts[i] = 0;
                        }

                        grand_total = (parseFloat(amounts[i]) + parseFloat(grand_total)).toFixed(2);
                    }

                    var vat = grand_total/vat_percentage * 100;
                    vat = grand_total - vat;
                    vat = parseFloat(vat).toFixed(2);

                    var sub_total = grand_total - vat;
                    sub_total = parseFloat(sub_total).toFixed(2);

                    $('#sub_total').val(sub_total);
                    $('#tax_amount').val(vat);
                    $('#grand_total').val(grand_total);

                    $('#grand_total_cell').text('€ ' + grand_total);

                });

                $("input[name='cost[]'").keypress(function(e){

                    e = e || window.event;
                    var charCode = (typeof e.which == "undefined") ? e.keyCode : e.which;
                    var val = String.fromCharCode(charCode);

                    if (!val.match(/^[0-9]*\.?[0-9]*$/))  // For characters validation
                    {
                        e.preventDefault();
                    }

                });

                $("input[name='qty[]'").keypress(function(e){

                    e = e || window.event;
                    var charCode = (typeof e.which == "undefined") ? e.keyCode : e.which;
                    var val = String.fromCharCode(charCode);

                    if (!val.match(/^[0-9]*\.?[0-9]*$/))  // For characters validation
                    {
                        e.preventDefault();
                    }

                });

                $("input[name='cost[]'").on('input',function(e){

                    var vat_percentage = parseInt($('#vat_percentage').val());
                    vat_percentage = vat_percentage + 100;
                    var cost = $(this).val();
                    var qty = $(this).parent().next('td').children('input').val();

                    var amount = cost * qty;

                    amount = parseFloat(amount).toFixed(2);

                    $(this).parent().next('td').next('td').children('input').val(amount);

                    var amounts = [];
                    $("input[name='amount[]']").each(function() {
                        amounts.push($(this).val());
                    });

                    var grand_total = 0;

                    for (let i = 0; i < amounts.length; ++i) {

                        if(isNaN(parseInt(amounts[i])))
                        {
                            amounts[i] = 0;
                        }

                        grand_total = (parseFloat(amounts[i]) + parseFloat(grand_total)).toFixed(2);
                    }

                    var vat = grand_total/vat_percentage * 100;
                    vat = grand_total - vat;
                    vat = parseFloat(vat).toFixed(2);

                    var sub_total = grand_total - vat;
                    sub_total = parseFloat(sub_total).toFixed(2);

                    $('#sub_total').val(sub_total);
                    $('#tax_amount').val(vat);
                    $('#grand_total').val(grand_total);

                    $('#grand_total_cell').text('€ ' + grand_total);

                });

                $("input[name='qty[]'").on('input',function(e){

                    var vat_percentage = parseInt($('#vat_percentage').val());
                    vat_percentage = vat_percentage + 100;
                    var qty = $(this).val();
                    var cost = $(this).parent().prev('td').children('input').val();

                    var amount = cost * qty;

                    amount = parseFloat(amount).toFixed(2);

                    $(this).parent().next('td').children('input').val(amount);

                    var amounts = [];
                    $("input[name='amount[]']").each(function() {
                        amounts.push($(this).val());
                    });

                    var grand_total = 0;

                    for (let i = 0; i < amounts.length; ++i) {

                        if(isNaN(parseInt(amounts[i])))
                        {
                            amounts[i] = 0;
                        }

                        grand_total = (parseFloat(amounts[i]) + parseFloat(grand_total)).toFixed(2);
                    }

                    var vat = grand_total/vat_percentage * 100;
                    vat = grand_total - vat;
                    vat = parseFloat(vat).toFixed(2);

                    var sub_total = grand_total - vat;
                    sub_total = parseFloat(sub_total).toFixed(2);

                    $('#sub_total').val(sub_total);
                    $('#tax_amount').val(vat);
                    $('#grand_total').val(grand_total);

                    $('#grand_total_cell').text('€ ' + grand_total);

                });

            });

            $(".remove-row").click(function(){

                var rowCount = $('.items-table tr').length;

                $(this).parent().parent().remove();

                $(".items-table tbody tr").each(function(index) {
                    $(this).children('td:first-child').text(index+1);
                });

                var vat_percentage = parseInt($('#vat_percentage').val());
                vat_percentage = vat_percentage + 100;

                var amounts = [];
                $("input[name='amount[]']").each(function() {
                    amounts.push($(this).val());
                });

                var grand_total = 0;

                for (let i = 0; i < amounts.length; ++i) {

                    if(isNaN(parseInt(amounts[i])))
                    {
                        amounts[i] = 0;
                    }

                    grand_total = (parseFloat(amounts[i]) + parseFloat(grand_total)).toFixed(2);
                }

                var vat = grand_total/vat_percentage * 100;
                vat = grand_total - vat;
                vat = parseFloat(vat).toFixed(2);

                var sub_total = grand_total - vat;
                sub_total = parseFloat(sub_total).toFixed(2);

                $('#sub_total').val(sub_total);
                $('#tax_amount').val(vat);
                $('#grand_total').val(grand_total);

                $('#grand_total_cell').text('€ ' + grand_total);

            });

            $("input[name='cost[]'").keypress(function(e){

                e = e || window.event;
                var charCode = (typeof e.which == "undefined") ? e.keyCode : e.which;
                var val = String.fromCharCode(charCode);

                if (!val.match(/^[0-9]*\.?[0-9]*$/))  // For characters validation
                {
                    e.preventDefault();
                }

            });

            $("input[name='qty[]'").keypress(function(e){

                e = e || window.event;
                var charCode = (typeof e.which == "undefined") ? e.keyCode : e.which;
                var val = String.fromCharCode(charCode);

                if (!val.match(/^[0-9]*\.?[0-9]*$/))  // For characters validation
                {
                    e.preventDefault();
                }

            });

            $("input[name='cost[]'").on('input',function(e){

                var vat_percentage = parseInt($('#vat_percentage').val());
                vat_percentage = vat_percentage + 100;
                var cost = $(this).val();
                var qty = $(this).parent().next('td').children('input').val();

                var amount = cost * qty;

                amount = parseFloat(amount).toFixed(2);

                $(this).parent().next('td').next('td').children('input').val(amount);

                var amounts = [];
                $("input[name='amount[]']").each(function() {
                    amounts.push($(this).val());
                });

                var grand_total = 0;

                for (let i = 0; i < amounts.length; ++i) {

                    if(isNaN(parseInt(amounts[i])))
                    {
                        amounts[i] = 0;
                    }

                    grand_total = (parseFloat(amounts[i]) + parseFloat(grand_total)).toFixed(2);
                }

                var vat = grand_total/vat_percentage * 100;
                vat = grand_total - vat;
                vat = parseFloat(vat).toFixed(2);

                var sub_total = grand_total - vat;
                sub_total = parseFloat(sub_total).toFixed(2);

                $('#sub_total').val(sub_total);
                $('#tax_amount').val(vat);
                $('#grand_total').val(grand_total);

                $('#grand_total_cell').text('€ ' + grand_total);

            });

            $("input[name='qty[]'").on('input',function(e){

                var vat_percentage = parseInt($('#vat_percentage').val());
                vat_percentage = vat_percentage + 100;
                var qty = $(this).val();
                var cost = $(this).parent().prev('td').children('input').val();

                var amount = cost * qty;

                amount = parseFloat(amount).toFixed(2);

                $(this).parent().next('td').children('input').val(amount);

                var amounts = [];
                $("input[name='amount[]']").each(function() {
                    amounts.push($(this).val());
                });

                var grand_total = 0;

                for (let i = 0; i < amounts.length; ++i) {

                    if(isNaN(parseInt(amounts[i])))
                    {
                        amounts[i] = 0;
                    }

                    grand_total = (parseFloat(amounts[i]) + parseFloat(grand_total)).toFixed(2);
                }

                var vat = grand_total/vat_percentage * 100;
                vat = grand_total - vat;
                vat = parseFloat(vat).toFixed(2);

                var sub_total = grand_total - vat;
                sub_total = parseFloat(sub_total).toFixed(2);

                $('#sub_total').val(sub_total);
                $('#tax_amount').val(vat);
                $('#grand_total').val(grand_total);

                $('#grand_total_cell').text('€ ' + grand_total);

            });


        });
    </script>

@endsection
