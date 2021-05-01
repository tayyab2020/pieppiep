@extends('layouts.app')

@section('title', trans('Admin Dasboard - Mera Brand'))

@section('content')


   <!-- Container -->
    <div class="container profile">
       <form method="post"  id="upload_form" enctype="multipart/form-data">


            <div class="row" style="margin-bottom: 20px;">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img src="{{url('public/user_image')}}/{{ $user->avatar }}" id="image_src" alt="" />
                        
                        <input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">
                        <input type="hidden" name="image_name" id="image_name" value="{{$user->avatar}}">

                        <div class="file btn btn-lg btn-primary" style="margin-top: -19%;">
                            Change Photo
                            <input type="file" id="file" name="file" style="width: 100%;height: 100%;" onchange="updateImage()" />
                        </div>
                    </div>
                </div>

                <div id="snackbar"></div>
                       

                        <style>
#snackbar {
  visibility: hidden;
  min-width: 250px;
  margin-left: -125px;
  background-color: #333;
  color: #fff;
  text-align: center;
  border-radius: 2px;
  padding: 16px;
  position: fixed;
  z-index: 1;
  left: 50%;
  bottom: 30px;
  font-size: 17px;
}

#snackbar.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 1.5s, fadeout 1s 2.5s;
}

@-webkit-keyframes fadein {
  from {bottom: 0; opacity: 0;} 
  to {bottom: 30px; opacity: 1;}
}

@keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {bottom: 30px; opacity: 1;} 
  to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
  from {bottom: 30px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}
</style>

                <script type="text/javascript">
                    
                    function updateImage() {

            var form_data = new FormData();
            var token = $('#token').val();
            
        form_data.append('file', $('#file')[0].files[0]);
        form_data.append('user', $('#user_id').val());
        form_data.append('name', $('#image_name').val());

   $.ajax({

     headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
   url: "<?php echo url('admin/update_admin_image') ?>",
   method:"POST",
   data:form_data,
   dataType:'JSON',
   contentType: false,
   cache: false,
   processData: false,
   success:function(data)
   {

    $('#snackbar').html(data.message);
    $('#image_name').val(data.filename);
     $("#image_src").attr('src', '../public/user_image/' + data.filename);
     $("#user_image").attr('src', '../public/user_image/' + data.filename);

     var x = document.getElementById("snackbar");
  x.className = "show";
  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);

   }
  });
}

                </script>

                <div class="col-md-6">
                    <div class="profile-head">
                        <h5>
                            {{$user->first_name}} {{$user->last_name}}
                        </h5>
                        <h6 style="text-transform: uppercase;">
                            {{$user->gender}}
                        </h6>

                        

                        <ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top: 40px;">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                            </li>
                            <li class="nav-item">

                            

                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Contact Details</a>

                                
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2">
                <a href="{{ URL::to('admin/update-profile-admin') }}" class="profile-edit-btn" style="background-color: buttonface;color: #6c757d;padding: 6%;text-decoration: none;">Edit Profile</a>
                </div>
            </div>


            <div class="row">

                

@include('layouts.admin_dashboard_menu')

  
                
                <div class="col-md-8">
                    <div class="tab-content profile-tab" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            
                          

                            <div class="row">
                                <div class="col-md-6">
                                    <label>First Name</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{$user->first_name}}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label>Last Name</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{$user->last_name}}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label>Email</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{$user->email}}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label>Gender</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{$user->gender}}</p>
                                </div>
                            </div>

                            

                           
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">



                             <div class="row">
                                <div class="col-md-6">
                                    <label>Phone</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{$user->phone}}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label>Address</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{$user->address}}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label>City</label>
                                </div>
                                <div class="col-md-6">
                                    <p>{{$user->city}}</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <label>Your Bio</label><br/>
                                    <p>{{$user->description}}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
              
        </form>
    </div>

    @endsection