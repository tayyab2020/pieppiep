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
                                        <h2>Services Questions</h2>
                                        <a href="{{route('create-services-question')}}" class="btn add-newProduct-btn"><i class="fa fa-plus"></i> Create New Question</a>
                                    </div>
                                    <hr>
                                    <div>
                                        @include('includes.form-success')

                                        <div class="row">
                                            <div class="col-sm-12">

                                                <table id="example" class="table table-striped table-hover products dt-responsive dataTable no-footer dtr-inline" role="grid" aria-describedby="product-table_wrapper_info" style="width: 100%;" width="100%" cellspacing="0">
                                                    <thead>
                                                    <tr role="row">
                                                        <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 20%;" aria-sort="ascending" aria-label="Blood Group Name: activate to sort column descending">Title</th>
                                                        <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 20%;" aria-sort="ascending" aria-label="Blood Group Name: activate to sort column descending">Placeholder</th>
                                                        <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 20%;" aria-sort="ascending" aria-label="Blood Group Name: activate to sort column descending">Service(s)</th>
                                                        <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" style="width: 50%;" colspan="1" aria-sort="ascending" aria-label="Blood Group Name: activate to sort column descending">Predefined Answer(s)</th>
                                                        <th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" style="width: 50%;" colspan="1" aria-sort="ascending" aria-label="Blood Group Name: activate to sort column descending">Sequence No</th>
                                                        <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" aria-label="Actions: activate to sort column ascending">Actions</th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    @foreach($data as $key)
                                                        <tr role="row" class="odd">
                                                            <td style="padding-left: 10px;">{{$key->title}}</td>

                                                            <td>{{$key->placeholder}}</td>

                                                            <td>
                                                                @foreach($key->services as $x => $service)
                                                                    <b>{{$x+1}}. {{$service->title}}</b>
                                                                    <br>
                                                                @endforeach
                                                            </td>

                                                            <td>
                                                                @foreach($key->answers as $i => $temp)
                                                                    <b>{{$i+1}}. {{$temp->title}}</b>
                                                                    <br>
                                                                @endforeach
                                                            </td>

                                                            <td>{{$key->order_no}}</td>

                                                            <td>
                                                                <a href="{{route('edit-services-question',$key->id)}}" class="btn btn-primary product-btn"><i class="fa fa-edit"></i> Edit</a>
                                                                <a href="{{route('delete-services-question',$key->id)}}" class="btn btn-danger product-btn"><i class="fa fa-trash"></i> Remove</a>
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
