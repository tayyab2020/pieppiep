<html lang="{{ env('APP_LOCALE') }}">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Reset - Mera Brand</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('public/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this website -->
    <link href="{{ asset('public/css/mera-brand.css') }}"  rel="stylesheet">

    <script src="{{ asset('public/vendor/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('public/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('public/js/mera_brand.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('public/css/app.css') }}">

</head>


<body class="hold-transition login-page" style="background: url('https://images3.alphacoders.com/253/253375.jpg') no-repeat center center fixed;background-size:100% 100%;">

   
    <div class="container" align="center">
        <div class="card col-4 mt-5 mb-5">
            <article class="card-body">
                <a href="{{ route('admin') }}" class="float-left btn btn-outline-primary" style="position: absolute;left: 18px;">Sign in</a>
               
               

                 <div class="login-box">
            <div class="login-logo">
                <img src="{{ asset('public/img/logo.png') }}" alt="" />
                <style type="text/css">
                    .login-logo img{
                        width: 210px;
                    }
                </style>
            </div>
            <!-- /.login-logo -->

            <div class="login-box-body">
                <p class="login-box-msg">Admin Reset Password</p>

               @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form role="form" method="POST" action="{{ route('admin.password.email') }}">
    {{ csrf_field() }}

    <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
         <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
    </div>
    <div class="row">
        <!-- /.col -->
         <div style="margin: auto;">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>

        <!-- /.col -->
    </div>
</form>

  

                           </div>
            <!-- /.login-box-body -->

            
            <!-- /.login-box-footer -->
        </div>

            </article>
        </div>
        <!-- card.// -->
    </div>





</body>
    
</html>

