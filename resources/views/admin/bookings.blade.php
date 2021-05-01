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
                                          <h2>Bookings</h2>

                                      </div>
                                      <hr>
                  <div>
                                 @include('includes.form-success')
<div class="row">
  <div class="col-sm-12">
    <table id="example" class="table table-striped table-hover products dt-responsive dataTable no-footer dtr-inline" role="grid" aria-describedby="product-table_wrapper_info" style="width: 100%;margin-top: 55px !important;" width="100%" cellspacing="0">
                                              <thead>
                                                  <tr role="row">

                                                    <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 239px;" aria-sort="ascending" aria-label="Donor's Photo: activate to sort column descending" id="photo">Handyman's Photo</th>

                                                    <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending" id="client">Client's Name</th>


                                                    <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending" id="handyman">Handyman's Name</th>



                                                    <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 95px;" aria-label="City: activate to sort column ascending" id="serv">Invoice Number</th>


                                                    <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="rate">Booking Date</th>


                                                    <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="service">Total Amount</th>


                                                    <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="service">Images</th>

                                                    <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="service">Status</th>


                                                    <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="date">Action</th>

                                                    <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="date">Negative Invoice</th>



                                              </thead>

                                              <tbody>
                                                <?php $i=0;  ?>

                                                @foreach($data as $key)


                                                <?php for($i = 0; $i<sizeof($key['handymans']); $i++){  ?>





                                              <tr role="row" class="odd">

                                                      <td tabindex="0" class="sorting_1" id="img"><img src="{{ $key['handymans'][$i]->photo ? asset('assets/images/'.$key['handymans'][$i]->photo):'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG'}}" alt="User's Photo" style="height: 180px; width: 80%;margin: auto;display: block;"></td>

                                                      <td>{{$key['users'][$i]->name}} {{$key['users'][$i]->family_name}}</td>

                                                      <td>{{$key['handymans'][$i]->name}} {{$key['handymans'][$i]->family_name}}</td>
                                                 <td><a href="{{ asset('logstof/invoice/' . $key['users'][$i]->id ) }}">
                                                    {{$key['users'][$i]->invoice_number}}</a>
                                                        </td>

                                                        <?php $date = strtotime($key['users'][$i]->booking_date);

                                                          $date = date('d-m-Y',$date);  ?>

                                                      <td>{{$date}}</td>

                                                      <td>€ <?php echo str_replace('.', ',', $key['users'][$i]->total); ?></td>

                                                      <td><a href="{{ asset('logstof/view-images/' . $key['users'][$i]->id ) }}">View</a></td>



                                                      <td>

                                                               <?php $date = strtotime($key['users'][$i]->booking_date);

                                                          $date = date('Y-m-d',$date);  ?>

                                                          <form class="form-horizontal" id="form<?php echo $i; ?>" action="{{route('admin-status-update')}}" method="POST" enctype="multipart/form-data">

                                                    {{csrf_field()}}


                                                          @if( $key['users'][$i]->is_booked == 1)

                                                          @if( $key['users'][$i]->is_completed == 1)


                                                          @if( $key['users'][$i]->pay_req == 1)


                                                          @if( $key['users'][$i]->is_paid == 1)



                                                          <button type="button" class="btn btn-sm btn-success" style="padding: 8px 22px;font-size: 14px;">Paid</button>

                                                          @else

                                                          <input type="hidden" name="item_id" id="item_id<?php echo $i; ?>" value="{{$key['users'][$i]->id}}">

                                                <input type="hidden" name="select_id" id="select_id<?php echo $i; ?>" value="0">

                                                <input type="hidden" name="user_email" id="user_email<?php echo $i; ?>" value="{{$key['users'][$i]->email}}">


                                                <input type="hidden" name="handyman_email" id="handyman_email<?php echo $i; ?>" value="{{$key['handymans'][$i]->email}}">

                                                <input type="hidden" name="handyman_id" id="handyman_id<?php echo $i; ?>" value="{{$key['users'][$i]->handyman_id}}">

                                                <select id="statusSelect<?php echo $i; ?>" name="statusSelect" class="btn btn-sm btn-info" style="padding: 8px 22px;font-size: 14px;" onchange="Change(<?php echo $i; ?>)">

                                                <option value="0" class="btn btn-sm btn-info" style="font-size: 15px;" selected>Job Completed</option>

                                                <option value="1" class="btn btn-sm btn-success" style="font-size: 15px;">Paid</option>

                                                </select>



                                                          @endif



                                                          @else




                                                <!-- <button type="button" class="btn btn-sm btn-danger" style="padding: 8px 22px;font-size: 14px;">Job Incomplete</button> -->

                                                <button type="button" class="btn btn-sm btn-warning" style="padding: 8px 22px;font-size: 14px;">Payment Pending</button>



                                                          @endif




                                                          @else

                                                           <button type="button" class="btn btn-sm btn-success" style="padding: 8px 22px;font-size: 14px;">Booked</button>



                                                          @endif




                                                          @else

                                                           @if( $date > date("Y-m-d") )

                                                           @if( $key['users'][$i]->is_cancelled == 0)

                                                           @if( $key['users'][$i]->cancel_req == 1)

                                                           <input type="hidden" name="item_id" id="item_id<?php echo $i; ?>" value="{{$key['users'][$i]->id}}">

                                                <input type="hidden" name="select_id" id="select_id<?php echo $i; ?>" value="0">

                                                <input type="hidden" name="user_email" id="user_email<?php echo $i; ?>" value="{{$key['users'][$i]->email}}">


                                                <input type="hidden" name="handyman_email" id="handyman_email<?php echo $i; ?>" value="{{$key['handymans'][$i]->email}}">

                                                <input type="hidden" name="handyman_id" id="handyman_id<?php echo $i; ?>" value="{{$key['users'][$i]->handyman_id}}">

                                                <select id="statusSelect<?php echo $i; ?>" name="statusSelect" class="btn btn-sm btn-info" style="padding: 8px 22px;font-size: 14px;" onchange="Change(<?php echo $i; ?>)">

                                                <option value="0" class="btn btn-sm btn-info" style="font-size: 15px;" selected>Request for cancellation</option>

                                                <option value="2" class="btn btn-sm btn-success" style="font-size: 15px;">Take Action</option>

                                                </select>

                                                           @else


                                                            @if( $key['users'][$i]->is_partial == 0 )

                                                           <button type="button" class="btn btn-sm btn-warning" style="padding: 8px 22px;font-size: 14px;">Pending</button>

                                                           @else

                                                           <button type="button" class="btn btn-sm btn-warning" style="padding: 8px 22px;font-size: 14px;">Partial Payment</button>

                                                           @endif

                                                           @endif



                                                      @else


                                                          <button type="button" class="btn btn-sm btn-danger" style="padding: 8px 22px;font-size: 14px;">Cancelled</button>


                                                           @endif





                                                           @else

                                                           @if( $key['users'][$i]->is_cancelled == 0)

                                                           @if( $key['users'][$i]->cancel_req == 1)

                                                           <input type="hidden" name="item_id" id="item_id<?php echo $i; ?>" value="{{$key['users'][$i]->id}}">

                                                <input type="hidden" name="select_id" id="select_id<?php echo $i; ?>" value="0">

                                                <input type="hidden" name="user_email" id="user_email<?php echo $i; ?>" value="{{$key['users'][$i]->email}}">


                                                <input type="hidden" name="handyman_email" id="handyman_email<?php echo $i; ?>" value="{{$key['handymans'][$i]->email}}">

                                                <input type="hidden" name="handyman_id" id="handyman_id<?php echo $i; ?>" value="{{$key['users'][$i]->handyman_id}}">

                                                <select id="statusSelect<?php echo $i; ?>" name="statusSelect" class="btn btn-sm btn-info" style="padding: 8px 22px;font-size: 14px;" onchange="Change(<?php echo $i; ?>)">

                                                <option value="0" class="btn btn-sm btn-info" style="font-size: 15px;" selected>Request for cancellation</option>

                                                <option value="2" class="btn btn-sm btn-success" style="font-size: 15px;">Take Action</option>

                                                </select>

                                                @else

                                                <button type="button" class="btn btn-sm btn-danger" style="padding: 8px 22px;font-size: 14px;">Expired</button>

                                                @endif

                                                @else


                                                          <button type="button" class="btn btn-sm btn-danger" style="padding: 8px 22px;font-size: 14px;">Cancelled</button>

                                              @endif





                                                           @endif

                                                           @endif


                              <!-- Modal -->
  <div class="modal fade" id="myModal<?php echo $i; ?>" role="dialog" style="background-color: #0000008c;">
    <div class="modal-dialog" style="margin-top: 130px;width: 75%;">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body" style="display: inline-block;width: 100%;padding-bottom: 50px;">



         <div style="text-align: center;font-size: 18px;margin: 20px;">

            <div style="width: 50%;text-align: left;float: left;">

              <h3 style="text-align: center;width: 95%;margin: auto;margin-bottom: 15px;">Reason for cancellation</h3>

              <textarea readonly name="reason" id="reason" style="width: 95%;display: block;margin: auto;height: 300px;border:1px solid rgb(214, 214, 214);border-radius: 10px;padding: 15px;resize: none;">{{$key['users'][$i]->reason}}</textarea>

            </div>

            <div style="width: 50%;text-align: left;float: left;">

              <h3 style="text-align: center;width: 95%;margin: auto;margin-bottom: 15px;">Enter your reply</h3>

            <textarea placeholder="Enter your message for email" name="reply" id="reply" style="width: 95%;display: block;margin: auto;height: 300px;border:1px solid rgb(214, 214, 214);border-radius: 10px;padding: 15px;resize: none;"></textarea>

        </div></div>


        </div>




        <div class="modal-footer">
          <button type="button" id="send_reason<?php echo $i; ?>" class="btn btn-success" onclick="Send(<?php echo $i; ?>)">Approve</button>
        </div>
      </div>

    </div>
  </div>

                                                         </form>



                                                      </td>

                                                      <td><a href="{{ route('admin-hi', ['id' =>  $key['users'][$i]->id ] ) }}">View HI</a>

                                                          <br>
                                                          <br>

                                                          <a href="{{ route('admin-download-hi', ['id' => $key['users'][$i]->id]  ) }}">Download HI</a>

                                                          <br>
                                                          <br>

                                                          <a href="{{ route('admin-ci', ['id' => $key['users'][$i]->id] ) }}">View CI</a>

                                                          <br>
                                                          <br>

                                                          <a href="{{ route('admin-download-ci', ['id' => $key['users'][$i]->id] ) }}">Download CI</a>

                                                      </td>

                                                      <td>  @if($key['users'][$i]->is_cancelled)

                                                          <a href="{{ route('admin-chi', ['id' => $key['users'][$i]->id] ) }}">View HI</a>

                                                          <br>
                                                          <br>

                                                          <a href="{{ route('admin-download-chi', ['id' => $key['users'][$i]->id] ) }}">Download HI</a>

                                                                <br>
                                                                <br>

                                                          <a href="{{ route('admin-cci', ['id' => $key['users'][$i]->id] ) }}">View CI</a>

                                                              <br>
                                                              <br>

                                                          <a href="{{ route('admin-download-cci', ['id' => $key['users'][$i]->id] ) }}">Download CI</a>

                                                          @endif


                                                      </td>

                                                  </tr>



                                                <?php } ?>

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
           $('#form'+input).submit();
}

    function Change(input)
    {


        var status_old = $('#select_id'+input).val();

        var id = $('#statusSelect'+input).val();

        if(id == 2)
        {

          $(function () {
   $('#myModal'+input).modal('toggle');
   $('.modal-backdrop').hide();
});



$('#myModal'+input).on('hidden.bs.modal', function () {

    $('#statusSelect'+input).val(status_old);

});


        }

        else
        {


        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to update the status for this booking!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.value) {

                $('#form'+input).submit();

            }
            else{

                $('#statusSelect'+input).val(status_old);

                Swal.fire(
                    'Cancelled!',
                    'Status update cancelled!',
                    'info'
                )

            }
        })


        }



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
    width: 168px !important;
  }

  #client{
    width: 185px !important;
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
  $('#example').DataTable();
</script>

@endsection
