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
                                        <h2>{{isset($feature) ? 'Edit Feature' : 'Add Feature'}}</h2>
                                        <a href="{{route('admin-feature-index')}}" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> Back</a>
                                    </div>
                                    <hr>
                                    <form class="form-horizontal" action="{{route('admin-feature-store')}}" method="POST" enctype="multipart/form-data">
                                        @include('includes.form-error')
                                        @include('includes.form-success')
                                        {{csrf_field()}}

                                        <input type="hidden" id="heading_id" name="heading_id" value="{{isset($feature) ? $feature->id : null}}">

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_display_name">Title* <span>(In Any Language)</span></label>
                                            <div class="col-sm-6">
                                                <input value="{{isset($feature) ? $feature->title : null}}" class="form-control" name="title" id="blood_group_display_name" placeholder="Enter Item Title" required="" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_display_name">PDF Order</label>
                                            <div class="col-sm-6">
                                                <select class="form-control" name="order_no" id="blood_group_display_name" required="">

                                                    <option {{isset($feature) ? ($feature->order_no == 0 ? 'selected' : null) : null}} value="0">1</option>
                                                    <option {{isset($feature) ? ($feature->order_no == 1 ? 'selected' : null) : null}} value="1">2</option>
                                                    <option {{isset($feature) ? ($feature->order_no == 2 ? 'selected' : null) : null}} value="2">3</option>
                                                    <option {{isset($feature) ? ($feature->order_no == 3 ? 'selected' : null) : null}} value="3">4</option>
                                                    <option {{isset($feature) ? ($feature->order_no == 4 ? 'selected' : null) : null}} value="4">5</option>
                                                    <option {{isset($feature) ? ($feature->order_no == 5 ? 'selected' : null) : null}} value="5">6</option>
                                                    <option {{isset($feature) ? ($feature->order_no == 6 ? 'selected' : null) : null}} value="6">7</option>

                                                </select>
                                            </div>
                                        </div>

                                        <hr>
                                        <div style="padding-top: 20px;" class="add-product-footer">
                                            <button type="submit" class="btn add-product_btn">{{isset($feature) ? 'Edit Feature' : 'Add Feature'}}</button>
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
@endsection

@section('scripts')

    <script type="text/javascript" src="{{asset('assets/admin/js/nicEdit.js')}}"></script>
    <script type="text/javascript">
        //<![CDATA[
        bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
        //]]>
    </script>

    <script type="text/javascript">

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
