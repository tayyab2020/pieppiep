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
                                        <h2>{{isset($cats) ? 'Edit Type' : 'Add Type'}}</h2>
                                        <a href="{{route('admin-model-index')}}" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> Back</a>
                                    </div>
                                    <hr>
                                    <form class="form-horizontal" action="{{route('admin-model-store')}}" method="POST" enctype="multipart/form-data">

                                        @include('includes.form-error')
                                        @include('includes.form-success')

                                        {{csrf_field()}}

                                        @if(isset($type_edit_request) && $type_edit_request)

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_display_name"></label>
                                                <div class="col-sm-6">
                                                    <h3>Edit Request Details</h3>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_display_name">Title</label>
                                                <div class="col-sm-6">
                                                    <input value="{{$type_edit_request->cat_name}}"
                                                           class="form-control" readonly
                                                           id="blood_group_display_name" placeholder="Enter Type title"
                                                           type="text">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">Slug</label>
                                                <div class="col-sm-6">
                                                    <input value="{{$type_edit_request->cat_slug}}"
                                                           class="form-control" id="blood_group_slug" readonly
                                                           placeholder="Enter Type Slug" type="text">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="service_description">Type Description</label>
                                                <div class="col-sm-6">
                                                    <div class="summernote">{!! $type_edit_request->description !!}</div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="current_photo">Current Photo</label>
                                                <div class="col-sm-6">
                                                    <img width="130px" height="90px" id="adminimg1"
                                                         src="{{$type_edit_request->photo ? asset('assets/images/'.$type_edit_request->photo):'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG'}}"
                                                         alt="">
                                                </div>
                                            </div>

                                            <hr style="margin-bottom: 40px;border-top: 1px solid #d6d6d6;">

                                        @endif

                                        <input type="hidden" name="cat_id" value="{{isset($cats) ? $cats->id : null}}" />

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_display_name">Title* <span>(In Any Language)</span></label>
                                            <div class="col-sm-6">
                                                <input value="{{isset($cats) ? $cats->cat_name : null}}" class="form-control" name="cat_name" id="blood_group_display_name" placeholder="Enter Model title" required="" type="text">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">Slug* <span>(In English)</span></label>
                                            <div class="col-sm-6">
                                                <input value="{{isset($cats) ? $cats->cat_slug : null}}" class="form-control" name="cat_slug" id="blood_group_slug" placeholder="Enter Model Slug" required="" type="text">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="service_description">Type Description*</label>
                                            <div class="col-sm-6">
                                                <input type="hidden" name="description">
                                                <div class="summernote">{!! isset($cats) ? $cats->description : null !!}</div>
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
                                                <button type="button" id="uploadTrigger" onclick="uploadclick()" class="form-control"><i class="fa fa-download"></i> Add Category Photo</button>
                                                <p>Prefered Size: (600x600) or Square Sized Image</p>
                                            </div>
                                        </div>

                                        @if(!isset($cats) || ($user_id == $cats->user_id))

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="website_title">Brand *</label>

                                                <div class="col-sm-6">
                                                    <select class="form-control" name="brand_id" required>
                                                        <option value="">Select Brand</option>

                                                        @foreach($brands as $key)

                                                            <option @if(isset($cats)) @if($cats->brand_id == $key->id) selected @endif @endif value="{{$key->id}}">{{$key->cat_name}}</option>

                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>

                                        @else

                                            <input type="hidden" name="brand_id" value="{{$cats->brand_id}}">

                                        @endif

                                        <hr>

                                        <div class="add-product-footer">
                                            <button name="addProduct_btn" type="submit" class="btn add-product_btn">{{isset($cats) ? 'Edit Type' : 'Add Type'}}</button>
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

<script type="text/javascript">

    $(document).ready(function () {

        $('.summernote').summernote({
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['style']],
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                /*['color', ['color']],*/
                ['fontname', ['fontname']],
                ['forecolor', ['forecolor']],
            ],
            height: 200,   //set editable area's height
            codemirror: { // codemirror options
                theme: 'monokai'
            },
            callbacks: {
                onChange: function (contents, $editable) {
                    $(this).prev('input').val(contents);
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

@endsection
