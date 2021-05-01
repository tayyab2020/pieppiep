@extends('layouts.admin')

@section('content')
<div class="right-side">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <!-- Starting of Dashboard Office Address -->
                        <div class="section-padding add-product-1">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="add-product-box">
                                        <div class="add-product-header">
                                            <h2>Payment Informations</h2>
                                        </div>
                                        <hr>
                                        <form class="form-horizontal" action="{{route('admin-gs-paymentsup')}}" method="POST">
                                        @include('includes.form-success')
                                          {{csrf_field()}}

                                          <div class="form-group" style="display:none;">
                                            <label class="control-label col-sm-4" for="phone">Paypal Business Email  *</label>
                                            <div class="col-sm-6">
                                              <input name="pb" id="phone" class="form-control" placeholder="Enter Paypal Business Email" type="text" value="{{$data->pb}}">
                                            </div>
                                          </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="key">Mollie API Key *</label>
                                                <div class="col-sm-6">
                                                    <input name="mollie" id="mollie" class="form-control" placeholder="Enter Mollie API Key" type="text" value="{{$data->mollie}}">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="fee">Service Fee *</label>
                                                <div class="col-sm-6">
                                                    <input name="service_fee" id="service_fee" class="form-control" placeholder="Enter service fee" type="number" value="{{$data->service_fee}}" required="" style="width: 94%;float: left;">
                                                    <div style="padding: 10px;display: inline-block;width: 6%;height: 40px;border: 1px solid #ccc;text-align: center;cursor: not-allowed;">€</div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="min">Min Amount</label>
                                                <div class="col-sm-6">
                                                    <input name="min_amount" id="min_amount" class="form-control" placeholder="Enter min amount for order" type="number" value="{{$data->min_amount}}"  style="width: 94%;float: left;">
                                                    <div style="padding: 10px;display: inline-block;width: 6%;height: 40px;border: 1px solid #ccc;text-align: center;cursor: not-allowed;">€</div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="reg">Registration Fee *</label>
                                                <div class="col-sm-6">
                                                    <input name="registration_fee" id="registration_fee" class="form-control" placeholder="Enter registration fee" type="text" value="{{$data->registration_fee}}"  style="width: 94%;float: left;" required pattern="^[0-9]+,?[0-9]+$">
                                                    <div style="padding: 10px;display: inline-block;width: 6%;height: 40px;border: 1px solid #ccc;text-align: center;cursor: not-allowed;">€</div>
                                                </div>
                                            </div>

                                            {{--<div class="form-group">
                                                <label class="control-label col-sm-4" for="vat">VAT % *</label>
                                                <div class="col-sm-6">
                                                    <input name="vat" id="vat" class="form-control" placeholder="Enter VAT" type="number" value="{{$data->vat}}" required="" style="width: 94%;float: left;">

                                                    <div style="padding: 10px;display: inline-block;width: 6%;height: 40px;border: 1px solid #ccc;text-align: center;cursor: not-allowed;">%</div>
                                                </div>
                                            </div>--}}

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="vat">Commission Percentage % *</label>
                                                <div class="col-sm-6">
                                                    <input name="commission_percentage" id="commission_percentage" class="form-control" placeholder="Enter Commission Percentage" type="number" value="{{$data->commission_percentage}}" required="" style="width: 94%;float: left;">

                                                    <div style="padding: 10px;display: inline-block;width: 6%;height: 40px;border: 1px solid #ccc;text-align: center;cursor: not-allowed;">%</div>
                                                </div>
                                            </div>

                                            <div class="api-button" style="text-align: center">
                                                <a href="{{ route('payment-mollie') }}" class="btn add-product_btn" style="color: white;background-color: black;">Test your api key</a>
                                            </div>

                                          <div class="form-group" style="display:none;">
                                            <label class="control-label col-sm-4" for="phone">Stripe Key  *</label>
                                            <div class="col-sm-6">
                                              <input name="sk" id="phone" class="form-control" placeholder="Enter Stripe Key" type="text" value="{{$data->sk}}">
                                            </div>
                                          </div>
                                          <div class="form-group" style="display:none;">
                                            <label class="control-label col-sm-4" for="phone">Stripe Secret Key  *</label>
                                            <div class="col-sm-6">
                                              <input name="ss" id="phone" class="form-control" placeholder="Enter Stripe Secret Key" type="text" value="{{$data->ss}}">
                                            </div>
                                          </div>
                                          <div class="form-group" style="display:none;">
                                            <label class="control-label col-sm-4" for="phone">Normal Profile Price  *</label>
                                            <div class="col-sm-6">
                                              <input name="np" id="phone" class="form-control" placeholder="Enter Normal Profile Price" type="text" value="{{$data->np}}" required="">
                                            </div>
                                          </div>
                                          <div class="form-group" style="display:none;">
                                            <label class="control-label col-sm-4" for="phone">Featured Profile Price  *</label>
                                            <div class="col-sm-6">
                                              <input name="fp" id="phone" class="form-control" placeholder="Enter Featured Profile Price" type="text" value="{{$data->fp}}" required="">
                                            </div>
                                          </div>
                                            <hr>
                                            <div class="add-product-footer" style="margin-top: 50px;">
                                                <button name="addProduct_btn" type="submit" class="btn add-product_btn">Update Setting</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <!-- Ending of Dashboard Office Address -->
                </div>
            </div>
        </div>
    </div>
@endsection
