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
					<div class="form-group">
						<label class="form-control-label">Invoice</label>
						<select name="stall_id" id='selStall' class='form-control'></select>
					</div>
                    
                    <div class="form-group">
						<table class="table table-bordered">
							<tr>
								<td colspan="2">Kios <span id="electricity_meter_code" style="font-weight: "></span></td>
							</tr>
							<tr>
								<td>Nama PIC</td>
								<td>Lokasi</td>
                                <td>Periode</td>
                                <td>Tanggal Jatuh Tempo</td>
							</tr>
							<tr>
								<td><input type="number" name="electricity_meter_before" placeholder="...."  class="form-control"></td>
								<td><input type="number" name="electricity_meter_after" placeholder="...."  class="form-control"></td>
                                <td><input type="number" name="electricity_meter_after" placeholder="...."  class="form-control"></td>
                                <td><input type="number" name="electricity_meter_after" placeholder="...."  class="form-control"></td>
							</tr>
						</table>
					</div>

                    <div class="form-group">
						<table class="table table-bordered">
							<tr>
								<td colspan="2">Tagihan <span id="electricity_meter_code" style="font-weight: "></span></td>
							</tr>
							<tr>
								<td>Total Tagihan</td>
								<td>Sudah Dibayar</td>
                                <td>Sisa Tagihan</td>
							</tr>
							<tr>
								<td><input type="number" name="electricity_meter_before" placeholder="...."  class="form-control"></td>
								<td><input type="number" name="electricity_meter_after" placeholder="...."  class="form-control"></td>
                                <td><input type="number" name="electricity_meter_after" placeholder="...."  class="form-control"></td>
							</tr>
						</table>
					</div>

                    <div class="form-group">
                        <label class="form-control-label">Pembayaran</label>
                        <input type="text" name="payment" placeholder="Pembayaran.." class="form-control">
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
});
</script>
@endsection