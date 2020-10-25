@extends('layouts.app')

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <strong>Pembayaran</strong>
      </div>
      <div class="card-body card-block">
        <form action="{{ route('master.receipt.store') }}" method="post">
          @csrf
          <div class="form-group" id="button-cari">
            <table class="table">
              <tr>
                <td><button type="button" class="au-btn au-btn-icon au-btn--blue au-btn--small" data-toggle="modal"
                    data-target="#scrollmodal">
                    <i class="zmdi zmdi-search"></i>Cari Invoice</button></td>
                <td><button id="button-cari" type="button" class="au-btn au-btn-icon au-btn--green au-btn--small"
                    data-toggle="modal" data-target="#largeModal">
                    <i class="zmdi zmdi-search"></i>Lihat Invoice</button></td>
              </tr>
            </table>
          </div>

          <div class="form-group">
            <table class="table table-bordered">
              <tr>
                <td colspan="4">KIOS <span id="electricity_meter_code" style="font-weight: "></span></td>
              </tr>
              <tr>
                <td>Nama PIC</td>
                <td>Lokasi</td>
                <td>Periode</td>
                <td>Tanggal Jatuh Tempo</td>
              </tr>
              <tr>
                <td><input readonly id="pic_name" class="form-control"></td>
                <td><input readonly id="area_name" class="form-control"></td>
                <td><input readonly id="month_bill" class="form-control"></td>
                <td><input readonly id="grace_date" class="form-control"></td>
              </tr>
            </table>
          </div>

          <div class="form-group">
            <table class="table table-bordered">
              <tr>
                <td colspan="4">TAGIHAN</td>
              </tr>
              <tr>
                <td>Total Tagihan</td>
                <td>Sudah Dibayar</td>
                <td>Sisa Tagihan</td>
              </tr>
              <tr>
                <td><input readonly id="grand_total" class="form-control"></td>
                <td><input readonly id="sudah_dibayar" class="form-control"></td>
                <td><input readonly id="sisa_tagihan" class="form-control"></td>
              </tr>
            </table>
          </div>

          <div class="form-group">
            <label class="form-control-label">PEMBAYARAN</label>
            <input type="hidden" id="stall_id" name="stall_id" class="form-control">
            <input type="hidden" id="invoice_id" name="invoice_id" class="form-control">
            <input type="text" id="payment" name="payment" placeholder="Pembayaran.." class="form-control">
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
</div>

</div>

<!-- modal large -->
<div class="modal fade" id="largeModal" tabindex="-1" role="dialog" aria-labelledby="largeModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" style="max-width:1200px" role="document">
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
              <td colspan='9' style="background-color:#ffd2a6"></td>
            </tr>
            <tr>
              <td style="font-weight:bold">NAMA</td>
              <td colspan='3' id="name"></td>
              <td style="font-weight:bold">BULAN/TAHUN</td>
              <td colspan='4' id="month_bill_1"></td>
            </tr>
            <tr>
              <td style="font-weight:bold">LOKASI/BLOK</td>
              <td colspan='3' id="area"></td>
              <td style="font-weight:bold">JATUH TEMPO</td>
              <td colspan='4' id="grace_date_1"></td>
            </tr>
            <tr>
              <td colspan='9' style="background-color:#ffd2a6;text-align:center;font-weight:bold">RINCIAN PEMAKAIAN
                DAN
                TAGIHAN</td>
            </tr>
            <td colspan="2" style="font-weight:bold">SATUAN</td>
            <td style="font-weight:bold">BEBAN</td>
            <td style="font-weight:bold">SERVICE CHARGE</td>
            <td style="font-weight:bold">TARIF/KWH</td>
            <td style="font-weight:bold">BIAYA LISTRIK</td>
            <td style="font-weight:bold">TAGIHAN</td>
            <td id="sub_total"></td>
            <td style="font-weight:bold">TOTAL TAGIHAN</td>
            </tr>
            <tr>
              <td style="font-weight:bold">DAYA</td>
              <td id="power_meter"></td>
              <td rowspan="4" id="area_price"></td>
              <td rowspan="4" id="stall_bill"></td>
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
              <td style="font-weight:bold"> PEMAKAIAN(KWH)</td>
              <td id="electricity_meter_used"></td>
              <td></td>
              <td></td>
            <tr>
              <td colspan='8'></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- end modal large -->

<!-- modal scroll -->
<div class="modal fade" id="scrollmodal" tabindex="-1" role="dialog" aria-labelledby="scrollmodalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" style="max-width:1000px" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="card">
          <div class="card-header">
            <strong>Cari</strong> Invoice
          </div>
          <div class="card-body card-block">
            <!-- DATA TABLE -->
            <div class="table-data__tool-left">
              <div class="rs-select2--light rs-select2--md" style="display: contents">
                <input class="au-input au-input--xl" type="text" name="search" id="search"
                  placeholder="Cari Data..." /><i style="font-size:150%" class="zmdi zmdi-search"></i>
              </div>
            </div>

            <div class="table-responsive table-responsive-data2">
              <table class="table table-data2">
                <thead>
                  <tr>
                    <th>Blok</th>
                    <th>Nama Toko</th>
                    <th>Total Tagihan</th>
                    <th>Periode</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody id="ajax">
                </tbody>
              </table>
              <!-- END DATA TABLE -->

            </div>
            <div class="card-footer">
              <button type="submit" class="btn btn-primary btn-sm" style="float:right;">
                <i class="fa fa-dot-circle-o"></i> Submit
              </button>
            </div>
          </div>
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

		$( "#selStall" ).select2({
			maximumSelectionLength: 5,
			placeholder: "Kios..",
			ajax: { 
				url: "/stallselect2",
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

$(document).on('keyup', '#search', function(){
var query = $(this).val();
fetch_customer_data(query);
});

$(document).on('click', '#button-cari', function(){
fetch_customer_data();
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
$('#pic_name').val(response.pic_name);
$('#month_bill_1').html(response.month_bill);
$('#month_bill').val(response.month_bill);
$('#area').html(response.area_name);
$('#area_name').val(response.area_name);
$('#power_meter').html(response.electricity_power_meter);
$('#sub_total').html(rupiah(response.sub_total));
$('#stall_bill').html(rupiah(response.stall_bill));
$('#area_price').html(rupiah(response.electricity_bill_beban));
$('#electricity_bill').html(rupiah(response.electricity_bill));
$('#total').html(rupiah(response.grand_total));
$('#grand_total').val(rupiah(response.grand_total));
$('#electricity_meter_before').html(response.electricity_meter_before);
$('#electricity_meter_after').html(response.electricity_meter_after);
$('#electricity_meter_used').html(response.electricity_meter_used);
$('#kwh_price').html(rupiah(response.kwh_price));
$('#grace_date_1').html(response.grace_date);
$('#grace_date').val(response.grace_date);
$('#invoice_id').val(id);
$('#stall_id').val(response.stall_id);
$('#sudah_dibayar').val(rupiah(response.total_payment));

var sisa_tagihan = response.grand_total - response.total_payment;
if(sisa_tagihan<0){
  $('#sisa_tagihan').val(rupiah(0));
}else{
  $('#sisa_tagihan').val(rupiah(sisa_tagihan));
}
},
error: function(request,msg,error) {
console.log(msg);
console.log(error);
}
});
});

function rupiah(angka){
var angka_str = angka.toString();
var number_string = angka_str.replace(/[^,\d]/g, ''),
split = number_string.split('.'),
sisa = split[0].length % 3,
rupiah = split[0].substr(0, sisa),
ribuan = split[0].substr(sisa).match(/\d{3}/gi);

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
url:"/invoicereceiptsearch",
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

$(document).on('keyup', '#payment', function(){
  var value = $(this).val();
  var result = rupiah(value);
  $(this).val(result);
 });

});
  </script>
  @endsection