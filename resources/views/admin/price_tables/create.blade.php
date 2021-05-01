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
                                            <h2>{{isset($cats) ? 'Edit Table' : 'Add Table'}}</h2>
                                            <a href="{{route('admin-price-tables')}}" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> Back</a>
                                        </div>
                                        <hr>
                                        <form class="form-horizontal" action="{{route('admin-price-tables-store')}}" method="POST" enctype="multipart/form-data">

                                            @include('includes.form-error')
                                            @include('includes.form-success')

                                            {{csrf_field()}}

                                            <input type="hidden" name="id" value="{{isset($cats) ? $cats->id : null}}" />

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_display_name">Title* <span>(In Any Language)</span></label>
                                                <div class="col-sm-6">
                                                    <input value="{{isset($cats) ? $cats->title : null}}" class="form-control" name="title" id="blood_group_display_name" placeholder="Enter Product title" required="" type="text">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">Color*</label>
                                                <div class="col-sm-6">
                                                    <select class="js-data-example-ajax form-control" style="height: 40px;" name="color_id" id="blood_grp" required>

                                                        <option value="">Select Color</option>

                                                        @foreach($colors as $key)
                                                            <option @if(isset($cats)) @if($cats->color_id == $key->id) selected @endif @endif value="{{$key->id}}">{{$key->title}}</option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="add-product-footer">
                                                <button name="addProduct_btn" type="submit" class="btn add-product_btn">{{isset($cats) ? 'Edit Table' : 'Add Table'}}</button>
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

    $(".js-data-example-ajax").select2({
        width: '100%',
        height: '200px',
        placeholder: "Select Color",
        allowClear: true,
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

    .select2-selection
    {
        height: 40px !important;
        display: flex !important;
        align-items: center;
        justify-content: space-between;
    }

    .select2-selection__rendered
    {
        width: 100% !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow
    {
        position: relative !important;
        top: 0 !important;
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
