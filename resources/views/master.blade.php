@extends('layouts.app')

@section('content')
     <div class="section__content section__content--p30">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12">
                <div class="overview-wrap">
                  <h2 class="title-1">master data</h2>
                </div>
              </div>
            </div>
          <div class="row m-t-25">
             
            <div class="col-md-6 col-lg-3">  

              <div class="statistic__item statistic__item--green" onclick="location.href='{{ url('master/area/') }}'">       
                <h2 class="text">Area</h2>
                <div class="icon">
                  <i class="zmdi zmdi-pin-drop"></i>
                </div>
              </div>

            </div>
             
             <div class="col-md-6 col-lg-3">
              <div class="statistic__item statistic__item--blue" onclick="location.href='{{ url('master/category/') }}'">
                <h2 class="text">Kategori</h2>
                <div class="icon">
                  <i class="zmdi zmdi-format-align-left"></i>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="statistic__item statistic__item--red" onclick="location.href='{{ url('master/electricity/') }}'">
                <h2 class="text">Listrik</h2>
                <div class="icon">
                  <i class="zmdi zmdi-flash"></i>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="statistic__item statistic__item--orange">
                <h2 class="text">Karyawan</h2>
                <div class="icon">
                  <i class="zmdi zmdi-accounts-alt"></i>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="statistic__item statistic__item--red" onclick="location.href='{{ url('master/floor') }}'">       
                <h2 class="text">Lantai</h2>
                <div class="icon">
                   <i class="zmdi zmdi-collection-item-3"></i>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="statistic__item statistic__item--orange">
                <h2 class="text">Invoice</h2>
                <div class="icon">
                  <i class="zmdi zmdi-money"></i>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="statistic__item statistic__item--green">
                <h2 class="text">Receipt</h2>
                <div class="icon">
                  <i class="zmdi zmdi-receipt"></i>
                </div>
              </div>
            </div>
               <div class="col-md-6 col-lg-3">
              <div class="statistic__item statistic__item--blue" onclick="location.href='{{ url('master/stall') }}'">
                <h2 class="text">Kios</h2>
                <div class="icon">
                   <i class="zmdi zmdi-home"></i>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-3">
              <div class="statistic__item statistic__item--green" onclick="location.href='{{ url('master/user/') }}'">
                <h2 class="text">User</h2>
                <div class="icon">
                  <i class="zmdi zmdi-accounts-list-alt"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
           
        </div>
      </div>
    </div>

@endsection
