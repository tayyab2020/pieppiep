@extends('layouts.app')

@section('title', trans('Invoices - Mera Brand'))

@section('content')


 <!-- container -->
    <div class="container m-5" style="width: 100%;max-width: 95%;min-height: 500px;">
        <div class="row">
             @include('layouts.admin_dashboard_menu')
            <div class="col-md-9" style="min-width: 75%;">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2 border-right" style="min-width: 20%;text-align: center;">
                                <h4 style="margin-bottom: 20px;">Invoices</h4>
                            </div>

                           
                          

                        </div>


                        <div class="row">
                            <div class="col-md-12" style="padding: 0;">
                                <table class="table table-hover ">
                                    <thead class="bg-light ">
                                        <tr>
                                            
                                            <th style="width: 20%;">Sr No</th>
                                            <th>Invoice No</th>
                                            <th>Invoiced at</th>
                                            <th>Invoice Status</th>                                          
                                            <th>Amount</th>
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php $i=1; ?>

                                        @foreach($post as $key)
                                        <tr>
                                            <td>
                                                {{$i}}
                                            </td>
                                            <td><a href="{{ asset('admin/invoice/' . $key->id ) }}">{{$key->invoice_number}}</a></td>
                                            <td>{{$key->invoiced_at}}</td>
                                            <td>
                                            
                                                @if($key->invoice_status == 'Pending')
                                            <button class="btn btn-sm btn-secondary">{{$key->invoice_status}}</button>

                                            @elseif($key->invoice_status == 'Partial')
                                            <button class="btn btn-sm btn-warning">{{$key->invoice_status}}</button>

                                            @elseif($key->invoice_status == 'Approved')
                                            <button class="btn btn-sm btn-info">{{$key->invoice_status}}</button>

                                            @elseif($key->invoice_status == 'Completed')
                                            <button class="btn btn-sm btn-success">{{$key->invoice_status}}</button>

                                            @else
                                            <button class="btn btn-sm btn-danger">{{$key->invoice_status}}</button>

                                            @endif
                                            </td>
                                            <td>{{$key->amount}}</td>

                                            <td style="padding: 0;">
                                                <a href="{{ asset('admin/invoice/' . $key->id ) }}"><img class="img-fluid" src="{{url('icons/package/build/svg/pencil.svg')}}"></a>
                                                

                                            </td>
                                        </tr>

                                        <?php $i++; ?>

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