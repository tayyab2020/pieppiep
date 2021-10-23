<!DOCTYPE html>
<html lang="en">
    <head>

        <link href="{{public_path('assets/admin/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{public_path('assets/admin/css/font-awesome.min.css')}}" rel="stylesheet">
        <link href="{{public_path('assets/admin/css/style.css')}}" rel="stylesheet">
        <link href="{{public_path('assets/admin/css/responsive.css')}}" rel="stylesheet">

    </head>
    <body>

    @include('styles.admin-design')
    @yield('styles')

    <div class="dashboard-wrapper">

        @yield('content')

    </div>

    <style type="text/css">



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

    </style>

    </body>
</html>
