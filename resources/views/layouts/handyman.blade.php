<!DOCTYPE html>
<html lang="en">
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
    <link href="{{ asset('assets/front/select2/select2.min.css') }}" rel="stylesheet">
    <script src="{{asset('assets/admin/js/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/front/select2/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/0.8.2/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.2/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css"
          href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css">


@include('styles.admin-design')


@yield('styles')

<!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-165295462-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-165295462-1');
    </script>

</head>
<body>

<div class="wrapper">
    <!-- Sidebar  -->
    <nav id="sidebar" class="active">

        <div class="sidebar-header">

            <a href="{{route('front.index')}}">
                <h3 style="color: white;">{{$gs->title[0]}}</h3>

                <img src="{{asset('assets/images/'.$gs->logo)}}" alt="Sidebar header logo" class="sidebar-header-logo" style="height: 55px;width: 100%;">
            </a>

        </div>

        <ul class="list-unstyled profile">
            <li style="padding-bottom: 0;" class="active">
                <div class="row" style="margin-left: 0px;margin-right: 0px;">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                        <img
                            src="{{ Auth::guard('user')->user()->photo ? asset('assets/images/'.Auth::guard('user')->user()->photo):"https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG"}}"
                            alt="profile image">
                    </div>
                    <div class="r-na col-lg-9 col-md-9 col-sm-9 col-xs-9">
                        <a class="dropdown-toggle" href="#homeSubmenu" data-toggle="collapse"
                           aria-expanded="false">{{ Auth::guard('user')->user()->name}} {{Auth::guard('user')->user()->family_name}}
                            <span>{{$lang->hmt}}</span></a>
                    </div>
                </div>
                <ul class="collapse list-unstyled profile-submenu" id="homeSubmenu">

                    <li><a href=" {{ route('user-reset') }} "><i
                                class="fa fa-fw fa-cog"></i> {{$lang->chnp}}</a></li>
                    <li><a href="{{ route('user-logout') }}"><i
                                class="fa fa-fw fa-power-off"></i> {{$lang->logout}}</a></li>
                </ul>
            </li>
        </ul>

        <ul class="list-unstyled components">

            <li>
                <a class="dropdown-toggle" href="#dashboard1" data-toggle="collapse" @if(Route::currentRouteName() == 'user-dashboard' || Route::currentRouteName() == 'user-profile' || Route::currentRouteName() == 'radius-management' || Route::currentRouteName() == 'user-complete-profile') aria-expanded="true" @else aria-expanded="false" @endif><i class="fa fa-fw fa-file-code-o"></i> <span>{{$lang->dashboard}}</span></a>

                <ul class="collapse list-unstyled submenu" id="dashboard1">

                    @if(auth()->user()->can('show-dashboard'))

                        <li><a href="{{route('user-dashboard')}}"><i class="fa fa-angle-right"></i> {{__('text.Dashboard')}}</a></li>

                    @endif


                    @if(auth()->user()->can('edit-profile'))

                        <li><a href="{{route('user-profile')}}"><i class="fa fa-angle-right"></i> {{$lang->edit}}</a></li>

                    @endif


                    @if(auth()->user()->can('radius-management'))

                        <li><a href="{{route('radius-management')}}"><i class="fa fa-angle-right"></i> {{$lang->rm}}</a></li>

                    @endif


                    @if(auth()->user()->can('user-complete-profile'))

                        <li><a href="{{route('user-complete-profile')}}"><i class="fa fa-angle-right"></i> {{$lang->cmpt}}</a></li>

                    @endif

                </ul>
            </li>

            {{--<li>
                <a href="{{route('handyman-bookings')}}"><i class="fa fa-fw fa-book"></i> <span>{{$lang->mbt}}</span></a>
            </li>--}}

            @if(auth()->user()->role_id == 2)

                @if(auth()->user()->can('retailer-suppliers'))

                    <li>
                        <a href="{{route('suppliers')}}"><i class="fa fa-fw fa-file-text"></i> <span>Suppliers</span></a>
                    </li>

                @endif

            @endif

            @if(auth()->user()->role_id == 4)

                @if(auth()->user()->can('supplier-retailers'))

                    <li>
                        <a href="{{route('retailers')}}"><i class="fa fa-fw fa-file-text"></i> <span>Retailers</span></a>
                    </li>

                @endif

            @endif

            @if(auth()->user()->can('create-new-quotation'))

                <li>
                    <a href="{{route('new-quotations')}}"><i class="fa fa-fw fa-file-text"></i> <span>New Quotations</span></a>
                </li>

                <li>
                    <a href="{{route('create-new-quotation')}}"><i class="fa fa-fw fa-file-text"></i> <span>Create Quotation (New)</span></a>
                </li>

            @endif


            @if(auth()->user()->can('handyman-quotation-requests'))

                <li>
                    <a href="{{route('handyman-quotation-requests')}}"><i class="fa fa-fw fa-file-text"></i> <span>{{__('text.Quotation Requests')}}</span></a>
                </li>

            @endif


            @if(auth()->user()->can('quotations'))

                <li>
                    <a href="{{route('quotations')}}"><i class="fa fa-fw fa-file-text"></i> <span>{{__('text.Quotations')}}</span></a>
                </li>

            @endif


            @if(auth()->user()->can('quotations-invoices'))

                <li>
                    <a href="{{route('quotations-invoices')}}"><i class="fa fa-fw fa-file-text"></i> <span>{{__('text.Quotation Invoices')}}</span></a>
                </li>

            @endif


            @if(auth()->user()->can('commission-invoices'))

                <li>
                    <a href="{{route('commission-invoices')}}"><i class="fa fa-fw fa-file-text"></i> <span>{{__('text.Commission Invoices')}}</span></a>
                </li>

            @endif


            @if(auth()->user()->can('customers'))

                <li>
                    <a href="{{route('customers')}}"><i class="fa fa-fw fa-file-text"></i> <span>{{__('text.Customers')}}</span></a>
                </li>

            @endif


            @if(auth()->user()->can('employees'))

                <li>
                    <a href="{{route('employees')}}"><i class="fa fa-fw fa-file-text"></i> <span>Employees</span></a>
                </li>

            @endif


            @if(auth()->user()->hasAnyPermission(['customer-quotations', 'customer-invoices']))

                <li>
                    <a class="dropdown-toggle" href="#sales" data-toggle="collapse" @if(Route::currentRouteName() == 'user-products' || Route::currentRouteName() == 'product-create') aria-expanded="true" @else aria-expanded="false" @endif><i class="fa fa-fw fa-file-code-o"></i> <span>{{__('text.Sales')}}</span></a>
                    <ul class="collapse list-unstyled submenu" id="sales">

                        @if(auth()->user()->can('customer-quotations'))

                            <li><a href="{{route('customer-quotations')}}"><i class="fa fa-angle-right"></i> {{__('text.Quotations')}}</a></li>

                        @endif

                        @if(auth()->user()->can('customer-invoices'))

                            <li><a href="{{route('customer-invoices')}}"><i class="fa fa-angle-right"></i> {{__('text.Invoices')}}</a></li>

                        @endif

                    </ul>
                </li>

            @endif


            {{--@if(auth()->user()->hasAnyPermission(['user-products', 'product-create', 'user-items']))

                <li>
                    <a class="dropdown-toggle" href="#services" data-toggle="collapse" @if(Route::currentRouteName() == 'user-products' || Route::currentRouteName() == 'product-create' || Route::currentRouteName() == 'user-items') aria-expanded="true" @else aria-expanded="false" @endif><i class="fa fa-fw fa-file-code-o"></i> <span>{{__('text.My Products')}}</span></a>
                    <ul class="collapse list-unstyled submenu" id="services">

                        @if(auth()->user()->can('user-products'))

                            <li><a href="{{route('user-products')}}"><i class="fa fa-angle-right"></i> {{__('text.Products Overview')}}</a></li>

                        @endif

                        @if(auth()->user()->can('product-create'))

                            <li><a href="{{route('product-create')}}"><i class="fa fa-angle-right"></i> {{__('text.Add Products')}}</a></li>

                        @endif

                        @if(auth()->user()->can('user-items'))

                            <li><a href="{{route('user-items')}}"><i class="fa fa-angle-right"></i> {{__('text.My Items')}}</a></li>

                        @endif

                    </ul>
                </li>

            @endif--}}

            @if(auth()->user()->hasAnyPermission(['user-products', 'user-colors', 'user-price-tables', 'my-services', 'user-categories', 'user-brands', 'user-models', 'user-items', 'user-features']))

                <li>
                    <a href="#products" data-toggle="collapse" @if(Route::currentRouteName() == 'admin-product-index' || Route::currentRouteName() == 'admin-cat-index' || Route::currentRouteName() == 'admin-brand-index' || Route::currentRouteName() == 'admin-model-index' || Route::currentRouteName() == 'admin-item-index' || Route::currentRouteName() == 'admin-feature-index') aria-expanded="true" @else aria-expanded="false" @endif><i class="fa fa-fw fa-file-code-o"></i> <span>Products</span></a>
                    <ul class="collapse list-unstyled submenu" id="products">

                            @if(auth()->user()->can('user-products'))

                                <li><a href="{{route('admin-product-index')}}"><i class="fa fa-angle-right"></i> Products</a></li>

                            @endif

                            @if(auth()->user()->can('user-colors'))

                                <li><a href="{{route('admin-color-index')}}"><i class="fa fa-angle-right"></i> Colors</a></li>

                            @endif

                            @if(auth()->user()->can('user-price-tables'))

                                 <li><a href="{{route('admin-price-tables')}}"><i class="fa fa-angle-right"></i> Price Tables</a></li>

                            @endif

                            @if(auth()->user()->can('my-services'))

                                 <li><a href="{{route('admin-service-index')}}"><i class="fa fa-angle-right"></i> Services</a></li>

                            @endif

                            @if(auth()->user()->can('user-categories'))

                                 <li><a href="{{route('admin-cat-index')}}"><i class="fa fa-angle-right"></i> Categories</a></li>

                            @endif

                            @if(auth()->user()->can('user-brands'))

                                 <li><a href="{{route('admin-brand-index')}}"><i class="fa fa-angle-right"></i> Brands</a></li>

                            @endif

                            @if(auth()->user()->can('user-models'))

                                 <li><a href="{{route('admin-model-index')}}"><i class="fa fa-angle-right"></i> Models</a></li>

                            @endif

                            @if(auth()->user()->can('user-items'))

                                 <li><a href="{{route('admin-item-index')}}"><i class="fa fa-angle-right"></i> Items</a></li>

                            @endif

                            @if(auth()->user()->can('user-features'))

                                 <li><a href="{{route('admin-feature-index')}}"><i class="fa fa-angle-right"></i> Features</a></li>

                            @endif

                    </ul>
                </li>

            @endif


            {{--@if(auth()->user()->hasAnyPermission(['my-services', 'service-create']))

                <li>
                    <a class="dropdown-toggle" href="#services1" data-toggle="collapse" @if(Route::currentRouteName() == 'my-services' || Route::currentRouteName() == 'service-create') aria-expanded="true" @else aria-expanded="false" @endif><i class="fa fa-fw fa-file-code-o"></i> <span>My Services</span></a>
                    <ul class="collapse list-unstyled submenu" id="services1">

                        @if(auth()->user()->can('my-services'))

                            <li><a href="{{route('my-services')}}"><i class="fa fa-angle-right"></i> Services Overview</a></li>

                        @endif

                        @if(auth()->user()->can('service-create'))

                            <li><a href="{{route('service-create')}}"><i class="fa fa-angle-right"></i> Add Services</a></li>

                        @endif

                    </ul>
                </li>

            @endif--}}


            {{--<li>
                <a href="{{ route('user-subservices') }}" id="sub-services"><i
                        class="fa fa-fw fa-hospital-o"></i> <span>{{$lang->msst}}</span></a>
            </li>

            <li>
                <a href="{{ route('user-availability') }}" id="availability"><i
                        class="fa fa-fw fa-hospital-o"></i> <span>{{$lang->avmt}}</span></a>
            </li>--}}

            {{--<li>
                <a href="{{route('purchased-bookings')}}"><i class="fa fa-fw fa-book"></i> <span>{{$lang->pbt}}</span>
                </a>
            </li>

            <li>
                <a href="{{ route('experience-years') }}" id="experience"><i
                        class="fa fa-fw fa-hospital-o"></i> <span>{{$lang->eyt}}</span></a>
            </li>

            <li>
                <a href="{{ route('insurance') }}" id="insurance"><i
                        class="fa fa-fw fa-book"></i> <span>{{$lang->ist}}</span></a>
            </li>--}}


            @if(auth()->user()->can('ratings'))

                <li>
                    <a href="{{ route('ratings') }}" id="rating"><i class="fa fa-fw fa-book"></i> <span>{{$lang->hpmrt}}</span></a>
                </li>

            @endif


            @if(auth()->user()->can('instruction-manual'))

                <li>
                    <a href="{{ route('instruction-manual') }}" id="instruction"><i class="fa fa-fw fa-book"></i> <span>{{__('text.Instruction Manual')}}</span></a>
                </li>

            @endif

            <li class="lang-list" style="text-align: center;margin-top: 20px;">

                <form method="post" action="{{route('lang.handymanchange')}}" id="lang-form">
                    {{csrf_field()}}


                    <input type="hidden" class="lang_select" value="{{$lang->lang}}" name="lang_select">

                    <div class="btn-group bootstrap-select fit-width">

                        @if($lang->lang == 'eng')

                            <button type="button" class="btn dropdown-toggle selectpicker btn-default"
                                    data-toggle="dropdown" title="English" style="color: black !important;">

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
                                    style="color: black !important;">

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

        {{--<nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">

                <button type="button" id="sidebarCollapse1" class="btn btn-info">
                    <i class="fa fa-align-left"></i>
                </button>

            </div>
        </nav>--}}

        @yield('content')

    </div>
</div>


<script type="text/javascript">

    function formSubmit(e) {
        var value = $(e).data('value');

        $('.lang_select').val(value);

        $('#lang-form').submit();

    }

    var mouse_already_there = false;
    var event_set = false;
    $(document).ready(function() {

        $('#sidebar').hover(function () {

            $('#sidebar').removeClass('active');

        }, function(){
            $('#sidebar').addClass('active');
        });

    });

</script>


<style type="text/css">

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
    }

    #sidebar {
        min-width: 250px;
        max-width: 250px;
        background-color: {{$gs->colors == null ? 'rgba(204, 37, 42, 0.79)':$gs->colors.'c9'}};
        color: #fff;
        transition: all 1.5s;
    }

    #sidebar.active {
        min-width: 80px;
        max-width: 80px;
        text-align: center;
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

    #sidebar.active ul ul a {
        padding: 10px !important;
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
        padding: 20px 0;
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
        padding: 20px;
        min-height: 100vh;
        transition: all 0.3s;
        overflow-x: hidden;
    }

    /* ---------------------------------------------------
        MEDIAQUERIES
    ----------------------------------------------------- */

    @media (max-width: 768px) {
        #sidebar {
            min-width: 80px;
            max-width: 80px;
            text-align: center;
            margin-left: -80px !important;
        }
        #sidebar .dropdown-toggle::before {
            top: auto !important;
            bottom: 10px !important;
            right: 50% !important;
            -webkit-transform: translateX(50%) !important;
            -ms-transform: translateX(50%) !important;
            transform: translateX(50%) !important;
        }
        #sidebar.active {
            margin-left: 0 !important;
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
        #sidebar ul li a i {
            margin-right: 0;
            display: block;
        }
        #sidebar ul ul a {
            padding: 10px !important;
        }
        #sidebar ul li a i {
            font-size: 1.3em;
        }
        #sidebar {
            margin-left: 0;
        }
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
        margin-bottom: 0px !important;
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
        height: auto !important;
        background: transparent !important;
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

            margin-left: 0px;
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
