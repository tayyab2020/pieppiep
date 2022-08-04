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
                                        <h2>Add Services Question</h2>
                                        <a href="{{route('services-quotation-questions')}}" class="btn add-back-btn"><i class="fa fa-arrow-left"></i>{{__('text.Back')}}</a>
                                    </div>
                                    <hr>
                                    <form class="form-horizontal" action="{{route('save-services-question')}}" method="POST" enctype="multipart/form-data">
                                        @include('includes.form-error')
                                        @include('includes.form-success')
                                        {{csrf_field()}}

                                        <input type="hidden" name="question_id" @if(isset($data)) value="{{$data->id}}" @endif>

                                        <div style="border-bottom: 1px solid rgba(233,233,233,0.33);padding: 15px 0px;margin-bottom: 20px;">

                                            <h2 style="text-align: center;">Services</h2>

                                            <div class="service_box" style="margin-bottom: 20px;">

                                                @if(isset($data))

                                                    @foreach($data->services as $service)

                                                        <div class="form-group">

                                                            <label class="control-label col-sm-4">Service* </label>

                                                            <div class="col-sm-6">

                                                                <select class="form-control validate js-data-example-ajax" name="services[]" required>

                                                                    <option value="">Select Service</option>

                                                                    @foreach($services as $key)

                                                                        <option @if($service->service_id == $key->id) selected @endif value="{{$key->id}}">{{$key->title}}</option>

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

                                                        <label class="control-label col-sm-4">Service* </label>

                                                        <div class="col-sm-6">

                                                            <select class="form-control validate js-data-example-ajax" name="services[]" required>

                                                                <option value="">Select Service</option>

                                                                @foreach($services as $key)

                                                                    <option value="{{$key->id}}">{{$key->title}}</option>

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
                                                    <button class="btn btn-default featured-btn" type="button" id="add-service-btn"><i class="fa fa-plus"></i> Add More Services</button>
                                                </div>
                                            </div>

                                        </div>


                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_display_name">Sequence No</label>
                                            <div class="col-sm-6">
                                                <input class="form-control validate" name="order_no" id="blood_group_display_name" placeholder="Enter Sequence No" @if(isset($data)) value="{{$data->order_no}}" @endif type="number">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_display_name">Question Title* <span>(In Any Language)</span></label>
                                            <div class="col-sm-6">
                                                <input class="form-control validate" name="title" id="blood_group_display_name" placeholder="Enter Question Title" required="" @if(isset($data)) value="{{$data->title}}" @endif type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_display_name">Placeholder</label>
                                            <div class="col-sm-6">
                                                <input class="form-control" name="placeholder" id="blood_group_display_name" placeholder="Enter Question Placeholder" @if(isset($data)) value="{{$data->placeholder}}" @endif type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="">Predefined Answers* </label>
                                            <div class="col-sm-3">
                                                <label class="switch">
                                                    <input @if(isset($data) && $data->predefined) checked @endif type="checkbox" name="predefined" id="predefined" onchange="Predefined()">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="sub-services s_box" id="q" @if(isset($data) && $data->predefined) style="display: block;"  @else style="display: none;" @endif>

                                            @if(isset($data) && $data->predefined)

                                                @foreach($data->answers as $x => $key)

                                                    <div class="form-group">

                                                        <label class="control-label col-sm-4">Text* </label>

                                                        <div class="col-sm-6">
                                                            <input type="text" value="{{$key->title}}" class="form-control predefined_answer" name="predefined_answer[]" id="predefined_answer">
                                                        </div>

                                                        <div class="col-xs-1 col-sm-1">
                                                            <span class="ui-close remove-ui1" style="margin:0;right:70%;">X</span>
                                                        </div>

                                                    </div>

                                                @endforeach


                                            @else

                                                <div class="form-group">

                                                    <label class="control-label col-sm-4">Text* </label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control predefined_answer" name="predefined_answer[]" id="predefined_answer">
                                                    </div>

                                                    <div class="col-xs-1 col-sm-1">
                                                        <span class="ui-close remove-ui1" style="margin:0;right:70%;">X</span>
                                                    </div>

                                                </div>

                                            @endif

                                        </div>

                                        <div class="form-group s_box" @if(isset($data) && $data->predefined) style="margin-top: 40px;display: block;" @else style="margin-top: 40px;display: none;" @endif>

                                            <label class="control-label col-sm-3" for=""></label>

                                            <div class="col-sm-12 text-center">

                                                <button class="btn btn-default featured-btn" type="button" name="add-field-btn" id="add-field-btn"><i class="fa fa-plus"></i> Add More Fields</button>
                                            </div>
                                        </div>


                                        <hr>
                                        <div class="add-product-footer">
                                            <button name="addProduct_btn" type="button" class="btn add-product_btn">Submit</button>
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

        $(document).ready(function() {

            var $selects = $('.js-data-example-ajax').change(function() {


                var id = this.value;
                var selector = this;

                if ($selects.find('option[value=' + id + ']:selected').length > 1) {
                    Swal.fire({
                        title: 'Oops...',
                        text: 'Service already selected!',

                    })
                    this.options[0].selected = true;

                    $(selector).val('');


                }

            });


        });

        $("#add-service-btn").on('click',function() {


            $(".service_box").append('<div class="form-group">\n' +
                '\n' +
                '                <label class="control-label col-sm-4">Service* </label>\n' +
                '\n' +
                '                <div class="col-sm-6">\n' +
                '                <select class="form-control validate js-data-example-ajax" name="services[]" required>\n' +
                '\n' +
                '            <option value="">Select Service</option>\n' +
                '\n' +
                '            @foreach($services as $key)\n' +
                '\n' +
                '            <option value="{{$key->id}}">{{$key->title}}</option>\n' +
                '\n' +
                '                @endforeach\n' +
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
                        text: 'Service already selected!',

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
                    '                <label class="control-label col-sm-4">Service* </label>\n' +
                    '\n' +
                    '                <div class="col-sm-6">\n' +
                    '                <select class="form-control validate js-data-example-ajax" name="services[]" required>\n' +
                    '\n' +
                    '            <option value="">Select Service</option>\n' +
                    '\n' +
                    '            @foreach($services as $key)\n' +
                    '\n' +
                    '            <option value="{{$key->id}}">{{$key->title}}</option>\n' +
                    '\n' +
                    '                @endforeach\n' +
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


        $("#add-field-btn").on('click',function() {


            $(".sub-services").append('<div class="form-group">'+
                '<label class="control-label col-sm-4">Text* </label>'+
                '<div class="col-sm-6">'+
                // '<input type="text" class="form-control" name="title[]" id="title" placeholder="'+title+'" required="">'+
                '<input type="text" class="form-control predefined_answer" name="predefined_answer[]" id="predefined_answer">'+
                '</div>'+
                '<div class="col-xs-1 col-sm-1">'+
                '<span class="ui-close remove-ui1" style="margin:0;right:70%;">X</span></div></div>');

        });

        $(document).on('click', '.add-product_btn' ,function() {

            var check = 0;

            if($('#predefined').is(":checked"))
            {
                $(".validate").each(function() {
                    var element = $(this);
                    if (element.val() == "") {
                        $(this).css('border','1px solid red');
                        check = 1;
                    }
                    else
                    {
                        $(this).css('border','');
                    }
                });

                $(".predefined_answer").each(function() {
                    var element = $(this);
                    if (element.val() == "") {
                        $(this).css('border','1px solid red');
                        check = 1;
                    }
                    else
                    {
                        $(this).css('border','');
                    }
                });

                if(!check)
                {
                    $('form').submit();
                }
            }
            else
            {
                $(".validate").each(function() {
                    var element = $(this);
                    if (element.val() == "") {
                        $(this).css('border','1px solid red');
                        check = 1;
                    }
                    else
                    {
                        $(this).css('border','');
                    }
                });

                if(!check)
                {
                    $('form').submit();
                }

            }

        });


        $(document).on('click', '.remove-ui1' ,function() {

            var parent = this.parentNode.parentNode;

            $(parent).hide();
            $(parent).remove();

            if($("#q .form-group").length == 0)
            {
                $(".sub-services").append('<div class="form-group">'+
                    '<label class="control-label col-sm-4">Text* </label>'+
                    '<div class="col-sm-6">'+
                    // '<input type="text" class="form-control" name="title[]" id="title" placeholder="'+title+'" required="">'+
                    '<input type="text" class="form-control predefined_answer" name="predefined_answer[]" id="predefined_answer">'+
                    '</div>'+
                    '<div class="col-xs-1 col-sm-1">'+
                    '<span class="ui-close remove-ui1" style="margin:0;right:70%;">X</span></div></div>');
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


    <script>
        $('#cp1').colorpicker();
        $('#cp2').colorpicker();
    </script>



    <script src="{{asset('assets/admin/js/jquery152.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/jqueryui.min.js')}}"></script>

@endsection
