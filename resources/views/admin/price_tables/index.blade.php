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
                                        <h2 style="width: 100%;">Price Tables</h2>
                                        <a style="margin-right: 10px;" href="{{route('admin-price-tables-create')}}" class="btn add-newProduct-btn">
                                            <i style="font-size: 12px;" class="fa fa-plus"></i> Add New Table</a>
                                        <a style="margin-right: 10px;background-color: #5cb85c !important;border-color: #5cb85c !important;" href="{{route('admin-price-tables-import')}}" class="btn add-newProduct-btn">
                                            <i style="font-size: 12px;" class="fa fa-plus"></i> Import Prices</a>
                                        {{--<a style="background-color: #5bc0de !important;border-color: #5bc0de !important;" href="{{route('admin-price-tables-export')}}" class="btn add-newProduct-btn">
                                            <i style="font-size: 12px;" class="fa fa-plus"></i> Export Prices</a>--}}
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
                                                            colspan="1" style="width: 100px;" aria-sort="ascending"
                                                            aria-label="Blood Group Name: activate to sort column descending">
                                                            ID
                                                        </th>
                                                        <th class="sorting_asc" tabindex="0"
                                                            aria-controls="product-table_wrapper" rowspan="1"
                                                            colspan="1" style="width: 144px;" aria-sort="ascending"
                                                            aria-label="Blood Group Name: activate to sort column descending">
                                                            Table
                                                        </th>
                                                        <th class="sorting_asc" tabindex="0"
                                                            aria-controls="product-table_wrapper" rowspan="1"
                                                            colspan="1" style="width: 144px;" aria-sort="ascending"
                                                            aria-label="Blood Group Name: activate to sort column descending">
                                                            Color
                                                        </th>
                                                        <th class="sorting_asc" tabindex="0"
                                                            aria-controls="product-table_wrapper" rowspan="1"
                                                            colspan="1" style="width: 144px;" aria-sort="ascending"
                                                            aria-label="Blood Group Name: activate to sort column descending">
                                                            Color Code
                                                        </th>
                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="product-table_wrapper" rowspan="1"
                                                            colspan="1" style="width: 314px;"
                                                            aria-label="Actions: activate to sort column ascending">
                                                            Actions
                                                        </th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    @foreach($cats as $cat)
                                                        <tr role="row" class="odd">
                                                            <td>{{$cat->id}}</td>
                                                            <td>{{$cat->title}}</td>
                                                            <td>{{$cat->color}}</td>
                                                            <td>{{$cat->color_code}}</td>
                                                            <td>
                                                                <a href="{{route('admin-price-tables-edit',$cat->id)}}"
                                                                   class="btn btn-primary product-btn"><i
                                                                        class="fa fa-edit"></i> Edit Table</a>
                                                                <a href="{{route('admin-prices-view',$cat->id)}}"
                                                                   class="btn btn-primary product-btn"><i
                                                                        class="fa fa-edit"></i> View Prices</a>
                                                                <a href="{{route('admin-price-tables-delete',$cat->id)}}"
                                                                   class="btn btn-danger product-btn"><i
                                                                        class="fa fa-trash"></i> Remove</a>
                                                                <a href="{{route('admin-prices-delete',$cat->id)}}"
                                                                   class="btn btn-danger product-btn"><i
                                                                        class="fa fa-trash"></i> Remove Prices</a>
                                                            </td>
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
