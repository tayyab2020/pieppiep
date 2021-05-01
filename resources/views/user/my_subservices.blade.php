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
                        <div class="panel-heading admin-title">{{$lang->msst}}</div>

                    </div>
                    <!-- Ending of Dashboard header items area -->

                    <!-- Starting of Dashboard Top reference + Most Used OS area -->
                    <div class="reference-OS-area">
                        <div class="donors-profile-top-bg overlay text-center wow fadeInUp" style="background-image: url({{asset('assets/images/'.$gs->h_dashbg)}}); visibility: visible; animation-name: fadeInUp;z-index: auto;color: black;">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2>{{$user->name}} {{$user->family_name}}</h2>
                                        <p>{{$lang->bg}}

                                            <?php for ($i=0; $i < sizeof($main_cats_selected); $i++) {

                                                if($i == 0)

                                                {

                                                  echo $main_cats_selected[$i]->cat_name;

                                          }

                                        else
                                        {

                                            echo ', '.$main_cats_selected[$i]->cat_name;

                                        }

                                    }
                                    ?>

                                    </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="profile-fillup-wrap wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
                            <div class="container" style="width: 100%;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <form class="form-horizontal" action="{{route('user-subservices-update',$user->id)}}" method="POST" enctype="multipart/form-data">
                                            @include('includes.form-success')
                                            @include('includes.form-error')
                                            {{csrf_field()}}


                                            <div class="profile-filup-description-box margin-bottom-30">

                                                @if($main_cats_selected->count() != 0)

                                                <h2 class="text-center">{{$lang->mssn}}</h2>

                                                @endif

                                                <div class="main_div" style="margin-top: 80px;">

                                                    <?php $i = 0; ?>


                                                    @if($main_cats_selected->count() != 0)

                                                        @foreach($main_cats_selected as $key)

                                                        <div class="qualification" id="q" style="display: inline-block;width: 100%;">

                                                                    <h2>{{$key->cat_name}}</h2>

                                                            <?php if(sizeof($sub_selected[$key->id]) != 0){

                                                                for($s=0; $s<sizeof($sub_selected[$key->id]); $s++){ if($sub_selected[$key->id][$s]->main_id == $key->id){  ?>

                                                            <div class="qualification-area" style="border: 1px solid #bebebe;display: inline-block;width: 100%;padding-left: 20px;margin-top:30px;padding-top: 20px;padding-bottom: 10px;">

                                                                <div class="form-group" style="float: left;width: 100%;">


                                                                    <div class="col-xs-12 col-sm-3 col-md-offset-0" style="height: 100px;">

                                                                        <span class="headings1">{{$lang->iservt}}</span>

                                                                        <input type="hidden" name="hs_id[]" value="{{$sub_selected[$key->id][$s]->h_id}}">
                                                                        <input type="hidden" name="main_id[]" value="{{$sub_selected[$key->id][$s]->main_id}}">

                                                                        <select class="js-data-example-ajax" data-value="<?php echo $i; ?>"  style="width: 100%" name="title[]" id="title" >
                                                                            <option value="">{{$lang->ssst}}</option>

                                                                            <?php for($x=0; $x<sizeof($sub_cats[$key->id]); $x++){

                                                                                if($sub_cats[$key->id][$x]->id == $sub_selected[$key->id][$s]->id){ ?>

                                                                            <option value="{{$sub_cats[$key->id][$x]->id}}" selected>{{$sub_cats[$key->id][$x]->cat_name}}</option>

                                                                            <?php }else{ ?>

                                                                            <option value="{{$sub_cats[$key->id][$x]->id}}">{{$sub_cats[$key->id][$x]->cat_name}}</option>

                                                                            <?php  }} ?>

                                                                        </select>

                                                                    </div>


                                                                    <div class="col-xs-6 col-sm-2" id="rate" style="height: 100px;">

                                                                        <span class="headings1">{{$lang->sr}}</span>

                                                                        <input class="form-control" name="details[]" id="text_details" placeholder="{{$lang->esrt}}" type="number" value="{{$sub_selected[$key->id][$s]->rate}}" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required style="height: 59%;text-align: center;padding: 0;">

                                                                    </div>

                                                                    <div class="col-xs-6 col-sm-2" id="vat" style="height: 100px;">

                                                                        <span class="headings1">VAT <small>(%)</small></span>

                                                                        <input class="form-control" name="vat_percentages[]" id="vat_percentages" placeholder="VAT" type="number" value="{{$sub_selected[$key->id][$s]->vat_percentage}}" readonly required style="text-align: center;height: 59%;padding: 0;">

                                                                    </div>

                                                                    <div class="col-xs-6 col-sm-2" id="sell_rate" style="height: 100px;">

                                                                        <span class="headings1">Selling Rate</span>

                                                                        <input class="form-control" name="sell_rates[]" id="sell_rates" placeholder="Selling Rate" type="number" value="{{$sub_selected[$key->id][$s]->sell_rate}}" readonly required style="text-align: center;height: 59%;padding: 0;">

                                                                    </div>

                                                                    <div class="col-xs-6 col-sm-3" id="service_type" style="height: 100px;">

                                                                        <span class="headings1">{{$lang->istt}}</span>

                                                                        <?php

                                                                        if($sub_selected[$key->id][$s]->type == "Per Hour Rate")
                                                                        {
                                                                            $type = $lang->servT1;
                                                                        }

                                                                        elseif($sub_selected[$key->id][$s]->type == "Per Meter Rate")
                                                                            {
                                                                                $type = $lang->servT2;
                                                                            }

                                                                        elseif($sub_selected[$key->id][$s]->type == "Per Foot Rate")
                                                                        {
                                                                            $type = $lang->servT3;
                                                                        }

                                                                        elseif($sub_selected[$key->id][$s]->type == "Per Piece Rate")
                                                                        {
                                                                            $type = $lang->servT4;
                                                                        }

                                                                        else
                                                                            {
                                                                                $type = "";
                                                                            }


                                                                        ?>

                                                                        <p class="form-control" style="text-align: center;padding-top: 18px;height: 59%;">{{$type}}

                                                                        </p>

                                                                    </div>

                                                                    <div class="col-xs-12 col-sm-12" id="description" style="margin-top: 20px;">

                                                                        <span class="headings1">{{$lang->dt}}</span>

                                                                        <textarea class="form-control" name="description[]" placeholder="{{$lang->sdesc}}" cols="2" rows="4" style="resize: vertical;height: 59%;">{{$sub_selected[$key->id][$s]->description}}</textarea>

                                                                    </div>

                                                                </div>

                                                                <span class="ui-close remove-ui" id="{{$sub_selected[$key->id][$s]->h_id}}" style="top: -10px;float: left;position: relative;">X</span>

                                                            </div>


                                                            <?php }}}else{ ?>


                                                            <div class="qualification-area" style="border: 1px solid #bebebe;display: inline-block;width: 100%;padding-left: 20px;margin-top:30px;padding-top: 20px;padding-bottom: 10px;">

                                                                <div class="form-group" style="float: left;width: 100%;">

                                                                    <div class="col-xs-12 col-sm-3 col-md-offset-0" style="height: 100px;">

                                                                        <span class="headings1">{{$lang->iservt}}</span>

                                                                        <input type="hidden" name="main_id[]" value="{{$key->id}}">
                                                                        <input type="hidden" name="hs_id[]" value="0">



                                                                        <select class="js-data-example-ajax" data-value="<?php echo $i; ?>"  style="width: 100%" name="title[]" id="title" >

                                                                            <option value="">{{$lang->ssst}}</option>

                                                                            <?php for($x=0; $x<sizeof($sub_cats[$key->id]); $x++){  ?>

                                                                            <option value="{{$sub_cats[$key->id][$x]->id}}" >{{$sub_cats[$key->id][$x]->cat_name}}</option>

                                                                            <?php  } ?>

                                                                        </select>

                                                                    </div>


                                                                    <div class="col-xs-6 col-sm-2" id="rate" style="height: 100px;">

                                                                        <span class="headings1">{{$lang->sr}}</span>

                                                                        <input class="form-control" name="details[]" id="text_details" placeholder="{{$lang->esrt}}" type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required style="height: 59%;text-align: center;padding: 0;">

                                                                    </div>

                                                                    <div class="col-xs-6 col-sm-2" id="vat" style="height: 100px;">

                                                                        <span class="headings1">VAT <small>(%)</small></span>

                                                                        <input class="form-control" name="vat_percentages[]" id="vat_percentages" placeholder="VAT" type="number" readonly required style="text-align: center;height: 59%;padding: 0;">

                                                                    </div>

                                                                    <div class="col-xs-6 col-sm-2" id="sell_rate" style="height: 100px;">

                                                                        <span class="headings1">Selling Rate</span>

                                                                        <input class="form-control" name="sell_rates[]" id="sell_rates" placeholder="Selling Rate" type="number" readonly required style="text-align: center;height: 59%;padding: 0;">

                                                                    </div>


                                                                    <div class="col-xs-6 col-sm-3" id="service_type" style="height: 100px;">

                                                                        <span class="headings1">{{$lang->istt}}</span>

                                                                        <p class="form-control" style="text-align: center;padding-top: 18px;height: 59%;">

                                                                        </p>

                                                                    </div>


                                                                    <div class="col-xs-12 col-sm-12" id="description" style="margin-top: 20px;">

                                                                        <span class="headings1">{{$lang->dt}}</span>

                                                                        <textarea class="form-control" name="description[]" placeholder="{{$lang->sdesc}}" cols="2" rows="4" style="resize: vertical;height: 59%;"></textarea>

                                                                    </div>

                                                                </div>

                                                                <span class="ui-close remove-ui1" id="parentclose" style="top: -10px;float: left;position: relative;">X</span>

                                                            </div>

                                                            <?php } ?>

                                                        </div>


                                                <div class="form-group" style="margin-top: 30px;margin-bottom: 50px;">
                                                    <label class="control-label col-sm-3" for=""></label>
                                                    <div class="col-sm-12 text-center">

                                                        <button class="btn btn-default featured-btn add-field-btn" type="button" name="add-field-btn" data-id="{{$key->id}}" data-key="{{$i}}" id="add-field-btn"><i class="fa fa-plus"></i> {{$lang->amsst}}</button>
                                                    </div>
                                                </div>

                                                <?php $i++; ?>



                                                        @endforeach




                                                    @else

                                                        <h1 style="margin: 80px;text-align: center;">{{$lang->mssn1}}</h1>

                                                    @endif

                                                </div>


                                            </div>

                                            @if($main_cats_selected->count() != 0)

                                            <div class="submit-area margin-bottom-30" style="margin-top: 80px;">
                                                <div class="row">
                                                    <div class="col-md-8 col-md-offset-2">
                                                        <div class="form-group text-center">
                                                            <button class="boxed-btn blog" type="submit">{{$lang->doupl}}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

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
                placeholder: "<?php echo $lang->ssst; ?>",
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
                var value = $(this).attr('data-value');

                $selects = $('[data-value='+value+']');


                if ($selects.find('option[value=' + id + ']:selected').length > 1) {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: <?php echo "'".$lang->sse."'" ?>,

                    })
                    this.options[0].selected = true;

                    $(selector).val('');

                    $(selector).select2("destroy");

                    $(selector).select2();
                }



                $.ajax({
                    type:"GET",
                    data: "id=" + id ,
                    url: "<?php echo url('/services')?>",
                    success: function(data) {

                        if(data.type == "Per Hour Rate"){

                            var type = <?php echo "'".$lang->servT1."'" ?>;
                            var text = <?php echo "'".$lang->servP1."'" ?>;

                        }

                        else if(data.type == "Per Meter Rate")
                            {

                                var type = <?php echo "'".$lang->servT2."'" ?>;
                                var text = <?php echo "'".$lang->servP2."'" ?>;
                            }

                        else if(data.type == "Per Foot Rate")
                        {
                            var type = <?php echo "'".$lang->servT3."'" ?>;
                            var text = <?php echo "'".$lang->servP3."'" ?>;

                        }

                        else if(data.type == "Per Piece Rate")
                        {
                            var type = <?php echo "'".$lang->servT4."'" ?>;
                            var text = <?php echo "'".$lang->servP4."'" ?>;

                        }

                        else
                        {

                            var type = "";
                            var text = "";

                        }

                        $(selector).parent().parent().children('#rate').children("input").attr("placeholder", text);
                        $(selector).parent().parent().children('#service_type').children("p").text(type);
                        $(selector).parent().parent().children('#vat').children("input").val(data.vat_percentage);

                        var rate = $(selector).parent().parent().children('#rate').children("input").val();
                        rate = parseInt(rate);

                        if(rate)
                        {
                            var vat_percentage = data.vat_percentage;
                            vat_percentage = vat_percentage/100;

                            var sell_rate = rate * (vat_percentage);
                            sell_rate = parseFloat(sell_rate.toFixed(2));
                            sell_rate = rate + sell_rate;

                            $(selector).parent().parent().children('#sell_rate').children("input").val(sell_rate);
                        }

                    }
                });

            });

            $("input[name='details[]'").on('input',function(e) {

                var rate = parseInt($(this).val());
                var vat_percentage = parseInt($(this).parent().parent().children('#vat').children("input").val());
                vat_percentage = vat_percentage/100;

                if(vat_percentage)
                {
                    var sell_rate = rate * (vat_percentage);
                    sell_rate = parseFloat(sell_rate.toFixed(2));
                    sell_rate = rate + sell_rate;

                    $(this).parent().parent().children('#sell_rate').children("input").val(sell_rate);
                }

            });

             // Handling the click event
        $(".add-field-btn").on('click',function() {

            var main_id = $(this).attr('data-id');
            var key = $(this).attr('data-key');
            var options = "";

            var parent = this.parentNode.parentNode.previousElementSibling;


            $.ajax({
                    type:"GET",
                    data: "id=" + main_id ,
                    url: "<?php echo url('/get-id')?>",
                    success: function(data) {

                        $.each(data, function(index, value) {


                    var opt = '<option value="'+value.id+'" >'+value.cat_name+'</option>';

                    options = options + opt;

                        });


                        $(parent).append('<div class="qualification-area" style="border: 1px solid #bebebe;display: inline-block;width: 100%;padding-left: 20px;margin-top:30px;padding-top: 20px;padding-bottom: 10px;">'+
                            '<div class="form-group" style="float: left;width: 100%;">'+
                            '<div class="col-xs-12 col-sm-3 col-md-offset-0" style="height: 100px;">'+
                            '<span class="headings1">{{$lang->iservt}}</span>'+
                            '<input type="hidden" name="hs_id[]" value="0">'+
                            '<input type="hidden" name="main_id[]" value="'+main_id+'">'+
                            '<select class="js-data-example-ajax" data-value="'+key+'"  style="width: 100%" name="title[]" id="title" required>'+
                            '<option value=""><?php echo $lang->ssst; ?></option>'+options+'</select>'+
                            '</div>'+
                            '<div class="col-xs-6 col-sm-2" id="rate" style="height: 100px;">'+
                            '<span class="headings1">{{$lang->sr}}</span>'+
                            '<input class="form-control" name="details[]" id="text_details" placeholder="{{$lang->esrt}}" type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" required style="height: 59%;text-align: center;padding:0;"></div>'+
                            '<div class="col-xs-6 col-sm-2" id="vat" style="height: 100px;">'+
                            '<span class="headings1">VAT <small>(%)</small></span>'+
                            '<input class="form-control" name="vat_percentages[]" id="vat_percentages" placeholder="VAT" type="number" readonly required style="text-align: center;height: 59%;padding: 0;">'+
                            '</div>'+
                            '<div class="col-xs-6 col-sm-2" id="sell_rate" style="height: 100px;">'+
                            '<span class="headings1">Selling Rate</span>'+
                            '<input class="form-control" name="sell_rates[]" id="sell_rates" placeholder="Selling Rate" type="number" readonly required style="text-align: center;height: 59%;padding: 0;">'+
                            '</div>'+
                            '<div class="col-xs-6 col-sm-3" id="service_type" style="height: 100px;">'+
                            '<span class="headings1">{{$lang->istt}}</span>'+
                            '<p class="form-control" style="text-align: center;padding-top: 18px;height: 59%;"></p></div>'+
                            '<div class="col-xs-12 col-sm-12" id="description" style="margin-top: 20px;">'+
                            '<span class="headings1">{{$lang->dt}}</span>'+
                            '<textarea class="form-control" name="description[]" placeholder="{{$lang->sdesc}}"  cols="2" rows="4" style="resize: vertical;height:59%;"></textarea></div></div>'+
                            '<span class="ui-close remove-ui1" id="parentclose" style="top: -10px;float: left;position: relative;">X</span></div>');

            $(".js-data-example-ajax").select2({
                width: '100%',
                // placeholder: "City Name",
                placeholder: "<?php echo $lang->ssst; ?>",
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
                var value = $(this).attr('data-value');

 $selects = $('[data-value='+value+']');


                if ($selects.find('option[value=' + id + ']:selected').length > 1) {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: <?php echo "'".$lang->sse."'" ?>,

                    })
                    this.options[0].selected = true;

                    $(selector).val('');

                    $(selector).select2("destroy");

                    $(selector).select2();
                }



                $.ajax({
                    type:"GET",
                    data: "id=" + id ,
                    url: "<?php echo url('/services')?>",
                    success: function(data) {

                        if(data.type == "Per Hour Rate"){

                            var type = <?php echo "'".$lang->servT1."'" ?>;
                            var text = <?php echo "'".$lang->servP1."'" ?>;

                        }

                        else if(data.type == "Per Meter Rate")
                            {

                                var type = <?php echo "'".$lang->servT2."'" ?>;
                                var text = <?php echo "'".$lang->servP2."'" ?>;
                            }

                        else if(data.type == "Per Foot Rate")
                        {
                            var type = <?php echo "'".$lang->servT3."'" ?>;
                            var text = <?php echo "'".$lang->servP3."'" ?>;

                        }

                        else if(data.type == "Per Piece Rate")
                        {
                            var type = <?php echo "'".$lang->servT4."'" ?>;
                            var text = <?php echo "'".$lang->servP4."'" ?>;

                        }

                        else
                        {

                            var type = "";
                            var text = "";

                        }

                        $(selector).parent().parent().children('#rate').children("input").attr("placeholder", text);
                        $(selector).parent().parent().children('#service_type').children("p").text(type);




                    }
                });

            });

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


         });



        $(document).on('click', '.remove-ui' ,function() {


            var id = $(this).attr('id');
            var node = this;



            var parent = this.parentNode;



            $.ajax({
                type:"GET",
                data: "id=" + id ,
                url: "<?php echo url('/aanbieder/delete-services')?>",
                success: function(data) {

                    $(parent).children().children().children('select').val('');


                    $(parent).children().children().children('select').select2("destroy");

                    $(parent).children().children().children('select').select2();



                    $(node).hide();
                    $(node).remove();
                    $(parent).children('div').hide();
                    $(parent).children('div').remove();



                    Swal.fire(
                        'Success!',
                        <?php echo "'".$lang->sdt."'"; ?>,
                        'success'
                    )





                }
            });


        });


        });



    </script>

    <style>

        .headings1{

            text-align: center;display: block;font-size: 15px;font-weight: 600;margin-bottom: 10px;
        }

        .ui-close
        {
            width: 25px;
            height: 25px;
            line-height: 26px;
            font-size: 14px;
            right: 0%;
        }

        @media (max-width: 1024px){
            .headings1{
                font-size: 14px;
            }
        }

        @media (max-width: 767px)
        {
            .col-xs-6{

                margin-top: 20px;

            }
        }

        @media (max-width: 400px){

            .col-xs-5{
                width: 91.66666667%;
            }

            .col-xs-6{
                width: 100%;
            }
        }

        .select2-container--default .select2-selection--single{

            height: 100%;
            padding: 14px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow{

            padding: 27px;
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

        .container
                {
                    width: 100% !important;
                }
    </style>

    <style>

        #sub-services{
            color: #fff;
            background: {{$gs->colors == null ? 'rgba(207, 55, 58, 0.70)':$gs->colors.'c2'}};

        }


    </style>

@endsection



@section('scripts')




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
