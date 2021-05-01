@extends('layouts.front')
@section('content')
<div class="section-padding all-blogs-area-wrapper wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title pb_50 text-center">
                            <h2>{{$lang->blogs}}</h2>

                            <div class="section-borders">
                                <span></span>
                                <span class="black-border"></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                	@foreach($blogs as $blog)
                     <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <a href="{{route('front.blogshow',$blog->title)}}" class="single-all-blogs-box">
                               <div class="blog-thumb-wrapper">
                                   <img src="{{asset('assets/images/'.$blog->photo)}}" alt="Blog Image">
                               </div>
                                <div class="blog-text">
                                    <p class="blog-meta">{{ date('d M, Y, h:i A',strtotime($blog->created_at))}}</p>
                                    <h4>{{$blog->title}}</h4>
                                    <p class="blog-meta-text">{{substr(strip_tags($blog->details),0,250)}}</p>
                                    <span class="boxed-btn blog">{{$lang->vd}}</span>
                                </div>
                            </a>
                        </div>
                        @endforeach


                     </div>
                    <div class="text-center">
                    {!! $blogs->links() !!}
                    </div>
                </div>
            </div>

@endsection
