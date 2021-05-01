@extends('layouts.app')

@section('title', trans('Feedbacks - Mera Brand'))

@section('content')


<!-- container -->
    <div class="container m-5" style="min-width: 90%;">
        <div class="row">
           @include('layouts.admin_dashboard_menu')



        <div class="col-md-9">





                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 border-right">
                                <h4>Users</h4>
                            </div>
                            


                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-hover " style="border-bottom: 1px solid #dee2e6;">
                                    <thead class="bg-light ">
                                        <tr>
                                           
                                            
                                            <th>Name</th>
                                            <th>email</th>
                                            <th>phone</th>
                                            <th style="width: 50%;">Message</th>
                                            

                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach($post as $temp)
                                        <tr>
                                            
                                            <td><small>{{$temp->name}}</small></a></td>
                                            <td><small>{{$temp->email}}</small></td>
                                            <td><small>{{$temp->phone}}</small></td>
                                            <td><small>{{$temp->query}}</small></td>

                                        </tr>

                                        @endforeach
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style type="text/css">
        

        .table td, .table th{

            text-align: center;
            border-left: 1px solid #dee2e6;
            border-right: 1px solid #dee2e6;
        }
    </style>

    @endsection