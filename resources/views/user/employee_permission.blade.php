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
                    <div style="padding: 0;" class="section-padding add-product-1">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="add-product-box">
                                    <div class="add-product-header">
                                        <h2>Assign permissions to {{$user->name . ' ' . $user->family_name . ' (' . $user->email . ')'}}</h2>
                                        <a href="{{route('employees')}}" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> {{__('text.Back')}}</a>
                                    </div>

                                    <hr>

                                    <div style="display: inline-block;padding-top: 20px;">
                                        <button id="select-all" style="margin-left: 10px;border-radius: 0;outline: none !important;border: 0;" class="btn btn-success">{{__('text.Select all')}}</button>
                                        <input type="hidden" value="0" id="current-select">
                                    </div>

                                    <form class="form-horizontal" action="{{route('employee-permission-store')}}" method="POST" enctype="multipart/form-data">
                                        @include('includes.form-error')
                                        @include('includes.form-success')
                                        {{csrf_field()}}

                                        <input type="hidden" name="user_id" value="{{$user->id}}">

                                        <div class="service_box" style="margin-bottom: 20px;">

                                            @foreach($permissions as $i => $key)

                                                <div style="display:flex;align-items: center;margin: 10px 0;" class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                                    <input style="margin: 0;margin-right: 5px;width: 20px;height: 20px;" value="{{$key->id}}" type="checkbox" id="permission{{$i}}" name="permissions[]" @if($user->permissions->contains('id', $key->id)) checked @endif>
                                                    <label style="margin: 0;" for="permission{{$i}}">{{$key->name}}</label>
                                                </div>

                                            @endforeach

                                        </div>

                                        <hr>
                                        <div style="display: inline-block;width: 100%;padding-top: 20px;" class="add-product-footer">
                                            <button type="submit" class="btn add-product_btn">{{__('text.Submit')}}</button>
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

        $("#select-all").click(function(){

            if($('#current-select').val() == 1)
            {
                $('input:checkbox').prop('checked', false);
                $('#current-select').val(0);
            }
            else
            {
                $('input:checkbox').prop('checked', true);
                $('#current-select').val(1);
            }
        });

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
                '                <select class="form-control validate js-data-example-ajax" name="permissions[]">\n' +
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
                    '                <select class="form-control validate js-data-example-ajax" name="permissions[]">\n' +
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
