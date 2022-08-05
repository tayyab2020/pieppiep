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
                    <div class="section-padding add-product-1" style="padding-top: 0;">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="add-product-box">
                                    <div class="add-product-header">
                                        <h2>{{isset($my_product) ?  __('text.Edit Product') :  __('text.Add Product')}}</h2>
                                        <a href="{{route('user-products')}}" class="btn add-back-btn"><i class="fa fa-arrow-left"></i>{{__('text.Back')}}</a>
                                    </div>
                                    <hr>
                                    <form class="form-horizontal" action="{{route('product-store')}}" method="POST" enctype="multipart/form-data">

                                        @include('includes.form-error')
                                        @include('includes.form-success')

                                        {{csrf_field()}}

                                        <input type="hidden" name="handyman_product_id" value="{{isset($my_product) ? $my_product->id : null}}" />

                                        <div class="form-group" style="display: none;">
                                            <label class="control-label col-sm-4" for="blood_group_slug">Products*</label>
                                            <div class="col-sm-6">
                                                <select class="js-data-example-ajax form-control quote_validation" style="height: 40px;" name="product_id" id="blood_grp" required>

                                                    <option value="">Select Product</option>

                                                    @foreach($products as $key)
                                                        <option @if(isset($my_product)) @if($my_product->product_id == $key->id) selected @endif @endif value="{{$key->id}}">{{$key->title}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>

                                        <div class="product_details" @if(!isset($my_product)) style="display: none;" @endif>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_display_name">Title* <span>(In Any Language)</span></label>
                                                <div class="col-sm-6">
                                                    <input readonly value="{{isset($my_product) ? $my_product->title : null}}" class="form-control product_title" name="title" id="blood_group_display_name" placeholder="{{__('text.Enter Product Title')}}" required="" type="text">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">Slug* <span>(In English)</span></label>
                                                <div class="col-sm-6">
                                                    <input readonly value="{{isset($my_product) ? $my_product->slug : null}}" class="form-control product_slug" name="slug" id="blood_group_slug" placeholder="Enter Product Slug" required="" type="text">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">{{__('text.Category*')}}</label>
                                                <div class="col-sm-6">
                                                    <input value="{{isset($my_product) ? $my_product->category_id : null}}" class="form-control category_id" name="category_id" id="blood_group_slug" type="hidden">
                                                    <input readonly value="{{isset($my_product) ? $my_product->category : null}}" class="form-control product_category" id="blood_group_slug" placeholder="Enter Product Category" required="" type="text">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">{{__('text.Brand*')}}</label>
                                                <div class="col-sm-6">
                                                    <input value="{{isset($my_product) ? $my_product->brand_id : null}}" class="form-control brand_id" name="brand_id" id="blood_group_slug" type="hidden">
                                                    <input readonly value="{{isset($my_product) ? $my_product->brand : null}}" class="form-control product_brand" id="blood_group_slug" placeholder="Enter Product Brand" required="" type="text">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">Model*</label>
                                                <div class="col-sm-6">
                                                    <input value="{{isset($my_product) ? $my_product->model_id : null}}" class="form-control model_id" name="model_id" id="blood_group_slug" type="hidden">
                                                    <input readonly value="{{isset($my_product) ? $my_product->model : null}}" class="form-control product_model" id="blood_group_slug" placeholder="Enter Product Model" required="" type="text">
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="service_description">Product Description*</label>
                                                <div class="col-sm-6">
                                                    <textarea readonly class="form-control product_description" id="service_description" name="description" rows="5" style="resize: vertical;" placeholder="{{__('text.Enter Product Description')}}">{{isset($my_product) ? $my_product->description : null}}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">VAT Percentage</label>
                                                <div class="col-sm-6">
                                                    <input readonly name="product_vat" value="{{isset($my_product) ? $my_product->vat_percentage : 21}}" class="form-control product_vat" id="blood_group_slug" type="text">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">{{__('text.Model number')}}</label>
                                                <div class="col-sm-6">
                                                    <input readonly name="model_number" value="{{isset($my_product) ? $my_product->model_number : null}}" class="form-control" id="blood_group_slug" type="text">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">{{__('text.Size')}}</label>
                                                <div class="col-sm-6">
                                                    <input readonly name="size" value="{{isset($my_product) ? $my_product->size : null}}" class="form-control" id="blood_group_slug" type="text">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">Measure</label>
                                                <div class="col-sm-6">
                                                    <input readonly name="measure" value="{{isset($my_product) ? $my_product->measure : null}}" class="form-control" id="blood_group_slug" type="text">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">Estimated Price</label>
                                                <div class="col-sm-6">
                                                    <input readonly name="estimated_price" value="{{isset($my_product) ? $my_product->estimated_price : null}}" class="form-control" id="blood_group_slug" type="text">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">{{__('text.Additional info')}}</label>
                                                <div class="col-sm-6">
                                                    <input readonly name="additional_info" value="{{isset($my_product) ? $my_product->additional_info : null}}" class="form-control" id="blood_group_slug" type="text">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">Floor Type</label>
                                                <div class="col-sm-6">
                                                    <input readonly name="floor_type" value="{{isset($my_product) ? $my_product->floor_type : null}}" class="form-control" id="blood_group_slug" type="text">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">Floor Type 2</label>
                                                <div class="col-sm-6">
                                                    <input readonly name="floor_type2" value="{{isset($my_product) ? $my_product->floor_type2 : null}}" class="form-control" id="blood_group_slug" type="text">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">Supplier</label>
                                                <div class="col-sm-6">
                                                    <input readonly name="supplier" value="{{isset($my_product) ? $my_product->supplier : null}}" class="form-control" id="blood_group_slug" type="text">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">Color</label>
                                                <div class="col-sm-6">
                                                    <input readonly name="color" value="{{isset($my_product) ? $my_product->color : null}}" class="form-control" id="blood_group_slug" type="text">
                                                </div>
                                            </div>

                                            @if($my_product->size)

                                                <?php

                                                $sizes = explode(',', $my_product->size);

                                                $size_rates = explode(',',$my_product->size_rates);
                                                $size_sell_rates = explode(',',$my_product->size_sell_rates);

                                                ?>

                                                @foreach($sizes as $x => $key)

                                                    <div style="margin-bottom: 30px;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                                        <h3 style="text-align: center;">{{__('text.Size')}}: {{$key}}</h3>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Rate*</label>
                                                            <div class="col-sm-6">
                                                                <input maskedFormat="9,1" autocomplete="off" name="product_rate[]" step="any" value="{{isset($size_rates[$x]) ? number_format((float)$size_rates[$x], 2, ',', '.') : null}}" class="form-control product_rate" id="blood_group_slug" placeholder="Enter Product Rate" required="" type="text">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Sell Rate*</label>
                                                            <div class="col-sm-6">
                                                                <input maskedFormat="9,1" autocomplete="off" name="product_sell_rate[]" step="any" value="{{isset($size_rates[$x]) ? number_format((float)$size_sell_rates[$x], 2, ',', '.') : null}}" class="form-control product_sell_rate" id="blood_group_slug" placeholder="" required="" type="text">
                                                            </div>
                                                        </div>

                                                    </div>

                                                @endforeach

                                            @else

                                                <div class="form-group">
                                                    <label class="control-label col-sm-4" for="blood_group_slug">Rate*</label>
                                                    <div class="col-sm-6">
                                                        <input maskedFormat="9,1" autocomplete="off" name="product_rate[]" step="any" value="{{isset($my_product) ? number_format((float)$my_product->size_rates, 2, ',', '.') : null}}" class="form-control product_rate" id="blood_group_slug" placeholder="Enter Product Rate" required="" type="text">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <label class="control-label col-sm-4" for="blood_group_slug">Sell Rate*</label>
                                                    <div class="col-sm-6">
                                                        <input maskedFormat="9,1" autocomplete="off" name="product_sell_rate[]" step="any" value="{{isset($my_product) ? number_format((float)$my_product->size_sell_rates, 2, ',', '.') : null}}" class="form-control product_sell_rate" id="blood_group_slug" placeholder="" required="" type="text">
                                                    </div>
                                                </div>

                                            @endif


                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="current_photo">Current Photo</label>
                                                <div class="col-sm-6">
                                                    <img width="130px" height="90px" id="adminimg" src="{{isset($my_product->photo) ? asset('assets/images/'.$my_product->photo):'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG'}}" alt="">
                                                </div>
                                            </div>


                                        </div>

                                        <hr>

                                        <div class="add-product-footer">
                                            <button name="addProduct_btn" type="submit" class="btn add-product_btn">{{isset($my_product) ?  __('text.Edit Product') :  __('text.Add Product')}}</button>
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

    {{--<script type="text/javascript" src="{{asset('assets/admin/js/nicEdit.js')}}"></script>
    <script type="text/javascript">
        //<![CDATA[
        bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
        //]]>
    </script>--}}

    <script type="text/javascript">

        $(".js-data-example-ajax").select2({
            width: '100%',
            height: '200px',
            placeholder: "Select Product",
            allowClear: true,
            "language": {
                "noResults": function(){
                    return '{{__('text.No results found')}}';
                }
            },
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

        $('.js-data-example-ajax').on('change', function() {

            var product_id = $(this).val();

            $.ajax({
                type:"GET",
                data: "id=" + product_id ,
                url: "<?php echo url('/aanbieder/product-details')?>",
                success: function(data) {

                    $('.product_title').val(data.title);
                    $('.product_slug').val(data.slug);
                    $('.category_id').val(data.category_id);
                    $('.product_category').val(data.category);
                    $('.brand_id').val(data.brand_id);
                    $('.product_brand').val(data.brand);
                    $('.model_id').val(data.model_id);
                    $('.product_model').val(data.model);
                    $('.product_description').text(data.description);

                    if(data.photo)
                    {
                        $('#adminimg').attr("src","<?php echo asset('assets/images/'); ?>"+"/"+data.photo);
                    }
                    else
                    {
                        $('#adminimg').attr("src","https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG");
                    }

                    $('.product_details').show();

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
