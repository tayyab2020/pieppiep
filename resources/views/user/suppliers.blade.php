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
                                        <h2>Suppliers</h2>
                                    </div>
                                    <hr>
                                    <div>
                                        @include('includes.form-success')
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table id="example" class="table table-striped table-hover products dt-responsive dataTable no-footer dtr-inline" role="grid" aria-describedby="product-table_wrapper_info" style="width: 100%;" width="100%" cellspacing="0">
                                                    <thead>
                                                    <tr role="row">

                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending">Supplier ID</th>
                                                        <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 239px;" aria-sort="ascending" aria-label="Donor's Photo: activate to sort column descending">Supplier's Photo</th>
                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending">Supplier's Company Name</th>
                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending">Email</th>
                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 134px;" aria-label="Blood Group: activate to sort column ascending">Status</th>
                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 95px;" aria-label="City: activate to sort column ascending">Products</th>
                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 240px;" aria-label="Actions: activate to sort column ascending">Actions</th>

                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    <?php $x = 0; ?>

                                                    @foreach($users as $user)
                                                        <tr role="row" class="odd">

                                                            <td>{{$user->id}}</td>

                                                            <td tabindex="0" class="sorting_1"><img src="{{ $user->photo ? asset('assets/images/'.$user->photo) : asset('assets/default.jpg')}}" alt="User's Photo" style="height: 180px; width: 200px;"></td>
                                                            <td>{{$user->company_name}}</td>

                                                            <td>{{$user->email}}</td>

                                                            <td>

                                                                @if($user->status != 1)

                                                                    <button class="btn btn-info">Not Requested</button>

                                                                @else

                                                                    @if($user->active != 1)

                                                                        <button class="btn btn-warning">Suspended</button>

                                                                    @else

                                                                        <button class="btn btn-success">Active</button>

                                                                    @endif

                                                                @endif

                                                            </td>

                                                            <td>

                                                                @if(count($products[$x]) > 0)

                                                                    <select style="padding: 10px;">

                                                                        @foreach($products[$x] as $product)

                                                                            <option value="{{$product->title}}">{{$product->title}}</option>

                                                                        @endforeach

                                                                    </select>

                                                                @endif

                                                            </td>


                                                            <td>

                                                                @if($user->status != 1)

                                                                    <button data-id="{{$user->id}}" class="btn btn-success product-btn send-request"><i class="fa fa-check"></i> Send Request</button>

                                                                @endif


                                                                @if(auth()->user()->can('supplier-details'))

                                                                        @if($user->active)

                                                                            <a href="{{route('supplier-details',$user->id)}}" class="btn btn-primary product-btn" style="background-color: #1a969c;margin: 5px !important;"><i class="fa fa-user" ></i> Details</a>

                                                                        @endif

                                                                @endif

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

    <div class="modal fade" id="myModal" role="dialog" style="background-color: #0000008c;">
        <div class="modal-dialog" style="margin-top: 130px;width: 75%;">

            <form action="{{route('send-request-supplier')}}" method="POST" id="request_form">

                {{csrf_field()}}
                <input name="supplier_id" id="supplier_id" type="hidden">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body" style="display: inline-block;width: 100%;">

                        <div style="text-align: center;font-size: 18px;margin: 20px;">

                            <div style="width: 100%;">

                                <h3 style="text-align: center;width: 95%;margin: auto;margin-bottom: 15px;">If you approve this action than you will agree to share your details with this supplier!</h3>

                            </div>

                        </div>

                        <div style="border: 0;text-align: center;" class="modal-footer">
                            <button style="padding: 10px 30px;font-size: 20px;" type="submit" class="btn btn-success">Approve</button>
                        </div>
                    </div>

                </div>

            </form>

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

        $('.send-request').click(function(){

            var id = $(this).data('id');

            $('#supplier_id').val(id);

            $('#myModal').modal('toggle');

        });

        $('#example').DataTable({
            order: [[0, 'desc']],
            "aoColumns": [
                { "sWidth": "" }, // 1st column width
                { "sWidth": "200px" }, // 2nd column width
                { "sWidth": "" },
                { "sWidth": "" },
                { "sWidth": "" },
                { "sWidth": "100px" },
                { "sWidth": "" },

            ]
        });
    </script>

@endsection