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

                                        <h2>@if(Route::currentRouteName() == 'admin-user-index') Retailers @else Suppliers @endif</h2>

                                        @if(Route::currentRouteName() == 'admin-user-index')

                                            <a href="{{route('admin-user-create')}}" class="btn add-newProduct-btn"><i class="fa fa-plus"></i> Add Retailer</a>

                                        @else

                                            <div>

                                                <button style="border-radius: 20px;" type="button" class="btn btn-success submit-suppliers"><i class="fa fa-save"></i> Submit</button>
                                                <input style="display: none;" type="checkbox" id="selectCheck">
                                                <label style="border-radius: 20px;" class="btn btn-success select-all" for="selectCheck">Select All</label>

                                                <a href="{{route('admin-supplier-create')}}" class="btn add-newProduct-btn"><i class="fa fa-plus"></i> Add Supplier</a>

                                            </div>

                                        @endif

                                    </div>
                                    <hr>

                                    <div>

                                        @include('includes.form-success')

                                        @if(Route::currentRouteName() == 'admin-supplier-index')

                                            <form id="supplier-form" method="POST" action="{{route('admin-supplier-manage-post')}}">
                                                <input type="hidden" name="_token" value="{{@csrf_token()}}">

                                        @endif

                                        <div class="row">

                                            <div class="col-sm-12">

                                                <table id="example" class="table table-striped table-hover products dt-responsive dataTable no-footer dtr-inline" role="grid" aria-describedby="product-table_wrapper_info" style="width: 100%;" width="100%" cellspacing="0">

                                                    <thead>
                                                    <tr role="row">

                                                        @if(Route::currentRouteName() == 'admin-user-index')

                                                            <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending">Retailer ID</th>
                                                            <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 239px;" aria-sort="ascending" aria-label="Donor's Photo: activate to sort column descending">Retailer's Photo</th><th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending">Retailer's Company Name</th><th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending">Email</th>
                                                            <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending">Rating</th>
                                                            <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 95px;" aria-label="City: activate to sort column ascending">Registration Fee</th><th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 95px;" aria-label="City: activate to sort column ascending">Suppliers</th><th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 240px;" aria-label="Actions: activate to sort column ascending">Actions</th>

                                                        @else

                                                            <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending">Supplier ID</th>
                                                            <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 239px;" aria-sort="ascending" aria-label="Donor's Photo: activate to sort column descending">Supplier's Photo</th><th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending">Supplier's Company Name</th><th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending">Email</th>
                                                            <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending">Rating</th>
                                                            <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 95px;" aria-label="City: activate to sort column ascending">Registration Fee</th><th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 95px;" aria-label="City: activate to sort column ascending">Products</th><th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 240px;" aria-label="Actions: activate to sort column ascending">Actions</th>

                                                        @endif

                                                    </tr>
                                                    </thead>

                                                    <tbody>

                                                            <?php $x = 0; ?>

                                                            @foreach($users as $user)

                                                                <tr role="row" class="odd">

                                                                    @if(Route::currentRouteName() == 'admin-supplier-index')

                                                                        <td>
                                                                            <div style="display: flex;align-items: center;justify-content: center;" class="custom-control custom-checkbox mb-3">
                                                                                <input style="margin: 0;" {{$user->supplier_account_show == 1 ? 'checked' : null}} type="checkbox" class="custom-control-input" id="customCheck{{$user->id}}">
                                                                                <input class="supplier_id" type="hidden" value="{{$user->id}}" name="suppliers[]">
                                                                                <input class="supplier_account_show" type="hidden" value="{{$user->supplier_account_show}}" name="supplier_account_show[]">
                                                                                <label style="margin: 0 0 0 5px;" class="custom-control-label" for="customCheck{{$user->id}}">{{$user->id}}</label>
                                                                            </div>
                                                                        </td>

                                                                    @else

                                                                        <td>{{$user->id}}</td>

                                                                    @endif

                                                                    <td tabindex="0" class="sorting_1"><img src="{{ $user->photo ? asset('assets/images/'.$user->photo) : 'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG'}}" alt="User's Photo" style="height: 180px; width: 200px;"></td>
                                                                    <td>{{$user->company_name}}</td>

                                                                    <td>{{$user->email}}</td>

                                                                    <td>
                                                                        {{$user->rating}} <span class="fa fa-star checked" style="margin-left: 5px;"></span>
                                                                    </td>

                                                                    <td>@if($user->featured)
                                                                            Paid
                                                                        @else
                                                                            Pending
                                                                        @endif</td>

                                                                    @if(Route::currentRouteName() == 'admin-user-index')

                                                                        <td></td>

                                                                    @else

                                                                        <td>

                                                                            @if(count($products[$x]) > 0)

                                                                                <select>

                                                                                    @foreach($products[$x] as $product)

                                                                                        <option value="{{$product->title}}">{{$product->title}}</option>

                                                                                    @endforeach

                                                                                </select>

                                                                            @endif

                                                                        </td>

                                                                    @endif


                                                                    <td>
                                                                        @if($user->active == 1)

                                                                            <a href="{{route('admin-user-st',['id1'=>$user->id,'id2'=>0])}}" class="btn btn-warning product-btn"><i class="fa fa-times"></i> Deactive</a>

                                                                        @else

                                                                            <a href="{{route('admin-user-st',['id1'=>$user->id,'id2'=>1])}}" class="btn btn-success product-btn"><i class="fa fa-check"></i> Active</a>

                                                                        @endif

                                                                        <a href="{{Route::currentRouteName() == 'admin-user-index' ? route('admin-user-edit',$user->id) : route('admin-supplier-edit',$user->id)}}" class="btn btn-primary product-btn"><i class="fa fa-edit"></i> Edit</a>
                                                                        <a href="{{route('admin-user-delete',$user->id)}}" class="btn btn-danger product-btn"><i class="fa fa-trash"></i> Remove</a>
                                                                        <a href="{{route('admin-user-insurance',$user->id)}}" class="btn btn-primary product-btn" style="background-color: black;"><i class="fa fa-clipboard" ></i> Insurance</a>
                                                                        <a href="{{Route::currentRouteName() == 'admin-user-index' ? route('admin-user-details',$user->id) : route('admin-supplier-details',$user->id)}}" class="btn btn-primary product-btn" style="background-color: #1a969c;"><i class="fa fa-user" ></i> Details</a>

                                                                    </td>
                                                                </tr>

                                                                <?php $x++; ?>

                                                            @endforeach

                                                    </tbody>

                                                </table>

                                            </div>

                                        </div>

                                        @if(Route::currentRouteName() == 'admin-supplier-index')

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

    <style type="text/css">

        .product-btn
        {
            margin: 5px;
        }

        .checked {
            color: orange !important;
        }

        .table.products > tbody > tr > td
        {
            text-align: center;
        }

        .table>caption+thead>tr:first-child>td, .table>caption+thead>tr:first-child>th, .table>colgroup+thead>tr:first-child>td, .table>colgroup+thead>tr:first-child>th, .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th
        {
            text-align: center;
        }

    </style>

@endsection

@section('scripts')

<script type="text/javascript">

    $(".submit-suppliers").click(function(){

        $('#supplier-form').submit();

    });

    $(".select-all").click(function(){

        var check = $('.custom-control-input:checked').length > 0 ? true : false;

        $('.custom-control-input').prop('checked', !check);
        $('.supplier_account_show').val(check ? 0 : 1);
    });

    $(".custom-control-input").change(function(){

        var check = $(this).is(":checked");

        $(this).parent().find('.supplier_account_show').val(check ? 1 : 0);

    });

    $('#example').DataTable({
        order: [[0, 'desc']],
        "aoColumns": [
            { "sWidth": "" }, // 1st column width
            { "sWidth": "200px" }, // 2nd column width
            { "sWidth": "" }, // 3rd column width and so on
            { "sWidth": "" },
            { "sWidth": "" },
            { "sWidth": "" },
            { "sWidth": "100px" },
            { "sWidth": "" },

        ]
    });
</script>

@endsection
