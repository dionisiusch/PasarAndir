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
    <title>Register</title>

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
                            <form method="POST" action="{{ route('register') }}">
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
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                                <div class="form-group">
                                    <label>PIC Name</label>
                                    <input id="pic_name" type="text" class="form-control @error('pic_name') is-invalid @enderror" name="pic_name" value="{{ old('pic_name') }}" required autocomplete="pic_name">

                                @error('pic_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <div class="form-group">
                                    <label>PIC Phone Number</label>
                                    <input id="pic_phone_number" type="text" class="form-control @error('pic_phone_number') is-invalid @enderror" name="pic_phone_number" value="{{ old('pic_phone_number') }}" required autocomplete="pic_phone_number" >

                                @error('pic_phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <div class="login-checkbox">
                                    <label>
                                        <input type="checkbox" name="aggree">Agree the terms and policy
                                    </label>
                                </div>
                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">register</button>
                            </form>
                            <div class="register-link">
                                <p>
                                    Already have account?
                                    <a href="/login">Sign In</a>
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
