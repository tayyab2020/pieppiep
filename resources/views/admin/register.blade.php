<html lang="{{ env('APP_LOCALE') }}">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Sign Up - Mera Brand</title>

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

    <div class="container mt-5 mb-5">
        <div class="card">
            <header class="card-header">
                <a href="login" class="float-right btn btn-outline-primary mt-1">Log in</a>
                <h4 class="card-title mt-2">Sign up</h4>
            </header>
            <article class="card-body">
                <form enctype="multipart/form-data" role="form" method="POST" action="{{ route('admin.register') }}">
    {{ csrf_field() }}
                    <div class="form-row">
                        <div class="col form-group">
                            <label>First name</label>
                            <input type="text" class="form-control" placeholder="Enter first name" name="first_name" required> 
                        </div>
                        <!-- form-group end.// -->
                        <div class="col form-group">
                            <label>Last name</label>
                            <input type="text" class="form-control" placeholder="Enter last name" name="last_name" required>
                        </div>
                        <!-- form-group end.// -->
                    </div>
                    <!-- form-row end.// -->
                    
                    <!-- form-group end.// -->
                    <div class="form-group">
                        <label class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="gender" value="male" required>
          <span class="form-check-label"> Male </span>
        </label>
                        <label class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="gender" value="female">
          <span class="form-check-label"> Female</span>
        </label>
                    </div>
                    <!-- form-group end.// -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>City</label>
                            <input type="text" class="form-control" placeholder="City" name="city" required>
                        </div>
                        <!-- form-group end.// -->
                        
                        <!-- form-group end.// -->
                    </div>
                    <!-- form-row.// -->
                    <div class="form-group">
                        <label>Email address</label>

                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Enter email address" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        <small class="form-text text-muted">We'll never share your email with anyone else.</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Create password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div>

                     <div class="form-group">
                        <label>Confirm password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                    </div>

                    <div class="form-group">
                        <label>User Image</label>
         <input  type="file" class="form-control" name="avatar" >

        @if ($errors->has('avatar'))
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->get('avatar') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    </div>

                    <!-- form-group end.// -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block"> Register  </button>
                    </div>
                    <!-- form-group// -->
                    <small class="text-muted">By clicking the 'Sign Up' button, you confirm that you accept our <br> Terms of use and Privacy Policy.</small>
                </form>
            </article>
            <!-- card-body end .// -->
            <div class="border-top card-body text-center">Have an account? <a href="login">Log In</a></div>
        </div>
        <!-- card.// -->

    </div>


</body>
    
</html>

