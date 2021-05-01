@extends('layouts.admin')

@section('content')
    <div class="right-side">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- Starting of Dashboard Office Address -->
                    <div class="section-padding add-product-1">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="add-product-box">
                                    <div class="add-product-header">
                                        <h2>Vat Information</h2>
                                        <a href="{{route('admin-gs-create-vat')}}" class="btn add-newProduct-btn"><i class="fa fa-plus"></i> Add New</a>
                                    </div>

                                    <hr>

                                    <div>
                                        <div class="row">
                                            <div class="col-sm-12">

                                                @include('includes.form-success')

                                                <table id="example" class="handyman_table table table-striped table-hover products dt-responsive dataTable no-footer dtr-inline" role="grid" aria-describedby="product-table_wrapper_info" style="width: 100%;margin-top: 45px !important;" width="100%" cellspacing="0">
                                                    <thead>

                                                    <tr role="row">

                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending" id="client">VAT Percentage</th>

                                                        <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 239px;" aria-sort="ascending" aria-label="Donor's Photo: activate to sort column descending" id="photo">VAT Rule</th>

                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending" id="client">VAT Code</th>

                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending" id="date">Action</th>


                                                    </thead>

                                                    <tbody>
                                                    <?php $i=0;  ?>

                                                    @foreach($data as $key)

                                                        <tr role="row" class="odd">

                                                            <td style="outline: none;"><a href="{{ url('/logstof/general-settings/view-vat/'.$key->id) }}">{{$key->vat_percentage}} %</a></td>

                                                            <td>{{$key->rule}}</td>

                                                            <td>{{$key->code}}</td>

                                                            <td>
                                                                <div class="dropdown">
                                                                    <button style="outline: none;" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
                                                                        <span class="caret"></span></button>
                                                                    <ul class="dropdown-menu">
                                                                        <li><a href="{{ url('/logstof/general-settings/view-vat/'.$key->id) }}">View</a></li>
                                                                        <li><a href="{{ url('/logstof/general-settings/delete-vat/'.$key->id) }}">Delete</a></li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                    @endforeach
                                                    </tbody>
                                                </table></div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Ending of Dashboard Office Address -->
                </div>
            </div>
        </div>
    </div>
@endsection

<style>

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

    }

    tr{cursor: pointer;}

</style>

@section('scripts')

<script>

    $('#example').DataTable();

</script>

@endsection
