@extends('layouts.admin')

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
                                            <h2>{{isset($cats) ? 'Edit Service' : 'Add Service'}}</h2>
                                            <a href="{{route('admin-service-index')}}" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> Back</a>
                                        </div>
                                        <hr>
                                        <form class="form-horizontal" action="{{route('admin-service-store')}}" method="POST" enctype="multipart/form-data">

                                            @include('includes.form-error')
                                            @include('includes.form-success')

                                            {{csrf_field()}}

                                            <input type="hidden" name="service_id" value="{{isset($cats) ? $cats->id : null}}" />

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">Category</label>
                                                <div class="col-sm-6">
                                                    <select class="js-data-example-ajax8 form-control" style="height: 40px;" name="category_id" id="blood_grp">

                                                        <option value="">Select Category</option>

                                                        @foreach($categories as $key)
                                                            <option @if(isset($cats)) @if($cats->category_id == $key->id) selected @endif @endif value="{{$key->id}}">{{$key->cat_name}}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">Sub Category</label>
                                                <div class="col-sm-6">
                                                    <select class="js-data-example-ajax9 form-control" style="height: 40px;" name="sub_category_id" id="blood_grp">

                                                        <option value="">Select Sub Category</option>

                                                        @if(isset($sub_categories))

                                                            @foreach($sub_categories as $sub_cat)

                                                                <option @if(isset($cats)) @if($cats->sub_category_id == $sub_cat->id) selected @endif @endif value="{{$sub_cat->id}}">{{$sub_cat->cat_name}}</option>

                                                            @endforeach

                                                        @endif

                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_display_name">Title*</label>
                                                <div class="col-sm-6">
                                                    <input value="{{isset($cats) ? $cats->title : null}}" class="form-control" name="title" id="blood_group_display_name" placeholder="Enter Service title" required="" type="text">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">Slug*</label>
                                                <div class="col-sm-6">
                                                    <input value="{{isset($cats) ? $cats->slug : null}}" class="form-control" name="slug" id="blood_group_slug" placeholder="Enter Service Slug" required="" type="text">
                                                </div>
                                            </div>

                                        <!-- <div class="form-group">
                                              <label class="control-label col-sm-4" for="blood_group_slug">Estimated Prices</label>
                                              <div class="col-sm-6">
                                                  <input value="{{isset($cats) ? $cats->estimated_prices : null}}" class="form-control" name="estimated_prices" id="blood_group_slug" placeholder="Enter Estimated Prices" type="text">
                                              </div>
                                          </div> -->

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">Measure</label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" id="measure" name="measure">
                                                        <option {{isset($cats) && $cats->measure == 'M1' ? 'selected' : null}} value="M1">M1</option>
                                                        <option {{isset($cats) && $cats->measure == 'M2' ? 'selected' : null}} value="M2">M2</option>
                                                        <option {{isset($cats) && $cats->measure == 'Custom Sized' ? 'selected' : null}} value="Custom Sized">Custom Sized</option>
                                                        <option {{isset($cats) && $cats->measure == 'Per Piece' ? 'selected' : null}} value="Per Piece">Per Piece</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="service_description">Service Description*</label>
                                                <div class="col-sm-6">
                                                    <textarea class="form-control" name="description" id="service_description" rows="5" style="resize: vertical;" placeholder="Enter Service Description">{{isset($cats) ? $cats->description : null}}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="current_photo">Current Photo*</label>
                                                <div class="col-sm-6">
                                                    <img width="130px" height="90px" id="adminimg" src="{{isset($cats->photo) ? asset('assets/images/'.$cats->photo):'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG'}}" alt="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="profile_photo">Add Photo</label>
                                                <div class="col-sm-6">
                                                    <input type="file" id="uploadFile" class="hidden" name="photo" value="">
                                                    <button type="button" id="uploadTrigger" onclick="uploadclick()" class="form-control"><i class="fa fa-download"></i> Add Service Photo</button>
                                                    <p>Prefered Size: (600x600) or Square Sized Image</p>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="add-product-footer">
                                                <button name="addProduct_btn" type="submit" class="btn add-product_btn">{{isset($cats) ? 'Edit Service' : 'Add Service'}}</button>
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

        $(".js-data-example-ajax8").select2({
            width: '100%',
            height: '200px',
            placeholder: "Select Category",
            allowClear: true,
        });

        $(".js-data-example-ajax9").select2({
            width: '100%',
            height: '200px',
            placeholder: "Select Sub Category",
            allowClear: true,
        });

        $('body').on('change', '.js-data-example-ajax8' ,function(){

            var id = $(this).val();
            var options = '';

            $.ajax({
                type:"GET",
                data: "id=" + id + "&type=single",
                url: "<?php echo url('/aanbieder/product/get-sub-categories-by-category')?>",
                success: function(data) {

                    $.each(data, function(index, value) {

                        var opt = '<option value="'+value.id+'" >'+value.cat_name+'</option>';

                        options = options + opt;

                    });

                    $('.js-data-example-ajax9').find('option')
                        .remove()
                        .end()
                        .append('<option value="">Select Sub Category</option>'+options);

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

        .select2-container .select2-selection--single
        {
            height: 40px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered
        {
            line-height: 40px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow
        {
            height: 38px;
        }

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
