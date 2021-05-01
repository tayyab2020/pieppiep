@extends('layouts.app')

@section('title', trans('Edit Category - Mera Brand'))

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
                                <h5>Edit Category</h5>
                                <form enctype="multipart/form-data" role="form" method="POST" action="{{ URL::to('admin/update_category') }}">
                                {{ csrf_field() }}
                                    <div class="form-group row">
                                        <label for="text" class="col-12 col-form-label">Name</label>
                                        <div class="col-12">
                                          
                                            <input  name="id" class="form-control here" type="hidden"  value="{{$result->id}}">
                                            <input id="text" name="category" class="form-control here" type="text" required value="{{$result->category}}">
                                            <input id="text" name="org_category" class="form-control here" type="hidden" value="{{$result->category}}">
                                            
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="text" class="col-12 col-form-label">Description</label>
                                        <div class="col-12">
                                          
                                            
                                            <input id="description" name="description" class="form-control here" type="text" value="{{$result->description}}">
                                            
                                            
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="text" class="col-12 col-form-label">Update Image</label>
                                        <div class="col-12">
                                            <input id="file-upload" name="image" class="form-control here" type="file" >
                                           
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="text" class="col-12 col-form-label">Existing Image</label>
                                        <div class="col-12">
                                           
                                           <div id="file-upload-filename" class="form-control here" readonly >File name: {{$result->image}}</div>
                                            
                                           
                                        </div>
                                    </div>

                                     

                                    <script type="text/javascript">
                                        
                                        var input = document.getElementById( 'file-upload' );
var infoArea = document.getElementById( 'file-upload-filename' );

input.addEventListener( 'change', showFileName );

function showFileName( event ) {
  
  // the change event gives us the input it occurred in 
  var input = event.srcElement;
  
  // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
  var fileName = input.files[0].name;
  
  // use fileName however fits your app best, i.e. add it into a div
  infoArea.textContent = 'File name: ' + fileName;
}

                                    </script>
                                    
                                   
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <button name="submit" type="submit" class="btn btn-primary btn-sm">Edit Category</button>
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
                                            <th>Action</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($post as $key)

                                        <tr>
                                           
                                            <td>{{$key->category}}</td>
                                            <td><a href="{{url('public/category/')}}/{{$key->image}}" target="_blanck">{{$key->image}}</a></td>
                                            <td>
                                                <a href="../edit_category/{{$key->id}}"><img class="img-fluid" src="{{url('icons/package/build/svg/pencil.svg')}}"></a>
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