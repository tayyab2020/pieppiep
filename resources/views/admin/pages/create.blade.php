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
                                            <h2>{{isset($page) ? 'Edit Page' : 'Add Page'}}</h2>
                                            <a href="{{route('admin-pages-index')}}" class="btn add-back-btn"><i class="fa fa-arrow-left"></i>{{__('text.Back')}}</a>
                                        </div>
                                        <hr>
                                        <form class="form-horizontal" action="{{route('admin-pages-store')}}" method="POST" enctype="multipart/form-data">

                                            @include('includes.form-error')
                                            @include('includes.form-success')

                                            {{csrf_field()}}

                                            <input type="hidden" name="page_id" value="{{isset($page) ? $page->id : null}}" />

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_display_name">Title*</label>
                                                <div class="col-sm-6">
                                                    <input value="{{isset($page) ? $page->page : null}}" class="form-control" name="page" id="blood_group_display_name" placeholder="Enter Menu title" required="" type="text">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">Page Heading*</label>
                                                <div class="col-sm-6">
                                                    <input value="{{isset($page) ? $page->title : null}}" class="form-control" name="title" id="blood_group_slug" placeholder="Enter Page Title" required="" type="text">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">Order No*</label>
                                                <div class="col-sm-6">
                                                    <input value="{{isset($page) ? $page->order_no : 0}}" class="form-control" name="order_no" id="blood_group_slug" placeholder="Enter Order No" required="" type="number">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="service_description">Description</label>
                                                <div class="col-sm-6">
                                                    <input type="hidden" value="{{isset($page) ? $page->description : null}}" name="description">
                                                    <div class="summernote">{!! isset($page) ? $page->description : null !!}</div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">Meta Keywords</label>
                                                <div class="col-sm-6">
                                                    <input value="{{isset($page) ? $page->meta_keywords : null}}" class="form-control" name="meta_keywords" id="blood_group_slug" placeholder="Enter Meta Keywords" type="text">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">Meta Title</label>
                                                <div class="col-sm-6">
                                                    <input value="{{isset($page) ? $page->meta_title : null}}" class="form-control" name="meta_title" id="blood_group_slug" placeholder="Enter Meta Title" type="text">
                                                </div>
                                            </div>

                                            <!-- <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">Meta URL</label>
                                                <div class="col-sm-6">
                                                    <input value="{{isset($page) ? $page->meta_url : null}}" class="form-control" name="meta_url" id="blood_group_slug" placeholder="Enter Meta URL" type="text">
                                                </div>
                                            </div> -->

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="blood_group_slug">Meta Description</label>
                                                <div class="col-sm-6">
                                                    <input value="{{isset($page) ? $page->meta_description : null}}" class="form-control" name="meta_description" id="blood_group_slug" placeholder="Enter Meta Description" type="text">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="current_photo">Current Photo</label>
                                                <div class="col-sm-6">
                                                    <img width="130px" height="90px" id="adminimg" src="{{isset($page->image) ? asset('assets/images/'.$page->image):'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG'}}" alt="">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="profile_photo">Add Photo</label>
                                                <div class="col-sm-6">
                                                    <input type="file" id="uploadFile" class="hidden" name="photo" value="">
                                                    <button type="button" id="uploadTrigger" onclick="uploadclick()" class="form-control"><i class="fa fa-download"></i> Add Photo</button>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="add-product-footer">
                                                <button name="addProduct_btn" type="submit" class="btn add-product_btn">{{isset($page) ? 'Edit Page' : 'Add Page'}}</button>
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

<script type="text/javascript">

$(document).ready(function () {

    $('.summernote').summernote({
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['style']],
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            /*['color', ['color']],*/
            ['fontname', ['fontname']],
            ['forecolor', ['forecolor']],
        ],
        height: 200,   //set editable area's height
        codemirror: { // codemirror options
            theme: 'monokai'
        },
        callbacks: {
            onChange: function (contents, $editable) {
                $(this).prev('input').val(contents);
            }
        }
    });

});

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
