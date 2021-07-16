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
                                    <div class="add-product-header products">
                                        <h2>Brands</h2>

                                        @if(auth()->user()->can('brand-create'))

                                            <a href="{{route('admin-brand-create')}}" class="btn add-newProduct-btn"><i
                                                    class="fa fa-plus"></i> Add New Brand</a>

                                        @endif

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
                                                            Description
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
                                                    @foreach($cats as $cat)
                                                        <tr role="row" class="odd">
                                                            <td tabindex="0" class="sorting_1"><img
                                                                    src="{{ $cat->photo ? asset('assets/images/'.$cat->photo):'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG'}}"
                                                                    alt="Category's Photo" style="max-height: 100px;">
                                                            </td>
                                                            <td>{{$cat->cat_name}}</td>
                                                            <td>{!!$cat->description!!}</td>
                                                            <td>{{$cat->cat_slug}}</td>
                                                            <td>
                                                                @if(auth()->user()->can('brand-edit'))

                                                                    <a href="{{route('admin-brand-edit',$cat->id)}}"
                                                                       class="btn btn-primary product-btn"><i
                                                                            class="fa fa-edit"></i> Edit</a>

                                                                @endif

                                                                @if(auth()->user()->can('brand-delete'))

                                                                        <a href="{{route('admin-brand-delete',$cat->id)}}"
                                                                           class="btn btn-danger product-btn"><i
                                                                                class="fa fa-trash"></i> Remove</a>

                                                                @endif

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
