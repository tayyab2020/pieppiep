@extends('layouts.handyman')

@section('content')

<div class="right-side">

	<div class="container-fluid">
		<div class="row">

			<form id="form-quote" style="padding: 0;" class="form-horizontal" action="{{route('store-new-order')}}"
				method="POST" enctype="multipart/form-data">
				{{csrf_field()}}

                @if(Route::currentRouteName() == 'edit-order')

                    <input type="hidden" name="supplier_id" value="{{$invoice[0]->supplier_id}}">

                @endif

                <input type="hidden" id="quotation_id" name="quotation_id" value="{{$check->quotation_id}}">
                <input type="hidden" name="customer" value="{{$check->customer_details}}">
                <input type="hidden" name="quotation_invoice_number" value="{{$check->quotation_invoice_number}}">
                <input type="hidden" name="created_at" value="{{$check->created_at}}">
                <input type="hidden" id="form_type" name="form_type" value="{{Route::currentRouteName() == 'view-order' ? 1 : 2}}">
				<input type="hidden" id="category" name="category" value="{{$check->form_type}}">

				<div style="margin: 0;" class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<!-- Starting of Dashboard data-table area -->
						<div class="section-padding add-product-1" style="padding: 0;">

							<div style="margin: 0;" class="row">
								<div style="padding: 0;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div style="box-shadow: none;" class="add-product-box">
										<div style="align-items: center;" class="add-product-header products">

                                            @if(Route::currentRouteName() == 'edit-order')

                                                <h2 style="margin-top: 0;">{{__('text.Edit Order')}}</h2>

                                            @else

                                                <h2 style="margin-top: 0;">{{__('text.View Order')}}</h2>

                                            @endif

											@if(Auth::guard('user')->user()->role_id == 2)

											<div style="display: flex;">

												@if(Route::currentRouteName() == 'view-order' && !$check->order_sent && $check->accepted && !$check->processing && !$check->finished)

													<button type="button" class="btn btn-success send-order" style="margin-right: 10px;">{{__('text.Send Order')}}</button>

												@endif
												
												<div style="background-color: black;border-radius: 10px;padding: 0 10px;">

													@if(!$check->order_sent && !$check->processing && !$check->finished)

													<span class="tooltip1 save-data" style="cursor: pointer;font-size: 20px;margin-right: 10px;color: white;">
														<i class="fa fa-fw fa-save"></i>
														<span class="tooltiptext">{{__('text.Save')}}</span>
													</span>

													@endif

													<a href="{{route('customer-quotations')}}" class="tooltip1" style="cursor: pointer;font-size: 20px;color: white;">
														<i class="fa fa-fw fa-close"></i>
														<span class="tooltiptext">{{__('text.Close')}}</span>
													</a>

												</div>

											</div>

											@endif


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

                                                                @if(Route::currentRouteName() == 'view-order')

																	@if(Auth::guard('user')->user()->role_id == 2)
																		
																		<div class="headings" style="width: 11%;">{{__('text.Supplier')}}</div>
																		
																	@endif

                                                                    <div class="headings" style="width: 11%;">{{__('text.Product')}}</div>

                                                                @else

                                                                    <div class="headings" style="width: 22%;">{{__('text.Product')}}</div>

                                                                @endif

                                                                <div class="headings" style="width: 15%;">{{__('text.Color')}}</div>
                                                                <div class="headings" style="width: 15%;">{{__('text.Model')}}</div>
                                                                <div class="headings" style="width: 15%;">{{__('text.Width')}}</div>
                                                                <div class="headings" style="width: 15%;">{{__('text.Height')}}</div>
                                                                <div class="headings" @if(Auth::guard('user')->user()->role_id == 2) style="width: 16%;" @else style="width: 27%;" @endif></div>

                                                            </div>

                                                            @foreach($invoice as $i => $item)

                                                                <div @if($i==0) class="content-div active" @else class="content-div" @endif data-id="{{$i+1}}">

                                                                    <div class="content full-res item1" style="width: 2%;">
                                                                        <label class="content-label">Sr. No</label>
                                                                        <div style="padding: 0 5px;" class="sr-res">{{$i+1}}</div>
                                                                    </div>

                                                                    <input type="hidden" value="{{$item->order_number}}" id="order_number" name="order_number[]">
                                                                    <input type="hidden" value="{{$i+1}}" id="row_id" name="row_id[]">
                                                                    <input type="hidden" value="{{$item->childsafe ? 1 : 0}}" id="childsafe" name="childsafe[]">
                                                                    <input type="hidden" value="{{$item->ladderband ? 1 : 0}}" id="ladderband" name="ladderband[]">
                                                                    <input type="hidden" value="{{$item->ladderband_value ? $item->ladderband_value : 0}}" id="ladderband_value" name="ladderband_value[]">
                                                                    <input type="hidden" value="{{$item->ladderband_price_impact ? $item->ladderband_price_impact : 0}}" id="ladderband_price_impact" name="ladderband_price_impact[]">
                                                                    <input type="hidden" value="{{$item->ladderband_impact_type ? $item->ladderband_impact_type : 0}}" id="ladderband_impact_type" name="ladderband_impact_type[]">
                                                                    <input type="hidden" value="0" id="area_conflict" name="area_conflict[]">
                                                                    <input type="hidden" value="{{$item->delivery_days}}" id="delivery_days" name="delivery_days[]">
                                                                    <input type="hidden" value="{{$item->price_based_option}}" id="price_based_option" name="price_based_option[]">

                                                                    @if(Route::currentRouteName() == 'view-order')

																		@if(Auth::guard('user')->user()->role_id == 2)

																			<div style="width: 11%;" class="suppliers content item16 full-res">

                                                                            	<label class="content-label">Supplier</label>

                                                                            	<select name="suppliers[]" class="js-data-example-ajax4">

                                                                                	<option value=""></option>

                                                                                	@foreach($suppliers as $key)

                                                                                    	<option {{$key->id == $item->supplier_id ? 'selected' : null}} value="{{$key->id}}">{{$key->company_name}}</option>

                                                                                	@endforeach

                                                                            	</select>

                                                                        	</div>

																		@endif

                                                                        <div style="width: 11%;" class="products content item3 full-res">

                                                                            <label class="content-label">Product</label>

                                                                            <select name="products[]" class="js-data-example-ajax">

                                                                                <option value=""></option>

                                                                                @foreach($supplier_products[$i] as $key)

                                                                                    <option {{$key->id == $item->product_id ? 'selected' : null}} value="{{$key->id}}">{{$key->title}}</option>

                                                                                @endforeach

                                                                            </select>

                                                                        </div>

                                                                    @else

                                                                        <div style="width: 22%;" class="products content item3 full-res">

                                                                            <label class="content-label">Product</label>

                                                                            <select name="products[]" class="js-data-example-ajax">

                                                                                <option value=""></option>

                                                                                @foreach($products as $key)

                                                                                    <option {{$key->id == $item->product_id ? 'selected' : null}} value="{{$key->id}}">{{$key->title}}</option>

                                                                                @endforeach

                                                                            </select>

                                                                        </div>

                                                                    @endif


                                                                    <div style="width: 15%;" class="color content item12">

                                                                        <label class="content-label">Color</label>

                                                                        <select name="colors[]" class="js-data-example-ajax2">

                                                                            <option value=""></option>

                                                                            @foreach($colors[$i] as $color)

                                                                                <option {{$color->id == $item->color ? 'selected' : null}} value="{{$color->id}}">{{$color->title}}</option>

                                                                            @endforeach

                                                                        </select>

                                                                    </div>


                                                                    <div style="width: 15%;" class="model content item13">

                                                                        <label class="content-label">Model</label>

                                                                        <select name="models[]" class="js-data-example-ajax3">

                                                                            <option value=""></option>

                                                                            @foreach($models[$i] as $model)

                                                                                <option {{$model->id == $item->model_id ? 'selected' : null}} value="{{$model->id}}">{{$model->model}}</option>

                                                                            @endforeach

                                                                        </select>

                                                                    </div>

                                                                    <div class="width item4 content" style="width: 15%;">

                                                                        <label class="content-label">Width</label>

                                                                        <div class="m-box">
                                                                            <input {{$item->price_based_option == 3 ? 'readonly' : null}} value="{{str_replace('.', ',', floatval($item->width))}}" class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="width[]" type="text">
                                                                            <input style="border: 0;outline: none;" readonly type="text" name="width_unit[]" class="measure-unit" value="{{$item->width_unit}}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="height item5 content" style="width: 15%;">

                                                                        <label class="content-label">Height</label>

                                                                        <div class="m-box">
                                                                            <input {{$item->price_based_option == 2 ? 'readonly' : null}} value="{{str_replace('.', ',', floatval($item->height))}}" class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="height[]" type="text">
                                                                            <input style="border: 0;outline: none;" readonly type="text" name="height_unit[]" class="measure-unit" value="{{$item->height_unit}}">
                                                                        </div>
                                                                    </div>

                                                                    <div class="content item10 last-content" id="next-row-td" @if(Auth::guard('user')->user()->role_id == 2) style="padding: 0;width: 16%;" @else style="padding: 0;width: 27%;" @endif>

																		@if(Auth::guard('user')->user()->role_id == 2 && !$check->order_sent && !$check->processing && !$check->finished)

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

                                                                </div>

                                                            @endforeach

                                                        </section>

													</div>

													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"
														style="background: white;padding: 15px 0 0 0;">

														<ul style="border: 0;" class="nav nav-tabs feature-tab">
															<li style="margin-bottom: 0;" class="active"><a
																	style="border: 0;border-bottom: 3px solid rgb(151, 140, 135);padding: 10px 30px;"
																	data-toggle="tab" href="#menu1"
																	aria-expanded="false">{{__('text.Features')}}</a></li>
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
																				style="margin-right: 10px;margin-bottom: 0;">{{__('text.Quantity')}}</label>
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

																				<option value="">{{__('text.Select any option')}}</option>

																				@if($key1->childsafe_diff <= 150)
																					
																					<option {{$key1->childsafe_question == 1 ? 'selected' : null}} value="1">{{__('text.Please note not childsafe')}}</option>
																					<option {{$key1->childsafe_question == 2 ? 'selected' : null}} value="2">{{__('text.Add childsafety clip')}}</option>

																					@else

																					<option {{$key1->childsafe_question == 2 ? 'selected' : null}} value="2">{{__('text.Add childsafety clip')}}</option>
																					<option {{$key1->childsafe_question == 3 ? 'selected' : null}} value="3">{{__('text.Yes childsafe')}}</option>

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
																			<label style="margin-right: 10px;margin-bottom: 0;">{{__('text.Childsafe Answer')}}</label>
																			<select
																				style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;"
																				class="form-control childsafe-answer"
																				name="childsafe_answer{{$x+1}}">
																				
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
																				<option {{$feature->ladderband == 0 ? 'selected' : null}} value="0">{{__('text.No')}}</option>
																				<option {{$feature->ladderband == 1 ? 'selected' : null}} value="1">{{__('text.Yes')}}</option>
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

																				<option value="0">{{__('text.Select Feature')}}</option>

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

																				<option value="0">{{__('text.Select Feature')}}</option>

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

<div id="myModal3" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<form id="send-order-form" action="{{route('send-new-order')}}" method="POST" enctype="multipart/form-data">
			{{csrf_field()}}

			<input type="hidden" name="quotation_id1" id="quotation_id1">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">{{__('text.Order Mail Body')}}</h4>
				</div>
				<div class="modal-body">

					<div style="margin: 20px 0;" class="row">
						<div style="display: flex;flex-direction: column;align-items: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<label>{{__('text.Subject')}}:</label>
							<input type="text" name="mail_subject1" class="form-control">
						</div>
					</div>

					<div style="margin: 20px 0;" class="row">
						<div style="display: flex;flex-direction: column;align-items: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<label>{{__('text.Text')}}:</label>
							<input type="hidden" name="mail_body1">
							<div class="summernote"></div>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button style="border: 0;outline: none;background-color: #5cb85c !important;" type="button" class="btn btn-primary submit-form1">{{__('text.Submit')}}</button>
				</div>
			</div>

		</form>

	</div>
</div>

<div id="cover"></div>


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
            'item16 item16 item16 item16 item16 item16'
    		'item3 item3 item3 item3 item3 item3'
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

		.sr-res
		{
			background: white;
			height: 35px;
			display: flex;
			align-items: center;
			border-radius: 4px;
			border: 1px solid #d6d6d6;
		}

		.select2-container--default .select2-selection--single
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

	.m-box {
		display: flex;
		align-items: center;
	}

	.select2-container--default .select2-selection--single {
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

<script type="text/javascript">


	$(document).ready(function () {

		$('.summernote').summernote({
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['style']],
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                /*['color', ['color']],*/
                ['fontname', ['fontname']],
                ['forecolor', ['forecolor']],
            ],
            height: 200,   //set editable area's height
            codemirror: { // codemirror options
                theme: 'monokai'
            },
            callbacks: {
                onChange: function(contents, $editable) {
                    $(this).prev('input').val(contents);
                }
            }
        });

		$(".send-order").on('click', function (e) {

            var id = $('#quotation_id').val();

            $.ajax({

                type: "GET",
                data: "id=" + id + '&type=order',
                url: "<?php echo url('/aanbieder/get-customer-email')?>",

                success: function (data) {

                    $('#quotation_id1').val(id);
                    $("[name='mail_subject1']").val(data[1]);
                    $("[name='mail_body1']").val(data[2]);
                    $('#myModal3').find(".note-editable").html(data[2]);
                    $('#myModal3').modal('toggle');
                    $('.modal-backdrop').hide();

                },
                error: function (data) {


                }

            });

        });

		$(document).on('click', '.submit-form1', function () {

            var flag = 0;

            if(!$("[name='mail_subject1']").val())
            {
                $("[name='mail_subject1']").css('border','1px solid red');
                flag = 1;
            }
            else{
                $("[name='mail_subject1']").css('border','');
            }

            if(!$("[name='mail_body1']").val())
            {
                $('#myModal3').find(".note-editable").css('border','1px solid red');
                flag = 1;
            }
            else{
                $('#myModal3').find(".note-editable").css('border','');
            }

            if(!flag)
            {
				Swal.fire({
					title: '{{__('text.Are you sure?')}}',
					text: '{{__('text.Make sure to save your changes first before sending the order!')}}',
					icon: 'question',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: '{{__('text.Yes')}}!',
					cancelButtonText: '{{__('text.Cancel')}}',
				}).then((result) => {
					if (result.value) {
		
						$('#send-order-form').submit();
		
					}
				});
            }

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

        $(".js-data-example-ajax4").select2({
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

        $(document).on('change', ".js-data-example-ajax4", function (e) {

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

                    $('#products_table').find(`[data-id='${row_id}']`).find('#childsafe').val(0);
                    $('#products_table').find(`[data-id='${row_id}']`).find('#ladderband').val(0);
                    $('#products_table').find(`[data-id='${row_id}']`).find('#ladderband_value').val(0);
                    $('#products_table').find(`[data-id='${row_id}']`).find('#ladderband_price_impact').val(0);
                    $('#products_table').find(`[data-id='${row_id}']`).find('#ladderband_impact_type').val(0);
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

						$('#products_table').find(`[data-id='${row_id}']`).find('#delivery_days').val(data.delivery_days);
						$('#products_table').find(`[data-id='${row_id}']`).find('#ladderband').val(data.ladderband);
						$('#products_table').find(`[data-id='${row_id}']`).find('#ladderband_value').val(data.ladderband_value);
						$('#products_table').find(`[data-id='${row_id}']`).find('#ladderband_price_impact').val(data.ladderband_price_impact);
						$('#products_table').find(`[data-id='${row_id}']`).find('#ladderband_impact_type').val(data.ladderband_impact_type);
						$('#products_table').find(`[data-id='${row_id}']`).find('#price_based_option').val(data.price_based_option);
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

				}
			});

            $('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').hide();
            $('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').css('visibility','visible');
            $('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').show();

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

			var width = $('#products_table').find(`[data-id='${row_id}']`).find('.width').find('.m-input').val();
			width = width.replace(/\,/g, '.');

			var height = $('#products_table').find(`[data-id='${row_id}']`).find('.height').find('.m-input').val();
			height = height.replace(/\,/g, '.');

			var product = $('#products_table').find(`[data-id='${row_id}']`).find('.products').find('select').val();
			var ladderband = $('#products_table').find(`[data-id='${row_id}']`).find('#ladderband').val();
			$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(0);

			if (width && height && color && model && product) {

				var margin = 0;

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

								$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(3);
							}
							else if (data[0].value === 'x_axis') {
								Swal.fire({
									icon: 'error',
									title: '{{__('text.Oops...')}}',
									html: '{{__('text.Width is greater than max value')}} <br> {{__('text.Max Width')}}: ' + data[0].max_width,
								});

								$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(1);
							}
							else if (data[0].value === 'y_axis') {

								Swal.fire({
									icon: 'error',
									title: '{{__('text.Oops...')}}',
									html: '{{__('text.Height is greater than max value')}} <br> {{__('text.Max Height')}}: ' + data[0].max_height,
								});

								$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(2);
							}
							else {

								$('#products_table').find(`[data-id='${row_id}']`).find('#childsafe').val(data[3].childsafe);
								var childsafe = data[3].childsafe;

								var features = '';
                                var count_features = 0;
								var f_value = 0;

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

									var opt = '<option value="0">Select Feature</option>';

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

							}
						}
						else {
                            $('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').hide();
                            $('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').css('visibility','visible');
                            $('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').show();
						}
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

			var width = $('#products_table').find(`[data-id='${row_id}']`).find('.width').find('.m-input').val();
			width = width.replace(/\,/g, '.');

			var height = $('#products_table').find(`[data-id='${row_id}']`).find('.height').find('.m-input').val();
			height = height.replace(/\,/g, '.');

			var product = $('#products_table').find(`[data-id='${row_id}']`).find('.products').find('select').val();
			var ladderband = $('#products_table').find(`[data-id='${row_id}']`).find('#ladderband').val();
			$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(0);

			if (width && height && color && model && product) {

				var margin = 1;

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
									html: '{{__('text.Quantity')}}Width & Height are greater than max values <br> {{__('text.Quantity')}}Max Width: ' + data[0].max_width + '<br> {{__('text.Quantity')}}Max Height: ' + data[0].max_height,
								});


								$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(3);
							}
							else if (data[0].value === 'x_axis') {

								Swal.fire({
									icon: 'error',
									title: '{{__('text.Oops...')}}',
									html: '{{__('text.Quantity')}}Width is greater than max value <br> {{__('text.Quantity')}}Max Width: ' + data[0].max_width,
								});

								$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(1);
							}
							else if (data[0].value === 'y_axis') {

								Swal.fire({
									icon: 'error',
									title: '{{__('text.Oops...')}}',
									html: '{{__('text.Quantity')}}Height is greater than max value <br> {{__('text.Quantity')}}Max Height: ' + data[0].max_height,
								});


								$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(2);
							}
							else {

								$('#products_table').find(`[data-id='${row_id}']`).find('#childsafe').val(data[3].childsafe);
								var childsafe = data[3].childsafe;


								var features = '';
								var count_features = 0;
								var f_value = 0;

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
							}
						}
						else {
                            $('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').hide();
                            $('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').css('visibility','visible');
                            $('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').show();
						}
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

			$('#products_table .content-div.active').removeClass('active');
			last_row.addClass('active');

			var id = last_row.data('id');

			$('#menu1').children().not(`[data-id='${id}']`).hide();
			$('#menu1').find(`[data-id='${id}']`).show();

		}

		function numbering() {
			$('#products_table .content-div').each(function (index, tr) { $(this).find('.content:eq(0)').find('.sr-res').text(index + 1); });
		}

		function add_row(copy = false, suppliers = null, supplier = null, products = null, product = null, colors = null, color = null, models = null, model = null, width = null, width_unit = null, height = null, height_unit = null, features = null, features_selects = null, childsafe_question = null, childsafe_answer = null, qty = null, childsafe = 0, ladderband = 0, ladderband_value = 0, ladderband_price_impact = 0, ladderband_impact_type = 0, area_conflict = 0, subs = null, childsafe_x = null, childsafe_y = null, delivery_days = null, price_based_option = null, width_readonly = null, height_readonly = null, last_column = null) {

		    var form_type = $('#form_type').val();
			var rowCount = $('#products_table .content-div:last').data('id');
			rowCount = rowCount + 1;

			var r_id = $('#products_table .content-div:last').find('.content:eq(0)').find('.sr-res').text();
			r_id = parseInt(r_id) + 1;

			if (!copy) {

			    if(form_type == 1)
                {
                    var sup_prod = '                                                 <div style="width: 11%;" class="suppliers content item16 full-res">\n' +
                        '\n' +
                        '                       									 	<label class="content-label">Supplier</label>\n' +
                        '\n' +
                        '                                                                <select name="suppliers[]" class="js-data-example-ajax4">\n' +
                        '\n' +
                        '                                                                    <option value=""></option>\n' +
                        '\n' +
                        '                                                                    @foreach($suppliers as $key)\n' +
                        '\n' +
                        '                                                                        <option value="{{$key->id}}">{{$key->company_name}}</option>\n' +
                        '\n' +
                        '                                                                    @endforeach\n' +
                        '\n' +
                        '                                                                </select>\n' +
                        '                                                            </div>\n' +
                        '\n' +
                        '                                                            <div style="width: 11%;" class="products content item3 full-res">\n' +
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
                        '                                                            </div>\n';
                }
			    else
                {
                    var sup_prod = '                                                 <div style="width: 22%;" class="products content item3 full-res">\n' +
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
                        '                                                            </div>\n';
                }

				$("#products_table").append('<div class="content-div" data-id="' + rowCount + '">\n' +
					'                                                            <div class="content full-res item1" style="width: 2%;">\n' +
                    '                       									 	<label class="content-label">Sr. No</label>\n' +
					'                       									 	<div style="padding: 0 5px;" class="sr-res">' + r_id + '</div>\n' +
					'                       									 </div>\n' +
					'\n' +
                    '                                                            <input type="hidden" value="" id="order_number" name="order_number[]">\n' +
                    '                                                            <input type="hidden" value="' + rowCount + '" id="row_id" name="row_id[]">\n' +
					'                                                            <input type="hidden" value="0" id="childsafe" name="childsafe[]">\n' +
					'                                                            <input type="hidden" value="0" id="ladderband" name="ladderband[]">\n' +
					'                                                            <input type="hidden" value="0" id="ladderband_value" name="ladderband_value[]">\n' +
					'                                                            <input type="hidden" value="0" id="ladderband_price_impact" name="ladderband_price_impact[]">\n' +
					'                                                            <input type="hidden" value="0" id="ladderband_impact_type" name="ladderband_impact_type[]">\n' +
					'                                                            <input type="hidden" value="0" id="area_conflict" name="area_conflict[]">\n' +
					'                                                            <input type="hidden" value="1" id="delivery_days" name="delivery_days[]">\n' +
					'                                                            <input type="hidden" id="price_based_option" name="price_based_option[]">\n' +
					'\n' +
					sup_prod +
                    '\n' +
					'                                                            <div style="width: 15%;" class="color content item12">\n' +
					'\n' +
					'                       									 	<label class="content-label">Color</label>\n' +
					'\n' +
					'                                                                <select name="colors[]" class="js-data-example-ajax2">\n' +
					'\n' +
					'                                                                    <option value=""></option>\n' +
					'\n' +
					'                                                                </select>\n' +
					'                                                            </div>\n' +
                    '\n' +
					'                                                            <div style="width: 15%;" class="model content item13">\n' +
					'\n' +
					'                       									 	<label class="content-label">Model</label>\n' +
					'\n' +
					'                                                                <select name="models[]" class="js-data-example-ajax3">\n' +
					'\n' +
					'                                                                    <option value=""></option>\n' +
					'\n' +
					'                                                                </select>\n' +
					'                                                            </div>\n' +
					'\n' +
					'                                                            <div class="width item4 content" style="width: 15%;">\n' +
					'\n' +
					'                       									 	<label class="content-label">Width</label>\n' +
					'\n' +
					'                                                                <div class="m-box">\n' +
					'                                                                	<input value="0" class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="width[]" type="text">\n' +
					'                                                                   <input style="border: 0;outline: none;" readonly type="text" name="width_unit[]" class="measure-unit" value="cm">\n' +
					'                                                                </div>\n' +
					'                                                            </div>\n' +
					'\n' +
					'                                                            <div class="height item5 content" style="width: 15%;">\n' +
					'\n' +
					'                       									 	<label class="content-label">Height</label>\n' +
					'\n' +
					'                                                                <div class="m-box">\n' +
					'                                                                	<input value="0" class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="height[]" type="text">\n' +
					'                                                                	<input style="border: 0;outline: none;" readonly type="text" name="height_unit[]" class="measure-unit" value="cm">\n' +
					'                                                                </div>\n' +
					'                                                            </div>\n' +
					'\n' +
					'                                                            <div class="content item10 last-content" id="next-row-td" style="padding: 0;width: 16%;">\n' +
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

                last_row.find(".js-data-example-ajax4").select2({
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

                if(form_type == 1)
                {
                    var sup_prod = '                                                 <div style="width: 11%;" class="suppliers content item16 full-res">\n' +
                        '\n' +
                        '                       									 	<label class="content-label">Supplier</label>\n' +
                        '\n' +
                        '                                                                <select name="suppliers[]" class="js-data-example-ajax4">\n' +
                        '\n' +
                        suppliers +
                        '\n' +
                        '                                                                </select>\n' +
                        '                                                            </div>\n' +
                        '\n' +
                        '                                                            <div style="width: 11%;" class="products content item3 full-res">\n' +
                        '\n' +
                        '                       									 	<label class="content-label">Product</label>\n' +
                        '\n' +
                        '                                                                <select name="products[]" class="js-data-example-ajax">\n' +
                        '\n' +
                        products +
                        '\n' +
                        '                                                                </select>\n' +
                        '                                                            </div>\n';
                }
                else
                {
                    var sup_prod = '                                                 <div style="width: 22%;" class="products content item3 full-res">\n' +
                        '\n' +
                        '                       									 	<label class="content-label">Product</label>\n' +
                        '\n' +
                        '                                                                <select name="products[]" class="js-data-example-ajax">\n' +
                        '\n' +
                        products +
                        '\n' +
                        '                                                                </select>\n' +
                        '                                                            </div>\n';
                }

				$("#products_table").append('<div class="content-div" data-id="' + rowCount + '">\n' +
					'                                                            <div class="content full-res item1" style="width: 2%;">\n' +
                    '                       									 	<label class="content-label">Sr. No</label>\n' +
					'                       									 	<div style="padding: 0 5px;" class="sr-res">' + r_id + '</div>\n' +
					'                       									 </div>\n' +
					'\n' +
                    '                                                            <input type="hidden" value="" id="order_number" name="order_number[]">\n' +
					'                                                            <input type="hidden" value="' + rowCount + '" id="row_id" name="row_id[]">\n' +
					'                                                            <input type="hidden" value="' + childsafe + '" id="childsafe" name="childsafe[]">\n' +
					'                                                            <input type="hidden" value="' + ladderband + '" id="ladderband" name="ladderband[]">\n' +
					'                                                            <input type="hidden" value="' + ladderband_value + '" id="ladderband_value" name="ladderband_value[]">\n' +
					'                                                            <input type="hidden" value="' + ladderband_price_impact + '" id="ladderband_price_impact" name="ladderband_price_impact[]">\n' +
					'                                                            <input type="hidden" value="' + ladderband_impact_type + '" id="ladderband_impact_type" name="ladderband_impact_type[]">\n' +
					'                                                            <input type="hidden" value="' + area_conflict + '" id="area_conflict" name="area_conflict[]">\n' +
					'                                                            <input type="hidden" value="' + delivery_days + '" id="delivery_days" name="delivery_days[]">\n' +
					'                                                            <input type="hidden" value="' + price_based_option + '" id="price_based_option" name="price_based_option[]">\n' +
					'\n' +
                    sup_prod +
                    '\n' +
                    '                       									 	<div style="width: 15%;" class="color content item12">\n' +
					'\n' +
					'																	<label class="content-label">Color</label>\n' +
					'\n' +
					'                                                                	<select name="colors[]" class="js-data-example-ajax2">\n' +
					'\n' +
					colors +
					'\n' +
					'                                                                	</select>\n' +
					'\n' +
					'																</div>\n' +
					'\n' +
					'																<div style="width: 15%;" class="model content item13">\n' +
					'\n' +
					'																	<label class="content-label">Model</label>\n' +
					'\n' +
					'                                                                	<select name="models[]" class="js-data-example-ajax3">\n' +
					'\n' +
					models +
					'\n' +
					'                                                                	</select>\n' +
					'\n' +
					'																</div>\n' +
					'\n' +
					'                                                            <div class="width item4 content" style="width: 15%;">\n' +
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
					'                                                            <div class="height item5 content" style="width: 15%;">\n' +
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
					'                                                            <div class="content item10 last-content" id="next-row-td" style="padding: 0;width: 16%;">\n' +
					'\n' +
					last_column +
					'\n' +
					'                                                            </div>\n' +
					'\n' +
					'                                                        </div>');

				var last_row = $('#products_table .content-div:last');

				last_row.find('.js-data-example-ajax').val(product);
                last_row.find('.js-data-example-ajax4').val(supplier);
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

                last_row.find(".js-data-example-ajax4").select2({
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
			}

		});

		$(document).on('click', '.save-data', function () {

			var flag = 0;

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
            var suppliers = current.find('.js-data-example-ajax4').html();
            var supplier = current.find('.js-data-example-ajax4').val();
			var products = current.find('.js-data-example-ajax').html();
			var product = current.find('.js-data-example-ajax').val();
			var colors = current.find('.js-data-example-ajax2').html();
			var color = current.find('.js-data-example-ajax2').val();
			var models = current.find('.js-data-example-ajax3').html();
			var model = current.find('.js-data-example-ajax3').val();
			var width = current.find('.width').find('.m-input').val();
			var width_unit = current.find('.width').find('.measure-unit').val();
			var height = current.find('.height').find('.m-input').val();
			var height_unit = current.find('.height').find('.measure-unit').val();
			var features = $('#menu1').find(`[data-id='${id}']`).html();
			var childsafe_question = $('#menu1').find(`[data-id='${id}']`).find('.childsafe-select').val();
			var childsafe_answer = $('#menu1').find(`[data-id='${id}']`).find('.childsafe-answer').val();
			var features_selects = $('#menu1').find(`[data-id='${id}']`).find('.feature-select');
			var qty = $('#menu1').find(`[data-id='${id}']`).find('input[name="qty[]"]').val();
			var subs = $('#myModal').find('.modal-body').find(`[data-id='${id}']`).html();
			var childsafe_x = $('#menu1').find(`[data-id='${id}']`).find('#childsafe_x').val();
			var childsafe_y = $('#menu1').find(`[data-id='${id}']`).find('#childsafe_y').val();
			var price_based_option = current.find('#price_based_option').val();
			var last_column = current.find('#next-row-td').html();

			var width_readonly = '';
			var height_readonly = '';

			if (price_based_option == 2) {
				height_readonly = 'readonly';
			}
			else if (price_based_option == 3) {
				width_readonly = 'readonly';
			}

			add_row(true, suppliers, supplier, products, product, colors, color, models, model, width, width_unit, height, height_unit, features, features_selects, childsafe_question, childsafe_answer, qty, childsafe, ladderband, ladderband_value, ladderband_price_impact, ladderband_impact_type, area_conflict, subs, childsafe_x, childsafe_y, delivery_days, price_based_option, width_readonly, height_readonly, last_column);

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

		$(document).on('keypress', ".childsafe_values", function (e) {

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

				var margin = 1;

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

								$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(3);
							}
							else if (data[0].value === 'x_axis') {

								Swal.fire({
									icon: 'error',
									title: '{{__('text.Oops...')}}',
									html: '{{__('text.Width is greater than max value')}} <br> {{__('text.Max Width')}}: ' + data[0].max_width,
								});

								$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(1);
							}
							else if (data[0].value === 'y_axis') {

								Swal.fire({
									icon: 'error',
									title: '{{__('text.Oops...')}}',
									html: '{{__('text.Height is greater than max value')}} <br> {{__('text.Max Height')}}: ' + data[0].max_height,
								});

								$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(2);
							}
							else {
								$('#products_table').find(`[data-id='${row_id}']`).find('#childsafe').val(data[3].childsafe);
								var childsafe = data[3].childsafe;

								$('#myModal').find('.modal-body').find(`[data-id='${row_id}']`).remove();


								var features = '';
								var count_features = 0;
								var f_value = 0;

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

							}
						}
						else {
                            $('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').hide();
                            $('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').css('visibility','visible');
                            $('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').show();
						}
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

                var margin = 1;

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

								$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(3);
							}
							else if (data[0].value === 'x_axis') {

								Swal.fire({
									icon: 'error',
									title: '{{__('text.Oops...')}}',
									html: '{{__('text.Width is greater than max value')}} <br> {{__('text.Max Width')}}: ' + data[0].max_width,
								});

								$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(1);
							}
							else if (data[0].value === 'y_axis') {

								Swal.fire({
									icon: 'error',
									title: '{{__('text.Oops...')}}',
									html: '{{__('text.Height is greater than max value')}} <br> {{__('text.Max Height')}}: ' + data[0].max_height,
								});

								$('#products_table').find(`[data-id='${row_id}']`).find('#area_conflict').val(2);
							}
							else {

								$('#products_table').find(`[data-id='${row_id}']`).find('#childsafe').val(data[3].childsafe);
								var childsafe = data[3].childsafe;

								$('#myModal').find('.modal-body').find(`[data-id='${row_id}']`).remove();


								var features = '';
								var count_features = 0;
								var f_value = 0;

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

							}
						}
						else {
                            $('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.green-circle').hide();
                            $('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').css('visibility','visible');
                            $('#products_table').find(`[data-id='${row_id}']`).find('#next-row-td').find('.yellow-circle').show();
						}
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
			var qty = $('#menu1').find(`[data-id='${row_id}']`).find('input[name="qty[]"]').val();

			if (id == 0) {

				if (feature_select == 1) {

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
