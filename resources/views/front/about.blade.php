@extends('layouts.front')
@section('content')
      <div class="section-padding about-area-wrapper wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
               <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title pb_50 text-center">
                            <h2>{{$lang->abouts}}</h2>

                            <div class="section-borders">
                                <span></span>
                                <span class="black-border"></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
                   <div class="row">
                       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        {!! $about !!}
                       </div>
                   </div>
               </div>
           </div>

@endsection