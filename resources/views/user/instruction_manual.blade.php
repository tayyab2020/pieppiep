@extends('layouts.handyman')

@section('content')
    <div class="right-side">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- Starting of Dashboard Background Image -->
                    <div class="section-padding add-product-1" style="padding: 0;">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="add-product-box">
                                    <div class="add-product-header">
                                        <h2>{{__('text.Instruction Manual')}}</h2>
                                    </div>
                                    <hr>

                                        <div class="form-group">
                                            <div style="display: flex;justify-content: center;" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                                <div class="col-lg-10 col-md-12 col-sm-12 col-xs-12">
                                                    <embed src="{{ isset($data->file) ? asset('assets/InstructionManual/'.$data->file) : asset('assets/terms-and-conditions-template.pdf')  }}" width="100%" height="800px" />
                                                </div>

                                            </div>
                                        </div>

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
