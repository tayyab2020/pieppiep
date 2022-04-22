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
        <link href="{{ asset('assets/front/select2/select2.min.css') }}" rel="stylesheet">
        <link rel="icon" type="image/png" href="{{asset('assets/images/'.$gs->favicon)}}">
        @include('styles.admin-design')
        @yield('styles')
        <script src="{{asset('assets/admin/js/jquery.min.js')}}"></script>
        <!-- include summernote css/js -->
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

    </head>
    <body>
        <div class="dashboard-wrapper">
            <div class="left-side">
            <!-- Starting of Dashboard Sidebar menu area -->
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-right">
                            <button type="button" id="sidebarCollapse" class="navbar-btn">
                                <span></span>
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </nav>

                <div class="dashboard-sidebar-area">
                    <img src="{{asset('assets/images/'.$gs->bimg)}}" alt="">
                    <div class="sidebar-menu-body">
                        <nav style="width: 100%;" id="sidebar-menu">
                            <div class="sidebar-header">
                                <a href="{{route('front.index')}}" > <img src="{{asset('assets/images/'.$gs->logo)}}" alt="Sidebar header logo" class="sidebar-header-logo" style="height: 55px;width: 100%;"></a>
                            </div>
                            <ul class="list-unstyled profile">
                                <li class="active">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                            <img src="{{ Auth::guard('admin')->user()->photo ? asset('assets/images/'.Auth::guard('admin')->user()->photo):asset('assets/default.jpg')}}" alt="profile image">
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                            <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false">{{ Auth::guard('admin')->user()->name}} <span>{{ Auth::guard('admin')->user()->role}}</span></a>
                                        </div>
                                    </div>
                                        <ul class="collapse list-unstyled profile-submenu" id="homeSubmenu">
                                            <li><a href="{{ route('admin-profile') }}"><i class="fa fa-fw fa-user"></i> Edit Profile</a></li>
                                            <li><a href=" {{ route('admin-password-reset') }} "><i class="fa fa-fw fa-cog"></i> Change Password</a></li>
                                            <li><a href="{{ route('admin-logout') }}"><i class="fa fa-fw fa-power-off"></i> Logout</a></li>
                                        </ul>
                                </li>
                            </ul>
                            <ul class="list-unstyled components">

                                <li>
                                    <a href="{{route('admin-dashboard')}}"><i class="fa fa-home"></i> Dashboard</a>
                                </li>

                                <li>
                                    <a href="#leads" data-toggle="collapse" @if(Route::currentRouteName() == 'quotation-requests' || Route::currentRouteName() == 'handyman-quotations' || Route::currentRouteName() == 'handyman-quotations-invoices' || Route::currentRouteName() == 'handyman-commission-invoices' || Route::currentRouteName() == 'quotation-questions' || Route::currentRouteName() == 'admin-my-cat-index' || Route::currentRouteName() == 'admin-features' || Route::currentRouteName() == 'admin-service-index' || Route::currentRouteName() == 'admin-item-index') aria-expanded="true" @else aria-expanded="false" @endif><i class="fa fa-fw fa-file-code-o"></i> Leads for admin</a>
                                    <ul class="collapse list-unstyled submenu" id="leads">
                                        <li><a href="{{route('quotation-requests')}}"><i class="fa fa-angle-right"></i> Quotation Requests</a></li>
                                        <li><a href="{{route('handyman-quotations')}}"><i class="fa fa-angle-right"></i> Retailer Quotations</a></li>
                                        <li><a href="{{route('handyman-quotations-invoices')}}"><i class="fa fa-angle-right"></i> Quotation Invoices</a></li>
                                        <li><a href="{{route('handyman-commission-invoices')}}"><i class="fa fa-angle-right"></i> Commission Invoices</a></li>
                                        <li><a href="{{route('quotation-questions')}}"><i class="fa fa-angle-right"></i> Categories Quotation Questions</a></li>
                                        <li><a href="{{route('services-quotation-questions')}}"><i class="fa fa-angle-right"></i> Services Quotation Questions</a></li>
                                        <li><a href="{{route('admin-my-cat-index')}}"><i class="fa fa-angle-right"></i> Categories</a></li>
                                        <li><a href="{{route('admin-my-brand-index')}}"><i class="fa fa-angle-right"></i> Brands</a></li>
                                        <li><a href="{{route('default-features-index')}}"><i class="fa fa-angle-right"></i> Features</a></li>
                                        <li><a href="{{route('admin-service-index')}}"><i class="fa fa-angle-right"></i> Services</a></li>
                                        <li><a href="{{route('admin-item-index')}}"><i class="fa fa-angle-right"></i> Items</a></li>
                                    </ul>
                                </li>


                                <li>
                                    <a href="#profiles" data-toggle="collapse" @if(Route::currentRouteName() == 'admin-user-index' || Route::currentRouteName() == 'admin-user-client' || Route::currentRouteName() == 'admin-user-requests') aria-expanded="true" @else aria-expanded="false" @endif><i class="fa fa-fw fa-file-code-o"></i> Profiles</a>
                                    <ul class="collapse list-unstyled submenu" id="profiles">
                                        <li><a href="{{route('admin-user-index')}}"><i class="fa fa-angle-right"></i> Retailers</a></li>
                                        <li><a href="{{route('admin-supplier-index')}}"><i class="fa fa-angle-right"></i> Suppliers</a></li>
                                        <li><a href="{{route('admin-user-client')}}"><i class="fa fa-angle-right"></i> Clients</a></li>
                                        <li><a href="{{route('admin-user-requests')}}"><i class="fa fa-angle-right"></i> Update Requests</a></li>
                                    </ul>
                                </li>

                                {{--<li>
                                    <a href="{{route('admin-user-bookings')}}"><i class="fa fa-fw fa-user-md"></i> Bookings</a>
                                </li>--}}

                                <li><a href="{{route('admin-permissions-index')}}"><i class="fa fa-fw fa-file-code-o"></i> Permissions</a></li>

                                <li><a href="{{route('admin-assign-permissions')}}"><i class="fa fa-fw fa-file-code-o"></i> Assign Permissions</a></li>

                                {{--<li>
                                    <a href="#products" data-toggle="collapse" @if(Route::currentRouteName() == 'admin-product-index' || Route::currentRouteName() == 'admin-cat-index' || Route::currentRouteName() == 'admin-brand-index' || Route::currentRouteName() == 'admin-model-index' || Route::currentRouteName() == 'admin-item-index') aria-expanded="true" @else aria-expanded="false" @endif><i class="fa fa-fw fa-file-code-o"></i> Products</a>
                                    <ul class="collapse list-unstyled submenu" id="products">
                                        <li><a href="{{route('admin-product-index')}}"><i class="fa fa-angle-right"></i> Products</a></li>
                                        <li><a href="{{route('admin-color-index')}}"><i class="fa fa-angle-right"></i> Colors</a></li>
                                        <li><a href="{{route('admin-price-tables')}}"><i class="fa fa-angle-right"></i> Price Tables</a></li>
                                        <li><a href="{{route('admin-service-index')}}"><i class="fa fa-angle-right"></i> Services</a></li>
                                        <li><a href="{{route('admin-cat-index')}}"><i class="fa fa-angle-right"></i> Categories</a></li>
                                        <li><a href="{{route('admin-brand-index')}}"><i class="fa fa-angle-right"></i> Brands</a></li>
                                        <li><a href="{{route('admin-model-index')}}"><i class="fa fa-angle-right"></i> Models</a></li>
                                        <li><a href="{{route('admin-item-index')}}"><i class="fa fa-angle-right"></i> Items</a></li>
                                        <li><a href="{{route('admin-feature-index')}}"><i class="fa fa-angle-right"></i> Features</a></li>
                                    </ul>
                                </li>--}}


                                <li>
                                    <a href="#seoTools" data-toggle="collapse" aria-expanded="false"><i class="fa fa-fw fa-wrench"></i> SEO Tools</a>
                                    <ul class="collapse list-unstyled submenu" id="seoTools">
                                        <!-- <li><a href="{{route('admin-seotool-analytics')}}"><i class="fa fa-angle-right"></i> Google analytics</a></li> -->
                                        <li><a href="{{route('admin-seotool-keywords')}}"><i class="fa fa-angle-right"></i> Meta Keys</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="#pageSettings" data-toggle="collapse" aria-expanded="false"><i class="fa fa-fw fa-file-code-o"></i> Page Settings</a>
                                    <ul class="collapse list-unstyled submenu" id="pageSettings">
                                        <li><a href="{{route('admin-ps-about')}}"><i class="fa fa-angle-right"></i> About us page</a></li>
                                        <li><a href="{{route('admin-fq-index')}}"><i class="fa fa-angle-right"></i> FAQ page</a></li>
                                        <li><a href="{{route('admin-ps-contact')}}"><i class="fa fa-angle-right"></i> Contact us page</a></li>
                                        <li><a href="{{route('admin-adv-index')}}"><i class="fa fa-fw fa-link"></i> Advertisements</a></li>
                                        <li><a href="{{route('admin-ad-index')}}"><i class="fa fa-fw fa-file-image-o"></i> Testimonials</a></li>
                                        <li><a href="{{route('admin-blog-index')}}"><i class="fa fa-fw fa-file-text"></i> Blog Section</a></li>
                                        <li><a href="{{route('admin-how-it-works')}}"><i class="fa fa-fw fa-question"></i>  How It Works</a></li>
                                        <li><a href="{{route('admin-reasons-to-book')}}"><i class="fa fa-fw fa-language"></i>  Reasons To Book</a></li>
                                    </ul>
                                </li>


                                <li><a href="{{route('admin-social-index')}}"><i class="fa fa-fw fa-paper-plane"></i> Social settings</a></li>

                                <li>
                                    <a href="#themeSettings" data-toggle="collapse" aria-expanded="false"><i class="fa fa-fw fa-cogs"></i> Theme Settings</a>
                                    <ul class="collapse list-unstyled submenu" id="themeSettings">
                                        <li><a href="{{route('admin-gs-logo')}}"><i class="fa fa-angle-right"></i> Logo</a></li>
                                        <li><a href="{{route('admin-gs-fav')}}"><i class="fa fa-angle-right"></i> Favicon</a></li>
                                        <li><a href="{{route('admin-gs-load')}}"><i class="fa fa-angle-right"></i> Loader</a></li>
                                        <li><a href="{{route('admin-gs-contents')}}"><i class="fa fa-angle-right"></i> Website Contents</a></li>
                                        <li><a href="{{route('admin-gs-bginfo')}}"><i class="fa fa-angle-right"></i> Welcome Contents</a></li>
                                        <li><a href="{{route('admin-gs-bgimg')}}"><i class="fa fa-angle-right"></i> Background Image</a></li>
                                        <li><a href="{{route('admin-gs-footer')}}"><i class="fa fa-angle-right"></i> Footer</a></li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="#generalSettings" data-toggle="collapse" aria-expanded="false"><i class="fa fa-fw fa-cogs"></i> General Settings</a>
                                    <ul class="collapse list-unstyled submenu" id="generalSettings">

                                        <li><a href="{{route('admin-lang-index')}}"><i class="fa fa-fw fa-language"></i>  Language Settings</a></li>

                                        <li><a href="{{route('admin-filter-settings')}}"><i class="fa fa-fw fa-cogs"></i> Filter settings</a></li>

                                        <li><a href="{{route('admin-gs-payments')}}"><i class="fa fa-angle-right"></i> Payment Informations</a></li>

                                        <li><a href="{{route('admin-gs-vats')}}"><i class="fa fa-angle-right"></i> VAT Settings</a></li>

                                        <li><a href="{{route('admin-handyman-terms')}}"><i class="fa fa-angle-right"></i> Handyman Terms & Conditions</a></li>

                                        <li><a href="{{route('admin-client-terms')}}"><i class="fa fa-angle-right"></i> Client Terms & Conditions</a></li>

                                        <li><a href="{{route('admin-instruction-manual')}}"><i class="fa fa-angle-right"></i> Instruction Manual</a></li>

                                        <li><a href="{{route('admin-gs-about')}}"><i class="fa fa-angle-right"></i> About Us</a></li>
                                        <li><a href="{{route('admin-gs-address')}}"><i class="fa fa-angle-right"></i> Office Address</a></li>

                                    </ul>
                                </li>
                                <li><a href="{{route('admin-subs-index')}}"><i class="fa fa-fw fa-group"></i> Subscribers</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            <!-- Ending of Dashboard Sidebar menu area -->
            </div>
            @yield('content')
</div>



<style type="text/css">

    .nicEdit-main
    {
        outline: none;
    }


    button
    {
        outline: none !important;
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

    .nicEdit-button
    {
        background-image: url("<?php echo asset('assets/images/nicEditIcons-latest.gif'); ?>") !important;
    }

</style>


        <script src="{{ asset('assets/front/select2/select2.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.css" rel="stylesheet">
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
