@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6">
			<div class="au-card m-b-10" style="min-height:95%">
				<div class="au-card-inner">
					<h3 class="title-2 m-b-40">Data Invoice</h3>
					<canvas id="chart-area-invo"></canvas>

				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="au-card m-b-10">
				<div class="au-card-inner">

					<h3 class="title-2 m-b-40">Data Invoice Perbulan <span
							style="font-size:15px;font-weight:normal;float: right"><button
								class="au-btn au-btn-icon au-btn--green au-btn--small" data-toggle="modal"
								data-target="#scrollmodal">List
								Invoice</button></span></h3>
					<input placeholder="Semua Periode.." autocomplete="off" id="periode"
						class="form-control date-picker">
					<input type="hidden" name="month" id="month" value="">
					<div id="keterangan"></div>
					<canvas id="chart-month"></canvas>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<div class="au-card m-b-10">
				<div class="au-card-inner">
					<h3 class="title-2 m-b-40">Data Kios</h3>
					<canvas id="chart-area"></canvas>
				</div>
			</div>
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
						<strong>List Invoice</strong> Belum Dibayar
					</div>
					<div class="card-body card-block">
						<table class="table table-bordered" id="list"></table>
					</div>
					<div class="card-footer">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end modal scroll -->


<script src="{{ asset('js/Chart.min.js') }}"></script>
<script>
	var ctx3 = document.getElementById('chart-month').getContext('2d');
	var stall_active;
var stall_inactive;
var stall_total;
var invoice_paid;
var invoice_unpaid;
var invoice_total;
var invoice_month_paid;
var invoice_month_unpaid;
var invoice_month_revenue;

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

$(function() {
$('.date-picker').datepicker( {
changeMonth: true,
changeYear: true,
showButtonPanel: true,
dateFormat: 'MM yy',
onClose: function(dateText, inst) {
$(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
changeField();
}
});
});

function changeField(){
$('#month').val($('#periode').val());
var datas = $('#month').val();
$.ajax({
url:"/master/invoice/dashboard",
method:'GET',
dataType:'json',
data:{month:datas},
success:function(response)
{
invoice_month_paid = response.total_paid;
invoice_month_unpaid = response.total_unpaid;
invoice_month_revenue = response.revenue;
$('#keterangan').html("<br>\
<ul>\
	<li>Lunas : "+rupiah(response.total_paid)+" </li>\
	<li>Belum Lunas : "+rupiah(response.total_unpaid)+" </li>\
	<li>Pemasukan : "+rupiah(response.revenue)+"</li>\
</ul>");

var config3 = {
type: 'pie',
data: {
datasets: [{
data: [
invoice_month_unpaid,
invoice_month_paid,
0
],
backgroundColor: [
'rgba(249, 52, 19, 0.8)',
'rgba(10, 56, 216, 0.8)',
'rgba(0, 0, 0, 0)'
],
label: 'Dataset'
}],
labels: [
'Belum Lunas',
'Lunas'

]
},
options: {
responsive: true,
legend: {
position: 'bottom'
}
}
};
window.myPie.destroy();
window.myPie = new Chart(ctx3, config3);
unpaidlist(datas);

}, error: function(request,msg,error) {
console.log(msg);
console.log(error);
},
async: false
})
}

$.ajax({
url:"/master/invoice/dashboard",
method:'GET',
dataType:'json',
data:{month:"All"},
success:function(response)
{
invoice_month_paid = response.total_paid;
invoice_month_unpaid = response.total_unpaid;
invoice_month_revenue = response.revenue;
$('#keterangan').html("<br><ul><li>Lunas : "+rupiah(response.total_paid)+" </li><li>Belum Lunas : "+rupiah(response.total_unpaid)+" </li><li>Pemasukan : "+rupiah(response.revenue)+"</li></ul>");

}, error: function(request,msg,error) {
console.log(msg);
console.log(error);
},
async: false
})

function unpaidlist(month){
$.ajax({
url:"master/invoice/unpaidlist",
method:'GET',
dataType:'json',
data:{query:month},
success:function(response)
{
$('#list').html(response.table_data);
}, error: function(request,msg,error) {
console.log(msg);
console.log(error);
}
})
}


$.ajax({
   url:"/chartstall",
   method:'GET',
   dataType:'json',
   success:function(response)
   {
 	 stall_active = response.active;
 	 stall_inactive = response.inactive;
 	 stall_total = response.total;
   }, error: function(request,msg,error) {
       console.log(msg);
       console.log(error);
    },
     async: false
  })

  $.ajax({
url:"/chartinvoice",
method:'GET',
dataType:'json',
success:function(response)
{
invoice_paid = response.paid;
invoice_unpaid = response.unpaid;
invoice_total = response.total;
}, error: function(request,msg,error) {
console.log(msg);
console.log(error);
},
async: false
})

	var config = {
			type: 'pie',
			data: {
				datasets: [{
					data: [
						stall_inactive,
						stall_active,
						0
					],
					backgroundColor: [
						'rgba(249, 52, 19, 0.8)',					
						'rgba(10, 56, 216, 0.8)',
						'rgba(0, 0, 0, 0)'				
					],
					label: 'Dataset'
				}],
				labels: [
					'Tidak Aktif',
					'Aktif','Total : ' + stall_total

				]
			},
			options: {
				responsive: true
			}
		};

		var config2 = {
		type: 'pie',
		data: {
		datasets: [{
		data: [
		invoice_unpaid,
		invoice_paid,
		0
		],
		backgroundColor: [
		'rgba(249, 52, 19, 0.8)',
		'rgba(10, 56, 216, 0.8)',
		'rgba(0, 0, 0, 0)'
		],
		label: 'Dataset'
		}],
		labels: [
		'Belum Lunas',
		'Lunas','Total : ' + invoice_total
		
		]
		},
		options: {
		responsive: true
		}
		};

		var config4 = {
		type: 'pie',
		data: {
		datasets: [{
		data: [
		invoice_month_unpaid,
		invoice_month_paid,
		0
		],
		backgroundColor: [
		'rgba(249, 52, 19, 0.8)',
		'rgba(10, 56, 216, 0.8)',
		'rgba(0, 0, 0, 0)'
		],
		label: 'Dataset'
		}],
		labels: [
		'Belum Lunas',
		'Lunas'
		
		]
		},
		options: {
		responsive: true,
		legend: {
		position: 'bottom'
		}
		}
		};

		
		window.onload = function() {
			var ctx = document.getElementById('chart-area').getContext('2d');
			window.myPie = new Chart(ctx, config);
			var ctx2 = document.getElementById('chart-area-invo').getContext('2d');
			window.myPie = new Chart(ctx2, config2);
			window.myPie = new Chart(ctx3, config4);
			
			
		};
</script>

@endsection