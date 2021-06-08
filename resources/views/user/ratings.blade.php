@extends('layouts.handyman')

@section('content')

<div class="right-side">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <!-- Starting of Dashboard data-table area -->
                        <div style="padding: 0;" class="section-padding add-product-1">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                  <div class="add-product-box">
                                      <div class="add-product-header products">
                                          <h2>{{$lang->hpmrt}}</h2>

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

                                                          <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 239px;" aria-sort="ascending" aria-label="Donor's Photo: activate to sort column descending" id="photo">{{$lang->inht}}</th>

                                                          <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending" id="client">{{$lang->cnht}}</th>

                                                          <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 95px;" aria-label="City: activate to sort column ascending" id="serv">{{$lang->ratt}}</th>

                                                          <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="date">{{$lang->hpbd}}</th>

                                                      </tr>

                                                      </thead>

                                                      <tbody>


                                                 <?php $i=1; $avg_rating = 0; ?>

                                                @foreach($ratings as $key)

                                                    <tr role="row" class="odd">

                                                        <td>{{$i}}</td>

                                                        <td><a href="{{ asset('handyman/invoice/' . $key->id ) }}">{{$key->invoice_number}}</a></td>

                                                        <td>{{$key->name}} {{$key->family_name}}</td>

                                                        <td>{{$key->client_rating}}</td>

                                                        <?php $date21 =date_create($key->booking_date);

                                                        $date12 = date_format($date21,"d-m-Y H:i:s"); ?>

                                                        <td>{{$date12}}</td>

                                                    </tr>

                                                  <?php $avg_rating = $key->client_rating + $avg_rating;  $i = $i + 1; ?>

                                                  @endforeach

                                                  @if(count($ratings) != 0)

                                                  <?php $total_jobs = count($ratings); $avg_rating = $avg_rating/($i-1); $rating = round($avg_rating); ?>

                                                  <tr role="row" class="even">
                                                    <td colspan="4" style="border-right: 1px solid #c7c7c7;font-size: 18px;">{{$lang->jct}}</td>
                                                    <td class="hide"></td>
                                                    <td class="hide"></td>
                                                    <td class="hide"></td>
                                                    <td style="font-size: 18px;">{{$total_jobs}}</td>
                                                  </tr>

                                                  <tr role="row" class="odd">
                                                    <td colspan="4" style="border-right: 1px solid #c7c7c7;font-size: 18px;">{{$lang->avrt}}</td>
                                                    <td class="hide"></td>
                                                    <td class="hide"></td>
                                                    <td class="hide"></td>
                                                    <td style="font-size: 18px;">{{$avg_rating}} <span class="fa fa-star checked" style="margin-left: 7px;"></span></td>
                                                  </tr>


                                                  <tr role="row" class="even">
                                                    <td colspan="4" style="border-right: 1px solid #c7c7c7;font-size: 18px;">{{$lang->acrt}}</td>
                                                    <td class="hide"></td>
                                                    <td class="hide"></td>
                                                    <td class="hide"></td>
                                                    <td style="font-size: 18px;">{{$rating}} <span class="fa fa-star checked" style="margin-left: 7px;"></span></td>
                                                  </tr>

                                                  @endif

                                                  </tbody>
                                          </table></div>

                                        </div>
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

                    .checked {
  color: orange !important;
}

    .text-left{

        font-size: 18px !important;
        text-align: center !important;

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

  .table.products > tbody > tr > td
  {

    text-align: center;

   }


</style>

@endsection

@section('scripts')

<script type="text/javascript">
  $('#example').DataTable({
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
