@extends('layouts.app')

@section('content')

<div class="row"> 
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<strong>Tambah</strong> Invoice
			</div>
			<div class="card-body card-block">
				<form action="{{ route('master.invoice.store') }}" method="post">
					@csrf
					<div class="form-group">
						<label class="form-control-label">Kios</label>
						<select name="stall_id" id='selStall' class='form-control'></select>
					</div>
					
                    <div class="form-group">
                        <label class="form-control-label">Periode (Bulan Tahun)</label>
                        <input type="text" name="month_bill" placeholder="Periode.." class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-control-label">Tanggal Jatuh Tempo</label>
                        <input type="date" name="grace_date" placeholder="Jatuh Tempo.." class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-control-label">Pembayaran Minimum</label>
                        <input type="text" name="minimal_payment" id="minimal_payment" placeholder="Pembayaran Minimum.." class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="form-control-label">Diskon</label>
                        <input type="number" name="discount" placeholder="Diskon.." class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Status</label>
                        <select name="status">
                            <option value="Belum Lunas">Belum Lunas</option>
                            <option value="Lunas">Lunas</option>
                        </select>
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

 $(document).on('keyup', '#minimal_payment', function(){
  var value = $(this).val();
  var result = rupiah(value);
  $(this).val(result);
 });
});
</script>
@endsection