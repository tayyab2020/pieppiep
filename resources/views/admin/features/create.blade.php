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
                                        <h2>{{isset($feature) ? 'Edit Feature' : 'Add Feature'}}</h2>
                                        <a href="{{route('admin-feature-index')}}" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> Back</a>
                                    </div>
                                    <hr>
                                    <form class="form-horizontal" action="{{route('admin-feature-store')}}" method="POST" enctype="multipart/form-data">
                                        @include('includes.form-error')
                                        @include('includes.form-success')
                                        {{csrf_field()}}

                                        <input type="hidden" id="feature_id" name="feature_id" value="{{isset($feature) ? $feature->id : null}}">

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_display_name">Title* <span>(In Any Language)</span></label>
                                            <div class="col-sm-6">
                                                <input value="{{isset($feature) ? $feature->title : null}}" class="form-control" name="title" id="blood_group_display_name" placeholder="Enter Item Title" required="" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group" style="margin-top: 50px;margin-bottom: 20px;display: flex;justify-content: center;">

                                            <div style="border: 1px solid #e1e1e1;padding: 25px;" class="col-lg-10 col-md-10 col-sm-12 col-xs-12">

                                                <h4 style="text-align: center;margin-bottom: 50px;">Sub Product(s)</h4>

                                                <div class="row" style="margin: 0;">

                                                    <div style="font-family: monospace;" class="col-sm-2">
                                                        <h4>ID</h4>
                                                    </div>

                                                    <div style="font-family: monospace;" class="col-sm-3">
                                                        <h4>Title</h4>
                                                    </div>

                                                    <div style="font-family: monospace;" class="col-sm-3">
                                                        <h4>Size 38mm</h4>
                                                    </div>

                                                    <div style="font-family: monospace;" class="col-sm-3">
                                                        <h4>Size 25mm</h4>
                                                    </div>

                                                </div>

                                                <div class="row feature_box" style="margin: 15px 0;">

                                                    <input type="hidden" name="removed" id="removed_rows">

                                                    @if(isset($sub_data) && count($sub_data) > 0)

                                                        @foreach($sub_data as $f => $key)

                                                            <div class="form-group" style="margin: 0 0 20px 0;display: flex;justify-content: center;">

                                                                <input type="hidden" name="sub_id" value="{{$key->id}}">

                                                                <div class="col-sm-2">

                                                                    <input value="{{$key->unique_code}}" class="form-control sub_code" name="sub_codes[]" id="blood_group_slug" placeholder="Sub Product ID" type="text">

                                                                </div>

                                                                <div class="col-sm-3">

                                                                    <input value="{{$key->title}}" class="form-control sub_product_title" name="sub_product_titles[]" id="blood_group_slug" placeholder="Sub Product Title" type="text">

                                                                </div>

                                                                <div class="col-sm-3">

                                                                    <input value="{{$key->size1_value}}" class="form-control sub_product_size1" name="sub_product_size1[]" id="blood_group_slug" placeholder="" type="text">

                                                                </div>

                                                                <div class="col-sm-3">

                                                                    <input value="{{$key->size2_value}}" class="form-control sub_product_size2" name="sub_product_size2[]" id="blood_group_slug" placeholder="" type="text">

                                                                </div>

                                                                <div class="col-xs-1 col-sm-1">
                                                                    <span class="ui-close remove-feature" data-id="{{$key->id}}" style="margin:0;right:70%;">X</span>
                                                                </div>

                                                            </div>

                                                        @endforeach

                                                    @else

                                                        <div class="form-group" style="margin: 0 0 20px 0;display: flex;justify-content: center;">

                                                            <div class="col-sm-2">

                                                                <input class="form-control sub_code" name="sub_codes[]" id="blood_group_slug" placeholder="Sub Product ID" type="text">

                                                            </div>

                                                            <div class="col-sm-3">

                                                                <input class="form-control sub_product_title" name="sub_product_titles[]" id="blood_group_slug" placeholder="Sub Product Title" type="text">

                                                            </div>

                                                            <div class="col-sm-3">

                                                                <input class="form-control sub_product_size1" name="sub_product_size1[]" id="blood_group_slug" placeholder="" type="text">

                                                            </div>

                                                            <div class="col-sm-3">

                                                                <input class="form-control sub_product_size2" name="sub_product_size2[]" id="blood_group_slug" placeholder="" type="text">

                                                            </div>

                                                            <div class="col-xs-1 col-sm-1">
                                                                <span class="ui-close remove-feature" data-id="" style="margin:0;right:70%;">X</span>
                                                            </div>

                                                        </div>

                                                    @endif

                                                </div>

                                            </div>

                                        </div>

                                        <div class="form-group add-color">
                                            <label class="control-label col-sm-3" for=""></label>

                                            <div class="col-sm-12 text-center">
                                                <button class="btn btn-default featured-btn" type="button" id="add-feature-btn"><i class="fa fa-plus"></i> Add More Sub Products</button>
                                            </div>
                                        </div>


                                        <hr>
                                        <div style="padding-top: 20px;" class="add-product-footer">
                                            <button type="submit" class="btn add-product_btn">{{isset($feature) ? 'Edit Feature' : 'Add Feature'}}</button>
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

            var rem_arr = [];

            $("#add-feature-btn").on('click',function() {


                $(".feature_box").append('<div class="form-group" style="margin: 0 0 20px 0;display: flex;justify-content: center;">\n' +
                    '\n' +
                    '                                                            <div class="col-sm-2">\n' +
                    '\n' +
                    '                                                                <input class="form-control sub_code" name="sub_codes[]" id="blood_group_slug" placeholder="Sub Product ID" type="text">\n' +
                    '\n' +
                    '                                                            </div>\n' +
                    '\n' +
                    '                                                            <div class="col-sm-3">\n' +
                    '\n' +
                    '                                                                <input class="form-control sub_product_title" name="sub_product_titles[]" id="blood_group_slug" placeholder="Sub Product Title" type="text">\n' +
                    '\n' +
                    '                                                            </div>\n' +
                    '\n' +
                    '                                                            <div class="col-sm-3">\n' +
                    '\n' +
                    '                                                                <input class="form-control sub_product_size1" name="sub_product_size1[]" id="blood_group_slug" placeholder="" type="text">\n' +
                    '\n' +
                    '                                                            </div>\n' +
                    '\n' +
                    '                                                            <div class="col-sm-3">\n' +
                    '\n' +
                    '                                                                <input class="form-control sub_product_size2" name="sub_product_size2[]" id="blood_group_slug" placeholder="" type="text">\n' +
                    '\n' +
                    '                                                            </div>\n' +
                    '\n' +
                    '                                                            <div class="col-xs-1 col-sm-1">\n' +
                    '                                                                <span class="ui-close remove-feature" data-id="" style="margin:0;right:70%;">X</span>\n' +
                    '                                                            </div>\n' +
                    '\n' +
                    '                                                        </div>');


            });

            $('body').on('click', '.remove-feature' ,function() {

                var id = $(this).data('id');

                if(id)
                {
                    rem_arr.push(id);
                    $('#removed_rows').val(rem_arr);
                }

                var parent = this.parentNode.parentNode;

                $(parent).hide();
                $(parent).remove();

                if($(".feature_box .form-group").length == 0)
                {
                    $(".feature_box").append('<div class="form-group" style="margin: 0 0 20px 0;display: flex;justify-content: center;">\n' +
                        '\n' +
                        '                                                            <div class="col-sm-2">\n' +
                        '\n' +
                        '                                                                <input class="form-control sub_code" name="sub_codes[]" id="blood_group_slug" placeholder="Sub Product ID" type="text">\n' +
                        '\n' +
                        '                                                            </div>\n' +
                        '\n' +
                        '                                                            <div class="col-sm-3">\n' +
                        '\n' +
                        '                                                                <input class="form-control sub_product_title" name="sub_product_titles[]" id="blood_group_slug" placeholder="Sub Product Title" type="text">\n' +
                        '\n' +
                        '                                                            </div>\n' +
                        '\n' +
                        '                                                            <div class="col-sm-3">\n' +
                        '\n' +
                        '                                                                <input class="form-control sub_product_size1" name="sub_product_size1[]" id="blood_group_slug" placeholder="" type="text">\n' +
                        '\n' +
                        '                                                            </div>\n' +
                        '\n' +
                        '                                                            <div class="col-sm-3">\n' +
                        '\n' +
                        '                                                                <input class="form-control sub_product_size2" name="sub_product_size2[]" id="blood_group_slug" placeholder="" type="text">\n' +
                        '\n' +
                        '                                                            </div>\n' +
                        '\n' +
                        '                                                            <div class="col-xs-1 col-sm-1">\n' +
                        '                                                                <span class="ui-close remove-feature" data-id="" style="margin:0;right:70%;">X</span>\n' +
                        '                                                            </div>\n' +
                        '\n' +
                        '                                                        </div>');

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
