@extends('layouts.app')

@section('content')
<div class="col-lg-6">
                                <div class="au-card m-b-10">
                                    <div class="au-card-inner">
                                        <h3 class="title-2 m-b-40">Data Kios</h3>
                                    <canvas id="chart-area"></canvas>
                                    </div>
                                </div>
                            </div>

<script src="{{ asset('assets/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('js/Chart.min.js') }}"></script>
<script>
var stall_active;
var stall_inactive;
var stall_total;

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

	var randomScalingFactor = function() {
			return Math.round(Math.random() * 100);
		};

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

		window.onload = function() {
			var ctx = document.getElementById('chart-area').getContext('2d');
			window.myPie = new Chart(ctx, config);
		};
</script>

@endsection