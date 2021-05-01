@extends('layouts.pdfHead')

@section('content')




    <!-- Page Content -->
    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">Client Refund Invoice</h1>
        </div>
    </section>


    <div class="container" style="width: 100%;">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="row p-5" style="margin-right: 15px !important;">
                            <div class="col-md-6 col-sm-4 col-xs-12">
                                <img class=" img-fluid" src="{{ public_path('assets/images/'.$gs->logo) }}" style="width:50%; height:100%;">

                                <p class="para" style="margin-top: 20px;margin-left: 26px;">{!! $gs->street  !!}<br>TEL: {{$gs->phone}}<br>BTW: NL001973883B94<br>IBAN: NL87ABNA0825957680<br>KvK-nummer: 70462623</p>

                            </div>


                            <div class="col-md-6 col-sm-6 col-xs-12 text-right inv-rigth" style="float: right;margin-top: 50px;">

                                <?php $date = strtotime($invoice[0]->inv_date);

                                $invoice_number =  'INV# ' .  date("Y",$date) . "-" . $invoice_number ?>

                                <p class="font-weight-bold mb-1" style="font-size: 20px;">{{$invoice_number}}</p>

                                <?php $date = date('d-m-Y',$date);  ?>


                                <p class="text-muted" style="font-size: 15px;">Invoiced at: {{$date}}</p>
                            </div>
                        </div>

                        <hr class="my-5">

                        <div class="row pb-5 p-5" style="margin-right: 15px !important;">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <p class="font-weight-bold mb-4 m-heading">Client Information</p>
                                <p class="mb-1 m-rest">{{$user->name}} {{$user->family_name}}</p>
                                <p class="mb-1 m-rest">{{$user->address}}</p>
                                <p class="mb-1 m-rest"><?php echo preg_replace('/(\d+)/', '${1} ', $user->postcode); ?> @if(!$user->postcode == "") , @endif {{$user->city}}</p>
                                <p class="mb-1 m-rest">{{$user->phone}} & {{$user->email}}</p>


                            </div>

                            <div class="col-md-6 col-sm-6 col-xs-12 text-right m2-heading" style="float: right;">
                                <p class="font-weight-bold mb-4 m-heading">Handyman Information</p>
                                <p class="mb-1 m-rest">{{$handyman->name}} {{$handyman->family_name}}</p>
                                <p class="mb-1 m-rest">{{$handyman->company_name}}</p>
                                <p class="mb-1 m-rest">{{$handyman->email}}</p>
                                <p class="mb-1 m-rest">{{$handyman->address}}</p>
                                <p class="mb-1 m-rest"><?php echo preg_replace('/(\d+)/', '${1} ', $handyman->postcode); ?> @if(!$handyman->postcode == "") , @endif {{$handyman->city}}</p>
                                <p class="mb-1 m-rest">{{$handyman->phone}}</p>
                            </div>
                        </div>

                        <div class="row p-5" style="font-size: 15px;padding: 5px !important;">
                            <div class="col-md-12" style="padding: 0px !important;padding-top: 50px;">
                                <table class="table" style="border: 1px solid #e5e5e5;">
                                    <thead>
                                    <tr>
                                        <th class="border-0 text-uppercase small font-weight-bold" style="font-size: 15px;font-weight: 300;padding: 10px !important;">ID</th>
                                        <th class="border-0 text-uppercase small font-weight-bold" style="font-size: 15px;font-weight: 300;padding: 10px !important;">Service</th>
                                        <th class="border-0 text-uppercase small font-weight-bold" style="font-size: 15px;font-weight: 300;padding: 10px !important;">Service Type</th>
                                        <th class="border-0 text-uppercase small font-weight-bold" style="font-size: 15px;font-weight: 300;padding: 10px !important;">Service Demand</th>
                                        <th class="border-0 text-uppercase small font-weight-bold" style="font-size: 15px;font-weight: 300;padding: 10px !important;">Service Rate</th>
                                        <th class="border-0 text-uppercase small font-weight-bold" style="font-size: 15px;font-weight: 300;padding: 10px !important;">Booking Date</th>
                                        <th class="border-0 text-uppercase small font-weight-bold" style="font-size: 15px;font-weight: 300;padding: 10px !important;">Total Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php $i=1; ?>

                                    @foreach($invoice as $key)

                                        <?php $date = strtotime($key->booking_date);

                                        $date = date('d-m-Y',$date);  ?>


                                        <tr>
                                            <td>{{$i}}</td>
                                            <td>{{$key->cat_name}}</td>
                                            <td>{{$key->type}}</td>
                                            <td>-{{$key->rate}}</td>
                                            <td>€ {{$key->service_rate}}</td>
                                            <td>{{$date}}</td>
                                            <td>- € <?php echo str_replace('.', ',', number_format($key->total,2)); ?></td>

                                        </tr>

                                        <?php $i++; ?>

                                    @endforeach

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

                        <div class="d-flex flex-row-reverse bg-dark text-white p-4" style="background-color: #343a40 !important;display: block !important;margin-left: -15px !important;margin-right: -15px !important;">

                            <?php $vat = $invoice[0]->inv_total*($invoice[0]->vat_percentage/100); $ex_vat = $invoice[0]->inv_total - $vat; ?>



                            <table class="table">
                                <thead>
                                <tr>

                                            <th class="border-0 text-uppercase small font-weight-bold">Status</th>


                                            @if($invoice[0]->is_cancelled == 1)

                                                <th class="border-0 text-uppercase small font-weight-bold">Amount Refund</th>

                                                <th class="border-0 text-uppercase small font-weight-bold">Amount Paid</th>

                                            @else

                                                @if($invoice[0]->is_partial == 1)

                                                    <th class="border-0 text-uppercase small font-weight-bold">Amount Paid</th>

                                                @else

                                                    <th class="border-0 text-uppercase small font-weight-bold">Amount Paid</th>

                                                @endif

                                            @endif

                                            <th class="border-0 text-uppercase small font-weight-bold">VAT<small style="font-size: 11px;"> (<?php echo $invoice[0]->vat_percentage; ?>%)</small></th>

                                            <th class="border-0 text-uppercase small font-weight-bold">Service Fee</th>

                                            <th class="border-0 text-uppercase small font-weight-bold">Subtotal</th>

                                            <th class="border-0 text-uppercase small font-weight-bold">Grand Total</th>

                                        </tr>
                                        </thead>

                                        <tbody>

                                        <tr>
                                            <td>
                                                <?php $date = strtotime($invoice[0]->booking_date);

                                                $date = date('Y-m-d',$date);  ?>

                                                @if( $invoice[0]->is_booked == 1)


                                                    @if( $invoice[0]->is_completed == 1)


                                                        @if( $invoice[0]->is_paid)

                                                            Paid

                                                        @else

                                                        Payment Pending

                                                        @endif


                                                    @else

                                                        Booked

                                                    @endif


                                                @else

                                                    @if( $date > date("Y-m-d") )

                                                        @if($invoice[0]->is_cancelled == 0)

                                                            @if($invoice[0]->is_partial == 0)

                                                             Pending

                                                            @else

                                                            Partial Payment

                                                            @endif

                                                        @else

                                                           Cancelled

                                                        @endif



                                                    @else

                                                        @if($invoice[0]->is_cancelled == 0)

                                                            @if($invoice[0]->cancel_req == 1)


                                                             Requested For Cancellation

                                                            @else


                                                            Expired

                                                            @endif

                                                        @else


                                                          Cancelled

                                                        @endif

                                                    @endif

                                                @endif

                                            </td>


                                            @if($invoice[0]->is_cancelled == 1)

                                                <td>- € <?php echo str_replace('.', ',', number_format($invoice[0]->amount_refund,2)); ?></td>

                                                <td>€ <?php echo str_replace('.', ',', number_format($invoice[0]->amount_refund,2)); ?></td>

                                            @else

                                                @if($invoice[0]->is_partial == 1)

                                                    <?php $paid = $invoice[0]->inv_total * 0.3; ?>


                                                    <td>€ <?php echo str_replace('.', ',', number_format($paid,2)); ?></td>

                                                @else

                                                    <td>€ <?php echo str_replace('.', ',', number_format($invoice[0]->inv_total,2)); ?></td>

                                                @endif

                                            @endif

                                            <td>- € <?php echo str_replace('.', ',', number_format($vat,2)); ?></td>

                                            <td>- € <?php echo str_replace('.', ',', number_format($invoice[0]->service_fee,2)); ?></td>

                                            <td>- € <?php echo str_replace('.', ',', number_format($ex_vat,2)); ?></td>

                                            <td>- € <?php echo str_replace('.', ',', number_format($invoice[0]->inv_total,2)); ?></td>


                                        </tr>

                                        </tbody>

                                    </table></div>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" mb-0" style="height: 110px;">
            <!-- <div class="text-right mt-5 mb-5">
                <a href="#" class="btn btn-primary  m-b-5 m-t-5"><img class="img-fluid" src="{{url('icons/package/build/svg/sharp-print-24px.svg')}}"> Print </a>
                <a href="#" class="btn btn-success  m-b-5 m-t-5"><img class="img-fluid" src="{{url('icons/package/build/svg/mail.svg')}}">Send</a>
                <a href="#" class="btn btn-danger m-t-5 m-b-5"><img class="img-fluid" src="{{url('icons/package/build/svg/credit-card.svg')}}">Pay</a>
            </div>
            <div class="clearfix"></div> -->
            </div>

        </div>
    </div>

    <style type="text/css">

        @media (max-width: 768px) {

            .inv-rigth{

                margin-top: 45px;
            }

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

        .table td, .table th{

            padding: 1.75rem !important;
            vertical-align: middle;
            text-align: center;
            border-top: 1px solid #dee2e6;
            min-width: 155px;
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

@endsection