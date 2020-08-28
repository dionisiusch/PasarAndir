@extends('layouts.app')

@section('content')

<div class="row"> 
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<strong>Input</strong> Meteran
			</div>
			<div class="card-body card-block">
				<form action="{{ route('master.floor.store') }}" method="post">
					@csrf
					<div class="form-group">
						<label class="form-control-label">Kios</label>
						<select name="stall_id" id='selStall' class='form-control'></select>
					</div>
					<div class="form-group">
						<label class=" form-control-label">Meteran Air</label>
						<input type="number" name="stall_water" placeholder="Meteran Air.." class="form-control">
					</div>
						<div class="form-group">
						<label class=" form-control-label">Meteran Listrik</label>
						<input type="number" name="stall_electricity" placeholder="Meteran Listrik.." class="form-control">
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



  });
</script>
@endsection