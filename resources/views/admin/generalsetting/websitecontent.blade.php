@extends('layouts.admin')


@section('styles')

<link href="{{asset('assets/admin/css/jquery-ui.css')}}" rel="stylesheet" type="text/css">

<style type="text/css">
    .colorpicker-alpha {display:none !important;}
    .colorpicker{ min-width:128px !important;}
    .colorpicker-color {display:none !important;}
</style>

@endsection

@section('content')
<div class="right-side">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <!-- Starting of Dashboard Website Title -->
                        <div class="section-padding add-product-1">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="add-product-box">
                                        <div class="add-product-header">
                                            <h2>Website Contents</h2> 
                                        </div>
                                        <hr>

                                        @include('includes.form-success')

                                        {{--                                        <form method="post" class="form-horizontal" action="{{route('theme.change')}}" id="theme-form">{{csrf_field()}}--}}

                                        {{--                                            <div class="form-group">--}}
                                        {{--                                                <label class="control-label col-sm-4" for="website_title">Select Office <span>All following theme changes will be applied to selected office.</span></label>--}}
                                        {{--                                                <div class="col-sm-6">--}}
                                        {{--                                                    <select name="office" id="office" class="form-control" onchange="formSubmit1(this)">--}}

                                        {{--                                                        <option value="0" {{$data->backend == 0 ? 'selected' : null}}>Front Office</option>--}}
                                        {{--                                                        <option value="1" {{$data->backend == 1 ? 'selected' : null}}>Back Office</option>--}}

                                        {{--                                                    </select>--}}
                                        {{--                                                </div>--}}
                                        {{--                                            </div>--}}
                                        {{--                                            --}}
                                        {{--                                        </form>--}}

                                        <form class="form-horizontal" action="{{route('admin-gs-contentsup')}}" method="POST" enctype="multipart/form-data">

                                            {{csrf_field()}}

                                            <input type="hidden" name="office" id="office_select" value="1">

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="website_title">Website Title *</label>
                                                <div class="col-sm-6">
                                                    <input name="title" id="website_title" class="form-control" placeholder="Enter Website Title" required="" type="text" value="{{$data->title}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="map_key">Google Map Api Key*</label>
                                                <div class="col-sm-6">
                                                    <textarea name="map_key" id="map_key" class="form-control" placeholder="Enter Map Key" required="">{{$data->map_key}}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="website_title">Theme Color *<span>Leaving Empty Will Set The Default Color (Don't Use RGB)</span></label>
                                                <div class="col-sm-6">
                                                    <div id="cp2" class="input-group colorpicker-component">
                                                        <input id="cp1" type="text" name="colors" value="{{$data->colors}}"  class="form-control"  />
                                                        <span class="input-group-addon"><i></i></span>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="website_title">Button Background Color *<span>Leaving Empty Will Set The Default Or Theme Color (Don't Use RGB)</span></label>

                                                <div class="col-sm-6">

                                                    <div id="cp4" class="input-group colorpicker-component">

                                                        <input id="cp3" type="text" name="btn_bg" value="{{$data->btn_bg}}"  class="form-control"  />

                                                        <span class="input-group-addon"><i></i></span>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="website_title">Button Border Color *<span>Leaving Empty Will Set Default Color To Transparent (Don't Use RGB)</span></label>

                                                <div class="col-sm-6">

                                                    <div id="cp6" class="input-group colorpicker-component">

                                                        <input id="cp5" type="text" name="btn_brd" value="{{$data->btn_brd}}"  class="form-control"  />

                                                        <span class="input-group-addon"><i></i></span>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="website_title">Button Text Color *<span>Leaving Empty Will Set Default Color To White (Don't Use RGB)</span></label>

                                                <div class="col-sm-6">

                                                    <div id="cp8" class="input-group colorpicker-component">

                                                        <input id="cp7" type="text" name="btn_col" value="{{$data->btn_col}}"  class="form-control"  />

                                                        <span class="input-group-addon"><i></i></span>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="current_logo">Current Admin Background Image</label>
                                                <div class="col-sm-6">
                                                    <img id="adminimg" src="{{asset('assets/images/'.$data->bimg)}}" alt="No Image Found" id="adminimg">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="bimg">Setup New Admin Background Image</label>
                                                <div class="col-sm-6">
                                                    <input  type="file" name="bimg" id="bimg">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="current_logo">Current Handyman Background Image</label>
                                                <div class="col-sm-6">
                                                    <img  src="{{asset('assets/images/'.$data->h_sidebg)}}" alt="No Image Found">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="h_sidebg">Setup New Handyman Background Image</label>
                                                <div class="col-sm-6">
                                                    <input  type="file" name="h_sidebg" id="h_sidebg">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="current_logo">Current Handyman Dashboard Background</label>
                                                <div class="col-sm-6">
                                                    <img  src="{{asset('assets/images/'.$data->h_dashbg)}}" alt="No Image Found">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="h_dashbg">Setup New Handyman Dashboard Background</label>
                                                <div class="col-sm-6">
                                                    <input  type="file" name="h_dashbg" id="h_dashbg">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="current_logo">Current Client Background Image</label>
                                                <div class="col-sm-6">
                                                    <img  src="{{asset('assets/images/'.$data->c_sidebg)}}" alt="No Image Found">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="c_sidebg">Setup New Client Background Image</label>
                                                <div class="col-sm-6">
                                                    <input  type="file" name="c_sidebg" id="c_sidebg">
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="current_logo">Current Client Dashboard Background</label>
                                                <div class="col-sm-6">
                                                    <img  src="{{asset('assets/images/'.$data->c_dashbg)}}" alt="No Image Found">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="c_dashbg">Setup New Client Dashboard Background</label>
                                                <div class="col-sm-6">
                                                    <input  type="file" name="c_dashbg" id="c_dashbg">
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
                    <!-- Ending of Dashboard Website Title -->  
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
            $('#cp5').colorpicker();
            $('#cp6').colorpicker();
            $('#cp7').colorpicker();
            $('#cp8').colorpicker();
            $('#cp9').colorpicker();
            $('#cp10').colorpicker();
            $('#cp11').colorpicker();
            $('#cp12').colorpicker();
            $('#cp13').colorpicker();
            $('#cp14').colorpicker();
            $('#cp15').colorpicker();
            $('#cp16').colorpicker();
            $('#cp17').colorpicker();
            $('#cp18').colorpicker();
            $('#cp19').colorpicker();
            $('#cp20').colorpicker();

            function formSubmit1(e)
    {

      var office = $('#office').val(); 

      $("#office_select").val(office);
      

        $('#theme-form').submit();


    }

    </script>



<script src="{{asset('assets/admin/js/jquery152.min.js')}}"></script>
<script src="{{asset('assets/admin/js/jqueryui.min.js')}}"></script>  
@endsection