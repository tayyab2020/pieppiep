@extends('layouts.client')

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
                                          <h2>{{$lang->cbit}}</h2>
                                          
                                      </div>
                                      <hr>
                  <div>


        
        <div class="row">
  <div class="col-sm-12">
    <table id="example" class="table table-striped table-hover products dt-responsive dataTable no-footer dtr-inline" role="grid" aria-describedby="product-table_wrapper_info" style="width: 100%;margin-top: 55px !important;" width="100%" cellspacing="0">
                                              <thead>
                                                  <tr role="row">

                                                  <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 95px;" aria-label="City: activate to sort column ascending" >Sr No</th>

                                                    <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 239px;" aria-sort="ascending" aria-label="Donor's Photo: activate to sort column descending" id="photo">{{$lang->cbipt}}</th>

                                                    <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending" id="client">{{$lang->cbist}}</th>




                                                    <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 95px;" aria-label="City: activate to sort column ascending" id="serv">{{$lang->cbidt}}</th>





                                                </tr>
                                              </thead>

                                              <tbody>
                                                <?php $i=1;  ?>

                                                @foreach($data as $key)

                                                    <tr role="row" class="odd">

                                                        <td>{{$i}}</td>



                                                      <td tabindex="0" class="sorting_1" id="img">

                                                        @if($key->image)

                                                        <a href="{{ asset('assets/bookingImages/'.$key->image) }}" target="_blank">

                                                        <img src="{{ asset('assets/bookingImages/'.$key->image) }}"  style="height: 260px; width: 80%;margin: auto;display: block;">

                                                        </a>

                                                        @else

                                                        {{$lang->cbinit}}

                                                    @endif
                                                </td>

                                                      <td>{{$key->cat_name}}</td>
                                                      
                                                <td>{{$key->description}}</td>

                                               
                                                  </tr>

                                                    <?php $i = $i + 1; ?>

                                                  @endforeach
                                                  </tbody>
                                          </table></div></div>

   
</div></div></div></div></div></div></div></div></div>


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



  .table.products > tbody > tr > td
  { 

    text-align: center;
    padding: 40px;

   }


</style>


    @endsection


@section('scripts')

<script type="text/javascript">
  $('#example').DataTable();
</script>

@endsection