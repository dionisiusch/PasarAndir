@extends('layouts.app')
@section('content')
             <div class="row"> 
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <h3 class="title-5 m-b-35">Master Data Lantai</h3>
                  <div class="table-data__tool-left">
                    <div class="rs-select2--light rs-select2--md" style="display: contents">
                       <input class="au-input au-input--xl" type="text" name="search" id="search" placeholder="Cari Data..." /><i style="font-size:150%" class="zmdi zmdi-search"></i>
                      
                      <button style="float:right" type="button" class="au-btn au-btn-icon au-btn--green au-btn--small" data-toggle="modal" data-target="#scrollmodal">
                       <i class="zmdi zmdi-plus"></i>Tambah Data</button>
                    </div>
                  </div>
                
                <div class="table-responsive table-responsive-data2">
                  <table class="table table-data2">
                    <thead>
                      <tr>
                        <th>Kode Lantai</th>
                        <th>Nama Lantai</th>
                        <th></th>
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
      <div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
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
                                        <strong>Tambah Data</strong> Lantai
                                    </div>
                                    <div class="card-body card-block">
                                        <form action="{{ route('master.floor.store') }}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label class="form-control-label">Kode Lantai</label>
                                                <input type="text" name="code" placeholder="Kode Lantai.." class="form-control">
                                            </div>
                                             <div class="form-group">
                                                <label class=" form-control-label">Nama Lantai</label>
                                                <input type="text" name="name" placeholder="Nama Lantai.." class="form-control">
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
      </div>
      <!-- end modal scroll -->

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
                                        <strong>Update Data</strong> Lantai
                                    </div>
                                    <div class="card-body card-block">
                                        <form id="update" action="" method="post">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label class="form-control-label">Kode Lantai</label>
                                                <input id="code-update" type="text" name="code" placeholder="Kode Lantai.." class="form-control">
                                            </div>
                                             <div class="form-group">
                                                <label class=" form-control-label">Nama Lantai</label>
                                                <input id="name-update" type="text" name="name" placeholder="Nama Lantai.." class="form-control">
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
   url:"/search",
   method:'GET',
   dataType:'json',
   data:{query:query},
   success:function(response)
   {
   $('tbody').html(response.table_data);
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
        url:'/master/floor/'+id,
        type: 'post',
        data: {_method: 'delete'},
    success: function(result) {
        $('.alert-success').html('<button type="button" class="close" data-dismiss="alert">×</button><strong>'+result+'</strong>');
        $(".alert-success").css("display", "block");
        fetch_customer_data();
        console.log(result);
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
   url:"/master/floor/"+id,
   method:'GET',
   dataType:'json',
   data:{id:id},
   success:function(response)
   {
   	 $('#update').attr('action', '/master/floor/'+id);
   	 $('#code-update').val(response.code);
   	 $('#name-update').val(response.name);
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
