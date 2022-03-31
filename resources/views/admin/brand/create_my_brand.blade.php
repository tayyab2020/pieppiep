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
                    <!-- Starting of Dashboard area -->
                    <div class="section-padding add-product-1">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="add-product-box">
                                    <div class="add-product-header">
                                        <h2>{{isset($brand) ? 'Edit Brand' : 'Add Brand'}}</h2>
                                        <a href="{{route('admin-my-brand-index')}}" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> Back</a>
                                    </div>
                                    <hr>
                                    <form class="form-horizontal" action="{{route('admin-my-brand-store')}}" method="POST" enctype="multipart/form-data">

                                        @include('includes.form-error')
                                        @include('includes.form-success')

                                        {{csrf_field()}}

                                        <input type="hidden" name="brand_id" value="{{isset($brand) ? $brand->id : null}}" />

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_display_name">Title*</label>
                                            <div class="col-sm-6">
                                                <input {{$brand->edit_request_id ? 'readonly' : null}} value="{{isset($brand) ? $brand->cat_name : null}}" class="form-control" name="cat_name" id="blood_group_display_name" placeholder="Enter Brand title" required="" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">Slug*</label>
                                            <div class="col-sm-6">
                                                <input {{$brand->edit_request_id ? 'readonly' : null}} value="{{isset($brand) ? $brand->cat_slug : null}}" class="form-control" name="cat_slug" id="blood_group_slug" placeholder="Enter Brand Slug" required="" type="text">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">Trademark*</label>
                                            <div class="col-sm-6">

                                                <select {{$brand->edit_request_id ? 'readonly' : null}} class="form-control" name="trademark">
                                                    <option {{(isset($brand) && $brand->trademark == 0) ? 'selected' : null}} value="0">No</option>
                                                    <option {{(isset($brand) && $brand->trademark == 1) ? 'selected' : null}} value="1">Yes</option>
                                                </select>

                                            </div>
                                        </div>

                                        <div class="form-group">

                                            <label class="control-label col-sm-4" for="blood_group_slug">Other Suppliers (Optional)</label>

                                            <div class="col-sm-6">

                                                <select {{$brand->edit_request_id ? 'readonly' : null}} style="height: 100px;" class="form-control" name="other_suppliers[]" id="suppliers" multiple>

                                                    @foreach($suppliers as $supplier)

                                                        <option {{isset($supplier_ids) ? (in_array($supplier->id, $supplier_ids) ? 'selected' : null) : null}} value="{{$supplier->id}}">{{$supplier->company_name}}</option>

                                                    @endforeach

                                                </select>

                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="service_description">Description</label>
                                            <div class="col-sm-6">
                                                <textarea {{$brand->edit_request_id ? 'readonly' : null}} class="form-control" name="description" id="service_description" rows="5" style="resize: vertical;" placeholder="Enter Brand Description">{{isset($brand) ? $brand->description : null}}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="current_photo">Current Photo</label>
                                            <div class="col-sm-6">
                                                <img width="130px" height="90px" id="adminimg" src="{{isset($brand->photo) ? asset('assets/images/'.$brand->photo):'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG'}}" alt="">
                                            </div>
                                        </div>

                                        @if(!$brand->edit_request_id)

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="profile_photo">Add Photo</label>
                                                <div class="col-sm-6">
                                                    <input type="file" id="uploadFile" class="hidden" name="photo" value="">
                                                    <button type="button" id="uploadTrigger" onclick="uploadclick()" class="form-control"><i class="fa fa-download"></i> Add Brand Photo</button>
                                                    <p>Prefered Size: (600x600) or Square Sized Image</p>
                                                </div>
                                            </div>

                                        @endif

                                        @if(isset($brand) && $brand->edit_request_id)

                                            <input type="hidden" name="edit_request_id" value="{{$brand->edit_request_id}}" />

                                            <hr>

                                            <div style="margin-top: 30px;" class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_display_name"></label>
                                                <div class="col-sm-6">
                                                    <h2>Request Details</h2>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_display_name">Title*</label>
                                                <div class="col-sm-6">
                                                    <input value="{{$brand->edit_title}}" class="form-control" name="edit_title" id="blood_group_display_name" placeholder="Enter Brand title" required="" type="text">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">Slug*</label>
                                                <div class="col-sm-6">
                                                    <input value="{{$brand->edit_slug}}" class="form-control" name="edit_slug" id="blood_group_slug" placeholder="Enter Brand Slug" required="" type="text">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="service_description1">Description</label>
                                                <div class="col-sm-6">
                                                    <textarea class="form-control" name="edit_description" id="service_description1" rows="5" style="resize: vertical;" placeholder="Enter Brand Description">{{$brand->edit_description}}</textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="current_photo">Current Photo</label>
                                                <div class="col-sm-6">
                                                    <input name="temp_edit_photo" type="hidden" value="{{$brand->edit_photo}}">
                                                    <img width="130px" height="90px" id="adminimg1" src="{{isset($brand->edit_photo) ? asset('assets/images/'.$brand->edit_photo):'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG'}}" alt="">
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="profile_photo">Add Photo</label>
                                                <div class="col-sm-6">
                                                    <input type="file" id="uploadFile1" class="hidden" name="edit_photo" value="">
                                                    <button type="button" id="uploadTrigger1" onclick="uploadclick1()" class="form-control"><i class="fa fa-download"></i> Add Brand Photo</button>
                                                    <p>Prefered Size: (600x600) or Square Sized Image</p>
                                                </div>
                                            </div>

                                        @endif

                                        <hr>

                                        <div class="add-product-footer">
                                            <button name="addProduct_btn" type="submit" class="btn add-product_btn">{{isset($brand) ? 'Edit Brand' : 'Add Brand'}}</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Ending of Dashboard area -->
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

    <script type="text/javascript" src="{{asset('assets/admin/js/nicEdit.js')}}"></script>
    <script type="text/javascript">
        //<![CDATA[
        /*bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });*/
        bkLib.onDomLoaded(function() {
            nicEditors.editors.push(
                new nicEditor().panelInstance(
                    document.getElementById('service_description')
                )
            );
        });

        bkLib.onDomLoaded(function() {
            nicEditors.editors.push(
                new nicEditor().panelInstance(
                    document.getElementById('service_description1')
                )
            );
        });
        //]]>
    </script>

<script type="text/javascript">

  function uploadclick(){
    $("#uploadFile").click();
    $("#uploadFile").change(function(event) {
          readURL(this);
        $("#uploadTrigger").html($("#uploadFile").val());
    });
  }

  function uploadclick1(){
      $("#uploadFile1").click();
      $("#uploadFile1").change(function(event) {
          readURL1(this);
          $("#uploadTrigger1").html($("#uploadFile1").val());
      });
  }

  function readURL(input) {

      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              $('#adminimg').attr('src', e.target.result);
          }
          reader.readAsDataURL(input.files[0]);
      }
  }

  function readURL1(input) {

      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              $('#adminimg1').attr('src', e.target.result);
          }
          reader.readAsDataURL(input.files[0]);
      }
  }

  var rem_arr = [];

  $(document).on('click', '.add-row', function () {

      var row = $('.table table tbody tr:last').data('id');
      row = row + 1;

      $(".table table tbody").append('<tr data-id="'+row+'">\n' +
          '                                                                                        <td>\n' +
          '                                                                                            <input type="hidden" name="sub_category_id[]">\n' +
          '                                                                                            <input class="form-control sub_category_title" name="sub_category_title[]" id="blood_group_slug" placeholder="Title" type="text">\n' +
          '                                                                                        </td>\n' +
          '                                                                                        <td>\n' +
          '                                                                                            <input class="form-control sub_category_slug" name="sub_category_slug[]" id="blood_group_slug" placeholder="Slug" type="text">\n' +
          '                                                                                        </td>\n' +
          '                                                                                        <td>\n' +
          '                                                                                            <textarea class="form-control" name="sub_category_description[]" id="sub_category_description" style="resize: vertical;height: 40px;" placeholder="Enter Category Description"></textarea>\n' +
          '                                                                                        </td>\n' +
          '                                                                                        <td style="text-align: center;">\n' +
          '                                                                                           <span id="next-row-span" class="tooltip1 add-row" style="cursor: pointer;font-size: 20px;">\n' +
          '                                                                                               <i id="next-row-icon" class="fa fa-fw fa-plus"></i>\n' +
          '                                                                                           </span>\n' +
          '\n' +
          '                                                                                           <span data-id="" id="next-row-span" class="tooltip1 remove-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;">\n' +
          '                                                                                               <i id="next-row-icon" class="fa fa-fw fa-trash-o"></i>\n' +
          '                                                                                           </span>\n' +
          '                                                                                        </td>\n' +
          '                                                                </tr>');

  });


  $(document).on('click', '.remove-row', function () {

      $(this).parent().parent().remove();

      if($('.table').find("table tbody tr").length == 0)
      {

          $('.table').find("table tbody").append('<tr data-id="1">\n' +
              '                                                                                        <td>\n' +
              '                                                                                            <input type="hidden" name="sub_category_id[]">\n' +
              '                                                                                            <input class="form-control sub_category_title" name="sub_category_title[]" id="blood_group_slug" placeholder="Title" type="text">\n' +
              '                                                                                        </td>\n' +
              '                                                                                        <td>\n' +
              '                                                                                            <input class="form-control sub_category_slug" name="sub_category_slug[]" id="blood_group_slug" placeholder="Slug" type="text">\n' +
              '                                                                                        </td>\n' +
              '                                                                                        <td>\n' +
              '                                                                                            <textarea class="form-control" name="sub_category_description[]" id="sub_category_description" style="resize: vertical;height: 40px;" placeholder="Enter Category Description"></textarea>\n' +
              '                                                                                        </td>\n' +
              '                                                                                        <td style="text-align: center;">\n' +
              '                                                                                           <span id="next-row-span" class="tooltip1 add-row" style="cursor: pointer;font-size: 20px;">\n' +
              '                                                                                               <i id="next-row-icon" class="fa fa-fw fa-plus"></i>\n' +
              '                                                                                           </span>\n' +
              '\n' +
              '                                                                                           <span data-id="" id="next-row-span" class="tooltip1 remove-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;">\n' +
              '                                                                                               <i id="next-row-icon" class="fa fa-fw fa-trash-o"></i>\n' +
              '                                                                                           </span>\n' +
              '                                                                                        </td>\n' +
              '                                                                </tr>');
      }

  });

</script>

<style type="text/css">

    .table{width: 100%;padding: 0 20px;margin: 40px 0 !important;}
    .table table{border-collapse: inherit;text-align: left;width: 100%;border: 1px solid #d6d6d6;border-radius: 10px;}
    .table table thead th{font-weight: 700;padding: 12px 10px;background: #f8f9fa;color: #3a3a3a;}
    .table table tbody td{padding: 10px;border-bottom: 1px solid #d3d3d3;color: #3a3a3a;vertical-align: middle;}
    .table table tbody tr:last-child td{ border-bottom: none; }

  .swal2-show
  {
    padding: 40px;
    width: 30%;

  }

  .swal2-header
  {
    font-size: 23px;
  }

  .swal2-content
  {
    font-size: 18px;
  }

  .swal2-actions
  {
    font-size: 16px;
  }

</style>


    <script>
            $('#cp1').colorpicker();
            $('#cp2').colorpicker();
    </script>





@endsection
