<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="keywords" content="{{$seo->meta_keys}}">
        <meta name="author" content="GeniusOcean">

        <title>{{$gs->title}}</title>
        <link href="{{public_path('assets/admin/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{public_path('assets/admin/css/font-awesome.min.css')}}" rel="stylesheet">
        <link href="{{public_path('assets/admin/css/perfect-scrollbar.min.css')}}" rel="stylesheet">
        <link href="{{public_path('assets/admin/css/bootstrap-colorpicker.css')}}" rel="stylesheet">
        <link href="{{public_path('assets/admin/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{public_path('assets/admin/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{public_path('assets/admin/css/style.css')}}" rel="stylesheet">
        <link href="{{public_path('assets/admin/css/responsive.css')}}" rel="stylesheet">
        <link rel="icon" type="image/png" href="{{public_path('assets/images/'.$gs->favicon)}}">
        @include('styles.admin-design')
        @yield('styles')


    </head>
    <body>
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
