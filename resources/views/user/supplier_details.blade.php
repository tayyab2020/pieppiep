@extends('layouts.handyman')



@section('content')
    <div class="right-side" style="margin-top: 73px !important;">
        <div class="container-fluid" style="width: 80%;">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                    <div class="login-form" style="border: 1px solid {{$gs->colors == null ? 'rgba(204, 37, 42, 0.79)':$gs->colors}}">
                        <div class="login-icon" style="background-color: {{$gs->colors == null ? 'rgba(204, 37, 42, 0.79)':$gs->colors}}"><i class="fa fa-user"></i></div>

                        <div class="section-borders">
                            <span style="background-color: {{$gs->colors == null ? 'rgba(204, 37, 42, 0.79)':$gs->colors}}"></span>
                            <span class="black-border"></span>
                            <span style="background-color: {{$gs->colors == null ? 'rgba(204, 37, 42, 0.79)':$gs->colors}}"></span>
                        </div>

                        <div class="login-title text-center" style="background-color: {{$gs->colors == null ? 'rgba(204, 37, 42, 0.79)':$gs->colors}}">{{__('text.Supplier Details')}}</div>

                        <div class="form-group" style="margin-top: 50px;display: inline-block;width: 100%;">

                            <label class="control-label col-sm-3" for="contact_form_success_text" style="text-align: right;padding-top: 7px;">{{__('text.Name')}}</label>
                            <div class="col-sm-7">

                                <p class="form-control" style="padding: 10px;text-align: center;">{{$user->name}} {{$user->family_name}}</p>

                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 30px;display: inline-block;width: 100%;">

                            <label class="control-label col-sm-3" for="contact_form_success_text" style="text-align: right;padding-top: 7px;">{{__('text.Email')}}</label>
                            <div class="col-sm-7">

                                <p class="form-control" style="padding: 10px;text-align: center;">{{$user->email}}</p>

                            </div>
                        </div>


                        <div class="form-group" style="margin-top: 30px;display: inline-block;width: 100%;">

                            <label class="control-label col-sm-3" for="contact_form_success_text" style="text-align: right;padding-top: 7px;">{{__('text.Experience Years')}}</label>
                            <div class="col-sm-7">

                                <p class="form-control" style="padding: 10px;text-align: center;">

                                    @if($user->experience_years) {{$user->experience_years}} @if($user->experience_years > 1) {{__('text.Years')}} @else {{__('text.Year')}} @endif @else N/A @endif

                                </p>

                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 30px;display: inline-block;width: 100%;">

                            <label class="control-label col-sm-3" for="contact_form_success_text" style="text-align: right;padding-top: 7px;">{{__('text.Rating')}}</label>
                            <div class="col-sm-7">

                                <p class="form-control" style="padding: 10px;text-align: center;">{{$user->rating}} <span class="fa fa-star checked" style="margin-left: 5px;"></span></p>

                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 30px;display: inline-block;width: 100%;">

                            <label class="control-label col-sm-3" for="contact_form_success_text" style="text-align: right;padding-top: 7px;">{{__('text.Registration Number')}}</label>
                            <div class="col-sm-7">

                                <p class="form-control" style="padding: 10px;text-align: center;">{{$user->registration_number}}</p>

                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 30px;display: inline-block;width: 100%;">

                            <label class="control-label col-sm-3" for="contact_form_success_text" style="text-align: right;padding-top: 7px;">{{__('text.Company Name')}}</label>
                            <div class="col-sm-7">

                                <p class="form-control" style="padding: 10px;text-align: center;">{{$user->company_name}}</p>

                            </div>
                        </div>


                        <div class="form-group" style="margin-top: 30px;display: inline-block;width: 100%;">

                            <label class="control-label col-sm-3" for="contact_form_success_text" style="text-align: right;padding-top: 7px;">{{__('text.Address')}}</label>
                            <div class="col-sm-7">

                                <p class="form-control" style="padding: 10px;text-align: center;">{{$user->address}}</p>

                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 30px;display: inline-block;width: 100%;">

                            <label class="control-label col-sm-3" for="contact_form_success_text" style="text-align: right;padding-top: 7px;">{{__('text.Phone Number')}}</label>
                            <div class="col-sm-7">

                                <p class="form-control" style="padding: 10px;text-align: center;">{{$user->phone}}</p>

                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 30px;display: inline-block;width: 100%;">

                            <label class="control-label col-sm-3" for="contact_form_success_text" style="text-align: right;padding-top: 7px;">{{__('text.Tax Number')}}</label>
                            <div class="col-sm-7">

                                <p class="form-control" style="padding: 10px;text-align: center;">{{$user->tax_number}}</p>

                            </div>
                        </div>

                        <div class="form-group" style="margin-top: 30px;display: inline-block;width: 100%;">

                            <label class="control-label col-sm-3" for="contact_form_success_text" style="text-align: right;padding-top: 7px;">{{__('text.Bank Account')}}</label>
                            <div class="col-sm-7">

                                <p class="form-control" style="padding: 10px;text-align: center;">{{$user->bank_account}}</p>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <style type="text/css">

        .checked {
            color: orange !important;
        }

        .section-borders
        {
            top: 60px;
        }

    </style>

@endsection
