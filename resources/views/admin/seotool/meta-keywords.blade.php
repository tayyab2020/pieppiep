@extends('layouts.admin')

@section('content')
<div class="right-side">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <!-- Starting of Dashboard Meta Keywords Page -->
                        <div class="section-padding add-product-1">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="add-product-box">
                                        <div class="add-product-header">
                                            <h2>Meta Keywords</h2> 
                                        </div>
                                        <hr>
                                        <form class="form-horizontal" action="{{route('admin-seotool-keywords-update')}}" method="POST">
                                         @include('includes.form-success')      
                                        {{csrf_field()}}
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="website_meta_keywords">Website Meta Keywords *</label>
                                            <div class="col-sm-6">
                                              <textarea name="meta_keys" id="website_meta_keywords" class="form-control" rows="5" style="resize: vertical;" placeholder="Enter Website Meta Keywords" required="">{{$tool->meta_keys}}</textarea>
                                            </div>
                                          </div>
                                            <hr>
                                            <div class="add-product-footer">
                                                <button name="addProduct_btn" type="submit" class="btn add-product_btn">Update Meta Keywords</button>
                                        
                                    </div></form>
                                </div>
                        </div>
                    </div>
                    <!-- Ending of Dashboard Meta Keywords Page --> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection