<!-- Required meta tags-->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="au theme template">
<meta name="author" content="Hau Nguyen">
<meta name="keywords" content="au theme template">
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Title Page-->
<title>PT AMAN PRIMA JAYA</title>

<!-- Fontfaces CSS-->
<link href="{{ asset('css/font-face.css') }}" rel="stylesheet" media="all">
<link href="{{ asset('assets/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
<link href="{{ asset('assets/font-awesome-5/css/fontawesome-all.min.css') }}" rel="stylesheet" media="all">
<link href="{{ asset('assets/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">

<!-- Bootstrap CSS-->
<link href="{{ asset('assets/bootstrap-4.1/bootstrap.min.css') }}" rel="stylesheet" media="all">

<!-- assets CSS-->
<link href="{{ asset('assets/animsition/animsition.min.css') }}" rel="stylesheet" media="all">
<link href="{{ asset('assets/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css') }}" rel="stylesheet"
    media="all">
<link href="{{ asset('assets/wow/animate.css') }}" rel="stylesheet" media="all">
<link href="{{ asset('assets/css-hamburgers/hamburgers.min.css') }}" rel="stylesheet" media="all">
<link href="{{ asset('assets/slick/slick.css') }}" rel="stylesheet" media="all">
<link href="{{ asset('assets/select2/select2.min.css') }}" rel="stylesheet" media="all">
<link href="{{ asset('assets/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" media="all">

<!-- Main CSS-->
<link href="{{ asset('css/theme.css') }}" rel="stylesheet" media="all">
<link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet" media="all">
<script src="{{ asset('js/jquery-3.5.1.js') }}"></script>

<div class="print">
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
                <td colspan='8' style="background-color:#ffd2a6;text-align:center;font-weight:bold">RINCIAN PEMAKAIAN
                    DAN
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
        </tbody>
    </table>
</div>

<script>
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

    if('{{$request->option_print}}'=='single'){
        single('{{$request->invoice_id_print}}');
    }

    function single(id){
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
    window.print();
    },
    error: function(request,msg,error) {
    console.log(msg);
    console.log(error);
    }
    });
}

function multiple(){

}
</script>