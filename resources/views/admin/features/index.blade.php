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
                                        <h2>Features</h2>

                                        @if(auth()->user()->can('create-feature'))

                                            <a href="{{route('admin-feature-create')}}" class="btn add-newProduct-btn"><i class="fa fa-plus"></i> Add New Feature</a>

                                        @endif

                                    </div>
                                    <hr>
                                    <div>
                                        @include('includes.form-success')

                                        <div class="row">
                                            <div class="col-sm-12">

                                                <table id="example" class="table table-striped table-hover products dt-responsive dataTable no-footer dtr-inline" role="grid" aria-describedby="product-table_wrapper_info" style="width: 100%;" width="100%" cellspacing="0">
                                                    <thead>
                                                    <tr role="row">
                                                        <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 344px;" aria-sort="ascending" aria-label="Blood Group Name: activate to sort column descending">ID</th>
                                                        <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 144px;" aria-sort="ascending" aria-label="Blood Group Name: activate to sort column descending">Title</th>
                                                        <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 144px;" aria-sort="ascending" aria-label="Blood Group Name: activate to sort column descending">Comment Box</th>
                                                        <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 144px;" aria-sort="ascending" aria-label="Blood Group Name: activate to sort column descending">PDF Order No</th>
                                                        <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 144px;" aria-sort="ascending" aria-label="Blood Group Name: activate to sort column descending">Quote Order No</th>
                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 314px;" aria-label="Actions: activate to sort column ascending">Actions</th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    @foreach($features as $item)
                                                        <tr role="row" class="odd">
                                                            <td>{{$item->id}}</td>
                                                            <td>{{$item->title}}</td>
                                                            <td>{{$item->comment_box ? 'Yes' : 'No'}}</td>
                                                            <td>{{$item->order_no + 1}}</td>
                                                            <td>{{$item->quote_order_no}}</td>
                                                            <td>
                                                                @if(auth()->user()->can('edit-feature'))

                                                                    <a href="{{route('admin-feature-edit',$item->id)}}" class="btn btn-primary product-btn"><i class="fa fa-edit"></i> Edit</a>

                                                                @endif

                                                                @if(auth()->user()->can('delete-feature'))

                                                                        <a href="{{route('admin-feature-delete',$item->id)}}" class="btn btn-danger product-btn"><i class="fa fa-trash"></i> Remove</a>

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

                                <div style="margin-top: 30px;" class="add-product-box">
                                    <div class="add-product-header products">
                                        
                                        <h2>Default Features</h2>

                                    </div>
                                    <hr>
                                    <div>
                                        @include('includes.form-success')

                                        <div class="row">
                                            <div class="col-sm-12">

                                                <table id="example1" class="table table-striped table-hover products dt-responsive dataTable no-footer dtr-inline" role="grid" aria-describedby="product-table_wrapper_info" style="width: 100%;" width="100%" cellspacing="0">
                                                    <thead>
                                                    <tr role="row">
                                                        <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 344px;" aria-sort="ascending" aria-label="Blood Group Name: activate to sort column descending">ID</th>
                                                        <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 144px;" aria-sort="ascending" aria-label="Blood Group Name: activate to sort column descending">Title</th>
                                                        <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 144px;" aria-sort="ascending" aria-label="Blood Group Name: activate to sort column descending">Comment Box</th>
                                                        <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 144px;" aria-sort="ascending" aria-label="Blood Group Name: activate to sort column descending">PDF Order No</th>
                                                        <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 144px;" aria-sort="ascending" aria-label="Blood Group Name: activate to sort column descending">Quote Order No</th>
                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 314px;" aria-label="Actions: activate to sort column ascending">Actions</th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    @foreach($default_features as $item)
                                                        <tr role="row" class="odd">
                                                            <td>{{$item->id}}</td>
                                                            <td>{{$item->title}}</td>
                                                            <td>{{$item->comment_box ? 'Yes' : 'No'}}</td>
                                                            <td>{{$item->order_no + 1}}</td>
                                                            <td>{{$item->quote_order_no}}</td>
                                                            <td>
                                                                <a href="{{route('add-default-feature',$item->id)}}" class="btn btn-primary product-btn"><i class="fa fa-edit"></i> Add to list</a>
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

    <style>

    .add-product-1
    {
        background-color: transparent;
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

        $('#example1').DataTable({
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
