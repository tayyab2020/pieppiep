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
                                        <h2>Types</h2>

                                        <div>

{{--                                            <a style="border-radius: 30px;" href="{{route('other-suppliers-types')}}" class="btn btn-success"><i style="font-size: 12px;" class="fa fa-plus"></i> Add Types from other suppliers</a>--}}

                                            @if(auth()->user()->can('model-create'))

                                                <a href="{{route('admin-model-create')}}" class="btn add-newProduct-btn"><i
                                                            class="fa fa-plus"></i> Add New Type</a>

                                            @endif

                                        </div>

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
                                                            Brand
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
                                                        <th class="sorting_asc" tabindex="0"
                                                            aria-controls="product-table_wrapper" rowspan="1"
                                                            colspan="1" style="width: 144px;" aria-sort="ascending"
                                                            aria-label="Blood Group Name: activate to sort column descending">
                                                            My Type
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
                                                            <td>{{$cat->brand}}</td>
                                                            <td>{!!$cat->description!!}</td>
                                                            <td>{{$cat->cat_slug}}</td>
                                                            <td>
                                                                @if($cat->user_id != $user_id)

                                                                    <button class="btn btn-danger">No</button>

                                                                @else

                                                                    <button class="btn btn-success">Yes</button>

                                                                @endif
                                                            </td>
                                                            <td>

                                                                @if(auth()->user()->can('model-edit'))

                                                                    <a href="{{route('admin-model-edit',$cat->id)}}"
                                                                       class="btn btn-primary product-btn"><i
                                                                            class="fa fa-edit"></i> Edit</a>

                                                                @endif

                                                                @if(auth()->user()->can('model-delete'))

                                                                        @if($cat->user_id == $user_id)

                                                                            <a href="{{route('admin-model-delete',$cat->id)}}"
                                                                               class="btn btn-danger product-btn"><i
                                                                                        class="fa fa-trash"></i> Remove</a>

                                                                        @endif

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
        $('#example').DataTable({
            "oLanguage": {
                "sLengthMenu": "<?php echo __('text.Show') . ' _MENU_ ' . __('text.records'); ?>",
                "sSearch": "<?php echo __('text.Search') . ':' ?>",
                "sInfo": "<?php echo __('text.Showing') . ' _START_ ' . __('text.to') . ' _END_ ' . __('text.of') . ' _TOTAL_ ' . __('text.items'); ?>",
                "sInfoEmpty": "<?php echo __('text.No data available in table'); ?>",
                "sZeroRecords": "<?php echo __('text.No data available in table'); ?>",
                "sInfoFiltered": "<?php echo '- ' . __('text.filtered from') . ' _MAX_ ' . __('text.records'); ?>",
                "oPaginate": {
                    "sPrevious": "<?php echo __('text.Previous'); ?>",
                    "sNext": "<?php echo __('text.Next'); ?>"
                },
                "sEmptyTable": '<?php echo __('text.No data available in table'); ?>'
            }
        });
    </script>

@endsection
