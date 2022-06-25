@extends('layouts.handyman')
@section('content')

    <div class="right-side">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- Starting of Dashboard header items area -->
                    <div class="panel panel-default admin">

                        <div class="panel-heading admin-title">{{Auth::guard('user')->user()->role_id == 2 ? $user->company_name : __('text.Supplier Dashboard')}}</div>

                    </div>
                    <!-- Ending of Dashboard header items area -->

                    <!-- Starting of Dashboard Top reference + Most Used OS area -->
                    <div class="reference-OS-area">

                        <h3 style="margin: 50px 0 20px 0;">{{__('text.Order status of last 10 orders')}}</h3>

                        <table id="example" class="table table-striped table-hover products dt-responsive dataTable no-footer dtr-inline" role="grid" aria-describedby="product-table_wrapper_info" style="width: 100%;margin-top: 10px !important;margin-bottom: 50px !important;" width="100%" cellspacing="0">

                            <thead>

                            <tr role="row">

                                <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending">{{__('text.Consumer Name')}}</th>

                                <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending">{{__('text.Quote Number')}}</th>

                                <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending">{{__('text.Order Date')}}</th>

                                <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending">{{__('text.Supplier')}}</th>

                                <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending">{{__('text.Delivery Date')}}</th>

                            </tr>

                            </thead>

                            <tbody>

                            @foreach($orders as $key)

                                <tr role="row" class="odd">
                                    <td>{{$key->name}}</td>
                                    <td>{{$key->quotation_invoice_number}}</td>
                                    <td>{{$key->order_date ? date('d-m-Y',strtotime($key->order_date)) : null}}</td>
                                    <td>{{$key->company_name}}</td>
                                    <td>{{$key->approved ? ($key->delivery_date ? date('d-m-Y',strtotime($key->delivery_date)) : null) : null}}</td>
                                </tr>

                            @endforeach

                            </tbody>

                        </table>

                        <div style="margin: 0 0 50px 0;" class="row">

                            <div style="padding: 0;" class="col-lg-6 col-md-6 col-sm-12 col-xs-12">

                                <h3 style="text-align: center;">{{__('text.Quotes')}}</h3>
                                <div id="quoteChart" style="width: 98%;height: 400px;"></div>

                            </div>

                            <div style="padding: 0;" class="col-lg-6 col-md-6 col-sm-12 col-xs-12 top-m">

                                <h3 style="text-align: center;">{{__('text.Invoices')}}</h3>
                                <div id="invoiceChart" style="width: 98%;height: 400px;"></div>

                            </div>

                        </div>

                    </div>
                    <!-- Ending of Dashboard Top reference + Most Used OS area -->

                </div>
            </div>
        </div>
    </div>

    <style>

        .top-m
        {
            margin-top: 30px;
        }

        @media (min-width: 992px)
        {
            .top-m
            {
                margin-top: 0;
            }
        }

        #dashboard {
            color: #fff;
            background: {{$gs->colors == null ? 'rgba(207, 55, 58, 0.70)':$gs->colors.'c2'}};

        }

        table.dataTable thead>tr>th.sorting_asc, table.dataTable thead>tr>th.sorting_desc, table.dataTable thead>tr>th.sorting, table.dataTable thead>tr>td.sorting_asc, table.dataTable thead>tr>td.sorting_desc, table.dataTable thead>tr>td.sorting{

            padding-right: 0;
            padding-left: 0;
            text-align: center;
            border-top: 1px solid black !important;
            border-bottom: 1px solid black !important;
        }

        .table.products > tbody > tr > td
        {
            text-align: center;
        }

    </style>


@endsection

@section('scripts')

    <script>

        window.onload = function () {

            CanvasJS.addCultureInfo("nl",
            {
                decimalSeparator: ",",
                digitGroupSeparator: ".",
            });
 
            var chart = new CanvasJS.Chart("quoteChart", {
                
                backgroundColor: "transparent",
                culture:  "nl",
                animationEnabled: true,
                theme: "light2",
                title:{
                    text: ""
                },
                axisY:{
                    includeZero: true,
                },
                legend:{
                    cursor: "pointer",
                    verticalAlign: "center",
                    horizontalAlign: "right",
                    itemclick: toggleDataSeries,
                },
                data: [{
                    type: "column",
                    name: "Quotes",
                    // indexLabelFontSize: 12,
                    // indexLabel: "{y}",
                    showInLegend: true,
                    dataPoints: <?php echo $quotes_chart; ?>
                },{
                    type: "column",
                    name: "Accepted",
                    // indexLabelFontSize: 12,
                    // indexLabel: "{y}",
                    showInLegend: true,
                    dataPoints: <?php echo $accepted_chart; ?>
                }]
            });
 
            chart.render();
  
            function toggleDataSeries(e){
            
                if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                }
                else{
                    e.dataSeries.visible = true;
                }
                chart.render();
            }

            var chart1 = new CanvasJS.Chart("invoiceChart", {
                
                backgroundColor: "transparent",
                culture:  "nl",
	            animationEnabled: true,
	            theme: "light2", // "light1", "light2", "dark1", "dark2"
	            title:{
		            text: ""
	            },
	            axisY: {
		            includeZero: true,
	            },
	            data: [{
                    // color: '#8CDCBD',
		            type: "column",
		            showInLegend: false,
		            legendMarkerColor: "gray",
		            legendText: "Invoices Total",
		            dataPoints: <?php echo $invoices_chart; ?>
	            }]
            });
        
            chart1.render();
  
        }

        $('#example').DataTable({
            order: [[0, 'desc']],
            searching: false,
            paging: false,
            info: false,
        });

        $("#opt").change(function () {

            var opt = $("#opt").val();

            if (opt == "yes") {
                $("#cost").html("Total Cost: {{$gs->fp+$gs->np}}$");
            } else {
                $("#cost").html("Total Cost: {{$gs->np}}$");
            }

        });
        //    $('#pay').click(function(e) {
        //
        //        var opt = $("#opt").val();
        //        if(opt !=""){
        //
        //            $('#ModalAll').modal('toggle'); //or  $('#IDModal').modal('hide');
        //        }
        //    });
        //    $('#pay2').click(function(e) {
        //        $('#ModalFeature').modal('toggle'); //or  $('#IDModal').modal('hide');
        //    });

        function meThods(val) {
            var action1 = "{{route('payment.submit')}}";
            var action2 = "{{route('stripe.submit')}}";
            if (val.value == "Paypal") {
                $("#payment_form").attr("action", action1);
                $("#stripes").hide();
                $("#stripes").find("input").attr('required', false);
            }
            if (val.value == "Stripe") {
                $("#payment_form").attr("action", action2);
                $("#stripes").show();
                $("#stripes").find("input").attr('required', true);
            }
        }

        function meThods2(val) {
            var action1 = "{{route('payment.submit')}}";
            var action2 = "{{route('stripe.submit')}}";
            if (val.value == "Paypal") {
                $("#payment_form2").attr("action", action1);
                $("#stripes2").hide();
                $("#stripes2").find("input").attr('required', false);
            }
            if (val.value == "Stripe") {
                $("#payment_form2").attr("action", action2);
                $("#stripes2").show();
                $("#stripes2").find("input").attr('required', true);
            }
        }

    </script>

@endsection
