@extends('layouts.admin')

@section('content')
<div class="right-side">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <!-- Starting of Dashboard Contact Page Content -->
                        <div class="section-padding add-product-1">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="add-product-box">
                                        <div class="add-product-header">
                                            <h2>Contact Page Content</h2> 
                                        </div>
                                        <hr>
                                        <form class="form-horizontal" action="{{route('admin-ps-contact-submit')}}" method="POST">
                                         @include('includes.form-success')      
                                        {{csrf_field()}}
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="disable/enable_contact_page">Disable/Enable Contact Page *</label>
                                            <div class="col-sm-3">
                                                <label class="switch">
                                                  <input type="checkbox" name="c_status" value="1" {{$pagedata->c_status==1?"checked":""}}>
                                                  <span class="slider round"></span>
                                                </label>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Contact Title *</label>
                                            <div class="col-sm-6">
                                              <input id="contact_form_success_text" class="form-control" type="text" name="contact_title" placeholder="Title" value="{{$pagedata->contact_title}}">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_us_email_address">Contact Descrition *</label>
                                            <div class="col-sm-6">
                                              <textarea name="contact_text" id="contact_us_email_address" class="form-control" style="resize: vertical;" rows="5" placeholder="Enter Contact Us Page Description">{{$pagedata->contact_text}}</textarea>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Contact Form Success Text *</label>
                                            <div class="col-sm-6">
                                              <textarea name="contact_success" id="contact_form_success_text" class="form-control" style="resize: vertical;" rows="5" placeholder="Enter Contact Form Success Text">{{$pagedata->contact_success}}</textarea>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_us_email_address">Contact Us Email Address * <span>Separate by Comma(,) for Multiple Email</span></label>
                                            <div class="col-sm-6">
                                              <textarea name="contact_email" id="contact_us_email_address" class="form-control" style="resize: vertical;" rows="5" placeholder="Enter Contact Us Email Address">{{$pagedata->contact_email}}</textarea>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_form_success_text">Contact Form Success Text *</label>
                                            <div class="col-sm-6">
                                              <textarea name="contact_success" id="contact_form_success_text" class="form-control" style="resize: vertical;" rows="5" placeholder="Enter Contact Form Success Text">{{$pagedata->contact_success}}</textarea>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="contact_us_email_address">Contact Us Email Address * <span>Separate by Comma(,) for Multiple Email</span></label>
                                            <div class="col-sm-6">
                                              <textarea name="contact_email" id="contact_us_email_address" class="form-control" style="resize: vertical;" rows="5" placeholder="Enter Contact Us Email Address">{{$pagedata->contact_email}}</textarea>
                                            </div>
                                          </div> 
                                            <hr>
                                            <div class="add-product-footer">
                                                <button name="addProduct_btn" type="submit" class="btn add-product_btn">Update Contact Page</button>   
                                            </div>
                                        </form>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <!-- Ending of Dashboard FAQ Page -->
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