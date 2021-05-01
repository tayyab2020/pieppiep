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
                                            <h2>Office Address</h2> 
                                        </div>
                                        <hr>
                                        <form class="form-horizontal" action="{{route('admin-gs-addressup')}}" method="POST">
                                        @include('includes.form-success')      
                                          {{csrf_field()}}
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="street_address">Street Address *</label>
                                            <div class="col-sm-6">
                                              <textarea name="street" id="street_address" class="form-control" rows="5" placeholder="Enter Street Address" style="resize: vertical;">{{$data->street}}</textarea>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="phone">Phone *</label>
                                            <div class="col-sm-6">
                                              <input name="phone" id="phone" class="form-control" placeholder="Enter Phone" type="text" value="{{$data->phone}}">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="fax">Fax *</label>
                                            <div class="col-sm-6">
                                              <input name="fax" id="fax" class="form-control" placeholder="Enter Fax" type="text" value="{{$data->fax}}">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="email">Email *</label>
                                            <div class="col-sm-6">
                                              <input name="email" id="email" class="form-control" placeholder="Enter Email"  type="email" value="{{$data->email}}">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="site">Website *</label>
                                            <div class="col-sm-6">
                                              <input name="site" id="site" class="form-control" placeholder="Enter Website" type="text" value="{{$data->site}}">
                                            </div>
                                          </div>
                                            <hr>
                                            <div class="add-product-footer">
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
@section('scripts')
<script type="text/javascript" src="{{asset('assets/admin/js/nicEdit.js')}}"></script> 
<script type="text/javascript">
//<![CDATA[
        bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
  //]]>
</script>
@endsection