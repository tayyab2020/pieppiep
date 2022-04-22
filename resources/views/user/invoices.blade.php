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
                                        
                                        <h2 style="display: inline-block;">{{__('text.Quotation Invoices')}}</h2>

                                            <!-- @if(auth()->user()->can('create-direct-invoice'))

                                                <a style="float: right;margin-right: 10px;" href="{{route('create-direct-invoice')}}" class="btn add-newProduct-btn"><i class="fa fa-plus"></i> {{__('text.Create New Invoice')}}</a>

                                            @endif -->

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

                                                            <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending" id="client">{{__('text.Quotation Number')}}</th>

                                                            <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending" id="client">{{__('text.Invoice Number')}}</th>

                                                            <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending" id="handyman">{{__('text.Customer Name')}}</th>

                                                            @if(Auth::guard('user')->user()->role_id == 2)

                                                                <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="rate">{{__('text.Grand Total')}}</th>

                                                            @endif

                                                            <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="rate">{{__('text.Current Stage')}}</th>

                                                            <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="service">{{__('text.Date')}}</th>

                                                            <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="date">{{__('text.Action')}}</th>

                                                        </tr>

                                                    </thead>

                                                    <tbody>

                                                    @foreach($invoices as $i => $key)

                                                        @if($key->getTable() == 'custom_quotations')

                                                            <tr role="row" class="odd">

                                                                <td>{{$i+1}}</td>

                                                                <td><a href="{{ url('/aanbieder/bekijk-eigen-offerte/'.$key->invoice_id) }}">OF# {{$key->quotation_invoice_number}}</a></td>

                                                                <td><a href="{{ url('/aanbieder/bekijk-eigen-offerte/'.$key->invoice_id) }}">FA# {{$key->quotation_invoice_number}}</a></td>

                                                                <td>{{$key->name}} {{$key->family_name}}</td>

                                                                @if(Auth::guard('user')->user()->role_id == 2)
                                                                
                                                                    <td>{{number_format((float)$key->grand_total, 2, ',', '.')}}</td>

                                                                @endif

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

                                                                                        <span class="btn btn-success">Order Processing</span>

                                                                                    @elseif($key->finished)

                                                                                        @if(Auth::guard('user')->user()->role_id == 2)

                                                                                            @if($key->retailer_delivered)

                                                                                                <span class="btn btn-success">Delivered</span>

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

                                                                                                            <span class="btn btn-success">Delivered by supplier(s)</span>

                                                                                                        @elseif($filteredData2->count() == 0)

                                                                                                            <span class="btn btn-success">Confirmed by supplier(s)</span>

                                                                                                        @else

                                                                                                            <span class="btn btn-success">{{$filteredData2->count()}}/{{$data->count()}} Delivered Order</span>

                                                                                                        @endif

                                                                                                    @else

                                                                                                        <span class="btn btn-success">Confirmed by supplier(s)</span>

                                                                                                    @endif

                                                                                                @elseif($filteredData->count() == 0)

                                                                                                    <span class="btn btn-warning">Confirmation Pending</span>

                                                                                                @else

                                                                                                    <span class="btn btn-success">{{$filteredData->count()}}/{{$data->count()}} Confirmed</span>

                                                                                                @endif

                                                                                            @endif

                                                                                        @else

                                                                                            @if($key->data_processing)

                                                                                                <span class="btn btn-warning">Processing</span>

                                                                                            @elseif($key->data_delivered)

                                                                                                <span class="btn btn-success">Order Delivered</span>

                                                                                            @elseif($key->data_approved)

                                                                                                <span class="btn btn-success">Order Confirmed</span>

                                                                                            @else

                                                                                                <span class="btn btn-warning">Confirmation Pending</span>

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


                                                                    <?php $date = strtotime($key->invoice_date);

                                                                    $date1 = date('d-m-Y',$date); ?>

                                                                <td data-sort="{{strtotime($key->invoice_date)}}">{{$date1}}</td>

                                                                <td>

                                                                    <div class="dropdown">
                                                                        
                                                                        <button style="outline: none;" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">{{__('text.Action')}}
                                                                            <span class="caret"></span>
                                                                        </button>
                                                                        
                                                                        <ul class="dropdown-menu">

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

                                                                        </ul>
                                                                        
                                                                    </div>
                                                                    
                                                                </td>
                                                                    
                                                            </tr>
                                                        
                                                        @else

                                                        <tr role="row" class="odd">

                                                            <td>{{$i+1}}</td>

                                                            <td>OF# {{$key->quotation_invoice_number}}</td>

                                                            <td>FA# {{$key->invoice_number}}</td>

                                                            <td>{{$key->quote_request_id ? $key->quote_name . ' ' . $key->quote_familyname : $key->name . ' ' . $key->family_name}}</td>

                                                            @if(Auth::guard('user')->user()->role_id == 2)

                                                                <td>{{number_format((float)$key->grand_total, 2, ',', '.')}}</td>

                                                            @endif


                                                            <td><span class="btn btn-success">{{__('text.Invoice Generated')}}</span></td>


                                                            <?php $date = strtotime($key->invoice_date);

                                                            $date1 = date('d-m-Y',$date); ?>

                                                            <td data-sort="{{strtotime($key->invoice_date)}}">{{$date1}}</td>

                                                            <td>
                                                                
                                                                <div class="dropdown">
                                                                    
                                                                    <button style="outline: none;" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">{{__('text.Action')}}
                                                                        <span class="caret"></span>
                                                                    </button>
                                                                        
                                                                        <ul class="dropdown-menu">

                                                                            @if(!$key->negative_invoice)

                                                                                <li><a href="{{ url('/aanbieder/view-new-invoice/'.$key->quotation_id) }}">{{__('text.View Invoice')}}</a></li>

                                                                                @if(!$key->has_negative_invoice)
                                                                                    <li><a href="{{ url('/aanbieder/create-new-negative-invoice/'.$key->quotation_id) }}">Create Negative Invoice</a></li>
                                                                                @endif

                                                                                <li><a href="{{ url('/aanbieder/download-invoice-pdf/'.$key->invoice_id) }}">Download Invoice PDF</a></li>

                                                                                @if(!$key->invoice_sent)

                                                                                    <li><a class="send-new-invoice" data-negative="0" data-id="{{$key->quotation_id}}" href="javascript:void(0)">Send Invoice</a></li>

                                                                                @endif

                                                                            @else

                                                                                <li><a href="{{ url('/aanbieder/create-new-negative-invoice/'.$key->quotation_id) }}">View Negative Invoice</a></li>
                                                                                <li><a href="{{ url('/aanbieder/download-negative-invoice-pdf/'.$key->quotation_id) }}">Download Negative Invoice PDF</a></li>

                                                                                @if(!$key->negative_invoice_sent)

                                                                                    <li><a class="send-negative-invoice" data-negative="1" data-id="{{$key->quotation_id}}" href="javascript:void(0)">Send Negative Invoice</a></li>

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

    <div id="myModal4" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <form id="send-invoice-form" action="{{route('send-new-invoice')}}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}

                <input type="hidden" name="quotation_id2" id="quotation_id2">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Invoice Mail Body</h4>
                    </div>
                    <div class="modal-body">

                        <div style="margin: 20px 0;" class="row">
                            <div style="display: flex;flex-direction: column;align-items: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>To:</label>
                                <input type="text" name="mail_to2" class="form-control">
                            </div>
                        </div>

                        <div style="margin: 20px 0;" class="row">
                            <div style="display: flex;flex-direction: column;align-items: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Subject:</label>
                                <input type="text" name="mail_subject2" class="form-control">
                            </div>
                        </div>

                        <div style="margin: 20px 0;" class="row">
                            <div style="display: flex;flex-direction: column;align-items: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Text:</label>
                                <input type="hidden" name="mail_body2">
                                <div class="summernote"></div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button style="border: 0;outline: none;background-color: #5cb85c !important;" type="button" class="btn btn-primary submit-form2">Submit</button>
                    </div>
                </div>

            </form>

        </div>
    </div>

    <div id="myModal5" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <form id="send-negative-invoice-form" action="{{route('send-negative-invoice')}}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}

                <input type="hidden" name="quotation_id3" id="quotation_id3">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Invoice Mail Body</h4>
                    </div>
                    <div class="modal-body">

                        <div style="margin: 20px 0;" class="row">
                            <div style="display: flex;flex-direction: column;align-items: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>To:</label>
                                <input type="text" name="mail_to3" class="form-control">
                            </div>
                        </div>

                        <div style="margin: 20px 0;" class="row">
                            <div style="display: flex;flex-direction: column;align-items: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Subject:</label>
                                <input type="text" name="mail_subject3" class="form-control">
                            </div>
                        </div>

                        <div style="margin: 20px 0;" class="row">
                            <div style="display: flex;flex-direction: column;align-items: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Text:</label>
                                <input type="hidden" name="mail_body3">
                                <div class="summernote"></div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button style="border: 0;outline: none;background-color: #5cb85c !important;" type="button" class="btn btn-primary submit-form3">Submit</button>
                    </div>
                </div>

            </form>

        </div>
    </div>

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

        $(".send-new-invoice, .send-negative-invoice").on('click', function (e) {

            var id = $(this).data('id');
            var negative = $(this).data('negative');

            $.ajax({

                type: "GET",
                data: "id=" + id + '&type=invoice',
                url: "<?php echo url('/aanbieder/get-customer-email')?>",

                success: function (data) {

                    if(negative == 0)
                    {
                        $('#quotation_id2').val(id);
                        $("[name='mail_to2']").val(data[0]);
                        $("[name='mail_subject2']").val(data[1]);
                        $("[name='mail_body2']").val(data[2]);
                        $('#myModal4').find(".note-editable").html(data[2]);
                        $('#myModal4').modal('toggle');
                    }
                    else
                    {
                        $('#quotation_id3').val(id);
                        $("[name='mail_to3']").val(data[0]);
                        $("[name='mail_subject3']").val(data[1]);
                        $("[name='mail_body3']").val(data[2]);
                        $('#myModal5').find(".note-editable").html(data[2]);
                        $('#myModal5').modal('toggle');
                    }

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

        $(document).on('click', '.submit-form3', function () {

            var flag = 0;

            if(!$("[name='mail_to3']").val())
            {
                $("[name='mail_to3']").css('border','1px solid red');
                flag = 1;
            }
            else{
                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if(regex.test($("[name='mail_to3']").val()))
                {
                    $("[name='mail_to3']").css('border','');
                }
                else{
                    $("[name='mail_to3']").css('border','1px solid red');
                    flag = 1;
                }
            }

            if(!$("[name='mail_subject3']").val())
            {
                $("[name='mail_subject3']").css('border','1px solid red');
                flag = 1;
            }
            else{
                $("[name='mail_subject3']").css('border','');
            }

            if(!$("[name='mail_body3']").val())
            {
                $('#myModal5').find(".note-editable").css('border','1px solid red');
                flag = 1;
            }
            else{
                $('#myModal5').find(".note-editable").css('border','');
            }

            if(!flag)
            {
                $('#send-negative-invoice-form').submit();
            }

        });

        function ask(e)
        {
            var text = $(e).data('text');

            $('#review_text').val(text);

            $('#myModal1').modal('toggle');
        }

        $('#example').DataTable({
            order: [[6, 'desc']],
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
