@extends('layouts.admin')

@section('content')
<div class="right-side">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <!-- Starting of Dashboard Background Image -->
                        <div class="section-padding add-product-1">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="add-product-box">
                                        <div class="add-product-header">
                                            <h2>Upload Documents</h2>
                                        </div>
                                        <hr>
                                        <form class="form-horizontal" action="{{route('admin-documents-post')}}" method="POST" enctype="multipart/form-data">
                                            
                                            @include('includes.form-error')
                                            @include('includes.form-success')
                                            {{csrf_field()}}

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="">Current Privacy declaration PDF File </label>
                                                <div class="col-sm-7">

                                                    <embed src="{{ $privacy ? asset('assets/'.$privacy->file) : asset('assets/terms-and-conditions-template.pdf')  }}" width="100%" height="800px" />
                                                
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="setup_new_background">Setup New PDF Template *</label>
                                                <div class="col-sm-6">
                                                    <input name="file1" type="file">
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="">Current Cookies PDF File </label>
                                                <div class="col-sm-7">

                                                    <embed src="{{ $cookies ? asset('assets/'.$cookies->file) : asset('assets/terms-and-conditions-template.pdf')  }}" width="100%" height="800px" />
                                                
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="setup_new_background">Setup New PDF Template *</label>
                                                <div class="col-sm-6">
                                                    <input name="file2" type="file">
                                                </div>
                                            </div>
                                            
                                            <hr>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="">Current Processing Agreement PDF File </label>
                                                <div class="col-sm-7">

                                                    <embed src="{{ $processing_agreement ? asset('assets/'.$processing_agreement->file) : asset('assets/terms-and-conditions-template.pdf')  }}" width="100%" height="800px" />
                                                
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="setup_new_background">Setup New PDF Template *</label>
                                                <div class="col-sm-6">
                                                    <input name="file3" type="file">
                                                </div>
                                            </div>
                                            
                                            <hr>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="">Current General terms & conditions consumers PDF File </label>
                                                <div class="col-sm-7">

                                                    <embed src="{{ $terms1 ? asset('assets/'.$terms1->file) : asset('assets/terms-and-conditions-template.pdf')  }}" width="100%" height="800px" />
                                                
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="setup_new_background">Setup New PDF Template *</label>
                                                <div class="col-sm-6">
                                                    <input name="file4" type="file">
                                                </div>
                                            </div>
                                            
                                            <hr>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="">Current General terms & conditions business PDF File </label>
                                                <div class="col-sm-7">

                                                    <embed src="{{ $terms2 ? asset('assets/'.$terms2->file) : asset('assets/terms-and-conditions-template.pdf')  }}" width="100%" height="800px" />
                                                
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-sm-4" for="setup_new_background">Setup New PDF Template *</label>
                                                <div class="col-sm-6">
                                                    <input name="file5" type="file">
                                                </div>
                                            </div>
                                            
                                            <hr>
                                            
                                            <div class="add-product-footer">
                                                <button name="addProduct_btn" type="submit" class="btn add-product_btn">Upload</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <!-- Ending of Dashboard Background Image -->
                </div>
            </div>
        </div>
    </div>
@endsection
