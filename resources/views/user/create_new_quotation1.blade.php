@extends('layouts.handyman')

@section('content')

	<script src="{{asset('assets/admin/js/main1.js')}}"></script>
	<script src="{{asset('assets/admin/js/bootstrap-tagsinput.js')}}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js"></script>
	<script src="{{asset('assets/admin/js/bootstrap-datetimepicker.min.js')}}"></script>

	<div class="right-side">

		<div class="container-fluid">
			<div class="row">

				<form id="form-quote" style="padding: 0;" class="form-horizontal" action="{{route('store-new-quotation')}}"
					  method="POST" enctype="multipart/form-data">
					{{csrf_field()}}

					<input type="hidden" name="form_type" value="2">
					<input type="hidden" name="quotation_id" value="{{isset($invoice) ? $invoice[0]->invoice_id : null}}">
					<input type="hidden" name="is_invoice" value="{{isset($invoice) ? (Route::currentRouteName() == 'view-new-quotation' ? 0 : 1) : 0}}">
					<input type="hidden" name="negative_invoice" value="{{Route::currentRouteName() == 'create-new-negative-invoice' ? 1 : 0}}">
					<input type="hidden" name="negative_invoice_id" value="{{isset($invoice) ? (Route::currentRouteName() == 'create-new-negative-invoice' ? ($invoice[0]->negative_invoice != 0 ? $invoice[0]->invoice_id : null) : null) : null}}">

					<div style="margin: 0;" class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<!-- Starting of Dashboard data-table area -->
							<div class="section-padding add-product-1" style="padding: 0;">

								<div style="margin: 0;" class="row">
									<div style="padding: 0;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div style="box-shadow: none;" class="add-product-box">
											<div style="align-items: center;" class="add-product-header products">

												<h2 style="margin-top: 0;">{{isset($invoice) ? (Route::currentRouteName() == 'view-new-quotation' ? __('text.View Quotation') : (Route::currentRouteName() == 'create-new-negative-invoice' ? __('text.Create Negative Invoice') : __('text.View Invoice') )) : __('text.Create Quotation')}}</h2>

												<div style="background-color: black;border-radius: 10px;padding: 0 10px;">

													@if(Route::currentRouteName() == 'view-new-invoice' || Route::currentRouteName() == 'create-new-negative-invoice')

														<span class="tooltip1 save-data" style="cursor: pointer;font-size: 20px;margin-right: 10px;color: white;">
															<i class="fa fa-fw fa-save"></i>
															<span class="tooltiptext">{{__('text.Save')}}</span>
														</span>

													@else

														@if((isset($invoice) && ($invoice[0]->status == 0 || $invoice[0]->status == 1 || $invoice[0]->status == 2 || $invoice[0]->ask_customization)) || !isset($invoice))

															<span class="tooltip1 save-data" style="cursor: pointer;font-size: 20px;margin-right: 10px;color: white;">
																<i class="fa fa-fw fa-save"></i>
																<span class="tooltiptext">{{__('text.Save')}}</span>
															</span>

														@endif

													@endif

													<a href="{{route('customer-quotations')}}" class="tooltip1" style="cursor: pointer;font-size: 20px;color: white;">
														<i class="fa fa-fw fa-close"></i>
														<span class="tooltiptext">{{__('text.Close')}}</span>
													</a>

												</div>

											</div>

											<hr>

											<div class="col-md-5">
												<div class="form-group" style="margin: 0;">

													<label>{{__('text.Customer')}}</label>

													<div id="cus-box" style="display: flex;">
														<select class="customer-select form-control" name="customer"
																required>

															<option value="">{{__('text.Select Customer')}}</option>

															@foreach($customers as $key)

																<option {{isset($invoice) ? ($invoice[0]->user_id ==
																$key->user_id ? 'selected' : null) : null}}
																		value="{{$key->id}}">{{$key->name}}
																	{{$key->family_name}}</option>

															@endforeach

														</select>

														@if(Route::currentRouteName() == 'view-new-invoice' || Route::currentRouteName() == 'create-new-negative-invoice')

															<button type="button" href="#myModal1" role="button" data-toggle="modal" style="outline: none;margin-left: 10px;" class="btn btn-primary">{{__('text.Add New Customer')}}</button>

														@else

															@if((isset($invoice) && ($invoice[0]->status == 0 || $invoice[0]->status == 1 || $invoice[0]->ask_customization)) || !isset($invoice))

																<button type="button" href="#myModal1" role="button" data-toggle="modal" style="outline: none;margin-left: 10px;" class="btn btn-primary">{{__('text.Add New Customer')}}</button>

															@endif

														@endif

													</div>
												</div>
											</div>

											<div style="display: inline-block;width: 100%;">

												<div class="alert-box">

												</div>

												@include('includes.form-success')

												<div style="padding-bottom: 0;" class="form-horizontal">

													<div style="margin: 0;border-top: 1px solid #eee;" class="row">

														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 second-row" style="padding-bottom: 15px;">

															<section id="products_table" style="width: 100%;">

																<div class="header-div">
																	<div class="headings" style="width: 2%;"></div>
																	<div class="headings" style="width: 12%;" @if(auth()->user()->role_id == 4) style="display: none;" @endif>{{__('text.Supplier')}}</div>
																	<div class="headings" style="width: 22%;">{{__('text.Product')}}</div>
																	<div class="headings" style="width: 10%;">{{__('text.Width')}}</div>
																	<div class="headings" style="width: 10%;">{{__('text.Height')}}</div>
																	<div class="headings" style="width: 7%;">{{__('text.€ Art.')}}</div>
																	<div class="headings" style="width: 7%;">{{__('text.€ Arb.')}}</div>
																	<div class="headings" style="width: 10%;">{{__('text.Discount')}}</div>
																	<div class="headings" style="width: 7%;">{{__('text.€ Total')}}</div>
																	<div class="headings" style="width: 13%;"></div>
																</div>

																@if(isset($invoice))

																	@foreach($invoice as $i => $item)

																		<div @if($i==0) class="content-div active" @else class="content-div" @endif data-id="{{$i+1}}">

																			<div class="content full-res item1" style="width: 2%;">
																				<label class="content-label">Sr. No</label>
																				<div style="padding: 0 5px;" class="sr-res">{{$i+1}}</div>
																			</div>

																			<input type="hidden" value="{{$item->order_number}}" id="order_number" name="order_number[]">
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
																			<input type="hidden" value="{{$item->supplier_margin}}" id="supplier_margin" name="supplier_margin[]">
																			<input type="hidden" value="{{$item->retailer_margin}}" id="retailer_margin" name="retailer_margin[]">

																			<div style="width: 12%;" @if(auth()->user()->role_id == 4) class="content item2 full-res suppliers hide" @else class="content item2 full-res suppliers" @endif>

																				<label class="content-label">Supplier</label>

																				<select name="suppliers[]" class="js-data-example-ajax1">

																					<option value=""></option>

																					@foreach($suppliers as $key)

																						<option {{$key->id == $item->supplier_id ? 'selected' : null}} value="{{$key->id}}">{{$key->company_name}}</option>

																					@endforeach

																				</select>

																			</div>

																			<div style="width: 22%;" class="products content item3 full-res">

																				<label class="content-label">Product</label>

																				<select name="products[]" class="js-data-example-ajax">

																					<option value=""></option>

																					@foreach($supplier_products[$i] as $key)

																						<option {{$key->id == $item->product_id ? 'selected' : null}} value="{{$key->id}}">{{$key->title}}</option>

																					@endforeach

																				</select>

																			</div>

																			<div class="width item4 content" style="width: 10%;">

																				<label class="content-label">Width</label>

																				<div class="m-box">
																					<input {{$item->price_based_option == 3 ? 'readonly' : null}} value="{{str_replace('.', ',', floatval($item->width))}}" class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="width[]" type="text">
																					<input style="border: 0;outline: none;" readonly type="text" name="width_unit[]" class="measure-unit" value="{{$item->width_unit}}">
																				</div>
																			</div>

																			<div class="height item5 content" style="width: 10%;">

																				<label class="content-label">Height</label>

																				<div class="m-box">
																					<input {{$item->price_based_option == 2 ? 'readonly' : null}} value="{{str_replace('.', ',', floatval($item->height))}}" class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="height[]" type="text">
																					<input style="border: 0;outline: none;" readonly type="text" name="height_unit[]" class="measure-unit" value="{{$item->height_unit}}">
																				</div>
																			</div>

																			<div class="content item6" style="width: 7%;">

																				<label class="content-label">€ Art.</label>

																				<div style="display: flex;align-items: center;">
																					<span>€</span>
																					<input type="text" value="{{number_format((float)$item->price_before_labor, 2, ',', '')}}" readonly name="price_before_labor[]" style="border: 0;background: transparent;padding: 0 5px;" class="form-control price_before_labor res-white">
																					<input type="hidden" value="{{$item->price_before_labor/$item->qty}}" class="price_before_labor_old">
																				</div>
																			</div>

																			<div class="content item7" style="width: 7%;">

																				<label class="content-label">€ Arb.</label>

																				<div style="display: flex;align-items: center;">
																					<span>€</span>
																					<input type="text" value="{{number_format((float)$item->labor_impact, 2, ',', '')}}" name="labor_impact[]" maskedFormat="9,1" class="form-control labor_impact res-white">
																					<input type="hidden" value="{{$item->labor_impact/$item->qty}}" class="labor_impact_old">
																				</div>
																			</div>

																			<div class="content item8" style="width: 10%;">

																				<label class="content-label">Discount</label>

																				<span>€</span>
																				<input type="text" value="{{str_replace('.', ',',floatval($item->total_discount))}}" name="total_discount[]" readonly style="border: 0;background: transparent;padding: 0 5px;height: 30px;" class="form-control total_discount res-white">
																				<input type="hidden" value="{{$item->total_discount/$item->qty}}" class="total_discount_old">
																			</div>

																			<div style="width: 7%;" class="content item9">

																				<label class="content-label">€ Total</label>
																				@if(Route::currentRouteName() == 'create-new-negative-invoice') -&nbsp; @endif
																				<div class="price res-white">€ {{number_format((float)$item->rate, 2, ',', '.')}}</div>

																			</div>

																			<div class="content item10 last-content" id="next-row-td" style="padding: 0;width: 13%;">

																				@if((Route::currentRouteName() == 'create-new-negative-invoice' || Route::currentRouteName() == 'view-new-invoice') || (isset($invoice) && ($invoice[0]->status == 0 || $invoice[0]->status == 1 || $invoice[0]->ask_customization)) || !isset($invoice))

																					<div class="res-white" style="display: flex;justify-content: flex-end;align-items: center;width: 100%;">

																						<div style="display: none;" class="green-circle tooltip1">
																							<span style="top: 45px;left: -40px;" class="tooltiptext">{{__('text.ALL features selected!')}}</span>
																						</div>

																						<div style="visibility: hidden;" class="yellow-circle tooltip1">
																							<span style="top: 45px;left: -40px;" class="tooltiptext">{{__('text.Select all features!')}}</span>
																						</div>

																						<span id="next-row-span" class="tooltip1 add-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;width: 20px;height: 20px;line-height: 20px;">
																							<i id="next-row-icon" class="fa fa-fw fa-plus"></i>
																							<span class="tooltiptext">{{__('text.Add')}}</span>
																						</span>

																						<span id="next-row-span" class="tooltip1 remove-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;width: 20px;height: 20px;line-height: 20px;">
																							<i id="next-row-icon" class="fa fa-fw fa-trash-o"></i>
																							<span class="tooltiptext">{{__('text.Remove')}}</span>
																						</span>

																						<span id="next-row-span" class="tooltip1 copy-row" style="cursor: pointer;font-size: 20px;margin: 0 10px;width: 20px;height: 20px;line-height: 20px;">
																							<i id="next-row-icon" class="fa fa-fw fa-copy"></i>
																							<span class="tooltiptext">{{__('text.Copy')}}</span>
																						</span>

																						<!--<span id="next-row-span" class="tooltip1 next-row" style="cursor: pointer;font-size: 20px;">
                                                                                            <i id="next-row-icon" style="color: #868686;" class="fa fa-fw fa-chevron-right"></i>
                                                                                            <span style="top: 45px;left: -20px;" class="tooltiptext">Next</span>
                                                                                        </span>-->

																					</div>

																				@endif

																			</div>

																			<div class="item11" style="display: flex;justify-content: flex-end;align-items: center;width: 100%;margin-top: 10px;">
																				<button style="outline: none;" type="button" class="btn btn-info res-collapse collapsed" data-toggle="collapse" data-target="#demo{{$i+1}}"></button>
																			</div>

																			<div style="width: 100%;" id="demo{{$i+1}}" class="item16 collapse">

																				<div style="width: 25%;" class="color item12">

																					<label>{{__('text.Color')}}</label>

																					<select name="colors[]" class="js-data-example-ajax2">

																						<option value=""></option>

																						@foreach($colors[$i] as $color)

																							<option {{$color->id == $item->color ? 'selected' : null}} value="{{$color->id}}">{{$color->title}}</option>

																						@endforeach

																					</select>

																				</div>

																				<div style="width: 25%;margin-left: 10px;" class="model item13">

																					<label>{{__('text.Model')}}</label>

																					<select name="models[]" class="js-data-example-ajax3">

																						<option value=""></option>

																						@foreach($models[$i] as $model)

																							<option {{$model->id == $item->model_id ? 'selected' : null}} value="{{$model->id}}">{{$model->model}}</option>

																						@endforeach

																					</select>

																					<input type="hidden" class="model_impact_value" name="model_impact_value[]" value="{{$item->model_impact_value}}">

																				</div>

																				<div style="width: 25%;margin-left: 10px;" class="discount-box item14">

																					<label>{{__('text.Discount')}} % </label>

																					<input style="height: 35px;border-radius: 4px;" placeholder="{{__('text.Enter discount in percentage')}}" type="text" class="form-control discount_values" value="{{$item->discount}}" name="discount[]">

																				</div>

																				<div style="width: 25%;margin-left: 10px;" class="labor-discount-box item15">

																					<label>{{__('text.Labor Discount')}} % </label>

																					<input style="height: 35px;border-radius: 4px;" placeholder="{{__('text.Enter discount in percentage')}}" type="text" class="form-control labor_discount_values" value="{{$item->labor_discount}}" name="labor_discount[]">

																				</div>

																			</div>

																		</div>

																	@endforeach

																@else

																	<div class="content-div active" data-id="1">

																		<div class="content full-res item1" style="width: 2%;">
																			<label class="content-label">Sr. No</label>
																			<div style="padding: 0 5px;" class="sr-res">1</div>
																		</div>

																		<input type="hidden" id="order_number" name="order_number[]">
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
																		<input type="hidden" id="supplier_margin" name="supplier_margin[]">
																		<input type="hidden" id="retailer_margin" name="retailer_margin[]">

																		<div style="width: 12%;" @if(auth()->user()->role_id == 4) class="content item2 full-res suppliers hide" @else class="content item2 full-res suppliers" @endif>

																			<label class="content-label">Supplier</label>

																			<select name="suppliers[]" class="js-data-example-ajax1">

																				<option value=""></option>

																				@foreach($suppliers as $key)

																					<option value="{{$key->id}}">{{$key->company_name}}</option>

																				@endforeach

																			</select>

																		</div>

																		<div style="width: 22%;" class="products content item3 full-res">

																			<label class="content-label">Product</label>

																			<select name="products[]" class="js-data-example-ajax">

																				<option value=""></option>

																				@foreach($products as $key)

																					<option value="{{$key->id}}">{{$key->title}}</option>

																				@endforeach

																			</select>

																		</div>

																		<div class="width item4 content" style="width: 10%;">

																			<label class="content-label">Width</label>

																			<div class="m-box">
																				<input value="0" class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="width[]" type="text">
																				<input style="border: 0;outline: none;" readonly type="text" name="width_unit[]" class="measure-unit" value="cm">
																			</div>
																		</div>

																		<div class="height item5 content" style="width: 10%;">

																			<label class="content-label">Height</label>

																			<div class="m-box">
																				<input value="0" class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="height[]" type="text">
																				<input style="border: 0;outline: none;" readonly type="text" name="height_unit[]" class="measure-unit" value="cm">
																			</div>
																		</div>

																		<div class="content item6" style="width: 7%;">

																			<label class="content-label">€ Art.</label>

																			<div style="display: flex;align-items: center;">
																				<span>€</span>
																				<input type="text" value="0" readonly name="price_before_labor[]" style="border: 0;background: transparent;padding: 0 5px;" class="form-control price_before_labor res-white">
																				<input type="hidden" value="0" class="price_before_labor_old">
																			</div>
																		</div>

																		<div class="content item7" style="width: 7%;">

																			<label class="content-label">€ Arb.</label>

																			<div style="display: flex;align-items: center;">
																				<span>€</span>
																				<input type="text" value="0" name="labor_impact[]" maskedFormat="9,1" class="form-control labor_impact res-white">
																				<input type="hidden" value="0" class="labor_impact_old">
																			</div>
																		</div>

																		<div class="content item8" style="width: 10%;">

																			<label class="content-label">Discount</label>

																			<span>€</span>
																			<input type="text" value="0" name="total_discount[]" readonly style="border: 0;background: transparent;padding: 0 5px;height: 30px;" class="form-control total_discount res-white">
																			<input type="hidden" value="0" class="total_discount_old">
																		</div>

																		<div style="width: 7%;" class="content item9">

																			<label class="content-label">€ Total</label>
																			<div class="price res-white"></div>

																		</div>

																		<div class="content item10 last-content" id="next-row-td" style="padding: 0;width: 13%;">
																			<div class="res-white" style="display: flex;justify-content: flex-end;align-items: center;width: 100%;">

																				<div style="display: none;" class="green-circle tooltip1">
																					<span style="top: 45px;left: -40px;" class="tooltiptext">{{__('text.ALL features selected!')}}</span>
																				</div>

																				<div style="visibility: hidden;" class="yellow-circle tooltip1">
																					<span style="top: 45px;left: -40px;" class="tooltiptext">{{__('text.Select all features!')}}</span>
																				</div>

																				<span id="next-row-span" class="tooltip1 add-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;width: 20px;height: 20px;line-height: 20px;">
																				<i id="next-row-icon" class="fa fa-fw fa-plus"></i>
																				<span class="tooltiptext">{{__('text.Add')}}</span>
																			</span>

																				<span id="next-row-span" class="tooltip1 remove-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;width: 20px;height: 20px;line-height: 20px;">
																				<i id="next-row-icon" class="fa fa-fw fa-trash-o"></i>
																				<span class="tooltiptext">{{__('text.Remove')}}</span>
																			</span>

																				<span id="next-row-span" class="tooltip1 copy-row" style="cursor: pointer;font-size: 20px;margin: 0 10px;width: 20px;height: 20px;line-height: 20px;">
																				<i id="next-row-icon" class="fa fa-fw fa-copy"></i>
																				<span class="tooltiptext">{{__('text.Copy')}}</span>
																			</span>

																				<!--<span id="next-row-span" class="tooltip1 next-row" style="cursor: pointer;font-size: 20px;">
                                                                                <i id="next-row-icon" style="color: #868686;" class="fa fa-fw fa-chevron-right"></i>
                                                                                <span style="top: 45px;left: -20px;" class="tooltiptext">Next</span>
                                                                                </span>-->
																			</div>
																		</div>

																		<div class="item11" style="display: flex;justify-content: flex-end;align-items: center;width: 100%;margin-top: 10px;">
																			<button style="outline: none;" type="button" class="btn btn-info res-collapse collapsed" data-toggle="collapse" data-target="#demo"></button>
																		</div>

																		<div style="width: 100%;" id="demo" class="item16 collapse">

																			<div style="width: 25%;" class="color item12">

																				<label>{{__('text.Color')}}</label>

																				<select name="colors[]" class="js-data-example-ajax2">

																					<option value=""></option>

																				</select>

																			</div>

																			<div style="width: 25%;margin-left: 10px;" class="model item13">

																				<label>{{__('text.Model')}}</label>

																				<select name="models[]" class="js-data-example-ajax3">

																					<option value=""></option>

																				</select>

																				<input type="hidden" class="model_impact_value" name="model_impact_value[]" value="0">

																			</div>

																			<div style="width: 25%;margin-left: 10px;" class="discount-box item14">

																				<label>{{__('text.Discount')}} % </label>

																				<input style="height: 35px;border-radius: 4px;" placeholder="{{__('text.Enter discount in percentage')}}" type="text" class="form-control discount_values" value="0" name="discount[]">

																			</div>

																			<div style="width: 25%;margin-left: 10px;" class="labor-discount-box item15">

																				<label>{{__('text.Labor Discount')}} % </label>

																				<input style="height: 35px;border-radius: 4px;" placeholder="{{__('text.Enter discount in percentage')}}" type="text" class="form-control labor_discount_values" value="0" name="labor_discount[]">

																			</div>

																		</div>

																	</div>

																@endif

															</section>

															<div style="width: 100%;margin-top: 10px;">

																<div style="display: flex;justify-content: center;">

																	<div class="headings1" style="width: 40%;display: flex;flex-direction: column;align-items: flex-start;">

																		<button href="#myModal3" role="button" data-toggle="modal" style="font-size: 16px;" type="button" class="btn btn-success"><i class="fa fa-calendar-check-o" style="margin-right: 5px;"></i> Appointments</button>

																		<!-- @if((isset($invoice) && !$invoice[0]->quote_request_id) || (isset($request_id) && !$request_id))

																		@endif -->

																	</div>
																	<div class="headings1" style="width: 16%;display: flex;justify-content: flex-end;align-items: center;padding-right: 15px;"><span style="font-size: 14px;font-weight: bold;font-family: monospace;">{{__('text.Total')}}</span></div>
																	<div class="headings1" style="width: 7%;display: flex;align-items: center;">
																		<div style="display: flex;align-items: center;justify-content: center;">
																			<span style="font-size: 14px;font-weight: 500;margin-right: 5px;">€</span>
																			<input name="price_before_labor_total"
																				   id="price_before_labor_total"
																				   style="border: 0;font-size: 14px;font-weight: 500;width: 75px;outline: none;"
																				   type="text" readonly
																				   value="{{isset($invoice) ? number_format((float)$invoice[0]->price_before_labor_total, 2, ',', '.') : 0}}">
																		</div>
																	</div>
																	<div class="headings1" style="width: 7%;display: flex;align-items: center;">
																		<div style="display: flex;align-items: center;justify-content: center;">
																			<span style="font-size: 14px;font-weight: 500;margin-right: 5px;">€</span>
																			<input name="labor_cost_total"
																				   id="labor_cost_total"
																				   style="border: 0;font-size: 14px;font-weight: 500;width: 75px;outline: none;"
																				   type="text" readonly
																				   value="{{isset($invoice) ? number_format((float)$invoice[0]->labor_cost_total, 2, ',', '.') : 0}}">
																		</div>
																	</div>
																	<div class="headings2" style="width: 30%;display: flex;align-items: center;">
																		<div style="display: flex;align-items: center;justify-content: flex-end;width: 60%;">
																			<span style="font-size: 14px;font-weight: 500;margin-right: 5px;font-family: monospace;">Te betalen: @if(Route::currentRouteName() == 'create-new-negative-invoice') - @endif €</span>
																			<input name="total_amount" id="total_amount"
																				   style="border: 0;font-size: 14px;font-weight: 500;width: 75px;outline: none;"
																				   type="text" readonly
																				   value="{{isset($invoice) ? number_format((float)$invoice[0]->grand_total, 2, ',', '.') : 0}}">
																		</div>
																	</div>

																</div>

																<div style="display: flex;justify-content: flex-end;margin-top: 20px;">

																	<div class="headings1" style="width: 40%;display: flex;flex-direction: column;align-items: flex-start;">

																		<?php if(isset($current_appointments)) {

																			$appointments_array = json_decode($current_appointments,true);
																			$count = count($appointments_array);
																			$last_event_id = $last_event_id + 1;
																			$appointments = json_encode($appointments_array);

																		} ?>

																		<input type="hidden" value="{{isset($appointments) ? ($count > 0 ? $appointments : null) : null}}" class="appointment_data" name="appointment_data">
																		<input type="hidden" value="{{isset($last_event_id) ? $last_event_id : 1}}" class="appointment_id">

																	</div>
																	<div class="headings1" style="width: 16%;display: flex;align-items: center;"></div>
																	<div class="headings1" style="width: 7%;display: flex;align-items: center;"></div>
																	<div class="headings1" style="width: 7%;display: flex;align-items: center;"></div>
																	<div class="headings2" style="width: 30%;display: flex;align-items: center;">
																		<div style="display: flex;align-items: center;justify-content: flex-end;width: 60%;">
																			<span style="font-size: 14px;font-weight: 500;margin-right: 5px;font-family: monospace;">Nettobedrag: @if(Route::currentRouteName() == 'create-new-negative-invoice') - @endif €</span>
																			<input name="net_amount" id="net_amount"
																				   style="border: 0;font-size: 14px;font-weight: 500;width: 75px;outline: none;"
																				   type="text" readonly
																				   value="{{isset($invoice) ? number_format((float)$invoice[0]->net_amount, 2, ',', '.') : 0}}">
																		</div>
																	</div>

																</div>

																<div style="display: flex;justify-content: flex-end;margin-top: 20px;">

																	<div class="headings1" style="width: 70%;">
																		<textarea name="description" style="width: 100%;border-radius: 5px;resize: vertical;" rows="5" class="form-control" placeholder="{{__('text.Enter Description')}}">{{isset($invoice) ? $invoice[0]->description : ''}}</textarea>
																	</div>
																	<div class="headings2" style="width: 30%;">
																		<div style="display: flex;align-items: center;justify-content: flex-end;width: 60%;">
																			<span style="font-size: 14px;font-weight: 500;margin-right: 5px;font-family: monospace;">BTW (21%): @if(Route::currentRouteName() == 'create-new-negative-invoice') - @endif €</span>
																			<input name="tax_amount" id="tax_amount"
																				   style="border: 0;font-size: 14px;font-weight: 500;width: 75px;outline: none;"
																				   type="text" readonly
																				   value="{{isset($invoice) ? number_format((float)$invoice[0]->tax_amount, 2, ',', '.') : 0}}">
																		</div>
																	</div>

																</div>

															</div>

														</div>

														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"
															 style="background: white;padding: 15px 0 0 0;">

															<ul style="border: 0;" class="nav nav-tabs feature-tab">
																<li style="margin-bottom: 0;" class="active"><a
																			style="border: 0;border-bottom: 3px solid rgb(151, 140, 135);padding: 10px 30px;"
																			data-toggle="tab" href="#menu1"
																			aria-expanded="false">{{__('text.Features')}}</a></li>
															</ul>

															<div style="padding: 30px 15px 20px 15px;border: 0;border-top: 1px solid #24232329;" class="tab-content">

																<div id="menu1" class="tab-pane fade active in">

																	@if(isset($invoice))

																		<?php $f = 0; $s = 0; ?>

																		@foreach($invoice as $x => $key1)

																			<div data-id="{{$x + 1}}" @if($x==0) style="margin: 0;"
																				 @else style="margin: 0;display: none;" @endif
																				 class="form-group">

																				<div class="row"
																					 style="margin: 0;display: flex;align-items: center;">
																					<div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;"
																						 class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
																						<label
																								style="margin-right: 10px;margin-bottom: 0;">{{__('text.Quantity')}}</label>
																						@if(Route::currentRouteName() == 'create-new-negative-invoice') - @endif
																						<input value="{{$key1->qty}}"
																							   style="border: none;border-bottom: 1px solid lightgrey;"
																							   maskedformat="9,1" name="qty[]"
																							   class="form-control"
																							   type="text"><span>pcs</span>
																					</div>
																				</div>

																				@if($key1->childsafe)

																					<div class="row childsafe-content-box" style="margin: 0;display: flex;align-items: center;">
																						<div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
																							<label style="margin-right: 10px;margin-bottom: 0;">Montagehoogte</label>
																							<input value="{{$key1->childsafe_x}}" style="border: none;border-bottom: 1px solid lightgrey;" type="number" class="form-control childsafe_values" id="childsafe_x" name="childsafe_x{{$x+1}}">
																						</div>
																					</div>

																					<div class="row childsafe-content-box1" style="margin: 0;display: flex;align-items: center;">
																						<div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
																							<label style="margin-right: 10px;margin-bottom: 0;">Kettinglengte</label>
																							<input value="{{$key1->childsafe_y}}" style="border: none;border-bottom: 1px solid lightgrey;" type="number" class="form-control childsafe_values" id="childsafe_y" name="childsafe_y{{$x+1}}">
																						</div>
																					</div>

																					<div class="row childsafe-question-box"
																						 style="margin: 0;display: flex;align-items: center;">

																						<div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;"
																							 class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
																							<label
																									style="margin-right: 10px;margin-bottom: 0;">{{__('text.Childsafe')}}</label>
																							<select
																									style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;"
																									class="form-control childsafe-select"
																									name="childsafe_option{{$x+1}}">

																								<option value="">{{__('text.Select any option')}}
																								</option>

																								@if($key1->childsafe_diff <= 150)
																									<option {{$key1->childsafe_question
																					== 1 ? 'selected' : null}}
																											value="1">{{__('text.Please note not childsafe')}}
																									</option>
																									<option {{$key1->childsafe_question
																						== 2 ? 'selected' : null}}
																											value="2">{{__('text.Add childsafety clip')}}
																									</option>

																								@else

																									<option {{$key1->childsafe_question
																						== 2 ? 'selected' : null}}
																											value="2">{{__('text.Add childsafety clip')}}
																									</option>
																									<option {{$key1->childsafe_question
																						== 3 ? 'selected' : null}}
																											value="3">{{__('text.Yes childsafe')}}</option>

																								@endif

																							</select>
																							<input value="{{$key1->childsafe_diff}}"
																								   name="childsafe_diff{{$x + 1}}"
																								   class="childsafe_diff" type="hidden">
																						</div>

																					</div>

																					<div class="row childsafe-answer-box"
																						 style="margin: 0;display: flex;align-items: center;">

																						<div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;"
																							 class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
																							<label
																									style="margin-right: 10px;margin-bottom: 0;">{{__('text.Childsafe')}}
																								Answer</label>
																							<select
																									style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;"
																									class="form-control childsafe-answer"
																									name="childsafe_answer{{$x+1}}">
																								@if($key1->childsafe_question == 1)
																									<option {{$key1->childsafe_answer == 1 ?
																					'selected' : null}} value="1">{{__('text.Make it childsafe')}}</option>
																									<option {{$key1->childsafe_answer == 2 ?
																					'selected' : null}} value="2">{{__('text.Yes i agree')}}</option>
																								@else
																									<option selected value="3">{{__('text.Is childsafe')}}
																									</option>
																								@endif
																							</select>
																						</div>

																					</div>

																				@endif

																				@foreach($key1->features as $feature)

																					@if($feature->feature_id == 0 &&
                                                                                    $feature->feature_sub_id == 0)

																						<div class="row"
																							 style="margin: 0;display: flex;align-items: center;">

																							<div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;"
																								 class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
																								<label
																										style="margin-right: 10px;margin-bottom: 0;">{{__('text.Ladderband')}}</label>
																								<select
																										style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;"
																										class="form-control feature-select"
																										name="features{{$x+1}}[]">
																									<option {{$feature->ladderband == 0 ?
																					'selected' : null}} value="0">{{__('text.No')}}
																									</option>
																									<option {{$feature->ladderband == 1 ?
																					'selected' : null}} value="1">{{__('text.Yes')}}
																									</option>
																								</select>
																								<input value="{{$feature->price}}"
																									   name="f_price{{$x + 1}}[]"
																									   class="f_price" type="hidden">
																								<input value="0" name="f_id{{$x + 1}}[]"
																									   class="f_id" type="hidden">
																								<input value="0" name="f_area{{$x + 1}}[]"
																									   class="f_area" type="hidden">
																								<input value="0"
																									   name="sub_feature{{$x + 1}}[]"
																									   class="sub_feature" type="hidden">
																							</div>

																							@if($feature->ladderband)

																								<a data-id="{{$x + 1}}"
																								   class="info ladderband-btn">{{__('text.Info')}}</a>

																							@endif

																						</div>

																					@else

																						<div class="row"
																							 style="margin: 0;display: flex;align-items: center;">

																							<div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;"
																								 class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
																								<label
																										style="margin-right: 10px;margin-bottom: 0;">{{$feature->title}}</label>
																								<select
																										style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;"
																										class="form-control feature-select"
																										name="features{{$x+1}}[]">

																									<option value="0">{{__('text.Select Feature')}}
																									</option>

																									@foreach($features[$f] as $temp)

																										<option {{$temp->id ==
																					$feature->feature_sub_id ?
																					'selected' : null}}
																												value="{{$temp->id}}">{{$temp->title}}
																										</option>

																									@endforeach

																								</select>
																								<input value="{{$feature->price}}"
																									   name="f_price{{$x + 1}}[]"
																									   class="f_price" type="hidden">
																								<input value="{{$feature->feature_id}}"
																									   name="f_id{{$x + 1}}[]" class="f_id"
																									   type="hidden">
																								<input value="0" name="f_area{{$x + 1}}[]"
																									   class="f_area" type="hidden">
																								<input value="0"
																									   name="sub_feature{{$x + 1}}[]"
																									   class="sub_feature" type="hidden">
																							</div>

																							@if($feature->comment_box)

																								<a data-feature="{{$feature->feature_id}}"
																								   class="info comment-btn">{{__('text.Info')}}</a>

																							@endif

																						</div>

																						@foreach($key1->sub_features as $sub_feature)

																							@if($sub_feature->feature_id == $feature->feature_sub_id)

																								<div class="row sub-features"
																									 style="margin: 0;display: flex;align-items: center;">

																									<div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;"
																										 class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
																										<label
																												style="margin-right: 10px;margin-bottom: 0;">{{$sub_feature->title}}</label>
																										<select
																												style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;"
																												class="form-control feature-select"
																												name="features{{$x+1}}[]">

																											<option value="0">{{__('text.Select Feature')}}
																											</option>

																											@foreach($sub_features[$s] as $temp)

																												<option {{$temp->id ==
																					$sub_feature->feature_sub_id ?
																					'selected' : null}}
																														value="{{$temp->id}}">{{$temp->title}}
																												</option>

																											@endforeach

																										</select>
																										<input value="{{$sub_feature->price}}"
																											   name="f_price{{$x + 1}}[]"
																											   class="f_price" type="hidden">
																										<input value="{{$sub_feature->feature_id}}"
																											   name="f_id{{$x + 1}}[]" class="f_id"
																											   type="hidden">
																										<input value="0" name="f_area{{$x + 1}}[]"
																											   class="f_area" type="hidden">
																										<input value="1"
																											   name="sub_feature{{$x + 1}}[]"
																											   class="sub_feature" type="hidden">
																									</div>

																								</div>

																								<?php $s = $s + 1; ?>

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
									<h4 class="modal-title">{{__('text.Sub Products Sizes')}}</h4>
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
															<th>{{__('text.Title')}}</th>
															<th>{{__('text.Size 38mm')}}</th>
															<th>{{__('text.Size 25mm')}}</th>
														</tr>
														</thead>
														<tbody>

														@foreach($sub_products[$x] as $sub_product)

															<tr>
																<td><input type="hidden" class="sub_product_id"
																		   name="sub_product_id{{$x+1}}[]"
																		   value="{{$sub_product->sub_product_id}}">{{$sub_product->code}}
																</td>
																<td>{{$sub_product->title}}</td>
																<td>
																	@if($sub_product->size1_value == 'x')

																		X<input class="sizeA" name="sizeA{{$x+1}}[]" type="hidden"
																				value="x">

																	@else

																		<input {{$sub_product->size1_value ? 'checked' : null}}
																			   data-id="{{$x + 1}}" class="cus_radio" name="cus_radio{{$x+1}}[]"
																			   type="radio">
																		<input class="cus_value sizeA" type="hidden"
																			   value="{{$sub_product->size1_value ? 1 : 0}}"
																			   name="sizeA{{$x+1}}[]">

																	@endif
																</td>
																<td>
																	@if($sub_product->size2_value == 'x')

																		X<input class="sizeB" name="sizeB{{$x+1}}[]" type="hidden"
																				value="x">

																	@else

																		<input {{$sub_product->size2_value ? 'checked' : null}}
																			   data-id="{{$x + 1}}" class="cus_radio" name="cus_radio{{$x+1}}[]"
																			   type="radio">
																		<input class="cus_value sizeB" type="hidden"
																			   value="{{$sub_product->size2_value ? 1 : 0}}"
																			   name="sizeB{{$x+1}}[]">

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
									<button type="button" class="btn btn-default" data-dismiss="modal">{{__('text.Close')}}</button>
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
									<h4 class="modal-title">{{__('text.Feature Comment')}}</h4>
								</div>
								<div class="modal-body">

									@if(isset($invoice))

										@foreach($invoice as $x => $key1)

											@foreach($key1->features as $feature)

												@if($feature->comment)

													<div class="comment-boxes" data-id="{{$x + 1}}">
									<textarea
											style="resize: vertical;width: 100%;border: 1px solid #c9c9c9;border-radius: 5px;outline: none;"
											data-id="{{$feature->feature_id}}" rows="5"
											name="comment-{{$x + 1}}-{{$feature->feature_id}}">{{$feature->comment}}</textarea>
													</div>

												@endif

											@endforeach

										@endforeach

									@endif

								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">{{__('text.Close')}}</button>
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
					<button style="background-color: white !important;color: black !important;" type="button" class="close"
							data-dismiss="modal" aria-hidden="true">×</button>
					<h3 id="myModalLabel">{{__('text.Create Customer')}}</h3>
				</div>

				<div class="modal-body" id="myWizard" style="display: inline-block;">

					<input type="hidden" id="token" name="token" value="{{csrf_token()}}">
					<input type="hidden" id="handyman_id" name="handyman_id" value="{{Auth::user()->id}}">
					<input type="hidden" id="handyman_name" name="handyman_name"
						   value="<?php echo Auth::user()->name .' '. Auth::user()->family_name; ?>">

					<div class="form-group col-sm-6">
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-user"></i>
							</div>
							<input id="name" name="name" class="form-control validation" placeholder="{{$lang->suf}}"
								   type="text">
						</div>
					</div>

					<div class="form-group col-sm-6">
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-user"></i>
							</div>
							<input id="family_name" name="family_name" class="form-control validation"
								   placeholder="{{$lang->fn}}" type="text">
						</div>
					</div>

					<div class="form-group col-sm-6">
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-user"></i>
							</div>
							<input id="business_name" name="business_name" class="form-control" placeholder="{{$lang->bn}}"
								   type="text">
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
							<input id="postcode" name="postcode" class="form-control" readonly placeholder="{{$lang->pc}}"
								   type="text">
						</div>
					</div>


					<div class="form-group col-sm-6">
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-user"></i>
							</div>
							<input id="city" name="city" class="form-control" placeholder="{{$lang->ct}}" readonly
								   type="text">
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
							<input id="email" name="email" class="form-control" placeholder="{{$lang->sue}}" type="email">
						</div>
					</div>

				</div>

				<div class="modal-footer">
					<button type="button" style="border: 0;outline: none;background-color: #5cb85c !important;"
							class="btn btn-primary submit-customer">{{__('text.Create')}}</button>
				</div>

			</div>

		</div>
	</div>

	<div id="myModal3" class="modal fade" role="dialog">
		<div style="width: 80%;" class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">{{__('text.Appointments')}}</h4>
				</div>
				<div style="padding: 0 0 50px 0;" class="modal-body">

					<div class="row" style="max-width: 1100px;margin: 20px auto;">
						<button class="btn btn-success add-appointment"><i class="fa fa-plus"></i> {{__('text.Add Appointment')}}</button>
					</div>

					<div id='calendar'></div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">{{__('text.Close')}}</button>
				</div>
			</div>

		</div>
	</div>

	<div style="overflow-y: auto;" id="addAppointmentModal" role="dialog" class="modal fade">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" data-dismiss="modal" class="close">×</button>
					<h4 class="modal-title">{{__('text.Add Appointment')}}</h4>
				</div>

				<div class="modal-body">

					<div class="row">
						<div class="form-group col-xs-12 col-sm-12 required appointment_title_box">
							<label>{{__('text.Select Event Title')}}</label>
							<select class="appointment_title">

								<option value="">{{__('text.Select Event Title')}}</option>
								<option value="Delivery Date">{{__('text.Delivery Date')}}</option>
								<option value="Installation Date">{{__('text.Installation Date')}}</option>

								@foreach($event_titles as $title)

									<option value="{{$title->title}}">{{$title->title}}</option>

								@endforeach

							</select>
						</div>

						<div class="form-group col-xs-12 col-sm-4 required">
							<label>{{__('text.Start')}}</label>
							<input type="text" class="form-control appointment_start validation_required" readonly="readonly">
						</div>

						<div class="form-group col-xs-12 col-sm-4 required">
							<label>{{__('text.End')}}</label>
							<input type="text" class="form-control appointment_end validation_required" readonly="readonly">
						</div>

						<div class="form-group col-xs-12 appointment_type_box col-sm-4 required">
							<label>{{__('text.Select Type')}}</label>
							<select class="appointment_type">

								<option value="1">{{__('text.For Quotation')}}</option>
								<option value="2">{{__('text.For Client')}}</option>
								<option value="3">{{__('text.For Supplier')}}</option>
								<option value="4">{{__('text.For Employee')}}</option>

							</select>
						</div>

						<?php if(isset($invoice)){ $client = $clients->where('id',$invoice[0]->customer_details)->first(); } ?>

						<div class="form-group col-xs-12 col-sm-4 appointment_quotation_number_box required">
							<label>{{__('text.Quotation Number')}}</label>
							<select class="appointment_quotation_number">

								<option value="">{{__('text.Select Quotation')}}</option>
								<option @if(isset($invoice) && $client) data-fname="{{$client->name}}" data-lname="{{$client->family_name}}" @endif value="0">{{__('text.Current Quotation')}}</option>

								@foreach($quotation_ids as $key)

									<option data-fname="{{$key->name}}" data-lname="{{$key->family_name}}" value="{{$key->id}}">{{$key->quotation_invoice_number}}</option>

								@endforeach

							</select>
						</div>

						<div style="display: none;" class="form-group appointment_customer_box col-xs-12 col-sm-4 required">
							<label>{{__('text.Customer')}}</label>
							<select class="appointment_client">

								<option value="">{{__('text.Select Customer')}}</option>

								@foreach($customers as $key)

									<option data-fname="{{$key->name}}" data-lname="{{$key->family_name}}" value="{{$key->id}}">{{$key->name . ' ' . $key->family_name}}</option>

								@endforeach

							</select>
						</div>

						<div style="display: none;" class="form-group appointment_supplier_box col-xs-12 col-sm-4 required">
							<label>{{__('text.Supplier')}}</label>
							<select class="appointment_supplier">

								<option value="">{{__('text.Select Supplier')}}</option>

								@foreach($suppliers as $key)

									<option value="{{$key->id}}">{{$key->company_name}}</option>

								@endforeach

							</select>
						</div>

						<div style="display: none;" class="form-group appointment_employee_box col-xs-12 col-sm-4 required">
							<label>{{__('text.Employee')}}</label>
							<select class="appointment_employee">

								<option value="">{{__('text.Select Employee')}}</option>

								@foreach($employees as $key)

									<option data-fname="{{$key->name}}" data-lname="{{$key->family_name}}" value="{{$key->id}}">{{$key->name . ' ' . $key->family_name}}</option>

								@endforeach

							</select>
						</div>

						<div class="form-group col-xs-12 col-sm-12">
							<label>{{__('text.Description')}}</label>
							<textarea rows="4" class="form-control appointment_description"></textarea>
						</div>

						<div class="form-group col-xs-12 col-sm-12 required">
							<label>{{__('text.Tags')}}</label>
							<input type="text" data-role="tagsinput" class="form-control appointment_tags" />
						</div>

					</div>
				</div>

				<div class="modal-footer">
					<input type="hidden" id="event_id">
					<button type="button" class="btn btn-success pull-left submit_appointmentForm">{{__('text.Save')}}</button>
					<button type="button" data-dismiss="modal" class="btn btn-default">{{__('text.Close')}}</button>
				</div>
			</div>
		</div>
	</div>

	<style>

		.bootstrap-tagsinput
		{
			width: 100%;
		}

		.fc .fc-daygrid-day-events
		{
			margin-top: 2px !important;
		}

		.fc-event:hover .fc-buttons
		{
			display: block;
		}

		.fc-event .fc-buttons
		{
			padding: 10px;
			text-align: center;
			display: none;
			position: absolute;
			background-color: #ffffff;
			border: 1px solid #d7d7d7;
			bottom: 100%;
			z-index: 99999;
			min-width: 80px;
		}

		.fc-event .fc-buttons:after,
		.fc-event .fc-buttons:before {
			top: 100%;
			left: 8px;
			border: solid transparent;
			content: " ";
			height: 0;
			width: 0;
			position: absolute;
			pointer-events: none;
		}

		.fc-event .fc-buttons:before {
			border-color: rgba(119, 119, 119, 0);
			border-top-color: #d7d7d7;
			border-width: 6px;
			margin-left: -6px;
		}

		.fc-event .fc-buttons:after {
			border-color: rgba(255, 255, 255, 0);
			border-top-color: #ffffff;
			border-width: 5px;
			margin-left: -5px;
		}

		.fc table
		{
			margin: 0 !important;
		}

		.fc .fc-scrollgrid-section-liquid > td, .fc .fc-scrollgrid-section > td, .fc-theme-standard td, .fc-theme-standard th
		{
			padding: 0 !important;
		}

		.fc .fc-scrollgrid-section-liquid > td:first-child
		{
			border-right: 1px solid var(--fc-border-color, #ddd);
		}

		#calendar {
			max-width: 1100px;
			margin: 0 auto;
		}

		.appointment_start, .appointment_end
		{
			background-color: white !important;
		}

		.res-collapse
		{
			box-shadow: none !important;
			border: 0;
			background: white !important;
			color: black !important;
			padding: 0;
		}

		button.btn.collapsed:before
		{
			content: 'Toon alle velden' ;
			display: block;
		}

		button.res-collapse:before
		{
			content: 'Toon minder velden' ;
			display: block;
		}

		.item1 { grid-area: item1; }
		.item2 { grid-area: item2; }
		.item3 { grid-area: item3; }
		.item4 { grid-area: item4; }
		.item5 { grid-area: item5; }
		.item6 { grid-area: item6; }
		.item7 { grid-area: item7; }
		.item8 { grid-area: item8; }
		.item9 { grid-area: item9; }
		.item10 { grid-area: item10; }
		.item11 { grid-area: item11; }
		.item12 { grid-area: item12; }
		.item13 { grid-area: item13; }
		.item14 { grid-area: item14; }
		.item15 { grid-area: item15; }
		.item16 { grid-area: item16; }

		.content-label
		{
			display: none;
		}

		.m-input,
		.labor_impact {
			border-radius: 5px !important;
			width: 70%;
			border: 0;
			padding: 0 5px;
			text-align: left;
			height: 30px !important;
		}

		.m-input:focus,
		.labor_impact:focus {
			background: #f6f6f6;
		}

		.measure-unit {
			width: 50%;
		}

		.add-product-box hr
		{
			margin-bottom: 20px;
		}

		@media (max-width: 992px)
		{

			.headings1
			{
				width: 25% !important;
			}

			.headings1 input
			{
				width: 40% !important;
			}

			.headings2
			{
				width: 100% !important;
			}

			.headings2 div
			{
				width: 100% !important;
			}

			.headings2 input
			{
				width: 28% !important;
			}

			.add-product-box hr
			{
				margin-top: 0;
			}

			.header-div
			{
				display:none !important;
			}

			.price
			{
				padding: 0 5px;
				display: flex;
				align-items: center;
			}

			.content-div
			{
				display: grid !important;
				grid-template-areas:'item1 item1 item1 item1 item1 item1'
				'item2 item2 item2 item2 item2 item2'
				'item3 item3 item3 item3 item3 item3'
				'item16 item16 item16 item16 item16 item16'
				'item12 item12 item12 item12 item12 item12'
				'item13 item13 item13 item13 item13 item13'
				'item14 item14 item14 item14 item14 item14'
				'item15 item15 item15 item15 item15 item15'
				'item4 item4 item4 item5 item5 item5'
				'item6 item6 item6 item6 item6 item6'
				'item7 item7 item7 item7 item7 item7'
				'item8 item8 item8 item8 item8 item8'
				'item9 item9 item9 item9 item9 item9'
				'item10 item10 item10 item10 item10 item10'
				'item11 item11 item11 item11 item11 item11';
				grid-column-gap: 10px;
				/*grid-gap: 10px;*/
				padding: 20px !important;
				border: 1px solid #d0d0d0 !important;
				border-radius: 5px;
			}

			.color .select2-container--default .select2-selection--single, .model .select2-container--default .select2-selection--single
			{
				border: 1px solid #d6d6d6 !important;
			}

			.m-box
			{
				border: 1px solid #d6d6d6;
				border-radius: 4px;
				padding: 0 10px;
				background: white;
			}

			.content-div .collapse, .content-div .collapsing, .content-div .collapse.in
			{
				display: grid !important;
				grid-template-areas: 'item12 item12 item12 item12 item12 item12'
				'item13 item13 item13 item13 item13 item13'
				'item14 item14 item14 item14 item14 item14'
				'item15 item15 item15 item15 item15 item15';
				margin-top: 0 !important;
			}

			.color, .model, .discount-box, .labor-discount-box
			{
				width: auto !important;
				margin-left: 0 !important;
				margin-top: 15px;
			}

			.content-div.active
			{
				background: #c6daef;
				border: 0 !important;
			}

			.second-row
			{
				padding: 0 !important;
			}

			.content-div .content
			{
				border: 0 !important;
				display: block !important;
				height: auto !important;
				width: auto !important;
			}

			.content-div .content:not(:first-child)
			{
				margin-top: 15px;
			}

			.res-white
			{
				background: white !important;
				height: 35px !important;
				width: 100% !important;
				border-radius: 4px !important;
				border: 1px solid #d6d6d6 !important;
			}

			.item11
			{
				display: none !important;
			}

			.m-input
			{
				border-radius: 0 !important;
				width: 75%;
			}

			.measure-unit
			{
				height: 30px;
				width: 25%;
				padding-bottom: 3px;
				border-radius: 0;
			}

			.full-res .select2-container .select2-selection--single, .full-res .select2-container--default .select2-selection--single .select2-selection__rendered, .full-res .select2-container--default .select2-selection--single .select2-selection__arrow
			{
				height: 35px;
				line-height: 35px;
				font-size: 10px;
			}

			:is(.color, .model) > .select2-container--default .select2-selection--single, :is(.color, .model) > .select2-container--default .select2-selection--single .select2-selection__rendered, :is(.color, .model) > .select2-container--default .select2-selection--single .select2-selection__arrow, :is(.color, .model) > .select2-container--default .select2-selection--single .select2-selection__rendered
			{
				font-size: 10px;
			}

			.sr-res
			{
				background: white;
				height: 35px;
				display: flex;
				align-items: center;
				border-radius: 4px;
				border: 1px solid #d6d6d6;
			}

			:not(.color, .model, .appointment_title_box, .appointment_quotation_number_box, .appointment_type_box, .appointment_customer_box, .appointment_supplier_box, .appointment_employee_box) > .select2-container--default .select2-selection--single
			{
				border: 1px solid #d6d6d6 !important;
			}

			.content-label
			{
				display: inline-block;
			}
		}

		.content-div .collapsing, .content-div .collapse.in
		{
			display: flex;
		}

		.header-div, .content-div
		{
			display: flex;
			flex-direction: row;
			align-items: center;
		}

		.header-div .headings
		{
			font-family: system-ui;
			font-weight: 500;
			border-bottom: 1px solid #ebebeb;
			padding-bottom: 15px;
			color: gray;
			height: 40px;
		}

		.content-div
		{
			margin-top: 15px;
			flex-flow: wrap;
			border-bottom: 1px solid #d0d0d0;
			padding-bottom: 10px;
		}

		.content-div .content {
			font-family: system-ui;
			font-weight: 500;
			padding: 0;
			color: #3c3c3c;
			height: 40px;
			display: flex;
			align-items: center;
		}

		.content-div.active .content {
			border-top: 2px solid #cecece;
			border-bottom: 2px solid #cecece;
		}

		.content-div.active .content:first-child {
			border-left: 2px solid #cecece;
			border-bottom-left-radius: 4px;
			border-top-left-radius: 4px;
		}

		.content-div.active .last-content {
			border-right: 2px solid #cecece;
			border-bottom-right-radius: 4px;
			border-top-right-radius: 4px;
		}

		.yellow-circle
		{
			background: #fae91a;width: 20px;height: 20px;border-radius: 50%;animation: yellow-glow 2s ease infinite;
		}

		@keyframes yellow-glow {
			0% {
				box-shadow: 0 0 #fae91a;
			}

			100% {
				box-shadow: 0 0 10px 8px transparent;
			}
		}

		.green-circle
		{
			background: #62e660;width: 20px;height: 20px;border-radius: 50%;animation: green-glow 2s ease infinite;
		}

		@keyframes green-glow {
			0% {
				box-shadow: 0 0 #62e660;
			}

			100% {
				box-shadow: 0 0 10px 8px transparent;
			}
		}

		/*.yellow-circle
        {
            background: #fae91a;width: 20px;height: 20px;border-radius: 50%;animation: anim-glow 2s linear infinite;
        }

        @keyframes anim-glow {
            0% {
                box-shadow: 0 0 9px 0px #ffec00;
            }
            25% {
                box-shadow: 0 0 5px 0px #ffec00;
            }
            50% {
                box-shadow: 0 0 0px 0px #ffec00;
            }
            75% {
                box-shadow: 0 0 5px 0px #ffec00;
            }
            100% {
                box-shadow: 0 0 9px 0px #ffec00;
            }
        }*/

		.note-editor
		{
			width: 100%;
		}

		.note-toolbar
		{
			line-height: 1;
		}

		#menu1 .form-group {
			display: flex;
			align-items: center;
			flex-wrap: wrap;
		}

		#menu1 .form-group .row {
			padding: 0 20px;
			justify-content: flex-start;
			border-right: 1px solid #dddddd;
			height: 40px;
			width: 33%;
			margin: 15px 0 !important;
		}

		#menu1 .form-group .row:nth-child(3n + 1) {
			padding-left: 0;
		}

		#menu1 .form-group .row:nth-child(3n) {
			border-right: 0;
			padding-right: 0;
		}

		@media (max-width: 992px) {
			#menu1 .form-group .row {
				width: 50%;
			}

			#menu1 .form-group .row:nth-child(3n + 1) {
				padding-left: 20px;
			}

			#menu1 .form-group .row:nth-child(3n) {
				border-right: 1px solid #dddddd;
				padding-right: 20px;
			}

			#menu1 .form-group .row:nth-child(2n + 1) {
				padding-left: 0;
			}

			#menu1 .form-group .row:nth-child(2n) {
				border-right: 0;
				padding-right: 0;
			}

		}

		@media (max-width: 670px) {
			#menu1 .form-group .row {
				width: 100%;
			}

			#menu1 .form-group .row {
				border-right: 0 !important;
				padding-left: 20px !important;
				padding-right: 20px !important;
			}

		}

		@media (max-width: 550px) {

			.add-product-header .col-md-5 {
				padding: 0;
				margin-top: 20px;
				width: 100%;
			}
		}

		.swal2-html-container {
			line-height: 2;
		}

		a.info {
			vertical-align: bottom;
			position: relative;
			/* Anything but static */
			width: 1.5em;
			height: 1.5em;
			text-indent: -9999em;
			display: inline-block;
			color: white;
			font-weight: bold;
			font-size: 1em;
			line-height: 1em;
			background-color: #628cb6;
			cursor: pointer;
			margin-top: 7px;
			-webkit-border-radius: .75em;
			-moz-border-radius: .75em;
			border-radius: .75em;
		}

		a.info:before {
			content: "i";
			position: absolute;
			top: .25em;
			left: 0;
			text-indent: 0;
			display: block;
			width: 1.5em;
			text-align: center;
			font-family: monospace;
		}

		.ladderband-btn {
			background-color: #494949 !important;
		}

		.childsafe-btn {
			background-color: #56a63c !important;
		}

		/*.select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 25px;
        }*/

		#cover {
			background: url(<?php echo asset('assets/images/page-loader.gif');
		?>) no-repeat scroll center center #ffffff78;
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

		.pac-container {
			z-index: 1000000;
		}

		#cus-box .select2-container--default .select2-selection--single .select2-selection__rendered, .appointment_title_box .select2-container--default .select2-selection--single .select2-selection__rendered, .appointment_quotation_number_box .select2-container--default .select2-selection--single .select2-selection__rendered, .appointment_type_box .select2-container--default .select2-selection--single .select2-selection__rendered, .appointment_customer_box .select2-container--default .select2-selection--single .select2-selection__rendered, .appointment_supplier_box .select2-container--default .select2-selection--single .select2-selection__rendered, .appointment_employee_box .select2-container--default .select2-selection--single .select2-selection__rendered {
			line-height: 28px;
		}

		#cus-box .select2-container--default .select2-selection--single, .appointment_title_box .select2-container--default .select2-selection--single, .appointment_quotation_number_box .select2-container--default .select2-selection--single, .appointment_type_box .select2-container--default .select2-selection--single, .appointment_customer_box .select2-container--default .select2-selection--single, .appointment_supplier_box .select2-container--default .select2-selection--single, .appointment_employee_box .select2-container--default .select2-selection--single {
			border: 1px solid #cacaca;
		}

		#cus-box .select2-selection, .appointment_title_box .select2-selection {
			height: 40px !important;
			padding-top: 5px !important;
			outline: none;
		}

		.appointment_quotation_number_box .select2-selection, .appointment_type_box .select2-selection, .appointment_customer_box .select2-selection, .appointment_supplier_box .select2-selection, .appointment_employee_box .select2-selection
		{
			height: 35px !important;
			padding-top: 0 !important;
			display: flex;
			align-items: center;
			justify-content: space-between;
		}

		#cus-box .select2-selection__arrow, .appointment_title_box .select2-selection__arrow {
			top: 7.5px !important;
		}

		.appointment_quotation_number_box .select2-selection__arrow, .appointment_type_box .select2-selection__arrow, .appointment_customer_box .select2-selection__arrow, .appointment_supplier_box .select2-selection__arrow, .appointment_employee_box .select2-selection__arrow
		{
			top: 0 !important;
			position: relative;
			height: 100% !important;
		}

		/* #cus-box .select2-selection__clear, .appointment_title_box .select2-selection__clear, .appointment_quotation_number_box .select2-selection__clear, .appointment_type_box .select2-selection__clear, .appointment_customer_box .select2-selection__clear {
			display: none;
		} */

		.feature-tab li a[aria-expanded="false"]::before,
		a[aria-expanded="true"]::before {
			display: none;
		}

		.m-box {
			display: flex;
			align-items: center;
		}

		:not(.color, .model, .appointment_title_box, .appointment_quotation_number_box, .appointment_type_box, .appointment_customer_box, .appointment_supplier_box, .appointment_employee_box) > .select2-container--default .select2-selection--single {
			border: 0;
		}

		:is(.color, .model) > .select2-container--default .select2-selection--single, :is(.color, .model) > .select2-container--default .select2-selection--single .select2-selection__rendered, :is(.color, .model) > .select2-container--default .select2-selection--single .select2-selection__arrow, :is(.color, .model) > .select2-container--default .select2-selection--single .select2-selection__rendered
		{
			line-height: 35px;
			height: 35px;
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
			padding: 10px;
			border-radius: 6px;
			position: absolute;
			z-index: 1;
			left: 0;
			top: 55px;
			font-size: 12px;
			white-space: nowrap;
		}

		/* Show the tooltip text when you mouse over the tooltip container */
		.tooltip1:hover .tooltiptext {
			visibility: visible;
		}

		.first-row {
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

		.second-row {
			padding: 25px;
			display: flex;
			flex-direction: column;
			background: #fff;
			/*overflow-y: hidden;
            overflow-x: auto;*/
		}

		table tr th:not(#addAppointmentModal table tr th) {
			font-family: system-ui;
			font-weight: 500;
			border-bottom: 1px solid #ebebeb;
			padding-bottom: 15px;
			color: gray;
		}

		table tbody tr td:not(#addAppointmentModal table tbody tr td) {
			font-family: system-ui;
			font-weight: 500;
			padding: 0 10px;
			color: #3c3c3c;
		}

		table tbody tr.active td:not(#addAppointmentModal table tbody tr.active td) {
			border-top: 2px solid #cecece;
			border-bottom: 2px solid #cecece;
		}

		table tbody tr.active td:first-child:not(#addAppointmentModal table tbody tr.active td:first-child) {
			border-left: 2px solid #cecece;
			border-bottom-left-radius: 4px;
			border-top-left-radius: 4px;
		}

		table tbody tr.active td:last-child:not(#addAppointmentModal table tbody tr.active td:last-child) {
			border-right: 2px solid #cecece;
			border-bottom-right-radius: 4px;
			border-top-right-radius: 4px;
		}

		table:not(#addAppointmentModal table) {
			border-collapse: separate;
			border-spacing: 0 1em;
		}

		.modal-body table tr th:not(#addAppointmentModal .modal-body table tr th) {
			border: 1px solid #ebebeb;
			padding-bottom: 15px;
			color: gray;
		}

		.modal-body table tbody tr td:not(#addAppointmentModal .modal-body table tbody tr td) {
			border-left: 1px solid #ebebeb;
			border-right: 1px solid #ebebeb;
			border-bottom: 1px solid #ebebeb;
		}

		.modal-body table tbody tr td:first-child:not(#addAppointmentModal .modal-body table tbody tr td:first-child) {
			border-right: 0;
		}

		.modal-body table tbody tr td:last-child:not(#addAppointmentModal .modal-body table tbody tr td:last-child) {
			border-left: 0;
		}

		.modal-body table:not(#addAppointmentModal .modal-body table) {
			border-collapse: separate;
			border-spacing: 0;
			margin: 20px 0;
		}

		.modal-body table tbody tr td:not(#addAppointmentModal .modal-body table tbody tr td),
		.modal-body table thead tr th:not(#addAppointmentModal .modal-body table thead tr th) {
			padding: 5px 10px;
		}

		.bootstrap-datetimepicker-widget .row:first-child
		{
			display: flex;
			align-items: center;
		}

	</style>

@endsection

@section('scripts')

	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNRJukOohRJ1tW0tMG4tzpDXFz68OnonM&libraries=places&callback=initMap" defer></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

	<script type="text/javascript">

		$('.appointment_start').on('dp.change', function(e) {

			var date = $(this).val();

			if(date)
			{
				$('.appointment_end').val(date);
			}

		});

		$(".appointment_type").change(function () {

			var type = $(this).val();

			if(type == 1)
			{
				$('.appointment_customer_box').hide();
                $('.appointment_supplier_box').hide();
                $('.appointment_employee_box').hide();
                $('.appointment_quotation_number_box').show();

                $('.appointment_client').val('');
                $('.appointment_supplier').val('');
                $('.appointment_employee').val('');
                $('.appointment_client').trigger('change.select2');
                $('.appointment_supplier').trigger('change.select2');
                $('.appointment_employee').trigger('change.select2');
			}
			else if(type == 2)
			{
				$('.appointment_quotation_number_box').hide();
                $('.appointment_supplier_box').hide();
                $('.appointment_employee_box').hide();
                $('.appointment_customer_box').show();

                $('.appointment_quotation_number').val('');
                $('.appointment_supplier').val('');
                $('.appointment_employee').val('');
                $('.appointment_quotation_number').trigger('change.select2');
                $('.appointment_supplier').trigger('change.select2');
                $('.appointment_employee').trigger('change.select2');
			}
			else if(type == 3)
            {
                $('.appointment_quotation_number_box').hide();
                $('.appointment_customer_box').hide();
                $('.appointment_employee_box').hide();
                $('.appointment_supplier_box').show();

                $('.appointment_quotation_number').val('');
                $('.appointment_client').val('');
                $('.appointment_employee').val('');
                $('.appointment_quotation_number').trigger('change.select2');
                $('.appointment_client').trigger('change.select2');
                $('.appointment_employee').trigger('change.select2');
            }
            else
            {
                $('.appointment_quotation_number_box').hide();
                $('.appointment_customer_box').hide();
                $('.appointment_supplier_box').hide();
                $('.appointment_employee_box').show();

                $('.appointment_quotation_number').val('');
                $('.appointment_client').val('');
                $('.appointment_supplier').val('');
                $('.appointment_quotation_number').trigger('change.select2');
                $('.appointment_client').trigger('change.select2');
                $('.appointment_supplier').trigger('change.select2');
            }

		});

		$(".submit_appointmentForm").click(function () {

			var validation = $('#addAppointmentModal').find('.modal-body').find('.validation_required');

			var flag = 0;

			var title = $('.appointment_title').val();
			var event_type = $('.appointment_type').val();
			var appointment_quotation_id = $('.appointment_quotation_number').val();
			var customer_id = $('.appointment_client').val();
			var supplier_id = $('.appointment_supplier').val();
            var employee_id = $('.appointment_employee').val();

			if (!title) {
				flag = 1;
				$('.appointment_title_box .select2-container--default .select2-selection--single').css('border-color', 'red');
			}
			else {
				$('.appointment_title_box .select2-container--default .select2-selection--single').css('border-color', '#cacaca');
			}

			if(event_type == 1)
			{
				if(!appointment_quotation_id)
				{
					flag = 1;
					$('.appointment_quotation_number_box .select2-container--default .select2-selection--single').css('border-color', 'red');
				}
				else
				{
					$('.appointment_quotation_number_box .select2-container--default .select2-selection--single').css('border-color', '#cacaca');
				}

				var client_quotation_fname = $(".appointment_quotation_number option:selected").data('fname') != undefined ? $(".appointment_quotation_number option:selected").data('fname') : '';
                var client_quotation_lname = $(".appointment_quotation_number option:selected").data('lname') != undefined ? $(".appointment_quotation_number option:selected").data('lname') : '';
                var client_fname = '';
                var client_lname = '';
                var company_name = '';
                var employee_fname = '';
                var employee_lname = '';
			}
			else if(event_type == 2)
            {
                if(!customer_id)
                {
                    flag = 1;
                    $('.appointment_customer_box .select2-container--default .select2-selection--single').css('border-color', 'red');
                }
                else
                {
                    $('.appointment_customer_box .select2-container--default .select2-selection--single').css('border-color', '#cacaca');
                }

                var client_quotation_fname = '';
                var client_quotation_lname = '';
                var client_fname = $(".appointment_client option:selected").data('fname') != undefined ? $(".appointment_client option:selected").data('fname') : '';
                var client_lname = $(".appointment_client option:selected").data('lname') != undefined ? $(".appointment_client option:selected").data('lname') : '';
                var company_name = '';
                var employee_fname = '';
                var employee_lname = '';
            }
            else if(event_type == 3)
            {
                if(!supplier_id)
                {
                    flag = 1;
                    $('.appointment_supplier_box .select2-container--default .select2-selection--single').css('border-color', 'red');
                }
                else
                {
                    $('.appointment_supplier_box .select2-container--default .select2-selection--single').css('border-color', '#cacaca');
                }

                var client_quotation_fname = '';
                var client_quotation_lname = '';
                var client_fname = '';
                var client_lname = '';
                var company_name = $('.appointment_supplier option:selected').text();
                var employee_fname = '';
                var employee_lname = '';
            }
            else
            {
                if(!employee_id)
                {
                    flag = 1;
                    $('.appointment_employee_box .select2-container--default .select2-selection--single').css('border-color', 'red');
                }
                else
                {
                    $('.appointment_employee_box .select2-container--default .select2-selection--single').css('border-color', '#cacaca');
                }

                var client_quotation_fname = '';
                var client_quotation_lname = '';
                var client_fname = '';
                var client_lname = '';
                var company_name = '';
                var employee_fname = $(".appointment_employee option:selected").data('fname') != undefined ? $(".appointment_employee option:selected").data('fname') : '';
                var employee_lname = $(".appointment_employee option:selected").data('lname') != undefined ? $(".appointment_employee option:selected").data('lname') : '';
            }

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
				var id = $('#event_id').val();
				var appointment_start = $('.appointment_start').val();
				var appointment_end = $('.appointment_end').val();
				var dateAr = /(\d+)\-(\d+)\-(\d+)/.exec(appointment_start);
                var timeAr = appointment_start.split(' ');
                // var timeAr1 = /(\d+)\:(\d+)/.exec(timeAr);
                var format_start = dateAr[3] + '-' + dateAr[2] + '-' + dateAr[1] + ' ' + timeAr[1];
                var dateAr = /(\d+)\-(\d+)\-(\d+)/.exec(appointment_end);
                var timeAr = appointment_end.split(' ');
                var format_end = dateAr[3] + '-' + dateAr[2] + '-' + dateAr[1] + ' ' + timeAr[1];
				var appointment_desc = $('.appointment_description').val();
				var appointment_tags = $('.appointment_tags').val();

				if (format_start <= format_end){

					$('.appointment_end').css('border','');

					var appointments = $('.appointment_data').val();

					if(appointments)
					{
						var data_array = JSON.parse(appointments);
					}
					else
					{
						var data_array = [];
					}

					if(id)
					{
						var event = calendar.getEventById(id);
						event.setDates(format_start,format_end);
						event.setExtendedProp('quotation_id', appointment_quotation_id);
						event.setExtendedProp('event_type', event_type);
						event.setExtendedProp('retailer_client_id', customer_id);
						event.setExtendedProp('supplier_id', supplier_id);
                        event.setExtendedProp('employee_id', employee_id);
						event.setProp('title', title);
						event.setExtendedProp('description',appointment_desc);
						event.setExtendedProp('tags',appointment_tags);
						event.setExtendedProp('client_quotation_fname',client_quotation_fname);
                        event.setExtendedProp('client_quotation_lname',client_quotation_lname);
                        event.setExtendedProp('client_fname',client_fname);
                        event.setExtendedProp('client_lname',client_lname);
                        event.setExtendedProp('company_name',company_name);
                        event.setExtendedProp('employee_fname',employee_fname);
                        event.setExtendedProp('employee_lname',employee_lname);

						$('.fc-daygrid-event').each(function (i, obj) {

							if(appointment_quotation_id)
							{
								var extended_title = client_quotation_fname + ' ' + client_quotation_lname;
							}
							else if(customer_id)
							{
								var extended_title = client_fname + ' ' + client_lname;
							}
							else if(supplier_id)
							{
								var extended_title = company_name;
							}
							else
							{
								var extended_title = employee_fname + ' ' + employee_lname;
							}

							$(this).find(`.extended_title[data-id='${id}']`).text(extended_title);

						});

					}
					else
					{
						var id = parseInt($('.appointment_id').val());
						$('.appointment_id').val(id+1);

						if(appointment_quotation_id == 0)
						{
							var color = '#3788d8';
						}
						else
						{
							var color = 'green';
						}

						calendar.addEvent({
							id: id,
							quotation_id: appointment_quotation_id,
							title: title,
							start: format_start,
							end: format_end + ':01',
							description: appointment_desc,
							tags: appointment_tags,
							event_type: event_type,
							retailer_client_id: customer_id,
							supplier_id: supplier_id,
                            employee_id: employee_id,
                            color: color,
                            client_quotation_fname: client_quotation_fname,
                            client_quotation_lname: client_quotation_lname,
                            client_fname: client_fname,
                            client_lname: client_lname,
                            company_name: company_name,
                            employee_fname: employee_fname,
                            employee_lname: employee_lname,
						});

						var obj = {};
						obj['id'] = id;
						obj['quotation_id'] = appointment_quotation_id;
						obj['title'] = title;
						obj['start'] = format_start;
						obj['end'] = format_end;
						obj['description'] = appointment_desc;
						obj['tags'] = appointment_tags;
						obj['new'] = 1;
						obj['event_type'] = event_type;
						obj['retailer_client_id'] = customer_id;
						obj['supplier_id'] = supplier_id;
                        obj['employee_id'] = employee_id;
						data_array.push(obj);

						$('.appointment_data').val(JSON.stringify(data_array));
					}

					$('#addAppointmentModal').modal('toggle');
					$('#myModal3').modal('toggle');
					$('#event_id').val('');
					$('.appointment_quotation_number').val('');
					$('.appointment_title').val('');
					$('.appointment_start').val('');
					$('.appointment_start').data("DateTimePicker").clear();
					$('.appointment_end').val('');
					$('.appointment_end').data("DateTimePicker").clear();
					$('.appointment_description').val('');
					$('.appointment_client').val('');
					$('.appointment_supplier').val('');
                    $('.appointment_employee').val('');
					$('.appointment_tags').tagsinput('removeAll');
					$('.appointment_title').trigger('change.select2');
					$('.appointment_quotation_number').trigger('change.select2');
					$('.appointment_client').trigger('change.select2');
					$('.appointment_supplier').trigger('change.select2');
                    $('.appointment_employee').trigger('change.select2');

				}
				else
				{
					$('.appointment_end').css('border','1px solid red');
				}
			}

			return false;

		});

		$('#myModal3').on('shown.bs.modal', function () {

			$('body').addClass('modal-open');

		});

		$(".appointment_tags").tagsinput('items');

		$(".add-appointment").click(function () {

			// $('.submit_appointmentForm').show();
			$('#event_id').val('');
			$('.appointment_quotation_number').val('');
			$('.appointment_title').val('');
			$('.appointment_start').val('');
			$('.appointment_start').data("DateTimePicker").clear();
			$('.appointment_end').val('');
			$('.appointment_end').data("DateTimePicker").clear();
			$('.appointment_description').val('');
			$('.appointment_client').val('');
			$('.appointment_supplier').val('');
            $('.appointment_employee').val('');
			$('.appointment_tags').tagsinput('removeAll');
			$('.appointment_title').trigger('change.select2');
			$('.appointment_quotation_number').trigger('change.select2');
			$('.appointment_type').trigger('change.select2');
			$('.appointment_client').trigger('change.select2');
			$('.appointment_supplier').trigger('change.select2');
            $('.appointment_employee').trigger('change.select2');

			$('#myModal3').modal('toggle');
			$('#addAppointmentModal').modal('toggle');

		});

		function edit_appointment(id)
		{
			var event = calendar.getEventById(id);
			var quotation_id = $('input[name="quotation_id"]').val();
			var appointment_quotation_id = event._def.extendedProps.quotation_id;
			var title = event.title;
			var description = event._def.extendedProps.description;
			var tags = event._def.extendedProps.tags;
			var start = moment(event.start).format('DD-MM-YYYY HH:mm');
			var end = event.end ? moment(event.end).format('DD-MM-YYYY HH:mm') : start;
			var event_type = event._def.extendedProps.event_type;
			var retailer_client_id = event._def.extendedProps.retailer_client_id;
			var supplier_id = event._def.extendedProps.supplier_id;
            var employee_id = event._def.extendedProps.employee_id;

			if(quotation_id == appointment_quotation_id)
			{
				quotation_id = 0;
			}
			else
			{
				quotation_id = appointment_quotation_id ? appointment_quotation_id : (event_type == 1 ? 0 : '');
			}

			$('#event_id').val(id);
			$('.appointment_quotation_number').val(quotation_id);
			$('.appointment_title').val(title);
			$('.appointment_start').val(start);
			$('.appointment_end').val(end);
			$('.appointment_description').val(description);
			$('.appointment_tags').tagsinput('removeAll');
			$('.appointment_tags').tagsinput('add',tags);
			$('.appointment_type').val(event_type);
			$('.appointment_client').val(retailer_client_id);
			$('.appointment_supplier').val(supplier_id);
            $('.appointment_employee').val(employee_id);

			$('.appointment_title').trigger('change.select2');
			$('.appointment_quotation_number').trigger('change.select2');
			$('.appointment_type').trigger('change.select2');
			$('.appointment_client').trigger('change.select2');
			$('.appointment_supplier').trigger('change.select2');
            $('.appointment_employee').trigger('change.select2');
			$('.appointment_type').trigger('change');

			$('#myModal3').modal('toggle');
			$('#addAppointmentModal').modal('toggle');
		}

		function remove_appointment(id)
		{
			var event = calendar.getEventById(id);

				event.remove();
				var appointments = $('.appointment_data').val();

				if(appointments)
				{
					appointments = JSON.parse(appointments);
				}
				else
				{
					appointments = [];
				}

				for(var i = 0; i < appointments.length; i++) {
					if(appointments[i].id == id) {
						appointments.splice(i, 1);
						break;
					}
				}

				if(jQuery.isEmptyObject(appointments))
				{
					$('.appointment_data').val('');
				}
				else
				{
					$('.appointment_data').val(JSON.stringify(appointments));
				}
			}

		$('#myModal3').on('shown.bs.modal', function () {

			calendar.render();

		});

		var calendar = '';

		document.addEventListener('DOMContentLoaded', function() {

			var calendarEl = document.getElementById('calendar');

			calendar = new FullCalendar.Calendar(calendarEl, {
				headerToolbar: {
					left: 'prev,next today',
					center: 'title',
					right: 'dayGridMonth,timeGridWeek,timeGridDay'
				},
				initialDate: new Date(),
				navLinks: true, // can click day/week names to navigate views
				selectable: true,
				selectMirror: true,
				select: function(arg) {
					$(".add-appointment").trigger("click");
					calendar.unselect()
				},
				eventChange: function(arg) {

					var quotation_id = arg.event._def.extendedProps.quotation_id;
					var title = arg.event._def.title;
					var description = arg.event._def.extendedProps.description;
					var tags = arg.event._def.extendedProps.tags;
					var start = new Date(arg.event._instance.range.start.toLocaleString('en-US', { timeZone: 'UTC' }));
					var end = new Date(arg.event._instance.range.end.toLocaleString('en-US', { timeZone: 'UTC' }));
					var retailer_client_id = arg.event._def.extendedProps.retailer_client_id;
					var event_type = arg.event._def.extendedProps.event_type;
					var supplier_id = arg.event._def.extendedProps.supplier_id;
                    var employee_id = arg.event._def.extendedProps.employee_id;

					var start_date = new Date(start);
					var curr_date = (start_date.getDate()<10?'0':'') + start_date.getDate();
					var curr_month = start_date.getMonth() + 1;
					curr_month = (curr_month<10?'0':'') + curr_month;
					var curr_year = start_date.getFullYear();
					var hour = (start_date.getHours()<10?'0':'') + start_date.getHours();
					var minute = (start_date.getMinutes()<10?'0':'') + start_date.getMinutes();
					start = curr_year+"-"+curr_month+"-"+curr_date+" "+hour+":"+minute;

					var end_date = new Date(end);
					var curr_date = (end_date.getDate()<10?'0':'') + end_date.getDate();
					var curr_month = end_date.getMonth() + 1;
					curr_month = (curr_month<10?'0':'') + curr_month;
					var curr_year = end_date.getFullYear();
					var hour = (end_date.getHours()<10?'0':'') + end_date.getHours();
					var minute = (end_date.getMinutes()<10?'0':'') + end_date.getMinutes();
					end = curr_year+"-"+curr_month+"-"+curr_date+" "+hour+":"+minute;

						var id = arg.event._def.publicId;
						var data = $('.appointment_data').val();
						var appointments = data ? JSON.parse(data) : '';

						for(var i = 0; i < appointments.length; i++) {

							if(appointments[i].id == id) {

								appointments[i]['title'] = title;
								appointments[i]['start'] = start;
								appointments[i]['end'] = end;
								appointments[i]['description'] = description;
								appointments[i]['tags'] = tags;
								appointments[i]['quotation_id'] = quotation_id;
								appointments[i]['event_type'] = event_type;
								appointments[i]['retailer_client_id'] = retailer_client_id;
								appointments[i]['supplier_id'] = supplier_id;
                            	appointments[i]['employee_id'] = employee_id;

								$('.appointment_data').val(JSON.stringify(appointments));
								break;
							}

						}

				},
				eventContent: function (arg) {

				},
				eventDidMount: function (arg)
				{
					var actualAppointment = $(arg.el);
					var event = arg.event;
					var id = arg.event._def.publicId;

						if(event._def.extendedProps.quotation_id)
                    	{
							if(event._def.extendedProps.client_quotation_fname || event._def.extendedProps.client_quotation_lname)
							{
								actualAppointment.find('.fc-event-title').append("<br/>" + '<span class="extended_title" data-id="'+id+'" style="font-size: 12px;">'+ event._def.extendedProps.client_quotation_fname + ' ' + event._def.extendedProps.client_quotation_lname +'</span>');
							}
							else
							{
								actualAppointment.find('.fc-event-title').append("<br/>" + '<span class="extended_title" data-id="'+id+'" style="font-size: 12px;"></span>');
							}
                    	}
                    	else if(event._def.extendedProps.retailer_client_id)
                    	{
                        	actualAppointment.find('.fc-event-title').append("<br/>" + '<span class="extended_title" data-id="'+id+'" style="font-size: 12px;">'+ event._def.extendedProps.client_fname + ' ' + event._def.extendedProps.client_lname +'</span>');
                    	}
                    	else if(event._def.extendedProps.supplier_id)
                    	{
                        	actualAppointment.find('.fc-event-title').append("<br/>" + '<span class="extended_title" data-id="'+id+'" style="font-size: 12px;">'+ event._def.extendedProps.company_name +'</span>');
                    	}
                    	else
                    	{
                        	actualAppointment.find('.fc-event-title').append("<br/>" + '<span class="extended_title" data-id="'+id+'" style="font-size: 12px;">'+ event._def.extendedProps.employee_fname + ' ' + event._def.extendedProps.employee_lname +'</span>');
                    	}

						var buttonsHtml = '<div class="fc-buttons">' + '<button class="btn btn-default edit-event" title="Edit"><i class="fa fa-pencil"></i></button>' + '<button class="btn btn-default remove-event" title="Remove"><i class="fa fa-trash"></i></button>' + '</div>';

					actualAppointment.append(buttonsHtml);

					actualAppointment.find(".edit-event").on('click', function () {
						edit_appointment(event.id);
					});

					actualAppointment.find(".remove-event").on('click', function () {
						remove_appointment(event.id);
					});
				},
				eventClick: function(arg) {

				},
				eventTimeFormat: { // like '14:30:00'
    				hour: '2-digit',
					minute: '2-digit',
					hour12:false
				},
				displayEventEnd: true,
				editable: true,
				dayMaxEvents: true, // allow "more" link when too many events
				events: {!! $current_appointments !!},
			});

			calendar.setOption('locale', 'nl');

		});

		function initMap() {

			var input = document.getElementById('address');

			var options = {
				componentRestrictions: { country: "nl" }
			};

			var autocomplete = new google.maps.places.Autocomplete(input, options);

			// Set the data fields to return when the user selects a place.
			autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);

			autocomplete.addListener('place_changed', function () {

				var flag = 0;

				var place = autocomplete.getPlace();

				if (!place.geometry) {

					// User entered the name of a Place that was not suggested and
					// pressed the Enter key, or the Place Details request failed.
					window.alert("{{__('text.No details available for input: ')}}" + place.name);
					return;
				}
				else {
					var string = $('#address').val().substring(0, $('#address').val().indexOf(',')); //first string before comma

					if (string) {
						var is_number = $('#address').val().match(/\d+/);

						if (is_number === null) {
							flag = 1;
						}
					}
				}

				var city = '';
				var postal_code = '';

				for (var i = 0; i < place.address_components.length; i++) {
					if (place.address_components[i].types[0] == 'postal_code') {
						postal_code = place.address_components[i].long_name;
					}

					if (place.address_components[i].types[0] == 'locality') {
						city = place.address_components[i].long_name;
					}
				}

				if (city == '') {
					for (var i = 0; i < place.address_components.length; i++) {
						if (place.address_components[i].types[0] == 'administrative_area_level_2') {
							city = place.address_components[i].long_name;

						}
					}
				}

				if (postal_code == '' || city == '') {
					flag = 1;
				}

				if (!flag) {
					$('#check_address').val(1);
					$("#address-error").remove();
					$('#postcode').val(postal_code);
					$("#city").val(city);
				}
				else {
					$('#address').val('');
					$('#postcode').val('');
					$("#city").val('');

					$("#address-error").remove();
					$('#address').parent().parent().append('<small id="address-error" style="color: red;display: block;margin-top: 10px;">{{__('text.Kindly write your full address with house / building number so system can detect postal code and city from it!')}}</small>');

				}


			});

		}

		$("#address").on('input', function (e) {
			$(this).next('input').val(0);
		});

		$("#address").focusout(function () {

			var check = $(this).next('input').val();

			if (check == 0) {
				$(this).val('');
				$('#postcode').val('');
				$("#city").val('');
			}
		});

		$(document).ready(function () {

			$(".submit-customer").click(function () {

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
				var email_flag = 0;

				$(validation).each(function () {

					if (!$(this).val()) {
						$(this).css('border', '1px solid red');
						flag = 1;
					}
					else {
						$(this).css('border', '');
					}

				});

				if (!flag) {

					if(email)
					{
						var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

						if(!regex.test(email))
						{
							email_flag = 1;
						}
					}
					
					if (email_flag) {
						$('#email').css('border', '1px solid red');

						$('.alert-box').html('<div class="alert alert-danger">\n' +
								'                                            <button type="button" class="close cl-btn" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>\n' +
								'                                            <p class="text-left">{{__('text.Email address is not valid...')}}</p>\n' +
								'                                        </div>');
						$('.alert-box').show();
						$('.alert-box').delay(5000).fadeOut(400);
					}
					else {
						$('#email').css('border', '');

						$('#cover').show();

						$.ajax({

							type: "POST",
							data: "handyman_id=" + handyman_id + "&handyman_name=" + handyman_name + "&name=" + name + "&family_name=" + family_name + "&business_name=" + business_name + "&postcode=" + postcode + "&address=" + address + "&city=" + city + "&phone=" + phone + "&email=" + email + "&_token=" + token,
							url: "<?php echo url('/aanbieder/create-customer')?>",

							success: function (data) {

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
										'                                            <p class="text-left">' + data.message + '</p>\n' +
										'                                        </div>');
								$('.alert-box').show();
								$('.alert-box').delay(5000).fadeOut(400);

								$('#myModal1').modal('toggle');
								window.scrollTo({ top: 0, behavior: 'smooth' });
							},
							error: function (data) {

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
										'                                            <p class="text-left">{{__('text.Something went wrong!')}}</p>\n' +
										'                                        </div>');
								$('.alert-box').show();
								$('.alert-box').delay(5000).fadeOut(400);

								$('#myModal1').modal('toggle');
								window.scrollTo({ top: 0, behavior: 'smooth' });
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
					"noResults": function () {
						return '{{__('text.No results found')}}';
					}
				},
			});

			// var current_desc = '';
			//
			// $(".add-desc").click(function () {
			// 	current_desc = $(this);
			// 	var d = current_desc.prev('input').val();
			// 	$('#description-text').val(d);
			// 	$("#myModal").modal('show');
			// });
			//
			// $(".submit-desc").click(function () {
			// 	var desc = $('#description-text').val();
			// 	current_desc.prev('input').val(desc);
			// 	$('#description-text').val('');
			// 	$("#myModal").modal('hide');
			// });

			$(".appointment_title").select2({
				width: '100%',
				height: '200px',
				placeholder: "{{__('text.Select Event Title')}}",
				allowClear: true,
				"language": {
					"noResults": function () {
						return '{{__('text.No results found')}}';
					}
				},
			});

			$(".appointment_type").select2({
				width: '100%',
				height: '200px',
				placeholder: "{{__('text.Select Event Type')}}",
				allowClear: false,
				"language": {
					"noResults": function () {
						return '{{__('text.No results found')}}';
					}
				},
			});

			$(".appointment_quotation_number").select2({
				width: '100%',
				height: '200px',
				placeholder: "{{__('text.Select Quotation')}}",
				allowClear: false,
				"language": {
					"noResults": function () {
						return '{{__('text.No results found')}}';
					}
				},
			});

			$(".appointment_client").select2({
				width: '100%',
				height: '200px',
				placeholder: "{{__('text.Select Customer')}}",
				allowClear: false,
				"language": {
					"noResults": function () {
						return '{{__('text.No results found')}}';
					}
				},
			});

			$(".appointment_supplier").select2({
            	width: '100%',
            	height: '200px',
            	placeholder: "{{__('text.Select Supplier')}}",
            	allowClear: false,
            	"language": {
                	"noResults": function () {
                    	return '{{__('text.No results found')}}';
                	}
            	},
        	});

        	$(".appointment_employee").select2({
            	width: '100%',
            	height: '200px',
            	placeholder: "{{__('text.Select Employee')}}",
            	allowClear: false,
            	"language": {
                	"noResults": function () {
                    	return '{{__('text.No results found')}}';
                	}
            	},
        	});

			$('.appointment_start').datetimepicker({
				format: 'DD-MM-YYYY HH:mm',
				defaultDate: '',
				ignoreReadonly: true,
				sideBySide: true,
			});

			$('.appointment_end').datetimepicker({
				format: 'DD-MM-YYYY HH:mm',
				defaultDate: '',
				ignoreReadonly: true,
				sideBySide: true,
			});

			$(".js-data-example-ajax").select2({
				width: '100%',
				height: '200px',
				placeholder: "{{__('text.Select Product')}}",
				allowClear: true,
				"language": {
					"noResults": function () {
						return '{{__('text.No results found')}}';
					}
				},
			});

			function calculate_total(qty_changed = 0,labor_changed = 0) {

				var total = 0;
				var price_before_labor_total = 0;
				var labor_cost_total = 0;

				$("input[name='total[]']").each(function (i, obj) {

					var rate = 0;
					var row_id = $(this).parent().data('id');
					var qty = $('#menu1').find(`[data-id='${row_id}']`).find('input[name="qty[]"]').val();

					if (!qty) {
						qty = 0;
					}

					if (!obj.value) {
						rate = 0;
					}
					else {
						rate = obj.value;
					}

					rate = rate * qty;

					var labor_impact = $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val();
					labor_impact = labor_impact * qty;
					labor_impact = parseFloat(labor_impact).toFixed(2);
					/*labor_impact = Math.round(labor_impact);*/

					if(labor_changed == 0)
					{
						$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val(labor_impact.replace(/\./g, ','));
					}

					var price_before_labor = $('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val();
					price_before_labor = price_before_labor * qty;
					price_before_labor = parseFloat(price_before_labor).toFixed(2);
					/*price_before_labor = Math.round(price_before_labor);*/
					$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val(price_before_labor.replace(/\./g, ','));

					if(qty_changed == 0)
					{
						var old_discount = $('#products_table').find(`[data-id='${row_id}']`).find('.total_discount').val();
						old_discount = old_discount.replace(/\,/g, '.');
						old_discount = parseFloat(old_discount).toFixed(2);

						rate = rate - old_discount;

						var discount = $('#products_table').find(`[data-id='${row_id}']`).find('.discount-box').find('.discount_values').val();
						var labor_discount = $('#products_table').find(`[data-id='${row_id}']`).find('.labor-discount-box').find('.labor_discount_values').val();


						if(!discount)
						{
							discount = 0;
						}


						if(!labor_discount)
						{
							labor_discount = 0;
						}

						var discount_val = parseFloat(price_before_labor) * (discount/100);
						/*discount_val = Math.round(discount_val);*/
						var labor_discount_val = parseFloat(labor_impact) * (labor_discount/100);
						/*labor_discount_val = Math.round(labor_discount_val);*/

						var total_discount = discount_val + labor_discount_val;
						total_discount = parseFloat(total_discount).toFixed(2);
						var old_discount = total_discount / qty;
						old_discount = parseFloat(old_discount).toFixed(2);
						$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount').val('-' + total_discount.replace(/\./g, ','));
						$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount_old').val('-' + old_discount);

						rate = parseFloat(rate) - parseFloat(total_discount);
						var price = rate / qty;
						/*price = Math.round(price);*/

						/*$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val(rate);*/
						$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val(price);

					}
					else
					{
						var price = rate / qty;
						/*price = Math.round(price);*/

						if(qty != 0)
						{
							/*$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val(rate);*/
							$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val(price);
						}

						var old_discount = $('#products_table').find(`[data-id='${row_id}']`).find('.total_discount_old').val();
						old_discount = old_discount * qty;
						old_discount = parseFloat(old_discount).toFixed(2);

						$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount').val(old_discount.replace(/\./g, ','));
					}

					rate = parseFloat(rate);
					rate = rate.toFixed(2);
					/*rate = Math.round(rate);*/

					total = parseFloat(total) + parseFloat(rate);
					total = total.toFixed(2);
					/*total = Math.round(total);*/

					$(this).parent().find('#rate').val(rate);
					$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('€ ' + new Intl.NumberFormat('nl-NL',{minimumFractionDigits: 2,maximumFractionDigits: 2}).format(rate));
					/*$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('€ ' + rate);*/

					var art = price_before_labor;
					price_before_labor_total = parseFloat(price_before_labor_total) + parseFloat(art);
					price_before_labor_total = parseFloat(price_before_labor_total).toFixed(2);

					var arb = labor_impact;
					labor_cost_total = parseFloat(labor_cost_total) + parseFloat(arb);
					labor_cost_total = parseFloat(labor_cost_total).toFixed(2);

				});

				var net_amount = (total / 121) * 100;
				net_amount = parseFloat(net_amount).toFixed(2);
				//net_amount = Math.round(net_amount);

				var tax_amount = total - net_amount;
				tax_amount = parseFloat(tax_amount).toFixed(2);

				$('#total_amount').val(new Intl.NumberFormat('nl-NL',{minimumFractionDigits: 2,maximumFractionDigits: 2}).format(total));
				$('#price_before_labor_total').val(new Intl.NumberFormat('nl-NL',{minimumFractionDigits: 2,maximumFractionDigits: 2}).format(price_before_labor_total));
				$('#labor_cost_total').val(new Intl.NumberFormat('nl-NL',{minimumFractionDigits: 2,maximumFractionDigits: 2}).format(labor_cost_total));
				$('#net_amount').val(new Intl.NumberFormat('nl-NL',{minimumFractionDigits: 2,maximumFractionDigits: 2}).format(net_amount));
				$('#tax_amount').val(new Intl.NumberFormat('nl-NL',{minimumFractionDigits: 2,maximumFractionDigits: 2}).format(tax_amount));
			}

			$(document).on('change', ".js-data-example-ajax1", function (e) {

				var current = $(this);

				var id = current.val();
				var row_id = current.parents(".content-div").data('id');
				var options = '';
				$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(0);

				$.ajax({
					type: "GET",
					data: "id=" + id,
					url: "<?php echo url('/aanbieder/get-supplier-products')?>",
					success: function (data) {

						$('#menu1').find(`[data-id='${row_id}']`).remove();

						$('#products_table').find(`[data-id='${row_id}']`).find('.discount-box').find('.discount_values').val(0);
						$('#products_table').find(`[data-id='${row_id}']`).find('.labor-discount-box').find('.labor_discount_values').val(0);
						$('#products_table').find(`[data-id='${row_id}']`).find('#childsafe').val(0);
						$('#products_table').find(`[data-id='${row_id}']`).find('#ladderband').val(0);
						$('#products_table').find(`[data-id='${row_id}']`).find('#ladderband_value').val(0);
						$('#products_table').find(`[data-id='${row_id}']`).find('#ladderband_price_impact').val(0);
						$('#products_table').find(`[data-id='${row_id}']`).find('#ladderband_impact_type').val(0);
						$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount').val(0);
						$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount_old').val(0);
						$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val('');
						$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val('');
						$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
						$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
						$('#products_table').find(`[data-id='${row_id}']`).find('.model').find('.model_impact_value').val('');
						$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('');
						$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val('');
						$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val('');
						$('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val('');
						$('#myModal2').find(`.comment-boxes[data-id='${row_id}']`).remove();

						$.each(data, function (index, value) {

							if (value.title) {
								var opt = '<option value="' + value.id + '" >' + value.title + '</option>';

								options = options + opt;
							}

						});

						$('#products_table').find(`[data-id='${row_id}']`).find('.products').children('select').find('option')
								.remove()
								.end()
								.append('<option value="">{{__('text.Select Product')}}</option>' + options);


						$('#products_table').find(`[data-id='${row_id}']`).find('.color').children('select').find('option')
								.remove()
								.end()
								.append('<option value="">{{__('text.Select Color')}}</option>');

						$('#products_table').find(`[data-id='${row_id}']`).find('.model').children('select').find('option')
								.remove()
								.end()
								.append('<option value="">{{__('text.Select Model')}}</option>');

						$('#products_table').find(`[data-id='${row_id}']`).find('.width').find('.measure-unit').val('');
						$('#products_table').find(`[data-id='${row_id}']`).find('.height').find('.measure-unit').val('');

						/*calculate_total();*/

					}
				});

				$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').hide();
				$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').css('visibility','visible');
				$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').show();

			});

			$(document).on('change', ".js-data-example-ajax", function (e) {

				var current = $(this);

				var id = current.val();
				var row_id = current.parents(".content-div").data('id');
				var options = '';
				var options1 = '';
				$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(0);

				$.ajax({
					type: "GET",
					data: "id=" + id,
					url: "<?php echo url('/aanbieder/get-colors')?>",
					success: function (data) {

						$('#menu1').find(`[data-id='${row_id}']`).remove();

						if (data != '') {

							$('#products_table').find(`[data-id='${row_id}']`).find('.discount-box').find('.discount_values').val(0);
							$('#products_table').find(`[data-id='${row_id}']`).find('.labor-discount-box').find('.labor_discount_values').val(0);
							$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount').val(0);
							$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount_old').val(0);
							$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val('');
							$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val('');
							$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
							$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
							$('#products_table').find(`[data-id='${row_id}']`).find('.model').find('.model_impact_value').val('');
							$('#products_table').find(`[data-id='${row_id}']`).find('#delivery_days').val(data.delivery_days);
							$('#products_table').find(`[data-id='${row_id}']`).find('#ladderband').val(data.ladderband);
							$('#products_table').find(`[data-id='${row_id}']`).find('#ladderband_value').val(data.ladderband_value);
							$('#products_table').find(`[data-id='${row_id}']`).find('#ladderband_price_impact').val(data.ladderband_price_impact);
							$('#products_table').find(`[data-id='${row_id}']`).find('#ladderband_impact_type').val(data.ladderband_impact_type);
							$('#products_table').find(`[data-id='${row_id}']`).find('#price_based_option').val(data.price_based_option);
							$('#products_table').find(`[data-id='${row_id}']`).find('#base_price').val(data.base_price);
							$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('');
							$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val('');
							$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val('');
							$('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val('');
							$('#myModal2').find(`.comment-boxes[data-id='${row_id}']`).remove();

							var price_based_option = data.price_based_option;

							if (price_based_option == 1) {
								$('#products_table').find(`[data-id='${row_id}']`).find('.width').children('.m-box').children('.m-input').attr('readonly', false);
								$('#products_table').find(`[data-id='${row_id}']`).find('.height').children('.m-box').children('.m-input').attr('readonly', false);
							}
							else if (price_based_option == 2) {
								$('#products_table').find(`[data-id='${row_id}']`).find('.width').children('.m-box').children('.m-input').attr('readonly', false);
								$('#products_table').find(`[data-id='${row_id}']`).find('.height').children('.m-box').children('.m-input').attr('readonly', true);
								$('#products_table').find(`[data-id='${row_id}']`).find('.height').children('.m-box').children('.m-input').val(0);
							}
							else {
								$('#products_table').find(`[data-id='${row_id}']`).find('.width').children('.m-box').children('.m-input').attr('readonly', true);
								$('#products_table').find(`[data-id='${row_id}']`).find('.width').children('.m-box').children('.m-input').val(0);
								$('#products_table').find(`[data-id='${row_id}']`).find('.height').children('.m-box').children('.m-input').attr('readonly', false);
							}

							$.each(data.colors, function (index, value) {

								if (value.title) {
									var opt = '<option value="' + value.id + '" >' + value.title + '</option>';

									options = options + opt;
								}

							});

							$.each(data.models, function (index1, value1) {

								if (value1.model) {
									var opt1 = '<option value="' + value1.id + '" >' + value1.model + '</option>';

									options1 = options1 + opt1;
								}

							});

							$('#products_table').find(`[data-id='${row_id}']`).find('.color').children('select').find('option')
									.remove()
									.end()
									.append('<option value="">{{__('text.Select Color')}}</option>' + options);

							$('#products_table').find(`[data-id='${row_id}']`).find('.model').children('select').find('option')
									.remove()
									.end()
									.append('<option value="">{{__('text.Select Model')}}</option>' + options1);

							if ((typeof (data) != "undefined") && data.measure) {
								$('#products_table').find(`[data-id='${row_id}']`).find('.width').find('.measure-unit').val(data.measure);
								$('#products_table').find(`[data-id='${row_id}']`).find('.height').find('.measure-unit').val(data.measure);
							}
							else {
								$('#products_table').find(`[data-id='${row_id}']`).find('.width').find('.measure-unit').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('.height').find('.measure-unit').val('');
							}
						}

						/*calculate_total();*/

						var windowsize = $(window).width();

						if (windowsize > 992) {

							$('#products_table').find(`[data-id='${row_id}']`).find('.collapse').collapse('show');

						}

					}
				});

				$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').hide();
				$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').css('visibility','visible');
				$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').show();

			});

			$(".js-data-example-ajax1").select2({
				width: '100%',
				height: '200px',
				placeholder: "{{__('text.Select Supplier')}}",
				allowClear: true,
				"language": {
					"noResults": function () {
						return '{{__('text.No results found')}}';
					}
				},
			});

			$(".js-data-example-ajax2").select2({
				width: '100%',
				height: '200px',
				placeholder: "{{__('text.Select Color')}}",
				allowClear: true,
				"language": {
					"noResults": function () {
						return '{{__('text.No results found')}}';
					}
				},
			});

			$(".js-data-example-ajax3").select2({
				width: '100%',
				height: '200px',
				placeholder: "{{__('text.Select Model')}}",
				allowClear: true,
				"language": {
					"noResults": function () {
						return '{{__('text.No results found')}}';
					}
				},
			});

			$(document).on('change', ".js-data-example-ajax3", function (e) {

				var current = $(this);
				var row_id = current.parents(".content-div").data('id');

				var model = current.val();
				var color = $('#products_table').find(`[data-id='${row_id}']`).find('.color').find('select').val();

				var price_based_option = $('#products_table').find(`[data-id='${row_id}']`).find('#price_based_option').val();
				var base_price = $('#products_table').find(`[data-id='${row_id}']`).find('#base_price').val();

				var width = $('#products_table').find(`[data-id='${row_id}']`).find('.width').find('.m-input').val();
				width = width.replace(/\,/g, '.');

				var height = $('#products_table').find(`[data-id='${row_id}']`).find('.height').find('.m-input').val();
				height = height.replace(/\,/g, '.');

				var product = $('#products_table').find(`[data-id='${row_id}']`).find('.products').find('select').val();
				var ladderband = $('#products_table').find(`[data-id='${row_id}']`).find('#ladderband').val();
				$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(0);

				if (width && height && color && model && product) {

					if ($('#products_table').find(`[data-id='${row_id}']`).find('.suppliers').hasClass('hide')) {
						var margin = 0;
					}
					else {
						var margin = 1;
					}

					$('#products_table').find(`[data-id='${row_id}']`).find('.discount-box').find('.discount_values').val(0);
					$('#products_table').find(`[data-id='${row_id}']`).find('.labor-discount-box').find('.labor_discount_values').val(0);
					$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount').val(0);
					$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount_old').val(0);

					$.ajax({
						type: "GET",
						data: "product=" + product + "&color=" + color + "&model=" + model + "&width=" + width + "&height=" + height + "&margin=" + margin,
						url: "<?php echo url('/aanbieder/get-price')?>",
						success: function (data) {

							if (typeof data[0].value !== 'undefined') {

								$('#myModal2').find(`.comment-boxes[data-id='${row_id}']`).remove();

								if (data[0].value === 'both') {
									Swal.fire({
										icon: 'error',
										title: '{{__('text.Oops...')}}',
										html: '{{__('text.Width & Height are greater than max values')}} <br> {{__('text.Max Width')}}: ' + data[0].max_width + '<br> {{__('text.Max Height')}}: ' + data[0].max_height,
									});

									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.model').find('.model_impact_value').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(3);
								}
								else if (data[0].value === 'x_axis') {
									Swal.fire({
										icon: 'error',
										title: '{{__('text.Oops...')}}',
										html: '{{__('text.Width is greater than max value')}} <br> {{__('text.Max Width')}}: ' + data[0].max_width,
									});

									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.model').find('.model_impact_value').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(1);
								}
								else if (data[0].value === 'y_axis') {

									Swal.fire({
										icon: 'error',
										title: '{{__('text.Oops...')}}',
										html: '{{__('text.Height is greater than max value')}} <br> {{__('text.Max Height')}}: ' + data[0].max_height,
									});

									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.model').find('.model_impact_value').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(2);
								}
								else {

									$('#products_table').find(`[data-id='${row_id}']`).find('#childsafe').val(data[3].childsafe);
									var childsafe = data[3].childsafe;

									if (price_based_option == 1) {
										var price = data[0].value;
										var org = data[0].value;
									}
									else {
										var price = base_price;
										var org = base_price;
									}

									var basic_price = price;

									/*if (margin == 1) {
                                        if (data[2]) {
                                            price = parseFloat(price);
                                            var supplier_margin = data[2].margin;
                                            var retailer_margin = data[2].retailer_margin;

                                            current.parent().parent().find('#supplier_margin').val(supplier_margin);
                                            current.parent().parent().find('#retailer_margin').val(retailer_margin);

                                            if (supplier_margin && retailer_margin) {
                                                price = (price / supplier_margin) * retailer_margin;
                                                price = price.toFixed(2);
                                            }
                                        }
                                    }*/

									var features = '';
									var count_features = 0;
									var f_value = 0;
									var m1_impact = data[3].m1_impact;
									var m2_impact = data[3].m2_impact;
									var m1_impact_value = 0;
									var m2_impact_value = 0;

									$('#myModal').find('.modal-body').find(`[data-id='${row_id}']`).remove();

									if (childsafe == 1) {

										count_features = count_features + 1;

										var content = '<div class="row childsafe-content-box" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
												'<label style="margin-right: 10px;margin-bottom: 0;">Montagehoogte</label>' +
												'<input style="border: none;border-bottom: 1px solid lightgrey;" type="number" class="form-control childsafe_values" id="childsafe_x" name="childsafe_x' + row_id + '">\n' +
												'</div></div>\n' +
												'<div class="row childsafe-content-box1" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
												'<label style="margin-right: 10px;margin-bottom: 0;">Kettinglengte</label>' +
												'<input style="border: none;border-bottom: 1px solid lightgrey;" type="number" class="form-control childsafe_values" id="childsafe_y" name="childsafe_y' + row_id + '">\n' +
												'</div></div>\n' +
												'<div class="row childsafe-question-box" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
												'<label style="margin-right: 10px;margin-bottom: 0;">{{__('text.Childsafe')}}</label>' +
												'<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control childsafe-select" name="childsafe_option' + row_id + '">\n' +
												'<option value="">{{__('text.Select any option')}}</option>\n' +
												'<option value="2">{{__('text.Add childsafety clip')}}</option>\n' +
												'</select>\n' +
												'<input value="0" name="childsafe_diff' + row_id + '" class="childsafe_diff" type="hidden">' +
												'</div></div>\n';

										features = features + content;

									}

									if (ladderband == 1) {

										var content = '<div class="row" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
												'<label style="margin-right: 10px;margin-bottom: 0;">{{__('text.Ladderband')}}</label>' +
												'<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features' + row_id + '[]">\n' +
												'<option value="0">{{__('text.No')}}</option>\n' +
												'<option value="1">{{__('text.Yes')}}</option>\n' +
												'</select>\n' +
												'<input value="0" name="f_price' + row_id + '[]" class="f_price" type="hidden">' +
												'<input value="0" name="f_id' + row_id + '[]" class="f_id" type="hidden">' +
												'<input value="0" name="f_area' + row_id + '[]" class="f_area" type="hidden">' +
												'<input value="0" name="sub_feature' + row_id + '[]" class="sub_feature" type="hidden">' +
												'</div><a data-id="' + row_id + '" class="info ladderband-btn hide">{{__('text.Info')}}</a></div>\n';

										features = features + content;

									}

									$.each(data[1], function (index, value) {

										count_features = count_features + 1;

										var opt = '<option value="0">{{__('text.Select Feature')}}</option>';

										$.each(value.features, function (index1, value1) {

											opt = opt + '<option value="' + value1.id + '">' + value1.title + '</option>';

										});

										if (value.comment_box == 1) {
											var icon = '<a data-feature="' + value.id + '" class="info comment-btn">{{__('text.Info')}}</a>';
										}
										else {
											var icon = '';
										}

										var content = '<div class="row" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
												'<label style="margin-right: 10px;margin-bottom: 0;">' + value.title + '</label>' +
												'<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features' + row_id + '[]">' + opt + '</select>\n' +
												'<input value="' + f_value + '" name="f_price' + row_id + '[]" class="f_price" type="hidden">' +
												'<input value="' + value.id + '" name="f_id' + row_id + '[]" class="f_id" type="hidden">' +
												'<input value="0" name="f_area' + row_id + '[]" class="f_area" type="hidden">' +
												'<input value="0" name="sub_feature' + row_id + '[]" class="sub_feature" type="hidden">' +
												'</div>' + icon + '</div>\n';

										features = features + content;

									});

									if(count_features > 0)
									{
										$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').hide();
										$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').css('visibility','visible');
										$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').show();
									}
									else
									{
										$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').hide();
										$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').css('visibility','visible');
										$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').show();
									}

									if ($('#menu1').find(`[data-id='${row_id}']`).length > 0) {
										$('#menu1').find(`[data-id='${row_id}']`).remove();
									}

									$('#menu1').append('<div data-id="' + row_id + '" style="margin: 0;" class="form-group">' +
											'\n' +
											'<div class="row" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
											'<label style="margin-right: 10px;margin-bottom: 0;">{{__('text.Quantity')}}</label>' +
											'<?php if(Route::currentRouteName() == 'create-new-negative-invoice'){ echo '-'; } ?>'+
											'<input value="1" style="border: none;border-bottom: 1px solid lightgrey;" maskedformat="9,1" name="qty[]" class="form-control" type="text" /><span>pcs</span>' +
											'</div></div>' + features +
											'</div>');

									if (data[3].max_size) {
										var sq = (width * height) / 10000;
										var max_size = data[3].max_size;

										if (sq > max_size) {
											Swal.fire({
												icon: 'error',
												title: '{{__('text.Oops...')}}',
												text: '{{__('text.Area is greater than max size')}}: ' + max_size,
											});

											current.parent().find('.f_area').val(1);
										}
									}
									else {
										current.parent().find('.f_area').val(0);
									}

									var model_impact_value = data[3].value;

									if (m1_impact == 1) {

										m1_impact_value = model_impact_value * (width / 100);

									}

									if (m2_impact == 1) {

										m2_impact_value = model_impact_value * ((width/100) * (height/100));

									}

									if (data[3].price_impact == 1) {

										if (data[3].impact_type == 0) {

											price = parseFloat(price) + parseFloat(model_impact_value);
											price = price.toFixed(2);

										}
										else {

											var per = (model_impact_value) / 100;
											model_impact_value = basic_price * per;

											price = parseFloat(price) + parseFloat(model_impact_value);
											price = price.toFixed(2);
										}

									}

									price = parseFloat(price) + parseFloat(m1_impact_value) + parseFloat(m2_impact_value);

									if(margin == 1)
									{
										if (data[2]) {

											var supplier_margin = data[2].margin;
											var retailer_margin = data[2].retailer_margin;

											if (supplier_margin && retailer_margin) {
												price = (parseFloat(price) / supplier_margin) * retailer_margin;
											}
										}
									}

									price = parseFloat(price).toFixed(2);

									var price_before_labor = parseFloat(price).toFixed(2);
									var labor = 0;

									if (data[4]) {
										labor = data[4].labor;
										labor = labor * (width / 100);
										//labor = Math.round(labor);
										price = parseFloat(price) + parseFloat(labor);
										price = price.toFixed(2);
									}

									labor = parseFloat(labor).toFixed(2);

									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val(price_before_labor.replace(/\./g, ','));
									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val(price_before_labor);
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val(labor.replace(/\./g, ','));
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val(labor);
									$('#products_table').find(`[data-id='${row_id}']`).find('.model').find('.model_impact_value').val(model_impact_value);
									//$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('€ ' + Math.round(price));
									$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('€ ' + price.replace(/\./g, ','));
									$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val(price);
									$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val(price);
									$('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val(basic_price);

								}
							}
							else {
								$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('.model').find('.model_impact_value').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('');
								$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val('');

								$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').hide();
								$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').css('visibility','visible');
								$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').show();
							}

							calculate_total();
						}
					});
				}
				else
				{
					$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').hide();
					$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').css('visibility','visible');
					$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').show();
				}

			});

			$(document).on('change', ".js-data-example-ajax2", function (e) {

				var current = $(this);
				var row_id = current.parents(".content-div").data('id');

				var color = current.val();
				var model = $('#products_table').find(`[data-id='${row_id}']`).find('.model').find('select').val();

				var price_based_option = $('#products_table').find(`[data-id='${row_id}']`).find('#price_based_option').val();
				var base_price = $('#products_table').find(`[data-id='${row_id}']`).find('#base_price').val();

				var width = $('#products_table').find(`[data-id='${row_id}']`).find('.width').find('.m-input').val();
				width = width.replace(/\,/g, '.');

				var height = $('#products_table').find(`[data-id='${row_id}']`).find('.height').find('.m-input').val();
				height = height.replace(/\,/g, '.');

				var product = $('#products_table').find(`[data-id='${row_id}']`).find('.products').find('select').val();
				var ladderband = $('#products_table').find(`[data-id='${row_id}']`).find('#ladderband').val();
				$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(0);

				if (width && height && color && model && product) {

					if ($('#products_table').find(`[data-id='${row_id}']`).find('.suppliers').hasClass('hide')) {
						var margin = 0;
					}
					else {
						var margin = 1;
					}

					$('#products_table').find(`[data-id='${row_id}']`).find('.discount-box').find('.discount_values').val(0);
					$('#products_table').find(`[data-id='${row_id}']`).find('.labor-discount-box').find('.labor_discount_values').val(0);
					$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount').val(0);
					$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount_old').val(0);

					$.ajax({
						type: "GET",
						data: "product=" + product + "&color=" + color + "&model=" + model + "&width=" + width + "&height=" + height + "&margin=" + margin,
						url: "<?php echo url('/aanbieder/get-price')?>",
						success: function (data) {

							if (typeof data[0].value !== 'undefined') {

								$('#myModal2').find(`.comment-boxes[data-id='${row_id}']`).remove();

								var color_max_height = data[0].max_height;

								if (data[0].value === 'both') {

									Swal.fire({
										icon: 'error',
										title: '{{__('text.Oops...')}}',
										html: '{{__('text.Width & Height are greater than max values')}} <br> {{__('text.Max Width')}}: ' + data[0].max_width + '<br> {{__('text.Max Height')}}: ' + data[0].max_height,
									});


									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.model').find('.model_impact_value').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(3);
								}
								else if (data[0].value === 'x_axis') {

									Swal.fire({
										icon: 'error',
										title: '{{__('text.Oops...')}}',
										html: '{{__('text.Width is greater than max value')}} <br> {{__('text.Max Width')}}: ' + data[0].max_width,
									});

									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.model').find('.model_impact_value').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(1);
								}
								else if (data[0].value === 'y_axis') {

									Swal.fire({
										icon: 'error',
										title: '{{__('text.Oops...')}}',
										html: '{{__('text.Height is greater than max value')}} <br> {{__('text.Max Height')}}: ' + data[0].max_height,
									});

									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.model').find('.model_impact_value').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(2);
								}
								else {
									$('#products_table').find(`[data-id='${row_id}']`).find('#childsafe').val(data[3].childsafe);
									var childsafe = data[3].childsafe;

									if (price_based_option == 1) {
										var price = data[0].value;
										var org = data[0].value;
									}
									else {
										var price = base_price;
										var org = base_price;
									}

									var basic_price = price;

									/*if (margin == 1) {
                                        if (data[2]) {
                                            price = parseFloat(price);
                                            var supplier_margin = data[2].margin;
                                            var retailer_margin = data[2].retailer_margin;

                                            current.parent().parent().find('#supplier_margin').val(supplier_margin);
                                            current.parent().parent().find('#retailer_margin').val(retailer_margin);

                                            if (supplier_margin && retailer_margin) {
                                                price = (price / supplier_margin) * retailer_margin;
                                                price = price.toFixed(2);
                                            }
                                        }
                                    }*/

									var features = '';
									var count_features = 0;
									var f_value = 0;
									var m1_impact = data[3].m1_impact;
									var m2_impact = data[3].m2_impact;
									var m1_impact_value = 0;
									var m2_impact_value = 0;

									$('#myModal').find('.modal-body').find(`[data-id='${row_id}']`).remove();

									if (childsafe == 1) {

										count_features = count_features + 1;

										var content = '<div class="row childsafe-content-box" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
												'<label style="margin-right: 10px;margin-bottom: 0;">Montagehoogte</label>' +
												'<input style="border: none;border-bottom: 1px solid lightgrey;" type="number" class="form-control childsafe_values" id="childsafe_x" name="childsafe_x' + row_id + '">\n' +
												'</div></div>\n' +
												'<div class="row childsafe-content-box1" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
												'<label style="margin-right: 10px;margin-bottom: 0;">Kettinglengte</label>' +
												'<input style="border: none;border-bottom: 1px solid lightgrey;" type="number" class="form-control childsafe_values" id="childsafe_y" name="childsafe_y' + row_id + '">\n' +
												'</div></div>\n' +
												'<div class="row childsafe-question-box" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
												'<label style="margin-right: 10px;margin-bottom: 0;">{{__('text.Childsafe')}}</label>' +
												'<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control childsafe-select" name="childsafe_option' + row_id + '">\n' +
												'<option value="">{{__('text.Select any option')}}</option>\n' +
												'<option value="2">{{__('text.Add childsafety clip')}}</option>\n' +
												'</select>\n' +
												'<input value="0" name="childsafe_diff' + row_id + '" class="childsafe_diff" type="hidden">' +
												'</div></div>\n';

										features = features + content;

									}

									if (ladderband == 1) {

										var content = '<div class="row" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
												'<label style="margin-right: 10px;margin-bottom: 0;">{{__('text.Ladderband')}}</label>' +
												'<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features' + row_id + '[]">\n' +
												'<option value="0">{{__('text.No')}}</option>\n' +
												'<option value="1">{{__('text.Yes')}}</option>\n' +
												'</select>\n' +
												'<input value="0" name="f_price' + row_id + '[]" class="f_price" type="hidden">' +
												'<input value="0" name="f_id' + row_id + '[]" class="f_id" type="hidden">' +
												'<input value="0" name="f_area' + row_id + '[]" class="f_area" type="hidden">' +
												'<input value="0" name="sub_feature' + row_id + '[]" class="sub_feature" type="hidden">' +
												'</div><a data-id="' + row_id + '" class="info ladderband-btn hide">{{__('text.Info')}}</a></div>\n';

										features = features + content;

									}

									$.each(data[1], function (index, value) {

										count_features = count_features + 1;

										var opt = '<option value="0">{{__('text.Select Feature')}}</option>';

										$.each(value.features, function (index1, value1) {

											opt = opt + '<option value="' + value1.id + '">' + value1.title + '</option>';

										});

										if (value.comment_box == 1) {
											var icon = '<a data-feature="' + value.id + '" class="info comment-btn">{{__('text.Info')}}</a>';
										}
										else {
											var icon = '';
										}

										var content = '<div class="row" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
												'<label style="margin-right: 10px;margin-bottom: 0;">' + value.title + '</label>' +
												'<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features' + row_id + '[]">' + opt + '</select>\n' +
												'<input value="' + f_value + '" name="f_price' + row_id + '[]" class="f_price" type="hidden">' +
												'<input value="' + value.id + '" name="f_id' + row_id + '[]" class="f_id" type="hidden">' +
												'<input value="0" name="f_area' + row_id + '[]" class="f_area" type="hidden">' +
												'<input value="0" name="sub_feature' + row_id + '[]" class="sub_feature" type="hidden">' +
												'</div>' + icon + '</div>\n';

										features = features + content;

									});

									if(count_features > 0)
									{
										$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').hide();
										$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').css('visibility','visible');
										$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').show();
									}
									else
									{
										$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').hide();
										$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').css('visibility','visible');
										$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').show();
									}

									if ($('#menu1').find(`[data-id='${row_id}']`).length > 0) {
										$('#menu1').find(`[data-id='${row_id}']`).remove();
									}

									$('#menu1').append('<div data-id="' + row_id + '" style="margin: 0;" class="form-group">' +
											'\n' +
											'<div class="row" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
											'<label style="margin-right: 10px;margin-bottom: 0;">{{__('text.Quantity')}}</label>' +
											'<?php if(Route::currentRouteName() == 'create-new-negative-invoice'){ echo '-'; } ?>'+
											'<input value="1" style="border: none;border-bottom: 1px solid lightgrey;" maskedformat="9,1" name="qty[]" class="form-control" type="text" /><span>pcs</span>' +
											'</div></div>' + features +
											'</div>');

									if (data[3].max_size) {
										var sq = (width * height) / 10000;
										var max_size = data[3].max_size;

										if (sq > max_size) {

											Swal.fire({
												icon: 'error',
												title: '{{__('text.Oops...')}}',
												text: '{{__('text.Area is greater than max size')}}: ' + max_size,
											});

											current.parent().find('.f_area').val(1);
										}
									}
									else {
										current.parent().find('.f_area').val(0);
									}

									var model_impact_value = data[3].value;

									if (m1_impact == 1) {

										m1_impact_value = model_impact_value * (width / 100);

									}

									if (m2_impact == 1) {

										m2_impact_value = model_impact_value * ((width/100) * (height/100));

									}

									if (data[3].price_impact == 1) {

										if (data[3].impact_type == 0) {

											price = parseFloat(price) + parseFloat(model_impact_value);
											price = price.toFixed(2);

										}
										else {

											var per = (model_impact_value) / 100;
											model_impact_value = basic_price * per;

											price = parseFloat(price) + parseFloat(model_impact_value);
											price = price.toFixed(2);
										}

									}

									price = parseFloat(price) + parseFloat(m1_impact_value) + parseFloat(m2_impact_value);

									if(margin == 1)
									{
										if (data[2]) {

											var supplier_margin = data[2].margin;
											var retailer_margin = data[2].retailer_margin;

											if (supplier_margin && retailer_margin) {
												price = (parseFloat(price) / supplier_margin) * retailer_margin;
											}
										}
									}

									price = parseFloat(price).toFixed(2);

									var price_before_labor = parseFloat(price).toFixed(2);
									var labor = 0;

									if (data[4]) {
										labor = data[4].labor;
										labor = labor * (width / 100);
										//labor = Math.round(labor);
										price = parseFloat(price) + parseFloat(labor);
										price = price.toFixed(2);										
									}

									labor = parseFloat(labor).toFixed(2);

									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val(price_before_labor.replace(/\./g, ','));
									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val(price_before_labor);
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val(labor.replace(/\./g, ','));
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val(labor);
									$('#products_table').find(`[data-id='${row_id}']`).find('.model').find('.model_impact_value').val(model_impact_value);
									//$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('€ ' + Math.round(price));
									$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('€ ' + price.replace(/\./g, ','));
									$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val(price);
									$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val(price);
									$('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val(basic_price);
								}
							}
							else {
								$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('.model').find('.model_impact_value').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('');
								$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val('');

								$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').hide();
								$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').css('visibility','visible');
								$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').show();
							}

							calculate_total();
						}
					});
				}
				else
				{
					$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').hide();
					$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').css('visibility','visible');
					$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').show();
				}

			});

			function focus_row(last_row) {

				var windowsize = $(window).width();

				if (windowsize > 992) {

					$('#products_table .content-div').not(last_row).find('.collapse[aria-expanded]').collapse("hide");

				}

				$('#products_table .content-div.active').removeClass('active');
				last_row.addClass('active');

				var id = last_row.data('id');

				$('#menu1').children().not(`[data-id='${id}']`).hide();
				$('#menu1').find(`[data-id='${id}']`).show();

			}

			function numbering() {
				$('#products_table .content-div').each(function (index, tr) { $(this).find('.content:eq(0)').find('.sr-res').text(index + 1); });
			}

			function add_row(copy = false, rate = null, basic_price = null, price = null, products = null, product = null, suppliers = null, supplier = null, colors = null, color = null, models = null, model = null, model_impact_value = null, width = null, width_unit = null, height = null, height_unit = null, price_text = null, features = null, features_selects = null, childsafe_question = null, childsafe_answer = null, qty = null, childsafe = 0, ladderband = 0, ladderband_value = 0, ladderband_price_impact = 0, ladderband_impact_type = 0, area_conflict = 0, subs = null, childsafe_x = null, childsafe_y = null, delivery_days = null, price_based_option = null, base_price = null, supplier_margin = null, retailer_margin = null, width_readonly = null, height_readonly = null, price_before_labor = null, price_before_labor_old = null, labor_impact = null, labor_impact_old = null, discount = null, labor_discount = null, total_discount = null, total_discount_old = null, last_column = null) {

				var rowCount = $('#products_table .content-div:last').data('id');
				rowCount = rowCount + 1;

				var r_id = $('#products_table .content-div:last').find('.content:eq(0)').find('.sr-res').text();
				r_id = parseInt(r_id) + 1;

				if (!copy) {

					$("#products_table").append('<div class="content-div" data-id="' + rowCount + '">\n' +
							'                                                            <div class="content full-res item1" style="width: 2%;">\n' +
							'                       									 	<label class="content-label">Sr. No</label>\n' +
							'                       									 	<div style="padding: 0 5px;" class="sr-res">' + r_id + '</div>\n' +
							'                       									 </div>\n' +
							'\n' +
							'                                                            <input type="hidden" id="order_number" name="order_number[]">\n' +
							'                                                            <input type="hidden" id="basic_price" name="basic_price[]">\n' +
							'                                                            <input type="hidden" id="rate" name="rate[]">\n' +
							'                                                            <input type="hidden" id="row_total" name="total[]">\n' +
							'                                                            <input type="hidden" value="' + rowCount + '" id="row_id" name="row_id[]">\n' +
							'                                                            <input type="hidden" value="0" id="childsafe" name="childsafe[]">\n' +
							'                                                            <input type="hidden" value="0" id="ladderband" name="ladderband[]">\n' +
							'                                                            <input type="hidden" value="0" id="ladderband_value" name="ladderband_value[]">\n' +
							'                                                            <input type="hidden" value="0" id="ladderband_price_impact" name="ladderband_price_impact[]">\n' +
							'                                                            <input type="hidden" value="0" id="ladderband_impact_type" name="ladderband_impact_type[]">\n' +
							'                                                            <input type="hidden" value="0" id="area_conflict" name="area_conflict[]">\n' +
							'                                                            <input type="hidden" value="1" id="delivery_days" name="delivery_days[]">\n' +
							'                                                            <input type="hidden" id="price_based_option" name="price_based_option[]">\n' +
							'                                                            <input type="hidden" id="base_price" name="base_price[]">\n' +
							'                                                            <input type="hidden" id="supplier_margin" name="supplier_margin[]">\n' +
							'                                                            <input type="hidden" id="retailer_margin" name="retailer_margin[]">\n' +
							'\n' +
							'                                                            <div style="width: 12%;" @if(auth()->user()->role_id == 4) class="suppliers content item2 full-res hide" @else class="suppliers content item2 full-res" @endif>\n' +
							'\n' +
							'                       									 	<label class="content-label">{{__('text.Supplier')}}</label>\n' +
							'\n' +
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
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div style="width: 22%;" class="products content item3 full-res">\n' +
							'\n' +
							'                       									 	<label class="content-label">{{__('text.Product')}}</label>\n' +
							'\n' +
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
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div class="width item4 content" style="width: 10%;">\n' +
							'\n' +
							'                       									 	<label class="content-label">{{__('text.Width')}}</label>\n' +
							'\n' +
							'                                                                <div class="m-box">\n' +
							'                                                                	<input value="0" class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="width[]" type="text">\n' +
							'                                                                   <input style="border: 0;outline: none;" readonly type="text" name="width_unit[]" class="measure-unit" value="cm">\n' +
							'                                                                </div>\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div class="height item5 content" style="width: 10%;">\n' +
							'\n' +
							'                       									 	<label class="content-label">{{__('text.Height')}}</label>\n' +
							'\n' +
							'                                                                <div class="m-box">\n' +
							'                                                                	<input value="0" class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="height[]" type="text">\n' +
							'                                                                	<input style="border: 0;outline: none;" readonly type="text" name="height_unit[]" class="measure-unit" value="cm">\n' +
							'                                                                </div>\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div class="content item6" style="width: 7%;">\n' +
							'\n' +
							'                       									 	<label class="content-label">{{__('text.€ Art.')}}</label>\n' +
							'\n' +
							'																 <div style="display: flex;align-items: center;">\n' +
							'																	<span>€</span>\n' +
							'																 	<input type="text" readonly name="price_before_labor[]" style="border: 0;background: transparent;padding: 0 5px;" class="form-control price_before_labor res-white">\n' +
							'																	<input type="hidden" class="price_before_labor_old">\n' +
							'																 </div>\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div class="content item7" style="width: 7%;">\n' +
							'\n' +
							'                       									 	<label class="content-label">{{__('text.€ Arb.')}}</label>\n' +
							'\n' +
							'																 <div style="display: flex;align-items: center;">\n' +
							'																	<span>€</span>\n' +
							'																 	<input type="text" name="labor_impact[]" maskedFormat="9,1" class="form-control labor_impact res-white">\n' +
							'                                                                	<input type="hidden" class="labor_impact_old">\n' +
							'																 </div>\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div class="content item8" style="width: 10%;">\n' +
							'\n' +
							'                       									 	<label class="content-label">{{__('text.Discount')}}</label>\n' +
							'\n' +
							'																<span>€</span>\n' +
							'																<input type="text" value="0" name="total_discount[]" readonly style="border: 0;background: transparent;padding: 0 5px;" class="form-control total_discount res-white">\n' +
							'																<input type="hidden" value="0" class="total_discount_old">\n' +
							'\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div style="width: 7%;" class="content item9">\n' +
							'\n' +
							'                       									 	<label class="content-label">{{__('text.€ Total')}}</label>\n' +
							'<?php if(Route::currentRouteName() == 'create-new-negative-invoice'){ echo '-&nbsp;'; } ?>'+
							'\n' +
							'																<div class="price res-white"></div>\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div class="content item10 last-content" id="next-row-td" style="padding: 0;width: 13%;">\n' +
							'\n' +
							'                       									 	<div class="res-white" style="display: flex;justify-content: flex-end;align-items: center;width: 100%;">\n' +
							'\n' +
							'																<div style="display: none;" class="green-circle tooltip1">\n' +
							'																	<span style="top: 45px;left: -40px;" class="tooltiptext">{{__('text.ALL features selected!')}}</span>\n' +
							'																</div>\n' +
							'\n' +
							'																<div style="visibility: hidden;" class="yellow-circle tooltip1">\n' +
							'																	<span style="top: 45px;left: -40px;" class="tooltiptext">{{__('text.Select all features!')}}</span>\n' +
							'																</div>\n' +
							'\n' +
							'																<span id="next-row-span" class="tooltip1 add-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;width: 20px;height: 20px;line-height: 20px;">\n' +
							'\n' +
							'																	<i id="next-row-icon" class="fa fa-fw fa-plus"></i>\n' +
							'\n' +
							'																	<span class="tooltiptext">{{__('text.Add')}}</span>\n' +
							'\n' +
							'																</span>\n' +
							'\n' +
							'																<span id="next-row-span" class="tooltip1 remove-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;width: 20px;height: 20px;line-height: 20px;">\n' +
							'\n' +
							'																	<i id="next-row-icon" class="fa fa-fw fa-trash-o"></i>\n' +
							'\n' +
							'																	<span class="tooltiptext">{{__('text.Remove')}}</span>\n' +
							'\n' +
							'																</span>\n' +
							'\n' +
							'																<span id="next-row-span" class="tooltip1 copy-row" style="cursor: pointer;font-size: 20px;margin: 0 10px;width: 20px;height: 20px;line-height: 20px;">\n' +
							'\n' +
							'																	<i id="next-row-icon" class="fa fa-fw fa-copy"></i>\n' +
							'\n' +
							'																	<span class="tooltiptext">{{__('text.Copy')}}</span>\n' +
							'\n' +
							'																</span>\n' +
							'\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div class="item11" style="display: flex;justify-content: flex-end;align-items: center;width: 100%;margin-top: 10px;">\n' +
							'\n' +
							'                       									 	<button style="outline: none;" type="button" class="btn btn-info res-collapse collapsed" data-toggle="collapse" data-target="#demo' + rowCount + '"></button>\n' +
							'\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div style="width: 100%;" id="demo' + rowCount + '" class="item16 collapse">\n' +
							'\n' +
							'                       									 	<div style="width: 25%;" class="color item12">\n' +
							'\n' +
							'																	<label>{{__('text.Color')}}</label>\n' +
							'\n' +
							'                                                                	<select name="colors[]" class="js-data-example-ajax2">\n' +
							'\n' +
							'                                                                    	<option value=""></option>\n' +
							'\n' +
							'                                                                	</select>\n' +
							'\n' +
							'																</div>\n' +
							'\n' +
							'																<div style="width: 25%;margin-left: 10px;" class="model item13">\n' +
							'\n' +
							'																	<label>{{__('text.Model')}}</label>\n' +
							'\n' +
							'                                                                	<select name="models[]" class="js-data-example-ajax3">\n' +
							'\n' +
							'                                                                   	<option value=""></option>\n' +
							'\n' +
							'                                                                	</select>\n' +
							'                                                                   <input type="hidden" class="model_impact_value" name="model_impact_value[]" value="">\n' +
							'\n' +
							'																</div>\n' +
							'\n' +
							'																<div style="width: 25%;margin-left: 10px;" class="discount-box item14">\n' +
							'\n' +
							'																	<label>{{__('text.Discount')}} %</label>\n' +
							'\n' +
							'																	<input style="height: 35px;border-radius: 4px;" placeholder="{{__('text.Enter discount in percentage')}}" type="text" class="form-control discount_values" value="0" name="discount[]">\n' +
							'\n' +
							'																</div>\n' +
							'\n' +
							'																<div style="width: 25%;margin-left: 10px;" class="labor-discount-box item15">\n' +
							'\n' +
							'																	<label>{{__('text.Labor Discount')}} %</label>\n' +
							'\n' +
							'																	<input style="height: 35px;border-radius: 4px;" placeholder="{{__('text.Enter discount in percentage')}}" type="text" class="form-control labor_discount_values" value="0" name="labor_discount[]">\n' +
							'\n' +
							'																</div>\n' +
							'\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                        </div>');

					var last_row = $('#products_table .content-div:last');

					focus_row(last_row);

					last_row.find(".js-data-example-ajax").select2({
						width: '100%',
						height: '200px',
						placeholder: "{{__('text.Select Product')}}",
						allowClear: true,
						"language": {
							"noResults": function () {
								return '{{__('text.No results found')}}';
							}
						},
					});

					last_row.find(".js-data-example-ajax1").select2({
						width: '100%',
						height: '200px',
						placeholder: "{{__('text.Select Supplier')}}",
						allowClear: true,
						"language": {
							"noResults": function () {
								return '{{__('text.No results found')}}';
							}
						},
					});

					last_row.find(".js-data-example-ajax2").select2({
						width: '100%',
						height: '200px',
						placeholder: "{{__('text.Select Color')}}",
						allowClear: true,
						"language": {
							"noResults": function () {
								return '{{__('text.No results found')}}';
							}
						},
					});

					last_row.find(".js-data-example-ajax3").select2({
						width: '100%',
						height: '200px',
						placeholder: "{{__('text.Select Model')}}",
						allowClear: true,
						"language": {
							"noResults": function () {
								return '{{__('text.No results found')}}';
							}
						},
					});
				}
				else {

					$("#products_table").append('<div class="content-div" data-id="' + rowCount + '">\n' +
							'                                                            <div class="content full-res item1" style="width: 2%;">\n' +
							'                       									 	<label class="content-label">Sr. No</label>\n' +
							'                       									 	<div style="padding: 0 5px;" class="sr-res">' + r_id + '</div>\n' +
							'                       									 </div>\n' +
							'\n' +
							'                                                            <input type="hidden" id="order_number" name="order_number[]">\n' +
							'                                                            <input value="' + basic_price + '" type="hidden" id="basic_price" name="basic_price[]">\n' +
							'                                                            <input value="' + rate + '" type="hidden" id="rate" name="rate[]">\n' +
							'                                                            <input value="' + price + '" type="hidden" id="row_total" name="total[]">\n' +
							'                                                            <input type="hidden" value="' + rowCount + '" id="row_id" name="row_id[]">\n' +
							'                                                            <input type="hidden" value="' + childsafe + '" id="childsafe" name="childsafe[]">\n' +
							'                                                            <input type="hidden" value="' + ladderband + '" id="ladderband" name="ladderband[]">\n' +
							'                                                            <input type="hidden" value="' + ladderband_value + '" id="ladderband_value" name="ladderband_value[]">\n' +
							'                                                            <input type="hidden" value="' + ladderband_price_impact + '" id="ladderband_price_impact" name="ladderband_price_impact[]">\n' +
							'                                                            <input type="hidden" value="' + ladderband_impact_type + '" id="ladderband_impact_type" name="ladderband_impact_type[]">\n' +
							'                                                            <input type="hidden" value="' + area_conflict + '" id="area_conflict" name="area_conflict[]">\n' +
							'                                                            <input type="hidden" value="' + delivery_days + '" id="delivery_days" name="delivery_days[]">\n' +
							'                                                            <input type="hidden" value="' + price_based_option + '" id="price_based_option" name="price_based_option[]">\n' +
							'                                                            <input type="hidden" value="' + base_price + '" id="base_price" name="base_price[]">\n' +
							'                                                            <input type="hidden" value="' + supplier_margin + '" id="supplier_margin" name="supplier_margin[]">\n' +
							'                                                            <input type="hidden" value="' + retailer_margin + '" id="retailer_margin" name="retailer_margin[]">\n' +
							'\n' +
							'                                                            <div style="width: 12%;" @if(auth()->user()->role_id == 4) class="suppliers content item2 full-res hide" @else class="suppliers content item2 full-res" @endif>\n' +
							'\n' +
							'                       									 	<label class="content-label">{{__('text.Supplier')}}</label>\n' +
							'\n' +
							'                                                                <select name="suppliers[]" class="js-data-example-ajax1">\n' +
							'\n' +
							suppliers +
							'\n' +
							'                                                                </select>\n' +
							'\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div style="width: 22%;" class="products content item3 full-res">\n' +
							'\n' +
							'                       									 	<label class="content-label">{{__('text.Product')}}</label>\n' +
							'\n' +
							'                                                                <select name="products[]" class="js-data-example-ajax">\n' +
							'\n' +
							products +
							'\n' +
							'                                                                </select>\n' +
							'\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div class="width item4 content" style="width: 10%;">\n' +
							'\n' +
							'                       									 	<label class="content-label">{{__('text.Width')}}</label>\n' +
							'\n' +
							'                                                                <div class="m-box">\n' +
							'                                                                	<input ' + width_readonly + ' value="' + width + '" class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="width[]" type="text">\n' +
							'                                                                   <input style="border: 0;outline: none;" readonly type="text" name="width_unit[]" class="measure-unit" value="' + width_unit + '">\n' +
							'                                                                </div>\n' +
							'\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div class="height item5 content" style="width: 10%;">\n' +
							'\n' +
							'                       									 	<label class="content-label">{{__('text.Height')}}</label>\n' +
							'\n' +
							'                                                                <div class="m-box">\n' +
							'                                                                	<input ' + height_readonly + ' value="' + height + '" class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="height[]" type="text">\n' +
							'                                                                	<input style="border: 0;outline: none;" readonly type="text" name="height_unit[]" class="measure-unit" value="' + height_unit + '">\n' +
							'                                                                </div>\n' +
							'\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div class="content item6" style="width: 7%;">\n' +
							'\n' +
							'                       									 	<label class="content-label">{{__('text.€ Art.')}}</label>\n' +
							'\n' +
							'																 <div style="display: flex;align-items: center;">\n' +
							'																	<span>€</span>\n' +
							'																 	<input value="' + price_before_labor + '" type="text" readonly name="price_before_labor[]" style="border: 0;background: transparent;padding: 0 5px;" class="form-control price_before_labor res-white">\n' +
							'																	<input value="' + price_before_labor_old + '" type="hidden" class="price_before_labor_old">\n' +
							'																 </div>\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div class="content item7" style="width: 7%;">\n' +
							'\n' +
							'                       									 	<label class="content-label">{{__('text.€ Arb.')}}</label>\n' +
							'\n' +
							'																 <div style="display: flex;align-items: center;">\n' +
							'																	<span>€</span>\n' +
							'																 	<input value="' + labor_impact + '" type="text" name="labor_impact[]" maskedFormat="9,1" class="form-control labor_impact res-white">\n' +
							'                                                                	<input value="' + labor_impact_old + '" type="hidden" class="labor_impact_old">\n' +
							'																 </div>\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div class="content item8" style="width: 10%;">\n' +
							'\n' +
							'                       									 	<label class="content-label">{{__('text.Discount')}}</label>\n' +
							'\n' +
							'																<span>€</span>\n' +
							'																<input type="text" value="' + total_discount + '" name="total_discount[]" readonly style="border: 0;background: transparent;padding: 0 5px;" class="form-control total_discount res-white">\n' +
							'																<input type="hidden" value="' + total_discount_old + '" class="total_discount_old">\n' +
							'\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div style="width: 7%;" class="content item9">\n' +
							'\n' +
							'                       									 	<label class="content-label">{{__('text.€ Total')}}</label>\n' +
							'<?php if(Route::currentRouteName() == 'create-new-negative-invoice'){ echo '-&nbsp;'; } ?>'+
							'\n' +
							'																<div class="price res-white">' + price_text + '</div>\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div class="content item10 last-content" id="next-row-td" style="padding: 0;width: 13%;">\n' +
							'\n' +
							last_column +
							'\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div class="item11" style="display: flex;justify-content: flex-end;align-items: center;width: 100%;margin-top: 10px;">\n' +
							'\n' +
							'																<button style="outline: none;" type="button" class="btn btn-info res-collapse collapsed" aria-expanded="true" data-toggle="collapse" data-target="#demo' + rowCount + '"></button>\n' +
							'\n' +
							'                                                            </div>\n' +
							'\n' +
							'															<div style="width: 100%;" id="demo' + rowCount + '" class="item16 collapse in" aria-expanded="true">\n' +
							'\n' +
							'                       									 	<div style="width: 25%;" class="color item12">\n' +
							'\n' +
							'																	<label>{{__('text.Color')}}</label>\n' +
							'\n' +
							'                                                                	<select name="colors[]" class="js-data-example-ajax2">\n' +
							'\n' +
							colors +
							'\n' +
							'                                                                	</select>\n' +
							'\n' +
							'																</div>\n' +
							'\n' +
							'																<div style="width: 25%;margin-left: 10px;" class="model item13">\n' +
							'\n' +
							'																	<label>{{__('text.Model')}}</label>\n' +
							'\n' +
							'                                                                	<select name="models[]" class="js-data-example-ajax3">\n' +
							'\n' +
							models +
							'\n' +
							'                                                                	</select>\n' +
							'                                                                   <input type="hidden" class="model_impact_value" name="model_impact_value[]" value="' + model_impact_value + '">\n' +
							'\n' +
							'																</div>\n' +
							'\n' +
							'																<div style="width: 25%;margin-left: 10px;" class="discount-box item14">\n' +
							'\n' +
							'																	<label>{{__('text.Discount')}} %</label>\n' +
							'\n' +
							'																	<input value="' + discount + '" style="height: 35px;border-radius: 4px;" placeholder="{{__('text.Enter discount in percentage')}}" type="text" class="form-control discount_values" name="discount[]">\n' +
							'\n' +
							'																</div>\n' +
							'\n' +
							'																<div style="width: 25%;margin-left: 10px;" class="labor-discount-box item15">\n' +
							'\n' +
							'																	<label>{{__('text.Labor Discount')}} %</label>\n' +
							'\n' +
							'																	<input value="' + labor_discount + '" style="height: 35px;border-radius: 4px;" placeholder="{{__('text.Enter discount in percentage')}}" type="text" class="form-control labor_discount_values" name="labor_discount[]">\n' +
							'\n' +
							'																</div>\n' +
							'\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                        </div>');

					var last_row = $('#products_table .content-div:last');

					last_row.find('.js-data-example-ajax').val(product);
					last_row.find('.js-data-example-ajax1').val(supplier);
					last_row.find('.js-data-example-ajax2').val(color);
					last_row.find('.js-data-example-ajax3').val(model);

					if (features) {

						$('#menu1').append('<div data-id="' + rowCount + '" style="margin: 0;" class="form-group">\n' + features + '</div>');

						$('#menu1').find(`[data-id='${rowCount}']`).find('input[name="qty[]"]').val(qty);

						if (childsafe == 1) {
							$('#menu1').find(`[data-id='${rowCount}']`).find('.childsafe-select').attr('name', 'childsafe_option' + rowCount);
							$('#menu1').find(`[data-id='${rowCount}']`).find('.childsafe_diff').attr('name', 'childsafe_diff' + rowCount);
							$('#menu1').find(`[data-id='${rowCount}']`).find('.childsafe-answer').attr('name', 'childsafe_answer' + rowCount);
							$('#menu1').find(`[data-id='${rowCount}']`).find('#childsafe_x').val(childsafe_x);
							$('#menu1').find(`[data-id='${rowCount}']`).find('#childsafe_y').val(childsafe_y);
							$('#menu1').find(`[data-id='${rowCount}']`).find('.childsafe-select').val(childsafe_question);
							$('#menu1').find(`[data-id='${rowCount}']`).find('.childsafe-answer').val(childsafe_answer);
						}

						features_selects.each(function (index, select) {

							$('#menu1').find(`[data-id='${rowCount}']`).find('.feature-select').eq(index).val($(this).val());

							if ($(this).parent().find('.f_id').val() == 0) {
								$('#myModal').find('.modal-body').append('<div class="sub-tables" data-id="' + rowCount + '">\n' + subs + '</div>');
							}

						});

						$('#menu1').find(`[data-id='${rowCount}']`).each(function (i, obj) {

							$(obj).find('.ladderband-btn').attr('data-id', rowCount);
							$(obj).find('.feature-select').attr('name', 'features' + rowCount + '[]');
							$(obj).find('.f_price').attr('name', 'f_price' + rowCount + '[]');
							$(obj).find('.f_id').attr('name', 'f_id' + rowCount + '[]');
							$(obj).find('.f_area').attr('name', 'f_area' + rowCount + '[]');
							$(obj).find('.sub_feature').attr('name', 'sub_feature' + rowCount + '[]');
							$(obj).find('#childsafe_x').attr('name', 'childsafe_x' + rowCount);
							$(obj).find('#childsafe_y').attr('name', 'childsafe_y' + rowCount);

						});

						$('#myModal').find('.modal-body').find(`[data-id='${rowCount}']`).each(function (i, obj) {

							$(obj).find('.sizeA').each(function (b, obj1) {

								if ($(this).val() == 1) {
									$(this).prev('input').prop("checked", true);
								}

							});

							$(obj).find('.sizeB').each(function (c, obj2) {

								if ($(this).val() == 1) {
									$(this).prev('input').prop("checked", true);
								}

							});

							$(obj).find('.sub_product_id').attr('name', 'sub_product_id' + rowCount + '[]');
							$(obj).find('.sizeA').attr('name', 'sizeA' + rowCount + '[]');
							$(obj).find('.sizeB').attr('name', 'sizeB' + rowCount + '[]');
							$(obj).find('.cus_radio').attr('name', 'cus_radio' + rowCount + '[]');
							$(obj).find('.cus_radio').attr('data-id', rowCount);

						});

					}

					focus_row(last_row);

					last_row.find(".js-data-example-ajax").select2({
						width: '100%',
						height: '200px',
						placeholder: "{{__('text.Select Product')}}",
						allowClear: true,
						"language": {
							"noResults": function () {
								return '{{__('text.No results found')}}';
							}
						},
					});

					last_row.find(".js-data-example-ajax1").select2({
						width: '100%',
						height: '200px',
						placeholder: "{{__('text.Select Supplier')}}",
						allowClear: true,
						"language": {
							"noResults": function () {
								return '{{__('text.No results found')}}';
							}
						},
					});

					last_row.find(".js-data-example-ajax2").select2({
						width: '100%',
						height: '200px',
						placeholder: "{{__('text.Select Color')}}",
						allowClear: true,
						"language": {
							"noResults": function () {
								return '{{__('text.No results found')}}';
							}
						},
					});

					last_row.find(".js-data-example-ajax3").select2({
						width: '100%',
						height: '200px',
						placeholder: "{{__('text.Select Model')}}",
						allowClear: true,
						"language": {
							"noResults": function () {
								return '{{__('text.No results found')}}';
							}
						},
					});
				}

				calculate_total();
			}

			$(document).on('click', '#products_table .content-div', function (e) {

				if (e.target.id !== "next-row-td" && e.target.id !== "next-row-span" && e.target.id !== "next-row-icon") {
					focus_row($(this));
				}

			});

			$(document).on('click', '.next-row', function () {

				if ($(this).parents(".content-div").next('.content-div').length == 0) {
					add_row();
				}
				else {
					var next_row = $(this).parents(".content-div").next('.content-div');
					focus_row(next_row);
				}
			});

			$(document).on('click', '.add-row', function () {

				add_row();

			});

			$(document).on('click', '.remove-row', function () {

				var rowCount = $('#products_table .content-div').length;

				var current = $(this).parents('.content-div');

				var id = current.data('id');

				if (rowCount != 1) {

					$('#menu1').find(`[data-id='${id}']`).remove();
					$('#myModal').find('.modal-body').find(`[data-id='${id}']`).remove();
					$('#myModal2').find('.modal-body').find(`[data-id='${id}']`).remove();

					var next = current.next('.content-div');

					if (next.length < 1) {
						var next = current.prev('.content-div');
					}

					focus_row(next);

					current.remove();

					numbering();
					calculate_total();
				}

			});

			$(document).on('click', '.save-data', function () {

				var customer = $('.customer-select').val();
				var flag = 0;

				if (!customer) {
					flag = 1;
					$('#cus-box .select2-container--default .select2-selection--single').css('border-color', 'red');
				}
				else {
					$('#cus-box .select2-container--default .select2-selection--single').css('border-color', '#cacaca');
				}


				$("[name='suppliers[]']").each(function (i, obj) {

					if (!$(this).parent().hasClass('hide')) {
						if (!obj.value) {
							flag = 1;
							$(obj).next().find('.select2-selection').css('border', '1px solid red');
						}
						else {
							$(obj).next().find('.select2-selection').css('border', '0');
						}
					}

				});

				$("[name='products[]']").each(function (i, obj) {

					if (!obj.value) {
						flag = 1;
						$(obj).next().find('.select2-selection').css('border', '1px solid red');
					}
					else {
						$(obj).next().find('.select2-selection').css('border', '0');
					}

				});


				$("[name='colors[]']").each(function (i, obj) {

					if (!obj.value) {
						flag = 1;
						$(obj).next().find('.select2-selection').css('border', '1px solid red');
					}
					else {
						$(obj).next().find('.select2-selection').css('border', '0');
					}

				});


				$("[name='models[]']").each(function (i, obj) {

					if (!obj.value) {
						flag = 1;
						$(obj).next().find('.select2-selection').css('border', '1px solid red');
					}
					else {
						$(obj).next().find('.select2-selection').css('border', '0');
					}

				});

				var conflict_feature = 0;

				$("[name='row_id[]']").each(function () {

					var id = $(this).val();
					var conflict_flag = 0;

					var childsafe = $("[name='childsafe_option" + id + "']").val();

					if (!childsafe && childsafe != undefined) {
						flag = 1;
						conflict_feature = 1;
						$("[name='childsafe_option" + id + "']").css('border-bottom', '1px solid red');
					}
					else {
						$("[name='childsafe_option" + id + "']").css('border-bottom', '1px solid lightgrey');
					}

					$("[name='features" + id + "[]']").each(function (i, obj) {

						var selected_feature = $(this).val();
						var feature_id = $(this).parent().find('.f_id').val();

						if (feature_id != 0) {
							if (selected_feature == 0) {
								flag = 1;
								conflict_feature = 1;
								$(this).css('border-bottom', '1px solid red');
							}
							else {
								$(this).css('border-bottom', '1px solid lightgrey');
							}
						}

					});

					$("[name='f_area" + id + "[]']").each(function () {

						var conflict = $(this).val();

						if (conflict == 1) {
							conflict_flag = 1;
						}

					});


					if (conflict_flag == 1) {
						flag = 1;
						$('#products_table').find(`[data-id='${id}']`).find('.width').find('.m-input').css('border', '1px solid red');
						$('#products_table').find(`[data-id='${id}']`).find('.height').find('.m-input').css('border', '1px solid red');
					}
					else {
						var area_conflict = $('#products_table').find(`[data-id='${id}']`).find('#area_conflict').val();

						if (area_conflict == 3) {
							flag = 1;
							$('#products_table').find(`[data-id='${id}']`).find('.width').find('.m-input').css('border', '1px solid red');
							$('#products_table').find(`[data-id='${id}']`).find('.height').find('.m-input').css('border', '1px solid red');
						}
						else if (area_conflict == 2) {
							flag = 1;
							$('#products_table').find(`[data-id='${id}']`).find('.width').find('.m-input').css('border', '0');
							$('#products_table').find(`[data-id='${id}']`).find('.height').find('.m-input').css('border', '1px solid red');
						}
						else if (area_conflict == 1) {
							flag = 1;
							$('#products_table').find(`[data-id='${id}']`).find('.width').find('.m-input').css('border', '1px solid red');
							$('#products_table').find(`[data-id='${id}']`).find('.height').find('.m-input').css('border', '0');
						}
						else {
							if (!$('#products_table').find(`[data-id='${id}']`).find('.width').find('.m-input').val()) {
								flag = 1;
								$('#products_table').find(`[data-id='${id}']`).find('.width').find('.m-input').css('border', '1px solid red');
							}
							else {
								$('#products_table').find(`[data-id='${id}']`).find('.width').find('.m-input').css('border', '0');
							}

							if (!$('#products_table').find(`[data-id='${id}']`).find('.height').find('.m-input').val()) {
								flag = 1;
								$('#products_table').find(`[data-id='${id}']`).find('.height').find('.m-input').css('border', '1px solid red');
							}
							else {
								$('#products_table').find(`[data-id='${id}']`).find('.height').find('.m-input').css('border', '0');
							}
						}
					}

				});

				if (conflict_feature) {

					Swal.fire({
						icon: 'error',
						title: '{{__('text.Oops...')}}',
						text: '{{__('text.Feature should not be empty!')}}',
					});

				}

				if (!flag) {
					$('#form-quote').submit();
				}

			});

			$(document).on('click', '.copy-row', function () {

				var current = $(this).parents('.content-div');
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
				var childsafe_x = $('#menu1').find(`[data-id='${id}']`).find('#childsafe_x').val();
				var childsafe_y = $('#menu1').find(`[data-id='${id}']`).find('#childsafe_y').val();
				var price_based_option = current.find('#price_based_option').val();
				var base_price = current.find('#base_price').val();
				var supplier_margin = current.find('#supplier_margin').val();
				var retailer_margin = current.find('#retailer_margin').val();
				var price_before_labor = current.find('.price_before_labor').val();
				var price_before_labor_old = current.find('.price_before_labor_old').val();
				var labor_impact = current.find('.labor_impact').val();
				var labor_impact_old = current.find('.labor_impact_old').val();
				var discount = current.find('.discount-box').find('.discount_values').val();
				var labor_discount = current.find('.labor-discount-box').find('.labor_discount_values').val();
				var total_discount = current.find('.total_discount').val();
				var total_discount_old = current.find('.total_discount_old').val();
				var last_column = current.find('#next-row-td').html();

				var width_readonly = '';
				var height_readonly = '';

				if (price_based_option == 2) {
					height_readonly = 'readonly';
				}
				else if (price_based_option == 3) {
					width_readonly = 'readonly';
				}

				add_row(true, rate, basic_price, price, products, product, suppliers, supplier, colors, color, models, model, model_impact_value, width, width_unit, height, height_unit, price_text, features, features_selects, childsafe_question, childsafe_answer, qty, childsafe, ladderband, ladderband_value, ladderband_price_impact, ladderband_impact_type, area_conflict, subs, childsafe_x, childsafe_y, delivery_days, price_based_option, base_price, supplier_margin, retailer_margin, width_readonly, height_readonly, price_before_labor, price_before_labor_old, labor_impact, labor_impact_old, discount, labor_discount, total_discount, total_discount_old, last_column);

			});

			$(document).on('keypress', "input[name='labor_impact[]']", function (e) {

				e = e || window.event;
				var charCode = (typeof e.which == "undefined") ? e.keyCode : e.which;
				var val = String.fromCharCode(charCode);

				if (!val.match(/^[0-9]*\,?[0-9]*$/))  // For characters validation
				{
					e.preventDefault();
					return false;
				}

				if (e.which == 44) {
					if (this.value.indexOf(',') > -1) {
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

			$(document).on('keypress', "input[name='qty[]']", function (e) {

				e = e || window.event;
				var charCode = (typeof e.which == "undefined") ? e.keyCode : e.which;
				var val = String.fromCharCode(charCode);

				if (!val.match(/^[0-9]*\,?[0-9]*$/))  // For characters validation
				{
					e.preventDefault();
					return false;
				}

				if (e.which == 44) {
					e.preventDefault();
					return false;
				}

				var num = $(this).attr("maskedFormat").toString().split(',');
				var regex = new RegExp("^\\d{0," + num[0] + "}(\\,\\d{0," + num[1] + "})?$");
				if (!regex.test(this.value)) {
					this.value = this.value.substring(0, this.value.length - 1);
				}

			});

			$(document).on('keypress', ".childsafe_values, .discount_values, .labor_discount_values", function (e) {

				e = e || window.event;
				var charCode = (typeof e.which == "undefined") ? e.keyCode : e.which;
				var val = String.fromCharCode(charCode);

				if (!val.match(/^[0-9]*\,?[0-9]*$/))  // For characters validation
				{
					e.preventDefault();
					return false;
				}

				if (e.which == 44) {
					e.preventDefault();
					return false;
				}

			});

			$(document).on('input', ".discount_values, .labor_discount_values", function (e) {

				calculate_total();

			});


			$(document).on('input', "input[name='qty[]']", function (e) {

				calculate_total(1);

			});

			$(document).on('keypress', "input[name='width[]']", function (e) {

				e = e || window.event;
				var charCode = (typeof e.which == "undefined") ? e.keyCode : e.which;
				var val = String.fromCharCode(charCode);

				if (!val.match(/^[0-9]*\,?[0-9]*$/))  // For characters validation
				{
					e.preventDefault();
					return false;
				}

				if (e.which == 44) {
					if (this.value.indexOf(',') > -1) {
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

			$(document).on('keypress', "input[name='height[]']", function (e) {

				e = e || window.event;
				var charCode = (typeof e.which == "undefined") ? e.keyCode : e.which;
				var val = String.fromCharCode(charCode);

				if (!val.match(/^[0-9]*\,?[0-9]*$/))  // For characters validation
				{
					e.preventDefault();
					return false;
				}

				if (e.which == 44) {
					if (this.value.indexOf(',') > -1) {
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

			$(document).on('focusout', "input[name='qty[]'], input[name='labor_impact[]']", function (e) {

				if (!$(this).val()) {
					$(this).val(0);
				}

				if ($(this).val().slice($(this).val().length - 1) == ',') {
					var val = $(this).val();
					val = val + '00';
					$(this).val(val);
				}

			});

			$(document).on('focusout', "input[name='width[]'], input[name='height[]']", function (e) {

				if ($(this).val().slice($(this).val().length - 1) == ',') {
					var val = $(this).val();
					val = val + '00';
					$(this).val(val);
				}
			});

			$(document).on('input', "input[name='width[]']", function (e) {

				var current = $(this);
				var row_id = current.parents(".content-div").data('id');

				var price_based_option = $('#products_table').find(`[data-id='${row_id}']`).find('#price_based_option').val();
				var base_price = $('#products_table').find(`[data-id='${row_id}']`).find('#base_price').val();

				var width = current.val();
				width = width.replace(/\,/g, '.');

				var height = $('#products_table').find(`[data-id='${row_id}']`).find('.height').find('.m-input').val();
				height = height.replace(/\,/g, '.');

				var color = $('#products_table').find(`[data-id='${row_id}']`).find('.color').find('select').val();
				var model = $('#products_table').find(`[data-id='${row_id}']`).find('.model').find('select').val();
				var product = $('#products_table').find(`[data-id='${row_id}']`).find('.products').find('select').val();
				var ladderband = $('#products_table').find(`[data-id='${row_id}']`).find('#ladderband').val();
				$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(0);

				if (width && height && color && model && product) {

					if ($(this).parents(".content-div").find('.suppliers').hasClass('hide')) {
						var margin = 0;
					}
					else {
						var margin = 1;
					}

					$('#products_table').find(`[data-id='${row_id}']`).find('.discount-box').find('.discount_values').val(0);
					$('#products_table').find(`[data-id='${row_id}']`).find('.labor-discount-box').find('.labor_discount_values').val(0);
					$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount').val(0);
					$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount_old').val(0);

					$.ajax({
						type: "GET",
						data: "product=" + product + "&color=" + color + "&model=" + model + "&width=" + width + "&height=" + height + "&margin=" + margin,
						url: "<?php echo url('/aanbieder/get-price')?>",
						success: function (data) {

							if (typeof data[0].value !== 'undefined') {

								$('#myModal2').find(`.comment-boxes[data-id='${row_id}']`).remove();

								if (data[0].value === 'both') {

									Swal.fire({
										icon: 'error',
										title: '{{__('text.Oops...')}}',
										html: '{{__('text.Width & Height are greater than max values')}} <br> {{__('text.Max Width')}}: ' + data[0].max_width + '<br> {{__('text.Max Height')}}: ' + data[0].max_height,
									});

									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.model').find('.model_impact_value').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(3);
								}
								else if (data[0].value === 'x_axis') {

									Swal.fire({
										icon: 'error',
										title: '{{__('text.Oops...')}}',
										html: '{{__('text.Width is greater than max value')}} <br> {{__('text.Max Width')}}: ' + data[0].max_width,
									});

									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.model').find('.model_impact_value').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(1);
								}
								else if (data[0].value === 'y_axis') {

									Swal.fire({
										icon: 'error',
										title: '{{__('text.Oops...')}}',
										html: '{{__('text.Height is greater than max value')}} <br> {{__('text.Max Height')}}: ' + data[0].max_height,
									});

									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.model').find('.model_impact_value').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(2);
								}
								else {
									$('#products_table').find(`[data-id='${row_id}']`).find('#childsafe').val(data[3].childsafe);
									var childsafe = data[3].childsafe;

									$('#myModal').find('.modal-body').find(`[data-id='${row_id}']`).remove();

									if (price_based_option == 1) {
										var price = data[0].value;
										var org = data[0].value;
									}
									else {
										var price = base_price;
										var org = base_price;
									}

									var basic_price = price;

									/*if (margin == 1) {
                                        if (data[2]) {
                                            price = parseFloat(price);
                                            var supplier_margin = data[2].margin;
                                            var retailer_margin = data[2].retailer_margin;

                                            $('#products_table').find(`[data-id='${row_id}']`).find('#supplier_margin').val(supplier_margin);
                                            $('#products_table').find(`[data-id='${row_id}']`).find('#retailer_margin').val(retailer_margin);

                                            if (supplier_margin && retailer_margin) {
                                                price = (price / supplier_margin) * retailer_margin;
                                                price = price.toFixed(2);
                                            }
                                        }
                                    }*/

									// var features = '';
									var count_features = 0;
									var f_value = 0;
									var m1_impact = data[3].m1_impact;
									var m2_impact = data[3].m2_impact;
									var m1_impact_value = 0;
									var m2_impact_value = 0;

									// if (childsafe == 1) {

									//     count_features = count_features + 1;

									// 	var content = '<div class="row childsafe-content-box" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
									// 		'<label style="margin-right: 10px;margin-bottom: 0;">Montagehoogte</label>' +
									// 		'<input style="border: none;border-bottom: 1px solid lightgrey;" type="number" class="form-control childsafe_values" id="childsafe_x" name="childsafe_x' + row_id + '">\n' +
									// 		'</div></div>\n' +
									// 		'<div class="row childsafe-content-box1" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
									// 		'<label style="margin-right: 10px;margin-bottom: 0;">Kettinglengte</label>' +
									// 		'<input style="border: none;border-bottom: 1px solid lightgrey;" type="number" class="form-control childsafe_values" id="childsafe_y" name="childsafe_y' + row_id + '">\n' +
									// 		'</div></div>\n' +
									// 		'<div class="row childsafe-question-box" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
									// 		'<label style="margin-right: 10px;margin-bottom: 0;">Childsafe</label>' +
									// 		'<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control childsafe-select" name="childsafe_option' + row_id + '">\n' +
									// 		'<option value="">Select any option</option>\n' +
									// 		'<option value="2">Add childsafety clip</option>\n' +
									// 		'</select>\n' +
									// 		'<input value="0" name="childsafe_diff' + row_id + '" class="childsafe_diff" type="hidden">' +
									// 		'</div></div>\n';

									// 	features = features + content;

									// }

									// if (ladderband == 1) {

									// 	var content = '<div class="row" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
									// 		'<label style="margin-right: 10px;margin-bottom: 0;">Ladderband</label>' +
									// 		'<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features' + row_id + '[]">\n' +
									// 		'<option value="0">No</option>\n' +
									// 		'<option value="1">Yes</option>\n' +
									// 		'</select>\n' +
									// 		'<input value="0" name="f_price' + row_id + '[]" class="f_price" type="hidden">' +
									// 		'<input value="0" name="f_id' + row_id + '[]" class="f_id" type="hidden">' +
									// 		'<input value="0" name="f_area' + row_id + '[]" class="f_area" type="hidden">' +
									// 		'<input value="0" name="sub_feature' + row_id + '[]" class="sub_feature" type="hidden">' +
									// 		'</div><a data-id="' + row_id + '" class="info ladderband-btn hide">Info</a></div>\n';

									// 	features = features + content;

									// }

									// $.each(data[1], function (index, value) {

									//     count_features = count_features + 1;

									// 	var opt = '<option value="0">Select Feature</option>';

									// 	$.each(value.features, function (index1, value1) {

									// 		opt = opt + '<option value="' + value1.id + '">' + value1.title + '</option>';

									// 	});

									// 	if (value.comment_box == 1) {
									// 		var icon = '<a data-feature="' + value.id + '" class="info comment-btn">Info</a>';
									// 	}
									// 	else {
									// 		var icon = '';
									// 	}

									// 	var content = '<div class="row" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
									// 		'<label style="margin-right: 10px;margin-bottom: 0;">' + value.title + '</label>' +
									// 		'<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features' + row_id + '[]">' + opt + '</select>\n' +
									// 		'<input value="' + f_value + '" name="f_price' + row_id + '[]" class="f_price" type="hidden">' +
									// 		'<input value="' + value.id + '" name="f_id' + row_id + '[]" class="f_id" type="hidden">' +
									// 		'<input value="0" name="f_area' + row_id + '[]" class="f_area" type="hidden">' +
									// 		'<input value="0" name="sub_feature' + row_id + '[]" class="sub_feature" type="hidden">' +
									// 		'</div>' + icon + '</div>\n';

									// 	features = features + content;

									// });

									if(count_features > 0)
									{
										$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').hide();
										$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').css('visibility','visible');
										$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').show();
									}
									else
									{
										$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').hide();
										$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').css('visibility','visible');
										$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').show();
									}

									// if ($('#menu1').find(`[data-id='${row_id}']`).length > 0) {
									// 	$('#menu1').find(`[data-id='${row_id}']`).remove();
									// }

									// $('#menu1').append('<div data-id="' + row_id + '" style="margin: 0;" class="form-group">' +
									// 	'\n' +
									// 	'<div class="row" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
									// 	'<label style="margin-right: 10px;margin-bottom: 0;">Quantity</label>' +
									// 	'<input value="1" style="border: none;border-bottom: 1px solid lightgrey;" maskedformat="9,1" name="qty[]" class="form-control" type="text" /><span>pcs</span>' +
									// 	'</div></div>' + features +
									// 	'</div>');

									if (data[3].max_size) {

										var sq = (width * height) / 10000;
										var max_size = data[3].max_size;

										if (sq > max_size) {
											Swal.fire({
												icon: 'error',
												title: '{{__('text.Oops...')}}',
												text: '{{__('text.Area is greater than max size')}}: ' + max_size,
											});

											current.parent().find('.f_area').val(1);
										}
									}
									else {
										current.parent().find('.f_area').val(0);
									}

									var model_impact_value = data[3].value;

									if (m1_impact == 1) {

										m1_impact_value = model_impact_value * (width / 100);

									}

									if (m2_impact == 1) {

										m2_impact_value = model_impact_value * ((width/100) * (height/100));

									}

									if (data[3].price_impact == 1) {

										if (data[3].impact_type == 0) {

											price = parseFloat(price) + parseFloat(model_impact_value);
											price = price.toFixed(2);

										}
										else {

											var per = (model_impact_value) / 100;
											model_impact_value = basic_price * per;

											price = parseFloat(price) + parseFloat(model_impact_value);
											price = price.toFixed(2);
										}

									}

									price = parseFloat(price) + parseFloat(m1_impact_value) + parseFloat(m2_impact_value);

									if(margin == 1)
									{
										if (data[2]) {

											var supplier_margin = data[2].margin;
											var retailer_margin = data[2].retailer_margin;

											if (supplier_margin && retailer_margin) {
												price = (parseFloat(price) / supplier_margin) * retailer_margin;
											}
										}
									}

									price = parseFloat(price).toFixed(2);

									var price_before_labor = parseFloat(price).toFixed(2);
									var labor = 0;

									if (data[4]) {
										labor = data[4].labor;
										labor = labor * (width / 100);
										//labor = Math.round(labor);
										price = parseFloat(price) + parseFloat(labor);
										price = price.toFixed(2);										
									}

									labor = parseFloat(labor).toFixed(2);

									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val(price_before_labor.replace(/\./g, ','));
									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val(price_before_labor);
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val(labor.replace(/\./g, ','));
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val(labor);
									$('#products_table').find(`[data-id='${row_id}']`).find('.model').find('.model_impact_value').val(model_impact_value);
									//$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('€ ' + Math.round(price));
									$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('€ ' + price.replace(/\./g, ','));
									$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val(price);
									$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val(price);
									$('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val(basic_price);
								}
							}
							else {

								$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('.model').find('.model_impact_value').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('');
								$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val('');

								$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').hide();
								$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').css('visibility','visible');
								$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').show();
							}

							calculate_total();
						}
					});
				}
				else
				{
					$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').hide();
					$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').css('visibility','visible');
					$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').show();
				}

			});

			$(document).on('input', "input[name='height[]']", function (e) {

				var current = $(this);
				var row_id = current.parents(".content-div").data('id');

				var price_based_option = $('#products_table').find(`[data-id='${row_id}']`).find('#price_based_option').val();
				var base_price = $('#products_table').find(`[data-id='${row_id}']`).find('#base_price').val();

				var height = current.val();
				height = height.replace(/\,/g, '.');

				var width = $('#products_table').find(`[data-id='${row_id}']`).find('.width').find('.m-input').val();
				width = width.replace(/\,/g, '.');

				var color = $('#products_table').find(`[data-id='${row_id}']`).find('.color').find('select').val();
				var model = $('#products_table').find(`[data-id='${row_id}']`).find('.model').find('select').val();
				var product = $('#products_table').find(`[data-id='${row_id}']`).find('.products').find('select').val();
				var ladderband = $('#products_table').find(`[data-id='${row_id}']`).find('#ladderband').val();
				$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(0);

				if (width && height && color && model && product) {

					if ($(this).parents(".content-div").find('.suppliers').hasClass('hide')) {
						var margin = 0;
					}
					else {
						var margin = 1;
					}

					$('#products_table').find(`[data-id='${row_id}']`).find('.discount-box').find('.discount_values').val(0);
					$('#products_table').find(`[data-id='${row_id}']`).find('.labor-discount-box').find('.labor_discount_values').val(0);
					$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount').val(0);
					$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount_old').val(0);

					$.ajax({
						type: "GET",
						data: "product=" + product + "&color=" + color + "&model=" + model + "&width=" + width + "&height=" + height + "&margin=" + margin,
						url: "<?php echo url('/aanbieder/get-price')?>",
						success: function (data) {

							if (typeof data[0].value !== 'undefined') {

								$('#myModal2').find(`.comment-boxes[data-id='${row_id}']`).remove();

								if (data[0].value === 'both') {

									Swal.fire({
										icon: 'error',
										title: '{{__('text.Oops...')}}',
										html: '{{__('text.Width & Height are greater than max values')}} <br> {{__('text.Max Width')}}: ' + data[0].max_width + '<br> {{__('text.Max Height')}}: ' + data[0].max_height,
									});

									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.model').find('.model_impact_value').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(3);
								}
								else if (data[0].value === 'x_axis') {

									Swal.fire({
										icon: 'error',
										title: '{{__('text.Oops...')}}',
										html: '{{__('text.Width is greater than max value')}} <br> {{__('text.Max Width')}}: ' + data[0].max_width,
									});

									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.model').find('.model_impact_value').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(1);
								}
								else if (data[0].value === 'y_axis') {

									Swal.fire({
										icon: 'error',
										title: '{{__('text.Oops...')}}',
										html: '{{__('text.Height is greater than max value')}} <br> {{__('text.Max Height')}}: ' + data[0].max_height,
									});

									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.model').find('.model_impact_value').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val('');
									$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(2);
								}
								else {

									$('#products_table').find(`[data-id='${row_id}']`).find('#childsafe').val(data[3].childsafe);
									var childsafe = data[3].childsafe;

									$('#myModal').find('.modal-body').find(`[data-id='${row_id}']`).remove();

									if (price_based_option == 1) {
										var price = data[0].value;
										var org = data[0].value;
									}
									else {
										var price = base_price;
										var org = base_price;
									}

									var basic_price = price;

									/*if (margin == 1) {
                                        if (data[2]) {
                                            price = parseFloat(price);
                                            var supplier_margin = data[2].margin;
                                            var retailer_margin = data[2].retailer_margin;

                                            $('#products_table').find(`[data-id='${row_id}']`).find('#supplier_margin').val(supplier_margin);
                                            $('#products_table').find(`[data-id='${row_id}']`).find('#retailer_margin').val(retailer_margin);

                                            if (supplier_margin && retailer_margin) {
                                                price = (price / supplier_margin) * retailer_margin;
                                                price = price.toFixed(2);
                                            }
                                        }
                                    }*/

									// var features = '';
									var count_features = 0;
									var f_value = 0;
									var m1_impact = data[3].m1_impact;
									var m2_impact = data[3].m2_impact;
									var m1_impact_value = 0;
									var m2_impact_value = 0;

									// if (childsafe == 1) {

									//     count_features = count_features + 1;

									// 	var content = '<div class="row childsafe-content-box" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
									// 		'<label style="margin-right: 10px;margin-bottom: 0;">Montagehoogte</label>' +
									// 		'<input style="border: none;border-bottom: 1px solid lightgrey;" type="number" class="form-control childsafe_values" id="childsafe_x" name="childsafe_x' + row_id + '">\n' +
									// 		'</div></div>\n' +
									// 		'<div class="row childsafe-content-box1" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
									// 		'<label style="margin-right: 10px;margin-bottom: 0;">Kettinglengte</label>' +
									// 		'<input style="border: none;border-bottom: 1px solid lightgrey;" type="number" class="form-control childsafe_values" id="childsafe_y" name="childsafe_y' + row_id + '">\n' +
									// 		'</div></div>\n' +
									// 		'<div class="row childsafe-question-box" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
									// 		'<label style="margin-right: 10px;margin-bottom: 0;">Childsafe</label>' +
									// 		'<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control childsafe-select" name="childsafe_option' + row_id + '">\n' +
									// 		'<option value="">Select any option</option>\n' +
									// 		'<option value="2">Add childsafety clip</option>\n' +
									// 		'</select>\n' +
									// 		'<input value="0" name="childsafe_diff' + row_id + '" class="childsafe_diff" type="hidden">' +
									// 		'</div></div>\n';

									// 	features = features + content;

									// }

									// if (ladderband == 1) {

									// 	var content = '<div class="row" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
									// 		'<label style="margin-right: 10px;margin-bottom: 0;">Ladderband</label>' +
									// 		'<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features' + row_id + '[]">\n' +
									// 		'<option value="0">No</option>\n' +
									// 		'<option value="1">Yes</option>\n' +
									// 		'</select>\n' +
									// 		'<input value="0" name="f_price' + row_id + '[]" class="f_price" type="hidden">' +
									// 		'<input value="0" name="f_id' + row_id + '[]" class="f_id" type="hidden">' +
									// 		'<input value="0" name="f_area' + row_id + '[]" class="f_area" type="hidden">' +
									// 		'<input value="0" name="sub_feature' + row_id + '[]" class="sub_feature" type="hidden">' +
									// 		'</div><a data-id="' + row_id + '" class="info ladderband-btn hide">Info</a></div>\n';

									// 	features = features + content;

									// }

									// $.each(data[1], function (index, value) {

									//     count_features = count_features + 1;

									// 	var opt = '<option value="0">Select Feature</option>';

									// 	$.each(value.features, function (index1, value1) {

									// 		opt = opt + '<option value="' + value1.id + '">' + value1.title + '</option>';

									// 	});

									// 	if (value.comment_box == 1) {
									// 		var icon = '<a data-feature="' + value.id + '" class="info comment-btn">Info</a>';
									// 	}
									// 	else {
									// 		var icon = '';
									// 	}

									// 	var content = '<div class="row" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
									// 		'<label style="margin-right: 10px;margin-bottom: 0;">' + value.title + '</label>' +
									// 		'<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features' + row_id + '[]">' + opt + '</select>\n' +
									// 		'<input value="' + f_value + '" name="f_price' + row_id + '[]" class="f_price" type="hidden">' +
									// 		'<input value="' + value.id + '" name="f_id' + row_id + '[]" class="f_id" type="hidden">' +
									// 		'<input value="0" name="f_area' + row_id + '[]" class="f_area" type="hidden">' +
									// 		'<input value="0" name="sub_feature' + row_id + '[]" class="sub_feature" type="hidden">' +
									// 		'</div>' + icon + '</div>\n';

									// 	features = features + content;

									// });

									if(count_features > 0)
									{
										$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').hide();
										$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').css('visibility','visible');
										$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').show();
									}
									else
									{
										$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').hide();
										$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').css('visibility','visible');
										$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').show();
									}

									// if ($('#menu1').find(`[data-id='${row_id}']`).length > 0) {
									// 	$('#menu1').find(`[data-id='${row_id}']`).remove();
									// }

									// $('#menu1').append('<div data-id="' + row_id + '" style="margin: 0;" class="form-group">' +
									// 	'\n' +
									// 	'<div class="row" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
									// 	'<label style="margin-right: 10px;margin-bottom: 0;">Quantity</label>' +
									// 	'<input value="1" style="border: none;border-bottom: 1px solid lightgrey;" maskedformat="9,1" name="qty[]" class="form-control" type="text" /><span>pcs</span>' +
									// 	'</div></div>' + features +
									// 	'</div>');

									if (data[3].max_size) {

										var sq = (width * height) / 10000;
										var max_size = data[3].max_size;

										if (sq > max_size) {
											Swal.fire({
												icon: 'error',
												title: '{{__('text.Oops...')}}',
												text: '{{__('text.Area is greater than max size')}}: ' + max_size,
											});

											current.parent().find('.f_area').val(1);
										}

									}
									else {
										current.parent().find('.f_area').val(0);
									}

									var model_impact_value = data[3].value;

									if (m1_impact == 1) {

										m1_impact_value = model_impact_value * (width / 100);

									}

									if (m2_impact == 1) {

										m2_impact_value = model_impact_value * ((width/100) * (height/100));

									}

									if (data[3].price_impact == 1) {

										if (data[3].impact_type == 0) {

											price = parseFloat(price) + parseFloat(model_impact_value);
											price = price.toFixed(2);

										}
										else {

											var per = (model_impact_value) / 100;
											model_impact_value = basic_price * per;

											price = parseFloat(price) + parseFloat(model_impact_value);
											price = price.toFixed(2);
										}

									}

									price = parseFloat(price) + parseFloat(m1_impact_value) + parseFloat(m2_impact_value);

									if(margin == 1)
									{
										if (data[2]) {

											var supplier_margin = data[2].margin;
											var retailer_margin = data[2].retailer_margin;

											if (supplier_margin && retailer_margin) {
												price = (parseFloat(price) / supplier_margin) * retailer_margin;
											}
										}
									}

									price = parseFloat(price).toFixed(2);

									var price_before_labor = parseFloat(price).toFixed(2);
									var labor = 0;

									if (data[4]) {
										labor = data[4].labor;
										labor = labor * (width / 100);
										//labor = Math.round(labor);
										price = parseFloat(price) + parseFloat(labor);
										price = price.toFixed(2);
									}

									labor = parseFloat(labor).toFixed(2);

									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val(price_before_labor.replace(/\./g, ','));
									$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val(price_before_labor);
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val(labor.replace(/\./g, ','));
									$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val(labor);
									$('#products_table').find(`[data-id='${row_id}']`).find('.model').find('.model_impact_value').val(model_impact_value);
									//$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('€ ' + Math.round(price));
									$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('€ ' + price.replace(/\./g, ','));
									$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val(price);
									$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val(price);
									$('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val(basic_price);
								}
							}
							else {
								$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('.model').find('.model_impact_value').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('');
								$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val('');

								$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').hide();
								$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').css('visibility','visible');
								$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').show();
							}

							calculate_total();
						}
					});
				}
				else
				{
					$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').hide();
					$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').css('visibility','visible');
					$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').show();
				}

			});

			$(document).on('input', '.labor_impact', function () {

				var value = $(this).val();
				value = value.replace(/\,/g, '.');
				var row_id = $(this).parents(".content-div").data('id');
				var price_before_labor = $('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val();
				price_before_labor = price_before_labor.replace(/\,/g, '.');
				var qty = $('#menu1').find(`[data-id='${row_id}']`).find('input[name="qty[]"]').val();
				var total_discount = $('#products_table').find(`[data-id='${row_id}']`).find('.total_discount').val();
				total_discount = total_discount.replace(/\,/g, '.');

				if (!value) {
					value = 0;
				}

				var total = parseFloat(price_before_labor) + parseFloat(value);
				total = total + parseFloat(total_discount);
				total = parseFloat(total);
				total = total.toFixed(2);
				var price = total;
				total = total / qty;
				total = parseFloat(total).toFixed(2);
				//total = Math.round(total);

				var new_old_value = value / qty;
				new_old_value = parseFloat(new_old_value).toFixed(2);

				$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val(new_old_value);
				$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('€ ' + total.replace(/\./g, ','));
				$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val(price);
				$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val(total);

				calculate_total(0,1);

			});

			$(document).on('input', '#childsafe_x, #childsafe_y', function () {

				var id = $(this).attr('id');
				var row_id = $(this).parent().parent().parent().data('id');

				if (id == 'childsafe_x') {
					var x = $(this).val();
					var y = $('#menu1').find(`[data-id='${row_id}']`).find('#childsafe_y').val();
				}
				else {
					var x = $('#menu1').find(`[data-id='${row_id}']`).find('#childsafe_x').val();
					var y = $(this).val();
				}

				var diff = x - y;
				diff = Math.abs(diff);

				if (x && y) {

					$('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-answer-box').remove();
					$('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-question-box').find('.childsafe-select').find('option').not(':first').remove();

					if (diff <= 150) {

						$('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-question-box').find('.childsafe-select').append('<option value="1" selected>{{__('text.Please note not childsafe')}}</option><option value="2">{{__('text.Add childsafety clip')}}</option>');

						$('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-question-box').after('<div class="row childsafe-answer-box" style="margin: 0;display: flex;align-items: center;">\n' +
								'\n' +
								'                                                                                        <div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
								'                                                                                            <label style="margin-right: 10px;margin-bottom: 0">{{__('text.Childsafe Answer')}}</label>\n' +
								'                                                                                            <select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control childsafe-answer" name="childsafe_answer' + row_id + '">\n' +
								'                                                                                                    <option value="1">{{__('text.Make it childsafe')}}</option>\n' +
								'                                                                                                    <option value="2">{{__('text.Yes i agree')}}</option>\n' +
								'                                                                                            </select>\n' +
								'                                                                                        </div>\n' +
								'\n' +
								'                                                                                    </div>');

					}
					else {

						$('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-question-box').find('.childsafe-select').append('<option value="2">{{__('text.Add childsafety clip')}}</option><option value="3" selected>{{__('text.Yes childsafe')}}</option>');

						$('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-question-box').after('<div class="row childsafe-answer-box" style="margin: 0;display: flex;align-items: center;">\n' +
								'\n' +
								'                                                                                        <div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
								'                                                                                            <label style="margin-right: 10px;margin-bottom: 0;">{{__('text.Childsafe Answer')}}</label>\n' +
								'                                                                                            <select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control childsafe-answer" name="childsafe_answer' + row_id + '">\n' +
								'                                                                                                    <option value="3">{{__('text.Is childsafe')}}</option>\n' +
								'                                                                                            </select>\n' +
								'                                                                                        </div>\n' +
								'\n' +
								'                                                                                    </div>');

					}

					$('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-question-box').find('.childsafe_diff').val(diff);

					var flag = 0;

					var childsafe = $('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-select').val();

					if (!childsafe && childsafe != undefined) {
						flag = 1;
					}

					$("[name='features" + row_id + "[]']").each(function (i, obj) {

						var selected_feature = $(this).val();
						var feature_id = $(this).parent().find('.f_id').val();

						if (feature_id != 0) {
							if (selected_feature == 0) {
								flag = 1;
							}
						}

					});

					if(flag == 1)
					{
						$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').hide();
						$('#products_table').find(`[data-id='${row_id}']`).find('.yellow-circle').css('visibility','visible');
						$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').show();
					}
					else
					{
						$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').hide();
						$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').css('visibility','visible');
						$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').show();
					}
				}
				else {

					$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').hide();
					$('#products_table').find(`[data-id='${row_id}']`).find('.yellow-circle').css('visibility','visible');
					$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').show();

					$('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-answer-box').remove();
					$('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-question-box').find('.childsafe-select').find('option').not(':first').remove();
					$('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-question-box').find('.childsafe-select').append('<option value="2">{{__('text.Add childsafety clip')}}</option>');
				}

			});

			$(document).on('change', '.childsafe-select', function () {
				var current = $(this);
				var row_id = current.parent().parent().parent().data('id');
				var value = current.val();
				var value_x = $('#menu1').find(`[data-id='${row_id}']`).find('#childsafe_x').val();
				var value_y = $('#menu1').find(`[data-id='${row_id}']`).find('#childsafe_y').val();

				if (value_x && value_y) {
					if (!value) {
						$('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-answer-box').remove();
					}
					else if (value == 2 || value == 3) {
						$('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-answer-box').remove();

						$('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-question-box').after('<div class="row childsafe-answer-box" style="margin: 0;display: flex;align-items: center;">\n' +
								'\n' +
								'                                                                                        <div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
								'                                                                                            <label style="margin-right: 10px;margin-bottom: 0;">{{__('text.Childsafe Answer')}}</label>\n' +
								'                                                                                            <select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control childsafe-answer" name="childsafe_answer' + row_id + '">\n' +
								'                                                                                                    <option value="3">{{__('text.Is childsafe')}}</option>\n' +
								'                                                                                            </select>\n' +
								'                                                                                        </div>\n' +
								'\n' +
								'                                                                                    </div>');
					}
					else {
						$('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-answer-box').remove();

						$('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-question-box').after('<div class="row childsafe-answer-box" style="margin: 0;display: flex;align-items: center;">\n' +
								'\n' +
								'                                                                                        <div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
								'                                                                                            <label style="margin-right: 10px;margin-bottom: 0">{{__('text.Childsafe Answer')}}</label>\n' +
								'                                                                                            <select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control childsafe-answer" name="childsafe_answer' + row_id + '">\n' +
								'                                                                                                    <option value="1">{{__('text.Make it childsafe')}}</option>\n' +
								'                                                                                                    <option value="2">{{__('text.Yes i agree')}}</option>\n' +
								'                                                                                            </select>\n' +
								'                                                                                        </div>\n' +
								'\n' +
								'                                                                                    </div>');
					}
				}
				else {
					current.val('');

					Swal.fire({
						icon: 'error',
						title: '{{__('text.Oops...')}}',
						text: '{{__('text.Kindly fill both childsafe values first.')}}',
					});
				}

			});

			$(document).on('change', '.feature-select', function () {

				var current = $(this);
				var row_id = current.parent().parent().parent().data('id');
				var feature_select = current.val();
				var id = current.parent().find('.f_id').val();
				var width = $('#products_table').find(`[data-id='${row_id}']`).find('.width').find('.m-input').val();
				width = width.replace(/\,/g, '.');
				var height = $('#products_table').find(`[data-id='${row_id}']`).find('.height').find('.m-input').val();
				height = height.replace(/\,/g, '.');
				var product_id = $('#products_table').find(`[data-id='${row_id}']`).find('.products').find('select').val();
				var ladderband_value = $('#products_table').find(`[data-id='${row_id}']`).find('#ladderband_value').val();
				var ladderband_price_impact = $('#products_table').find(`[data-id='${row_id}']`).find('#ladderband_price_impact').val();
				var ladderband_impact_type = $('#products_table').find(`[data-id='${row_id}']`).find('#ladderband_impact_type').val();

				var impact_value = current.next('input').val();
				var total = $('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val();
				var basic_price = $('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val();
				var qty = $('#menu1').find(`[data-id='${row_id}']`).find('input[name="qty[]"]').val();
				var margin = $('#products_table').find(`[data-id='${row_id}']`).find('.suppliers').hasClass('hide');
				var supplier_margin = $('#products_table').find(`[data-id='${row_id}']`).find('#supplier_margin').val();
				var retailer_margin = $('#products_table').find(`[data-id='${row_id}']`).find('#retailer_margin').val();

				total = total - impact_value;
				var price_before_labor = $('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val();
				price_before_labor = price_before_labor - impact_value;

				if (id == 0) {

					if (feature_select == 1) {

						if (ladderband_price_impact == 1) {
							if (ladderband_impact_type == 0) {
								impact_value = ladderband_value;

								if(!margin)
								{
									if (supplier_margin && retailer_margin) {
										if(supplier_margin != 0)
										{
											impact_value = (parseFloat(impact_value) / supplier_margin) * retailer_margin;
										}
									}
								}

								impact_value = parseFloat(impact_value).toFixed(2);
								total = parseFloat(total) + parseFloat(impact_value);
								total = total.toFixed(2);
							}
							else {
								impact_value = ladderband_value;
								var per = (impact_value) / 100;
								impact_value = basic_price * per;

								if(!margin)
								{
									if (supplier_margin && retailer_margin) {
										if(supplier_margin != 0)
										{
											impact_value = (parseFloat(impact_value) / supplier_margin) * retailer_margin;
										}
									}
								}

								impact_value = parseFloat(impact_value).toFixed(2);
								total = parseFloat(total) + parseFloat(impact_value);
								total = total.toFixed(2);
							}
						}
						else {
							impact_value = 0;
							total = parseFloat(total) + parseFloat(impact_value);
							total = total.toFixed(2);
						}

						//total = Math.round(total);
						price_before_labor = parseFloat(price_before_labor) + parseFloat(impact_value);
						price_before_labor = parseFloat(price_before_labor).toFixed(2);
						//price_before_labor = Math.round(price_before_labor);

						current.next('input').val(impact_value);

						$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val(price_before_labor);
						$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('€ ' + total.replace(/\./g, ','));
						$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val(total);

						calculate_total();

						$.ajax({
							type: "GET",
							data: "product_id=" + product_id,
							url: "<?php echo url('/aanbieder/get-sub-products-sizes')?>",
							success: function (data) {

								$('#myModal').find('.modal-body').find('.sub-tables').hide();

								if ($('#myModal').find('.modal-body').find(`[data-id='${row_id}']`).length > 0) {
									$('#myModal').find('.modal-body').find(`[data-id='${row_id}']`).remove();
								}


								$('#myModal').find('.modal-body').append(
										'<div class="sub-tables" data-id="' + row_id + '">\n' +
										'<table style="width: 100%;">\n' +
										'<thead>\n' +
										'<tr>\n' +
										'<th>ID</th>\n' +
										'<th>{{__('text.Title')}}</th>\n' +
										'<th>{{__('text.Size 38mm')}}</th>\n' +
										'<th>{{__('text.Size 25mm')}}</th>\n' +
										'</tr>\n' +
										'</thead>\n' +
										'<tbody>\n' +
										'</tbody>\n' +
										'</table>\n' +
										'</div>'
								);

								$.each(data, function (index, value) {

									var size1 = value.size1_value;
									var size2 = value.size2_value;

									if (size1 == 1) {
										size1 = '<input data-id="' + row_id + '" class="cus_radio" name="cus_radio' + row_id + '[]" type="radio"><input class="cus_value sizeA" type="hidden" value="0" name="sizeA' + row_id + '[]">';
									}
									else {
										size1 = 'X' + '<input class="sizeA" name="sizeA' + row_id + '[]" type="hidden" value="x">';
									}

									if (size2 == 1) {
										size2 = '<input data-id="' + row_id + '" class="cus_radio" name="cus_radio' + row_id + '[]" type="radio"><input class="cus_value sizeB" type="hidden" value="0" name="sizeB' + row_id + '[]">';
									}
									else {
										size2 = 'X' + '<input class="sizeB" name="sizeB' + row_id + '[]" type="hidden" value="x">';
									}

									$('#myModal').find('.modal-body').find(`[data-id='${row_id}']`).find('table').append(
											'<tr>\n' +
											'<td><input class="sub_product_id" type="hidden" name="sub_product_id' + row_id + '[]" value="' + value.id + '">' + value.code + '</td>\n' +
											'<td>' + value.title + '</td>\n' +
											'<td>' + size1 + '</td>\n' +
											'<td>' + size2 + '</td>\n' +
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
					else {

						$('#menu1').find(`[data-id='${row_id}']`).find('.ladderband-btn').addClass('hide');
						$('#myModal').find('.modal-body').find(`[data-id='${row_id}']`).remove();

						impact_value = 0;
						total = parseFloat(total) + parseFloat(impact_value);
						total = total.toFixed(2);
						//total = Math.round(total);
						price_before_labor = parseFloat(price_before_labor) + parseFloat(impact_value);
						price_before_labor = parseFloat(price_before_labor).toFixed(2);
						//price_before_labor = Math.round(price_before_labor);

						current.next('input').val(impact_value);

						$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val(price_before_labor);
						$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('€ ' + total.replace(/\./g, ','));
						$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val(total);

						calculate_total();
					}
				}
				else {
					var heading = current.find("option:selected").text();
					var heading_id = current.val();

					$.ajax({
						type: "GET",
						data: "id=" + feature_select,
						url: "<?php echo url('/aanbieder/get-feature-price')?>",
						success: function (data) {

							if (current.parent().parent().next('.sub-features').length > 0) {
								var sub_impact_value = current.parent().parent().next('.sub-features').find('.f_price').val();
								total = total - sub_impact_value;
								price_before_labor = price_before_labor - sub_impact_value;
								current.parent().parent().next('.sub-features').remove();
							}

							if (data[1].length > 0) {
								var opt = '<option value="0">{{__('text.Select Feature')}}</option>';

								$.each(data[1], function (index, value) {

									opt = opt + '<option value="' + value.id + '">' + value.title + '</option>';

								});

								current.parent().parent().after('<div class="row sub-features" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
										'<label style="margin-right: 10px;margin-bottom: 0;">' + heading + '</label>' +
										'<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features' + row_id + '[]">' + opt + '</select>\n' +
										'<input value="0" name="f_price' + row_id + '[]" class="f_price" type="hidden">' +
										'<input value="' + heading_id + '" name="f_id' + row_id + '[]" class="f_id" type="hidden">' +
										'<input value="0" name="f_area' + row_id + '[]" class="f_area" type="hidden">' +
										'<input value="1" name="sub_feature' + row_id + '[]" class="sub_feature" type="hidden">' +
										'</div></div>');
							}

							if (data[0] && data[0].max_size) {
								var sq = (width * height) / 10000;
								var max_size = data[0].max_size;

								if (sq > max_size) {
									Swal.fire({
										icon: 'error',
										title: '{{__('text.Oops...')}}',
										text: '{{__('text.Area is greater than max size')}}: ' + max_size,
									});

									current.parent().find('.f_area').val(1);
								}
							}
							else {
								current.parent().find('.f_area').val(0);
							}

							if (data[0] && data[0].price_impact == 1) {

								if (data[0].variable == 1) {
									impact_value = data[0].value;
									impact_value = impact_value * (width / 100);

									if(!margin)
									{
										if (supplier_margin && retailer_margin) {
											if(supplier_margin != 0)
											{
												impact_value = (parseFloat(impact_value) / supplier_margin) * retailer_margin;
											}
										}
									}

									impact_value = parseFloat(impact_value).toFixed(2);
									total = parseFloat(total) + parseFloat(impact_value);
									total = total.toFixed(2);
								}
								else {
									if (data[0].impact_type == 0) {
										impact_value = data[0].value;

										if(!margin)
										{
											if (supplier_margin && retailer_margin) {
												if(supplier_margin != 0)
												{
													impact_value = (parseFloat(impact_value) / supplier_margin) * retailer_margin;
												}
											}
										}

										impact_value = parseFloat(impact_value).toFixed(2);
										total = parseFloat(total) + parseFloat(impact_value);
										total = total.toFixed(2);
									}
									else {
										impact_value = data[0].value;
										var per = (impact_value) / 100;
										impact_value = basic_price * per;

										if(!margin)
										{
											if (supplier_margin && retailer_margin) {
												if(supplier_margin != 0)
												{
													impact_value = (parseFloat(impact_value) / supplier_margin) * retailer_margin;
												}
											}
										}

										impact_value = parseFloat(impact_value).toFixed(2);
										total = parseFloat(total) + parseFloat(impact_value);
										total = total.toFixed(2);
									}
								}
							}
							else {
								impact_value = 0;
								total = parseFloat(total) + parseFloat(impact_value);
								total = total.toFixed(2);
							}

							//total = Math.round(total);
							price_before_labor = parseFloat(price_before_labor) + parseFloat(impact_value);
							price_before_labor = parseFloat(price_before_labor).toFixed(2);
							//price_before_labor = Math.round(price_before_labor);

							current.next('input').val(impact_value);

							$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val(price_before_labor);
							$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('€ ' + total.replace(/\./g, ','));
							$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val(total);

							calculate_total();

							var flag = 0;

							var childsafe = $('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-select').val();

							if (!childsafe && childsafe != undefined) {
								flag = 1;
							}

							$("[name='features" + row_id + "[]']").each(function (i, obj) {

								var selected_feature = $(this).val();
								var feature_id = $(this).parent().find('.f_id').val();

								if (feature_id != 0) {
									if (selected_feature == 0) {
										flag = 1;
									}
								}

							});

							if(flag == 1)
							{
								$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').hide();
								$('#products_table').find(`[data-id='${row_id}']`).find('.yellow-circle').css('visibility','visible');
								$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').show();
							}
							else
							{
								$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').hide();
								$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').css('visibility','visible');
								$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').show();
							}
						}
					});
				}

			});

			$(document).on('change', '.childsafe-select', function () {

				var current = $(this);
				var row_id = current.parent().parent().parent().data('id');
				var feature_select = current.val();

				if(!feature_select)
				{
					$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').hide();
					$('#products_table').find(`[data-id='${row_id}']`).find('.yellow-circle').css('visibility','visible');
					$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').show();
				}
				else
				{
					$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').hide();
					$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').css('visibility','visible');
					$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').show();
				}

			});

			/*$('#myModal, #myModal2').on('hidden.bs.modal', function () {
                $('.top-bar').css('z-index','1000');
            });*/

			$(document).on('click', '.comment-btn', function () {

				var current = $(this);
				var row_id = current.parent().parent().data('id');
				var feature_id = current.data('feature');

				$('#myModal2').find('.modal-body').find('.comment-boxes').hide();

				if ($('#myModal2').find('.modal-body').find(`[data-id='${row_id}']`).find(`[data-id='${feature_id}']`).length > 0) {
					var box = $('#myModal2').find('.modal-body').find(`[data-id='${row_id}']`).find(`[data-id='${feature_id}']`);
					box.parent().show();
				}
				else {
					$('#myModal2').find('.modal-body').append(
							'<div class="comment-boxes" data-id="' + row_id + '">\n' +
							'<textarea style="resize: vertical;width: 100%;border: 1px solid #c9c9c9;border-radius: 5px;outline: none;" data-id="' + feature_id + '" rows="5" name="comment-' + row_id + '-' + feature_id + '"></textarea>\n' +
							'</div>'
					);
				}

				/*$('.top-bar').css('z-index','1');*/
				$('#myModal2').modal('toggle');
				$('.modal-backdrop').hide();

			});

			$(document).on('click', '.ladderband-btn', function () {

				var current = $(this);
				var row_id = current.data('id');

				$('#myModal').find('.modal-body').find('.sub-tables').hide();
				$('#myModal').find('.modal-body').find(`[data-id='${row_id}']`).show();

				/*$('.top-bar').css('z-index','1');*/
				$('#myModal').modal('toggle');
				$('.modal-backdrop').hide();

			});

			$(document).on('change', '.cus_radio', function () {

				var row_id = $(this).data('id');

				$('#myModal').find('.modal-body').find(`[data-id='${row_id}']`).find('.cus_radio').next('input').val(0);
				$(this).next('input').val(1);

			});


		});
	</script>

	<link href="{{asset('assets/admin/css/main.css')}}" rel="stylesheet">
	<link href="{{asset('assets/admin/css/bootstrap-tagsinput.css')}}" rel="stylesheet">

@endsection
