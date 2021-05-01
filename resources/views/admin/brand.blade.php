@extends('layouts.app')

@section('title', trans('Brand - Mera Brand'))

@section('content')


<!-- container -->
    <div class="container m-5">
        <div class="row">
             @include('layouts.admin_dashboard_menu')
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 border-right">
                                <h4>Brands</h4>
                            </div>
                            

                        </div>
                        <hr>
@if(Session::has('message'))
@if( Session::get('messagetype') == 1)
<p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{Session::get('message')}}</p>

@else

<p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{Session::get('message')}}</p>

@endif

@endif

<script type="text/javascript">

    $('.alert').fadeIn().delay(3000).fadeOut();

</script>
                        <div class="row">
                            <div class="col-md-4 bg-light card-body">
                                <h5>Add New Brand</h5>
                                <form enctype="multipart/form-data" role="form" method="POST" action="add_brand">
                                {{ csrf_field() }}
                                    <div class="form-group row">
                                        <label for="text" class="col-12 col-form-label">Name</label>
                                        <div class="col-12">
                                            <input id="text" name="brand" class="form-control here" type="text" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="text" class="col-12 col-form-label">Upload Image</label>
                                        <div class="col-12">
                                            <input id="image" name="image" class="form-control here" type="file" required>
                                        </div>
                                    </div>
                                    
                                   
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <button name="submit" type="submit" class="btn btn-primary btn-sm">Add New Brand</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-8">
                                <table class="table table-hover ">
                                    <thead class="bg-light ">
                                        <tr>
                                            
                                            <th>Brand</th>
                                            <th>Image</th>
                                            <th>Action</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($post as $key)

                                        <tr>
                                           
                                            <td>{{$key->brand}}</td>
                                            <td><a href="{{url('public/brand/')}}/{{$key->image}}" target="_blanck">{{$key->image}}</a></td>
                                            <td>
                                                <a href="edit_brand/{{$key->id}}"><img class="img-fluid" src="{{url('icons/package/build/svg/pencil.svg')}}"></a>
                                                <a href="#"><img class="img-fluid" src="{{url('icons/package/build/svg/trashcan.svg')}}"></a>

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

    <style type="text/css">
        

        .table td, .table th{

            text-align: center;
        }
    </style>

    @endsection