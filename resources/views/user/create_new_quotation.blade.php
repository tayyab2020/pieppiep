@extends('layouts.handyman')

@section('content')

    <div class="right-side">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- Starting of Dashboard data-table area -->
                    <div class="section-padding add-product-1" style="padding-top: 0;">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="add-product-box">
                                    <div class="add-product-header products">
                                        <h2>{{__('text.Create Quotation')}}</h2>

                                    </div>
                                    <hr>
                                    <div>
                                        @include('includes.form-success')

                                        <form class="form-horizontal" action="{{route('store-quotation')}}" method="POST" enctype="multipart/form-data">
                                            {{csrf_field()}}

                                            <div style="margin: 0;" class="row">

                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 first-row">

                                                    <div>
                                                        <span class="tooltip1" style="margin-right: 10px;">
                                                            <i class="fa fa-fw fa-plus-circle"></i>
                                                            <span class="tooltiptext">Add</span>
                                                        </span>

                                                        <span class="tooltip1" style="cursor: pointer;font-size: 20px;margin-right: 10px;">
                                                            <i class="fa fa-fw fa-minus-circle"></i>
                                                            <span class="tooltiptext">Remove</span>
                                                        </span>

                                                        <span class="tooltip1" style="cursor: pointer;font-size: 20px;">
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


                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 second-row">

                                                    <table style="width: 100%;">
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

                                                        <tr>
                                                            <td>1</td>
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
                                                            <td style="padding: 0;">
                                                                <span class="tooltip1" style="cursor: pointer;font-size: 20px;">
                                                                    <i style="color: #868686;" class="fa fa-fw fa-chevron-right"></i>
                                                                    <span style="top: 45px;" class="tooltiptext">Next</span>
                                                                </span>
                                                            </td>
                                                        </tr>

                                                        </tbody>

                                                    </table>

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

    <style>

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
            border-top: 2px solid #cecece;
            border-bottom: 2px solid #cecece;
            padding: 0 10px;
            color: #3c3c3c;
        }

        table tbody tr td:first-child {
            border-left: 2px solid #cecece;
            border-bottom-left-radius: 4px;
            border-top-left-radius: 4px;
        }

        table tbody tr td:last-child {
            border-right: 2px solid #cecece;
            border-bottom-right-radius: 4px;
            border-top-right-radius: 4px;
        }

        table {
            border-collapse:separate;
            border-spacing: 0 1em;
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

            $('.js-data-example-ajax').change(function(){

                var current = $(this);

                var id = current.val();
                var options = '';

                $.ajax({
                    type:"GET",
                    data: "id=" + id,
                    url: "<?php echo url('/aanbieder/get-colors')?>",
                    success: function(data) {

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

            $('.js-data-example-ajax2').change(function(){

                var current = $(this);

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

                                    $.each(data[1], function(index, value) {

                                        if(value.impact_type == 0)
                                        {
                                            price = price + parseInt(value.value);
                                        }
                                        else
                                        {
                                            var per = (parseInt(value.value))/100;
                                            price = price + (org * per);
                                        }

                                    });
                                    current.parent().parent().find('.price').text('€ ' + price);
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

            $(document).on('focusout', '#productInput', function(){

                var check = $(this).next('input').val();

                if(check == 0)
                {
                    $(this).val('');
                }
            });

            /*An array containing all the country names in the world:*/
            options = [];
            texts = [];
            categories = [];

            var sel = $(".all-products");
            var length = sel.children('option').length;

            $(".all-products > option").each(function() {
                if(this.getAttribute('data-type') != 'Product')
                {
                    var category = this.getAttribute('data-type');
                }
                else
                {
                    var category = this.getAttribute('data-cat');
                }
                if (this.value) options.push(this.value); texts.push(this.text); categories.push(category);
            });

            $(document).on('click', '.add-row', function(){

                var rowCount = $('.items-table tr').length;

                $(".items-table").append('<tr>\n' +
                    '                                                                        <td>'+rowCount+'</td>\n' +
                    '                                                                           <td class="main_box">\n' +
                    '                                                                            <div class="autocomplete" style="width:100%;">\n' +
                    '                                                                                <input autocomplete="off" required name="productInput[]" id="productInput" class="form-control" type="text" placeholder="{{__('text.Select Product')}}">\n' +
                    '                                                                                <input type="hidden" id="check" value="0">\n' +
                    '                                                                            </div>\n' +
                    '                                                                            <input type="hidden" id="item" name="item[]" value="">\n' +
                    '                                                                            <input type="hidden" id="service_title" name="service_title[]">\n' +
                    '                                                                            <input type="hidden" id="brand" name="brand[]" value="">\n' +
                    '                                                                            <input type="hidden" id="brand_title" name="brand_title[]">\n' +
                    '                                                                            <input type="hidden" id="model" name="model[]" value="">\n' +
                    '                                                                            <input type="hidden" id="model_title" name="model_title[]">\n' +
                    '                                                                        </td>'+
                    '                                                                        <td class="td-qty">\n' +
                    '                                                                            <input name="qty[]" maskedFormat="9,1" autocomplete="off" class="form-control" type="text" required>\n' +
                    '                                                                        </td>\n' +
                    '                                                                        <td class="td-rate">\n' +
                    '                                                                            <input name="cost[]" maskedFormat="9,1" autocomplete="off" class="form-control" type="text" value="" required>\n' +
                    '                                                                        </td>\n' +
                    '                                                                        <td class="td-amount">\n' +
                    '                                                                            <input name="amount[]" class="form-control" readonly="" type="text">\n' +
                    '                                                                        </td>\n' +
                    '                                                                        <td style="text-align: center;" class="td-desc">\n' +
                    '                                                                            <input type="hidden" name="description[]" id="description" class="form-control">\n' +
                    '                                                                            <a href="javascript:void(0)" class="add-desc" title="<?php echo __('text.Add Description') ?>" style="color: black;"><i style="font-size: 20px;" class="fa fa-plus-square"></i></a>\n'+
                    '                                                                        </td>\n' +
                    '                                                                        <td style="text-align: center;"><a href="javascript:void(0)" class="text-success font-18 add-row" title=""><i class="fa fa-plus"></i></a><a href="javascript:void(0)" class="text-danger font-18 remove-row" title="<?php echo __('text.Remove') ?>"><i class="fa fa-trash-o"></i></a></td>\n' +
                    '                                                                    </tr>');

                $(".add-desc").click(function(){
                    current_desc = $(this);
                    var d = current_desc.prev('input').val();
                    $('#description-text').val(d);
                    $("#myModal").modal('show');
                });

                var last_row = $('.items-table tr:last');

                autocomplete(last_row.find('#productInput')[0], texts, options, categories);

                last_row.find(".js-data-example-ajax").select2({
                    width: '100%',
                    height: '200px',
                    placeholder: "{{__('text.Select Category/Item')}}",
                    allowClear: true,
                });

                last_row.find(".js-data-example-ajax1").select2({
                    width: '100%',
                    height: '200px',
                    placeholder: "{{__('text.Select Brand')}}",
                    allowClear: true,
                });

                last_row.find(".js-data-example-ajax2").select2({
                    width: '100%',
                    height: '200px',
                    placeholder: "{{__('text.Select Model')}}",
                    allowClear: true,
                });


                $('.estimate_date').datepicker({

                    format: 'dd-mm-yyyy',
                    startDate: new Date(),

                });


                $(".remove-row").click(function(){

                    var rowCount = $('.items-table tr').length;

                    $(this).parent().parent().remove();

                    $(".items-table tbody tr").each(function(index) {
                        $(this).children('td:first-child').text(index+1);
                    });

                    var vat_percentage = parseInt($('#vat_percentage').val());
                    vat_percentage = vat_percentage + 100;

                    var amounts = [];
                    $("input[name='amount[]']").each(function() {
                        amounts.push($(this).val().replace(/\,/g, '.'));
                    });

                    var grand_total = 0;

                    for (let i = 0; i < amounts.length; ++i) {

                        if(isNaN(parseFloat(amounts[i])))
                        {
                            amounts[i] = 0;
                        }

                        grand_total = (parseFloat(amounts[i]) + parseFloat(grand_total)).toFixed(2);
                    }

                    var vat = grand_total/vat_percentage * 100;
                    vat = grand_total - vat;
                    vat = parseFloat(vat).toFixed(2);

                    var sub_total = grand_total - vat;
                    sub_total = parseFloat(sub_total).toFixed(2);

                    $('#sub_total').val(sub_total.replace(/\./g, ','));
                    $('#tax_amount').val(vat.replace(/\./g, ','));
                    $('#grand_total').val(grand_total);

                    $('#grand_total_cell').text('€ ' + grand_total.replace(/\./g, ','));

                });

                $("input[name='cost[]'").keypress(function(e){

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

                $("input[name='qty[]'").keypress(function(e){

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

                $("input[name='cost[]'").on('focusout',function(e){
                    if($(this).val().slice($(this).val().length - 1) == ',')
                    {
                        var val = $(this).val();
                        val = val + '00';
                        $(this).val(val);
                    }
                });

                $("input[name='qty[]'").on('focusout',function(e){
                    if($(this).val().slice($(this).val().length - 1) == ',')
                    {
                        var val = $(this).val();
                        val = val + '00';
                        $(this).val(val);
                    }
                });

                $("input[name='cost[]'").on('input',function(e){

                    var vat_percentage = parseInt($('#vat_percentage').val());
                    vat_percentage = vat_percentage + 100;
                    var cost = $(this).val();
                    cost = cost.replace(/\,/g, '.');
                    var qty = $(this).parent().parent().find('.td-qty').children('input').val();
                    qty = qty.replace(/\,/g, '.');

                    var amount = cost * qty;

                    amount = parseFloat(amount).toFixed(2);

                    if(isNaN(amount))
                    {
                        amount = 0;
                    }

                    amount = amount.replace(/\./g, ',');

                    $(this).parent().parent().find('.td-amount').children('input').val(amount);

                    var amounts = [];
                    $("input[name='amount[]']").each(function() {
                        amounts.push($(this).val().replace(/\,/g, '.'));
                    });

                    var grand_total = 0;

                    for (let i = 0; i < amounts.length; ++i) {

                        if(isNaN(parseFloat(amounts[i])))
                        {
                            amounts[i] = 0;
                        }

                        grand_total = (parseFloat(amounts[i]) + parseFloat(grand_total)).toFixed(2);
                    }

                    var vat = grand_total/vat_percentage * 100;
                    vat = grand_total - vat;
                    vat = parseFloat(vat).toFixed(2);

                    var sub_total = grand_total - vat;
                    sub_total = parseFloat(sub_total).toFixed(2);

                    $('#sub_total').val(sub_total.replace(/\./g, ','));
                    $('#tax_amount').val(vat.replace(/\./g, ','));
                    $('#grand_total').val(grand_total);

                    $('#grand_total_cell').text('€ ' + grand_total.replace(/\./g, ','));

                });

                $("input[name='qty[]'").on('input',function(e){

                    var vat_percentage = parseInt($('#vat_percentage').val());
                    vat_percentage = vat_percentage + 100;
                    var qty = $(this).val();
                    qty = qty.replace(/\,/g, '.');
                    var cost = $(this).parent().parent().find('.td-rate').children('input').val();
                    cost = cost.replace(/\,/g, '.');

                    var amount = cost * qty;

                    amount = parseFloat(amount).toFixed(2);

                    if(isNaN(amount))
                    {
                        amount = 0;
                    }

                    amount = amount.replace(/\./g, ',');

                    $(this).parent().parent().find('.td-amount').children('input').val(amount);

                    var amounts = [];
                    $("input[name='amount[]']").each(function() {
                        amounts.push($(this).val().replace(/\,/g, '.'));
                    });

                    var grand_total = 0;

                    for (let i = 0; i < amounts.length; ++i) {

                        if(isNaN(parseFloat(amounts[i])))
                        {
                            amounts[i] = 0;
                        }

                        grand_total = (parseFloat(amounts[i]) + parseFloat(grand_total)).toFixed(2);
                    }

                    var vat = grand_total/vat_percentage * 100;
                    vat = grand_total - vat;
                    vat = parseFloat(vat).toFixed(2);

                    var sub_total = grand_total - vat;
                    sub_total = parseFloat(sub_total).toFixed(2);

                    $('#sub_total').val(sub_total.replace(/\./g, ','));
                    $('#tax_amount').val(vat.replace(/\./g, ','));
                    $('#grand_total').val(grand_total);

                    $('#grand_total_cell').text('€ ' + grand_total.replace(/\./g, ','));

                });

            });


            $(".remove-row").click(function(){

                var rowCount = $('.items-table tr').length;

                $(this).parent().parent().remove();

                $(".items-table tbody tr").each(function(index) {
                    $(this).children('td:first-child').text(index+1);
                });

                var vat_percentage = parseFloat($('#vat_percentage').val());
                vat_percentage = vat_percentage + 100;

                var amounts = [];
                $("input[name='amount[]']").each(function() {
                    amounts.push($(this).val().replace(/\,/g, '.'));
                });

                var grand_total = 0;

                for (let i = 0; i < amounts.length; ++i) {

                    if(isNaN(parseFloat(amounts[i])))
                    {
                        amounts[i] = 0;
                    }

                    grand_total = (parseFloat(amounts[i]) + parseFloat(grand_total)).toFixed(2);
                }

                var vat = grand_total/vat_percentage * 100;
                vat = grand_total - vat;
                vat = parseFloat(vat).toFixed(2);

                var sub_total = grand_total - vat;
                sub_total = parseFloat(sub_total).toFixed(2);

                $('#sub_total').val(sub_total.replace(/\./g, ','));
                $('#tax_amount').val(vat.replace(/\./g, ','));
                $('#grand_total').val(grand_total);

                $('#grand_total_cell').text('€ ' + grand_total.replace(/\./g, ','));

            });


            $("input[name='width[]'").keypress(function(e){

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


            $("input[name='height[]'").keypress(function(e){

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


            $("input[name='width[]'").on('focusout',function(e){

                if($(this).val().slice($(this).val().length - 1) == ',')
                {
                    var val = $(this).val();
                    val = val + '00';
                    $(this).val(val);
                }
            });

            $("input[name='height[]'").on('focusout',function(e){
                if($(this).val().slice($(this).val().length - 1) == ',')
                {
                    var val = $(this).val();
                    val = val + '00';
                    $(this).val(val);
                }
            });

            $("input[name='width[]'").on('input',function(e){

                var current = $(this);

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

                                    $.each(data[1], function(index, value) {

                                        if(value.impact_type == 0)
                                        {
                                            price = price + parseInt(value.value);
                                        }
                                        else
                                        {
                                            var per = (parseInt(value.value))/100;
                                            price = price + (org * per);
                                        }

                                    });
                                    current.parent().parent().parent().find('.price').text('€ ' + price);
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

            $("input[name='height[]'").on('input',function(e){

                var current = $(this);

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

                                    $.each(data[1], function(index, value) {

                                        if(value.impact_type == 0)
                                        {
                                            price = price + parseInt(value.value);
                                        }
                                        else
                                        {
                                            var per = (parseInt(value.value))/100;
                                            price = price + (org * per);
                                        }

                                    });
                                    current.parent().parent().parent().find('.price').text('€ ' + price);
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


        });
    </script>

@endsection
