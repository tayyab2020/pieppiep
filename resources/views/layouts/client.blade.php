<!DOCTYPE html>
<html style="position: relative;height: 100%;" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="{{$seo->meta_keys}}">
    <meta name="author" content="GeniusOcean">

    <title>{{$gs->title}}</title>
    <link href="{{asset('assets/admin/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/perfect-scrollbar.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/bootstrap-colorpicker.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('assets/admin/css/responsive.css')}}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{asset('assets/images/'.$gs->favicon)}}">


    <link href="{{ asset('assets/front/css/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/front/css/slicknav.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/front/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/front/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/front/css/responsive.css') }}" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{asset('assets/images/'.$gs->favicon)}}">
    <link href="{{ asset('assets/front/select2/select2.min.css') }}" rel="stylesheet" >
    <script src="{{asset('assets/admin/js/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/front/select2/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/0.8.2/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/css/bootstrap-select.min.css">



    @include('styles.admin-design')


    @yield('styles')


<!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-165295462-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-165295462-1');
    </script>


</head>
<body style="overflow: hidden;height: 100%;">

<div style="padding: 20px 0;border-bottom: 2px solid #0090e3c9;position: fixed;width: 100%;z-index: 1000;" class="container-fluid top-bar">

    <div style="display: flex;flex-direction: row;align-items: center;">

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">

            <button style="outline: none !important;background: #5bc0de !important;border-color: #46b8da !important;" type="button" id="sidebarCollapse1" class="btn btn-info">
                <i class="fa fa-align-left"></i>
            </button>

        </div>

        <div style="text-align: right;" class="col-lg-10 col-md-10 col-sm-10 col-xs-10">

            <a class="dropdown-toggle" href="#homeSubmenu" data-toggle="collapse"
               aria-expanded="false">

                <img style="width: 45px;height: 45px;border-radius: 100%;border: 1px solid #dddddd;margin-right: 10px;"
                     src="{{ Auth::guard('user')->user()->photo ? asset('assets/images/'.Auth::guard('user')->user()->photo):"https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG"}}"
                     alt="profile image">

                <span class="user-info">
                    {{ Auth::guard('user')->user()->name}} {{Auth::guard('user')->user()->family_name}}
                    {{--<span>{{$lang->cmt}}</span>--}}
                </span>

            </a>

            <ul style="position: absolute;right: 20px;border: 1px solid rgb(190, 190, 190);text-align: left;margin: 0;z-index: 1000;background: white;border-radius: 5px;" class="collapse list-unstyled profile-submenu" id="homeSubmenu">

                <li style="padding: 15px;"><a href=" {{ route('client-profile') }} "><i
                            class="fa fa-fw fa-cog"></i> {{$lang->edit}}</a></li>
                <li style="padding: 0 15px 15px 15px;"><a href=" {{ route('user-reset') }} "><i
                            class="fa fa-fw fa-cog"></i> {{$lang->chnp}}</a></li>
                <li style="padding: 0 15px 15px 15px;"><a href="{{ route('user-logout') }}"><i
                            class="fa fa-fw fa-power-off"></i> {{$lang->logout}}</a></li>
            </ul>

        </div>

    </div>

</div>

<style type="text/css">

    #sidebar ul
    {
        list-style-type:none;
    }


    #sidebar ul li a
    {
        text-decoration:none;
        text-align: left !important;
    }

    #sidebar ul li a::before
    {
        display: none;
    }

    #sidebar.active .sub-show {

        /*-webkit-transform: translateX(118px) !important;

        transform: translateX(118px) !important;*/

        -webkit-transform: translateX(-250px) !important;

        transform: translateX(-250px) !important;

        -webkit-transition: transform 0.5s ease-in-out !important;

        -moz-transition: transform 0.5s ease-in-out !important;

        -ms-transition: transform 0.5s ease-in-out !important;

        transition: transform 0.5s ease-in-out !important;

    }

    #sidebar .sub-show {

        -webkit-transform: translateX(248px) !important;

        transform: translateX(248px) !important;

        -webkit-transition: transform 1s ease-in !important;

        -moz-transition: transform 1s ease-in !important;

        -ms-transition: transform 1s ease-in !important;

        transition: transform 1s ease-in !important;

    }

    #sidebar ul li > ul {

        position: absolute;

        background-color: #35A7E8;

        top: 87px;

        width: 250px;

        z-index: 1000;

        height: 100%;

        -webkit-transform: translateX(-250px);

        transform: translateX(-250px);

        -webkit-transition: transform 0.8s ease-in;

        -moz-transition: transform 0.8s ease-in;

        -ms-transition: transform 0.8s ease-in;

        transition: transform 0.8s ease-in;

        padding: 0;

        border-left: 1px solid #3f99e6;

    }

    .parent-menu:hover > .parent-menu::-webkit-scrollbar
    {
        display: block;
    }

    .parent-menu::-webkit-scrollbar-thumb
    {
        background-color: #1c97dd;
        border-radius: 10px;
    }

    .parent-menu::-webkit-scrollbar
    {
        background-color: transparent;
        width: 5px;
    }

    /*
    DEMO STYLE
*/
    .section-padding
    {
        padding: 0;
    }

    @import "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700";
    body {
        font-family: 'Poppins', sans-serif;
        background: #fafafa;
    }

    p {
        font-family: 'Poppins', sans-serif;
        font-size: 1.1em;
        font-weight: 300;
        line-height: 1.7em;
        color: #999;
    }

    a,
    a:hover,
    a:focus {
        color: inherit;
        text-decoration: none;
        transition: all 0.3s;
    }

    .navbar {
        padding: 15px 10px;
        background: #fff;
        border: none;
        border-radius: 0;
        margin-bottom: 40px;
        box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
    }

    .navbar-btn {
        box-shadow: none;
        outline: none !important;
        border: none;
    }

    .line {
        width: 100%;
        height: 1px;
        border-bottom: 1px dashed #ddd;
        margin: 40px 0;
    }


    /*i,
    span {
        display: inline-block;
    }*/

    /* ---------------------------------------------------
        SIDEBAR STYLE
    ----------------------------------------------------- */

    .wrapper {
        display: flex;
        align-items: stretch;
        height: 100%;
        position: absolute;
        width: 100%;
        padding-top: 87px;
    }

    #sidebar {
        position: static;
        z-index: 1000;
        height: 100%;
        min-width: 250px;
        max-width: 250px;
        background-color: {{$gs->colors == null ? 'rgba(204, 37, 42, 0.79)':$gs->colors.'c9'}};
        color: #fff;
        transition: all 1s;
        overflow: hidden;
    }

    #sidebar.active {
        /*min-width: 120px;
        max-width: 120px;*/
        min-width: 0;
        max-width: 0;
        text-align: center;
        /*margin-left: -250px;*/
    }

    .transform-it
    {
        -webkit-transform: translateX(120px);
        transform: translateX(120px);
        width: 92.2% !important;
    }

    .transform-it2
    {
        -webkit-transform: translateX(250px);
        transform: translateX(250px);
    }

    #sidebar:not(.active) h3
    {
        display: none;
    }

    #sidebar.active .sidebar-header .sidebar-header-logo,
    #sidebar.active .CTAs {
        display: none;
    }

    #sidebar.active .sidebar-header strong {
        display: block;
    }

    #sidebar.active .profile .r-na
    {
        width: 100%;
        padding: 0;
    }

    #sidebar ul li a {
        text-align: left;
    }

    #sidebar ul li a.active
    {
        color: #fff;
        background: {{$gs->colors == null ? 'rgba(207, 55, 58, 0.70)':$gs->colors.'c2'}};
    }

    #sidebar ul li a.active1
    {
        background-color: #fff;
        color: {{$gs->colors == null ? 'rgba(207, 55, 58, 0.70)':$gs->colors.'c2'}};
    }

    #sidebar.active ul li a {
        padding: 20px 10px;
        text-align: center;
        font-size: 0.85em;
    }

    #sidebar.active ul li a span
    {
        display: none;
    }

    #sidebar.active ul li a i {
        margin: auto auto 5px auto;
        display: block;
        font-size: 1.3em;
    }

    #sidebar.active ul li ul li a i {
        margin: auto 10px 5px auto;
        display: inline-block;
    }

    #sidebar.active ul ul a {
        padding: 19px !important;
    }

    #sidebar ul ul a {
        padding: 1em !important;
    }

    #sidebar.active .dropdown-toggle::before {
        top: auto !important;
        bottom: 5px !important;
        right: 50% !important;
        -webkit-transform: translateX(50%) !important;
        -ms-transform: translateX(50%) !important;
        transform: translateX(50%) !important;
    }

    #sidebar .sidebar-header {
        padding: 20px;
    }

    #sidebar .sidebar-header strong {
        display: none;
        font-size: 0.8em;
    }

    #sidebar ul.components {
        padding: 0 0 100px 0;
        overflow-y: auto;
        height: 100%;
        visibility: hidden;
    }

    #sidebar ul.components li, #sidebar ul.components:hover,
    #sidebar ul.components:focus
    {
        visibility: visible !important;
    }

    #sidebar ul li a {
        padding: 10px;
        font-size: 1.1em;
        display: block;
    }

    #sidebar .components li a:hover, #sidebar .profile .profile-submenu li a:hover {
        color: #7386D5;
        background: #fff;
    }

    #sidebar ul li a i {
        margin-right: 10px;
    }

    #sidebar .components li.active>a {
        color: #fff;
        background: {{$gs->colors == null ? 'rgba(204, 37, 42, 0.79)':$gs->colors.'c9'}};
    }

    a[data-toggle="collapse"] {
        position: relative;
    }

    #sidebar .dropdown-toggle::before
    {
        display: block !important;
        position: absolute !important;
        top: 50% !important;
        right: 20px !important;
        transform: translateY(-50%) !important;
    }

    ul ul a {
        font-size: 0.9em !important;
        padding-left: 30px !important;
    }

    ul.CTAs {
        padding: 20px;
    }

    ul.CTAs a {
        text-align: center;
        font-size: 0.9em !important;
        display: block;
        border-radius: 5px;
        margin-bottom: 5px;
    }

    a.download {
        background: #fff;
        color: #7386D5;
    }

    /* ---------------------------------------------------
        CONTENT STYLE
    ----------------------------------------------------- */

    #content {
        width: 100%;
        transition: all 1s;
        overflow: hidden;
    }

    /* ---------------------------------------------------
        MEDIAQUERIES
    ----------------------------------------------------- */

    @media (max-width: 768px) {

        #sidebar ul li > ul
        {
            top: 0 !important;
        }

        .user-info, a[aria-expanded="false"]::before, a[aria-expanded="true"]::before
        {
            display: none;
        }

        /*#sidebar {
            min-width: 80px;
            max-width: 80px;
            text-align: center;
            margin-left: -80px !important;
        }*/
        /*#sidebar .dropdown-toggle::before {
            top: auto !important;
            bottom: 10px !important;
            right: 50% !important;
            -webkit-transform: translateX(50%) !important;
            -ms-transform: translateX(50%) !important;
            transform: translateX(50%) !important;
        }*/

        .transform-it
        {
            -webkit-transform: translateX(0px);
            transform: translateX(0px);
            width: 100% !important;
        }

        .transform-it2
        {
            -webkit-transform: translateX(250px);
            transform: translateX(250px);
        }

        #sidebar
        {
            position: absolute;
        }

        #sidebar.active .sub-show {

            -webkit-transform: translateX(-250px) !important;

            transform: translateX(-250px) !important;

            -webkit-transition: transform 0.5s ease-in-out !important;

            -moz-transition: transform 0.5s ease-in-out !important;

            -ms-transition: transform 0.5s ease-in-out !important;

            transition: transform 0.5s ease-in-out !important;

        }

        #sidebar .sub-show {

            -webkit-transform: translateX(0px) !important;

            transform: translateX(0px) !important;

            -webkit-transition: transform 1s ease-in !important;

            -moz-transition: transform 1s ease-in !important;

            -ms-transition: transform 1s ease-in !important;

            transition: transform 1s ease-in !important;

        }

        #sidebar.active {
            margin-left: -120px !important;
        }

        #sidebar .sidebar-header .sidebar-header-logo,
        #sidebar .CTAs {
            display: none;
        }
        #sidebar .sidebar-header strong {
            display: block;
        }
        #sidebar ul li a {
            padding: 20px 10px;
        }
        #sidebar ul li a span {
            font-size: 0.85em;
        }
        /*#sidebar ul li a i {
            margin-right: 0;
            display: block;
        }*/
        #sidebar ul ul a {
            padding: 10px !important;
        }
        #sidebar ul li a i {
            font-size: 1.3em;
        }
        /*#sidebar {
            margin-left: 0;
        }*/
        #sidebarCollapse span {
            display: none;
        }
    }

    #sidebar-menu
    {
        width: 100%;
    }

    button {
        outline: none !important;
    }

    .bootstrap-select {
        margin-bottom: 0 !important;
    }

    #lang-form .bootstrap-select .selectpicker {

        background-color: white !important;
        color: inherit !important;
        margin: 0;
        text-transform: inherit;
        white-space: nowrap;
        border: 1px solid transparent;
        box-shadow: none;
        border-color: #ccc !important;
        font-size: 14px;
        padding: 6px 12px;
        padding-right: 25px;
        border-radius: 4px;

    }

    .bootstrap-select .dropdown-menu {
        padding: 0 !important;
    }

    .selected {
        background-color: #ececec;

    }

    .language-select {

        width: 100% !important;
        text-align: center;
        margin-top: 25px !important;
    }

    .right-side {
        width: 100% !important;
        margin: 0 !important;
        height: 100% !important;
        background: transparent !important;
        padding: 20px;
        overflow-y: auto;
        overflow-x: hidden;
    }

    .right-side .container-fluid
    {
        padding: 0;
    }

    .add-product-1
    {
        margin: 0;
    }

    @media only screen and (min-width: 1200px) and (min-width: 768px) {

        ul.profile li.active img {

            margin-left: 0;
        }

    }

    .bootstrap-select.fit-width {
        width: 70% !important;
    }

    #sidebar-menu ul.components ul li a {
        padding-left: 15px;
    }


    iframe {
        width: 100%;
    }


    .bootstrap-select .dropdown-menu {
        position: relative;
    }


    .add-back-btn, .add-newProduct-btn {
        background-color: <?php if($gs->btn_bg == null) { if($gs->colors == null){ echo '#f3bd02 !important;'; } else {   echo $gs->colors.' !important;'; }} else { echo $gs->btn_bg. ' !important;'; } ?>

         border-color:
        <?php if($gs->btn_brd != null) { echo $gs->btn_brd. ' !important;'; } else { echo '#ffffff00 !important;'; } ?>
color: <?php if($gs->btn_col != null) { echo $gs->btn_col. ' !important;'; } else { echo '#fff !important;'; } ?>

    }

    .featured-btn {
        background-color: <?php if($gs->btn_bg == null) { if($gs->colors == null){ echo '#f3bd02 !important;'; } else {   echo $gs->colors.' !important;'; }} else { echo $gs->btn_bg. ' !important;'; } ?>

         border-color:
        <?php if($gs->btn_brd != null) { echo $gs->btn_brd. ' !important;'; } else { echo '#ffffff00 !important;'; } ?>

color: <?php if($gs->btn_col != null) { echo $gs->btn_col. ' !important;'; } else { echo '#fff !important;'; } ?>

    }

    .add-product_btn {
        background-color: <?php if($gs->btn_bg == null) { if($gs->colors == null){ echo '#f3bd02 !important;'; } else {   echo $gs->colors.' !important;'; }} else { echo $gs->btn_bg. ' !important;'; } ?>

         border-color:
        <?php if($gs->btn_brd != null) { echo $gs->btn_brd. ' !important;'; } else { echo '#ffffff00 !important;'; } ?>

color: <?php if($gs->btn_col != null) { echo $gs->btn_col. ' !important;'; } else { echo '#fff !important;'; } ?>

    }

    .boxed-btn.blog {
        background-color: <?php if($gs->btn_bg == null) { if($gs->colors == null){ echo '#f3bd02 !important;'; } else {   echo $gs->colors.' !important;'; }} else { echo $gs->btn_bg. ' !important;'; } ?>

         border-color:
        <?php if($gs->btn_brd != null) { echo $gs->btn_brd. ' !important;'; } else { echo '#ffffff00 !important;'; } ?>

color: <?php if($gs->btn_col != null) { echo $gs->btn_col. ' !important;'; } else { echo '#fff !important;'; } ?>

    }

    .nicEdit-button {
        background-image: url("<?php echo asset('assets/images/nicEditIcons-latest.gif'); ?>") !important;
    }

</style>

<div class="wrapper">

    <!-- Sidebar  -->
    <nav id="sidebar" class="active">

        <ul class="parent-menu list-unstyled components">

            {{--<li>
                <a href="{{route('client-quotation-requests')}}"  id="dashboard"><i class="fa fa-home"></i> <span>{{$lang->dashboard}}</span></a>
            </li>--}}

            {{--<li>
                <a href="{{route('client-bookings')}}"><i class="fa fa-fw fa-book"></i> <span>{{$lang->mbt1}}</span></a>
            </li>--}}

            <li>
                <a href="{{route('client-new-quotations')}}"><i class="fa fa-fw fa-file-text"></i> <span>Direct Quotations</span></a>
            </li>

            <li>
                <a href="{{route('client-quotation-requests')}}"><i class="fa fa-fw fa-file-text"></i> <span>{{__('text.Quotation Requests')}}</span></a>
            </li>

            <li>
                <a href="{{route('client-quotations')}}"><i class="fa fa-fw fa-file-text"></i> <span>Indirect Quotations</span></a>
            </li>

            <li>
                <a href="{{route('client-quotations-invoices')}}"><i class="fa fa-fw fa-file-text"></i> <span>{{__('text.Quotation Invoices')}}</span></a>
            </li>

            {{--<li>
                <a href="{{route('client-custom-quotations')}}"><i class="fa fa-fw fa-file-text"></i> <span>{{__('text.Handyman Quotations')}}</span></a>
            </li>--}}

            <li class="lang-list" style="text-align: center;margin-top: 20px;">

                <form method="post" action="{{route('lang.clientchange')}}" id="lang-form">
                    {{csrf_field()}}


                    <input type="hidden" class="lang_select" value="{{$lang->lang}}" name="lang_select">

                    <div class="btn-group bootstrap-select fit-width">

                        @if($lang->lang == 'eng')

                            <button type="button" class="btn dropdown-toggle selectpicker btn-default"
                                    data-toggle="dropdown" title="English" style="color: black !important;outline: none !important;">

                                            <span class="filter-option pull-left"><span
                                                    class="flag-icon flag-icon-nl"></span> English</span>&nbsp;<span
                                    class="caret"></span></button>

                            <div class="dropdown-menu open">

                                <ul class="dropdown-menu inner selectpicker" role="menu">

                                    <li rel="0" class="selected"><a href="#" tabindex="0" class=""
                                                                    onclick="formSubmit(this)"
                                                                    data-value="eng"
                                                                    style="color: black !important;"><span
                                                class="flag-icon flag-icon-us"></span> English<i
                                                class="glyphicon glyphicon-ok icon-ok check-mark"></i></a>
                                    </li>

                                    <li rel="1"><a href="#" tabindex="0" class=""
                                                   style="color: black !important;"
                                                   onclick="formSubmit(this)" data-value="du"><span
                                                class="flag-icon flag-icon-nl"></span> Nederlands<i
                                                class="glyphicon glyphicon-ok icon-ok check-mark"></i></a>
                                    </li>
                                </ul>

                            </div>

                        @elseif($lang->lang == 'du')

                            <button type="button" class="btn dropdown-toggle selectpicker btn-default"
                                    data-toggle="dropdown" title="Nederlands"
                                    style="color: black !important;outline: none !important;">

                                            <span class="filter-option pull-left"><span
                                                    class="flag-icon flag-icon-nl"></span> Nederlands</span>&nbsp;<span
                                    class="caret"></span></button>

                            <div class="dropdown-menu open">

                                <ul class="dropdown-menu inner selectpicker" role="menu">

                                    <li rel="0"><a href="#" tabindex="0" class="" onclick="formSubmit(this)"
                                                   data-value="eng" style="color: black !important;"><span
                                                class="flag-icon flag-icon-us"></span> English<i
                                                class="glyphicon glyphicon-ok icon-ok check-mark"></i></a>
                                    </li>

                                    <li rel="1" class="selected"><a href="#" tabindex="0" class=""
                                                                    onclick="formSubmit(this)"
                                                                    data-value="du"
                                                                    style="color: black !important;"><span
                                                class="flag-icon flag-icon-nl"></span> Nederlands<i
                                                class="glyphicon glyphicon-ok icon-ok check-mark"></i></a>
                                    </li>
                                </ul>

                            </div>

                        @endif

                    </div>

                </form>

            </li>

        </ul>

    </nav>

    <!-- Page Content  -->
    <div id="content">

        @yield('content')

    </div>
</div>


<script type="text/javascript">

    function formSubmit(e)
    {
        var value = $(e).data('value');

        $('.lang_select').val(value);

        $('#lang-form').submit();

    }

    $(document).ready(function() {

        $('#sidebar ul li ul').removeClass('hide');

        /*$('#sidebar').hover(function () {

            $('#sidebar').removeClass('active');

        }, function(){
            $('#sidebar').addClass('active');
        });*/

        $('#sidebarCollapse1').on('click', function () {

            if($(window).innerWidth() <= 768)
            {
                $('#sidebar ul li ul').removeClass('sub-show');
            }

            $('#sidebar').toggleClass('active');

            /*if($('#sidebar').hasClass('active'))
            {
                $('#content').removeClass('transform-it2');
                $('#content').addClass('transform-it');
            }
            else
            {
                $('#content').removeClass('transform-it');
                $('#content').addClass('transform-it2');
            }*/
        });

        $('#sidebar ul li a').on('click', function () {

            $('#sidebar ul li ul').not($(this).next('ul')).removeClass('sub-show');
            $(this).next('ul').toggleClass('sub-show');

        });

    });

</script>


<style type="text/css">

    button
    {
        outline: none !important;
    }

    .bootstrap-select
    {
        margin-bottom: 0px !important;
    }

    #lang-form .bootstrap-select .selectpicker
    {

        background-color: white !important;
    color: inherit !important;
    margin: 0;
    text-transform: inherit;
    white-space: nowrap;
    border: 1px solid transparent;
    box-shadow: none;
    border-color: #ccc !important;
    font-size: 14px;
    padding: 6px 12px;
    padding-right: 25px;
    border-radius: 4px;

    }

     .bootstrap-select .dropdown-menu
     {
         padding: 0 !important;
     }

    .selected
    {
        background-color: #ececec;
    }

    .language-select
    {
        width: 100% !important;
        text-align: center;
        margin-top: 25px !important;
    }

                @media only screen and (min-width: 1200px) and (min-width: 768px)
                {

                    .right-side
                    {
                        width: 81%;
                    }

                    ul.profile li.active img
                    {
                        margin-left: 0px;
                    }

                }

                .bootstrap-select.fit-width
                {
                    width: 70% !important;
                }

                #sidebar-menu ul.components ul li a
                {
                    padding-left: 15px;
                }




                iframe
                {
                    width: 100%;
                }



                .bootstrap-select .dropdown-menu
                {
                    position: relative;
                }

                .bootstrap-select .dropdown-menu
                {
                    position: relative;
                }
</style>

<style type="text/css">

    #sidebar-menu
    {
        width: 100%;
    }

    .add-back-btn, .add-newProduct-btn
    {
        background-color: <?php if($gs->btn_bg == null) { if($gs->colors == null){ echo '#f3bd02 !important;'; } else {   echo $gs->colors.' !important;'; }} else { echo $gs->btn_bg. ' !important;'; } ?>

        border-color: <?php if($gs->btn_brd != null) { echo $gs->btn_brd. ' !important;'; } else { echo '#ffffff00 !important;'; } ?>

        color: <?php if($gs->btn_col != null) { echo $gs->btn_col. ' !important;'; } else { echo '#fff !important;'; } ?>
    }

    .featured-btn
    {
        background-color: <?php if($gs->btn_bg == null) { if($gs->colors == null){ echo '#f3bd02 !important;'; } else {   echo $gs->colors.' !important;'; }} else { echo $gs->btn_bg. ' !important;'; } ?>

        border-color: <?php if($gs->btn_brd != null) { echo $gs->btn_brd. ' !important;'; } else { echo '#ffffff00 !important;'; } ?>

        color: <?php if($gs->btn_col != null) { echo $gs->btn_col. ' !important;'; } else { echo '#fff !important;'; } ?>
    }

    .add-product_btn
    {
        background-color: <?php if($gs->btn_bg == null) { if($gs->colors == null){ echo '#f3bd02 !important;'; } else {   echo $gs->colors.' !important;'; }} else { echo $gs->btn_bg. ' !important;'; } ?>

        border-color: <?php if($gs->btn_brd != null) { echo $gs->btn_brd. ' !important;'; } else { echo '#ffffff00 !important;'; } ?>

        color: <?php if($gs->btn_col != null) { echo $gs->btn_col. ' !important;'; } else { echo '#fff !important;'; } ?>
    }

    .boxed-btn.blog
     {
        background-color: <?php if($gs->btn_bg == null) { if($gs->colors == null){ echo '#f3bd02 !important;'; } else {   echo $gs->colors.' !important;'; }} else { echo $gs->btn_bg. ' !important;'; } ?>

        border-color: <?php if($gs->btn_brd != null) { echo $gs->btn_brd. ' !important;'; } else { echo '#ffffff00 !important;'; } ?>

        color: <?php if($gs->btn_col != null) { echo $gs->btn_col. ' !important;'; } else { echo '#fff !important;'; } ?>
    }

    .nicEdit-button
    {
        background-image: url("<?php echo asset('assets/images/nicEditIcons-latest.gif'); ?>") !important;
    }

</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/js/bootstrap-select.min.js"></script>
<script src="{{asset('assets/admin/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/admin/js/perfect-scrollbar.jquery.min.js')}}"></script>
<script src="{{asset('assets/admin/js/jquery.canvasjs.min.js')}}"></script>
<script src="{{asset('assets/admin/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/admin/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('assets/admin/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/admin/js/bootstrap-colorpicker.js')}}"></script>
<script src="{{asset('assets/admin/js/main.js')}}"></script>
<script src="{{asset('assets/admin/js/admin-main.js')}}"></script>



@yield('scripts')

</body>
</html>
