@extends('layouts.app')

@section('title', trans('Products - Mera Brand'))

@section('content')


 <!-- container -->
    <div class="container m-5" style="width: 100%;max-width: 95%;">
        <div class="row">
             @include('layouts.admin_dashboard_menu')
            <div class="col-md-9" style="min-width: 82%;">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 border-right" style="min-width: 20%;text-align: center;">
                                <h4 style="margin-bottom: 20px;">Products</h4>
                            </div>
                          

                        </div>


                        <div class="row">
                            <div class="col-md-12" style="padding: 0;">
                                <table class="table table-hover ">
                                    <thead class="bg-light ">
                                        <tr>
                                            
                                            <th style="width: 20%;">Image</th>
                                            <th>Title</th>
                                            <th>Type</th>
                                            <th>Material</th>
                                            <th>Fabric</th>
                                            <th>{{__('text.Size')}}</th>
                                            <th>Brand</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Color</th>
                                            <th>Review</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($post as $key)
                                        <tr>
                                            <td>
                                                <img class="img-fluid" src="{{url('public/products_images')}}/{{ $key->image }}">
                                            </td>
                                            <td><a href="{{ asset('show_product/' . $key->productId . '/' . $key->colorId) }}">{{$key->title}}</a></td>
                                            <td>{{$key->type}}</td>
                                            <td>{{$key->material}}</td>
                                            <td>{{$key->fabric}}</td>
                                            <td>{{$key->size}}</td>
                                            <td>{{$key->brand}}</td>
                                            <td>{{$key->category}}</td>
                                            <td>Rs {{$key->price}}</td>
                                            <td>{{$key->color}}</td>

                                            <td>{{$key->rating}} Stars</td>

                                            
                                        </tr>

                                        @endforeach
                                       
                                       <style type="text/css">
                                           
                                           .table td, .table th
                                           {
                                            vertical-align: middle;
                                            text-align: center;
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