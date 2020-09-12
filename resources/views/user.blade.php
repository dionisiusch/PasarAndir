@extends('layouts.userapp')

@section('content')
<div class="section__content section__content--p30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="overview-wrap">
                </div>
            </div>
        </div>
        <div class="row m-t-25">

            <div class="col-md-4 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <strong>Data User</strong>
                    </div>
                    <div class="card-body card-block">
                        <table class="table">
                            <tr>
                                <td>Username :</td>
                                <td style="font-weight: bold" id="username">Ujang</td>
                            </tr>
                            <tr>
                                <td>Nama :</td>
                                <td style="font-weight: bold" id="pic_name">Ujang</td>
                            </tr>
                            <tr>
                                <td>No. Tlp :</td>
                                <td style="font-weight: bold" id="pic_phone_number">Ujang</td>
                            </tr>
                            <tr>
                                <td>Tgl Bergabung :</td>
                                <td style="font-weight: bold" id="joined_date">Ujang</td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>

            </div>

            <div class="col-md-4 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <strong>Data Kios</strong>
                    </div>
                    <div class="card-body card-block">
                        <table class="table table-bordered">
                            <tr>
                                <td>Lokasi</td>
                                <td>Nama Toko</td>
                                <td>Status</td>

                            </tr>
                            <tbody id="data-kios"></tbody>
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



<script>
    var id = "{{ Auth::guard('web')->user()->id }}";

$.ajax({
   url:"/user/"+id,
   method:'GET',
   data:{id:id},
   dataType:'json',
   success:function(response)
   {
 	 $('#pic_name').html(response.pic_name);
     $('#pic_phone_number').html(response.pic_phone_number);
     $('#username').html(response.username);
     $('#joined_date').html(response.joined_date);
   }, error: function(request,msg,error) {
       console.log(msg);
       console.log(error);
    }
  })

  $.ajax({
    url:"/user/"+id+"/stall",
    method:'GET',
    data:{id:id},
    dataType:'json',
    success:function(response)
    {
     $('#data-kios').html(response.text);
     console.log(response);
    }, error: function(request,msg,error) {
    console.log(msg);
    console.log(error);
    }
    })


			

</script>

@endsection