@extends('layouts.app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6">
			<div class="au-card m-b-10">
				<div class="au-card-inner">
					<h3 class="title-2 m-b-40">Data Kios</h3>
					<canvas id="chart-area"></canvas>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="au-card m-b-10">
				<div class="au-card-inner">
					<h3 class="title-2 m-b-40">Data Invoice</h3>
					<canvas id="chart-area-invo"></canvas>
				</div>
			</div>
		</div>
	</div>
</div>


<script src="{{ asset('js/Chart.min.js') }}"></script>
<script>
	var stall_active;
var stall_inactive;
var stall_total;
var invoice_paid;
var invoice_unpaid;
var invoice_total;


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

		window.onload = function() {
			var ctx = document.getElementById('chart-area').getContext('2d');
			window.myPie = new Chart(ctx, config);
			var ctx2 = document.getElementById('chart-area-invo').getContext('2d');
			window.myPie = new Chart(ctx2, config2);
			
		};
</script>

@endsection