@extends('layouts.app')
  @section('content')
               <div class="row"> 
              <div class="col-md-12">
                  <!-- DATA TABLE -->
                  <h3 class="title-5 m-b-35">Master Data Receipt</h3>
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
                          <th>Tanggal Pembayaran</th>
                          <th>Jumlah Pembayaran</th>
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
              <td id="electricity_meter_before"></td>
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
   url:"/receiptsearch",
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


});


</script>

  @endsection