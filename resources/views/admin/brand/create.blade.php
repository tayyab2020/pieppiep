@extends('layouts.handyman')

@section('styles')

    <link href="{{asset('assets/admin/css/jquery-ui.css')}}" rel="stylesheet" type="text/css">

    <style type="text/css">
        .colorpicker-alpha {
            display: none !important;
        }

        .colorpicker {
            min-width: 128px !important;
        }

        .colorpicker-color {
            display: none !important;
        }
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
                                        <h2>{{isset($cats) ? 'Edit Brand' : 'Add Brand'}}</h2>
                                        <a href="{{route('admin-brand-index')}}" class="btn add-back-btn"><i
                                                class="fa fa-arrow-left"></i> Back</a>
                                    </div>
                                    <hr>
                                    <form class="form-horizontal" action="{{route('admin-brand-store')}}" method="POST"
                                          enctype="multipart/form-data">

                                        @include('includes.form-error')
                                        @include('includes.form-success')

                                        {{csrf_field()}}

                                        <input type="hidden" name="cat_id" value="{{isset($cats) ? $cats->id : null}}"/>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_display_name">Title*
                                                <span>(In Any Language)</span></label>
                                            <div class="col-sm-6">
                                                <input value="{{isset($cats) ? $cats->cat_name : null}}"
                                                       class="form-control" name="cat_name"
                                                       id="blood_group_display_name" placeholder="Enter Brand title"
                                                       required="" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">Slug* <span>(In English)</span></label>
                                            <div class="col-sm-6">
                                                <input value="{{isset($cats) ? $cats->cat_slug : null}}"
                                                       class="form-control" name="cat_slug" id="blood_group_slug"
                                                       placeholder="Enter Brand Slug" required="" type="text">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="service_description">Brand
                                                Description*</label>
                                            <div class="col-sm-6">
                                                <textarea class="form-control" name="description"
                                                          id="service_description" rows="5" style="resize: vertical;"
                                                          placeholder="Enter Brand Description">{{isset($cats) ? $cats->description : null}}</textarea>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="current_photo">Current
                                                Photo*</label>
                                            <div class="col-sm-6">
                                                <img width="130px" height="90px" id="adminimg"
                                                     src="{{isset($cats->photo) ? asset('assets/images/'.$cats->photo):'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG'}}"
                                                     alt="">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="profile_photo">Add Photo</label>
                                            <div class="col-sm-6">
                                                <input type="file" id="uploadFile" class="hidden" name="photo" value="">
                                                <button type="button" id="uploadTrigger" onclick="uploadclick()"
                                                        class="form-control"><i class="fa fa-download"></i> Add Category
                                                    Photo
                                                </button>
                                                <p>Prefered Size: (600x600) or Square Sized Image</p>
                                            </div>
                                        </div>

                                        @if(!isset($cats) || ($user_id == $cats->user_id))

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="website_title">Trademark *</label>

                                                <div class="col-sm-6">
                                                    <select class="form-control" name="trademark" required="">

                                                        <option {{isset($cats) ? ($cats->trademark == 0 ? 'selected' : null) : null}} value="0">No</option>
                                                        <option {{isset($cats) ? ($cats->trademark == 1 ? 'selected' : null) : null}} value="1">Yes</option>

                                                    </select>
                                                </div>
                                            </div>

                                        @else

                                            <input type="hidden" name="trademark" value="{{$cats->trademark}}">

                                        @endif

                                        <hr>

                                        <div class="add-product-footer">
                                            <button name="addProduct_btn" type="submit"
                                                    class="btn add-product_btn">{{isset($cats) ? 'Edit Brand' : 'Add Brand'}}</button>
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
        bkLib.onDomLoaded(function () {
            nicEditors.allTextAreas()
        });
        //]]>
    </script>

    <script type="text/javascript">

        function uploadclick() {
            $("#uploadFile").click();
            $("#uploadFile").change(function (event) {
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

        .swal2-show {
            padding: 40px;
            width: 30%;

        }

        .swal2-header {
            font-size: 23px;
        }

        .swal2-content {
            font-size: 18px;
        }

        .swal2-actions {
            font-size: 16px;
        }

    </style>

@endsection
