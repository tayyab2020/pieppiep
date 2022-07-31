@extends('layouts.handyman')

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
                                    <div class="add-product-header products" style="display: block;">
                                        @if(Route::currentRouteName() == 'quotations' || Route::currentRouteName() == 'new-orders' || Route::currentRouteName() == 'new-quotations' || Route::currentRouteName() == 'customer-quotations')

                                            @if(Auth::guard('user')->user()->role_id == 4 || Route::currentRouteName() == 'new-orders')

                                                <h2 style="display: inline-block;">{{__('text.Orders')}}</h2>

                                            @elseif(Route::currentRouteName() == 'new-invoices')

                                                <h2 style="display: inline-block;">{{__('text.Invoices')}}</h2>

                                            @else

                                                <h2 style="display: inline-block;">{{__('text.Quotations')}}</h2>

                                            @endif

                                        @elseif(Route::currentRouteName() == 'commission-invoices')
                                            <h2 style="display: inline-block;">{{__('text.Commission Invoices')}}</h2>
                                        @else
                                            <h2 style="display: inline-block;">{{__('text.Quotation Invoices')}}</h2>
                                        @endif

                                            @if(Route::currentRouteName() == 'customer-quotations')

                                                @if(auth()->user()->can('create-custom-quotation'))

                                                    <a style="float: right;" href="{{route('create-custom-quotation')}}" class="btn add-newProduct-btn"><i class="fa fa-plus"></i> {{__('text.Create New Quotation')}}</a>

                                                @endif

                                            @elseif(Route::currentRouteName() == 'customer-invoices')

                                                @if(auth()->user()->can('create-direct-invoice'))

                                                    <a style="float: right;margin-right: 10px;" href="{{route('create-direct-invoice')}}" class="btn add-newProduct-btn"><i class="fa fa-plus"></i> {{__('text.Create New Invoice')}}</a>

                                                @endif

                                            @elseif(Route::currentRouteName() == 'new-quotations')

                                                @if(Auth::guard('user')->user()->role_id == 2)

                                                    <a style="float: right;margin-right: 10px;" href="{{route('create-new-quotation')}}" class="btn add-newProduct-btn"><i class="fa fa-plus"></i> {{__('text.Create New Quotation')}}</a>

                                                @endif

                                            @endif
                                    </div>
                                    <hr>
                                    <div>

                                        @include('includes.form-success')
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table id="example" class="table table-striped table-hover products dt-responsive dataTable no-footer dtr-inline" role="grid" aria-describedby="product-table_wrapper_info" style="width: 100%;margin-top: 55px !important;" width="100%" cellspacing="0">
                                                    <thead>

                                                    @if(Route::currentRouteName() == 'new-orders')

                                                        <tr role="row">

                                                            <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending">ID</th>

                                                            <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending" id="client">{{__('text.Quotation Number')}}</th>

                                                            <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending" id="client">{{__('text.Order Number')}}</th>

                                                            <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending" id="handyman">{{__('text.Customer Name')}}</th>

                                                            <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="rate">{{__('text.Current Stage')}}</th>

                                                            <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="date">{{__('text.Action')}}</th>

                                                        </tr>

                                                    @else

                                                        <tr role="row">

                                                            <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending">ID</th>

                                                            <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending" id="client">@if(Route::currentRouteName() == 'quotations' || Route::currentRouteName() == 'new-invoices' || Route::currentRouteName() == 'new-quotations' || Route::currentRouteName() == 'customer-quotations') {{__('text.Quotation Number')}} @else {{__('text.Invoice Number')}} @endif</th>

                                                            @if(Route::currentRouteName() == 'new-invoices')

                                                                <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending" id="client">{{__('text.Invoice Number')}}</th>

                                                            @endif

                                                            @if(Route::currentRouteName() != 'customer-quotations' && Route::currentRouteName() != 'customer-invoices' && Route::currentRouteName() != 'new-quotations' && Route::currentRouteName() != 'new-invoices')

                                                                <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 239px;" aria-sort="ascending" aria-label="Donor's Photo: activate to sort column descending" id="photo">{{__('text.Delivery Date')}}</th>

                                                            @endif

                                                            @if(Route::currentRouteName() != 'customer-quotations' && Route::currentRouteName() != 'customer-invoices' && Route::currentRouteName() != 'new-quotations' && Route::currentRouteName() != 'new-invoices')

                                                                <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 95px;" aria-label="City: activate to sort column ascending" id="serv">{{__('text.Subtotal')}}</th>

                                                                <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending">{{__('text.Tax')}}</th>

                                                            @else

                                                                <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending" id="handyman">{{__('text.Customer Name')}}</th>

                                                            @endif

                                                            @if(Route::currentRouteName() == 'new-quotations')

                                                                @if(Auth::guard('user')->user()->role_id == 2)

                                                                    <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="rate">{{__('text.Grand Total')}}</th>

                                                                @endif

                                                            @else

                                                                <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="rate">{{__('text.Grand Total')}}</th>

                                                            @endif

                                                            @if(Route::currentRouteName() == 'commission-invoices')

                                                                <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="rate">{{__('text.Commission')}} %</th>
                                                                <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="rate">{{__('text.Commission')}}</th>
                                                                <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="rate">{{__('text.Total Receive')}}</th>

                                                            @else

                                                                @if(Route::currentRouteName() != 'new-invoices')

                                                                    <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="rate">{{__('text.Current Stage')}}</th>

                                                                @endif

                                                            @endif

                                                            <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="service">{{__('text.Date')}}</th>

                                                            <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="date">{{__('text.Action')}}</th>

                                                        </tr>

                                                    @endif

                                                    </thead>

                                                    <tbody>

                                                    <?php $t = 1; ?>

                                                    @foreach($invoices as $key)

                                                        @if(Route::currentRouteName() == 'new-orders')

                                                            <?php $sup_data = $key->orders->unique('supplier_id'); ?>

                                                            @foreach($sup_data as $sup)

                                                                <tr role="row" class="odd">

                                                                    <td>{{$t}}</td>

                                                                    <td><a href="">OF# {{$key->quotation_invoice_number}}</a></td>

                                                                    <td><a href="">OR# {{$sup->order_number}}</a></td>

                                                                    <td>{{$key->name}} {{$key->family_name}}</td>

                                                                    <td>

                                                                        @if($sup->delivered)

                                                                            <span class="btn btn-success">{{__('text.Order Delivered')}}</span>

                                                                        @elseif($sup->approved)

                                                                            <span class="btn btn-success">{{__('text.Order Confirmed')}}</span>

                                                                        @elseif($sup->order_sent)

                                                                            <span class="btn btn-success">{{__('text.Order Sent')}}</span>

                                                                        @else

                                                                            <span class="btn btn-warning">{{__('text.Confirmation Pending')}}</span>

                                                                        @endif

                                                                    </td>

                                                                    <td>
                                                                        <div class="dropdown">
                                                                            <button style="outline: none;" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">{{__('text.Action')}}
                                                                                <span class="caret"></span></button>
                                                                            <ul class="dropdown-menu">

                                                                                @if($sup->approved)

                                                                                    <li><a href="{{ url('/aanbieder/download-order-confirmation-pdf/'.$sup->id) }}">{{__('text.Download Order Confirmation PDF')}}</a></li>
                                                                                    <li><a href="{{ url('/aanbieder/download-order-pdf/'.$sup->id) }}">{{__('text.Download Order PDF')}}</a></li>

                                                                                @elseif($sup->order_sent)

                                                                                    <li><a href="{{ url('/aanbieder/download-order-pdf/'.$sup->id) }}">{{__('text.Download Order PDF')}}</a></li>

                                                                                @endif

                                                                                <li><a href="{{ url('/aanbieder/download-new-quotation/'.$key->invoice_id) }}">{{__('text.Download PDF')}}</a></li>

                                                                                @if(!$sup->order_sent)
                                                                                
                                                                                    <li><a href="{{ url('/aanbieder/edit-order/'.$sup->id) }}">{{__('text.Edit Order')}}</a></li>

                                                                                @endif

                                                                            </ul>
                                                                        </div>
                                                                    </td>
                                                                </tr>

                                                                <?php $t = $t + 1; ?>

                                                            @endforeach

                                                        @else

                                                            <tr role="row" class="odd">

                                                                <td>{{$key->invoice_id}}</td>

                                                                @if(Route::currentRouteName() == 'customer-quotations' || Route::currentRouteName() == 'customer-invoices' || Route::currentRouteName() == 'new-quotations' || Route::currentRouteName() == 'new-invoices')

                                                                    <td><a @if(Route::currentRouteName() == 'new-quotations' || Route::currentRouteName() == 'new-invoices') href="" @else href="{{ url('/aanbieder/bekijk-eigen-offerte/'.$key->invoice_id) }}" @endif>@if(Auth::guard('user')->user()->role_id == 4) OR# {{$key->order_number}} @else OF# {{$key->quotation_invoice_number}} @endif</a></td>

                                                                @else

                                                                    <td><a href="{{ url('/aanbieder/bekijk-offerte/'.$key->invoice_id) }}">@if(Route::currentRouteName() == 'quotations') QUO# @else INV# @endif {{$key->quotation_invoice_number}}</a></td>

                                                                    <?php
                                                                    $requested_quote_number = $key->quote_number;
                                                                    if($key->delivery_date){ $delivery_date = date("d-m-Y",strtotime($key->delivery_date)); }else{ $delivery_date = ''; }
                                                                    ?>

                                                                    <td><a href="{{ url('/aanbieder/bekijk-offerteaanvraag-aanbieder/'.$key->id) }}">{{$delivery_date}}</a></td>

                                                                @endif

                                                                @if(Route::currentRouteName() == 'new-invoices')

                                                                    <td>{{$key->invoice_number}}</td>

                                                                @endif

                                                                @if(Route::currentRouteName() != 'customer-quotations' && Route::currentRouteName() != 'customer-invoices' && Route::currentRouteName() != 'new-quotations' && Route::currentRouteName() != 'new-invoices')

                                                                    <td>{{number_format((float)$key->subtotal, 2, ',', '.')}}</td>
                                                                    <td>{{number_format((float)$key->tax, 2, ',', '.')}}</td>

                                                                @else

                                                                    <td>{{$key->name}} {{$key->family_name}}</td>

                                                                @endif


                                                                @if(Route::currentRouteName() == 'new-quotations')

                                                                    @if(Auth::guard('user')->user()->role_id == 2)

                                                                        <td>{{number_format((float)$key->grand_total, 2, ',', '.')}}</td>

                                                                    @endif

                                                                @else

                                                                    <td>{{number_format((float)$key->grand_total, 2, ',', '.')}}</td>

                                                                @endif


                                                                @if(Route::currentRouteName() == 'commission-invoices')

                                                                    <td>{{$key->commission_percentage}}</td>
                                                                    <td>{{number_format((float)$key->commission, 2, ',', '.')}}</td>
                                                                    <td>{{number_format((float)$key->total_receive, 2, ',', '.')}}</td>

                                                                @else

                                                                    @if(Route::currentRouteName() != 'new-invoices')

                                                                        <td>

                                                                            @if(Route::currentRouteName() == 'quotations' || Route::currentRouteName() == 'new-quotations' || Route::currentRouteName() == 'customer-quotations' || Route::currentRouteName() == 'customer-invoices')

                                                                                @if($key->status == 3)

                                                                                    @if($key->received)

                                                                                        <span class="btn btn-success">{{__('text.Goods Received')}}</span>

                                                                                    @elseif($key->delivered)

                                                                                        <span class="btn btn-success">{{__('text.Goods Delivered')}}</span>
                                                                                    @else

                                                                                        <span class="btn btn-success">{{__('text.Invoice Generated')}}</span>

                                                                                    @endif

                                                                                @elseif($key->status == 2)

                                                                                    @if(Route::currentRouteName() == 'new-quotations')

                                                                                        @if($key->accepted)

                                                                                            @if($key->processing)

                                                                                                <span class="btn btn-success">{{__('text.Order Processing')}}</span>

                                                                                            @elseif($key->finished)

                                                                                                @if(Auth::guard('user')->user()->role_id == 2)

                                                                                                    @if($key->retailer_delivered)

                                                                                                        <span class="btn btn-success">{{__('text.Delivered')}}</span>

                                                                                                    @else

                                                                                                        <?php $data = $key->data->unique('supplier_id'); $filteredData = $data->reject(function ($value, $key) {
                                                                                                            return $value['approved'] !== 1;
                                                                                                        }); ?>

                                                                                                        @if($filteredData->count() === $data->count())

                                                                                                            @if($data->contains('delivered',1))

                                                                                                                <?php $filteredData2 = $data->reject(function ($value, $key) {
                                                                                                                    return $value['delivered'] !== 1;
                                                                                                                }); ?>

                                                                                                                @if($filteredData2->count() === $data->count())

                                                                                                                    <span class="btn btn-success">{{__('text.Delivered by supplier(s)')}}</span>

                                                                                                                @elseif($filteredData2->count() == 0)

                                                                                                                    <span class="btn btn-success">{{__('text.Confirmed by supplier(s)')}}</span>

                                                                                                                @else

                                                                                                                    <span class="btn btn-success">{{$filteredData2->count()}}/{{$data->count()}} {{__('text.Delivered Order')}}</span>

                                                                                                                @endif

                                                                                                            @else

                                                                                                                <span class="btn btn-success">{{__('text.Confirmed by supplier(s)')}}</span>

                                                                                                            @endif

                                                                                                        @elseif($filteredData->count() == 0)

                                                                                                            <span class="btn btn-warning">{{__('text.Confirmation Pending')}}</span>

                                                                                                        @else

                                                                                                            <span class="btn btn-success">{{$filteredData->count()}}/{{$data->count()}} {{__('text.Confirmed')}}</span>

                                                                                                        @endif

                                                                                                    @endif

                                                                                                @else

                                                                                                    @if($key->data_processing)

                                                                                                        <span class="btn btn-warning">{{__('text.Processing')}}</span>

                                                                                                    @elseif($key->data_delivered)

                                                                                                        <span class="btn btn-success">{{__('text.Order Delivered')}}</span>

                                                                                                    @elseif($key->data_approved)

                                                                                                        <span class="btn btn-success">{{__('text.Order Confirmed')}}</span>

                                                                                                    @else

                                                                                                        <span class="btn btn-warning">{{__('text.Confirmation Pending')}}</span>

                                                                                                    @endif

                                                                                                @endif

                                                                                            @else

                                                                                                <span class="btn btn-primary1">{{__('text.Quotation Accepted')}}</span>

                                                                                            @endif

                                                                                        @else

                                                                                            <span class="btn btn-success">{{__('text.Closed')}}</span>

                                                                                        @endif

                                                                                    @else

                                                                                        @if($key->accepted)

                                                                                            <span class="btn btn-primary1">{{__('text.Quotation Accepted')}}</span>

                                                                                        @else

                                                                                            <span class="btn btn-success">{{__('text.Closed')}}</span>

                                                                                        @endif

                                                                                    @endif

                                                                                @else

                                                                                    @if($key->ask_customization)

                                                                                        <span class="btn btn-info">{{__('text.Asking for Review')}}</span>

                                                                                    @elseif($key->approved)

                                                                                        @if(Route::currentRouteName() == 'new-quotations')

                                                                                            <span class="btn btn-success">{{__('text.Quotation Sent')}}</span>

                                                                                        @else

                                                                                            <span class="btn btn-success">{{__('text.Quotation Approved')}}</span>

                                                                                        @endif

                                                                                    @else

                                                                                        <span class="btn btn-warning">{{__('text.Pending')}}</span>

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

                                                                    @endif

                                                                @endif


                                                                <?php $date = strtotime($key->invoice_date);

                                                                $date = date('d-m-Y',$date);  ?>

                                                                <td>{{$date}}</td>

                                                                <td>
                                                                    <div class="dropdown">
                                                                        <button style="outline: none;" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">{{__('text.Action')}}
                                                                            <span class="caret"></span></button>
                                                                        <ul class="dropdown-menu">

                                                                            @if(Route::currentRouteName() == 'new-invoices')

                                                                                <li><a href="{{ url('/aanbieder/download-invoice-pdf/'.$key->invoice_id) }}">{{__('text.Download Invoice PDF')}}</a></li>

                                                                                @if(!$key->invoice_sent)

                                                                                    <li><a class="send-new-invoice" data-id="{{$key->invoice_id}}" href="javascript:void(0)">{{__('text.Send Invoice')}}</a></li>

                                                                                @endif

                                                                            @else

                                                                                @if(Route::currentRouteName() == 'customer-quotations' || Route::currentRouteName() == 'customer-invoices')


                                                                                    @if(auth()->user()->can('view-custom-quotation'))

                                                                                        <li><a href="{{ url('/aanbieder/bekijk-eigen-offerte/'.$key->invoice_id) }}">{{__('text.View')}}</a></li>

                                                                                    @endif


                                                                                    @if(auth()->user()->can('download-custom-quotation'))

                                                                                        <li><a href="{{ url('/aanbieder/download-custom-quotation/'.$key->invoice_id) }}">{{__('text.Download PDF')}}</a></li>

                                                                                    @endif


                                                                                    @if(!$key->approved)

                                                                                        @if(auth()->user()->can('send-custom-quotation'))

                                                                                            <li><a href="{{ url('/aanbieder/versturen-eigen-offerte/'.$key->invoice_id) }}">{{__('text.Send Quotation')}}</a></li>

                                                                                        @endif

                                                                                    @endif


                                                                                    @if($key->status == 2 && $key->accepted)

                                                                                        @if(auth()->user()->can('create-custom-invoice'))

                                                                                            <li><a href="{{ url('/aanbieder/opstellen-eigen-factuur/'.$key->invoice_id) }}">{{__('text.Create Invoice')}}</a></li>

                                                                                        @endif

                                                                                    @endif


                                                                                    @if($key->status != 2 && $key->status != 3)

                                                                                        @if($key->ask_customization)

                                                                                            <li><a onclick="ask(this)" data-text="{{$key->review_text}}" href="javascript:void(0)">{{__('text.Review Reason')}}</a></li>

                                                                                        @endif


                                                                                        @if(auth()->user()->can('edit-custom-quotation'))

                                                                                            <li><a href="{{ url('/aanbieder/bewerk-eigen-offerte/'.$key->invoice_id) }}">{{__('text.Edit Quotation')}}</a></li>

                                                                                        @endif

                                                                                    @endif


                                                                                    @if($key->status == 3 && $key->delivered == 0)

                                                                                        @if(auth()->user()->can('custom-mark-delivered'))

                                                                                            <li><a href="{{ url('/aanbieder/custom-mark-delivered/'.$key->invoice_id) }}">{{__('text.Mark as delivered')}}</a></li>

                                                                                        @endif

                                                                                    @endif

                                                                                @else

                                                                                    @if(Route::currentRouteName() == 'new-quotations')

                                                                                        @if(Auth::guard('user')->user()->role_id == 2)

                                                                                            @if(!$key->invoice)

                                                                                                <li><a href="{{ url('/aanbieder/create-new-invoice/'.$key->invoice_id) }}">{{__('text.Create Invoice')}}</a></li>

                                                                                            @else

                                                                                                <li><a href="{{ url('/aanbieder/download-invoice-pdf/'.$key->invoice_id) }}">{{__('text.Download Invoice PDF')}}</a></li>

                                                                                                @if(!$key->invoice_sent)

                                                                                                    <li><a class="send-new-invoice" data-id="{{$key->invoice_id}}" href="javascript:void(0)">{{__('text.Send Invoice')}}</a></li>

                                                                                                @endif

                                                                                            @endif

                                                                                        @endif

                                                                                        @if($key->status != 2 && $key->status != 3)

                                                                                            @if($key->ask_customization)

                                                                                                <li><a onclick="ask(this)" data-text="{{$key->review_text}}" href="javascript:void(0)">{{__('text.Review Reason')}}</a></li>

                                                                                            @endif

                                                                                            @if($key->status == 1)

                                                                                                <li><a href="{{ url('/aanbieder/accept-new-quotation/'.$key->invoice_id) }}">{{__('text.Accept')}}</a></li>

                                                                                            @endif

                                                                                            @if($key->status == 0 || $key->ask_customization)

                                                                                                <li><a href="{{ url('/aanbieder/view-new-quotation/'.$key->invoice_id) }}">{{__('text.View Quotation')}}</a></li>

                                                                                            @endif

                                                                                        @endif

                                                                                        @if($key->accepted && !$key->processing && !$key->finished)

                                                                                            <li><a class="send-new-order" data-id="{{$key->invoice_id}}" data-date="{{$key->delivery_date ? date('Y-m-d',strtotime($key->delivery_date)) : null}}" href="javascript:void(0)">{{__('text.Send Order')}}</a></li>

                                                                                        @endif

                                                                                        @if(Auth::guard('user')->user()->role_id == 4)

                                                                                            @if(!$key->data_delivered && !$key->data_processing)

                                                                                                <li><a href="{{ url('/aanbieder/change-delivery-dates/'.$key->invoice_id) }}">{{__('text.Edit Delivery Dates')}}</a></li>

                                                                                            @endif

                                                                                            @if($key->data_approved && !$key->data_delivered)

                                                                                                <li><a href="{{ url('/aanbieder/supplier-order-delivered/'.$key->invoice_id) }}">{{__('text.Mark as delivered')}}</a></li>

                                                                                            @endif

                                                                                        @else

                                                                                            @if($key->delivered && !$key->retailer_delivered)

                                                                                                <li><a href="{{ url('/aanbieder/retailer-mark-delivered/'.$key->invoice_id) }}">{{__('text.Mark as delivered')}}</a></li>

                                                                                            @endif

                                                                                            @if($key->status == 2)

                                                                                                @if($key->finished)

                                                                                                    <?php $data = $key->data->unique('supplier_id'); ?>

                                                                                                    @foreach($data as $d => $data1)

                                                                                                        <li><a href="{{ url('/aanbieder/download-order-pdf/'.$data1->id) }}">{{__('text.Download Supplier :attribute Order PDF',['attribute' => $d+1])}}</a></li>

                                                                                                    @endforeach

                                                                                                @endif

                                                                                                <?php $data = $key->data->unique('supplier_id'); ?>

                                                                                                @foreach($data as $d => $data1)

                                                                                                    @if($data1->approved)

                                                                                                        <li><a href="{{ url('/aanbieder/download-order-confirmation-pdf/'.$data1->id) }}">{{__('text.Download Supplier :attribute Order Confirmation PDF',['attribute' => $d+1])}}</a></li>

                                                                                                    @endif

                                                                                                @endforeach

                                                                                            @endif

                                                                                        @endif

                                                                                        @if(Auth::guard('user')->user()->role_id == 4)

                                                                                            @if($key->data_approved)

                                                                                                <li><a href="{{ url('/aanbieder/download-order-confirmation-pdf/'.$key->data_id) }}">{{__('text.Download Order Confirmation PDF')}}</a></li>

                                                                                            @endif

                                                                                            <li><a href="{{ url('/aanbieder/download-order-pdf/'.$key->data_id) }}">{{__('text.Download Order PDF')}}</a></li>

                                                                                        @else

                                                                                            <li><a href="{{ url('/aanbieder/download-new-quotation/'.$key->invoice_id) }}">{{__('text.Download PDF')}}</a></li>

                                                                                        @endif

                                                                                        @if(!$key->approved)

                                                                                            <li><a class="send-new-quotation" data-id="{{$key->invoice_id}}" href="javascript:void(0)">{{__('text.Send Quotation')}}</a></li>

                                                                                        @endif

                                                                                    @else

                                                                                        @if(auth()->user()->can('view-handyman-quotation'))

                                                                                            <li><a href="{{ url('/aanbieder/bekijk-offerte/'.$key->invoice_id) }}">{{__('text.View')}}</a></li>

                                                                                        @endif


                                                                                        @if(auth()->user()->can('handyman-quote-request'))

                                                                                            <li><a href="{{ url('/aanbieder/bekijk-offerteaanvraag-aanbieder/'.$key->id) }}">{{__('text.View Request')}}</a></li>

                                                                                        @endif


                                                                                        @if(Route::currentRouteName() == 'commission-invoices')

                                                                                            @if(auth()->user()->can('download-commission-invoice'))

                                                                                                <li><a href="{{ url('/aanbieder/download-commission-invoice/'.$key->invoice_id) }}">{{__('text.Download PDF')}}</a></li>

                                                                                            @endif

                                                                                        @else

                                                                                            @if(auth()->user()->can('download-quote-invoice'))

                                                                                                <li><a href="{{ url('/aanbieder/download-quote-invoice/'.$key->invoice_id) }}">{{__('text.Download PDF')}}</a></li>

                                                                                            @endif

                                                                                        @endif


                                                                                        @if($key->status == 2 && $key->accepted)

                                                                                            @if(auth()->user()->can('create-handyman-invoice'))

                                                                                                <li><a href="{{ url('/aanbieder/opstellen-factuur/'.$key->invoice_id) }}">{{__('text.Create Invoice')}}</a></li>

                                                                                            @endif

                                                                                        @elseif($key->status == 1)

                                                                                            @if($key->ask_customization)

                                                                                                <li><a onclick="ask(this)" data-text="{{$key->review_text}}" href="javascript:void(0)">{{__('text.Review Reason')}}</a></li>

                                                                                                @if(auth()->user()->can('edit-handyman-quotation'))

                                                                                                    <li><a href="{{ url('/aanbieder/bewerk-offerte/'.$key->invoice_id) }}">{{__('text.Edit Quotation')}}</a></li>

                                                                                                @endif

                                                                                            @endif

                                                                                        @endif

                                                                                        @if($key->status == 3 && $key->delivered == 0)

                                                                                            @if(auth()->user()->can('mark-delivered'))

                                                                                                <li><a href="{{ url('/aanbieder/mark-delivered/'.$key->invoice_id) }}">{{__('text.Mark as delivered')}}</a></li>

                                                                                            @endif

                                                                                        @endif

                                                                                    @endif

                                                                                @endif

                                                                            @endif

                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>

                                                        @endif

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

    <div id="myModal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">
                        <button style="font-size: 32px;background-color: white !important;color: black !important;" type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 style="margin: 10px 0;" id="myModalLabel">{{__('text.Review Reason')}}</h3>
                    </div>

                    <div class="modal-body" id="myWizard">

                        <textarea rows="5" style="resize: vertical;" type="text" name="review_text" id="review_text" class="form-control" readonly autocomplete="off"></textarea>

                    </div>

                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" aria-label="Close" style="border: 0;outline: none;background-color: #e5e5e5 !important;color: black !important;" class="btn back">{{__('text.Close')}}</button>
                    </div>

                </div>

        </div>
    </div>

    @if(Route::currentRouteName() == 'new-quotations')

        <div id="myModal2" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <form id="send-quotation-form" action="{{route('send-new-quotation')}}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}

                    <input type="hidden" name="quotation_id" id="quotation_id">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{__('text.Quotation Mail Body')}}</h4>
                        </div>
                        <div class="modal-body">

                            <div style="margin: 20px 0;" class="row">
                                <div style="display: flex;flex-direction: column;align-items: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>{{__('text.Quotation Mail Body')}}To:</label>
                                    <input type="text" name="mail_to" class="form-control">
                                </div>
                            </div>

                            <div style="margin: 20px 0;" class="row">
                                <div style="display: flex;flex-direction: column;align-items: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>{{__('text.Quotation Mail Body')}}Subject:</label>
                                    <input type="text" name="mail_subject" class="form-control">
                                </div>
                            </div>

                            <div style="margin: 20px 0;" class="row">
                                <div style="display: flex;flex-direction: column;align-items: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>{{__('text.Quotation Mail Body')}}Text:</label>
                                    <input type="hidden" name="mail_body">
                                    <div class="summernote"></div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button style="border: 0;outline: none;background-color: #5cb85c !important;" type="button" class="btn btn-primary submit-form">{{__('text.Quotation Mail Body')}}Submit</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>

        <div id="myModal3" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <form id="send-order-form" action="{{route('send-new-order')}}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}

                    <input type="hidden" name="quotation_id1" id="quotation_id1">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{__('text.Order Mail Body')}}</h4>
                        </div>
                        <div class="modal-body">

                            <div style="margin: 20px 0;" class="row">
                                <div style="display: flex;flex-direction: column;align-items: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>{{__('text.Delivery Date')}}</label>
                                    <input style="height: 45px;margin-bottom: 20px;background: white;" type="text" name="delivery_date" id="delivery_date_picker" class="form-control" placeholder="{{__('text.Select Delivery Date')}}" readonly autocomplete="off">
                                </div>
                            </div>

                            <div style="margin: 20px 0;" class="row">
                                <div style="display: flex;flex-direction: column;align-items: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>{{__('text.Subject')}}:</label>
                                    <input type="text" name="mail_subject1" class="form-control">
                                </div>
                            </div>

                            <div style="margin: 20px 0;" class="row">
                                <div style="display: flex;flex-direction: column;align-items: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>{{__('text.Text')}}:</label>
                                    <input type="hidden" name="mail_body1">
                                    <div class="summernote"></div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button style="border: 0;outline: none;background-color: #5cb85c !important;" type="button" class="btn btn-primary submit-form1">{{__('text.Submit')}}</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>

        <div id="myModal4" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <form id="send-invoice-form" action="{{route('send-new-invoice')}}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}

                    <input type="hidden" name="quotation_id2" id="quotation_id2">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{__('text.Invoice Mail Body')}}</h4>
                        </div>
                        <div class="modal-body">

                            <div style="margin: 20px 0;" class="row">
                                <div style="display: flex;flex-direction: column;align-items: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>{{__('text.To')}}:</label>
                                    <input type="text" name="mail_to2" class="form-control">
                                </div>
                            </div>

                            <div style="margin: 20px 0;" class="row">
                                <div style="display: flex;flex-direction: column;align-items: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>{{__('text.Subject')}}:</label>
                                    <input type="text" name="mail_subject2" class="form-control">
                                </div>
                            </div>

                            <div style="margin: 20px 0;" class="row">
                                <div style="display: flex;flex-direction: column;align-items: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>{{__('text.Text')}}:</label>
                                    <input type="hidden" name="mail_body2">
                                    <div class="summernote"></div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button style="border: 0;outline: none;background-color: #5cb85c !important;" type="button" class="btn btn-primary submit-form2">{{__('text.Submit')}}</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>

    @endif

    <style type="text/css">

        .note-editor
        {
            width: 100%;
        }

        .note-toolbar
        {
            line-height: 1;
        }

        .btn-primary1
        {
            background-color: darkcyan;
            border-color: darkcyan;
            color: white !important;
        }

        @media (min-width: 768px)
        {
            .open>.dropdown-menu
            {
                display: grid;
            }

            .dropdown-menu
            {
                width: 215px;
                overflow: auto;
            }

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

@endsection

@section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

    <script type="text/javascript">

        var todayDate = new Date().getDate();
        var endD = new Date(new Date().setDate(todayDate + 1));

        $('#delivery_date_picker').datepicker({

            format: 'yyyy-mm-dd',
            startDate: endD,

        });

        $('.summernote').summernote({
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['style']],
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                /*['color', ['color']],*/
                ['fontname', ['fontname']],
                ['forecolor', ['forecolor']],
            ],
            height: 200,   //set editable area's height
            codemirror: { // codemirror options
                theme: 'monokai'
            },
            callbacks: {
                onChange: function(contents, $editable) {
                    $(this).prev('input').val(contents);
                }
            }
        });

        $(".send-new-quotation").on('click', function (e) {

            var id = $(this).data('id');

            $.ajax({

                type: "GET",
                data: "id=" + id + '&type=quotation',
                url: "<?php echo url('/aanbieder/get-customer-email')?>",

                success: function (data) {

                    $('#quotation_id').val(id);
                    $("[name='mail_to']").val(data[0]);
                    $("[name='mail_subject']").val(data[1]);
                    $("[name='mail_body']").val(data[2]);
                    $('#myModal2').find(".note-editable").html(data[2]);
                    $('#myModal2').modal('toggle');
                    $('.modal-backdrop').hide();

                },
                error: function (data) {


                }

            });

        });

        $(document).on('click', '.submit-form', function () {

            var flag = 0;

            if(!$("[name='mail_to']").val())
            {
                $("[name='mail_to']").css('border','1px solid red');
                flag = 1;
            }
            else{
                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if(regex.test($("[name='mail_to']").val()))
                {
                    $("[name='mail_to']").css('border','');
                }
                else{
                    $("[name='mail_to']").css('border','1px solid red');
                    flag = 1;
                }
            }

            if(!$("[name='mail_subject']").val())
            {
                $("[name='mail_subject']").css('border','1px solid red');
                flag = 1;
            }
            else{
                $("[name='mail_subject']").css('border','');
            }

            if(!$("[name='mail_body']").val())
            {
                $('#myModal2').find(".note-editable").css('border','1px solid red');
                flag = 1;
            }
            else{
                $('#myModal2').find(".note-editable").css('border','');
            }

            if(!flag)
            {
                $('#send-quotation-form').submit();
            }

        });

        $(".send-new-order").on('click', function (e) {

            var id = $(this).data('id');
            var date = $(this).data('date');

            $.ajax({

                type: "GET",
                data: "id=" + id + '&type=order',
                url: "<?php echo url('/aanbieder/get-customer-email')?>",

                success: function (data) {

                    $('#quotation_id1').val(id);
                    $('#delivery_date_picker').val(date);
                    $("[name='mail_subject1']").val(data[1]);
                    $("[name='mail_body1']").val(data[2]);
                    $('#myModal3').find(".note-editable").html(data[2]);
                    $('#myModal3').modal('toggle');
                    $('.modal-backdrop').hide();

                },
                error: function (data) {


                }

            });

        });

        $(document).on('click', '.submit-form1', function () {

            var flag = 0;

            if(!$("[name='mail_subject1']").val())
            {
                $("[name='mail_subject1']").css('border','1px solid red');
                flag = 1;
            }
            else{
                $("[name='mail_subject1']").css('border','');
            }

            if(!$("[name='mail_body1']").val())
            {
                $('#myModal3').find(".note-editable").css('border','1px solid red');
                flag = 1;
            }
            else{
                $('#myModal3').find(".note-editable").css('border','');
            }

            if(!flag)
            {
                $('#send-order-form').submit();
            }

        });

        $(".send-new-invoice").on('click', function (e) {

            var id = $(this).data('id');

            $.ajax({

                type: "GET",
                data: "id=" + id + '&type=invoice',
                url: "<?php echo url('/aanbieder/get-customer-email')?>",

                success: function (data) {

                    $('#quotation_id2').val(id);
                    $("[name='mail_to2']").val(data[0]);
                    $("[name='mail_subject2']").val(data[1]);
                    $("[name='mail_body2']").val(data[2]);
                    $('#myModal4').find(".note-editable").html(data[2]);
                    $('#myModal4').modal('toggle');
                    $('.modal-backdrop').hide();

                },
                error: function (data) {


                }

            });

        });

        $(document).on('click', '.submit-form2', function () {

            var flag = 0;

            if(!$("[name='mail_to2']").val())
            {
                $("[name='mail_to2']").css('border','1px solid red');
                flag = 1;
            }
            else{
                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if(regex.test($("[name='mail_to2']").val()))
                {
                    $("[name='mail_to2']").css('border','');
                }
                else{
                    $("[name='mail_to2']").css('border','1px solid red');
                    flag = 1;
                }
            }

            if(!$("[name='mail_subject2']").val())
            {
                $("[name='mail_subject2']").css('border','1px solid red');
                flag = 1;
            }
            else{
                $("[name='mail_subject2']").css('border','');
            }

            if(!$("[name='mail_body2']").val())
            {
                $('#myModal4').find(".note-editable").css('border','1px solid red');
                flag = 1;
            }
            else{
                $('#myModal4').find(".note-editable").css('border','');
            }

            if(!flag)
            {
                $('#send-invoice-form').submit();
            }

        });

        function ask(e)
        {
            var text = $(e).data('text');

            $('#review_text').val(text);

            $('#myModal1').modal('toggle');
        }

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
