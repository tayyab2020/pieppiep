@extends('layouts.handyman')

@section('styles')

<link href="{{asset('assets/admin/css/jquery-ui.css')}}" rel="stylesheet" type="text/css">

<style type="text/css">
    .colorpicker-alpha {display:none !important;}
    .colorpicker{ min-width:128px !important;}
    .colorpicker-color {display:none !important;}
</style>

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
                                            <h2>Edit Service</h2>
                                            <a href="{{route('admin-cat-index')}}" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> {{__('text.Back')}}</a>
                                        </div>
                                        <hr>
                                        <form class="form-horizontal" action="{{route('admin-cat-update',$cat->id)}}" method="POST" enctype="multipart/form-data">
                                          {{csrf_field()}}
                                          @include('includes.form-error')
                                          @include('includes.form-success')

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_blood_group_display_name"> Name* <span>(In Any Language)</span></label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="cat_name" id="edit_blood_group_display_name" placeholder="Enter Category Name" required="" type="text" value="{{$cat->cat_name}}">
                                            </div>
                                          </div>


                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_blood_group_slug">Slug* <span>(In English)</span></label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="cat_slug" id="edit_blood_group_slug" placeholder="Enter Category Slug" required="" type="text" value="{{$cat->cat_slug}}">
                                            </div>
                                          </div>


                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="service_type">VAT* </label>
                                                <div class="col-sm-6">

                                                    <select class="form-control" name="vat" id="vat" required="" >

                                                        <option value="">Select VAT</option>

                                                        @foreach($vats as $key)

                                                            <option @if($key->id == $cat->vat_id) selected @endif value="{{$key->id}}">{{$key->rule}}</option>

                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="service_description">Service Description*</label>
                                                <div class="col-sm-6">
                                                    <textarea class="form-control" name="description" id="service_description" rows="5" style="resize: vertical;" placeholder="Enter Service Description">{{$cat->description}}</textarea>
                                                </div>
                                            </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="current_photo">Current Photo*</label>
                                            <div class="col-sm-6">
                                              <img width="130px" height="90px" id="adminimg" src="{{ $cat->photo ? asset('assets/images/'.$cat->photo):'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG'}}" alt="" id="adminimg">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="profile_photo">Edit Photo *</label>
                                            <div class="col-sm-6">
                                                <input type="file" id="uploadFile" class="hidden" name="photo" value="">
                                              <button type="button" id="uploadTrigger" onclick="uploadclick()" class="form-control"><i class="fa fa-download"></i> Edit Category Photo</button>
                                              <p>Prefered Size: (600x600) or Square Sized Image</p>
                                            </div>
                                          </div>


                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="service_type">Service Type* </label>
                                                <div class="col-sm-6">

                                                    <select class="form-control" name="service_type" id="service_type" required="" >

                                                        <option value="">Select Service Type</option>

                                                        @foreach($service_types as $key)

                                                            @if($cat->service_type == $key->id)

                                                                <option value="{{$key->id}}" selected>{{$key->type}}</option>

                                                            @else

                                                                <option value="{{$key->id}}">{{$key->type}}</option>

                                                            @endif

                                                        @endforeach

                                                    </select>

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="">Main Service* </label>
                                                <div class="col-sm-3">
                                                    <label class="switch">

                                                        @if($cat->main_service)

                                                            <input type="checkbox" checked disabled onchange="SubService()">

                                                            <span class="slider round" style="cursor: not-allowed;"></span>

                                                            <input type="hidden" name="main_service" value="1">

                                                        @else

                                                            <input type="checkbox" name="main_service" id="main_service" disabled style="cursor: disabled;" onchange="SubService()">

                                                            <span class="slider round" style="cursor: not-allowed;"></span>

                                                            <input type="hidden" name="main_service" value="0">

                                                        @endif

                                                    </label>

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="">Variable Questions* </label>
                                                <div class="col-sm-3">
                                                    <label class="switch">
                                                        <input @if($cat->variable_questions) checked @endif type="checkbox" name="variable_questions" id="variable_questions">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>

                                          @if(!$cat->main_service)

                                          <div class="sub-services s_box" id="q">

                                            @foreach($sub_services as $temp)

                                          <div class="form-group">

                                            <label class="control-label col-sm-4" for="sub_service">Services </label>
                                            <div class="col-sm-3">
                                              <select class="form-control js-data-example-ajax" name="sub_service[]" id="sub_service" required>

                                                <option value="">Select Main Service</option>

                                                @foreach($cats as $key)

                                                @if($temp->cat_id == $key->id)

                                                <option value="{{$key->id}}" selected>{{$key->cat_name}}</option>

                                                @else

                                                <option value="{{$key->id}}">{{$key->cat_name}}</option>

                                                @endif



                                                @endforeach

                                              </select>


                                            </div>


                                          <div class="col-xs-3 col-sm-3" id="s3Type" style="height: 40px;">

                                          <input class="form-control" style="text-align: center;padding-top: 5px;height: 100%;margin-bottom: 0;background-color: transparent;" value="{{$temp->type}}" readonly>



                                          </div>

                                          <input type="hidden" name="s_id[]" value="{{$temp->id}}">

                                          <div class="col-xs-1 col-sm-1">
                                            <span class="ui-close remove-ui" id="{{$temp->id}}" style="margin:0;right:70%;">X</span>
                                          </div>

                                          </div>

                                          @endforeach

                                          </div>

                                          <div class="form-group s_box" style="margin-top: 40px;">

                                                    <label class="control-label col-sm-3" for=""></label>

                                                    <div class="col-sm-12 text-center">

                                                        <button class="btn btn-default featured-btn" type="button" name="add-field-btn" id="add-field-btn"><i class="fa fa-plus"></i> Add More Main Services</button>
                                                    </div>
                                          </div>

                                          @endif


                                            <hr>
                                            <div class="add-product-footer">
                                                <button name="addProduct_btn" type="submit" class="btn add-product_btn">Update Service</button>
                                            </div>
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

  $(document).ready(function() {

var $selects = $('.js-data-example-ajax').change(function() {


                var id = this.value;
                var selector = this;

                if ($selects.find('option[value=' + id + ']:selected').length > 1) {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Service already selected!',

                    })
                    this.options[0].selected = true;

                    $(selector).val('');


                }


if(id)
{

  $.ajax({
                    type:"GET",
                    data: "id=" + id ,
                    url: "<?php echo url('/services')?>",
                    success: function(data) {


                        $(selector).parent().parent().children('#s3Type').children("input").val(data.type);




                    }
                });

}

            });


        });

    $("#add-field-btn").on('click',function() {


            $(".sub-services").append('<div class="form-group">'+
                '<label class="control-label col-sm-4" for="sub_service">Services </label>'+
                '<div class="col-sm-3">'+
                // '<input type="text" class="form-control" name="title[]" id="title" placeholder="'+title+'" required="">'+
                '<select class="form-control js-data-example-ajax" name="sub_service[]" id="sub_service" required>'+
                '<option value="">Select Main Service</option>' +
                '@foreach($cats as $key)' +
                '<option value="{{$key->id}}">{{$key->cat_name}}</option>' +
                '@endforeach' +
                '</select>'+
                '</div>'+
                '<div class="col-xs-3 col-sm-3" id="s3Type" style="height: 40px;">'+
                '<input class="form-control" style="text-align: center;padding-top: 5px;height: 100%;margin-bottom: 0;background-color: transparent;" value="(Main Service) Service Type" readonly>'+
                '</div>'+
                '<input type="hidden" name="s_id[]" value="0">'+
                '<div class="col-xs-1 col-sm-1">'+
                '<span class="ui-close remove-ui1" style="margin:0;right:70%;">X</span></div></div>');

//             $(".js-data-example-ajax").select2({
//                 width: '100%',
//                 // placeholder: "City Name",
//                 placeholder: "Select Sub Service",
//                 allowClear: true,

//             }).on('change', function (e) {
// // AT this section we have to load placeholder and use it to Next textfield
//             });

            var $selects = $('.js-data-example-ajax').change(function() {


                var id = this.value;
                var selector = this;

                if ($selects.find('option[value=' + id + ']:selected').length > 1) {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Service already selected!',

                    })
                    this.options[0].selected = true;

                    $(selector).val('');


                }

if(id)
{

  $.ajax({
                    type:"GET",
                    data: "id=" + id ,
                    url: "<?php echo url('/services')?>",
                    success: function(data) {


                        $(selector).parent().parent().children('#s3Type').children("input").val(data.type);




                    }
                });

}



            });

        });



  $(document).on('click', '.remove-ui1' ,function() {

            var parent = this.parentNode.parentNode;

            $(parent).children().children().children('select').val('');


            $(parent).hide();
            $(parent).remove();



        });

  function isEmpty(el){
            return !$.trim(el.html())
        }

        $(document).on('click', '.remove-ui' ,function() {


            var id = $(this).attr('id');

            var parent = this.parentNode.parentNode;



            $.ajax({
                type:"GET",
                data: "id=" + id ,
                url: "<?php echo url('/aanbieder/delete-subservices')?>",
                success: function(data) {

                    $(parent).children().children().children('select').val('');


                    $(parent).hide();
                    $(parent).remove();


                    Swal.fire(
                        'Success!',
                        'Main Service Deleted Successfully!',
                        'success'
                    )

                    if (isEmpty($('#q'))) {

                        $(".sub-services").append('<div class="form-group">'+
                '<label class="control-label col-sm-4" for="sub_service">Services </label>'+
                '<div class="col-sm-3">'+
                // '<input type="text" class="form-control" name="title[]" id="title" placeholder="'+title+'" required="">'+
                '<select class="form-control js-data-example-ajax" name="sub_service[]" id="sub_service" required>'+
                '<option value="">Select Main Service</option>' +
                '@foreach($cats as $key)' +
                '<option value="{{$key->id}}">{{$key->cat_name}}</option>' +
                '@endforeach' +
                '</select>'+
                '</div>'+
                '<div class="col-xs-3 col-sm-3" id="s3Type" style="height: 40px;">'+
                '<input class="form-control" style="text-align: center;padding-top: 5px;height: 100%;margin-bottom: 0;background-color: transparent;" value="(Main Service) Service Type" readonly>'+
                '</div>'+
                '<input type="hidden" name="s_id[]" value="0">'+
                '<div class="col-xs-1 col-sm-1">'+
                '<span class="ui-close remove-ui1" style="margin:0;right:70%;">X</span></div></div>');



                        $('.js-data-example-ajax').on('change', function() {
                            var id = this.value;
                            var selector = this;


if(id)
{

  $.ajax({
                    type:"GET",
                    data: "id=" + id ,
                    url: "<?php echo url('/services')?>",
                    success: function(data) {


                        $(selector).parent().parent().children('#s3Type').children("input").val(data.type);




                    }
                });

}

                        });
                    }



                }
            });


        });

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

</script>

<style type="text/css">

  .swal2-show
  {
    padding: 40px;
    width: 30%;

  }

  .swal2-header
  {
    font-size: 23px;
  }

  .swal2-content
  {
    font-size: 18px;
  }

  .swal2-actions
  {
    font-size: 16px;
  }

</style>

    <script>
            $('#cp1').colorpicker();
            $('#cp2').colorpicker();
    </script>



<script src="{{asset('assets/admin/js/jquery152.min.js')}}"></script>
<script src="{{asset('assets/admin/js/jqueryui.min.js')}}"></script>

@endsection
