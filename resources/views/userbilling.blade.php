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

            <div class="col-md-4 col-lg-6">
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

<script src="{{ asset('assets/jquery-3.2.1.min.js') }}"></script>

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

    $(document).on('change', '#pilih-kios', function(){
    var id = $(this).val();

    $.ajax({
    url:'/user/invoice/'+id,
    type: 'get',
    data: {id:id},
    success: function(result) {
    console.log(result);
    },
    error: function(request,msg,error) {
    console.log(msg);
    console.log(error);
    }
    });

    });


			

</script>

@endsection