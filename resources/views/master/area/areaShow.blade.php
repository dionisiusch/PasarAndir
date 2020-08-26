@extends('layouts.app')
@section('content')
             <div class="row"> 
            <div class="col-md-12">
                <!-- DATA TABLE -->
                <h3 class="title-5 m-b-35">Master Data Blok</h3>
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
                        <th>Blok</th>
                        <th>Nomor Blok</th>
                        <th>Harga/m</th>
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
                                        <strong>Tambah Data</strong> Blok
                                    </div>
                                    <div class="card-body card-block">
                                        <form action="{{ route('master.area.store') }}" method="post">
                                            @csrf
                                            <div class="form-group">
                                              <label class=" form-control-label">Lantai</label>
                                            <select name="floor_id" id='selFloor' class='form-control'>
                                            </select>
                                            </div>
                                             <div class="form-group">
                                                <label class=" form-control-label">Blok</label>
                                                <input type="text" name="name" placeholder="Blok.." class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label class=" form-control-label">Nomor Blok</label>
                                                <input type="text" name="no" placeholder="Nomor Blok.." class="form-control">
                                            </div>
                                             <div class="form-group">
                                                <label class=" form-control-label">Harga/m</label>
                                                <input type="text" id="price" name="price" placeholder="Harga.." class="form-control">
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
                                        <strong>Update Data</strong> Blok<div class="form-group">
                                    </div>
                                    <div class="card-body card-block">
                                        <form id="update" action="" method="post">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">    
                                                <label class="form-control-label">Lantai</label>
                                                <select name="floor_id" id='selFloor-update' class='form-control'>
                                            </select>
                                            </div>
                                             <div class="form-group">
                                                <label class=" form-control-label">Blok</label>
                                                <input id="blok-update" type="text" name="name" placeholder="Blok.." class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label class=" form-control-label">Nomor Blok</label>
                                                <input id="no-update" type="text" name="no" placeholder="Nomor Blok.." class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label class=" form-control-label">Harga/m</label>
                                                <input id="harga-update" type="text" name="price" placeholder="Harga.." class="form-control">
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
   url:"/areasearch",
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
        url:'/master/area/'+id,
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
   url:"/master/area/"+id,
   method:'GET',
   dataType:'json',
   data:{id:id},
   success:function(response)
   {
     $('#update').attr('action', '/master/area/'+id);
     $('#blok-update').val(response.name);
     $('#no-update').val(response.no);
     $('#harga-update').val() ;
     alert(rupiah(response.price));
     var option = new Option(response.floor_name, response.floor,false, false);
     option.selected = true;
     $("#selFloor-update" ).append(option);
     $("#selFloor-update" ).trigger("change");

   }, error: function(request,msg,error) {
       console.log(msg);
       console.log(error);
    }
  })
});

 $( "#selFloor" ).select2({
        maximumSelectionLength: 5,
        placeholder: "Kode Lantai..",
        dropdownParent: $("#scrollmodal"),
        ajax: { 
          url: "/floorselect2",
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

 $( "#selFloor-update" ).select2({
        maximumSelectionLength: 5,
        placeholder: "Kode Lantai..",
        dropdownParent: $("#scrollmodal-update"),
        ajax: { 
          url: "/floorselect2",
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

 function rupiah(angka){
  var number_string = angka.replace(/[^,\d]/g, '').toString(),
  split       = number_string.split('.'),
  sisa        = split[0].length % 3,
  rupiah        = split[0].substr(0, sisa),
  ribuan        = split[0].substr(sisa).match(/\d{3}/gi);
 
  // tambahkan titik jika yang di input sudah menjadi angka ribuan
  if(ribuan){
    separator = sisa ? '.' : '';
    rupiah += separator + ribuan.join('.');
  }
 
  rupiah = split[1] != undefined ? rupiah + '' + split[1] + '' : rupiah;
  return('Rp ' + rupiah);
}


 $(document).on('keyup', '#price', function(){
  var value = $(this).val();
  var result = rupiah(value);
  $(this).val(result);
 });

});
</script>

@endsection