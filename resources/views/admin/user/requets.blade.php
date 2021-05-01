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
                                          <h2>Handyman Update Requests</h2>

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



                                                    <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending" id="handyman">Handyman's Name</th>




                                                    <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="rate">Request Posting Date</th>

                                                    <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="rate">Request Update Date</th>




                                                    <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="date">Action</th>



                                              </thead>

                                              <tbody>
                                                <?php $i=0;  ?>

                                                @foreach($users_requests as $key)



                                              <tr role="row" class="odd">

                                                      <td tabindex="0" class="sorting_1" id="img"><img src="{{ $key->photo ? asset('assets/images/'.$key->photo):asset('assets/default.jpg')}}" alt="User's Photo" style="height: 180px; width: 80%;margin: auto;display: block;"></td>

                                                      <td>{{$key->name}} {{$key->family_name}}</td>

                                                      <td>{{$key->Date}}</td>

                                                      <td>{{$key->UpdateDate}}</td>


                                                      <td><a href="{{ asset('logstof/request/' . $key->handyman_id ) }}">View</a></td>

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
    width: 25% !important;
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
