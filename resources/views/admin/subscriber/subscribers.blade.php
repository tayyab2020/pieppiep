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
                                          <h2>All Subscribers</h2>
                                            <a href="{{route('admin-subs-download')}}" class="btn add-newProduct-btn"><i class="fa fa-download"></i> Export</a>
                                      </div>
                                      <hr>
                  <div>
                                  @include('includes.form-success')
        


                                      <div class="row">
                                        <div class="col-sm-12">

                                        <table id="example" class="table table-striped table-hover products dt-responsive dataTable no-footer dtr-inline" role="grid" aria-describedby="product-table_wrapper_info" style="width: 100%;" width="100%" cellspacing="0">
                                              <thead>
                                                  <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 44px;" aria-sort="ascending" aria-label="Blood Group Name: activate to sort column descending">#SL</th><th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 320px;" aria-label="Blood Group Slug: activate to sort column ascending">Email</th></tr>
                                              </thead>

                                              <tbody>
                                              @php
                                              $i=1;
                                              @endphp
                                              @foreach($subscribers as $subscriber)    
                                              <tr role="row" class="odd">

                                                      <td tabindex="0" class="sorting_1">{{$i++}}</td>
                                                      <td>{{$subscriber->email}}</td>
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

