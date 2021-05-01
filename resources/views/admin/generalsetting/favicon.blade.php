@extends('layouts.admin')

@section('content')
<div class="right-side">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <!-- Starting of Dashboard Website Logo -->
                        <div class="section-padding add-product-1">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="add-product-box">
                                        <div class="add-product-header">
                                            <h2>Website Icon</h2> 
                                        </div>
                                        <hr>
                                        <form class="form-horizontal" action="{{route('admin-gs-favup')}}" method="POST" enctype="multipart/form-data">
                                            @include('includes.form-error')
                                            @include('includes.form-success')      
                                          {{csrf_field()}}
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="current_logo">Current Favicon</label>
                                            <div class="col-sm-6">
                                        <img id="adminimg" src="{{asset('assets/images/'.$data->favicon)}}" alt="No Icon Found" id="adminimg">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="setup_new_logo">Setup New Icon *</label>
                                            <div class="col-sm-6">
                                              <input  type="file" name="favicon">
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
                    <!-- Ending of Dashboard Website Logo -->
                </div>
            </div>
        </div>
    </div>
@endsection