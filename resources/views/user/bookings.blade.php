@extends('layouts.handyman')

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
                                          <h2>{{$lang->mbt}}</h2>
                                          
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

                                                    <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 239px;" aria-sort="ascending" aria-label="Donor's Photo: activate to sort column descending" id="photo">{{$lang->cpht}}</th>

                                                    <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending" id="client">{{$lang->cnht}}</th>




                                                    <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 95px;" aria-label="City: activate to sort column ascending" id="serv">{{$lang->inht}}</th>





                                                    <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="date">{{$lang->hpbd}}</th>



                                                    <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="amount">{{$lang->hpta}}</th>

                                                    <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 240px;" aria-label="Actions: activate to sort column ascending" id="booking-images">{{$lang->hbit}}</th>


                                                    <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 240px;" aria-label="Actions: activate to sort column ascending" id="status">{{$lang->sht}}</th>

                                                  <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 240px;" aria-label="Actions: activate to sort column ascending" id="status">{{$lang->hpa}}</th>

                                                  <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 240px;" aria-label="Actions: activate to sort column ascending" id="negative">Negative Invoice</th>

                                                </tr>
                                              </thead>

                                              <tbody>
                                                <?php $i=1;  ?>

                                                @foreach($users_bookings as $key)

                                                    <tr role="row" class="odd">

                                                        <td>{{$i}}</td>



                                                      <td tabindex="0" class="sorting_1" id="img"><img src="{{ $key->photo ? asset('assets/images/'.$key->photo):asset('assets/default.jpg')}}" alt="User's Photo" style="height: 180px; width: 80%;margin: auto;display: block;"></td>

                                                      <td>{{$key->name}} {{$key->family_name}}</td>
                                                      
                                                <td><a href="{{ asset('handyman/invoice/' . $key->id ) }}">{{$key->invoice_number}}</a></td>

                                                <?php $date21 =date_create($key->booking_date);

                                $date12 = date_format($date21,"d-m-Y H:i:s"); ?>

                                            
                                                      <td>{{$date12}}</td>

                                                        <?php $commission_percentage = $key->commission_percentage; $service_fee = $key->service_fee;

                                                        $handyman_total = $key->total - $service_fee;

                                                        $total = $handyman_total - ( ($handyman_total) * ($commission_percentage/100) );

                                                        ?>

                                                      <td>€ <?php echo str_replace('.', ',', number_format($total,2)); ?></td>

                                                      <td><a href="{{ asset('handyman/view-images/' . $key->id ) }}">View</a></td>

                                                      <td>

                                                          <?php $date = strtotime($key->booking_date);

                                                          $date = date('Y-m-d',$date);  ?>

                                                          <form class="form-horizontal" id="form<?php echo $i; ?>" action="{{route('handyman-status-update')}}" method="POST" enctype="multipart/form-data">

                                                    {{csrf_field()}}



                                                    @if( $key->is_booked == 1)


                                                    @if( $key->is_completed == 1)


                                                    @if( $key->is_paid)

                                                    <button type="button" class="btn btn-sm btn-success" style="padding: 8px 22px;font-size: 14px;">{{$lang->past}}</button>


                                                    @else

                                                    <button type="button" class="btn btn-sm btn-info" style="padding: 8px 22px;font-size: 14px;">{{$lang->ppest}}</button>


                                                    @endif


                                                    @else

                                                <input type="hidden" name="item_id" id="item_id<?php echo $i; ?>" value="{{$key->id}}">

                                                <input type="hidden" name="select_id" id="select_id<?php echo $i; ?>" value="2">

                                                <input type="hidden" name="user_email" id="user_email<?php echo $i; ?>" value="{{$key->email}}">

                                                <input type="hidden" name="handyman_id" id="handyman_id<?php echo $i; ?>" value="{{$key->handyman_id}}">

                                                <select id="statusSelect<?php echo $i; ?>" name="statusSelect" class="btn btn-sm btn-success" style="padding: 8px 22px;font-size: 14px;" onchange="Change(<?php echo $i; ?>)">

                                                <option value="2" class="btn btn-sm btn-success" style="font-size: 15px;" selected>{{$lang->bst}}</option>
                                                <option value="3" class="btn btn-sm btn-info" style="font-size: 15px;">{{$lang->jcst}}</option>

                                                </select>

                                           

                                                    @endif


                                                    @else

                                                  @if( $date > date("Y-m-d") )

                                                  @if($key->is_cancelled == 0)


                                                  @if($key->cancel_req == 1)

                                                           <button type="button" class="btn btn-sm btn-danger" style="padding: 8px 22px;font-size: 14px;">{{$lang->rfcst}}</button>

                                                           @else

                                                  @if( $key->is_partial == 0 )

                                                  <input type="hidden" name="item_id" id="item_id<?php echo $i; ?>" value="{{$key->id}}">

                                                <input type="hidden" name="select_id" id="select_id<?php echo $i; ?>" value="0">

                                                <input type="hidden" name="user_email" id="user_email<?php echo $i; ?>" value="{{$key->email}}">

                                                <input type="hidden" name="handyman_id" id="handyman_id<?php echo $i; ?>" value="{{$key->handyman_id}}">

                                                <select id="statusSelect<?php echo $i; ?>" name="statusSelect" class="btn btn-sm btn-warning" style="padding: 8px 22px;font-size: 14px;" onchange="Change(<?php echo $i; ?>)">

                                                <option value="0" class="btn btn-sm btn-warning" style="font-size: 15px;" selected>{{$lang->pst}}</option>
                                                <option value="1" class="btn btn-sm btn-success" style="font-size: 15px;">{{$lang->acst}}</option>

                                                </select>

                                                  @else

                                                  <input type="hidden" name="item_id" id="item_id<?php echo $i; ?>" value="{{$key->id}}">
                                                  <input type="hidden" name="select_id" id="select_id<?php echo $i; ?>" value="0">
                                                  <input type="hidden" name="user_email" id="user_email<?php echo $i; ?>" value="{{$key->email}}">
                                                  <input type="hidden" name="handyman_id" id="handyman_id<?php echo $i; ?>" value="{{$key->handyman_id}}">

                                                                                  <select id="statusSelect<?php echo $i; ?>" name="statusSelect" class="btn btn-sm btn-warning" style="padding: 8px 22px;font-size: 14px;" onchange="Change(<?php echo $i; ?>)">

                                                                                      <option value="0" class="btn btn-sm btn-warning" style="font-size: 15px;" selected>{{$lang->ppst}}</option>
                                                                                      <option value="1" class="btn btn-sm btn-success" style="font-size: 15px;">{{$lang->acst}}</option>

                                                                                  </select>



                                                  @endif

                                                  @endif

                                                   @else

                                                           <button type="button" class="btn btn-sm btn-danger" style="padding: 8px 22px;font-size: 14px;">{{$lang->cast}}</button>


                                                           @endif


                                              @else

                                              @if( $key->is_cancelled == 0)

                                              @if( $key->cancel_req == 1)

                                              <button type="button" class="btn btn-sm btn-danger" style="padding: 8px 22px;font-size: 14px;">{{$lang->rfcst}}</button>

                                              @else

                                              <button type="button" class="btn btn-sm btn-danger" style="padding: 8px 22px;font-size: 14px;">{{$lang->est}}</button>

                                              @endif

                                                @else

                                                <button type="button" class="btn btn-sm btn-danger" style="padding: 8px 22px;font-size: 14px;">{{$lang->cast}}</button>

                                               @endif
                                               @endif
                                               @endif

                                             </form>
                                                       
                                                      </td>

                                                      <td><a href="{{ asset('handyman/invoice/' . $key->id ) }}">{{$lang->vbt}}</a></td>

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

    function Change(input)
    {


        var status_old = $('#select_id'+input).val();

        Swal.fire({
            title: <?php echo "'".$lang->ayst."'" ?>,
            text: <?php echo "'".$lang->uscm."'" ?>,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: <?php echo "'".$lang->qyt."'" ?>,
            cancelButtonText: <?php echo "'".$lang->qnt."'" ?>,
        }).then((result) => {
            if (result.value) {

                $('#form'+input).submit();

            }
            else{

                $('#statusSelect'+input).val(status_old);

                Swal.fire(
                    <?php echo "'".$lang->cant."'" ?>,
                    <?php echo "'".$lang->suct."'" ?>,
                    'info'
                )

            }
        })


    }
</script>

<style type="text/css">

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

  #negative{
    width: 160px !important;
  }

  #booking-images{
    width: 115px !important;
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