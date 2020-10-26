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

<div class="container-fluid">
    <div class="row">
        {{-- <div class='col-lg-6' style='max-width: 27%'>
            <div class='au-card m-b-10'>
                <div class='au-card-inner'>
                    <div class='print'>
                        <table class='table table-bordered' style='font-size: 10px;width:200px;height:400px'>
                            <tbody id='modal-invoice'>
                                <tr>
                                    <td style='font-weight:bold'>NAMA</td>
                                    <td colspan='3' id='name'></td>
                                </tr>
                                <tr>
                                    <td style='font-weight:bold'>BULAN/TAHUN</td>
                                    <td colspan='3' id='month_bill'></td>
                                </tr>
                                <tr>
                                    <td style='font-weight:bold'>LOKASI/BLOK</td>
                                    <td colspan='3' id='area'></td>
                                </tr>
                                <tr>
                                    <td style='font-weight:bold'>JATUH TEMPO</td>
                                    <td colspan='3' id='grace_date'></td>
                                </tr>
                                <tr>
                                    <td colspan='4' style='background-color:#ffd2a6;text-align:center;font-weight:bold'> RINCIAN
                                        PEMAKAIAN DAN TAGIHAN</td>
                                </tr>
                                <tr>
                                    <td style='font-weight:bold'>BEBAN</td>
                                    <td id='area_price'></td>
                                </tr>
                                <tr>
                                    <td style='font-weight:bold'>SERVICE CHARGE</td>
                                    <td id='stall_bill'></td>
                                </tr>
                                <tr>
                                    <td style='font-weight:bold'>TARIF/KWH</td>
                                    <td id='kwh_price'></td>
                                </tr>
                                <tr>
                                    <td style='font-weight:bold'>BIAYA  PEMAKAIAN(KWH)</td>
                                    <td id='electricity_bill'></td>
                                </tr>
                                <tr>
                                    <td style='font-weight:bold'>TAGIHAN</td>
                                    <td id='sub_total'></td>
                                </tr>
                                <tr>
                                    <td style='font-weight:bold'>BIAYA ADMIN</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td style='font-weight:bold'>TOTAL TAGIHAN</td>
                                    <td id='total'></td>
                                </tr>
                                <tr>
                                    <td colspan='2' style='font-size: 9px'>*ini hanya penagihan, bukan bukti pembayaran </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

    <script>
        multiple();
    
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

    function single(id,index){
    $.ajax({
    url:'/master/invoice/'+id,
    type: 'get',
    dataType:'json',
    data: {id:id},
    success: function(response) {
    
    var html = "<div class='col-lg-6' style='max-width: 26%'><div class='au-card-inner'>";
    
    if(index>3){
         
      html += "<div class='print' style='margin-top:2px'>";

    }else{
        html += "<div class='print'>";
    }
    
      html += "<table class='table table-bordered' style='font-size: 14.7px;width:280px;height:400px'>\
                        <tbody id='modal-invoice'>\
                            <tr>\
                                <td style='font-weight:bold'>NAMA</td>\
                                <td colspan='3' id='name'>"+response.pic_name+"</td>\
                            </tr>\
                            <tr>\
                                <td style='font-weight:bold'>BULAN/TAHUN</td>\
                                <td colspan='3' id='month_bill'>"+response.month_bill+"</td>\
                            </tr>\
                            <tr>\
                                <td style='font-weight:bold'>LOKASI/BLOK</td>\
                                <td colspan='3' id='area'>"+response.area_name+"</td>\
                            </tr>\
                            <tr>\
                                <td style='font-weight:bold'>JATUH TEMPO</td>\
                                <td colspan='3' id='grace_date'>"+response.grace_date+"</td>\
                            </tr>\
                            <tr>\
                                <td colspan='4' style='background-color:#ffd2a6;text-align:center;font-weight:bold'> RINCIAN\
                                    PEMAKAIAN DAN TAGIHAN</td>\
                            </tr>\
                            <tr>\
                                <td style='font-weight:bold'>BEBAN</td>\
                                <td id='area_price'>"+rupiah(response.electricity_bill_beban)+"</td>\
                            </tr>\
                            <tr>\
                                <td style='font-weight:bold'>SERVICE CHARGE</td>\
                                <td id='stall_bill'>"+rupiah(response.stall_bill)+"</td>\
                            </tr>\
                            <tr>\
                                <td style='font-weight:bold'>TARIF/KWH</td>\
                                <td id='kwh_price'>"+rupiah(response.kwh_price)+"</td>\
                            </tr>\
                            <tr>\
                                <td style='font-weight:bold'>BIAYA LISTRIK</td>\
                                <td id='electricity_bill'>"+rupiah(response.electricity_bill)+"</td>\
                            </tr>\
                            <tr>\
                                <td style='font-weight:bold'>TAGIHAN</td>\
                                <td id='sub_total'>"+rupiah(response.sub_total)+"</td>\
                            </tr>\
                            <tr>\
                                <td style='font-weight:bold'>BIAYA ADMIN</td>\
                                <td></td>\
                            </tr>\
                            <tr>\
                                <td style='font-weight:bold'>TOTAL TAGIHAN</td>\
                                <td id='total'>"+rupiah(response.grand_total)+"</td>\
                            </tr>\
                            <tr>\
                                <td colspan='2' style='font-size: 11px'>*ini hanya penagihan, bukan bukti pembayaran </td>\
                            </tr>\
                        </tbody>\
                    </table>\
                </div>\
            </div>\
        </div>\
    </div>" ;

    $(".row").append(html);

    },
    error: function(request,msg,error) {
    console.log(msg);
    console.log(error);
    }
    });
}

function multiple(){
    $.ajax({
    url:'/showprintlistinvoice',
    type: 'get',
    dataType:'json',
    success: function(response) {
    for(var i=0;i<response.length;i++){
        single(response[i].invoice_id,i+1);
    }
    },
    error: function(request,msg,error) {
    console.log(msg);
    console.log(error);
    }
    });
}

function printBody() {

    setTimeout(function(){
    window.print();
    }, 3000);

    $.ajax({
    url:'/truncateprintinvoice',
    type: 'get',
    dataType:'json',
    success: function(response) {
     console.log("succes truncate");
    },
    error: function(request,msg,error) {
    console.log(msg);
    console.log(error);
    }
    });

    }
    
    printBody();
    </script>