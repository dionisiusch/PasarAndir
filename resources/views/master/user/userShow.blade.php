@extends('layouts.app')
@section('content')
<div class="row">
  <div class="col-md-12">
    <!-- DATA TABLE -->
    <h3 class="title-5 m-b-35">Master Data User</h3>
    <div class="table-data__tool-left">
      <div class="rs-select2--light rs-select2--md" style="display: contents">
        <input class="au-input au-input--xl" type="text" name="search" id="search" placeholder="Cari Data..." /><i
          style="font-size:150%" class="zmdi zmdi-search"></i>
        <button style="float:right" type="button" class="au-btn au-btn-icon au-btn--green au-btn--small"
          data-toggle="modal" data-target="#scrollmodal">
          <i class="zmdi zmdi-plus"></i>Tambah User</button>
      </div>
    </div>

    <div class="table-responsive table-responsive-data2">
      <table class="table table-data2">
        <thead>
          <tr>
            <th>Username</th>
            <th>Nama PIC</th>
            <th>No. Telp</th>
            <th>Tanggal Gabung</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
      <!-- END DATA TABLE -->
    </div>
  </div>

</div>
</div>

</div>

<!-- modal scroll -->
<div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card">
          <div class="card-header">
            <strong>Tambah Data</strong> User
          </div>
          <div class="card-body card-block">
            <form method="POST" action="{{ route('register') }}">
              @csrf
              <div class="form-group">
                <label>Username</label>
                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                  name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                @error('username')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <div class="form-group">
                <label>Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                  name="password" required autocomplete="new-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <div class="form-group">
                <label>Confirm Password</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                  autocomplete="new-password">
              </div>
              <div class="form-group">
                <label>PIC Name</label>
                <input id="pic_name" type="text" class="form-control @error('pic_name') is-invalid @enderror"
                  name="pic_name" value="{{ old('pic_name') }}" autocomplete="pic_name">

                @error('pic_name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <div class="form-group">
                <label>PIC Phone Number</label>
                <input id="pic_phone_number" type="text"
                  class="form-control @error('pic_phone_number') is-invalid @enderror" name="pic_phone_number"
                  value="{{ old('pic_phone_number') }}" autocomplete="pic_phone_number">

                @error('pic_phone_number')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
              <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">register</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end modal scroll -->



  <!-- modal scroll update -->
  <div class="modal fade" id="scrollmodal-update" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card">
            <div class="card-header">
              <strong>Update Data</strong> User
            </div>
            <div class="card-body card-block">
              <form id="update" action="" method="post">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label class=" form-control-label">Username</label>
                  <input type="text" id="username" placeholder="Username.." class="form-control" readonly>
                  <label class=" form-control-label">Nama PIC</label>
                  <input type="text" id="pic_name" name="pic_name" placeholder="Nama PIC.." class="form-control">
                  <label class=" form-control-label">Nomor Telepon</label>
                  <input type="number" id="pic_phone_number" name="pic_phone_number" placeholder="Nomor Telepon.."
                    class="form-control">
                  <label class=" form-control-label">Tanggal Gabung</label>
                  <input type="date" id="joined_date" name="joined_date" placeholder="Tanggal Gabung.."
                    class="form-control">
                </div>

            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary btn-sm" style="float:right;">
                <i class="fa fa-dot-circle-o"></i> Submit
              </button>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- end modal scroll -->



    <script>
      $(document).ready(function(){
$.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

 fetch_customer_data();

 function fetch_customer_data(query = '')
 {
  $.ajax({
   url:"/usersearch",
   method:'GET',
   dataType:'json',
   data:{query:query},
   success:function(response)
   {
   $('tbody').html(response.table_data);
   }, error: function(jqxhr, status, exception) {
             console.log('Exception:', exception);
    }
  })
 }

 $(document).on('keyup', '#search', function(){
  var query = $(this).val();
  fetch_customer_data(query);
 });

 $(document).on('click', '.delete', function(){
  var id = $(this).attr('id');
  if(confirm("Hapus data ini?"))
  {
   $.ajax({
        url:'/master/user/'+id,
        type: 'post',
        data: {_method: 'delete'},
    success: function(result) {
        $('.alert-success').html('<button type="button" class="close" data-dismiss="alert">×</button><strong>'+result+'</strong>');
        $(".alert-success").css("display", "block");
        fetch_customer_data();
    },
    error: function(request,msg,error) {
       console.log(msg);
       console.log(error);
    }
});
  }
 });


$(document).on('click', '.edit', function(){

   var id = $(this).attr('id');

     $.ajax({
   url:"/master/user/"+id,
   method:'GET',
   dataType:'json',
   data:{id:id},
   success:function(response)
   {
   	 $('#update').attr('action', '/master/user/'+id+"/pic");
     $('#username').val(response.username);
   	 $('#pic_name').val(response.pic_name);
     $('#pic_phone_number').val(response.pic_phone_number);
     $('#joined_date').val(response.joined_date);
   console.log(response);
   }, error: function(request,msg,error) {
       console.log(msg);
       console.log(error);
    }
  })



});

});
    </script>

    @endsection