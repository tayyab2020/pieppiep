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
                                        <a style="background-color: #cf2525 !important;border-color: #cf2525 !important;" href="{{route('admin-prices-delete',$data->id)}}" class="btn add-newProduct-btn">
                                            <i style="font-size: 12px;" class="fa fa-minus"></i> Remove</a>
                                    </div>
                                    <hr>
                                    <div>
                                        @include('includes.form-success')

                                        <div class="row">
                                            <div class="col-sm-12">

                                                <table id="example"
                                                       class="table table-striped table-hover products dt-responsive dataTable no-footer dtr-inline"
                                                       role="grid" aria-describedby="product-table_wrapper_info"
                                                       style="width: 100%;" width="100%" cellspacing="0">
                                                    <thead>

                                                    <tr role="row">

                                                        <th class="sorting_asc" tabindex="0"
                                                            aria-controls="product-table_wrapper" rowspan="1"
                                                            colspan="1" style="width: 344px;" aria-sort="ascending"
                                                            aria-label="Blood Group Name: activate to sort column descending">

                                                        </th>

                                                        @foreach($widths as $width)

                                                            <th class="sorting_asc" tabindex="0"
                                                                aria-controls="product-table_wrapper" rowspan="1"
                                                                colspan="1" style="width: 144px;" aria-sort="ascending"
                                                                aria-label="Blood Group Name: activate to sort column descending">
                                                                {{$width}}
                                                            </th>

                                                        @endforeach

                                                    </tr>
                                                    </thead>

                                                    <tbody>

                                                    @foreach($org_heights as $i => $height)

                                                        <tr role="row">

                                                            <td>{{$height}}</td>

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

@endsection

@section('scripts')

    <script type="text/javascript">
        $('#example').DataTable();
    </script>

@endsection
