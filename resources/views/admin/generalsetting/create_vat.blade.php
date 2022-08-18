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
                                        <h2>Vat Information</h2>
                                    </div>
                                    <hr>
                                    <form class="form-horizontal" action="{{route('admin-gs-vatsup')}}" method="POST">
                                        @include('includes.form-success')
                                        {{csrf_field()}}

                                        <input type="hidden" name="vat_id" value="{{ isset($data) ? $data->id : '' }}">

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="phone">{{__('text.VAT Percentage')}} *</label>
                                            <div class="col-sm-6">
                                                <input style="width: 94%;float: left;" value="{{ isset($data) ? $data->vat_percentage : '' }}" name="vat_percentage" id="vat_percentage" class="form-control" placeholder="Enter VAT %" type="number" required>
                                                <div style="padding: 10px;display: inline-block;width: 6%;height: 40px;border: 1px solid #ccc;text-align: center;cursor: not-allowed;">%</div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="key">VAT Rule *</label>
                                            <div class="col-sm-6">
                                                <input value="{{ isset($data) ? $data->rule : '' }}" name="rule" id="rule" class="form-control" placeholder="Enter VAT Rule" type="text" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="fee">VAT Code *</label>
                                            <div class="col-sm-6">
                                                <input value="{{ isset($data) ? $data->code : '' }}" name="code" id="code" class="form-control" placeholder="Enter VAT Code" type="text" required="">
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="add-product-footer" style="margin-top: 50px;">
                                            <button name="addProduct_btn" type="submit" class="btn add-product_btn">{{ isset($data) ? 'Update' : 'Submit' }}</button>
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
