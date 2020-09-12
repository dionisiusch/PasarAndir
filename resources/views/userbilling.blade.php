@extends('layouts.userapp')

@section('content')
<div class="section__content section__content--p30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="overview-wrap">
                    <select id="pilih-kios">
                        <option value="">Pilih Kios..</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row m-t-25">

            <div class="col-md-4 col-lg-5">
                <div class="card">
                    <div class="card-header">
                        <strong>Invoice</strong>
                    </div>
                    <div class="card-body card-block">
                        <table class="table">
                            <tr>
                                <th>Periode</th>
                                <th>Status</th>
                            </tr>
                            <tbody id="data-table-invoice"></tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>

            </div>

            <div class="col-md-4 col-lg-7">
                <div class="card">
                    <div class="card-header">
                        <strong>Histori Pembayaran</strong>
                    </div>
                    <div class="card-body card-block">
                        <table class="table table-bordered">
                            <tr>
                                <th>Periode</th>
                                <th>Jumlah</th>
                                <th>Tanggal Bayar</th>

                            </tr>
                            <tbody id="data-table-receipt"></tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                    </div>
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
                            <td colspan='8' style="background-color:#ffd2a6;text-align:center;font-weight:bold">RINCIAN
                                PEMAKAIAN DAN
                                TAGIHAN</td>
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
                            <td style="font-weight:bold">DAYA</td>
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
                            <td colspan='8' style="background-color:#ffd2a6;text-align:center;font-weight:bold">RINCIAN
                                PEMBAYARAN</td>
                        </tr>
                        <tr>
                            <td style="font-weight:bold" colspan="4">TANGGAL PEMBAYARAN</td>
                            <td style="font-weight:bold" colspan="4">JUMLAH PEMBAYARAN</td>
                        <tr>
                    <tbody id='rincian_pembayaran'></tbody>
                    <tr style="background-color:#f59d8c">
                        <td style="font-weight:bold" colspan="4">SISA TAGIHAN</td>
                        <td style="font-weight:bold" colspan="4" id='sisa_tagihan'></td>
                    <tr>
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- end modal large -->



<script>
    var id = "{{ Auth::guard('web')->user()->id }}";

  $.ajax({
    url:"/user/"+id+"/stall",
    method:'GET',
    data:{id:id},
    dataType:'json',
    success:function(response)
    {
        var text = '';
     for(var i=0;i<response.stall.length;i++){
         text += "<option value='"+response.stall[i].stall_id+"'>"+response.stall[i].area_name+" | "+response.stall[i].stall_name+"</option>";
     }
     $('#pilih-kios').append(text);
    }, error: function(request,msg,error) {
    console.log(msg);
    console.log(error);
    }
    })

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

    $(document).on('click', '.invoice-row', function(){
    var id = $(this).attr('id');
    var invoice_id;
    $.ajax({
    url:'/user/invoice/'+id,
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
    var sisa_tagihan = response.grand_total - response.total_payment;
    invoice_id = response.id;
    if(sisa_tagihan<0){ $('#sisa_tagihan').html(rupiah(0)); }else{ $('#sisa_tagihan').html(rupiah(sisa_tagihan)); }
    },async: false,
    error: function(request,msg,error) {
    console.log(msg);
    console.log(error);
    }
    });
    
$.ajax({
    url:'invoice/'+invoice_id+'/receipt',
    type: 'get',
    dataType:'json',
    data: {id:invoice_id},
    success: function(response) {
    
    var text = '';
     for(var i=0;i<response.text.length;i++){
         text += "<tr><td colspan='4'>"+response.text[i].created_at.substring(0,10)+"</td><td colspan='4'>"+rupiah(response.text[i].payment)+"</td></tr>";
     }
     console.log(text);
     $('#rincian_pembayaran').html(text);
   
    },
    error: function(request,msg,error) {
    console.log(msg);
    console.log(error);
    }
    });
    });

    $(document).on('change', '#pilih-kios', function(){
    var id = $(this).val();

    $.ajax({
    url:'/user/invoice/'+id+"/stall",
    type: 'get',
    dataType:'json',
    data: {id:id},
    success: function(result) {

        $('#data-table-invoice').html(result.text);

    },
    error: function(request,msg,error) {
    console.log(msg);
    console.log(error);
    }
    });

    $.ajax({
    url:'/user/receipt/'+id+"/stall",
    type: 'get',
    dataType:'json',
    data: {id:id},
    success: function(result) {

        $('#data-table-receipt').html(result.text);

    },
    error: function(request,msg,error) {
    console.log(msg);
    console.log(error);
    }
    });

    });


			

</script>

@endsection