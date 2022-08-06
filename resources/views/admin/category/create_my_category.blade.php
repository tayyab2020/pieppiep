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
                                            <h2>{{isset($cats) ? 'Edit Category' : 'Add Category'}}</h2>
                                            <a href="{{route('admin-my-cat-index')}}" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> {{__('text.Back')}}</a>
                                        </div>
                                        <hr>
                                        <form class="form-horizontal" action="{{route('admin-my-cat-store')}}" method="POST" enctype="multipart/form-data">

                                            @include('includes.form-error')
                                            @include('includes.form-success')

                                            {{csrf_field()}}

                                            <input type="hidden" name="cat_id" value="{{isset($cats) ? $cats->id : null}}" />

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_display_name">{{__('Title')}}</label>
                                            <div class="col-sm-6">
                                              <input value="{{isset($cats) ? $cats->cat_name : null}}" class="form-control" name="cat_name" id="blood_group_display_name" placeholder="Enter Category title" required="" type="text">
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">Slug*</label>
                                            <div class="col-sm-6">
                                              <input value="{{isset($cats) ? $cats->cat_slug : null}}" class="form-control" name="cat_slug" id="blood_group_slug" placeholder="Enter Category Slug" required="" type="text">
                                            </div>
                                          </div>

                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="blood_group_slug">Quotation Layout*</label>
                                            <div class="col-sm-6">

                                              <select class="form-control" name="quotation_layout">
                                                <option {{(isset($cats) && $cats->quotation_layout == 1) ? 'selected' : null}} value="1">Old</option>
                                                <option {{(isset($cats) && $cats->quotation_layout == 2) ? 'selected' : null}} value="2">New</option>
                                              </select>

                                            </div>
                                          </div>

                                          <div class="form-group">

                                              <label class="control-label col-sm-4" for="blood_group_slug">Suppliers (Optional)</label>

                                              <div class="col-sm-6">

                                                <select style="height: 100px;" class="form-control" name="suppliers[]" id="suppliers" multiple>

                                                  @foreach($suppliers as $supplier)

                                                    <option {{isset($category_suppliers) ? (in_array($supplier->id, $category_suppliers) ? 'selected' : null) : null}} value="{{$supplier->id}}">{{$supplier->company_name}}</option>

                                                  @endforeach

                                                </select>

                                              </div>

                                            </div>

                                            <div class="table form-group">

                                                <table style="margin: auto;">

                                                    <thead>
                                                    <tr>
                                                        <th style="border-top-left-radius: 9px;">Title</th>
                                                        <th>Slug</th>
                                                        <th>Description</th>
                                                        <th style="width: 10%;border-top-right-radius: 9px;"></th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>

                                                    @if(isset($cats) && count($cats->sub_categories) > 0)

                                                        @foreach($cats->sub_categories as $x => $key)

                                                            <tr data-id="{{$x+1}}">
                                                                <td>
                                                                    <input value="{{$key->id}}" type="hidden" name="sub_category_id[]">
                                                                    <input value="{{$key->cat_name}}" class="form-control sub_category_title" name="sub_category_title[]" id="blood_group_slug" placeholder="Title" type="text">
                                                                </td>
                                                                <td>
                                                                    <input value="{{$key->cat_slug}}" class="form-control sub_category_slug" name="sub_category_slug[]" id="blood_group_slug" placeholder="Slug" type="text">
                                                                </td>
                                                                <td>
                                                                    <textarea class="form-control" name="sub_category_description[]" id="sub_category_description" style="resize: vertical;height: 40px;" placeholder="Enter Category Description">{{$key->description}}</textarea>
                                                                </td>
                                                                <td style="text-align: center;">

                                                                    <span id="next-row-span" class="tooltip1 add-row" data-id="" style="cursor: pointer;font-size: 20px;">
                                                                        <i id="next-row-icon" class="fa fa-fw fa-plus"></i>
                                                                    </span>

                                                                    <span data-id="" id="next-row-span" class="tooltip1 remove-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;">
                                                                        <i id="next-row-icon" class="fa fa-fw fa-trash-o"></i>
                                                                    </span>

                                                                </td>
                                                            </tr>

                                                        @endforeach

                                                    @else

                                                        <tr data-id="1">
                                                            <td>
                                                                <input type="hidden" name="sub_category_id[]">
                                                                <input class="form-control sub_category_title" name="sub_category_title[]" id="blood_group_slug" placeholder="Title" type="text">
                                                            </td>
                                                            <td>
                                                                <input class="form-control sub_category_slug" name="sub_category_slug[]" id="blood_group_slug" placeholder="Slug" type="text">
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control" name="sub_category_description[]" id="sub_category_description" style="resize: vertical;height: 40px;" placeholder="Enter Category Description"></textarea>
                                                            </td>
                                                            <td style="text-align: center;">

                                                            <span id="next-row-span" class="tooltip1 add-row" data-id="" style="cursor: pointer;font-size: 20px;">
                                                                <i id="next-row-icon" class="fa fa-fw fa-plus"></i>
                                                            </span>

                                                                <span data-id="" id="next-row-span" class="tooltip1 remove-row" style="cursor: pointer;font-size: 20px;margin-left: 10px;">
                                                                <i id="next-row-icon" class="fa fa-fw fa-trash-o"></i>
                                                            </span>

                                                            </td>
                                                        </tr>

                                                    @endif

                                                    </tbody>

                                                </table>

                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="service_description">Category Description</label>
                                                <div class="col-sm-6">
                                                    <textarea class="form-control" name="description" id="service_description" rows="5" style="resize: vertical;" placeholder="Enter Category Description">{{isset($cats) ? $cats->description : null}}</textarea>
                                                </div>
                                            </div>


                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="current_photo">Current Photo</label>
                                            <div class="col-sm-6">
                                             <img width="130px" height="90px" id="adminimg" src="{{isset($cats->photo) ? asset('assets/images/'.$cats->photo):'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG'}}" alt="">
                                            </div>
                                          </div>


                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="profile_photo">{{__('text.Add photo')}}</label>
                                            <div class="col-sm-6">
                                                <input type="file" id="uploadFile" class="hidden" name="photo" value="">
                                              <button type="button" id="uploadTrigger" onclick="uploadclick()" class="form-control"><i class="fa fa-download"></i>{{__('text.Add Category Photo')}}</button>
                                              <p>{{__('text.Prefered Size: (600x600) or Square Sized Image')}}</p>
                                            </div>
                                          </div>


                                            <hr>

                                            <div class="add-product-footer">
                                                <button name="addProduct_btn" type="submit" class="btn add-product_btn">{{isset($cats) ? 'Edit Category' : 'Add Category'}}</button>
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

  function readURL(input) {

      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              $('#adminimg').attr('src', e.target.result);
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
