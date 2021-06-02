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
                                        <h2>Users Permissions</h2>

                                        {{--<a href="{{route('admin-permission-create')}}" class="btn add-newProduct-btn"><i class="fa fa-plus"></i> Create Permission</a>--}}

                                    </div>
                                    <hr>
                                    <div>
                                        @include('includes.form-success')
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table id="example" class="table table-striped table-hover products dt-responsive dataTable no-footer dtr-inline" role="grid" aria-describedby="product-table_wrapper_info" style="width: 100%;" width="100%" cellspacing="0">
                                                    <thead>
                                                    <tr role="row">

                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending">ID</th>
                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending">User Name</th>
                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending">User Email</th>
                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending">User Role</th>
                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending">Permission(s)</th>
                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 240px;" aria-label="Actions: activate to sort column ascending">Actions</th>

                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    <?php $x = 0; ?>

                                                    @foreach($users as $user)
                                                        <tr role="row" class="odd">

                                                            <td>{{$user->id}}</td>

                                                            <td>{{$user->name . ' ' . $user->family_name}}</td>

                                                            <td>{{$user->email}}</td>

                                                            <td>{{$user->role_id == 2 ? 'Retailer' : 'Supplier'}}</td>

                                                            <td>

                                                                @if(count($user->permissions) > 0)

                                                                    <select style="width: 100%;padding: 10px 5px;outline: none;border:1px solid #cecece;">

                                                                        @foreach($user->permissions as $key)

                                                                            <option value="{{$key->id}}">{{$key->name}}</option>

                                                                        @endforeach

                                                                    </select>

                                                                @endif

                                                            </td>

                                                            <td>
                                                                <a href="{{route('admin-assign-permission-edit',$user->id)}}" class="btn btn-primary product-btn"><i class="fa fa-edit"></i> Edit</a>
                                                            </td>
                                                        </tr>

                                                        <?php $x++; ?>

                                                    @endforeach
                                                    </tbody>
                                                </table></div></div>
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
        $('#example').DataTable({
            order: [[0, 'desc']],
        });
    </script>

@endsection
