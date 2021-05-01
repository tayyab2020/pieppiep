@extends('layouts.admin')

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
                                            <h2>Create Testimonial</h2>
                                            <a href="{{route('admin-ad-index')}}" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> Back</a>  
                                        </div>
                                        <hr>
                                        <form class="form-horizontal" action="{{route('admin-ad-create')}}" method="POST" enctype="multipart/form-data">
                                          @include('includes.form-error')
                                          @include('includes.form-success')
                                          {{csrf_field()}}
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_title">Client's Name*</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="client" id="edit_title" placeholder="Enter Client's Name " required="" type="text" value="">
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_language">Designation*</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="designation" id="edit_language" placeholder="Enter Designation" required="" type="text" value="">
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_profile_description">Review*</label>
                                            <div class="col-sm-6"> 
                                              <textarea class="form-control" name="review" id="edit_profile_description" rows="5" style="resize: vertical;" placeholder="Enter Profile Description"></textarea>
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_current_photo">Current Image*</label>
                                            <div class="col-sm-6">
     
                                              <img width="130px" height="90px" id="adminimg" src="" alt="" id="adminimg">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_profile_photo">Add Image</label>
                                            <div class="col-sm-6">
                                    <input type="file" id="uploadFile" class="hidden" name="photo" value="">
                                              <button type="button" id="uploadTrigger" onclick="uploadclick()" class="form-control"><i class="fa fa-download"></i> Add Client Photo</button>
                                              <p>Prefered Size: (600x600) or Square Sized Image</p>
                                            </div>
                                          </div>                                            <hr>
                                            <div class="add-product-footer">
                                                <button name="addProduct_btn" type="submit" class="btn add-product_btn">Create Testimonial</button>
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

@endsection

