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
                                    <div style="justify-content: flex-end;" class="add-product-header products">
                                        <h2 style="width: 100%;">{{__('text.Items')}}</h2>

                                        @if(auth()->user()->can('create-item'))

                                            <a style="margin-right: 10px;" href="{{route('create-item')}}" class="btn add-newProduct-btn"><i class="fa fa-plus"></i> {{__('text.Add New Item')}}</a>

                                            <a style="margin-right: 10px;background-color: #5cb85c !important;border-color: #5cb85c !important;" href="{{route('import-items')}}" class="btn add-newProduct-btn">
                                                <i style="font-size: 12px;" class="fa fa-plus"></i> {{__('text.Import Items')}}</a>

                                            <a style="background-color: #5bc0de !important;border-color: #5bc0de !important;" href="{{route('export-items')}}" class="btn add-newProduct-btn">
                                                <i style="font-size: 12px;" class="fa fa-plus"></i> {{__('text.Export Items')}}</a>

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
                                                        <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 344px;" aria-sort="ascending" aria-label="Blood Group Name: activate to sort column descending">{{__('text.Photo')}}</th>
                                                        <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 144px;" aria-sort="ascending" aria-label="Blood Group Name: activate to sort column descending">{{__('text.Item')}}</th>
                                                        <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 144px;" aria-sort="ascending" aria-label="Blood Group Name: activate to sort column descending">{{__('text.Sell Rate')}}</th>
                                                        <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 144px;" aria-sort="ascending" aria-label="Blood Group Name: activate to sort column descending">{{__('text.Supplier')}}</th>
                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 314px;" aria-label="Actions: activate to sort column ascending">{{__('text.Actions')}}</th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    @foreach($items as $item)
                                                        <tr role="row" class="odd">
                                                            <td tabindex="0" class="sorting_1"><img src="{{ $item->photo ? asset('assets/item_images/'.$item->photo):'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG'}}" alt="Item's Photo" style="max-height: 100px;"></td>
                                                            <td>{{$item->cat_name}}</td>
                                                            <td>€ {{number_format((float)$item->sell_rate, 2, ',', '.')}}</td>
                                                            <td>{{$item->supplier}}</td>
                                                            <td>
                                                                @if(auth()->user()->can('edit-item'))
                                                                    <a href="{{route('edit-item',$item->id)}}" class="btn btn-primary product-btn"><i class="fa fa-edit"></i> {{__('text.Edit')}}</a>
                                                                @endif

                                                                @if(auth()->user()->can('delete-item'))
                                                                    <a href="{{route('delete-item',$item->id)}}" class="btn btn-danger product-btn"><i class="fa fa-trash"></i> {{__('text.Remove')}}</a>
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
