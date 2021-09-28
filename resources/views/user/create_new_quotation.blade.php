@extends('layouts.handyman')

@section('content')

    <div class="right-side">

        <div class="container-fluid">
            <div class="row">

                <form id="form-quote" style="padding: 0;" class="form-horizontal" action="{{route('store-new-quotation')}}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}

                    <input type="hidden" name="quotation_id" value="{{isset($invoice) ? $invoice[0]->invoice_id : null}}">

                    <div style="margin: 0;" class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <!-- Starting of Dashboard data-table area -->
                            <div class="section-padding add-product-1" style="padding: 0;">

                                <div style="margin: 0;" class="row">
                                    <div style="padding: 0;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div style="box-shadow: none;" class="add-product-box">
                                            <div class="add-product-header products">

                                                <h2>{{isset($invoice) ? __('text.Edit Quotation') : __('text.Create Quotation')}}</h2>

                                                <div class="col-md-5">
                                                    <div class="form-group" style="margin: 0;">
                                                        <div id="cus-box" style="display: flex;">
                                                            <select class="customer-select form-control" name="customer" required>

                                                                <option value="">{{__('text.Select Customer')}}</option>

                                                                @foreach($customers as $key)

                                                                    <option {{isset($invoice) ? ($invoice[0]->user_id == $key->user_id ? 'selected' : null) : null}} value="{{$key->id}}">{{$key->name}} {{$key->family_name}}</option>

                                                                @endforeach

                                                            </select>
                                                            <button type="button" href="#myModal1" role="button" data-toggle="modal" style="outline: none;margin-left: 10px;" class="btn btn-primary">{{__('text.Add New Customer')}}</button>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <hr>
                                            <div>

                                                <div class="alert-box">

                                                </div>

                                                @include('includes.form-success')

                                                <div style="padding-bottom: 0;" class="form-horizontal">

                                                    <div style="margin: 0;background: #f5f5f5;" class="row">

                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 first-row">

                                                            <div>

                                                            <span class="tooltip1 add-row" style="margin-right: 10px;">
                                                                <i class="fa fa-fw fa-plus-circle"></i>
                                                                <span class="tooltiptext">Add</span>
                                                            </span>

                                                                <span class="tooltip1 remove-row" style="cursor: pointer;font-size: 20px;margin-right: 10px;">
                                                                <i class="fa fa-fw fa-minus-circle"></i>
                                                                <span class="tooltiptext">Remove</span>
                                                            </span>

                                                                <span class="tooltip1 copy-row" style="cursor: pointer;font-size: 20px;">
                                                                <i class="fa fa-fw fa-copy"></i>
                                                                <span class="tooltiptext">Copy</span>
                                                            </span>

                                                            </div>

                                                            <div>

                                                            <span class="tooltip1 save-data" style="cursor: pointer;font-size: 20px;margin-right: 10px;">
                                                                <i class="fa fa-fw fa-save"></i>
                                                                <span class="tooltiptext">Save</span>
                                                            </span>

                                                                <a href="{{Request::url()}}" class="tooltip1" style="cursor: pointer;font-size: 20px;margin-right: 10px;">
                                                                <i class="fa fa-fw fa-close"></i>
                                                                <span class="tooltiptext">Close</span>
                                                            </a>

                                                            </div>

                                                        </div>

                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 second-row" style="padding-bottom: 15px;">

                                                            <table id="products_table" style="width: 100%;">
                                                                <thead>
                                                                <tr>
                                                                    <th style="padding: 5px;"></th>
                                                                    <th @if(auth()->user()->role_id == 4) style="display: none;" @endif>Supplier</th>
                                                                    <th style="width: 250px;">Product</th>
                                                                    <th>Color</th>
                                                                    <th>Model</th>
                                                                    <th>Width</th>
                                                                    <th>Height</th>
                                                                    <th>Required</th>
                                                                    <th>€ Art.</th>
                                                                    <th>€ Arb.</th>
                                                                    <th>€ Total</th>
                                                                    <th></th>
                                                                </tr>
                                                                </thead>

                                                                <tbody>

                                                                @if(isset($invoice))

                                                                    @foreach($invoice as $i => $item)

                                                                        <tr @if($i == 0) class="active" @endif data-id="{{$i+1}}">
                                                                            <td>{{$i+1}}</td>
                                                                            <input type="hidden" value="{{$item->basic_price}}" id="basic_price" name="basic_price[]">
                                                                            <input type="hidden" value="{{$item->rate}}" id="rate" name="rate[]">
                                                                            <input type="hidden" value="{{$item->amount}}" id="row_total" name="total[]">
                                                                            <input type="hidden" value="{{$i+1}}" id="row_id" name="row_id[]">
                                                                            <input type="hidden" value="{{$item->childsafe ? 1 : 0}}" id="childsafe" name="childsafe[]">
                                                                            <input type="hidden" value="{{$item->ladderband ? 1 : 0}}" id="ladderband" name="ladderband[]">
                                                                            <input type="hidden" value="{{$item->ladderband_value ? $item->ladderband_value : 0}}" id="ladderband_value" name="ladderband_value[]">
                                                                            <input type="hidden" value="{{$item->ladderband_price_impact ? $item->ladderband_price_impact : 0}}" id="ladderband_price_impact" name="ladderband_price_impact[]">
                                                                            <input type="hidden" value="{{$item->ladderband_impact_type ? $item->ladderband_impact_type : 0}}" id="ladderband_impact_type" name="ladderband_impact_type[]">
                                                                            <input type="hidden" value="0" id="area_conflict" name="area_conflict[]">
                                                                            <input type="hidden" value="{{$item->delivery_days}}" id="delivery_days" name="delivery_days[]">
                                                                            <input type="hidden" value="{{$item->price_based_option}}" id="price_based_option" name="price_based_option[]">
                                                                            <input type="hidden" value="{{$item->base_price}}" id="base_price" name="base_price[]">

                                                                            <td @if(auth()->user()->role_id == 4) class="suppliers hide" @else class="suppliers" @endif>
                                                                                <select name="suppliers[]" class="js-data-example-ajax1">

                                                                                    <option value=""></option>

                                                                                    @foreach($suppliers as $key)

                                                                                        <option {{$key->id == $item->supplier_id ? 'selected' : null}} value="{{$key->id}}">{{$key->company_name}}</option>

                                                                                    @endforeach

                                                                                </select>
                                                                            </td>

                                                                            <td class="products">
                                                                                <select name="products[]" class="js-data-example-ajax">

                                                                                    <option value=""></option>

                                                                                    @foreach($supplier_products[$i] as $key)

                                                                                        <option {{$key->id == $item->product_id ? 'selected' : null}} value="{{$key->id}}">{{$key->title}}</option>

                                                                                    @endforeach

                                                                                </select>
                                                                            </td>
                                                                            <td class="color">
                                                                                <select name="colors[]" class="js-data-example-ajax2">

                                                                                    <option value=""></option>

                                                                                    @foreach($colors[$i] as $color)

                                                                                        <option {{$color->id == $item->color ? 'selected' : null}} value="{{$color->id}}">{{$color->title}}</option>

                                                                                    @endforeach

                                                                                </select>
                                                                            </td>
                                                                            <td class="model">
                                                                                <select name="models[]" class="js-data-example-ajax3">

                                                                                    <option value=""></option>

                                                                                    @foreach($models[$i] as $model)

                                                                                        <option {{$model->id == $item->model_id ? 'selected' : null}} value="{{$model->id}}">{{$model->model}}</option>

                                                                                    @endforeach

                                                                                </select>
                                                                                <input type="hidden" class="model_impact_value" name="model_impact_value[]" value="{{$item->model_impact_value}}">
                                                                            </td>
                                                                            <td class="width" style="width: 80px;">
                                                                                <div class="m-box">
                                                                                    <input {{$item->price_based_option == 3 ? 'readonly' : null}} value="{{str_replace('.', ',', floatval($item->width))}}" class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="width[]" type="text">
                                                                                    <input style="border: 0;outline: none;" readonly type="text" name="width_unit[]" class="measure-unit" value="{{$item->width_unit}}">
                                                                                </div>
                                                                            </td>
                                                                            <td class="height" style="width: 80px;">
                                                                                <div class="m-box">
                                                                                    <input {{$item->price_based_option == 2 ? 'readonly' : null}} value="{{str_replace('.', ',', floatval($item->height))}}" class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="height[]" type="text">
                                                                                    <input style="border: 0;outline: none;" readonly type="text" name="height_unit[]" class="measure-unit" value="{{$item->height_unit}}">
                                                                                </div>
                                                                            </td>
                                                                            <td>1 x 17</td>
                                                                            <td></td>
                                                                            <td></td>
                                                                            <td class="price">€ {{round($item->rate)}}</td>
                                                                            <td id="next-row-td" style="padding: 0;">
                                                                            <span id="next-row-span" class="tooltip1 next-row" style="cursor: pointer;font-size: 20px;">
                                                                                <i id="next-row-icon" style="color: #868686;" class="fa fa-fw fa-chevron-right"></i>
                                                                                <span style="top: 45px;" class="tooltiptext">Next</span>
                                                                            </span>
                                                                            </td>
                                                                        </tr>

                                                                    @endforeach

                                                                @else

                                                                    <tr class="active" data-id="1">
                                                                        <td>1</td>
                                                                        <input type="hidden" id="basic_price" name="basic_price[]">
                                                                        <input type="hidden" id="rate" name="rate[]">
                                                                        <input type="hidden" id="row_total" name="total[]">
                                                                        <input type="hidden" value="1" id="row_id" name="row_id[]">
                                                                        <input type="hidden" value="0" id="childsafe" name="childsafe[]">
                                                                        <input type="hidden" value="0" id="ladderband" name="ladderband[]">
                                                                        <input type="hidden" value="0" id="ladderband_value" name="ladderband_value[]">
                                                                        <input type="hidden" value="0" id="ladderband_price_impact" name="ladderband_price_impact[]">
                                                                        <input type="hidden" value="0" id="ladderband_impact_type" name="ladderband_impact_type[]">
                                                                        <input type="hidden" value="0" id="area_conflict" name="area_conflict[]">
                                                                        <input type="hidden" id="delivery_days" name="delivery_days[]">
                                                                        <input type="hidden" id="price_based_option" name="price_based_option[]">
                                                                        <input type="hidden" id="base_price" name="base_price[]">

                                                                        <td @if(auth()->user()->role_id == 4) class="suppliers hide" @else class="suppliers" @endif>
                                                                            <select name="suppliers[]" class="js-data-example-ajax1">

                                                                                <option value=""></option>

                                                                                @foreach($suppliers as $key)

                                                                                    <option value="{{$key->id}}">{{$key->company_name}}</option>

                                                                                @endforeach

                                                                            </select>
                                                                        </td>
                                                                        <td class="products">
                                                                            <select name="products[]" class="js-data-example-ajax">

                                                                                <option value=""></option>

                                                                                @foreach($products as $key)

                                                                                    <option value="{{$key->id}}">{{$key->title}}</option>

                                                                                @endforeach

                                                                            </select>
                                                                        </td>
                                                                        <td class="color">
                                                                            <select name="colors[]" class="js-data-example-ajax2">

                                                                                <option value=""></option>

                                                                            </select>
                                                                        </td>
                                                                        <td class="model">
                                                                            <select name="models[]" class="js-data-example-ajax3">

                                                                                <option value=""></option>

                                                                            </select>
                                                                            <input type="hidden" class="model_impact_value" name="model_impact_value[]" value="0">
                                                                        </td>
                                                                        <td class="width" style="width: 80px;">
                                                                            <div class="m-box">
                                                                                <input class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="width[]" type="text">
                                                                                <input style="border: 0;outline: none;" readonly type="text" name="width_unit[]" class="measure-unit" value="cm">
                                                                            </div>
                                                                        </td>
                                                                        <td class="height" style="width: 80px;">
                                                                            <div class="m-box">
                                                                                <input class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="height[]" type="text">
                                                                                <input style="border: 0;outline: none;" readonly type="text" name="height_unit[]" class="measure-unit" value="cm">
                                                                            </div>
                                                                        </td>
                                                                        <td>1 x 17</td>
                                                                        <td></td>
                                                                        <td></td>
                                                                        <td class="price"></td>
                                                                        <td id="next-row-td" style="padding: 0;">
                                                                        <span id="next-row-span" class="tooltip1 next-row" style="cursor: pointer;font-size: 20px;">
                                                                            <i id="next-row-icon" style="color: #868686;" class="fa fa-fw fa-chevron-right"></i>
                                                                            <span style="top: 45px;" class="tooltiptext">Next</span>
                                                                        </span>
                                                                        </td>
                                                                    </tr>

                                                                @endif

                                                                </tbody>

                                                            </table>

                                                            <div style="display: flex;justify-content: flex-end;align-items: center;" id="total_box">
                                                                <span style="font-size: 18px;font-weight: 500;margin-right: 5px;">Total: €</span>
                                                                <input name="total_amount" id="total_amount" style="border: 0;font-size: 18px;font-weight: 500;width: 75px;outline: none;" type="text" readonly value="{{isset($invoice) ? $invoice[0]->grand_total : 0}}">
                                                            </div>

                                                        </div>

                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background: white;padding: 15px 0 0 0;">

                                                            <ul style="border: 0;" class="nav nav-tabs feature-tab">
                                                                <li style="margin-bottom: 0;" class="active"><a style="border: 0;border-bottom: 3px solid rgb(151, 140, 135);padding: 10px 30px;" data-toggle="tab" href="#menu1" aria-expanded="false">Features</a></li>
                                                            </ul>

                                                            <div style="padding: 30px 15px 20px 15px;border: 0;border-top: 1px solid #24232329;" class="tab-content">

                                                                <div id="menu1" class="tab-pane fade active in">

                                                                    @if(isset($invoice))

                                                                        <?php $f = 0; ?>

                                                                        @foreach($invoice as $x => $key1)

                                                                            <div data-id="{{$x + 1}}" @if($x == 0) style="margin: 0;" @else style="margin: 0;display: none;" @endif class="form-group">

                                                                                <div class="row" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
                                                                                        <label style="margin-right: 10px;margin-bottom: 0;">Quantity</label>
                                                                                        <input value="{{$key1->qty}}" style="border: none;border-bottom: 1px solid lightgrey;" maskedformat="9,1" name="qty[]" class="form-control" type="text"><span>pcs</span>
                                                                                    </div>
                                                                                </div>

                                                                                @if($key1->childsafe)

                                                                                    <div class="row childsafe-question-box" style="margin: 0;display: flex;align-items: center;">

                                                                                        <div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
                                                                                            <label style="margin-right: 10px;margin-bottom: 0;">Childsafe</label>
                                                                                            <select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control childsafe-select" name="childsafe_option{{$x+1}}">

                                                                                                <option value="">Select any option</option>

                                                                                                @if($key1->childsafe_diff <= 150)

                                                                                                    <option {{$key1->childsafe_question == 1 ? 'selected' : null}} value="1">Please note not childsafe</option>
                                                                                                    <option {{$key1->childsafe_question == 2 ? 'selected' : null}} value="2">Add childsafety clip</option>

                                                                                                @else

                                                                                                    <option {{$key1->childsafe_question == 2 ? 'selected' : null}} value="2">Add childsafety clip</option>
                                                                                                    <option {{$key1->childsafe_question == 3 ? 'selected' : null}} value="3">Yes childsafe</option>

                                                                                                @endif

                                                                                            </select>
                                                                                            <input value="{{$key1->childsafe_diff}}" name="childsafe_diff{{$x + 1}}" class="childsafe_diff" type="hidden">
                                                                                        </div>

                                                                                        <a data-id="{{$x + 1}}" class="info childsafe-btn">Info</a>

                                                                                    </div>

                                                                                    <div class="row childsafe-answer-box" style="margin: 0;display: flex;align-items: center;">

                                                                                        <div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
                                                                                            <label style="margin-right: 10px;margin-bottom: 0;">Childsafe Answer</label>
                                                                                            <select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control childsafe-answer" name="childsafe_answer{{$x+1}}">
                                                                                                @if($key1->childsafe_question == 1)
                                                                                                    <option {{$key1->childsafe_answer == 1 ? 'selected' : null}} value="1">Make it childsafe</option>
                                                                                                    <option {{$key1->childsafe_answer == 2 ? 'selected' : null}} value="2">Yes i agree</option>
                                                                                                @else
                                                                                                    <option selected value="3">Is childsafe</option>
                                                                                                @endif
                                                                                            </select>
                                                                                        </div>

                                                                                    </div>

                                                                                @endif

                                                                                @foreach($key1->features as $feature)

                                                                                    @if($feature->feature_id == 0 && $feature->feature_sub_id == 0)

                                                                                        <div class="row" style="margin: 0;display: flex;align-items: center;">

                                                                                            <div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
                                                                                                <label style="margin-right: 10px;margin-bottom: 0;">Ladderband</label>
                                                                                                <select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features{{$x+1}}[]">
                                                                                                    <option {{$feature->ladderband == 0 ? 'selected' : null}} value="0">No</option>
                                                                                                    <option {{$feature->ladderband == 1 ? 'selected' : null}} value="1">Yes</option>
                                                                                                </select>
                                                                                                <input value="{{$feature->price}}" name="f_price{{$x + 1}}[]" class="f_price" type="hidden">
                                                                                                <input value="0" name="f_id{{$x + 1}}[]" class="f_id" type="hidden">
                                                                                                <input value="0" name="f_area{{$x + 1}}[]" class="f_area" type="hidden">
                                                                                                <input value="0" name="sub_feature{{$x + 1}}[]" class="sub_feature" type="hidden">
                                                                                            </div>

                                                                                            @if($feature->ladderband)

                                                                                                <a data-id="{{$x + 1}}" class="info ladderband-btn">Info</a>

                                                                                            @endif

                                                                                        </div>

                                                                                    @else

                                                                                        <div class="row" style="margin: 0;display: flex;align-items: center;">

                                                                                            <div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
                                                                                                <label style="margin-right: 10px;margin-bottom: 0;">{{$feature->title}}</label>
                                                                                                <select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features{{$x+1}}[]">

                                                                                                    <option value="0">Select Feature</option>

                                                                                                    @foreach($features[$f] as $temp)

                                                                                                        <option {{$temp->id == $feature->feature_sub_id ? 'selected' : null}} value="{{$temp->id}}">{{$temp->title}}</option>

                                                                                                    @endforeach

                                                                                                </select>
                                                                                                <input value="{{$feature->price}}" name="f_price{{$x + 1}}[]" class="f_price" type="hidden">
                                                                                                <input value="{{$feature->feature_id}}" name="f_id{{$x + 1}}[]" class="f_id" type="hidden">
                                                                                                <input value="0" name="f_area{{$x + 1}}[]" class="f_area" type="hidden">
                                                                                                <input value="0" name="sub_feature{{$x + 1}}[]" class="sub_feature" type="hidden">
                                                                                            </div>

                                                                                            @if($feature->comment_box)

                                                                                                <a data-feature="{{$feature->feature_id}}" class="info comment-btn">Info</a>

                                                                                            @endif

                                                                                        </div>

                                                                                        @foreach($key1->sub_features as $s => $sub_feature)

                                                                                            @if($sub_feature->feature_id == $feature->feature_sub_id)

                                                                                                <div class="row sub-features" style="margin: 0;display: flex;align-items: center;">

                                                                                                    <div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
                                                                                                        <label style="margin-right: 10px;margin-bottom: 0;">{{$sub_feature->title}}</label>
                                                                                                        <select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features{{$x+1}}[]">

                                                                                                            <option value="0">Select Feature</option>

                                                                                                            @foreach($sub_features[$s] as $temp)

                                                                                                                <option {{$temp->id == $sub_feature->feature_sub_id ? 'selected' : null}} value="{{$temp->id}}">{{$temp->title}}</option>

                                                                                                            @endforeach

                                                                                                        </select>
                                                                                                        <input value="{{$sub_feature->price}}" name="f_price{{$x + 1}}[]" class="f_price" type="hidden">
                                                                                                        <input value="{{$sub_feature->feature_id}}" name="f_id{{$x + 1}}[]" class="f_id" type="hidden">
                                                                                                        <input value="0" name="f_area{{$x + 1}}[]" class="f_area" type="hidden">
                                                                                                        <input value="1" name="sub_feature{{$x + 1}}[]" class="sub_feature" type="hidden">
                                                                                                    </div>

                                                                                                </div>

                                                                                            @endif

                                                                                        @endforeach

                                                                                    @endif

                                                                                    <?php $f = $f + 1; ?>

                                                                                @endforeach

                                                                            </div>

                                                                        @endforeach

                                                                    @endif

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- Ending of Dashboard data-table area -->
                    </div>

                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Sub Products Sizes</h4>
                                </div>
                                <div class="modal-body">
                                    @if(isset($invoice))

                                        @foreach($invoice as $x => $key1)

                                            @if(isset($sub_products[$x]))

                                                <div class="sub-tables" data-id="{{$x+1}}">
                                                    <table style="width: 100%;">
                                                        <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Title</th>
                                                            <th>Size 38mm</th>
                                                            <th>Size 25mm</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                        @foreach($sub_products[$x] as $sub_product)

                                                            <tr>
                                                                <td><input type="hidden" class="sub_product_id" name="sub_product_id{{$x+1}}[]" value="{{$sub_product->sub_product_id}}">{{$sub_product->code}}</td>
                                                                <td>{{$sub_product->title}}</td>
                                                                <td>
                                                                    @if($sub_product->size1_value == 'x')

                                                                        X<input class="sizeA" name="sizeA{{$x+1}}[]" type="hidden" value="x">

                                                                    @else

                                                                        <input {{$sub_product->size1_value ? 'checked' : null}} data-id="{{$x + 1}}" class="cus_radio" name="cus_radio{{$x+1}}[]" type="radio">
                                                                        <input class="cus_value sizeA" type="hidden" value="{{$sub_product->size1_value ? 1 : 0}}" name="sizeA{{$x+1}}[]">

                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($sub_product->size2_value == 'x')

                                                                        X<input class="sizeB" name="sizeB{{$x+1}}[]" type="hidden" value="x">

                                                                    @else

                                                                        <input {{$sub_product->size2_value ? 'checked' : null}} data-id="{{$x + 1}}" class="cus_radio" name="cus_radio{{$x+1}}[]" type="radio">
                                                                        <input class="cus_value sizeB" type="hidden" value="{{$sub_product->size2_value ? 1 : 0}}" name="sizeB{{$x+1}}[]">

                                                                    @endif
                                                                </td>
                                                            </tr>

                                                        @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>

                                            @endif

                                        @endforeach

                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div id="myModal2" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Feature Comment</h4>
                                </div>
                                <div class="modal-body">

                                    @if(isset($invoice))

                                        @foreach($invoice as $x => $key1)

                                            @foreach($key1->features as $feature)

                                                @if($feature->comment)

                                                    <div class="comment-boxes" data-id="{{$x + 1}}">
                                                        <textarea style="resize: vertical;width: 100%;border: 1px solid #c9c9c9;border-radius: 5px;outline: none;" data-id="{{$feature->feature_id}}" rows="5" name="comment-{{$x + 1}}-{{$feature->feature_id}}">{{$feature->comment}}</textarea>
                                                    </div>

                                                @endif

                                            @endforeach

                                        @endforeach

                                    @endif

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div id="myModal3" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Childsafe Content</h4>
                                </div>
                                <div class="modal-body">
                                    @if(isset($invoice))

                                        @foreach($invoice as $x => $key1)

                                            @if($key1->childsafe)

                                                <div class="childsafe-content-box" data-id="{{$x+1}}">
                                                    <div style="margin: 20px 0;" class="row">
                                                        <div style="display: flex;align-items: center;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <label style="width: 15%;margin-right: 10px;">Width</label>
                                                            <input type="number" value="{{$key1->childsafe_x}}" class="form-control childsafe_values" id="childsafe_x" name="childsafe_x{{$x+1}}">
                                                        </div>
                                                    </div>
                                                    <div style="margin: 20px 0;" class="row">
                                                        <div style="display: flex;align-items: center;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                            <label style="width: 15%;margin-right: 10px;">Height</label>
                                                            <input type="number" value="{{$key1->childsafe_y}}" class="form-control childsafe_values" id="childsafe_y" name="childsafe_y{{$x+1}}">
                                                        </div>
                                                    </div>
                                                </div>

                                            @endif

                                        @endforeach

                                    @endif
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </div>
                    </div>

                </form>

            </div>

        </div>

    </div>

    <div id="cover"></div>

    <div id="myModal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">
                    <button style="background-color: white !important;color: black !important;" type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">{{__('text.Create Customer')}}</h3>
                </div>

                <div class="modal-body" id="myWizard" style="display: inline-block;">

                    <input type="hidden" id="token" name="token" value="{{csrf_token()}}">
                    <input type="hidden" id="handyman_id" name="handyman_id" value="{{Auth::user()->id}}">
                    <input type="hidden" id="handyman_name" name="handyman_name" value="<?php echo Auth::user()->name .' '. Auth::user()->family_name; ?>">

                    <div class="form-group col-sm-6">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </div>
                            <input id="name" name="name" class="form-control validation" placeholder="{{$lang->suf}}" type="text">
                        </div>
                    </div>

                    <div class="form-group col-sm-6">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </div>
                            <input id="family_name" name="family_name" class="form-control validation" placeholder="{{$lang->fn}}" type="text">
                        </div>
                    </div>

                    <div class="form-group col-sm-6">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </div>
                            <input id="business_name" name="business_name" class="form-control" placeholder="{{$lang->bn}}" type="text">
                        </div>
                    </div>

                    <div class="form-group col-sm-6">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </div>
                            <input id="address" name="address" class="form-control" placeholder="{{$lang->ad}}" type="text">
                            <input type="hidden" id="check_address" value="0">
                        </div>
                    </div>


                    <div class="form-group col-sm-6">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </div>
                            <input id="postcode" name="postcode" class="form-control" readonly placeholder="{{$lang->pc}}" type="text">
                        </div>
                    </div>


                    <div class="form-group col-sm-6">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </div>
                            <input id="city" name="city" class="form-control" placeholder="{{$lang->ct}}" readonly type="text">
                        </div>
                    </div>

                    <div class="form-group col-sm-6">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-user"></i>
                            </div>
                            <input id="phone" name="phone" class="form-control" placeholder="{{$lang->pn}}" type="text">
                        </div>
                    </div>

                    <div class="form-group col-sm-6">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <input id="email" name="email" class="form-control validation" placeholder="{{$lang->sue}}" type="email">
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" style="border: 0;outline: none;background-color: #5cb85c !important;" class="btn btn-primary submit-customer">{{__('text.Create')}}</button>
                </div>

            </div>

        </div>
    </div>

    <style>

        #menu1 .form-group
        {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }

        #menu1 .form-group .row
        {
            padding: 0 20px;
            justify-content: flex-start;
            border-right: 1px solid #dddddd;
            height: 40px;
            width: 33%;
            margin: 15px 0 !important;
        }

        #menu1 .form-group .row:nth-child(3n + 1)
        {
            padding-left: 0;
        }

        #menu1 .form-group .row:nth-child(3n)
        {
            border-right: 0;
            padding-right: 0;
        }

        @media (max-width: 992px)
        {
            #menu1 .form-group .row
            {
                width: 50%;
            }

            #menu1 .form-group .row:nth-child(3n + 1)
            {
                padding-left: 20px;
            }

            #menu1 .form-group .row:nth-child(3n)
            {
                border-right: 1px solid #dddddd;
                padding-right: 20px;
            }

            #menu1 .form-group .row:nth-child(2n + 1)
            {
                padding-left: 0;
            }

            #menu1 .form-group .row:nth-child(2n)
            {
                border-right: 0;
                padding-right: 0;
            }

        }

        @media (max-width: 670px)
        {
            #menu1 .form-group .row
            {
                width: 100%;
            }

            #menu1 .form-group .row
            {
                border-right: 0 !important;
                padding-left: 20px !important;
                padding-right: 20px !important;
            }

        }

        @media (max-width: 550px)
        {
            .add-product-header
            {
                flex-direction: column;
            }

            .add-product-header .col-md-5
            {
                padding: 0;
                margin-top: 20px;
                width: 100%;
            }
        }

        .swal2-html-container
        {
            line-height: 2;
        }

        a.info {
            vertical-align: bottom;
            position:relative; /* Anything but static */
            width: 1.5em;
            height: 1.5em;
            text-indent: -9999em;
            display: inline-block;
            color: white;
            font-weight:bold;
            font-size:1em;
            line-height:1em;
            background-color:#628cb6;
            cursor: pointer;
            margin-top: 7px;
            -webkit-border-radius:.75em;
            -moz-border-radius:.75em;
            border-radius:.75em;
        }

        a.info:before {
            content:"i";
            position: absolute;
            top: .25em;
            left:0;
            text-indent: 0;
            display:block;
            width:1.5em;
            text-align:center;
            font-family: monospace;
        }

        .ladderband-btn
        {
            background-color: #494949 !important;
        }

        .childsafe-btn
        {
            background-color: #56a63c !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered
        {
            line-height: 25px;
        }

        #cover {
            background: url(<?php echo asset('assets/images/page-loader.gif'); ?>) no-repeat scroll center center #ffffff78;
            position: fixed;
            z-index: 100000;
            height: 100%;
            width: 100%;
            margin: auto;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            background-size: 8%;
            display: none;
        }

        .pac-container
        {
            z-index: 1000000;
        }

        #cus-box .select2-container--default .select2-selection--single .select2-selection__rendered
        {
            line-height: 28px;
        }

        #cus-box .select2-container--default .select2-selection--single
        {
            border:1px solid #cacaca;
        }

        #cus-box .select2-selection
        {
            height: 40px !important;
            padding-top: 5px !important;
            outline: none;
        }

        #cus-box .select2-selection__arrow
        {
            top: 7.5px !important;
        }

        #cus-box .select2-selection__clear
        {
            display: none;
        }

        .feature-tab li a[aria-expanded="false"]::before, a[aria-expanded="true"]::before
        {
            display: none;
        }

        .m-box
        {
            display: flex;
            align-items: center;
        }

        .m-input
        {
            border-radius: 5px !important;
            width: 70%;
            border: 0;
            padding: 0;
            padding-right: 5px;
            text-align: right;
            height: 30px !important;
        }

        .m-input:focus
        {
            background: #f6f6f6;
        }

        .measure-unit
        {
            width: 50%;
        }

        .select2-container--default .select2-selection--single
        {
            border: 0;
        }

        .tooltip1 {
            position: relative;
            display: inline-block;
            cursor: pointer;
            font-size: 20px;
        }

        /* Tooltip text */
        .tooltip1 .tooltiptext {
            visibility: hidden;
            width: auto;
            min-width: 60px;
            background-color: #7e7e7e;
            color: #fff;
            text-align: center;
            padding: 5px 0;
            border-radius: 6px;
            position: absolute;
            z-index: 1;
            left: 0;
            top: 55px;
            font-size: 12px;
        }

        /* Show the tooltip text when you mouse over the tooltip container */
        .tooltip1:hover .tooltiptext {
            visibility: visible;
        }

        .first-row
        {
            flex-direction: row;
            box-sizing: border-box;
            display: flex;
            background-color: rgb(151, 140, 135);
            height: 50px;
            color: white;
            font-size: 13px;
            align-items: center;
            white-space: nowrap;
            justify-content: space-between;
        }

        .second-row
        {
            padding: 25px;
            display: flex;
            flex-direction: column;
            background: #fff;
            overflow-y: hidden;
            overflow-x: auto;
        }

        table tr th
        {
            font-family: system-ui;
            font-weight: 500;
            border-bottom: 1px solid #ebebeb;
            padding-bottom: 15px;
            color: gray;
        }

        table tbody tr td
        {
            font-family: system-ui;
            font-weight: 500;
            padding: 0 10px;
            color: #3c3c3c;
        }

        table tbody tr.active td
        {
            border-top: 2px solid #cecece;
            border-bottom: 2px solid #cecece;
        }

        table tbody tr.active td:first-child
        {
            border-left: 2px solid #cecece;
            border-bottom-left-radius: 4px;
            border-top-left-radius: 4px;
        }

        table tbody tr.active td:last-child {
            border-right: 2px solid #cecece;
            border-bottom-right-radius: 4px;
            border-top-right-radius: 4px;
        }

        table {
            border-collapse:separate;
            border-spacing: 0 1em;
        }


        .modal-body table tr th
        {
            border: 1px solid #ebebeb;
            padding-bottom: 15px;
            color: gray;
        }

        .modal-body table tbody tr td
        {
            border-left: 1px solid #ebebeb;
            border-right: 1px solid #ebebeb;
            border-bottom: 1px solid #ebebeb;
        }

        .modal-body table tbody tr td:first-child
        {
            border-right: 0;
        }

        .modal-body table tbody tr td:last-child {
            border-left: 0;
        }

        .modal-body table {
            border-collapse:separate;
            border-spacing: 0;
            margin: 20px 0;
        }

        .modal-body table tbody tr td, .modal-body table thead tr th
        {
            padding: 5px 10px;
        }

    </style>

@endsection

@section('scripts')

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNRJukOohRJ1tW0tMG4tzpDXFz68OnonM&libraries=places&callback=initMap" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

    <script type="text/javascript">

        function initMap() {

            var input = document.getElementById('address');

            var options = {
                componentRestrictions: {country: "nl"}
            };

            var autocomplete = new google.maps.places.Autocomplete(input,options);

            // Set the data fields to return when the user selects a place.
            autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);

            autocomplete.addListener('place_changed', function() {

                var flag = 0;

                var place = autocomplete.getPlace();

                if (!place.geometry) {

                    // User entered the name of a Place that was not suggested and
                    // pressed the Enter key, or the Place Details request failed.
                    window.alert("{{__('text.No details available for input: ')}}" + place.name);
                    return;
                }
                else
                {
                    var string = $('#address').val().substring(0, $('#address').val().indexOf(',')); //first string before comma

                    if(string)
                    {
                        var is_number = $('#address').val().match(/\d+/);

                        if(is_number === null)
                        {
                            flag = 1;
                        }
                    }
                }

                var city = '';
                var postal_code = '';

                for(var i=0; i < place.address_components.length; i++)
                {
                    if(place.address_components[i].types[0] == 'postal_code')
                    {
                        postal_code = place.address_components[i].long_name;
                    }

                    if(place.address_components[i].types[0] == 'locality')
                    {
                        city = place.address_components[i].long_name;
                    }
                }

                if(city == '')
                {
                    for(var i=0; i < place.address_components.length; i++)
                    {
                        if(place.address_components[i].types[0] == 'administrative_area_level_2')
                        {
                            city = place.address_components[i].long_name;

                        }
                    }
                }

                if(postal_code == '' || city == '')
                {
                    flag = 1;
                }

                if(!flag)
                {
                    $('#check_address').val(1);
                    $("#address-error").remove();
                    $('#postcode').val(postal_code);
                    $("#city").val(city);
                }
                else
                {
                    $('#address').val('');
                    $('#postcode').val('');
                    $("#city").val('');

                    $("#address-error").remove();
                    $('#address').parent().parent().append('<small id="address-error" style="color: red;display: block;margin-top: 10px;">{{__('text.Kindly write your full address with house/building number so system can detect postal code and city from it!')}}</small>');
                }

            });
        }

        $("#address").on('input',function(e){
            $(this).next('input').val(0);
        });

        $("#address").focusout(function(){

            var check = $(this).next('input').val();

            if(check == 0)
            {
                $(this).val('');
                $('#postcode').val('');
                $("#city").val('');
            }
        });

        $(document).ready(function() {

            $(".submit-customer").click(function(){

                var name = $('#name').val();
                var family_name = $('#family_name').val();
                var business_name = $('#business_name').val();
                var postcode = $('#postcode').val();
                var address = $('#address').val();
                var city = $('#city').val();
                var phone = $('#phone').val();
                var email = $('#email').val();
                var handyman_id = $('#handyman_id').val();
                var handyman_name = $('#handyman_name').val();
                var token = $('#token').val();

                var validation = $('.modal-body').find('.validation');

                var flag = 0;

                $(validation).each(function(){

                    if(!$(this).val())
                    {
                        $(this).css('border','1px solid red');
                        flag = 1;
                    }
                    else
                    {
                        $(this).css('border','');
                    }

                });

                if(!flag)
                {
                    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

                    if(!regex.test(email))
                    {
                        $('#email').css('border','1px solid red');

                        $('.alert-box').html('<div class="alert alert-danger">\n' +
                            '                                            <button type="button" class="close cl-btn" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>\n' +
                            '                                            <p class="text-left">Email address is not valid...</p>\n' +
                            '                                        </div>');
                        $('.alert-box').show();
                        $('.alert-box').delay(5000).fadeOut(400);
                    }
                    else
                    {
                        $('#email').css('border','');

                        $('#cover').show();

                        $.ajax({

                            type: "POST",
                            data: "handyman_id=" + handyman_id + "&handyman_name=" + handyman_name + "&name=" + name + "&family_name=" + family_name + "&business_name=" + business_name + "&postcode=" + postcode + "&address=" + address + "&city=" + city + "&phone=" + phone + "&email=" + email + "&_token=" + token,
                            url: "<?php echo url('/aanbieder/create-customer')?>",

                            success: function(data) {

                                $('#cover').hide();

                                var newStateVal = data.data.id;
                                var newName = data.data.name + " " + data.data.family_name;

                                // Set the value, creating a new option if necessary
                                if ($(".customer-select").find("option[value=" + newStateVal + "]").length) {
                                    $(".customer-select").val(newStateVal).trigger("change");
                                } else {
                                    // Create the DOM option that is pre-selected by default
                                    var newState = new Option(newName, newStateVal, true, true);
                                    // Append it to the select
                                    $(".customer-select").append(newState).trigger('change');
                                }

                                $('.alert-box').html('<div class="alert alert-success">\n' +
                                    '                                            <button type="button" class="close cl-btn" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>\n' +
                                    '                                            <p class="text-left">'+data.message+'</p>\n' +
                                    '                                        </div>');
                                $('.alert-box').show();
                                $('.alert-box').delay(5000).fadeOut(400);

                                $('#myModal1').modal('toggle');
                                window.scrollTo({top: 0, behavior: 'smooth'});
                            },
                            error: function(data) {

                                $('#cover').hide();

                                /*if (data.status == 422) {
                                    $.each(data.responseJSON.errors, function (i, error) {
                                        $('.alert-box').html('<div class="alert alert-danger">\n' +
                                            '                                            <button type="button" class="close cl-btn" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>\n' +
                                            '                                            <p class="text-left">'+error[0]+'</p>\n' +
                                            '                                        </div>');
                                    });
                                    $('.alert-box').show();
                                    $('.alert-box').delay(5000).fadeOut(400);
                                }*/

                                $('.alert-box').html('<div class="alert alert-danger">\n' +
                                    '                                            <button type="button" class="close cl-btn" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>\n' +
                                    '                                            <p class="text-left">Something went wrong!</p>\n' +
                                    '                                        </div>');
                                $('.alert-box').show();
                                $('.alert-box').delay(5000).fadeOut(400);

                                $('#myModal1').modal('toggle');
                                window.scrollTo({top: 0, behavior: 'smooth'});
                            }

                        });
                    }
                }

            });

            $(".customer-select").select2({
                width: '100%',
                height: '200px',
                placeholder: "{{__('text.Select Customer')}}",
                allowClear: true,
                "language": {
                    "noResults": function(){
                        return '{{__('text.No results found')}}';
                    }
                },
            });

            var current_desc = '';

            $(".add-desc").click(function(){
                current_desc = $(this);
                var d = current_desc.prev('input').val();
                $('#description-text').val(d);
                $("#myModal").modal('show');
            });

            $(".submit-desc").click(function () {
                var desc = $('#description-text').val();
                current_desc.prev('input').val(desc);
                $('#description-text').val('');
                $("#myModal").modal('hide');
            });

            $('.estimate_date').datepicker({

                format: 'dd-mm-yyyy',
                startDate: new Date(),

            });

            $(".js-data-example-ajax").select2({
                width: '250px',
                height: '200px',
                placeholder: "{{__('text.Select Product')}}",
                allowClear: true,
                "language": {
                    "noResults": function(){
                        return '{{__('text.No results found')}}';
                    }
                },
            });


            function calculate_total()
            {
                var total = 0;

                $("input[name='total[]']").each(function(i, obj) {

                    var rate = 0;
                    var row_id = $(this).parent().data('id');
                    var qty = $('#menu1').find(`[data-id='${row_id}']`).find('input[name="qty[]"]').val();

                    if(!qty)
                    {
                        qty = 0;
                    }

                    if(!obj.value)
                    {
                        rate = 0;
                    }
                    else
                    {
                        rate = obj.value;
                    }

                    rate = rate * qty;
                    total = parseFloat(total) + parseFloat(rate);
                    total = total.toFixed(2);
                    total = Math.round(total);

                    $(this).parent().find('#rate').val(rate);
                    $('#products_table tbody').find(`[data-id='${row_id}']`).find('.price').text('€ ' + Math.round(rate));

                });

                $('#total_amount').val(total);
            }


            $(document).on('change', ".js-data-example-ajax1", function(e){

                var current = $(this);

                var id = current.val();
                var row_id = current.parent().parent().data('id');
                var options = '';
                current.parent().parent().find('#area_conflict').val(0);

                $.ajax({
                    type:"GET",
                    data: "id=" + id,
                    url: "<?php echo url('/aanbieder/get-supplier-products')?>",
                    success: function(data) {

                        $('#menu1').find(`[data-id='${row_id}']`).remove();

                        current.parent().parent().find('#childsafe').val(0);
                        current.parent().parent().find('#ladderband').val(0);
                        current.parent().parent().find('#ladderband_value').val(0);
                        current.parent().parent().find('#ladderband_price_impact').val(0);
                        current.parent().parent().find('#ladderband_impact_type').val(0);
                        current.parent().parent().find('.price').text('');
                        current.parent().parent().find('#row_total').val('');
                        current.parent().parent().find('#rate').val('');
                        current.parent().parent().find('#basic_price').val('');

                        $.each(data, function(index, value) {

                            if(value.title)
                            {
                                var opt = '<option value="'+value.id+'" >'+value.title+'</option>';

                                options = options + opt;
                            }

                        });

                        current.parent().parent().find('.products').children('select').find('option')
                            .remove()
                            .end()
                            .append('<option value="">Select Product</option>'+options);


                        current.parent().parent().find('.color').children('select').find('option')
                            .remove()
                            .end()
                            .append('<option value="">Select Color</option>');
                        current.parent().parent().find('.width').children('.m-box').children('.measure-unit').val('');
                        current.parent().parent().find('.height').children('.m-box').children('.measure-unit').val('');

                        calculate_total();

                    }
                });

            });


            $(document).on('change', ".js-data-example-ajax", function(e){

                var current = $(this);

                var id = current.val();
                var row_id = current.parent().parent().data('id');
                var options = '';
                var options1 = '';
                current.parent().parent().find('#area_conflict').val(0);

                $.ajax({
                    type:"GET",
                    data: "id=" + id,
                    url: "<?php echo url('/aanbieder/get-colors')?>",
                    success: function(data) {

                        $('#menu1').find(`[data-id='${row_id}']`).remove();

                        if(data != '')
                        {
                            current.parent().parent().find('#delivery_days').val(data.delivery_days);
                            current.parent().parent().find('#ladderband').val(data.ladderband);
                            current.parent().parent().find('#ladderband_value').val(data.ladderband_value);
                            current.parent().parent().find('#ladderband_price_impact').val(data.ladderband_price_impact);
                            current.parent().parent().find('#ladderband_impact_type').val(data.ladderband_impact_type);
                            current.parent().parent().find('#price_based_option').val(data.price_based_option);
                            current.parent().parent().find('#base_price').val(data.base_price);
                            current.parent().parent().find('.price').text('');
                            current.parent().parent().find('#row_total').val('');
                            current.parent().parent().find('#rate').val('');
                            current.parent().parent().find('#basic_price').val('');

                            var price_based_option = data.price_based_option;

                            if(price_based_option == 1)
                            {
                                current.parent().parent().find('.width').children('.m-box').children('.m-input').attr('readonly',false);
                                current.parent().parent().find('.height').children('.m-box').children('.m-input').attr('readonly',false);
                            }
                            else if(price_based_option == 2)
                            {
                                current.parent().parent().find('.width').children('.m-box').children('.m-input').attr('readonly',false);
                                current.parent().parent().find('.height').children('.m-box').children('.m-input').attr('readonly',true);
                                current.parent().parent().find('.height').children('.m-box').children('.m-input').val(0);
                            }
                            else
                            {
                                current.parent().parent().find('.width').children('.m-box').children('.m-input').attr('readonly',true);
                                current.parent().parent().find('.width').children('.m-box').children('.m-input').val(0);
                                current.parent().parent().find('.height').children('.m-box').children('.m-input').attr('readonly',false);
                            }

                            $.each(data.colors, function(index, value) {

                                if(value.title)
                                {
                                    var opt = '<option value="'+value.id+'" >'+value.title+'</option>';

                                    options = options + opt;
                                }

                            });

                            $.each(data.models, function(index1, value1) {

                                if(value1.model)
                                {
                                    var opt1 = '<option value="'+value1.id+'" >'+value1.model+'</option>';

                                    options1 = options1 + opt1;
                                }

                            });

                            current.parent().parent().find('.color').children('select').find('option')
                                .remove()
                                .end()
                                .append('<option value="">Select Color</option>'+options);

                            current.parent().parent().find('.model').children('select').find('option')
                                .remove()
                                .end()
                                .append('<option value="">Select Model</option>'+options1);


                            if((typeof(data[0]) != "undefined") && data[0].measure)
                            {
                                current.parent().parent().find('.width').children('.m-box').children('.measure-unit').val(data[0].measure);
                                current.parent().parent().find('.height').children('.m-box').children('.measure-unit').val(data[0].measure);
                            }
                            else
                            {
                                current.parent().parent().find('.width').children('.m-box').children('.measure-unit').val('');
                                current.parent().parent().find('.height').children('.m-box').children('.measure-unit').val('');
                            }
                        }

                        calculate_total();

                    }
                });

            });


            $(".js-data-example-ajax1").select2({
                width: '100%',
                height: '200px',
                placeholder: "Select Supplier",
                allowClear: true,
                "language": {
                    "noResults": function(){
                        return '{{__('text.No results found')}}';
                    }
                },
            });

            $(".js-data-example-ajax2").select2({
                width: '100%',
                height: '200px',
                placeholder: "Select Color",
                allowClear: true,
                "language": {
                    "noResults": function(){
                        return '{{__('text.No results found')}}';
                    }
                },
            });

            $(".js-data-example-ajax3").select2({
                width: '100%',
                height: '200px',
                placeholder: "Select Model",
                allowClear: true,
                "language": {
                    "noResults": function(){
                        return '{{__('text.No results found')}}';
                    }
                },
            });

            $(document).on('change', ".js-data-example-ajax3", function(e){

                var current = $(this);
                var row_id = current.parent().parent().data('id');

                var model = current.val();
                var color = current.parent().parent().find('.color').find('select').val();

                var price_based_option = current.parent().parent().find('#price_based_option').val();
                var base_price = current.parent().parent().find('#base_price').val();

                var width = current.parent().parent().find('.width').find('.m-input').val();
                width = width.replace(/\,/g, '.');

                var height = current.parent().parent().find('.height').find('.m-input').val();
                height = height.replace(/\,/g, '.');

                var product = current.parent().parent().find('.products').find('select').val();
                var ladderband = current.parent().parent().find('#ladderband').val();
                current.parent().parent().find('#area_conflict').val(0);

                if(width && height && color && model && product)
                {
                    if($(this).parent().parent().find('.suppliers').hasClass('hide'))
                    {
                        var margin = 0;
                    }
                    else
                    {
                        var margin = 1;
                    }

                    $.ajax({
                        type:"GET",
                        data: "product=" + product + "&color=" + color + "&model=" + model + "&width=" + width + "&height=" + height + "&margin=" + margin,
                        url: "<?php echo url('/aanbieder/get-price')?>",
                        success: function(data) {

                            if(typeof data[0].value !== 'undefined')
                            {
                                current.parent().parent().find('#childsafe').val(data[3].childsafe);
                                var childsafe = data[3].childsafe;

                                if(data[0].value === 'both')
                                {
                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{__('text.Oops...')}}',
                                        html: 'Width & Height are greater than max values <br> Max Width: '+data[0].max_width+'<br> Max Height: '+data[0].max_height,
                                    });

                                    current.parent().parent().find('.price').text('');
                                    current.parent().parent().find('#row_total').val('');
                                    current.parent().parent().find('#rate').val('');
                                    current.parent().parent().find('#basic_price').val('');
                                    current.parent().parent().find('#area_conflict').val(3);
                                }
                                else if(data[0].value === 'x_axis')
                                {
                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{__('text.Oops...')}}',
                                        html: 'Width is greater than max value <br> Max Width: '+data[0].max_width,
                                    });

                                    current.parent().parent().find('.price').text('');
                                    current.parent().parent().find('#row_total').val('');
                                    current.parent().parent().find('#rate').val('');
                                    current.parent().parent().find('#basic_price').val('');
                                    current.parent().parent().find('#area_conflict').val(1);
                                }
                                else if(data[0].value === 'y_axis')
                                {

                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{__('text.Oops...')}}',
                                        html: 'Height is greater than max value <br> Max Height: '+data[0].max_height,
                                    });

                                    current.parent().parent().find('.price').text('');
                                    current.parent().parent().find('#row_total').val('');
                                    current.parent().parent().find('#rate').val('');
                                    current.parent().parent().find('#basic_price').val('');
                                    current.parent().parent().find('#area_conflict').val(2);
                                }
                                else
                                {
                                    if(price_based_option == 1)
                                    {
                                        var price = data[0].value;
                                        var org = data[0].value;
                                    }
                                    else
                                    {
                                        var price = base_price;
                                        var org = base_price;
                                    }

                                    if(margin == 1)
                                    {
                                        if(data[2])
                                        {
                                            price = parseFloat(price);
                                            var supplier_margin = data[2].margin;
                                            var retailer_margin = data[2].retailer_margin;

                                            if(supplier_margin && retailer_margin)
                                            {
                                                price = (price / supplier_margin) * retailer_margin;
                                                price = price.toFixed(2);
                                            }
                                        }
                                    }

                                    var features = '';
                                    var f_value = 0;

                                    $('#myModal').find('.modal-body').find(`[data-id='${row_id}']`).remove();
                                    $('#myModal3').find('.modal-body').find(`[data-id='${row_id}']`).remove();

                                    if(childsafe == 1)
                                    {
                                        var content = '<div class="row childsafe-question-box" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
                                            '<label style="margin-right: 10px;margin-bottom: 0;">Childsafe</label>'+
                                            '<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control childsafe-select" name="childsafe_option'+ row_id +'">\n' +
                                            '<option value="">Select any option</option>\n' +
                                            '<option value="2">Add childsafety clip</option>\n' +
                                            '</select>\n' +
                                            '<input value="0" name="childsafe_diff'+ row_id +'" class="childsafe_diff" type="hidden">'+
                                            '</div><a data-id="'+ row_id +'" class="info childsafe-btn">Info</a></div>\n';

                                        features = features + content;


                                        $('#myModal3').find('.modal-body').append(
                                            '<div class="childsafe-content-box" data-id="'+row_id+'">\n' +
                                            '                                            <div style="margin: 20px 0;" class="row">\n' +
                                            '                                                <div style="display: flex;align-items: center;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">\n' +
                                            '                                                    <label style="width: 15%;margin-right: 10px;">Width</label>\n' +
                                            '                                                    <input type="number" class="form-control childsafe_values" id="childsafe_x" name="childsafe_x'+row_id+'">\n' +
                                            '                                                </div>\n' +
                                            '                                            </div>\n' +
                                            '                                            <div style="margin: 20px 0;" class="row">\n' +
                                            '                                                <div style="display: flex;align-items: center;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">\n' +
                                            '                                                    <label style="width: 15%;margin-right: 10px;">Height</label>\n' +
                                            '                                                    <input type="number" class="form-control childsafe_values" id="childsafe_y" name="childsafe_y'+row_id+'">\n' +
                                            '                                                </div>\n' +
                                            '                                            </div>\n' +
                                            '                                        </div>'
                                        );
                                    }

                                    if(ladderband == 1)
                                    {
                                        var content = '<div class="row" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
                                            '<label style="margin-right: 10px;margin-bottom: 0;">Ladderband</label>'+
                                            '<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features'+ row_id +'[]">\n' +
                                            '<option value="0">No</option>\n' +
                                            '<option value="1">Yes</option>\n' +
                                            '</select>\n' +
                                            '<input value="0" name="f_price'+ row_id +'[]" class="f_price" type="hidden">'+
                                            '<input value="0" name="f_id'+ row_id +'[]" class="f_id" type="hidden">'+
                                            '<input value="0" name="f_area'+ row_id +'[]" class="f_area" type="hidden">'+
                                            '<input value="0" name="sub_feature'+ row_id +'[]" class="sub_feature" type="hidden">'+
                                            '</div><a data-id="'+ row_id +'" class="info ladderband-btn hide">Info</a></div>\n';

                                        features = features + content;
                                    }

                                    $.each(data[1], function(index, value) {

                                        var opt = '<option value="0">Select Feature</option>';

                                        $.each(value.features, function(index1, value1) {

                                            opt = opt + '<option value="'+value1.id+'">'+value1.title+'</option>';

                                        });

                                        if(value.comment_box == 1)
                                        {
                                            var icon = '<a data-feature="'+value.id+'" class="info comment-btn">Info</a>';
                                        }
                                        else
                                        {
                                            var icon = '';
                                        }

                                        var content = '<div class="row" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
                                            '<label style="margin-right: 10px;margin-bottom: 0;">'+value.title+'</label>'+
                                            '<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features'+ row_id +'[]">'+opt+'</select>\n' +
                                            '<input value="'+f_value+'" name="f_price'+ row_id +'[]" class="f_price" type="hidden">'+
                                            '<input value="'+value.id+'" name="f_id'+ row_id +'[]" class="f_id" type="hidden">'+
                                            '<input value="0" name="f_area'+ row_id +'[]" class="f_area" type="hidden">'+
                                            '<input value="0" name="sub_feature'+ row_id +'[]" class="sub_feature" type="hidden">'+
                                            '</div>' + icon + '</div>\n';

                                        features = features + content;

                                    });

                                    if($('#menu1').find(`[data-id='${row_id}']`).length > 0)
                                    {
                                        $('#menu1').find(`[data-id='${row_id}']`).remove();
                                    }

                                    $('#menu1').append('<div data-id="'+row_id+'" style="margin: 0;" class="form-group">' +
                                        '\n' +
                                        '<div class="row" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
                                        '<label style="margin-right: 10px;margin-bottom: 0;">Quantity</label>'+
                                        '<input value="1" style="border: none;border-bottom: 1px solid lightgrey;" maskedformat="9,1" name="qty[]" class="form-control" type="text" /><span>pcs</span>' +
                                        '</div></div>' + features +
                                        '</div>');

                                    if(data[3].max_size)
                                    {
                                        var sq = (width * height) / 10000;
                                        var max_size = data[3].max_size;

                                        if(sq > max_size)
                                        {
                                            Swal.fire({
                                                icon: 'error',
                                                title: '{{__('text.Oops...')}}',
                                                text: 'Area is greater than max size: ' + max_size,
                                            });

                                            current.parent().find('.f_area').val(1);
                                        }
                                    }
                                    else
                                    {
                                        current.parent().find('.f_area').val(0);
                                    }

                                    /*var impact_value = current.parent().parent().find('.model').find('.model_impact_value').val();*/
                                    var basic_price = $('#products_table tbody').find(`[data-id='${row_id}']`).find('#basic_price').val();

                                    /*price = price - impact_value;*/

                                    if(data[3].price_impact == 1)
                                    {
                                        if(data[3].impact_type == 0)
                                        {
                                            var impact_value = data[3].value;
                                            impact_value = parseFloat(impact_value).toFixed(2);
                                            price = parseFloat(price) + parseFloat(impact_value);
                                            price = price.toFixed(2);
                                        }
                                        else
                                        {
                                            var impact_value = data[3].value;
                                            var per = (impact_value)/100;
                                            impact_value = basic_price * per;
                                            impact_value = parseFloat(impact_value).toFixed(2);
                                            price = parseFloat(price) + parseFloat(impact_value);
                                            price = price.toFixed(2);
                                        }
                                    }
                                    else
                                    {
                                        var impact_value = 0;
                                        price = parseFloat(price) + parseFloat(impact_value);
                                        price = price.toFixed(2);
                                    }

                                    current.parent().parent().find('.model').find('.model_impact_value').val(impact_value);
                                    current.parent().parent().find('.price').text('€ ' + Math.round(price));
                                    current.parent().parent().find('#row_total').val(price);
                                    current.parent().parent().find('#rate').val(price);
                                    current.parent().parent().find('#basic_price').val(price);
                                }
                            }
                            else
                            {
                                current.parent().parent().find('.price').text('');
                                current.parent().parent().find('#row_total').val('');
                                current.parent().parent().find('#rate').val('');
                                current.parent().parent().find('#basic_price').val('');
                            }

                            calculate_total();
                        }
                    });
                }

            });

            $(document).on('change', ".js-data-example-ajax2", function(e){

                var current = $(this);
                var row_id = current.parent().parent().data('id');

                var color = current.val();
                var model = current.parent().parent().find('.model').find('select').val();

                var price_based_option = current.parent().parent().find('#price_based_option').val();
                var base_price = current.parent().parent().find('#base_price').val();

                var width = current.parent().parent().find('.width').find('.m-input').val();
                width = width.replace(/\,/g, '.');

                var height = current.parent().parent().find('.height').find('.m-input').val();
                height = height.replace(/\,/g, '.');

                var product = current.parent().parent().find('.products').find('select').val();
                var ladderband = current.parent().parent().find('#ladderband').val();
                current.parent().parent().find('#area_conflict').val(0);

                if(width && height && color && model && product)
                {
                    if($(this).parent().parent().find('.suppliers').hasClass('hide'))
                    {
                        var margin = 0;
                    }
                    else
                    {
                        var margin = 1;
                    }

                    $.ajax({
                        type:"GET",
                        data: "product=" + product + "&color=" + color + "&model=" + model + "&width=" + width + "&height=" + height + "&margin=" + margin,
                        url: "<?php echo url('/aanbieder/get-price')?>",
                        success: function(data) {

                            if(typeof data[0].value !== 'undefined')
                            {
                                current.parent().parent().find('#childsafe').val(data[3].childsafe);
                                var childsafe = data[3].childsafe;
                                var color_max_height = data[0].max_height;

                                if(data[0].value === 'both')
                                {
                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{__('text.Oops...')}}',
                                        html: 'Width & Height are greater than max values <br> Max Width: '+data[0].max_width+'<br> Max Height: '+data[0].max_height,
                                    });

                                    current.parent().parent().find('.price').text('');
                                    current.parent().parent().find('#row_total').val('');
                                    current.parent().parent().find('#rate').val('');
                                    current.parent().parent().find('#basic_price').val('');
                                    current.parent().parent().find('#area_conflict').val(3);
                                }
                                else if(data[0].value === 'x_axis')
                                {
                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{__('text.Oops...')}}',
                                        html: 'Width is greater than max value <br> Max Width: '+data[0].max_width,
                                    });

                                    current.parent().parent().find('.price').text('');
                                    current.parent().parent().find('#row_total').val('');
                                    current.parent().parent().find('#rate').val('');
                                    current.parent().parent().find('#basic_price').val('');
                                    current.parent().parent().find('#area_conflict').val(1);
                                }
                                else if(data[0].value === 'y_axis')
                                {

                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{__('text.Oops...')}}',
                                        html: 'Height is greater than max value <br> Max Height: '+data[0].max_height,
                                    });

                                    current.parent().parent().find('.price').text('');
                                    current.parent().parent().find('#row_total').val('');
                                    current.parent().parent().find('#rate').val('');
                                    current.parent().parent().find('#basic_price').val('');
                                    current.parent().parent().find('#area_conflict').val(2);
                                }
                                else
                                {
                                    if(price_based_option == 1)
                                    {
                                        var price = data[0].value;
                                        var org = data[0].value;
                                    }
                                    else
                                    {
                                        var price = base_price;
                                        var org = base_price;
                                    }

                                    if(margin == 1)
                                    {
                                        if(data[2])
                                        {
                                            price = parseFloat(price);
                                            var supplier_margin = data[2].margin;
                                            var retailer_margin = data[2].retailer_margin;

                                            if(supplier_margin && retailer_margin)
                                            {
                                                price = (price / supplier_margin) * retailer_margin;
                                                price = price.toFixed(2);
                                            }
                                        }
                                    }

                                    var features = '';
                                    var f_value = 0;

                                    $('#myModal').find('.modal-body').find(`[data-id='${row_id}']`).remove();
                                    $('#myModal3').find('.modal-body').find(`[data-id='${row_id}']`).remove();

                                    if(childsafe == 1)
                                    {
                                        var content = '<div class="row childsafe-question-box" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
                                            '<label style="margin-right: 10px;margin-bottom: 0;">Childsafe</label>'+
                                            '<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control childsafe-select" name="childsafe_option'+ row_id +'">\n' +
                                            '<option value="">Select any option</option>\n' +
                                            '<option value="2">Add childsafety clip</option>\n' +
                                            '</select>\n' +
                                            '<input value="0" name="childsafe_diff'+ row_id +'" class="childsafe_diff" type="hidden">'+
                                            '</div><a data-id="'+ row_id +'" class="info childsafe-btn">Info</a></div>\n';

                                        features = features + content;

                                        $('#myModal3').find('.modal-body').append(
                                            '<div class="childsafe-content-box" data-id="'+row_id+'">\n' +
                                            '                                            <div style="margin: 20px 0;" class="row">\n' +
                                            '                                                <div style="display: flex;align-items: center;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">\n' +
                                            '                                                    <label style="width: 15%;margin-right: 10px;">Width</label>\n' +
                                            '                                                    <input type="number" class="form-control childsafe_values" id="childsafe_x" name="childsafe_x'+row_id+'">\n' +
                                            '                                                </div>\n' +
                                            '                                            </div>\n' +
                                            '                                            <div style="margin: 20px 0;" class="row">\n' +
                                            '                                                <div style="display: flex;align-items: center;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">\n' +
                                            '                                                    <label style="width: 15%;margin-right: 10px;">Height</label>\n' +
                                            '                                                    <input type="number" class="form-control childsafe_values" id="childsafe_y" name="childsafe_y'+row_id+'">\n' +
                                            '                                                </div>\n' +
                                            '                                            </div>\n' +
                                            '                                        </div>'
                                        );
                                    }

                                    if(ladderband == 1)
                                    {
                                        var content = '<div class="row" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
                                            '<label style="margin-right: 10px;margin-bottom: 0;">Ladderband</label>'+
                                            '<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features'+ row_id +'[]">\n' +
                                            '<option value="0">No</option>\n' +
                                            '<option value="1">Yes</option>\n' +
                                            '</select>\n' +
                                            '<input value="0" name="f_price'+ row_id +'[]" class="f_price" type="hidden">'+
                                            '<input value="0" name="f_id'+ row_id +'[]" class="f_id" type="hidden">'+
                                            '<input value="0" name="f_area'+ row_id +'[]" class="f_area" type="hidden">'+
                                            '<input value="0" name="sub_feature'+ row_id +'[]" class="sub_feature" type="hidden">'+
                                            '</div><a data-id="'+ row_id +'" class="info ladderband-btn hide">Info</a></div>\n';

                                        features = features + content;
                                    }

                                    $.each(data[1], function(index, value) {

                                        var opt = '<option value="0">Select Feature</option>';

                                        $.each(value.features, function(index1, value1) {

                                            opt = opt + '<option value="'+value1.id+'">'+value1.title+'</option>';

                                        });

                                        if(value.comment_box == 1)
                                        {
                                            var icon = '<a data-feature="'+value.id+'" class="info comment-btn">Info</a>';
                                        }
                                        else
                                        {
                                            var icon = '';
                                        }

                                        var content = '<div class="row" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
                                            '<label style="margin-right: 10px;margin-bottom: 0;">'+value.title+'</label>'+
                                            '<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features'+ row_id +'[]">'+opt+'</select>\n' +
                                            '<input value="'+f_value+'" name="f_price'+ row_id +'[]" class="f_price" type="hidden">'+
                                            '<input value="'+value.id+'" name="f_id'+ row_id +'[]" class="f_id" type="hidden">'+
                                            '<input value="0" name="f_area'+ row_id +'[]" class="f_area" type="hidden">'+
                                            '<input value="0" name="sub_feature'+ row_id +'[]" class="sub_feature" type="hidden">'+
                                            '</div>' + icon + '</div>\n';

                                        features = features + content;

                                    });

                                    if($('#menu1').find(`[data-id='${row_id}']`).length > 0)
                                    {
                                        $('#menu1').find(`[data-id='${row_id}']`).remove();
                                    }

                                    $('#menu1').append('<div data-id="'+row_id+'" style="margin: 0;" class="form-group">' +
                                        '\n' +
                                        '<div class="row" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
                                        '<label style="margin-right: 10px;margin-bottom: 0;">Quantity</label>'+
                                        '<input value="1" style="border: none;border-bottom: 1px solid lightgrey;" maskedformat="9,1" name="qty[]" class="form-control" type="text" /><span>pcs</span>' +
                                        '</div></div>' + features +
                                        '</div>');

                                    if(data[3].max_size)
                                    {
                                        var sq = (width * height) / 10000;
                                        var max_size = data[3].max_size;

                                        if(sq > max_size)
                                        {
                                            Swal.fire({
                                                icon: 'error',
                                                title: '{{__('text.Oops...')}}',
                                                text: 'Area is greater than max size: ' + max_size,
                                            });

                                            current.parent().find('.f_area').val(1);
                                        }
                                    }
                                    else
                                    {
                                        current.parent().find('.f_area').val(0);
                                    }

                                    /*var impact_value = current.parent().parent().find('.model').find('.model_impact_value').val();*/
                                    var basic_price = $('#products_table tbody').find(`[data-id='${row_id}']`).find('#basic_price').val();

                                    /*price = price - impact_value;*/

                                    if(data[3].price_impact == 1)
                                    {
                                        if(data[3].impact_type == 0)
                                        {
                                            var impact_value = data[3].value;
                                            impact_value = parseFloat(impact_value).toFixed(2);
                                            price = parseFloat(price) + parseFloat(impact_value);
                                            price = price.toFixed(2);
                                        }
                                        else
                                        {
                                            var impact_value = data[3].value;
                                            var per = (impact_value)/100;
                                            impact_value = basic_price * per;
                                            impact_value = parseFloat(impact_value).toFixed(2);
                                            price = parseFloat(price) + parseFloat(impact_value);
                                            price = price.toFixed(2);
                                        }
                                    }
                                    else
                                    {
                                        var impact_value = 0;
                                        price = parseFloat(price) + parseFloat(impact_value);
                                        price = price.toFixed(2);
                                    }

                                    current.parent().parent().find('.model').find('.model_impact_value').val(impact_value);
                                    current.parent().parent().find('.price').text('€ ' + Math.round(price));
                                    current.parent().parent().find('#row_total').val(price);
                                    current.parent().parent().find('#rate').val(price);
                                    current.parent().parent().find('#basic_price').val(price);
                                }
                            }
                            else
                            {
                                current.parent().parent().find('.price').text('');
                                current.parent().parent().find('#row_total').val('');
                                current.parent().parent().find('#rate').val('');
                                current.parent().parent().find('#basic_price').val('');
                            }

                            calculate_total();
                        }
                    });
                }

            });

            function focus_row(last_row)
            {
                $('#products_table tbody tr.active').removeClass('active');
                last_row.addClass('active');

                var id = last_row.data('id');

                $('#menu1').children().not(`[data-id='${id}']`).hide();
                $('#menu1').find(`[data-id='${id}']`).show();
            }

            function numbering()
            {
                $('#products_table > tbody  > tr').each(function(index, tr) { $(this).find('td:eq(0)').text(index + 1); });
            }

            function add_row(copy = false,rate = null,basic_price = null,price = null,products = null,product = null,suppliers = null,supplier = null,colors = null,color = null,models = null,model = null,model_impact_value = null,width = null,width_unit = null,height = null,height_unit = null,price_text = null,features = null,features_selects = null,childsafe_question = null,childsafe_answer = null,qty = null,childsafe = 0,ladderband = 0,ladderband_value = 0,ladderband_price_impact = 0,ladderband_impact_type = 0,area_conflict = 0,subs = null,childsafe_content = null,childsafe_x = null,childsafe_y = null,delivery_days = null,price_based_option = null,base_price = null,width_readonly = null,height_readonly = null)
            {
                var rowCount = $('#products_table tbody tr:last').data('id');
                rowCount = rowCount + 1;

                var r_id = $('#products_table tbody tr:last').find('td:eq(0)').text();
                r_id = parseInt(r_id) + 1;

                if(!copy)
                {
                    $("#products_table tbody").append('<tr data-id="'+rowCount+'">\n' +
                        '                                                            <td>'+r_id+'</td>\n' +
                        '                                                            <input type="hidden" id="basic_price" name="basic_price[]">\n' +
                        '                                                            <input type="hidden" id="rate" name="rate[]">\n' +
                        '                                                            <input type="hidden" id="row_total" name="total[]">\n' +
                        '                                                            <input type="hidden" value="'+rowCount+'" id="row_id" name="row_id[]">\n' +
                        '                                                            <input type="hidden" value="0" id="childsafe" name="childsafe[]">\n' +
                        '                                                            <input type="hidden" value="0" id="ladderband" name="ladderband[]">\n' +
                        '                                                            <input type="hidden" value="0" id="ladderband_value" name="ladderband_value[]">\n' +
                        '                                                            <input type="hidden" value="0" id="ladderband_price_impact" name="ladderband_price_impact[]">\n' +
                        '                                                            <input type="hidden" value="0" id="ladderband_impact_type" name="ladderband_impact_type[]">\n' +
                        '                                                            <input type="hidden" value="0" id="area_conflict" name="area_conflict[]">\n' +
                        '                                                            <input type="hidden" value="1" id="delivery_days" name="delivery_days[]">\n' +
                        '                                                            <input type="hidden" id="price_based_option" name="price_based_option[]">\n' +
                        '                                                            <input type="hidden" id="base_price" name="base_price[]">\n' +
                        '                                                            <td @if(auth()->user()->role_id == 4) class="suppliers hide" @else class="suppliers" @endif>\n' +
                        '                                                                <select name="suppliers[]" class="js-data-example-ajax1">\n' +
                        '\n' +
                        '                                                                    <option value=""></option>\n' +
                        '\n' +
                        '                                                                    @foreach($suppliers as $key)\n' +
                        '\n' +
                        '                                                                        <option value="{{$key->id}}">{{$key->company_name}}</option>\n' +
                        '\n' +
                        '                                                                     @endforeach\n' +
                        '\n' +
                        '                                                                </select>\n' +
                        '                                                            </td>\n' +
                        '                                                            <td class="products">\n' +
                        '                                                                <select name="products[]" class="js-data-example-ajax">\n' +
                        '\n' +
                        '                                                                    <option value=""></option>\n' +
                        '\n' +
                        '                                                                    @foreach($products as $key)\n' +
                        '\n' +
                        '                                                                        <option value="{{$key->id}}">{{$key->title}}</option>\n' +
                        '\n' +
                        '                                                                    @endforeach\n' +
                        '\n' +
                        '                                                                </select>\n' +
                        '                                                            </td>\n' +
                        '                                                            <td class="color">\n' +
                        '                                                                <select name="colors[]" class="js-data-example-ajax2">\n' +
                        '\n' +
                        '                                                                    <option value=""></option>\n' +
                        '\n' +
                        '                                                                </select>\n' +
                        '                                                            </td>\n' +
                        '                                                            <td class="model">\n' +
                        '                                                                <select name="models[]" class="js-data-example-ajax3">\n' +
                        '\n' +
                        '                                                                    <option value=""></option>\n' +
                        '\n' +
                        '                                                                </select>\n' +
                        '                                                                    <input type="hidden" class="model_impact_value" name="model_impact_value[]" value="">\n' +
                        '                                                            </td>\n' +
                        '                                                            <td class="width" style="width: 80px;">\n' +
                        '                                                                <div class="m-box">\n' +
                        '                                                                    <input class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="width[]" type="text">\n' +
                        '                                                                    <input style="border: 0;outline: none;" readonly type="text" name="width_unit[]" class="measure-unit" value="cm">\n' +
                        '                                                                </div>\n' +
                        '                                                            </td>\n' +
                        '                                                            <td class="height" style="width: 80px;">\n' +
                        '                                                                <div class="m-box">\n' +
                        '                                                                    <input class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="height[]" type="text">\n' +
                        '                                                                    <input style="border: 0;outline: none;" readonly type="text" name="height_unit[]" class="measure-unit" value="cm">\n' +
                        '                                                                </div>\n' +
                        '                                                            </td>\n' +
                        '                                                            <td>1 x 17</td>\n' +
                        '                                                            <td></td>\n' +
                        '                                                            <td></td>\n' +
                        '                                                            <td class="price"></td>\n' +
                        '                                                            <td id="next-row-td" style="padding: 0;">\n' +
                        '                                                                <span id="next-row-span" class="tooltip1 next-row" style="cursor: pointer;font-size: 20px;">\n' +
                        '                                                                    <i id="next-row-icon" style="color: #868686;" class="fa fa-fw fa-chevron-right"></i>\n' +
                        '                                                                    <span style="top: 45px;" class="tooltiptext">Next</span>\n' +
                        '                                                                </span>\n' +
                        '                                                            </td>\n' +
                        '                                                        </tr>');

                    var last_row = $('#products_table tbody tr:last');

                    focus_row(last_row);

                    last_row.find(".js-data-example-ajax").select2({
                        width: '250px',
                        height: '200px',
                        placeholder: "{{__('text.Select Product')}}",
                        allowClear: true,
                        "language": {
                            "noResults": function(){
                                return '{{__('text.No results found')}}';
                            }
                        },
                    });

                    last_row.find(".js-data-example-ajax1").select2({
                        width: '100%',
                        height: '200px',
                        placeholder: "Select Supplier",
                        allowClear: true,
                        "language": {
                            "noResults": function(){
                                return '{{__('text.No results found')}}';
                            }
                        },
                    });

                    last_row.find(".js-data-example-ajax2").select2({
                        width: '100%',
                        height: '200px',
                        placeholder: "Select Color",
                        allowClear: true,
                        "language": {
                            "noResults": function(){
                                return '{{__('text.No results found')}}';
                            }
                        },
                    });

                    last_row.find(".js-data-example-ajax3").select2({
                        width: '100%',
                        height: '200px',
                        placeholder: "Select Model",
                        allowClear: true,
                        "language": {
                            "noResults": function(){
                                return '{{__('text.No results found')}}';
                            }
                        },
                    });
                }
                else
                {

                    $("#products_table tbody").append('<tr data-id="'+rowCount+'">\n' +
                        '                                                            <td>'+r_id+'</td>\n' +
                        '                                                            <input value="'+basic_price+'" type="hidden" id="basic_price" name="basic_price[]">\n' +
                        '                                                            <input value="'+rate+'" type="hidden" id="rate" name="rate[]">\n' +
                        '                                                            <input value="'+price+'" type="hidden" id="row_total" name="total[]">\n' +
                        '                                                            <input type="hidden" value="'+rowCount+'" id="row_id" name="row_id[]">\n' +
                        '                                                            <input type="hidden" value="'+childsafe+'" id="childsafe" name="childsafe[]">\n' +
                        '                                                            <input type="hidden" value="'+ladderband+'" id="ladderband" name="ladderband[]">\n' +
                        '                                                            <input type="hidden" value="'+ladderband_value+'" id="ladderband_value" name="ladderband_value[]">\n' +
                        '                                                            <input type="hidden" value="'+ladderband_price_impact+'" id="ladderband_price_impact" name="ladderband_price_impact[]">\n' +
                        '                                                            <input type="hidden" value="'+ladderband_impact_type+'" id="ladderband_impact_type" name="ladderband_impact_type[]">\n' +
                        '                                                            <input type="hidden" value="'+area_conflict+'" id="area_conflict" name="area_conflict[]">\n' +
                        '                                                            <input type="hidden" value="'+delivery_days+'" id="delivery_days" name="delivery_days[]">\n' +
                        '                                                            <input type="hidden" value="'+price_based_option+'" id="price_based_option" name="price_based_option[]">\n' +
                        '                                                            <input type="hidden" value="'+base_price+'" id="base_price" name="base_price[]">\n' +
                        '                                                            <td @if(auth()->user()->role_id == 4) class="suppliers hide" @else class="suppliers" @endif>\n' +
                        '                                                                <select name="suppliers[]" class="js-data-example-ajax1">\n' +
                        '\n' +
                        suppliers +
                        '\n' +
                        '                                                                </select>\n' +
                        '                                                            <input type="hidden" name="sub_impact_value" id="sub_impact_value" value="0">\n' +
                        '                                                            </td>\n' +
                        '                                                            <td class="products">\n' +
                        '                                                                <select name="products[]" class="js-data-example-ajax">\n' +
                        '\n' +
                        products +
                        '\n' +
                        '                                                                </select>\n' +
                        '                                                            </td>\n' +
                        '                                                            <td class="color">\n' +
                        '                                                                <select name="colors[]" class="js-data-example-ajax2">\n' +
                        '\n' +
                        colors +
                        '\n' +
                        '                                                                </select>\n' +
                        '                                                            </td>\n' +
                        '                                                            <td class="model">\n' +
                        '                                                                <select name="models[]" class="js-data-example-ajax3">\n' +
                        '\n' +
                        models +
                        '\n' +
                        '                                                                </select>\n' +
                        '                                                                    <input type="hidden" class="model_impact_value" name="model_impact_value[]" value="'+model_impact_value+'">\n' +
                        '                                                            </td>\n' +
                        '                                                            <td class="width" style="width: 80px;">\n' +
                        '                                                                <div class="m-box">\n' +
                        '                                                                    <input '+width_readonly+' value="'+width+'" class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="width[]" type="text">\n' +
                        '                                                                    <input style="border: 0;outline: none;" readonly type="text" name="width_unit[]" class="measure-unit" value="'+width_unit+'">\n' +
                        '                                                                </div>\n' +
                        '                                                            </td>\n' +
                        '                                                            <td class="height" style="width: 80px;">\n' +
                        '                                                                <div class="m-box">\n' +
                        '                                                                    <input '+height_readonly+' value="'+height+'" class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="height[]" type="text">\n' +
                        '                                                                    <input style="border: 0;outline: none;" readonly type="text" name="height_unit[]" class="measure-unit" value="'+height_unit+'">\n' +
                        '                                                                </div>\n' +
                        '                                                            </td>\n' +
                        '                                                            <td>1 x 17</td>\n' +
                        '                                                            <td></td>\n' +
                        '                                                            <td></td>\n' +
                        '                                                            <td class="price">'+price_text+'</td>\n' +
                        '                                                            <td id="next-row-td" style="padding: 0;">\n' +
                        '                                                                <span id="next-row-span" class="tooltip1 next-row" style="cursor: pointer;font-size: 20px;">\n' +
                        '                                                                    <i id="next-row-icon" style="color: #868686;" class="fa fa-fw fa-chevron-right"></i>\n' +
                        '                                                                    <span style="top: 45px;" class="tooltiptext">Next</span>\n' +
                        '                                                                </span>\n' +
                        '                                                            </td>\n' +
                        '                                                        </tr>');

                    var last_row = $('#products_table tbody tr:last');

                    last_row.find('.js-data-example-ajax').val(product);
                    last_row.find('.js-data-example-ajax1').val(supplier);
                    last_row.find('.js-data-example-ajax2').val(color);
                    last_row.find('.js-data-example-ajax3').val(model);

                    if(features)
                    {
                        $('#menu1').append('<div data-id="'+rowCount+'" style="margin: 0;" class="form-group">\n' + features + '</div>');

                        $('#menu1').find(`[data-id='${rowCount}']`).find('input[name="qty[]"]').val(qty);

                        if(childsafe == 1)
                        {
                            $('#menu1').find(`[data-id='${rowCount}']`).find('.childsafe-select').attr('name', 'childsafe_option' + rowCount);
                            $('#menu1').find(`[data-id='${rowCount}']`).find('.childsafe_diff').attr('name', 'childsafe_diff' + rowCount);
                            $('#menu1').find(`[data-id='${rowCount}']`).find('.childsafe-answer').attr('name', 'childsafe_answer' + rowCount);
                            $('#menu1').find(`[data-id='${rowCount}']`).find('.childsafe-btn').attr('data-id', rowCount);
                            $('#menu1').find(`[data-id='${rowCount}']`).find('.childsafe-select').val(childsafe_question);
                            $('#menu1').find(`[data-id='${rowCount}']`).find('.childsafe-answer').val(childsafe_answer);
                            $('#myModal3').find('.modal-body').append('<div class="childsafe-content-box" data-id="'+rowCount+'">\n' + childsafe_content + '</div>');
                        }

                        features_selects.each(function(index,select){

                            $('#menu1').find(`[data-id='${rowCount}']`).find('.feature-select').eq(index).val($(this).val());

                            if($(this).parent().find('.f_id').val() == 0)
                            {
                                $('#myModal').find('.modal-body').append('<div class="sub-tables" data-id="'+rowCount+'">\n' + subs + '</div>');
                            }

                        });

                        $('#menu1').find(`[data-id='${rowCount}']`).each(function(i, obj) {

                            $(obj).find('.ladderband-btn').attr('data-id', rowCount);
                            $(obj).find('.feature-select').attr('name', 'features' + rowCount + '[]');
                            $(obj).find('.f_price').attr('name', 'f_price' + rowCount + '[]');
                            $(obj).find('.f_id').attr('name', 'f_id' + rowCount + '[]');
                            $(obj).find('.f_area').attr('name', 'f_area' + rowCount + '[]');
                            $(obj).find('.sub_feature').attr('name', 'sub_feature' + rowCount + '[]');

                        });

                        $('#myModal').find('.modal-body').find(`[data-id='${rowCount}']`).each(function(i, obj) {

                            $(obj).find('.sizeA').each(function(b, obj1) {

                                if($(this).val() == 1)
                                {
                                    $(this).prev('input').prop("checked", true);
                                }

                            });

                            $(obj).find('.sizeB').each(function(c, obj2) {

                                if($(this).val() == 1)
                                {
                                    $(this).prev('input').prop("checked", true);
                                }

                            });

                            $(obj).find('.sub_product_id').attr('name', 'sub_product_id' + rowCount + '[]');
                            $(obj).find('.sizeA').attr('name', 'sizeA' + rowCount + '[]');
                            $(obj).find('.sizeB').attr('name', 'sizeB' + rowCount + '[]');
                            $(obj).find('.cus_radio').attr('name', 'cus_radio' + rowCount + '[]');
                            $(obj).find('.cus_radio').attr('data-id', rowCount);

                        });

                        $('#myModal3').find('.modal-body').find(`[data-id='${rowCount}']`).each(function(i, obj) {

                            $(obj).find('#childsafe_x').attr('name', 'childsafe_x' + rowCount);
                            $(obj).find('#childsafe_y').attr('name', 'childsafe_y' + rowCount);
                            $(obj).find('#childsafe_x').val(childsafe_x);
                            $(obj).find('#childsafe_y').val(childsafe_y);

                        });
                    }

                    focus_row(last_row);

                    last_row.find(".js-data-example-ajax").select2({
                        width: '250px',
                        height: '200px',
                        placeholder: "{{__('text.Select Product')}}",
                        allowClear: true,
                        "language": {
                            "noResults": function(){
                                return '{{__('text.No results found')}}';
                            }
                        },
                    });

                    last_row.find(".js-data-example-ajax1").select2({
                        width: '100%',
                        height: '200px',
                        placeholder: "Select Supplier",
                        allowClear: true,
                        "language": {
                            "noResults": function(){
                                return '{{__('text.No results found')}}';
                            }
                        },
                    });

                    last_row.find(".js-data-example-ajax2").select2({
                        width: '100%',
                        height: '200px',
                        placeholder: "Select Color",
                        allowClear: true,
                        "language": {
                            "noResults": function(){
                                return '{{__('text.No results found')}}';
                            }
                        },
                    });

                    last_row.find(".js-data-example-ajax3").select2({
                        width: '100%',
                        height: '200px',
                        placeholder: "Select Model",
                        allowClear: true,
                        "language": {
                            "noResults": function(){
                                return '{{__('text.No results found')}}';
                            }
                        },
                    });
                }

                calculate_total();
            }

            $(document).on('click', '#products_table tbody tr', function(e){

                if(e.target.id !== "next-row-td" && e.target.id !== "next-row-span" && e.target.id !== "next-row-icon"){
                    focus_row($(this));
                }

            });

            $(document).on('click', '.next-row', function(){

                if($(this).parent().parent().next('tr').length == 0)
                {
                    add_row();
                }
                else
                {
                    var next_row = $(this).parent().parent().next('tr');
                    focus_row(next_row);
                }
            });

            $(document).on('click', '.add-row', function(){

                add_row();

            });

            $(document).on('click', '.remove-row', function(){

                var rowCount = $('#products_table tbody tr').length;

                var current = $('#products_table tbody tr.active');

                var id = current.data('id');

                if(rowCount != 1)
                {
                    $('#menu1').find(`[data-id='${id}']`).remove();
                    $('#myModal').find('.modal-body').find(`[data-id='${id}']`).remove();
                    $('#myModal2').find('.modal-body').find(`[data-id='${id}']`).remove();
                    $('#myModal3').find('.modal-body').find(`[data-id='${id}']`).remove();

                    var next = current.next('tr');

                    if(next.length < 1)
                    {
                        var next = current.prev('tr');
                    }

                    focus_row(next);

                    current.remove();

                    numbering();
                    calculate_total();
                }

            });


            $(document).on('click', '.save-data', function(){

                var customer = $('.customer-select').val();
                var flag = 0;

                if(!customer)
                {
                    flag = 1;
                    $('#cus-box .select2-container--default .select2-selection--single').css('border-color','red');
                }
                else
                {
                    $('#cus-box .select2-container--default .select2-selection--single').css('border-color','#cacaca');
                }


                $("[name='suppliers[]']").each(function(i, obj) {

                    if(!$(this).parent().hasClass('hide'))
                    {
                        if(!obj.value)
                        {
                            flag = 1;
                            $(obj).next().find('.select2-selection').css('border','1px solid red');
                        }
                        else
                        {
                            $(obj).next().find('.select2-selection').css('border','0');
                        }
                    }

                });

                $("[name='products[]']").each(function(i, obj) {

                    if(!obj.value)
                    {
                        flag = 1;
                        $(obj).next().find('.select2-selection').css('border','1px solid red');
                    }
                    else
                    {
                        $(obj).next().find('.select2-selection').css('border','0');
                    }

                });


                $("[name='colors[]']").each(function(i, obj) {

                    if(!obj.value)
                    {
                        flag = 1;
                        $(obj).next().find('.select2-selection').css('border','1px solid red');
                    }
                    else
                    {
                        $(obj).next().find('.select2-selection').css('border','0');
                    }

                });

                var conflict_feature = 0;

                $("[name='row_id[]']").each(function () {

                    var id = $(this).val();
                    var conflict_flag = 0;

                    var childsafe = $("[name='childsafe_option" + id + "']").val();

                    if(!childsafe && childsafe != undefined)
                    {
                        flag = 1;
                        conflict_feature = 1;
                        $("[name='childsafe_option" + id + "']").css('border-bottom','1px solid red');
                    }
                    else
                    {
                        $("[name='childsafe_option" + id + "']").css('border-bottom','1px solid lightgrey');
                    }

                    $("[name='features" + id + "[]']").each(function(i,obj) {

                        var selected_feature = $(this).val();
                        var feature_id = $(this).parent().find('.f_id').val();

                        if(feature_id != 0)
                        {
                            if(selected_feature == 0)
                            {
                                flag = 1;
                                conflict_feature = 1;
                                $(this).css('border-bottom','1px solid red');
                            }
                            else
                            {
                                $(this).css('border-bottom','1px solid lightgrey');
                            }
                        }

                    });

                    $("[name='f_area" + id + "[]']").each(function() {

                        var conflict = $(this).val();

                        if(conflict == 1)
                        {
                            conflict_flag = 1;
                        }

                    });


                    if(conflict_flag == 1)
                    {
                        flag = 1;
                        $('#products_table tbody').find(`[data-id='${id}']`).find('.width').find('.m-input').css('border','1px solid red');
                        $('#products_table tbody').find(`[data-id='${id}']`).find('.height').find('.m-input').css('border','1px solid red');
                    }
                    else
                    {
                        var area_conflict = $('#products_table tbody').find(`[data-id='${id}']`).find('#area_conflict').val();

                        if(area_conflict == 3)
                        {
                            flag = 1;
                            $('#products_table tbody').find(`[data-id='${id}']`).find('.width').find('.m-input').css('border','1px solid red');
                            $('#products_table tbody').find(`[data-id='${id}']`).find('.height').find('.m-input').css('border','1px solid red');
                        }
                        else if(area_conflict == 2)
                        {
                            flag = 1;
                            $('#products_table tbody').find(`[data-id='${id}']`).find('.width').find('.m-input').css('border','0');
                            $('#products_table tbody').find(`[data-id='${id}']`).find('.height').find('.m-input').css('border','1px solid red');
                        }
                        else if(area_conflict == 1)
                        {
                            flag = 1;
                            $('#products_table tbody').find(`[data-id='${id}']`).find('.width').find('.m-input').css('border','1px solid red');
                            $('#products_table tbody').find(`[data-id='${id}']`).find('.height').find('.m-input').css('border','0');
                        }
                        else
                        {
                            if(!$('#products_table tbody').find(`[data-id='${id}']`).find('.width').find('.m-input').val())
                            {
                                flag = 1;
                                $('#products_table tbody').find(`[data-id='${id}']`).find('.width').find('.m-input').css('border','1px solid red');
                            }
                            else
                            {
                                $('#products_table tbody').find(`[data-id='${id}']`).find('.width').find('.m-input').css('border','0');
                            }

                            if(!$('#products_table tbody').find(`[data-id='${id}']`).find('.height').find('.m-input').val())
                            {
                                flag = 1;
                                $('#products_table tbody').find(`[data-id='${id}']`).find('.height').find('.m-input').css('border','1px solid red');
                            }
                            else
                            {
                                $('#products_table tbody').find(`[data-id='${id}']`).find('.height').find('.m-input').css('border','0');
                            }
                        }
                    }

                });

                if(conflict_feature)
                {
                    Swal.fire({
                        icon: 'error',
                        title: '{{__('text.Oops...')}}',
                        text: 'Feature should not be empty!',
                    });
                }

                if(!flag)
                {
                    $('#form-quote').submit();
                }

            });


            $(document).on('click', '.copy-row', function(){

                var current = $('#products_table tbody tr.active');
                var id = current.data('id');
                var childsafe = current.find('#childsafe').val();
                var ladderband = current.find('#ladderband').val();
                var ladderband_value = current.find('#ladderband_value').val();
                var ladderband_price_impact = current.find('#ladderband_price_impact').val();
                var ladderband_impact_type = current.find('#ladderband_impact_type').val();
                var area_conflict = current.find('#area_conflict').val();
                var delivery_days = current.find('#delivery_days').val();
                var rate = current.find('#rate').val();
                var basic_price = current.find('#basic_price').val();
                var price = current.find('#row_total').val();
                var products = current.find('.js-data-example-ajax').html();
                var product = current.find('.js-data-example-ajax').val();
                var suppliers = current.find('.js-data-example-ajax1').html();
                var supplier = current.find('.js-data-example-ajax1').val();
                var colors = current.find('.js-data-example-ajax2').html();
                var color = current.find('.js-data-example-ajax2').val();
                var models = current.find('.js-data-example-ajax3').html();
                var model = current.find('.js-data-example-ajax3').val();
                var model_impact_value = current.find('.model_impact_value').val();
                var width = current.find('.width').find('.m-input').val();
                var width_unit = current.find('.width').find('.measure-unit').val();
                var height = current.find('.height').find('.m-input').val();
                var height_unit = current.find('.height').find('.measure-unit').val();
                var price_text = current.find('.price').text();
                var features = $('#menu1').find(`[data-id='${id}']`).html();
                var childsafe_question = $('#menu1').find(`[data-id='${id}']`).find('.childsafe-select').val();
                var childsafe_answer = $('#menu1').find(`[data-id='${id}']`).find('.childsafe-answer').val();
                var features_selects = $('#menu1').find(`[data-id='${id}']`).find('.feature-select');
                var qty = $('#menu1').find(`[data-id='${id}']`).find('input[name="qty[]"]').val();
                var subs = $('#myModal').find('.modal-body').find(`[data-id='${id}']`).html();
                var childsafe_content = $('#myModal3').find('.modal-body').find(`[data-id='${id}']`).html();
                var childsafe_x = $('#myModal3').find('.modal-body').find(`[data-id='${id}']`).find('#childsafe_x').val();
                var childsafe_y = $('#myModal3').find('.modal-body').find(`[data-id='${id}']`).find('#childsafe_y').val();
                var price_based_option = current.find('#price_based_option').val();
                var base_price = current.find('#base_price').val();

                var width_readonly = '';
                var height_readonly = '';

                if(price_based_option == 2)
                {
                    height_readonly = 'readonly';
                }
                else if(price_based_option == 3)
                {
                    width_readonly = 'readonly';
                }

                add_row(true,rate,basic_price,price,products,product,suppliers,supplier,colors,color,models,model,model_impact_value,width,width_unit,height,height_unit,price_text,features,features_selects,childsafe_question,childsafe_answer,qty,childsafe,ladderband,ladderband_value,ladderband_price_impact,ladderband_impact_type,area_conflict,subs,childsafe_content,childsafe_x,childsafe_y,delivery_days,price_based_option,base_price,width_readonly,height_readonly);

            });

            $(document).on('keypress', "input[name='qty[]']", function(e){

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

                var num = $(this).attr("maskedFormat").toString().split(',');
                var regex = new RegExp("^\\d{0," + num[0] + "}(\\,\\d{0," + num[1] + "})?$");
                if (!regex.test(this.value)) {
                    this.value = this.value.substring(0, this.value.length - 1);
                }

            });

            $(document).on('keypress', ".childsafe_values", function(e){

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

            $(document).on('input', "input[name='qty[]']", function(e) {

                calculate_total();

            });

            $(document).on('keypress', "input[name='width[]']", function(e){

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

            $(document).on('keypress', "input[name='height[]']", function(e){

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

            $(document).on('focusout', "input[name='qty[]']", function(e){

                if(!$(this).val())
                {
                    $(this).val(0);
                }

                if($(this).val().slice($(this).val().length - 1) == ',')
                {
                    var val = $(this).val();
                    val = val + '00';
                    $(this).val(val);
                }
            });

            $(document).on('focusout', "input[name='width[]']", function(e){

                if($(this).val().slice($(this).val().length - 1) == ',')
                {
                    var val = $(this).val();
                    val = val + '00';
                    $(this).val(val);
                }
            });

            $(document).on('focusout', "input[name='height[]']", function(e){
                if($(this).val().slice($(this).val().length - 1) == ',')
                {
                    var val = $(this).val();
                    val = val + '00';
                    $(this).val(val);
                }
            });

            $(document).on('input', "input[name='width[]']", function(e){

                var current = $(this);
                var row_id = current.parent().parent().parent().data('id');

                var price_based_option = current.parent().parent().parent().find('#price_based_option').val();
                var base_price = current.parent().parent().parent().find('#base_price').val();

                var width = current.val();
                width = width.replace(/\,/g, '.');

                var height = current.parent().parent().next('.height').find('.m-input').val();
                height = height.replace(/\,/g, '.');

                var color = current.parent().parent().parent().find('.color').find('select').val();
                var model = current.parent().parent().parent().find('.model').find('select').val();
                var product = current.parent().parent().parent().find('.products').find('select').val();
                var ladderband = current.parent().parent().parent().find('#ladderband').val();
                current.parent().parent().parent().find('#area_conflict').val(0);

                if(width && height && color && model && product)
                {
                    if($(this).parent().parent().parent().find('.suppliers').hasClass('hide'))
                    {
                        var margin = 0;
                    }
                    else
                    {
                        var margin = 1;
                    }

                    $.ajax({
                        type:"GET",
                        data: "product=" + product + "&color=" + color + "&model=" + model + "&width=" + width + "&height=" + height + "&margin=" + margin,
                        url: "<?php echo url('/aanbieder/get-price')?>",
                        success: function(data) {

                            if(typeof data[0].value !== 'undefined')
                            {
                                current.parent().parent().parent().find('#childsafe').val(data[3].childsafe);
                                var childsafe = data[3].childsafe;

                                if(data[0].value === 'both')
                                {
                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{__('text.Oops...')}}',
                                        html: 'Width & Height are greater than max values <br> Max Width: '+data[0].max_width+'<br> Max Height: '+data[0].max_height,
                                    });

                                    current.parent().parent().parent().find('.price').text('');
                                    current.parent().parent().parent().find('#row_total').val('');
                                    current.parent().parent().parent().find('#rate').val('');
                                    current.parent().parent().parent().find('#basic_price').val('');
                                    current.parent().parent().parent().find('#area_conflict').val(3);
                                }
                                else if(data[0].value === 'x_axis')
                                {
                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{__('text.Oops...')}}',
                                        html: 'Width is greater than max value <br> Max Width: '+data[0].max_width,
                                    });

                                    current.parent().parent().parent().find('.price').text('');
                                    current.parent().parent().parent().find('#row_total').val('');
                                    current.parent().parent().parent().find('#rate').val('');
                                    current.parent().parent().parent().find('#basic_price').val('');
                                    current.parent().parent().parent().find('#area_conflict').val(1);
                                }
                                else if(data[0].value === 'y_axis')
                                {

                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{__('text.Oops...')}}',
                                        html: 'Height is greater than max value <br> Max Height: '+data[0].max_height,
                                    });

                                    current.parent().parent().parent().find('.price').text('');
                                    current.parent().parent().parent().find('#row_total').val('');
                                    current.parent().parent().parent().find('#rate').val('');
                                    current.parent().parent().parent().find('#basic_price').val('');
                                    current.parent().parent().parent().find('#area_conflict').val(2);
                                }
                                else
                                {
                                    $('#myModal').find('.modal-body').find(`[data-id='${row_id}']`).remove();
                                    $('#myModal3').find('.modal-body').find(`[data-id='${row_id}']`).remove();

                                    if(price_based_option == 1)
                                    {
                                        var price = data[0].value;
                                        var org = data[0].value;
                                    }
                                    else
                                    {
                                        var price = base_price;
                                        var org = base_price;
                                    }

                                    if(margin == 1)
                                    {
                                        if(data[2])
                                        {
                                            price = parseFloat(price);
                                            var supplier_margin = data[2].margin;
                                            var retailer_margin = data[2].retailer_margin;

                                            if(supplier_margin && retailer_margin)
                                            {
                                                price = (price / supplier_margin) * retailer_margin;
                                                price = price.toFixed(2);
                                            }
                                        }
                                    }

                                    var features = '';
                                    var f_value = 0;

                                    if(childsafe == 1)
                                    {
                                        var content = '<div class="row childsafe-question-box" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
                                            '<label style="margin-right: 10px;margin-bottom: 0;">Childsafe</label>'+
                                            '<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control childsafe-select" name="childsafe_option'+ row_id +'">\n' +
                                            '<option value="">Select any option</option>\n' +
                                            '<option value="2">Add childsafety clip</option>\n' +
                                            '</select>\n' +
                                            '<input value="0" name="childsafe_diff'+ row_id +'" class="childsafe_diff" type="hidden">'+
                                            '</div><a data-id="'+ row_id +'" class="info childsafe-btn">Info</a></div>\n';

                                        features = features + content;

                                        $('#myModal3').find('.modal-body').append(
                                            '<div class="childsafe-content-box" data-id="'+row_id+'">\n' +
                                            '                                            <div style="margin: 20px 0;" class="row">\n' +
                                            '                                                <div style="display: flex;align-items: center;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">\n' +
                                            '                                                    <label style="width: 15%;margin-right: 10px;">Width</label>\n' +
                                            '                                                    <input type="number" class="form-control childsafe_values" id="childsafe_x" name="childsafe_x'+row_id+'">\n' +
                                            '                                                </div>\n' +
                                            '                                            </div>\n' +
                                            '                                            <div style="margin: 20px 0;" class="row">\n' +
                                            '                                                <div style="display: flex;align-items: center;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">\n' +
                                            '                                                    <label style="width: 15%;margin-right: 10px;">Height</label>\n' +
                                            '                                                    <input type="number" class="form-control childsafe_values" id="childsafe_y" name="childsafe_y'+row_id+'">\n' +
                                            '                                                </div>\n' +
                                            '                                            </div>\n' +
                                            '                                        </div>'
                                        );
                                    }

                                    if(ladderband == 1)
                                    {
                                        var content = '<div class="row" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
                                            '<label style="margin-right: 10px;margin-bottom: 0;">Ladderband</label>'+
                                            '<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features'+ row_id +'[]">\n' +
                                            '<option value="0">No</option>\n' +
                                            '<option value="1">Yes</option>\n' +
                                            '</select>\n' +
                                            '<input value="0" name="f_price'+ row_id +'[]" class="f_price" type="hidden">'+
                                            '<input value="0" name="f_id'+ row_id +'[]" class="f_id" type="hidden">'+
                                            '<input value="0" name="f_area'+ row_id +'[]" class="f_area" type="hidden">'+
                                            '<input value="0" name="sub_feature'+ row_id +'[]" class="sub_feature" type="hidden">'+
                                            '</div><a data-id="'+ row_id +'" class="info ladderband-btn hide">Info</a></div>\n';

                                        features = features + content;
                                    }

                                    $.each(data[1], function(index, value) {

                                        var opt = '<option value="0">Select Feature</option>';

                                        $.each(value.features, function(index1, value1) {

                                            opt = opt + '<option value="'+value1.id+'">'+value1.title+'</option>';

                                        });

                                        if(value.comment_box == 1)
                                        {
                                            var icon = '<a data-feature="'+value.id+'" class="info comment-btn">Info</a>';
                                        }
                                        else
                                        {
                                            var icon = '';
                                        }

                                        var content = '<div class="row" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
                                            '<label style="margin-right: 10px;margin-bottom: 0;">'+value.title+'</label>'+
                                            '<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features'+ row_id +'[]">'+opt+'</select>\n' +
                                            '<input value="'+f_value+'" name="f_price'+ row_id +'[]" class="f_price" type="hidden">'+
                                            '<input value="'+value.id+'" name="f_id'+ row_id +'[]" class="f_id" type="hidden">'+
                                            '<input value="0" name="f_area'+ row_id +'[]" class="f_area" type="hidden">'+
                                            '<input value="0" name="sub_feature'+ row_id +'[]" class="sub_feature" type="hidden">'+
                                            '</div>' + icon + '</div>\n';

                                        features = features + content;

                                    });

                                    if($('#menu1').find(`[data-id='${row_id}']`).length > 0)
                                    {
                                        $('#menu1').find(`[data-id='${row_id}']`).remove();
                                    }

                                    $('#menu1').append('<div data-id="'+row_id+'" style="margin: 0;" class="form-group">' +
                                        '\n' +
                                        '<div class="row" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
                                        '<label style="margin-right: 10px;margin-bottom: 0;">Quantity</label>'+
                                        '<input value="1" style="border: none;border-bottom: 1px solid lightgrey;" maskedformat="9,1" name="qty[]" class="form-control" type="text" /><span>pcs</span>' +
                                        '</div></div>' + features +
                                        '</div>');

                                    if(data[3].max_size)
                                    {
                                        var sq = (width * height) / 10000;
                                        var max_size = data[3].max_size;

                                        if(sq > max_size)
                                        {
                                            Swal.fire({
                                                icon: 'error',
                                                title: '{{__('text.Oops...')}}',
                                                text: 'Area is greater than max size: ' + max_size,
                                            });

                                            current.parent().find('.f_area').val(1);
                                        }
                                    }
                                    else
                                    {
                                        current.parent().find('.f_area').val(0);
                                    }

                                    /*var impact_value = current.parent().parent().parent().find('.model').find('.model_impact_value').val();*/
                                    var basic_price = $('#products_table tbody').find(`[data-id='${row_id}']`).find('#basic_price').val();

                                    /*price = price - impact_value;*/

                                    if(data[3].price_impact == 1)
                                    {
                                        if(data[3].impact_type == 0)
                                        {
                                            var impact_value = data[3].value;
                                            impact_value = parseFloat(impact_value).toFixed(2);
                                            price = parseFloat(price) + parseFloat(impact_value);
                                            price = price.toFixed(2);
                                        }
                                        else
                                        {
                                            var impact_value = data[3].value;
                                            var per = (impact_value)/100;
                                            impact_value = basic_price * per;
                                            impact_value = parseFloat(impact_value).toFixed(2);
                                            price = parseFloat(price) + parseFloat(impact_value);
                                            price = price.toFixed(2);
                                        }
                                    }
                                    else
                                    {
                                        var impact_value = 0;
                                        price = parseFloat(price) + parseFloat(impact_value);
                                        price = price.toFixed(2);
                                    }

                                    current.parent().parent().parent().find('.model').find('.model_impact_value').val(impact_value);
                                    current.parent().parent().parent().find('.price').text('€ ' + Math.round(price));
                                    current.parent().parent().parent().find('#row_total').val(price);
                                    current.parent().parent().parent().find('#rate').val(price);
                                    current.parent().parent().parent().find('#basic_price').val(price);

                                }
                            }
                            else
                            {
                                current.parent().parent().parent().find('.price').text('');
                                current.parent().parent().parent().find('#row_total').val('');
                                current.parent().parent().parent().find('#rate').val('');
                                current.parent().parent().parent().find('#basic_price').val('');
                            }

                            calculate_total();
                        }
                    });
                }

            });

            $(document).on('input', "input[name='height[]']", function(e){

                var current = $(this);
                var row_id = current.parent().parent().parent().data('id');

                var price_based_option = current.parent().parent().parent().find('#price_based_option').val();
                var base_price = current.parent().parent().parent().find('#base_price').val();

                var height = current.val();
                height = height.replace(/\,/g, '.');

                var width = current.parent().parent().prev('.width').find('.m-input').val();
                width = width.replace(/\,/g, '.');

                var color = current.parent().parent().parent().find('.color').find('select').val();
                var model = current.parent().parent().parent().find('.model').find('select').val();
                var product = current.parent().parent().parent().find('.products').find('select').val();
                var ladderband = current.parent().parent().parent().find('#ladderband').val();
                current.parent().parent().parent().find('#area_conflict').val(0);

                if(width && height && color && model && product)
                {
                    if($(this).parent().parent().parent().find('.suppliers').hasClass('hide'))
                    {
                        var margin = 0;
                    }
                    else
                    {
                        var margin = 1;
                    }

                    $.ajax({
                        type:"GET",
                        data: "product=" + product + "&color=" + color + "&model=" + model + "&width=" + width + "&height=" + height + "&margin=" + margin,
                        url: "<?php echo url('/aanbieder/get-price')?>",
                        success: function(data) {

                            if(typeof data[0].value !== 'undefined')
                            {
                                current.parent().parent().parent().find('#childsafe').val(data[3].childsafe);
                                var childsafe = data[3].childsafe;

                                if(data[0].value === 'both')
                                {
                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{__('text.Oops...')}}',
                                        html: 'Width & Height are greater than max values <br> Max Width: '+data[0].max_width+'<br> Max Height: '+data[0].max_height,
                                    });

                                    current.parent().parent().parent().find('.price').text('');
                                    current.parent().parent().parent().find('#row_total').val('');
                                    current.parent().parent().parent().find('#rate').val('');
                                    current.parent().parent().parent().find('#basic_price').val('');
                                    current.parent().parent().parent().find('#area_conflict').val(3);
                                }
                                else if(data[0].value === 'x_axis')
                                {
                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{__('text.Oops...')}}',
                                        html: 'Width is greater than max value <br> Max Width: '+data[0].max_width,
                                    });

                                    current.parent().parent().parent().find('.price').text('');
                                    current.parent().parent().parent().find('#row_total').val('');
                                    current.parent().parent().parent().find('#rate').val('');
                                    current.parent().parent().parent().find('#basic_price').val('');
                                    current.parent().parent().parent().find('#area_conflict').val(1);
                                }
                                else if(data[0].value === 'y_axis')
                                {

                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{__('text.Oops...')}}',
                                        html: 'Height is greater than max value <br> Max Height: '+data[0].max_height,
                                    });

                                    current.parent().parent().parent().find('.price').text('');
                                    current.parent().parent().parent().find('#row_total').val('');
                                    current.parent().parent().parent().find('#rate').val('');
                                    current.parent().parent().parent().find('#basic_price').val('');
                                    current.parent().parent().parent().find('#area_conflict').val(2);
                                }
                                else
                                {
                                    $('#myModal').find('.modal-body').find(`[data-id='${row_id}']`).remove();
                                    $('#myModal3').find('.modal-body').find(`[data-id='${row_id}']`).remove();

                                    if(price_based_option == 1)
                                    {
                                        var price = data[0].value;
                                        var org = data[0].value;
                                    }
                                    else
                                    {
                                        var price = base_price;
                                        var org = base_price;
                                    }

                                    if(margin == 1)
                                    {
                                        if(data[2])
                                        {
                                            price = parseFloat(price);
                                            var supplier_margin = data[2].margin;
                                            var retailer_margin = data[2].retailer_margin;

                                            if(supplier_margin && retailer_margin)
                                            {
                                                price = (price / supplier_margin) * retailer_margin;
                                                price = price.toFixed(2);
                                            }
                                        }
                                    }

                                    var features = '';
                                    var f_value = 0;

                                    if(childsafe == 1)
                                    {
                                        var content = '<div class="row childsafe-question-box" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
                                            '<label style="margin-right: 10px;margin-bottom: 0;">Childsafe</label>'+
                                            '<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control childsafe-select" name="childsafe_option'+ row_id +'">\n' +
                                            '<option value="">Select any option</option>\n' +
                                            '<option value="2">Add childsafety clip</option>\n' +
                                            '</select>\n' +
                                            '<input value="0" name="childsafe_diff'+ row_id +'" class="childsafe_diff" type="hidden">'+
                                            '</div><a data-id="'+ row_id +'" class="info childsafe-btn">Info</a></div>\n';

                                        features = features + content;

                                        $('#myModal3').find('.modal-body').append(
                                            '<div class="childsafe-content-box" data-id="'+row_id+'">\n' +
                                            '                                            <div style="margin: 20px 0;" class="row">\n' +
                                            '                                                <div style="display: flex;align-items: center;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">\n' +
                                            '                                                    <label style="width: 15%;margin-right: 10px;">Width</label>\n' +
                                            '                                                    <input type="number" class="form-control childsafe_values" id="childsafe_x" name="childsafe_x'+row_id+'">\n' +
                                            '                                                </div>\n' +
                                            '                                            </div>\n' +
                                            '                                            <div style="margin: 20px 0;" class="row">\n' +
                                            '                                                <div style="display: flex;align-items: center;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">\n' +
                                            '                                                    <label style="width: 15%;margin-right: 10px;">Height</label>\n' +
                                            '                                                    <input type="number" class="form-control childsafe_values" id="childsafe_y" name="childsafe_y'+row_id+'">\n' +
                                            '                                                </div>\n' +
                                            '                                            </div>\n' +
                                            '                                        </div>'
                                        );
                                    }

                                    if(ladderband == 1)
                                    {
                                        var content = '<div class="row" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
                                            '<label style="margin-right: 10px;margin-bottom: 0;">Ladderband</label>'+
                                            '<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features'+ row_id +'[]">\n' +
                                            '<option value="0">No</option>\n' +
                                            '<option value="1">Yes</option>\n' +
                                            '</select>\n' +
                                            '<input value="0" name="f_price'+ row_id +'[]" class="f_price" type="hidden">'+
                                            '<input value="0" name="f_id'+ row_id +'[]" class="f_id" type="hidden">'+
                                            '<input value="0" name="f_area'+ row_id +'[]" class="f_area" type="hidden">'+
                                            '<input value="0" name="sub_feature'+ row_id +'[]" class="sub_feature" type="hidden">'+
                                            '</div><a data-id="'+ row_id +'" class="info ladderband-btn hide">Info</a></div>\n';

                                        features = features + content;
                                    }

                                    $.each(data[1], function(index, value) {

                                        var opt = '<option value="0">Select Feature</option>';

                                        $.each(value.features, function(index1, value1) {

                                            opt = opt + '<option value="'+value1.id+'">'+value1.title+'</option>';

                                        });

                                        if(value.comment_box == 1)
                                        {
                                            var icon = '<a data-feature="'+value.id+'" class="info comment-btn">Info</a>';
                                        }
                                        else
                                        {
                                            var icon = '';
                                        }

                                        var content = '<div class="row" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
                                            '<label style="margin-right: 10px;margin-bottom: 0;">'+value.title+'</label>'+
                                            '<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features'+ row_id +'[]">'+opt+'</select>\n' +
                                            '<input value="'+f_value+'" name="f_price'+ row_id +'[]" class="f_price" type="hidden">'+
                                            '<input value="'+value.id+'" name="f_id'+ row_id +'[]" class="f_id" type="hidden">'+
                                            '<input value="0" name="f_area'+ row_id +'[]" class="f_area" type="hidden">'+
                                            '<input value="0" name="sub_feature'+ row_id +'[]" class="sub_feature" type="hidden">'+
                                            '</div>' + icon + '</div>\n';

                                        features = features + content;

                                    });

                                    if($('#menu1').find(`[data-id='${row_id}']`).length > 0)
                                    {
                                        $('#menu1').find(`[data-id='${row_id}']`).remove();
                                    }

                                    $('#menu1').append('<div data-id="'+row_id+'" style="margin: 0;" class="form-group">' +
                                        '\n' +
                                        '<div class="row" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
                                        '<label style="margin-right: 10px;margin-bottom: 0;">Quantity</label>'+
                                        '<input value="1" style="border: none;border-bottom: 1px solid lightgrey;" maskedformat="9,1" name="qty[]" class="form-control" type="text" /><span>pcs</span>' +
                                        '</div></div>' + features +
                                        '</div>');

                                    if(data[3].max_size)
                                    {
                                        var sq = (width * height) / 10000;
                                        var max_size = data[3].max_size;

                                        if(sq > max_size)
                                        {
                                            Swal.fire({
                                                icon: 'error',
                                                title: '{{__('text.Oops...')}}',
                                                text: 'Area is greater than max size: ' + max_size,
                                            });

                                            current.parent().find('.f_area').val(1);
                                        }
                                    }
                                    else
                                    {
                                        current.parent().find('.f_area').val(0);
                                    }

                                    /*var impact_value = current.parent().parent().parent().find('.model').find('.model_impact_value').val();*/
                                    var basic_price = $('#products_table tbody').find(`[data-id='${row_id}']`).find('#basic_price').val();

                                    /*price = price - impact_value;*/

                                    if(data[3].price_impact == 1)
                                    {
                                        if(data[3].impact_type == 0)
                                        {
                                            var impact_value = data[3].value;
                                            impact_value = parseFloat(impact_value).toFixed(2);
                                            price = parseFloat(price) + parseFloat(impact_value);
                                            price = price.toFixed(2);
                                        }
                                        else
                                        {
                                            var impact_value = data[3].value;
                                            var per = (impact_value)/100;
                                            impact_value = basic_price * per;
                                            impact_value = parseFloat(impact_value).toFixed(2);
                                            price = parseFloat(price) + parseFloat(impact_value);
                                            price = price.toFixed(2);
                                        }
                                    }
                                    else
                                    {
                                        var impact_value = 0;
                                        price = parseFloat(price) + parseFloat(impact_value);
                                        price = price.toFixed(2);
                                    }

                                    current.parent().parent().parent().find('.model').find('.model_impact_value').val(impact_value);
                                    current.parent().parent().parent().find('.price').text('€ ' + Math.round(price));
                                    current.parent().parent().parent().find('#row_total').val(price);
                                    current.parent().parent().parent().find('#rate').val(price);
                                    current.parent().parent().parent().find('#basic_price').val(price);
                                }
                            }
                            else
                            {
                                current.parent().parent().parent().find('.price').text('');
                                current.parent().parent().parent().find('#row_total').val('');
                                current.parent().parent().parent().find('#rate').val('');
                                current.parent().parent().parent().find('#basic_price').val('');
                            }

                            calculate_total();
                        }
                    });
                }

            });

            $(document).on('input', '#childsafe_x, #childsafe_y', function()
            {
                var id = $(this).attr('id');
                var row_id = $(this).parent().parent().parent().data('id');

                if(id == 'childsafe_x')
                {
                    var x = $(this).val();
                    var y = $('#myModal3').find('.modal-body').find(`[data-id='${row_id}']`).find('#childsafe_y').val();
                }
                else
                {
                    var x = $('#myModal3').find('.modal-body').find(`[data-id='${row_id}']`).find('#childsafe_x').val();
                    var y = $(this).val();
                }

                var diff = x-y;
                diff = Math.abs(diff);

                if(x && y)
                {
                    $('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-answer-box').remove();
                    $('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-question-box').find('.childsafe-select').find('option').not(':first').remove();

                    if(diff <= 150)
                    {
                        $('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-question-box').find('.childsafe-select').append('<option value="1" selected>Please note not childsafe</option><option value="2">Add childsafety clip</option>');

                        $('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-question-box').after('<div class="row childsafe-answer-box" style="margin: 0;display: flex;align-items: center;">\n' +
                            '\n' +
                            '                                                                                        <div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
                            '                                                                                            <label style="margin-right: 10px;margin-bottom: 0">Childsafe Answer</label>\n' +
                            '                                                                                            <select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control childsafe-answer" name="childsafe_answer'+row_id+'">\n' +
                            '                                                                                                    <option value="1">Make it childsafe</option>\n' +
                            '                                                                                                    <option value="2">Yes i agree</option>\n' +
                            '                                                                                            </select>\n' +
                            '                                                                                        </div>\n' +
                            '\n' +
                            '                                                                                    </div>');
                    }
                    else
                    {
                        $('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-question-box').find('.childsafe-select').append('<option value="2">Add childsafety clip</option><option value="3" selected>Yes childsafe</option>');

                        $('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-question-box').after('<div class="row childsafe-answer-box" style="margin: 0;display: flex;align-items: center;">\n' +
                            '\n' +
                            '                                                                                        <div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
                            '                                                                                            <label style="margin-right: 10px;margin-bottom: 0;">Childsafe Answer</label>\n' +
                            '                                                                                            <select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control childsafe-answer" name="childsafe_answer'+row_id+'">\n' +
                            '                                                                                                    <option value="3">Is childsafe</option>\n' +
                            '                                                                                            </select>\n' +
                            '                                                                                        </div>\n' +
                            '\n' +
                            '                                                                                    </div>');
                    }

                    $('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-question-box').find('.childsafe_diff').val(diff);
                }
                else
                {
                    $('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-answer-box').remove();
                    $('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-question-box').find('.childsafe-select').find('option').not(':first').remove();
                    $('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-question-box').find('.childsafe-select').append('<option value="2">Add childsafety clip</option>');
                }

            });

            $(document).on('change', '.childsafe-select', function()
            {
                var current = $(this);
                var row_id = current.parent().parent().parent().data('id');
                var value = current.val();
                var value_x = $('#myModal3').find('.modal-body').find(`[data-id='${row_id}']`).find('#childsafe_x').val();
                var value_y = $('#myModal3').find('.modal-body').find(`[data-id='${row_id}']`).find('#childsafe_y').val();

                if(value_x && value_y)
                {
                    if(!value)
                    {
                        $('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-answer-box').remove();
                    }
                    else if(value == 2 || value == 3)
                    {
                        $('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-answer-box').remove();

                        $('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-question-box').after('<div class="row childsafe-answer-box" style="margin: 0;display: flex;align-items: center;">\n' +
                            '\n' +
                            '                                                                                        <div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
                            '                                                                                            <label style="margin-right: 10px;margin-bottom: 0;">Childsafe Answer</label>\n' +
                            '                                                                                            <select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control childsafe-answer" name="childsafe_answer'+row_id+'">\n' +
                            '                                                                                                    <option value="3">Is childsafe</option>\n' +
                            '                                                                                            </select>\n' +
                            '                                                                                        </div>\n' +
                            '\n' +
                            '                                                                                    </div>');
                    }
                    else
                    {
                        $('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-answer-box').remove();

                        $('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-question-box').after('<div class="row childsafe-answer-box" style="margin: 0;display: flex;align-items: center;">\n' +
                            '\n' +
                            '                                                                                        <div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
                            '                                                                                            <label style="margin-right: 10px;margin-bottom: 0">Childsafe Answer</label>\n' +
                            '                                                                                            <select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control childsafe-answer" name="childsafe_answer'+row_id+'">\n' +
                            '                                                                                                    <option value="1">Make it childsafe</option>\n' +
                            '                                                                                                    <option value="2">Yes i agree</option>\n' +
                            '                                                                                            </select>\n' +
                            '                                                                                        </div>\n' +
                            '\n' +
                            '                                                                                    </div>');
                    }
                }
                else
                {
                    current.val('');

                    Swal.fire({
                        icon: 'error',
                        title: '{{__('text.Oops...')}}',
                        text: 'Kindly fill both childsafe values first by clicking on "i" icon.',
                    });
                }

            });

            $(document).on('change', '.feature-select', function(){

                var current = $(this);
                var row_id = current.parent().parent().parent().data('id');
                var feature_select = current.val();
                var id = current.parent().find('.f_id').val();
                var width = $('#products_table tbody').find(`[data-id='${row_id}']`).find('.width').find('.m-input').val();
                var height = $('#products_table tbody').find(`[data-id='${row_id}']`).find('.height').find('.m-input').val();
                var product_id = $('#products_table tbody').find(`[data-id='${row_id}']`).find('.products').find('select').val();
                var ladderband_value = $('#products_table tbody').find(`[data-id='${row_id}']`).find('#ladderband_value').val();
                var ladderband_price_impact = $('#products_table tbody').find(`[data-id='${row_id}']`).find('#ladderband_price_impact').val();
                var ladderband_impact_type = $('#products_table tbody').find(`[data-id='${row_id}']`).find('#ladderband_impact_type').val();

                var impact_value = current.next('input').val();
                var total = $('#products_table tbody').find(`[data-id='${row_id}']`).find('#row_total').val();
                var basic_price = $('#products_table tbody').find(`[data-id='${row_id}']`).find('#basic_price').val();

                total = total - impact_value;

                if(id == 0)
                {
                    if(feature_select == 1)
                    {
                        if(ladderband_price_impact == 1)
                        {
                            if(ladderband_impact_type == 0)
                            {
                                impact_value = ladderband_value;
                                impact_value = parseFloat(impact_value).toFixed(2);
                                total = parseFloat(total) + parseFloat(impact_value);
                                total = total.toFixed(2);
                            }
                            else
                            {
                                impact_value = ladderband_value;
                                var per = (impact_value)/100;
                                impact_value = basic_price * per;
                                impact_value = parseFloat(impact_value).toFixed(2);
                                total = parseFloat(total) + parseFloat(impact_value);
                                total = total.toFixed(2);
                            }
                        }
                        else
                        {
                            impact_value = 0;
                            total = parseFloat(total) + parseFloat(impact_value);
                            total = total.toFixed(2);
                        }

                        current.next('input').val(impact_value);

                        $('#products_table tbody').find(`[data-id='${row_id}']`).find('.price').text('€ ' + Math.round(total));
                        $('#products_table tbody').find(`[data-id='${row_id}']`).find('#row_total').val(total);

                        calculate_total();

                        $.ajax({
                            type: "GET",
                            data: "product_id=" + product_id,
                            url: "<?php echo url('/aanbieder/get-sub-products-sizes')?>",
                            success: function (data) {

                                $('#myModal').find('.modal-body').find('.sub-tables').hide();

                                if($('#myModal').find('.modal-body').find(`[data-id='${row_id}']`).length > 0)
                                {
                                    $('#myModal').find('.modal-body').find(`[data-id='${row_id}']`).remove();
                                }


                                $('#myModal').find('.modal-body').append(
                                    '<div class="sub-tables" data-id="'+row_id+'">\n' +
                                    '<table style="width: 100%;">\n' +
                                    '<thead>\n' +
                                    '<tr>\n' +
                                    '<th>ID</th>\n' +
                                    '<th>Title</th>\n' +
                                    '<th>Size 38mm</th>\n' +
                                    '<th>Size 25mm</th>\n' +
                                    '</tr>\n' +
                                    '</thead>\n' +
                                    '<tbody>\n' +
                                    '</tbody>\n' +
                                    '</table>\n' +
                                    '</div>'
                                );

                                $.each(data, function(index, value) {

                                    var size1 = value.size1_value;
                                    var size2 = value.size2_value;

                                    if(size1 == 1)
                                    {
                                        size1 = '<input data-id="'+ row_id +'" class="cus_radio" name="cus_radio'+ row_id +'[]" type="radio"><input class="cus_value sizeA" type="hidden" value="0" name="sizeA'+ row_id +'[]">';
                                    }
                                    else
                                    {
                                        size1 = 'X' + '<input class="sizeA" name="sizeA'+ row_id +'[]" type="hidden" value="x">';
                                    }

                                    if(size2 == 1)
                                    {
                                        size2 = '<input data-id="'+ row_id +'" class="cus_radio" name="cus_radio'+ row_id +'[]" type="radio"><input class="cus_value sizeB" type="hidden" value="0" name="sizeB'+ row_id +'[]">';
                                    }
                                    else
                                    {
                                        size2 = 'X' + '<input class="sizeB" name="sizeB'+ row_id +'[]" type="hidden" value="x">';
                                    }

                                    $('#myModal').find('.modal-body').find(`[data-id='${row_id}']`).find('table').append(
                                        '<tr>\n' +
                                        '<td><input class="sub_product_id" type="hidden" name="sub_product_id'+ row_id + '[]" value="'+value.id+'">'+value.code+'</td>\n' +
                                        '<td>'+value.title+'</td>\n' +
                                        '<td>'+size1+'</td>\n' +
                                        '<td>'+size2+'</td>\n' +
                                        '</tr>\n'
                                    );

                                });

                                $('#menu1').find(`[data-id='${row_id}']`).find('.ladderband-btn').removeClass('hide');
                                /*$('.top-bar').css('z-index','1');*/
                                $('#myModal').modal('toggle');
                                $('.modal-backdrop').hide();
                            }
                        });
                    }
                    else
                    {
                        $('#menu1').find(`[data-id='${row_id}']`).find('.ladderband-btn').addClass('hide');
                        $('#myModal').find('.modal-body').find(`[data-id='${row_id}']`).remove();

                        impact_value = 0;
                        total = parseFloat(total) + parseFloat(impact_value);
                        total = total.toFixed(2);

                        current.next('input').val(impact_value);

                        $('#products_table tbody').find(`[data-id='${row_id}']`).find('.price').text('€ ' + Math.round(total));
                        $('#products_table tbody').find(`[data-id='${row_id}']`).find('#row_total').val(total);

                        calculate_total();
                    }
                }
                else
                {
                    var heading = current.find("option:selected").text();
                    var heading_id = current.val();

                    $.ajax({
                        type: "GET",
                        data: "id=" + feature_select,
                        url: "<?php echo url('/aanbieder/get-feature-price')?>",
                        success: function (data) {

                            if(current.parent().parent().next('.sub-features').length > 0)
                            {
                                var sub_impact_value = current.parent().parent().next('.sub-features').find('.f_price').val();
                                total = total - sub_impact_value;
                                current.parent().parent().next('.sub-features').remove();
                            }

                            if(data[1].length > 0)
                            {
                                var opt = '<option value="0">Select Feature</option>';

                                $.each(data[1], function(index, value) {

                                    opt = opt + '<option value="'+value.id+'">'+value.title+'</option>';

                                });

                                current.parent().parent().after('<div class="row sub-features" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
                                    '<label style="margin-right: 10px;margin-bottom: 0;">'+heading+'</label>'+
                                    '<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features'+ row_id +'[]">'+opt+'</select>\n' +
                                    '<input value="0" name="f_price'+ row_id +'[]" class="f_price" type="hidden">'+
                                    '<input value="'+heading_id+'" name="f_id'+ row_id +'[]" class="f_id" type="hidden">'+
                                    '<input value="0" name="f_area'+ row_id +'[]" class="f_area" type="hidden">'+
                                    '<input value="1" name="sub_feature'+ row_id +'[]" class="sub_feature" type="hidden">'+
                                    '</div></div>');
                            }

                            if(data[0] && data[0].max_size)
                            {
                                var sq = (width * height) / 10000;
                                var max_size = data[0].max_size;

                                if(sq > max_size)
                                {
                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{__('text.Oops...')}}',
                                        text: 'Area is greater than max size: ' + max_size,
                                    });

                                    current.parent().find('.f_area').val(1);
                                }
                            }
                            else
                            {
                                current.parent().find('.f_area').val(0);
                            }

                            if(data[0] && data[0].price_impact == 1)
                            {
                                if(data[0].variable == 1)
                                {
                                    impact_value = data[0].value;
                                    impact_value = impact_value * (width / 100);
                                    impact_value = parseFloat(impact_value).toFixed(2);
                                    total = parseFloat(total) + parseFloat(impact_value);
                                    total = total.toFixed(2);
                                }
                                else
                                {
                                    if(data[0].impact_type == 0)
                                    {
                                        impact_value = data[0].value;
                                        impact_value = parseFloat(impact_value).toFixed(2);
                                        total = parseFloat(total) + parseFloat(impact_value);
                                        total = total.toFixed(2);
                                    }
                                    else
                                    {
                                        impact_value = data[0].value;
                                        var per = (impact_value)/100;
                                        impact_value = basic_price * per;
                                        impact_value = parseFloat(impact_value).toFixed(2);
                                        total = parseFloat(total) + parseFloat(impact_value);
                                        total = total.toFixed(2);
                                    }
                                }
                            }
                            else
                            {
                                impact_value = 0;
                                total = parseFloat(total) + parseFloat(impact_value);
                                total = total.toFixed(2);
                            }

                            current.next('input').val(impact_value);

                            $('#products_table tbody').find(`[data-id='${row_id}']`).find('.price').text('€ ' + Math.round(total));
                            $('#products_table tbody').find(`[data-id='${row_id}']`).find('#row_total').val(total);

                            calculate_total();
                        }
                    });
                }

            });

            /*$('#myModal, #myModal2').on('hidden.bs.modal', function () {
                $('.top-bar').css('z-index','1000');
            });*/

            $(document).on('click', '.comment-btn', function(){

                var current = $(this);
                var row_id = current.parent().parent().data('id');
                var feature_id = current.data('feature');

                $('#myModal2').find('.modal-body').find('.comment-boxes').hide();

                if($('#myModal2').find('.modal-body').find(`[data-id='${row_id}']`).find(`[data-id='${feature_id}']`).length > 0)
                {
                    var box = $('#myModal2').find('.modal-body').find(`[data-id='${row_id}']`).find(`[data-id='${feature_id}']`);
                    box.parent().show();
                }
                else
                {
                    $('#myModal2').find('.modal-body').append(
                        '<div class="comment-boxes" data-id="'+row_id+'">\n' +
                        '<textarea style="resize: vertical;width: 100%;border: 1px solid #c9c9c9;border-radius: 5px;outline: none;" data-id="'+ feature_id +'" rows="5" name="comment-'+ row_id + '-' + feature_id +'"></textarea>\n' +
                        '</div>'
                    );
                }

                /*$('.top-bar').css('z-index','1');*/
                $('#myModal2').modal('toggle');
                $('.modal-backdrop').hide();

            });

            $(document).on('click', '.ladderband-btn', function(){

                var current = $(this);
                var row_id = current.data('id');

                $('#myModal').find('.modal-body').find('.sub-tables').hide();
                $('#myModal').find('.modal-body').find(`[data-id='${row_id}']`).show();

                /*$('.top-bar').css('z-index','1');*/
                $('#myModal').modal('toggle');
                $('.modal-backdrop').hide();

            });

            $(document).on('click', '.childsafe-btn', function(){

                var current = $(this);
                var row_id = current.data('id');

                $('#myModal3').find('.modal-body').find('.childsafe-content-box').hide();
                $('#myModal3').find('.modal-body').find(`[data-id='${row_id}']`).show();

                /*$('.top-bar').css('z-index','1');*/
                $('#myModal3').modal('toggle');
                $('.modal-backdrop').hide();

            });

            $(document).on('change', '.cus_radio', function(){

                var row_id = $(this).data('id');

                $('#myModal').find('.modal-body').find(`[data-id='${row_id}']`).find('.cus_radio').next('input').val(0);
                $(this).next('input').val(1);

            });


        });
    </script>

@endsection
