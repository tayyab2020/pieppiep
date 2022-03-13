@extends('layouts.handyman')

@section('content')
    <div class="right-side">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- Starting of Dashboard data-table area -->
                    <div class="section-padding add-product-1" style="padding: 0;">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="add-product-box">
                                    {{--<div class="add-product-header products">
                                        <h2>Products</h2>
                                        <a href="{{route('product-create')}}" class="btn add-newProduct-btn"><i
                                                class="fa fa-plus"></i> Add New Product</a>
                                    </div>
                                    <hr>--}}
                                    <div>
                                        @include('includes.form-success')

                                        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
                                        <link rel="stylesheet" href="https://gurayyarar.github.io/AdminBSBMaterialDesign/css/style.css" />

                                        <script src="{{asset('assets/admin/js/editable.js?v=1.1')}}"></script>

                                        @if(Route::currentRouteName() == 'service-create')

                                            <form method="post" action="{{route('service-store')}}">

                                                {{csrf_field()}}

                                                <div class="row">
                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                                        <div class="card" style="box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);margin-bottom: 0;">
                                                            <div class="header">

                                                                <h2 style="font-weight: bold;">Select Services</h2>

                                                                <ul class="header-dropdown m-r--5">
                                                                    <li class="dropdown">
                                                                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true">
                                                                            {{--<i class="material-icons">more_vert</i>--}}
                                                                        </a>
                                                                        {{--<ul class="dropdown-menu pull-right">
                                                                            <li><a href="javascript:void(0);" class=" waves-effect waves-block">Action</a></li>
                                                                            <li><a href="javascript:void(0);" class=" waves-effect waves-block">Another action</a></li>
                                                                            <li><a href="javascript:void(0);" class=" waves-effect waves-block">Something else here</a></li>
                                                                        </ul>--}}
                                                                    </li>
                                                                </ul>
                                                            </div>

                                                            <div class="body">
                                                                <table id="example1" class="mainTable table table-striped table-hover products dt-responsive dataTable no-footer dtr-inline" role="grid" aria-describedby="product-table_wrapper_info" style="width: 100%;cursor: pointer;display: block;overflow-y: auto;" width="100%" cellspacing="0">
                                                                    <thead>
                                                                    <tr role="row">
                                                                        <th class="no-sort">{{__('text.Select')}}</th>
                                                                        <th class="sorting" id="photo" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" aria-label="Donor's Name: activate to sort column ascending">ID</th>
                                                                        <th class="sorting" id="photo" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" aria-label="Donor's Name: activate to sort column ascending">{{__('text.Photo')}}</th>
                                                                        {{--<th class="sorting" id="client" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" aria-label="Donor's Name: activate to sort column ascending">{{__('text.Title')}}</th>--}}
                                                                        {{--<th class="sorting" id="client"  tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" aria-label="Donor's Name: activate to sort column ascending">Slug</th>--}}
                                                                        <th class="sorting" id="client"  tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" aria-label="Donor's Name: activate to sort column ascending">{{__('text.Title')}}</th>
                                                                        <th class="sorting" id="client"  tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" aria-label="Donor's Name: activate to sort column ascending">Slug</th>
                                                                        <th class="sorting" id="client"  tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" aria-label="Donor's Name: activate to sort column ascending">{{__('text.Description')}}</th>
                                                                        <th class="sorting" id="client"  tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" aria-label="Donor's Name: activate to sort column ascending">Estimated Prices</th>
                                                                        <th class="sorting" id="client"  tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" aria-label="Donor's Name: activate to sort column ascending">{{__('text.Measure')}}</th>
                                                                        <th class="sorting" id="client"  tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" aria-label="Donor's Name: activate to sort column ascending">{{__('text.Rate')}}</th>
                                                                        <th class="sorting" id="client"  tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" aria-label="Donor's Name: activate to sort column ascending">{{__('text.Sell Rate')}}</th>
                                                                        <th class="sorting" id="client"  tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" aria-label="Donor's Name: activate to sort column ascending">{{__('text.VAT')}} %</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                    @foreach($services as $i => $cat)

                                                                        <tr role="row" class="odd">

                                                                            <td style="outline: none;" data-editable="false">
                                                                                <label class="container-checkbox">
                                                                                    <input value="" class="services-checkboxes" name="service_checkboxes[]" type="checkbox">
                                                                                    <span class="checkmark-checkbox"></span>
                                                                                </label>
                                                                            </td>
                                                                            <td data-editable="false" class="sorting_1">
                                                                                {{$cat->id}}
                                                                            </td>
                                                                            <td data-editable="false">
                                                                                <img src="{{ $cat->photo ? asset('assets/images/'.$cat->photo):'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG'}}" alt="Category's Photo" style="max-height: 100px;">
                                                                            </td>
                                                                            {{--<td data-editable="false">{{$cat->title}}</td>--}}
                                                                            {{--<td data-editable="false">{{$cat->slug}}</td>--}}
                                                                            <td data-editable="false">{{$cat->title}}</td>
                                                                            <td data-editable="false">{{$cat->slug}}</td>
                                                                            <td data-editable="false">{!! $cat->description !!}</td>
                                                                            <td data-editable="false">{{$cat->estimated_prices}}</td>
                                                                            <td data-editable="false">{{$cat->measure}}</td>
                                                                            {{--<td data-type="model_number"></td>--}}
                                                                            <td data-type="rate"><span style="border: 2px solid;display: block;width: 100%;">€</span></td>
                                                                            <td data-type="sell_rate"><span style="border: 2px solid;display: block;width: 100%;">€</span></td>
                                                                            <td data-editable="false">21</td>

                                                                            <input type="hidden" name="service_id[]" value="{{$cat->id}}" />
                                                                            <input class="product_rate" name="product_rate[]" step="any" value="" type="hidden">
                                                                            <input class="product_sell_rate" name="product_sell_rate[]" step="any" value="" type="hidden">
                                                                            {{--<input class="model_number" name="model_number[]" value="" type="hidden">--}}

                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>

                                                                @if(auth()->user()->can('service-store'))

                                                                    <button type="button" style="margin: auto;" class="btn add-newProduct-btn"><i class="fa fa-plus"></i> Add Service (s)</button>

                                                                @endif

                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>

                                            </form>

                                        @else

                                            <div class="row">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                    <div class="card" style="box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);margin-bottom: 0;">
                                                        <div style="display: flex;justify-content: space-between;align-items: center;" class="header">

                                                            <h2 style="font-weight: bold;">Services Overview</h2>

                                                            @if(auth()->user()->can('service-create'))

                                                                <a href="{{route('service-create')}}" class="btn btn-success"><i class="fa fa-plus"></i> Add Services</a></li>

                                                            @endif

                                                            <ul class="header-dropdown m-r--5">
                                                                <li class="dropdown">
                                                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true">
                                                                        {{--<i class="material-icons">more_vert</i>--}}
                                                                    </a>
                                                                    {{--<ul class="dropdown-menu pull-right">
                                                                        <li><a href="javascript:void(0);" class=" waves-effect waves-block">Action</a></li>
                                                                        <li><a href="javascript:void(0);" class=" waves-effect waves-block">Another action</a></li>
                                                                        <li><a href="javascript:void(0);" class=" waves-effect waves-block">Something else here</a></li>
                                                                    </ul>--}}
                                                                </li>
                                                            </ul>
                                                        </div>

                                                        <div class="body">
                                                            <table id="example2" class="table table-striped table-hover products dt-responsive dataTable no-footer dtr-inline" role="grid" aria-describedby="product-table_wrapper_info" style="width: 100%;cursor: pointer;" width="100%" cellspacing="0">
                                                                <thead>
                                                                <tr role="row">
                                                                    <th class="sorting" id="photo" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" aria-label="Donor's Name: activate to sort column ascending">{{__('text.Photo')}}</th>
                                                                    <th class="sorting" id="client" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" aria-label="Donor's Name: activate to sort column ascending">{{__('text.Title')}}</th>
                                                                    <th class="sorting" id="client"  tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" aria-label="Donor's Name: activate to sort column ascending">Slug</th>
                                                                    <th class="sorting" id="client"  tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" aria-label="Donor's Name: activate to sort column ascending">{{__('text.Description')}}</th>
                                                                    <th class="sorting" id="client"  tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" aria-label="Donor's Name: activate to sort column ascending">Estimated Prices</th>
                                                                    <th class="sorting" id="client"  tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" aria-label="Donor's Name: activate to sort column ascending">{{__('text.Measure')}}</th>
                                                                    <th class="sorting" id="client"  tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" aria-label="Donor's Name: activate to sort column ascending">{{__('text.Rate')}}</th>
                                                                    <th class="sorting" id="client"  tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" aria-label="Donor's Name: activate to sort column ascending">{{__('text.Sell Rate')}}</th>
                                                                    <th class="sorting" id="client"  tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" aria-label="Donor's Name: activate to sort column ascending">{{__('text.VAT')}} %</th>
                                                                    <th class="sorting" id="client"  tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" aria-label="Donor's Name: activate to sort column ascending">{{__('text.Actions')}}</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>

                                                                @foreach($services_selected as $cat)

                                                                    <tr role="row" class="odd">
                                                                        <td data-editable="false" tabindex="0" class="sorting_1"><img
                                                                                src="{{ $cat->photo ? asset('assets/images/'.$cat->photo):'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG'}}"
                                                                                alt="Category's Photo" style="max-height: 100px;">
                                                                        </td>
                                                                        <td data-editable="false">{{$cat->title}}</td>
                                                                        <td data-editable="false">{{$cat->slug}}</td>
                                                                        <td data-editable="false">{!! $cat->description !!}</td>
                                                                        <td data-editable="false">{{$cat->estimated_prices}}</td>
                                                                        <td data-editable="false">{{$cat->measure}}</td>
                                                                        <td>{{$cat->rate}}</td>
                                                                        <td>{{$cat->sell_rate}}</td>
                                                                        <td data-editable="false">21</td>
                                                                        <td data-editable="false">

                                                                                @if(auth()->user()->can('service-edit'))

                                                                                    <a href="{{route('service-edit',$cat->id)}}"
                                                                                       class="btn btn-primary product-btn"><i
                                                                                            class="fa fa-edit"></i> {{__('text.Edit')}}</a>

                                                                                @endif

                                                                                @if(auth()->user()->can('service-delete'))

                                                                                    <a href="{{route('service-delete',$cat->id)}}"
                                                                                       class="btn btn-danger product-btn"><i
                                                                                            class="fa fa-trash"></i> {{__('text.Remove')}}</a>

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

                                        @endif

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

            .alert p
            {
                color: #ffffff !important;
            }

            @media (max-width: 768px)
            {
                .card .body
                {
                    padding-left: 0;
                    padding-right: 0;
                }
            }

            .container-checkbox {
                display: flex;
                justify-content: center;
                position: relative;
                /*padding-left: 30px;*/
                margin-bottom: 12px;
                cursor: pointer;
                font-size: 22px;
                font-weight: 300;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
                align-items: center;
                font-family: sans-serif;
                color: #353535;
            }

            /* Hide the browser's default radio button */
            .container-checkbox input {
                position: absolute;
                opacity: 0;
                cursor: pointer;
                height: 0;
                width: 0;
            }

            /* Create a custom radio button */
            .checkmark-checkbox {
                position: relative;
                /*top: 6.5px;*/
                left: 0;
                height: 20px;
                width: 20px;
                background-color: transparent;
                border: 1px solid #979797;
                border-radius: 2px;
            }

            /* On mouse-over, add a grey background color */
            .container-checkbox:hover input ~ .checkmark-checkbox {
                background-color: #ccc;
            }

            /* When the radio button is checked, add a blue background */
            .container-checkbox input:checked ~ .checkmark-checkbox {
                background-color: #2196F3;
            }

            /* Create the indicator (the dot/circle - hidden when not checked) */
            .checkmark-checkbox:after {
                content: "";
                position: absolute;
                display: none;
            }

            /* Show the indicator (dot/circle) when checked */
            .container-checkbox input:checked ~ .checkmark-checkbox:after {
                display: block;
            }

            /* Style the indicator (dot/circle) */
            .container-checkbox .checkmark-checkbox:after {
                left: 7px;
                top: 3.5px;
                width: 5px;
                height: 10px;
                border: solid white;
                border-width: 0 3px 3px 0;
                -webkit-transform: rotate(45deg);
                -ms-transform: rotate(45deg);
                transform: rotate(45deg);
            }

            .hide-col
            {
                display: none !important;
            }

            .col-sm-5
            {
                margin-bottom: 0 !important;
            }

            .col-sm-7
            {
                margin-bottom: 0 !important;
            }

            .navbar
            {
                position: relative;
            }

            #photo
            {
                width: 250px !important;
            }

            #client
            {
                width: 170px !important;
            }



            .btn
            {
                display: flex;
                align-items: center;
            }

            .fa
            {
                top: 0 !important;
                margin-right: 5px;
                font-size: 13px !important;
            }

            .table.products > tbody > tr > td
            {
                text-align: center;
            }

            table.dataTable thead>tr>th.sorting_asc, table.dataTable thead>tr>th.sorting_desc, table.dataTable thead>tr>th.sorting, table.dataTable thead>tr>td.sorting_asc, table.dataTable thead>tr>td.sorting_desc, table.dataTable thead>tr>td.sorting
            {
                padding-right: 0;
                padding-left: 0;
                text-align: center;
            }

            table tr>th
            {
                border-top: 1px solid #e1e1e1 !important;
                border-bottom: 1px solid #e1e1e1 !important;
            }

            .dtr-details .dtr-data .btn
            {
                margin: 5px;
            }

            .no-sort::after { display: none!important; }

            .no-sort { pointer-events: none!important; cursor: default!important; }

            .swal2-show{
                font-size: 17px;
            }

        </style>

        @endsection

        @section('scripts')

            <script type="text/javascript">

                var table = $('#example1').DataTable(
                    {
                        responsive: false,
                        "fnDrawCallback": function(settings, json) {
                            $('#example1 > tbody  > tr').each(function(index, tr) {
                                $(this).children().first('td').find('.services-checkboxes').val(index);
                            });
                            $('.mainTable').editableTableWidget();
                            $('.mainTable td').on('change', function(evt, newValue) {

                                var type = $(this).data('type');
                                var parent = $(this).parent();

                                if(type == 'rate')
                                {
                                    parent.find('.product_rate').val(newValue);

                                    var rate = newValue.replace(/\,/g, '.');
                                    var vat = (100 + 21)/100;

                                    var sell_rate = rate * vat;
                                    sell_rate = parseFloat(sell_rate).toFixed(2);

                                    if(sell_rate != 'NaN')
                                    {
                                        parent.find('.product_rate').val(rate);
                                        parent.find('.product_sell_rate').val(sell_rate);
                                        parent.find('td[data-type="sell_rate"]').text(sell_rate.replace(/\./g, ','));
                                    }
                                    else
                                    {
                                        parent.find('.product_rate').val('');
                                        parent.find('.product_sell_rate').val('');
                                        parent.find('td[data-type="sell_rate"]').text('');
                                    }
                                }
                                else if(type == 'sell_rate')
                                {
                                    parent.find('.product_sell_rate').val(newValue);

                                    var sell_rate = newValue.replace(/\,/g, '.');
                                    var vat = (100 + 21)/100;

                                    var rate = sell_rate / vat;
                                    rate = parseFloat(rate).toFixed(2);

                                    if(rate != 'NaN')
                                    {
                                        parent.find('.product_rate').val(rate);
                                        parent.find('.product_sell_rate').val(sell_rate);
                                        parent.find('td[data-type="rate"]').text(rate.replace(/\./g, ','));
                                    }
                                    else
                                    {
                                        parent.find('.product_rate').val('');
                                        parent.find('.product_sell_rate').val('');
                                        parent.find('td[data-type="rate"]').text('');
                                    }
                                }
                                else
                                {
                                    parent.find('.model_number').val(newValue);
                                }

                                table.rows().invalidate();
                            });
                        },
                        columnDefs: [ { "orderable": false, "targets": [0] } ],
                        order: [[1, 'desc']],
                        "oLanguage": {
                            "sLengthMenu": "<?php echo __('text.Show') . ' _MENU_ ' . __('text.records'); ?>",
                            "sSearch": "<?php echo __('text.Search') . ':' ?>",
                            "sInfo": "<?php echo __('text.Showing') . ' _START_ ' . __('text.to') . ' _END_ ' . __('text.of') . ' _TOTAL_ ' . __('text.items'); ?>",
                            "oPaginate": {
                                "sPrevious": "<?php echo __('text.Previous'); ?>",
                                "sNext": "<?php echo __('text.Next'); ?>"
                            },
                            "sEmptyTable": '<?php echo __('text.No data available in table'); ?>'
                        }
                    }
                );


                $('#example2').DataTable({
                    "oLanguage": {
                        "sLengthMenu": "<?php echo __('text.Show') . ' _MENU_ ' . __('text.records'); ?>",
                        "sSearch": "<?php echo __('text.Search') . ':' ?>",
                        "sInfo": "<?php echo __('text.Showing') . ' _START_ ' . __('text.to') . ' _END_ ' . __('text.of') . ' _TOTAL_ ' . __('text.items'); ?>",
                        "oPaginate": {
                            "sPrevious": "<?php echo __('text.Previous'); ?>",
                            "sNext": "<?php echo __('text.Next'); ?>"
                        },
                        "sEmptyTable": '<?php echo __('text.No data available in table'); ?>'
                    }
                });


                /*$('.mainTable').on('validate', function(evt, newValue) {
                    table.ajax.reload();
                    $('#example1').load(document.URL + ' #example1');
                });*/

                $('.add-newProduct-btn').on('click', function()
                {
                    var checked = table.$('.services-checkboxes:checkbox:checked');
                    var check = 0;

                    if(checked.length > 0)
                    {
                        checked.map(function() {

                            if(!$(this).parent().parent().parent().find('.product_rate').val())
                            {
                                $(this).parent().parent().parent().find('td[data-type="rate"]').css('border','1px solid red');
                                check = 1;
                            }
                            else
                            {
                                $(this).parent().parent().parent().find('td[data-type="rate"]').css('border','');
                            }

                            if(!$(this).parent().parent().parent().find('.product_sell_rate').val())
                            {
                                $(this).parent().parent().parent().find('td[data-type="sell_rate"]').css('border','1px solid red');
                                check = 1;
                            }
                            else
                            {
                                $(this).parent().parent().parent().find('td[data-type="sell_rate"]').css('border','');
                            }

                        });

                        if(check == 1)
                        {
                            Swal.fire({
                                type: 'error',
                                title: '{{__('text.Oops...')}}',
                                text: 'Kindly make sure all selected services rates and sell rates are filled.',

                            })
                        }
                        else
                        {
                            $('form').submit();
                        }
                    }

                });

            </script>

@endsection
