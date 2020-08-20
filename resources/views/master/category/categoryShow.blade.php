@extends('layouts.app')
@section('content')
             <div class="row"> 
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <h3 class="title-5 m-b-35">Master Data Kategori</h3>
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
                        <th>Nama Kategori</th>
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
                                        <strong>Tambah Data</strong> Kategori
                                    </div>
                                    <div class="card-body card-block">
                                        <form action="{{ route('master.category.store') }}" method="post">
                                            @csrf
                                             <div class="form-group">
                                                <label class=" form-control-label">Nama Kategori</label>
                                                <input type="text" name="name" placeholder="Nama Kategori.." class="form-control">
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
                                        <strong>Update Data</strong> Kategori
                                    </div>
                                    <div class="card-body card-block">
                                        <form id="update" action="" method="post">
                                            @csrf
                                            @method('PUT')
                                             <div class="form-group">
                                                <label class=" form-control-label">Nama Kategori</label>
                                                <input id="name-update" type="text" name="name" placeholder="Nama Kategori.." class="form-control">
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
   url:"/categorysearch",
   method:'GET',
   dataType:'json',
   data:{query:query},
   success:function(response)
   {
   $('tbody').html(response.table_data);
   }, error: function(request,msg,error) {
       console.log(msg);
       console.log(error);
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
        url:'/master/category/'+id,
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
   url:"/master/category/"+id,
   method:'GET',
   dataType:'json',
   data:{id:id},
   success:function(response)
   {
   	 $('#update').attr('action', '/master/category/'+id);
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
