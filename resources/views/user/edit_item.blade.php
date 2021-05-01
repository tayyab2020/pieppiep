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
                                        <h2>{{__('text.Edit Item')}}</h2>
                                        <a href="{{route('user-items')}}" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> {{__('text.Back')}}</a>
                                    </div>
                                    <hr>
                                    <form class="form-horizontal" action="{{route('update-item',$item->id)}}" method="POST" enctype="multipart/form-data">
                                        {{csrf_field()}}
                                        @include('includes.form-error')
                                        @include('includes.form-success')

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_blood_group_display_name">{{__('text.Item')}}* </label>
                                            <div class="col-sm-6">
                                                <input class="form-control" name="item" id="edit_blood_group_display_name" placeholder="{{__('text.Enter Item Title')}}" required="" type="text" value="{{$item->cat_name}}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_blood_group_slug">{{__('text.Rate')}}*</label>
                                            <div class="col-sm-6">
                                                <input maskedFormat="9,1" autocomplete="off" class="form-control rate" name="rate" id="edit_blood_group_slug" placeholder="{{__('text.Enter Rate')}}" required="" type="text" value="{{number_format((float)$item->rate, 2, ',', '.')}}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="item_description">{{__('text.Description')}}</label>
                                            <div class="col-sm-6">
                                                <textarea class="form-control" name="description" id="item_description" rows="5" style="resize: vertical;" placeholder="{{__('text.Enter Description')}}">{{$item->description}}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="current_photo">{{__('text.Current Photo<')}}/label>
                                            <div class="col-sm-6">
                                                <img width="130px" height="90px" id="adminimg" src="{{ $item->photo ? asset('assets/item_images/'.$item->photo):'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG'}}" alt="" id="adminimg">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="profile_photo">{{__('text.Edit Photo')}} *</label>
                                            <div class="col-sm-6">
                                                <input type="file" id="uploadFile" class="hidden" name="photo" value="">
                                                <button type="button" id="uploadTrigger" onclick="uploadclick()" class="form-control"><i class="fa fa-download"></i> {{__('text.Edit Item Photo')}}</button>
                                                <p>{{__('text.Prefered Size: (600x600) or Square Sized Image')}}</p>
                                            </div>
                                        </div>


                                        <hr>
                                        <div class="add-product-footer">
                                            <button name="addProduct_btn" type="submit" class="btn add-product_btn">{{__('text.Update Item')}}</button>
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

        $('.rate').keypress(function(e){

            e = e || window.event;
            var charCode = (typeof e.which == "undefined") ? e.keyCode : e.which;
            var val = String.fromCharCode(charCode);

            if (!val.match(/^[0-9]*\,?[0-9]*$/))  // For characters validation
            {
                e.preventDefault();
                return false;
            }

            if(e.which == 44)
            {
                if(this.value.indexOf(',') > -1)
                {
                    e.preventDefault();
                    return false;
                }
            }

            var num = $(this).attr("maskedFormat").toString().split(',');
            var regex = new RegExp("^\\d{0," + num[0] + "}(\\,\\d{0," + num[1] + "})?$");
            if (!regex.test(this.value)) {
                this.value = this.value.substring(0, this.value.length - 1);
            }

        });

        $('.rate').on('focusout',function(e){
            if($(this).val().slice($(this).val().length - 1) == ',')
            {
                var val = $(this).val();
                val = val + '00';
                $(this).val(val);
            }
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


    <script src="{{asset('assets/admin/js/jquery152.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/jqueryui.min.js')}}"></script>

@endsection
