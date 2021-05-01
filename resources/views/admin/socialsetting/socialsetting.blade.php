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
                                            <h2>Social Links</h2>  
                                        </div>
                                        <hr>
                                        <form class="form-horizontal" action="{{route('admin-social-update')}}" method="POST">
                                         @include('includes.form-success')      
                                        {{csrf_field()}}

                                         <div class="form-group">
                                            <label class="control-label col-sm-3" for="ADmin Email">Admin Email Address *</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="admin_email" id="admin_email" placeholder="Admin Email Address" required="" type="email" value="{{$socialdata->admin_email}}">
                                            </div>
                                            
                                          </div>


                                          <div class="form-group">
                                            <label class="control-label col-sm-3" for="facebook">Facebook *</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="facebook" id="facebook" placeholder="http://facebook.com/" required="" type="text" value="{{$socialdata->facebook}}">
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="switch">
                                                  <input type="checkbox" name="f_status" value="1" {{$socialdata->f_status==1?"checked":""}}>
                                                  <span class="slider round"></span>
                                                </label>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-3" for="google-Plus">Google Plus *</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="gplus" id="google-Plus" placeholder="http://google.com/" required="" type="text" value="{{$socialdata->gplus}}">
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="switch">
                                                  <input type="checkbox" name="g_status" value="1" {{$socialdata->g_status==1?"checked":""}}>
                                                  <span class="slider round"></span>
                                                </label>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-3" for="twiter">Twiter *</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="twitter" id="twiter" placeholder="http://twitter.com/" required="" type="text" value="{{$socialdata->twitter}}">
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="switch">
                                                  <input type="checkbox" name="t_status" value="1" {{$socialdata->t_status==1?"checked":""}}>
                                                  <span class="slider round"></span>
                                                </label>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-3" for="linkedin">Linkedin *</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="linkedin" id="linkedin" placeholder="http://linkedin.com/" required="" type="text" value="{{$socialdata->linkedin}}">
                                            </div>
                                            <div class="col-sm-3">
                                                <label class="switch">
                                                  <input type="checkbox" name="l_status" value="1" {{$socialdata->l_status==1?"checked":""}}>
                                                  <span class="slider round"></span>
                                                </label>
                                            </div>
                                          </div>
                                          <hr>
                                            <div class="add-product-footer">
                                                <button name="addProduct_btn" type="submit" class="btn add-product_btn">Update Social Settings</button>   
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