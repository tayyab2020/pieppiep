@extends('layouts.app')

@section('title', trans('Orders - Mera Brand'))

@section('content')


 <!-- container -->
    <div class="container m-5" style="width: 100%;max-width: 95%;">
        <div class="row">
             @include('layouts.admin_dashboard_menu')
            <div class="col-md-9" style="min-width: 75%;">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 border-right" style="min-width: 20%;text-align: center;">
                                <h4 style="margin-bottom: 20px;">Orders</h4>
                            </div>

                            
                          <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">

                        </div>

<div id="snackbar"></div>
                       

                        <style>
#snackbar {
  visibility: hidden;
  min-width: 250px;
  margin-left: -125px;
  background-color: #333;
  color: #fff;
  text-align: center;
  border-radius: 2px;
  padding: 16px;
  position: fixed;
  z-index: 1;
  left: 50%;
  bottom: 30px;
  font-size: 17px;
}

#snackbar.show {
  visibility: visible;
  -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
  animation: fadein 1.5s, fadeout 1s 2.5s;
}

@-webkit-keyframes fadein {
  from {bottom: 0; opacity: 0;} 
  to {bottom: 30px; opacity: 1;}
}

@keyframes fadein {
  from {bottom: 0; opacity: 0;}
  to {bottom: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
  from {bottom: 30px; opacity: 1;} 
  to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
  from {bottom: 30px; opacity: 1;}
  to {bottom: 0; opacity: 0;}
}
</style>

                        <div class="row">
                            <div class="col-md-12" style="padding: 0;">
                                <table class="table table-hover " style="font-size: 14px;">
                                    <thead class="bg-light ">
                                        <tr>
                                            
                                            <th style="width: 16%;">Image</th>
                                            <th style="width: 20%;">Title</th>
                                            <th>Color</th>
                                            <th>Quantity</th>
                                            <th style="width: 10%;">Total</th>
                                            <th>Status</th>
                                            <th style="width: 13%;">Invoice Number</th>
                                            <th style="width: 13%;">Invoiced at</th>
                                            <th>Customer Email</th>
                                            <th>Phone</th>

                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php $i=0; ?>

                                        @foreach($post as $key)
                                        <tr>
                                            <td>
                                                <input type="hidden" name="item_id" id="item_id<?php echo $i; ?>" value="{{$key->id}}">

                                                <img class="img-fluid" src="{{url('public/products_images')}}/{{ $key->image }}">
                                            </td>
                                            <td><a href="{{ asset('show_product/' . $key->productId . '/' . $key->colorId) }}">{{$key->title}}</a></td>
                                            <td>{{$key->color}}</td>
                                            <td>{{$key->quantity}}</td>
                                            <td>Rs {{$key->total}}</td>
                                            <td>
                                                
                                                    @foreach($statuses as $temp)
                                                    
                                                    @if($key->product_status == $temp->status)

                                                    <input id="colorSelect<?php echo $i; ?>" class="{{$temp->class}}" value="{{$temp->status}}" readonly>

                                                    <script type="text/javascript">
                                                        

                                                        

                                                        $("#colorSelect<?php echo $i; ?>").attr('class', '<?php echo $temp->class; ?>');
                                                    
                                                    </script>

                                                    @endif
                                                   

                                                    @endforeach

                                                    <?php $i++; ?>


                                                
                                                </select>
                                            </td>
                                            <td>{{$key->invoice_number}}</td>
                                            <td>{{$key->invoiced_at}}</td>
                                            <td>{{$key->email}}</td>
                                            <td>{{$key->phone}}</td>
                                            
                                        </tr>

                                        @endforeach
                                       
                                       <style type="text/css">
                                           
                                           .table td, .table th
                                           {
                                            vertical-align: middle;
                                            text-align: center;
                                           }

                                           .btn-primary{
                                            background-color: #e618a7;
                                            border-color: #e618a7;
                                           }

                                           .btn-primary:hover
                                           {

                                            background-color: #d41a9b;
                                            border-color: #e214a3;

                                           }

                                           .btn-primary.focus, .btn-primary:focus
                                           {

                                            box-shadow: 0 0 0 0.2rem rgba(222, 16, 187, 0.5);


                                           }

                                           .btn-info{

                                            background-color: #000000;
                                            border-color: #000000;

                                           }

                                           .btn-info:hover{

                                            background-color: #6d6d6d;
                                            border-color: #6d6d6d;

                                           }

                                           .btn-info.focus, .btn-info:focus
                                           {

                                            box-shadow: 0 0 0 0.2rem rgba(65, 69, 74, 0.5);


                                           }

                                       </style>

                                      
                                        
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
        </div>


    </div>


    @endsection