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
                                            <h2>Edit Advertisement</h2>
                                            <a href="{{route('admin-adv-index')}}" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> {{__('text.Back')}}</a>  
                                        </div>
                                        <hr>
                                        <form class="form-horizontal" action="{{route('admin-adv-update',$ad->id)}}" method="POST" enctype="multipart/form-data">
                                          @include('includes.form-error')
                                          @include('includes.form-success')
                                          {{csrf_field()}}
                            <div class="item form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="number"> Advertise Type <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select onchange="adstypes(this.value)" name="type" class="form-control" required>
                                        <option value="">Select Advertise Type</option>
                                        @if($ad->type == "banner")
                                            <option value="banner" selected>Banner</option>
                                        @else
                                            <option value="banner">Banner</option>
                                        @endif
                                        @if($ad->type == "script")
                                            <option value="script" selected>Script</option>
                                        @else
                                            <option value="script">Script</option>
                                        @endif

                                    </select>
                                </div>
                            </div>

                            <div class="item form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="number"> Advertise Banner Size <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select name="size" class="form-control" required>
                                        <option value="">Select Banner Size</option>
                                        @if($ad->size == "728x90")
                                            <option value="728x90" selected>728x90</option>
                                        @else
                                            <option value="728x90">728x90</option>
                                        @endif
                                        @if($ad->size == "300x250")
                                            <option value="300x250" selected>300x250</option>
                                        @else
                                            <option value="300x250">300x250</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div id="typeoption">
                                @if($ad->type == "script")
                                    <div class="item form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slug">Ad Script <span class="required">*</span>
                                            <p class="small-label">Google Adsense or Others</p>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea class="form-control col-md-7 col-xs-12" data-validate-length-range="6" name="script" placeholder="Paste Your Ad Script Here.." required="required">{{$ad->script}}</textarea>
                                        </div>
                                    </div>
                                @else

                                    <div class="item form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Advertiser Name<span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input class="form-control col-md-7 col-xs-12" value="{{$ad->alt}}" name="alt" placeholder="e.g Sports" type="text">
                                        </div>
                                    </div>

                                    <div class="item form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="number"> Current Banner <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <img src="{{ $ad->photo ? asset('assets/images/'.$ad->photo):'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG'}}" style="max-height: 200px;" alt="No Banner Photo">
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="number"> Change Advertise Banner <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="file" accept="image/*" name="photo" id="uploadFile"/>
                                        </div>
                                    </div>
                                    <div class="item form-group">
                                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="slug">Redirect URL <span class="required">*</span>
                                            <p class="small-label">e.g. http://geniusocean.com</p>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input class="form-control col-md-7 col-xs-12" value="{{$ad->url}}" name="url" placeholder="e.g. http://geniusocean.com" required="required" type="text">
                                        </div>
                                    </div>
                                @endif
                            </div>

                                           <hr>
                                            <div class="add-product-footer">
                                                <button name="addProduct_btn" type="submit" class="btn add-product_btn">Update Advertisement</button>
                                            </div>
                                        </form>
                                        </div>
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

