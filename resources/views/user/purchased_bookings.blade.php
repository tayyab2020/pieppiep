@extends('layouts.handyman')

@section('content')

    <div class="right-side" style="z-index: auto;">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- Starting of Dashboard data-table area -->
                    <div class="section-padding add-product-1">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="add-product-box">
                                    <div class="add-product-header products">
                                        <h2>{{$lang->pbt}}</h2>

                                    </div>
                                    <hr>
                                    <div>
                                        @include('includes.form-success')
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table id="example" class="table table-striped table-hover products dt-responsive dataTable no-footer dtr-inline" role="grid" aria-describedby="product-table_wrapper_info" style="width: 100%;margin-top: 55px !important;" width="100%" cellspacing="0">
                                                    <thead>
                                                    <tr role="row">

                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 95px;" aria-label="City: activate to sort column ascending" >Sr No</th>

                                                        <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 239px;" aria-sort="ascending" aria-label="Donor's Photo: activate to sort column descending" id="photo">{{$lang->chi}}</th>

                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending" id="client">{{$lang->chn}}</th>




                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 95px;" aria-label="City: activate to sort column ascending" id="serv">{{$lang->inct}}</th>


                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="rate">{{$lang->cbd}}</th>


                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="service">{{$lang->ctot}}</th>

                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 240px;" aria-label="Actions: activate to sort column ascending" id="booking-images">{{$lang->cbit}}</th>


                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="service">{{$lang->sct}}</th>


                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="date">{{$lang->cpat}}</th>

                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 240px;" aria-label="Actions: activate to sort column ascending" id="negative">Negative Invoice</th>



                                                    </thead>

                                                    <tbody>
                                                    <?php $i=1;  ?>

                                                    @foreach($users_bookings as $key)

                                                        <tr role="row" class="odd">

                                                            <td>{{$i}}</td>

                                                            <td tabindex="0" class="sorting_1" id="img"><img src="{{ $key->photo ? asset('assets/images/'.$key->photo):asset('assets/default.jpg')}}" alt="User's Photo" style="height: 180px; width: 80%;margin: auto;display: block;"></td>

                                                            <td>{{$key->name}} {{$key->family_name}}</td>

                                                            <td><a href="{{ asset('handyman/invoice/' . $key->id ) }}">{{$key->invoice_number}}</a></td>

                                                            <?php $date = strtotime($key->booking_date);

                                                            $date = date('d-m-Y',$date);  ?>

                                                            <td>{{$date}}</td>

                                                            <td>€ <?php echo str_replace('.', ',', $key->total); ?></td>

                                                            <td><a href="{{ asset('handyman/view-images/' . $key->id ) }}">View</a></td>


                                                            <td>

                                                                <?php $date = strtotime($key->booking_date);

                                                                $date = date('Y-m-d',$date);  ?>

                                                                <form class="form-horizontal" id="form<?php echo $i; ?>" action="{{route('client-status-update')}}" method="POST" enctype="multipart/form-data">

                                                                    {{csrf_field()}}




                                                                    @if( $key->is_booked == 1)

                                                                        @if( $key->is_completed == 1)

                                                                            @if( $key->pay_req == 1)

                                                                                @if( $key->is_paid == 1)

                                                                                    <button type="button" class="btn btn-sm btn-success" style="padding: 8px 22px;font-size: 14px;">{{$lang->past1}}</button>

                                                                                @else

                                                                                    <button type="button" class="btn btn-sm btn-info" style="padding: 8px 22px;font-size: 14px;">{{$lang->ppest1}}</button>

                                                                                @endif

                                                                            @else




                                                                                <input type="hidden" name="item_id" id="item_id<?php echo $i; ?>" value="{{$key->id}}">

                                                                                <input type="hidden" name="select_id" id="select_id<?php echo $i; ?>" value="0">

                                                                                <input type="hidden" name="user_email" id="user_email<?php echo $i; ?>" value="{{$key->email}}">

                                                                                <input type="hidden" name="handyman_id" id="handyman_id<?php echo $i; ?>" value="{{$key->handyman_id}}">

                                                                                <select id="statusSelect<?php echo $i; ?>" name="statusSelect" class="btn btn-sm btn-success" style="padding: 8px 22px;font-size: 14px;" onchange="Change(<?php echo $i; ?>)">

                                                                                    <option value="0" class="btn btn-sm btn-success" style="font-size: 15px;" selected>{{$lang->jcst1}}</option>
                                                                                    <option value="1" class="btn btn-sm btn-info" style="font-size: 15px;">{{$lang->tfst}}</option>

                                                                                </select>



                                                                            @endif




                                                                        @else

                                                                            @if($key->is_partial == 1)

                                                                                <input type="hidden" name="item_id" id="item_id<?php echo $i; ?>" value="{{$key->id}}">

                                                                                <input type="hidden" name="select_id" id="select_id<?php echo $i; ?>" value="0">

                                                                                <input type="hidden" name="user_email" id="user_email<?php echo $i; ?>" value="{{$key->email}}">

                                                                                <input type="hidden" name="handyman_id" id="handyman_id<?php echo $i; ?>" value="{{$key->handyman_id}}">

                                                                                <select id="statusSelect<?php echo $i; ?>" name="statusSelect" class="btn btn-sm btn-success" style="padding: 8px 22px;font-size: 14px;" onchange="Change(<?php echo $i; ?>)">


                                                                                    <option value="0" class="btn btn-sm btn-success" style="font-size: 15px;" selected>{{$lang->bst1}}</option>

                                                                                    <option value="3" class="btn btn-sm btn-success" style="font-size: 15px;">{{$lang->cpst}}</option>



                                                                                </select>



                                                                            @else

                                                                                <button type="button" class="btn btn-sm btn-success" style="padding: 8px 22px;font-size: 14px;">{{$lang->bst1}}</button>

                                                                            @endif



                                                                        @endif




                                                                    @else



                                                                        @if( $date > date("Y-m-d") )

                                                                            @if($key->is_cancelled == 0)



                                                                                @if($key->cancel_req == 1)

                                                                                    <button type="button" class="btn btn-sm btn-danger" style="padding: 8px 22px;font-size: 14px;">{{$lang->rfcst1}}</button>

                                                                                @else

                                                                                    @if($key->is_partial == 1)

                                                                                        <input type="hidden" name="item_id" id="item_id<?php echo $i; ?>" value="{{$key->id}}">

                                                                                        <input type="hidden" name="select_id" id="select_id<?php echo $i; ?>" value="0">

                                                                                        <input type="hidden" name="user_email" id="user_email<?php echo $i; ?>" value="{{$key->email}}">

                                                                                        <input type="hidden" name="handyman_id" id="handyman_id<?php echo $i; ?>" value="{{$key->handyman_id}}">

                                                                                        <select id="statusSelect<?php echo $i; ?>" name="statusSelect" class="btn btn-sm btn-warning" style="padding: 8px 22px;font-size: 14px;" onchange="Change(<?php echo $i; ?>)">


                                                                                            <option value="0" class="btn btn-sm btn-warning" style="font-size: 15px;" selected>{{$lang->ppst1}}</option>

                                                                                            <option value="3" class="btn btn-sm btn-success" style="font-size: 15px;">{{$lang->cpst}}</option>

                                                                                            <option value="-1" class="btn btn-sm btn-danger" style="font-size: 15px;">{{$lang->cjst}}</option>

                                                                                        </select>



                                                                                    @else

                                                                                        <input type="hidden" name="item_id" id="item_id<?php echo $i; ?>" value="{{$key->id}}">

                                                                                        <input type="hidden" name="select_id" id="select_id<?php echo $i; ?>" value="0">

                                                                                        <input type="hidden" name="user_email" id="user_email<?php echo $i; ?>" value="{{$key->email}}">

                                                                                        <input type="hidden" name="handyman_id" id="handyman_id<?php echo $i; ?>" value="{{$key->handyman_id}}">

                                                                                        <select id="statusSelect<?php echo $i; ?>" name="statusSelect" class="btn btn-sm btn-warning" style="padding: 8px 22px;font-size: 14px;" onchange="Change(<?php echo $i; ?>)">


                                                                                            <option value="0" class="btn btn-sm btn-warning" style="font-size: 15px;" selected>{{$lang->pst1}}</option>

                                                                                            <option value="-1" class="btn btn-sm btn-danger" style="font-size: 15px;">{{$lang->cjst}}</option>

                                                                                        </select>


                                                                                    @endif

                                                                                @endif



                                                                            @else

                                                                                <button type="button" class="btn btn-sm btn-danger" style="padding: 8px 22px;font-size: 14px;">{{$lang->cast1}}</button>


                                                                            @endif



                                                                        @else

                                                                            @if( $key->is_cancelled == 0)

                                                                                @if( $key->cancel_req == 1)

                                                                                    <button type="button" class="btn btn-sm btn-danger" style="padding: 8px 22px;font-size: 14px;">{{$lang->rfcst1}}</button>

                                                                                @else

                                                                                    <button type="button" class="btn btn-sm btn-danger" style="padding: 8px 22px;font-size: 14px;">{{$lang->est1}}</button>

                                                                                @endif

                                                                            @else

                                                                                <button type="button" class="btn btn-sm btn-danger" style="padding: 8px 22px;font-size: 14px;">{{$lang->cast1}}</button>

                                                                        @endif

                                                                    @endif

                                                                @endif

                                                                <!-- Modal -->
                                                                    <div class="modal fade" id="myModal<?php echo $i; ?>" role="dialog" >
                                                                        <div class="modal-dialog" style="margin-top: 150px;">

                                                                            <!-- Modal content-->
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                    <h4 class="modal-title">{{$lang->rfct}}</h4>
                                                                                </div>
                                                                                <div class="modal-body">



                                                                                    <div style="text-align: center;font-size: 18px;margin: 20px;">

                                                                                        <div style="width: 100%; margin: auto;text-align: left;">

                                                                                            <textarea placeholder="{{$lang->erfct}}" name="reason" id="reason" style="width: 100%;height: 300px;border:1px solid rgb(214, 214, 214);border-radius: 10px;padding: 15px;resize: none;"></textarea>

                                                                                        </div></div>


                                                                                </div>




                                                                                <div class="modal-footer">
                                                                                    <button type="button" id="send_reason<?php echo $i; ?>" class="btn btn-success" onclick="Send(<?php echo $i; ?>)">{{$lang->send}}</button>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                    <div class="modal fade" id="ReviewModal<?php echo $i; ?>" role="dialog" style="background-color: #0000008c;">
                                                                        <div class="modal-dialog" style="margin-top: 150px;">

                                                                            <!-- Modal content-->
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                    <h4 class="modal-title">{{$lang->grn}}</h4>
                                                                                </div>
                                                                                <div class="modal-body" style="display: inline-block;">



                                                                                    <div style="text-align: center;font-size: 18px;margin: 20px;">

                                                                                        <div style="width: 100%; margin: auto;text-align: left;">

                                                                                            <div class="rate rate_box<?php echo $i; ?>">
                                                                                                <input type="radio" id="star5<?php echo $i; ?>" name="rate" value="5" required />
                                                                                                <label for="star5<?php echo $i; ?>" title="text">5 stars</label>
                                                                                                <input type="radio" id="star4<?php echo $i; ?>" name="rate" value="4" required />
                                                                                                <label for="star4<?php echo $i; ?>" title="text">4 stars</label>
                                                                                                <input type="radio" id="star3<?php echo $i; ?>" name="rate" value="3" required />
                                                                                                <label for="star3<?php echo $i; ?>" title="text">3 stars</label>
                                                                                                <input type="radio" id="star2<?php echo $i; ?>" name="rate" value="2" required />
                                                                                                <label for="star2<?php echo $i; ?>" title="text">2 stars</label>
                                                                                                <input type="radio" id="star1<?php echo $i; ?>" name="rate" value="1" required />
                                                                                                <label for="star1<?php echo $i; ?>" title="text">1 star</label>
                                                                                            </div>



                                                                                        </div></div>


                                                                                </div>




                                                                                <div class="modal-footer">
                                                                                    <button type="button" id="submit_review<?php echo $i; ?>" class="btn btn-success" onclick="Send(<?php echo $i; ?>)">{{$lang->fpb}}</button>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                </form>




                                                            </td>

                                                            <td><a href="{{ asset('handyman/invoice/' . $key->id ) }}">{{$lang->cpvb}}</a></td>

                                                            <td>@if($key->is_cancelled)<a href="{{ asset('handyman/cancelled-invoice/' . $key->id ) }}">View</a>@endif</td>

                                                        </tr>

                                                        <?php $i = $i + 1; ?>

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
    <script type="text/javascript">

        function Send(input)
        {
            var id =$('#statusSelect'+input).val();

            if(id == 1)
            {
                if($('.rate_box'+input).children("input[name='rate']").is(':checked'))
                {

                    $('#form'+input).submit();

                }
                else
                {

                    Swal.fire(
                        <?php echo "'".$lang->ert."'"; ?>,
                        <?php echo "'".$lang->pgrt."'"; ?>,
                        'error'
                    )

                }

            }
            else
            {

                $('#form'+input).submit();

            }

        }



        function Change(input)
        {


            var status_old = $('#select_id'+input).val();

            var id = $('#statusSelect'+input).val();

            if(id == -1)
            {

                $(function () {
                    $('#myModal'+input).modal('toggle');

                });



                $('#myModal'+input).on('hidden.bs.modal', function () {

                    $('#statusSelect'+input).val(status_old);

                });


            }
            else
            {

                Swal.fire({
                    title: <?php echo "'".$lang->ayst1."'" ?>,
                    text: <?php echo "'".$lang->uscm1."'" ?>,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: <?php echo "'".$lang->qyt."'" ?>,
                    cancelButtonText: <?php echo "'".$lang->qnt."'" ?>,
                }).then((result) => {
                    if (result.value) {

                        if(id == 1)
                        {

                            $(function () {
                                $('#ReviewModal'+input).modal('toggle');

                            });



                            $('#ReviewModal'+input).on('hidden.bs.modal', function () {

                                $('#statusSelect'+input).val(status_old);

                            });

                        }

                        else
                        {

                            $('#form'+input).submit();

                        }



                    }
                    else{

                        $('#statusSelect'+input).val(status_old);

                        Swal.fire(
                            <?php echo "'".$lang->cant1."'" ?>,
                            <?php echo "'".$lang->suct1."'" ?>,
                            'info'
                        )

                    }
                })

            }




        }
    </script>

    <style type="text/css">

        *{
            margin: 0;
            padding: 0;
        }
        .rate {
            float: left;
            height: 46px;
            padding: 0 10px;
        }
        .rate:not(:checked) > input {
            position:absolute;
            top:-9999px;
        }
        .rate:not(:checked) > label {
            float:right;
            width:1em;
            overflow:hidden;
            white-space:nowrap;
            cursor:pointer;
            font-size:30px;
            color:#ccc;
        }
        .rate:not(:checked) > label:before {
            content: '★ ';
        }
        .rate > input:checked ~ label {
            color: #ffc700;
        }
        .rate:not(:checked) > label:hover,
        .rate:not(:checked) > label:hover ~ label {
            color: #deb217;
        }
        .rate > input:checked + label:hover,
        .rate > input:checked + label:hover ~ label,
        .rate > input:checked ~ label:hover,
        .rate > input:checked ~ label:hover ~ label,
        .rate > label:hover ~ input:checked ~ label {
            color: #c59b08;
        }

        /* Modified from: https://github.com/mukulkant/Star-rating-using-pure-css */

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
            width: 168px !important;
        }

        #client{
            width: 127px !important;
        }

        #handyman{
            width: 185px !important;
        }

        #serv{
            width: 118px !important;
        }

        #rate{
            width: 128px !important;
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

        #booking-images{
            width: 115px !important;
        }

        #negative{
            width: 160px !important;
        }

        .table.products > tbody > tr > td
        {

            text-align: center;

        }


    </style>

@endsection

@section('scripts')

    <script type="text/javascript">
        $('#example').DataTable();
    </script>

@endsection