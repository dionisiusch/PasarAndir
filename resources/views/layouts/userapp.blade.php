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
    <title>PT AMAN PRIMA JAYA</title>

    <!-- Fontfaces CSS-->
    <link href="{{ asset('css/font-face.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('assets/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('assets/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('assets/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">

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
    <div class="page-wrapper">
      <!-- HEADER MOBILE-->
      <header class="header-mobile d-block d-lg-none">
        <div class="header-mobile__bar">
          <div class="container-fluid">
            <div class="header-mobile-inner">
              <a class="logo" href="/home">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Pasar Andir" />
              </a>
              <button class="hamburger hamburger--slider" type="button">
                <span class="hamburger-box">
                  <span class="hamburger-inner"></span>
                </span>
              </button>
            </div>
          </div>
        </div>
        <nav class="navbar-mobile">
          <div class="container-fluid">
            <ul class="navbar-mobile__list list-unstyled">
              <li class="{{Request::routeIs('user.index') ? 'active' : '' }}">
                <a href="/user/index">
                  <i class="fas fa-tachometer-alt"></i>Dashboard</a>
              </li>
              <li class="{{Request::routeIs('user.billing') ? 'active' : '' }}">
                <a href="/user/billing">
                  <i class="fas fa-usd"></i>Billing</a>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- END HEADER MOBILE-->

      <!-- MENU SIDEBAR-->
      <aside class="menu-sidebar d-none d-lg-block">
        <div class="logo">
          <a href="#">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Pasar Andir" />
          </a>
        </div>
        <div class="menu-sidebar__content js-scrollbar1">
          <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
              <li class="{{Request::routeIs('user.index') ? 'active' : '' }}">
                <a href="/user/index">
                  <i class="fas fa-tachometer-alt"></i>Dashboard</a>
              </li>
              <li class="{{Request::routeIs('user.billing') ? 'active' : '' }}">
                <a href="/user/billing">
                  <i class="fas fa-usd"></i>Billing</a>
              </li>
            </ul>
          </nav>
        </div>
      </aside>
      <!-- END MENU SIDEBAR-->

      <!-- PAGE CONTAINER-->
      <div class="page-container">
        <!-- HEADER DESKTOP-->
        <header class="header-desktop">
          <div class="section__content section__content--p30">
            <div class="container-fluid">
              <div class="header-wrap">
                <!-- Not Used @dion-->
                <form class="form-header" action="" method="POST">
                  <input class="au-input au-input--xl" type="hidden" name="search"
                    placeholder="Search for datas &amp; reports..." />
                  <button class="au-btn--submit" type="hidden">
                    <i class="zmdi zmdi-search"></i>
                  </button>
                </form>
                <!-- Not Used @dion-->

                <div class="header-button">
                  <div class="account-wrap">
                    <div class="account-item clearfix js-item-menu">
                      <div class="content">
                        <a class="js-acc-btn" href="#">{{ Auth::guard('web')->user()->username }}</a>
                      </div>
                      <div class="account-dropdown js-dropdown">
                        <div class="info clearfix">
                          <div class="content">
                            <h5 class="name">
                              <a href="#">{{ Auth::guard('web')->user()->username }}</a>
                            </h5>
                          </div>
                        </div>
                        <div class="account-dropdown__body">
                        </div>
                        <div class="account-dropdown__footer">
                          <form id="logout-form" action="{{ url('logout') }}" method="POST">
                            {{ csrf_field() }}
                          </form>
                          <a onclick="document.getElementById('logout-form').submit()">
                            <i class="zmdi zmdi-power"></i>Logout</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </header>
        <!-- HEADER DESKTOP-->

        <!-- MAIN CONTENT-->
        <div class="main-content">

          <div class="section__content section__content--p30">
            <div class="container-fluid">
              @include('message')
              @yield('content')
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="copyright">
                <p>Copyright © 2020 CodeOnTop. All rights reserved. Template by <a
                    href="https://colorlib.com">Colorlib</a>.</p>
              </div>
            </div>
          </div>
        </div>
        <!-- END MAIN CONTENT-->
        <!-- END PAGE CONTAINER-->
      </div>

    </div>

    <!-- Jquery JS-->
    <script src="{{ asset('assets/jquery-3.2.1.min.js') }}"></script>
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