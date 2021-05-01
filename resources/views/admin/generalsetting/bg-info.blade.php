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
                                            <h2>Welcome Contents</h2> 
                                        </div>
                                        <hr>
                                        <form class="form-horizontal" action="{{route('admin-gs-bginfoup')}}" method="POST">
                                        @include('includes.form-success')      
                                          {{csrf_field()}}
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="title">Title *</label>
                                            <div class="col-sm-6">
                                              <input name="bg_title" id="title" class="form-control" placeholder="Enter Title" required="" type="text" value="{{$data->bg_title}}">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="phone">Link *</label>
                                            <div class="col-sm-6">
                                              <input name="bg_link" id="phone" class="form-control" placeholder="Enter Link" required="" type="text" value="{{$data->bg_link}}">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="about_us_text">About Us Text *</label>
                                            <div class="col-sm-6">
                                              <textarea name="bg_text" id="about_us_text" class="form-control" rows="5" style="resize: vertical;" placeholder="Enter Information" required="">{{$data->bg_text}}</textarea>
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