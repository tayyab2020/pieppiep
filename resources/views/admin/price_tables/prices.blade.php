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
                                    <div style="justify-content: flex-end;" class="add-product-header products">
                                        <h2 style="width: 100%;">Prices for Table {{$data->title}}</h2>
                                        <a href="{{route('admin-price-tables')}}" class="btn add-newProduct-btn">Back</a>
                                    </div>
                                    <hr>
                                    <div>
                                        @include('includes.form-success')

                                        <div class="row">
                                            <div class="col-sm-12">

                                                <table id="example1"
                                                       class="table table-striped table-hover products dt-responsive dataTable no-footer dtr-inline"
                                                       role="grid" aria-describedby="product-table_wrapper_info"
                                                       style="width: 100%;display: block;overflow-x: auto;" width="100%" cellspacing="0">
                                                    <thead>

                                                    <tr role="row">

                                                        <th class="sorting_asc" tabindex="0"
                                                            aria-controls="product-table_wrapper" rowspan="1"
                                                            colspan="1" style="padding: 0 25px;border: 1px solid #e7e7e7;" aria-sort="ascending"
                                                            aria-label="Blood Group Name: activate to sort column descending">

                                                        </th>

                                                        @foreach($widths as $width)

                                                            <th class="sorting_asc" tabindex="0"
                                                                aria-controls="product-table_wrapper" rowspan="1"
                                                                colspan="1" style="width: 144px;border: 1px solid #e7e7e7;" aria-sort="ascending"
                                                                aria-label="Blood Group Name: activate to sort column descending">
                                                                {{$width}}
                                                            </th>

                                                        @endforeach

                                                    </tr>
                                                    </thead>

                                                    <tbody>

                                                    @foreach($org_heights as $i => $height)

                                                        <tr role="row">

                                                            <td style="background-color: #e9e9e9;text-align: center;">{{$height}}</td>

                                                            @foreach($prices[$org_heights[$i]] as $key)

                                                                <td>{{$key['value']}}</td>

                                                            @endforeach

                                                        </tr>

                                                    @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
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

    <style>

        table.dataTable thead .sorting::after, table.dataTable thead .sorting_asc::after, table.dataTable thead .sorting_desc::after, table.dataTable thead .sorting_asc_disabled::after, table.dataTable thead .sorting_desc_disabled::after
        {
            display: none;
        }

    </style>

@endsection

@section('scripts')

    <script type="text/javascript">
        $('#example').DataTable();
    </script>

@endsection
