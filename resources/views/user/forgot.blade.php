@extends('layouts.front_new')
@section('content')

    <style>

        .input-group
        {
            position: relative;
            display: table !important;
            border-collapse: separate;
        }

        .input-group-addon:first-child
        {
            border-right: 0;
        }

        .input-group-addon
        {
            padding: 6px 12px;
            font-size: 14px;
            font-weight: 400;
            line-height: 1;
            text-align: center;
            border: 1px solid #ccc;
        }

        .input-group-addon, .input-group-btn
        {
            width: 1%;
            white-space: nowrap;
            vertical-align: middle;
        }

        .input-group .form-control, .input-group-addon, .input-group-btn
        {
            display: table-cell;
        }

        .input-group .form-control:last-child, .input-group-addon:last-child, .input-group-btn:first-child>.btn-group:not(:first-child)>.btn, .input-group-btn:first-child>.btn:not(:first-child), .input-group-btn:last-child>.btn, .input-group-btn:last-child>.btn-group>.btn, .input-group-btn:last-child>.dropdown-toggle
        {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .login-form .form-control
        {
            height: 40px;
            border-radius: 2px;
            box-shadow: none;
        }

        .input-group .form-control
        {
            position: relative;
            z-index: 2;
            float: left;
            width: 100% !important;
            margin-bottom: 0;
        }

    </style>

    <section style="padding: 200px 0 0 0;" class="login-area">
        <div class="container">
            <div style="justify-content: center;" class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12">
                    <div class="login-form">
                        <div class="login-icon"><i class="fa fa-user"></i></div>

                        <div class="section-borders">
                            <span></span>
                            <span class="black-border"></span>
                            <span></span>
                        </div>

                        <div class="login-title text-center">{{$lang->fpt}}</div>

                        <form action="{{route('user-forgot-submit')}}" method="POST">
                            {{csrf_field()}}
                            @include('includes.form-success')
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <input name="email" class="form-control" placeholder="{{$lang->fpe}}" type="email">
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn login-btn" name="button">{{$lang->fpb}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection