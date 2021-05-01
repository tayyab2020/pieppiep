@extends('layouts.admin')

@section('content')



<div class="right-side">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <!-- Starting of Dashboard Website Footer -->
                        <div class="section-padding add-product-1">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="add-product-box">
                                        <div class="add-product-header">
                                            <h2>Website Footer</h2> 
                                        </div>
                                        <hr>
                                        <form class="form-horizontal" action="{{route('admin-gs-footerup')}}" method="POST">
                                        @include('includes.form-success')      
                                          {{csrf_field()}}
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="footer_text">Footer Text *</label>
                                            <div class="col-sm-6">
                                              <textarea name="footer" id="footer_text" class="form-control" rows="5" placeholder="Enter Footer Text" style="resize: vertical;" required="">{{$data->footer}}</textarea>
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="footer_bg">Footer Background Color *<span>Leaving Empty Will Set The Default Color (Don't Use RGB)</span></label>
                                            <div class="col-sm-6">
                                              <div id="cp2" class="input-group colorpicker-component">
                                  <input id="cp1" type="text" name="footer_bg" value="{{$data->footer_bg}}"  class="form-control"  />
                                    <span class="input-group-addon"><i></i></span>
                                    </div>

                                            </div>
                                          </div>


                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="footer_tx">Footer Text Color *<span>Leaving Empty Will Set The Default Color (Don't Use RGB)</span></label>
                                            <div class="col-sm-6">
                                              <div id="cp4" class="input-group colorpicker-component">
                                  <input id="cp3" type="text" name="footer_tx" value="{{$data->footer_tx}}"  class="form-control"  />
                                    <span class="input-group-addon"><i></i></span>
                                    </div>

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
                    <!-- Ending of Dashboard Website Footer -->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>
            $('#cp1').colorpicker();
            $('#cp2').colorpicker();
            $('#cp3').colorpicker();
            $('#cp4').colorpicker();
    </script>



<script src="{{asset('assets/admin/js/jquery152.min.js')}}"></script>
<script src="{{asset('assets/admin/js/jqueryui.min.js')}}"></script>

<script type="text/javascript" src="{{asset('assets/admin/js/nicEdit.js')}}"></script> 
<script type="text/javascript">
//<![CDATA[
        bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
  //]]>
</script>

@endsection