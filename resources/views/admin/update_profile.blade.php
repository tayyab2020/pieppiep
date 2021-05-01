@extends('layouts.app')

@section('title', trans('Update Profile - Mera Brand'))

@section('content')


   <!-- container -->
    <div class="container m-5" style="max-width: 95%;">
        <div class="row">
 @include('layouts.admin_dashboard_menu')
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Your Profile</h4>
                                <hr>
                            </div>
                        </div>

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
                            <div class="col-md-12">
                                <form method="post" action="{{ URL::to('admin/update-profile-admin-account') }}">
                                  {{ csrf_field() }}

                                  <input type="hidden" name="id" value="{{$user->id}}">
                                    <div class="form-group row">
                                        <label for="username" class="col-4 col-form-label">User Name*</label>
                                        <div class="col-8">
                                            <input id="username" name="username" placeholder="Username" class="form-control here" required type="text" value="{{$user->first_name}} {{$user->last_name}}" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="name" class="col-4 col-form-label">First Name</label>
                                        <div class="col-8">
                                            <input id="firstname" name="firstname" placeholder="First Name" class="form-control here" type="text" required value="{{$user->first_name}}" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="lastname" class="col-4 col-form-label">Last Name</label>
                                        <div class="col-8">
                                            <input id="lastname" name="lastname" placeholder="Last Name" class="form-control here" type="text" required value="{{$user->last_name}}">
                                        </div>
                                    </div>
                                   
                                    <div class="form-group row">
                                        <label for="select" class="col-4 col-form-label">Role</label>
                                        <div class="col-8">



                                           <input id="text" name="role" id="role" placeholder="Role" class="form-control here" required type="text" value="Admin" readonly>

                                          
                                            
                                        </div>
                                        
                                    </div>
                                    <div class="form-group row">
                                        <label for="email" class="col-4 col-form-label">Email*</label>
                                        <div class="col-8">
                                            <input id="email" name="email" placeholder="Email" class="form-control here" required type="text" value="{{$user->email}}" readonly>
                                        </div>
                                    </div>

                                    

                                    <div class="form-group row">
                                        <label for="website" class="col-4 col-form-label">Phone*</label>
                                        <div class="col-8">
                                            <input id="phone" name="phone" placeholder="Phone No" class="form-control here" type="text" required value="{{$user->phone}}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="website" class="col-4 col-form-label">Address*</label>
                                        <div class="col-8">
                                            <input id="address" name="address" placeholder="City" class="form-control here" type="text" required value="{{$user->address}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="website" class="col-4 col-form-label">City*</label>
                                        <div class="col-8">
                                            <input id="city" name="city" placeholder="City" class="form-control here" type="text" required value="{{$user->city}}">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="publicinfo" class="col-4 col-form-label">Description</label>
                                        <div class="col-8">
                                            <textarea id="publicinfo" name="publicinfo" cols="40" rows="4" class="form-control" style="resize:none;">{{$user->description}}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="newpass" class="col-4 col-form-label">New Password</label>
                                        <div class="col-8">
                                            <input id="newpass" name="newpass" placeholder="New Password" class="form-control here" type="password">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="offset-4 col-8">
                                            <button name="submit" type="submit" class="btn btn-primary">Update My Profile</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection