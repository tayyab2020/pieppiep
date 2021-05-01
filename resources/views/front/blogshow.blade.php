@extends('layouts.front')
@section('content')
<div class="section-padding blog-post-wrapper wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title">
                            <h2>{{$blog->title}}</h2>
                            <ul>
                                <li style="display: none;"><i class="fa fa-clock-o"></i> {{$blog->created_at->diffForHumans()}}</li>
                                <li>{{$lang->bs}}: {{$blog->source}}</li>
                                <li><i class="fa fa-eye"></i>{{$blog->views}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        @if($blog->photo)
                            <p><img style="height: 300px;" src="{{asset('assets/images/'.$blog->photo)}}" alt=""></p>
                        @endif
                       <div class="row">
                           <div class="col-md-8">
                               <div class="entry-content">
                                {!!$blog->details!!}
                                </div>
                           </div>
                           <div class="col-md-3 col-md-offset-1">
                               <div class="post-sidebar-area">
                                   <h2 class="post-heading">{{__('text.Recent Posts')}}</h2>
                                   <ul>
                                    @foreach($lblogs as $lblog)
                                       <li><i class="fa fa-angle-right"></i> <a href="{{route('front.blogshow',$lblog->title)}}">{{$lblog->title}}</a> <span>{{date('d M Y',(strtotime($lblog->created_at)))}}</span></li>
                                    @endforeach
                                   </ul>
                               </div>
                           </div>
                       </div>
                                <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                    <a class="a2a_dd" href=""></a>
                                    <a class="a2a_button_facebook" href=""></a>
                                    <a class="a2a_button_twitter" href=""></a>
                                    <a class="a2a_button_google_plus" href=""></a>
                                </div>
                                <script async src="https://static.addtoany.com/menu/page.js"></script>
                    </div>
                </div>
            </div>
        </div>

@endsection
