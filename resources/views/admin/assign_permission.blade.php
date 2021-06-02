@extends('layouts.admin')

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
                                        <h2>Assign permissions to {{$user->name . ' ' . $user->family_name . ' (' . $user->email . ')'}}</h2>
                                        <a href="{{route('admin-assign-permissions')}}" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> Back</a>
                                    </div>
                                    <hr>
                                    <form class="form-horizontal" action="{{route('admin-assign-permission-store')}}" method="POST" enctype="multipart/form-data">
                                        @include('includes.form-error')
                                        @include('includes.form-success')
                                        {{csrf_field()}}

                                        <input type="hidden" name="user_id" value="{{$user->id}}">


                                        <div class="service_box" style="margin-bottom: 20px;">

                                            @if(count($user->permissions) > 0)

                                                @foreach($user->permissions as $permission)

                                                    <div class="form-group">

                                                        <label class="control-label col-sm-4">Permission* </label>

                                                        <div class="col-sm-6">

                                                            <select class="form-control validate js-data-example-ajax" name="permissions[]" required>

                                                                <option value="">Select Permission</option>

                                                                @foreach($permissions as $key)

                                                                    <option @if($permission->id == $key->id) selected @endif value="{{$key->id}}">{{$key->name}}</option>

                                                                @endforeach

                                                            </select>

                                                        </div>

                                                        <div class="col-xs-1 col-sm-1">
                                                            <span class="ui-close remove-service" style="margin:0;right:70%;">X</span>
                                                        </div>

                                                    </div>

                                                @endforeach

                                            @else

                                                <div class="form-group">

                                                    <label class="control-label col-sm-4">Permission* </label>

                                                    <div class="col-sm-6">

                                                        <select class="form-control validate js-data-example-ajax" name="permissions[]" required>

                                                            <option value="">Select Permission</option>

                                                            @foreach($permissions as $key)

                                                                <option value="{{$key->id}}">{{$key->name}}</option>

                                                            @endforeach

                                                        </select>

                                                    </div>

                                                    <div class="col-xs-1 col-sm-1">
                                                        <span class="ui-close remove-service" style="margin:0;right:70%;">X</span>
                                                    </div>

                                                </div>

                                            @endif

                                        </div>

                                        <div class="form-group add-service">
                                            <label class="control-label col-sm-3" for=""></label>

                                            <div class="col-sm-12 text-center">
                                                <button class="btn btn-default featured-btn" type="button" id="add-service-btn"><i class="fa fa-plus"></i> Add More Permissions</button>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="add-product-footer">
                                            <button name="addProduct_btn" type="submit" class="btn add-product_btn">Submit</button>
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

        $(document).ready(function() {

            var $selects = $('.js-data-example-ajax').change(function() {


                var id = this.value;
                var selector = this;

                if ($selects.find('option[value=' + id + ']:selected').length > 1) {
                    Swal.fire({
                        title: 'Oops...',
                        text: 'Permission already selected!',

                    })
                    this.options[0].selected = true;

                    $(selector).val('');


                }

            });


        });

        $("#add-service-btn").on('click',function() {


            $(".service_box").append('<div class="form-group">\n' +
                '\n' +
                '                <label class="control-label col-sm-4">Permission* </label>\n' +
                '\n' +
                '                <div class="col-sm-6">\n' +
                '                <select class="form-control validate js-data-example-ajax" name="permissions[]" required>\n' +
                '\n' +
                '            <option value="">Select Permission</option>\n' +
                '\n' +
                '            @foreach($permissions as $key)\n' +
                '\n' +
                '            <option value="{{$key->id}}">{{$key->name}}</option>\n' +
                '\n' +
                '            @endforeach\n' +
                '\n' +
                '                </select>\n' +
                '                </div>\n' +
                '\n' +
                '                <div class="col-xs-1 col-sm-1">\n' +
                '                <span class="ui-close remove-service" style="margin:0;right:70%;">X</span>\n' +
                '                </div>\n' +
                '\n' +
                '                </div>');

            var $selects = $('.js-data-example-ajax').change(function() {


                var id = this.value;
                var selector = this;

                if ($selects.find('option[value=' + id + ']:selected').length > 1) {
                    Swal.fire({
                        title: 'Oops...',
                        text: 'Permission already selected!',

                    })
                    this.options[0].selected = true;

                    $(selector).val('');


                }

            });

        });

        $(document).on('click', '.remove-service' ,function() {

            var parent = this.parentNode.parentNode;

            $(parent).hide();
            $(parent).remove();

            if($(".service_box .form-group").length == 0)
            {
                $(".service_box").append('<div class="form-group">\n' +
                    '\n' +
                    '                <label class="control-label col-sm-4">Permission* </label>\n' +
                    '\n' +
                    '                <div class="col-sm-6">\n' +
                    '                <select class="form-control validate js-data-example-ajax" name="permissions[]" required>\n' +
                    '\n' +
                    '            <option value="">Select Permission</option>\n' +
                    '\n' +
                    '            @foreach($permissions as $key)\n' +
                    '\n' +
                    '            <option value="{{$key->id}}">{{$key->name}}</option>\n' +
                    '\n' +
                    '            @endforeach\n' +
                    '\n' +
                    '                </select>\n' +
                    '                </div>\n' +
                    '\n' +
                    '                <div class="col-xs-1 col-sm-1">\n' +
                    '                <span class="ui-close remove-service" style="margin:0;right:70%;">X</span>\n' +
                    '                </div>\n' +
                    '\n' +
                    '                </div>');


            }



        });

        function Predefined()
        {

            if($('#predefined').is(":checked"))
            {

                $('.s_box').show();

            }
            else
            {

                $('.s_box').hide();

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



    <script src="{{asset('assets/admin/js/jquery152.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/jqueryui.min.js')}}"></script>

@endsection
