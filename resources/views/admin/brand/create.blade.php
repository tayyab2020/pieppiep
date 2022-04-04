@extends('layouts.handyman')

@section('styles')

    <link href="{{asset('assets/admin/css/jquery-ui.css')}}" rel="stylesheet" type="text/css">

    <style type="text/css">
        .colorpicker-alpha {
            display: none !important;
        }

        .colorpicker {
            min-width: 128px !important;
        }

        .colorpicker-color {
            display: none !important;
        }
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
                                        <h2>{{isset($cats) ? 'Edit Brand' : 'Add Brand'}}</h2>
                                        <a href="{{route('admin-brand-index')}}" class="btn add-back-btn"><i
                                                class="fa fa-arrow-left"></i> Back</a>
                                    </div>
                                    <hr>
                                    <form class="form-horizontal" action="{{route('admin-brand-store')}}" method="POST"
                                          enctype="multipart/form-data">

                                        @include('includes.form-error')
                                        @include('includes.form-success')

                                        {{csrf_field()}}

                                        <input type="hidden" name="cat_id" value="{{isset($cats) ? $cats->id : null}}"/>

                                        <div style="margin: 0 0 50px 0;display: flex;justify-content: center;" class="row">

                                            <div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">

                                                <ul class="nav nav-tabs" role="tablist">
                                                    <li class="nav-item active">
                                                        <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">General Information</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Types</a>
                                                    </li>
                                                </ul><!-- Tab panes -->

                                                <div style="border: 1px solid #ddd;border-top: none;" class="tab-content">
                                                    <div style="padding: 30px 0;" class="tab-pane active" id="tabs-1" role="tabpanel">

                                                        @if(isset($brand_edit_request) && $brand_edit_request)

                                                            <div class="form-group">
                                                                <label class="control-label col-sm-4" for="blood_group_display_name"></label>
                                                                <div class="col-sm-6">
                                                                    <h3>Edit Request Details</h3>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="control-label col-sm-4" for="blood_group_display_name">Title</label>
                                                                <div class="col-sm-6">
                                                                    <input value="{{$brand_edit_request->cat_name}}"
                                                                           class="form-control" readonly
                                                                           id="blood_group_display_name" placeholder="Enter Brand title"
                                                                           type="text">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="control-label col-sm-4" for="blood_group_slug">Slug</label>
                                                                <div class="col-sm-6">
                                                                    <input value="{{$brand_edit_request->cat_slug}}"
                                                                           class="form-control" id="blood_group_slug" readonly
                                                                           placeholder="Enter Brand Slug" type="text">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="control-label col-sm-4" for="service_description">Brand Description</label>
                                                                <div class="col-sm-6">
                                                                    <div class="summernote">{!! $brand_edit_request->description !!}</div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="control-label col-sm-4" for="current_photo">Current Photo</label>
                                                                <div class="col-sm-6">
                                                                    <img width="130px" height="90px" id="adminimg1"
                                                                         src="{{$brand_edit_request->photo ? asset('assets/images/'.$brand_edit_request->photo):'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG'}}"
                                                                         alt="">
                                                                </div>
                                                            </div>

                                                            <hr style="margin-bottom: 40px;border-top: 1px solid #d6d6d6;">

                                                        @endif

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_display_name">Title*
                                                                <span>(In Any Language)</span></label>
                                                            <div class="col-sm-6">
                                                                <input value="{{isset($cats) ? $cats->cat_name : old('cat_name')}}"
                                                                       class="form-control" name="cat_name"
                                                                       id="blood_group_display_name" placeholder="Enter Brand title"
                                                                       required="" type="text">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="blood_group_slug">Slug* <span>(In English)</span></label>
                                                            <div class="col-sm-6">
                                                                <input value="{{isset($cats) ? $cats->cat_slug : old('cat_slug')}}"
                                                                       class="form-control" name="cat_slug" id="blood_group_slug"
                                                                       placeholder="Enter Brand Slug" required="" type="text">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="service_description">Brand Description</label>
                                                            <div class="col-sm-6">
                                                                <input type="hidden" value="{{isset($cats) ? $cats->description : old('description')}}" name="description">
                                                                <div class="summernote">{!! isset($cats) ? $cats->description : old('description') !!}</div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="current_photo">Current
                                                                Photo*</label>
                                                            <div class="col-sm-6">
                                                                <img width="130px" height="90px" id="adminimg"
                                                                     src="{{isset($cats->photo) ? asset('assets/images/'.$cats->photo):'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG'}}"
                                                                     alt="">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label col-sm-4" for="profile_photo">Add Photo</label>
                                                            <div class="col-sm-6">
                                                                <input type="file" id="uploadFile" class="hidden" name="photo" value="">
                                                                <button type="button" id="uploadTrigger" onclick="uploadclick()"
                                                                        class="form-control"><i class="fa fa-download"></i> Add Category
                                                                    Photo
                                                                </button>
                                                                <p>Prefered Size: (600x600) or Square Sized Image</p>
                                                            </div>
                                                        </div>

                                                        @if(!isset($cats) || ($user_id == $cats->user_id))

                                                            <div class="form-group">
                                                                <label class="control-label col-sm-4" for="website_title">Trademark *</label>

                                                                <div class="col-sm-6">
                                                                    <select class="form-control" name="trademark" required="">

                                                                        <option {{isset($cats) ? ($cats->trademark == 0 ? 'selected' : null) : null}} value="0">No</option>
                                                                        <option {{isset($cats) ? ($cats->trademark == 1 ? 'selected' : null) : null}} value="1">Yes</option>

                                                                    </select>
                                                                </div>
                                                            </div>

                                                        @else

                                                            <input type="hidden" name="trademark" value="{{$cats->trademark}}">

                                                        @endif

                                                    </div>

                                                    <div style="padding: 30px 0;" class="tab-pane" id="tabs-2" role="tabpanel">

                                                        @if(isset($type_edit_requests) && count($type_edit_requests) > 0)

                                                            <div class="form-group">
                                                                <label class="control-label col-sm-4" for="blood_group_display_name"></label>
                                                                <div class="col-sm-6">
                                                                    <h3>Edit Request Details</h3>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 20px;">

                                                                <div style="margin: 0;" class="row">

                                                                    <div class="col-sm-3">

                                                                        <h4>Title</h4>

                                                                    </div>

                                                                    <div class="col-sm-3">

                                                                        <h4>Slug</h4>

                                                                    </div>

                                                                    <div class="col-sm-5 type_description">

                                                                        <h4>Description</h4>

                                                                    </div>

                                                                    <div class="col-xs-1 col-sm-1">

                                                                    </div>

                                                                </div>

                                                                @foreach($type_edit_requests as $s => $temp)

                                                                    <div class="form-group">

                                                                        <div class="col-sm-3">

                                                                            <input readonly value="{{$temp->cat_name}}" class="form-control" id="blood_group_slug" placeholder="Type Title" type="text">

                                                                        </div>

                                                                        <div class="col-sm-3">

                                                                            <input readonly value="{{$temp->cat_slug}}" class="form-control" id="blood_group_slug" placeholder="Type Slug" type="text">

                                                                        </div>

                                                                        <div class="col-sm-5 type_description">

                                                                            <div class="summernote">{!! $temp->description !!}</div>

                                                                        </div>

                                                                        <div class="col-xs-1 col-sm-1">
                                                                        </div>

                                                                    </div>

                                                                @endforeach

                                                            </div>

                                                            <div style="margin-bottom: 40px;border-top: 1px solid #d6d6d6;width: 100%;display: inline-block;"></div>

                                                        @endif

                                                            @if(isset($types) && count($types) > 0)

                                                                <div class="form-group">
                                                                    <label class="control-label col-sm-4" for="blood_group_display_name"></label>
                                                                    <div class="col-sm-6">
                                                                        <h3>Original Details</h3>
                                                                    </div>
                                                                </div>

                                                                <div class="type_box col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 20px;">

                                                                    <div style="margin: 0;" class="row">

                                                                        <div class="col-sm-3">

                                                                            <h4>Title</h4>

                                                                        </div>

                                                                        <div class="col-sm-3">

                                                                            <h4>Slug</h4>

                                                                        </div>

                                                                        <div class="col-sm-5 type_description">

                                                                            <h4>Description</h4>

                                                                        </div>

                                                                        <div class="col-xs-1 col-sm-1">

                                                                        </div>

                                                                    </div>

                                                                    @foreach($types as $x => $key)

                                                                        <div class="form-group" data-id="{{$x+1}}">

                                                                            <input type="hidden" name="type_ids[]" value="{{$key->id}}">

                                                                            <div class="col-sm-3">

                                                                                <input value="{{$key->cat_name}}" class="form-control type_title" name="types[]" id="blood_group_slug" placeholder="Type Title" type="text">

                                                                            </div>

                                                                            <div class="col-sm-3">

                                                                                <input value="{{$key->cat_slug}}" class="form-control type_slug" name="type_slugs[]" id="blood_group_slug" placeholder="Type Slug" type="text">

                                                                            </div>

                                                                            <div class="col-sm-5 type_description">

                                                                                <input type="hidden" value="{{$key->description}}" name="type_descriptions[]">
                                                                                <div class="summernote">{!! $key->description !!}</div>

                                                                            </div>

                                                                            <div class="col-xs-1 col-sm-1">
                                                                                @if(!isset($cats) || ($user_id == $cats->user_id))
                                                                                    <span class="ui-close remove-type" data-id="" style="margin:0;right:70%;">X</span>
                                                                                @endif
                                                                            </div>

                                                                        </div>

                                                                    @endforeach

                                                                </div>

                                                                @if(!isset($cats) || ($user_id == $cats->user_id))

                                                                    <div class="form-group add-type">
                                                                        <label class="control-label col-sm-3" for=""></label>

                                                                        <div class="col-sm-12 text-center">
                                                                            <button class="btn btn-default featured-btn" type="button" id="add-type-btn"><i class="fa fa-plus"></i> Add More Types</button>
                                                                        </div>
                                                                    </div>

                                                                @endif

                                                            @elseif(!isset($cats) || ($user_id == $cats->user_id))

                                                                <div class="type_box col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 20px;">

                                                                    <div style="margin: 0;" class="row">

                                                                        <div class="col-sm-3">

                                                                            <h4>Title</h4>

                                                                        </div>

                                                                        <div class="col-sm-3">

                                                                            <h4>Slug</h4>

                                                                        </div>

                                                                        <div class="col-sm-5 type_description">

                                                                            <h4>Description</h4>

                                                                        </div>

                                                                        <div class="col-xs-1 col-sm-1">

                                                                        </div>

                                                                    </div>

                                                                    <div class="form-group" data-id="1">

                                                                        <input type="hidden" name="type_ids[]">

                                                                        <div class="col-sm-3">

                                                                            <input class="form-control type_title" name="types[]" id="blood_group_slug" placeholder="Type Title" type="text">

                                                                        </div>

                                                                        <div class="col-sm-3">

                                                                            <input class="form-control type_slug" name="type_slugs[]" id="blood_group_slug" placeholder="Type Slug" type="text">

                                                                        </div>

                                                                        <div class="col-sm-5 type_description">

                                                                            <input type="hidden" name="type_descriptions[]">
                                                                            <div class="summernote"></div>

                                                                        </div>

                                                                        <div class="col-xs-1 col-sm-1">
                                                                            <span class="ui-close remove-type" data-id="" style="margin:0;right:70%;">X</span>
                                                                        </div>

                                                                    </div>

                                                                </div>

                                                                <div class="form-group add-type">
                                                                    <label class="control-label col-sm-3" for=""></label>

                                                                    <div class="col-sm-12 text-center">
                                                                        <button class="btn btn-default featured-btn" type="button" id="add-type-btn"><i class="fa fa-plus"></i> Add More Types</button>
                                                                    </div>
                                                                </div>

                                                            @else

                                                                <h3 style="text-align: center;">The supplier of this brand has not linked any type with it.</h3>

                                                            @endif

                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                        <hr>

                                        <div class="add-product-footer">
                                            <button name="addProduct_btn" type="submit"
                                                    class="btn add-product_btn">{{isset($cats) ? 'Edit Brand' : 'Add Brand'}}</button>
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
                    onChange: function (contents, $editable) {
                        $(this).prev('input').val(contents);
                    }
                }
            });

            $("#add-type-btn").on('click', function () {

                var row = $('.type_box').find('.form-group').last().data('id');
                row = row + 1;

                $(".type_box").append('<div class="form-group" data-id="' + row + '"> <input type="hidden" name="type_ids[]">\n' +
                    '\n' +
                    '                                                                <div class="col-sm-3">\n' +
                    '\n' +
                    '                                                                    <input class="form-control type_title" name="types[]" id="blood_group_slug" placeholder="Type Title" type="text">\n' +
                    '\n' +
                    '                                                                </div>\n' +
                    '\n' +
                    '                                                                <div class="col-sm-3">\n' +
                    '\n' +
                    '                                                                    <input class="form-control type_slug" name="type_slugs[]" id="blood_group_slug" placeholder="Type Slug" type="text">\n' +
                    '\n' +
                    '                                                                </div>\n' +
                    '\n' +
                    '                                                                <div class="col-sm-5 type_description">\n' +
                    '\n' +
                    '                                                                    <input name="type_descriptions[]" type="hidden">\n' +
                    '                                                                    <div class="summernote"></div>\n' +
                    '\n' +
                    '                                                                </div>\n' +
                    '\n' +
                    '                                                                <div class="col-xs-1 col-sm-1">\n' +
                    '                                                                    <span class="ui-close remove-type" data-id="" style="margin:0;right:70%;">X</span>\n' +
                    '                                                                </div>\n' +
                    '\n' +
                    '                </div>');

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
                        onChange: function (contents, $editable) {
                            $(this).prev('input').val(contents);
                        }
                    }
                });

            });

            $('body').on('click', '.remove-type', function () {

                var parent = this.parentNode.parentNode;

                $(parent).hide();
                $(parent).remove();

                if ($(".type_box .form-group").length == 0) {
                    $(".type_box").append('<div class="form-group" data-id="1"> <input type="hidden" name="type_ids[]">\n' +
                        '\n' +
                        '                                                                <div class="col-sm-3">\n' +
                        '\n' +
                        '                                                                    <input class="form-control type_title" name="types[]" id="blood_group_slug" placeholder="Type Title" type="text">\n' +
                        '\n' +
                        '                                                                </div>\n' +
                        '\n' +
                        '                                                                <div class="col-sm-3">\n' +
                        '\n' +
                        '                                                                    <input class="form-control type_slug" name="type_slugs[]" id="blood_group_slug" placeholder="Type Slug" type="text">\n' +
                        '\n' +
                        '                                                                </div>\n' +
                        '\n' +
                        '                                                                <div class="col-sm-5 type_description">\n' +
                        '\n' +
                        '                                                                    <input name="type_descriptions[]" type="hidden">\n' +
                        '                                                                    <div class="summernote"></div>\n' +
                        '\n' +
                        '                                                                </div>\n' +
                        '\n' +
                        '                                                                <div class="col-xs-1 col-sm-1">\n' +
                        '                                                                    <span class="ui-close remove-type" data-id="" style="margin:0;right:70%;">X</span>\n' +
                        '                                                                </div>\n' +
                        '\n' +
                        '                </div>');

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
                            onChange: function (contents, $editable) {
                                $(this).prev('input').val(contents);
                            }
                        }
                    });

                }

            });

        });

        function uploadclick() {
            $("#uploadFile").click();
            $("#uploadFile").change(function (event) {
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

        .tab-content>.active
        {
            display: inline-block;
            width: 100%;
        }

        .nav-link::before
        {
            display: none !important;
        }

        .swal2-show {
            padding: 40px;
            width: 30%;

        }

        .swal2-header {
            font-size: 23px;
        }

        .swal2-content {
            font-size: 18px;
        }

        .swal2-actions {
            font-size: 16px;
        }

    </style>

@endsection
