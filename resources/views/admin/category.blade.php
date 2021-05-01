@extends('layouts.app')

@section('title', trans('Category - Mera Brand'))

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
                                <h4>Categories</h4>
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
                                <h5>Add New Category</h5>
                                <form enctype="multipart/form-data" role="form" method="POST" action="{{ URL::to('admin/add_category') }}">
                                {{ csrf_field() }}
                                    <div class="form-group row">
                                        <label for="text" class="col-12 col-form-label">Name</label>
                                        <div class="col-12">
                                            <input id="text" name="category" class="form-control here" type="text" required>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="text"  class="col-12 col-form-label">Description</label>
                                        <div class="col-12">
                                            <input id="description" name="description" class="form-control here" type="text" >
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
                                            <button name="submit" type="submit" class="btn btn-primary btn-sm">Add New Category</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-8">
                                <table class="table table-hover ">
                                    <thead class="bg-light ">
                                        <tr>
                                            
                                            <th>Category</th>
                                            <th>Image</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($post as $key)

                                        <tr>
                                           
                                            <td>{{$key->category}}</td>
                                            <td><a href="{{url('public/category/')}}/{{$key->image}}" target="_blanck">{{$key->image}}</a></td>
                                            <td>{{$key->description}}</td>
                                            <td>
                                                <a href="edit_category/{{$key->id}}"><img class="img-fluid" src="{{url('icons/package/build/svg/pencil.svg')}}"></a>
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