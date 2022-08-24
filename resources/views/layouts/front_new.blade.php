<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="keywords" content="@yield('head_keywords')" />
    <meta name="title" content="@yield('head_title')">
    <meta name="description" content="@yield('head_description')">
    <meta name="author" content="GeniusOcean">
    <title>{{$gs->title}}</title>
    <link href="{{asset('assets/images/'.$gs->favicon)}}" type="image/png" rel="icon"/>
    <script src="{{ asset('assets/front/js/jquery.min.js') }}"></script>

    @if($lang->lang == 'eng')

        <script src="https://www.google.com/recaptcha/api.js?hl=eng" async defer></script>

    @else

        <script src="https://www.google.com/recaptcha/api.js?hl=nl" async defer></script>

    @endif

</head>

<body class="frontend exact-ac">

<style>

    .mainmenu
    {
        text-align: left !important;
        display: block !important;
        background-color: white !important;
    }

    .sp-page-builder .page-content #header {
        padding-top: 125px;
        padding-right: 0px;
        padding-bottom: 50px;
        padding-left: 0px;
        margin-top: 0px;
        margin-right: 0px;
        margin-bottom: 0px;
        margin-left: 0px;
        background-image: url(/images/pieppiep/headers/header-homepage_.jpg);
        background-repeat: no-repeat;
        background-size: cover;
        background-attachment: inherit;
        background-position: 100% 0;
    }

    @media (min-width: 768px) and (max-width: 991px) {
        .sp-page-builder .page-content #header {
            padding-top: 100px;
            padding-right: 30px;
            padding-bottom: 30px;
            padding-left: 30px;
        }
    }

    @media (max-width: 767px) {
        .sp-page-builder .page-content #header {
            padding-top: 100px;
            padding-right: 0;
            padding-bottom: 30px;
            padding-left: 0;
        }
    }

    #column-id-1623675747033 {
        box-shadow: 0 0 0 0 #fff;
    }

    #sppb-addon-wrapper-1623675747036 {
        margin: 0px 0px 30px 0px;
    }

    #sppb-addon-1623675747036 {
        box-shadow: 0 0 0 0 #ffffff;
    }

    @media (min-width: 768px) and (max-width: 991px) {
        #sppb-addon-wrapper-1623675747036 {
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 30px;
            margin-left: 0px;
        }
    }

    @media (max-width: 767px) {
        #sppb-addon-wrapper-1623675747036 {
            margin-top: 0px;
            margin-right: 0px;
            margin-bottom: 30px;
            margin-left: 0px;
        }
    }

    #sppb-addon-1623675747036 .sppb-addon-title {
        font-weight: 600;
        margin-bottom: 30px;
    }

    #sppb-addon-wrapper-1623675747037 {
        margin: 0 0 30px 0;
    }

    #sppb-addon-1623675747037 {
        box-shadow: 0 0 0 0 #ffffff;
    }

    @media (min-width: 768px) and (max-width: 991px) {
        #sppb-addon-wrapper-1623675747037 {
            margin-top: 0;
            margin-right: 0;
            margin-bottom: 20px;
            margin-left: 0;
        }
    }

    @media (max-width: 767px) {
        #sppb-addon-wrapper-1623675747037 {
            margin-top: 0;
            margin-right: 0;
            margin-bottom: 10px;
            margin-left: 0;
        }
    }

    #sppb-addon-1623675747037 .sppb-addon-content {
        margin: 0 -10px;
    }

    #sppb-addon-1623675747037 .sppb-addon-content .btn {
        margin: 10px;
    }

    .sp-page-builder .page-content #section-id-1623738603432 {
        padding-top: 60px;
        padding-right: 0px;
        padding-bottom: 60px;
        padding-left: 0px;
        margin-top: 0;
        margin-right: 0;
        margin-bottom: 0;
        margin-left: 0;
        box-shadow: 0 0 0 0 #ffffff;
    }

    @media (min-width: 768px) and (max-width: 991px) {
        .sp-page-builder .page-content #section-id-1623738603432 {
            padding-top: 45px;
            padding-right: 0px;
            padding-bottom: 45px;
            padding-left: 0px;
        }
    }

    @media (max-width: 767px) {
        .sp-page-builder .page-content #section-id-1623738603432 {
            padding-top: 45px;
            padding-right: 0;
            padding-bottom: 45px;
            padding-left: 0;
        }
    }

    #column-id-1623738603429 {
        padding-top: 0px;
        padding-right: 60px;
        padding-bottom: 0px;
        padding-left: 60px;
        box-shadow: 0 0 0 0 #fff;
    }

    @media (max-width: 767px) {
        #column-id-1623738603429 {
            padding-top: 0px;
            padding-right: 0px;
            padding-bottom: 0px;
            padding-left: 0px;
        }
    }

    #sppb-addon-wrapper-1623738603435 {
        margin: 0 0 0 0;
    }

    #sppb-addon-1623738603435 {
        box-shadow: 0 0 0 0 #ffffff;
    }

    .sp-page-builder .page-content #section-id-1623738603409 {
        margin-top: 0px;
        margin-right: 0px;
        margin-bottom: 0px;
        margin-left: 0px;
        box-shadow: 0 0 0 0 #ffffff;
    }

    #column-id-1623738603408 {
        box-shadow: 0 0 0 0 #fff;
    }

    .sp-page-builder .page-content #section-id-1623746996019 {
        padding-top: 30px;
        padding-right: 0px;
        padding-bottom: 45px;
        padding-left: 0px;
        margin-top: 0px;
        margin-right: 0px;
        margin-bottom: 0px;
        margin-left: 0px;
        box-shadow: 0 0 0 0 #ffffff;
    }

    #column-id-1623746996020 {
        box-shadow: 0 0 0 0 #fff;
    }

    @media (max-width: 767px) {
        #column-id-1623746996020 {
            padding-top: 0px;
            padding-right: 0px;
            padding-bottom: 15px;
            padding-left: 0px;
        }
    }

    #sppb-addon-wrapper-1623746996011 {
        margin: 30px 0 0 0;
    }

    #sppb-addon-1623746996011 {
        box-shadow: 0 0 0 0 #ffffff;
    }

    @media (min-width: 768px) and (max-width: 991px) {
        #sppb-addon-wrapper-1623746996011 {
            margin-top: 0;
            margin-right: 0;
            margin-bottom: 0;
            margin-left: 0;
        }
    }

    @media (max-width: 767px) {
        #sppb-addon-1623746996011 {
            padding-top: 30px;
            padding-right: 0px;
            padding-bottom: 0px;
            padding-left: 0px;
        }

        #sppb-addon-wrapper-1623746996011 {
            margin-top: 0;
            margin-right: 0;
            margin-bottom: 0;
            margin-left: 0;
        }
    }

    #column-id-1623746996023 {
        padding-top: 45px;
        padding-right: 45px;
        padding-bottom: 45px;
        padding-left: 45px;
    }

    @media (min-width: 768px) and (max-width: 991px) {
        #column-id-1623746996023 {
            padding-top: 30px;
            padding-right: 30px;
            padding-bottom: 30px;
            padding-left: 30px;
        }
    }

    @media (max-width: 767px) {
        #column-id-1623746996023 {
            padding-top: 30px;
            padding-right: 0px;
            padding-bottom: 30px;
            padding-left: 0px;
        }
    }

    #sppb-addon-wrapper-1623828553884 {
        margin: 0px 0px 30px 0px;
    }

    #sppb-addon-1623828553884 {
        box-shadow: 0 0 0 0 #ffffff;
    }

    #sppb-addon-wrapper-1623746995951 {
        margin: 0px 0px 30px 0px;
    }

    #sppb-addon-1623746995951 {
        box-shadow: 0 0 0 0 #ffffff;
    }

    #sppb-addon-wrapper-1623828553887 {
        margin: 0px 0px 0 0px;
    }

    #sppb-addon-1623828553887 {
        box-shadow: 0 0 0 0 #ffffff;
    }

    #sppb-addon-wrapper-1623828553890 {
        margin: 30px 0 0 0;
    }

    #sppb-addon-1623828553890 {
        box-shadow: 0 0 0 0 #ffffff;
        padding: 0 0 0 0;
    }

    @media (min-width: 768px) and (max-width: 991px) {
        #sppb-addon-wrapper-1623828553890 {
            margin-top: 0;
            margin-right: 0;
            margin-bottom: 20px;
            margin-left: 0;
        }
    }

    @media (max-width: 767px) {
        #sppb-addon-wrapper-1623828553890 {
            margin-top: 0;
            margin-right: 0;
            margin-bottom: 10px;
            margin-left: 0;
        }
    }

    #sppb-addon-1623828553890 .sppb-addon-content {
        margin: 0 -10px;
    }

    #sppb-addon-1623828553890 .sppb-addon-content .btn {
        margin: 10px;
    }

    .sp-page-builder .page-content #section-id-1623828553997 {
        padding-top: 30px;
        padding-right: 0px;
        padding-bottom: 90px;
        padding-left: 0px;
        margin-top: 0px;
        margin-right: 0px;
        margin-bottom: 0px;
        margin-left: 0px;
        box-shadow: 0 0 0 0 #ffffff;
    }

    @media (max-width: 767px) {
        .sp-page-builder .page-content #section-id-1623828553997 {
            padding-top: 30px;
            padding-right: 0px;
            padding-bottom: 30px;
            padding-left: 0px;
        }
    }

    #column-id-1623828553996 {
        box-shadow: 0 0 0 0 #fff;
    }

    #column-id-1623828553995 {
        box-shadow: 0 0 0 0 #fff;
    }

    @media (min-width: 768px) and (max-width: 991px) {
        #column-id-1623828553995 {
            padding-top: 0px;
            padding-right: 30px;
            padding-bottom: 0px;
            padding-left: 30px;
        }
    }

    @media (max-width: 767px) {
        #column-id-1623828553995 {
            padding-top: 0px;
            padding-right: 0px;
            padding-bottom: 0px;
            padding-left: 0px;
        }
    }

    .sp-page-builder .page-content #section-id-1623828553998 {
        padding-top: 0;
        padding-right: 0;
        padding-bottom: 0;
        padding-left: 0;
        margin-top: 0px;
        margin-right: 0px;
        margin-bottom: 0px;
        margin-left: 0px;
        box-shadow: 0 0 0 0 #ffffff;
    }

    #column-id-1623828553999 {
        padding-bottom: 30px;
        box-shadow: 0 0 0 0 #fff;
    }

    #sppb-addon-wrapper-1623828553910 {
        margin: 0 0 0 0;
    }

    #sppb-addon-1623828553910 {
        box-shadow: 0 0 0 0 #ffffff;
    }

    @media (max-width: 767px) {
        #column-id-1623828554002 {
            padding-top: 15px;
            padding-right: 15px;
            padding-bottom: 15px;
            padding-left: 15px;
        }
    }

    #sppb-addon-wrapper-1623828553915 {
        margin: 0px 0px 0 0px;
    }

    #sppb-addon-1623828553915 {
        box-shadow: 0 0 0 0 #ffffff;
    }

    @media (max-width: 767px) {
        #column-id-1623828554003 {
            padding-top: 15px;
            padding-right: 15px;
            padding-bottom: 15px;
            padding-left: 15px;
        }
    }

    #sppb-addon-wrapper-1623828553917 {
        margin: 0px 0px 0 0px;
    }

    #sppb-addon-1623828553917 {
        box-shadow: 0 0 0 0 #ffffff;
    }

    @media (max-width: 767px) {
        #column-id-1623828554004 {
            padding-top: 15px;
            padding-right: 15px;
            padding-bottom: 15px;
            padding-left: 15px;
        }
    }

    #sppb-addon-wrapper-1623828553913 {
        margin: 0px 0px 0 0px;
    }

    #sppb-addon-1623828553913 {
        box-shadow: 0 0 0 0 #ffffff;
    }

    .sp-page-builder .page-content #section-id-1623746996055 {
        padding-top: 60px;
        padding-right: 0px;
        padding-bottom: 60px;
        padding-left: 0px;
        margin-top: 0px;
        margin-right: 0px;
        margin-bottom: 0px;
        margin-left: 0px;
        box-shadow: 0 0 0 0 #ffffff;
    }

    #sppb-addon-wrapper-1623746996071 {
        margin: 0px 0px 30px 0px;
    }

    #sppb-addon-1623746996071 {
        box-shadow: 0 0 0 0 #ffffff;
    }

    #column-id-1623746996056 {
        box-shadow: 0 0 0 0 #fff;
    }

    .sp-page-builder .page-content #section-id-1623996709062 {
        padding-top: 0;
        padding-right: 0;
        padding-bottom: 0;
        padding-left: 0;
        margin-top: 0px;
        margin-right: 0px;
        margin-bottom: 0px;
        margin-left: 0px;
        box-shadow: 0 0 0 0 #ffffff;
    }

    @media (max-width: 767px) {
        .sp-page-builder .page-content #section-id-1623996709062 {
            padding-top: 0px;
            padding-right: 0px;
            padding-bottom: 0px;
            padding-left: 0px;
            margin-top: 0;
            margin-right: 0;
            margin-bottom: 30px;
            margin-left: 0;
        }
    }

    #column-id-1623996709063 {
        box-shadow: 0 0 0 0 #fff;
    }

    #sppb-addon-wrapper-1623746996082 {
        margin: 0px 0px 30px 0px;
    }

    #sppb-addon-1623746996082 {
        box-shadow: 0 0 0 0 #ffffff;
    }

    #sppb-addon-wrapper-1623746996058 {
        margin: 0px 0px 30px 0px;
    }

    #sppb-addon-1623746996058 {
        box-shadow: 0 0 0 0 #ffffff;
    }

    #sppb-addon-wrapper-1626267733560 {
        margin: 0px 0px 30px 0px;
    }

    #sppb-addon-1626267733560 {
        box-shadow: 0 0 0 0 #ffffff;
    }

    #sppb-addon-1626267733560 .sppb-addon-content {
        margin: 0 -5px;
    }

    #sppb-addon-1626267733560 .sppb-addon-content .btn {
        margin: 5px;
    }

    #column-id-1623746996059 {
        box-shadow: 0 0 0 0 #fff;
    }

    .sp-page-builder .page-content #section-id-1623996709075 {
        padding-top: 0;
        padding-right: 0;
        padding-bottom: 0;
        padding-left: 0;
        margin-top: 0px;
        margin-right: 0px;
        margin-bottom: 0px;
        margin-left: 0px;
        box-shadow: 0 0 0 0 #ffffff;
    }

    @media (max-width: 767px) {
        .sp-page-builder .page-content #section-id-1623996709075 {
            padding-top: 0px;
            padding-right: 0px;
            padding-bottom: 0px;
            padding-left: 0px;
            margin-top: 0;
            margin-right: 0;
            margin-bottom: 30px;
            margin-left: 0;
        }
    }

    #column-id-1623996709076 {
        box-shadow: 0 0 0 0 #fff;
    }

    #sppb-addon-wrapper-1623746996097 {
        margin: 0px 0px 30px 0px;
    }

    #sppb-addon-1623746996097 {
        box-shadow: 0 0 0 0 #ffffff;
    }

    #sppb-addon-wrapper-1623746996100 {
        margin: 0px 0px 30px 0px;
    }

    #sppb-addon-1623746996100 {
        box-shadow: 0 0 0 0 #ffffff;
    }

    #sppb-addon-wrapper-1626267733547 {
        margin: 0px 0px 30px 0px;
    }

    #sppb-addon-1626267733547 {
        box-shadow: 0 0 0 0 #ffffff;
    }

    #sppb-addon-1626267733547 .sppb-addon-content {
        margin: 0 -5px;
    }

    #sppb-addon-1626267733547 .sppb-addon-content .btn {
        margin: 5px;
    }

    #column-id-1623746996062 {
        box-shadow: 0 0 0 0 #fff;
    }

    .sp-page-builder .page-content #section-id-1623996709082 {
        padding-top: 0;
        padding-right: 0;
        padding-bottom: 0;
        padding-left: 0;
        margin-top: 0px;
        margin-right: 0px;
        margin-bottom: 0px;
        margin-left: 0px;
        box-shadow: 0 0 0 0 #ffffff;
    }

    @media (max-width: 767px) {
        .sp-page-builder .page-content #section-id-1623996709082 {
            padding-top: 0px;
            padding-right: 0px;
            padding-bottom: 0px;
            padding-left: 0px;
        }
    }

    #column-id-1623996709083 {
        box-shadow: 0 0 0 0 #fff;
    }

    #sppb-addon-wrapper-1623746996103 {
        margin: 0px 0px 30px 0px;
    }

    #sppb-addon-1623746996103 {
        box-shadow: 0 0 0 0 #ffffff;
    }

    #sppb-addon-wrapper-1623746996106 {
        margin: 0px 0px 30px 0px;
    }

    #sppb-addon-1623746996106 {
        box-shadow: 0 0 0 0 #ffffff;
    }

    #sppb-addon-wrapper-1626267733542 {
        margin: 0px 0px 30px 0px;
    }

    #sppb-addon-1626267733542 {
        box-shadow: 0 0 0 0 #ffffff;
    }

    #sppb-addon-1626267733542 .sppb-addon-content {
        margin: 0 -5px;
    }

    #sppb-addon-1626267733542 .sppb-addon-content .btn {
        margin: 5px;
    }

    .sp-page-builder .page-content #section-id-1623746996115 {
        padding-top: 30px;
        padding-right: 0px;
        padding-bottom: 60px;
        padding-left: 0px;
        margin-top: 0px;
        margin-right: 0px;
        margin-bottom: 0px;
        margin-left: 0px;
        box-shadow: 0 0 0 0 #ffffff;
    }

    @media (max-width: 767px) {
        .sp-page-builder .page-content #section-id-1623746996115 {
            padding-top: 30px;
            padding-right: 0px;
            padding-bottom: 30px;
            padding-left: 0px;
        }
    }

    #column-id-1623746996116 {
        box-shadow: 0 0 0 0 #fff;
    }

    #column-id-1623746996117 {
        padding-top: 45px;
        padding-right: 45px;
        padding-bottom: 45px;
        padding-left: 45px;
        box-shadow: 0 0 0 0 #fff;
    }

    #sppb-addon-wrapper-1623746996118 {
        margin: 0 0 0 0;
    }

    #sppb-addon-1623746996118 {
        box-shadow: 0 0 0 0 #ffffff;
    }

    #sppb-addon-wrapper-1623746996126 {
        margin: 0 0 0 0;
    }

    #sppb-addon-1623746996126 {
        box-shadow: 0 0 0 0 #ffffff;
    }

    @media (min-width: 768px) and (max-width: 991px) {
        #sppb-addon-wrapper-1623746996126 {
            margin-top: 0;
            margin-right: 0;
            margin-bottom: 20px;
            margin-left: 0;
        }
    }

    @media (max-width: 767px) {
        #sppb-addon-wrapper-1623746996126 {
            margin-top: 0;
            margin-right: 0;
            margin-bottom: 10px;
            margin-left: 0;
        }
    }

    #sppb-addon-1623746996126 .sppb-addon-content {
        margin: 0 -10px;
    }

    #sppb-addon-1623746996126 .sppb-addon-content .btn {
        margin: 10px;
    }

    #column-id-1623746996119 {
        box-shadow: 0 0 0 0 #fff;
    }
</style>


<style>
    body {
        font-family: Arial, sans-serif;
        font-weight: 400;
        line-height: 1.5em;
        font-size: 16px;
        color: #787a7a;
        -webkit-font-smoothing: antialiased;
        margin: 0;
        padding: 0
    }

    * {
        box-sizing: border-box
    }

    .h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
        color: #333;
        line-height: 1.2em;
        font-family: Apax, Arial, sans-serif;
        font-weight: 400;
        margin-top: 0
    }

    h1 {
        font-weight: 600;
        margin-bottom: 30px
    }

    h2, h3, h4, h5, h6 {
        margin-bottom: 20px
    }

    p {
        margin-top: 0;
        margin-bottom: 1rem
    }

    a {
        text-decoration: none
    }

    .float-left {
        float: left
    }

    .float-right {
        float: right
    }

    .fixed-top {
        position: fixed;
        top: 0;
        right: 0;
        left: 0;
        z-index: 1030
    }

    .img-responsive {
        max-width: 100%
    }

    .container {
        margin: 0 auto;
        max-width: 1140px;
        padding: 0 15px
    }

    .row {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px
    }

    .mainmenu .navbar-collapse, .navbar-brand {
        display: inline-block;
        vertical-align: top
    }

    .navbar > .container {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        -ms-flex-align: center;
        align-items: center;
        -ms-flex-pack: justify;
        justify-content: space-between
    }

    .navbar-collapse {
        flex-grow: 1
    }

    .navbar-brand {
        margin-right: 1rem;
        padding-top: .3125rem;
        padding-bottom: .3125rem
    }

    @media (min-width: 768px)
    {
        .navbar-brand img {
            width: 200px !important;
        }
    }

    .mainmenu ul {
        margin: 0;
        padding: 0
    }

    .mainmenu .navbar-collapse > ul.menu > li {
        display: inline-block;
        vertical-align: top;
        margin: 15px 0
    }

    .mainmenu .navbar-collapse > ul.menu > li > a {
        display: block;
        padding: 15px 20px;
        color: #333
    }

    .mainmenu .dropdown-menu {
        display: none
    }

    .mainmenu ul.menu > li > a.btn-blue {
        background-color: #0650d0;
        color: #fff;
        border-radius: 2px
    }

    .btn {
        display: inline-block;
        font-weight: 400;
        text-align: center;
        vertical-align: middle;
        line-height: 1.5
    }

    .btn.btn-sm {
        padding: 10px 20px
    }

    .link-blue {
        color: #0650d0;
        padding: 0
    }

    .btn, .link-blue {
        font-weight: 600;
        padding: 20px 25px;
        border-radius: 2px
    }

    .btn-blue {
        background: #0650d0;
        color: #fff
    }

    .text-center {
        text-align: center
    }

    .header .btn.link-blue {
        padding: 0
    }

    .bg-mustard-20 {
        background: #f9f2dc
    }

    .bg-navy-20 {
        background: #e6ecf1
    }

    .bg-beige-20 {
        background: #f8f5f3
    }

    .nav-sub .btn {
        padding: 10px
    }

    .article-header .category {
        margin: 0 0 10px;
        font-size: 18px;
        font-weight: 600
    }

    .header-navy .header {
        background-color: #e6ecf1
    }

    @media (min-width: 768px) {
        body.country .mainmenu {
            top: 80px
        }

        .country-selector-bar {
            padding: 15px;
            min-height: 73px;
            display: block;
            position: relative
        }

        .country-selector-bar p {
            font-size: 12px;
            margin: 0;
            line-height: 1.8em
        }

        .mod-searchbar.hide {
            display: none
        }

        .mainmenu .navbar-collapse > ul.menu > li > a.menu-right.toggle-search {
            font-size: 0
        }

        .nav-sub .sppb-addon-title {
            margin: 0
        }

        .col-lg-10, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-md-10, .col-md-5, .col-md-6, .col-md-7, .col-md-8 {
            padding-left: 15px;
            padding-right: 15px
        }

        .col-md-6 {
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
            max-width: 50%
        }

        .col-md-5 {
            -ms-flex: 0 0 41.666667%;
            flex: 0 0 41.666667%;
            max-width: 41.666667%
        }

        .col-md-7 {
            -ms-flex: 0 0 58.333333%;
            flex: 0 0 58.333333%;
            max-width: 58.333333%
        }

        .col-md-8 {
            -ms-flex: 0 0 66.666667%;
            flex: 0 0 66.666667%;
            max-width: 66.666667%
        }

        .col-md-10 {
            -ms-flex: 0 0 83.333333%;
            flex: 0 0 83.333333%;
            max-width: 83.333333%
        }

        #preferences {
            padding: 0
        }
    }

    @media (min-width: 992px) {
        .h1, h1 {
            font-size: 48px
        }

        .h2, h2 {
            font-size: 36px
        }

        .h3, h3 {
            font-size: 24px
        }

        .navbar-expand-lg .navbar-toggler {
            display: none
        }

        .navbar-expand-lg > .container {
            -ms-flex-wrap: nowrap;
            flex-wrap: nowrap
        }

        .col-lg-6 {
            -ms-flex: 0 0 50%;
            flex: 0 0 50%;
            max-width: 50%
        }

        .col-lg-5 {
            -ms-flex: 0 0 41.666667%;
            flex: 0 0 41.666667%;
            max-width: 41.666667%
        }

        .col-lg-7 {
            -ms-flex: 0 0 58.333333%;
            flex: 0 0 58.333333%;
            max-width: 58.333333%
        }

        .col-lg-8 {
            -ms-flex: 0 0 66.666667%;
            flex: 0 0 66.666667%;
            max-width: 66.666667%
        }

        .col-lg-10 {
            -ms-flex: 0 0 83.333333%;
            flex: 0 0 83.333333%;
            max-width: 83.333333%
        }

        .offset-md-1 {
            margin-left: 8.333333%
        }

        .offset-lg-2 {
            margin-left: 16.666667%
        }

        .stormdigital-cookieWall-header {
            min-height: 230px
        }

        .toggle-search-mobile {
            display: none
        }

        .header-image img {
            position: absolute;
            bottom: 0;
            left: 0;
            max-width: calc((100vw / 3) + 120px)
        }

        .bbs-left img {
            width: 100%
        }

        .bbs-left {
            position: relative;
            margin: 0 -30px 0 0
        }

        .sppb-modal-selector {
            height: 100%;
            display: block;
            position: relative;
            text-align: center
        }

        .modal-trigger .overlay-icon {
            position: absolute
        }

        .article-header {
            padding: 120px 0 100px
        }

        .article-header.small-header {
            padding: 120px 0 0
        }

        .blog .article-header-image img {
            margin-top: -100px;
            width: 100%
        }

        .blog .article-info {
            margin: 20px 0 40px
        }

        .blog-article #sp-page-builder .page-content > section.sppb-section {
            padding: 0 0 30px
        }

        .blog-article #sp-page-builder {
            margin: 0 -15px
        }

        .blog-article .news-feed {
            margin-top: 50px
        }

        .article-extra-info {
            padding-bottom: 50px
        }

        .blog-article .share-icons {
            margin-bottom: 40px
        }

        .blog-article .share-icons a {
            height: 40px;
            width: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px
        }
    }

    .nav-sub .sppb-addon-button-group {
        float: right
    }

    .nav-sub .sppb-addon-button-group.nav-phone {
        float: none
    }

    .nav-sub .btn.link-blue {
        color: #333;
        font-weight: 400
    }

    .sp-page-builder .header {
        position: relative
    }

    .nav-sub .sppb-addon-title a {
        color: inherit
    }

    .nav-phone .btn {
        font-size: 12px;
        letter-spacing: .5px;
        background: #e6ecf1;
        color: inherit;
        padding: 3px 10px 0;
        line-height: 1.8em;
        margin: 5px 5px 0
    }

    .header-image .sppb-column-addons > div {
        position: absolute;
        left: calc(100% / 3 * 2);
        width: calc(100% / 3);
        top: 0;
        height: 100%
    }

    .container .container {
        padding: 0
    }

    .blog-article .container .container {
        padding: 0 15px
    }

    .country-selector-bar .col-dropdown {
        display: none
    }

    @media (max-width: 767px) {
        body {
            font-size: 14px;
            overflow-x: hidden
        }

        .container {
            padding: 0 30px
        }

        .row > div {
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
            max-width: 100%;
            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            position: relative
        }

        body.country .mainmenu {
            top: 0
        }

        .mainmenu {
            background-color: #fff;
            padding: 0 15px 0 30px
        }

        .mainmenu .navbar-collapse {
            position: absolute;
            top: 54px;
            right: -100%;
            width: 100%;
            padding: 0
        }

        .mainmenu ul.menu > li > a {
            padding: 7px 15px
        }

        .navbar-brand {
            margin: 15px 0
        }

        .navbar-brand img {
            width: 90px
        }

        .navbar-toggler {
            display: none
        }

        .navbar-expand-lg > .container, .navbar-expand-lg > .container-fluid {
            padding-left: 0
        }

        .toggle-search-mobile {
            position: fixed;
            top: 20px;
            right: 70px;
            z-index: 501;
            font-size: 20px;
            width: 25px;
            height: 20px;
            display: block
        }

        .toggle-search-mobile .fa-search {
            font-size: 0
        }

        .toggle-search-mobile .fa-search:before {
            font-size: 20px
        }

        .h1, h1 {
            font-size: 28px;
            margin-bottom: 20px
        }

        .btn {
            padding: 15px 20px;
            font-size: 100%
        }

        .mod-searchbar {
            display: none
        }

        .mod-searchbar.show {
            display: block
        }

        .blog-article .container .container {
            padding: 0 30px
        }

        .hidden-xs {
            display: none
        }

        .sppb-section {
            position: relative
        }

        body .sp-page-builder .page-content #header {
            padding-top: 80px
        }

        .stormdigital-cookieWall-header {
            min-height: 250px
        }

        #disclaimer_mobile {
            min-height: 115px
        }

        .nav-sub .sppb-addon-button-group, .nav-sub .sppb-addon-title {
            text-align: center;
            line-height: 30px !important;
            font-size: 18px !important;
            margin-bottom: 15px;
            float: none
        }

        .nav-sub .sppb-addon-title {
            margin-bottom: 15px
        }

        .nav-sub .btn {
            margin: 0 !important;
            padding: 10px 5px;
            font-size: 14px
        }

        .nav-sub .sppb-addon-button-group .nav .btn-blue {
            display: block;
            visibility: hidden;
            opacity: 0;
            max-height: 0;
            padding: 0 !important
        }

        .article-header {
            padding: 90px 0 10px
        }

        .article-header .category a {
            font-size: 14px
        }

        .article-header-image {
            margin: 0 -30px;
            min-height: 160px
        }

        .blog .article-header-image img {
            width: 100%
        }

        .blog-article #sp-page-builder {
            margin: 0 -30px
        }

        .blog-article #sp-page-builder .page-content > section.sppb-section {
            padding: 0 0 15px
        }

        .blog .article-info {
            margin: 20px 0
        }

        .article-header h1 {
            font-size: 20px
        }

        .blog .article-info .info-item {
            display: inline-block
        }
    }
</style>

<div class="mod-sppagebuilder mod-searchbar hide sp-page-builder" data-module_id="403">
    <div class="page-content">
        <div id="section-id-1598447628638" class="sppb-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2" id="column-wrap-id-1598447628635">
                        <div id="column-id-1598447628635" class="sppb-column">
                            <div class="sppb-column-addons"></div>
                        </div>
                    </div>
                    <div class="col-lg-8" id="column-wrap-id-1598447628636">
                        <div id="column-id-1598447628636" class="sppb-column">
                            <div class="sppb-column-addons">
                                <div id="sppb-addon-wrapper-1598447628641" class="sppb-addon-wrapper">
                                    <div id="sppb-addon-1598447628641" class="clearfix ">
                                        <div class="addon-searchbar">
                                            <form method="get" class="m-bottom-20 m-top-10" id="search"
                                                  action="/nl/zoeken">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text" data-search><span
                                                                class="fas fa-search"></span></div>
                                                    </div>
                                                    <input id="searchInput" type="text" name="search"
                                                           placeholder="Vul je zoekterm in" class="wide form-control"
                                                           value=""/>
                                                    <a href="#search"
                                                       class="toggle-search no-scroll hidden-md hidden-lg"><span
                                                            class="fas fa-times"></span></a>
                                                </div>
                                            </form>
                                            <div class="results-wrapper">
                                                <ul id="results"></ul>
                                            </div>
                                        </div>

                                        <style type="text/css">#sppb-addon-wrapper-1598447628641 {
                                                margin: 0px 0px 0px 0px;
                                            }

                                            #sppb-addon-1598447628641 {
                                                box-shadow: 0 0 0 0 #ffffff;
                                            }

                                            #sppb-addon-1598447628641 {
                                            }

                                            #sppb-addon-1598447628641.sppb-element-loaded {
                                            }

                                            @media (min-width: 768px) and (max-width: 991px) {
                                                #sppb-addon-1598447628641 {
                                                }
                                            }

                                            @media (max-width: 767px) {
                                                #sppb-addon-1598447628641 {
                                                }
                                            }</style>
                                        <style type="text/css">.mod-searchbar {
                                                position: fixed;
                                                top: 0;
                                                left: 0;
                                                width: 100vw;
                                                z-index: 999;
                                                top: 74px;
                                            }

                                            .addon-searchbar {
                                                background-color: #FFF;
                                                padding: 20px;
                                                box-shadow: 0 15px 15px rgba(69, 99, 121, 0.15);
                                            }

                                            .addon-searchbar ul#results {
                                                margin: 0;
                                                max-height: calc(100vh - 180px);
                                                overflow: auto;
                                            }

                                            .addon-searchbar ul#results li.result {
                                                padding: 0;
                                            }

                                            .addon-searchbar ul#results li.result:before {
                                                display: none;
                                            }

                                            .addon-searchbar ul#results li p {
                                                margin: 10px 0;
                                            }

                                            .addon-searchbar ul#results li.result a {
                                                display: block;
                                                padding: 20px 0 10px;
                                                border-bottom: 1px solid #cbd8e2;
                                            }

                                            .addon-searchbar ul#results li.result-all a {
                                                border-bottom: none;
                                                padding: 20px 0 0;
                                                margin: 0 0 -20px;
                                            }

                                            .addon-searchbar .h5 p {
                                                color: #6d6f6f;
                                                font-family: "arial", sans-serif;
                                                font-size: 16px;
                                                line-height: 1.5em;
                                                margin: 10px 0;
                                            }

                                            .results-wrapper {
                                                position: relative;
                                            }

                                            .addon-searchbar .input-group-text:hover {
                                                cursor: pointer;
                                            }

                                            @media (max-width: 992px) {
                                                .mod-searchbar {
                                                    top: 61px
                                                }

                                                .addon-searchbar .toggle-search {
                                                    padding: 10px 15px;
                                                    margin-right: 0px;
                                                    font-size: 20px;
                                                    color: #a5a9a9;
                                                }
                                            }

                                            @media (max-width: 768px) {
                                                .mod-searchbar {
                                                    top: 61px
                                                }

                                                .addon-searchbar {
                                                    margin: 0 -30px;
                                                }

                                                .addon-searchbar .h5 p {
                                                    font-size: 14px;
                                                }

                                                .addon-searchbar .toggle-search {
                                                    margin-right: -15px;
                                                }
                                            }</style>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2" id="column-wrap-id-1598447628637">
                        <div id="column-id-1598447628637" class="sppb-column">
                            <div class="sppb-column-addons"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style type="text/css">.sp-page-builder .page-content #section-id-1598447628638 {
                padding-top: 0px;
                padding-right: 0px;
                padding-bottom: 0px;
                padding-left: 0px;
                margin-top: 0px;
                margin-right: 0px;
                margin-bottom: 0px;
                margin-left: 0px;
                box-shadow: 0 0 0 0 #ffffff;
            }

            #column-id-1598447628635 {
                box-shadow: 0 0 0 0 #fff;
            }

            #column-id-1598447628636 {
                box-shadow: 0 0 0 0 #fff;
            }

            #column-id-1598447628637 {
                box-shadow: 0 0 0 0 #fff;
            }</style>
    </div>
</div>


<div class="hidden-md hidden-lg toggle-search-mobile">
    <a href="#search" class="toggle-search no-scroll"><span class="fas fa-search">&nbsp;</span></a>
</div>

<style>

    .bottom-menu:before, .bottom-menu:after
    {
        display: none !important;
    }

    .exact-ac .country-selector-bar {
        display: none;
    }

    body.country.exact-ac .mainmenu {
        top: 0;
    }

    .exact-ac .mainmenu .deeper.parent.active > a {
        color: #f78c2d;
    }

    .exact-ac .mainmenu .dropdown.show > a:after {
        background: #f78c2d;
    }
    .dropbtn {
        background-color: #04AA6D;
        color: white;
        font-size: 16px;
        border: none;
    }

    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        min-width: 200px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {background-color: #ddd;}

    .dropdown:hover .dropdown-content {display: block;}

    .dropdown:hover .dropbtn {background-color: #3e8e41;}
    </style>

<nav class="navbar fixed-top navbar-expand-lg mainmenu">
    <div class="container">
        <a class="navbar-brand" href="{{url('/')}}">
            <img src="{{asset('assets/images/'.$gs->logo)}}" alt="Pieppiep logo"/>
        </a>
        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav float-left menu">
                @foreach($menu as $m)

                    <li class="item-6903"><a href="{{url($m->page)}}">{{$m->page}}</a></li>

                @endforeach

                    {{--                <li class="item-6903"><a href="#">Retailer</a></li>--}}
{{--                <li class="item-6925"><a href="#">Leverancier</a></li>--}}
{{--                <li class="item-6952"><a href="#">Prijzen</a></li>--}}
{{--                <li class="item-6967 deeper parent dropdown"><a href="/nl/pieppiep/contact" id="navbarDropdown-6967"--}}
{{--                                                                role="button" data-toggle="dropdown"--}}
{{--                                                                aria-haspopup="true" aria-expanded="false">Services</a>--}}
                    <div class="mainmenu-dropdown dropdown-menu" aria-labelledby="navbarDropdown-6967">
                        <div class="container">
                            <div class="backbone-menu"></div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-9 col-menu">
                                    <div class="row">
                                        <ul class="col-xs-12 col-md-4 nav-child nav flex-column">
                                            <li class="item-6968"><a href="/nl/pieppiep/contact">Contact</a></li>
                                            <li class="item-6969"><a href="https://www.pieppiep.nl/kennisbank/">Kennisbank</a>
                                            </li>
                                            <li class="item-7061"><a href="/nl/pieppiep/ondernemer/vind-een-adviseur">Vind
                                                    een adviseur</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-3 col-default bg-light-blue"></div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <ul class="menu-right nav menu float-right">

                @if(Auth::guard('user')->check())

                    <li class="item-6953">

                        <div class="dropdown">
                            <button style="padding: 10px;font-family: Apax,Arial,sans-serif;" class="dropbtn">Profile <i style="margin-left: 5px;" class="fa fa-angle-down"></i></button>
                            <div class="dropdown-content">
                                <a href="{{Auth::guard('user')->user()->role_id == 3 ? route('client-new-quotations') : route('user-dashboard')}}">{{Auth::guard('user')->user()->role_id == 2 ? __('text.Retailer Dashboard') : (Auth::guard('user')->user()->role_id == 4 ? __('text.Supplier Dashboard') : __('text.Customer Dashboard'))}}</a>
                                <a href="{{route('user-logout')}}">{{$lang->logout}}</a>
                            </div>
                        </div>

                    </li>

                @else

                    <li class="item-6953"><a href="{{route('user-login')}}" class="link-blue menu-right" target="_blank" rel="noopener">Login</a></li>

                @endif
                
                <li class="item-7035"><a href="{{route('handyman-register')}}" class="btn-blue">Probeer nu</a></li>
            </ul>

        </div>
    </div>
</nav>


<div id="system-message-container">
</div>

<!-- Starting of Hero area -->
@yield('content')

<footer id="page-footer" class="footer bg-gray">
    <div class="container">
        <div class="row">
            <div class="hidden-xs col-xs-12 col-md-3">

                <h4>Start een gesprek</h4>



                <div class="hidden-xs"  >
                    <ul>
                        <li><a href="tel:0201111111">020 - 210 11 87</a></li>
                        <li><a href="/contact">Contactformulier</a></li>
                    </ul>
                </div>

            </div>

            <div class=" col-xs-12 col-md-3">

                <h4>Contact</h4>


                <p>Herengracht 420<br />1017 BZ Amsterdam<br />Nederland<br/><a href="mailto:info@pieppiep.nl">info@pieppiep.nl</a></p>
            </div>

            <div class=" col-xs-12 col-md-3">

                <h4>Volg ons</h4>


                <ul class="social">
                    <li><a href="https://www.facebook.com//" target="_blank" rel="noopener" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="https://twitter.com/" target="_blank" rel="noopener" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="https://www.linkedin.com/company/" target="_blank" rel="noopener" title="LinkedIn"><i class="fa fa-linkedin"></i></a></li>
                    <li><a href="https://www.youtube.com/" target="_blank" rel="noopener" title="YouTube"><i class="fa fa-youtube-play"></i></a></li>
                </ul>
            </div>


        </div>
    </div>
</footer>
<section class="bottom-menu">
    <div class="container">
        <div class="copyright">&copy; Pieppiep 2022</div>

        <ul>
            <li><a href="/privacy-verklaring">Privacy verklaring</a></li>
            <li><a href="/cookies">Cookies</a></li>
            <li><a href="/Verwerkersovereenkomst">Verwerkersovereenkomst</a></li>
            <li><a href="/Algemene-voorwaarden-consumenten">Algemene voorwaarden consumenten</a></li>
            <li><a href="/Algemene-voorwaarden-zakelijk">Algemene voorwaarden zakelijk</a></li>
        </ul>

        <!-- <a href="/country-selector" class="country-selector ">
            <span class="pretext">NL</span>
            <span class="posttext">Select your country</span>
        </a> -->

    </div>
</section>


<!--[if IE]>
<style>.navbar li {
    list-style-type: none;
}</style>
<![endif]-->


<link href="{{ asset('assets/front/css/font-awesome.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/front/css/rainbow.min.css') }}" rel="stylesheet" type="text/css">
<script src="{{ asset('assets/front/js/rainbow.min.js') }}"></script>
<link href="{{ asset('assets/front/css/exact-ac.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/front/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('assets/front/css/responsive.css') }}" rel="stylesheet">

</body>
</html>
