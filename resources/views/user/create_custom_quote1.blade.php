@extends('layouts.handyman')

@section('content')

<div class="right-side">

	<div class="container-fluid">
		<div class="row">

			<form id="form-quote" style="padding: 0;" class="form-horizontal" action=""
				method="POST" enctype="multipart/form-data">
				{{csrf_field()}}

				<input type="hidden" name="quotation_id" value="{{isset($invoice) ? $invoice[0]->invoice_id : null}}">

				<div style="margin: 0;" class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<!-- Starting of Dashboard data-table area -->
						<div class="section-padding add-product-1" style="padding: 0;">

							<div style="margin: 0;" class="row">
								<div style="padding: 0;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div style="box-shadow: none;" class="add-product-box">
										<div style="align-items: center;" class="add-product-header products">

											<h2 style="margin-top: 0;">{{isset($invoice) ? (Route::currentRouteName() == 'view-new-quotation' ? __('text.View Quotation') : __('text.View Invoice')) : __('text.Create Quotation')}}</h2>

											<div style="background-color: black;border-radius: 10px;padding: 0 10px;">

												@if((isset($invoice) && ($invoice[0]->status == 0 || $invoice[0]->status == 1 || $invoice[0]->ask_customization)) || !isset($invoice))

													<span class="tooltip1 save-data" style="cursor: pointer;font-size: 20px;margin-right: 10px;color: white;">
														<i class="fa fa-fw fa-save"></i>
														<span class="tooltiptext">Save</span>
													</span>

												@endif

												<a href="{{route('customer-quotations')}}" class="tooltip1" style="cursor: pointer;font-size: 20px;color: white;">
													<i class="fa fa-fw fa-close"></i>
													<span class="tooltiptext">Close</span>
												</a>

											</div>

										</div>

										<hr>

                                        <div class="row" style="margin: 20px 0px;border-bottom: 1px solid #f1f1f1;padding-bottom: 20px;">

                                            <div class="col-md-4 col-sm-4 col-xs-12 customer-details" style="float: left;text-align: left">

                                            </div>

                                            <div class="col-md-4 col-sm-4 col-xs-12" style="float: right;text-align: right;">

                                                <img class="img-fluid" src="{{ asset('assets/images/'.$user->photo) }}" style="width:50%; height:100%;margin-bottom: 30px;">

                                                <p style="margin: 0"><b>{{$user->name}} {{$user->family_name}}</b></p>
                                                <p style="margin: 0">{{$user->company_name}}</p>
                                                <p style="margin: 0">{{$user->address}}<?php if($user->city){ echo ', '.$user->city; } ?></p>
                                                <p style="margin: 0">TEL: {{$user->phone}}</p>
                                                <p style="margin: 0">{{$user->email}}</p>

                                            </div>

                                        </div>

											<div class="col-md-5">
												<div class="form-group" style="margin: 0;">

												@if((isset($invoice) && ($invoice[0]->status == 0 || $invoice[0]->status == 1 || $invoice[0]->ask_customization)) || !isset($invoice))

												@else

													<label>Customer</label>

												@endif

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

														@if((isset($invoice) && ($invoice[0]->status == 0 || $invoice[0]->status == 1 || $invoice[0]->ask_customization)) || !isset($invoice))

															<button type="button" href="#myModal1" role="button" data-toggle="modal" style="outline: none;margin-left: 10px;" class="btn btn-primary">{{__('text.Add New Customer')}}</button>

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
                                                                <div class="headings" style="width: 12%;" @if(auth()->user()->role_id == 4) style="display: none;" @endif>Supplier</div>
																<div class="headings" style="width: 22%;">Product</div>
																<div class="headings" style="width: 10%;">Width</div>
																<div class="headings" style="width: 10%;">Height</div>
																<div class="headings" style="width: 7%;">Qty</div>
																<div class="headings" style="width: 7%;">€ Art.</div>
																<div class="headings" style="width: 10%;">Discount</div>
																<div class="headings" style="width: 7%;">€ Total</div>
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
																	<input type="hidden" value="" id="estimated_price_quantity" name="estimated_price_quantity[]">
																	<input type="hidden" value="" id="width_unit" name="width_unit[]">
																	<input type="hidden" value="" id="height_unit" name="height_unit[]">

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

																		<label class="content-label">Qty</label>

																		<div style="display: flex;align-items: center;">
																			<input type="text" value="{{str_replace('.', ',',floatval($item->qty))}}" maskedformat="9,1" name="qty[]" style="border: 0;background: transparent;padding: 0 5px;" class="form-control qty res-white">
																		</div>
                                                                    </div>
																	
																	<div class="content item6" style="width: 7%;">

																		<label class="content-label">€ Art.</label>

																		<div style="display: flex;align-items: center;">
																			<input type="text" value="{{str_replace('.', ',',floatval($item->price_before_labor))}}" readonly name="price_before_labor[]" style="border: 0;background: transparent;padding: 0 5px;" class="form-control price_before_labor res-white">
																			<input type="hidden" value="{{$item->price_before_labor/$item->qty}}" class="price_before_labor_old">
																		</div>
                                                                    </div>

																	<div class="content item8" style="width: 10%;">

																		<label class="content-label">Discount</label>

																		<input type="text" value="{{$item->total_discount}}" name="total_discount[]" readonly style="border: 0;background: transparent;padding: 0 5px;height: 30px;" class="form-control total_discount res-white">
																		<input type="hidden" value="{{$item->total_discount/$item->qty}}" class="total_discount_old">
                                                                    </div>

																	<div style="width: 7%;" class="content item9">

																		<label class="content-label">€ Total</label>
																		<div class="price res-white">€ {{str_replace('.', ',',floatval($item->rate))}}</div>

																	</div>

																	<div class="content item10 last-content" id="next-row-td" style="padding: 0;width: 13%;">

																		@if((isset($invoice) && ($invoice[0]->status == 0 || $invoice[0]->status == 1 || $invoice[0]->ask_customization)) || !isset($invoice))

																			<div class="res-white" style="display: flex;justify-content: flex-end;align-items: center;width: 100%;">

																				<div style="display: none;" class="green-circle tooltip1">
                                                                                	<span style="top: 45px;left: -40px;" class="tooltiptext">ALL features selected!</span>
                                                                            	</div>
                                                                            	
																				<div style="visibility: hidden;" class="yellow-circle tooltip1">
                                                                                	<span style="top: 45px;left: -40px;" class="tooltiptext">Select all features!</span>
                                                                            	</div>

																				<span id="next-row-span" class="tooltip1 add-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;width: 20px;height: 20px;line-height: 20px;">
																					<i id="next-row-icon" class="fa fa-fw fa-plus"></i>
																					<span class="tooltiptext">Add</span>
																				</span>

																				<span id="next-row-span" class="tooltip1 remove-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;width: 20px;height: 20px;line-height: 20px;">
																					<i id="next-row-icon" class="fa fa-fw fa-trash-o"></i>
																					<span class="tooltiptext">Remove</span>
																				</span>

																				<span id="next-row-span" class="tooltip1 copy-row" style="cursor: pointer;font-size: 20px;margin: 0 10px;width: 20px;height: 20px;line-height: 20px;">
																					<i id="next-row-icon" class="fa fa-fw fa-copy"></i>
																					<span class="tooltiptext">Copy</span>
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

                                                                            <label>Color</label>

																		    <select name="colors[]" class="js-data-example-ajax2">

																			    <option value=""></option>

																				@foreach($colors[$i] as $color)

																				<option {{$color->id == $item->color ? 'selected' : null}} value="{{$color->id}}">{{$color->title}}</option>

																				@endforeach

																		    </select>

                                                                        </div>

                                                                        <div style="width: 25%;margin-left: 10px;" class="model item13">

                                                                            <label>Model</label>

                                                                            <select name="models[]" class="js-data-example-ajax3">

																			    <option value=""></option>

																				@foreach($models[$i] as $model)

																				<option {{$model->id == $item->model_id ? 'selected' : null}} value="{{$model->id}}">{{$model->model}}</option>

																				@endforeach

																		    </select>

                                                                            <input type="hidden" class="model_impact_value" name="model_impact_value[]" value="{{$item->model_impact_value}}">

                                                                        </div>

                                                                        <div style="width: 25%;margin-left: 10px;" class="discount-box item14">

                                                                            <label>Discount % </label>

                                                                            <input style="height: 35px;border-radius: 4px;" placeholder="Enter discount in percentage" type="text" class="form-control discount_values" value="{{$item->discount}}" name="discount[]">

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
																	<input type="hidden" id="estimated_price_quantity" name="estimated_price_quantity[]">
																	<input type="hidden" id="width_unit" name="width_unit[]">
																	<input type="hidden" id="height_unit" name="height_unit[]">

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

																		<label class="content-label">Qty</label>

																		<div style="display: flex;align-items: center;">
																			<input type="text" value="1" name="qty[]" maskedformat="9,1" style="border: 0;background: transparent;padding: 0 5px;" class="form-control qty res-white">
																		</div>
                                                                    </div>

																	<div class="content item6" style="width: 7%;">

																		<label class="content-label">€ Art.</label>

																		<div style="display: flex;align-items: center;">
																			<input type="text" value="0" readonly name="price_before_labor[]" style="border: 0;background: transparent;padding: 0 5px;" class="form-control price_before_labor res-white">
																			<input type="hidden" value="0" class="price_before_labor_old">
																		</div>
                                                                    </div>

																	<div class="content item8" style="width: 10%;">

																		<label class="content-label">Discount</label>

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
                                                                                <span style="top: 45px;left: -40px;" class="tooltiptext">ALL features selected!</span>
                                                                            </div>

                                                                            <div style="visibility: hidden;" class="yellow-circle tooltip1">
                                                                                <span style="top: 45px;left: -40px;" class="tooltiptext">Select all features!</span>
                                                                            </div>

																			<span id="next-row-span" class="tooltip1 add-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;width: 20px;height: 20px;line-height: 20px;">
																				<i id="next-row-icon" class="fa fa-fw fa-plus"></i>
																				<span class="tooltiptext">Add</span>
																			</span>

																			<span id="next-row-span" class="tooltip1 remove-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;width: 20px;height: 20px;line-height: 20px;">
																				<i id="next-row-icon" class="fa fa-fw fa-trash-o"></i>
																				<span class="tooltiptext">Remove</span>
																			</span>

																			<span id="next-row-span" class="tooltip1 copy-row" style="cursor: pointer;font-size: 20px;margin: 0 10px;width: 20px;height: 20px;line-height: 20px;">
																				<i id="next-row-icon" class="fa fa-fw fa-copy"></i>
																				<span class="tooltiptext">Copy</span>
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

                                                                            <label>Color</label>

																		    <select name="colors[]" class="js-data-example-ajax2">

																			    <option value=""></option>

																		    </select>

                                                                        </div>

                                                                        <div style="width: 25%;margin-left: 10px;" class="model item13">

                                                                            <label>Model</label>

                                                                            <select name="models[]" class="js-data-example-ajax3">

																			    <option value=""></option>

																		    </select>

                                                                            <input type="hidden" class="model_impact_value" name="model_impact_value[]" value="0">

                                                                        </div>

                                                                        <div style="width: 25%;margin-left: 10px;" class="discount-box item14">

                                                                            <label>Discount % </label>

                                                                            <input style="height: 35px;border-radius: 4px;" placeholder="Enter discount in percentage" type="text" class="form-control discount_values" value="0" name="discount[]">

                                                                        </div>

                                                                    </div>

                                                            </div>

															@endif

                                                        </section>

														<div style="width: 100%;margin-top: 10px;">

															<div style="display: flex;justify-content: center;">

																<div class="headings1" style="width: 63%;display: flex;justify-content: flex-end;align-items: center;padding-right: 15px;"><span style="font-size: 14px;font-weight: bold;font-family: monospace;">Totaal</span></div>
																<div class="headings1" style="width: 7%;">
																	<div style="display: flex;align-items: center;justify-content: center;">
																		<span style="font-size: 14px;font-weight: 500;margin-right: 5px;">€</span>
																		<input name="price_before_labor_total"
																			id="price_before_labor_total"
																			style="border: 0;font-size: 14px;font-weight: 500;width: 75px;outline: none;"
																			type="text" readonly
																			value="{{isset($invoice) ? str_replace('.', ',',floatval($invoice[0]->price_before_labor_total)) : 0}}">
																	</div>
																</div>
																
																<div class="headings2" style="width: 30%;">
																	<div style="display: flex;align-items: center;justify-content: flex-end;width: 60%;">
																		<span style="font-size: 14px;font-weight: 500;margin-right: 5px;">Te betalen: €</span>
																		<input name="total_amount" id="total_amount"
																			style="border: 0;font-size: 14px;font-weight: 500;width: 75px;outline: none;"
																			type="text" readonly
																			value="{{isset($invoice) ? str_replace('.', ',',floatval($invoice[0]->grand_total)) : 0}}">
																	</div>
																</div>

															</div>

															<div style="display: flex;justify-content: flex-end;">

																<div class="headings1" style="width: 56%;"></div>
																<div class="headings1" style="width: 7%;"></div>
																<div class="headings1" style="width: 7%;"></div>
																<div class="headings2" style="width: 30%;">
																	<div style="display: flex;align-items: center;justify-content: flex-end;width: 60%;">
																		<span style="font-size: 14px;font-weight: 500;margin-right: 5px;font-family: monospace;">Nettobedrag: €</span>
																			<input name="net_amount" id="net_amount"
																				style="border: 0;font-size: 14px;font-weight: 500;width: 75px;outline: none;"
																				type="text" readonly
																				value="{{isset($invoice) ? str_replace('.', ',',floatval($invoice[0]->net_amount)) : 0}}">
																	</div>
																</div>

															</div>

															<div style="display: flex;justify-content: flex-end;">

																<div class="headings1" style="width: 56%;"></div>
																<div class="headings1" style="width: 7%;"></div>
																<div class="headings1" style="width: 7%;"></div>
																<div class="headings2" style="width: 30%;">
																	<div style="display: flex;align-items: center;justify-content: flex-end;width: 60%;">
																		<span style="font-size: 14px;font-weight: 500;margin-right: 5px;font-family: monospace;">BTW (21%): €</span>
																		<input name="tax_amount" id="tax_amount"
																			style="border: 0;font-size: 14px;font-weight: 500;width: 75px;outline: none;"
																			type="text" readonly
																			value="{{isset($invoice) ? str_replace('.', ',',floatval($invoice[0]->tax_amount)) : 0}}">
																	</div>
																</div>

															</div>

														</div>

													</div>

													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"
														style="background: white;padding: 15px 0 0 0;">

														<ul style="border: 0;" class="nav nav-tabs feature-tab">
															
															<li style="margin-bottom: 0;" class="active"><a style="border: 0;padding: 10px 30px;" data-toggle="tab" href="#menu1" aria-expanded="false">Features</a></li>
																
															<li style="margin-bottom: 0;"><a style="border: 0;padding: 10px 30px;" data-toggle="tab" href="#menu2" aria-expanded="false">Calculator</a></li>
														
														</ul>

														<div style="padding: 30px 15px 20px 15px;border: 0;border-top: 1px solid #24232329;"
															class="tab-content">

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
																				style="margin-right: 10px;margin-bottom: 0;">Quantity</label>
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
																				style="margin-right: 10px;margin-bottom: 0;">Childsafe</label>
																			<select
																				style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;"
																				class="form-control childsafe-select"
																				name="childsafe_option{{$x+1}}">

																				<option value="">Select any option
																				</option>

																				@if($key1->childsafe_diff <= 150)
																					<option {{$key1->childsafe_question
																					== 1 ? 'selected' : null}}
																					value="1">Please note not childsafe
																					</option>
																					<option {{$key1->childsafe_question
																						== 2 ? 'selected' : null}}
																						value="2">Add childsafety clip
																					</option>

																					@else

																					<option {{$key1->childsafe_question
																						== 2 ? 'selected' : null}}
																						value="2">Add childsafety clip
																					</option>
																					<option {{$key1->childsafe_question
																						== 3 ? 'selected' : null}}
																						value="3">Yes childsafe</option>

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
																				style="margin-right: 10px;margin-bottom: 0;">Childsafe
																				Answer</label>
																			<select
																				style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;"
																				class="form-control childsafe-answer"
																				name="childsafe_answer{{$x+1}}">
																				@if($key1->childsafe_question == 1)
																				<option {{$key1->childsafe_answer == 1 ?
																					'selected' : null}} value="1">Make
																					it childsafe</option>
																				<option {{$key1->childsafe_answer == 2 ?
																					'selected' : null}} value="2">Yes i
																					agree</option>
																				@else
																				<option selected value="3">Is childsafe
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
																				style="margin-right: 10px;margin-bottom: 0;">Ladderband</label>
																			<select
																				style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;"
																				class="form-control feature-select"
																				name="features{{$x+1}}[]">
																				<option {{$feature->ladderband == 0 ?
																					'selected' : null}} value="0">No
																				</option>
																				<option {{$feature->ladderband == 1 ?
																					'selected' : null}} value="1">Yes
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
																			class="info ladderband-btn">Info</a>

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

																				<option value="0">Select Feature
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
																			class="info comment-btn">Info</a>

																		@endif

																	</div>

																	@foreach($key1->sub_features as $sub_feature)

																	@if($sub_feature->feature_id ==
																	$feature->feature_sub_id)

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

																				<option value="0">Select Feature
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

															<div id="menu2" class="tab-pane">

																<section class="attributes_table active" data-id="1" style="width: 100%;">

																	<div class="header-div">
																		<div class="headings" style="width: 22%;">Description</div>
																		<div class="headings" style="width: 10%;">Width</div>
																		<div class="headings" style="width: 10%;">Height</div>
																		<div class="headings" style="width: 10%;">Cutting lose %</div>
																		<div class="headings" style="width: 10%;">Total</div>
																		<div class="headings" style="width: 10%;">Box quantity</div>
																		<div class="headings" style="width: 10%;">Total boxes</div>
																		<div class="headings" style="width: 18%;"></div>
																	</div>


																	<div class="attribute-content-div" data-id="1">

																		<div class="attribute full-res item1" style="width: 22%;">
																			<textarea class="form-control attribute_description" style="width: 90%;border-radius: 7px;resize: vertical;height: 40px;outline: none;" name="attribute_description1[]"></textarea>
																		</div>

																		<div class="attribute item2 width-box" style="width: 10%;">

																			<div class="m-box">
																				<input style="border: 1px solid #ccc;" id="width" class="form-control width m-input" maskedformat="9,1" autocomplete="off" name="width1[]" type="text">
																				<input style="border: 0;outline: none;" readonly="" type="text" name="width_unit1[]" class="measure-unit">
																			</div>

																		</div>

																		<div class="attribute item3 height-box" style="width: 10%;">

																			<div class="m-box">
																				<input style="border: 1px solid #ccc;" id="height" class="form-control height m-input" maskedformat="9,1" autocomplete="off" name="height1[]" type="text">
																				<input style="border: 0;outline: none;" readonly="" type="text" name="height_unit1[]" class="measure-unit">
																			</div>

																		</div>

																		<div class="attribute item4" style="width: 10%;">

																			<div class="m-box">
																				<input class="form-control cutting_lose_percentage m-input" id="cutting_lose_percentage" style="border: 1px solid #ccc;" maskedformat="9,1" autocomplete="off" name="cutting_lose_percentage1[]" type="text">
																				<input style="border: 0;outline: none;" value="%" readonly="" type="text" class="measure-unit">
																			</div>

																		</div>

																		<div class="attribute item5" style="width: 10%;">

																			<div class="m-box">
																				<input style="border: 1px solid #ccc;" class="form-control total_boxes m-input" style="background: transparent;border: 1px solid #ccc;" readonly autocomplete="off" name="total_boxes1[]" type="number">
																				<input style="border: 0;outline: none;" value="m2" readonly="" type="text" class="measure-unit">
																			</div>

																		</div>

																		<div class="attribute item6" style="width: 10%;">

																			<div class="m-box">
																				<input class="form-control box_quantity_supplier m-input" style="border: 1px solid #ccc;" readonly autocomplete="off" name="box_quantity_supplier1[]" type="number">
																				<input style="border: 0;outline: none;" value="m2" readonly="" type="text" class="measure-unit">
																			</div>

																		</div>

																		<div class="attribute item7" style="width: 10%;">

																			<div style="display: flex;align-items: center;">
																				<input type="number" name="box_quantity1[]" readonly style="border: 1px solid #ccc;" class="form-control box_quantity res-white m-input">
																			</div>

																		</div>

																		<div class="attribute item8 last-content" style="padding: 0;width: 18%;">
																			<div class="res-white" style="display: flex;justify-content: flex-start;align-items: center;width: 100%;">

																				<span id="next-row-span" class="tooltip1 add-attribute-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;width: 20px;height: 20px;line-height: 20px;">
																					<i id="next-row-icon" class="fa fa-fw fa-plus"></i>
																					<span class="tooltiptext">Add</span>
																				</span>

																				<span id="next-row-span" class="tooltip1 remove-attribute-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;width: 20px;height: 20px;line-height: 20px;">
																					<i id="next-row-icon" class="fa fa-fw fa-trash-o"></i>
																					<span class="tooltiptext">Remove</span>
																				</span>

																				<span id="next-row-span" class="tooltip1 copy-attribute-row" style="cursor: pointer;font-size: 20px;margin: 0 10px;width: 20px;height: 20px;line-height: 20px;">
																					<i id="next-row-icon" class="fa fa-fw fa-copy"></i>
																					<span class="tooltiptext">Copy</span>
																				</span>

																			</div>
																		</div>

																	</div>


																</section>

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

<style>

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

		:not(.color, .model) > .select2-container--default .select2-selection--single
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

	#cus-box .select2-container--default .select2-selection--single .select2-selection__rendered {
		line-height: 28px;
	}

	#cus-box .select2-container--default .select2-selection--single {
		border: 1px solid #cacaca;
	}

	#cus-box .select2-selection {
		height: 40px !important;
		padding-top: 5px !important;
		outline: none;
	}

	#cus-box .select2-selection__arrow {
		top: 7.5px !important;
	}

	#cus-box .select2-selection__clear {
		display: none;
	}

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

	:not(.color, .model) > .select2-container--default .select2-selection--single {
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

	table tr th {
		font-family: system-ui;
		font-weight: 500;
		border-bottom: 1px solid #ebebeb;
		padding-bottom: 15px;
		color: gray;
	}

	table tbody tr td {
		font-family: system-ui;
		font-weight: 500;
		padding: 0 10px;
		color: #3c3c3c;
	}

	table tbody tr.active td {
		border-top: 2px solid #cecece;
		border-bottom: 2px solid #cecece;
	}

	table tbody tr.active td:first-child {
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
		border-collapse: separate;
		border-spacing: 0 1em;
	}


	.modal-body table tr th {
		border: 1px solid #ebebeb;
		padding-bottom: 15px;
		color: gray;
	}

	.modal-body table tbody tr td {
		border-left: 1px solid #ebebeb;
		border-right: 1px solid #ebebeb;
		border-bottom: 1px solid #ebebeb;
	}

	.modal-body table tbody tr td:first-child {
		border-right: 0;
	}

	.modal-body table tbody tr td:last-child {
		border-left: 0;
	}

	.modal-body table {
		border-collapse: separate;
		border-spacing: 0;
		margin: 20px 0;
	}

	.modal-body table tbody tr td,
	.modal-body table thead tr th {
		padding: 5px 10px;
	}

</style>

@endsection

@section('scripts')

<script
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNRJukOohRJ1tW0tMG4tzpDXFz68OnonM&libraries=places&callback=initMap"
	defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

<script type="text/javascript">

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
						'                                            <p class="text-left">Email address is not valid...</p>\n' +
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
								'                                            <p class="text-left">Something went wrong!</p>\n' +
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

		var current_desc = '';

		$(".add-desc").click(function () {
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

			$("input[name='total[]']").each(function (i, obj) {

				var rate = 0;
				var row_id = $(this).parent().data('id');
				var qty = $('#products_table').find(`[data-id='${row_id}']`).find('input[name="qty[]"]').val();

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

				// var labor_impact = $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val();
				// labor_impact = labor_impact * qty;
				// labor_impact = parseFloat(labor_impact).toFixed(2);

				// if(labor_changed == 0)
				// {
				// 	$('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val(labor_impact.replace(/\./g, ','));
				// }

				var price_before_labor = $('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val();
				price_before_labor = price_before_labor * qty;
				price_before_labor = parseFloat(price_before_labor).toFixed(2);
				$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val(price_before_labor.replace(/\./g, ','));

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

					var discount_val = parseFloat(price_before_labor) * (discount/100);
					// var labor_discount_val = parseFloat(labor_impact) * (labor_discount/100);

					// var total_discount = discount_val + labor_discount_val;
					var total_discount = discount_val;
					total_discount = parseFloat(total_discount).toFixed(2);
					var old_discount = total_discount / qty;
					old_discount = parseFloat(old_discount).toFixed(2);
					$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount').val('-' + total_discount.replace(/\./g, ','));
					$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount_old').val('-' + old_discount);

					rate = parseFloat(rate) - parseFloat(total_discount);
					var price = rate / qty;

					$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val(price);

				}
				else
				{
					var price = rate / qty;

					if(qty != 0)
					{
						$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val(price);
					}

					var old_discount = $('#products_table').find(`[data-id='${row_id}']`).find('.total_discount_old').val();
					old_discount = old_discount * qty;
					old_discount = parseFloat(old_discount).toFixed(2);

					$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount').val(old_discount.replace(/\./g, ','));
				}

				rate = parseFloat(rate);
				rate = rate.toFixed(2);

				total = parseFloat(total) + parseFloat(rate);
				total = total.toFixed(2);

				$(this).parent().find('#rate').val(rate);
				$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('€ ' + rate.replace(/\./g, ','));


				var art = price_before_labor;
				price_before_labor_total = parseFloat(price_before_labor_total) + parseFloat(art);
				price_before_labor_total = parseFloat(price_before_labor_total).toFixed(2);

				// var arb = labor_impact;
				// labor_cost_total = parseFloat(labor_cost_total) + parseFloat(arb);
				// labor_cost_total = parseFloat(labor_cost_total).toFixed(2);

			});

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

		$(document).on('change', ".js-data-example-ajax1", function (e) {

			var current = $(this);

			var id = current.val();
			var row_id = current.parents(".content-div").data('id');
			var options = '';
			$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(0);

			$.ajax({
				type: "GET",
				data: "id=" + id + '&type=floors',
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
					// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
					// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
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
						.append('<option value="">Select Product</option>' + options);


					$('#products_table').find(`[data-id='${row_id}']`).find('.color').children('select').find('option')
						.remove()
						.end()
						.append('<option value="">Select Color</option>');

                    $('#products_table').find(`[data-id='${row_id}']`).find('.model').children('select').find('option')
                        .remove()
                        .end()
                        .append('<option value="">Select Model</option>');

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

						if(data.estimated_price_per_box)
						{
							var estimated_price_per_box = data.estimated_price_per_box;
							estimated_price_per_box = estimated_price_per_box.replace(/\./g, ',');
							estimated_price_per_box_old = data.estimated_price_per_box;
						}
						else
						{
							var estimated_price_per_box = 0;
							estimated_price_per_box_old = 0;
						}

						$('#products_table').find(`[data-id='${row_id}']`).find('.discount-box').find('.discount_values').val(0);
						// $('#products_table').find(`[data-id='${row_id}']`).find('.labor-discount-box').find('.labor_discount_values').val(0);
						$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount').val(0);
						$('#products_table').find(`[data-id='${row_id}']`).find('.total_discount_old').val(0);
						$('#products_table').find(`[data-id='${row_id}']`).find('.qty').val(1);
						$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val(estimated_price_per_box);
						$('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val(estimated_price_per_box_old);
						// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
						// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
						$('#products_table').find(`[data-id='${row_id}']`).find('.model').find('.model_impact_value').val('');
						$('#products_table').find(`[data-id='${row_id}']`).find('#delivery_days').val(data.delivery_days);
						$('#products_table').find(`[data-id='${row_id}']`).find('#ladderband').val(data.ladderband);
						$('#products_table').find(`[data-id='${row_id}']`).find('#ladderband_value').val(data.ladderband_value);
						$('#products_table').find(`[data-id='${row_id}']`).find('#ladderband_price_impact').val(data.ladderband_price_impact);
						$('#products_table').find(`[data-id='${row_id}']`).find('#ladderband_impact_type').val(data.ladderband_impact_type);
						$('#products_table').find(`[data-id='${row_id}']`).find('#price_based_option').val(data.price_based_option);
						$('#products_table').find(`[data-id='${row_id}']`).find('#base_price').val(data.base_price);
						$('#products_table').find(`[data-id='${row_id}']`).find('#estimated_price_quantity').val(data.estimated_price_quantity);
						$('#menu2').find(`.attributes_table[data-id='${row_id}']`).find('.box_quantity_supplier').val(data.estimated_price_quantity);
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
							.append('<option value="">Select Color</option>' + options);

							$('#products_table').find(`[data-id='${row_id}']`).find('.model').children('select').find('option')
							.remove()
							.end()
							.append('<option value="">Select Model</option>' + options1);

						if ((typeof (data) != "undefined") && data.measure) {
							
							if(data.measure == 'M2')
							{
								data.measure = 'm²';
							}
							else if(data.measure == 'M1')
							{
								data.measure = 'm';
							}

							$('#products_table').find(`[data-id='${row_id}']`).find('#width_unit').val(data.measure);
							$('#products_table').find(`[data-id='${row_id}']`).find('#height_unit').val(data.measure);

							$('#menu2').find(`.attributes_table[data-id='${row_id}']`).find('.width-box').find('.measure-unit').val(data.measure);
							$('#menu2').find(`.attributes_table[data-id='${row_id}']`).find('.height-box').find('.measure-unit').val(data.measure);
						}
						else {
							$('#products_table').find(`[data-id='${row_id}']`).find('#width_unit').val('');
							$('#products_table').find(`[data-id='${row_id}']`).find('#height_unit').val('');

							$('#menu2').find(`.attributes_table[data-id='${row_id}']`).find('.width-box').find('.measure-unit').val('');
							$('#menu2').find(`.attributes_table[data-id='${row_id}']`).find('.height-box').find('.measure-unit').val('');
						}

						$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('€ ' + estimated_price_per_box);
						$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val(estimated_price_per_box_old);
						$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val(estimated_price_per_box_old);

						calculate_total();
					}

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
			placeholder: "Select Supplier",
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
			placeholder: "Select Color",
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
			placeholder: "Select Model",
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
				// $('#products_table').find(`[data-id='${row_id}']`).find('.labor-discount-box').find('.labor_discount_values').val(0);
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
									html: 'Width & Height are greater than max values <br> Max Width: ' + data[0].max_width + '<br> Max Height: ' + data[0].max_height,
								});

								// $('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val('');
								// $('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val('');
								// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
								// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
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
									html: 'Width is greater than max value <br> Max Width: ' + data[0].max_width,
								});

								// $('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val('');
								// $('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val('');
								// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
								// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
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
									html: 'Height is greater than max value <br> Max Height: ' + data[0].max_height,
								});

								// $('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val('');
								// $('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val('');
								// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
								// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
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
										'<label style="margin-right: 10px;margin-bottom: 0;">Childsafe</label>' +
										'<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control childsafe-select" name="childsafe_option' + row_id + '">\n' +
										'<option value="">Select any option</option>\n' +
										'<option value="2">Add childsafety clip</option>\n' +
										'</select>\n' +
										'<input value="0" name="childsafe_diff' + row_id + '" class="childsafe_diff" type="hidden">' +
										'</div></div>\n';

									features = features + content;

								}

								if (ladderband == 1) {

									var content = '<div class="row" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
										'<label style="margin-right: 10px;margin-bottom: 0;">Ladderband</label>' +
										'<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features' + row_id + '[]">\n' +
										'<option value="0">No</option>\n' +
										'<option value="1">Yes</option>\n' +
										'</select>\n' +
										'<input value="0" name="f_price' + row_id + '[]" class="f_price" type="hidden">' +
										'<input value="0" name="f_id' + row_id + '[]" class="f_id" type="hidden">' +
										'<input value="0" name="f_area' + row_id + '[]" class="f_area" type="hidden">' +
										'<input value="0" name="sub_feature' + row_id + '[]" class="sub_feature" type="hidden">' +
										'</div><a data-id="' + row_id + '" class="info ladderband-btn hide">Info</a></div>\n';

									features = features + content;

								}

								$.each(data[1], function (index, value) {

                                    count_features = count_features + 1;

									var opt = '<option value="0">Select Feature</option>';

									$.each(value.features, function (index1, value1) {

										opt = opt + '<option value="' + value1.id + '">' + value1.title + '</option>';

									});

									if (value.comment_box == 1) {
										var icon = '<a data-feature="' + value.id + '" class="info comment-btn">Info</a>';
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
									'<label style="margin-right: 10px;margin-bottom: 0;">Quantity</label>' +
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
											text: 'Area is greater than max size: ' + max_size,
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
									labor = parseFloat(labor).toFixed(2);
								}

								// $('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val(price_before_labor.replace(/\./g, ','));
								// $('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val(price_before_labor);
								// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val(labor.replace(/\./g, ','));
								// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val(labor);
								$('#products_table').find(`[data-id='${row_id}']`).find('.model').find('.model_impact_value').val(model_impact_value);
								//$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('€ ' + Math.round(price));
								$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('€ ' + price.replace(/\./g, ','));
								$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val(price);
								$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val(price);
								$('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val(basic_price);

							}
						}
						else {
							// $('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val('');
							// $('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val('');
							// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
							// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
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
				// $('#products_table').find(`[data-id='${row_id}']`).find('.labor-discount-box').find('.labor_discount_values').val(0);
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
									html: 'Width & Height are greater than max values <br> Max Width: ' + data[0].max_width + '<br> Max Height: ' + data[0].max_height,
								});


								// $('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val('');
								// $('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val('');
								// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
								// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
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
									html: 'Width is greater than max value <br> Max Width: ' + data[0].max_width,
								});

								// $('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val('');
								// $('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val('');
								// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
								// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
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
									html: 'Height is greater than max value <br> Max Height: ' + data[0].max_height,
								});

								// $('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val('');
								// $('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val('');
								// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
								// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
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
										'<label style="margin-right: 10px;margin-bottom: 0;">Childsafe</label>' +
										'<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control childsafe-select" name="childsafe_option' + row_id + '">\n' +
										'<option value="">Select any option</option>\n' +
										'<option value="2">Add childsafety clip</option>\n' +
										'</select>\n' +
										'<input value="0" name="childsafe_diff' + row_id + '" class="childsafe_diff" type="hidden">' +
										'</div></div>\n';

									features = features + content;

								}

								if (ladderband == 1) {

									var content = '<div class="row" style="margin: 0;display: flex;align-items: center;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-11 col-md-11 col-sm-11 col-xs-11">\n' +
										'<label style="margin-right: 10px;margin-bottom: 0;">Ladderband</label>' +
										'<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features' + row_id + '[]">\n' +
										'<option value="0">No</option>\n' +
										'<option value="1">Yes</option>\n' +
										'</select>\n' +
										'<input value="0" name="f_price' + row_id + '[]" class="f_price" type="hidden">' +
										'<input value="0" name="f_id' + row_id + '[]" class="f_id" type="hidden">' +
										'<input value="0" name="f_area' + row_id + '[]" class="f_area" type="hidden">' +
										'<input value="0" name="sub_feature' + row_id + '[]" class="sub_feature" type="hidden">' +
										'</div><a data-id="' + row_id + '" class="info ladderband-btn hide">Info</a></div>\n';

									features = features + content;

								}

								$.each(data[1], function (index, value) {

                                    count_features = count_features + 1;

									var opt = '<option value="0">Select Feature</option>';

									$.each(value.features, function (index1, value1) {

										opt = opt + '<option value="' + value1.id + '">' + value1.title + '</option>';

									});

									if (value.comment_box == 1) {
										var icon = '<a data-feature="' + value.id + '" class="info comment-btn">Info</a>';
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
									'<label style="margin-right: 10px;margin-bottom: 0;">Quantity</label>' +
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
											text: 'Area is greater than max size: ' + max_size,
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
									labor = parseFloat(labor).toFixed(2);
								}

								// $('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val(price_before_labor.replace(/\./g, ','));
								// $('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val(price_before_labor);
								// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val(labor.replace(/\./g, ','));
								// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val(labor);
								$('#products_table').find(`[data-id='${row_id}']`).find('.model').find('.model_impact_value').val(model_impact_value);
								//$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('€ ' + Math.round(price));
								$('#products_table').find(`[data-id='${row_id}']`).find('.price').text('€ ' + price.replace(/\./g, ','));
								$('#products_table').find(`[data-id='${row_id}']`).find('#row_total').val(price);
								$('#products_table').find(`[data-id='${row_id}']`).find('#rate').val(price);
								$('#products_table').find(`[data-id='${row_id}']`).find('#basic_price').val(basic_price);
							}
						}
						else {
							// $('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor').val('');
							// $('#products_table').find(`[data-id='${row_id}']`).find('.price_before_labor_old').val('');
							// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact').val('');
							// $('#products_table').find(`[data-id='${row_id}']`).find('.labor_impact_old').val('');
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
			$('#menu2').children().not(`.attributes_table[data-id='${id}']`).removeClass('active');
			$('#menu2').find(`.attributes_table[data-id='${id}']`).addClass('active');

		}

		function numbering() {
			$('#products_table .content-div').each(function (index, tr) { $(this).find('.content:eq(0)').find('.sr-res').text(index + 1); });
		}

		function add_row(copy = false, rate = null, basic_price = null, price = null, products = null, product = null, suppliers = null, supplier = null, colors = null, color = null, models = null, model = null, model_impact_value = null, width = null, width_unit = null, height = null, height_unit = null, price_text = null, features = null, features_selects = null, childsafe_question = null, childsafe_answer = null, qty = null, childsafe = 0, ladderband = 0, ladderband_value = 0, ladderband_price_impact = 0, ladderband_impact_type = 0, area_conflict = 0, subs = null, childsafe_x = null, childsafe_y = null, delivery_days = null, price_based_option = null, base_price = null, supplier_margin = null, retailer_margin = null, width_readonly = null, height_readonly = null, price_before_labor = null, price_before_labor_old = null, discount = null, total_discount = null, total_discount_old = null, last_column = null, menu2 = null, estimated_price_quantity = null) {

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
					'                                                            <input type="hidden" value="" id="estimated_price_quantity" name="estimated_price_quantity[]">\n' +
					'                                                            <input type="hidden" value="" id="width_unit" name="width_unit[]">\n' +
					'                                                            <input type="hidden" value="" id="height_unit" name="height_unit[]">\n' +
					'\n' +
					'                                                            <div style="width: 12%;" @if(auth()->user()->role_id == 4) class="suppliers content item2 full-res hide" @else class="suppliers content item2 full-res" @endif>\n' +
					'\n' +
					'                       									 	<label class="content-label">Supplier</label>\n' +
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
					'                       									 	<label class="content-label">Product</label>\n' +
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
					'                       									 	<label class="content-label">Width</label>\n' +
					'\n' +
					'                                                                <div class="m-box">\n' +
					'                                                                	<input value="0" class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="width[]" type="text">\n' +
					'                                                                   <input style="border: 0;outline: none;" readonly type="text" name="width_unit[]" class="measure-unit" value="cm">\n' +
					'                                                                </div>\n' +
					'                                                            </div>\n' +
					'\n' +
					'                                                            <div class="height item5 content" style="width: 10%;">\n' +
					'\n' +
					'                       									 	<label class="content-label">Height</label>\n' +
					'\n' +
					'                                                                <div class="m-box">\n' +
					'                                                                	<input value="0" class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="height[]" type="text">\n' +
					'                                                                	<input style="border: 0;outline: none;" readonly type="text" name="height_unit[]" class="measure-unit" value="cm">\n' +
					'                                                                </div>\n' +
					'                                                            </div>\n' +
					'\n' +
					'                                                            <div class="content item6" style="width: 7%;">\n' +
					'\n' +
					'                       									 	<label class="content-label">Qty</label>\n' +
					'\n' +
					'																 <div style="display: flex;align-items: center;">\n' +
					'																 	<input type="text" name="qty[]" maskedFormat="9,1" style="border: 0;background: transparent;padding: 0 5px;" class="form-control qty res-white">\n' +
					'																 </div>\n' +
					'                                                            </div>\n' +
					'\n' +
					'                                                            <div class="content item7" style="width: 7%;">\n' +
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
					'\n' +
					'																<div class="price res-white"></div>\n' +
					'                                                            </div>\n' +
					'\n' +
					'                                                            <div class="content item10 last-content" id="next-row-td" style="padding: 0;width: 13%;">\n' +
					'\n' +
					'                       									 	<div class="res-white" style="display: flex;justify-content: flex-end;align-items: center;width: 100%;">\n' +
					'\n' +
					'																<div style="display: none;" class="green-circle tooltip1">\n' +
					'																	<span style="top: 45px;left: -40px;" class="tooltiptext">ALL features selected!</span>\n' +
					'																</div>\n' +
					'\n' +
					'																<div style="visibility: hidden;" class="yellow-circle tooltip1">\n' +
					'																	<span style="top: 45px;left: -40px;" class="tooltiptext">Select all features!</span>\n' +
					'																</div>\n' +
					'\n' +
					'																<span id="next-row-span" class="tooltip1 add-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;width: 20px;height: 20px;line-height: 20px;">\n' +
					'\n' +
					'																	<i id="next-row-icon" class="fa fa-fw fa-plus"></i>\n' +
					'\n' +
					'																	<span class="tooltiptext">Add</span>\n' +
					'\n' +
					'																</span>\n' +
					'\n' +
					'																<span id="next-row-span" class="tooltip1 remove-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;width: 20px;height: 20px;line-height: 20px;">\n' +
					'\n' +
					'																	<i id="next-row-icon" class="fa fa-fw fa-trash-o"></i>\n' +
					'\n' +
					'																	<span class="tooltiptext">Remove</span>\n' +
					'\n' +
					'																</span>\n' +
					'\n' +
					'																<span id="next-row-span" class="tooltip1 copy-row" style="cursor: pointer;font-size: 20px;margin: 0 10px;width: 20px;height: 20px;line-height: 20px;">\n' +
					'\n' +
					'																	<i id="next-row-icon" class="fa fa-fw fa-copy"></i>\n' +
					'\n' +
					'																	<span class="tooltiptext">Copy</span>\n' +
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
					'																	<label>Color</label>\n' +
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
					'																	<label>Model</label>\n' +
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
					'																	<label>Discount %</label>\n' +
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
                    '                       									 	<div class="headings" style="width: 22%;">Description</div>\n' +
					'                       									 	<div class="headings" style="width: 10%;">Width</div>\n' +
					'																<div class="headings" style="width: 10%;">Height</div>\n' +
					'																<div class="headings" style="width: 10%;">Cutting lose %</div>\n' +
					'																<div class="headings" style="width: 10%;">Total</div>\n' +
					'																<div class="headings" style="width: 10%;">Box quantity</div>\n' +
					'																<div class="headings" style="width: 10%;">Total boxes</div>\n' +
					'																<div class="headings" style="width: 18%;"></div>\n' +
					'                       									 </div>\n'
					);

				add_attribute_row(false, rowCount);

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
					placeholder: "Select Supplier",
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
					placeholder: "Select Color",
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
					placeholder: "Select Model",
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
					'                                                            <input type="hidden" value=" '+ estimated_price_quantity +' " id="estimated_price_quantity" name="estimated_price_quantity[]">\n' +
					'                                                            <input type="hidden" value=" '+ width_unit +' " id="width_unit" name="width_unit[]">\n' +
					'                                                            <input type="hidden" value=" '+ height_unit +' " id="height_unit" name="height_unit[]">\n' +
					'\n' +
					'                                                            <div style="width: 12%;" @if(auth()->user()->role_id == 4) class="suppliers content item2 full-res hide" @else class="suppliers content item2 full-res" @endif>\n' +
					'\n' +
					'                       									 	<label class="content-label">Supplier</label>\n' +
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
					'                       									 	<label class="content-label">Product</label>\n' +
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
					'                       									 	<label class="content-label">Width</label>\n' +
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
					'                       									 	<label class="content-label">Height</label>\n' +
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
					'                       									 	<label class="content-label">Qty</label>\n' +
					'\n' +
					'																 <div style="display: flex;align-items: center;">\n' +
					'																 	<input value="' + qty + '" type="text" name="qty[]" maskedFormat="9,1" style="border: 0;background: transparent;padding: 0 5px;" class="form-control qty res-white">\n' +
					'																 </div>\n' +
					'                                                            </div>\n' +
					'\n' +
					'                                                            <div class="content item7" style="width: 7%;">\n' +
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
					'																	<label>Color</label>\n' +
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
					'																	<label>Model</label>\n' +
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

				if(menu2)
				{					
					$('#menu2').append('<section class="attributes_table" data-id="'+rowCount+'" style="width: 100%;"></section>\n');
					menu2.appendTo(`#menu2 .attributes_table[data-id='${rowCount}']`);

					$('#menu2').find(`.attributes_table[data-id='${rowCount}']`).each(function (i, obj) {

						$(obj).find('.attribute_description').attr('name', 'attribute_description' + rowCount + '[]');
						$(obj).find('.width-box').find('.width').attr('name', 'width' + rowCount + '[]');
						$(obj).find('.width-box').find('.measure-unit').attr('name', 'width_unit' + rowCount + '[]');
						$(obj).find('.height-box').find('.height').attr('name', 'height' + rowCount + '[]');
						$(obj).find('.height-box').find('.measure-unit').attr('name', 'height_unit' + rowCount + '[]');
						$(obj).find('.cutting_lose_percentage').attr('name', 'cutting_lose_percentage' + rowCount + '[]');
						$(obj).find('.total_boxes').attr('name', 'total_boxes' + rowCount + '[]');
						$(obj).find('.box_quantity_supplier').attr('name', 'box_quantity_supplier' + rowCount + '[]');
						$(obj).find('.box_quantity').attr('name', 'box_quantity' + rowCount + '[]');

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
					placeholder: "Select Supplier",
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
					placeholder: "Select Color",
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
					placeholder: "Select Model",
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

		function add_attribute_row(copy = false, product_row, description = null, width = null, width_unit = null, height = null, height_unit = null, cutting_lose_percentage = null, total_boxes = null, box_quantity_supplier = null, box_quantity = null) {

			var check_length = $(`.attributes_table[data-id='${product_row}']`).find('.attribute-content-div').length;

			if(check_length == 0)
			{
				var rowCount = 1;
			}
			else
			{
				var rowCount = $(`.attributes_table[data-id='${product_row}']`).find('.attribute-content-div:last').data('id');
				rowCount = rowCount + 1;
			}

			if (!copy) {

				var box_quantity = $('#products_table').find(`[data-id='${product_row}']`).find('#estimated_price_quantity').val();
				var measure_unit = $('#products_table').find(`[data-id='${product_row}']`).find('#width_unit').val();

				$(`.attributes_table[data-id='${product_row}']`).append('<div class="attribute-content-div" data-id="' + rowCount + '">\n' +
					'\n' +
					'                                                            <div class="attribute full-res item1" style="width: 22%;">\n' +
					'                       									 	<textarea class="form-control attribute_description" style="width: 90%;border-radius: 7px;resize: vertical;height: 40px;outline: none;" name="attribute_description'+product_row+'[]"></textarea>\n' +
					'                       									 </div>\n' +
					'\n' +
					'                                                            <div class="attribute item2 width-box" style="width: 10%;">\n' +
					'\n' +
					'                       									 	<div class="m-box">\n' +
					'\n' +
					'                                                                <input style="border: 1px solid #ccc;" id="width" class="form-control width m-input" maskedformat="9,1" autocomplete="off" name="width'+product_row+'[]" type="text">\n' +
					'\n' +
					'                                                                <input style="border: 0;outline: none;" value="'+measure_unit+'" readonly="" type="text" name="width_unit'+product_row+'[]" class="measure-unit">\n' +
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
					'                                                                <input style="border: 0;outline: none;" value="'+measure_unit+'" readonly="" type="text" name="height_unit'+product_row+'[]" class="measure-unit">\n' +
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
					'                                                                <input style="border: 0;outline: none;" readonly value="%" type="text" class="measure-unit">\n' +
					'\n' +
					'                                                               </div>\n' +
					'\n' +
					'                                                            </div>\n' +
					'\n' +
					'                                                            <div class="attribute item5" style="width: 10%;">\n' +
					'\n' +
					'                       									 	<div class="m-box">\n' +
					'\n' +
					'                                                                <input style="border: 1px solid #ccc;" class="form-control total_boxes m-input" readonly autocomplete="off" name="total_boxes'+product_row+'[]" type="number">\n' +
					'\n' +
					'                                                                <input style="border: 0;outline: none;" readonly value="m2" type="text" class="measure-unit">\n' +
					'\n' +
					'                                                               </div>\n' +
					'\n' +
					'                                                            </div>\n' +
					'\n' +
					'                                                            <div class="attribute item6" style="width: 10%;">\n' +
					'\n' +
					'                       									 	<div class="m-box">\n' +
					'\n' +
					'                                                                <input style="border: 1px solid #ccc;" value="'+box_quantity+'" class="form-control box_quantity_supplier m-input" readonly autocomplete="off" name="box_quantity_supplier'+product_row+'[]" type="number">\n' +
					'\n' +
					'                                                                <input style="border: 0;outline: none;" readonly value="m2" type="text" class="measure-unit">\n' +
					'\n' +
					'                                                               </div>\n' +
					'\n' +
					'                                                            </div>\n' +
					'\n' +
					'                                                            <div class="attribute item7" style="width: 10%;">\n' +
					'\n' +
					'                       									 	<div style="display: flex;align-items: center;">\n' +
					'\n' +
					'                                                                <input type="number" name="box_quantity'+product_row+'[]" readonly="" style="border: 1px solid #ccc;" class="form-control box_quantity res-white m-input">\n' +
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
					'																		<span class="tooltiptext">Add</span>\n' +
					'\n' +
					'																	</span>\n' +
					'\n' +
					'																	<span id="next-row-span" class="tooltip1 remove-attribute-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;width: 20px;height: 20px;line-height: 20px;">\n' +
					'\n' +
					'																		<i id="next-row-icon" class="fa fa-fw fa-trash-o"></i>\n' +
					'\n' +
					'																		<span class="tooltiptext">Remove</span>\n' +
					'\n' +
					'																	</span>\n' +
					'\n' +
					'																	<span id="next-row-span" class="tooltip1 copy-attribute-row" style="cursor: pointer;font-size: 20px;margin: 0 10px;width: 20px;height: 20px;line-height: 20px;">\n' +
					'\n' +
					'																		<i id="next-row-icon" class="fa fa-fw fa-copy"></i>\n' +
					'\n' +
					'																		<span class="tooltiptext">Copy</span>\n' +
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

				$(`.attributes_table[data-id='${product_row}']`).append('<div class="attribute-content-div" data-id="' + rowCount + '">\n' +
					'\n' +
					'                                                            <div class="attribute full-res item1" style="width: 22%;">\n' +
					'                       									 	<textarea class="form-control attribute_description" style="width: 90%;border-radius: 7px;resize: vertical;height: 40px;outline: none;" name="attribute_description'+product_row+'[]">'+description+'</textarea>\n' +
					'                       									 </div>\n' +
					'\n' +
					'                                                            <div class="attribute item2 width-box" style="width: 10%;">\n' +
					'\n' +
					'                       									 	<div class="m-box">\n' +
					'\n' +
					'                                                                <input style="border: 1px solid #ccc;" id="width" value="'+width+'" class="form-control width m-input" maskedformat="9,1" autocomplete="off" name="width'+product_row+'[]" type="text">\n' +
					'\n' +
					'                                                                <input style="border: 0;outline: none;" value="'+width_unit+'" readonly="" type="text" name="width_unit'+product_row+'[]" class="measure-unit">\n' +
					'\n' +
					'                                                               </div>\n' +
					'\n' +
					'                                                            </div>\n' +
					'\n' +
					'                                                            <div class="attribute item3 height-box" style="width: 10%;">\n' +
					'\n' +
					'                       									 	<div class="m-box">\n' +
					'\n' +
					'                                                                <input style="border: 1px solid #ccc;" id="height" value="'+height+'" class="form-control height m-input" maskedformat="9,1" autocomplete="off" name="height'+product_row+'[]" type="text">\n' +
					'\n' +
					'                                                                <input style="border: 0;outline: none;" value="'+height_unit+'" readonly="" type="text" name="height_unit'+product_row+'[]" class="measure-unit">\n' +
					'\n' +
					'                                                               </div>\n' +
					'\n' +
					'                                                            </div>\n' +
					'\n' +
					'                                                            <div class="attribute item4" style="width: 10%;">\n' +
					'\n' +
					'                       									 	<div class="m-box">\n' +
					'\n' +
					'                                                                <input style="border: 1px solid #ccc;" id="cutting_lose_percentage" value="'+cutting_lose_percentage+'" class="form-control cutting_lose_percentage m-input" maskedformat="9,1" autocomplete="off" name="cutting_lose_percentage'+product_row+'[]" type="text">\n' +
					'\n' +
					'                                                                <input style="border: 0;outline: none;" readonly value="%" type="text" class="measure-unit">\n' +
					'\n' +
					'                                                               </div>\n' +
					'\n' +
					'                                                            </div>\n' +
					'\n' +
					'                                                            <div class="attribute item5" style="width: 10%;">\n' +
					'\n' +
					'                       									 	<div class="m-box">\n' +
					'\n' +
					'                                                                <input style="border: 1px solid #ccc;" value="'+total_boxes+'" class="form-control total_boxes m-input" readonly autocomplete="off" name="total_boxes'+product_row+'[]" type="number">\n' +
					'\n' +
					'                                                                <input style="border: 0;outline: none;" readonly value="m2" type="text" class="measure-unit">\n' +
					'\n' +
					'                                                               </div>\n' +
					'\n' +
					'                                                            </div>\n' +
					'\n' +
					'                                                            <div class="attribute item6" style="width: 10%;">\n' +
					'\n' +
					'                       									 	<div class="m-box">\n' +
					'\n' +
					'                                                                <input style="border: 1px solid #ccc;" value="'+box_quantity_supplier+'" class="form-control box_quantity_supplier m-input" readonly autocomplete="off" name="box_quantity_supplier'+product_row+'[]" type="number">\n' +
					'\n' +
					'                                                                <input style="border: 0;outline: none;" readonly value="m2" type="text" class="measure-unit">\n' +
					'\n' +
					'                                                               </div>\n' +
					'\n' +
					'                                                            </div>\n' +
					'\n' +
					'                                                            <div class="attribute item7" style="width: 10%;">\n' +
					'\n' +
					'                       									 	<div style="display: flex;align-items: center;">\n' +
					'\n' +
					'                                                                <input type="number" value="'+box_quantity+'" name="box_quantity'+product_row+'[]" readonly="" style="border: 1px solid #ccc;" class="form-control box_quantity res-white m-input">\n' +
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
					'																		<span class="tooltiptext">Add</span>\n' +
					'\n' +
					'																	</span>\n' +
					'\n' +
					'																	<span id="next-row-span" class="tooltip1 remove-attribute-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;width: 20px;height: 20px;line-height: 20px;">\n' +
					'\n' +
					'																		<i id="next-row-icon" class="fa fa-fw fa-trash-o"></i>\n' +
					'\n' +
					'																		<span class="tooltiptext">Remove</span>\n' +
					'\n' +
					'																	</span>\n' +
					'\n' +
					'																	<span id="next-row-span" class="tooltip1 copy-attribute-row" style="cursor: pointer;font-size: 20px;margin: 0 10px;width: 20px;height: 20px;line-height: 20px;">\n' +
					'\n' +
					'																		<i id="next-row-icon" class="fa fa-fw fa-copy"></i>\n' +
					'\n' +
					'																		<span class="tooltiptext">Copy</span>\n' +
					'\n' +
					'																	</span>\n' +
					'\n' +
					'                                                            	</div>\n' +
					'\n' +
					'                                                            </div>\n' +
					'\n' +
					'                                                        </div>');
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

			var rowCount = $('.attributes_table .attribute-content-div').length;

			var current = $(this).parents('.attribute-content-div');

			if (rowCount != 1) {

				current.remove();

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
					text: 'Feature should not be empty!',
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
			var width_unit = current.find('#width_unit').val();
			var height = current.find('.height').find('.m-input').val();
			var height_unit = current.find('#height_unit').val();
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
			var discount = current.find('.discount-box').find('.discount_values').val();
			// var labor_discount = current.find('.labor-discount-box').find('.labor_discount_values').val();
			var total_discount = current.find('.total_discount').val();
			var total_discount_old = current.find('.total_discount_old').val();
			var last_column = current.find('#next-row-td').html();
			var menu2 = $('#menu2').find(`.attributes_table[data-id='${id}']`).children().clone();
			var estimated_price_quantity = current.find('#estimated_price_quantity').val();

			var width_readonly = '';
			var height_readonly = '';

			if (price_based_option == 2) {
				height_readonly = 'readonly';
			}
			else if (price_based_option == 3) {
				width_readonly = 'readonly';
			}

			add_row(true, rate, basic_price, price, products, product, suppliers, supplier, colors, color, models, model, model_impact_value, width, width_unit, height, height_unit, price_text, features, features_selects, childsafe_question, childsafe_answer, qty, childsafe, ladderband, ladderband_value, ladderband_price_impact, ladderband_impact_type, area_conflict, subs, childsafe_x, childsafe_y, delivery_days, price_based_option, base_price, supplier_margin, retailer_margin, width_readonly, height_readonly, price_before_labor, price_before_labor_old, discount, total_discount, total_discount_old, last_column, menu2, estimated_price_quantity);

		});

		$(document).on('click', '.copy-attribute-row', function () {

			var current = $(this).parents('.attribute-content-div');
			var product_row = current.parents('.attributes_table').data('id');
			var description = current.find('.attribute_description').val();
			var width = current.find('.width-box').find('.width').val();
			var width_unit = current.find('.width-box').find('.measure-unit').val();
			var height = current.find('.height-box').find('.height').val();
			var height_unit = current.find('.height-box').find('.measure-unit').val();
			var cutting_lose_percentage = current.find('.cutting_lose_percentage').val();
			var total_boxes = current.find('.total_boxes').val();
			var box_quantity_supplier = current.find('.box_quantity_supplier').val();
			var box_quantity = current.find('.box_quantity').val();

			add_attribute_row(true, product_row, description, width, width_unit, height, height_unit, cutting_lose_percentage, total_boxes, box_quantity_supplier, box_quantity);

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

		$(document).on('keypress', ".cutting_lose_percentage", function (e) {

			e = e || window.event;
			var charCode = (typeof e.which == "undefined") ? e.keyCode : e.which;
			var val = String.fromCharCode(charCode);

			if (!val.match(/^[0-9]+$/))  // For characters validation
			{
				e.preventDefault();
				return false;
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

		$(document).on('focusout', ".width, .height", function (e) {

			if ($(this).val().slice($(this).val().length - 1) == ',') {
				var val = $(this).val();
				val = val + '00';
				$(this).val(val);
			}
		});

		$(document).on('input', ".width, .height, .cutting_lose_percentage", function (e) {

			var current = $(this);
			var product_row = current.parents(".attributes_table").data('id');
			var row_id = current.parents(".attribute-content-div").data('id');

			if(current.attr('id') == 'width')
			{
				var width = current.val();
				width = width.replace(/\,/g, '.');

				var height = $('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.height').val();
				height = height.replace(/\,/g, '.');

				var cutting_lose_percentage = $('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.cutting_lose_percentage').val();
			}
			else if(current.attr('id') == 'height')
			{
				var height = current.val();
				height = height.replace(/\,/g, '.');
				
				var width = $('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.width').val();
				width = width.replace(/\,/g, '.');

				var cutting_lose_percentage = $('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.cutting_lose_percentage').val();
			}
			else
			{
				var cutting_lose_percentage = current.val();

				var width = $('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.width').val();
				width = width.replace(/\,/g, '.');

				var height = $('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.height').val();
				height = height.replace(/\,/g, '.');
			}
			
			var box_quantity = $('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.box_quantity_supplier').val();

			if (width && height && cutting_lose_percentage && box_quantity) {

				var total_quantity = ((width/100) * (height/100) * (1 + (cutting_lose_percentage/100)));
				total_quantity = parseFloat(total_quantity).toFixed(2);
				var total_boxes = total_quantity/box_quantity;
				total_boxes = parseFloat(total_boxes).toFixed(2);

				$('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.box_quantity').val(total_boxes);
				$('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.total_boxes').val(total_quantity);

			}
			else
            {
                $('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.box_quantity').val('');
				$('#menu2').find(`.attributes_table[data-id='${product_row}']`).find(`.attribute-content-div[data-id='${row_id}']`).find('.total_boxes').val('');
            }

		});

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
						'                                                                                            <label style="margin-right: 10px;margin-bottom: 0">Childsafe Answer</label>\n' +
						'                                                                                            <select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control childsafe-answer" name="childsafe_answer' + row_id + '">\n' +
						'                                                                                                    <option value="1">Make it childsafe</option>\n' +
						'                                                                                                    <option value="2">Yes i agree</option>\n' +
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
						'                                                                                            <label style="margin-right: 10px;margin-bottom: 0;">Childsafe Answer</label>\n' +
						'                                                                                            <select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control childsafe-answer" name="childsafe_answer' + row_id + '">\n' +
						'                                                                                                    <option value="3">Is childsafe</option>\n' +
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
				$('#menu1').find(`[data-id='${row_id}']`).find('.childsafe-question-box').find('.childsafe-select').append('<option value="2">Add childsafety clip</option>');
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
						'                                                                                            <label style="margin-right: 10px;margin-bottom: 0;">Childsafe Answer</label>\n' +
						'                                                                                            <select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control childsafe-answer" name="childsafe_answer' + row_id + '">\n' +
						'                                                                                                    <option value="3">Is childsafe</option>\n' +
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
						'                                                                                            <label style="margin-right: 10px;margin-bottom: 0">Childsafe Answer</label>\n' +
						'                                                                                            <select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control childsafe-answer" name="childsafe_answer' + row_id + '">\n' +
						'                                                                                                    <option value="1">Make it childsafe</option>\n' +
						'                                                                                                    <option value="2">Yes i agree</option>\n' +
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
					text: 'Kindly fill both childsafe values first.',
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

						if (data[0] && data[0].max_size) {
							var sq = (width * height) / 10000;
							var max_size = data[0].max_size;

							if (sq > max_size) {
								Swal.fire({
									icon: 'error',
									title: '{{__('text.Oops...')}}',
									text: 'Area is greater than max size: ' + max_size,
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

@endsection
