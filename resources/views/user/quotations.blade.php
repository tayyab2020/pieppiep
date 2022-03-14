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

                                        <h2 style="display: inline-block;">@if(Auth::guard('user')->user()->role_id == 2) {{__('text.Quotations')}} @else Orders @endif</h2>

                                        @if(Auth::guard('user')->user()->role_id == 2)

                                            <a style="float: right;" href="{{route('create-custom-quotation')}}" class="btn add-newProduct-btn"><i class="fa fa-plus"></i> {{__('text.Create Quotation')}}</a>

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

                                                            <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending" id="client">{{__('text.Quotation Number')}}</th>

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

                                                                <td><a href="{{ url('/aanbieder/bekijk-eigen-offerte/'.$key->invoice_id) }}">@if(Auth::guard('user')->user()->role_id == 4) OR# {{$key->order_number}} @else OF# {{$key->quotation_invoice_number}} @endif</a></td>

                                                                <td>{{$key->name}} {{$key->family_name}}</td>

                                                                @if(Auth::guard('user')->user()->role_id == 2)

                                                                    <td>{{number_format((float)$key->grand_total, 2, ',', '.')}}</td>

                                                                @endif

                                                                <td>

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

                                                                            <span class="btn btn-success">{{__('text.Quotation Approved')}}</span>

                                                                        @else

                                                                            <span class="btn btn-warning">{{__('text.Pending')}}</span>

                                                                        @endif

                                                                    @endif

                                                                </td>

                                                                <?php $date = strtotime($key->invoice_date);

                                                                $date1 = date('d-m-Y',$date); ?>

                                                                <td data-sort="{{$date}}">{{$date1}}</td>

                                                                <td>
                                                                    <div class="dropdown">
                                                                        <button style="outline: none;" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">{{__('text.Action')}}
                                                                            <span class="caret"></span></button>
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

                                                                <td><a href="">@if(Auth::guard('user')->user()->role_id == 4) OR# {{$key->order_number}} @else OF# {{$key->quotation_invoice_number}} @endif</a></td>

                                                                <td>{{$key->name}} {{$key->family_name}}</td>

                                                                @if(Auth::guard('user')->user()->role_id == 2)

                                                                    <td>{{number_format((float)$key->grand_total, 2, ',', '.')}}</td>

                                                                @endif

                                                                <td>

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

                                                                            @if($key->processing)

                                                                                <span class="btn btn-success">Order Processing</span>

                                                                            @elseif($key->finished)

                                                                                @if(Auth::guard('user')->user()->role_id == 2)

                                                                                    @if($key->retailer_delivered)

                                                                                        <span class="btn btn-success">Delivered</span>

                                                                                    @else

                                                                                        <?php $data = $key->orders->unique('supplier_id'); $filteredData = $data->reject(function ($value, $key) {
                                                                                            return $value['approved'] != 1;
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

                                                                        @if($key->ask_customization)

                                                                            <span class="btn btn-info">{{__('text.Asking for Review')}}</span>

                                                                        @elseif($key->approved)

                                                                            <span class="btn btn-success">Quotation Sent</span>

                                                                        @else

                                                                            @if($key->processing)

                                                                                <span class="btn btn-success">Order Processing</span>

                                                                            @else

                                                                                <span class="btn btn-warning">{{__('text.Pending')}}</span>

                                                                            @endif

                                                                        @endif

                                                                    @endif

                                                                </td>


                                                                <?php $date = strtotime($key->invoice_date);

                                                                $date1 = date('d-m-Y',$date); ?>

                                                                <td data-sort="{{$date}}">{{$date1}}</td>

                                                                <td>
                                                                    <div class="dropdown">
                                                                        <button style="outline: none;" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">{{__('text.Action')}}
                                                                            <span class="caret"></span></button>
                                                                        <ul class="dropdown-menu">

                                                                            @if(Auth::guard('user')->user()->role_id == 2)

                                                                                <li><a href="{{ url('/aanbieder/view-new-quotation/'.$key->invoice_id) }}">{{__('text.View Quotation')}}</a></li>

                                                                                @if(!$key->invoice)

                                                                                    <li><a href="{{ url('/aanbieder/create-new-invoice/'.$key->invoice_id) }}">Create Invoice</a></li>

                                                                                @else

                                                                                    <li><a href="{{ url('/aanbieder/view-new-invoice/'.$key->invoice_id) }}">{{__('text.View Invoice')}}</a></li>

                                                                                    <li><a href="{{ url('/aanbieder/download-invoice-pdf/'.$key->invoice_id) }}">Download Invoice PDF</a></li>

                                                                                    @if(!$key->invoice_sent)

                                                                                        <li><a class="send-new-invoice" data-id="{{$key->invoice_id}}" href="javascript:void(0)">Send Invoice</a></li>

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

                                                                            @endif


                                                                            @if(Auth::guard('user')->user()->role_id == 2)

                                                                                @if(count($key->orders) > 0)

                                                                                    <li><a href="{{ url('/aanbieder/view-order/'.$key->invoice_id) }}">View Order</a></li>

                                                                                @endif

                                                                            @else

                                                                                <li><a href="{{ url('/aanbieder/edit-order/'.$key->invoice_id) }}">View Order</a></li>

                                                                            @endif
                                                                            

                                                                            @if($key->accepted && !$key->processing && !$key->finished)

                                                                                <li><a class="send-new-order" data-id="{{$key->invoice_id}}" href="javascript:void(0)">Send Order</a></li>

                                                                            @endif

                                                                            @if(Auth::guard('user')->user()->role_id == 4)

                                                                                @if(!$key->data_delivered && !$key->data_processing)

                                                                                    <li><a href="{{ url('/aanbieder/change-delivery-dates/'.$key->invoice_id) }}">Edit Delivery Dates</a></li>

                                                                                @endif

                                                                                @if($key->data_approved && !$key->data_delivered)

                                                                                    <li><a href="{{ url('/aanbieder/supplier-order-delivered/'.$key->invoice_id) }}">Mark as delivered</a></li>

                                                                                @endif

                                                                            @else

                                                                                @if($key->delivered && !$key->retailer_delivered)

                                                                                    <li><a href="{{ url('/aanbieder/retailer-mark-delivered/'.$key->invoice_id) }}">Mark as delivered</a></li>

                                                                                @endif

                                                                                @if($key->status == 2)

                                                                                    @if($key->finished)

                                                                                        <?php $data = $key->orders->unique('supplier_id'); ?>

                                                                                        @foreach($data as $d => $data1)

                                                                                            <li><a href="{{ url('/aanbieder/download-order-pdf/'.$data1->id) }}">Download Supplier {{$d+1}} Order PDF</a></li>

                                                                                        @endforeach

                                                                                    @endif

                                                                                    <?php $data = $key->orders->unique('supplier_id'); ?>

                                                                                    @foreach($data as $d => $data1)

                                                                                        @if($data1->approved)

                                                                                            <li><a href="{{ url('/aanbieder/download-order-confirmation-pdf/'.$data1->id) }}">Download Supplier {{$d+1}} Order Confirmation PDF</a></li>

                                                                                        @endif

                                                                                    @endforeach

                                                                                @endif

                                                                            @endif

                                                                            @if(Auth::guard('user')->user()->role_id == 4)

                                                                                @if($key->data_approved)

                                                                                    <li><a href="{{ url('/aanbieder/download-order-confirmation-pdf/'.$key->data_id) }}">Download Order Confirmation PDF</a></li>

                                                                                @endif

                                                                                <li><a href="{{ url('/aanbieder/download-order-pdf/'.$key->data_id) }}">Download Order PDF</a></li>

                                                                            @else

                                                                                <li><a href="{{ url('/aanbieder/download-new-quotation/'.$key->invoice_id) }}">{{__('text.Download PDF')}}</a></li>

                                                                                @if(!$key->processing)
                                                                                
                                                                                    @if(count($key->orders) > 0)

                                                                                        <li><a href="{{ url('/aanbieder/download-full-order-pdf/'.$key->invoice_id) }}">Download Full Order PDF</a></li>

                                                                                    @endif

                                                                                @endif

                                                                            @endif

                                                                            @if(!$key->approved)

                                                                                <li><a class="send-new-quotation" data-id="{{$key->invoice_id}}" href="javascript:void(0)">{{__('text.Send Quotation')}}</a></li>

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

    <div id="myModal2" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <form id="send-quotation-form" action="{{route('send-new-quotation')}}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}

                <input type="hidden" name="quotation_id" id="quotation_id">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Quotation Mail Body</h4>
                    </div>
                    <div class="modal-body">

                        <div style="margin: 20px 0;" class="row">
                            <div style="display: flex;flex-direction: column;align-items: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>To:</label>
                                <input type="text" name="mail_to" class="form-control">
                            </div>
                        </div>

                        <div style="margin: 20px 0;" class="row">
                            <div style="display: flex;flex-direction: column;align-items: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Subject:</label>
                                <input type="text" name="mail_subject" class="form-control">
                            </div>
                        </div>

                        <div style="margin: 20px 0;" class="row">
                            <div style="display: flex;flex-direction: column;align-items: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Text:</label>
                                <input type="hidden" name="mail_body">
                                <div class="summernote"></div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button style="border: 0;outline: none;background-color: #5cb85c !important;" type="button" class="btn btn-primary submit-form">Submit</button>
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
                        <h4 class="modal-title">Order Mail Body</h4>
                    </div>
                    <div class="modal-body">

                        <div style="margin: 20px 0;" class="row">
                            <div style="display: flex;flex-direction: column;align-items: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Subject:</label>
                                <input type="text" name="mail_subject1" class="form-control">
                            </div>
                        </div>

                        <div style="margin: 20px 0;" class="row">
                            <div style="display: flex;flex-direction: column;align-items: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label>Text:</label>
                                <input type="hidden" name="mail_body1">
                                <div class="summernote"></div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button style="border: 0;outline: none;background-color: #5cb85c !important;" type="button" class="btn btn-primary submit-form1">Submit</button>
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

            $.ajax({

                type: "GET",
                data: "id=" + id + '&type=order',
                url: "<?php echo url('/aanbieder/get-customer-email')?>",

                success: function (data) {

                    $('#quotation_id1').val(id);
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

    </script>

    @if(Auth::guard('user')->user()->role_id == 2)

        <script>

            $('#example').DataTable({
                order: [[5, 'desc']],
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

    @else

        <script>

            $('#example').DataTable({
                order: [[4, 'desc']],
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

    @endif

@endsection
