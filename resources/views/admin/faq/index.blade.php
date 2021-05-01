@extends('layouts.admin')

@section('content')
<div class="right-side">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <!-- Starting of Dashboard data-table area -->
                        <div class="section-padding add-product-1">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                  <div class="add-product-box">

                                      <div class="add-product-header products">
                                          <h2>FAQ Section</h2>
                                          <a href="{{route('admin-fq-create')}}" class="btn add-newProduct-btn"><i class="fa fa-plus"></i> Add New FAQ</a>
                                      </div>
                                      <hr>
                                    <form action="{{route('admin-faq-update')}}" method="POST">
                                      {{csrf_field()}}
                                      <div class="add-product-header products" style="justify-content: unset;">
                                        <label class="control-label" for="about_page_content" style=" padding-top: 10px;">Disable/Enable Faq Page *</label>
                                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <label class="switch" style="padding-top: 5px">
                                        <input type="checkbox" name="f_status" value="1" {{$pagedata->f_status==1?"checked":""}}>
                                        <span class="slider round"></span>
                                        </label>
                                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <button name="addProduct_btn" type="submit" class="btn add-product_btn">Update</button>
                                      </div>
                                    </form>
                                      <hr>



                  <div>
                                  @include('includes.form-success')



                                      <div class="row">
                                        <div class="col-sm-12">

                                        <table id="example" class="table table-striped table-hover products dt-responsive dataTable no-footer dtr-inline" role="grid" aria-describedby="product-table_wrapper_info" style="width: 100%;" width="100%" cellspacing="0">
                                              <thead>
                                                  <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 194px;" aria-sort="ascending" aria-label="Blood Group Name: activate to sort column descending">Title</th><th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 420px;" aria-label="Blood Group Slug: activate to sort column ascending">Text</th><th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 314px;" aria-label="Actions: activate to sort column ascending">Actions</th></tr>
                                              </thead>

                                              <tbody>
                                              @foreach($faqs as $faq)
                                              <tr role="row" class="odd">
                                                      <td tabindex="0" class="sorting_1">{{$faq->title}}</td>
                                                      <td>{{$faq->text}}</td>
                                                      <td>
                                                        <a href="{{route('admin-fq-edit',$faq->id)}}" class="btn btn-primary product-btn"><i class="fa fa-edit"></i> Edit</a>
                                                        <a href="{{route('admin-fq-delete',$faq->id)}}" class="btn btn-danger product-btn"><i class="fa fa-trash"></i> Remove</a>
                                                      </td>
                                                  </tr>
                                              @endforeach
                                                </tbody>
                                          </table>
                                        </div>
                                      </div>
                       </div>
                    </div>
                                  </div>
                              </div>
                        </div>
                    </div>
                    <!-- Ending of Dashboard data-table area -->
                </div>
            </div>
        </div>

@endsection

@section('scripts')

<script type="text/javascript">
  $('#example').DataTable();
</script>

@endsection
