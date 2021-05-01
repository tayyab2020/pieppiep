@extends('layouts.admin')

@section('content')
<div class="right-side">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <!-- Starting of Dashboard Social Links area -->
                        <div class="section-padding add-product-1">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="add-product-box">
                                        <div class="add-product-header">
                                            <h2>Filter Settings</h2>  
                                        </div>
                                        <hr>
                                        <form class="form-horizontal" action="{{route('admin-filter-update')}}" method="POST">
                                         @include('includes.form-success')      
                                        {{csrf_field()}}

                                          <div class="form-group">
                                            <label class="control-label col-sm-6" for="Insurance">Insurance</label>
                                            
                                            <div class="col-sm-3">
                                                <label class="switch">
                                                  <input type="checkbox" name="ins" value="1" {{$socialdata->ins==1?"checked":""}}>
                                                  <span class="slider round"></span>
                                                </label>
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-6" for="Rating">Rating</label>
                                            
                                            <div class="col-sm-3">
                                                <label class="switch">
                                                  <input type="checkbox" name="rat" value="1" {{$socialdata->rat==1?"checked":""}}>
                                                  <span class="slider round"></span>
                                                </label>
                                            </div>
                                          </div>


                                          <div class="form-group">
                                            <label class="control-label col-sm-6" for="Price Range">Price Range</label>
                                            
                                            <div class="col-sm-3">
                                                <label class="switch">
                                                  <input type="checkbox" name="pr" value="1" {{$socialdata->pr==1?"checked":""}}>
                                                  <span class="slider round"></span>
                                                </label>
                                            </div>
                                          </div>


                                          <div class="form-group">
                                            <label class="control-label col-sm-6" for="Experience Years">Experience Years</label>
                                            
                                            <div class="col-sm-3">
                                                <label class="switch">
                                                  <input type="checkbox" name="ey" value="1" {{$socialdata->ey==1?"checked":""}}>
                                                  <span class="slider round"></span>
                                                </label>
                                            </div>
                                          </div>
                                          <hr>
                                            <div class="add-product-footer">
                                                <button name="addProduct_btn" type="submit" class="btn add-product_btn">Update Filter Settings</button>   
                                            </div>
                                        </form>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <!-- Ending of Dashboard Social Links area --> 
                </div>
            </div>
        </div>
    </div>
@endsection