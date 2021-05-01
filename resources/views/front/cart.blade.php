@extends('layouts.front')

@section('content')

<script src="{{ asset('assets/front/js/custom.js') }}"></script>

   <section class="jumbotron text-center">
        <div class="container">
            <h2 class="jumbotron-heading">{{$lang->sch}}</h2>
        </div>
    </section>


 @if(Session::has('unsuccess'))

<div class="alert alert-danger validation" style="position: relative;top: 0px;z-index: 10000;width: 100%;background-color: #e45151;color: black;border: none;">

<button type="button" class="close cl-btn" data-dismiss="alert" aria-label="Close" style="text-shadow: none;opacity: 1;"><span aria-hidden="true" style="font-size: 30px;">×</span></button>

<ul class="text-left" style="text-align: center;font-size: 21px;list-style: none;padding-left: 0;font-weight: 600;font-family: monospace;">

                                                    <li>{{ Session::get('unsuccess') }}</li>

                                            </ul>
                                        </div>

                                        @endif


 <form enctype="multipart/form-data" role="form" method="POST" action="{{ route('book-handyman') }}" style="min-height: 400px;margin-top: 90px;margin-bottom: 75px;" id="cart-form" >

    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
    @if(!$cart->isEmpty())
    <input type="hidden"  name="handyman_id" value="{{$cart[0]->handyman_id}}">
    @endif
    <input type="hidden" name="ip" value="{{$ip_address}}">

    <div class="container mb-4">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-striped" style="border: 1px solid #e2e2e2;">
                        <thead>
                            <tr>
                                <th scope="col">{{$lang->chi}}</th>
                                <th scope="col">{{$lang->chn}}</th>
                                <th scope="col">{{$lang->chs}}</th>
                                <th scope="col">{{$lang->chst}}</th>
                                <th scope="col">{{$lang->chr}}(€)</th>
                                <th scope="col" style="width: 80px;">{{$lang->cvat}}</th>
                                <th scope="col" style="width: 115px;" class="text-center">{{$lang->csd}}</th>
                                <th scope="col" class="text-center">{{$lang->cbd}}</th>
                                <th scope="col" class="text-right">{{$lang->ctot}}(€)</th>
                                <th scope="col" class="text-right">{{$lang->cac}}</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $i = 0; $sub_total = 0; ?>
                            @foreach($cart as $temp)

                            <tr class="product">


                            <input type="hidden"  id="cart_id<?php echo $i; ?>" name="cart_id[]" value="{{$temp->id}}">


                                <td style="width: 15%;padding: 25px;">

                                    @if($temp->photo == '')

                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG" style="width: 100%;" />

                                    @else

                                    <img src="{{asset('assets/images/'.$temp->photo)}}" style="width: 100%;" />

                                    @endif
                                     </td>

                                <td>{{$temp->name}} {{$temp->full_name}}</td>

                                @if($lang->lang == 'eng')

                                    <td>{{$temp->cat_slug}}</td>

                                    @else

                                    <td>{{$temp->cat_name}}</td>

                                    @endif


                                <?php  if($temp->rate_id == 1){ $service_type = $lang->servT1; }

          elseif($temp->rate_id == 2){ $service_type = $lang->servT2; }

          elseif($temp->rate_id == 3){ $service_type = $lang->servT3; }

          elseif($temp->rate_id == 4){ $service_type = $lang->servT4; }

          else{$service_type = "";}

           ?>


                                <td>{{$service_type}}</td>
                                <td class="product-price">{{$temp->service_rate}}</td>

                                <td>{{$temp->vat_percentage}}%</td>

                                <input type="hidden" name="service_rate[]" value="{{$temp->service_rate}}">
                                <input type="hidden" name="rate_id[]" value="{{$temp->rate_id}}">
                                <input type="hidden" name="service_id[]" value="{{$temp->service_id}}">

                                <td class="product-quantity">
                                    <input class="form-control" type="number" value="{{$temp->rate}}" id="qty<?php echo $i; ?>" name="rate[]" min="1" style="text-align: center;" onchange="Qty(<?php echo $i; ?>)" />
                                </td>

                                <?php $date21 =date_create($temp->booking_date);

                                $date12 = date_format($date21,"d-m-Y H:i:s"); ?>

                                <td>{{$date12}}</td>

                                <input type="hidden" name="date[]" value="{{$temp->booking_date}}">


                                <?php $price = $temp->rate;
                                        $qty = $temp->service_rate;
                                        $total = $price * $qty; ?>

                                <td class="text-right product-line-price"><?php echo str_replace('.', ',', number_format($total,2)); ?></td>
                                <input type="hidden" name="service_total[]" value="{{$total}}">

                                <td class="text-right product-removal" data-id="{{$temp->service_id}}" data-main="{{$temp->main_id}}">
                                    <button type="button" class="btn btn-sm btn-danger remove-product" onclick="Delete(<?php echo $i; ?>)"><img class="img-fluid" src="assets/images/trashcan.svg"> </button>
                                </td>
                            </tr>

                            <?php $i = $i + 1; $sub_total = $sub_total + $total;  ?>

                            @endforeach



                            <?php  if(!$cart->isEmpty()){ $sub_total = $sub_total + $service_fee;} ?>

                            <tr>
                                <td colspan="8" style="border-right: 1px solid #e8e8e8;">{{$lang->csf}}</td>
                                <td colspan="2" class="text-left totals-value" id="service-fee"><?php echo str_replace('.', ',', number_format($service_fee,2)); ?></td>

                                <input type="hidden" id="service_fee" name="service_fee" value="{{$service_fee}}">
                            </tr>


                            <tr>
                                <td colspan="8" style="border-right: 1px solid #e8e8e8;">{{$lang->cpit}}</td>
                                <td colspan="2" class="text-left totals-value" id="cart-total"><?php echo str_replace('.', ',', number_format($sub_total,2)); ?></td>
                            </tr>

                            <input type="hidden" name="sub_total" id="cart-total1" value="{{$sub_total}}">


                            <tr>
                                <td colspan="8" style="border-right: 1px solid #e8e8e8;">{{$lang->cvat}}</td>
                                <td colspan="2" class="text-left totals-value" ><?php echo str_replace('.', ',', number_format($vat_percentage,2)) . '%' ?></td>

                                <input type="hidden" name="vat_percentage" id="vat_percentage" value="{{$vat_percentage}}">
                            </tr>



                            <?php  if(!$cart->isEmpty()){ $vat = $sub_total * ($vat_percentage/100); } else {
                                $vat = 0;
                            } ?>

                            <tr>
                                <td colspan="8" style="border-right: 1px solid #e8e8e8;">{{$lang->cvatam}}</td>
                                <td colspan="2" class="text-left totals-value" id="cart-vat"><?php echo str_replace('.', ',', number_format($vat,2)); ?></td>
                            </tr>

<?php $grand_total = $sub_total - $vat; ?>

                            <tr>
                                <td colspan="8" style="border-right: 1px solid #e8e8e8;" class="product-line-price"><strong>{{$lang->cpet}}</strong></td>
                                <td colspan="2" class="text-left totals-value" id="cart-grandtotal"><strong><?php echo str_replace('.', ',', number_format($grand_total,2));  ?></strong>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <div style="margin: auto;margin-bottom: 40px;margin-top:30px;width: 50%;text-align: center;">

                              <input type="checkbox" name="terms" id="terms" required> <span style="position: relative;bottom: 2px;"> {{$lang->iagt}} <a href="{{  $terms ? url('assets/'.$terms->file) : url('assets/terms-and-conditions-template.pdf')  }}" style="color: blue;">{{$lang->tact}}</a></span>
                            </div>



            <div class="col mb-2" style="margin-top: 70px;">
                <div class="row" style="width: 100%;margin-left: 0;margin-right: 0;">



                    @if(!$cart->isEmpty())

                    @php

$now = time(); // or your date as well
$your_date = strtotime($cart[0]->booking_date);
$datediff =  $your_date - $now;

$days = round($datediff / (60 * 60 * 24));

 @endphp

 @if($days > 7)

 <div class="col-sm-6  col-md-6 col-xs-6 cb">
                        <button  onclick="window.location.href = '{{url('handyman-profile/'.$cart[0]->handyman_id)}}';" type="button" class="btn btn-lg btn-block btn-primary"><a class="btn-primary"  style="background-color: transparent; text-decoration: none;">{{$lang->ccs}}</a></button>
                    </div>

<div class="col-sm-6 col-md-6 col-xs-6 text-right cb">
                        <button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-lg btn-block btn-success text-uppercase checkout" >{{$lang->cc}}</button>
                    </div>

 @else

<div class="col-sm-6  col-md-6 col-xs-6 cb">
                        <button  onclick="window.location.href = '{{url('handyman-profile/'.$cart[0]->handyman_id)}}';" type="button" class="btn btn-lg btn-block btn-primary"><a class="btn-primary"  style="background-color: transparent; text-decoration: none;">{{$lang->ccs}}</a></button>
                    </div>

 <div class="col-sm-6 col-md-6 col-xs-6 text-right cb">
                        <button type="submit"  class="btn btn-lg btn-block btn-success text-uppercase checkout" >{{$lang->cc}}</button>
                    </div>

 @endif

@else

<div class="col-sm-6  col-md-6 col-xs-6 cb">
                        <button  onclick="window.location.href = '{{route('front.featured')}}';" type="button" class="btn btn-lg btn-block btn-primary"><a class="btn-primary"  style="background-color: transparent; text-decoration: none;">{{$lang->ccs}}</a></button>
                    </div>
                    @endif


                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog" style="margin-top: 150px;">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{$lang->cspo}}</h4>
        </div>
        <div class="modal-body">



         <div style="text-align: center;font-size: 18px;margin: 20px;">

            <div style="width: 100%; margin: auto;text-align: left;">

            <input type="radio" checked name="payment_option" id="test2" value="1"><label for="test2">{{$lang->cfp}}</label>

        </div></div>

        <div style="text-align: center;font-size: 18px;margin: 20px;">

                <div style="width: 100%; margin: auto;text-align: left;">

         <input type="radio" name="payment_option" id="test1" value="2"><label for="test1">{{$lang->cpp}}

            <p style="font-size: 12px;color: red;font-weight: 500;margin-top: 5px;">{{$lang->cppt}}</p>

        </label>

        </div></div>

        </div>

        <div  style="text-align: center;margin-bottom: 20px;font-size: 20px;font-weight: 500;border: 1px solid #e0e0e0;color: green;">{{$lang->cpa}}: <span  id="total_payment"><?php echo number_format($sub_total,2) ?></span></div>

        <input type="hidden"  name="total_payment1" id="total_payment1" value="{{$sub_total}}">

        <div class="modal-footer">
          <button type="submit" class="btn btn-success" >{{$lang->cc}}</button>
        </div>
      </div>

    </div>
  </div>

</form>



  <script type="text/javascript">

      $('input[type=radio][name=payment_option]').change(function() {

        var x = $('#cart-total1').val();
        x = parseInt(x, 10);

    if (this.value == 2) {


        var a = x * 0.3;


        $('#total_payment').html(a.toFixed(2));
            $('#total_payment1').val(a);
    }
    else {


        $('#total_payment').html(x.toFixed(2));
            $('#total_payment1').val(x);

    }
});

  </script>

            <style type="text/css">


                @media (max-width: 550px)
                {

                    .cb button{

                        font-size: 14px;
                    }
                }

                .table td, .table th
                {
                    vertical-align: middle;
                    text-align: center !important;
                }

                [type="radio"]:checked,
[type="radio"]:not(:checked) {
    position: absolute;
    left: -9999px;
}
[type="radio"]:checked + label,
[type="radio"]:not(:checked) + label
{
    position: relative;
    padding-left: 28px;
    cursor: pointer;
    line-height: 20px;
    display: inline-block;
    color: #666;
}
[type="radio"]:checked + label:before,
[type="radio"]:not(:checked) + label:before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 18px;
    height: 18px;
    border: 1px solid #ddd;
    border-radius: 100%;
    background: #fff;
}
[type="radio"]:checked + label:after,
[type="radio"]:not(:checked) + label:after {
    content: '';
    width: 12px;
    height: 12px;
    background: #F87DA9;
    position: absolute;
    top: 3px;
    left: 3px;
    border-radius: 100%;
    -webkit-transition: all 0.2s ease;
    transition: all 0.2s ease;
}
[type="radio"]:not(:checked) + label:after {
    opacity: 0;
    -webkit-transform: scale(0);
    transform: scale(0);
}
[type="radio"]:checked + label:after {
    opacity: 1;
    -webkit-transform: scale(1);
    transform: scale(1);
}

                html {
  height: 100%;
}
body {
  min-height: 100%;
}

.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th
{

padding: 15px;
vertical-align: middle;

}



    .pulse_start{
  animation: pulse 1s;
  animation-timing-function: linear;
}

@keyframes pulse {
  0% { transform: scale(1); }
  50% { transform: scale(2.1);
  100% { transform: scale(2); }
  }
}



            </style>

<script type="text/javascript">



    function Qty(input)
    {


    var rate = $('#qty'+input).val();
    var cart_id = $('#cart_id'+ input).val();


var token = $("#token").val();



 $.ajax({

type: "POST",
data: "cart_id=" + cart_id  +  "&rate=" + rate +  "&_token=" + token,
url: "<?php echo url('/update-rate')?>",



        success: function(data) {




}

});
    }


    function Delete(input)
    {


    var cart_id = $('#cart_id'+ input).val();


var token = $("#token").val();



 $.ajax({

type: "POST",
data: "cart_id=" + cart_id  +  "&_token=" + token,
url: "<?php echo url('/delete-cart')?>",



        success: function(data) {

$('.has-badge').addClass('pulse_start');
$(".has-badge").attr("data-count", data);


}

});

  $('.has-badge').removeClass('pulse_start');

    }
</script>

@endsection
