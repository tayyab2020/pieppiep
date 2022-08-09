<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{$gs->title}}</title>

        <link href="{{asset('assets/admin/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/admin/css/font-awesome.min.css')}}" rel="stylesheet">
        <link href="{{asset('assets/admin/css/style.css')}}" rel="stylesheet">
        <link href="{{asset('assets/admin/css/responsive.css')}}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{asset('assets/images/'.$gs->favicon)}}">
    <style type="text/css">
.login-form {
    border: 1px solid {{$gs->colors == null ? '#337AB7':$gs->colors}};
}
.login-icon {
    background-color: {{$gs->colors == null ? '#337AB7':$gs->colors}};
}
.login-title {
    background-color: {{$gs->colors == null ? '#337AB7':$gs->colors}};
}
.section-borders span {
    background-color: {{$gs->colors == null ? '#337AB7':$gs->colors}};
}
.login-form .input-group-addon {
    color: {{$gs->colors == null ? '#337AB7':$gs->colors}};
}
.login-btn {
    background-color: {{$gs->colors == null ? '#337AB7':$gs->colors}};
}
    </style>
    </head>
    <body>
        <section class="login-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                        <div style="padding: 30px;" class="login-form">
                            <div class="login-icon"><i class="fa fa-user"></i></div>

                            <div class="section-borders">
                                <span></span>
                                <span class="black-border"></span>
                                <span></span>
                            </div>

                            <div style="margin-top: 100px;text-align: center;" class="login-title">Please Sign In</div>

                            @include('includes.form-error')
                            @include('includes.form-success')
                            <form action="{{ route('admin-login-submit') }}" method="POST">
                            {{ csrf_field() }}
                              <div class="form-group">
                                <div class="input-group">
                                  <div class="input-group-addon">
                                      <i class="fa fa-envelope"></i>
                                  </div>
                                  <input type="email" name="email" class="form-control" placeholder="Type Email Address" required="">
                                </div>
                              </div>
                              <div class="form-group">
                                <div class="input-group">
                                  <div class="input-group-addon">
                                        <i class="fa fa-unlock-alt"></i>
                                    </div>
                                  <input type="password" class="form-control" name="password" placeholder="Type Password" required="">
                                </div>
                              </div>
                              <div class="form-group text-center">
                                    <button type="submit" class="btn login-btn" >LOGIN</button>
                              </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col-lg-12">
                    <div class="login-footer text-center">
                      Powered By <a href="http://geniusocean.com/">Pieppiep.com</a>
                    </div>
                  </div>
                </div>
            </div>
        </section>



        <script src="{{asset('assets/admin/js/jquery.min.js')}}"></script>
        <script src="{{asset('assets/admin/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/admin/js/main.js')}}"></script>
    </body>
</html>
