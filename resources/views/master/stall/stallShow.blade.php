  @extends('layouts.app')
  @section('content')
               <div class="row"> 
              <div class="col-md-12">
                  <!-- DATA TABLE -->
                  <h3 class="title-5 m-b-35">Master Data Kios</h3>
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
                          <th>User</th>
                          <th>Blok</th>
                          <th>Kategori</th>
                          <th>Nama Kios</th>
                          <th>Panjang(m)</th>
                          <th>Lebar(m)</th>
                          <th>Tinggi(m)</th>
                          <th>Status</th>
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
                                        <strong>Tambah Data</strong> Kios
                                    </div>
                                    <div class="card-body card-block">
                                        <form action="{{ route('master.stall.store') }}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label class="form-control-label">User</label>
                                                <select name="user_id" id='selUser' class='form-control'></select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label">Blok</label>
                                               <select name="area_id" id='selArea' class='form-control'>
                                            </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-control-label">Kategori</label>
                                                <select name="category_id" id='selKategori' class='form-control'>
                                            </select>
                                            </div>
                                             <div class="form-group">
                                                <label class=" form-control-label">Nama Kios</label>
                                                <input type="text" name="name" id='name' placeholder="Nama Kios.." class="form-control">
                                            </div>
                                             <div class="form-group">
                                                <label class=" form-control-label">Panjang(m)</label>
                                                <input type="number" name="length" id='length' placeholder="Panjang.." class="form-control">
                                            </div>
                                             <div class="form-group">
                                                <label class=" form-control-label">Lebar(m)</label>
                                                <input type="number" name="width" id='width' placeholder="Lebar.." class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label class=" form-control-label">Tinggi(m)</label>
                                                <input type="number" name="height" id='height' placeholder="Tinggi.." class="form-control">
                                            </div>
                                             <div class="form-group">
                                                <label class=" form-control-label">Status</label>
                                                  <select class="form-control" name="status" id="status">
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                          </select>
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
                                        <strong>Update Data</strong> Kios
                                    </div>
                                    <div class="card-body card-block">
                                        <form id="update" action="" method="post">
                                            @csrf
                                            @method('PUT')
                                           <div class="form-group">
                                              <label class=" form-control-label">User</label>
                                            <select name="user_id" id='selUser-update' class='form-control'>
                                            </select>
                                            <div class="form-group">
                                              <label class=" form-control-label">Blok</label>
                                            <select name="area_id" id='selArea-update' class='form-control'>
                                            </select>
                                            <div class="form-group">
                                              <label class=" form-control-label">Kategori</label>
                                            <select name="category_id" id='selKategori-update' class='form-control'>
                                            </select>
                                            </div>
                                             <div class="form-group">
                                                <label class=" form-control-label">Nama Kios</label>
                                                <input type="text" name="name" id='name-update' placeholder="Nama Kios.." class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label class=" form-control-label">Panjang(m)</label>
                                                <input type="number" name="length" id='length-update' placeholder="Panjang.." class="form-control">
                                            </div>
                                             <div class="form-group">
                                                <label class=" form-control-label">Lebar(m)</label>
                                                <input type="number" name="width" id='width-update' placeholder="Lebar.." class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label class=" form-control-label">Tinggi(m)</label>
                                                <input type="number" name="height" id='height-update' placeholder="Tinggi.." class="form-control">
                                            </div>
                                             <div class="form-group">
                                                <label class=" form-control-label">Status</label>
                                                  <select class="form-control" name="status" id="status-update">
                            <option value="Aktif">Aktif</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                          </select>
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
   url:"/stallsearch",
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
        url:'/master/stall/'+id,
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
   url:"/master/stall/"+id,
   method:'GET',
   dataType:'json',
   data:{id:id},
   success:function(response)
   {
     $('#update').attr('action', '/master/stall/'+id);
     $('#name-update').val(response.name);
     $('#length-update').val(response.length);
     $('#width-update').val(response.width);
     $('#height-update').val(response.height);
     
     var option = new Option(response.pic_name, response.user_id,false, false);
     option.selected = true;
     $("#selUser-update" ).append(option);
     $("#selUser-update" ).trigger("change");

     var option = new Option(response.category_name, response.category_id,false, false);
     option.selected = true;
     $("#selKategori-update" ).append(option);
     $("#selKategori-update" ).trigger("change");

     var area_text = response.floor_name+" Blok "+response.area_name+" No. "+response.area_no;
     var option = new Option(area_text, response.area_id,false, false);
     option.selected = true;
     $("#selArea-update" ).append(option);
     $("#selArea-update" ).trigger("change");

     if(response.status=="Aktif"){
      $("#status-update").val("Aktif").change();
     }else{
      $("#status-update").val("Tidak Aktif").change();;
     }

   }, error: function(request,msg,error) {
       console.log(msg);
       console.log(error);
    }
  })
});


 $( "#selUser" ).select2({
        maximumSelectionLength: 5,
        placeholder: "User..",
        dropdownParent: $("#scrollmodal"),
        ajax: { 
          url: "/userselect2",
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

  $( "#selArea" ).select2({
        maximumSelectionLength: 5,
        placeholder: "Blok..",
        dropdownParent: $("#scrollmodal"),
        ajax: { 
          url: "/areaselect2",
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

   $( "#selKategori" ).select2({
        maximumSelectionLength: 5,
        placeholder: "Kategori..",
        dropdownParent: $("#scrollmodal"),
        ajax: { 
          url: "/categoryselect2",
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

 $( "#selUser-update" ).select2({
        maximumSelectionLength: 5,
        placeholder: "User..",
        dropdownParent: $("#scrollmodal-update"),
        ajax: { 
          url: "/userselect2",
          dataType: 'json',
          type:'get',
          delay: 250,
          data: function (params) {
            return {
              search: params.term // search term
            };
          },
          processResults: function (response) {
            return {
              results: response
            };
          },
          cache: false
        }

      });

  $( "#selArea-update" ).select2({
        maximumSelectionLength: 5,
        placeholder: "Area..",
        dropdownParent: $("#scrollmodal-update"),
        ajax: { 
          url: "/areaselect2",
          dataType: 'json',
          type:'get',
          delay: 250,
          data: function (params) {
            return {
              search: params.term // search term
            };
          },
          processResults: function (response) {
            return {
              results: response
            };
          },
          cache: false
        }

      });

   $( "#selKategori-update" ).select2({
        maximumSelectionLength: 5,
        placeholder: "Kategori..",
        dropdownParent: $("#scrollmodal-update"),
        ajax: { 
          url: "/categoryselect2",
          dataType: 'json',
          type:'get',
          delay: 250,
          data: function (params) {
            return {
              search: params.term // search term
            };
          },
          processResults: function (response) {
            return {
              results: response
            };
          },
          cache: false
        }

      });

});


</script>

  @endsection