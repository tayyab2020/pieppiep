@extends('layouts.app')

@section('title', trans('User Management - Mera Brand'))

@section('content')


<!-- container -->
    <div class="container m-5" style="min-width: 90%;">
        <div class="row">
           @include('layouts.admin_dashboard_menu')



        <div class="col-md-9">

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


                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 border-right">
                                <h4>Users</h4>
                            </div>
                            


                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-hover " style="border-bottom: 1px solid #dee2e6;">
                                    <thead class="bg-light ">
                                        <tr>
                                           
                                            <th style="width: 20%">Image</th>
                                            <th>Name</th>
                                            <th>email</th>
                                            <th>phone</th>
                                            <th>Address</th>
                                            <th>Role</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($post as $temp)
                                        <tr>
                                            <td><img src="{{url('public/user_image')}}/{{ $temp->avatar }}" style="height: 20%;width: 100%;"></td>
                                            <td><small>{{$temp->first_name}} {{$temp->last_name}}</small></a></td>
                                            <td><small>{{$temp->email}}</small></td>
                                            <td><small>{{$temp->phone}}</small></td>
                                            <td><small>{{$temp->address}}</small></td>

                                            @if( $temp->user_role == 2)

                                            <td><small>Customer</small></td>

                                            @else

                                            <td><small>Vendor</small></td>

                                            @endif

                                            
                                            <td>
                                                <form enctype="multipart/form-data" role="form" method="POST" action="{{ URL::to('admin/block-unblock-user') }}">
                                                    {{ csrf_field() }} 
                                                <input type="hidden" name="user_id" value="{{$temp->id}}">
                                                
                                                
                                                    @if( $temp->block == 0 )

                                                <input type="hidden" name="block" value="1">
                                                <button type="submit" >Block</button>

                                                @else

                                                <input type="hidden" name="block" value="0">                                                
                                                <button type="submit" >Unblock</button>

                                                @endif
                                                </form>
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
            border-left: 1px solid #dee2e6;
            border-right: 1px solid #dee2e6;
        }
    </style>

    @endsection