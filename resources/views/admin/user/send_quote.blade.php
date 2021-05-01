@extends('layouts.admin')

@section('content')
    <div class="right-side">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- Starting of Dashboard area -->
                    <div class="section-padding add-product-1">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div style="box-shadow: none;" class="add-product-box">
                                    <div class="add-product-header">
                                        <h2>Send Quote Request</h2>
                                        <a href="{{route('quotation-requests')}}" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> Back</a>
                                    </div>
                                    <hr>
                                    <form class="form-horizontal" id="handyman_form" action="{{route('send-quote-request')}}" method="POST" enctype="multipart/form-data">

                                        @include('includes.form-error')
                                        @include('includes.form-success')

                                        {{csrf_field()}}

                                        <input type="hidden" name="quote_id" value="{{$request->id}}">


                                        <div class="form-group" style="margin: 0;">
                                            <div style="text-align: center;">
                                                @if($request->quote_service != 0 && $request->quote_brand != 0 && $request->quote_model != 0)

                                                    <p style="text-align: center;font-size: 20px;" class="form-control"><b>Category:</b> {{$request->cat_name}}</p>
                                                    <p style="text-align: center;font-size: 20px;" class="form-control"><b>Brand:</b> {{$request->brand_name}}</p>
                                                    <p style="text-align: center;font-size: 20px;" class="form-control"><b>Model:</b> {{$request->model_name}}</p>

                                                @else

                                                    <p style="text-align: center;font-size: 20px;" class="form-control"><b>Service:</b> {{$request->title}}</p>

                                                @endif
                                            </div>
                                        </div>

                                        @if(count($handymen) > 0)

                                        <div class="form-group" style="margin: 30px 0px;overflow-y: auto;">

                                            <table class="handyman_table" style="margin: auto;display: table;text-align: center;">

                                                <thead>
                                                <th>Action</th>
                                                <th>Company</th>
                                                <th>Radius</th>
                                                {{--<th>Address</th>--}}
                                                <th>Postcode</th>
                                                </thead>

                                                <tbody>
                                                @foreach($handymen as $i => $key)

                                                <tr @if($key->preferred) style="background: #ccffcc;" @endif>
                                                <td><input type="checkbox" name="action[]" value="{{$key->id}}" class="action"></td>
                                                <td>{{$key->company_name}} @if($key->preferred) <br> <span class="btn btn-info" style="margin-top: 7px;background-color: #5bc0de !important;border-color: #46b8da !important;">Preferred</span> @endif</td>
                                                <td><?php echo number_format((float)$key->distance, 2, '.', ''); ?> KM</td>
                                                {{--<td>{{$key->address}}</td>--}}
                                                <td>{{$key->zipcode}}</td>
                                                </tr>

                                                @endforeach

                                                </tbody>

                                            </table>

                                        </div>

                                            <div class="add-product-footer">
                                                <button type="button" style="outline: none;" class="btn add-product_btn submit_btn">Send</button>
                                            </div>

                                        @endif

                                    </form>
                                </div>

                                    <div class="form-group" style="margin: 30px 0px;overflow-y: auto;">

                                        <h3 style="text-align: center;margin-bottom: 30px;">History</h3>

                                        <table style="margin: auto;display: table;text-align: center;">

                                            <thead>
                                            <th style="text-align: center;">ID</th>
                                            <th style="text-align: center;width: 300px;">Name</th>
                                            <th style="text-align: center;">Date</th>
                                            </thead>

                                            <tbody>

                                            @if(count($history)>0)

                                            @foreach($history as $i => $key)

                                                <?php $date = strtotime($key->quote_date);

                                                $date = date('d-m-Y',$date);  ?>

                                                <tr>
                                                    <td>{{$i+1}}</td>
                                                    <td>{{$key->company_name}}</td>
                                                    <td>{{$date}}</td>
                                                </tr>

                                            @endforeach

                                            @else

                                                <tr>
                                                    <td colspan="3">No Records Found</td>
                                                </tr>

                                            @endif
                                            </tbody>

                                        </table>

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

<style type="text/css">

    tr{cursor: pointer;}

    td,th{
        padding: 20px !important;
        border: 1px solid lightgrey;
    }

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
        font-size: 22px !important;
    }

    .swal2-actions
    {
        font-size: 16px;
    }


</style>

@section('scripts')

    <script type="text/javascript" src="{{asset('assets/admin/js/nicEdit.js')}}"></script>
    <script type="text/javascript">
        //<![CDATA[
        bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
        //]]>
    </script>

    <script>
        $(document).ready(function() {

            $('.submit_btn').click(function(event) {

                if($('.action:checked').length == 0)
                {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'You have to select atleast one handyman!',
                    });
                }
                else
                {
                    $('#handyman_form').submit();
                }

            });


            $('.handyman_table tr').click(function(event) {
                if (event.target.type !== 'checkbox') {
                    $(':checkbox', this).trigger('click');
                }
            });

        });
    </script>


    <script src="{{asset('assets/admin/js/jquery152.min.js')}}"></script>
    <script src="{{asset('assets/admin/js/jqueryui.min.js')}}"></script>

@endsection
