@extends('layouts.handyman')

@section('content')

    <div class="right-side">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- Starting of Dashboard data-table area -->
                    <div class="section-padding add-product-1" style="padding: 0;">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div style="box-shadow: none;" class="add-product-box">
                                    <div class="add-product-header products">
                                        <h2>{{__('text.Create Quotation')}}</h2>

                                    </div>
                                    <hr>
                                    <div>
                                        @include('includes.form-success')

                                        <form style="padding: 0;" class="form-horizontal" action="{{route('store-quotation')}}" method="POST" enctype="multipart/form-data">
                                            {{csrf_field()}}

                                            <div style="margin: 0;background: #f5f5f5;" class="row">

                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 first-row">

                                                    <div>
                                                        <span class="tooltip1 add-row" style="margin-right: 10px;">
                                                            <i class="fa fa-fw fa-plus-circle"></i>
                                                            <span class="tooltiptext">Add</span>
                                                        </span>

                                                        <span class="tooltip1 remove-row" style="cursor: pointer;font-size: 20px;margin-right: 10px;">
                                                            <i class="fa fa-fw fa-minus-circle"></i>
                                                            <span class="tooltiptext">Remove</span>
                                                        </span>

                                                        <span class="tooltip1 copy-row" style="cursor: pointer;font-size: 20px;">
                                                            <i class="fa fa-fw fa-copy"></i>
                                                            <span class="tooltiptext">Copy</span>
                                                        </span>
                                                    </div>

                                                    <div>
                                                        <span class="tooltip1" style="cursor: pointer;font-size: 20px;margin-right: 10px;">
                                                            <i class="fa fa-fw fa-save"></i>
                                                            <span class="tooltiptext">Save</span>
                                                        </span>

                                                        <span class="tooltip1" style="cursor: pointer;font-size: 20px;margin-right: 10px;">
                                                            <i class="fa fa-fw fa-close"></i>
                                                            <span class="tooltiptext">Close</span>
                                                        </span>
                                                    </div>

                                                </div>

                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 second-row" style="margin-bottom: 10px;">

                                                    <table id="products_table" style="width: 100%;">
                                                        <thead>
                                                        <tr>
                                                            <th style="padding: 5px;"></th>
                                                            <th>Product</th>
                                                            <th>Items</th>
                                                            <th>Color</th>
                                                            <th>Width</th>
                                                            <th>Height</th>
                                                            <th>Required</th>
                                                            <th>€ Art.</th>
                                                            <th>€ Arb.</th>
                                                            <th>€ Total</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>

                                                        <tr class="active" data-id="1">
                                                            <td>1</td>
                                                            <input type="hidden" id="row_total" name="total[]">
                                                            <td class="products">
                                                                <select class="js-data-example-ajax">

                                                                    <option value=""></option>

                                                                    @foreach($products as $key)

                                                                        <option value="{{$key->id}}">{{$key->title}}</option>

                                                                    @endforeach

                                                                </select>
                                                            </td>
                                                            <td class="items">
                                                                <select class="js-data-example-ajax1">

                                                                    <option value=""></option>

                                                                    @foreach($items as $key)

                                                                        <option value="{{$key->id}}">{{$key->cat_name}}</option>

                                                                    @endforeach

                                                                </select>
                                                            </td>
                                                            <td class="color">
                                                                <select class="js-data-example-ajax2">

                                                                    <option value=""></option>

                                                                </select>
                                                            </td>
                                                            <td class="width" style="width: 80px;">
                                                                <div class="m-box">
                                                                    <input class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="width[]" type="text">
                                                                    <span class="measure-unit">cm</span>
                                                                </div>
                                                            </td>
                                                            <td class="height" style="width: 80px;">
                                                                <div class="m-box">
                                                                    <input class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="height[]" type="text">
                                                                    <span class="measure-unit">cm</span>
                                                                </div>
                                                            </td>
                                                            <td>1 x 17</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="price"></td>
                                                            <td id="next-row-td" style="padding: 0;">
                                                                <span id="next-row-span" class="tooltip1 next-row" style="cursor: pointer;font-size: 20px;">
                                                                    <i id="next-row-icon" style="color: #868686;" class="fa fa-fw fa-chevron-right"></i>
                                                                    <span style="top: 45px;" class="tooltiptext">Next</span>
                                                                </span>
                                                            </td>
                                                        </tr>

                                                        </tbody>

                                                    </table>

                                                </div>

                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background: white;padding: 15px 0 0 0;">

                                                    <ul style="border: 0;" class="nav nav-tabs feature-tab">
                                                        <li style="margin-bottom: 0;" class="active"><a style="border: 0;border-bottom: 3px solid rgb(151, 140, 135);padding: 10px 30px;" data-toggle="tab" href="#menu1" aria-expanded="false">Features</a></li>
                                                    </ul>

                                                    <div style="padding: 30px 15px 20px 15px;border: 0;border-top: 1px solid #24232329;" class="tab-content">

                                                        <div id="menu1" class="tab-pane fade active in">

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Ending of Dashboard data-table area -->
            </div>
        </div>
    </div>

    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Sub Products Sizes</h4>
                </div>
                <div class="modal-body">
                    <table style="width: 100%;">

                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Size 38mm</th>
                            <th>Size 25mm</th>
                        </tr>
                        </thead>

                        <tbody>

                        </tbody>

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

    <style>

        .feature-tab li a[aria-expanded="false"]::before, a[aria-expanded="true"]::before
        {
            display: none;
        }

        .m-box
        {
            display: flex;
            align-items: center;
        }

        .m-input
        {
            border-radius: 5px !important;
            width: 70%;
            border: 0;
            padding: 0;
            padding-right: 5px;
            text-align: right;
        }

        .m-input:focus
        {
            background: #f6f6f6;
        }

        .measure-unit
        {
            width: 30%;
        }

        .select2-container--default .select2-selection--single
        {
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
            padding: 5px 0;
            border-radius: 6px;
            position: absolute;
            z-index: 1;
            left: 0;
            top: 55px;
            font-size: 12px;
        }

        /* Show the tooltip text when you mouse over the tooltip container */
        .tooltip1:hover .tooltiptext {
            visibility: visible;
        }

        .first-row
        {
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

        .second-row
        {
            padding: 25px;
            display: flex;
            flex-direction: column;
            background: #fff;
            overflow: hidden;
        }

        table tr th
        {
            font-family: system-ui;
            font-weight: 500;
            border-bottom: 1px solid #ebebeb;
            padding-bottom: 15px;
            color: gray;
        }

        table tbody tr td
        {
            font-family: system-ui;
            font-weight: 500;
            padding: 0 10px;
            color: #3c3c3c;
        }

        table tbody tr.active td
        {
            border-top: 2px solid #cecece;
            border-bottom: 2px solid #cecece;
        }

        table tbody tr.active td:first-child
        {
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
            border-collapse:separate;
            border-spacing: 0 1em;
        }


        .modal-body table tr th
        {
            border: 1px solid #ebebeb;
            padding-bottom: 15px;
            color: gray;
        }

        .modal-body table tbody tr td
        {
            border-left: 1px solid #ebebeb;
            border-right: 1px solid #ebebeb;
            border-bottom: 1px solid #ebebeb;
        }

        .modal-body table tbody tr td:first-child
        {
            border-right: 0;
        }

        .modal-body table tbody tr td:last-child {
            border-left: 0;
        }

        .modal-body table {
            border-collapse:separate;
            border-spacing: 0;
            margin: 20px 0;
        }

        .modal-body table tbody tr td, .modal-body table thead tr th
        {
            padding: 5px 10px;
        }

    </style>

@endsection

@section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

    <script type="text/javascript">

        $(document).ready(function() {

            var current_desc = '';

            $(".add-desc").click(function(){
                current_desc = $(this);
                var d = current_desc.prev('input').val();
                $('#description-text').val(d);
                $("#myModal").modal('show');
            });

            $(".submit-desc").click(function () {
                var desc = $('#description-text').val();
                current_desc.prev('input').val(desc);
                $('#description-text').val('');
                $("#myModal").modal('hide');
            });

            $('.estimate_date').datepicker({

                format: 'dd-mm-yyyy',
                startDate: new Date(),

            });

            $(".js-data-example-ajax").select2({
                width: '100%',
                height: '200px',
                placeholder: "{{__('text.Select Products')}}",
                allowClear: true,
                "language": {
                    "noResults": function(){
                        return '{{__('text.No results found')}}';
                    }
                },
            });

            $(document).on('change', ".js-data-example-ajax", function(e){

                var current = $(this);

                var id = current.val();
                var row_id = current.parent().parent().data('id');
                var options = '';

                $.ajax({
                    type:"GET",
                    data: "id=" + id,
                    url: "<?php echo url('/aanbieder/get-colors')?>",
                    success: function(data) {

                        $('#menu1').find(`[data-id='${row_id}']`).remove();

                        current.parent().parent().find('.price').text('');
                        current.parent().parent().find('#row_total').val('');

                        $.each(data, function(index, value) {

                            if(value.title)
                            {
                                var opt = '<option value="'+value.id+'" >'+value.title+'</option>';

                                options = options + opt;
                            }

                        });

                        current.parent().parent().find('.color').children('select').find('option')
                            .remove()
                            .end()
                            .append('<option value="">Select Model</option>'+options);


                        if(data[0].measure)
                        {
                            current.parent().parent().find('.width').children('.m-box').children('.measure-unit').text(data[0].measure);
                            current.parent().parent().find('.height').children('.m-box').children('.measure-unit').text(data[0].measure);
                        }
                        else
                        {
                            current.parent().parent().find('.width').children('.m-box').children('.measure-unit').text('');
                            current.parent().parent().find('.height').children('.m-box').children('.measure-unit').text('');
                        }

                    }
                });

            });

            $(".js-data-example-ajax1").select2({
                width: '100%',
                height: '200px',
                placeholder: "",
                allowClear: true,
                "language": {
                    "noResults": function(){
                        return '{{__('text.No results found')}}';
                    }
                },
            });

            $(".js-data-example-ajax2").select2({
                width: '100%',
                height: '200px',
                placeholder: "",
                allowClear: true,
                "language": {
                    "noResults": function(){
                        return '{{__('text.No results found')}}';
                    }
                },
            });

            $(document).on('change', ".js-data-example-ajax2", function(e){

                var current = $(this);
                var row_id = current.parent().parent().data('id');

                var color = current.val();

                var width = current.parent().parent().find('.width').find('input').val();
                width = width.replace(/\,/g, '.');

                var height = current.parent().parent().find('.height').find('input').val();
                height = height.replace(/\,/g, '.');

                var product = current.parent().parent().find('.products').find('select').val();

                if(width && height && color && product)
                {
                    $.ajax({
                        type:"GET",
                        data: "product=" + product + "&color=" + color + "&width=" + width + "&height=" + height,
                        url: "<?php echo url('/aanbieder/get-price')?>",
                        success: function(data) {

                            if(typeof data[0].value !== 'undefined')
                            {
                                if(data[0].value === 'both')
                                {
                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{__('text.Oops...')}}',
                                        text: 'Width & Height are greater than max values',
                                    });

                                    current.parent().parent().find('.price').text('');
                                }
                                else if(data[0].value === 'x_axis')
                                {
                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{__('text.Oops...')}}',
                                        text: 'Width is greater than max value',
                                    });

                                    current.parent().parent().find('.price').text('');
                                }
                                else if(data[0].value === 'y_axis')
                                {

                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{__('text.Oops...')}}',
                                        text: 'Height is greater than max value',
                                    });

                                    current.parent().parent().find('.price').text('');
                                }
                                else
                                {
                                    var price = parseInt(data[0].value);
                                    var org = parseInt(data[0].value);
                                    var features = '';
                                    var f_value = 0;

                                    $.each(data[1], function(index, value) {

                                        var opt = '';

                                        $.each(value.features, function(index1, value1) {
                                            if(index1 == 0)
                                            {
                                                if(value1.impact_type == 0)
                                                {
                                                    f_value = value1.value;
                                                    price = price + parseInt(f_value);
                                                }
                                                else
                                                {
                                                    var per = (parseInt(f_value))/100;
                                                    f_value = org * per;
                                                    price = price + f_value;
                                                }
                                            }

                                            opt = opt + '<option value="'+value1.id+'">'+value1.title+'</option>';
                                        });

                                        var content = '<div class="row" style="margin: 10px 0;display: inline-block;width: 100%;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-3 col-md-3 col-sm-6 col-xs-6">\n' +
                                            '<label style="margin-right: 10px;margin-bottom: 0;min-width: 50%;">'+value.title+'</label>'+
                                            '<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="'+value.title+row_id+'">'+opt+'</select>\n' +
                                            '<input value="'+f_value+'" name="f_price" id="f_price" type="hidden">'+
                                            '</div></div>\n';

                                        features = features + content;

                                    });

                                    if($('#menu1').find(`[data-id='${row_id}']`).length > 0)
                                    {
                                        $('#menu1').find(`[data-id='${row_id}']`).remove();
                                    }

                                    $('#menu1').append('<div data-id="'+row_id+'" style="margin: 0;" class="form-group">' +
                                        '\n' +
                                        '<div class="row" style="margin: 10px 0;display: inline-block;width: 100%;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-3 col-md-3 col-sm-6 col-xs-6">\n' +
                                        '<label style="margin-right: 10px;margin-bottom: 0;min-width: 50%;">Quantity</label>'+
                                        '<input value="1" style="border: none;border-bottom: 1px solid lightgrey;" name="qty[]" class="form-control" type="text" /><span>pcs</span>' +
                                        '</div></div>' + features +
                                        '</div>');

                                    current.parent().parent().find('.price').text('€ ' + price);
                                    current.parent().parent().find('#row_total').val(price);

                                }
                            }
                            else
                            {
                                current.parent().parent().find('.price').text('');
                            }
                        }
                    });
                }

            });

            function focus_row(last_row)
            {
                $('#products_table tbody tr.active').removeClass('active');
                last_row.addClass('active');

                var id = last_row.data('id');

                $('#menu1').children().not(`[data-id='${id}']`).hide();
                $('#menu1').find(`[data-id='${id}']`).show();
            }

            function numbering()
            {
                $('#products_table > tbody  > tr').each(function(index, tr) { $(this).find('td:eq(0)').text(index + 1); });
            }

            function add_row(copy = false,price = null,products = null,product = null,items = null,item = null,colors = null,color = null,width = null,width_unit = null,height = null,height_unit = null,price_text = null,features = null,features_selects = null,qty = null)
            {
                var rowCount = $('#products_table tbody tr:last').data('id');
                rowCount = rowCount + 1;

                if(!copy)
                {
                    $("#products_table tbody").append('<tr data-id="'+rowCount+'">\n' +
                        '                                                            <td>'+rowCount+'</td>\n' +
                        '                                                            <input type="hidden" id="row_total" name="total[]">\n' +
                        '                                                            <td class="products">\n' +
                        '                                                                <select class="js-data-example-ajax">\n' +
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
                        '                                                            </td>\n' +
                        '                                                            <td class="items">\n' +
                        '                                                                <select class="js-data-example-ajax1">\n' +
                        '\n' +
                        '                                                                    <option value=""></option>\n' +
                        '\n' +
                        '                                                                    @foreach($items as $key)\n' +
                        '\n' +
                        '                                                                        <option value="{{$key->id}}">{{$key->cat_name}}</option>\n' +
                        '\n' +
                        '                                                                    @endforeach\n' +
                        '\n' +
                        '                                                                </select>\n' +
                        '                                                            </td>\n' +
                        '                                                            <td class="color">\n' +
                        '                                                                <select class="js-data-example-ajax2">\n' +
                        '\n' +
                        '                                                                    <option value=""></option>\n' +
                        '\n' +
                        '                                                                </select>\n' +
                        '                                                            </td>\n' +
                        '                                                            <td class="width" style="width: 80px;">\n' +
                        '                                                                <div class="m-box">\n' +
                        '                                                                    <input class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="width[]" type="text">\n' +
                        '                                                                    <span class="measure-unit">cm</span>\n' +
                        '                                                                </div>\n' +
                        '                                                            </td>\n' +
                        '                                                            <td class="height" style="width: 80px;">\n' +
                        '                                                                <div class="m-box">\n' +
                        '                                                                    <input class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="height[]" type="text">\n' +
                        '                                                                    <span class="measure-unit">cm</span>\n' +
                        '                                                                </div>\n' +
                        '                                                            </td>\n' +
                        '                                                            <td>1 x 17</td>\n' +
                        '                                                            <td></td>\n' +
                        '                                                            <td></td>\n' +
                        '                                                            <td class="price"></td>\n' +
                        '                                                            <td id="next-row-td" style="padding: 0;">\n' +
                        '                                                                <span id="next-row-span" class="tooltip1 next-row" style="cursor: pointer;font-size: 20px;">\n' +
                        '                                                                    <i id="next-row-icon" style="color: #868686;" class="fa fa-fw fa-chevron-right"></i>\n' +
                        '                                                                    <span style="top: 45px;" class="tooltiptext">Next</span>\n' +
                        '                                                                </span>\n' +
                        '                                                            </td>\n' +
                        '                                                        </tr>');

                    var last_row = $('#products_table tbody tr:last');

                    focus_row(last_row);

                    last_row.find(".js-data-example-ajax").select2({
                        width: '100%',
                        height: '200px',
                        placeholder: "{{__('text.Select Products')}}",
                        allowClear: true,
                        "language": {
                            "noResults": function(){
                                return '{{__('text.No results found')}}';
                            }
                        },
                    });

                    last_row.find(".js-data-example-ajax1").select2({
                        width: '100%',
                        height: '200px',
                        placeholder: "",
                        allowClear: true,
                        "language": {
                            "noResults": function(){
                                return '{{__('text.No results found')}}';
                            }
                        },
                    });

                    last_row.find(".js-data-example-ajax2").select2({
                        width: '100%',
                        height: '200px',
                        placeholder: "",
                        allowClear: true,
                        "language": {
                            "noResults": function(){
                                return '{{__('text.No results found')}}';
                            }
                        },
                    });
                }
                else
                {

                    $("#products_table tbody").append('<tr data-id="'+rowCount+'">\n' +
                        '                                                            <td>'+rowCount+'</td>\n' +
                        '                                                            <input value="'+price+'" type="hidden" id="row_total" name="total[]">\n' +
                        '                                                            <td class="products">\n' +
                        '                                                                <select class="js-data-example-ajax">\n' +
                        '\n' +
                        products +
                        '\n' +
                        '                                                                </select>\n' +
                        '                                                            </td>\n' +
                        '                                                            <td class="items">\n' +
                        '                                                                <select class="js-data-example-ajax1">\n' +
                        '\n' +
                        items +
                        '\n' +
                        '                                                                </select>\n' +
                        '                                                            </td>\n' +
                        '                                                            <td class="color">\n' +
                        '                                                                <select class="js-data-example-ajax2">\n' +
                        '\n' +
                        colors +
                        '\n' +
                        '                                                                </select>\n' +
                        '                                                            </td>\n' +
                        '                                                            <td class="width" style="width: 80px;">\n' +
                        '                                                                <div class="m-box">\n' +
                        '                                                                    <input value="'+width+'" class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="width[]" type="text">\n' +
                        '                                                                    <span class="measure-unit">'+width_unit+'</span>\n' +
                        '                                                                </div>\n' +
                        '                                                            </td>\n' +
                        '                                                            <td class="height" style="width: 80px;">\n' +
                        '                                                                <div class="m-box">\n' +
                        '                                                                    <input value="'+height+'" class="form-control m-input" maskedFormat="9,1" autocomplete="off" name="height[]" type="text">\n' +
                        '                                                                    <span class="measure-unit">'+height_unit+'</span>\n' +
                        '                                                                </div>\n' +
                        '                                                            </td>\n' +
                        '                                                            <td>1 x 17</td>\n' +
                        '                                                            <td></td>\n' +
                        '                                                            <td></td>\n' +
                        '                                                            <td class="price">'+price_text+'</td>\n' +
                        '                                                            <td id="next-row-td" style="padding: 0;">\n' +
                        '                                                                <span id="next-row-span" class="tooltip1 next-row" style="cursor: pointer;font-size: 20px;">\n' +
                        '                                                                    <i id="next-row-icon" style="color: #868686;" class="fa fa-fw fa-chevron-right"></i>\n' +
                        '                                                                    <span style="top: 45px;" class="tooltiptext">Next</span>\n' +
                        '                                                                </span>\n' +
                        '                                                            </td>\n' +
                        '                                                        </tr>');

                    var last_row = $('#products_table tbody tr:last');

                    last_row.find('.js-data-example-ajax').val(product);
                    last_row.find('.js-data-example-ajax1').val(item);
                    last_row.find('.js-data-example-ajax2').val(color);

                    if(features)
                    {
                        $('#menu1').append('<div data-id="'+rowCount+'" style="margin: 0;" class="form-group">\n' + features + '</div>');

                        $('#menu1').find(`[data-id='${rowCount}']`).find('input[name="qty[]"]').val(qty);

                        features_selects.each(function(index,select){
                            $('#menu1').find(`[data-id='${rowCount}']`).find('.feature-select').eq(index).val($(this).val());
                        });
                    }

                    focus_row(last_row);

                    last_row.find(".js-data-example-ajax").select2({
                        width: '100%',
                        height: '200px',
                        placeholder: "{{__('text.Select Products')}}",
                        allowClear: true,
                        "language": {
                            "noResults": function(){
                                return '{{__('text.No results found')}}';
                            }
                        },
                    });

                    last_row.find(".js-data-example-ajax1").select2({
                        width: '100%',
                        height: '200px',
                        placeholder: "",
                        allowClear: true,
                        "language": {
                            "noResults": function(){
                                return '{{__('text.No results found')}}';
                            }
                        },
                    });

                    last_row.find(".js-data-example-ajax2").select2({
                        width: '100%',
                        height: '200px',
                        placeholder: "",
                        allowClear: true,
                        "language": {
                            "noResults": function(){
                                return '{{__('text.No results found')}}';
                            }
                        },
                    });
                }
            }

            $(document).on('click', '#products_table tbody tr', function(e){

                if(e.target.id !== "next-row-td" && e.target.id !== "next-row-span" && e.target.id !== "next-row-icon"){
                    focus_row($(this));
                }

            });

            $(document).on('click', '.next-row', function(){

                if($(this).parent().parent().next('tr').length == 0)
                {
                    add_row();
                }
                else
                {
                    var next_row = $(this).parent().parent().next('tr');
                    focus_row(next_row);
                }
            });

            $(document).on('click', '.add-row', function(){

                add_row();

            });

            $(document).on('click', '.remove-row', function(){

                var current = $('#products_table tbody tr.active');

                var id = current.data('id');

                $('#menu1').find(`[data-id='${id}']`).remove();

                var next = current.next('tr');

                focus_row(next);

                current.remove();

                numbering();

            });

            $(document).on('click', '.copy-row', function(){

                var current = $('#products_table tbody tr.active');
                var id = current.data('id');
                var price = current.find('#row_total').val();
                var products = current.find('.js-data-example-ajax').html();
                var product = current.find('.js-data-example-ajax').val();
                var items = current.find('.js-data-example-ajax1').html();
                var item = current.find('.js-data-example-ajax1').val();
                var colors = current.find('.js-data-example-ajax2').html();
                var color = current.find('.js-data-example-ajax2').val();
                var width = current.find('.width').find('.m-input').val();
                var width_unit = current.find('.width').find('.measure-unit').text();
                var height = current.find('.height').find('.m-input').val();
                var height_unit = current.find('.height').find('.measure-unit').text();
                var price_text = current.find('.price').text();
                var features = $('#menu1').find(`[data-id='${id}']`).html();
                var features_selects = $('#menu1').find(`[data-id='${id}']`).find('.feature-select');
                var qty = $('#menu1').find(`[data-id='${id}']`).find('input[name="qty[]"]').val();

                add_row(true,price,products,product,items,item,colors,color,width,width_unit,height,height_unit,price_text,features,features_selects,qty);

            });

            $(document).on('keypress', "input[name='width[]']", function(e){

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

            $(document).on('keypress', "input[name='height[]']", function(e){

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

            $(document).on('focusout', "input[name='width[]']", function(e){

                if($(this).val().slice($(this).val().length - 1) == ',')
                {
                    var val = $(this).val();
                    val = val + '00';
                    $(this).val(val);
                }
            });

            $(document).on('focusout', "input[name='height[]']", function(e){
                if($(this).val().slice($(this).val().length - 1) == ',')
                {
                    var val = $(this).val();
                    val = val + '00';
                    $(this).val(val);
                }
            });

            $(document).on('input', "input[name='width[]']", function(e){

                var current = $(this);
                var row_id = current.parent().parent().parent().data('id');

                var width = current.val();
                width = width.replace(/\,/g, '.');

                var height = current.parent().parent().next('.height').find('input').val();
                height = height.replace(/\,/g, '.');

                var color = current.parent().parent().parent().find('.color').find('select').val();
                var product = current.parent().parent().parent().find('.products').find('select').val();

                if(width && height && color && product)
                {
                    $.ajax({
                        type:"GET",
                        data: "product=" + product + "&color=" + color + "&width=" + width + "&height=" + height,
                        url: "<?php echo url('/aanbieder/get-price')?>",
                        success: function(data) {

                            if(typeof data[0].value !== 'undefined')
                            {
                                if(data[0].value === 'both')
                                {
                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{__('text.Oops...')}}',
                                        text: 'Width & Height are greater than max values',
                                    });

                                    current.parent().parent().parent().find('.price').text('');
                                }
                                else if(data[0].value === 'x_axis')
                                {
                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{__('text.Oops...')}}',
                                        text: 'Width is greater than max value',
                                    });

                                    current.parent().parent().parent().find('.price').text('');
                                }
                                else if(data[0].value === 'y_axis')
                                {

                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{__('text.Oops...')}}',
                                        text: 'Height is greater than max value',
                                    });

                                    current.parent().parent().parent().find('.price').text('');
                                }
                                else
                                {
                                    var price = parseInt(data[0].value);
                                    var org = parseInt(data[0].value);
                                    var features = '';
                                    var f_value = 0;

                                    $.each(data[1], function(index, value) {

                                        var opt = '';

                                        $.each(value.features, function(index1, value1) {
                                            if(index1 == 0)
                                            {
                                                if(value1.impact_type == 0)
                                                {
                                                    f_value = value1.value;
                                                    price = price + parseInt(f_value);
                                                }
                                                else
                                                {
                                                    var per = (parseInt(f_value))/100;
                                                    f_value = org * per;
                                                    price = price + f_value;
                                                }
                                            }

                                            opt = opt + '<option value="'+value1.id+'">'+value1.title+'</option>';
                                        });

                                        var content = '<div class="row" style="margin: 10px 0;display: inline-block;width: 100%;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-3 col-md-3 col-sm-6 col-xs-6">\n' +
                                            '<label style="margin-right: 10px;margin-bottom: 0;min-width: 50%;">'+value.title+'</label>'+
                                            '<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features[]">'+opt+'</select>\n' +
                                            '<input value="'+f_value+'" name="f_price" id="f_price" type="hidden">'+
                                            '</div></div>\n';

                                        features = features + content;

                                    });

                                    if($('#menu1').find(`[data-id='${row_id}']`).length > 0)
                                    {
                                        $('#menu1').find(`[data-id='${row_id}']`).remove();
                                    }

                                    $('#menu1').append('<div data-id="'+row_id+'" style="margin: 0;" class="form-group">' +
                                        '\n' +
                                        '<div class="row" style="margin: 10px 0;display: inline-block;width: 100%;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-3 col-md-3 col-sm-6 col-xs-6">\n' +
                                        '<label style="margin-right: 10px;margin-bottom: 0;min-width: 50%;">Quantity</label>'+
                                        '<input value="1" style="border: none;border-bottom: 1px solid lightgrey;" name="qty[]" class="form-control" type="text" /><span>pcs</span>' +
                                        '</div></div>' + features +
                                        '</div>');

                                    current.parent().parent().parent().find('.price').text('€ ' + price);
                                    current.parent().parent().parent().find('#row_total').val(price);

                                }
                            }
                            else
                            {
                                current.parent().parent().parent().find('.price').text('');
                            }
                        }
                    });
                }

            });

            $(document).on('input', "input[name='height[]']", function(e){

                var current = $(this);
                var row_id = current.parent().parent().parent().data('id');

                var height = current.val();
                height = height.replace(/\,/g, '.');

                var width = current.parent().parent().prev('.width').find('input').val();
                width = width.replace(/\,/g, '.');

                var color = current.parent().parent().parent().find('.color').find('select').val();
                var product = current.parent().parent().parent().find('.products').find('select').val();

                if(width && height && color && product)
                {
                    $.ajax({
                        type:"GET",
                        data: "product=" + product + "&color=" + color + "&width=" + width + "&height=" + height,
                        url: "<?php echo url('/aanbieder/get-price')?>",
                        success: function(data) {

                            if(typeof data[0].value !== 'undefined')
                            {
                                if(data[0].value === 'both')
                                {
                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{__('text.Oops...')}}',
                                        text: 'Width & Height are greater than max values',
                                    });

                                    current.parent().parent().parent().find('.price').text('');
                                }
                                else if(data[0].value === 'x_axis')
                                {
                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{__('text.Oops...')}}',
                                        text: 'Width is greater than max value',
                                    });

                                    current.parent().parent().parent().find('.price').text('');
                                }
                                else if(data[0].value === 'y_axis')
                                {

                                    Swal.fire({
                                        icon: 'error',
                                        title: '{{__('text.Oops...')}}',
                                        text: 'Height is greater than max value',
                                    });

                                    current.parent().parent().parent().find('.price').text('');
                                }
                                else
                                {
                                    var price = parseInt(data[0].value);
                                    var org = parseInt(data[0].value);
                                    var features = '';
                                    var f_value = 0;


                                    $.each(data[1], function(index, value) {

                                        var opt = '';

                                        $.each(value.features, function(index1, value1) {
                                            if(index1 == 0)
                                            {
                                                if(value1.impact_type == 0)
                                                {
                                                    f_value = value1.value;
                                                    price = price + parseInt(f_value);
                                                }
                                                else
                                                {
                                                    var per = (parseInt(f_value))/100;
                                                    f_value = org * per;
                                                    price = price + f_value;
                                                }
                                            }

                                            /*opt = opt + '<option value="'+value1.id+'">'+value1.title+'</option>';*/
                                        });

                                        opt = '<option value="0">No</option><option value="1">Yes</option>';

                                        var content = '<div class="row" style="margin: 10px 0;display: inline-block;width: 100%;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-3 col-md-3 col-sm-6 col-xs-6">\n' +
                                            '<label style="margin-right: 10px;margin-bottom: 0;min-width: 50%;">'+value.title+'</label>'+
                                            '<select style="border: none;border-bottom: 1px solid lightgrey;height: 30px;padding: 0;" class="form-control feature-select" name="features[]">'+opt+'</select>\n' +
                                            '<input value="'+f_value+'" name="f_price" class="f_price" type="hidden">'+
                                            '<input value="'+value.id+'" name="f_id" class="f_id" type="hidden">'+
                                            '</div></div>\n';

                                        features = features + content;

                                    });

                                    if($('#menu1').find(`[data-id='${row_id}']`).length > 0)
                                    {
                                        $('#menu1').find(`[data-id='${row_id}']`).remove();
                                    }

                                    $('#menu1').append('<div data-id="'+row_id+'" style="margin: 0;" class="form-group">' +
                                        '\n' +
                                        '<div class="row" style="margin: 10px 0;display: inline-block;width: 100%;"><div style="display: flex;align-items: center;font-family: Dlp-Brown,Helvetica Neue,sans-serif;font-size: 12px;" class="col-lg-3 col-md-3 col-sm-6 col-xs-6">\n' +
                                        '<label style="margin-right: 10px;margin-bottom: 0;min-width: 50%;">Quantity</label>'+
                                        '<input value="1" style="border: none;border-bottom: 1px solid lightgrey;" name="qty[]" class="form-control" type="text" /><span>pcs</span>' +
                                        '</div></div>' + features +
                                        '</div>');

                                    current.parent().parent().parent().find('.price').text('€ ' + price);
                                    current.parent().parent().parent().find('#row_total').val(price);
                                }
                            }
                            else
                            {
                                current.parent().parent().parent().find('.price').text('');
                            }
                        }
                    });
                }

            });

            $(document).on('change', '.feature-select', function(){

                var current = $(this);
                var feature_select = current.val();
                var id = current.parent().find('.f_id').val();

                if(feature_select == 1)
                {
                    $.ajax({
                        type: "GET",
                        data: "id=" + id,
                        url: "<?php echo url('/aanbieder/get-sub-products-sizes')?>",
                        success: function (data) {

                            $('#myModal').find('.modal-body').find('table tbody').children().remove();

                            $.each(data, function(index, value) {

                                var size1 = value.size1_value;
                                var size2 = value.size2_value;

                                if(size1 == 1)
                                {
                                    size1 = '<input type="checkbox">';
                                }
                                else
                                {
                                    size1 = 'X';
                                }

                                if(size2 == 1)
                                {
                                    size2 = '<input type="checkbox">';
                                }
                                else
                                {
                                    size2 = 'X';
                                }

                                $('#myModal').find('.modal-body').find('table tbody').append(
                                    '<tr>\n' +
                                    '<td>'+value.unique_code+'</td>\n' +
                                    '<td>'+value.title+'</td>\n' +
                                    '<td>'+size1+'</td>\n' +
                                    '<td>'+size2+'</td>\n' +
                                    '</tr>'
                                );

                            });

                            $('#myModal').modal('toggle');
                        }
                    });
                }

                /*var impact_value = current.next('input').val();
                var row_id = current.parent().parent().parent().data('id');
                var total = $('#products_table tbody').find(`[data-id='${row_id}']`).find('#row_total').val();

                total = total - impact_value;

                $.ajax({
                    type: "GET",
                    data: "id=" + feature_select,
                    url: "<?php echo url('/aanbieder/get-feature-price')?>",
                    success: function (data) {

                        if(data.impact_type == 0)
                        {
                            impact_value = data.value;
                            total = total + parseInt(impact_value);
                        }
                        else
                        {
                            var per = (parseInt(data.value))/100;
                            impact_value = total * per;
                            total = total + (impact_value);
                        }

                        current.next('input').val(impact_value);
                        $('#products_table tbody').find(`[data-id='${row_id}']`).find('.price').text('€ ' + total);
                        $('#products_table tbody').find(`[data-id='${row_id}']`).find('#row_total').val(total);
                    }
                });*/

            });


        });
    </script>

@endsection
