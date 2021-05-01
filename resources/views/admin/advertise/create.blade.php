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
                                            <h2>Create Advertisement</h2>
                                            <a href="{{route('admin-adv-index')}}" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> Back</a>  
                                        </div>
                                        <hr>
                                        <form class="form-horizontal" action="{{route('admin-adv-create')}}" method="POST" enctype="multipart/form-data">
                                          @include('includes.form-error')
                                          @include('includes.form-success')
                                          {{csrf_field()}}


   

                             <div class="item form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="number"> Advertise Type <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select id="adstype" onchange="adstypes(this.value)" name="type" class="form-control" required>
                                        <option value="">Select Advertise Type</option>
                                        <option value="banner">Banner</option>
                                        <option value="script">Script</option>
                                    </select>
                                </div>
                            </div>
                            <div class="item form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="number"> Advertise Banner Size <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="size" class="form-control" required>
                                        <option value="">Select Banner Size</option>
                                        <option value="728x90">728x90</option>
                                        <option value="300x250">300x250</option>
                                    </select>
                                </div>
                            </div>

                            <div id="typeoption">

                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                            <div class="add-product-footer">
                                                <button name="addProduct_btn" type="submit" class="btn add-product_btn">Create Advertisement</button>
                                            </div>
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

function adstypes(type){
    if (type == "banner"){
        $("#typeoption").html('<div class="item form-group"><label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Advertiser Name<span class="required">*</span></label><div class="col-md-6 col-sm-6 col-xs-12"><input class="form-control col-md-7 col-xs-12" name="alt" placeholder="e.g CodeCannyon" type="text"></div></div><div class="item form-group"><label class="control-label col-md-4 col-sm-4 col-xs-12" for="number"> Advertise Banner <span class="required">*</span></label><div class="col-md-6 col-sm-6 col-xs-12"><input type="file" accept="image/*" name="photo" id="uploadFile" required/></div></div><div class="item form-group"><label class="control-label col-md-4 col-sm-4 col-xs-12" for="slug">Redirect URL <span class="required">*</span><p class="small-label">e.g. http://geniusocean.com</p></label><div class="col-md-6 col-sm-6 col-xs-12"><input class="form-control col-md-7 col-xs-12" name="url" placeholder="e.g. http://geniusocean.com" required type="text"></div></div>');
    }else if (type == "script"){
        $("#typeoption").html('<div class="item form-group"> <label class="control-label col-md-4 col-sm-4 col-xs-12" for="script">Ad Script <span class="required">*</span> <p class="small-label">Google Adsense or Others</p> </label> <div class="col-md-6 col-sm-6 col-xs-12"> <textarea class="form-control col-md-7 col-xs-12" name="script" placeholder="Paste Your Ad Script Here.." required></textarea> </div> </div>');
    }else{
        $("#typeoption").html('');
    }
}
  
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

