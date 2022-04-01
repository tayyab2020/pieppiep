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
                                        
                                        <h2>Brands</h2>

                                        <a href="{{route('admin-my-brand-create')}}" class="btn add-newProduct-btn"><i class="fa fa-plus"></i> Add New Brand</a>

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
                                                            colspan="1" aria-sort="ascending"
                                                            aria-label="Blood Group Name: activate to sort column descending">
                                                            Photo
                                                        </th>
                                                        <th class="sorting_asc" tabindex="0"
                                                            aria-controls="product-table_wrapper" rowspan="1"
                                                            colspan="1" style="width: 144px;" aria-sort="ascending"
                                                            aria-label="Blood Group Name: activate to sort column descending">
                                                            Title
                                                        </th>
                                                        <th class="sorting_asc" tabindex="0"
                                                            aria-controls="product-table_wrapper" rowspan="1"
                                                            colspan="1" style="width: 144px;" aria-sort="ascending"
                                                            aria-label="Blood Group Name: activate to sort column descending">
                                                            Trademark
                                                        </th>
                                                        <th class="sorting_asc" tabindex="0"
                                                            aria-controls="product-table_wrapper" rowspan="1"
                                                            colspan="1" style="width: 144px;" aria-sort="ascending"
                                                            aria-label="Blood Group Name: activate to sort column descending">
                                                            Main Supplier
                                                        </th>
                                                        <th class="sorting_asc" tabindex="0"
                                                            aria-controls="product-table_wrapper" rowspan="1"
                                                            colspan="1" style="width: 144px;" aria-sort="ascending"
                                                            aria-label="Blood Group Name: activate to sort column descending">
                                                            Suppliers
                                                        </th>
                                                        <th class="sorting_asc" tabindex="0"
                                                            aria-controls="product-table_wrapper" rowspan="1"
                                                            colspan="1" style="width: 144px;" aria-sort="ascending"
                                                            aria-label="Blood Group Name: activate to sort column descending">
                                                            Slug
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
                                                    @foreach($brands->unique('id') as $cat)
                                                        <tr role="row" class="odd">
                                                            <td tabindex="0" class="sorting_1"><img
                                                                    src="{{ $cat->photo ? asset('assets/images/'.$cat->photo):'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG'}}"
                                                                    alt="Category's Photo" style="max-height: 100px;">
                                                            </td>
                                                            <td>{{$cat->cat_name}}</td>
                                                            <td>
                                                                @if($cat->trademark)

                                                                    <button class="btn btn-success">Yes</button>

                                                                @else

                                                                    <button class="btn btn-danger">No</button>

                                                                @endif
                                                            </td>
                                                            <td>{{$cat->main_supplier}}</td>
                                                            <td>
                                                                @if($cat->other_suppliers)
                                                                    <select style="width: 80%;" class="form-control">

                                                                        @foreach($brands as $key)

                                                                            @if($key->id == $cat->id)
                                                                                <option>{{$key->company_name}}</option>
                                                                            @endif

                                                                        @endforeach

                                                                    </select>
                                                                @endif
                                                            </td>
                                                            <td>{{$cat->cat_slug}}</td>
                                                            <td>
                                                                <a href="{{route('admin-my-brand-edit',$cat->id)}}" class="btn btn-primary product-btn"><i class="fa fa-edit"></i> Edit</a>
                                                                <a href="{{route('admin-my-brand-edit-requests',$cat->id)}}" class="btn btn-primary product-btn"><i class="fa fa-edit"></i> Edit Requests</a>
                                                                <a href="{{route('admin-my-brand-delete',$cat->id)}}" class="btn btn-danger product-btn"><i class="fa fa-trash"></i> Remove</a>
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

            <div class="text-center clearfix clear col-md-12 margin_tb_5" >
                <div class="pagination"> {!! $brands->render() !!} </div>
            </div>

        </div>
    </div>

    <style>
        .page-link
        {
            border-radius: 0 !important;
        }
    </style>

@endsection

@section('scripts')

    <script type="text/javascript">
        $('#example').DataTable({
            paging: false,
        });
    </script>

@endsection
