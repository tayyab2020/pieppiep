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
                                        <h2>{{isset($feature) ? 'Edit Sub Products' : 'Add Sub Products'}}</h2>
                                        <a href="{{route('admin-sub-products-index')}}" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> Back</a>
                                    </div>
                                    <hr>
                                    <form class="form-horizontal" action="{{route('admin-sub-products-store')}}" method="POST" enctype="multipart/form-data">
                                        @include('includes.form-error')
                                        @include('includes.form-success')
                                        {{csrf_field()}}

                                        <input type="hidden" id="sub_id" name="sub_id" value="{{isset($sub_product) ? $sub_product->id : null}}">

                                        <div class="form-group">
                                            <label class="control-label col-sm-4">Title* <span>(In Any Language)</span></label>
                                            <div class="col-sm-6">
                                                <select {{isset($sub_product) ? 'disabled' : null}} name="title" required="" class="js-data-example-ajax">
                                                    <option value="">Select Sub Product</option>
                                                    <option {{isset($sub_product) ? ($sub_product->title == 'Ladderband' ? 'selected' : null) : null}} value="Ladderband">Ladderband</option>
                                                    <option {{isset($sub_product) ? ($sub_product->title == 'Type Package' ? 'selected' : null) : null}} value="Type Package">Type Package</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4">Max Size</label>
                                            <div class="col-sm-6">
                                                <input value="{{isset($sub_product) ? str_replace(".",",",$sub_product->max_size) : null}}" maskedformat="9,1" class="form-control" name="max_size" placeholder="Enter Max Size" type="text">
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

                                                    <div style="font-family: monospace;text-align: center;" class="col-sm-3">
                                                        <h4>Size 38mm</h4>
                                                    </div>

                                                    <div style="font-family: monospace;text-align: center;" class="col-sm-3">
                                                        <h4>Size 25mm</h4>
                                                    </div>

                                                </div>

                                                <div class="row feature_box" style="margin: 15px 0;">

                                                    <input type="hidden" name="removed" id="removed_rows">

                                                    @if(isset($sub_data) && count($sub_data) > 0)

                                                        @foreach($sub_data as $f => $key)

                                                            <div class="form-group" style="margin: 0 0 20px 0;display: flex;justify-content: center;">

                                                                <div class="col-sm-2">

                                                                    <input value="{{$key->unique_code}}" class="form-control sub_code" name="sub_codes[]" id="blood_group_slug" placeholder="Sub Product ID" type="text">

                                                                </div>

                                                                <div class="col-sm-3">

                                                                    <input value="{{$key->title}}" class="form-control sub_product_title" name="sub_product_titles[]" id="blood_group_slug" placeholder="Sub Product Title" type="text">

                                                                </div>

                                                                <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-3">

                                                                    <input type="hidden" name="size1_value[]" id="size1_value" value="{{$key->size1_value}}">

                                                                    <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                    <label style="margin: 0;" class="switch">
                                                                        <input {{$key->size1_value ? 'checked' : null}} class="size1_value" type="checkbox">
                                                                        <span class="slider round"></span>
                                                                    </label>
                                                                    <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                </div>

                                                                <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-3">

                                                                    <input type="hidden" name="size2_value[]" id="size2_value" value="{{$key->size2_value}}">

                                                                    <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                    <label style="margin: 0;" class="switch">
                                                                        <input {{$key->size2_value ? 'checked' : null}} class="size2_value" type="checkbox">
                                                                        <span class="slider round"></span>
                                                                    </label>
                                                                    <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

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

                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-3">

                                                                <input type="hidden" name="size1_value[]" id="size1_value" value="0">

                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                <label style="margin: 0;" class="switch">
                                                                    <input class="size1_value" type="checkbox">
                                                                    <span class="slider round"></span>
                                                                </label>
                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                            </div>

                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-3">

                                                                <input type="hidden" name="size2_value[]" id="size2_value" value="0">

                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                <label style="margin: 0;" class="switch">
                                                                    <input class="size2_value" type="checkbox">
                                                                    <span class="slider round"></span>
                                                                </label>
                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

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
                                            <button type="submit" class="btn add-product_btn">{{isset($sub_product) ? 'Edit Sub Product' : 'Add Sub Product'}}</button>
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

            $(document).on('keypress', "input[name='max_size']", function(e){

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

            $(document).on('focusout', "input[name='max_size']", function(e){

                if($(this).val().slice($(this).val().length - 1) == ',')
                {
                    var val = $(this).val();
                    val = val + '00';
                    $(this).val(val);
                }
            });

            $(".js-data-example-ajax").select2({
                width: '100%',
                height: '200px',
                placeholder: "Select Sub Product",
                allowClear: true,
            });

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
                    '                                                           <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-3">\n' +
                    '\n' +
                    '                                                                <input type="hidden" name="size1_value[]" id="size1_value" value="0">\n' +
                    '\n' +
                    '                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                    '                                                                <label style="margin: 0;" class="switch">\n' +
                    '                                                                    <input class="size1_value" type="checkbox">\n' +
                    '                                                                    <span class="slider round"></span>\n' +
                    '                                                                </label>\n' +
                    '                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                    '\n' +
                    '                                                            </div>\n' +
                    '\n' +
                    '                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-3">\n' +
                    '\n' +
                    '                                                                <input type="hidden" name="size2_value[]" id="size2_value" value="0">\n' +
                    '\n' +
                    '                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                    '                                                                <label style="margin: 0;" class="switch">\n' +
                    '                                                                    <input class="size2_value" type="checkbox">\n' +
                    '                                                                    <span class="slider round"></span>\n' +
                    '                                                                </label>\n' +
                    '                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
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
                        '                                                           <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-3">\n' +
                        '\n' +
                        '                                                                <input type="hidden" name="size1_value[]" id="size1_value" value="0">\n' +
                        '\n' +
                        '                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                        '                                                                <label style="margin: 0;" class="switch">\n' +
                        '                                                                    <input class="size1_value" type="checkbox">\n' +
                        '                                                                    <span class="slider round"></span>\n' +
                        '                                                                </label>\n' +
                        '                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                        '\n' +
                        '                                                            </div>\n' +
                        '\n' +
                        '                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-3">\n' +
                        '\n' +
                        '                                                                <input type="hidden" name="size2_value[]" id="size2_value" value="0">\n' +
                        '\n' +
                        '                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                        '                                                                <label style="margin: 0;" class="switch">\n' +
                        '                                                                    <input class="size2_value" type="checkbox">\n' +
                        '                                                                    <span class="slider round"></span>\n' +
                        '                                                                </label>\n' +
                        '                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
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

        $('body').on('change', '.size1_value', function() {

            if($(this).is(":checked"))
            {
                $(this).parent().parent().find('#size1_value').val(1);
            }
            else
            {
                $(this).parent().parent().find('#size1_value').val(0);
            }

        });

        $('body').on('change', '.size2_value', function() {

            if($(this).is(":checked"))
            {
                $(this).parent().parent().find('#size2_value').val(1);
            }
            else
            {
                $(this).parent().parent().find('#size2_value').val(0);
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

        .select2-container--default .select2-selection--single
        {
            height: 45px;
            display: flex;
            align-items: center;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow
        {
            height: 100%;
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


@endsection
