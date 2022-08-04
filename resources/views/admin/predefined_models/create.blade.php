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
                                        <a href="{{route('predefined-model-index')}}" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> {{__('text.Back')}}</a>
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
                                                    <h2>Sizes <i class="arrow"></i></h2>
                                                    <div class="accordion-content">

                                                        <div class="table options-table">

                                                            <table style="margin: auto;">

                                                                <thead>
                                                                <tr>
                                                                    <th style="border-top-left-radius: 9px;">Title</th>
                                                                    <th>Value</th>
                                                                    <th style="width: 10%;">Measure</th>
                                                                    <th>Price Impact</th>
                                                                    <th>Impact Type</th>
                                                                    <th style="width: 12%;border-top-right-radius: 9px;"></th>
                                                                </tr>
                                                                </thead>

                                                                <tbody>

                                                                @if(isset($models_data) && count($models_data) > 0)

                                                                    @foreach($models_data as $f1 => $key1)

                                                                        <tr data-id="{{$f1+1}}">
                                                                            <td>
                                                                                <input value="{{$key1->id}}" type="hidden" name="size_ids[]">
                                                                                <input value="{{$key1->model}}" class="form-control size_title" name="sizes[]" id="blood_group_slug" placeholder="Size Title" type="text">
                                                                            </td>
                                                                            <td>
                                                                                <input value="{{$key1->value}}" class="form-control size_value" name="size_values[]" id="blood_group_slug" placeholder="Value" type="text">
                                                                            </td>
                                                                            <td>
                                                                                <select class="form-control" name="size_measure[]">

                                                                                    <option {{$key1->measure == 'M1' ? 'selected' : null}} value="M1">M1</option>
                                                                                    <option {{$key1->measure == 'M2' ? 'selected' : null}} value="M2">M2</option>
                                                                                    <option {{$key1->measure == 'Custom Sized' ? 'selected' : null}} value="Custom Sized">Custom Sized</option>
                                                                                    <option {{$key1->measure == 'Per Piece' ? 'selected' : null}} value="Per Piece">Per Piece</option>

                                                                                </select>
                                                                            </td>
                                                                            <td>
                                                                                <select class="form-control" name="price_impact[]">

                                                                                    <option {{$key1->price_impact == 0 ? 'selected' : null}} value="0">No</option>
                                                                                    <option {{$key1->price_impact == 1 ? 'selected' : null}} value="1">Fixed</option>
                                                                                    <option {{$key1->m1_impact == 1 ? 'selected' : null}} value="2">m¹ Impact</option>
                                                                                    <option {{$key1->m2_impact == 1 ? 'selected' : null}} value="3">m² Impact</option>

                                                                                </select>
                                                                            </td>
                                                                            <td>
                                                                                <select class="form-control" name="impact_type[]">

                                                                                    <option {{$key1->impact_type == 0 ? 'selected' : null}} value="0">€</option>
                                                                                    <option {{$key1->impact_type == 1 ? 'selected' : null}} value="1">%</option>

                                                                                </select>
                                                                            </td>
                                                                            <td style="text-align: center;">

                                                                                <span id="next-row-span" class="tooltip1 add-row" data-id="" style="cursor: pointer;font-size: 20px;">
                                                                                    <i id="next-row-icon" class="fa fa-fw fa-plus"></i>
                                                                                </span>

                                                                                <span data-id="{{$key1->id}}" id="next-row-span" class="tooltip1 remove-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;">
                                                                                    <i id="next-row-icon" class="fa fa-fw fa-trash-o"></i>
                                                                                </span>

                                                                            </td>
                                                                        </tr>

                                                                    @endforeach

                                                                @else

                                                                    <tr data-id="1">
                                                                        <td>
                                                                            <input type="hidden" name="size_ids[]">
                                                                            <input class="form-control size_title" name="sizes[]" id="blood_group_slug" placeholder="Size Title" type="text">
                                                                        </td>
                                                                        <td>
                                                                            <input class="form-control size_value" name="size_values[]" id="blood_group_slug" placeholder="Value" type="text">
                                                                        </td>
                                                                        <td>
                                                                            <select class="form-control" name="size_measure[]">

                                                                                <option value="M1">M1</option>
                                                                                <option value="M2">M2</option>
                                                                                <option value="Custom Sized">Custom Sized</option>
                                                                                <option value="Per Piece">Per Piece</option>

                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select class="form-control" name="price_impact[]">

                                                                                <option value="0">No</option>
                                                                                <option value="1">Fixed</option>
                                                                                <option value="2">m¹ Impact</option>
                                                                                <option value="3">m² Impact</option>

                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select class="form-control" name="impact_type[]">

                                                                                <option value="0">€</option>
                                                                                <option value="1">%</option>

                                                                            </select>
                                                                        </td>
                                                                        <td style="text-align: center;">

                                                                            <span id="next-row-span" class="tooltip1 add-row" data-id="" style="cursor: pointer;font-size: 20px;">
                                                                                <i id="next-row-icon" class="fa fa-fw fa-plus"></i>
																		    </span>

                                                                            <span data-id="" id="next-row-span" class="tooltip1 remove-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;">
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

    <script>

        $(document).on('click', '.add-row', function () {

            var row = $('.options-table table tbody tr:last').data('id');
            row = row + 1;

            $(".options-table table tbody").append('<tr data-id="'+row+'">\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <input type="hidden" name="size_ids[]">\n' +
                '                                                                                            <input class="form-control size_title" name="sizes[]" id="blood_group_slug" placeholder="Size Title" type="text">\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <input class="form-control size_value" name="size_values[]" id="blood_group_slug" placeholder="Value" type="text">\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                            <select class="form-control" name="size_measure[]">\n' +
                '\n' +
                '                                                                                <option value="M1">M1</option>\n' +
                '                                                                                <option value="M2">M2</option>\n' +
                '                                                                                <option value="Custom Sized">Custom Sized</option>\n' +
                '                                                                                <option value="Per Piece">Per Piece</option>\n' +
                '\n' +
                '                                                                            </select>\n' +
                '                                                                        </td>\n' +
                '                                                                        <td>\n' +
                '                                                                            <select class="form-control" name="price_impact[]">\n' +
                '\n' +
                '                                                                                <option value="0">No</option>\n' +
                '                                                                                <option value="1">Fixed</option>\n' +
                '                                                                                <option value="2">m¹ Impact</option>\n' +
                '                                                                                <option value="3">m² Impact</option>\n' +
                '\n' +
                '                                                                            </select>\n' +
                '                                                                        </td>\n' +
                '                                                                        <td>\n' +
                '                                                                            <select class="form-control" name="impact_type[]">\n' +
                '\n' +
                '                                                                                <option value="0">€</option>\n' +
                '                                                                                <option value="1">%</option>\n' +
                '\n' +
                '                                                                            </select>\n' +
                '                                                                        </td>\n' +
                '                                                                                        <td style="text-align: center;">\n' +
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
                '                                                                </tr>');

        });

        $(document).on('click', '.remove-row', function () {

            if ($(".options-table table tbody tr").length > 1) {

                $(this).parents('tr').remove();

            }

            $(this).parents('tr').remove();

            if($('.options-table').find("table tbody tr").length == 0)
            {
                var row = 1;

                $(".options-table table tbody").append('<tr data-id="'+row+'">\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <input type="hidden" name="size_ids[]">\n' +
                    '                                                                                            <input class="form-control size_title" name="sizes[]" id="blood_group_slug" placeholder="Size Title" type="text">\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <input class="form-control size_value" name="size_values[]" id="blood_group_slug" placeholder="Value" type="text">\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                            <select class="form-control" name="size_measure[]">\n' +
                    '\n' +
                    '                                                                                <option value="M1">M1</option>\n' +
                    '                                                                                <option value="M2">M2</option>\n' +
                    '                                                                                <option value="Custom Sized">Custom Sized</option>\n' +
                    '                                                                                <option value="Per Piece">Per Piece</option>\n' +
                    '\n' +
                    '                                                                            </select>\n' +
                    '                                                                        </td>\n' +
                    '                                                                        <td>\n' +
                    '                                                                            <select class="form-control" name="price_impact[]">\n' +
                    '\n' +
                    '                                                                                <option value="0">No</option>\n' +
                    '                                                                                <option value="1">Fixed</option>\n' +
                    '                                                                                <option value="2">m¹ Impact</option>\n' +
                    '                                                                                <option value="3">m² Impact</option>\n' +
                    '\n' +
                    '                                                                            </select>\n' +
                    '                                                                        </td>\n' +
                    '                                                                        <td>\n' +
                    '                                                                            <select class="form-control" name="impact_type[]">\n' +
                    '\n' +
                    '                                                                                <option value="0">€</option>\n' +
                    '                                                                                <option value="1">%</option>\n' +
                    '\n' +
                    '                                                                            </select>\n' +
                    '                                                                        </td>\n' +
                    '                                                                                        <td style="text-align: center;">\n' +
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
                    '                                                                </tr>');

            }

        });

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
