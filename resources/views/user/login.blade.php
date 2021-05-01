@extends('layouts.front')
@section('content')
<section class="login-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-12">
                        <div class="login-form">
                            <div class="login-icon"><i class="fa fa-user"></i></div>
                            
                            <div class="section-borders">
                                <span></span>
                                <span class="black-border"></span>
                                <span></span>
                            </div>
                            
                            <div class="login-title text-center">{{$lang->signin}}</div>

                            <form action="{{route('user-login-submit')}}" method="POST">
                            	{{csrf_field()}}
                                @include('includes.form-error')
                            	@include('includes.form-success')
                              <div class="form-group">
                                <div class="input-group">
                                  <div class="input-group-addon">
                                      <i class="fa fa-envelope"></i>
                                  </div>
                                  <input name="email" class="form-control" placeholder="{{$lang->sie}}" type="email" required="">
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="input-group">
                                  <div class="input-group-addon">
                                        <i class="fa fa-unlock-alt"></i>
                                    </div>
                                  <input class="form-control" name="password" placeholder="{{$lang->spe}}" type="password" required="">
                                </div>
                              </div>
                              <div class="form-group text-center">
                                    <button type="submit" class="btn login-btn" name="button">{{$lang->signin}}</button>
                              </div>
                              <div class="form-group text-center">
                                    <a href="{{route('user-forgot')}}">{{$lang->fpw}}</a>
                                    <br>
                                    <a href="{{route('user-register')}}">{{$lang->cn}}</a>
                              </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection