@extends('layouts.handyman')

@section('styles')

    <link href="{{asset('assets/admin/css/jquery.tagit.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/admin/css/jquery-ui.css')}}" rel="stylesheet" type="text/css">



@endsection

@section('content')


    <div class="right-side">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- Starting of Dashboard header items area -->
                    <div class="panel panel-default admin">
                        <div class="panel-heading admin-title">{{$lang->cmpt}}</div>

                    </div>
                    <!-- Ending of Dashboard header items area -->

                    <!-- Starting of Dashboard Top reference + Most Used OS area -->
                    <div class="reference-OS-area">
                        <div class="donors-profile-top-bg overlay text-center wow fadeInUp" style="background-image: url({{asset('assets/images/'.$gs->h_dashbg)}}); visibility: visible; animation-name: fadeInUp;z-index: auto;color: black;">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2>{{$user->name}} {{$user->family_name}}</h2>
                                        <p>{{$lang->bg}} <?php $count = count($services); $i=1; ?>
                                            @foreach($services as $key)

                                                @if($i == $count)

                                                    {{$key->cat_name}}

                                                @else

                                                    {{$key->cat_name}},

                                                @endif

                                                <?php $i++; ?>

                                            @endforeach</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="profile-fillup-wrap wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form class="form-horizontal" action="{{route('user-complete-profile-update')}}" method="POST" enctype="multipart/form-data">
                                            @include('includes.form-success')
                                            @include('includes.form-error')
                                            {{csrf_field()}}

                                            <div class="profile-filup-description-box margin-bottom-30">


                                                <div class="form-group" >

                                                     <h2 class="text-center">{{$lang->cypt}}</h2>



<div class="col-xs-10 col-sm-5 col-md-offset-1" style="width: 100%;padding: 0;margin: 0;margin-top: 30px;">

<input type="text" name="email" placeholder="Email" readonly value="{{$user->email}}" style="width: 95%;display: block;margin: auto;text-align: center;cursor: not-allowed;" required>

<input type="hidden" name="full_name" value="{{$user->name}} {{$user->family_name}}">

 </div>







                                                                </div>



                                            </div>

                                            @if($user->featured == 0)

<span style="font-size: 22px;"><strong>{{$lang->cmpnt}}:</strong>&nbsp;&nbsp;{{$lang->cmpn}}</span>

<span style="font-size: 22px;display: block;margin-top: 20px;"><strong>{{$lang->rft}}:</strong>&nbsp;&nbsp;€ <?php echo str_replace('.', ',', number_format($gs->registration_fee,2)); ?></span>

<?php $without_vat = $gs->registration_fee/1.21;
$without_vat = number_format($without_vat,2)
?>

<span style="font-size: 22px;display: block;margin-top: 20px;"><strong>{{$lang->rft}} <small>{{$lang->rfevat}}</small>:</strong>&nbsp;&nbsp;€ <?php echo str_replace('.', ',', number_format($without_vat,2)); ?> </span>

<div class="submit-area margin-bottom-30" style="margin-top: 30px;">
                                                <div class="row">
                                                    <div class="col-md-8 col-md-offset-2">
                                                        <div class="form-group text-center">
                                                            <button class="boxed-btn blog" type="submit" style="font-size: 20px;">{{$lang->gtcp}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

@else

                                                @if($user->active == 0)

<div style="text-align: center;margin-top: 80px;"><span style="font-size: 24px;font-family: inherit;">{{$lang->cmpsm}}</span></div>

                                                    @else

<div style="text-align: center;margin-top: 80px;"><span style="font-size: 24px;font-family: inherit;">{{$lang->cmpsm1}}</span></div>

                                                    @endif

@endif



                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div></div></div></div></div>

    <script type="text/javascript">



        $(document).ready(function() {



            $(".js-data-example-ajax").select2({
                width: '100%',
                // placeholder: "City Name",
                placeholder: "<?php echo $lang->sbg; ?>",
                allowClear: true,
                "language": {
                    "noResults": function(){
                        return '{{__('text.No results found')}}';
                    }
                },


            });


            var $selects = $('.js-data-example-ajax').change(function() {
                var id = this.value;
                var selector = this;


                if ($selects.find('option[value=' + id + ']:selected').length > 1) {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'This Service is already selected!',

                    })
                    this.options[0].selected = true;

                    $(selector).val('');

                    $(selector).select2("destroy");

                    $(selector).select2();
                }






                $.ajax({
                    type:"GET",
                    data: "id=" + id ,
                    url: "<?php echo url('/aanbieder/services')?>",
                    success: function(data) {

                        $(selector).parent().parent().children('#rate').children("input").attr("placeholder", data);




                    }
                });




            });


        });



    </script>

    <style>

        .container
                {
                    width: 100% !important;
                }

        .select2-container{

            height: 100%;
        }

        .select2-container--default .select2-selection--single{

            height: 100%;
            padding: 7px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow{

            padding: 19px;
        }

        .select2-selection__clear{

            display: none;
        }

        .nicEdit-main
        {
            width: 100% !important;
            margin: 0 !important;
            background-color: white;
        }
    </style>

    <style>

        #complete{
            color: #fff;
            background: {{$gs->colors == null ? 'rgba(207, 55, 58, 0.70)':$gs->colors.'c2'}};

        }


    </style>

@endsection



@section('scripts')



    <script type="text/javascript" src="{{asset('assets/front/js/nicEdit.js')}}"></script>

    <script type="text/javascript">
        //<![CDATA[
        bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
        //]]>
    </script>

    <script type="text/javascript">



        // Handling the click event
        $("#add-field-btn").on('click',function() {
            var title = $('#tttl').val();
            var desc = $('#dddc').val();

            $(".qualification").append('<div class="qualification-area">'+
                '<div class="form-group">'+
                '<div class="col-xs-10 col-sm-5 col-md-offset-1" style="height: 40px;">'+
                '<input type="hidden" name="hs_id[]" value="0">' +
                // '<input type="text" class="form-control" name="title[]" id="title" placeholder="'+title+'" required="">'+
                '<select class="js-data-example-ajax" style="width: 100%" name="title[]" id="title" required>'+
                '<option value="">{{$lang->sbg}}</option>' +
                '@foreach($cats as $cat)' +
                '<option value="{{$cat->id}}" >{{$cat->cat_name}}</option>' +
                '@endforeach' +
                '</select>'+
                '</div>'+
                '<div class="col-xs-10 col-sm-5" id="rate">'+
                // '<select class="js-example-responsive" style="width: 100%" name="details[]" id="text_details" placeholder="'+desc+'" type="text" ></select>'+
                '<input type="text" class="form-control" name="details[]" id="text_details" placeholder="'+desc+'" required>'+
                '</div>'+
                '</div>'+
                '<span class="ui-close remove-ui1">X</span>'+
                '</div>');

            $(".js-data-example-ajax").select2({
                width: '100%',
                // placeholder: "City Name",
                placeholder: "<?php echo $lang->sbg; ?>",
                allowClear: true,
                "language": {
                    "noResults": function(){
                        return '{{__('text.No results found')}}';
                    }
                },

            }).on('change', function (e) {
// AT this section we have to load placeholder and use it to Next textfield
            });

            var $selects = $('.js-data-example-ajax').change(function() {


                var id = this.value;
                var selector = this;

                if ($selects.find('option[value=' + id + ']:selected').length > 1) {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'This Service is already selected!',

                    })
                    this.options[0].selected = true;

                    $(selector).val('');

                    $(selector).select2("destroy");

                    $(selector).select2();
                }



                $.ajax({
                    type:"GET",
                    data: "id=" + id ,
                    url: "<?php echo url('/aanbieder/services')?>",
                    success: function(data) {

                        $(selector).parent().parent().children('#rate').children("input").attr("placeholder", data);




                    }
                });

            });

        });

        function isEmpty(el){
            return !$.trim(el.html())
        }

        $(document).on('click', '.remove-ui' ,function() {


            var id = $(this).attr('id');

            var parent = this.parentNode;



            $.ajax({
                type:"GET",
                data: "id=" + id ,
                url: "<?php echo url('/aanbieder/delete-services')?>",
                success: function(data) {

                    $(parent).children().children().children('select').val('');


                    $(parent).children().children().children('select').select2("destroy");

                    $(parent).children().children().children('select').select2();


                    $(parent).hide();
                    $(parent).remove();


                    Swal.fire(
                        'Success!',
                        'Service deleted!',
                        'success'
                    )

                    if (isEmpty($('#q'))) {
                        var title = $('#tttl').val();
                        var desc = $('#dddc').val();
                        $(".qualification").append('<div class="qualification-area">'+
                            '<div class="form-group">'+
                            '<div class="col-xs-10 col-sm-5 col-md-offset-1" style="height: 40px;">'+
                            '<select class="js-data-example-ajax" style="width: 100%"name="title[]" id="title" required>'+
                            '<option value="">{{$lang->sbg}}</option>' +
                            '@foreach($cats as $cat)' +
                            '<option value="{{$cat->id}}" >{{$cat->cat_name}}</option>' +
                            '@endforeach' +
                            '</select>'+
                            // '<input type="text" class="form-control" name="title[]" id="title" placeholder="'+title+'">'+
                            '</div>'+
                            '<div class="col-xs-10 col-sm-5" id="rate">'+
                            '<input type="text" class="form-control" name="details[]" id="text_details" placeholder="'+desc+'" required>'+
                            // '<select class="js-example-responsive" style="width: 100%" name="details[]" id="text_details" placeholder="'+desc+'" type="text" ></select>'+
                            '</div>'+
                            '</div>'+
                            '<span class="ui-close remove-ui1">X</span>'+
                            '</div>');

                        $(".js-data-example-ajax").select2({
                            width: '100%',
                            // placeholder: "City Name",
                            placeholder: "<?php echo $lang->sbg; ?>",
                            allowClear: true,
                            "language": {
                                "noResults": function(){
                                    return '{{__('text.No results found')}}';
                                }
                            },

                        }).on('change', function (e) {
// AT this section we have to load placeholder and use it to Next textfield
                        });

                        $('.js-data-example-ajax').on('change', function() {
                            var id = this.value;
                            var selector = this;



                            $.ajax({
                                type:"GET",
                                data: "id=" + id ,
                                url: "<?php echo url('/aanbieder/services')?>",
                                success: function(data) {

                                    $(selector).parent().parent().children('#rate').children("input").attr("placeholder", data);




                                }
                            });

                        });
                    }



                }
            });


        });

        $(document).on('click', '.remove-ui1' ,function() {



            var parent = this.parentNode;

            $(parent).children().children().children('select').val('');


            $(parent).children().children().children('select').select2("destroy");

            $(parent).children().children().children('select').select2();

            $(parent).hide();
            $(parent).remove();


            if (isEmpty($('#q'))) {
                var title = $('#tttl').val();
                var desc = $('#dddc').val();
                $(".qualification").append('<div class="qualification-area">'+
                    '<div class="form-group">'+
                    '<div class="col-xs-10 col-sm-5 col-md-offset-1" style="height: 40px;">'+
                    '<select class="js-data-example-ajax" style="width: 100%"name="title[]" id="title" required>'+
                    '<option value="">{{$lang->sbg}}</option>' +
                    '@foreach($cats as $cat)' +
                    '<option value="{{$cat->id}}" >{{$cat->cat_name}}</option>' +
                    '@endforeach' +
                    '</select>'+
                    // '<input type="text" class="form-control" name="title[]" id="title" placeholder="'+title+'">'+
                    '</div>'+
                    '<div class="col-xs-10 col-sm-5" id="rate">'+
                    '<input type="text" class="form-control" name="details[]" id="text_details" placeholder="'+desc+'" required>'+
                    // '<select class="js-example-responsive" style="width: 100%" name="details[]" id="text_details" placeholder="'+desc+'" type="text" ></select>'+
                    '</div>'+
                    '</div>'+
                    '<span class="ui-close remove-ui1">X</span>'+
                    '</div>');

                $(".js-data-example-ajax").select2({
                    width: '100%',
                    // placeholder: "City Name",
                    placeholder: "<?php echo $lang->sbg; ?>",
                    allowClear: true,
                    "language": {
                        "noResults": function(){
                            return '{{__('text.No results found')}}';
                        }
                    },

                }).on('change', function (e) {
// AT this section we have to load placeholder and use it to Next textfield
                });

                $('.js-data-example-ajax').on('change', function() {
                    var id = this.value;
                    var selector = this;




                    $.ajax({
                        type:"GET",
                        data: "id=" + id ,
                        url: "<?php echo url('/aanbieder/services')?>",
                        success: function(data) {

                            $(selector).parent().parent().children('#rate').children("input").attr("placeholder", data);




                        }
                    });

                });
            }

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

    </script>


    <script src="{{asset('assets/admin/js/jqueryui.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/tag-it.js')}}" type="text/javascript" charset="utf-8"></script>



    <script type="text/javascript">
        $(document).ready(function() {
            $("#myTags").tagit({
                fieldName: "special[]",
                allowSpaces: true
            });
        });
    </script>


    <style>

        .swal2-show{
            font-size: 17px;
        }
    </style>


@endsection
