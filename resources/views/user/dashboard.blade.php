@extends('layouts.handyman')
@section('content')



    <div class="right-side">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- Starting of Dashboard header items area -->
                    <div class="panel panel-default admin">

                        <div class="panel-heading admin-title">{{Auth::guard('user')->user()->role_id == 2 ? 'Retailer Dashboard' : 'Supplier Dashboard'}}</div>

                    </div>
                    <!-- Ending of Dashboard header items area -->

                    <!-- Starting of Dashboard Top reference + Most Used OS area -->
                    <div class="reference-OS-area">

                        <h3 style="margin: 50px 0 20px 0;">Order status of last 10 orders</h3>

                        <table id="example" class="table table-striped table-hover products dt-responsive dataTable no-footer dtr-inline" role="grid" aria-describedby="product-table_wrapper_info" style="width: 100%;margin-top: 10px !important;margin-bottom: 50px !important;" width="100%" cellspacing="0">

                            <thead>

                            <tr role="row">

                                <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending">Consumer Name</th>

                                <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending">Quote Number</th>

                                <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending">Order Date</th>

                                <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending">Supplier</th>

                                <th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 171px;" aria-label="Donor's Name: activate to sort column ascending">Delivery Date</th>

                            </tr>

                            </thead>

                            <tbody>

                            @foreach($orders as $key)

                                <tr role="row" class="odd">
                                    <td>{{$key->company_name}}</td>
                                    <td>{{$key->quotation_invoice_number}}</td>
                                    <td>{{$key->order_date}}</td>
                                    <td>{{$key->name}}</td>
                                    <td>{{$key->approved ? $key->delivery_date : null}}</td>
                                </tr>

                            @endforeach

                            </tbody>

                        </table>

                        <div class="row" style="margin: 0 0 50px 0;">

                            <h3 style="text-align: center;">Quotes</h3>
                            <div id="chart-bar"></div>

                        </div>

                        <div class="row" style="margin: 0 0 50px 0;">

                            <h3 style="text-align: center;">Invoices</h3>
                            <div id="chart"></div>

                        </div>

                        <div class="donors-profile-top-bg overlay text-center wow fadeInUp"
                             style="background-image: url({{asset('assets/images/'.$gs->h_dashbg)}}); visibility: visible; animation-name: fadeInUp;z-index: auto;color: black;">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2 class="ut">{{$user->name}} {{$user->family_name}}</h2>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="donors-profile-wrap wow fadeInUp"
                             style="visibility: visible; animation-name: fadeInUp;">
                            <div class="container">

                                <div class="row">
                                    @include('includes.form-success')
                                    @if(count($errors) > 0)
                                        <div class="alert alert-danger validation">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">×</span></button>
                                            <ul class="text-left">
                                                @foreach($errors->all() as $error)
                                                    <li>{{$error}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="col-md-8">
                                        @if($user->status != 1)
                                            @if($user->active != 1)
                                                @if($user->featured != 1)
                                                    @if($gs->np == 0)

                                                        <div
                                                            class="profile-description-box margin-bottom-30 text-center">
                                                            <a href="{{route('user-publish')}}" class="boxed-btn blog"
                                                               style="width: 160px;">{{$lang->ppr}}</a>
                                                        </div>

                                                    @else
                                                        <div
                                                            class="profile-description-box margin-bottom-30 text-center">
                                                            <button class="boxed-btn blog" type="button"
                                                                    data-toggle="modal" data-target="#ModalAll"
                                                                    style="width: 160px;">{{$lang->ppr}}</button>
                                                        </div>
                                                    @endif
                                                @endif
                                            @endif

                                        @elseif($user->is_featured != 1)
                                            @if($user->featured != 1)
                                                @if($gs->fp == 0)
                                                    <div class="profile-description-box margin-bottom-30 text-center">
                                                        <a href="{{route('user-feature')}}" class="boxed-btn blog"
                                                           style="width: 160px;">{{$lang->fpr}}</a>
                                                    </div>

                                                @else

                                                    <div class="profile-description-box margin-bottom-30 text-center">
                                                        <button class="boxed-btn blog" type="button" data-toggle="modal"
                                                                data-target="#ModalFeature"
                                                                style="width: 160px;">{{$lang->fpr}}</button>
                                                    </div>
                                                @endif
                                            @endif
                                        @endif
                                        <div class="profile-description-box margin-bottom-30">
                                            <h2 class="ut">{{$lang->dopd}}</h2>
                                            <hr>
                                            <p>{!!$user->description!!}</p>
                                        </div>

                                        @if($user->special != null)
                                            <div class="other-description-box margin-bottom-30">
                                                <h2 class="ut">{{$lang->doo}}</h2>
                                                <hr>
                                                <div class="table-responsive" style="overflow: hidden;">
                                                    @php
                                                        $specials = explode(',', $user->special);
                                                    @endphp
                                                    <ul class="row">
                                                        @foreach($specials as $special)
                                                            <li class="col-md-6 col-sm-6">{{$special}}</li>

                                                        @endforeach
                                                    </ul>


                                                </div>
                                            </div>
                                        @endif

                                        <div class="other-description-box margin-bottom-30">
                                            <h2 class="ut">{{$lang->binfo}}</h2>
                                            <hr>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tbody>
                                                    <tr>
                                                        <th>{{$lang->dol}}</th>
                                                        <td>{{$user->language}}</td>
                                                    </tr>
                                                    {{--<tr>
                                                        <th>{{$lang->doa}}</th>
                                                        <td>{{$user->age}}</td>
                                                    </tr>--}}
                                                    <tr>
                                                        <th>{{$lang->doe}}</th>
                                                        <td>{{$user->education}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{$lang->dor}}</th>
                                                        <td>{{$user->residency}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>{{$lang->dopr}}</th>
                                                        <td>{{$user->profession}}</td>
                                                    </tr>

                                                    {{--<tr>
                                                        <th>{{$lang->jct}}</th>
                                                        <td>{{$no}}</td>
                                                    </tr>--}}

                                                    <tr>
                                                        <th>{{$lang->ratt}}</th>
                                                        <td>{{$user->rating}} <span class="fa fa-star checked"
                                                                                    style="margin-left: 5px;"></span>
                                                        </td>
                                                    </tr>

                                                    {{--<tr>
                                                        <th>{{$lang->et}}</th>
                                                        <td>@if($user->experience_years) {{$user->experience_years}} @if($user->experience_years > 1)
                                                                Years @else Year @endif @else N/A @endif</td>
                                                    </tr>--}}


                                                    </tbody>
                                                </table>
                                            </div>

                                            <div style="margin-top: 10px;">
                                                <h2>Leadprijs</h2>
                                                <p>De huidige commissie is {{$commission_percentage->commission_percentage}}% per afgesloten deal.</p>
                                            </div>
                                        </div>

                                        <style type="text/css">

                                            .checked {
                                                color: orange !important;
                                            }

                                            .container {
                                                width: 100% !important;
                                            }

                                        </style>

                                        <!--                         <div class="add-area margin-bottom-30">
                                                                    <img src="assets/img/add.jpg" alt="Ad. Image">
                                                                </div> -->

                                    </div>
                                    <div class="col-md-4">
                                        <div class="profile-right-side">

                                            <div class="profile-img">
                                                <img width="130px" height="90px" id="adminimg"
                                                     src="{{ $user->photo ? asset('assets/images/'.$user->photo):"https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG"}}"
                                                     alt="" id="adminimg">
                                            </div>

                                            <div class="profile-contact-info" style="margin-top: 40px;">
                                                <h2>{{$lang->doci}}</h2>
                                                <hr>

                                                <p><i class="fa fa-home fa-1x"></i>&nbsp;{{$user->address}}</p>
                                                @if($user->fax != null)
                                                    <p><i class="fa fa-fax fa-1x"></i>&nbsp;{{$user->fax}}</p>
                                                @endif
                                                <p><i class="fa fa-phone fa-1x"></i>&nbsp;{{$user->phone}}</p>
                                                <p><i class="fa fa-envelope fa-1x"></i>&nbsp;{{$user->email}}</p>
                                                @if($user->web != null)
                                                    <p><i class="fa fa-globe fa-1x"></i>&nbsp;{{$user->web}}</p>
                                                @endif
                                            </div>

                                            <div class="share-profile-info" style="margin-top: 40px;">
                                                <h2>{{$lang->dosp}}</h2>
                                                <hr>
                                                <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                                    <a class="a2a_dd" href=""></a>
                                                    <a class="a2a_button_facebook" href=""></a>
                                                    <a class="a2a_button_twitter" href=""></a>
                                                    <a class="a2a_button_google_plus" href=""></a>
                                                    <a class="a2a_button_linkedin" href=""></a>
                                                </div>
                                                <script async src="https://static.addtoany.com/menu/page.js"></script>
                                            </div>
                                            <hr>
                                            <div class="add-area margin-bottom-30">
                                                <iframe
                                                    width="340"
                                                    height="350"
                                                    frameborder="0" style="border:0"
                                                    src="https://www.google.com/maps/embed/v1/place?key={{$gs->map_key}}&q={{$user->address == null ? '@':$user->address}}"
                                                    allowfullscreen>
                                                </iframe>
                                            </div>
                                            <!--                             <div class="add-area">
                                                                        <img src="assets/img/ad1.jpg" alt="Ad. Image">
                                                                    </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <!-- Modal -->
                        <div class="modal fade-scale" id="ModalAll" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Publish Your Profile</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <h4 id="cost" class="cost"></h4>
                                                <h4>Select Premium Features</h4>
                                                <form class="paypal" action="{{route('payment.submit')}}" method="post"
                                                      id="payment_form">
                                                    {{csrf_field()}}
                                                    <input type="hidden" name="cmd" value="_xclick"/>
                                                    <input type="hidden" name="no_note" value="1"/>
                                                    <input type="hidden" name="lc" value="UK"/>
                                                    <input type="hidden" name="currency_code" value="USD"/>
                                                    <input type="hidden" name="bn"
                                                           value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest"/>
                                                    <div class="form-group col-md-8 col-md-offset-2">
                                                        <select name="featured" class="form-control" id="opt" required>
                                                            <option value="">Select Option</option>
                                                            <option value="no">Normal Profile</option>
                                                            <option value="yes">Featured Profile</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-8 col-md-offset-2">
                                                        <select class="form-control" onChange="meThods(this)"
                                                                id="formac" name="method" required>
                                                            <option value="Paypal" selected>Paypal</option>
                                                            <option value="Stripe">Credit Card</option>
                                                        </select>
                                                    </div>
                                                    <input type="hidden" name="userid" value="{{$user->id}}"/>

                                                    <div id="stripes" class="col-md-8 col-md-offset-2"
                                                         style="display: none;">
                                                        <img class="pull-right"
                                                             src="{{url('/assets/images')}}/creditcards.png">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="card"
                                                                   placeholder="Card">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="cvv"
                                                                   placeholder="Cvv">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="month"
                                                                   placeholder="Month">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="year"
                                                                   placeholder="Year">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <input type="submit" name="submit" id="pay"
                                                               class="boxed-btn blog" value="Pay Now"/>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <!-- Modal -->
                        <div class="modal fade-scale" id="ModalFeature" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Feature Your Profile</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <h4>Make Your Profile Featured</h4>
                                                <h4 class="cost">Total Cost: {{$gs->fp}}$</h4>
                                                <form class="paypal" action="{{route('payment.submit')}}" method="post"
                                                      id="payment_form2">
                                                    {{csrf_field()}}

                                                    <div class="form-group col-md-8 col-md-offset-2">
                                                        <select class="form-control" onChange="meThods2(this)"
                                                                id="formac" name="method" required>
                                                            <option value="Paypal" selected>Paypal</option>
                                                            <option value="Stripe">Credit Card</option>
                                                        </select>
                                                    </div>
                                                    <input type="hidden" name="cmd" value="_xclick"/>
                                                    <input type="hidden" name="no_note" value="1"/>
                                                    <input type="hidden" name="lc" value="UK"/>
                                                    <input type="hidden" name="currency_code" value="USD"/>
                                                    <input type="hidden" name="bn"
                                                           value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest"/>
                                                    <input type="hidden" name="featured" value="yes"/>
                                                    <input type="hidden" name="userid" value="{{$user->id}}"/>

                                                    <div id="stripes2" class="col-md-8 col-md-offset-2"
                                                         style="display: none;">
                                                        <img class="pull-right"
                                                             src="{{url('/assets/images')}}/creditcards.png">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="card"
                                                                   placeholder="Card">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="cvv"
                                                                   placeholder="Cvv">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="month"
                                                                   placeholder="Month">
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="year"
                                                                   placeholder="Year">
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <input type="submit" name="submit" id="pay2"
                                                               class="boxed-btn blog" value="Pay Now"/>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- Ending of Dashboard Top reference + Most Used OS area -->

                </div>
            </div>
        </div>
    </div>


    <style>

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

        $('#example').DataTable({
            order: [[0, 'desc']],
            searching: false, paging: false, info: false
        });

        var chart = c3.generate({
            bindto: '#chart-bar',
            data: {
                type: 'bar',
                json:  <?php echo $quotes_chart; ?>,
                keys: {
                    x: 'date',
                    value: ['Quotes','Accepted'],
                }
            },
            axis: {
                x: {
                    type: 'timeseries',
                    tick: {
                        format: function(time) {
                            var dat = new Date(time);
                            var _months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"];
                            var month = dat.getMonth();
                            return _months[month];
                        }
                    },
                },
                y: {
                    tick: {
                        format: function (d) {
                            return '€ ' + d;
                        },
                        width: 0
                    }
                }
            },
            bar: {
                width: {
                    ratio: 0.5 // this makes bar width 50% of length between ticks
                }
                // or
                //width: 100 // this makes bar width 100px
            }
        });

        var chart = c3.generate({
            bindto: '#chart',
            data: {
                type: 'bar',
                json:  <?php echo $invoices_chart; ?>,
                keys: {
                    x: 'date',
                    value: ['Invoices Total'],
                }
            },
            axis: {
                x: {
                    type: 'timeseries',
                    tick: {
                        format: function(time) {
                            var dat = new Date(time);
                            var _months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sept", "Oct", "Nov", "Dec"];
                            var month = dat.getMonth();
                            return _months[month];
                        }
                    },
                },
                y: {
                    padding: {
                        bottom: 0,
                        top: 0
                    },
                    tick: {
                        format: function (d) {
                            return '€ ' + d;
                        },
                        width: 0
                    }
                }
            }
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
