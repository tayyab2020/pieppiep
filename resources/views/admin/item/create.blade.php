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
                                        <h2>Add Item</h2>
                                        <a href="{{route('admin-item-index')}}" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> Back</a>
                                    </div>
                                    <hr>
                                    <form class="form-horizontal" action="{{route('admin-item-store')}}" method="POST" enctype="multipart/form-data">
                                        @include('includes.form-error')
                                        @include('includes.form-success')
                                        {{csrf_field()}}

                                        <input type="hidden" name="item_id" value="{{isset($item) ? $item->id : null}}">

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_display_name">Category*</label>
                                            <div class="col-sm-6">
                                                <select class="js-data-example-ajax8 form-control" style="height: 40px;" name="category_id" id="blood_grp" required>

                                                    <option value="">Select Category</option>

                                                    @foreach($categories as $key)
                                                        <option @if(isset($item)) @if($item->category_id == $key->id) selected @endif @endif value="{{$key->id}}">{{$key->cat_name}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>

                                        <div class="sub-categories-box form-group">

                                            @if(isset($item) && $item->sub_category_ids)

                                                <?php $sub_category_id = explode(',', $item->sub_category_ids); ?>

                                                @foreach($sub_category_id as $key)

                                                    <div style="display: inline-block;width: 100%;margin: 10px 0;" class="sub-category-box">
                                                        <label class="control-label col-sm-4" for="blood_group_slug">Sub Category</label>
                                                        <div style="display: flex;align-items: center;justify-content: space-between;" class="col-sm-6">
                                                            <div style="padding: 0;" class="col-lg-10">
                                                                <select class="js-data-example-ajax10 form-control" style="height: 40px;" name="sub_category_id[]" id="blood_grp">

                                                                    <option value="">Select Sub Category</option>

                                                                    @foreach($sub_categories as $sub_cat)

                                                                        <option @if($key == $sub_cat->id) selected @endif value="{{$sub_cat->id}}">{{$sub_cat->cat_name}}</option>

                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                            <div style="display: flex;justify-content: flex-end;padding: 0;" class="col-lg-2">
                                                                <span class="ui-close add-sub-category" style="margin:0;position: relative;top: 0;background-color: #5cb85c;font-size: 22px;">+</span>
                                                                <span class="ui-close remove-sub-category" style="margin:0;position: relative;right: 0;top: 0;">X</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                @endforeach

                                            @else

                                                <div style="display: inline-block;width: 100%;margin: 10px 0;" class="sub-category-box">
                                                    <label class="control-label col-sm-4" for="blood_group_slug">Sub Category</label>
                                                    <div style="display: flex;align-items: center;justify-content: space-between;" class="col-sm-6">
                                                        <div style="padding: 0;" class="col-lg-10">
                                                            <select class="js-data-example-ajax10 form-control" style="height: 40px;" name="sub_category_id[]" id="blood_grp">

                                                                <option value="">Select Sub Category</option>

                                                            </select>
                                                        </div>
                                                        <div style="display: flex;justify-content: flex-end;padding: 0;" class="col-lg-2">
                                                            <span class="ui-close add-sub-category" style="margin:0;position: relative;top: 0;background-color: #5cb85c;font-size: 22px;">+</span>
                                                            <span class="ui-close remove-sub-category" style="margin:0;position: relative;right: 0;top: 0;">X</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endif

                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_display_name">Retailer</label>
                                            <div class="col-sm-6">
                                                <select class="js-data-example-ajax9 form-control" style="height: 40px;" name="retailer_id" id="blood_grp">

                                                    <option value="">Select Retailer</option>

                                                    @foreach($retailers as $key)
                                                        <option @if(isset($item)) @if($item->user_id == $key->id) selected @endif @endif value="{{$key->id}}">{{$key->company_name}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_display_name">Title* <span>(In Any Language)</span></label>
                                            <div class="col-sm-6">
                                                <input value="{{isset($item) ? $item->cat_name : null}}" class="form-control" name="title" id="blood_group_display_name" placeholder="Enter Item Title" required="" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_display_name">Product ID</label>
                                            <div class="col-sm-6">
                                                <input value="{{isset($item) ? $item->product_id : null}}" class="form-control" name="product_id" id="blood_group_display_name" placeholder="Enter Product ID" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_display_name">Supplier</label>
                                            <div class="col-sm-6">
                                                <input value="{{isset($item) ? $item->supplier : null}}" class="form-control" name="supplier" id="blood_group_display_name" placeholder="Enter Supplier Name" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">VAT Percentage</label>
                                            <div class="col-sm-6">
                                                <input readonly name="product_vat" value="21" class="form-control product_vat" id="blood_group_slug" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">Rate*</label>
                                            <div class="col-sm-6">
                                                <input value="{{isset($item) ? $item->rate : null}}" class="form-control product_rate" maskedFormat="9,1" autocomplete="off" name="rate" id="blood_group_slug" placeholder="Enter Rate" required="" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">Sell Rate*</label>
                                            <div class="col-sm-6">
                                                <input maskedFormat="9,1" autocomplete="off" name="sell_rate" step="any" value="{{isset($item) ? number_format((float)$item->sell_rate, 2, ',', '.') : null}}" class="form-control product_sell_rate" id="blood_group_slug" placeholder="Sell Rate" required="" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="item_description">Description</label>
                                            <div class="col-sm-6">
                                                <textarea class="form-control" name="description" id="item_description" rows="5" style="resize: vertical;" placeholder="Enter Description">{{isset($item) ? $item->description : null}}</textarea>
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="current_photo">Current Photo</label>
                                            <div class="col-sm-6">
                                                <img width="130px" height="90px" id="adminimg" src="{{isset($item) ? $item->photo ? asset('assets/item_images/'.$item->photo):'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG' : null}}" alt="">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="profile_photo">Add Photo</label>
                                            <div class="col-sm-6">
                                                <input type="file" id="uploadFile" class="hidden" name="photo" value="">
                                                <button type="button" id="uploadTrigger" onclick="uploadclick()" class="form-control"><i class="fa fa-download"></i> Add Item Photo</button>
                                                <p>Prefered Size: (600x600) or Square Sized Image</p>
                                            </div>
                                        </div>

                                        <div class="products-box">

                                            @if(isset($item) && $item->products)

                                                <?php $products = explode(',', $item->products); ?>

                                                    @foreach($products as $key)

                                                        <div class="form-group product-box">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Product</label>
                                                            <div style="display: flex;align-items: center;justify-content: space-between;" class="col-sm-6">
                                                                <div style="padding: 0;" class="col-lg-8">
                                                                    <select class="form-control js-data-example-ajax11" name="products[]">

                                                                        <option value="">Select Product</option>

                                                                        @foreach($retailer_products as $temp)

                                                                            <option {{$temp->id == $key ? 'selected' : null}} value="{{$temp->id}}">{{$temp->title}}</option>

                                                                        @endforeach

                                                                    </select>
                                                                </div>
                                                                <div style="display: flex;justify-content: flex-start;" class="col-lg-4">
                                                                    <span class="ui-close add-product" style="margin:0;position: relative;top: 0;background-color: #5cb85c;font-size: 22px;">+</span>
                                                                    <span class="ui-close remove-product" style="margin:0;position: relative;right: 0;top: 0;">X</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    @endforeach

                                            @else

                                                <div class="form-group product-box">
                                                    <label class="control-label col-sm-4" for="blood_group_slug">Product</label>
                                                    <div style="display: flex;align-items: center;justify-content: space-between;" class="col-sm-6">
                                                        <div style="padding: 0;" class="col-lg-8">
                                                            <select class="form-control js-data-example-ajax11" name="products[]">

                                                                <option value="">Select Product</option>

                                                            </select>
                                                        </div>
                                                        <div style="display: flex;justify-content: flex-start;" class="col-lg-4">
                                                            <span class="ui-close add-product" style="margin:0;position: relative;top: 0;background-color: #5cb85c;font-size: 22px;">+</span>
                                                            <span class="ui-close remove-product" style="margin:0;position: relative;right: 0;top: 0;">X</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endif

                                        </div>

                                        <hr>
                                        <div class="add-product-footer">
                                            <button name="addProduct_btn" type="submit" class="btn add-product_btn">{{isset($item) ? 'Edit Item' : 'Add Item'}}</button>
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

        $("body").on('click','.add-product',function() {

            $(".products-box").append('<div class="form-group product-box">\n' +
                '                                                <label class="control-label col-sm-4" for="blood_group_slug">Product</label>\n' +
                '                                                <div style="display: flex;align-items: center;justify-content: space-between;" class="col-sm-6">\n' +
                '                                                    <div style="padding: 0;" class="col-lg-8">\n' +
                '\n' +
                '                                                       <select class="form-control js-data-example-ajax11" name="products[]">\n' +
                '\n' +
                '                                                           <option value="">Select Product</option>\n' +
                '\n' +
                '                                                       </select>\n' +
                '\n' +
                '                                                    </div>\n' +
                '                                                    <div style="display: flex;justify-content: flex-start;" class="col-lg-4">\n' +
                '                                                        <span class="ui-close add-product" style="margin:0;position: relative;top: 0;background-color: #5cb85c;font-size: 22px;">+</span>\n' +
                '                                                        <span class="ui-close remove-product" style="margin:0;position: relative;right: 0;top: 0;">X</span>\n' +
                '                                                    </div>\n' +
                '                                                </div>\n' +
                '                                            </div>');

            var last_row = $('.products-box .js-data-example-ajax11:last');

            last_row.select2({
                width: '100%',
                placeholder: "Select Product",
                allowClear: true,
            });

            var id = $(".js-data-example-ajax9").val();
            get_products_by_retailers(id,last_row);

        });

        $("body").on('click','.remove-product',function() {

            $(this).parents('.product-box').remove();

            if($(".products-box .product-box").length == 0)
            {
                $(".products-box").append('<div class="form-group product-box">\n' +
                    '                                                <label class="control-label col-sm-4" for="blood_group_slug">Product</label>\n' +
                    '                                                <div style="display: flex;align-items: center;justify-content: space-between;" class="col-sm-6">\n' +
                    '                                                    <div style="padding: 0;" class="col-lg-8">\n' +
                    '\n' +
                    '                                                       <select class="form-control js-data-example-ajax11" name="products[]">\n' +
                    '\n' +
                    '                                                           <option value="">Select Product</option>\n' +
                    '\n' +
                    '                                                       </select>\n' +
                    '\n' +
                    '                                                    </div>\n' +
                    '                                                    <div style="display: flex;justify-content: flex-start;" class="col-lg-4">\n' +
                    '                                                        <span class="ui-close add-product" style="margin:0;position: relative;top: 0;background-color: #5cb85c;font-size: 22px;">+</span>\n' +
                    '                                                        <span class="ui-close remove-product" style="margin:0;position: relative;right: 0;top: 0;">X</span>\n' +
                    '                                                    </div>\n' +
                    '                                                </div>\n' +
                    '                                            </div>');

                var last_row = $('.products-box .js-data-example-ajax11:last');

                last_row.select2({
                    width: '100%',
                    placeholder: "Select Product",
                    allowClear: true,
                });

                var id = $(".js-data-example-ajax9").val();
                get_products_by_retailers(id,last_row);
            }

        });

        $('.product_rate,.product_sell_rate').keypress(function(e){

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

        $('.product_rate,.product_sell_rate').on('focusout',function(e){
            if($(this).val().slice($(this).val().length - 1) == ',')
            {
                var val = $(this).val();
                val = val + '00';
                $(this).val(val);
            }
        });


        $('.product_rate').on('change keyup', function() {

            var rate = $(this).val().replace(/\,/g, '.');
            var vat = parseInt($('.product_vat').val());
            vat = (100 + vat)/100;

            var sell_rate = rate * vat;
            sell_rate = parseFloat(sell_rate).toFixed(2);

            $(this).parent().parent().parent().find('.product_sell_rate').val(sell_rate.replace(/\./g, ','));

        });

        $('.product_sell_rate').on('change keyup', function() {

            var sell_rate = $(this).val().replace(/\,/g, '.');
            var vat = parseInt($('.product_vat').val());
            vat = (100 + vat)/100;

            var rate = sell_rate / vat;
            rate = parseFloat(rate).toFixed(2);

            $(this).parent().parent().parent().find('.product_rate').val(rate.replace(/\./g, ','));

        });

        $(".js-data-example-ajax8").select2({
            width: '100%',
            height: '200px',
            placeholder: "Select Category",
            allowClear: true,
        });

        $(".js-data-example-ajax10").select2({
            width: '100%',
            height: '200px',
            placeholder: "Select Sub Category",
            allowClear: true,
        });

        $("body").on('click','.add-sub-category',function() {

            var id = $('.js-data-example-ajax8').val();

            $(".sub-categories-box").append('<div style="display: inline-block;width: 100%;margin: 10px 0;" class="sub-category-box">\n' +
                '                                                    <label class="control-label col-sm-4" for="blood_group_slug">Sub Category</label>\n' +
                '                                                    <div style="display: flex;align-items: center;justify-content: space-between;" class="col-sm-6">\n' +
                '                                                        <div style="padding: 0;" class="col-lg-10">\n' +
                '                                                            <select class="js-data-example-ajax10 form-control" style="height: 40px;" name="sub_category_id[]" id="blood_grp">\n' +
                '\n' +
                '                                                            <option value="">Select Sub Category</option>\n' +
                '\n' +
                '                                                            </select>\n' +
                '                                                        </div>\n' +
                '                                                        <div style="display: flex;justify-content: flex-end;padding: 0;" class="col-lg-2">\n' +
                '                                                            <span class="ui-close add-sub-category" style="margin:0;position: relative;top: 0;background-color: #5cb85c;font-size: 22px;">+</span>\n' +
                '                                                            <span class="ui-close remove-sub-category" style="margin:0;position: relative;right: 0;top: 0;">X</span>\n' +
                '                                                        </div>\n' +
                '                                                    </div>\n' +
                '                                                </div>');

            get_sub_categories(id,2);

            $(".js-data-example-ajax10").select2({
                width: '100%',
                height: '200px',
                placeholder: "Select Sub Category",
                allowClear: true,
            });

        });

        $("body").on('click','.remove-sub-category',function() {

            var id = $('.js-data-example-ajax8').val();
            $(this).parents('.sub-category-box').remove();

            if($(".sub-categories-box .sub-category-box").length == 0)
            {
                $(".sub-categories-box").append('<div style="display: inline-block;width: 100%;margin: 10px 0;" class="sub-category-box">\n' +
                    '                                                    <label class="control-label col-sm-4" for="blood_group_slug">Sub Category</label>\n' +
                    '                                                    <div style="display: flex;align-items: center;justify-content: space-between;" class="col-sm-6">\n' +
                    '                                                        <div style="padding: 0;" class="col-lg-10">\n' +
                    '                                                            <select class="js-data-example-ajax10 form-control" style="height: 40px;" name="sub_category_id[]" id="blood_grp">\n' +
                    '\n' +
                    '                                                            <option value="">Select Sub Category</option>\n' +
                    '\n' +
                    '                                                            </select>\n' +
                    '                                                        </div>\n' +
                    '                                                        <div style="display: flex;justify-content: flex-end;padding: 0;" class="col-lg-2">\n' +
                    '                                                            <span class="ui-close add-sub-category" style="margin:0;position: relative;top: 0;background-color: #5cb85c;font-size: 22px;">+</span>\n' +
                    '                                                            <span class="ui-close remove-sub-category" style="margin:0;position: relative;right: 0;top: 0;">X</span>\n' +
                    '                                                        </div>\n' +
                    '                                                    </div>\n' +
                    '                                                </div>');

                get_sub_categories(id,1);

                $(".js-data-example-ajax10").select2({
                    width: '100%',
                    height: '200px',
                    placeholder: "Select Sub Category",
                    allowClear: true,
                });
            }

        });

        function get_sub_categories(id,type)
        {
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

                    if(type == 1)
                    {
                        var current = $('.js-data-example-ajax10');
                    }
                    else
                    {
                        var current = $('.sub-categories-box .sub-category-box:last').find('.js-data-example-ajax10');
                    }

                    current.find('option')
                        .remove()
                        .end()
                        .append('<option value="">Select Sub Category</option>'+options);

                }
            });
        }

        function get_products_by_retailers(id,last_row = null)
        {
            var options = '';

            $.ajax({
                type:"GET",
                data: "id=" + id,
                url: "<?php echo url('/logstof/get-products-by-retailer')?>",
                success: function(data) {

                    $.each(data, function(index, value) {

                        var opt = '<option value="'+value.id+'" >'+value.title+'</option>';

                        options = options + opt;

                    });

                    if(last_row)
                    {
                        last_row.find('option')
                            .remove()
                            .end()
                            .append('<option value="">Select Product</option>'+options);
                    }
                    else
                    {
                        $('.js-data-example-ajax11').find('option')
                            .remove()
                            .end()
                            .append('<option value="">Select Product</option>'+options);
                    }

                }
            });
        }

        $('body').on('change', '.js-data-example-ajax8' ,function(){

            var id = $(this).val();

            get_sub_categories(id,1);

        });

        $('body').on('change', '.js-data-example-ajax9' ,function(){

            var id = $(this).val();

            get_products_by_retailers(id);

        });

        $(".js-data-example-ajax9").select2({
            width: '100%',
            placeholder: "Select Retailer",
            allowClear: true,
        });

        $(".js-data-example-ajax11").select2({
            width: '100%',
            placeholder: "Select Product",
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

@endsection
