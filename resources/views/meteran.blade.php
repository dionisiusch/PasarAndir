@extends('layouts.app')

@section('content')

<div class="row"> 
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<strong>Input</strong> Meteran
			</div>
			<div class="card-body card-block">
				<form action="{{ route('meteran.store') }}" method="post">
					@csrf
					<div class="form-group">
						<label class="form-control-label">Kios</label>
						<select name="stall_id" id='selStall' class='form-control'></select>
					</div>
					
					<div class="form-group">
						<table class="table table-bordered">
							<tr>
								<td colspan="2">Meteran Listrik <span id="electricity_meter_code" style="font-weight: "></span></td>
							</tr>
							<tr>
								<td>Meteran Sebelum</td>
								<td>Meteran Sekarang</td>
							</tr>
							<tr>
								<td><input type="number" name="electricity_meter_before" placeholder="...."  class="form-control"></td>
								<td><input type="number" name="electricity_meter_after" placeholder="...."  class="form-control"></td>
							</tr>
						</table>
					</div>


					<div class="form-group">
						<table class="table table-bordered">
							<tr>
								<td colspan="2">Meteran Air <span id="electricity_meter_code" style="font-weight: bold"></span></td>
							</tr>
							<tr>
								<td>Meteran Sebelum</td>
								<td>Meteran Sekarang</td>
							</tr>
							<tr>
								<td><input type="number" name="water_meter_before" placeholder="...." value="0" class="form-control"></td>
								<td><input type="number" name="water_meter_after" placeholder="...."  value="0" class="form-control"></td>
							</tr>
						</table>
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

<script src="{{ asset('assets/jquery-3.2.1.min.js') }}"></script>

<script>

	$(document).ready(function(){

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

		$('#selStall').change(function() {
			var query = $('#selStall').val();

			$.ajax({
				url:"/meteranelectricity",
				method:'GET',
				dataType:'json',
				data:{id:query},
				success:function(response)
				{
					$('#electricity_meter_code').html(response.name);
				}, error: function(request,msg,error) {
					console.log(msg);
					console.log(error);
				}
			})

		});

	});
</script>
@endsection