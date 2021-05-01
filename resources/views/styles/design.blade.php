<style type="text/css">

    #cover {
        background: url({{asset('assets/images/'.$gs->loader)}}) no-repeat scroll center center #FFF;
        position: fixed;
        height: 100%;
        width: 100%;
        z-index: 9999;
        }

/*Handyman color: #f3bd02*/
.section-borders span.black-border {
    background-color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};
}
.header-top-area {
    background-color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};
}

.section-padding.footer-area-wrapper {
    background-color: {{$gs->footer_bg == null ? '#f3bd02':$gs->footer_bg}};
    color: {{$gs->footer_tx == null ? '#fff':$gs->footer_tx}};

}

.footer-content ul.about-footer li a
{
    color: {{$gs->footer_tx == null ? '#fff':$gs->footer_tx}};
}

.footer-content ul.about-footer li
{
    border-top: 1px solid {{$gs->footer_tx == null ? '#fff':$gs->footer_tx}};
}

.footer-content ul.latest-tweet li a
{

    color: {{$gs->footer_tx == null ? '#fff':$gs->footer_tx}};

}

.footer-content .contact-info i.fa, .footer-content .contact-info a
{

    color: {{$gs->footer_tx == null ? '#fff':$gs->footer_tx}};

}

.header-top-area .top-social-links li a:hover {color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};}

.header-top-area .top-social-links .top-social-links-li a:hover {color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};}

.header-area-wrapper {
    border-top: 1px solid {{$gs->colors == null ? '#f3bd02':$gs->colors}};
    border-bottom: 1px solid {{$gs->colors == null ? '#f3bd02':$gs->colors}};
}

.mainmenu li ul {
    border: 1px solid #e1e1e1;
    border-top: 3px solid {{$gs->colors == null ? '#f3bd02':$gs->colors}};
}
.mainmenu li ul li {
    border-bottom: 1px solid {{$gs->colors == null ? '#f3bd02':$gs->colors}};
}
.slicknav_btn {
    background-color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};
}

.slicknav_nav {
    background-color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};
    margin-top: 25px;
}
.slicknav_nav .slicknav_row:hover, .slicknav_nav a:hover {
    background-color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};
}

.hero-form {
    background-color: {{$gs->colors == null ? '#f3bd02':$gs->colors}}ad;
}

.hero-btn {background-color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};}

.profile-contact-area .btn {background: {{$gs->colors == null ? '#f3bd02':$gs->colors}}; border-color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};}

.team_style2 .team_common{
    border: 1px solid {{$gs->colors == null ? '#f3bd02':$gs->colors}};
}
.team_style2 .member_info .overlay2 {
    background: {{$gs->colors == null ? '#f3bd02':$gs->colors}} none repeat scroll 0 0;
}
.testimonial-wrapper .section-borders span.black-border {background-color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};}
.testimonial-wrapper .owl-prev,
.testimonial-wrapper .owl-next {
    box-shadow: 0 0 1px {{$gs->colors == null ? '#f3bd02':$gs->colors}};
    background-color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};
}
.single-blog-box {
    border: 1px solid {{$gs->colors == null ? '#f3bd02':$gs->colors}};
}
.boxed-btn.blog {
    background-color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};
    border: 1px solid {{$gs->colors == null ? '#f3bd02':$gs->colors}};
}
.boxed-btn.blog:hover {color: {{$gs->colors == null ? '#f3bd02':$gs->colors}}; border-color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};}

.blog-area-wrapper .owl-carousel .owl-nav .owl-prev,
.blog-area-wrapper .owl-carousel .owl-nav .owl-next {
    color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};
}

.post-heading {border-bottom: 2px solid {{$gs->colors == null ? '#f3bd02':$gs->colors}};}

.post-sidebar-area li a:hover {color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};}
.single-all-blogs-box {
    border: 1px solid {{$gs->colors == null ? '#f3bd02':$gs->colors}};
}
.comments-form input[type="submit"],
.comments-form button[type="submit"]  {
    background-color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};
    border: 1px solid {{$gs->colors == null ? '#f3bd02':$gs->colors}};
}
.comments-form input[type="submit"]:hover,
button[type="submit"]:hover {
    border: 1px solid {{$gs->colors == null ? '#f3bd02':$gs->colors}};
    color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};
}

.contact-info i.fa {
    color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};
}

.styled-faq .panel-title {background-color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};}

.subscribe-newsletter-area {
    background-color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};
}
.login-form {
    border: 1px solid {{$gs->colors == null ? '#f3bd02':$gs->colors}};
}
.login-icon {
    background-color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};
}
.login-title {
    background-color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};
}
.login-area .section-borders span {
    background-color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};
}

.login-form .input-group-addon {
    color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};
}

.login-btn {
    background-color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};
}

            .pagination>.disabled>a:focus,
            .pagination>.disabled>a:hover,
            .pagination>.disabled>span,
            .pagination>.disabled>span:focus,
            .pagination>.disabled>span:hover {
                color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};
            }

            .pagination>.disabled>a,
            .pagination>.disabled>a:focus,
            .pagination>.disabled>a:hover,
            .pagination>.disabled>span,
            .pagination>.disabled>span:focus,
            .pagination>.disabled>span:hover {
                border-color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};
            }

            .pagination>.active>a,
            .pagination>.active>a:focus,
            .pagination>.active>a:hover,
            .pagination>.active>span,
            .pagination>.active>span:focus,
            .pagination>.active>span:hover {
                background-color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};
                border-color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};

            }
            .pagination>li>a, .pagination>li>span {
                border: 1px solid {{$gs->colors == null ? '#f3bd02':$gs->colors}};

            }
            .pagination>li>a, .pagination>li>span {
                color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};
                border: 1px solid {{$gs->colors == null ? '#f3bd02':$gs->colors}};
            }
.pagination>li>a:focus, .pagination>li>a:hover, .pagination>li>span:focus, .pagination>li>span:hover {
    border-color: {{$gs->colors == null ? '#f3bd02':$gs->colors}};
}

</style>
