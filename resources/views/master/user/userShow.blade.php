@extends('layouts.app')
@section('content')
             <div class="row"> 
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <h3 class="title-5 m-b-35">Master Data User</h3>
                  <div class="table-data__tool-left">
                    <div class="rs-select2--light rs-select2--md" style="display: contents">
                       <input class="au-input au-input--xl" type="text" name="search" id="search" placeholder="Cari Data..." /><i style="font-size:150%" class="zmdi zmdi-search"></i>
                      
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

      

         <!-- modal scroll update -->
      <div class="modal fade" id="scrollmodal-update" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
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
                                                <input type="number" id="pic_phone_number" name="pic_phone_number" placeholder="Nomor Telepon.." class="form-control">
                                                <label class=" form-control-label">Tanggal Gabung</label>
                                                <input type="date" id="joined_date" name="joined_date" placeholder="Tanggal Gabung.." class="form-control">
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


<script src="{{ asset('assets/jquery-3.2.1.min.js') }}"></script>
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
