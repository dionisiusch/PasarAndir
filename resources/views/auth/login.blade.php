    <!DOCTYPE html>
    <html lang="en">

    <head>
        <!-- Required meta tags-->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="au theme template">
        <meta name="author" content="Hau Nguyen">
        <meta name="keywords" content="au theme template">

        <!-- Title Page-->
        <title>Login</title>

        <!-- Fontfaces CSS-->
        <link href="../css/font-face.css" rel="stylesheet" media="all">
        <link href="../assets/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
        <link href="../assets/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
        <link href="../assets/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

        <!-- Bootstrap CSS-->
        <link href="../assets/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

        <!-- Vendor CSS-->
        <link href="../assets/animsition/animsition.min.css" rel="stylesheet" media="all">
        <link href="../assets/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
        <link href="../assets/wow/animate.css" rel="stylesheet" media="all">
        <link href="../assets/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
        <link href="../assets/slick/slick.css" rel="stylesheet" media="all">
        <link href="../assets/select2/select2.min.css" rel="stylesheet" media="all">
        <link href="../assets/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

        <!-- Main CSS-->
        <link href="../css/theme.css" rel="stylesheet" media="all">

    </head>

    <body class="animsition">
        <div class="page-wrapper">
            <div class="page-content--bge5">
                <div class="container">
                    <div class="login-wrap">
                        <div class="login-content">
                            <div class="login-logo">
                                <a href="#">
                                    <img src="{{ asset('assets/img/logo.png') }}" alt="Pasar Andir">
                                </a>
                            </div>
                            <div class="login-form">
                               <div class="card">
                                        <div class="card-body">
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#user" role="tab" aria-controls="home" aria-selected="true">User</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#admin" role="tab" aria-controls="profile" aria-selected="false">Admin</a>
                                                </li>
                                            </ul>
                                            <div class="tab-content pl-3 p-1" id="myTabContent">
                                                <div class="tab-pane fade show active" id="user" role="tabpanel" aria-labelledby="home-tab">
                                                    <form method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label>Username</label>
                                    
                                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                               
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                    <div class="login-checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            Remember Me
                                        </label>
                                        @if (Route::has('password.request'))
                                        <label>
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                        </label>
                                        @endif
                                    </div>
                                    <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">sign in</button>
                                </form>
                                                </div>
                                                <div class="tab-pane fade" id="admin" role="tabpanel" aria-labelledby="profile-tab">
                                                     <form method="POST" action="">
                                    @csrf
                                    <div class="form-group">
                                        <label>Username Admin</label>
                                    
                                        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                        @error('username')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                               
                                    </div>
                                    <div class="form-group">
                                        <label>Password Admin</label>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                    <div class="login-checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            Remember Me
                                        </label>
                                        @if (Route::has('password.request'))
                                        <label>
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                        </label>
                                        @endif
                                    </div>
                                    <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">sign in</button>
                                </form>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                <div class="register-link">
                                    <p>
                                        Don't you have account?
                                        <a href="/register">Sign Up Here</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Jquery JS-->
        <script src="../assets/jquery-3.2.1.min.js"></script>
        <!-- Bootstrap JS-->
        <script src="../assets/bootstrap-4.1/popper.min.js"></script>
        <script src="../assets/bootstrap-4.1/bootstrap.min.js"></script>
        <!-- Vendor JS       -->
        <script src="../assets/slick/slick.min.js">
        </script>
        <script src="../assets/wow/wow.min.js"></script>
        <script src="../assets/animsition/animsition.min.js"></script>
        <script src="../assets/bootstrap-progressbar/bootstrap-progressbar.min.js">
        </script>
        <script src="../assets/counter-up/jquery.waypoints.min.js"></script>
        <script src="../assets/counter-up/jquery.counterup.min.js">
        </script>
        <script src="../assets/circle-progress/circle-progress.min.js"></script>
        <script src="../assets/perfect-scrollbar/perfect-scrollbar.js"></script>
        <script src="../assets/chartjs/Chart.bundle.min.js"></script>
        <script src="../assets/select2/select2.min.js">
        </script>

        <!-- Main JS-->
        <script src="../js/main.js"></script>

    </body>

    </html>
    <!-- end document-->