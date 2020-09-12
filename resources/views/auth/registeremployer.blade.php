<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags-->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="au theme template">
        <meta name="author" content="Hau Nguyen">
        <meta name="keywords" content="au theme template">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Title Page-->
        <title>Dashboard</title>

        <!-- Fontfaces CSS-->
        <link href="{{ asset('css/font-face.css') }}" rel="stylesheet" media="all">
        <link href="{{ asset('assets/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
        <link href="{{ asset('assets/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
        <link href="{{ asset('assets/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet"
            media="all">

        <!-- Bootstrap CSS-->
        <link href="{{ asset('assets/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">

        <!-- assets CSS-->
        <link href="{{ asset('assets/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
        <link href="{{ asset('assets/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet"
            media="all">
        <link href="{{ asset('assets/wow/animate.css') }}" rel="stylesheet" media="all">
        <link href="{{ asset('assets/css-hamburgers/hamburgers.min.css') }}" rel="stylesheet" media="all">
        <link href="{{ asset('assets/slick/slick.css') }}" rel="stylesheet" media="all">
        <link href="{{ asset('assets/select2/select2.min.css') }}" rel="stylesheet" media="all">
        <link href="{{ asset('assets/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" media="all">

        <!-- Main CSS-->
        <link href="{{ asset('css/theme.css') }}" rel="stylesheet" media="all">

    </head>

    <body class="animsition">
        <div class="page-wrapper" style="overflow:auto">
            <div class="page-content--bge5">
                <div class="container">
                    <div class="login-wrap">
                        <div class="login-content">
                            <div class="login-logo">
                                <a href="/">
                                    <img src="{{ asset('assets/img/logo.png') }}" alt="Pasar Andir">
                                </a>
                            </div>
                            <div class="login-form">
                                <form method="POST" action="{{ route('master.employer.store') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input id="username" type="text"
                                            class="form-control @error('username') is-invalid @enderror" name="username"
                                            value="{{ old('username') }}" required autocomplete="username" autofocus>

                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Role</label>
                                        <select name="role_id" id='selRole' class='form-control' required>
                                        </select>
                                        @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Password</label>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="new-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>Confirm Password</label>
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                    <div class="form-group">
                                        <label>PIC Name</label>
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autocomplete="name">

                                        @error('pic_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>E-mail</label>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label>PIC Phone Number</label>
                                        <input id="phone_number" type="text"
                                            class="form-control @error('phone_number') is-invalid @enderror"
                                            name="phone_number" value="{{ old('phone_number') }}" required
                                            autocomplete="phone_number">

                                        @error('pic_phone_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <button class="au-btn au-btn--block au-btn--green m-b-20"
                                        type="submit">register</button>
                                </form>
                                <div class="register-link">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Jquery JS-->

        <!-- Bootstrap JS-->
        <script src="{{ asset('assets/bootstrap-4.1/popper.min.js') }}"></script>
        <script src="{{ asset('assets/bootstrap-4.1/bootstrap.min.js') }}"></script>
        <!-- assets JS       -->
        <script src="{{ asset('assets/slick/slick.min.js') }}">
        </script>
        <script src="{{ asset('assets/wow/wow.min.js') }}"></script>
        <script src="{{ asset('assets/animsition/animsition.min.js') }}"></script>
        <script src="{{ asset('assets/bootstrap-progressbar/bootstrap-progressbar.min.js') }}">
        </script>
        <script src="{{ asset('assets/counter-up/jquery.waypoints.min.js') }}"></script>
        <script src="{{ asset('assets/counter-up/jquery.counterup.min.js') }}">
        </script>
        <script src="{{ asset('assets/circle-progress/circle-progress.min.js') }}"></script>
        <script src="{{ asset('assets/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
        <script src="{{ asset('assets/chartjs/Chart.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/select2/select2.min.js') }}">
        </script>

        <!-- Main JS-->
        <script src="{{ asset('js/main.js') }}"></script>

    </body>

</html>
<!-- end document-->

<script>
    $(document).ready(function(){
        $( "#selRole" ).select2({
        maximumSelectionLength: 5,
        placeholder: "Role..",
        ajax: {
        url: "/roleselect2",
        dataType: 'json',
        type:'get',
        delay: 250,
        data: function (params) {
        return {
        search: params.term // search term
        };
        },
        processResults: function (response) {
        console.log(response);
        return {
        results: response
        };
        },
        cache: false
        }
        
        });
    });

</script>