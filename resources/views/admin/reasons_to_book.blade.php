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
                                            <h2>Reasons To Book</h2>  
                                        </div>
                                        <hr>
                                        <form class="form-horizontal" action="{{route('admin-reasons-to-book-update')}}" method="POST">
                                         @include('includes.form-success')      
                                        {{csrf_field()}}

                                         <div class="form-group">
                                            <label class="control-label col-sm-3" for="English Heading 1">English Heading 1 *</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="heading1" id="heading1" placeholder="English Heading 1" required="" type="text" value="{{$data->heading1}}">
                                            </div>
                                            
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-3" for="English Description 1">English Description 1</label>
                                            <div class="col-sm-6">
                                              <textarea class="form-control" name="desc1" id="desc1" placeholder="English Description 1" style="resize: vertical;" rows="8">{{$data->desc1}}</textarea>
                                            </div>
                                            
                                          </div>


                                          <div class="form-group">
                                            <label class="control-label col-sm-3" for="English Heading 2">English Heading 2 *</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="heading2" id="heading2" placeholder="English Heading 2" required="" type="text" value="{{$data->heading2}}">
                                            </div>
                                            
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-3" for="English Description 2">English Description 2</label>
                                            <div class="col-sm-6">
                                              <textarea class="form-control" name="desc2" id="desc2" placeholder="English Description 2" style="resize: vertical;" rows="8">{{$data->desc2}}</textarea>
                                            </div>
                                            
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-3" for="English Heading 3">English Heading 3 *</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="heading3" id="heading3" placeholder="English Heading 3" required="" type="text" value="{{$data->heading3}}">
                                            </div>
                                            
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-3" for="English Description 3">English Description 3</label>
                                            <div class="col-sm-6">
                                              <textarea class="form-control" name="desc3" id="desc3" placeholder="English Description 3" style="resize: vertical;" rows="8">{{$data->desc3}}</textarea>
                                            </div>
                                            
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-3" for="Dutch Heading 1">Dutch Heading 1 *</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="dh1" id="dh1" placeholder="Dutch Heading 1" required="" type="text" value="{{$data->dh1}}">
                                            </div>
                                            
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-3" for="Dutch Description 1">Dutch Description 1</label>
                                            <div class="col-sm-6">
                                              <textarea class="form-control" name="dd1" id="dd1" placeholder="Dutch Description 1" style="resize: vertical;" rows="8">{{$data->dd1}}</textarea>
                                            </div>
                                            
                                          </div>


                                          <div class="form-group">
                                            <label class="control-label col-sm-3" for="Dutch Heading 2">Dutch Heading 2 *</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="dh2" id="dh2" placeholder="Dutch Heading 2" required="" type="text" value="{{$data->dh2}}">
                                            </div>
                                            
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-3" for="Dutch Description 2">Dutch Description 2</label>
                                            <div class="col-sm-6">
                                              <textarea class="form-control" name="dd2" id="dd2" placeholder="Dutch Description 2" style="resize: vertical;" rows="8">{{$data->dd2}}</textarea>
                                            </div>
                                            
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-3" for="Dutch Heading 3">Dutch Heading 3 *</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="dh3" id="dh3" placeholder="Dutch Heading 3" required="" type="text" value="{{$data->dh3}}">
                                            </div>
                                            
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-3" for="Dutch Description 3">Dutch Description 3</label>
                                            <div class="col-sm-6">
                                              <textarea class="form-control" name="dd3" id="dd3" placeholder="Dutch Description 3" style="resize: vertical;" rows="8">{{$data->dd3}}</textarea>
                                            </div>
                                            
                                          </div>

                                          
                                          <hr>
                                            <div class="add-product-footer">
                                                <button name="addProduct_btn" type="submit" class="btn add-product_btn">Update</button>   
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