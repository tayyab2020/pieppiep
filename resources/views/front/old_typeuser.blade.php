@extends('layouts.front')
@section('styles')
    <style type="text/css">
        /* Hide the list on focus of the input field */
        datalist {
            display: none;
        }

        /* specifically hide the arrow on focus */
        input::-webkit-calendar-picker-indicator {
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="hero-area overlay" style="background-image: url({{asset('assets/images/'.$gs->bgimg)}});">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="donors-header text-center">{{$lang->gt}} {{$cat->cat_name}}</h1>
                    <div class="hero-form">
                        <div class="hero-form-wrapper inline">
                            <form action="{{route('user.search')}}" method="GET">

                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-fw fa-home"></i>
                                                </div>
                                                <input list="cities" type="search" name="search" id="country"
                                                       class="form-control" placeholder="{{$lang->ec}}" required="">

                                                <datalist id="cities">
                                                    @if($cities != null)
                                                        @foreach($cities as $city)
                                                            <option value="{{$city}}">
                                                        @endforeach
                                                    @endif
                                                </datalist>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-fw fa-cog"></i>
                                                </div>
                                                <select name="group" id="blood_grp" class="form-control" required="">
                                                    <option value="">{{$lang->sbg}}</option>
                                                    @foreach($cats as $cat)
                                                        <option value="{{$cat->id}}">{{$cat->cat_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group text-center">
                                            <input class="btn btn-block hero-btn" name="button"
                                                   value="{{$lang->search}}" type="submit">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="section-padding all-donors-wrap team_section team_style2 wow fadeInUp"
         style="visibility: visible; animation-name: fadeInUp;">
        <div class="container">
            @foreach($users->chunk(4) as $userChunk)
                <div class="row">
                    @foreach($userChunk as $user)
                        <div class="col-lg-3 col-md-3 col-sm-6">
                            <div class="team_common">
                                <div class="member_img">
                                    <a href="{{route('front.user',$user->id)}}"><img
                                            src="{{ $user->photo ? asset('assets/images/'.$user->photo):'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG'}}"
                                            alt="member image"></a>
                                </div>
                                <div class="member_info text-center pos_relative">
                                    <div class="overlay1"></div>
                                    <div class="overlay2"></div>
                                    <div class="content">
                                        <a href="{{route('front.user',$user->id)}}"
                                           class="d_inline fw_600">{{$user->name}}</a>
                                        <span
                                            class="d_block transition_3s">{{$lang->bg}} {{$user->category->cat_name}}</span>
                                        <ul class="social_contact pt_10" style="padding-left: 0px;">
                                            @if($user->f_url != null)
                                                <li>
                                                    <a href="{{$user->f_url ? $user->f_url:'https://www.facebook.com/'}}"
                                                       title="Facebook" target="_blank"><i
                                                            class="fa fa-facebook"></i></a>
                                                </li>
                                            @endif
                                            @if($user->t_url != null)
                                                <li>
                                                    <a href="{{$user->t_url ? $user->t_url:'https://twitter.com/'}}"
                                                       title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a>
                                                </li>
                                            @endif
                                            @if($user->l_url != null)
                                                <li>
                                                    <a href="{{$user->l_url ? $user->l_url:'https://www.linkedin.com/'}}"
                                                       title="linkedin" target="_blank"><i
                                                            class="fa fa-linkedin"></i></a>
                                                </li>
                                            @endif
                                            @if($user->g_url != null)
                                                <li>
                                                    <a href="{{$user->g_url ? $user->g_url:'https://plus.google.com/'}}"
                                                       title="Google-plus" target="_blank"><i
                                                            class="fa fa-google-plus"></i></a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            @endforeach
        </div>
        <div class="text-center">
            {!! $users->links() !!}
        </div>
    </div>

@endsection
