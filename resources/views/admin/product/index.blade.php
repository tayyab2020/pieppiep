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
                                    <div style="justify-content: flex-end;" class="add-product-header products">
                                        <h2 style="width: 100%;">{{auth()->user()->role_id == 4 ? 'My Products' : 'Supplier Products'}}</h2>

                                        @if(auth()->user()->role_id == 2)

                                            <a href="{{route('reset-supplier-margins')}}" style="margin: auto;" class="btn btn-success"><i style="margin-right: 5px;" class="fa fa-refresh"></i> Reset Margins</a>

                                        @endif

                                        @if(auth()->user()->role_id == 4)

                                            @if(auth()->user()->can('product-create'))

                                                <a style="margin-right: 10px;" href="{{route('admin-product-create')}}" class="btn add-newProduct-btn">
                                                    <i style="font-size: 12px;" class="fa fa-plus"></i> Add New Product</a>

                                            @endif

                                            @if(auth()->user()->can('product-import'))

                                                <a style="margin-right: 10px;background-color: #5cb85c !important;border-color: #5cb85c !important;" href="{{route('admin-product-import')}}" class="btn add-newProduct-btn">
                                                    <i style="font-size: 12px;" class="fa fa-plus"></i> Import Products</a>

                                            @endif

                                            @if(auth()->user()->can('product-export'))

                                                <a style="background-color: #5bc0de !important;border-color: #5bc0de !important;" href="{{route('admin-product-export')}}" class="btn add-newProduct-btn">
                                                    <i style="font-size: 12px;" class="fa fa-plus"></i> Export Products</a>

                                            @endif

                                        @endif

                                    </div>
                                    <hr>
                                    <div>
                                        @include('includes.form-success')

                                        @if(auth()->user()->role_id == 2)

                                            <form method="post" action="{{route('store-retailer-margins')}}">

                                                {{csrf_field()}}

                                        @endif

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
                                                                    Photo
                                                                </th>
                                                                <th class="sorting_asc" tabindex="0"
                                                                    aria-controls="product-table_wrapper" rowspan="1"
                                                                    colspan="1" style="width: 144px;" aria-sort="ascending"
                                                                    aria-label="Blood Group Name: activate to sort column descending">
                                                                    Title
                                                                </th>

                                                                @if(auth()->user()->role_id == 4)

                                                                    <th class="sorting_asc" tabindex="0"
                                                                        aria-controls="product-table_wrapper" rowspan="1"
                                                                        colspan="1" style="width: 144px;" aria-sort="ascending"
                                                                        aria-label="Blood Group Name: activate to sort column descending">
                                                                        Description
                                                                    </th>

                                                                    <th class="sorting_asc" tabindex="0"
                                                                        aria-controls="product-table_wrapper" rowspan="1"
                                                                        colspan="1" style="width: 144px;" aria-sort="ascending"
                                                                        aria-label="Blood Group Name: activate to sort column descending">
                                                                        Margin (%)
                                                                    </th>

                                                                @else

                                                                    <th class="sorting_asc" tabindex="0"
                                                                        aria-controls="product-table_wrapper" rowspan="1"
                                                                        colspan="1" style="width: 144px;" aria-sort="ascending"
                                                                        aria-label="Blood Group Name: activate to sort column descending">
                                                                        Supplier
                                                                    </th>

                                                                @endif

                                                                <th class="sorting_asc" tabindex="0"
                                                                    aria-controls="product-table_wrapper" rowspan="1"
                                                                    colspan="1" style="width: 144px;" aria-sort="ascending"
                                                                    aria-label="Blood Group Name: activate to sort column descending">
                                                                    Category
                                                                </th>
                                                                <th class="sorting_asc" tabindex="0"
                                                                    aria-controls="product-table_wrapper" rowspan="1"
                                                                    colspan="1" style="width: 144px;" aria-sort="ascending"
                                                                    aria-label="Blood Group Name: activate to sort column descending">
                                                                    Brand
                                                                </th>
                                                                <th class="sorting_asc" tabindex="0"
                                                                    aria-controls="product-table_wrapper" rowspan="1"
                                                                    colspan="1" style="width: 144px;" aria-sort="ascending"
                                                                    aria-label="Blood Group Name: activate to sort column descending">
                                                                    Model
                                                                </th>

                                                                @if(auth()->user()->role_id == 4)

                                                                    <th class="sorting" tabindex="0"
                                                                        aria-controls="product-table_wrapper" rowspan="1"
                                                                        colspan="1" style="width: 314px;"
                                                                        aria-label="Actions: activate to sort column ascending">
                                                                        Actions
                                                                    </th>

                                                                @else

                                                                    <th class="sorting" tabindex="0"
                                                                        aria-controls="product-table_wrapper" rowspan="1"
                                                                        colspan="1" style="width: 314px;"
                                                                        aria-label="Actions: activate to sort column ascending">
                                                                        Retailer Margin (%)
                                                                    </th>

                                                                @endif
                                                            </tr>
                                                            </thead>

                                                            <tbody>
                                                            @foreach($cats as $i => $cat)
                                                                <tr role="row" class="odd">
                                                                    <td tabindex="0" class="sorting_1"><img
                                                                            src="{{ $cat->photo ? asset('assets/images/'.$cat->photo):'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG'}}"
                                                                            alt="Category's Photo" style="max-height: 100px;">
                                                                    </td>
                                                                    <td>{{$cat->title}}</td>

                                                                    @if(auth()->user()->role_id == 4)

                                                                        <td>{!!$cat->description!!}</td>
                                                                        <td>{{$cat->margin}}</td>

                                                                    @else

                                                                        <td>{{$cat->company_name}}</td>

                                                                    @endif

                                                                    <td>{{$cat->category}}</td>
                                                                    <td>{{$cat->brand}}</td>
                                                                    <td>{{$cat->model}}</td>

                                                                    @if(auth()->user()->role_id == 4)

                                                                        <td>
                                                                            @if(auth()->user()->can('product-edit'))

                                                                                <a href="{{route('admin-product-edit',$cat->id)}}"
                                                                                   class="btn btn-primary product-btn"><i
                                                                                        class="fa fa-edit"></i> Edit</a>

                                                                            @endif

                                                                            @if(auth()->user()->can('product-delete'))

                                                                                <a href="{{route('admin-product-delete',$cat->id)}}"
                                                                                   class="btn btn-danger product-btn"><i
                                                                                        class="fa fa-trash"></i> Remove</a>

                                                                            @endif

                                                                            @if(auth()->user()->can('product-copy'))

                                                                                    <a href="{{route('admin-product-copy',$cat->id)}}"
                                                                                       class="btn btn-success product-btn"><i
                                                                                            class="fa fa-copy"></i> Copy</a>

                                                                            @endif

                                                                        </td>

                                                                    @else

                                                                        <td>
                                                                            <input type="hidden" name="product_ids[]" value="{{$cat->id}}">
                                                                            <input min="100" value="{{$cat->retailer_margin ? $cat->retailer_margin : $cat->margin}}" type="number" step="1" name="margin[]" class="form-control">
                                                                        </td>

                                                                    @endif

                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>

                                                        @if(auth()->user()->role_id == 2)

                                                            <div style="margin: 0 0 10px 0;text-align: center;" class="row">

                                                                <button type="submit" style="margin: auto;" class="btn btn-success"><i class="fa fa-check"></i>  Submit</button>

                                                            </div>

                                                        @endif

                                                    </div>
                                                </div>

                                        @if(auth()->user()->role_id == 2)

                                             </form>

                                        @endif

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
