@extends('layouts.app')
  @section('content')
               <div class="row"> 
              <div class="col-md-12">
                  <!-- DATA TABLE -->
                  <h3 class="title-5 m-b-35">Master Data Invoice</h3>
                    <div class="table-data__tool-left">
                      <div class="rs-select2--light rs-select2--md" style="display: contents">
                         <input class="au-input au-input--xl" type="text" name="search" id="search" placeholder="Cari Data..." /><i style="font-size:150%" class="zmdi zmdi-search"></i>
                      </div>
                    </div>
                  
                  <div class="table-responsive table-responsive-data2">
                    <table class="table table-data2">
                      <thead>
                       <tr>
                          <th>User</th>
                          <th>Blok</th>
                          <th>Nama Toko</th>
                          <th>Periode</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody id="ajax">
                      </tbody>
                    </table>
                  <!-- END DATA TABLE -->
                </div>
              </div>

          </div>
  </div>
</div>

     <!-- modal scroll -->
      <!-- <div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel" aria-hidden="true">
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
      </div> -->
      <!-- end modal scroll -->

      <!-- modal large -->
			<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" style="max-width:1200px"role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="largeModalLabel">Detail Invoice</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<table class="table table-bordered">
              <tbody id="modal-invoice">
              <tr>
              <td colspan='8' style="background-color:#ffd2a6"></td>
              </tr>
              <tr>
              <td style="font-weight:bold">NAMA</td>
              <td colspan='3' id="name"></td>
              <td style="font-weight:bold">BULAN/TAHUN</td>
              <td colspan='3' id="month_bill"></td>
              </tr>
              <tr>
              <td style="font-weight:bold">LOKASI/BLOK</td>
              <td colspan='3' id="area"></td>
              <td style="font-weight:bold">JATUH TEMPO</td>
              <td colspan='3' id="grace_date"></td>
              </tr>
              <tr>
              <td colspan='8' style="background-color:#ffd2a6;text-align:center;font-weight:bold">RINCIAN PEMAKAIAN DAN TAGIHAN</td>
              </tr>
              <td colspan="2" style="font-weight:bold">SATUAN</td>
              <td style="font-weight:bold">BEBAN</td>
              <td style="font-weight:bold">TARIF/KWH</td>
              <td style="font-weight:bold">BIAYA PEMAKAIAN/KWH</td>
              <td style="font-weight:bold">TAGIHAN</td>
              <td id="sub_total"></td>
              <td style="font-weight:bold">TOTAL TAGIHAN</td>
              </tr>
              <tr>
              <td style="font-weight:bold">DATA</td>
              <td id="power_meter"></td>
              <td rowspan="4" id="area_price"></td>
              <td rowspan="4" id="kwh_price"></td>
              <td rowspan="4" id="electricity_bill"></td>
              <td style="font-weight:bold">BIAYA ADMIN</td>
              <td></td>
              <td rowspan="4" id="total"></td>
              </tr>
              <tr>
              <td style="font-weight:bold">STAND AWAL</td>
              <td id="electricity_meter_before">2289</td>
              <td style="font-weight:bold">BIAYA PERAWATAN</td>
              <td></td>
              </tr>
              <tr>
              <td style="font-weight:bold">STAND AKHIR</td>
              <td id="electricity_meter_after"></td>
              <td></td>
              <td></td>
              </tr>
              <tr>
              <td style="font-weight:bold">PEMAKAIAN/KWH</td>
              <td id="electricity_meter_used"></td>
              <td></td>
              <td></td>
              <tr>
              <td colspan='4'></td>
              </tr>
              </tbody>
              </table>
						</div>
					</div>
				</div>
			</div>
			<!-- end modal large -->

       



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
   url:"/invoicesearch",
   method:'GET',
   dataType:'json',
   data:{query:query},
   success:function(response)
   {
   $('#ajax').html(response.table_data);
   }, error: function(request,msg,error) {
       console.log(msg);
       console.log(error);
    }
  })
 }

 function rupiah(angka){
  var angka_str = angka.toString(); 
  var number_string = angka_str.replace(/[^,\d]/g, ''),
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

 $(document).on('keyup', '#search', function(){
  var query = $(this).val();
  fetch_customer_data(query);
 });

 $(document).on('click', '.invoice-row', function(){
  var id = $(this).attr('id');
   $.ajax({
        url:'/master/invoice/'+id,
        type: 'get',
        dataType:'json',
        data: {id:id},
    success: function(response) {
      $('#name').html(response.pic_name);
      $('#month_bill').html(response.month_bill);
      $('#area').html(response.area_name);
      $('#power_meter').html(response.electricity_power_meter);
      $('#sub_total').html(rupiah(response.sub_total));
      $('#area_price').html(rupiah(response.area_price));
      $('#electricity_bill').html(rupiah(response.electricity_bill));
      $('#total').html(rupiah(response.grand_total));
      $('#electricity_meter_before').html(response.electricity_meter_before);
      $('#electricity_meter_after').html(response.electricity_meter_after);
      $('#electricity_meter_used').html(response.electricity_meter_used);
      $('#kwh_price').html(rupiah(response.kwh_price));
      $('#grace_date').html(response.grace_date);
    },
    error: function(request,msg,error) {
       console.log(msg);
       console.log(error);
    }
});
 });

 $(document).on('click', '.delete', function(){
  var id = $(this).attr('id');
  if(confirm("Hapus data ini?"))
  {
   $.ajax({
        url:'/master/invoice/'+id,
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

//  $(document).on('click', '.edit', function(){

//    var id = $(this).attr('id');

//      $.ajax({
//    url:"/master/stall/"+id,
//    method:'GET',
//    dataType:'json',
//    data:{id:id},
//    success:function(response)
//    {
//      $('#update').attr('action', '/master/stall/'+id);
//      $('#name-update').val(response.name);
//      $('#length-update').val(response.length);
//      $('#width-update').val(response.width);
//      $('#height-update').val(response.height);
     
//      var option = new Option(response.pic_name, response.user_id,false, false);
//      option.selected = true;
//      $("#selUser-update" ).append(option);
//      $("#selUser-update" ).trigger("change");

//      var option = new Option(response.category_name, response.category_id,false, false);
//      option.selected = true;
//      $("#selKategori-update" ).append(option);
//      $("#selKategori-update" ).trigger("change");

//      var area_text = response.floor_name+" Blok "+response.area_name+" No. "+response.area_no;
//      var option = new Option(area_text, response.area_id,false, false);
//      option.selected = true;
//      $("#selArea-update" ).append(option);
//      $("#selArea-update" ).trigger("change");

//      if(response.status=="Aktif"){
//       $("#status-update").val("Aktif").change();
//      }else{
//       $("#status-update").val("Tidak Aktif").change();;
//      }

//    }, error: function(request,msg,error) {
//        console.log(msg);
//        console.log(error);
//     }
//   })
// });


//  $( "#selUser" ).select2({
//         maximumSelectionLength: 5,
//         placeholder: "User..",
//         dropdownParent: $("#scrollmodal"),
//         ajax: { 
//           url: "/userselect2",
//           dataType: 'json',
//           type:'get',
//           delay: 250,
//           data: function (params) {
//             return {
//               search: params.term // search term
//             };
//           },
//           processResults: function (response) {
//             console.log(response);
//             return {
//               results: response
//             };
//           },
//           cache: false
//         }

//       });


});


</script>

  @endsection