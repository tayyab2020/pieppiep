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
                                            </ul>

                                            <form id="product_form" style="padding: 0;" class="form-horizontal" action="{{route('admin-product-store')}}" method="POST" enctype="multipart/form-data">

                                                {{csrf_field()}}

                                                <input type="hidden" name="cat_id" value="{{isset($cats) ? $cats->id : null}}" />

                                                <div style="padding: 40px 15px 20px 15px;border: 1px solid #24232329;" class="tab-content">

                                                    <div id="menu1" class="tab-pane fade in active">


                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_display_name">Margin (%)*</label>
                                                            <div class="col-sm-6">
                                                                <input min="100" value="{{isset($cats) ? $cats->margin : null}}" class="form-control" name="margin" id="blood_group_display_name" placeholder="Enter Product margin" required step="1" type="number">
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

                                                        <div class="form-group">
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
                                                        </div>

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

                                                                    <div class="form-group" data-id="{{$i}}">

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

                                                                <div class="form-group" data-id="">

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

                                                                            <tr data-id="{{$i}}">
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

                                                            <div class="row" style="margin: 0;">

                                                                <div style="font-family: monospace;" class="col-sm-3">
                                                                    <h4>Heading</h4>
                                                                </div>

                                                                <div style="font-family: monospace;" class="col-sm-2">
                                                                    <h4>Feature</h4>
                                                                </div>

                                                                <div style="font-family: monospace;" class="col-sm-1">
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
                                                                </div>

                                                            </div>

                                                            <div class="row feature_box" style="margin: 15px 0;">

                                                                <input type="hidden" name="removed" id="removed_rows">

                                                                @if(isset($features_data) && count($features_data) > 0)

                                                                    @foreach($features_data as $f => $key)

                                                                        <div class="form-group" style="margin: 0 0 20px 0;">

                                                                            <div class="col-sm-3">

                                                                                <select class="form-control validate js-data-example-ajax5" name="feature_headings[]">

                                                                                    <option value="">Select Feature Heading</option>

                                                                                    @foreach($features_headings as $heading)

                                                                                        <option {{$heading->id == $key->heading_id ? 'selected' : null}} value="{{$heading->id}}">{{$heading->title}}</option>

                                                                                    @endforeach

                                                                                </select>

                                                                            </div>

                                                                            <div class="col-sm-2">

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
                                                                            </div>

                                                                        </div>

                                                                    @endforeach

                                                                @else

                                                                    <div class="form-group" style="margin: 0 0 20px 0;">

                                                                        <div class="col-sm-3">

                                                                            <select class="form-control validate js-data-example-ajax5" name="feature_headings[]">

                                                                                <option value="">Select Feature Heading</option>

                                                                                @foreach($features_headings as $feature)

                                                                                    <option value="{{$feature->id}}">{{$feature->title}}</option>

                                                                                @endforeach

                                                                            </select>

                                                                        </div>

                                                                        <div class="col-sm-2">

                                                                            <input class="form-control feature_title" name="features[]" id="blood_group_slug" placeholder="Feature Title" type="text">

                                                                        </div>

                                                                        <div class="col-sm-1">

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

                                                                        </div>


                                                                        <div class="col-xs-1 col-sm-1">
                                                                            <span class="ui-close remove-feature" data-id="" style="margin:0;right:70%;">X</span>
                                                                        </div>

                                                                    </div>

                                                                @endif

                                                            </div>

                                                        </div>

                                                        <div class="form-group add-color">
                                                            <label class="control-label col-sm-3" for=""></label>

                                                            <div class="col-sm-12 text-center">
                                                                <button class="btn btn-default featured-btn" type="button" id="add-feature-btn"><i class="fa fa-plus"></i> Add More Features</button>
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
@endsection

@section('scripts')

<script type="text/javascript">

    $(document).ready(function() {

        $(".add-product_btn").click(function () {

            var flag = 0;

            if(!$("input[name='margin']").val())
            {
                flag = 1;
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Margin should not be empty!',
                });
            }
            else if($("input[name='margin']").val() < 100)
            {
                flag = 1;
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Margin should not be smaller than 100!',
                });
            }
            else if(!$("input[name='title']").val())
            {
                flag = 1;
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Title should not be empty!',
                });
            }
            else if(!$("input[name='slug']").val())
            {
                flag = 1;
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Slug should not be empty!',
                });
            }
            else if(!$(".js-data-example-ajax").val())
            {
                flag = 1;
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Category should not be empty!',
                });
            }
            else if(!$(".js-data-example-ajax1").val())
            {
                flag = 1;
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Brand should not be empty!',
                });
            }
            else if(!$(".js-data-example-ajax2").val())
            {
                flag = 1;
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Model should not be empty!',
                });
            }
            else if(!$(".base_price").val())
            {
                flag = 1;
                Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Base price should not be empty!',
                });
            }

            if(!flag)
            {
                $('#product_form').submit();
            }

        });

        var row = 0;
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

        $(document).on('keypress', ".max_size", function(e){

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

        $(document).on('focusout', ".max_size", function(e){

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

        $(document).on('keypress', ".base_price", function(e){

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
            var code = $(selector).parent().prev('div').find('input').val();
            var color = $(selector).parent().prev('div').prev('div').find('input').val();
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
                            $("#example1").append('<tr data-id="'+row+'"><td>'+value.id+'</td><td>'+value.title+'</td><td class="color_col">'+color+'</td><td class="code_col">'+code+'</td><td><a href="/aanbieder/price-tables/prices/view/'+value.id+'">View</a></td></tr>');
                            $(selector).parent().parent().attr('data-id',row);
                            row++;
                        }

                    });

                }
            });
        });

        $("#add-color-btn").on('click',function() {


            $(".color_box").append('<div class="form-group" data-id="">\n' +
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

        $("#add-feature-btn").on('click',function() {


            $(".feature_box").append('<div class="form-group" style="margin: 0 0 20px 0;">\n' +
                '\n' +
                '<div class="col-sm-3">\n' +
                '\n' +
                '                                                                            <select class="form-control validate js-data-example-ajax5" name="feature_headings[]">\n' +
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
                '<div class="col-sm-2">\n' +
                '\n' +
                '                                                                        <input class="form-control feature_title" name="features[]" id="blood_group_slug" placeholder="Feature Title" type="text">\n' +
                '\n' +
                '                                                                    </div>\n' +
                '\n' +
                '                                                                    <div class="col-sm-1">\n' +
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
                '                                                                    </div>\n'+
                '\n' +
                '                </div>');



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

        $(".js-data-example-ajax2").select2({
            width: '100%',
            height: '200px',
            placeholder: "Select Model",
            allowClear: true,
        });


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

                    $('.js-data-example-ajax2').find('option')
                        .remove()
                        .end()
                        .append('<option value="">Select Model</option>'+options);

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
                $(".color_box").append('<div class="form-group" data-id="">\n' +
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

        $('body').on('click', '.remove-feature' ,function() {

            var id = $(this).data('id');

            if(id)
            {
                rem_arr.push(id);
                $('#removed_rows').val(rem_arr);
            }

            var parent = this.parentNode.parentNode;

            $(parent).hide();
            $(parent).remove();

            if($(".feature_box .form-group").length == 0)
            {
                $(".feature_box").append('<div class="form-group" style="margin: 0 0 20px 0;">\n' +
                    '\n' +
                    '<div class="col-sm-3">\n' +
                    '\n' +
                    '                                                                            <select class="form-control validate js-data-example-ajax5" name="feature_headings[]">\n' +
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
                    '<div class="col-sm-2">\n' +
                    '\n' +
                    '                                                                        <input class="form-control feature_title" name="features[]" id="blood_group_slug" placeholder="Feature Title" type="text">\n' +
                    '\n' +
                    '                                                                    </div>\n' +
                    '\n' +
                    '                                                                    <div class="col-sm-1">\n' +
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
                    '                                                                    </div>\n'+
                    '\n' +
                    '                </div>');


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
