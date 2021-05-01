@extends('layouts.admin')

@section('content')
    <div class="right-side">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- Starting of Dashboard Background Image -->
                    <div style="padding: 0;" class="section-padding add-product-1">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="add-product-box">
                                    <div class="add-product-header">
                                        <h2>Upload Instruction Manual</h2>
                                    </div>
                                    <hr>
                                    <form class="form-horizontal" action="{{route('admin-instruction-manual-post')}}" method="POST" enctype="multipart/form-data">
                                        @include('includes.form-error')
                                        @include('includes.form-success')
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="">Current PDF File </label>
                                            <div class="col-sm-7">

                                                <embed src="{{ isset($data->file) ? asset('assets/InstructionManual/'.$data->file) : asset('assets/terms-and-conditions-template.pdf')  }}" width="100%" height="800px" />


                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="setup_new_background">Setup New PDF Template *</label>
                                            <div class="col-sm-6">
                                                <input name="file" type="file" required>
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
