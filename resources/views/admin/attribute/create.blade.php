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
                                        <h2>{{isset($attributes) ? 'Edit Attribute' : 'Add Attribute'}}</h2>
                                        <a href="{{route('admin-attribute-index')}}" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> Back</a>
                                    </div>

                                    <form class="form-horizontal" action="{{route('admin-attribute-store')}}" method="POST" enctype="multipart/form-data">
                                        @include('includes.form-error')
                                        @include('includes.form-success')

                                        {{csrf_field()}}

                                        <input type="hidden" name="attribute_id" value="{{isset($attributes) ? $attributes->id : null}}" />

                                        <div class="accordion-menu">

                                            <ul>
                                                <li>
                                                    <input type="checkbox">
                                                    <h2>General <i class="arrow"></i></h2>
                                                    <div class="accordion-content">

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_display_name">Attribute Title*</label>
                                                            <div class="col-sm-6">
                                                                <input value="{{isset($attributes) ? $attributes->title : null}}" class="form-control" name="title" id="blood_group_display_name" placeholder="Enter Attribute title" required="" type="text">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_display_name">Attribute Value*</label>
                                                            <div class="col-sm-6">
                                                                <input value="{{isset($attributes) ? $attributes->value : null}}" class="form-control" name="value" id="blood_group_display_name" placeholder="Enter Attribute value" required="" type="number">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">

                                                            <label class="control-label col-sm-4" for="blood_group_slug">Attribute Type*</label>

                                                            <div class="col-sm-6">

                                                                <select class="form-control" name="attribute_type" id="attribute_type" required>

                                                                    <option value="">Select Attribute Type</option>
                                                                    <option {{isset($attributes) ? ($attributes->type == 'Text' ? 'selected' : null) : null}} value="Text">Text</option>
                                                                    <option {{isset($attributes) ? ($attributes->type == 'Textarea' ? 'selected' : null) : null}} value="Textarea">Textarea</option>
                                                                    <option {{isset($attributes) ? ($attributes->type == 'Price' ? 'selected' : null) : null}} value="Price">Price</option>
                                                                    <option {{isset($attributes) ? ($attributes->type == 'Boolean' ? 'selected' : null) : null}} value="Boolean">Boolean</option>
                                                                    <option {{isset($attributes) ? ($attributes->type == 'Select' ? 'selected' : null) : null}} value="Select">Select</option>
                                                                    <option {{isset($attributes) ? ($attributes->type == 'Multiselect' ? 'selected' : null) : null}} value="Multiselect">Multiselect</option>
                                                                    <option {{isset($attributes) ? ($attributes->type == 'Checkbox' ? 'selected' : null) : null}} value="Checkbox">Checkbox</option>

                                                                </select>

                                                            </div>

                                                        </div>

                                                    </div>
                                                </li>

                                                <li>
                                                    <input type="checkbox">
                                                    <h2>Validations <i class="arrow"></i></h2>
                                                    <div class="accordion-content">

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Required</label>

                                                            <div class="col-sm-6">

                                                                <select class="form-control" name="attribute_required" id="attribute_required" required>

                                                                    <option {{isset($attributes) ? ($attributes->is_required == 0 ? 'selected' : null) : null}} value="0">No</option>
                                                                    <option {{isset($attributes) ? ($attributes->is_required == 1 ? 'selected' : null) : null}} value="1">Yes</option>

                                                                </select>

                                                            </div>

                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Unique</label>

                                                            <div class="col-sm-6">

                                                                <select class="form-control" name="attribute_unique" id="attribute_unique" required>

                                                                    <option {{isset($attributes) ? ($attributes->is_unique == 0 ? 'selected' : null) : null}} value="0">No</option>
                                                                    <option {{isset($attributes) ? ($attributes->is_unique == 1 ? 'selected' : null) : null}} value="1">Yes</option>

                                                                </select>

                                                            </div>

                                                        </div>

                                                    </div>
                                                </li>

                                                <li @if(!isset($attributes) || ($attributes->type != 'Select' && $attributes->type != 'Multiselect' && $attributes->type != 'Checkbox')) style="display: none;" @endif id="options-li">
                                                    <input type="checkbox">
                                                    <h2>Options <i class="arrow"></i></h2>
                                                    <div class="accordion-content">

                                                        <div class="table options-table">

                                                            <table style="margin: auto;">

                                                                <thead>
                                                                <tr>
                                                                    <th style="border-top-left-radius: 9px;">Title</th>
                                                                    <th>Position</th>
                                                                    <th style="width: 10%;border-top-right-radius: 9px;"></th>
                                                                </tr>
                                                                </thead>

                                                                <tbody>

                                                                @if(isset($options) && count($options) > 0)

                                                                @foreach($options as $key)

                                                                <tr>
                                                                    <td>
                                                                        <input value="{{$key->title}}" class="form-control" name="attribute_option_title[]" placeholder="" type="text">
                                                                    </td>
                                                                    <td>
                                                                        <input value="{{$key->position}}" class="form-control" name="attribute_option_position[]" placeholder="" type="number">
                                                                    </td>
                                                                    <td style="text-align: center;">
                                                                        <span id="next-row-span" class="tooltip1 add-row" style="cursor: pointer;font-size: 20px;">
                                                                            <i id="next-row-icon" class="fa fa-fw fa-plus"></i>
																		</span>

                                                                        <span id="next-row-span" class="tooltip1 remove-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;">
																			<i id="next-row-icon" class="fa fa-fw fa-trash-o"></i>
																		</span>
                                                                    </td>
                                                                </tr>

                                                                @endforeach

                                                                @else

                                                                <tr>
                                                                    <td>
                                                                        <input class="form-control" name="attribute_option_title[]" placeholder="" type="text">
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control" name="attribute_option_position[]" placeholder="" type="number">
                                                                    </td>
                                                                    <td style="text-align: center;">
                                                                        <span id="next-row-span" class="tooltip1 add-row" style="cursor: pointer;font-size: 20px;">
                                                                            <i id="next-row-icon" class="fa fa-fw fa-plus"></i>
																		</span>

                                                                        <span id="next-row-span" class="tooltip1 remove-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;">
																			<i id="next-row-icon" class="fa fa-fw fa-trash-o"></i>
																		</span>
                                                                    </td>
                                                                </tr>

                                                                @endif
                                                                
                                                                </tbody>

                                                            </table>

                                                        </div>

                                                    </div>
                                                </li>

                                                <li>
                                                    <input type="checkbox">
                                                    <h2>Configurations <i class="arrow"></i></h2>
                                                    <div class="accordion-content">

                                                        <div class="table sub-attributes-table">

                                                            <table style="margin: auto;">

                                                                <thead>
                                                                <tr>
                                                                    <th style="border-top-left-radius: 9px;">Sub Attribute Title</th>
                                                                    <th style="width: 10%;">Value</th>
                                                                    <th>Required</th>
                                                                    <th>Unique</th>
                                                                    <th>Price Impact</th>
                                                                    <th>Impact Type</th>
                                                                    <th>m¹ Impact</th>
                                                                    <th>m² Impact</th>
                                                                    <th style="border-top-right-radius: 9px;"></th>
                                                                </tr>
                                                                </thead>

                                                                <tbody>

                                                                @if(isset($sub_attributes) && count($sub_attributes) > 0)

                                                                @foreach($sub_attributes as $key1)

                                                                <tr>
                                                                    <td>
                                                                        <input value="{{$key1->title}}" class="form-control" name="sub_attribute_title[]" placeholder="" type="text">
                                                                    </td>
                                                                    <td>
                                                                        <input value="{{$key1->value}}" class="form-control" name="sub_attribute_value[]" placeholder="" type="number">
                                                                    </td>
                                                                    <td>
                                                                        <select class="form-control" name="sub_attribute_required[]">

                                                                            <option {{$key1->is_required == 0 ? 'selected' : null}} value="0">No</option>
                                                                            <option {{$key1->is_required == 1 ? 'selected' : null}} value="1">Yes</option>

                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select class="form-control" name="sub_attribute_unique[]">

                                                                            <option {{$key1->is_unique == 0 ? 'selected' : null}} value="0">No</option>
                                                                            <option {{$key1->is_unique == 1 ? 'selected' : null}} value="1">Yes</option>

                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select class="form-control" name="sub_attribute_price_impact[]">

                                                                            <option {{$key1->price_impact == 0 ? 'selected' : null}} value="0">No</option>
                                                                            <option {{$key1->price_impact == 1 ? 'selected' : null}} value="1">Yes</option>

                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select class="form-control" name="sub_attribute_impact_type[]">

                                                                            <option {{$key1->impact_type == 0 ? 'selected' : null}} value="0">€</option>
                                                                            <option {{$key1->impact_type == 1 ? 'selected' : null}} value="1">%</option>

                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select class="form-control" name="sub_attribute_m1_impact[]">

                                                                            <option {{$key1->m1_impact == 0 ? 'selected' : null}} value="0">No</option>
                                                                            <option {{$key1->m1_impact == 1 ? 'selected' : null}} value="1">Yes</option>

                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select class="form-control" name="sub_attribute_m2_impact[]">

                                                                            <option {{$key1->m2_impact == 0 ? 'selected' : null}} value="0">No</option>
                                                                            <option {{$key1->m2_impact == 1 ? 'selected' : null}} value="1">Yes</option>

                                                                        </select>
                                                                    </td>
                                                                    <td style="text-align: center;">
                                                                        <span id="next-row-span" class="tooltip1 add-row1" style="cursor: pointer;font-size: 20px;">
                                                                            <i id="next-row-icon" class="fa fa-fw fa-plus"></i>
																		</span>

                                                                        <span id="next-row-span" class="tooltip1 remove-row1" style="cursor: pointer;font-size: 20px;margin-left: 10px;">
																			<i id="next-row-icon" class="fa fa-fw fa-trash-o"></i>
																		</span>
                                                                    </td>
                                                                </tr>

                                                                @endforeach

                                                                @else

                                                                <tr>
                                                                    <td>
                                                                        <input class="form-control" name="sub_attribute_title[]" placeholder="" type="text">
                                                                    </td>
                                                                    <td>
                                                                        <input class="form-control" name="sub_attribute_value[]" placeholder="" type="number">
                                                                    </td>
                                                                    <td>
                                                                        <select class="form-control" name="sub_attribute_required[]">

                                                                            <option value="0">No</option>
                                                                            <option value="1">Yes</option>

                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select class="form-control" name="sub_attribute_unique[]">

                                                                            <option value="0">No</option>
                                                                            <option value="1">Yes</option>

                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select class="form-control" name="sub_attribute_price_impact[]">

                                                                            <option value="0">No</option>
                                                                            <option value="1">Yes</option>

                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select class="form-control" name="sub_attribute_impact_type[]">

                                                                            <option value="0">€</option>
                                                                            <option value="1">%</option>

                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select class="form-control" name="sub_attribute_m1_impact[]">

                                                                            <option value="0">No</option>
                                                                            <option value="1">Yes</option>

                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select class="form-control" name="sub_attribute_m2_impact[]">

                                                                            <option value="0">No</option>
                                                                            <option value="1">Yes</option>

                                                                        </select>
                                                                    </td>
                                                                    <td style="text-align: center;">
                                                                        <span id="next-row-span" class="tooltip1 add-row1" style="cursor: pointer;font-size: 20px;">
                                                                            <i id="next-row-icon" class="fa fa-fw fa-plus"></i>
																		</span>

                                                                        <span id="next-row-span" class="tooltip1 remove-row1" style="cursor: pointer;font-size: 20px;margin-left: 10px;">
																			<i id="next-row-icon" class="fa fa-fw fa-trash-o"></i>
																		</span>
                                                                    </td>
                                                                </tr>

                                                                @endif

                                                                </tbody>

                                                            </table>

                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Attribute Category*</label>

                                                            <div class="col-sm-6">

                                                                <select class="form-control" name="attribute_category" id="attribute_category" required>

                                                                    <option value="">Select Attribute Category</option>

                                                                    @foreach($cats as $cat)

                                                                        <option {{isset($attributes) ? ($attributes->category_id == $cat->id ? 'selected' : null) : null}} value="{{$cat->id}}">{{$cat->cat_name}}</option>

                                                                    @endforeach

                                                                </select>

                                                            </div>

                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Price Impact</label>

                                                            <div class="col-sm-6">

                                                                <select class="form-control" name="price_impact" id="price_impact" required>

                                                                    <option {{isset($attributes) ? ($attributes->price_impact == 0 ? 'selected' : null) : null}} value="0">No</option>
                                                                    <option {{isset($attributes) ? ($attributes->price_impact == 1 ? 'selected' : null) : null}} value="1">Yes</option>

                                                                </select>

                                                            </div>

                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Impact Type</label>

                                                            <div class="col-sm-6">

                                                                <select class="form-control" name="impact_type" id="impact_type" required>

                                                                    <option {{isset($attributes) ? ($attributes->impact_type == 0 ? 'selected' : null) : null}} value="0">€</option>
                                                                    <option {{isset($attributes) ? ($attributes->impact_type == 1 ? 'selected' : null) : null}} value="1">%</option>

                                                                </select>

                                                            </div>

                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">m¹ Impact</label>

                                                            <div class="col-sm-6">

                                                                <select class="form-control" name="m1_impact" id="m1_impact" required>

                                                                    <option {{isset($attributes) ? ($attributes->m1_impact == 0 ? 'selected' : null) : null}} value="0">No</option>
                                                                    <option {{isset($attributes) ? ($attributes->m1_impact == 1 ? 'selected' : null) : null}} value="1">Yes</option>

                                                                </select>

                                                            </div>

                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">m² Impact</label>

                                                            <div class="col-sm-6">

                                                                <select class="form-control" name="m2_impact" id="m2_impact" required>

                                                                    <option {{isset($attributes) ? ($attributes->m2_impact == 0 ? 'selected' : null) : null}} value="0">No</option>
                                                                    <option {{isset($attributes) ? ($attributes->m2_impact == 1 ? 'selected' : null) : null}} value="1">Yes</option>

                                                                </select>

                                                            </div>

                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Use for filter page</label>

                                                            <div class="col-sm-6">

                                                                <select class="form-control" name="attribute_filter" id="attribute_filter" required>

                                                                    <option {{isset($attributes) ? ($attributes->filter == 0 ? 'selected' : null) : null}} value="0">No</option>
                                                                    <option {{isset($attributes) ? ($attributes->filter == 1 ? 'selected' : null) : null}} value="1">Yes</option>

                                                                </select>

                                                            </div>

                                                        </div>

                                                    </div>
                                                </li>

                                            </ul>

                                        </div>

                                        <div style="margin-top: 20px;" class="add-product-footer">
                                            <button name="addProduct_btn" type="submit" class="btn add-product_btn">{{isset($attributes) ? 'Edit Attribute' : 'Add Attribute'}}</button>
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

<style>

.table{width: 100%;padding: 0 20px;}
.table table{border-collapse: inherit;text-align: left;width: 100%;border: 1px solid #d6d6d6;border-radius: 10px;}
.table table thead th{font-weight: 700;padding: 12px 10px;background: #f8f9fa;color: #3a3a3a;}
.table table tbody td{padding: 10px;border-bottom: 1px solid #d3d3d3;color: #3a3a3a;vertical-align: middle;}
.table table tbody tr:last-child td{ border-bottom: none; }

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
	max-height: 800px;
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

<?php if(!isset($attributes) || ($attributes->type != 'Select' && $attributes->type != 'Multiselect' && $attributes->type != 'Checkbox')) { ?> 
    .accordion-menu ul li:nth-of-type(1) { animation-delay: 0.5s; }
    .accordion-menu ul li:nth-of-type(2) { animation-delay: 0.75s; }
    .accordion-menu ul li:nth-of-type(4) { animation-delay: 1.0s; } <?php }else{ ?> 
    .accordion-menu ul li:nth-of-type(1) { animation-delay: 0.5s; }
    .accordion-menu ul li:nth-of-type(2) { animation-delay: 0.75s; }
    .accordion-menu ul li:nth-of-type(3) { animation-delay: 1.0s; }
    .accordion-menu ul li:nth-of-type(4) { animation-delay: 1.25s; } <?php } ?>

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

    $(document).on('change', '#attribute_type', function () {

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

        $(".options-table table tbody").append('<tr>\n' +
            '                                                                    <td>\n' +
            '                                                                        <input class="form-control" name="attribute_option_title[]" placeholder="" type="text">\n' +
            '                                                                    </td>\n' +
            '                                                                    <td>\n' +
            '                                                                        <input class="form-control" name="attribute_option_position[]" placeholder="" type="number">\n' +
            '                                                                    </td>\n' +
            '                                                                    <td style="text-align: center;">\n' +
            '                                                                        <span id="next-row-span" class="tooltip1 add-row" style="cursor: pointer;font-size: 20px;">\n' +
            '                                                                            <i id="next-row-icon" class="fa fa-fw fa-plus"></i>\n' +
            '                                                                        </span>\n' +
            '\n' +
            '                                                                        <span id="next-row-span" class="tooltip1 remove-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;">\n' +
            '                                                                            <i id="next-row-icon" class="fa fa-fw fa-trash-o"></i>\n' +
            '                                                                        </span>\n' +
            '                                                                    </td>\n' +
            '                                                                </tr>');

	});

    $(document).on('click', '.remove-row', function () {

        if ($(".options-table table tbody tr").length > 1) {

            $(this).parent().parent().remove();

        }

    });

    $(document).on('click', '.add-row1', function () {

        $(".sub-attributes-table table tbody").append('<tr>\n' +
            '                                                                    <td>\n' +
            '                                                                        <input class="form-control" name="sub_attribute_title[]" placeholder="" type="text">\n' +
            '                                                                    </td>\n' +
            '                                                                    <td>\n' +
            '                                                                        <input class="form-control" name="sub_attribute_value[]" placeholder="" type="number">\n' +
            '                                                                    </td>\n' +
            '                                                                    <td>\n' +
            '                                                                        <select class="form-control" name="sub_attribute_required[]">\n' +
            '\n' +
            '                                                                            <option value="0">No</option>\n' +
            '                                                                            <option value="1">Yes</option>\n' +
            '\n' +
            '                                                                        </select>\n' +
            '                                                                    </td>\n' +
            '                                                                    <td>\n' +
            '                                                                        <select class="form-control" name="sub_attribute_unique[]">\n' +
            '\n' +
            '                                                                            <option value="0">No</option>\n' +
            '                                                                            <option value="1">Yes</option>\n' +
            '\n' +
            '                                                                        </select>\n' +
            '                                                                    </td>\n' +
            '                                                                    <td>\n' +
            '                                                                        <select class="form-control" name="sub_attribute_price_impact[]">\n' +
            '\n' +
            '                                                                            <option value="0">No</option>\n' +
            '                                                                            <option value="1">Yes</option>\n' +
            '\n' +
            '                                                                        </select>\n' +
            '                                                                    </td>\n' +
            '                                                                    <td>\n' +
            '                                                                        <select class="form-control" name="sub_attribute_impact_type[]">\n' +
            '\n' +
            '                                                                            <option value="0">€</option>\n' +
            '                                                                            <option value="1">%</option>\n' +
            '\n' +
            '                                                                        </select>\n' +
            '                                                                    </td>\n' +
            '                                                                    <td>\n' +
            '                                                                        <select class="form-control" name="sub_attribute_m1_impact[]">\n' +
            '\n' +
            '                                                                            <option value="0">No</option>\n' +
            '                                                                            <option value="1">Yes</option>\n' +
            '\n' +
            '                                                                        </select>\n' +
            '                                                                    </td>\n' +
            '                                                                    <td>\n' +
            '                                                                        <select class="form-control" name="sub_attribute_m2_impact[]">\n' +
            '\n' +
            '                                                                            <option value="0">No</option>\n' +
            '                                                                            <option value="1">Yes</option>\n' +
            '\n' +
            '                                                                        </select>\n' +
            '                                                                    </td>\n' +
            '                                                                    <td style="text-align: center;">\n' +
            '                                                                        <span id="next-row-span" class="tooltip1 add-row1" style="cursor: pointer;font-size: 20px;">\n' +
            '                                                                            <i id="next-row-icon" class="fa fa-fw fa-plus"></i>\n' +
            '                                                                        </span>\n' +
            '\n' +
            '                                                                        <span id="next-row-span" class="tooltip1 remove-row1" style="cursor: pointer;font-size: 20px;margin-left: 10px;">\n' +
            '                                                                            <i id="next-row-icon" class="fa fa-fw fa-trash-o"></i>\n' +
            '                                                                        </span>\n' +
            '                                                                    </td>\n' +
            '                                                                </tr>');

	});

    $(document).on('click', '.remove-row1', function () {

        if ($(".sub-attributes-table table tbody tr").length > 1) {

            $(this).parent().parent().remove();

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


    <script>
            $('#cp1').colorpicker();
            $('#cp2').colorpicker();
    </script>

@endsection
