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
                                          <h2>Blog Section</h2>
                                          <a href="{{route('admin-blog-create')}}" class="btn add-newProduct-btn"><i class="fa fa-plus"></i> Add New Blog</a>  
                                      </div>
                                      <hr>
                  <div>
                                 @include('includes.form-success')
<div class="row">
  <div class="col-sm-12">
    <table id="example" class="table table-striped table-hover products dt-responsive dataTable no-footer dtr-inline" role="grid" aria-describedby="product-table_wrapper_info" style="width: 100%;" width="100%" cellspacing="0">
                                              <thead>
                                                  <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 150px;" aria-sort="ascending" aria-label="Donor's Photo: activate to sort column descending">Featured Image</th><th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 110px;" aria-label="Donor's Name: activate to sort column ascending">Blog Title</th><th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 184px;" aria-label="Blood Group: activate to sort column ascending">Blog Details</th><th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 85px;" aria-label="City: activate to sort column ascending">views</th><th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 120px;" aria-label="Actions: activate to sort column ascending">Actions</th></tr>
                                              </thead>

                                              <tbody>
                                            @foreach($blogs as $blog)                                                
                                              <tr role="row" class="odd">
                                                      <td tabindex="0" class="sorting_1"><img src="{{ $blog->photo ? asset('assets/images/'.$blog->photo):'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG'}}" alt="Blog's Photo" style="width: 200px"></td>
                                                    <td>{{$blog->title}}</td>
                                                    <td>{{substr(strip_tags($blog->details),0,100)}}</td>
                                                    <td>{{$blog->views}}</td>
                                                      <td>
                                                        <a href="{{route('admin-blog-edit',$blog->id)}}" class="btn btn-primary product-btn"><i class="fa fa-edit"></i> Edit</a>
                                                        <a href="{{route('admin-blog-delete',$blog->id)}}" class="btn btn-danger product-btn"><i class="fa fa-trash"></i> Remove</a>
                                                      </td>
                                                  </tr>
                                                  @endforeach
                                                  </tbody>
                                          </table></div></div>
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

