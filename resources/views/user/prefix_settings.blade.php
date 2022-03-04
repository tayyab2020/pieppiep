@extends('layouts.handyman')

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
                                        <h2>Prefix Settings</h2>
                                    </div>
                                    
                                    <hr>

                                    <form class="form-horizontal" action="{{route('save-prefix-settings')}}" method="POST" enctype="multipart/form-data">

                                        @include('includes.form-error')
                                        @include('includes.form-success')

                                        {{csrf_field()}}

                                        <input type="hidden" name="user_id" value="{{$user->id}}"/>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_display_name">Quotation Prefix</label>
                                            <div class="col-sm-6">
                                                <input value="{{$user->quotation_prefix}}" class="form-control" name="quotation_prefix" placeholder="Enter Quotation Prefix" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">Quotation Number Length</label>
                                            <div class="col-sm-6">

                                                <select class="form-control" name="quotation_length">

                                                    <option {{$user->quotation_length == 1 ? 'selected' : null}} value="1">1</option>
                                                    <option {{$user->quotation_length == 2 ? 'selected' : null}} value="2">2</option>
                                                    <option {{$user->quotation_length == 3 ? 'selected' : null}} value="3">3</option>
                                                    <option {{$user->quotation_length == 4 ? 'selected' : null}} value="4">4</option>
                                                    <option {{$user->quotation_length == 5 ? 'selected' : null}} value="5">5</option>
                                                    <option {{$user->quotation_length == 6 ? 'selected' : null}} value="6">6</option>
                                                    <option {{$user->quotation_length == 7 ? 'selected' : null}} value="7">7</option>
                                                    <option {{$user->quotation_length == 8 ? 'selected' : null}} value="8">8</option>
                                                    <option {{$user->quotation_length == 9 ? 'selected' : null}} value="9">9</option>
                                                    <option {{$user->quotation_length == 10 ? 'selected' : null}} value="10">10</option>

                                                </select>
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_display_name">Order Prefix</label>
                                            <div class="col-sm-6">
                                                <input value="{{$user->order_prefix}}" class="form-control" name="order_prefix" placeholder="Enter Order Prefix" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">Order Number Length</label>
                                            <div class="col-sm-6">

                                                <select class="form-control" name="order_length">

                                                    <option {{$user->order_length == 1 ? 'selected' : null}} value="1">1</option>
                                                    <option {{$user->order_length == 2 ? 'selected' : null}} value="2">2</option>
                                                    <option {{$user->order_length == 3 ? 'selected' : null}} value="3">3</option>
                                                    <option {{$user->order_length == 4 ? 'selected' : null}} value="4">4</option>
                                                    <option {{$user->order_length == 5 ? 'selected' : null}} value="5">5</option>
                                                    <option {{$user->order_length == 6 ? 'selected' : null}} value="6">6</option>
                                                    <option {{$user->order_length == 7 ? 'selected' : null}} value="7">7</option>
                                                    <option {{$user->order_length == 8 ? 'selected' : null}} value="8">8</option>
                                                    <option {{$user->order_length == 9 ? 'selected' : null}} value="9">9</option>
                                                    <option {{$user->order_length == 10 ? 'selected' : null}} value="10">10</option>

                                                </select>
                                                
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_display_name">Invoice Prefix</label>
                                            <div class="col-sm-6">
                                                <input value="{{$user->invoice_prefix}}" class="form-control" name="invoice_prefix" placeholder="Enter Invoice Prefix" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">Invoice Number Length</label>
                                            <div class="col-sm-6">

                                                <select class="form-control" name="invoice_length">

                                                    <option {{$user->invoice_length == 1 ? 'selected' : null}} value="1">1</option>
                                                    <option {{$user->invoice_length == 2 ? 'selected' : null}} value="2">2</option>
                                                    <option {{$user->invoice_length == 3 ? 'selected' : null}} value="3">3</option>
                                                    <option {{$user->invoice_length == 4 ? 'selected' : null}} value="4">4</option>
                                                    <option {{$user->invoice_length == 5 ? 'selected' : null}} value="5">5</option>
                                                    <option {{$user->invoice_length == 6 ? 'selected' : null}} value="6">6</option>
                                                    <option {{$user->invoice_length == 7 ? 'selected' : null}} value="7">7</option>
                                                    <option {{$user->invoice_length == 8 ? 'selected' : null}} value="8">8</option>
                                                    <option {{$user->invoice_length == 9 ? 'selected' : null}} value="9">9</option>
                                                    <option {{$user->invoice_length == 10 ? 'selected' : null}} value="10">10</option>

                                                </select>
                                                
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="add-product-footer">
                                            <button name="addProduct_btn" type="submit" class="btn add-product_btn">Save</button>
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

    <style type="text/css">

        .swal2-show {
            padding: 40px;
            width: 30%;

        }

        .swal2-header {
            font-size: 23px;
        }

        .swal2-content {
            font-size: 18px;
        }

        .swal2-actions {
            font-size: 16px;
        }

    </style>
