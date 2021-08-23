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
                                        @if(Route::currentRouteName() == 'quotations' || Route::currentRouteName() == 'new-quotations' || Route::currentRouteName() == 'customer-quotations')
                                            <h2 style="display: inline-block;">{{__('text.Quotations')}}</h2>
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

                                                <a style="float: right;margin-right: 10px;" href="{{route('create-new-quotation')}}" class="btn add-newProduct-btn"><i class="fa fa-plus"></i> Create New Quotation</a>

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

                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending" id="client">@if(Route::currentRouteName() == 'quotations' || Route::currentRouteName() == 'new-quotations' || Route::currentRouteName() == 'customer-quotations') {{__('text.Quotation Number')}} @else {{__('text.Invoice Number')}} @endif</th>

                                                        @if(Route::currentRouteName() != 'customer-quotations' && Route::currentRouteName() != 'customer-invoices' && Route::currentRouteName() != 'new-quotations')

                                                        <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 239px;" aria-sort="ascending" aria-label="Donor's Photo: activate to sort column descending" id="photo">{{__('text.Delivery Date')}}</th>

                                                        @endif

                                                        @if(Route::currentRouteName() != 'customer-quotations' && Route::currentRouteName() != 'customer-invoices' && Route::currentRouteName() != 'new-quotations')

                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 95px;" aria-label="City: activate to sort column ascending" id="serv">{{__('text.Subtotal')}}</th>

                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending">{{__('text.Tax')}}</th>

                                                        @else

                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending" id="handyman">{{__('text.Customer Name')}}</th>

                                                        @endif

                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="rate">{{__('text.Grand Total')}}</th>

                                                        @if(Route::currentRouteName() == 'commission-invoices')

                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="rate">{{__('text.Commission')}} %</th>
                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="rate">{{__('text.Commission')}}</th>
                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="rate">{{__('text.Total Receive')}}</th>

                                                        @else

                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="rate">{{__('text.Current Stage')}}</th>

                                                        @endif

                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="service">{{__('text.Date')}}</th>

                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="date">{{__('text.Action')}}</th>


                                                    </thead>

                                                    <tbody>
                                                    <?php $i=0;  ?>

                                                    @foreach($invoices as $key)

                                                        <tr role="row" class="odd">

                                                            <td>{{$key->invoice_id}}</td>

                                                            @if(Route::currentRouteName() == 'customer-quotations' || Route::currentRouteName() == 'customer-invoices' || Route::currentRouteName() == 'new-quotations')

                                                                <td><a @if(Route::currentRouteName() == 'new-quotations') href="" @else href="{{ url('/aanbieder/bekijk-eigen-offerte/'.$key->invoice_id) }}" @endif>QUO# {{$key->quotation_invoice_number}}</a></td>

                                                            @else

                                                                <td><a href="{{ url('/aanbieder/bekijk-offerte/'.$key->invoice_id) }}">@if(Route::currentRouteName() == 'quotations') QUO# @else INV# @endif {{$key->quotation_invoice_number}}</a></td>

                                                                <?php
                                                                $requested_quote_number = $key->quote_number;
                                                                if($key->delivery_date){ $delivery_date = date("d-m-Y",strtotime($key->delivery_date)); }else{ $delivery_date = ''; }
                                                                ?>

                                                                <td><a href="{{ url('/aanbieder/bekijk-offerteaanvraag-aanbieder/'.$key->id) }}">{{$delivery_date}}</a></td>

                                                            @endif


                                                            @if(Route::currentRouteName() != 'customer-quotations' && Route::currentRouteName() != 'customer-invoices' && Route::currentRouteName() != 'new-quotations')

                                                                    <td>{{number_format((float)$key->subtotal, 2, ',', '.')}}</td>
                                                                    <td>{{number_format((float)$key->tax, 2, ',', '.')}}</td>

                                                            @else

                                                                    <td>{{$key->name}} {{$key->family_name}}</td>

                                                            @endif


                                                                <td>{{number_format((float)$key->grand_total, 2, ',', '.')}}</td>

                                                                @if(Route::currentRouteName() == 'commission-invoices')

                                                                    <td>{{$key->commission_percentage}}</td>
                                                                    <td>{{number_format((float)$key->commission, 2, ',', '.')}}</td>
                                                                    <td>{{number_format((float)$key->total_receive, 2, ',', '.')}}</td>

                                                                @else

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

                                                                                @if($key->accepted)

                                                                                    <span class="btn btn-primary1">{{__('text.Quotation Accepted')}}</span>

                                                                                @else

                                                                                    <span class="btn btn-success">{{__('text.Closed')}}</span>

                                                                                @endif

                                                                            @else

                                                                                @if($key->ask_customization)

                                                                                    <span class="btn btn-info">{{__('text.Asking for Review')}}</span>

                                                                                @elseif($key->approved)

                                                                                    @if(Route::currentRouteName() == 'new-quotations')

                                                                                        <span class="btn btn-success">Quotation Sent</span>

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


                                                                <?php $date = strtotime($key->invoice_date);

                                                                $date = date('d-m-Y',$date);  ?>

                                                                <td>{{$date}}</td>

                                                                <td>
                                                                    <div class="dropdown">
                                                                        <button style="outline: none;" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">{{__('text.Action')}}
                                                                            <span class="caret"></span></button>
                                                                        <ul class="dropdown-menu">

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

                                                                                    @if($key->status != 2 && $key->status != 3)

                                                                                        @if($key->ask_customization)

                                                                                            <li><a onclick="ask(this)" data-text="{{$key->review_text}}" href="javascript:void(0)">{{__('text.Review Reason')}}</a></li>

                                                                                        @endif

                                                                                        @if($key->status == 0 || $key->ask_customization)

                                                                                            <li><a href="{{ url('/aanbieder/edit-new-quotation/'.$key->invoice_id) }}">{{__('text.Edit Quotation')}}</a></li>

                                                                                        @endif

                                                                                    @endif

                                                                                        @if($key->accepted)

                                                                                            <li><a href="{{ url('/aanbieder/send-order/'.$key->invoice_id) }}">Send Order</a></li>

                                                                                        @endif

                                                                                        <li><a href="{{ url('/aanbieder/download-new-quotation/'.$key->invoice_id) }}">{{__('text.Download PDF')}}</a></li>

                                                                                        @if(!$key->approved)

                                                                                            <li><a href="{{ url('/aanbieder/send-new-quotation/'.$key->invoice_id) }}">{{__('text.Send Quotation')}}</a></li>

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


    <style type="text/css">

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

@endsection

@section('scripts')

    <script type="text/javascript">

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
