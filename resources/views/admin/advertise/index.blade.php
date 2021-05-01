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
                                          <h2>Advertisement Section</h2>
                                          <a href="{{route('admin-adv-create')}}" class="btn add-newProduct-btn"><i class="fa fa-plus"></i> Add New Advertisement</a>  
                                      </div>
                                      <hr>
                  <div>
                                 @include('includes.form-success')
<div class="row">
  <div class="col-sm-12">
    <table id="example" class="table table-striped table-hover products dt-responsive dataTable no-footer dtr-inline" role="grid" aria-describedby="product-table_wrapper_info" style="width: 100%;" width="100%" cellspacing="0">
                                              <thead>
                                                  <tr role="row"><th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 75px;" aria-label="Donor's Name: activate to sort column ascending">Ad Type</th><th class="sorting_asc" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 200px;" aria-sort="ascending" aria-label="Donor's Photo: activate to sort column descending">Image / Script</th><th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 10px;" aria-label="Blood Group: activate to sort column ascending"> URL</th><th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 40px;" aria-label="City: activate to sort column ascending"> Size</th><th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 40px;" aria-label="City: activate to sort column ascending">Clicks</th><th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 40px;" aria-label="City: activate to sort column ascending">Status</th><th class="sorting" tabindex="0" aria-controls="product-table_wrapper" rowspan="1" colspan="1" style="width: 230px;" aria-label="Actions: activate to sort column ascending">Actions</th></tr>
                                              </thead>

                                              <tbody>
                                            @foreach($ads as $ad)                                                
                                              <tr role="row" class="odd">

                                                    <td>{{$ad->type}}</td>
                                                      <td tabindex="0" class="sorting_1">
                                                        @if($ad->photo)
                                                        <img src="{{ $ad->photo ? asset('assets/images/'.$ad->photo):'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG'}}" alt="Ad Photo" style="width: 200px">
                                                        @else
                                                        {{$ad->script }}
                                                        @endif
                                                      </td>

                                                    <td>{{$ad->photo ? $ad->url : "Not Available For Script."}}</td>
                                                    <td>{{$ad->size}}</td>
                                                    <td>{{$ad->clicks}}</td>
                                                    <td>{{$ad->status}}</td>
                                                      <td>
                                                        <a href="{{route('admin-adv-edit',$ad->id)}}" class="btn btn-primary product-btn"><i class="fa fa-edit"></i> Edit</a>

                                                        @if($ad->status == 1)

                                                        <a href="{{route('admin-adv-st',['id1'=>$ad->id,'id2'=>0])}}" class="btn btn-warning product-btn"><i class="fa fa-times"></i> Deactive</a>
                                                        @else        

                                                        <a href="{{route('admin-adv-st',['id1'=>$ad->id,'id2'=>1])}}" class="btn btn-success product-btn"><i class="fa fa-times"></i> Active</a>
                                                        @endif

                                                        <a href="{{route('admin-adv-delete',$ad->id)}}" class="btn btn-danger product-btn"><i class="fa fa-trash"></i> Remove</a>
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

