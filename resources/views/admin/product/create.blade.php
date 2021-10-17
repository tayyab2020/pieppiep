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
                                            <h2>{{isset($cats) ? 'Edit Product' : 'Add Product'}}</h2>
                                            <a href="{{route('admin-product-index')}}" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> Back</a>
                                        </div>

                                        <hr>

                                        @include('includes.form-error')
                                        @include('includes.form-success')

                                        <div class="product-configuration" style="width: 85%;margin: auto;">

                                            <ul style="border: 0;" class="nav nav-tabs">
                                                <li style="margin-bottom: 0;" class="active"><a data-toggle="tab" href="#menu1">General Information</a></li>
                                                {{--<li style="margin-bottom: 0;"><a data-toggle="tab" href="#menu2">General Options</a></li>--}}
                                                <li style="margin-bottom: 0;"><a data-toggle="tab" href="#menu3">Colors Options</a></li>
                                                <li style="margin-bottom: 0;"><a data-toggle="tab" href="#menu4">Price Tables</a></li>
                                                <li style="margin-bottom: 0;"><a data-toggle="tab" href="#menu5">Features</a></li>
                                                <li style="margin-bottom: 0;"><a data-toggle="tab" href="#menu6">Price Control</a></li>
                                                <li style="margin-bottom: 0;"><a data-toggle="tab" href="#menu7">Models</a></li>
                                            </ul>

                                            <form id="product_form" style="padding: 0;" class="form-horizontal" action="{{route('admin-product-store')}}" method="POST" enctype="multipart/form-data">

                                                {{csrf_field()}}

                                                <input type="hidden" id="submit_check" value="0">
                                                <input type="hidden" name="cat_id" value="{{isset($cats) ? $cats->id : null}}" />

                                                <div style="padding: 40px 15px 20px 15px;border: 1px solid #24232329;" class="tab-content">

                                                    <div id="menu1" class="tab-pane fade in active">


                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_display_name">Margin (%)*</label>
                                                            <div class="col-sm-6">
                                                                <input min="100" value="{{isset($cats) ? $cats->margin : null}}" class="form-control" name="margin" id="margin_input" placeholder="Enter Product margin" required step="1" type="number">
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_display_name">Title*</label>
                                                            <div class="col-sm-6">
                                                                <input value="{{isset($cats) ? $cats->title : null}}" class="form-control" name="title" id="blood_group_display_name" placeholder="Enter Product title" required="" type="text">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Slug*</label>
                                                            <div class="col-sm-6">
                                                                <input value="{{isset($cats) ? $cats->slug : null}}" class="form-control" name="slug" id="blood_group_slug" placeholder="Enter Product Slug" required="" type="text">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Model Number</label>
                                                            <div class="col-sm-6">
                                                                <input value="{{isset($cats) ? $cats->model_number : null}}" class="form-control" name="model_number" id="blood_group_slug" placeholder="Enter Model Number" type="text">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Size</label>
                                                            <div class="col-sm-6">
                                                                <input value="{{isset($cats) ? $cats->size : null}}" class="form-control" name="size" id="blood_group_slug" placeholder="Enter Size" type="text">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Measure</label>
                                                            <div class="col-sm-6">
                                                                <input value="{{isset($cats) ? $cats->measure : null}}" class="form-control" name="measure" id="blood_group_slug" placeholder="Enter Measure" type="text">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Estimated Price</label>
                                                            <div class="col-sm-6">
                                                                <input value="{{isset($cats) ? $cats->estimated_price : null}}" class="form-control" name="estimated_price" id="blood_group_slug" placeholder="Enter Estimated Price" type="text">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Additional Info</label>
                                                            <div class="col-sm-6">
                                                                <input value="{{isset($cats) ? $cats->additional_info : null}}" class="form-control" name="additional_info" id="blood_group_slug" placeholder="Enter Additional Info" type="text">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Floor Type</label>
                                                            <div class="col-sm-6">
                                                                <input value="{{isset($cats) ? $cats->floor_type : null}}" class="form-control" name="floor_type" id="blood_group_slug" placeholder="Enter Floor Type" type="text">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Floor Type 2</label>
                                                            <div class="col-sm-6">
                                                                <input value="{{isset($cats) ? $cats->floor_type2 : null}}" class="form-control" name="floor_type2" id="blood_group_slug" placeholder="Enter Floor Type 2" type="text">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Supplier</label>
                                                            <div class="col-sm-6">
                                                                <input value="{{isset($cats) ? $cats->supplier : null}}" class="form-control" name="supplier" id="blood_group_slug" placeholder="Enter Supplier" type="text">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Color</label>
                                                            <div class="col-sm-6">
                                                                <input value="{{isset($cats) ? $cats->color : null}}" class="form-control" name="color" id="blood_group_slug" placeholder="Enter Color" type="text">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Delivery Time (In Days)*</label>
                                                            <div class="col-sm-6">
                                                                <select class="js-data-example-ajax6 form-control" style="height: 40px;" name="delivery_days" id="blood_grp" required>

                                                                    <option @if(isset($cats)) @if($cats->delivery_days == 1) selected @endif @endif value="1">1</option>
                                                                    <option @if(isset($cats)) @if($cats->delivery_days == 2) selected @endif @endif value="2">2</option>
                                                                    <option @if(isset($cats)) @if($cats->delivery_days == 3) selected @endif @endif value="3">3</option>
                                                                    <option @if(isset($cats)) @if($cats->delivery_days == 4) selected @endif @endif value="4">4</option>
                                                                    <option @if(isset($cats)) @if($cats->delivery_days == 5) selected @endif @endif value="5">5</option>
                                                                    <option @if(isset($cats)) @if($cats->delivery_days == 6) selected @endif @endif value="6">6</option>
                                                                    <option @if(isset($cats)) @if($cats->delivery_days == 7) selected @endif @endif value="7">7</option>
                                                                    <option @if(isset($cats)) @if($cats->delivery_days == 8) selected @endif @endif value="8">8</option>
                                                                    <option @if(isset($cats)) @if($cats->delivery_days == 9) selected @endif @endif value="9">9</option>
                                                                    <option @if(isset($cats)) @if($cats->delivery_days == 10) selected @endif @endif value="10">10</option>
                                                                    <option @if(isset($cats)) @if($cats->delivery_days == 11) selected @endif @endif value="11">11</option>
                                                                    <option @if(isset($cats)) @if($cats->delivery_days == 12) selected @endif @endif value="12">12</option>
                                                                    <option @if(isset($cats)) @if($cats->delivery_days == 13) selected @endif @endif value="13">13</option>
                                                                    <option @if(isset($cats)) @if($cats->delivery_days == 14) selected @endif @endif value="14">14</option>
                                                                    <option @if(isset($cats)) @if($cats->delivery_days == 15) selected @endif @endif value="15">15</option>
                                                                    <option @if(isset($cats)) @if($cats->delivery_days == 16) selected @endif @endif value="16">16</option>
                                                                    <option @if(isset($cats)) @if($cats->delivery_days == 17) selected @endif @endif value="17">17</option>
                                                                    <option @if(isset($cats)) @if($cats->delivery_days == 18) selected @endif @endif value="18">18</option>
                                                                    <option @if(isset($cats)) @if($cats->delivery_days == 19) selected @endif @endif value="19">19</option>
                                                                    <option @if(isset($cats)) @if($cats->delivery_days == 20) selected @endif @endif value="20">20</option>
                                                                    <option @if(isset($cats)) @if($cats->delivery_days == 21) selected @endif @endif value="21">21</option>

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Category*</label>
                                                            <div class="col-sm-6">
                                                                <select class="js-data-example-ajax form-control" style="height: 40px;" name="category_id" id="blood_grp" required>

                                                                    <option value="">Select Category</option>

                                                                    @foreach($categories as $key)
                                                                        <option @if(isset($cats)) @if($cats->category_id == $key->id) selected @endif @endif value="{{$key->id}}">{{$key->cat_name}}</option>
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Brand*</label>
                                                            <div class="col-sm-6">
                                                                <select class="js-data-example-ajax1 form-control" style="height: 40px;" name="brand_id" id="blood_grp" required>

                                                                    <option value="">Select Brand</option>

                                                                    @foreach($brands as $key)
                                                                        <option @if(isset($cats)) @if($cats->brand_id == $key->id) selected @endif @endif value="{{$key->id}}">{{$key->cat_name}}</option>
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                        </div>

                                                        {{--<div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Model*</label>
                                                            <div class="col-sm-6">
                                                                <select class="js-data-example-ajax2 form-control" style="height: 40px;" name="model_id" id="blood_grp" required>

                                                                    <option value="">Select Model</option>

                                                                    @if(isset($cats))

                                                                        @foreach($models as $key)

                                                                            <option @if($cats->model_id == $key->id) selected @endif value="{{$key->id}}">{{$key->cat_name}}</option>

                                                                        @endforeach

                                                                    @endif

                                                                </select>
                                                            </div>
                                                        </div>--}}

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="service_description">Product Description</label>
                                                            <div class="col-sm-6">
                                                                <textarea class="form-control" name="description" id="service_description" rows="5" style="resize: vertical;" placeholder="Enter Product Description">{{isset($cats) ? $cats->description : null}}</textarea>
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="current_photo">Current Photo*</label>
                                                            <div class="col-sm-6">
                                                                <img width="130px" height="90px" id="adminimg" src="{{isset($cats->photo) ? asset('assets/images/'.$cats->photo):'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG'}}" alt="">
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="profile_photo">Add Photo</label>
                                                            <div class="col-sm-6">
                                                                <input type="file" id="uploadFile" class="hidden" name="photo" value="">
                                                                <button type="button" id="uploadTrigger" onclick="uploadclick()" class="form-control"><i class="fa fa-download"></i> Add Category Photo</button>
                                                                <p>Prefered Size: (600x600) or Square Sized Image</p>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    {{--<div id="menu2" class="tab-pane fade">

                                                        <input type="hidden" name="cat_id" value="{{isset($cats) ? $cats->id : null}}" />

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_display_name">Min Height</label>
                                                            <div class="col-sm-6">
                                                                <input value="{{isset($cats) ? $cats->min_height : null}}" class="form-control" name="min_height" id="blood_group_display_name" placeholder="" type="text">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Max Height</label>
                                                            <div class="col-sm-6">
                                                                <input value="{{isset($cats) ? $cats->max_height : null}}" class="form-control" name="max_height" id="blood_group_slug" placeholder="" type="text">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Min Width</label>
                                                            <div class="col-sm-6">
                                                                <input value="{{isset($cats) ? $cats->min_width : null}}" class="form-control" name="min_width" id="blood_group_slug" placeholder="" type="text">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Max Width</label>
                                                            <div class="col-sm-6">
                                                                <input value="{{isset($cats) ? $cats->max_width : null}}" class="form-control" name="max_width" id="blood_group_slug" placeholder="" type="text">
                                                            </div>
                                                        </div>

                                                    </div>--}}

                                                    <div id="menu3" class="tab-pane fade">

                                                        <div class="color_box" style="margin-bottom: 20px;">

                                                            <input type="hidden" name="removed_colors" id="removed_colors">

                                                            @if(isset($colors_data) && count($colors_data) > 0)

                                                                @foreach($colors_data as $i => $key)

                                                                    <div class="form-group" data-id="{{$i+1}}">

                                                                        <div class="col-sm-3">

                                                                            <input value="{{$key->color}}" class="form-control color_title" name="colors[]" id="blood_group_slug" placeholder="Color Title" type="text">

                                                                        </div>

                                                                        <div class="col-sm-3">

                                                                            <input value="{{$key->color_code}}" class="form-control color_code" name="color_codes[]" id="blood_group_slug" placeholder="Color Code" type="text">

                                                                        </div>

                                                                        <div class="col-sm-2">

                                                                            <input class="form-control color_max_height" value="{{str_replace(".",",",$key->max_height)}}" maskedformat="9,1" name="color_max_height[]" id="blood_group_slug" placeholder="Max Height" type="text">

                                                                        </div>

                                                                        <div class="col-sm-3">
                                                                            <select class="form-control validate js-data-example-ajax4" name="price_tables[]">

                                                                                <option value="">Select Price Table</option>

                                                                                @foreach($tables as $table)

                                                                                    <option @if($table->id == $key->table_id) selected @endif value="{{$table->id}}">{{$table->title}}</option>

                                                                                @endforeach

                                                                            </select>
                                                                        </div>

                                                                        <div class="col-xs-1 col-sm-1">
                                                                            <span class="ui-close remove-color" data-id="{{$key->id}}" style="margin:0;right:70%;">X</span>
                                                                        </div>

                                                                    </div>

                                                                @endforeach

                                                            @else

                                                                <div class="form-group" data-id="1">

                                                                    <div class="col-sm-3">

                                                                        <input class="form-control color_title" name="colors[]" id="blood_group_slug" placeholder="Color Title" type="text">

                                                                    </div>

                                                                    <div class="col-sm-3">

                                                                        <input class="form-control color_code" name="color_codes[]" id="blood_group_slug" placeholder="Color Code" type="text">

                                                                    </div>

                                                                    <div class="col-sm-2">

                                                                        <input class="form-control color_max_height" maskedformat="9,1" name="color_max_height[]" id="blood_group_slug" placeholder="Max Height" type="text">

                                                                    </div>

                                                                    <div class="col-sm-3">
                                                                        <select class="form-control validate js-data-example-ajax4" name="price_tables[]">

                                                                            <option value="">Select Price Table</option>

                                                                            @foreach($tables as $table)

                                                                                <option value="{{$table->id}}">{{$table->title}}</option>

                                                                            @endforeach

                                                                        </select>
                                                                    </div>

                                                                    <div class="col-xs-1 col-sm-1">
                                                                        <span class="ui-close remove-color" data-id="" style="margin:0;right:70%;">X</span>
                                                                    </div>

                                                                </div>

                                                            @endif

                                                        </div>

                                                        <div class="form-group add-color">
                                                            <label class="control-label col-sm-3" for=""></label>

                                                            <div class="col-sm-12 text-center">
                                                                <button class="btn btn-default featured-btn" type="button" id="add-color-btn"><i class="fa fa-plus"></i> Add More Colors</button>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div id="menu4" class="tab-pane fade">

                                                        <div class="row">
                                                            <div class="col-sm-12">

                                                                <table id="example1"
                                                                       class="table table-striped table-hover products dt-responsive dataTable no-footer dtr-inline"
                                                                       role="grid" aria-describedby="product-table_wrapper_info"
                                                                       style="width: 100%;display: inline-table;overflow-x: auto;" width="100%" cellspacing="0">
                                                                    <thead>

                                                                    <tr role="row">

                                                                        <th tabindex="0"
                                                                            aria-controls="product-table_wrapper" rowspan="1"
                                                                            colspan="1" style="padding: 0 25px;border: 1px solid #e7e7e7;text-align: center;" aria-sort="ascending"
                                                                            aria-label="Blood Group Name: activate to sort column descending">
                                                                            ID
                                                                        </th>

                                                                        <th tabindex="0"
                                                                            aria-controls="product-table_wrapper" rowspan="1"
                                                                            colspan="1" style="padding: 0 25px;border: 1px solid #e7e7e7;text-align: center;" aria-sort="ascending"
                                                                            aria-label="Blood Group Name: activate to sort column descending">
                                                                            Table
                                                                        </th>

                                                                        <th tabindex="0"
                                                                            aria-controls="product-table_wrapper" rowspan="1"
                                                                            colspan="1" style="padding: 0 25px;border: 1px solid #e7e7e7;text-align: center;" aria-sort="ascending"
                                                                            aria-label="Blood Group Name: activate to sort column descending">
                                                                            Color
                                                                        </th>

                                                                        <th tabindex="0"
                                                                            aria-controls="product-table_wrapper" rowspan="1"
                                                                            colspan="1" style="padding: 0 25px;border: 1px solid #e7e7e7;text-align: center;" aria-sort="ascending"
                                                                            aria-label="Blood Group Name: activate to sort column descending">
                                                                            Code
                                                                        </th>

                                                                        <th tabindex="0"
                                                                            aria-controls="product-table_wrapper" rowspan="1"
                                                                            colspan="1" style="padding: 0 25px;border: 1px solid #e7e7e7;text-align: center;" aria-sort="ascending"
                                                                            aria-label="Blood Group Name: activate to sort column descending">
                                                                            Action
                                                                        </th>

                                                                    </tr>
                                                                    </thead>

                                                                    <tbody>

                                                                    @if(isset($colors_data))

                                                                        @foreach($colors_data as $i => $key)

                                                                            <tr data-id="{{$i+1}}">
                                                                                <td>{{$key->table_id}}</td>
                                                                                <td>{{$key->table}}</td>
                                                                                <td>{{$key->color}}</td>
                                                                                <td>{{$key->color_code}}</td>
                                                                                <td><a href="/aanbieder/price-tables/prices/view/{{$key->table_id}}">View</a></td>
                                                                            </tr>

                                                                        @endforeach

                                                                    @endif

                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div id="menu5" class="tab-pane fade">

                                                        <div class="row" style="margin: 0;margin-bottom: 35px;">

                                                            <div class="form-group">

                                                                <div class="row" style="margin: 0;">

                                                                    <div style="display: flex;align-items: center;justify-content: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                                                        <label style="display: block;text-align: left;padding-top: 0;padding-right: 20px;color: red;" class="control-label">Ladderband:</label>

                                                                        <input type="hidden" name="ladderband" id="ladderband" value="{{isset($cats) ? $cats->ladderband : 0}}">

                                                                        <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                        <label style="margin: 0;" class="switch">
                                                                            <input class="ladderband" type="checkbox" {{isset($cats) ? ($cats->ladderband ? 'checked' : null) : null}}>
                                                                            <span class="slider round"></span>
                                                                        </label>
                                                                        <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                            <div @if(isset($cats)) @if(!$cats->ladderband) style='display: none;' @endif @else style='display: none;' @endif id="ladderband_box" class="form-group">

                                                                <div class="row" style="margin: 0;">

                                                                    <div style="margin: 15px 0;display: flex;align-items: center;justify-content: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <label style="display: block;text-align: left;padding-top: 0;padding-right: 20px;" class="control-label">Ladderband Value:</label>
                                                                        <input style="width: auto;border-radius: 10px;" class="form-control ladderband_value" value="{{isset($cats) ? $cats->ladderband_value : null}}" name="ladderband_value" id="blood_group_slug" placeholder="Ladderband Value" type="text">
                                                                    </div>

                                                                    <div style="margin: 15px 0;display: flex;align-items: center;justify-content: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                                                        <label style="display: block;text-align: left;padding-top: 0;padding-right: 20px;" class="control-label">Ladderband Price Impact:</label>

                                                                        <input type="hidden" name="ladderband_price_impact" id="ladderband_price_impact" value="{{isset($cats) ? $cats->ladderband_price_impact : 0}}">

                                                                        <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                        <label style="margin: 0;" class="switch">
                                                                            <input class="ladderband_price_impact" type="checkbox" {{isset($cats) ? ($cats->ladderband_price_impact ? 'checked' : null) : null}}>
                                                                            <span class="slider round"></span>
                                                                        </label>
                                                                        <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                    </div>

                                                                    <div style="margin: 15px 0;display: flex;align-items: center;justify-content: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                                                        <label style="display: block;text-align: left;padding-top: 0;padding-right: 20px;" class="control-label">Ladderband Impact Type:</label>

                                                                        <input type="hidden" name="ladderband_impact_type" id="ladderband_impact_type" value="{{isset($cats) ? $cats->ladderband_impact_type : 0}}">

                                                                        <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>
                                                                        <label style="margin: 0;" class="switch">
                                                                            <input class="ladderband_impact_type" type="checkbox" {{isset($cats) ? ($cats->ladderband_impact_type ? 'checked' : null) : null}}>
                                                                            <span class="slider round"></span>
                                                                        </label>
                                                                        <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>

                                                                    </div>

                                                                </div>

                                                                <div class="form-group" style="margin: 50px 0px 20px 0;display: flex;justify-content: center;">

                                                                    <div style="border: 1px solid #e1e1e1;padding: 25px;" class="col-lg-11 col-md-11 col-sm-12 col-xs-12">

                                                                        <h4 style="text-align: center;margin-bottom: 50px;">Ladderband Sub Product(s)</h4>

                                                                        <div class="row" style="margin: 0;">

                                                                            <div style="font-family: monospace;" class="col-sm-2">
                                                                                <h4>ID</h4>
                                                                            </div>

                                                                            <div style="font-family: monospace;" class="col-sm-3">
                                                                                <h4>Title</h4>
                                                                            </div>

                                                                            <div style="font-family: monospace;text-align: center;" class="col-sm-3">
                                                                                <h4>Size 38mm</h4>
                                                                            </div>

                                                                            <div style="font-family: monospace;text-align: center;" class="col-sm-3">
                                                                                <h4>Size 25mm</h4>
                                                                            </div>

                                                                        </div>

                                                                        <div class="row ladderband_products_box" style="margin: 15px 0;">

                                                                            <input type="hidden" name="removed_ladderband" id="removed_ladderband_rows">

                                                                            @if(isset($ladderband_data) && count($ladderband_data) > 0)

                                                                                @foreach($ladderband_data as $f => $key)

                                                                                    <div class="form-group" style="margin: 0 0 20px 0;display: flex;justify-content: center;">

                                                                                        <div class="col-sm-2">

                                                                                            <input value="{{$key->code}}" class="form-control sub_code" name="sub_codes[]" id="blood_group_slug" placeholder="Sub Product ID" type="text">

                                                                                        </div>

                                                                                        <div class="col-sm-3">

                                                                                            <input value="{{$key->title}}" class="form-control sub_product_title" name="sub_product_titles[]" id="blood_group_slug" placeholder="Sub Product Title" type="text">

                                                                                        </div>

                                                                                        <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-3">

                                                                                            <input type="hidden" name="size1_value[]" id="size1_value" value="{{$key->size1_value}}">

                                                                                            <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                                            <label style="margin: 0;" class="switch">
                                                                                                <input {{$key->size1_value ? 'checked' : null}} class="size1_value" type="checkbox">
                                                                                                <span class="slider round"></span>
                                                                                            </label>
                                                                                            <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                                        </div>

                                                                                        <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-3">

                                                                                            <input type="hidden" name="size2_value[]" id="size2_value" value="{{$key->size2_value}}">

                                                                                            <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                                            <label style="margin: 0;" class="switch">
                                                                                                <input {{$key->size2_value ? 'checked' : null}} class="size2_value" type="checkbox">
                                                                                                <span class="slider round"></span>
                                                                                            </label>
                                                                                            <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                                        </div>

                                                                                        <div class="col-xs-1 col-sm-1">
                                                                                            <span class="ui-close remove-ladderband" data-id="{{$key->id}}" style="margin:0;right:70%;">X</span>
                                                                                        </div>

                                                                                    </div>

                                                                                @endforeach

                                                                            @else

                                                                                <div class="form-group" style="margin: 0 0 20px 0;display: flex;justify-content: center;">

                                                                                    <div class="col-sm-2">

                                                                                        <input class="form-control sub_code" name="sub_codes[]" id="blood_group_slug" placeholder="Sub Product ID" type="text">

                                                                                    </div>

                                                                                    <div class="col-sm-3">

                                                                                        <input class="form-control sub_product_title" name="sub_product_titles[]" id="blood_group_slug" placeholder="Sub Product Title" type="text">

                                                                                    </div>

                                                                                    <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-3">

                                                                                        <input type="hidden" name="size1_value[]" id="size1_value" value="0">

                                                                                        <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                                        <label style="margin: 0;" class="switch">
                                                                                            <input class="size1_value" type="checkbox">
                                                                                            <span class="slider round"></span>
                                                                                        </label>
                                                                                        <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                                    </div>

                                                                                    <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-3">

                                                                                        <input type="hidden" name="size2_value[]" id="size2_value" value="0">

                                                                                        <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                                        <label style="margin: 0;" class="switch">
                                                                                            <input class="size2_value" type="checkbox">
                                                                                            <span class="slider round"></span>
                                                                                        </label>
                                                                                        <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                                    </div>

                                                                                    <div class="col-xs-1 col-sm-1">
                                                                                        <span class="ui-close remove-ladderband" data-id="" style="margin:0;right:70%;">X</span>
                                                                                    </div>

                                                                                </div>

                                                                            @endif

                                                                        </div>

                                                                        <div class="form-group add-color">
                                                                            <label class="control-label col-sm-3" for=""></label>

                                                                            <div class="col-sm-12 text-center">
                                                                                <button class="btn btn-default featured-btn" type="button" id="add-ladderband-btn"><i class="fa fa-plus"></i> Add Ladderband Sub Products</button>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div class="form-group" style="margin-bottom: 20px;">

                                                            <div class="row" style="margin: 0;display: flex;justify-content: center;">

                                                                <div style="font-family: monospace;" class="col-sm-3">
                                                                    <h4>Heading</h4>
                                                                </div>

                                                                <div style="font-family: monospace;" class="col-sm-3">
                                                                    <h4>Order</h4>
                                                                </div>

                                                                <div style="font-family: monospace;" class="col-sm-3">
                                                                    <h4>Action</h4>
                                                                </div>

                                                                {{--<div style="font-family: monospace;" class="col-sm-1">
                                                                    <h4>Value</h4>
                                                                </div>

                                                                <div style="font-family: monospace;" class="col-sm-1">
                                                                    <h4>Max Size</h4>
                                                                </div>

                                                                <div style="text-align: center;font-family: monospace;" class="col-sm-2">
                                                                    <h4>Price Impact</h4>
                                                                </div>

                                                                <div style="text-align: center;font-family: monospace;" class="col-sm-2">
                                                                    <h4>Impact Type</h4>
                                                                </div>--}}

                                                            </div>

                                                            <div class="row feature_box" style="margin: 15px 0;">

                                                                <input type="hidden" name="removed" id="removed_rows">

                                                                @if(isset($features_data) && count($features_data) > 0)

                                                                    @foreach($features_data->unique('heading_id') as $f => $key)

                                                                        <div data-id="{{$f+1}}" class="form-group feature-row" style="margin: 0 0 20px 0;display: flex;justify-content: center;">

                                                                            <div class="col-sm-5">

                                                                                <select class="form-control validate js-data-example-ajax5">

                                                                                    <option value="">Select Feature Heading</option>

                                                                                    @foreach($features_headings as $heading)

                                                                                        <option {{$heading->id == $key->heading_id ? 'selected' : null}} value="{{$heading->id}}">{{$heading->title}}</option>

                                                                                    @endforeach

                                                                                </select>

                                                                            </div>

                                                                            <div style="display:flex;" class="col-sm-5">

                                                                                <button data-id="{{$f+1}}" style="margin-right: 10px;" class="btn btn-success create-feature-btn" type="button">Create/Edit Features</button>

                                                                                <span class="ui-close remove-feature" data-id="{{$f+1}}" style="margin:0;position: relative;left: 0;right: 0;">X</span>

                                                                                {{--<input class="form-control feature_title" value="{{$key->title}}" name="features[]" id="blood_group_slug" placeholder="Feature Title" type="text">--}}

                                                                            </div>

                                                                            {{--<div class="col-sm-2">

                                                                                <input class="form-control feature_title" value="{{$key->title}}" name="features[]" id="blood_group_slug" placeholder="Feature Title" type="text">

                                                                            </div>

                                                                            <div class="col-sm-1">

                                                                                <input class="form-control feature_value" value="{{$key->value}}" name="feature_values[]" id="blood_group_slug" placeholder="Value" type="text">

                                                                            </div>

                                                                            <div class="col-sm-1">

                                                                                <input class="form-control max_size" value="{{str_replace(".",",",$key->max_size)}}" maskedformat="9,1" name="max_size[]" id="blood_group_slug" placeholder="Max Size" type="text">

                                                                            </div>

                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-2">

                                                                                <input type="hidden" name="price_impact[]" id="price_impact" value="{{$key->price_impact}}">

                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                                <label style="margin: 0;" class="switch">
                                                                                    <input class="price_impact" type="checkbox" {{$key->price_impact ? 'checked' : null}}>
                                                                                    <span class="slider round"></span>
                                                                                </label>
                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                            </div>

                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-2">

                                                                                <input type="hidden" name="impact_type[]" id="impact_type" value="{{$key->impact_type}}">

                                                                                <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>
                                                                                <label style="margin: 0;" class="switch">
                                                                                    <input class="impact_type" type="checkbox" {{$key->impact_type ? 'checked' : null}}>
                                                                                    <span class="slider round"></span>
                                                                                </label>
                                                                                <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>

                                                                            </div>


                                                                            <div class="col-xs-1 col-sm-1">
                                                                                <span class="ui-close remove-feature" data-id="{{$key->id}}" style="margin:0;right:70%;">X</span>
                                                                            </div>--}}

                                                                        </div>

                                                                    @endforeach

                                                                @else

                                                                    <div data-id="1" class="form-group feature-row" style="margin: 0 0 20px 0;display: flex;justify-content: center">

                                                                        <div class="col-sm-5">

                                                                            <select class="form-control validate js-data-example-ajax5">

                                                                                <option value="">Select Feature Heading</option>

                                                                                @foreach($features_headings as $feature)

                                                                                    <option value="{{$feature->id}}">{{$feature->title}}</option>

                                                                                @endforeach

                                                                            </select>

                                                                        </div>

                                                                        <div style="display:flex;" class="col-sm-5">

                                                                            <button data-id="1" style="margin-right: 10px;" class="btn btn-success create-feature-btn" type="button">Create/Edit Features</button>

                                                                            <span class="ui-close remove-feature" data-id="" style="margin:0;position: relative;left: 0;right: 0;">X</span>

                                                                            {{--<input class="form-control feature_title" name="features[]" id="blood_group_slug" placeholder="Feature Title" type="text">--}}

                                                                        </div>

                                                                        {{--<div class="col-sm-1">

                                                                            <input class="form-control feature_value" name="feature_values[]" id="blood_group_slug" placeholder="Value" type="text">

                                                                        </div>

                                                                        <div class="col-sm-1">

                                                                            <input class="form-control max_size" name="max_size[]" maskedformat="9,1" id="blood_group_slug" placeholder="Max Size" type="text">

                                                                        </div>

                                                                        <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-2">

                                                                            <input type="hidden" name="price_impact[]" id="price_impact" value="0">

                                                                            <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                            <label style="margin: 0;" class="switch">
                                                                                <input class="price_impact" type="checkbox">
                                                                                <span class="slider round"></span>
                                                                            </label>
                                                                            <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                        </div>

                                                                        <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-2">

                                                                            <input type="hidden" name="impact_type[]" id="impact_type" value="0">

                                                                            <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>
                                                                            <label style="margin: 0;" class="switch">
                                                                                <input class="impact_type" type="checkbox">
                                                                                <span class="slider round"></span>
                                                                            </label>
                                                                            <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>

                                                                        </div>--}}


                                                                        {{--<div class="col-xs-1 col-sm-1">
                                                                            <span class="ui-close remove-feature" data-id="" style="margin:0;right:70%;">X</span>
                                                                        </div>--}}

                                                                    </div>

                                                                @endif

                                                            </div>

                                                            @if(isset($features_data) && count($features_data) > 0)

                                                                <div id="myModal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                    <div style="width: 70%;" class="modal-dialog">

                                                                        <div class="modal-content">

                                                                            <div class="modal-header">
                                                                                <button style="background-color: white !important;color: black !important;" type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                <h3 id="myModalLabel">Features</h3>
                                                                            </div>

                                                                            <div class="modal-body" id="myWizard" style="display: inline-block;width: 100%;padding: 30px 10px;">

                                                                                <div id="primary-features">

                                                                                    @foreach($features_data->unique('heading_id') as $f => $key)

                                                                                        <div data-id="{{$f+1}}" class="feature-table-container">

                                                                                            <table style="margin: auto;width: 95%;border-collapse: separate;">
                                                                                                <thead>
                                                                                                <tr>
                                                                                                    <th>Feature</th>
                                                                                                    <th>Value</th>
                                                                                                    <th>Sub Feature</th>
                                                                                                    <th>Price Impact</th>
                                                                                                    <th>Impact Type</th>
                                                                                                    <th>m¹ Impact</th>
                                                                                                    <th>Remove</th>
                                                                                                </tr>
                                                                                                </thead>

                                                                                                <tbody>

                                                                                                @foreach($features_data as $f1 => $key1)

                                                                                                    @if($key->heading_id == $key1->heading_id)

                                                                                                        <tr data-id="{{$f1+1}}">
                                                                                                            <td>
                                                                                                                <input type="hidden" name="f_rows[]" class="f_row" value="{{$f1+1}}">
                                                                                                                <input value="{{$key1->heading_id}}" type="hidden" class="feature_heading" name="feature_headings[]">
                                                                                                                <input value="{{$key1->title}}" class="form-control feature_title" name="features[]" id="blood_group_slug" placeholder="Feature Title" type="text">
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <input value="{{$key1->value}}" class="form-control feature_value" name="feature_values[]" id="blood_group_slug" placeholder="Value" type="text">
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <button data-id="{{$f1+1}}" class="btn btn-success create-sub-feature-btn" type="button">Create/Edit Sub Features</button>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">

                                                                                                                    <input type="hidden" name="price_impact[]" id="price_impact" value="{{$key1->price_impact}}">

                                                                                                                    <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                                                                    <label style="margin: 0;" class="switch">
                                                                                                                        <input class="price_impact" type="checkbox" {{$key1->price_impact ? 'checked' : null}}>
                                                                                                                        <span class="slider round"></span>
                                                                                                                    </label>
                                                                                                                    <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                                                                </div>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">

                                                                                                                    <input type="hidden" name="impact_type[]" id="impact_type" value="{{$key1->impact_type}}">

                                                                                                                    <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>
                                                                                                                    <label style="margin: 0;" class="switch">
                                                                                                                        <input class="impact_type" type="checkbox" {{$key1->impact_type ? 'checked' : null}}>
                                                                                                                        <span class="slider round"></span>
                                                                                                                    </label>
                                                                                                                    <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>

                                                                                                                </div>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">

                                                                                                                    <input type="hidden" name="variable[]" id="variable" value="{{$key1->variable}}">

                                                                                                                    <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                                                                    <label style="margin: 0;" class="switch">
                                                                                                                        <input class="variable" type="checkbox" {{$key1->variable ? 'checked' : null}}>
                                                                                                                        <span class="slider round"></span>
                                                                                                                    </label>
                                                                                                                    <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                                                                </div>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <div style="display: flex;justify-content: center;"><span class="ui-close remove-primary-feature" data-id="{{$key1->id}}" style="margin:0;position: relative;left: 0;right: 0;top: 0;">X</span></div>
                                                                                                            </td>
                                                                                                        </tr>

                                                                                                    @endif

                                                                                                @endforeach

                                                                                                </tbody>
                                                                                            </table>

                                                                                            <div style="margin-top: 20px;" class="col-sm-12 text-center">
                                                                                                <button data-id="{{$f+1}}" class="btn btn-default featured-btn" type="button" id="add-primary-feature-btn"><i class="fa fa-plus"></i> Add More Features</button>
                                                                                            </div>
                                                                                        </div>

                                                                                    @endforeach

                                                                                </div>

                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                </div>

                                                            @else

                                                                <div id="myModal1" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                    <div style="width: 70%;" class="modal-dialog">

                                                                        <div class="modal-content">

                                                                            <div class="modal-header">
                                                                                <button style="background-color: white !important;color: black !important;" type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                <h3 id="myModalLabel">Features</h3>
                                                                            </div>

                                                                            <div class="modal-body" id="myWizard" style="display: inline-block;width: 100%;padding: 30px 10px;">

                                                                                <div id="primary-features">

                                                                                    <div data-id="1" class="feature-table-container">

                                                                                        <table style="margin: auto;width: 95%;border-collapse: separate;">
                                                                                            <thead>
                                                                                            <tr>
                                                                                                <th>Feature</th>
                                                                                                <th>Value</th>
                                                                                                <th>Sub Features</th>
                                                                                                <th>Price Impact</th>
                                                                                                <th>Impact Type</th>
                                                                                                <th>m¹ Impact</th>
                                                                                                <th>Remove</th>
                                                                                            </tr>
                                                                                            </thead>

                                                                                            <tbody>

                                                                                            <tr data-id="1">
                                                                                                <td>
                                                                                                    <input type="hidden" name="f_rows[]" class="f_row" value="1">
                                                                                                    <input type="hidden" class="feature_heading" name="feature_headings[]">
                                                                                                    <input class="form-control feature_title" name="features[]" id="blood_group_slug" placeholder="Feature Title" type="text">
                                                                                                </td>
                                                                                                <td>
                                                                                                    <input class="form-control feature_value" name="feature_values[]" id="blood_group_slug" placeholder="Value" type="text">
                                                                                                </td>
                                                                                                <td>
                                                                                                    <button data-id="1" class="btn btn-success create-sub-feature-btn" type="button">Create/Edit Sub Features</button>
                                                                                                </td>
                                                                                                <td>
                                                                                                    <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">

                                                                                                        <input type="hidden" name="price_impact[]" id="price_impact" value="0">

                                                                                                        <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                                                        <label style="margin: 0;" class="switch">
                                                                                                            <input class="price_impact" type="checkbox">
                                                                                                            <span class="slider round"></span>
                                                                                                        </label>
                                                                                                        <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                                                    </div>
                                                                                                </td>
                                                                                                <td>
                                                                                                    <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">

                                                                                                        <input type="hidden" name="impact_type[]" id="impact_type" value="0">

                                                                                                        <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>
                                                                                                        <label style="margin: 0;" class="switch">
                                                                                                            <input class="impact_type" type="checkbox">
                                                                                                            <span class="slider round"></span>
                                                                                                        </label>
                                                                                                        <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>

                                                                                                    </div>
                                                                                                </td>
                                                                                                <td>
                                                                                                    <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">

                                                                                                        <input type="hidden" name="variable[]" id="variable" value="0">

                                                                                                        <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                                                        <label style="margin: 0;" class="switch">
                                                                                                            <input class="variable" type="checkbox">
                                                                                                            <span class="slider round"></span>
                                                                                                        </label>
                                                                                                        <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                                                    </div>
                                                                                                </td>
                                                                                                <td>
                                                                                                    <div style="display: flex;justify-content: center;"><span class="ui-close remove-primary-feature" data-id="" style="margin:0;position: relative;left: 0;right: 0;top: 0;">X</span></div>
                                                                                                </td>
                                                                                            </tr>

                                                                                            </tbody>
                                                                                        </table>

                                                                                        <div style="margin-top: 20px;" class="col-sm-12 text-center">
                                                                                            <button data-id="1" class="btn btn-default featured-btn" type="button" id="add-primary-feature-btn"><i class="fa fa-plus"></i> Add More Features</button>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>

                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                </div>

                                                            @endif

                                                            @if(isset($sub_features_data) && count($features_data) > 0)

                                                                <div id="myModal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                    <div style="width: 70%;" class="modal-dialog">

                                                                        <div class="modal-content">

                                                                            <div class="modal-header">
                                                                                <button style="background-color: white !important;color: black !important;" type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                <h3 id="myModalLabel">Sub Features</h3>
                                                                            </div>

                                                                            <div class="modal-body" id="myWizard" style="display: inline-block;width: 100%;padding: 30px 10px;">

                                                                                <div id="sub-features">

                                                                                    <?php $s1 = 1; ?>

                                                                                    @foreach($features_data as $s => $key)

                                                                                        <div data-id="{{$s+1}}" class="sub-feature-table-container">

                                                                                            <table style="margin: auto;width: 95%;border-collapse: separate;">
                                                                                                <thead>
                                                                                                <tr>
                                                                                                    <th>Feature</th>
                                                                                                    <th>Value</th>
                                                                                                    <th>Price Impact</th>
                                                                                                    <th>Impact Type</th>
                                                                                                    <th>m¹ Impact</th>
                                                                                                    <th>Remove</th>
                                                                                                </tr>
                                                                                                </thead>

                                                                                                <tbody>

                                                                                                @if($sub_features_data->contains('main_id',$key->id))

                                                                                                    @foreach($sub_features_data as $key1)

                                                                                                        @if($key->id == $key1->main_id)

                                                                                                            <tr data-id="{{$s1}}">
                                                                                                                <td>
                                                                                                                    <input type="hidden" name="f_rows{{$s+1}}[]" class="f_row1" value="{{$s1}}">
                                                                                                                    <input value="{{$key1->title}}" class="form-control feature_title1" name="features{{$s+1}}[]" id="blood_group_slug" placeholder="Sub Feature Title" type="text">
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                    <input value="{{$key1->value}}" class="form-control feature_value1" name="feature_values{{$s+1}}[]" id="blood_group_slug" placeholder="Value" type="text">
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                    <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">

                                                                                                                        <input type="hidden" name="price_impact{{$s+1}}[]" id="price_impact" value="{{$key1->price_impact}}">

                                                                                                                        <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                                                                        <label style="margin: 0;" class="switch">
                                                                                                                            <input class="price_impact" type="checkbox" {{$key1->price_impact ? 'checked' : null}}>
                                                                                                                            <span class="slider round"></span>
                                                                                                                        </label>
                                                                                                                        <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                    <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">

                                                                                                                        <input type="hidden" name="impact_type{{$s+1}}[]" id="impact_type" value="{{$key1->impact_type}}">

                                                                                                                        <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>
                                                                                                                        <label style="margin: 0;" class="switch">
                                                                                                                            <input class="impact_type" type="checkbox" {{$key1->impact_type ? 'checked' : null}}>
                                                                                                                            <span class="slider round"></span>
                                                                                                                        </label>
                                                                                                                        <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>

                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                    <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">

                                                                                                                        <input type="hidden" name="variable{{$s+1}}[]" id="variable" value="{{$key1->variable}}">

                                                                                                                        <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                                                                        <label style="margin: 0;" class="switch">
                                                                                                                            <input class="variable" type="checkbox" {{$key1->variable ? 'checked' : null}}>
                                                                                                                            <span class="slider round"></span>
                                                                                                                        </label>
                                                                                                                        <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                    <div style="display: flex;justify-content: center;"><span class="ui-close remove-sub-feature" data-id="{{$key1->id}}" style="margin:0;position: relative;left: 0;right: 0;top: 0;">X</span></div>
                                                                                                                </td>
                                                                                                            </tr>

                                                                                                            <?php $s1 = $s1 + 1; ?>

                                                                                                        @endif

                                                                                                    @endforeach

                                                                                                @else

                                                                                                    <tr data-id="{{$s1}}">
                                                                                                        <td>
                                                                                                            <input type="hidden" name="f_rows{{$s+1}}[]" class="f_row1" value="{{$s1}}">
                                                                                                            <input value="" class="form-control feature_title1" name="features{{$s+1}}[]" id="blood_group_slug" placeholder="Sub Feature Title" type="text">
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <input value="" class="form-control feature_value1" name="feature_values{{$s+1}}[]" id="blood_group_slug" placeholder="Value" type="text">
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">

                                                                                                                <input type="hidden" name="price_impact{{$s+1}}[]" id="price_impact" value="0">

                                                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                                                                <label style="margin: 0;" class="switch">
                                                                                                                    <input class="price_impact" type="checkbox">
                                                                                                                    <span class="slider round"></span>
                                                                                                                </label>
                                                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                                                            </div>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">

                                                                                                                <input type="hidden" name="impact_type{{$s+1}}[]" id="impact_type" value="0">

                                                                                                                <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>
                                                                                                                <label style="margin: 0;" class="switch">
                                                                                                                    <input class="impact_type" type="checkbox">
                                                                                                                    <span class="slider round"></span>
                                                                                                                </label>
                                                                                                                <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>

                                                                                                            </div>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">

                                                                                                                <input type="hidden" name="variable{{$s+1}}[]" id="variable" value="0">

                                                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                                                                <label style="margin: 0;" class="switch">
                                                                                                                    <input class="variable" type="checkbox">
                                                                                                                    <span class="slider round"></span>
                                                                                                                </label>
                                                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                                                            </div>
                                                                                                        </td>
                                                                                                        <td>
                                                                                                            <div style="display: flex;justify-content: center;"><span class="ui-close remove-sub-feature" data-id="" style="margin:0;position: relative;left: 0;right: 0;top: 0;">X</span></div>
                                                                                                        </td>
                                                                                                    </tr>

                                                                                                    <?php $s1 = $s1 + 1; ?>

                                                                                                @endif

                                                                                                </tbody>
                                                                                            </table>

                                                                                            <div style="margin-top: 20px;" class="col-sm-12 text-center">
                                                                                                <button data-id="{{$s+1}}" class="btn btn-default featured-btn" type="button" id="add-sub-feature-btn"><i class="fa fa-plus"></i> Add More Sub Features</button>
                                                                                            </div>
                                                                                        </div>

                                                                                    @endforeach

                                                                                </div>

                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                </div>

                                                            @else

                                                                <div id="myModal2" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                    <div style="width: 70%;" class="modal-dialog">

                                                                        <div class="modal-content">

                                                                            <div class="modal-header">
                                                                                <button style="background-color: white !important;color: black !important;" type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                <h3 id="myModalLabel">Sub Features</h3>
                                                                            </div>

                                                                            <div class="modal-body" id="myWizard" style="display: inline-block;width: 100%;padding: 30px 10px;">

                                                                                <div id="sub-features">

                                                                                    <div data-id="1" class="sub-feature-table-container">

                                                                                        <table style="margin: auto;width: 95%;border-collapse: separate;">
                                                                                            <thead>
                                                                                            <tr>
                                                                                                <th>Feature</th>
                                                                                                <th>Value</th>
                                                                                                <th>Price Impact</th>
                                                                                                <th>Impact Type</th>
                                                                                                <th>m¹ Impact</th>
                                                                                                <th>Remove</th>
                                                                                            </tr>
                                                                                            </thead>

                                                                                            <tbody>

                                                                                            <tr data-id="1">
                                                                                                <td>
                                                                                                    <input type="hidden" name="f_rows1[]" class="f_row1" value="1">
                                                                                                    <input class="form-control feature_title1" name="features1[]" id="blood_group_slug" placeholder="Feature Title" type="text">
                                                                                                </td>
                                                                                                <td>
                                                                                                    <input class="form-control feature_value1" name="feature_values1[]" id="blood_group_slug" placeholder="Value" type="text">
                                                                                                </td>
                                                                                                <td>
                                                                                                    <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">

                                                                                                        <input type="hidden" name="price_impact1[]" id="price_impact" value="0">

                                                                                                        <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                                                        <label style="margin: 0;" class="switch">
                                                                                                            <input class="price_impact" type="checkbox">
                                                                                                            <span class="slider round"></span>
                                                                                                        </label>
                                                                                                        <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                                                    </div>
                                                                                                </td>
                                                                                                <td>
                                                                                                    <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">

                                                                                                        <input type="hidden" name="impact_type1[]" id="impact_type" value="0">

                                                                                                        <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>
                                                                                                        <label style="margin: 0;" class="switch">
                                                                                                            <input class="impact_type" type="checkbox">
                                                                                                            <span class="slider round"></span>
                                                                                                        </label>
                                                                                                        <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>

                                                                                                    </div>
                                                                                                </td>
                                                                                                <td>
                                                                                                    <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">

                                                                                                        <input type="hidden" name="variable1[]" id="variable" value="0">

                                                                                                        <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                                                        <label style="margin: 0;" class="switch">
                                                                                                            <input class="variable" type="checkbox">
                                                                                                            <span class="slider round"></span>
                                                                                                        </label>
                                                                                                        <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                                                    </div>
                                                                                                </td>
                                                                                                <td>
                                                                                                    <div style="display: flex;justify-content: center;"><span class="ui-close remove-sub-feature" data-id="" style="margin:0;position: relative;left: 0;right: 0;top: 0;">X</span></div>
                                                                                                </td>
                                                                                            </tr>

                                                                                            </tbody>
                                                                                        </table>

                                                                                        <div style="margin-top: 20px;" class="col-sm-12 text-center">
                                                                                            <button data-id="1" class="btn btn-default featured-btn" type="button" id="add-sub-feature-btn"><i class="fa fa-plus"></i> Add More Sub Features</button>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>

                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                </div>

                                                            @endif

                                                        </div>

                                                        <div class="form-group add-color">
                                                            <label class="control-label col-sm-3" for=""></label>

                                                            <div class="col-sm-12 text-center">
                                                                <button class="btn btn-default featured-btn" type="button" id="add-feature-btn"><i class="fa fa-plus"></i> Add More Headings</button>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div id="menu6" class="tab-pane fade">

                                                        <div class="row" style="margin: 0;">

                                                            <div class="form-group">

                                                                <div class="row" style="margin: 0;">

                                                                    <div style="margin: 10px 0;display: flex;align-items: center;justify-content: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <label class="container1">Price based on price table
                                                                            <input type="radio" name="price_based_option" value="1" {{isset($cats) ? ($cats->price_based_option == 1 ? 'checked' : null) : 'checked'}}>
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </div>

                                                                    <div style="margin: 10px 0;display: flex;align-items: center;justify-content: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <label class="container1">Price based on width
                                                                            <input type="radio" name="price_based_option" value="2" {{isset($cats) ? ($cats->price_based_option == 2 ? 'checked' : null) : null}}>
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </div>

                                                                    <div style="margin: 10px 0;display: flex;align-items: center;justify-content: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                        <label class="container1">Price based on height
                                                                            <input type="radio" name="price_based_option" value="3" {{isset($cats) ? ($cats->price_based_option == 3 ? 'checked' : null) : null}}>
                                                                            <span class="checkmark"></span>
                                                                        </label>
                                                                    </div>

                                                                    <div style="margin: 10px 0;display: flex;align-items: center;justify-content: flex-start;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                                                        <label style="display: block;text-align: left;padding-top: 0;padding-right: 20px;" class="control-label">Base Price:</label>
                                                                        <input style="width: auto;border-radius: 10px;" class="form-control base_price" value="{{isset($cats) ? $cats->base_price : 0}}" name="base_price" id="blood_group_slug" placeholder="Base Price" type="number">

                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                    <div id="menu7" class="tab-pane fade">

                                                        <div class="form-group" style="margin-bottom: 20px;">

                                                            <div class="row" style="margin: 0;">

                                                                <div style="font-family: monospace;" class="col-sm-2">
                                                                    <h4>Model</h4>
                                                                </div>

                                                                <div style="font-family: monospace;" class="col-sm-1">
                                                                    <h4>Value</h4>
                                                                </div>

                                                                <div style="text-align: center;font-family: monospace;" class="col-sm-2">
                                                                    <h4>Price Impact</h4>
                                                                </div>

                                                                <div style="text-align: center;font-family: monospace;" class="col-sm-2">
                                                                    <h4>Impact Type</h4>
                                                                </div>

                                                                <div style="text-align: center;font-family: monospace;" class="col-sm-2">
                                                                    <h4>m² Impact</h4>
                                                                </div>

                                                                <div style="text-align: center;font-family: monospace;" class="col-sm-2">
                                                                    <h4>m¹ Impact</h4>
                                                                </div>

                                                                <div style="font-family: monospace;text-align: center;" class="col-sm-1">
                                                                    <h4>Action</h4>
                                                                </div>

                                                            </div>

                                                            <div class="row model_box" style="margin: 15px 0;">

                                                                <input type="hidden" name="removed1" id="removed_rows1">

                                                                @if(isset($models) && count($models) > 0)

                                                                    @foreach($models as $m => $key)

                                                                        <div data-id="{{$m+1}}" class="form-group" style="margin: 0 0 20px 0;">

                                                                            <div class="col-sm-2">

                                                                                <input type="text" value="{{$key->model}}" placeholder="Model" name="models[]" class="form-control validate models">

                                                                            </div>

                                                                            <div class="col-sm-1">

                                                                                <input value="{{$key->value}}" class="form-control model_value" name="model_values[]" id="blood_group_slug" placeholder="Value" type="text">

                                                                            </div>

                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-2">

                                                                                <input type="hidden" name="model_price_impact[]" id="price_impact" value="{{$key->price_impact}}">

                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                                <label style="margin: 0;" class="switch">
                                                                                    <input class="price_impact" type="checkbox" {{$key->price_impact ? 'checked' : null}}>
                                                                                    <span class="slider round"></span>
                                                                                </label>
                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                            </div>

                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-2">

                                                                                <input type="hidden" name="model_impact_type[]" id="impact_type" value="{{$key->impact_type}}">

                                                                                <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>
                                                                                <label style="margin: 0;" class="switch">
                                                                                    <input class="impact_type" type="checkbox" {{$key->impact_type ? 'checked' : null}}>
                                                                                    <span class="slider round"></span>
                                                                                </label>
                                                                                <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>

                                                                            </div>

                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-2">

                                                                                <input type="hidden" name="model_m2_impact[]" id="m2_impact" value="{{$key->m2_impact}}">

                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                                <label style="margin: 0;" class="switch">
                                                                                    <input class="m2_impact" type="checkbox" {{$key->m2_impact ? 'checked' : null}}>
                                                                                    <span class="slider round"></span>
                                                                                </label>
                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                            </div>

                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-2">

                                                                                <input type="hidden" name="model_width_impact[]" id="width_impact" value="{{$key->m1_impact}}">

                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                                <label style="margin: 0;" class="switch">
                                                                                    <input class="width_impact" type="checkbox" {{$key->m1_impact ? 'checked' : null}}>
                                                                                    <span class="slider round"></span>
                                                                                </label>
                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                            </div>

                                                                            <div style="display: flex;justify-content: space-between;" class="col-sm-1">

                                                                                {{--<button data-id="{{$m+1}}" style="margin-right: 10px;" class="btn btn-success select-feature-btn" type="button">Select Features</button>--}}
                                                                                <span class="ui-close select-feature-btn" data-id="{{$m+1}}" style="margin:0;position: relative;right: auto;top: 0;background-color: #5cb85c;font-size: 22px;">+</span>
                                                                                <span class="ui-close remove-model" data-id="{{$key->id}}" style="margin:0;position: relative;right:0;top: 0;">X</span>

                                                                            </div>

                                                                        </div>

                                                                    @endforeach

                                                                @else

                                                                    <div data-id="1" class="form-group" style="margin: 0 0 20px 0;">

                                                                        <div class="col-sm-2">

                                                                            <input type="text" placeholder="Model" name="models[]" class="form-control validate models">

                                                                        </div>

                                                                        <div class="col-sm-1">

                                                                            <input class="form-control model_value" name="model_values[]" id="blood_group_slug" placeholder="Value" type="text">

                                                                        </div>

                                                                        <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-2">

                                                                            <input type="hidden" name="model_price_impact[]" id="price_impact" value="0">

                                                                            <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                            <label style="margin: 0;" class="switch">
                                                                                <input class="price_impact" type="checkbox">
                                                                                <span class="slider round"></span>
                                                                            </label>
                                                                            <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                        </div>

                                                                        <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-2">

                                                                            <input type="hidden" name="model_impact_type[]" id="impact_type" value="0">

                                                                            <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>
                                                                            <label style="margin: 0;" class="switch">
                                                                                <input class="impact_type" type="checkbox">
                                                                                <span class="slider round"></span>
                                                                            </label>
                                                                            <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>

                                                                        </div>

                                                                        <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-2">

                                                                            <input type="hidden" name="model_m2_impact[]" id="m2_impact" value="0">

                                                                            <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                            <label style="margin: 0;" class="switch">
                                                                                <input class="m2_impact" type="checkbox">
                                                                                <span class="slider round"></span>
                                                                            </label>
                                                                            <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                        </div>

                                                                        <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-2">

                                                                            <input type="hidden" name="model_width_impact[]" id="width_impact" value="0">

                                                                            <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                            <label style="margin: 0;" class="switch">
                                                                                <input class="width_impact" type="checkbox">
                                                                                <span class="slider round"></span>
                                                                            </label>
                                                                            <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                        </div>

                                                                        <div style="display: flex;justify-content: space-between;" class="col-sm-1">

                                                                            {{--<button data-id="1" style="margin-right: 10px;" class="btn btn-success select-feature-btn" type="button">Select Features</button>--}}
                                                                            <span class="ui-close select-feature-btn" data-id="1" style="margin:0;position: relative;right: auto;top: 0;background-color: #5cb85c;font-size: 22px;">+</span>
                                                                            <span class="ui-close remove-model" data-id="" style="margin:0;position: relative;right:0;top: 0;">X</span>

                                                                        </div>

                                                                    </div>

                                                                @endif

                                                            </div>

                                                            @if(isset($models) && count($models) > 0)

                                                                <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog">

                                                                        <div class="modal-content">

                                                                            <div class="modal-header">
                                                                                <button style="background-color: white !important;color: black !important;" type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                <h3 id="myModalLabel">Model Features</h3>
                                                                            </div>

                                                                            <div class="modal-body" id="myWizard" style="display: inline-block;width: 100%;">

                                                                                <div id="models-features-tables">

                                                                                    @foreach($models as $s => $mod)

                                                                                        <div style="margin-left: 0;margin-right: 0;" data-id="{{$s+1}}" class="form-group model-childsafe">

                                                                                            <div class="row" style="margin: auto;width: 70%;">

                                                                                                <div style="display: flex;align-items: center;justify-content: flex-start;padding: 0;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                                                                                    <label style="display: block;text-align: left;padding-top: 0;padding-right: 20px;color: red;" class="control-label">Childsafe:</label>
                                                                                                    <input type="hidden" name="childsafe[]" id="childsafe" value="{{$mod->childsafe ? 1 : 0}}">

                                                                                                    <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                                                    <label style="margin: 0;" class="switch">
                                                                                                        <input class="childsafe" type="checkbox" {{$mod->childsafe ? 'checked' : null}}>
                                                                                                        <span class="slider round"></span>
                                                                                                    </label>
                                                                                                    <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                                                </div>

                                                                                                <div style="display: flex;align-items: center;justify-content: flex-start;padding: 0;margin-top: 20px;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                                                                                    <label style="display: block;text-align: left;padding-top: 0;padding-right: 20px;color: red;white-space: nowrap;" class="control-label">Max Size:</label>
                                                                                                    <input value="{{str_replace(".",",",$key->max_size)}}" class="form-control model_max_size" name="model_max_size[]" maskedformat="9,1" id="blood_group_slug" placeholder="Max Size" type="text">

                                                                                                </div>

                                                                                            </div>

                                                                                        </div>

                                                                                        <table data-id="{{$s+1}}" style="margin: auto;width: 70%;border-collapse: separate;">
                                                                                            <thead>
                                                                                            <tr>
                                                                                                <th></th>
                                                                                                <th>Heading</th>
                                                                                                <th>Feature</th>
                                                                                            </tr>
                                                                                            </thead>

                                                                                            <tbody>

                                                                                            @foreach($mod->features as $x => $feature)

                                                                                                <tr data-id="{{$x+1}}">
                                                                                                    <td>
                                                                                                        <div style="display: flex;justify-content: center;align-items: center;">
                                                                                                            <input type="hidden" name="selected_model_feature{{$x+1}}[]" id="price_impact" value="{{$feature->linked}}">
                                                                                                            <label style="margin: 0;" class="switch">
                                                                                                                <input class="price_impact" type="checkbox" {{$feature->linked ? 'checked' : null}}>
                                                                                                                <span class="slider round"></span>
                                                                                                            </label>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        {{$feature->heading}}
                                                                                                    </td>
                                                                                                    <td>{{$feature->feature_title}}</td>
                                                                                                </tr>

                                                                                            @endforeach

                                                                                            </tbody>
                                                                                        </table>

                                                                                    @endforeach

                                                                                </div>

                                                                                <div style="text-align: center;margin-top: 25px;">
                                                                                    <button class="btn btn-success" type="button" data-dismiss="modal" aria-hidden="true" style="padding: 5px 25px;font-size: 16px;">Save</button>
                                                                                </div>

                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                </div>

                                                            @else

                                                                @if(isset($features_data) && count($features_data) > 0)

                                                                    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog">

                                                                            <div class="modal-content">

                                                                                <div class="modal-header">
                                                                                    <button style="background-color: white !important;color: black !important;" type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                    <h3 id="myModalLabel">Model Features</h3>
                                                                                </div>

                                                                                <div class="modal-body" id="myWizard" style="display: inline-block;width: 100%;">

                                                                                    <div id="models-features-tables">

                                                                                        <div style="margin-left: 0;margin-right: 0;" data-id="1" class="form-group model-childsafe">

                                                                                            <div class="row" style="margin: auto;width: 70%;">

                                                                                                <div style="display: flex;align-items: center;justify-content: flex-start;padding: 0;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                                                                                    <label style="display: block;text-align: left;padding-top: 0;padding-right: 20px;color: red;" class="control-label">Childsafe:</label>
                                                                                                    <input type="hidden" name="childsafe[]" id="childsafe" value="0">

                                                                                                    <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                                                    <label style="margin: 0;" class="switch">
                                                                                                        <input class="childsafe" type="checkbox">
                                                                                                        <span class="slider round"></span>
                                                                                                    </label>
                                                                                                    <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                                                </div>

                                                                                                <div style="display: flex;align-items: center;justify-content: flex-start;padding: 0;margin-top: 20px;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                                                                                    <label style="display: block;text-align: left;padding-top: 0;padding-right: 20px;color: red;white-space: nowrap;" class="control-label">Max Size:</label>
                                                                                                    <input class="form-control model_max_size" name="model_max_size[]" maskedformat="9,1" id="blood_group_slug" placeholder="Max Size" type="text">

                                                                                                </div>

                                                                                            </div>

                                                                                        </div>

                                                                                        <table data-id="1" style="margin: auto;width: 70%;border-collapse: separate;">
                                                                                            <thead>
                                                                                            <tr>
                                                                                                <th></th>
                                                                                                <th>Heading</th>
                                                                                                <th>Feature</th>
                                                                                            </tr>
                                                                                            </thead>

                                                                                            <tbody>

                                                                                            @foreach($features_data as $x => $feature)

                                                                                                <tr data-id="{{$x+1}}">
                                                                                                    <td>
                                                                                                        <div style="display: flex;justify-content: center;align-items: center;">
                                                                                                            <input type="hidden" name="selected_model_feature{{$x+1}}[]" id="price_impact" value="0">
                                                                                                            <label style="margin: 0;" class="switch">
                                                                                                                <input class="price_impact" type="checkbox">
                                                                                                                <span class="slider round"></span>
                                                                                                            </label>
                                                                                                        </div>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        @foreach($features_headings as $heading)

                                                                                                            @if($heading->id == $feature->heading_id)

                                                                                                                {{$heading->title}}

                                                                                                            @endif

                                                                                                        @endforeach
                                                                                                    </td>
                                                                                                    <td>{{$feature->title}}</td>
                                                                                                </tr>

                                                                                            @endforeach

                                                                                            </tbody>
                                                                                        </table>

                                                                                        <div style="text-align: center;margin-top: 25px;">
                                                                                            <button class="btn btn-success" type="button" data-dismiss="modal" aria-hidden="true" style="padding: 5px 25px;font-size: 16px;">Save</button>
                                                                                        </div>

                                                                                    </div>

                                                                                </div>

                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                @else

                                                                    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog">

                                                                            <div class="modal-content">

                                                                                <div class="modal-header">
                                                                                    <button style="background-color: white !important;color: black !important;" type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                    <h3 id="myModalLabel">Model Features</h3>
                                                                                </div>

                                                                                <div class="modal-body" id="myWizard" style="display: inline-block;width: 100%;">

                                                                                    <div id="models-features-tables">

                                                                                        <div style="margin-left: 0;margin-right: 0;" data-id="1" class="form-group model-childsafe">

                                                                                            <div class="row" style="margin: auto;width: 70%;">

                                                                                                <div style="display: flex;align-items: center;justify-content: flex-start;padding: 0;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                                                                                    <label style="display: block;text-align: left;padding-top: 0;padding-right: 20px;color: red;" class="control-label">Childsafe:</label>
                                                                                                    <input type="hidden" name="childsafe[]" id="childsafe" value="0">

                                                                                                    <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>
                                                                                                    <label style="margin: 0;" class="switch">
                                                                                                        <input class="childsafe" type="checkbox">
                                                                                                        <span class="slider round"></span>
                                                                                                    </label>
                                                                                                    <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>

                                                                                                </div>

                                                                                                <div style="display: flex;align-items: center;justify-content: flex-start;padding: 0;margin-top: 20px;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                                                                                    <label style="display: block;text-align: left;padding-top: 0;padding-right: 20px;color: red;white-space: nowrap;" class="control-label">Max Size:</label>
                                                                                                    <input class="form-control model_max_size" name="model_max_size[]" maskedformat="9,1" id="blood_group_slug" placeholder="Max Size" type="text">

                                                                                                </div>

                                                                                            </div>

                                                                                        </div>

                                                                                        <table data-id="1" style="margin: auto;width: 70%;border-collapse: separate;">
                                                                                            <thead>
                                                                                            <tr>
                                                                                                <th></th>
                                                                                                <th>Heading</th>
                                                                                                <th>Feature</th>
                                                                                            </tr>
                                                                                            </thead>

                                                                                            <tbody>

                                                                                            </tbody>
                                                                                        </table>

                                                                                    </div>

                                                                                    <div style="text-align: center;margin-top: 25px;">
                                                                                        <button class="btn btn-success" type="button" data-dismiss="modal" aria-hidden="true" style="padding: 5px 25px;font-size: 16px;">Save</button>
                                                                                    </div>

                                                                                </div>

                                                                            </div>

                                                                        </div>
                                                                    </div>

                                                                @endif

                                                            @endif

                                                        </div>.

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-3" for=""></label>

                                                            <div class="col-sm-12 text-center">
                                                                <button class="btn btn-default featured-btn" type="button" id="add-model-btn"><i class="fa fa-plus"></i> Add More Models</button>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <hr style="margin: 30px 0;">

                                                    <div style="padding: 0;" class="add-product-footer">
                                                        <button name="addProduct_btn" type="button" class="btn add-product_btn">{{isset($cats) ? 'Edit Product' : 'Add Product'}}</button>
                                                    </div>

                                                </div>

                                            </form>
                                        </div>

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

        #menu7 .switch
        {
            width: 75px;
        }

        #menu7 input:checked + .slider:before
        {
            -webkit-transform: translateX(50px);
            transform: translateX(50px);
        }

    </style>

@endsection

@section('scripts')

<script type="text/javascript">

    window.onbeforeunload = function (e) {

        if($('#submit_check').val() == 0)
        {
            e = e || window.event;

            // For IE and Firefox prior to version 4
            if (e) {
                e.returnValue = 'Sure?';
            }
            // For Safari
            return 'Sure?';
        }
        else
        {
            // do nothing
        }

    };

    $(document).ready(function() {

        $('body').on('click', '.create-feature-btn' ,function(){

            var id = $(this).data('id');
            $('#primary-features').children().not(".feature-table-container[data-id='" + id + "']").hide();
            $('#primary-features').find(".feature-table-container[data-id='" + id + "']").show();

            $('#myModal1').modal('toggle');
            $('.modal-backdrop').hide();

        });

        $('body').on('click', '.create-sub-feature-btn' ,function(){

            var id = $(this).data('id');
            $('#sub-features').children().not(".sub-feature-table-container[data-id='" + id + "']").hide();
            $('#sub-features').find(".sub-feature-table-container[data-id='" + id + "']").show();

            $('#myModal1').modal('toggle');
            $('#myModal2').modal('toggle');
            $('.modal-backdrop').hide();

        });

        $('#myModal1').on('hidden.bs.modal', function () {
            $('body').addClass('modal-open');
        });

        $('body').on('click', '.select-feature-btn' ,function(){

            var id = $(this).data('id');
            $('#models-features-tables').find("table").hide();
            $('#models-features-tables').find(".model-childsafe").hide();
            $('#models-features-tables').find(".model-childsafe[data-id='" + id + "']").show();
            $('#models-features-tables').find("table[data-id='" + id + "']").show();

            $('#myModal').modal('toggle');
            $('.modal-backdrop').hide();

        });


        $('body').on('click', '#add-model-btn' ,function(){

            var model_row = $('.model_box').find('.form-group').last().data('id');
            model_row = model_row + 1;

            $(".model_box").append('<div data-id="'+model_row+'" class="form-group" style="margin: 0 0 20px 0;">\n' +
                '\n' +
                '                                                                   <div class="col-sm-2">\n' +
                '\n' +
                '                                                                        <input type="text" placeholder="Model" name="models[]" class="form-control validate models">\n' +
                '\n' +
                '                                                                    </div>\n' +
                '\n' +
                '                                                                    <div class="col-sm-1">\n' +
                '\n' +
                '                                                                        <input class="form-control model_value" name="model_values[]" id="blood_group_slug" placeholder="Value" type="text">\n' +
                '\n' +
                '                                                                    </div>\n' +
                '\n' +
                '                                                                    <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-2">\n' +
                '\n' +
                '                                                                        <input type="hidden" name="model_price_impact[]" id="price_impact" value="0">\n' +
                '\n' +
                '                                                                        <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                '                                                                        <label style="margin: 0;" class="switch">\n' +
                '                                                                            <input class="price_impact" type="checkbox">\n' +
                '                                                                            <span class="slider round"></span>\n' +
                '                                                                        </label>\n' +
                '                                                                        <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                '\n' +
                '                                                                    </div>\n' +
                '\n' +
                '                                                                    <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-2">\n' +
                '\n' +
                '                                                                        <input type="hidden" name="model_impact_type[]" id="impact_type" value="0">\n' +
                '\n' +
                '                                                                        <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>\n' +
                '                                                                        <label style="margin: 0;" class="switch">\n' +
                '                                                                            <input class="impact_type" type="checkbox">\n' +
                '                                                                            <span class="slider round"></span>\n' +
                '                                                                        </label>\n' +
                '                                                                        <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>\n' +
                '\n' +
                '                                                                    </div>\n' +
                '\n' +
                '                                                                    <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-2">\n' +
                '\n' +
                '                                                                        <input type="hidden" name="model_m2_impact[]" id="m2_impact" value="0">\n' +
                '\n' +
                '                                                                        <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>\n' +
                '                                                                        <label style="margin: 0;" class="switch">\n' +
                '                                                                            <input class="m2_impact" type="checkbox">\n' +
                '                                                                            <span class="slider round"></span>\n' +
                '                                                                        </label>\n' +
                '                                                                        <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>\n' +
                '\n' +
                '                                                                    </div>\n' +
                '\n' +
                '                                                                    <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-2">\n' +
                '\n' +
                '                                                                        <input type="hidden" name="model_width_impact[]" id="width_impact" value="0">\n' +
                '\n' +
                '                                                                        <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>\n' +
                '                                                                        <label style="margin: 0;" class="switch">\n' +
                '                                                                            <input class="width_impact" type="checkbox">\n' +
                '                                                                            <span class="slider round"></span>\n' +
                '                                                                        </label>\n' +
                '                                                                        <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>\n' +
                '\n' +
                '                                                                    </div>\n' +
                '\n' +
                '                                                                    <div style="display: flex;justify-content: space-between;" class="col-sm-1">\n' +
                '\n' +
                /*'                                                                        <button data-id="'+model_row+'" style="margin-right: 10px;" class="btn btn-success select-feature-btn" type="button">Select Features</button>\n' +*/
                '                                                                        <span class="ui-close select-feature-btn" data-id="'+model_row+'" style="margin:0;position: relative;right: auto;top: 0;background-color: #5cb85c;font-size: 22px;">+</span>\n' +
                '                                                                        <span class="ui-close remove-model" data-id="" style="margin:0;position: relative;right:0;top: 0;">X</span>\n' +
                '\n' +
                '                                                                    </div>' +
                '\n' +
                '        </div>');

            var rows = '';

            $('.feature_box').find('.feature-row', this).each(function (index) {

                var id = $(this).data('id');
                var heading = $(this).find('.js-data-example-ajax5 option:selected').text();
                var heading_id = $(this).find('.js-data-example-ajax5').val();

                if(!heading_id)
                {
                    heading = '';
                }

                $('#primary-features').find(".feature-table-container[data-id='" + id + "']").find('table tbody tr').each(function (index) {

                    var title = $(this).find('.feature_title').val();
                    var row = $(this).find('.f_row').val();

                    if(title && heading)
                    {
                        rows += '<tr data-id="'+row+'">' +
                            '                                                                                 <td>\n' +
                            '                                                                                <div style="display: flex;justify-content: center;align-items: center;">\n' +
                            '                                                                                <input type="hidden" name="selected_model_feature'+row+'[]" id="price_impact" value="0">\n' +
                            '                                                                                <label style="margin: 0;" class="switch">\n' +
                            '                                                                                    <input class="price_impact" type="checkbox">\n' +
                            '                                                                                    <span class="slider round"></span>\n' +
                            '                                                                                </label>\n' +
                            '                                                                                </div>\n' +
                            '                                                                                </td>' +
                            '                                                                                <td>'+heading+'</td><td>'+title+'</td></tr>';
                    }

                });

            });

            $('#models-features-tables').append('<div style="margin-left: 0;margin-right: 0;" data-id="'+model_row+'" class="form-group model-childsafe">\n' +
                '\n' +
                '                                                                                        <div class="row" style="margin: auto;width: 70%;">\n' +
                '\n' +
                '                                                                                            <div style="display: flex;align-items: center;justify-content: flex-start;padding: 0;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">\n' +
                '\n' +
                '                                                                                                <label style="display: block;text-align: left;padding-top: 0;padding-right: 20px;color: red;" class="control-label">Childsafe:</label>\n' +
                '                                                                                                   <input type="hidden" name="childsafe[]" id="childsafe" value="0">\n' +
                '\n' +
                '                                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                '                                                                                                <label style="margin: 0;" class="switch">\n' +
                '                                                                                                    <input class="childsafe" type="checkbox">\n' +
                '                                                                                                    <span class="slider round"></span>\n' +
                '                                                                                                </label>\n' +
                '                                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                '\n' +
                '                                                                                            </div>\n' +
                '\n' +
                '                                                                                                <div style="display: flex;align-items: center;justify-content: flex-start;padding: 0;margin-top: 20px;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">\n' +
                '\n' +
                '                                                                                                    <label style="display: block;text-align: left;padding-top: 0;padding-right: 20px;color: red;white-space: nowrap;" class="control-label">Max Size:</label>\n' +
                '                                                                                                    <input class="form-control model_max_size" name="model_max_size[]" maskedformat="9,1" id="blood_group_slug" placeholder="Max Size" type="text">\n' +
                '\n' +
                '                                                                                                </div>\n' +
                '\n' +
                '                                                                                        </div>\n' +
                '\n' +
                '                                                                                    </div>' +
                '<table data-id="'+model_row+'" style="margin: auto;width: 70%;border-collapse: separate;">\n' +
                '                <thead>\n' +
                '                <tr>\n' +
                '                <th></th>\n' +
                '            <th>Heading</th>\n' +
                '            <th>Feature</th>\n' +
                '        </tr>\n' +
                '        </thead>\n' +
                '\n' +
                '        <tbody>\n' +
                '\n' +
                rows +
                '        </tbody>\n' +
                '        </table>');


        });

        var rem_mod = [];

        $('body').on('click', '.remove-model' ,function()
        {
            var id = $(this).data('id');
            var model_row = $(this).parent().parent().data('id');

            if(id)
            {
                rem_mod.push(id);
                $('#removed_rows1').val(rem_mod);
            }

            $('#models-features-tables').find(".model-childsafe[data-id='" + model_row + "']").remove();
            $('#models-features-tables').find("table[data-id='" + model_row + "']").remove();
            $('.model_box').find("[data-id='" + model_row + "']").remove();

            if($(".model_box .form-group").length == 0)
            {

                $(".model_box").append('<div data-id="1" class="form-group" style="margin: 0 0 20px 0;">\n' +
                    '\n' +
                    '                                                                   <div class="col-sm-2">\n' +
                    '\n' +
                    '                                                                        <input type="text" placeholder="Model" name="models[]" class="form-control validate models">\n' +
                    '\n' +
                    '                                                                    </div>\n' +
                    '\n' +
                    '                                                                    <div class="col-sm-1">\n' +
                    '\n' +
                    '                                                                        <input class="form-control model_value" name="model_values[]" id="blood_group_slug" placeholder="Value" type="text">\n' +
                    '\n' +
                    '                                                                    </div>\n' +
                    '\n' +
                    '                                                                    <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-2">\n' +
                    '\n' +
                    '                                                                        <input type="hidden" name="model_price_impact[]" id="price_impact" value="0">\n' +
                    '\n' +
                    '                                                                        <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                    '                                                                        <label style="margin: 0;" class="switch">\n' +
                    '                                                                            <input class="price_impact" type="checkbox">\n' +
                    '                                                                            <span class="slider round"></span>\n' +
                    '                                                                        </label>\n' +
                    '                                                                        <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                    '\n' +
                    '                                                                    </div>\n' +
                    '\n' +
                    '                                                                    <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-2">\n' +
                    '\n' +
                    '                                                                        <input type="hidden" name="model_impact_type[]" id="impact_type" value="0">\n' +
                    '\n' +
                    '                                                                        <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>\n' +
                    '                                                                        <label style="margin: 0;" class="switch">\n' +
                    '                                                                            <input class="impact_type" type="checkbox">\n' +
                    '                                                                            <span class="slider round"></span>\n' +
                    '                                                                        </label>\n' +
                    '                                                                        <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>\n' +
                    '\n' +
                    '                                                                    </div>\n' +
                    '\n' +
                    '                                                                    <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-2">\n' +
                    '\n' +
                    '                                                                        <input type="hidden" name="model_m2_impact[]" id="m2_impact" value="0">\n' +
                    '\n' +
                    '                                                                        <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>\n' +
                    '                                                                        <label style="margin: 0;" class="switch">\n' +
                    '                                                                            <input class="m2_impact" type="checkbox">\n' +
                    '                                                                            <span class="slider round"></span>\n' +
                    '                                                                        </label>\n' +
                    '                                                                        <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>\n' +
                    '\n' +
                    '                                                                    </div>\n' +
                    '\n' +
                    '                                                                    <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-2">\n' +
                    '\n' +
                    '                                                                        <input type="hidden" name="model_width_impact[]" id="width_impact" value="0">\n' +
                    '\n' +
                    '                                                                        <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>\n' +
                    '                                                                        <label style="margin: 0;" class="switch">\n' +
                    '                                                                            <input class="width_impact" type="checkbox">\n' +
                    '                                                                            <span class="slider round"></span>\n' +
                    '                                                                        </label>\n' +
                    '                                                                        <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>\n' +
                    '\n' +
                    '                                                                    </div>\n' +
                    '\n' +
                    '                                                                    <div style="display: flex;justify-content: space-between;" class="col-sm-1">\n' +
                    '\n' +
                    /*'                                                                        <button data-id="1" style="margin-right: 10px;" class="btn btn-success select-feature-btn" type="button">Select Features</button>\n' +*/
                    '                                                                        <span class="ui-close select-feature-btn" data-id="1" style="margin:0;position: relative;right: auto;top: 0;background-color: #5cb85c;font-size: 22px;">+</span>\n' +
                    '                                                                        <span class="ui-close remove-model" data-id="" style="margin:0;position: relative;right:0;top: 0;">X</span>\n' +
                    '\n' +
                    '                                                                    </div>' +
                    '\n' +
                    '        </div>');

                var rows = '';

                $('.feature_box').find('.feature-row', this).each(function (index) {

                    var id = $(this).data('id');
                    var heading = $(this).find('.js-data-example-ajax5 option:selected').text();
                    var heading_id = $(this).find('.js-data-example-ajax5').val();

                    if(!heading_id)
                    {
                        heading = '';
                    }

                    $('#primary-features').find(".feature-table-container[data-id='" + id + "']").find('table tbody tr').each(function (index) {

                        var title = $(this).find('.feature_title').val();
                        var row = $(this).find('.f_row').val();

                        if(title && heading)
                        {
                            rows += '<tr data-id="'+row+'">' +
                                '                                                                                 <td>\n' +
                                '                                                                                <div style="display: flex;justify-content: center;align-items: center;">\n' +
                                '                                                                                <input type="hidden" name="selected_model_feature'+row+'[]" id="price_impact" value="0">\n' +
                                '                                                                                <label style="margin: 0;" class="switch">\n' +
                                '                                                                                    <input class="price_impact" type="checkbox">\n' +
                                '                                                                                    <span class="slider round"></span>\n' +
                                '                                                                                </label>\n' +
                                '                                                                                </div>\n' +
                                '                                                                                </td>' +
                                '                                                                                <td>'+heading+'</td><td>'+title+'</td></tr>';

                        }

                    });

                });

                $('#models-features-tables').append('<div style="margin-left: 0;margin-right: 0;" data-id="1" class="form-group model-childsafe">\n' +
                    '\n' +
                    '                                                                                        <div class="row" style="margin: auto;width: 70%;">\n' +
                    '\n' +
                    '                                                                                            <div style="display: flex;align-items: center;justify-content: flex-start;padding: 0;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">\n' +
                    '\n' +
                    '                                                                                                <label style="display: block;text-align: left;padding-top: 0;padding-right: 20px;color: red;" class="control-label">Childsafe:</label>\n' +
                    '                                                                                                   <input type="hidden" name="childsafe[]" id="childsafe" value="0">\n' +
                    '\n' +
                    '                                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                    '                                                                                                <label style="margin: 0;" class="switch">\n' +
                    '                                                                                                    <input class="childsafe" type="checkbox">\n' +
                    '                                                                                                    <span class="slider round"></span>\n' +
                    '                                                                                                </label>\n' +
                    '                                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                    '\n' +
                    '                                                                                            </div>\n' +
                    '\n' +
                    '                                                                                                <div style="display: flex;align-items: center;justify-content: flex-start;padding: 0;margin-top: 20px;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">\n' +
                    '\n' +
                    '                                                                                                    <label style="display: block;text-align: left;padding-top: 0;padding-right: 20px;color: red;white-space: nowrap;" class="control-label">Max Size:</label>\n' +
                    '                                                                                                    <input class="form-control model_max_size" name="model_max_size[]" maskedformat="9,1" id="blood_group_slug" placeholder="Max Size" type="text">\n' +
                    '\n' +
                    '                                                                                                </div>\n' +
                    '\n' +
                    '                                                                                        </div>\n' +
                    '\n' +
                    '                                                                                    </div>' +
                    '<table data-id="1" style="margin: auto;width: 70%;border-collapse: separate;">\n' +
                    '                <thead>\n' +
                    '                <tr>\n' +
                    '                <th></th>\n' +
                    '            <th>Heading</th>\n' +
                    '            <th>Feature</th>\n' +
                    '        </tr>\n' +
                    '        </thead>\n' +
                    '\n' +
                    '        <tbody>\n' +
                    '\n' +
                    rows +
                    '        </tbody>\n' +
                    '        </table>');
            }

        });

        var $selects = $('body').on('change', '.js-data-example-ajax5', function()
        {
            var id = $(this).parent().parent().attr("data-id");
            var heading = $(this).find("option:selected").text();
            var heading_id = $(this).val();

            var selector = this;

            if ($selects.find('option[value=' + heading_id + ']:selected').length > 1) {

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'This Heading is already selected!',

                });

                $(selector).val('').trigger('change.select2');

            }
            else
            {
                if(!heading_id)
                {
                    heading = '';
                }

                $('#primary-features').find(".feature-table-container[data-id='" + id + "']").find('table tbody tr').each(function (index) {

                    $(this).find('.feature_heading').val(heading_id);
                    var title = $(this).find('.feature_title').val();
                    var f_row = $(this).find('.f_row').val();

                    $('#models-features-tables').find('table', this).each(function (index) {

                        if($(this).find('tbody').find("[data-id='" + f_row + "']").length > 0)
                        {
                            if(!title || !heading)
                            {
                                $(this).find('tbody').find("[data-id='" + f_row + "']").hide();
                            }
                            else
                            {
                                $(this).find('tbody').find("[data-id='" + f_row + "']").find('td', this).each(function (index) {

                                    if(index == 1)
                                    {
                                        $(this).text(heading);
                                    }

                                    if(index == 2)
                                    {
                                        $(this).text(title);
                                    }

                                });

                                $(this).find('tbody').find("[data-id='" + f_row + "']").show();
                            }
                        }
                        else
                        {
                            if(title && heading)
                            {
                                $(this).find('tbody').append('<tr data-id="'+f_row+'">' +
                                    '                                                                                 <td>\n' +
                                    '                                                                                <div style="display: flex;justify-content: center;align-items: center;">\n' +
                                    '                                                                                <input type="hidden" name="selected_model_feature'+f_row+'[]" id="price_impact" value="0">\n' +
                                    '                                                                                <label style="margin: 0;" class="switch">\n' +
                                    '                                                                                    <input class="price_impact" type="checkbox">\n' +
                                    '                                                                                    <span class="slider round"></span>\n' +
                                    '                                                                                </label>\n' +
                                    '                                                                                </div>\n' +
                                    '                                                                                </td>' +
                                    '                                                                                <td>'+heading+'</td><td>'+title+'</td></tr>');

                                var $wrapper = $(this).find('tbody');

                                $wrapper.find('tr').sort(function(a, b) {
                                    return +$(a).data('id') - +$(b).data('id');
                                }).appendTo($wrapper);
                            }
                        }

                    });

                });
            }
        });

        $('body').on('input', '.feature_title', function() {

            var id = $(this).parent().find('.f_row').val();
            var main = $(this).parent().parent().parent().parent().parent().data('id');
            var title = $(this).val();
            var heading = $('.feature_box').find(".feature-row[data-id='" + main + "']").find('.js-data-example-ajax5 option:selected').text();
            var heading_id = $('.feature_box').find(".feature-row[data-id='" + main + "']").find('.js-data-example-ajax5').val();

            if(!heading_id)
            {
                heading = '';
            }

            $('#models-features-tables').find('table', this).each(function (index) {

                if($(this).find('tbody').find("[data-id='" + id + "']").length > 0)
                {
                    if(!title || !heading)
                    {
                        $(this).find('tbody').find("[data-id='" + id + "']").hide();
                    }
                    else
                    {
                        $(this).find('tbody').find("[data-id='" + id + "']").find('td', this).each(function (index) {

                            if(index == 1)
                            {
                                $(this).text(heading);
                            }

                            if(index == 2)
                            {
                                $(this).text(title);
                            }

                        });

                        $(this).find('tbody').find("[data-id='" + id + "']").show();
                    }
                }
                else
                {
                    if(title && heading)
                    {
                        $(this).find('tbody').append('<tr data-id="'+id+'">' +
                            '                                                                                 <td>\n' +
                            '                                                                                <div style="display: flex;justify-content: center;align-items: center;">\n' +
                            '                                                                                <input type="hidden" name="selected_model_feature'+id+'[]" id="price_impact" value="0">\n' +
                            '                                                                                <label style="margin: 0;" class="switch">\n' +
                            '                                                                                    <input class="price_impact" type="checkbox">\n' +
                            '                                                                                    <span class="slider round"></span>\n' +
                            '                                                                                </label>\n' +
                            '                                                                                </div>\n' +
                            '                                                                                </td>' +
                            '                                                                                <td>'+heading+'</td><td>'+title+'</td></tr>');

                        var $wrapper = $(this).find('tbody');

                        $wrapper.find('tr').sort(function(a, b) {
                            return +$(a).data('id') - +$(b).data('id');
                        }).appendTo($wrapper);

                    }
                }

            });

        });

        $(".add-product_btn").click(function () {

            var flag = 0;

            if(!$("input[name='margin']").val())
            {
                flag = 1;
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Margin should not be empty!',
                });
            }
            else if($("input[name='margin']").val() < 100)
            {
                flag = 1;
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Margin should not be smaller than 100!',
                });
            }
            else if(!$("input[name='title']").val())
            {
                flag = 1;
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Title should not be empty!',
                });
            }
            else if(!$("input[name='slug']").val())
            {
                flag = 1;
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Slug should not be empty!',
                });
            }
            else if(!$(".js-data-example-ajax").val())
            {
                flag = 1;
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Category should not be empty!',
                });
            }
            else if(!$(".js-data-example-ajax1").val())
            {
                flag = 1;
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Brand should not be empty!',
                });
            }
            /*else if(!$(".js-data-example-ajax2").val())
            {
                flag = 1;
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Model should not be empty!',
                });
            }*/
            else if(!$(".base_price").val())
            {
                flag = 1;
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Base price should not be empty!',
                });
            }

            if(!flag)
            {
                $('#submit_check').val(1);
                $('#product_form').submit();
            }

        });

        var rem_index = 0;
        var rem_arr = [];
        var rem_col_arr = [];
        var rem_lad_arr = [];

        $("#add-ladderband-btn").on('click',function() {


            $(".ladderband_products_box").append('<div class="form-group" style="margin: 0 0 20px 0;display: flex;justify-content: center;">\n' +
                '\n' +
                '                                                            <div class="col-sm-2">\n' +
                '\n' +
                '                                                                <input class="form-control sub_code" name="sub_codes[]" id="blood_group_slug" placeholder="Sub Product ID" type="text">\n' +
                '\n' +
                '                                                            </div>\n' +
                '\n' +
                '                                                            <div class="col-sm-3">\n' +
                '\n' +
                '                                                                <input class="form-control sub_product_title" name="sub_product_titles[]" id="blood_group_slug" placeholder="Sub Product Title" type="text">\n' +
                '\n' +
                '                                                            </div>\n' +
                '\n' +
                '                                                           <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-3">\n' +
                '\n' +
                '                                                                <input type="hidden" name="size1_value[]" id="size1_value" value="0">\n' +
                '\n' +
                '                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                '                                                                <label style="margin: 0;" class="switch">\n' +
                '                                                                    <input class="size1_value" type="checkbox">\n' +
                '                                                                    <span class="slider round"></span>\n' +
                '                                                                </label>\n' +
                '                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                '\n' +
                '                                                            </div>\n' +
                '\n' +
                '                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-3">\n' +
                '\n' +
                '                                                                <input type="hidden" name="size2_value[]" id="size2_value" value="0">\n' +
                '\n' +
                '                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                '                                                                <label style="margin: 0;" class="switch">\n' +
                '                                                                    <input class="size2_value" type="checkbox">\n' +
                '                                                                    <span class="slider round"></span>\n' +
                '                                                                </label>\n' +
                '                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                '\n' +
                '                                                            </div>\n' +
                '\n' +
                '                                                            <div class="col-xs-1 col-sm-1">\n' +
                '                                                                <span class="ui-close remove-ladderband" data-id="" style="margin:0;right:70%;">X</span>\n' +
                '                                                            </div>\n' +
                '\n' +
                '                                                        </div>');


        });

        $('body').on('click', '.remove-ladderband' ,function() {

            var id = $(this).data('id');

            if(id)
            {
                rem_lad_arr.push(id);
                $('#removed_ladderband_rows').val(rem_lad_arr);
            }

            var parent = this.parentNode.parentNode;

            $(parent).hide();
            $(parent).remove();

            if($(".ladderband_products_box .form-group").length == 0)
            {
                $(".ladderband_products_box").append('<div class="form-group" style="margin: 0 0 20px 0;display: flex;justify-content: center;">\n' +
                    '\n' +
                    '                                                            <div class="col-sm-2">\n' +
                    '\n' +
                    '                                                                <input class="form-control sub_code" name="sub_codes[]" id="blood_group_slug" placeholder="Sub Product ID" type="text">\n' +
                    '\n' +
                    '                                                            </div>\n' +
                    '\n' +
                    '                                                            <div class="col-sm-3">\n' +
                    '\n' +
                    '                                                                <input class="form-control sub_product_title" name="sub_product_titles[]" id="blood_group_slug" placeholder="Sub Product Title" type="text">\n' +
                    '\n' +
                    '                                                            </div>\n' +
                    '\n' +
                    '                                                           <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-3">\n' +
                    '\n' +
                    '                                                                <input type="hidden" name="size1_value[]" id="size1_value" value="0">\n' +
                    '\n' +
                    '                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                    '                                                                <label style="margin: 0;" class="switch">\n' +
                    '                                                                    <input class="size1_value" type="checkbox">\n' +
                    '                                                                    <span class="slider round"></span>\n' +
                    '                                                                </label>\n' +
                    '                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                    '\n' +
                    '                                                            </div>\n' +
                    '\n' +
                    '                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-3">\n' +
                    '\n' +
                    '                                                                <input type="hidden" name="size2_value[]" id="size2_value" value="0">\n' +
                    '\n' +
                    '                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                    '                                                                <label style="margin: 0;" class="switch">\n' +
                    '                                                                    <input class="size2_value" type="checkbox">\n' +
                    '                                                                    <span class="slider round"></span>\n' +
                    '                                                                </label>\n' +
                    '                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                    '\n' +
                    '                                                            </div>\n' +
                    '\n' +
                    '                                                            <div class="col-xs-1 col-sm-1">\n' +
                    '                                                                <span class="ui-close remove-ladderband" data-id="" style="margin:0;right:70%;">X</span>\n' +
                    '                                                            </div>\n' +
                    '\n' +
                    '                                                        </div>');

            }

        });

        $('body').on('change', '.size1_value', function() {

            if($(this).is(":checked"))
            {
                $(this).parent().parent().find('#size1_value').val(1);
            }
            else
            {
                $(this).parent().parent().find('#size1_value').val(0);
            }

        });

        $('body').on('change', '.size2_value', function() {

            if($(this).is(":checked"))
            {
                $(this).parent().parent().find('#size2_value').val(1);
            }
            else
            {
                $(this).parent().parent().find('#size2_value').val(0);
            }

        });

        $(document).on('keypress', ".max_size, .model_max_size", function(e){

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

        $(document).on('focusout', ".max_size, .model_max_size", function(e){

            if($(this).val().slice($(this).val().length - 1) == ',')
            {
                var val = $(this).val();
                val = val + '00';
                $(this).val(val);
            }
        });

        $(document).on('keypress', ".color_max_height", function(e){

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

        $(document).on('focusout', ".color_max_height", function(e){

            if($(this).val().slice($(this).val().length - 1) == ',')
            {
                var val = $(this).val();
                val = val + '00';
                $(this).val(val);
            }
        });

        $(document).on('keypress', ".base_price, #margin_input", function(e){

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

        $(document).on('focusout', ".base_price", function(e){

            if(!$(this).val())
            {
                $(this).val(0);
            }

        });

        $('body').on('change', '.childsafe', function() {

            if($(this).is(":checked"))
            {
                $(this).parent().parent().find('#childsafe').val(1);
            }
            else
            {
                $(this).parent().parent().find('#childsafe').val(0);
            }

        });

        $('body').on('change', '.ladderband', function() {

            if($(this).is(":checked"))
            {
                $(this).parent().parent().find('#ladderband').val(1);
                $('#ladderband_box').show();
            }
            else
            {
                $(this).parent().parent().find('#ladderband').val(0);
                $('#ladderband_box').hide();
            }

        });

        $('body').on('change', '.ladderband_price_impact', function() {

            if($(this).is(":checked"))
            {
                $(this).parent().parent().find('#ladderband_price_impact').val(1);
            }
            else
            {
                $(this).parent().parent().find('#ladderband_price_impact').val(0);
            }

        });

        $('body').on('change', '.ladderband_impact_type', function() {

            if($(this).is(":checked"))
            {
                $(this).parent().parent().find('#ladderband_impact_type').val(1);
            }
            else
            {
                $(this).parent().parent().find('#ladderband_impact_type').val(0);
            }

        });

        $('body').on('change', '.price_impact', function() {

            if($(this).is(":checked"))
            {
                $(this).parent().parent().find('#price_impact').val(1);
            }
            else
            {
                $(this).parent().parent().find('#price_impact').val(0);
            }

        });

        $('body').on('change', '.impact_type', function() {

            if($(this).is(":checked"))
            {
                $(this).parent().parent().find('#impact_type').val(1);
            }
            else
            {
                $(this).parent().parent().find('#impact_type').val(0);
            }

        });

        $('body').on('change', '.m2_impact', function() {

            if($(this).is(":checked"))
            {
                $(this).parent().parent().find('#m2_impact').val(1);
            }
            else
            {
                $(this).parent().parent().find('#m2_impact').val(0);
            }

        });

        $('body').on('change', '.width_impact', function() {

            if($(this).is(":checked"))
            {
                $(this).parent().parent().find('#width_impact').val(1);
            }
            else
            {
                $(this).parent().parent().find('#width_impact').val(0);
            }

        });

        $('body').on('change', '.variable', function() {

            if($(this).is(":checked"))
            {
                $(this).parent().parent().find('#variable').val(1);
            }
            else
            {
                $(this).parent().parent().find('#variable').val(0);
            }

        });

        $('body').on('input', '.color_title', function() {

            var val = $(this).val();
            var id = $(this).parent().parent().attr("data-id");

            if(id)
            {
                $('#example1 tbody').find("[data-id='" + id + "']").find('.color_col').text(val);
            }

        });

        $('body').on('input', '.color_code', function() {

            var val = $(this).val();
            var id = $(this).parent().parent().attr("data-id");

            if(id)
            {
                $('#example1 tbody').find("[data-id='" + id + "']").find('.code_col').text(val);
            }

        });

        $('body').on('change', '.js-data-example-ajax4', function() {

            var id = this.value;
            var selector = this;
            var code = $(selector).parent().parent().find('.color_code').val();
            var color = $(selector).parent().parent().find('.color_title').val();
            var row_id = $(this).parent().parent().attr("data-id");

            $.ajax({
                type:"GET",
                data: "id=" + id ,
                url: "<?php echo url('/aanbieder/product/get-prices-tables')?>",
                success: function(data) {

                    $.each(data, function(index, value) {

                        if(row_id && $('#example1 tbody').find("[data-id='" + row_id + "']").length > 0)
                        {

                            $('#example1 tbody').find("[data-id='" + row_id + "']").find('td', this).each(function (index) {

                                if(index == 0)
                                {
                                    $(this).text(value.id);
                                }
                                else if(index == 1)
                                {
                                    $(this).text(value.title);
                                }
                                else if(index == 2)
                                {
                                    $(this).text(color);
                                }
                                else if(index == 3)
                                {
                                    $(this).text(code);
                                }
                                else if(index == 4)
                                {
                                    $(this).html('<a href="/aanbieder/price-tables/prices/view/'+value.id+'">View</a>');
                                }

                            })
                        }
                        else
                        {
                            $("#example1").append('<tr data-id="'+row_id+'"><td>'+value.id+'</td><td>'+value.title+'</td><td class="color_col">'+color+'</td><td class="code_col">'+code+'</td><td><a href="/aanbieder/price-tables/prices/view/'+value.id+'">View</a></td></tr>');
                            /*$(selector).parent().parent().attr('data-id',row);
                            row++;*/
                        }

                    });

                }
            });
        });

        $("#add-color-btn").on('click',function() {

            var color_row = $('.color_box').find('.form-group').last().data('id');
            color_row = color_row + 1;

            $(".color_box").append('<div class="form-group" data-id="'+color_row+'">\n' +
                '\n' +
                '                                                                <div class="col-sm-3">\n' +
                '\n' +
                '                                                                    <input class="form-control color_title" name="colors[]" id="blood_group_slug" placeholder="Color Title" type="text">\n' +
                '\n' +
                '                                                                </div>\n' +
                '\n' +
                '                                                                <div class="col-sm-3">\n' +
                '\n' +
                '                                                                    <input class="form-control color_code" name="color_codes[]" id="blood_group_slug" placeholder="Color Code" type="text">\n' +
                '\n' +
                '                                                                </div>\n' +
                '\n' +
                '                                                                <div class="col-sm-2">\n' +
                '\n' +
                '                                                                    <input class="form-control color_max_height" maskedformat="9,1" name="color_max_height[]" id="blood_group_slug" placeholder="Max Height" type="text">\n' +
                '\n' +
                '                                                                </div>\n' +
                '\n' +
                '                                                                <div class="col-sm-3">\n' +
                '                                                                    <select class="form-control validate js-data-example-ajax4" name="price_tables[]">\n' +
                '\n' +
                '                                                                        <option value="">Select Price Table</option>\n' +
                '\n' +
                '                                                                        @foreach($tables as $table)\n' +
                '\n' +
                '                                                                            <option value="{{$table->id}}">{{$table->title}}</option>\n' +
                '\n' +
                '                                                                        @endforeach\n' +
                '\n' +
                '                                                                    </select>\n' +
                '                                                                </div>\n'+
                '\n' +
                '                <div class="col-xs-1 col-sm-1">\n' +
                '                <span class="ui-close remove-color" data-id="" style="margin:0;right:70%;">X</span>\n' +
                '                </div>\n' +
                '\n' +
                '                </div>');



            $(".js-data-example-ajax4").select2({
                width: '100%',
                height: '200px',
                placeholder: "Select Price Table",
                allowClear: true,
            });


        });

        $(document).on('click', "#add-primary-feature-btn", function(e){

            var id = $(this).data('id');
            var heading = $('.feature_box').find(".feature-row[data-id='" + id + "']").find('.js-data-example-ajax5').val();
            var feature_row = null;

            $('#primary-features').find(".feature-table-container").each(function() {

                $(this).find('table tbody tr').each(function() {

                    var value = parseInt($(this).find('.f_row').val());
                    feature_row = (value > feature_row) ? value : feature_row;

                });
            });

            feature_row = feature_row + 1;

            $('#primary-features').find(".feature-table-container[data-id='" + id + "']").find('table').append('<tr data-id="'+feature_row+'">\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <input type="hidden" name="f_rows[]" class="f_row" value="'+feature_row+'">' +
                '                                                                                            <input type="hidden" class="feature_heading" name="feature_headings[]" value="'+heading+'">\n' +
                '                                                                                            <input class="form-control feature_title" name="features[]" id="blood_group_slug" placeholder="Feature Title" type="text">\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <input class="form-control feature_value" name="feature_values[]" id="blood_group_slug" placeholder="Value" type="text">\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <button data-id="'+feature_row+'" class="btn btn-success create-sub-feature-btn" type="button">Create/Edit Sub Features</button>\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                '\n' +
                '                                                                                                <input type="hidden" name="price_impact[]" id="price_impact" value="0">\n' +
                '\n' +
                '                                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                '                                                                                                <label style="margin: 0;" class="switch">\n' +
                '                                                                                                    <input class="price_impact" type="checkbox">\n' +
                '                                                                                                    <span class="slider round"></span>\n' +
                '                                                                                                </label>\n' +
                '                                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                '\n' +
                '                                                                                            </div>\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                '\n' +
                '                                                                                                <input type="hidden" name="impact_type[]" id="impact_type" value="0">\n' +
                '\n' +
                '                                                                                                <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>\n' +
                '                                                                                                <label style="margin: 0;" class="switch">\n' +
                '                                                                                                    <input class="impact_type" type="checkbox">\n' +
                '                                                                                                    <span class="slider round"></span>\n' +
                '                                                                                                </label>\n' +
                '                                                                                                <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>\n' +
                '\n' +
                '                                                                                            </div>\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                '\n' +
                '                                                                                                <input type="hidden" name="variable[]" id="variable" value="0">\n' +
                '\n' +
                '                                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                '                                                                                                <label style="margin: 0;" class="switch">\n' +
                '                                                                                                    <input class="variable" type="checkbox">\n' +
                '                                                                                                    <span class="slider round"></span>\n' +
                '                                                                                                </label>\n' +
                '                                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                '\n' +
                '                                                                                            </div>\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <div style="display: flex;justify-content: center;"><span class="ui-close remove-primary-feature" data-id="" style="margin:0;position: relative;left: 0;right: 0;top: 0;">X</span></div>\n' +
                '                                                                                        </td>\n' +
                '                                                                                    </tr>');


            var feature_row1 = null;

            $('#sub-features').find(".sub-feature-table-container").each(function() {

                $(this).find('table tbody tr').each(function() {

                    var value = parseInt($(this).find('.f_row1').val());
                    feature_row1 = (value > feature_row1) ? value : feature_row1;

                });
            });

            feature_row1 = feature_row1 + 1;

            $('#sub-features').append('<div data-id="'+feature_row+'" class="sub-feature-table-container">\n' +
                '\n' +
                '                                                                                        <table style="margin: auto;width: 95%;border-collapse: separate;">\n' +
                '                                                                                            <thead>\n' +
                '                                                                                            <tr>\n' +
                '                                                                                                <th>Feature</th>\n' +
                '                                                                                                <th>Value</th>\n' +
                '                                                                                                <th>Price Impact</th>\n' +
                '                                                                                                <th>Impact Type</th>\n' +
                '                                                                                                <th>m¹ Impact</th>\n' +
                '                                                                                                <th>Remove</th>\n' +
                '                                                                                            </tr>\n' +
                '                                                                                            </thead>\n' +
                '\n' +
                '                                                                                            <tbody>' +
                '                                                                                        <tr data-id="'+feature_row1+'">\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <input type="hidden" name="f_rows'+feature_row+'[]" class="f_row1" value="'+feature_row1+'">' +
                '                                                                                            <input class="form-control feature_title1" name="features'+feature_row+'[]" id="blood_group_slug" placeholder="Feature Title" type="text">\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <input class="form-control feature_value1" name="feature_values'+feature_row+'[]" id="blood_group_slug" placeholder="Value" type="text">\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                '\n' +
                '                                                                                                <input type="hidden" name="price_impact'+feature_row+'[]" id="price_impact" value="0">\n' +
                '\n' +
                '                                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                '                                                                                                <label style="margin: 0;" class="switch">\n' +
                '                                                                                                    <input class="price_impact" type="checkbox">\n' +
                '                                                                                                    <span class="slider round"></span>\n' +
                '                                                                                                </label>\n' +
                '                                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                '\n' +
                '                                                                                            </div>\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                '\n' +
                '                                                                                                <input type="hidden" name="impact_type'+feature_row+'[]" id="impact_type" value="0">\n' +
                '\n' +
                '                                                                                                <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>\n' +
                '                                                                                                <label style="margin: 0;" class="switch">\n' +
                '                                                                                                    <input class="impact_type" type="checkbox">\n' +
                '                                                                                                    <span class="slider round"></span>\n' +
                '                                                                                                </label>\n' +
                '                                                                                                <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>\n' +
                '\n' +
                '                                                                                            </div>\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                '\n' +
                '                                                                                                <input type="hidden" name="variable'+feature_row+'[]" id="variable" value="0">\n' +
                '\n' +
                '                                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                '                                                                                                <label style="margin: 0;" class="switch">\n' +
                '                                                                                                    <input class="variable" type="checkbox">\n' +
                '                                                                                                    <span class="slider round"></span>\n' +
                '                                                                                                </label>\n' +
                '                                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                '\n' +
                '                                                                                            </div>\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <div style="display: flex;justify-content: center;"><span class="ui-close remove-sub-feature" data-id="" style="margin:0;position: relative;left: 0;right: 0;top: 0;">X</span></div>\n' +
                '                                                                                        </td>\n' +
                '                                                                                    </tr></tbody></table>' +
                '                                                                                        <div style="margin-top: 20px;" class="col-sm-12 text-center">\n' +
                '                                                                                            <button data-id="'+feature_row+'" class="btn btn-default featured-btn" type="button" id="add-sub-feature-btn"><i class="fa fa-plus"></i> Add More Sub Features</button>\n' +
                '                                                                                        </div></div>');

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
                '                                                                                            <input class="form-control feature_title1" name="features'+id+'[]" id="blood_group_slug" placeholder="Feature Title" type="text">\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <input class="form-control feature_value1" name="feature_values'+id+'[]" id="blood_group_slug" placeholder="Value" type="text">\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                '\n' +
                '                                                                                                <input type="hidden" name="price_impact'+id+'[]" id="price_impact" value="0">\n' +
                '\n' +
                '                                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                '                                                                                                <label style="margin: 0;" class="switch">\n' +
                '                                                                                                    <input class="price_impact" type="checkbox">\n' +
                '                                                                                                    <span class="slider round"></span>\n' +
                '                                                                                                </label>\n' +
                '                                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                '\n' +
                '                                                                                            </div>\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                '\n' +
                '                                                                                                <input type="hidden" name="impact_type'+id+'[]" id="impact_type" value="0">\n' +
                '\n' +
                '                                                                                                <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>\n' +
                '                                                                                                <label style="margin: 0;" class="switch">\n' +
                '                                                                                                    <input class="impact_type" type="checkbox">\n' +
                '                                                                                                    <span class="slider round"></span>\n' +
                '                                                                                                </label>\n' +
                '                                                                                                <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>\n' +
                '\n' +
                '                                                                                            </div>\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                '\n' +
                '                                                                                                <input type="hidden" name="variable'+id+'[]" id="variable" value="0">\n' +
                '\n' +
                '                                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                '                                                                                                <label style="margin: 0;" class="switch">\n' +
                '                                                                                                    <input class="variable" type="checkbox">\n' +
                '                                                                                                    <span class="slider round"></span>\n' +
                '                                                                                                </label>\n' +
                '                                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                '\n' +
                '                                                                                            </div>\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <div style="display: flex;justify-content: center;"><span class="ui-close remove-sub-feature" data-id="" style="margin:0;position: relative;left: 0;right: 0;top: 0;">X</span></div>\n' +
                '                                                                                        </td>\n' +
                '                                                                                    </tr>');

        });

        $("#add-feature-btn").on('click',function() {

            var heading_row = $('.feature_box').find('.feature-row').last().data('id');
            heading_row = heading_row + 1;
            var f_row = null;

            $('#primary-features').find(".feature-table-container").each(function() {

                $(this).find('table tbody tr').each(function() {

                    var value = parseInt($(this).find('.f_row').val());
                    f_row = (value > f_row) ? value : f_row;

                });
            });

            f_row = f_row + 1;

            $(".feature_box").append('<div data-id="' + heading_row + '" class="form-group feature-row" style="margin: 0 0 20px 0;display: flex;justify-content: center;">\n' +
                '\n' +
                '                                                                            <div class="col-sm-5">\n' +
                '\n' +
                '                                                                            <select class="form-control validate js-data-example-ajax5">\n' +
                '\n' +
                '                                                                                <option value="">Select Feature Heading</option>\n' +
                '\n' +
                '                                                                                @foreach($features_headings as $feature)\n' +
                '\n' +
                '                                                                                    <option value="{{$feature->id}}">{{$feature->title}}</option>\n' +
                '\n' +
                '                                                                                @endforeach\n' +
                '\n' +
                '                                                                            </select>\n' +
                '\n' +
                '                                                                        </div>\n' +
                '\n' +
                '                                                                    <div style="display: flex;" class="col-sm-5">\n' +
                '\n' +
                '                                                                        <button data-id="' + heading_row + '" style="margin-right: 10px;" class="btn btn-success create-feature-btn" type="button">Create/Edit Features</button>\n' +
                '                                                                        <span class="ui-close remove-feature" data-id="" style="margin:0;position: relative;left: 0;right: 0;">X</span>\n' +
                /*'                                                                        <input class="form-control feature_title" name="features[]" id="blood_group_slug" placeholder="Feature Title" type="text">\n' +*/
                '\n' +
                '                                                                    </div>\n' +
                '\n' +
                /*'                                                                    <div class="col-sm-1">\n' +
                '\n' +
                '                                                                        <input class="form-control feature_value" name="feature_values[]" id="blood_group_slug" placeholder="Value" type="text">\n' +
                '\n' +
                '                                                                    </div>\n' +
                '\n' +
                '                                                                    <div class="col-sm-1">\n' +
                '\n' +
                '                                                                        <input class="form-control max_size" name="max_size[]" maskedformat="9,1" id="blood_group_slug" placeholder="Max Size" type="text">\n' +
                '\n' +
                '                                                                    </div>\n' +
                '\n' +
                '                                                                    <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-2">\n' +
                '\n' +
                '                                                                   <input type="hidden" name="price_impact[]" id="price_impact" value="0">\n' +
                '\n' +
                '                                                                        <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                '                                                                        <label style="margin: 0;" class="switch">\n' +
                '                                                                            <input class="price_impact" type="checkbox">\n' +
                '                                                                            <span class="slider round"></span>\n' +
                '                                                                        </label>\n' +
                '                                                                        <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                '\n' +
                '                                                                    </div>\n' +
                '\n' +
                '                                                                    <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-2">\n' +
                '\n' +
                '                                                                   <input type="hidden" name="impact_type[]" id="impact_type" value="0">\n' +
                '\n' +
                '                                                                        <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>\n' +
                '                                                                        <label style="margin: 0;" class="switch">\n' +
                '                                                                            <input class="impact_type" type="checkbox">\n' +
                '                                                                            <span class="slider round"></span>\n' +
                '                                                                        </label>\n' +
                '                                                                        <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>\n' +
                '\n' +
                '                                                                    </div>\n' +*/
                /*'\n' +
                '                                                                    <div class="col-xs-1 col-sm-1">\n' +
                '                                                                        <span class="ui-close remove-feature" data-id="" style="margin:0;right:70%;">X</span>\n' +
                '                                                                    </div>\n'+*/
                '\n' +
                '                </div>');

            $('#primary-features').append('<div data-id="'+heading_row+'" class="feature-table-container">\n' +
                '\n' +
                '                                                                                    <table style="margin: auto;width: 95%;border-collapse: separate;">\n' +
                '                                                                                        <thead>\n' +
                '                                                                                        <tr>\n' +
                '                                                                                            <th>Feature</th>\n' +
                '                                                                                            <th>Value</th>\n' +
                '                                                                                            <th>Sub Features</th>\n' +
                '                                                                                            <th>Price Impact</th>\n' +
                '                                                                                            <th>Impact Type</th>\n' +
                '                                                                                            <th>m¹ Impact</th>\n' +
                '                                                                                            <th>Remove</th>\n' +
                '                                                                                        </tr>\n' +
                '                                                                                        </thead>\n' +
                '\n' +
                '                                                                                        <tbody>' +
                '                                                                                   <tr data-id="'+f_row+'">\n' +
                '\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <input type="hidden" name="f_rows[]" class="f_row" value="'+f_row+'">' +
                '                                                                                            <input type="hidden" class="feature_heading" name="feature_headings[]">\n' +
                '                                                                                            <input class="form-control feature_title" name="features[]" id="blood_group_slug" placeholder="Feature Title" type="text">\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <input class="form-control feature_value" name="feature_values[]" id="blood_group_slug" placeholder="Value" type="text">\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <button data-id="'+f_row+'" class="btn btn-success create-sub-feature-btn" type="button">Create/Edit Sub Features</button>\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                '\n' +
                '                                                                                                <input type="hidden" name="price_impact[]" id="price_impact" value="0">\n' +
                '\n' +
                '                                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                '                                                                                                <label style="margin: 0;" class="switch">\n' +
                '                                                                                                    <input class="price_impact" type="checkbox">\n' +
                '                                                                                                    <span class="slider round"></span>\n' +
                '                                                                                                </label>\n' +
                '                                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                '\n' +
                '                                                                                            </div>\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                '\n' +
                '                                                                                                <input type="hidden" name="impact_type[]" id="impact_type" value="0">\n' +
                '\n' +
                '                                                                                                <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>\n' +
                '                                                                                                <label style="margin: 0;" class="switch">\n' +
                '                                                                                                    <input class="impact_type" type="checkbox">\n' +
                '                                                                                                    <span class="slider round"></span>\n' +
                '                                                                                                </label>\n' +
                '                                                                                                <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>\n' +
                '\n' +
                '                                                                                            </div>\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                '\n' +
                '                                                                                                <input type="hidden" name="variable[]" id="variable" value="0">\n' +
                '\n' +
                '                                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                '                                                                                                <label style="margin: 0;" class="switch">\n' +
                '                                                                                                    <input class="variable" type="checkbox">\n' +
                '                                                                                                    <span class="slider round"></span>\n' +
                '                                                                                                </label>\n' +
                '                                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                '\n' +
                '                                                                                            </div>\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <div style="display: flex;justify-content: center;"><span class="ui-close remove-primary-feature" data-id="" style="margin:0;position: relative;left: 0;right: 0;top: 0;">X</span></div>\n' +
                '                                                                                        </td>\n' +
                '                                                                                    </tr></tbody></table>' +
                '                                                                                    <div style="margin-top: 20px;" class="col-sm-12 text-center">\n' +
                '                                                                                        <button data-id="'+heading_row+'" class="btn btn-default featured-btn" type="button" id="add-primary-feature-btn"><i class="fa fa-plus"></i> Add More Features</button>\n' +
                '                                                                                    </div></div>');

            var feature_row1 = null;

            $('#sub-features').find(".sub-feature-table-container").each(function() {

                $(this).find('table tbody tr').each(function() {

                    var value = parseInt($(this).find('.f_row1').val());
                    feature_row1 = (value > feature_row1) ? value : feature_row1;

                });
            });

            feature_row1 = feature_row1 + 1;

            $('#sub-features').append('<div data-id="'+f_row+'" class="sub-feature-table-container">\n' +
                '\n' +
                '                                                                                        <table style="margin: auto;width: 95%;border-collapse: separate;">\n' +
                '                                                                                            <thead>\n' +
                '                                                                                            <tr>\n' +
                '                                                                                                <th>Feature</th>\n' +
                '                                                                                                <th>Value</th>\n' +
                '                                                                                                <th>Price Impact</th>\n' +
                '                                                                                                <th>Impact Type</th>\n' +
                '                                                                                                <th>m¹ Impact</th>\n' +
                '                                                                                                <th>Remove</th>\n' +
                '                                                                                            </tr>\n' +
                '                                                                                            </thead>\n' +
                '\n' +
                '                                                                                            <tbody>' +
                '                                                                                        <tr data-id="'+feature_row1+'">\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <input type="hidden" name="f_rows'+f_row+'[]" class="f_row1" value="'+feature_row1+'">' +
                '                                                                                            <input class="form-control feature_title1" name="features'+f_row+'[]" id="blood_group_slug" placeholder="Feature Title" type="text">\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <input class="form-control feature_value1" name="feature_values'+f_row+'[]" id="blood_group_slug" placeholder="Value" type="text">\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                '\n' +
                '                                                                                                <input type="hidden" name="price_impact'+f_row+'[]" id="price_impact" value="0">\n' +
                '\n' +
                '                                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                '                                                                                                <label style="margin: 0;" class="switch">\n' +
                '                                                                                                    <input class="price_impact" type="checkbox">\n' +
                '                                                                                                    <span class="slider round"></span>\n' +
                '                                                                                                </label>\n' +
                '                                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                '\n' +
                '                                                                                            </div>\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                '\n' +
                '                                                                                                <input type="hidden" name="impact_type'+f_row+'[]" id="impact_type" value="0">\n' +
                '\n' +
                '                                                                                                <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>\n' +
                '                                                                                                <label style="margin: 0;" class="switch">\n' +
                '                                                                                                    <input class="impact_type" type="checkbox">\n' +
                '                                                                                                    <span class="slider round"></span>\n' +
                '                                                                                                </label>\n' +
                '                                                                                                <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>\n' +
                '\n' +
                '                                                                                            </div>\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                '\n' +
                '                                                                                                <input type="hidden" name="variable'+f_row+'[]" id="variable" value="0">\n' +
                '\n' +
                '                                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                '                                                                                                <label style="margin: 0;" class="switch">\n' +
                '                                                                                                    <input class="variable" type="checkbox">\n' +
                '                                                                                                    <span class="slider round"></span>\n' +
                '                                                                                                </label>\n' +
                '                                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                '\n' +
                '                                                                                            </div>\n' +
                '                                                                                        </td>\n' +
                '                                                                                        <td>\n' +
                '                                                                                            <div style="display: flex;justify-content: center;"><span class="ui-close remove-sub-feature" data-id="" style="margin:0;position: relative;left: 0;right: 0;top: 0;">X</span></div>\n' +
                '                                                                                        </td>\n' +
                '                                                                                    </tr></tbody></table>' +
                '                                                                                        <div style="margin-top: 20px;" class="col-sm-12 text-center">\n' +
                '                                                                                            <button data-id="'+f_row+'" class="btn btn-default featured-btn" type="button" id="add-sub-feature-btn"><i class="fa fa-plus"></i> Add More Sub Features</button>\n' +
                '                                                                                        </div></div>');

            $(".js-data-example-ajax5").select2({
                width: '100%',
                height: '200px',
                placeholder: "Select Feature Heading",
                allowClear: true,
            });


        });

        $(".js-data-example-ajax").select2({
            width: '100%',
            height: '200px',
            placeholder: "Select Category",
            allowClear: true,
        });

        $(".js-data-example-ajax1").select2({
            width: '100%',
            height: '200px',
            placeholder: "Select Brand",
            allowClear: true,
        });

        /*$(".js-data-example-ajax2").select2({
            width: '80%',
            height: '200px',
            placeholder: "Select Model",
            allowClear: true,
        });*/


        $(".js-data-example-ajax4").select2({
            width: '100%',
            height: '200px',
            placeholder: "Select Price Table",
            allowClear: true,
        });

        $(".js-data-example-ajax5").select2({
            width: '100%',
            height: '200px',
            placeholder: "Select Feature Heading",
            allowClear: true,
        });

        $(".js-data-example-ajax7").select2({
            width: '100%',
            height: '200px',
            placeholder: "Select Feature",
            allowClear: true,
        });


        $('.js-data-example-ajax1').on('change', function() {

            var brand_id = $(this).val();
            var options = '';

            $.ajax({
                type:"GET",
                data: "id=" + brand_id ,
                url: "<?php echo url('/aanbieder/product/products-models-by-brands')?>",
                success: function(data) {

                    $.each(data, function(index, value) {

                        var opt = '<option value="'+value.id+'" >'+value.cat_slug+'</option>';

                        options = options + opt;

                    });

                    /*$('.js-data-example-ajax2').find('option')
                        .remove()
                        .end()
                        .append('<option value="">Select Model</option>'+options);*/

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

        $('body').on('click', '.remove-color' ,function() {

            var parent = this.parentNode.parentNode;
            var id = $(this).parent().parent().attr("data-id");

            if(id)
            {
                $('#example1 tbody').find("[data-id='" + id + "']").remove();
            }

            var rem_id = $(this).data('id');

            if(rem_id)
            {
                rem_col_arr.push(rem_id);
                $('#removed_colors').val(rem_col_arr);
            }

            $(parent).hide();
            $(parent).remove();

            if($(".color_box .form-group").length == 0)
            {
                $(".color_box").append('<div class="form-group" data-id="1">\n' +
                    '\n' +
                    '                                                                <div class="col-sm-3">\n' +
                    '\n' +
                    '                                                                    <input class="form-control color_title" name="colors[]" id="blood_group_slug" placeholder="Color Title" type="text">\n' +
                    '\n' +
                    '                                                                </div>\n' +
                    '\n' +
                    '                                                                <div class="col-sm-3">\n' +
                    '\n' +
                    '                                                                    <input class="form-control color_code" name="color_codes[]" id="blood_group_slug" placeholder="Color Code" type="text">\n' +
                    '\n' +
                    '                                                                </div>\n' +
                    '\n' +
                    '                                                                <div class="col-sm-2">\n' +
                    '\n' +
                    '                                                                    <input class="form-control color_max_height" maskedformat="9,1" name="color_max_height[]" id="blood_group_slug" placeholder="Max Height" type="text">\n' +
                    '\n' +
                    '                                                                </div>\n' +
                    '\n' +
                    '                                                                <div class="col-sm-3">\n' +
                    '                                                                    <select class="form-control validate js-data-example-ajax4" name="price_tables[]">\n' +
                    '\n' +
                    '                                                                        <option value="">Select Price Table</option>\n' +
                    '\n' +
                    '                                                                        @foreach($tables as $table)\n' +
                    '\n' +
                    '                                                                            <option value="{{$table->id}}">{{$table->title}}</option>\n' +
                    '\n' +
                    '                                                                        @endforeach\n' +
                    '\n' +
                    '                                                                    </select>\n' +
                    '                                                                </div>\n'+
                    '\n' +
                    '                <div class="col-xs-1 col-sm-1">\n' +
                    '                <span class="ui-close remove-color" data-id="" style="margin:0;right:70%;">X</span>\n' +
                    '                </div>\n' +
                    '\n' +
                    '                </div>');


                $(".js-data-example-ajax4").select2({
                    width: '100%',
                    height: '200px',
                    placeholder: "Select Price Table",
                    allowClear: true,
                });


            }

        });

        $('body').on('click', '.remove-sub-feature' ,function() {

            var id = $(this).data('id');
            var row_id = $(this).parent().parent().parent().data('id');
            var heading_id = $(this).parent().parent().parent().parent().parent().parent().data('id');
            var f_row = null;

            $('#sub-features').find(".sub-feature-table-container").each(function() {

                $(this).find('table tbody tr').each(function() {

                    var value = parseInt($(this).find('.f_row1').val());
                    f_row = (value > f_row) ? value : f_row;

                });
            });

            f_row = f_row + 1;

            if(id)
            {
                rem_arr.push(id);
                $('#removed_rows').val(rem_arr);
            }

            $('#sub-features').find(".sub-feature-table-container").find("table tbody tr[data-id='" + row_id + "']").remove();

            if($('#sub-features').find(".sub-feature-table-container[data-id='" + heading_id + "']").find("table tbody tr").length == 0)
            {

                $('#sub-features').find(".sub-feature-table-container[data-id='" + heading_id + "']").find('table').append('<tr data-id="'+f_row+'">\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <input type="hidden" name="f_rows'+heading_id+'[]" class="f_row1" value="'+f_row+'">' +
                    '                                                                                            <input class="form-control feature_title1" name="features'+heading_id+'[]" id="blood_group_slug" placeholder="Feature Title" type="text">\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <input class="form-control feature_value1" name="feature_values'+heading_id+'[]" id="blood_group_slug" placeholder="Value" type="text">\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                    '\n' +
                    '                                                                                                <input type="hidden" name="price_impact'+heading_id+'[]" id="price_impact" value="0">\n' +
                    '\n' +
                    '                                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                    '                                                                                                <label style="margin: 0;" class="switch">\n' +
                    '                                                                                                    <input class="price_impact" type="checkbox">\n' +
                    '                                                                                                    <span class="slider round"></span>\n' +
                    '                                                                                                </label>\n' +
                    '                                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                    '\n' +
                    '                                                                                            </div>\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                    '\n' +
                    '                                                                                                <input type="hidden" name="impact_type'+heading_id+'[]" id="impact_type" value="0">\n' +
                    '\n' +
                    '                                                                                                <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>\n' +
                    '                                                                                                <label style="margin: 0;" class="switch">\n' +
                    '                                                                                                    <input class="impact_type" type="checkbox">\n' +
                    '                                                                                                    <span class="slider round"></span>\n' +
                    '                                                                                                </label>\n' +
                    '                                                                                                <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>\n' +
                    '\n' +
                    '                                                                                            </div>\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                    '\n' +
                    '                                                                                                <input type="hidden" name="variable'+heading_id+'[]" id="variable" value="0">\n' +
                    '\n' +
                    '                                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                    '                                                                                                <label style="margin: 0;" class="switch">\n' +
                    '                                                                                                    <input class="variable" type="checkbox">\n' +
                    '                                                                                                    <span class="slider round"></span>\n' +
                    '                                                                                                </label>\n' +
                    '                                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                    '\n' +
                    '                                                                                            </div>\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <div style="display: flex;justify-content: center;"><span class="ui-close remove-sub-feature" data-id="" style="margin:0;position: relative;left: 0;right: 0;top: 0;">X</span></div>\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                    </tr>');

            }

        });

        $('body').on('click', '.remove-primary-feature' ,function() {

            var id = $(this).data('id');
            var row_id = $(this).parent().parent().parent().data('id');
            var heading_id = $(this).parent().parent().parent().parent().parent().parent().data('id');
            var heading = $('.feature_box').find(".feature-row[data-id='" + heading_id + "']").find('.js-data-example-ajax5').val();
            var f_row = null;

            $('#primary-features').find(".feature-table-container").each(function() {

                $(this).find('table tbody tr').each(function() {

                    var value = parseInt($(this).find('.f_row').val());
                    f_row = (value > f_row) ? value : f_row;

                });
            });

            f_row = f_row + 1;

            $('#models-features-tables table tbody').find("[data-id='" + row_id + "']").remove();

            if(id)
            {
                rem_arr.push(id);

                $('#sub-features').find(".sub-feature-table-container[data-id='" + row_id + "']").find('table tbody tr').each(function (index) {

                    if($(this).find('.remove-sub-feature').data('id'))
                    {
                        rem_arr.push($(this).find('.remove-sub-feature').data('id'));
                    }

                });

                $('#removed_rows').val(rem_arr);
            }

            $('#primary-features').find(".feature-table-container[data-id='" + heading_id + "']").find("table tbody tr[data-id='" + row_id + "']").remove();
            $('#sub-features').find(".sub-feature-table-container[data-id='" + row_id + "']").remove();

            if($('#primary-features').find(".feature-table-container[data-id='" + heading_id + "']").find("table tbody tr").length == 0)
            {

                $('#primary-features').find(".feature-table-container[data-id='" + heading_id + "']").find("table").append('<tr data-id="'+f_row+'">\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <input type="hidden" name="f_rows[]" class="f_row" value="'+f_row+'">' +
                    '                                                                                            <input type="hidden" class="feature_heading" name="feature_headings[]" value="'+heading+'">\n' +
                    '                                                                                            <input class="form-control feature_title" name="features[]" id="blood_group_slug" placeholder="Feature Title" type="text">\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <input class="form-control feature_value" name="feature_values[]" id="blood_group_slug" placeholder="Value" type="text">\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <button data-id="'+f_row+'" class="btn btn-success create-sub-feature-btn" type="button">Create/Edit Sub Features</button>\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                    '\n' +
                    '                                                                                                <input type="hidden" name="price_impact[]" id="price_impact" value="0">\n' +
                    '\n' +
                    '                                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                    '                                                                                                <label style="margin: 0;" class="switch">\n' +
                    '                                                                                                    <input class="price_impact" type="checkbox">\n' +
                    '                                                                                                    <span class="slider round"></span>\n' +
                    '                                                                                                </label>\n' +
                    '                                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                    '\n' +
                    '                                                                                            </div>\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                    '\n' +
                    '                                                                                                <input type="hidden" name="impact_type[]" id="impact_type" value="0">\n' +
                    '\n' +
                    '                                                                                                <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>\n' +
                    '                                                                                                <label style="margin: 0;" class="switch">\n' +
                    '                                                                                                    <input class="impact_type" type="checkbox">\n' +
                    '                                                                                                    <span class="slider round"></span>\n' +
                    '                                                                                                </label>\n' +
                    '                                                                                                <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>\n' +
                    '\n' +
                    '                                                                                            </div>\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                    '\n' +
                    '                                                                                                <input type="hidden" name="variable[]" id="variable" value="0">\n' +
                    '\n' +
                    '                                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                    '                                                                                                <label style="margin: 0;" class="switch">\n' +
                    '                                                                                                    <input class="variable" type="checkbox">\n' +
                    '                                                                                                    <span class="slider round"></span>\n' +
                    '                                                                                                </label>\n' +
                    '                                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                    '\n' +
                    '                                                                                            </div>\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <div style="display: flex;justify-content: center;"><span class="ui-close remove-primary-feature" data-id="" style="margin:0;position: relative;left: 0;right: 0;top: 0;">X</span></div>\n' +
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

                $('#sub-features').append('<div data-id="'+f_row+'" class="sub-feature-table-container">\n' +
                    '\n' +
                    '                                                                                        <table style="margin: auto;width: 95%;border-collapse: separate;">\n' +
                    '                                                                                            <thead>\n' +
                    '                                                                                            <tr>\n' +
                    '                                                                                                <th>Feature</th>\n' +
                    '                                                                                                <th>Value</th>\n' +
                    '                                                                                                <th>Price Impact</th>\n' +
                    '                                                                                                <th>Impact Type</th>\n' +
                    '                                                                                                <th>m¹ Impact</th>\n' +
                    '                                                                                                <th>Remove</th>\n' +
                    '                                                                                            </tr>\n' +
                    '                                                                                            </thead>\n' +
                    '\n' +
                    '                                                                                            <tbody>' +
                    '                                                                                        <tr data-id="'+f_row1+'">\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <input type="hidden" name="f_rows'+f_row+'[]" class="f_row1" value="'+f_row1+'">' +
                    '                                                                                            <input class="form-control feature_title1" name="features'+f_row+'[]" id="blood_group_slug" placeholder="Feature Title" type="text">\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <input class="form-control feature_value1" name="feature_values'+f_row+'[]" id="blood_group_slug" placeholder="Value" type="text">\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                    '\n' +
                    '                                                                                                <input type="hidden" name="price_impact'+f_row+'[]" id="price_impact" value="0">\n' +
                    '\n' +
                    '                                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                    '                                                                                                <label style="margin: 0;" class="switch">\n' +
                    '                                                                                                    <input class="price_impact" type="checkbox">\n' +
                    '                                                                                                    <span class="slider round"></span>\n' +
                    '                                                                                                </label>\n' +
                    '                                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                    '\n' +
                    '                                                                                            </div>\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                    '\n' +
                    '                                                                                                <input type="hidden" name="impact_type'+f_row+'[]" id="impact_type" value="0">\n' +
                    '\n' +
                    '                                                                                                <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>\n' +
                    '                                                                                                <label style="margin: 0;" class="switch">\n' +
                    '                                                                                                    <input class="impact_type" type="checkbox">\n' +
                    '                                                                                                    <span class="slider round"></span>\n' +
                    '                                                                                                </label>\n' +
                    '                                                                                                <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>\n' +
                    '\n' +
                    '                                                                                            </div>\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                    '\n' +
                    '                                                                                                <input type="hidden" name="variable'+f_row+'[]" id="variable" value="0">\n' +
                    '\n' +
                    '                                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                    '                                                                                                <label style="margin: 0;" class="switch">\n' +
                    '                                                                                                    <input class="variable" type="checkbox">\n' +
                    '                                                                                                    <span class="slider round"></span>\n' +
                    '                                                                                                </label>\n' +
                    '                                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                    '\n' +
                    '                                                                                            </div>\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <div style="display: flex;justify-content: center;"><span class="ui-close remove-sub-feature" data-id="" style="margin:0;position: relative;left: 0;right: 0;top: 0;">X</span></div>\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                    </tr></tbody></table>' +
                    '                                                                                        <div style="margin-top: 20px;" class="col-sm-12 text-center">\n' +
                    '                                                                                            <button data-id="'+f_row+'" class="btn btn-default featured-btn" type="button" id="add-sub-feature-btn"><i class="fa fa-plus"></i> Add More Sub Features</button>\n' +
                    '                                                                                        </div></div>');

            }

        });

        $('body').on('click', '.remove-feature' ,function() {

            var id = $(this).data('id');
            var row_id = $(this).parent().parent().data('id');

            $('#primary-features').find(".feature-table-container[data-id='" + row_id + "']").find('table tbody tr').each(function (index) {

                var row = $(this).find('.f_row').val();

                if($(this).find('.remove-primary-feature').data('id'))
                {
                    rem_arr.push($(this).find('.remove-primary-feature').data('id'));
                }

                $('#models-features-tables table tbody').find("[data-id='" + row + "']").remove();

                $('#sub-features').find(".sub-feature-table-container[data-id='" + row + "']").find('table tbody tr').each(function (index) {

                    if($(this).find('.remove-sub-feature').data('id'))
                    {
                        rem_arr.push($(this).find('.remove-sub-feature').data('id'));
                    }

                });

                $('#sub-features').find(".sub-feature-table-container[data-id='" + row + "']").remove();

            });

            $('#primary-features').find(".feature-table-container[data-id='" + row_id + "']").remove();


            if(id)
            {
                $('#removed_rows').val(rem_arr);
            }

            var parent = this.parentNode.parentNode;

            $(parent).hide();
            $(parent).remove();

            if($(".feature_box .form-group").length == 0)
            {
                $(".feature_box").append('<div data-id="1" class="form-group feature-row" style="margin: 0 0 20px 0;display: flex;justify-content: center;">\n' +
                    '\n' +
                    '                                                                            <input type="hidden" name="f_rows[]" class="f_row" value="1">\n' +
                    '\n' +
                    '                                                                            <div class="col-sm-5">\n' +
                    '\n' +
                    '                                                                            <select class="form-control validate js-data-example-ajax5">\n' +
                    '\n' +
                    '                                                                                <option value="">Select Feature Heading</option>\n' +
                    '\n' +
                    '                                                                                @foreach($features_headings as $feature)\n' +
                    '\n' +
                    '                                                                                    <option value="{{$feature->id}}">{{$feature->title}}</option>\n' +
                    '\n' +
                    '                                                                                @endforeach\n' +
                    '\n' +
                    '                                                                            </select>\n' +
                    '\n' +
                    '                                                                        </div>\n'+
                    '\n' +
                    '                                                                    <div style="display: flex;" class="col-sm-5">\n' +
                    '\n' +
                    '                                                                        <button data-id="1" style="margin-right: 10px;" class="btn btn-success create-feature-btn" type="button">Create/Edit Features</button>\n' +
                    '                                                                        <span class="ui-close remove-feature" data-id="" style="margin:0;position: relative;left: 0;right: 0;">X</span>\n' +
                    /*'                                                                        <input class="form-control feature_title" name="features[]" id="blood_group_slug" placeholder="Feature Title" type="text">\n' +*/
                    '\n' +
                    '                                                                    </div>\n' +
                    '\n' +
                    /*'                                                                    <div class="col-sm-1">\n' +
                    '\n' +
                    '                                                                        <input class="form-control feature_value" name="feature_values[]" id="blood_group_slug" placeholder="Value" type="text">\n' +
                    '\n' +
                    '                                                                    </div>\n' +
                    '\n' +
                    '                                                                    <div class="col-sm-1">\n' +
                    '\n' +
                    '                                                                        <input class="form-control max_size" name="max_size[]" maskedformat="9,1" id="blood_group_slug" placeholder="Max Size" type="text">\n' +
                    '\n' +
                    '                                                                    </div>\n' +
                    '\n' +
                    '                                                                    <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-2">\n' +
                    '\n' +
                    '                                                                   <input type="hidden" name="price_impact[]" id="price_impact" value="0">\n' +
                    '\n' +
                    '                                                                        <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                    '                                                                        <label style="margin: 0;" class="switch">\n' +
                    '                                                                            <input class="price_impact" type="checkbox">\n' +
                    '                                                                            <span class="slider round"></span>\n' +
                    '                                                                        </label>\n' +
                    '                                                                        <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                    '\n' +
                    '                                                                    </div>\n' +
                    '\n' +
                    '                                                                    <div style="display: flex;align-items: center;height: 40px;justify-content: center;" class="col-sm-2">\n' +
                    '\n' +
                    '                                                                   <input type="hidden" name="impact_type[]" id="impact_type" value="0">\n' +
                    '\n' +
                    '                                                                        <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>\n' +
                    '                                                                        <label style="margin: 0;" class="switch">\n' +
                    '                                                                            <input class="impact_type" type="checkbox">\n' +
                    '                                                                            <span class="slider round"></span>\n' +
                    '                                                                        </label>\n' +
                    '                                                                        <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>\n' +
                    '\n' +
                    '                                                                    </div>\n' +
                    '\n' +
                    '\n' +
                    '                                                                    <div class="col-xs-1 col-sm-1">\n' +
                    '                                                                        <span class="ui-close remove-feature" data-id="" style="margin:0;right:70%;">X</span>\n' +
                    '                                                                    </div>\n'+*/
                    '\n' +
                    '                </div>');

                $('#primary-features').append('<div data-id="1" class="feature-table-container">\n' +
                    '\n' +
                    '                                                                                    <table style="margin: auto;width: 95%;border-collapse: separate;">\n' +
                    '                                                                                        <thead>\n' +
                    '                                                                                        <tr>\n' +
                    '                                                                                            <th>Feature</th>\n' +
                    '                                                                                            <th>Value</th>\n' +
                    '                                                                                            <th>Sub Features</th>\n' +
                    '                                                                                            <th>Price Impact</th>\n' +
                    '                                                                                            <th>Impact Type</th>\n' +
                    '                                                                                            <th>Remove</th>\n' +
                    '                                                                                        </tr>\n' +
                    '                                                                                        </thead>\n' +
                    '\n' +
                    '                                                                                        <tbody>' +
                    '                                                                                   <tr data-id="1">\n' +
                    '\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <input type="hidden" name="f_rows[]" class="f_row" value="1">' +
                    '                                                                                            <input type="hidden" class="feature_heading" name="feature_headings[]">\n' +
                    '                                                                                            <input class="form-control feature_title" name="features[]" id="blood_group_slug" placeholder="Feature Title" type="text">\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <input class="form-control feature_value" name="feature_values[]" id="blood_group_slug" placeholder="Value" type="text">\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <button data-id="1" class="btn btn-success create-sub-feature-btn" type="button">Create/Edit Sub Features</button>\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                    '\n' +
                    '                                                                                                <input type="hidden" name="price_impact[]" id="price_impact" value="0">\n' +
                    '\n' +
                    '                                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                    '                                                                                                <label style="margin: 0;" class="switch">\n' +
                    '                                                                                                    <input class="price_impact" type="checkbox">\n' +
                    '                                                                                                    <span class="slider round"></span>\n' +
                    '                                                                                                </label>\n' +
                    '                                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                    '\n' +
                    '                                                                                            </div>\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                    '\n' +
                    '                                                                                                <input type="hidden" name="impact_type[]" id="impact_type" value="0">\n' +
                    '\n' +
                    '                                                                                                <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>\n' +
                    '                                                                                                <label style="margin: 0;" class="switch">\n' +
                    '                                                                                                    <input class="impact_type" type="checkbox">\n' +
                    '                                                                                                    <span class="slider round"></span>\n' +
                    '                                                                                                </label>\n' +
                    '                                                                                                <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>\n' +
                    '\n' +
                    '                                                                                            </div>\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                    '\n' +
                    '                                                                                                <input type="hidden" name="variable[]" id="variable" value="0">\n' +
                    '\n' +
                    '                                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                    '                                                                                                <label style="margin: 0;" class="switch">\n' +
                    '                                                                                                    <input class="variable" type="checkbox">\n' +
                    '                                                                                                    <span class="slider round"></span>\n' +
                    '                                                                                                </label>\n' +
                    '                                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                    '\n' +
                    '                                                                                            </div>\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <div style="display: flex;justify-content: center;"><span class="ui-close remove-primary-feature" data-id="" style="margin:0;position: relative;left: 0;right: 0;top: 0;">X</span></div>\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                    </tr></tbody></table>' +
                    '                                                                                    <div style="margin-top: 20px;" class="col-sm-12 text-center">\n' +
                    '                                                                                        <button data-id="1" class="btn btn-default featured-btn" type="button" id="add-primary-feature-btn"><i class="fa fa-plus"></i> Add More Features</button>\n' +
                    '                                                                                    </div></div>');


                $('#sub-features').append('<div data-id="1" class="sub-feature-table-container">\n' +
                    '\n' +
                    '                                                                                        <table style="margin: auto;width: 95%;border-collapse: separate;">\n' +
                    '                                                                                            <thead>\n' +
                    '                                                                                            <tr>\n' +
                    '                                                                                                <th>Feature</th>\n' +
                    '                                                                                                <th>Value</th>\n' +
                    '                                                                                                <th>Price Impact</th>\n' +
                    '                                                                                                <th>Impact Type</th>\n' +
                    '                                                                                                <th>m¹ Impact</th>\n' +
                    '                                                                                                <th>Remove</th>\n' +
                    '                                                                                            </tr>\n' +
                    '                                                                                            </thead>\n' +
                    '\n' +
                    '                                                                                            <tbody>' +
                    '                                                                                        <tr data-id="1">\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <input type="hidden" name="f_rows1[]" class="f_row1" value="1">' +
                    '                                                                                            <input class="form-control feature_title1" name="features1[]" id="blood_group_slug" placeholder="Feature Title" type="text">\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <input class="form-control feature_value1" name="feature_values1[]" id="blood_group_slug" placeholder="Value" type="text">\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                    '\n' +
                    '                                                                                                <input type="hidden" name="price_impact1[]" id="price_impact" value="0">\n' +
                    '\n' +
                    '                                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                    '                                                                                                <label style="margin: 0;" class="switch">\n' +
                    '                                                                                                    <input class="price_impact" type="checkbox">\n' +
                    '                                                                                                    <span class="slider round"></span>\n' +
                    '                                                                                                </label>\n' +
                    '                                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                    '\n' +
                    '                                                                                            </div>\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                    '\n' +
                    '                                                                                                <input type="hidden" name="impact_type1[]" id="impact_type" value="0">\n' +
                    '\n' +
                    '                                                                                                <span style="font-size: 15px;padding-right: 10px;font-weight: 600;font-family: monospace;">€</span>\n' +
                    '                                                                                                <label style="margin: 0;" class="switch">\n' +
                    '                                                                                                    <input class="impact_type" type="checkbox">\n' +
                    '                                                                                                    <span class="slider round"></span>\n' +
                    '                                                                                                </label>\n' +
                    '                                                                                                <span style="font-size: 15px;padding-left: 10px;font-weight: 1000;font-family: revert;">%</span>\n' +
                    '\n' +
                    '                                                                                            </div>\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <div style="display: flex;align-items: center;height: 40px;justify-content: center;width: 100%;">\n' +
                    '\n' +
                    '                                                                                                <input type="hidden" name="variable1[]" id="variable" value="0">\n' +
                    '\n' +
                    '                                                                                                <span style="font-size: 13px;padding-right: 10px;font-weight: 600;font-family: monospace;">No</span>\n' +
                    '                                                                                                <label style="margin: 0;" class="switch">\n' +
                    '                                                                                                    <input class="variable" type="checkbox">\n' +
                    '                                                                                                    <span class="slider round"></span>\n' +
                    '                                                                                                </label>\n' +
                    '                                                                                                <span style="font-size: 13px;padding-left: 10px;font-weight: 600;font-family: monospace;">Yes</span>\n' +
                    '\n' +
                    '                                                                                            </div>\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                        <td>\n' +
                    '                                                                                            <div style="display: flex;justify-content: center;"><span class="ui-close remove-sub-feature" data-id="" style="margin:0;position: relative;left: 0;right: 0;top: 0;">X</span></div>\n' +
                    '                                                                                        </td>\n' +
                    '                                                                                    </tr></tbody></table>' +
                    '                                                                                        <div style="margin-top: 20px;" class="col-sm-12 text-center">\n' +
                    '                                                                                            <button data-id="1" class="btn btn-default featured-btn" type="button" id="add-sub-feature-btn"><i class="fa fa-plus"></i> Add More Sub Features</button>\n' +
                    '                                                                                        </div></div>');

                $(".js-data-example-ajax5").select2({
                    width: '100%',
                    height: '200px',
                    placeholder: "Select Feature Heading",
                    allowClear: true,
                });


            }

        });

    });

</script>

<style type="text/css">

    th:first-child,td:first-child
    {
        border-left: 1px solid #c5c5c5;
    }

    th
    {
        border-top: 1px solid #c5c5c5;
        border-bottom: 1px solid #c5c5c5;
    }

    td
    {
        border-bottom: 1px solid #c5c5c5;
    }

    th,td
    {
        padding: 10px;
        font-family: monospace;
        color: #4f4f4f;
        text-align: center;
        border-right: 1px solid #c5c5c5;
    }

    .container1 {
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        padding-left: 35px;
        margin-bottom: 0;
        cursor: pointer;
        font-size: 17px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default radio button */
    .container1 input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    /* Create a custom radio button */
    .checkmark {
        position: absolute;
        left: 0;
        height: 18px;
        width: 18px;
        background-color: #eee;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* On mouse-over, add a grey background color */
    .container1:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the radio button is checked, add a blue background */
    .container1 input:checked ~ .checkmark {
        background-color: #2196F3;
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after {
        content: "";
        position: relative;
        display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .container1 input:checked ~ .checkmark:after {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Style the indicator (dot/circle) */
    .container1 .checkmark:after {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: white;
    }

    .table.products > tbody > tr td
    {
        border-right: 1px solid #e3e3e3;
        text-align: center;
    }

    .table.products > tbody > tr td:first-child
    {
        border-left: 1px solid #e3e3e3;
    }

    .table.products > tbody > tr td:last-child
    {
        border-right: 1px solid #e3e3e3;
    }

    .product-configuration a[aria-expanded="false"]::before, a[aria-expanded="true"]::before
    {
        display: none;
    }

    .product-configuration a[aria-expanded="true"]::before
    {
        display: none;
    }

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
    width: 30%;

  }

  .swal2-header
  {
    font-size: 14px;
  }

  .swal2-content
  {
    font-size: 20px;
  }

  .swal2-actions
  {
    font-size: 12px;
  }

    .switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 20px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 13px;
        width: 13px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

</style>


@endsection
