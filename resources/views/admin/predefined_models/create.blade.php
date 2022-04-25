@extends('layouts.handyman')

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
                                        <h2>{{isset($model) ? 'Edit Model' : 'Add Model'}}</h2>
                                        <a href="{{route('predefined-model-index')}}" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> Back</a>
                                    </div>

                                    <form class="form-horizontal" action="{{route('predefined-model-store')}}" method="POST" enctype="multipart/form-data">
                                        @include('includes.form-error')
                                        @include('includes.form-success')

                                        {{csrf_field()}}

                                        <input type="hidden" name="default_model" value="{{Route::currentRouteName() == 'predefined-model-edit' ? 0 : 1}}">
                                        <input type="hidden" id="heading_id" name="heading_id" value="{{isset($model) ? $model->id : null}}">

                                        <div class="accordion-menu">

                                            <ul>
                                                <li>
                                                    <input type="checkbox">
                                                    <h2>General <i class="arrow"></i></h2>
                                                    <div class="accordion-content">

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_display_name">Title* <span>(In Any Language)</span></label>
                                                            <div class="col-sm-6">
                                                                <input value="{{isset($model) ? $model->model : null}}" class="form-control" name="title" id="blood_group_display_name" placeholder="Enter Model Title" required="" type="text">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_display_name">Value</label>
                                                            <div class="col-sm-6">
                                                                <input type="text" value="{{isset($model) ? $model->value : null}}" placeholder="Model Value" class="form-control" name="value" id="blood_group_display_name">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_display_name">Measure</label>
                                                            <div class="col-sm-6">
                                                                <select class="form-control" name="measure" id="blood_group_display_name">

                                                                    <option {{isset($model) ? ($model->measure == 'M1' ? 'selected' : null) : null}} value="M1">M1</option>
                                                                    <option {{isset($model) ? ($model->measure == 'M2' ? 'selected' : null) : null}} value="M2">M2</option>
                                                                    <option {{isset($model) ? ($model->measure == 'Custom Sized' ? 'selected' : null) : null}} value="Custom Sized">Custom Sized</option>
                                                                    <option {{isset($model) ? ($model->measure == 'Per Piece' ? 'selected' : null) : null}} value="Per Piece">Per Piece</option>

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Model Category*</label>

                                                            <div class="col-sm-6">

                                                                <?php if(isset($model)) $category_ids = explode(',',$model->category_ids); ?>

                                                                <select style="height: 100px;" class="form-control" name="model_category[]" id="model_category" required multiple>

                                                                    @foreach($cats as $cat)

                                                                        <option {{isset($model) ? (in_array($cat->id, $category_ids) ? 'selected' : null) : null}} value="{{$cat->id}}">{{$cat->cat_name}}</option>

                                                                    @endforeach

                                                                </select>

                                                            </div>

                                                        </div>

                                                    </div>
                                                </li>

                                                <li>
                                                    <input type="checkbox">
                                                    <h2>Price Impact <i class="arrow"></i></h2>
                                                    <div class="accordion-content">

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Price Impact</label>

                                                            <div class="col-sm-6">

                                                                <select class="form-control" name="price_impact" id="price_impact">

                                                                    <option {{isset($model) ? ($model->price_impact == 0 ? 'selected' : null) : null}} value="0">No</option>
                                                                    <option {{isset($model) ? ($model->price_impact == 1 ? 'selected' : null) : null}} value="1">Fixed</option>
                                                                    <option {{isset($model) ? ($model->m1_impact == 1 ? 'selected' : null) : null}} value="2">m¹ Impact</option>
                                                                    <option {{isset($model) ? ($model->m2_impact == 1 ? 'selected' : null) : null}} value="3">m² Impact</option>

                                                                </select>

                                                            </div>

                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Impact Type</label>

                                                            <div class="col-sm-6">

                                                                <select class="form-control" name="impact_type" id="impact_type">

                                                                    <option {{isset($model) ? ($model->impact_type == 0 ? 'selected' : null) : null}} value="0">€</option>
                                                                    <option {{isset($model) ? ($model->impact_type == 1 ? 'selected' : null) : null}} value="1">%</option>

                                                                </select>

                                                            </div>

                                                        </div>

                                                    </div>
                                                </li>

                                            </ul>

                                        </div>

                                        <div style="margin-top: 20px;" class="add-product-footer">
                                            <button name="addProduct_btn" type="submit" class="btn add-product_btn">{{isset($model) ? 'Edit Model' : 'Add Model'}}</button>
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


    <?php if(!isset($feature) || ($feature->type != 'Select' && $feature->type != 'Multiselect' && $feature->type != 'Checkbox')) { ?>

    <style>
        .accordion-menu ul li:nth-of-type(1) { animation-delay: 0s; }
        .accordion-menu ul li:nth-of-type(2) { animation-delay: 0.25s; }
        .accordion-menu ul li:nth-of-type(4) { animation-delay: 0.5s; }
    </style>

    <?php }else{ ?>

    <style>
        .accordion-menu ul li:nth-of-type(1) { animation-delay: 0.25s; }
        .accordion-menu ul li:nth-of-type(2) { animation-delay: 0.55s; }
        .accordion-menu ul li:nth-of-type(3) { animation-delay: 0.75s; }
        .accordion-menu ul li:nth-of-type(4) { animation-delay: 1.0s; }
    </style>

    <?php } ?>

<style>

.table{width: 100%;padding: 0 20px;}
.table table{border-collapse: inherit;text-align: left;width: 100%;border: 1px solid #d6d6d6;border-radius: 10px;}
.table table thead th{font-weight: 700;padding: 12px 10px;background: #f8f9fa;color: #3a3a3a;}
.table table tbody td{padding: 10px;border-bottom: 1px solid #d3d3d3;color: #3a3a3a;vertical-align: middle;}
.table table tbody tr:last-child td{ border-bottom: none; }

.table1 table{ border-collapse: separate; }
.table1 th, .table1 td{ padding: 10px;border: 1px solid #c2c2c2; }
.table1 td{ border-top: 0; }

.accordion-menu h2 {
	font-size: 18px;
	line-height: 34px;
	font-weight: 500;
	letter-spacing: 1px;
	margin: 0;
    cursor: pointer;
    color: black;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #fbfbfb;
    padding: 15px;
    border-top: 1px solid #dadada;
}
.accordion-menu .accordion-content {
	color: rgba(48, 69, 92, 0.8);
	font-size: 15px;
	line-height: 26px;
	letter-spacing: 1px;
	position: relative;
	overflow: hidden;
	max-height: 10000px;
	opacity: 1;
	transform: translate(0, 0);
	margin: 20px 0;
	z-index: 2;
}
.accordion-menu ul {
	list-style: none;
	perspective: 900;
	padding: 0;
    margin: 0;
    background-color: #fff;
	border-radius: 0;
	/*box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.2),
	0 2px 2px 0 rgba(255, 255, 255, 0.19);*/
}
.accordion-menu ul li {
	position: relative;
	padding: 0;
	margin: 0;
}

.accordion-menu ul li input[type=checkbox]:not(:checked) ~ h2 { border-bottom: 1px solid #dadada; }

.accordion-menu ul li:last-of-type { padding-bottom: 0; }
.accordion-menu ul li:last-of-type h2{ border-bottom: 1px solid #dadada; }

.accordion-menu ul li .fas{
	color:#f6483b;
	font-size: 15px;
	margin-right: 10px;
}

.accordion-menu ul li .arrow:before, ul li .arrow:after {
	content: "";
	position: absolute;
	background-color: #f6483b;
	width: 3px;
	height: 9px;
}

.accordion-menu ul li h2 .arrow:before {
	transform: translate(-20px, 0) rotate(45deg);
}

.accordion-menu ul li h2 .arrow:after {
	transform: translate(-15.8px, 0) rotate(-45deg);
}

.accordion-menu ul li input[type=checkbox] {
	position: absolute;
	cursor: pointer;
	width: 100%;
	height: 100%;
    z-index: 1;
    opacity: 0;
}

.accordion-menu ul li input[type=checkbox]:checked ~ .accordion-content {
	max-height: 0;
	opacity: 0;
	transform: translate(0, 50%);
    margin: 0;
}

.accordion-menu ul li input[type=checkbox]:checked ~ h2 .arrow:before {
	transform: translate(-16px, 0) rotate(45deg);
}

.accordion-menu ul li input[type=checkbox]:checked ~ h2 .arrow:after {
	transform: translate(-20px, 0) rotate(-45deg);
}

.transition, .accordion-menu .accordion-content, .accordion-menu ul li h2 .arrow:before, .accordion-menu ul li h2 .arrow:after {
	transition: all 0.25s ease-in-out;
}

.flipIn, h1, .accordion-menu ul li {
	animation: flipdown 0.5s ease both;
}

.no-select, .accordion-menu h2 {
	-webkit-tap-highlight-color: transparent;
	-webkit-touch-callout: none;
	user-select: none;
}
@keyframes flipdown {
	0% {
		opacity: 0;
		transform-origin: top center;
		transform: rotateX(-90deg);
	}

	5% { opacity: 1; }

	80% { transform: rotateX(8deg); }

	83% { transform: rotateX(6deg); }

	92% { transform: rotateX(-3deg); }

	100% {
		transform-origin: top center;
		transform: rotateX(0deg);
	}
}

</style>

@endsection

@section('scripts')

    <script type="text/javascript" src="{{asset('assets/admin/js/nicEdit.js')}}"></script>
    <script type="text/javascript">
        //<![CDATA[
        bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
        //]]>
    </script>

<script type="text/javascript">

    function fetch_sub_categories()
    {
        var id = $("#feature_category").val();

        $.ajax({

            type:"GET",
            data: "id=" + id + "&type=multiple",
            url: "<?php echo url('/aanbieder/product/get-sub-categories-by-category')?>",
            success: function(data) {

                if(data.length == 0)
                {
                    $('#sub-categories').find(".sub-category-table-container").find("table tbody tr").remove();
                }
                else{

                    var a = [];

                    $.each(data, function(index, value) {

                        $('#sub-categories').find(".sub-category-table-container").each(function() {

                            var row_id = $(this).data('id');
                            a.push(value.id);

                            if($(this).find("table tbody tr[data-id='" + value.id + "']").length == 0)
                            {
                                $(this).find("table tbody").append('<tr data-id="'+value.id+'">\n' +
                                    '                                                                                           <td>'+value.main_category.cat_name+'</td>\n' +
                                    '                                                                                           <td>'+value.cat_name+'</td>\n' +
                                    '                                                                                           <td>\n' +
                                    '                                                                                               <input type="hidden" name="sub_category_id'+row_id+'[]" value="'+value.id+'">\n' +
                                    '                                                                                               <select class="form-control" name="sub_category_link'+row_id+'[]">\n' +
                                    '\n' +
                                    '                                                                                                   <option value="0">No</option>\n' +
                                    '                                                                                                   <option selected value="1">Yes</option>\n' +
                                    '\n' +
                                    '                                                                                               </select>\n' +
                                    '                                                                                           </td>\n' +
                                    '                                                                                       </tr>');
                            }

                        });

                    });

                    $('#sub-categories').find(".sub-category-table-container").each(function() {

                        $(this).find("table tbody tr").each(function() {

                            if($.inArray($(this).data('id'), a) == -1)
                            {
                                $(this).remove();
                            }

                        });

                    });

                }

            }
        });
    }

    $("#feature_category").change(function(event) {

        fetch_sub_categories();

    });

    $('body').on('click', '.create-sub-feature-btn' ,function(){

        var id = $(this).data('id');
        $('#sub-features').children().not(".sub-feature-table-container[data-id='" + id + "']").hide();
        $('#sub-features').find(".sub-feature-table-container[data-id='" + id + "']").show();

        $('#myModal2').modal('toggle');
        $('.modal-backdrop').hide();

    });

    $('body').on('click', '.sub-category-row' ,function(){

        var id = $(this).data('id');
        $('#sub-categories').children().not(".sub-category-table-container[data-id='" + id + "']").hide();
        $('#sub-categories').find(".sub-category-table-container[data-id='" + id + "']").show();

        $('#myModal3').modal('toggle');
        $('.modal-backdrop').hide();

    });

    $(document).on('click', "#add-sub-feature-btn", function(e){

        var id = $(this).data('id');
        var feature_row = null;

        $('#sub-features').find(".sub-feature-table-container").each(function() {

            $(this).find('table tbody tr').each(function() {

                var value = parseInt($(this).find('.f_row1').val());
                feature_row = (value > feature_row) ? value : feature_row;

            });
        });

        feature_row = feature_row + 1;

        $('#sub-features').find(".sub-feature-table-container[data-id='" + id + "']").find('table').append('<tr data-id="'+feature_row+'">\n' +
            '                                                                                        <td>\n' +
            '                                                                                            <input type="hidden" name="f_rows'+id+'[]" class="f_row1" value="'+feature_row+'">' +
            '                                                                                            <input type="hidden" name="feature_row_ids'+id+'[]">' +
            '                                                                                            <input class="form-control feature_title1" name="features'+id+'[]" id="blood_group_slug" placeholder="Feature Title" type="text">\n' +
            '                                                                                        </td>\n' +
            '                                                                                        <td>\n' +
            '                                                                                            <input class="form-control feature_value1" name="feature_values'+id+'[]" id="blood_group_slug" placeholder="Value" type="text">\n' +
            '                                                                                        </td>\n' +
            '                                                                                        <td>\n' +
            '                                                                                            <select class="form-control" name="price_impact'+id+'[]">\n' +
            '\n' +
            '                                                                                                <option value="0">No</option>\n' +
            '                                                                                                <option value="1">Fixed</option>\n' +
            '                                                                                                <option value="2">m¹ Impact</option>\n' +
            '\n' +
            '                                                                                            </select>\n' +
            '                                                                                        </td>\n' +
            '                                                                                        <td>\n' +
            '                                                                                            <select class="form-control" name="impact_type'+id+'[]">\n' +
            '\n' +
            '                                                                                                <option value="0">€</option>\n' +
            '                                                                                                <option value="1">%</option>\n' +
            '\n' +
            '                                                                                            </select>\n' +
            '                                                                                        </td>\n' +
            '                                                                                        <td>\n' +
            '                                                                                            <div style="display: flex;justify-content: center;"><span class="ui-close remove-sub-feature" data-id="" style="margin:0;position: relative;left: 0;right: 0;top: 0;">X</span></div>\n' +
            '                                                                                        </td>\n' +
            '                                                                                    </tr>');

    });

    $('body').on('click', '.remove-sub-feature' ,function() {

        var heading_id = $(this).parents('.sub-feature-table-container').data('id');
        var f_row = null;

        $('#sub-features').find(".sub-feature-table-container").each(function() {

            $(this).find('table tbody tr').each(function() {

                var value = parseInt($(this).find('.f_row1').val());
                f_row = (value > f_row) ? value : f_row;

            });
        });

        f_row = f_row + 1;

        $(this).parents('tr').remove();

        if($('#sub-features').find(".sub-feature-table-container[data-id='" + heading_id + "']").find("table tbody tr").length == 0)
        {

            $('#sub-features').find(".sub-feature-table-container[data-id='" + heading_id + "']").find('table').append('<tr data-id="'+f_row+'">\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <input type="hidden" name="f_rows'+heading_id+'[]" class="f_row1" value="'+f_row+'">' +
                '                                                                                            <input type="hidden" name="feature_row_ids'+heading_id+'[]">' +
                '                                                                                            <input class="form-control feature_title1" name="features'+heading_id+'[]" id="blood_group_slug" placeholder="Feature Title" type="text">\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <input class="form-control feature_value1" name="feature_values'+heading_id+'[]" id="blood_group_slug" placeholder="Value" type="text">\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <select class="form-control" name="price_impact'+heading_id+'[]">\n' +
                '\n' +
                '                                                                                                <option value="0">No</option>\n' +
                '                                                                                                <option value="1">Fixed</option>\n' +
                '                                                                                                <option value="2">m¹ Impact</option>\n' +
                '\n' +
                '                                                                                            </select>\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <select class="form-control" name="impact_type'+heading_id+'[]">\n' +
                '\n' +
                '                                                                                                <option value="0">€</option>\n' +
                '                                                                                                <option value="1">%</option>\n' +
                '\n' +
                '                                                                                            </select>\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <div style="display: flex;justify-content: center;"><span class="ui-close remove-sub-feature" data-id="" style="margin:0;position: relative;left: 0;right: 0;top: 0;">X</span></div>\n' +
                '                                                                                        </td>\n' +
                '                                                                                    </tr>');

        }

    });

    $(document).on('change', '#feature_type', function () {

        var value = $(this).val();
        $('.accordion-menu ul li').css('animation-delay','0s');

        if(value == 'Select' || value == 'Multiselect' || value == 'Checkbox')
        {
            $('#options-li').show();
        }
        else
        {
            $('#options-li').hide();
        }

    });

    $(document).on('click', '.add-row', function () {

        var feature_row = $('.options-table table tbody tr:last').data('id');
        feature_row = feature_row + 1;

        $(".options-table table tbody").append('<tr data-id="'+feature_row+'">\n' +
            '                                                                                        <td>\n' +
            '                                                                                            <input type="hidden" name="f_rows[]" class="f_row" value="'+feature_row+'">' +
            '                                                                                            <input type="hidden" name="feature_ids[]">' +
            '                                                                                            <input class="form-control feature_title" name="features[]" id="blood_group_slug" placeholder="Feature Title" type="text">\n' +
            '                                                                                        </td>\n' +
            '                                                                                        <td>\n' +
            '                                                                                            <input class="form-control feature_value" name="feature_values[]" id="blood_group_slug" placeholder="Value" type="text">\n' +
            '                                                                                        </td>\n' +
            '                                                                                        <td>\n' +
            '                                                                                            <button data-id="'+feature_row+'" class="btn btn-success create-sub-feature-btn" type="button">Create/Edit Sub Features</button>\n' +
            '                                                                                        </td>\n' +
            '                                                                                        <td>\n' +
            '\n' +
            '                                                                                            <select class="form-control" name="price_impact[]">\n' +
            '\n' +
            '                                                                                                <option value="0">No</option>\n' +
            '                                                                                                <option value="1">Fixed</option>\n' +
            '                                                                                                <option value="2">m¹ Impact</option>\n' +
            '\n' +
            '                                                                                            </select>\n' +
            '\n' +
            '                                                                                        </td>\n' +
            '                                                                                        <td>\n' +
            '\n' +
            '                                                                                            <select class="form-control" name="impact_type[]">\n' +
            '\n' +
            '                                                                                                <option value="0">€</option>\n' +
            '                                                                                                <option value="1">%</option>\n' +
            '\n' +
            '                                                                                            </select>\n' +
            '\n' +
            '                                                                                        </td>\n' +
            '                                                                                        <td style="text-align: center;">\n' +
            '\n' +
            '                                                                                           <span id="next-row-span" class="tooltip1 sub-category-row" data-id="'+feature_row+'" style="cursor: pointer;font-size: 20px;">\n' +
            '                                                                                               <i id="next-row-icon" class="fa fa-fw fa-shield"></i>\n' +
            '                                                                                           </span>\n' +
            '\n' +
            '                                                                                           <span id="next-row-span" class="tooltip1 add-row" style="cursor: pointer;font-size: 20px;">\n' +
            '                                                                                               <i id="next-row-icon" class="fa fa-fw fa-plus"></i>\n' +
            '                                                                                           </span>\n' +
            '\n' +
            '                                                                                           <span data-id="" id="next-row-span" class="tooltip1 remove-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;">\n' +
            '                                                                                               <i id="next-row-icon" class="fa fa-fw fa-trash-o"></i>\n' +
            '                                                                                           </span>\n' +
            '                                                                                        </td>\n' +
            '                                                                </tr>');

        var feature_row1 = null;

        $('#sub-features').find(".sub-feature-table-container").each(function() {

            $(this).find('table tbody tr').each(function() {

                var value = parseInt($(this).find('.f_row1').val());
                feature_row1 = (value > feature_row1) ? value : feature_row1;

            });
        });

        feature_row1 = feature_row1 + 1;

        $('#sub-features').append('<div data-id="'+feature_row+'" class="sub-feature-table-container table">\n' +
            '\n' +
            '                                                                                        <table style="margin: auto;width: 95%;border-collapse: separate;">\n' +
            '                                                                                            <thead>\n' +
            '                                                                                            <tr>\n' +
            '                                                                                                <th style="border-top-left-radius: 9px;">Feature</th>\n' +
            '                                                                                                <th>Value</th>\n' +
            '                                                                                                <th>Price Impact</th>\n' +
            '                                                                                                <th>Impact Type</th>\n' +
            '                                                                                                <th style="border-top-right-radius: 9px;">Remove</th>\n' +
            '                                                                                            </tr>\n' +
            '                                                                                            </thead>\n' +
            '\n' +
            '                                                                                            <tbody>' +
            '                                                                                        <tr data-id="'+feature_row1+'">\n' +
            '                                                                                        <td>\n' +
            '                                                                                            <input type="hidden" name="f_rows'+feature_row+'[]" class="f_row1" value="'+feature_row1+'">' +
            '                                                                                            <input type="hidden" name="feature_row_ids'+feature_row+'[]">' +
            '                                                                                            <input class="form-control feature_title1" name="features'+feature_row+'[]" id="blood_group_slug" placeholder="Feature Title" type="text">\n' +
            '                                                                                        </td>\n' +
            '                                                                                        <td>\n' +
            '                                                                                            <input class="form-control feature_value1" name="feature_values'+feature_row+'[]" id="blood_group_slug" placeholder="Value" type="text">\n' +
            '                                                                                        </td>\n' +
            '                                                                                        <td>\n' +
            '                                                                                            <select class="form-control" name="price_impact'+feature_row+'[]">\n' +
            '\n' +
            '                                                                                                <option value="0">No</option>\n' +
            '                                                                                                <option value="1">Fixed</option>\n' +
            '                                                                                                <option value="2">m¹ Impact</option>\n' +
            '\n' +
            '                                                                                            </select>\n' +
            '                                                                                        </td>\n' +
            '                                                                                        <td>\n' +
            '                                                                                            <select class="form-control" name="impact_type'+feature_row+'[]">\n' +
            '\n' +
            '                                                                                                <option value="0">€</option>\n' +
            '                                                                                                <option value="1">%</option>\n' +
            '\n' +
            '                                                                                            </select>\n' +
            '                                                                                        </td>\n' +
            '                                                                                        <td>\n' +
            '                                                                                            <div style="display: flex;justify-content: center;"><span class="ui-close remove-sub-feature" data-id="" style="margin:0;position: relative;left: 0;right: 0;top: 0;">X</span></div>\n' +
            '                                                                                        </td>\n' +
            '                                                                                    </tr></tbody></table>' +
            '                                                                                        <div style="margin-top: 20px;" class="col-sm-12 text-center">\n' +
            '                                                                                            <button data-id="'+feature_row+'" class="btn btn-default featured-btn" type="button" id="add-sub-feature-btn"><i class="fa fa-plus"></i> Add More Sub Features</button>\n' +
            '                                                                                        </div></div>');

        $('#sub-categories').append('<div data-id="'+feature_row+'" class="sub-category-table-container table1">\n' +
            '\n' +
            '                                                                                        <table style="margin: auto;width: 95%;">\n' +
            '                                                                                            <thead>\n' +
            '                                                                                            <tr>\n' +
            '                                                                                                <th>Main Category</th>\n' +
            '                                                                                                <th>Sub Category</th>\n' +
            '                                                                                                <th>Linked</th>\n' +
            '                                                                                            </tr>\n' +
            '                                                                                            </thead>\n' +
            '\n' +
            '                                                                                            <tbody>' +
            '                                                                                    </tbody></table>\n' +
            '                                                                                        </div>');

            fetch_sub_categories();

	});

    $(document).on('click', '.remove-row', function () {

        if ($(".options-table table tbody tr").length > 1) {

            $(this).parent().parent().remove();

        }

        var row_id = $(this).parents('tr').data('id');
        var f_row = 1;

        $(this).parents('tr').remove();
        $('#sub-features').find(".sub-feature-table-container[data-id='" + row_id + "']").remove();
        $('#sub-categories').find(".sub-category-table-container[data-id='" + row_id + "']").remove();

        if($('.options-table').find("table tbody tr").length == 0)
        {

            $('.options-table').find("table").append('<tr data-id="'+f_row+'">\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <input type="hidden" name="f_rows[]" class="f_row" value="'+f_row+'">' +
                '                                                                                            <input type="hidden" name="feature_ids[]">' +
                '                                                                                            <input class="form-control feature_title" name="features[]" id="blood_group_slug" placeholder="Feature Title" type="text">\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <input class="form-control feature_value" name="feature_values[]" id="blood_group_slug" placeholder="Value" type="text">\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <button data-id="'+f_row+'" class="btn btn-success create-sub-feature-btn" type="button">Create/Edit Sub Features</button>\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '\n' +
                '                                                                                            <select class="form-control" name="price_impact[]">\n' +
                '\n' +
                '                                                                                                <option value="0">No</option>\n' +
                '                                                                                                <option value="1">Fixed</option>\n' +
                '                                                                                                <option value="2">m¹ Impact</option>\n' +
                '\n' +
                '                                                                                            </select>\n' +
                '\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '\n' +
                '                                                                                            <select class="form-control" name="impact_type[]">\n' +
                '\n' +
                '                                                                                                <option value="0">€</option>\n' +
                '                                                                                                <option value="1">%</option>\n' +
                '\n' +
                '                                                                                            </select>\n' +
                '\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td style="text-align: center;">\n' +
                '\n' +
                '                                                                                           <span data-id="'+f_row+'" id="next-row-span" class="tooltip1 sub-category-row" style="cursor: pointer;font-size: 20px;">\n' +
                '                                                                                               <i id="next-row-icon" class="fa fa-fw fa-shield"></i>\n' +
                '                                                                                           </span>\n' +
                '\n' +
                '                                                                                           <span id="next-row-span" class="tooltip1 add-row" style="cursor: pointer;font-size: 20px;">\n' +
                '                                                                                               <i id="next-row-icon" class="fa fa-fw fa-plus"></i>\n' +
                '                                                                                           </span>\n' +
                '\n' +
                '                                                                                           <span data-id="" id="next-row-span" class="tooltip1 remove-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;">\n' +
                '                                                                                               <i id="next-row-icon" class="fa fa-fw fa-trash-o"></i>\n' +
                '                                                                                           </span>\n' +
                '\n' +
                '                                                                                        </td>\n' +
                '                                                                                    </tr>');

            var f_row1 = null;

            $('#sub-features').find(".sub-feature-table-container").each(function() {

                $(this).find('table tbody tr').each(function() {

                    var value = parseInt($(this).find('.f_row1').val());
                    f_row1 = (value > f_row1) ? value : f_row1;

                });
            });

            f_row1 = f_row1 + 1;

            $('#sub-features').append('<div data-id="'+f_row+'" class="sub-feature-table-container table">\n' +
                '\n' +
                '                                                                                        <table style="margin: auto;width: 95%;border-collapse: separate;">\n' +
                '                                                                                            <thead>\n' +
                '                                                                                            <tr>\n' +
                '                                                                                                <th style="border-top-left-radius: 9px;">Feature</th>\n' +
                '                                                                                                <th>Value</th>\n' +
                '                                                                                                <th>Price Impact</th>\n' +
                '                                                                                                <th>Impact Type</th>\n' +
                '                                                                                                <th style="border-top-right-radius: 9px;">Remove</th>\n' +
                '                                                                                            </tr>\n' +
                '                                                                                            </thead>\n' +
                '\n' +
                '                                                                                            <tbody>' +
                '                                                                                        <tr data-id="'+f_row1+'">\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <input type="hidden" name="f_rows'+f_row+'[]" class="f_row1" value="'+f_row1+'">' +
                '                                                                                            <input type="hidden" name="feature_row_ids'+f_row+'[]">' +
                '                                                                                            <input class="form-control feature_title1" name="features'+f_row+'[]" id="blood_group_slug" placeholder="Feature Title" type="text">\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <input class="form-control feature_value1" name="feature_values'+f_row+'[]" id="blood_group_slug" placeholder="Value" type="text">\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <select class="form-control" name="price_impact'+f_row+'[]">\n' +
                '\n' +
                '                                                                                                <option value="0">No</option>\n' +
                '                                                                                                <option value="1">Fixed</option>\n' +
                '                                                                                                <option value="2">m¹ Impact</option>\n' +
                '\n' +
                '                                                                                            </select>\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <select class="form-control" name="impact_type'+f_row+'[]">\n' +
                '\n' +
                '                                                                                                <option value="0">€</option>\n' +
                '                                                                                                <option value="1">%</option>\n' +
                '\n' +
                '                                                                                            </select>\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <div style="display: flex;justify-content: center;"><span class="ui-close remove-sub-feature" data-id="" style="margin:0;position: relative;left: 0;right: 0;top: 0;">X</span></div>\n' +
                '                                                                                        </td>\n' +
                '                                                                                    </tr></tbody></table>' +
                '                                                                                        <div style="margin-top: 20px;" class="col-sm-12 text-center">\n' +
                '                                                                                            <button data-id="'+f_row+'" class="btn btn-default featured-btn" type="button" id="add-sub-feature-btn"><i class="fa fa-plus"></i> Add More Sub Features</button>\n' +
                '                                                                                        </div></div>');

            $('#sub-categories').append('<div data-id="'+f_row+'" class="sub-category-table-container table1">\n' +
                '\n' +
                '                                                                                        <table style="margin: auto;width: 95%;">\n' +
                '                                                                                            <thead>\n' +
                '                                                                                            <tr>\n' +
                '                                                                                                <th>Main Category</th>\n' +
                '                                                                                                <th>Sub Category</th>\n' +
                '                                                                                                <th>Linked</th>\n' +
                '                                                                                            </tr>\n' +
                '                                                                                            </thead>\n' +
                '\n' +
                '                                                                                            <tbody>' +
                '                                                                                    </tbody></table>\n' +
                '                                                                                        </div>');

            fetch_sub_categories();

        }

    });

    $(document).on('keypress', ".quote_order_no", function(e){

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
            e.preventDefault();
            return false;
        }

    });

  function uploadclick()
  {

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
