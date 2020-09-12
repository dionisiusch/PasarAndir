@extends('layouts.app')
@section('content')
<div class="row">
  <div class="col-md-12">
    <!-- DATA TABLE -->
    <h3 class="title-5 m-b-35">Master Data Listrik</h3>
    <div class="table-data__tool-left">
      <div class="rs-select2--light rs-select2--md" style="display: contents">
        <input class="au-input au-input--xl" type="text" name="search" id="search" placeholder="Cari Data..." /><i
          style="font-size:150%" class="zmdi zmdi-search"></i>

        <button style="float:right" type="button" class="au-btn au-btn-icon au-btn--green au-btn--small"
          data-toggle="modal" data-target="#scrollmodal">
          <i class="zmdi zmdi-plus"></i>Tambah Data</button>
      </div>
    </div>

    <div class="table-responsive table-responsive-data2">
      <table class="table table-data2">
        <thead>
          <tr>
            <th>Kode Listrik</th>
            <th>Daya(W)</th>
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
            <strong>Tambah Data</strong> Listrik
          </div>
          <div class="card-body card-block">
            <form action="{{ route('master.electricity.store') }}" method="post">
              @csrf
              <div class="form-group">
                <label class="form-control-label">Kode Listrik</label>
                <input id="name" type="text" name="name" placeholder="Kode Listrik.." class="form-control">
              </div>
              <div class="form-group">
                <label class=" form-control-label">Daya</label>
                <select id="selPowermeter" name="power_meter_id" placeholder="Daya.." class="form-control"></select>
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
            <strong>Update Data</strong> Listrik
          </div>
          <div class="card-body card-block">
            <form id="update" action="" method="post">
              @csrf
              @method('PUT')
              <div class="form-group">
                <label class="form-control-label">Kode Listrik</label>
                <input id="name-update" type="text" name="name" placeholder="Kode Listrik.." class="form-control">
              </div>
              <div class="form-group">
                <label class=" form-control-label">Daya(W)</label>
                <select id="selPowermeter-update" name="power_meter_id" placeholder="Daya.."
                  class="form-control"></select>
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


 function fetch_customer_data(query = '')
 {
  $.ajax({
   url:"/electricitysearch",
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
        url:'/master/electricity/'+id,
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
   url:"/master/electricity/"+id,
   method:'GET',
   dataType:'json',
   data:{id:id},
   success:function(response)
   {
     $('#update').attr('action', '/master/electricity/'+id);
     $('#name-update').val(response.name);
     $('#power_meter-update').val(response.power_meter);
     $('#kva-update').val(rupiah(response.kva_price.toString()));
     $('#kwh-update').val(rupiah(response.kwh_price.toString()));

     var option = new Option(response.power_meter+" W", response.power_meter_id,false, false);
      option.selected = true;
      $("#selPowermeter-update" ).append(option);
      $("#selPowermeter-update" ).trigger("change");
        console.log(response);
   }, error: function(request,msg,error) {
       console.log(msg);
       console.log(error);
    }
  })
});

$( "#selPowermeter" ).select2({
placeholder: "Daya..",
dropdownParent: $("#scrollmodal"),
ajax: {
url: "/powermeterselect2",
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

$( "#selPowermeter-update" ).select2({
placeholder: "Daya..",
dropdownParent: $("#scrollmodal-update"),
ajax: {
url: "/powermeterselect2",
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

 $(document).on('keyup', '#kva', function(){
  var value = $(this).val();
  var result = rupiah(value);
  $('#kva').val(result);
 });


 $(document).on('keyup', '#kwh', function(){
  var value = $(this).val();
  var result = rupiah(value);
  $('#kwh').val(result);
 });

 $(document).on('keyup', '#kva-update', function(){
  var value = $(this).val();
  var result = rupiah(value);
  $('#kva-update').val(result);
 });


 $(document).on('keyup', '#kwh-update', function(){
  var value = $(this).val();
  var result = rupiah(value);
  $('#kwh-update').val(result);
 });


});
  </script>

  @endsection