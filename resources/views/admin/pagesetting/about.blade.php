@extends('layouts.admin')

@section('content')
<div class="right-side">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <!-- Starting of Dashboard About Us Page -->
                        <div class="section-padding add-product-1">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="add-product-box">
                                        <div class="add-product-header">
                                            <h2>About Us Page</h2> 
                                        </div>
                                        <hr>
                                        <form class="form-horizontal" action="{{route('admin-ps-about-submit')}}" method="POST">
                                         @include('includes.form-success')      
                                        {{csrf_field()}}
                                            <div class="form-group">
                                            <label class="control-label col-sm-4" for="disable/enable_about_page">Disable/Enable About Page *</label>
                                            <div class="col-sm-3">
                                                <label class="switch">
                                                  <input type="checkbox" name="a_status" value="1" {{$pagedata->a_status==1?"checked":""}}>
                                                  <span class="slider round"></span>
                                                </label>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="about_page_content">About Us Page Content *</label>
                                            <div class="col-sm-6">
                                              <textarea name="about" id="about_page_content" class="form-control" style="resize: vertical;" placeholder="Enter About Us Page Content" rows="10">{{$pagedata->about}}</textarea>
                                            </div>
                                          </div>

                                        <hr>
                                        <div class="add-product-footer">
                                        <button name="addProduct_btn" type="submit" class="btn add-product_btn">Update About Page</button>   
                                        </div>
                                        </form>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <!-- Ending of Dashboard About Us Page -->
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