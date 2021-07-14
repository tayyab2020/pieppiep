@extends('layouts.front')
@section('content')
<section class="login-area">
            <div class="container">
                <div style="display: flex;justify-content: center;" class="row">

                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">

                        <div style="border: 0;border-radius: 10px;" class="login-form">

                            <div style="width: 100%;display: flex;justify-content: center;margin-bottom: 30px;">
                                <a href="{{route('front.index')}}">
                                    <img src="{{asset('assets/images/'.$gs->logo)}}" alt="" style="height: 75px;">
                                </a>
                            </div>

                            <form action="{{route('user-login-submit')}}" method="POST">

                                {{csrf_field()}}
                                @include('includes.form-error')
                                @include('includes.form-success')

                                <div style="margin-bottom: 30px;display: none;" class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-home"></i>
                                        </div>
                                        <input name="company" class="form-control" placeholder="Company" type="text">
                                    </div>
                                </div>

                                <div style="margin-bottom: 30px;" class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i style="font-size: 18px;" class="fa fa-envelope"></i>
                                        </div>
                                        <input name="email" class="form-control" placeholder="{{$lang->sie}}" type="email" required="">
                                    </div>
                                </div>

                                <div style="margin-bottom: 30px;" class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-unlock-alt"></i>
                                        </div>
                                        <input class="form-control" name="password" placeholder="{{$lang->spe}}" type="password" required="">
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <button style="box-shadow: 0 3px 1px -2px rgb(0 0 0 / 20%), 0 2px 2px 0 rgb(0 0 0 / 14%), 0 1px 5px 0 rgb(0 0 0 / 12%);width: 80%;border-radius: 100px;border: 0;font-size: 15px;padding: 10px 0;" type="submit" class="btn login-btn" name="button">{{$lang->signin}}</button>
                                </div>
                                <div class="form-group text-center">
                                    <a href="{{route('user-forgot')}}">{{$lang->fpw}}</a>
                                    <br>
                                    <a href="{{route('handyman-register')}}">{{$lang->cn}}</a>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </section>

    <style>

        .login-form
        {
            padding: 55px;
        }

        .input-group
        {
            border-bottom: 1px solid #e3e3e3;
        }

        .input-group:focus-within
        {
            border-bottom: 2px solid rgb(151,140,135);
        }

        .input-group-addon
        {
            border: 0;
        }

        .form-control
        {
            border: 0;
        }

        html
        {
            background-image: url({{asset('assets/images/background-login.jpg')}});
            background-repeat: no-repeat;
            background-size: cover;
            background-position: 50%;
            height: 100%;
        }

        body
        {
            background: transparent;
        }

        .login-area
        {
            background: transparent;
        }

    </style>

@endsection
