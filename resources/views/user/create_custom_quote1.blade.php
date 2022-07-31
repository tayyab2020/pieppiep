@extends('layouts.handyman')

@section('content')

	<script src="{{asset('assets/admin/js/main1.js')}}"></script>
	<script src="{{asset('assets/admin/js/bootstrap-tagsinput.js')}}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js"></script>
	<script src="{{asset('assets/admin/js/bootstrap-datetimepicker.min.js')}}"></script>

	<div class="right-side">

		<div class="container-fluid">
			<div class="row">

				<form id="form-quote" style="padding: 0;" class="form-horizontal" action="{{route('store-new-quotation')}}" method="POST" enctype="multipart/form-data">
					{{csrf_field()}}

					<input type="hidden" name="form_type" value="1">
					<input type="hidden" id="quote_request_id" name="quote_request_id" value="{{isset($request_id) ? $request_id : (isset($invoice) ? $invoice[0]->quote_request_id : null)}}">
					<input type="hidden" name="quotation_id" value="{{isset($invoice) ? $invoice[0]->invoice_id : null}}">
					<input type="hidden" name="is_invoice" value="{{isset($invoice) ? (Route::currentRouteName() == 'view-new-quotation' ? 0 : 1) : 0}}">
					{{--				<input type="hidden" name="direct_invoice" value="{{Route::currentRouteName() == 'create-direct-invoice' ? 1 : 0}}">--}}
					<input type="hidden" name="negative_invoice" value="{{Route::currentRouteName() == 'create-new-negative-invoice' ? 1 : 0}}">
					<input type="hidden" name="negative_invoice_id" value="{{isset($invoice) ? (Route::currentRouteName() == 'create-new-negative-invoice' ? ($invoice[0]->negative_invoice != 0 ? $invoice[0]->invoice_id : null) : null) : null}}">
					<input type="hidden" value="{{isset($request_id) && $request_id ? 1 : 0}}" id="request_quotation">

					<div style="margin: 0;" class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<!-- Starting of Dashboard data-table area -->
							<div class="section-padding add-product-1" style="padding: 0;">

								<div style="margin: 0;" class="row">
									<div style="padding: 0;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div style="box-shadow: none;" class="add-product-box">
											<div style="align-items: center;" class="add-product-header products">

												<h2 style="margin-top: 0;">{{isset($invoice) ? (Route::currentRouteName() == 'view-new-quotation' ? __('text.View Quotation') : (Route::currentRouteName() == 'create-new-negative-invoice' ? __('text.Create Negative Invoice') : __('text.View Invoice') )) : (Route::currentRouteName() == 'create-direct-invoice' ? __('text.Create Invoice') : __('text.Create Quotation'))}}</h2>

												<div style="background-color: black;border-radius: 10px;padding: 0 10px;">

													@if(Route::currentRouteName() == 'view-new-invoice' || Route::currentRouteName() == 'create-new-negative-invoice')

														<span class="tooltip1 save-data" style="cursor: pointer;font-size: 20px;margin-right: 10px;color: white;">
														<i class="fa fa-fw fa-save"></i>
														<span class="tooltiptext">{{__('text.Save')}}</span>
													</span>

													@else

														@if((isset($invoice) && ($invoice[0]->status == 0 || $invoice[0]->status == 1 || $invoice[0]->ask_customization)) || !isset($invoice))

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

											@if((isset($invoice) && !$invoice[0]->quote_request_id) || (isset($request_id) && !$request_id))

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

											@endif

											<div style="display: inline-block;width: 100%;">

												<div class="alert-box">

												</div>

												@include('includes.form-success')

												<select style="display: none;" class="form-control all-products" id="blood_grp">

													@foreach($products as $key)

														@foreach($key->models as $key1)

															@foreach($key->colors as $key2)

																<option data-model="{{$key1->model}}" data-model-id="{{$key1->id}}" data-color="{{$key2->title}}" data-color-id="{{$key2->id}}" data-supplier-id="{{$key->user_id}}" value="{{$key->id}}">{{$key->title.', '.$key1->model.', '.$key2->title.', ('.$key->company_name.')' . ' € ' . number_format((float)$key1->estimated_price, 2, ',', '') . ' per m&#178;, pakinhoud ' . number_format((float)$key1->estimated_price_quantity, 2, ',', '') . ' m&#178;'}}</option>

															@endforeach

														@endforeach

													@endforeach

													@foreach($services as $service)
														<option data-type="Service" value="{{$service->id}}S">{{$service->title . ', Service'}}</option>
													@endforeach

													@foreach($items as $item1)
														<option data-type="Item" value="{{$item1->id}}I">{{$item1->cat_name . ', Item, (' . $item1->category . ')'}}</option>
													@endforeach

												</select>

												<div style="padding-bottom: 0;" class="form-horizontal">

													<div style="margin: 0;border-top: 1px solid #eee;" class="row">

														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 second-row" style="padding-bottom: 15px;">

															<section id="products_table" style="width: 100%;">

																<div class="header-div">
																	<div class="headings" style="width: 2%;"></div>
																	<div class="headings" style="width: 34%;">{{__('text.Product')}}</div>
																	<div class="headings" style="width: 17%;">{{__('text.Qty')}}</div>
																	<div class="headings" style="width: 17%;">{{__('text.€ Art.')}}</div>
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
																			<input type="hidden" value="{{$item->base_price}}" id="base_price" name="base_price[]">
																			<input type="hidden" value="{{$item->supplier_margin}}" id="supplier_margin" name="supplier_margin[]">
																			<input type="hidden" value="{{$item->retailer_margin}}" id="retailer_margin" name="retailer_margin[]">
																			<input type="hidden" value="{{$item->box_quantity}}" id="estimated_price_quantity" name="estimated_price_quantity[]">
																			<input type="hidden" value="{{$item->measure}}" id="measure" name="measure[]">
																			<input type="hidden" value="{{$item->max_width}}" id="max_width" name="max_width[]">

																			<div style="width: 34%;" class="products content item3 full-res">

																				<label class="content-label">{{__('text.Product')}}</label>

																				<div class="autocomplete" style="width:100%;">
																					<input value="{{$item->item_id != 0 ? $item_titles[$i]->cat_name . ', Item, (' . $item_titles[$i]->category . ')' : ($item->service_id != 0 ? $service_titles[$i] . ', Service' : $product_titles[$i].', '.$model_titles[$i].', '.$color_titles[$i].', ('.$product_suppliers[$i]->company_name.')' . ' € ' . number_format((float)($item->price_before_labor/$item->box_quantity), 2, ',', '') . ' per m², pakinhoud ' . number_format((float)$item->box_quantity, 2, ',', '') . ' m²')}}" id="productInput" autocomplete="off" class="form-control quote-product" type="text" name="product" placeholder="{{__('text.Select Product')}}">
																				</div>

																				<input type="hidden" value="{{$item->item_id != 0 ? $item->item_id.'I' : ($item->service_id != 0 ? $item->service_id.'S' : $item->product_id)}}" name="products[]" id="product_id">
																				<input type="hidden" value="{{$item->supplier_id}}" name="suppliers[]" id="supplier_id">
																				<input type="hidden" value="{{$item->color}}" name="colors[]" id="color_id">
																				<input type="hidden" value="{{$item->model_id}}" name="models[]" id="model_id">

																			</div>

																			<div class="content item6" style="width: 17%;">

																				<label class="content-label">{{__('text.Qty')}}</label>

																				<div style="display: flex;align-items: center;">
																					@if(Route::currentRouteName() == 'create-new-negative-invoice') - @endif
																					<input type="text" value="{{str_replace('.', ',',floatval($item->qty))}}" maskedformat="9,1" name="qty[]" style="border: 0;background: transparent;padding: 0 5px;" class="form-control qty res-white">
																				</div>
																			</div>

																			<div class="content item6" style="width: 17%;">

																				<label class="content-label">{{__('text.€ Art.')}}</label>

																				<div style="display: flex;align-items: center;">
																					<span>€</span>
																					<input type="text" value="{{str_replace('.', ',',floatval($item->price_before_labor))}}" readonly name="price_before_labor[]" style="border: 0;background: transparent;padding: 0 5px;" class="form-control price_before_labor res-white">
																					<input type="hidden" value="{{$item->price_before_labor}}" class="price_before_labor_old">
																				</div>
																			</div>

																			<div class="content item8" style="width: 10%;">

																				<label class="content-label">{{__('text.Discount')}}</label>

																				<span>€</span>
																				<input type="text" value="{{$item->total_discount}}" name="total_discount[]" readonly style="border: 0;background: transparent;padding: 0 5px;height: 30px;" class="form-control total_discount res-white">
																				<input type="hidden" value="{{$item->total_discount/$item->qty}}" class="total_discount_old">
																			</div>

																			<div style="width: 7%;" class="content item9">

																				<label class="content-label">{{__('text.€ Total')}}</label>
																				@if(Route::currentRouteName() == 'create-new-negative-invoice') -&nbsp; @endif
																				<div class="price res-white">€ {{str_replace('.', ',',floatval($item->rate))}}</div>

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

																				<div style="width: 25%;margin-left: 10px;" class="discount-box item14">

																					<label>{{__('text.Discount')}} % </label>

																					<input style="height: 35px;border-radius: 4px;" placeholder="{{__('text.Enter discount in percentage')}}" type="text" class="form-control discount_values" value="{{$item->discount}}" name="discount[]">

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
																		<input type="hidden" id="base_price" name="base_price[]">
																		<input type="hidden" id="supplier_margin" name="supplier_margin[]">
																		<input type="hidden" id="retailer_margin" name="retailer_margin[]">
																		<input type="hidden" id="estimated_price_quantity" name="estimated_price_quantity[]">
																		<input type="hidden" id="measure" name="measure[]">
																		<input type="hidden" id="max_width" name="max_width[]">

																		<div style="width: 34%;" class="products content item3 full-res">

																			<label class="content-label">{{__('text.Product')}}</label>

																			<div class="autocomplete" style="width:100%;">
																				<input id="productInput" value="{{isset($request_id) && $request_id ? ($quote->quote_service ? $product_request->title.', '.($product_request->model ? $product_request->model.', ' : null).$product_request->color.', ('.$product_request->company_name.')' . ' € ' . number_format((float)$product_request->estimated_price, 2, ',', '') . ' per m², pakinhoud ' . number_format((float)$product_request->estimated_price_quantity, 2, ',', '') . ' m²' : $product_request->title.', Service') : null}}" autocomplete="off" class="form-control quote-product" type="text" name="product" placeholder="{{__('text.Select Product')}}">
																			</div>

																			<input type="hidden" value="{{isset($request_id) && $request_id ? ($quote->quote_service ? $product_request->id : $product_request->id.'S') : null}}" name="products[]" id="product_id">
																			<input type="hidden" value="{{isset($request_id) && $request_id ? ($quote->quote_service ? $product_request->supplier_id : null) : null}}" name="suppliers[]" id="supplier_id">
																			<input type="hidden" value="{{isset($request_id) && $request_id ? ($quote->quote_service ? $product_request->color_id : null) : null}}" name="colors[]" id="color_id">
																			<input type="hidden" value="{{isset($request_id) && $request_id ? ($quote->quote_service ? $product_request->model_id : null) : null}}" name="models[]" id="model_id">

																		</div>

																		<div class="content item6" style="width: 17%;">

																			<label class="content-label">{{__('text.Qty')}}</label>

																			<div style="display: flex;align-items: center;">
																				<input type="text" value="{{isset($request_id) && $request_id ? number_format((float)$quote_qty, 2, ',', '') : 1}}" name="qty[]" maskedformat="9,1" style="border: 0;background: transparent;padding: 0 5px;" class="form-control qty res-white">
																			</div>
																		</div>

																		<div class="content item6" style="width: 17%;">

																			<label class="content-label">{{__('text.€ Art.')}}</label>

																			<div style="display: flex;align-items: center;">
																				<span>€</span>
																				<input type="text" value="0" readonly name="price_before_labor[]" style="border: 0;background: transparent;padding: 0 5px;" class="form-control price_before_labor res-white">
																				<input type="hidden" value="0" class="price_before_labor_old">
																			</div>
																		</div>

																		<div class="content item8" style="width: 10%;">

																			<label class="content-label">{{__('text.Discount')}}</label>

																			<span>€</span>
																			<input type="text" value="0" name="total_discount[]" readonly style="border: 0;background: transparent;padding: 0 5px;height: 30px;" class="form-control total_discount res-white">
																			<input type="hidden" value="0" class="total_discount_old">
																		</div>

																		<div style="width: 7%;" class="content item9">

																			<label class="content-label">{{__('text.€ Total')}}</label>
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

																			<div style="width: 25%;margin-left: 10px;" class="discount-box item14">

																				<label>{{__('text.Discount')}} % </label>

																				<input style="height: 35px;border-radius: 4px;" placeholder="{{__('text.Enter discount in percentage')}}" type="text" class="form-control discount_values" value="0" name="discount[]">

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
																	<div class="headings1" style="visibility: hidden;width: 23%;display: flex;justify-content: flex-end;align-items: center;padding-right: 15px;"><span style="font-size: 14px;font-weight: bold;font-family: monospace;">{{__('text.Total')}}</span></div>
																	<div class="headings1" style="visibility: hidden;width: 7%;display: flex;align-items: center;">
																		<div style="display: flex;align-items: center;justify-content: center;">
																			<span style="font-size: 14px;font-weight: 500;margin-right: 5px;">€</span>
																			<input name="price_before_labor_total"
																				   id="price_before_labor_total"
																				   style="border: 0;font-size: 14px;font-weight: 500;width: 75px;outline: none;"
																				   type="text" readonly
																				   value="{{isset($invoice) ? str_replace('.', ',',floatval($invoice[0]->price_before_labor_total)) : 0}}">
																		</div>
																	</div>

																	<div class="headings2" style="width: 30%;display: flex;align-items: center;">
																		<div style="display: flex;align-items: center;justify-content: flex-end;width: 60%;">
																			<span style="font-size: 14px;font-weight: 500;margin-right: 5px;font-family: monospace;">Te betalen: @if(Route::currentRouteName() == 'create-new-negative-invoice') - @endif €</span>
																			<input name="total_amount" id="total_amount"
																				   style="border: 0;font-size: 14px;font-weight: 500;width: 75px;outline: none;"
																				   type="text" readonly
																				   value="{{isset($invoice) ? str_replace('.', ',',floatval($invoice[0]->grand_total)) : 0}}">
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
																				   value="{{isset($invoice) ? str_replace('.', ',',floatval($invoice[0]->net_amount)) : 0}}">
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
																				   value="{{isset($invoice) ? str_replace('.', ',',floatval($invoice[0]->tax_amount)) : 0}}">
																		</div>
																	</div>

																</div>

															</div>

														</div>

														<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background: white;padding: 15px 0 0 0;">

															<ul style="border: 0;" class="nav nav-tabs feature-tab">

																<li style="margin-bottom: 0;" class="active"><a style="border: 0;padding: 10px 30px;" data-toggle="tab" href="#menu2" aria-expanded="false">{{__('text.Calculator')}}</a></li>

																<li style="margin-bottom: 0;display: none;"><a style="border: 0;padding: 10px 30px;" data-toggle="tab" href="#menu1" aria-expanded="false">{{__('text.Features')}}</a></li>

															</ul>

															<div style="padding: 30px 15px 20px 15px;border: 0;border-top: 1px solid #24232329;" class="tab-content">

																<div id="menu1" class="tab-pane">

																	@if(isset($invoice))

																		<?php $f = 0; $s = 0; ?>

																		@foreach($invoice as $x => $key1)

																			<div data-id="{{$x + 1}}" @if($x==0) style="margin: 0;" @else style="margin: 0;display: none;" @endif class="form-group">

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

																					<div class="row childsafe-question-box" style="margin: 0;display: flex;align-items: center;">

																						<div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">

																							<label style="margin-right: 10px;margin-bottom: 0;">{{__('text.Childsafe')}}</label>

																							<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control childsafe-select" name="childsafe_option{{$x+1}}">

																								<option value="">{{__('text.Select any option')}}</option>

																								@if($key1->childsafe_diff <= 150)

																									<option {{$key1->childsafe_question == 1 ? 'selected' : null}} value="1">{{__('text.Please note not childsafe')}}</option>
																									<option {{$key1->childsafe_question == 2 ? 'selected' : null}} value="2">{{__('text.Add childsafety clip')}}</option>

																								@else

																									<option {{$key1->childsafe_question == 2 ? 'selected' : null}} value="2">{{__('text.Add childsafety clip')}}</option>
																									<option {{$key1->childsafe_question == 3 ? 'selected' : null}} value="3">{{__('text.Yes childsafe')}}</option>

																								@endif

																							</select>

																							<input value="{{$key1->childsafe_diff}}" name="childsafe_diff{{$x + 1}}" class="childsafe_diff" type="hidden">

																						</div>

																					</div>

																					<div class="row childsafe-answer-box" style="margin: 0;display: flex;align-items: center;">

																						<div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">

																							<label style="margin-right: 10px;margin-bottom: 0;">{{__('text.Childsafe Answer')}}</label>
																							<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control childsafe-answer" name="childsafe_answer{{$x+1}}">

																								@if($key1->childsafe_question == 1)

																									<option {{$key1->childsafe_answer == 1 ? 'selected' : null}} value="1">{{__('text.Make it childsafe')}}</option>
																									<option {{$key1->childsafe_answer == 2 ? 'selected' : null}} value="2">{{__('text.Yes i agree')}}</option>

																								@else

																									<option selected value="3">{{__('text.Is childsafe')}}</option>

																								@endif

																							</select>
																						</div>

																					</div>

																				@endif

																				@foreach($key1->features as $feature)

																					@if($feature->feature_id == 0 && $feature->feature_sub_id == 0)

																						<div class="row" style="margin: 0;display: flex;align-items: center;">

																							<div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">

																								<label style="margin-right: 10px;margin-bottom: 0;">{{__('text.Ladderband')}}</label>

																								<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features{{$x+1}}[]">

																									<option {{$feature->ladderband == 0 ? 'selected' : null}} value="0">{{__('text.No')}}</option>
																									<option {{$feature->ladderband == 1 ? 'selected' : null}} value="1">{{__('text.Yes')}}</option>

																								</select>

																								<input value="{{$feature->price}}" name="f_price{{$x + 1}}[]" class="f_price" type="hidden">
																								<input value="0" name="f_id{{$x + 1}}[]" class="f_id" type="hidden">
																								<input value="0" name="f_area{{$x + 1}}[]" class="f_area" type="hidden">
																								<input value="0" name="sub_feature{{$x + 1}}[]" class="sub_feature" type="hidden">

																							</div>


																							@if($feature->ladderband)

																								<a data-id="{{$x + 1}}" class="info ladderband-btn">{{__('text.Info')}}</a>

																							@endif

																						</div>

																					@else

																						<div class="row" style="margin: 0;display: flex;align-items: center;">

																							<div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">

																								<label style="margin-right: 10px;margin-bottom: 0;">{{$feature->title}}</label>

																								<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features{{$x+1}}[]">

																									<option value="0">{{__('text.Select Feature')}}</option>

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

																								<a data-feature="{{$feature->feature_id}}" class="info comment-btn">{{__('text.Info')}}</a>

																							@endif

																						</div>

																						@foreach($key1->sub_features as $sub_feature)

																							@if($sub_feature->feature_id == $feature->feature_sub_id)

																								<div class="row sub-features" style="margin: 0;display: flex;align-items: center;">

																									<div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">

																										<label style="margin-right: 10px;margin-bottom: 0;">{{$sub_feature->title}}</label>

																										<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features{{$x+1}}[]">

																											<option value="0">{{__('text.Select Feature')}}</option>

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

																<div id="menu2" class="tab-pane fade active in">

																	@if(isset($invoice))

																		@foreach($invoice as $i => $key)

																			<section @if($i == 0) class="attributes_table active" @else class="attributes_table" @endif data-id="{{$i+1}}" style="width: 100%;">

																				@if($key->measure == 'M1')

																					<div class="header-div">
																						<div class="headings" style="width: 22%;">{{__('text.Description')}}</div>
																						<div class="headings" style="width: 10%;">{{__('text.Width')}}</div>
																						<div class="headings" style="width: 10%;">{{__('text.Height')}}</div>
																						<div class="headings" style="width: 10%;">{{__('text.Cutting lose')}}</div>
																						<div class="headings m2_box" style="width: 10%;display: none;">{{__('text.Total')}}</div>
																						<div class="headings m1_box" style="width: 10%;">{{__('text.Turn')}}</div>
																						<div class="headings m1_box" style="width: 10%;">{{__('text.Max Width')}}</div>
																						<div class="headings m2_box" style="width: 10%;display: none;">{{__('text.Box quantity')}}</div>
																						<div class="headings m1_box" style="width: 10%;">{{__('text.Total')}}</div>
																						<div class="headings m2_box" style="width: 10%;display: none;">{{__('text.Total boxes')}}</div>
																						<div class="headings" style="width: 18%;"></div>
																					</div>

																				@else

																					<div class="header-div">
																						<div class="headings" style="width: 22%;">{{__('text.Description')}}</div>
																						<div class="headings" style="width: 10%;">{{__('text.Width')}}</div>
																						<div class="headings" style="width: 10%;">{{__('text.Height')}}</div>
																						<div class="headings" style="width: 10%;">{{__('text.Cutting lose')}}</div>
																						<div class="headings m2_box" style="width: 10%;">{{__('text.Total')}}</div>
																						<div class="headings m1_box" style="width: 10%;display: none;">{{__('text.Turn')}}</div>
																						<div class="headings m1_box" style="width: 10%;display: none;">{{__('text.Max Width')}}</div>
																						<div class="headings m2_box" style="width: 10%;">{{__('text.Box quantity')}}</div>
																						<div class="headings m1_box" style="width: 10%;display: none;">{{__('text.Total')}}</div>
																						<div class="headings m2_box" style="width: 10%;">{{__('text.Total boxes')}}</div>
																						<div class="headings" style="width: 18%;"></div>
																					</div>

																				@endif

																				@foreach($key->calculations as $c => $temp)

																					<div @if($key->measure == 'Per Piece') style="display: none;" @endif class="attribute-content-div" data-id="{{$temp->calculator_row}}" data-main-id="{{$temp->parent_row ? $temp->parent_row : 0}}">

																						<div class="attribute full-res item1" style="width: 22%;">
																							<div style="display: flex;align-items: center;">
																								<input type="hidden" class="calculator_row" name="calculator_row{{$i+1}}[]" value="{{$temp->calculator_row}}">
																								<span style="width: 10%">{{$temp->calculator_row}}</span>
																								<div style="width: 90%;"><textarea class="form-control attribute_description" style="width: 90%;border-radius: 7px;resize: vertical;height: 40px;outline: none;" name="attribute_description{{$i+1}}[]">{{$temp->description}}</textarea></div>
																							</div>
																						</div>

																						<div class="attribute item2 width-box" style="width: 10%;">

																							<div class="m-box">
																								<input @if($key->measure == 'M1' && $temp->parent_row == NULL && $temp->turn == 1 && $temp->width != NULL) style="border: 1px solid #ccc;background-color: rgb(144, 238, 144);" @else style="border: 1px solid #ccc;" @endif {{$temp->parent_row != NULL ? 'readonly' : null}} value="{{$temp->width ? str_replace('.', ',',floatval($temp->width)) : NULL}}" id="width" class="form-control width m-input" maskedformat="9,1" autocomplete="off" name="width{{$i+1}}[]" type="text">
																								<input style="border: 0;outline: none;" value="cm" readonly="" type="text" name="width_unit1[]" class="measure-unit">
																							</div>

																						</div>

																						<div class="attribute item3 height-box" style="width: 10%;">

																							<div class="m-box">
																								<input @if($key->measure == 'M1' && $temp->parent_row == NULL && $temp->turn == 0 && $temp->height != NULL) style="border: 1px solid #ccc;background-color: rgb(144, 238, 144);" @else style="border: 1px solid #ccc;" @endif {{$temp->parent_row != NULL ? 'readonly' : null}} value="{{$temp->height ? str_replace('.', ',',floatval($temp->height)) : NULL}}" id="height" class="form-control height m-input" maskedformat="9,1" autocomplete="off" name="height{{$i+1}}[]" type="text">
																								<input style="border: 0;outline: none;" value="cm" readonly="" type="text" name="height_unit1[]" class="measure-unit">
																							</div>

																						</div>

																						<div class="attribute item4" style="width: 10%;">

																							<div class="m-box">
																								<input {{$temp->parent_row != NULL ? 'readonly' : null}} value="{{$temp->cutting_lose}}" class="form-control cutting_lose_percentage m-input" id="cutting_lose_percentage" style="border: 1px solid #ccc;" maskedformat="9,1" autocomplete="off" name="cutting_lose_percentage{{$i+1}}[]" type="text">
																								<input style="border: 0;outline: none;" readonly="" type="text" class="measure-unit">
																							</div>

																						</div>

																						<div class="attribute item5 m2_box" @if($key->measure == 'M1') style="width: 10%;display: none;" @else style="width: 10%;" @endif>

																							<div class="m-box">
																								<input value="{{$temp->total_boxes}}" class="form-control total_boxes m-input" style="background: transparent;border: 1px solid #ccc;" autocomplete="off" name="total_boxes{{$i+1}}[]" maskedformat="9,1" type="text">
																								<input style="border: 0;outline: none;" readonly="" type="text" class="measure-unit">
																							</div>

																						</div>

																						<div class="attribute item5 m1_box" @if($key->measure == 'M1') style="width: 10%;" @else style="width: 10%;display: none;" @endif>

																							<div style="display: flex;align-items: center;">
																								<select style="border-radius: 5px;width: 70%;height: 35px;" class="form-control turn" {{$temp->parent_row != NULL ? 'readonly' : null}} name="turn{{$i+1}}[]">
																									<option {{$temp->turn == 0 ? 'selected' : null}} {{$temp->parent_row != NULL && $temp->turn == 1 ? 'disabled' : null}} value="0">{{__('text.No')}}</option>
																									<option {{$temp->turn == 1 ? 'selected' : null}} {{$temp->parent_row != NULL && $temp->turn == 0 ? 'disabled' : null}} value="1">{{__('text.Yes')}}</option>
																								</select>
																							</div>

																						</div>

																						<div class="attribute item6 m1_box" @if($key->measure == 'M1') style="width: 10%;" @else style="width: 10%;display: none;" @endif>

																							<div style="display: flex;align-items: center;">
																								<input type="number" value="{{$temp->max_width}}" name="max_width{{$i+1}}[]" readonly style="border: 1px solid #ccc;background: transparent;" class="form-control max_width res-white m-input">
																							</div>

																						</div>

																						<div class="attribute item6 m2_box" @if($key->measure == 'M1') style="width: 10%;display: none;" @else style="width: 10%;" @endif>

																							<div class="m-box">
																								<input value="{{$temp->box_quantity_supplier}}" class="form-control box_quantity_supplier m-input" style="border: 1px solid #ccc;background: transparent;" readonly autocomplete="off" name="box_quantity_supplier{{$i+1}}[]" type="number">
																								<input style="border: 0;outline: none;" readonly="" type="text" class="measure-unit">
																							</div>

																						</div>

																						<div class="attribute item7" style="width: 10%;">

																							<div style="display: flex;align-items: center;">
																								<input value="{{$temp->box_quantity}}" type="number" name="box_quantity{{$i+1}}[]" readonly style="border: 1px solid #ccc;background: transparent;" class="form-control box_quantity res-white m-input">
																							</div>

																						</div>

																						<div class="attribute item8 last-content" style="padding: 0;width: 18%;">
																							<div class="res-white" style="display: flex;justify-content: flex-start;align-items: center;width: 100%;">

																								@if($temp->parent_row == NULL)

																									<span id="next-row-span" class="tooltip1 add-attribute-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;width: 20px;height: 20px;line-height: 20px;">
																										<i id="next-row-icon" class="fa fa-fw fa-plus"></i>
																										<span class="tooltiptext">{{__('text.Add')}}</span>
																									</span>

																									<span id="next-row-span" class="tooltip1 remove-attribute-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;width: 20px;height: 20px;line-height: 20px;">
																										<i id="next-row-icon" class="fa fa-fw fa-trash-o"></i>
																										<span class="tooltiptext">{{__('text.Remove')}}</span>
																									</span>

																									<span id="next-row-span" class="tooltip1 copy-attribute-row" style="cursor: pointer;font-size: 20px;margin: 0 10px;width: 20px;height: 20px;line-height: 20px;">
																										<i id="next-row-icon" class="fa fa-fw fa-copy"></i>
																										<span class="tooltiptext">{{__('text.Copy')}}</span>
																									</span>

																								@endif

																							</div>
																						</div>

																					</div>

																				@endforeach

																			</section>

																		@endforeach

																	@else

																		<section class="attributes_table active" data-id="1" style="width: 100%;">

																			<div class="header-div">
																				<div class="headings" style="width: 22%;">{{__('text.Description')}}</div>
																				<div class="headings" style="width: 10%;">{{__('text.Width')}}</div>
																				<div class="headings" style="width: 10%;">{{__('text.Height')}}</div>
																				<div class="headings" style="width: 10%;">{{__('text.Cutting lose')}}</div>
																				<div class="headings m2_box" style="width: 10%;">{{__('text.Total')}}</div>
																				<div class="headings m1_box" style="width: 10%;display: none;">{{__('text.Turn')}}</div>
																				<div class="headings m1_box" style="width: 10%;display: none;">{{__('text.Max Width')}}</div>
																				<div class="headings m2_box" style="width: 10%;">{{__('text.Box quantity')}}</div>
																				<div class="headings m1_box" style="width: 10%;display: none;">{{__('text.Total')}}</div>
																				<div class="headings m2_box" style="width: 10%;">{{__('text.Total boxes')}}</div>
																				<div class="headings" style="width: 18%;"></div>
																			</div>

																			@if($quote && (count($quote->dimensions) > 0))

																				@foreach($quote->dimensions as $d => $key)

																					<div class="attribute-content-div" data-id="{{$d+1}}" data-main-id="0">

																						<div class="attribute full-res item1" style="width: 22%;">
																							<div style="display: flex;align-items: center;">
																								<input type="hidden" class="calculator_row" name="calculator_row1[]" value="{{$d+1}}">
																								<span style="width: 10%">{{$d+1}}</span>
																								<div style="width: 90%;"><textarea class="form-control attribute_description" style="width: 90%;border-radius: 7px;resize: vertical;height: 40px;outline: none;" name="attribute_description1[]">{{$key->description}}</textarea></div>
																							</div>
																						</div>

																						<div class="attribute item2 width-box" style="width: 10%;">

																							<div class="m-box">
																								<input value="{{str_replace('.', ',',floatval($key->width))}}" style="border: 1px solid #ccc;" id="width" class="form-control width m-input" maskedformat="9,1" autocomplete="off" name="width1[]" type="text">
																								<input style="border: 0;outline: none;" value="cm" readonly="" type="text" name="width_unit1[]" class="measure-unit">
																							</div>

																						</div>

																						<div class="attribute item3 height-box" style="width: 10%;">

																							<div class="m-box">
																								<input value="{{str_replace('.', ',',floatval($key->height))}}" style="border: 1px solid #ccc;" id="height" class="form-control height m-input" maskedformat="9,1" autocomplete="off" name="height1[]" type="text">
																								<input style="border: 0;outline: none;" value="cm" readonly="" type="text" name="height_unit1[]" class="measure-unit">
																							</div>

																						</div>

																						<div class="attribute item4" style="width: 10%;">

																							<div class="m-box">
																								<input class="form-control cutting_lose_percentage m-input" id="cutting_lose_percentage" style="border: 1px solid #ccc;" maskedformat="9,1" autocomplete="off" name="cutting_lose_percentage1[]" type="text">
																								<input style="border: 0;outline: none;" readonly="" type="text" class="measure-unit">
																							</div>

																						</div>

																						<div class="attribute item5 m2_box" style="width: 10%;">

																							<div class="m-box">
																								<input class="form-control total_boxes m-input" style="background: transparent;border: 1px solid #ccc;" autocomplete="off" name="total_boxes1[]" maskedformat="9,1" type="text">
																								<input style="border: 0;outline: none;" readonly="" type="text" class="measure-unit">
																							</div>

																						</div>

																						<div class="attribute item5 m1_box" style="width: 10%;display: none;">

																							<div style="display: flex;align-items: center;">
																								<select style="border-radius: 5px;width: 70%;height: 35px;" class="form-control turn" name="turn1[]">
																									<option value="0">{{__('text.No')}}</option>
																									<option value="1">{{__('text.Yes')}}</option>
																								</select>
																							</div>

																						</div>

																						<div class="attribute item6 m1_box" style="width: 10%;display: none;">

																							<div style="display: flex;align-items: center;">
																								<input type="number" name="max_width1[]" readonly style="border: 1px solid #ccc;background: transparent;" class="form-control max_width res-white m-input">
																							</div>

																						</div>

																						<div class="attribute item6 m2_box" style="width: 10%;">

																							<div class="m-box">
																								<input class="form-control box_quantity_supplier m-input" style="border: 1px solid #ccc;background: transparent;" readonly autocomplete="off" name="box_quantity_supplier1[]" type="number">
																								<input style="border: 0;outline: none;" readonly="" type="text" class="measure-unit">
																							</div>

																						</div>

																						<div class="attribute item7" style="width: 10%;">

																							<div style="display: flex;align-items: center;">
																								<input type="number" name="box_quantity1[]" readonly style="border: 1px solid #ccc;background: transparent;" class="form-control box_quantity res-white m-input">
																							</div>

																						</div>

																						<div class="attribute item8 last-content" style="padding: 0;width: 18%;">

																							<div class="res-white" style="display: flex;justify-content: flex-start;align-items: center;width: 100%;">

																							<span id="next-row-span" class="tooltip1 add-attribute-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;width: 20px;height: 20px;line-height: 20px;">
																								<i id="next-row-icon" class="fa fa-fw fa-plus"></i>
																								<span class="tooltiptext">{{__('text.Add')}}</span>
																							</span>

																								<span id="next-row-span" class="tooltip1 remove-attribute-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;width: 20px;height: 20px;line-height: 20px;">
																								<i id="next-row-icon" class="fa fa-fw fa-trash-o"></i>
																								<span class="tooltiptext">{{__('text.Remove')}}</span>
																							</span>

																								<span id="next-row-span" class="tooltip1 copy-attribute-row" style="cursor: pointer;font-size: 20px;margin: 0 10px;width: 20px;height: 20px;line-height: 20px;">
																								<i id="next-row-icon" class="fa fa-fw fa-copy"></i>
																								<span class="tooltiptext">{{__('text.Copy')}}</span>
																							</span>

																							</div>
																						</div>

																					</div>

																				@endforeach

																			@else

																				<div class="attribute-content-div" data-id="1" data-main-id="0">

																					<div class="attribute full-res item1" style="width: 22%;">
																						<div style="display: flex;align-items: center;">
																							<input type="hidden" class="calculator_row" name="calculator_row1[]" value="1">
																							<span style="width: 10%">1</span>
																							<div style="width: 90%;"><textarea class="form-control attribute_description" style="width: 90%;border-radius: 7px;resize: vertical;height: 40px;outline: none;" name="attribute_description1[]"></textarea></div>
																						</div>
																					</div>

																					<div class="attribute item2 width-box" style="width: 10%;">

																						<div class="m-box">
																							<input style="border: 1px solid #ccc;" id="width" class="form-control width m-input" maskedformat="9,1" autocomplete="off" name="width1[]" type="text">
																							<input style="border: 0;outline: none;" value="cm" readonly="" type="text" name="width_unit1[]" class="measure-unit">
																						</div>

																					</div>

																					<div class="attribute item3 height-box" style="width: 10%;">

																						<div class="m-box">
																							<input style="border: 1px solid #ccc;" id="height" class="form-control height m-input" maskedformat="9,1" autocomplete="off" name="height1[]" type="text">
																							<input style="border: 0;outline: none;" value="cm" readonly="" type="text" name="height_unit1[]" class="measure-unit">
																						</div>

																					</div>

																					<div class="attribute item4" style="width: 10%;">

																						<div class="m-box">
																							<input class="form-control cutting_lose_percentage m-input" id="cutting_lose_percentage" style="border: 1px solid #ccc;" maskedformat="9,1" autocomplete="off" name="cutting_lose_percentage1[]" type="text">
																							<input style="border: 0;outline: none;" readonly="" type="text" class="measure-unit">
																						</div>

																					</div>

																					<div class="attribute item5 m2_box" style="width: 10%;">

																						<div class="m-box">
																							<input class="form-control total_boxes m-input" style="background: transparent;border: 1px solid #ccc;" autocomplete="off" name="total_boxes1[]" maskedformat="9,1" type="text">
																							<input style="border: 0;outline: none;" readonly="" type="text" class="measure-unit">
																						</div>

																					</div>

																					<div class="attribute item5 m1_box" style="width: 10%;display: none;">

																						<div style="display: flex;align-items: center;">
																							<select style="border-radius: 5px;width: 70%;height: 35px;" class="form-control turn" name="turn1[]">
																								<option value="0">{{__('text.No')}}</option>
																								<option value="1">{{__('text.Yes')}}</option>
																							</select>
																						</div>

																					</div>

																					<div class="attribute item6 m1_box" style="width: 10%;display: none;">

																						<div style="display: flex;align-items: center;">
																							<input type="number" name="max_width1[]" readonly style="border: 1px solid #ccc;background: transparent;" class="form-control max_width res-white m-input">
																						</div>

																					</div>

																					<div class="attribute item6 m2_box" style="width: 10%;">

																						<div class="m-box">
																							<input class="form-control box_quantity_supplier m-input" style="border: 1px solid #ccc;background: transparent;" readonly autocomplete="off" name="box_quantity_supplier1[]" type="number">
																							<input style="border: 0;outline: none;" readonly="" type="text" class="measure-unit">
																						</div>

																					</div>

																					<div class="attribute item7" style="width: 10%;">

																						<div style="display: flex;align-items: center;">
																							<input type="number" name="box_quantity1[]" readonly style="border: 1px solid #ccc;background: transparent;" class="form-control box_quantity res-white m-input">
																						</div>

																					</div>

																					<div class="attribute item8 last-content" style="padding: 0;width: 18%;">

																						<div class="res-white" style="display: flex;justify-content: flex-start;align-items: center;width: 100%;">

																						<span id="next-row-span" class="tooltip1 add-attribute-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;width: 20px;height: 20px;line-height: 20px;">
																							<i id="next-row-icon" class="fa fa-fw fa-plus"></i>
																							<span class="tooltiptext">{{__('text.Add')}}</span>
																						</span>

																							<span id="next-row-span" class="tooltip1 remove-attribute-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;width: 20px;height: 20px;line-height: 20px;">
																							<i id="next-row-icon" class="fa fa-fw fa-trash-o"></i>
																							<span class="tooltiptext">{{__('text.Remove')}}</span>
																						</span>

																							<span id="next-row-span" class="tooltip1 copy-attribute-row" style="cursor: pointer;font-size: 20px;margin: 0 10px;width: 20px;height: 20px;line-height: 20px;">
																							<i id="next-row-icon" class="fa fa-fw fa-copy"></i>
																							<span class="tooltiptext">{{__('text.Copy')}}</span>
																						</span>

																						</div>
																					</div>

																				</div>

																			@endif

																		</section>

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
							<input id="email" name="email" class="form-control validation" placeholder="{{$lang->sue}}"
								   type="email">
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

		.alert-danger
		{
			margin: 30px 10px !important;
		}

		.autocomplete ::-webkit-input-placeholder {
			text-align: center;
		}

		.autocomplete :-moz-placeholder { /* Firefox 18- */
			text-align: center;
		}

		.autocomplete ::-moz-placeholder {  /* Firefox 19+ */
			text-align: center;
		}

		.autocomplete :-ms-input-placeholder {
			text-align: center;
		}

		.autocomplete {
			position: relative;
			display: inline-block;
		}

		.quote-product {
			border: 0;
			padding: 0 5px;
			width: 100%;
			height: 35px !important;
		}

		.autocomplete-items {
			position: absolute;
			border: 1px solid #d4d4d4;
			/* border-bottom: none;
            border-top: none; */
			z-index: 99;
			/*position the autocomplete items to be the same width as the container:*/
			top: 100%;
			left: 0;
			right: 0;
			max-height: 230px;
			overflow-x: hidden;
			overflow-y: auto;
		}

		.autocomplete-items div {
			padding: 10px;
			cursor: pointer;
			background-color: #fff;
			border-bottom: 1px solid #d4d4d4;
		}

		.autocomplete-items div:last-child
		{
			border-bottom: 0;
		}

		/*when hovering an item:*/
		.autocomplete-items div:hover {
			background-color: #e9e9e9;
		}

		/*when navigating through the items using the arrow keys:*/
		.autocomplete-active {
			background-color: DodgerBlue !important;
			color: #ffffff;
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

		#menu2 .attributes_table
		{
			display: none;
		}

		#menu2 .attributes_table.active
		{
			display: block;
		}

		.header-div, .content-div, .attribute-content-div
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

		.content-div, .attribute-content-div
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

		.appointment_start, .appointment_end
		{
			background-color: white !important;
		}

		/* #cus-box .select2-selection__clear, .appointment_title_box .select2-selection__clear, .appointment_quotation_number_box .select2-selection__clear, .appointment_type_box .select2-selection__clear, .appointment_customer_box .select2-selection__clear, .appointment_supplier_box .select2-selection__clear, .appointment_employee_box .select2-selection__clear {
			display: none;
		} */

		.feature-tab li a[aria-expanded="false"]::before,
		a[aria-expanded="true"]::before {
			display: none;
		}

		.feature-tab .active > a
		{
			border-bottom: 3px solid rgb(151, 140, 135) !important;
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
				// events: [
				// 	{
				// 		id: 1,
				// 		title: 'All Day Event',
				// 		start: '2022-06-01',
				// 	},
				// 	{
				// 		id: 2,
				// 		title: 'Long Event',
				// 		start: '2022-06-07',
				// 		end: '2022-06-10'
				// 	},
				// 	{
				// 		id: 3,
				// 		classNames: 'delivery_date',
				// 		title: 'Delivery Date',
				// 		start: '2022-06-09T16:00:00',
				// 		durationEditable: false
				// 	},
				// 	{
				// 		id: 4,
				// 		classNames: 'non_removeables',
				// 		title: 'Repeating Event',
				// 		start: '2022-06-16T16:00:00',
				// 		editable: false,
				// 		droppable: false,
				// 		eventStartEditable: false,
				// 		eventResizableFromStart: false,
				// 		eventDurationEditable: false
				// 	},
				// 	{
				// 		id: 5,
				// 		classNames: 'installation_date',
				// 		title: 'Installation Date',
				// 		start: '2022-06-11T00:00:00',
				// 		end: '2022-06-13T00:00:00'
				// 	},
				// 	{
				// 		id: 6,
				// 		title: 'Meeting',
				// 		start: '2022-06-12T10:30:00',
				// 		end: '2022-06-12T12:30:00'
				// 	},
				// 	{
				// 		id: 7,
				// 		title: 'Lunch',
				// 		start: '2022-06-12T12:00:00'
				// 	},
				// 	{
				// 		id: 8,
				// 		title: 'Meeting',
				// 		start: '2022-06-12T14:30:00'
				// 	},
				// 	{
				// 		id: 9,
				// 		title: 'Happy Hour',
				// 		start: '2022-06-12T17:30:00'
				// 	},
				// 	{
				// 		id: 10,
				// 		title: 'Dinner',
				// 		start: '2022-06-12T20:00:00'
				// 	},
				// 	{
				// 		id: 11,
				// 		title: 'Birthday Party',
				// 		start: '2022-06-13T07:00:00'
				// 	},
				// 	{
				// 		id: 12,
				// 		title: 'Click for Google',
				// 		url: 'http://google.com/',
				// 		start: '2022-06-28'
				// 	}
				// ]
			});

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

			if($('#request_quotation').val() == 1)
			{
				var current = $(".quote-product");
				var product_id = current.parents(".content-div").find('#product_id').val();
				var model_id = current.parents(".content-div").find('#model_id').val();
				var color_id = current.parents(".content-div").find('#color_id').val();
				var supplier_id = current.parents(".content-div").find('#supplier_id').val();
				var row_id = current.parents(".content-div").data('id');
				var measure = '';
				var box_quantity = '';
				var max_width = '';
				var quote_qty = current.parents(".content-div").find('.qty').val();

				select_product(current,product_id,model_id,color_id,supplier_id,row_id,measure,box_quantity,max_width,quote_qty);
			}

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
					var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

					if (!regex.test(email)) {
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

			function calculate_total(qty_changed = 0,labor_changed = 0) {

				var total = 0;
				var price_before_labor_total = 0;

				$("input[name='total[]']").each(function (i, obj) {

					var rate = 0;
					var row_id = $(this).parent().data('id');
					var qty = $('#products_table').find(`[data-id='${row_id}']`).find('input[name="qty[]"]').val();
					qty = qty.replace(/\,/g, '.');

					if (!qty) {
						qty = 1;
					}

					if (!obj.value) {
						rate = 0;
					}
					else {
						rate = obj.value;
					}

					rate = rate * qty;

					// var labor_impact = $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val();
					// labor_impact = labor_impact * qty;
					// labor_impact = parseFloat(labor_impact).toFixed(2);

					// if(labor_changed == 0)
					// {
					// 	$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val(labor_impact.replace(/\./g, ','));
					// }

					var price_before_labor = $('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val();
					// price_before_labor = price_before_labor * qty;
					// price_before_labor = parseFloat(price_before_labor).toFixed(2);

					if(isNaN(price_before_labor))
					{
						price_before_labor = 0;
						// $('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val(price_before_labor);
					}
					// else
					// {
					// 	$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val(price_before_labor.replace(/\./g, ','));
					// }

					if(qty_changed == 0)
					{
						var old_discount = $('#products_table').find(`[data-id='${row_id}']`).find('.total_discount').val();
						old_discount = old_discount.replace(/\,/g, '.');
						old_discount = parseFloat(old_discount).toFixed(2);

						rate = rate - old_discount;

						var discount = $('#products_table').find(`[data-id='${row_id}']`).find('.discount-box').find('.discount_values').val();
						// var labor_discount = $('#products_table').find(`[data-id='${row_id}']`).find('.labor-discount-box').find('.labor_discount_values').val();

						if(!discount)
						{
							discount = 0;
						}

						// if(!labor_discount)
						// {
						// 	labor_discount = 0;
						// }

						var discount_val = parseFloat(rate) * (discount/100);
						// var labor_discount_val = parseFloat(labor_impact) * (labor_discount/100);

						// var total_discount = discount_val + labor_discount_val;
						var total_discount = discount_val;
						total_discount = parseFloat(total_discount).toFixed(2);

						if(isNaN(total_discount))
						{
							total_discount = 0;
						}

						var old_discount = total_discount / qty;
						old_discount = parseFloat(old_discount).toFixed(2);

						if(isNaN(old_discount))
						{
							old_discount = 0;
						}

						$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount').val('-' + total_discount.replace(/\./g, ','));
						$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount_old').val('-' + old_discount);

						rate = parseFloat(rate) - parseFloat(total_discount);
						var price = rate / qty;

						if(isNaN(price))
						{
							price = 0;
						}

						price = parseFloat(price).toFixed(2);

						if(qty != 0)
						{
							$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val(price);
						}

					}
					else
					{
						var price = rate / qty;

						if(isNaN(price))
						{
							price = 0;
						}

						if(qty != 0)
						{
							$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val(price);
						}

						var old_discount = $('#products_table').find(`[data-id='${row_id}']`).find('.total_discount_old').val();
						old_discount = old_discount * qty;
						old_discount = parseFloat(old_discount).toFixed(2);

						if(isNaN(old_discount))
						{
							old_discount = 0;
						}

						$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount').val(old_discount.replace(/\./g, ','));
					}

					rate = parseFloat(rate);
					rate = rate.toFixed(2);

					total = parseFloat(total) + parseFloat(rate);
					total = total.toFixed(2);

					if(isNaN(rate))
					{
						rate = 0;
					}

					$(this).parent().find('#rate').val(rate);
					$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('€ ' + rate.replace(/\./g, ','));


					var art = price_before_labor;
					price_before_labor_total = parseFloat(price_before_labor_total) + parseFloat(art);
					price_before_labor_total = parseFloat(price_before_labor_total).toFixed(2);

					// var arb = labor_impact;
					// labor_cost_total = parseFloat(labor_cost_total) + parseFloat(arb);
					// labor_cost_total = parseFloat(labor_cost_total).toFixed(2);

				});

				if(isNaN(total))
				{
					total = 0;
				}

				var net_amount = (total / 121) * 100;
				net_amount = parseFloat(net_amount).toFixed(2);

				var tax_amount = total - net_amount;
				tax_amount = parseFloat(tax_amount).toFixed(2);

				$('#total_amount').val(total.replace(/\./g, ','));
				$('#price_before_labor_total').val(price_before_labor_total.replace(/\./g, ','));
				// $('#labor_cost_total').val(labor_cost_total.replace(/\./g, ','));
				$('#net_amount').val(net_amount.replace(/\./g, ','));
				$('#tax_amount').val(tax_amount.replace(/\./g, ','));
			}

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
				$('#menu2').children().not(`.attributes_table[data-id='${id}']`).removeClass('active');
				$('#menu2').find(`.attributes_table[data-id='${id}']`).addClass('active');

			}

			function numbering() {
				$('#products_table .content-div').each(function (index, tr) { $(this).find('.content:eq(0)').find('.sr-res').text(index + 1); });
			}

			function add_row(copy = false, rate = null, basic_price = null, price = null, product = null, product_text = null, supplier = null, color = null, model = null, price_text = null, features = null, features_selects = null, childsafe_question = null, childsafe_answer = null, qty = null, childsafe = 0, ladderband = 0, ladderband_value = 0, ladderband_price_impact = 0, ladderband_impact_type = 0, area_conflict = 0, subs = null, childsafe_x = null, childsafe_y = null, delivery_days = null, base_price = null, supplier_margin = null, retailer_margin = null, price_before_labor = null, price_before_labor_old = null, discount = null, total_discount = null, total_discount_old = null, last_column = null, menu2 = null, estimated_price_quantity = null, turns = null, measure = null, max_width = null) {

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
							'                                                            <input type="hidden" id="base_price" name="base_price[]">\n' +
							'                                                            <input type="hidden" id="supplier_margin" name="supplier_margin[]">\n' +
							'                                                            <input type="hidden" id="retailer_margin" name="retailer_margin[]">\n' +
							'                                                            <input type="hidden" id="estimated_price_quantity" name="estimated_price_quantity[]">\n' +
							'                                                            <input type="hidden" id="measure" name="measure[]">\n' +
							'                                                            <input type="hidden" id="max_width" name="max_width[]">\n' +
							'\n' +
							'                                                            <div style="width: 34%;" class="products content item3 full-res">\n' +
							'\n' +
							'                       									 	<label class="content-label">Product</label>\n' +
							'\n' +
							'                                                                <div class="autocomplete" style="width:100%;">\n' +
							'\n' +
							'																	<input id="productInput" autocomplete="off" class="form-control quote-product" type="text" name="product" placeholder="{{__('text.Select Product')}}">\n' +
							'\n' +
							'                                                                </div>\n' +
							'\n' +
							'																<input type="hidden" name="products[]" id="product_id">\n' +
							'																<input type="hidden" name="suppliers[]" id="supplier_id">\n' +
							'																<input type="hidden" name="colors[]" id="color_id">\n' +
							'																<input type="hidden" name="models[]" id="model_id">\n' +
							'\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div class="content item6" style="width: 17%;">\n' +
							'\n' +
							'                       									 	<label class="content-label">Qty</label>\n' +
							'\n' +
							'																 <div style="display: flex;align-items: center;">\n' +
							'<?php if(Route::currentRouteName() == 'create-new-negative-invoice'){ echo '-'; } ?>'+
							'																 	<input type="text" name="qty[]" maskedFormat="9,1" style="border: 0;background: transparent;padding: 0 5px;" class="form-control qty res-white">\n' +
							'																 </div>\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div class="content item7" style="width: 17%;">\n' +
							'\n' +
							'                       									 	<label class="content-label">€ Art.</label>\n' +
							'\n' +
							'																 <div style="display: flex;align-items: center;">\n' +
							'																 	<input type="text" readonly name="price_before_labor[]" style="border: 0;background: transparent;padding: 0 5px;" class="form-control price_before_labor res-white">\n' +
							'																	<input type="hidden" class="price_before_labor_old">\n' +
							'																 </div>\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div class="content item8" style="width: 10%;">\n' +
							'\n' +
							'                       									 	<label class="content-label">Discount</label>\n' +
							'\n' +
							'																<input type="text" value="0" name="total_discount[]" readonly style="border: 0;background: transparent;padding: 0 5px;" class="form-control total_discount res-white">\n' +
							'																<input type="hidden" value="0" class="total_discount_old">\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div style="width: 7%;" class="content item9">\n' +
							'\n' +
							'                       									 	<label class="content-label">€ Total</label>\n' +
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
							'																<div style="width: 25%;margin-left: 10px;" class="discount-box item14">\n' +
							'\n' +
							'																	<label>{{__('text.Discount')}} %</label>\n' +
							'\n' +
							'																	<input style="height: 35px;border-radius: 4px;" placeholder="Enter discount in percentage" type="text" class="form-control discount_values" value="0" name="discount[]">\n' +
							'\n' +
							'																</div>\n' +
							'\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                        </div>');


					$('#menu2').append('<section class="attributes_table active" data-id="'+rowCount+'" style="width: 100%;">\n' +
							'                                                            <div class="header-div">\n' +
							'                       									 	<div class="headings" style="width: 22%;">{{__('text.Description')}}</div>\n' +
							'                       									 	<div class="headings" style="width: 10%;">{{__('text.Width')}}</div>\n' +
							'																<div class="headings" style="width: 10%;">{{__('text.Height')}}</div>\n' +
							'																<div class="headings" style="width: 10%;">{{__('text.Cutting lose')}}</div>\n' +
							'																<div class="headings m2_box" style="width: 10%;">{{__('text.Total')}}</div>\n' +
							'																<div class="headings m1_box" style="width: 10%;display: none;">{{__('text.Turn')}}</div>\n' +
							'																<div class="headings m1_box" style="width: 10%;display: none;">{{__('text.Max Width')}}</div>\n' +
							'																<div class="headings m2_box" style="width: 10%;">{{__('text.Box quantity')}}</div>\n' +
							'																<div class="headings m1_box" style="width: 10%;display: none;">{{__('text.Total')}}</div>\n' +
							'																<div class="headings m2_box" style="width: 10%;">{{__('text.Total boxes')}}</div>\n' +
							'																<div class="headings" style="width: 18%;"></div>\n' +
							'                       									 </div>\n'
					);

					add_attribute_row(false, rowCount);

					var last_row = $('#products_table .content-div:last');

					focus_row(last_row);

					autocomplete(last_row.find("#productInput")[0], product_titles, product_ids, model_ids, color_ids, supplier_ids);

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
							'                                                            <input type="hidden" value="' + base_price + '" id="base_price" name="base_price[]">\n' +
							'                                                            <input type="hidden" value="' + supplier_margin + '" id="supplier_margin" name="supplier_margin[]">\n' +
							'                                                            <input type="hidden" value="' + retailer_margin + '" id="retailer_margin" name="retailer_margin[]">\n' +
							'                                                            <input type="hidden" value="' + estimated_price_quantity + '" id="estimated_price_quantity" name="estimated_price_quantity[]">\n' +
							'                                                            <input type="hidden" value="' + measure + '" id="measure" name="measure[]">\n' +
							'                                                            <input type="hidden" value="' + max_width + '" id="max_width" name="max_width[]">\n' +
							'\n' +
							'                                                            <div style="width: 34%;" class="products content item3 full-res">\n' +
							'\n' +
							'                       									 	<label class="content-label">Product</label>\n' +
							'\n' +
							'                                                                <div class="autocomplete" style="width:100%;">\n' +
							'\n' +
							'																	<input id="productInput" value="'+product_text+'" autocomplete="off" class="form-control quote-product" type="text" name="product" placeholder="{{__('text.Select Product')}}">\n' +
							'\n' +
							'                                                                </div>\n' +
							'\n' +
							'																<input type="hidden" name="products[]" id="product_id" value="'+product+'">\n' +
							'																<input type="hidden" name="suppliers[]" id="supplier_id" value="'+supplier+'">\n' +
							'																<input type="hidden" name="colors[]" id="color_id" value="'+color+'">\n' +
							'																<input type="hidden" name="models[]" id="model_id" value="'+model+'">\n' +
							'\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div class="content item6" style="width: 17%;">\n' +
							'\n' +
							'                       									 	<label class="content-label">Qty</label>\n' +
							'\n' +
							'																 <div style="display: flex;align-items: center;">\n' +
							'<?php if(Route::currentRouteName() == 'create-new-negative-invoice'){ echo '-'; } ?>'+
							'																 	<input value="' + qty + '" type="text" name="qty[]" maskedFormat="9,1" style="border: 0;background: transparent;padding: 0 5px;" class="form-control qty res-white">\n' +
							'																 </div>\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div class="content item7" style="width: 17%;">\n' +
							'\n' +
							'                       									 	<label class="content-label">€ Art.</label>\n' +
							'\n' +
							'																 <div style="display: flex;align-items: center;">\n' +
							'																 	<input value="' + price_before_labor + '" type="text" readonly name="price_before_labor[]" style="border: 0;background: transparent;padding: 0 5px;" class="form-control price_before_labor res-white">\n' +
							'																	<input value="' + price_before_labor_old + '" type="hidden" class="price_before_labor_old">\n' +
							'																 </div>\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div class="content item8" style="width: 10%;">\n' +
							'\n' +
							'                       									 	<label class="content-label">Discount</label>\n' +
							'\n' +
							'																<input type="text" value="' + total_discount + '" name="total_discount[]" readonly style="border: 0;background: transparent;padding: 0 5px;" class="form-control total_discount res-white">\n' +
							'																<input type="hidden" value="' + total_discount_old + '" class="total_discount_old">\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div style="width: 7%;" class="content item9">\n' +
							'\n' +
							'                       									 	<label class="content-label">€ Total</label>\n' +
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
							'                                                            <div style="width: 100%;" id="demo' + rowCount + '" class="item16 collapse">\n' +
							'\n' +
							'																<div style="width: 25%;margin-left: 10px;" class="discount-box item14">\n' +
							'\n' +
							'																	<label>Discount %</label>\n' +
							'\n' +
							'																	<input value="' + discount + '" style="height: 35px;border-radius: 4px;" placeholder="Enter discount in percentage" type="text" class="form-control discount_values" name="discount[]">\n' +
							'\n' +
							'																</div>\n' +
							'\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                        </div>');

					var last_row = $('#products_table .content-div:last');

					autocomplete(last_row.find("#productInput")[0], product_titles, product_ids, model_ids, color_ids, supplier_ids);

					if (features) {

						$('#menu1').append('<div data-id="' + rowCount + '" style="margin: 0;" class="form-group">\n' + features + '</div>');

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

					if(menu2)
					{
						$('#menu2').append('<section class="attributes_table" data-id="'+rowCount+'" style="width: 100%;"></section>\n');
						menu2.appendTo(`#menu2 .attributes_table[data-id='${rowCount}']`);

						$('#menu2').find(`.attributes_table[data-id='${rowCount}']`).each(function (i, obj) {

							$(obj).find('.calculator_row').attr('name', 'calculator_row' + rowCount + '[]');
							$(obj).find('.attribute_description').attr('name', 'attribute_description' + rowCount + '[]');
							$(obj).find('.width-box').find('.width').attr('name', 'width' + rowCount + '[]');
							$(obj).find('.width-box').find('.measure-unit').attr('name', 'width_unit' + rowCount + '[]');
							$(obj).find('.height-box').find('.height').attr('name', 'height' + rowCount + '[]');
							$(obj).find('.height-box').find('.measure-unit').attr('name', 'height_unit' + rowCount + '[]');
							$(obj).find('.cutting_lose_percentage').attr('name', 'cutting_lose_percentage' + rowCount + '[]');
							$(obj).find('.total_boxes').attr('name', 'total_boxes' + rowCount + '[]');
							$(obj).find('.box_quantity_supplier').attr('name', 'box_quantity_supplier' + rowCount + '[]');
							$(obj).find('.box_quantity').attr('name', 'box_quantity' + rowCount + '[]');
							$(obj).find('.max_width').attr('name', 'max_width' + rowCount + '[]');
							$(obj).find('.turn').attr('name', 'turn' + rowCount + '[]');

						});

						turns.each(function (index, select) {

							$('#menu2').find(`.attributes_table[data-id='${rowCount}']`).find('.turn').eq(index).val($(this).val());

						});
					}

					focus_row(last_row);

				}

				calculate_total();
			}

			function add_attribute_row(copy = false, product_row, menu2 = null, turn = 0, row_id = null) {

				var check_length = $(`.attributes_table[data-id='${product_row}']`).find('.attribute-content-div[data-main-id="0"]').length;

				if(check_length == 0)
				{
					var rowCount = 1;
				}
				else
				{
					var rowCount = $(`.attributes_table[data-id='${product_row}']`).find('.attribute-content-div[data-main-id="0"]:last').data('id');
					rowCount = rowCount + 1;
				}

				if (!copy) {

					var box_quantity = $('#products_table').find(`[data-id='${product_row}']`).find('#estimated_price_quantity').val();
					var max_width = $('#products_table').find(`[data-id='${product_row}']`).find('#max_width').val();
					var measure = $('#products_table').find(`[data-id='${product_row}']`).find('#measure').val();

					$(`.attributes_table[data-id='${product_row}']`).append((measure == "Per Piece" ? '<div style="display: none;" class="attribute-content-div" data-id="' + rowCount + '" data-main-id="0">\n' : '<div class="attribute-content-div" data-id="' + rowCount + '" data-main-id="0">\n') +
							'\n' +
							'                                                            <div class="attribute full-res item1" style="width: 22%;">\n' +
							'                       									 	<div style="display: flex;align-items: center;"><input type="hidden" class="calculator_row" name="calculator_row'+product_row+'[]" value="'+rowCount+'"><span style="width: 10%">'+rowCount+'</span><div style="width: 90%;"><textarea class="form-control attribute_description" style="width: 90%;border-radius: 7px;resize: vertical;height: 40px;outline: none;" name="attribute_description'+product_row+'[]"></textarea></div></div>\n' +
							'                       									 </div>\n' +
							'\n' +
							'                                                            <div class="attribute item2 width-box" style="width: 10%;">\n' +
							'\n' +
							'                       									 	<div class="m-box">\n' +
							'\n' +
							'                                                                <input style="border: 1px solid #ccc;" id="width" class="form-control width m-input" maskedformat="9,1" autocomplete="off" name="width'+product_row+'[]" type="text">\n' +
							'\n' +
							'                                                                <input style="border: 0;outline: none;" value="cm" readonly="" type="text" name="width_unit'+product_row+'[]" class="measure-unit">\n' +
							'\n' +
							'                                                               </div>\n' +
							'\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div class="attribute item3 height-box" style="width: 10%;">\n' +
							'\n' +
							'                       									 	<div class="m-box">\n' +
							'\n' +
							'                                                                <input style="border: 1px solid #ccc;" id="height" class="form-control height m-input" maskedformat="9,1" autocomplete="off" name="height'+product_row+'[]" type="text">\n' +
							'\n' +
							'                                                                <input style="border: 0;outline: none;" value="cm" readonly="" type="text" name="height_unit'+product_row+'[]" class="measure-unit">\n' +
							'\n' +
							'                                                               </div>\n' +
							'\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div class="attribute item4" style="width: 10%;">\n' +
							'\n' +
							'                       									 	<div class="m-box">\n' +
							'\n' +
							'                                                                <input style="border: 1px solid #ccc;" id="cutting_lose_percentage" class="form-control cutting_lose_percentage m-input" maskedformat="9,1" autocomplete="off" name="cutting_lose_percentage'+product_row+'[]" type="text">\n' +
							'\n' +
							'                                                                <input style="border: 0;outline: none;" readonly type="text" class="measure-unit">\n' +
							'\n' +
							'                                                               </div>\n' +
							'\n' +
							'                                                            </div>\n' +
							'\n' +
							(measure == "M1" ? '<div class="attribute item5 m2_box" style="width: 10%;display: none;">\n' : '<div class="attribute item5 m2_box" style="width: 10%;">\n') +
							'\n' +
							'                       									 	<div class="m-box">\n' +
							'\n' +
							'                                                                <input style="border: 1px solid #ccc;background: transparent;" class="form-control total_boxes m-input" autocomplete="off" name="total_boxes'+product_row+'[]" maskedformat="9,1" type="text">\n' +
							'\n' +
							'                                                                <input style="border: 0;outline: none;" readonly type="text" class="measure-unit">\n' +
							'\n' +
							'                                                               </div>\n' +
							'\n' +
							'                                                            </div>\n' +
							'\n' +
							(measure == "M1" ? '<div class="attribute item5 m1_box" style="width: 10%;">\n' : '<div class="attribute item5 m1_box" style="width: 10%;display: none;">\n') +
							'\n' +
							'                       									 	<div style="display: flex;align-items: center;">\n' +
							'\n' +
							'                                                                <select style="border-radius: 5px;width: 70%;height: 35px;" class="form-control turn" name="turn'+product_row+'[]">\n' +
							'\n' +
							'                                                                	<option value="0">{{__('text.No')}}</option>\n' +
							'                                                                	<option value="1">{{__('text.Yes')}}</option>\n' +
							'\n' +
							'                                                                </select>\n' +
							'\n' +
							'                                                               </div>\n' +
							'\n' +
							'                                                            </div>\n' +
							'\n' +
							(measure == "M1" ? '<div class="attribute item6 m1_box" style="width: 10%;">\n' : '<div class="attribute item6 m1_box" style="width: 10%;display: none;">\n') +
							'\n' +
							'                       									 	<div style="display: flex;align-items: center;">\n' +
							'\n' +
							'                                                                <input type="number" name="max_width'+product_row+'[]" value="'+max_width+'" readonly="" style="border: 1px solid #ccc;background: transparent;" class="form-control max_width res-white m-input">\n' +
							'\n' +
							'                                                               </div>\n' +
							'\n' +
							'                                                            </div>\n' +
							'\n' +
							(measure == "M1" ? '<div class="attribute item6 m2_box" style="width: 10%;display: none;">\n' : '<div class="attribute item6 m2_box" style="width: 10%;">\n') +
							'\n' +
							'                       									 	<div class="m-box">\n' +
							'\n' +
							'                                                                <input style="border: 1px solid #ccc;background: transparent;" value="'+box_quantity+'" class="form-control box_quantity_supplier m-input" readonly autocomplete="off" name="box_quantity_supplier'+product_row+'[]" type="number">\n' +
							'\n' +
							'                                                                <input style="border: 0;outline: none;" readonly type="text" class="measure-unit">\n' +
							'\n' +
							'                                                               </div>\n' +
							'\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div class="attribute item7" style="width: 10%;">\n' +
							'\n' +
							'                       									 	<div style="display: flex;align-items: center;">\n' +
							'\n' +
							'                                                                <input type="number" name="box_quantity'+product_row+'[]" readonly="" style="border: 1px solid #ccc;background: transparent;" class="form-control box_quantity res-white m-input">\n' +
							'\n' +
							'                                                               </div>\n' +
							'\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                            <div class="attribute item8 last-content" style="padding: 0;width: 18%;">\n' +
							'\n' +
							'                       									 	<div class="res-white" style="display: flex;justify-content: flex-start;align-items: center;width: 100%;">\n' +
							'\n' +
							'																	<span id="next-row-span" class="tooltip1 add-attribute-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;width: 20px;height: 20px;line-height: 20px;">\n' +
							'\n' +
							'																		<i id="next-row-icon" class="fa fa-fw fa-plus"></i>\n' +
							'\n' +
							'																		<span class="tooltiptext">{{__('text.Add')}}</span>\n' +
							'\n' +
							'																	</span>\n' +
							'\n' +
							'																	<span id="next-row-span" class="tooltip1 remove-attribute-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;width: 20px;height: 20px;line-height: 20px;">\n' +
							'\n' +
							'																		<i id="next-row-icon" class="fa fa-fw fa-trash-o"></i>\n' +
							'\n' +
							'																		<span class="tooltiptext">{{__('text.Remove')}}</span>\n' +
							'\n' +
							'																	</span>\n' +
							'\n' +
							'																	<span id="next-row-span" class="tooltip1 copy-attribute-row" style="cursor: pointer;font-size: 20px;margin: 0 10px;width: 20px;height: 20px;line-height: 20px;">\n' +
							'\n' +
							'																		<i id="next-row-icon" class="fa fa-fw fa-copy"></i>\n' +
							'\n' +
							'																		<span class="tooltiptext">{{__('text.Copy')}}</span>\n' +
							'\n' +
							'																	</span>\n' +
							'\n' +
							'                                                            	</div>\n' +
							'\n' +
							'                                                            </div>\n' +
							'\n' +
							'                                                        </div>');
				}
				else {

					$('#menu2').find(`.attributes_table[data-id='${product_row}']`).append('<div class="attribute-content-div" data-id="'+rowCount+'" data-main-id="0"></div>\n');
					menu2.appendTo(`#menu2 .attributes_table[data-id='${product_row}'] .attribute-content-div[data-id='${rowCount}']`);
					$('#menu2').find(`.attributes_table[data-id='${product_row}'] .attribute-content-div[data-id='${rowCount}']`).find('.calculator_row').val(rowCount);
					$('#menu2').find(`.attributes_table[data-id='${product_row}'] .attribute-content-div[data-id='${rowCount}']`).find('.item1 span').text(rowCount);
					$('#menu2').find(`.attributes_table[data-id='${product_row}'] .attribute-content-div[data-id='${rowCount}']`).find('.turn').val(turn);

					if($('#menu2').find(`.attributes_table[data-id='${product_row}'] .attribute-content-div[data-main-id='${row_id}']`).length > 0)
					{
						calculator(product_row,rowCount);
					}
					else
					{
						calculate_qty(product_row);
					}
				}
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

			$(document).on('click', '.add-attribute-row', function () {

				var product_row = $(this).parents('.attributes_table').data('id');

				add_attribute_row(false, product_row);

			});

			$(document).on('click', '.remove-row', function () {

				var rowCount = $('#products_table .content-div').length;

				var current = $(this).parents('.content-div');

				var id = current.data('id');

				if (rowCount != 1) {

					$('#menu1').find(`[data-id='${id}']`).remove();
					$('#menu2').find(`.attributes_table[data-id='${id}']`).remove();
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

			$(document).on('click', '.remove-attribute-row', function () {

				var product_row = $(this).parents('.attributes_table').data('id');
				var row_id = $(this).parents('.attribute-content-div').data('id');
				var rowCount = $('#menu2').find(`.attributes_table[data-id='${product_row}']`).find('.attribute-content-div[data-main-id="0"]').length;
				var current = $(this).parents('.attribute-content-div');

				if (rowCount != 1) {

					$(this).parents('.attributes_table').find('.attribute-content-div[data-main-id="'+row_id+'"]').remove();
					current.remove();
					calculate_qty(product_row);

				}

			});

			$(document).on('click', '.save-data', function () {

				var quote_request_id = $('#quote_request_id').val();
				var flag = 0;

				if(quote_request_id == '')
				{
					var customer = $('.customer-select').val();
					if (!customer) {
						flag = 1;
						$('#cus-box .select2-container--default .select2-selection--single').css('border-color', 'red');
					}
					else {
						$('#cus-box .select2-container--default .select2-selection--single').css('border-color', '#cacaca');
					}
				}

				$("[name='products[]']").each(function (i, obj) {

					if (!obj.value) {
						flag = 1;
						$(obj).parents('.products').find('#productInput').css('border', '1px solid red');
					}
					else {
						$(obj).parents('.products').find('#productInput').css('border', '0');
					}

				});

				$("[name='colors[]']").each(function (i, obj) {

					var product_id = $("[name='products[]']").eq(i).val();

					if(!product_id.includes('S') && !product_id.includes('I'))
					{
						if (!obj.value) {
							flag = 1;
							$(obj).parents('.products').find('#productInput').css('border', '1px solid red');
						}
						else {
							$(obj).parents('.products').find('#productInput').css('border', '0');
						}
					}

				});

				$("[name='models[]']").each(function (i, obj) {

					var product_id = $("[name='products[]']").eq(i).val();

					if(!product_id.includes('S') && !product_id.includes('I'))
					{
						if (!obj.value) {
							flag = 1;
							$(obj).parents('.products').find('#productInput').css('border', '1px solid red');
						}
						else {
							$(obj).parents('.products').find('#productInput').css('border', '0');
						}
					}

				});

				var conflict_feature = 0;

				$("[name='row_id[]']").each(function () {

					var id = $(this).val();

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

					// $("[name='width" + id + "[]']").each(function (i, obj) {

					// 	var value = $(this).val();

					// 	if (value == "") {
					// 		flag = 1;
					// 		$(this).css('border', '1px solid red');
					// 	}
					// 	else
					// 	{
					// 		$(this).css('border', '1px solid #ccc');
					// 	}

					// });

					// $("[name='height" + id + "[]']").each(function (i, obj) {

					// 	var value = $(this).val();

					// 	if (value == "") {
					// 		flag = 1;
					// 		$(this).css('border', '1px solid red');
					// 	}
					// 	else
					// 	{
					// 		$(this).css('border', '1px solid #ccc');
					// 	}

					// });

					// $("[name='cutting_lose_percentage" + id + "[]']").each(function (i, obj) {

					// 	var value = $(this).val();

					// 	if (value == "") {
					// 		flag = 1;
					// 		$(this).css('border', '1px solid red');
					// 	}
					// 	else
					// 	{
					// 		$(this).css('border', '1px solid #ccc');
					// 	}

					// });

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
				var product = current.find('#product_id').val();
				var product_text = current.find('#productInput').val();
				var supplier = current.find('#supplier_id').val();
				var color = current.find('#color_id').val();
				var model = current.find('#model_id').val();
				var price_text = current.find('.price').text();
				var features = $('#menu1').find(`[data-id='${id}']`).html();
				var childsafe_question = $('#menu1').find(`[data-id='${id}']`).find('.childsafe-select').val();
				var childsafe_answer = $('#menu1').find(`[data-id='${id}']`).find('.childsafe-answer').val();
				var features_selects = $('#menu1').find(`[data-id='${id}']`).find('.feature-select');
				var qty = current.find('.qty').val();
				var subs = $('#myModal').find('.modal-body').find(`[data-id='${id}']`).html();
				var childsafe_x = $('#menu1').find(`[data-id='${id}']`).find('#childsafe_x').val();
				var childsafe_y = $('#menu1').find(`[data-id='${id}']`).find('#childsafe_y').val();
				var base_price = current.find('#base_price').val();
				var supplier_margin = current.find('#supplier_margin').val();
				var retailer_margin = current.find('#retailer_margin').val();
				var price_before_labor = current.find('.price_before_labor').val();
				var price_before_labor_old = current.find('.price_before_labor_old').val();
				var discount = current.find('.discount-box').find('.discount_values').val();
				// var labor_discount = current.find('.labor-discount-box').find('.labor_discount_values').val();
				var total_discount = current.find('.total_discount').val();
				var total_discount_old = current.find('.total_discount_old').val();
				var last_column = current.find('#next-row-td').html();
				var menu2 = $('#menu2').find(`.attributes_table[data-id='${id}']`).children().clone();
				var turns = $('#menu2').find(`.attributes_table[data-id='${id}']`).find('.turn');
				var estimated_price_quantity = current.find('#estimated_price_quantity').val();
				var measure = current.find('#measure').val();
				var max_width = current.find('#max_width').val();

				add_row(true, rate, basic_price, price, product, product_text, supplier, color, model, price_text, features, features_selects, childsafe_question, childsafe_answer, qty, childsafe, ladderband, ladderband_value, ladderband_price_impact, ladderband_impact_type, area_conflict, subs, childsafe_x, childsafe_y, delivery_days, base_price, supplier_margin, retailer_margin, price_before_labor, price_before_labor_old, discount, total_discount, total_discount_old, last_column, menu2, estimated_price_quantity, turns, measure, max_width);

			});

			$(document).on('click', '.copy-attribute-row', function () {

				var current = $(this).parents('.attribute-content-div');
				var product_row = current.parents('.attributes_table').data('id');
				var row_id = current.data('id');
				var turn = current.find(".turn").val();
				var menu2 = current.children().clone();

				add_attribute_row(true, product_row, menu2, turn, row_id);

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

			$(document).on('keypress', ".childsafe_values, .discount_values", function (e) {

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

			$(document).on('input', ".discount_values", function (e) {

				calculate_total();

			});


			$(document).on('input', "input[name='qty[]']", function (e) {

				calculate_total(1);

			});

			$(document).on('keypress', ".width, .height", function (e) {

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

			$(document).on('keypress', ".cutting_lose_percentage, .total_boxes", function (e) {

				e = e || window.event;
				var charCode = (typeof e.which == "undefined") ? e.keyCode : e.which;
				var val = String.fromCharCode(charCode);

				if (!val.match(/^[0-9]+$/))  // For characters validation
				{
					e.preventDefault();
					return false;
				}

			});

			$(document).on('focusout', "input[name='qty[]']", function (e) {

				if (!$(this).val()) {
					$(this).val(0);
				}

				if ($(this).val().slice($(this).val().length - 1) == ',') {
					var val = $(this).val();
					val = val + '00';
					$(this).val(val);
				}

			});

			$(document).on('focusout', ".width, .height", function (e) {

				if ($(this).val().slice($(this).val().length - 1) == ',') {
					var val = $(this).val();
					val = val + '00';
					$(this).val(val);
				}
			});

			function calculator(product_row,row_id,cutting_change = null,total_boxes_change = null)
			{
				var measure = $("#products_table").find(`.content-div[data-id='${product_row}']`).find('#measure').val();
				var width = $('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.width').val();
				width = width.replace(/\,/g, '.');
				var height = $('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.height').val();
				height = height.replace(/\,/g, '.');
				var cutting_lose_percentage = $('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.cutting_lose_percentage').val();
				var total_quantity = $('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.total_boxes').val();

				if(measure == "M1")
				{
					$('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-main-id='${row_id}']`).remove();
					calculate_qty(product_row);
					var org_width = width;
					var org_height = height;
					var retailer_width = width;
					var retailer_height = height;
					var turn = $('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.turn').val();
					var max_width = $('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.max_width').val();
					var description = $('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.attribute_description').val();

					if(!max_width)
					{
						max_width = 0;
					}

					if (width && height && cutting_lose_percentage) {

						if(turn == 0)
						{
							if(max_width > parseFloat(width))
							{
								var total_boxes = (parseFloat(height) + parseInt(cutting_lose_percentage))/100;
								total_boxes = (Math.round(total_boxes * 10)) / 10;
								total_boxes = parseFloat(total_boxes).toFixed(2);

								$('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.box_quantity').val(total_boxes);
								$('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('#width').css('background-color','');
								$('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('#height').css('background-color','#90ee90');
							}
							else
							{
								if(max_width == 0)
								{
									var total_rows = 0;
								}
								else
								{
									var total_rows = parseFloat(width)/max_width;
									total_rows = Math.ceil(total_rows);
								}

								$('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.box_quantity').val('');
								$('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('#width').css('background-color','');
								$('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('#height').css('background-color','#90ee90');
								var content = '';
								var width_array = [];

								for(i = 0; i <= total_rows; i++)
								{
									if(i != total_rows)
									{
										var total = (parseFloat(height) + parseInt(cutting_lose_percentage))/100;
										total = (Math.round(total * 10)) / 10;
										total = parseFloat(total).toFixed(2);
									}
									else
									{
										var total = 0;
									}

									if(i == 0)
									{
										width = max_width;
										width_array[i] = width;
									}
									else
									{
										width = parseFloat(org_width) - parseFloat(width_array[width_array.length-1]);

										if(width > max_width)
										{
											width = max_width
										}
										else if(width == 0)
										{
											var sum = 0;

											for (j = 0; j < width_array.length; j++) {

												sum = sum + parseFloat(width_array[j]);

											}

											width = parseFloat(retailer_width) - parseFloat(sum);
										}

										org_width = width_array[width_array.length-1];
										width_array[i] = width;
									}

									width = parseFloat(width).toFixed(2);
									width = width.replace(/\./g, ',');
									height = parseFloat(height).toFixed(2);
									height = height.replace(/\./g, ',');

									// var rowCount = $(`.attributes_table[data-id='${product_row}']`).find('.attribute-content-div:last').data('id');
									// rowCount = rowCount + 1;

									content =  content + '<div class="attribute-content-div" data-id="'+row_id+'.'+(i+1)+'" data-main-id="'+ row_id +'">\n' +
											'\n' +
											'                                                            <div class="attribute full-res item1" style="width: 22%;">\n' +
											'                       									 	<div style="display: flex;align-items: center;"><input type="hidden" class="calculator_row" name="calculator_row'+product_row+'[]" value="'+row_id+'.'+(i+1)+'"><span style="width: 10%">'+row_id+'.'+(i+1)+'</span><div style="width: 90%;"><textarea class="form-control attribute_description" style="width: 90%;border-radius: 7px;resize: vertical;height: 40px;outline: none;" name="attribute_description'+product_row+'[]">'+ (i != total_rows ? description : 'Restant rol') +'</textarea></div></div>\n' +
											'                       									 </div>\n' +
											'\n' +
											'                                                            <div class="attribute item2 width-box" style="width: 10%;">\n' +
											'\n' +
											'                       									 	<div class="m-box">\n' +
											'\n' +
											'                                                                <input style="border: 1px solid #ccc;" readonly value="'+ width +'" id="width" class="form-control width m-input" maskedformat="9,1" autocomplete="off" name="width'+product_row+'[]" type="text">\n' +
											'\n' +
											'                                                                <input style="border: 0;outline: none;" value="cm" readonly="" type="text" name="width_unit'+product_row+'[]" class="measure-unit">\n' +
											'\n' +
											'                                                               </div>\n' +
											'\n' +
											'                                                            </div>\n' +
											'\n' +
											'                                                            <div class="attribute item3 height-box" style="width: 10%;">\n' +
											'\n' +
											'                       									 	<div class="m-box">\n' +
											'\n' +
											'                                                                <input style="border: 1px solid #ccc;" readonly value="'+ height +'" id="height" class="form-control height m-input" maskedformat="9,1" autocomplete="off" name="height'+product_row+'[]" type="text">\n' +
											'\n' +
											'                                                                <input style="border: 0;outline: none;" value="cm" readonly="" type="text" name="height_unit'+product_row+'[]" class="measure-unit">\n' +
											'\n' +
											'                                                               </div>\n' +
											'\n' +
											'                                                            </div>\n' +
											'\n' +
											'                                                            <div class="attribute item4" style="width: 10%;">\n' +
											'\n' +
											'                       									 	<div class="m-box">\n' +
											'\n' +
											(i != total_rows ? '<input style="border: 1px solid #ccc;" readonly value="'+ cutting_lose_percentage +'" id="cutting_lose_percentage" class="form-control cutting_lose_percentage m-input" maskedformat="9,1" autocomplete="off" name="cutting_lose_percentage'+product_row+'[]" type="text">\n' : '<input style="border: 1px solid #ccc;" readonly id="cutting_lose_percentage" class="form-control cutting_lose_percentage m-input" maskedformat="9,1" autocomplete="off" name="cutting_lose_percentage'+product_row+'[]" type="text">\n') +
											'\n' +
											'                                                                <input style="border: 0;outline: none;" readonly type="text" class="measure-unit">\n' +
											'\n' +
											'                                                               </div>\n' +
											'\n' +
											'                                                            </div>\n' +
											'\n' +
											'                                                            <div class="attribute item5 m2_box" style="width: 10%;display: none;">\n' +
											'\n' +
											'                       									 	<div class="m-box">\n' +
											'\n' +
											'                                                                <input style="border: 1px solid #ccc;background: transparent;" class="form-control total_boxes m-input" autocomplete="off" name="total_boxes'+product_row+'[]" maskedformat="9,1" type="text">\n' +
											'\n' +
											'                                                                <input style="border: 0;outline: none;" readonly type="text" class="measure-unit">\n' +
											'\n' +
											'                                                               </div>\n' +
											'\n' +
											'                                                            </div>\n' +
											'\n' +
											'                                                            <div class="attribute item5 m1_box" style="width: 10%;">\n' +
											'\n' +
											'                       									 	<div style="display: flex;align-items: center;">\n' +
											'\n' +
											'                                                                <select style="border-radius: 5px;width: 70%;height: 35px;" readonly class="form-control turn" name="turn'+product_row+'[]">\n' +
											'\n' +
											'                                                                	<option value="0">{{__('text.No')}}</option>\n' +
											'                                                                	<option disabled value="1">{{__('text.Yes')}}</option>\n' +
											'\n' +
											'                                                                </select>\n' +
											'\n' +
											'                                                               </div>\n' +
											'\n' +
											'                                                            </div>\n' +
											'\n' +
											'                                                            <div class="attribute item6 m1_box" style="width: 10%;">\n' +
											'\n' +
											'                       									 	<div style="display: flex;align-items: center;">\n' +
											'\n' +
											(i != total_rows ? '<input type="number" value="'+ max_width +'" name="max_width'+product_row+'[]" readonly="" style="border: 1px solid #ccc;background: transparent;" class="form-control max_width res-white m-input">\n' : '<input type="number" name="max_width'+product_row+'[]" readonly="" style="border: 1px solid #ccc;background: transparent;" class="form-control max_width res-white m-input">\n') +
											'\n' +
											'                                                               </div>\n' +
											'\n' +
											'                                                            </div>\n' +
											'\n' +
											'                                                            <div class="attribute item6 m2_box" style="width: 10%;display: none;">\n' +
											'\n' +
											'                       									 	<div class="m-box">\n' +
											'\n' +
											'                                                                <input style="border: 1px solid #ccc;background: transparent;" class="form-control box_quantity_supplier m-input" readonly autocomplete="off" name="box_quantity_supplier'+product_row+'[]" type="number">\n' +
											'\n' +
											'                                                                <input style="border: 0;outline: none;" readonly type="text" class="measure-unit">\n' +
											'\n' +
											'                                                               </div>\n' +
											'\n' +
											'                                                            </div>\n' +
											'\n' +
											'                                                            <div class="attribute item7" style="width: 10%;">\n' +
											'\n' +
											'                       									 	<div style="display: flex;align-items: center;">\n' +
											'\n' +
											'                                                                <input type="number" value="'+ total +'" name="box_quantity'+product_row+'[]" readonly="" style="border: 1px solid #ccc;background: transparent;" class="form-control box_quantity res-white m-input">\n' +
											'\n' +
											'                                                               </div>\n' +
											'\n' +
											'                                                            </div>\n' +
											'\n' +
											'                                                            <div class="attribute item8 last-content" style="padding: 0;width: 18%;">\n' +
											'                                                            </div>\n' +
											'\n' +
											'                                                        </div>';
								}

								$(`.attributes_table[data-id='${product_row}']`).append(content);

							}
						}
						else
						{
							if(max_width > parseFloat(height))
							{
								var total_boxes = (parseFloat(width) + parseInt(cutting_lose_percentage))/100;
								total_boxes = (Math.round(total_boxes * 10)) / 10;
								total_boxes = parseFloat(total_boxes).toFixed(2);

								$('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.box_quantity').val(total_boxes);
								$('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('#height').css('background-color','');
								$('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('#width').css('background-color','#90ee90');
							}
							else
							{
								if(max_width == 0)
								{
									var total_rows = 0;
								}
								else
								{
									var total_rows = height/max_width;
									total_rows = Math.ceil(total_rows);
								}

								$('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.box_quantity').val('');
								$('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('#height').css('background-color','');
								$('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('#width').css('background-color','#90ee90');
								var content = '';
								var height_array = [];

								for(i = 0; i <= total_rows; i++)
								{
									if(i != total_rows)
									{
										var total = (parseFloat(width) + parseInt(cutting_lose_percentage))/100;
										total = (Math.round(total * 10)) / 10;
										total = parseFloat(total).toFixed(2);
									}
									else
									{
										var total = 0;
									}

									if(i == 0)
									{
										if(parseFloat(retailer_height) < max_width)
										{
											height = retailer_height;
										}
										else
										{
											height = max_width;
										}
										height_array[i] = height;
									}
									else
									{
										if(i == total_rows)
										{
											height = max_width - parseFloat(height_array[height_array.length-1]);
										}
										else
										{
											height = parseFloat(org_height) - parseFloat(height_array[height_array.length-1]);

											if(height > max_width)
											{
												height = max_width
											}
											else if(height == 0)
											{
												var sum = 0;

												for (j = 0; j < height_array.length; j++) {

													sum = sum + parseFloat(height_array[j]);

												}

												height = parseFloat(retailer_height) - parseFloat(sum);
											}
										}

										org_height = height_array[height_array.length-1];
										height_array[i] = height;
									}

									width = parseFloat(width).toFixed(2);
									width = width.replace(/\./g, ',');
									height = parseFloat(height).toFixed(2);
									height = height.replace(/\./g, ',');

									// var rowCount = $(`.attributes_table[data-id='${product_row}']`).find('.attribute-content-div:last').data('id');
									// rowCount = rowCount + 1;

									content =  content + '<div class="attribute-content-div" data-id="'+row_id+'.'+(i+1)+'" data-main-id="'+ row_id +'">\n' +
											'\n' +
											'                                                            <div class="attribute full-res item1" style="width: 22%;">\n' +
											'                       									 	<div style="display: flex;align-items: center;"><input type="hidden" class="calculator_row" name="calculator_row'+product_row+'[]" value="'+row_id+'.'+(i+1)+'"><span style="width: 10%">'+row_id+'.'+(i+1)+'</span><div style="width: 90%;"><textarea class="form-control attribute_description" style="width: 90%;border-radius: 7px;resize: vertical;height: 40px;outline: none;" name="attribute_description'+product_row+'[]">'+ (i != total_rows ? description : 'Restant rol') +'</textarea></div></div>\n' +
											'                       									 </div>\n' +
											'\n' +
											'                                                            <div class="attribute item2 width-box" style="width: 10%;">\n' +
											'\n' +
											'                       									 	<div class="m-box">\n' +
											'\n' +
											'                                                                <input style="border: 1px solid #ccc;" readonly value="'+ width +'" id="width" class="form-control width m-input" maskedformat="9,1" autocomplete="off" name="width'+product_row+'[]" type="text">\n' +
											'\n' +
											'                                                                <input style="border: 0;outline: none;" value="cm" readonly="" type="text" name="width_unit'+product_row+'[]" class="measure-unit">\n' +
											'\n' +
											'                                                               </div>\n' +
											'\n' +
											'                                                            </div>\n' +
											'\n' +
											'                                                            <div class="attribute item3 height-box" style="width: 10%;">\n' +
											'\n' +
											'                       									 	<div class="m-box">\n' +
											'\n' +
											'                                                                <input style="border: 1px solid #ccc;" readonly value="'+ height +'" id="height" class="form-control height m-input" maskedformat="9,1" autocomplete="off" name="height'+product_row+'[]" type="text">\n' +
											'\n' +
											'                                                                <input style="border: 0;outline: none;" value="cm" readonly="" type="text" name="height_unit'+product_row+'[]" class="measure-unit">\n' +
											'\n' +
											'                                                               </div>\n' +
											'\n' +
											'                                                            </div>\n' +
											'\n' +
											'                                                            <div class="attribute item4" style="width: 10%;">\n' +
											'\n' +
											'                       									 	<div class="m-box">\n' +
											'\n' +
											(i != total_rows ? '<input style="border: 1px solid #ccc;" readonly value="'+ cutting_lose_percentage +'" id="cutting_lose_percentage" class="form-control cutting_lose_percentage m-input" maskedformat="9,1" autocomplete="off" name="cutting_lose_percentage'+product_row+'[]" type="text">\n' : '<input style="border: 1px solid #ccc;" readonly id="cutting_lose_percentage" class="form-control cutting_lose_percentage m-input" maskedformat="9,1" autocomplete="off" name="cutting_lose_percentage'+product_row+'[]" type="text">\n') +
											'\n' +
											'                                                                <input style="border: 0;outline: none;" readonly type="text" class="measure-unit">\n' +
											'\n' +
											'                                                               </div>\n' +
											'\n' +
											'                                                            </div>\n' +
											'\n' +
											'                                                            <div class="attribute item5 m2_box" style="width: 10%;display: none;">\n' +
											'\n' +
											'                       									 	<div class="m-box">\n' +
											'\n' +
											'                                                                <input style="border: 1px solid #ccc;background: transparent;" class="form-control total_boxes m-input" autocomplete="off" name="total_boxes'+product_row+'[]" maskedformat="9,1" type="text">\n' +
											'\n' +
											'                                                                <input style="border: 0;outline: none;" readonly type="text" class="measure-unit">\n' +
											'\n' +
											'                                                               </div>\n' +
											'\n' +
											'                                                            </div>\n' +
											'\n' +
											'                                                            <div class="attribute item5 m1_box" style="width: 10%;">\n' +
											'\n' +
											'                       									 	<div style="display: flex;align-items: center;">\n' +
											'\n' +
											'                                                                <select style="border-radius: 5px;width: 70%;height: 35px;" readonly class="form-control turn" name="turn'+product_row+'[]">\n' +
											'\n' +
											'                                                                	<option disabled value="0">{{__('text.No')}}</option>\n' +
											'                                                                	<option value="1">{{__('text.Yes')}}</option>\n' +
											'\n' +
											'                                                                </select>\n' +
											'\n' +
											'                                                               </div>\n' +
											'\n' +
											'                                                            </div>\n' +
											'\n' +
											'                                                            <div class="attribute item6 m1_box" style="width: 10%;">\n' +
											'\n' +
											'                       									 	<div style="display: flex;align-items: center;">\n' +
											'\n' +
											(i != total_rows ? '<input type="number" value="'+ max_width +'" name="max_width'+product_row+'[]" readonly="" style="border: 1px solid #ccc;background: transparent;" class="form-control max_width res-white m-input">\n' : '<input type="number" name="max_width'+product_row+'[]" readonly="" style="border: 1px solid #ccc;background: transparent;" class="form-control max_width res-white m-input">\n') +
											'\n' +
											'                                                               </div>\n' +
											'\n' +
											'                                                            </div>\n' +
											'\n' +
											'                                                            <div class="attribute item6 m2_box" style="width: 10%;display: none;">\n' +
											'\n' +
											'                       									 	<div class="m-box">\n' +
											'\n' +
											'                                                                <input style="border: 1px solid #ccc;background: transparent;" class="form-control box_quantity_supplier m-input" readonly autocomplete="off" name="box_quantity_supplier'+product_row+'[]" type="number">\n' +
											'\n' +
											'                                                                <input style="border: 0;outline: none;" readonly type="text" class="measure-unit">\n' +
											'\n' +
											'                                                               </div>\n' +
											'\n' +
											'                                                            </div>\n' +
											'\n' +
											'                                                            <div class="attribute item7" style="width: 10%;">\n' +
											'\n' +
											'                       									 	<div style="display: flex;align-items: center;">\n' +
											'\n' +
											'                                                                <input type="number" value="'+ total +'" name="box_quantity'+product_row+'[]" readonly="" style="border: 1px solid #ccc;background: transparent;" class="form-control box_quantity res-white m-input">\n' +
											'\n' +
											'                                                               </div>\n' +
											'\n' +
											'                                                            </div>\n' +
											'\n' +
											'                                                            <div class="attribute item8 last-content" style="padding: 0;width: 18%;">\n' +
											'                                                            </div>\n' +
											'\n' +
											'                                                        </div>';
								}

								$(`.attributes_table[data-id='${product_row}']`).append(content);

							}
						}
					}
					else
					{
						$('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.box_quantity').val('');
					}
				}
				else
				{
					var box_quantity = $('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.box_quantity_supplier').val();

					if(cutting_change != 0)
					{
						if(total_quantity)
							{
								if(box_quantity && cutting_lose_percentage)
								{
									var total_quantity = parseInt(total_quantity) * ((100 + parseInt(cutting_lose_percentage))/100);
									console.log(total_quantity);
									total_quantity = Math.round(parseFloat(total_quantity).toFixed(2));
									var total_boxes = total_quantity/box_quantity;
									total_boxes = Math.round(parseFloat(total_boxes).toFixed(2));
								}
								else
								{
									$('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.box_quantity').val('');
									$('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.total_boxes').val('');
								}
							}
							else
							{
								if(width && height && box_quantity && cutting_lose_percentage)
								{
									var total_quantity = ((width/100) * (height/100) * (1 + (cutting_lose_percentage/100)));
									total_quantity = Math.round(parseFloat(total_quantity).toFixed(2));
									var total_boxes = total_quantity/box_quantity;
									total_boxes = Math.round(parseFloat(total_boxes).toFixed(2));
									total_quantity = total_boxes * box_quantity;
									total_quantity = ~~total_quantity;
								}
								else
								{
									$('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.box_quantity').val('');
									$('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.total_boxes').val('');
								}
							}
							
							$('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.total_boxes').val(total_quantity);
							$('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.box_quantity').val(total_boxes);
					}
					else
					{
						if(box_quantity && total_quantity)
						{
							var total_boxes = total_quantity/box_quantity;
							total_boxes = Math.round(parseFloat(total_boxes).toFixed(2));

							$('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.box_quantity').val(total_boxes);
						}
						else
						{
							$('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.box_quantity').val('');
							$('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.total_boxes').val('');
						}
					}
				}

				calculate_qty(product_row);
			}

			$(document).on('input', ".width, .height", function (e) {

				var current = $(this);
				var product_row = current.parents(".attributes_table").data('id');
				var row_id = current.parents(".attribute-content-div").data('id');

				calculator(product_row,row_id);

			});

			$(document).on('input', ".cutting_lose_percentage", function (e) {

				var current = $(this);
				var product_row = current.parents(".attributes_table").data('id');
				var row_id = current.parents(".attribute-content-div").data('id');

				calculator(product_row,row_id,1,0);

			});

			$(document).on('input', ".total_boxes", function (e) {

				var current = $(this);
				var product_row = current.parents(".attributes_table").data('id');
				var row_id = current.parents(".attribute-content-div").data('id');

				calculator(product_row,row_id,0,1);

			});

			$(document).on('change', ".turn", function (e) {

				var current = $(this);
				var product_row = current.parents(".attributes_table").data('id');
				var row_id = current.parents(".attribute-content-div").data('id');

				calculator(product_row,row_id);

			});

			function calculate_qty(product_row)
			{
				var total_qty = 0;

				$('#menu2').find(`.attributes_table[data-id='${product_row}']`).find('.box_quantity').each(function (i, obj) {

					var qty = 0;

					if($(obj).val())
					{
						qty = $(obj).val();
					}

					total_qty = parseFloat(total_qty) + parseFloat(qty);
					total_qty = total_qty.toFixed(2);

				});

				total_qty = total_qty.replace(/\./g, ',');

				$("#products_table").find(`.content-div[data-id='${product_row}']`).find('.qty').val(total_qty);

				calculate_total(1,0);
			}

			// $(document).on('input', '.labor_impact', function () {

			// 	var value = $(this).val();
			// 	value = value.replace(/\,/g, '.');
			// 	var row_id = $(this).parents(".content-div").data('id');
			// 	var price_before_labor = $('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val();
			// 	price_before_labor = price_before_labor.replace(/\,/g, '.');
			// 	var qty = $('#menu1').find(`[data-id='${row_id}']`).find('input[name="qty[]"]').val();
			// 	var total_discount = $('#products_table').find(`[data-id='${row_id}']`).find('.total_discount').val();
			// 	total_discount = total_discount.replace(/\,/g, '.');

			// 	if (!value) {
			// 		value = 0;
			// 	}

			// 	var total = parseFloat(price_before_labor) + parseFloat(value);
			// 	total = total + parseFloat(total_discount);
			// 	total = parseFloat(total);
			// 	total = total.toFixed(2);
			// 	var price = total;
			// 	total = total / qty;
			// 	total = parseFloat(total).toFixed(2);
			// 	//total = Math.round(total);

			// 	var new_old_value = value / qty;
			// 	new_old_value = parseFloat(new_old_value).toFixed(2);

			// 	$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val(new_old_value);
			// 	$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('€ ' + total.replace(/\./g, ','));
			// 	$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val(price);
			// 	$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val(total);

			// 	calculate_total(0,1);

			// });

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

						$('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-question-box').find('.childsafe-select').append('<option value="1" selected>Please note not childsafe</option><option value="2">Add childsafety clip</option>');

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

						$('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-question-box').find('.childsafe-select').append('<option value="2">Add childsafety clip</option><option value="3" selected>Yes childsafe</option>');

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
				var product_id = $('#products_table').find(`[data-id='${row_id}']`).find('.products').find('select').val();
				var ladderband_value = $('#products_table').find(`[data-id='${row_id}']`).find('#ladderband_value').val();
				var ladderband_price_impact = $('#products_table').find(`[data-id='${row_id}']`).find('#ladderband_price_impact').val();
				var ladderband_impact_type = $('#products_table').find(`[data-id='${row_id}']`).find('#ladderband_impact_type').val();

				var impact_value = current.next('input').val();
				var total = $('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val();
				var basic_price = $('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val();
				var margin = 1;
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
								impact_value = parseFloat(impact_value).toFixed(2);
								total = parseFloat(total) + parseFloat(impact_value);
								total = total.toFixed(2);
							}
							else {
								impact_value = ladderband_value;
								var per = (impact_value) / 100;
								impact_value = basic_price * per;
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
								var opt = '<option value="0">Select Feature</option>';

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

							current.parent().find('.f_area').val(0);

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

			function select_product(current,product_id,model_id,color_id,supplier_id,row_id,measure,box_quantity,max_width,quote_qty = 1)
			{
				$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(0);

				if(product_id.includes('S'))
				{
					var org_product_id = product_id;
					product_id = product_id.replace('S', '');
					var type = 'service';
				}
				else if(product_id.includes('I'))
				{
					var org_product_id = product_id;
					product_id = product_id.replace('I', '');
					var type = 'item';
				}
				else
				{
					var org_product_id = product_id;
					var type = 'product';
				}

				$.ajax({
					type: "GET",
					data: "id=" + product_id + "&model=" + model_id + "&type=" + type,
					url: "<?php echo url('/aanbieder/get-colors')?>",
					success: function (data) {

						current.parents('.products').find('#product_id').val(org_product_id);
						current.parents('.products').find('#supplier_id').val(supplier_id);
						current.parents('.products').find('#color_id').val(color_id);
						current.parents('.products').find('#model_id').val(model_id);

						$('#menu1').find(`[data-id='${row_id}']`).remove();

						if (data != '') {

							if(type == 'product')
							{
								if(data.measure == 'M2')
								{
									$('#menu2').find(`.attributes_table[data-id='${row_id}']`).find('.m1_box').hide();
									$('#menu2').find(`.attributes_table[data-id='${row_id}']`).find('.m2_box').show();
								}
								else
								{
									$('#menu2').find(`.attributes_table[data-id='${row_id}']`).find('.m2_box').hide();
									$('#menu2').find(`.attributes_table[data-id='${row_id}']`).find('.m1_box').show();
								}

								if(data.estimated_price_per_box)
								{
									var estimated_price_per_box = data.estimated_price_per_box;
									estimated_price_per_box = estimated_price_per_box.replace(/\./g, ',');
									var estimated_price_per_box_old = data.estimated_price_per_box;
								}
								else
								{
									var estimated_price_per_box = 0;
									var estimated_price_per_box_old = 0;
								}

								if(data.max_width == null)
								{
									data.max_width = 0;
								}

								$('#products_table').find(`[data-id='${row_id}']`).find('#max_width').val(data.max_width);
								$('#products_table').find(`[data-id='${row_id}']`).find('#measure').val(data.measure);
								$('#products_table').find(`[data-id='${row_id}']`).find('.discount-box').find('.discount_values').val(0);
								// $('#products_table').find(`[data-id='${row_id}']`).find('.labor-discount-box').find('.labor_discount_values').val(0);
								$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount').val(0);
								$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount_old').val(0);
								$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val(estimated_price_per_box);
								$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val(estimated_price_per_box_old);
								// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
								// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('#delivery_days').val(data.delivery_days);
								$('#products_table').find(`[data-id='${row_id}']`).find('#ladderband').val(data.ladderband);
								$('#products_table').find(`[data-id='${row_id}']`).find('#ladderband_value').val(data.ladderband_value);
								$('#products_table').find(`[data-id='${row_id}']`).find('#ladderband_price_impact').val(data.ladderband_price_impact);
								$('#products_table').find(`[data-id='${row_id}']`).find('#ladderband_impact_type').val(data.ladderband_impact_type);
								$('#products_table').find(`[data-id='${row_id}']`).find('#base_price').val(data.base_price);
								$('#products_table').find(`[data-id='${row_id}']`).find('#estimated_price_quantity').val(data.estimated_price_quantity);
								$('#menu2').find(`.attributes_table[data-id='${row_id}']`).find('.box_quantity_supplier').val(data.estimated_price_quantity);
								$('#menu2').find(`.attributes_table[data-id='${row_id}']`).find('.max_width').val(data.max_width);
								$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('');
								$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val('');
								$('#myModal2').find(`.comment-boxes[data-id='${row_id}']`).remove();
								$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('€ ' + estimated_price_per_box);
								$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val(estimated_price_per_box_old);
								$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val(estimated_price_per_box_old);

								var model = model_id;
								var color = color_id;
								var base_price = $('#products_table').find(`[data-id='${row_id}']`).find('#base_price').val();

								var product = product_id;
								var ladderband = $('#products_table').find(`[data-id='${row_id}']`).find('#ladderband').val();
								$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(0);

								if (color && model && product) {

									var margin = 1;

									$('#products_table').find(`[data-id='${row_id}']`).find('.discount-box').find('.discount_values').val(0);
									// $('#products_table').find(`[data-id='${row_id}']`).find('.labor-discount-box').find('.labor_discount_values').val(0);
									$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount').val(0);
									$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount_old').val(0);

									$.ajax({
										type: "GET",
										data: "product=" + product + "&color=" + color + "&model=" + model + "&margin=" + margin + "&type=floors",
										url: "<?php echo url('/aanbieder/get-price')?>",
										success: function (data) {

											$('#myModal2').find(`.comment-boxes[data-id='${row_id}']`).remove();

											$('#products_table').find(`[data-id='${row_id}']`).find('#childsafe').val(data[3].childsafe);
											var childsafe = data[3].childsafe;

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

											$('#menu1').append('<div data-id="' + row_id + '" style="margin: 0;" class="form-group">' + features + '</div>');

											current.parents('.content-div').find('.f_area').val(0);
										}
									});
								}
								else
								{
									$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').hide();
									$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').css('visibility','visible');
									$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').show();
								}

								if($('#request_quotation').val() == 0)
								{
									if(data.measure != measure)
									{
										$('#menu2').find(`.attributes_table[data-id='${row_id}']`).find('.attribute-content-div').remove();
										add_attribute_row(false, row_id);
										$('#products_table').find(`[data-id='${row_id}']`).find('.qty').val(quote_qty);
									}
									else
									{
										if(measure == 'M1')
										{
											if(max_width != data.max_width)
											{
												$('#menu2').find(`.attributes_table[data-id='${row_id}']`).find(`.attribute-content-div[data-main-id='0']`).each(function (i, obj) {

													$(this).find('.max_width').val(data.max_width);
													var row = $(this).data('id');
													calculator(row_id,row);

												});
											}
										}
										else if(measure == 'M2')
										{
											if(box_quantity != data.estimated_price_quantity)
											{
												$('#menu2').find(`.attributes_table[data-id='${row_id}']`).find(`.attribute-content-div[data-main-id='0']`).each(function (i, obj) {

													$(this).find('.box_quantity_supplier').val(data.estimated_price_quantity);
													var row = $(this).data('id');
													calculator(row_id,row);

												});
											}
										}
									}
								}
								else
								{
									$('#products_table').find(`[data-id='${row_id}']`).find('.qty').val(quote_qty);
								}
							}
							else
							{
								if(data.sell_rate)
								{
									var estimated_price_per_box = parseFloat(data.sell_rate).toFixed(2);
									estimated_price_per_box = estimated_price_per_box.replace(/\./g, ',');
									var estimated_price_per_box_old = data.sell_rate;
								}
								else
								{
									var estimated_price_per_box = 0;
									var estimated_price_per_box_old = 0;
								}

								$('#products_table').find(`[data-id='${row_id}']`).find('.qty').val(quote_qty);
								$('#products_table').find(`[data-id='${row_id}']`).find('#max_width').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('#measure').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('.discount-box').find('.discount_values').val(0);
								// $('#products_table').find(`[data-id='${row_id}']`).find('.labor-discount-box').find('.labor_discount_values').val(0);
								$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount').val(0);
								$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount_old').val(0);
								$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val(estimated_price_per_box);
								$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val(estimated_price_per_box_old);
								// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
								// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('#delivery_days').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('#ladderband').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('#ladderband_value').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('#ladderband_price_impact').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('#ladderband_impact_type').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('#estimated_price_quantity').val('');
								$('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val('');
								$('#myModal2').find(`.comment-boxes[data-id='${row_id}']`).remove();
								$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('€ ' + estimated_price_per_box);
								$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val(estimated_price_per_box_old);
								$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val(estimated_price_per_box_old);
								$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(0);
								$('#products_table').find(`[data-id='${row_id}']`).find('#childsafe').val('');
								$('#myModal').find('.modal-body').find(`[data-id='${row_id}']`).remove();
								$('#menu1').find(`[data-id='${row_id}']`).remove();
								$('#menu2').find(`.attributes_table[data-id='${row_id}']`).find('.attribute-content-div').remove();

							}

							calculate_total();
						}

						var windowsize = $(window).width();

						if (windowsize > 992) {

							$('#products_table').find(`[data-id='${row_id}']`).find('.collapse').collapse('show');

						}

					}
				});

				if(type != 'product')
				{
					$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').hide();
					$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').css('visibility','visible');
					$('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').show();
				}
			}

			function autocomplete(inp, arr, values, model_ids, color_ids, supplier_ids) {
				/*the autocomplete function takes two arguments,
                the text field element and an array of possible autocompleted values:*/
				var currentFocus;
				/*execute a function when someone writes in the text field:*/
				inp.addEventListener("input", function(e) {

					var current = $(this);
					var a, b, i, val = this.value;
					/*close any already open lists of autocompleted values*/
					closeAllLists();
					if (!val) { return false;}
					currentFocus = -1;
					/*create a DIV element that will contain the items (values):*/
					a = document.createElement("DIV");
					a.setAttribute("id", this.id + "autocomplete-list");
					a.setAttribute("class", "autocomplete-items");
					/*append the DIV element as a child of the autocomplete container:*/
					this.parentNode.appendChild(a);

					var border_flag = 0;
					var found_flag = 0;

					if(arr.length == 0)
					{
						border_flag = 1;
					}

					/*for each item in the array...*/
					for (i = 0; i < arr.length; i++) {

						var string = arr[i];
						string = string.toLowerCase();
						val = val.toLowerCase();
						var res = string.includes(val);

						if (res) {

							found_flag = 1;

							/*create a DIV element for each matching element:*/
							b = document.createElement("DIV");
							/*make the matching letters bold:*/
							/*b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                            b.innerHTML += arr[i].substr(val.length);*/
							b.innerHTML = arr[i];
							/*insert a input field that will hold the current array item's value:*/
							b.innerHTML += "<input type='hidden' value='" + arr[i] + "'><input type='hidden' value='" + values[i] + "'><input type='hidden' value='" + model_ids[i] + "'><input type='hidden' value='" + color_ids[i] + "'><input type='hidden' value='" + supplier_ids[i] + "'>";
							/*execute a function when someone clicks on the item value (DIV element):*/
							b.addEventListener("click", function(e) {

								/*insert the value for the autocomplete text field:*/
								inp.value = this.getElementsByTagName("input")[0].value;
								var product_id = this.getElementsByTagName("input")[1].value;
								var model_id = this.getElementsByTagName("input")[2].value;
								var color_id = this.getElementsByTagName("input")[3].value;
								var supplier_id = this.getElementsByTagName("input")[4].value;
								var row_id = current.parents(".content-div").data('id');
								var measure = current.parents(".content-div").find('#measure').val();
								var box_quantity = current.parents(".content-div").find('#estimated_price_quantity').val();
								var max_width = current.parents(".content-div").find('#max_width').val();

								select_product(current,product_id,model_id,color_id,supplier_id,row_id,measure,box_quantity,max_width);

								/*close the list of autocompleted values,
                                (or any other open lists of autocompleted values:*/
								closeAllLists();
							});
							a.appendChild(b);
						}
					}

					if(border_flag || !found_flag)
					{
						a.style.border = "0";
					}
				});
				/*execute a function presses a key on the keyboard:*/
				inp.addEventListener("keydown", function(e) {
					var x = document.getElementById(this.id + "autocomplete-list");
					if (x) x = x.getElementsByTagName("div");
					if (e.keyCode == 40) {
						/*If the arrow DOWN key is pressed,
                        increase the currentFocus variable:*/
						currentFocus++;
						/*and and make the current item more visible:*/
						addActive(x);
					} else if (e.keyCode == 38) { //up
						/*If the arrow UP key is pressed,
                        decrease the currentFocus variable:*/
						currentFocus--;
						/*and and make the current item more visible:*/
						addActive(x);
					} else if (e.keyCode == 13) {
						/*If the ENTER key is pressed, prevent the form from being submitted,*/
						e.preventDefault();
						if (currentFocus > -1) {
							/*and simulate a click on the "active" item:*/
							if (x) x[currentFocus].click();
						}
					}
				});
				function addActive(x) {
					/*a function to classify an item as "active":*/
					if (!x) return false;
					/*start by removing the "active" class on all items:*/
					removeActive(x);
					if (currentFocus >= x.length) currentFocus = 0;
					if (currentFocus < 0) currentFocus = (x.length - 1);
					/*add class "autocomplete-active":*/
					x[currentFocus].classList.add("autocomplete-active");
				}
				function removeActive(x) {
					/*a function to remove the "active" class from all autocomplete items:*/
					for (var i = 0; i < x.length; i++) {
						x[i].classList.remove("autocomplete-active");
					}
				}
				function closeAllLists(elmnt) {
					/*close all autocomplete lists in the document,
                    except the one passed as an argument:*/
					var x = document.getElementsByClassName("autocomplete-items");
					for (var i = 0; i < x.length; i++) {
						if (elmnt != x[i] && elmnt != inp) {
							x[i].parentNode.removeChild(x[i]);
						}
					}
				}
				/*execute a function when someone clicks in the document:*/
				document.addEventListener("click", function (e) {
					closeAllLists(e.target);
				});
			}

			product_ids = [];
			product_titles = [];
			model_ids = [];
			color_ids = [];
			supplier_ids = [];

			var sel = $(".all-products");
			var length = sel.children('option').length;

			$(".all-products:first > option").each(function() {
				if (this.value) product_ids.push(this.value); product_titles.push(this.text); model_ids.push(this.getAttribute('data-model-id')); color_ids.push(this.getAttribute('data-color-id')); supplier_ids.push(this.getAttribute('data-supplier-id'));
			});

			var cls = document.getElementsByClassName("quote-product");
			for (n=0, length = cls.length; n < length; n++) {
				autocomplete(cls[n], product_titles, product_ids, model_ids, color_ids, supplier_ids);
			}

		});
	</script>

	<link href="{{asset('assets/admin/css/main.css')}}" rel="stylesheet">
	<link href="{{asset('assets/admin/css/bootstrap-tagsinput.css')}}" rel="stylesheet">

@endsection
