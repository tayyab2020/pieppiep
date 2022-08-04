@extends('layouts.admin')

@section('styles')

<link href="{{asset('assets/admin/css/jquery.tagit.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('assets/admin/css/jquery-ui.css')}}" rel="stylesheet" type="text/css">

@endsection

@section('content')

<div class="right-side">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <!-- Starting of Dashboard area -->
                        <div class="section-padding add-product-1">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="add-product-box">
                                        <div class="add-product-header">
                                            <h2>Handyman Insurance</h2>
                                            <a href="{{route('admin-user-index')}}" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> {{__('text.Back')}}</a>  
                                        </div>
                                        <hr>
                                        <form class="form-horizontal" action="{{route('admin-user-insurance-update',$user->id)}}" method="POST" enctype="multipart/form-data">
                                          @include('includes.form-error')
                                          @include('includes.form-success')
                                          {{csrf_field()}}
                                           <div class="profile-filup-description-box margin-bottom-30">
                                               

                                                <div class="form-group" >

                                                  



<div class="col-xs-10 col-sm-5 col-md-offset-1" style="width: 100%;padding: 0;margin: 0;margin-top: 30px;">

<input type="hidden" name="handyman_id" placeholder="id" readonly value="{{$user->id}}" >



 </div>

                                 </div>



                                            </div>

                                            

                                            <?php if($user->insurance == 0){ ?>

                                            <?php if($user->insurance_pod == null){ ?>

                                            <p style="font-size: 20px;font-weight: bold;text-align: center;">Insurance POD is not uploaded by this handyman.</p>

                                            <?php }else{  ?>

                                            <div style="border:1px solid #dadada;margin-bottom: 30px;">

    <a href="{{ asset('assets/InsurancePod/'). '/'.$user->insurance_pod }}" target="_blank">

<img style="width: 30%;height: 300px;margin: auto;display: block;" src="{{ asset('assets/InsurancePod/'). '/'.$user->insurance_pod }}" id="profile-img-tag" width="200px" height="300px"/></a></div>

  <div class="row">
                                                    <div class="col-md-8 col-md-offset-2">
                                                        <div class="form-group text-center">
                                                            <button class="btn btn-success" type="submit"  style="font-size: 20px;">Approve</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php } ?>



<?php }else{ ?>


<p style="font-size: 23px;color: green;text-align: center;font-weight: bold;padding-bottom: 50px;">This handyman insurance has been approved!</p>

<div style="border:1px solid #dadada;margin-bottom: 30px;">

    <a href="{{ asset('assets/InsurancePod/'). '/'.$user->insurance_pod }}" target="_blank">

<img style="width: 30%;height: 300px;margin: auto;display: block;" src="{{ asset('assets/InsurancePod/'). '/'.$user->insurance_pod }}" id="profile-img-tag" width="200px" height="300px"/></a></div>


<?php } ?>

                                        </form>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <!-- Ending of Dashboard area --> 
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

<script type="text/javascript" src="{{asset('assets/admin/js/nicEdit.js')}}"></script> 
<script type="text/javascript">
//<![CDATA[
        bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
  //]]>
</script>

<script type="text/javascript">
  
  function uploadclick(){
    $("#uploadFile").click();
    $("#uploadFile").change(function(event) {
          readURL(this);
        $("#uploadTrigger").html($("#uploadFile").val());
    });

}


    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#adminimg').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#add-field-btn").on('click',function() {
      var title = $('#tttl').val();
      var desc = $('#dddc').val();

        $(".qualification").append('<div class="qualification-area">'+
                '<div class="form-group">'+
                 '<div class="col-sm-5 col-md-offset-1">'+
'<input type="text" class="form-control" name="title[]" id="title" placeholder="'+title+'" required="">'+
                   '</div>'+
                   '<div class="col-sm-5">'+
'<input type="text" class="form-control" name="details[]" id="text_details" placeholder="'+desc+'" required="">'+
                  '</div>'+
                  '</div>'+
                  '<span class="ui-close">X</span>'+
                 '</div>');

    });

  function isEmpty(el){
      return !$.trim(el.html())
  }


  $(document).on('click', '.ui-close' ,function() {
    $(this.parentNode).hide();
    $(this.parentNode).remove();
    if (isEmpty($('#q'))) {
      var title = $('#tttl').val();
      var desc = $('#dddc').val();
        $(".qualification").append('<div class="qualification-area">'+
                '<div class="form-group">'+
                 '<div class="col-sm-5 col-md-offset-1">'+
'<input type="text" class="form-control" name="title[]" id="title" placeholder="'+title+'">'+
                   '</div>'+
                   '<div class="col-sm-5">'+
'<input type="text" class="form-control" name="details[]" id="text_details" placeholder="'+desc+'">'+
                  '</div>'+
                  '</div>'+
                  '<span class="ui-close">X</span>'+
                 '</div>');
    }
  });



</script>

<script src="{{asset('assets/admin/js/jquery152.min.js')}}"></script>
<script src="{{asset('assets/admin/js/jqueryui.min.js')}}"></script>    
<script src="{{asset('assets/admin/js/tag-it.js')}}" type="text/javascript" charset="utf-8"></script>



<script type="text/javascript">
    $(document).ready(function() {
        $("#myTags").tagit({
          fieldName: "special[]",
          allowSpaces: true 
        });
    });
</script>

@endsection