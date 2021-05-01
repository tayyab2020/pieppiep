(function ($) {
	"use strict";

    jQuery(document).ready(function($){

        //-----------Slick Nav Mobile menu-----------
	   $('#menuResponsive').slicknav({
		   prependTo: "#mobile-menu-wrap",
		   allowParentLinks : false,
		   label: ''
	   });

		$(".slicknav_btn").on('click', function() {
		  if ( $(this).hasClass("slicknav_collapsed")) {
			$(".slicknav_icon").html('<i class="fa fa-bars"></i>');
		  } else {
			$(".slicknav_icon").html('<i class="fa fa-times"></i>');
		  }
		});

       $(window).bind('scroll', function() {
        var navHeight = $(".header-top-area").height();
        ($(window).scrollTop() > navHeight) ? $('.header-area-wrapper').addClass('goToTop') : $('.header-area-wrapper').removeClass('goToTop');
    	});

       /*  dropdown  */
		$('.menuUl').hide();
        $('.menuLi').click(function(){
            $('.menuUl').toggle();
        });

        $('.menuUl1').hide();
        $('.menuLi1').click(function(){
            $('.menuUl1').toggle();
        });


       //-----------Wow js-----------
       new WOW().init();

       //-----------testimonial style-10-----------
	    $(".t_carousel10").owlCarousel({
	        items: 1,
	        loop: true,
	        dots: false,
	        nav: true,
	        margin: 30,
	        autoplay: true,
	        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
	        smartSpeed: 1200
	    });

	    //-----------Blog Carousel-----------
		$(".blog-area-slider").owlCarousel({
		    items: 3,
		    autoplay: false,
		    margin: 30,
			loop: false,
			nav: true,
			navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
		    smartSpeed: 800,
		    responsive : {
				0 : {
					items: 1,
				},
				768 : {
					items: 2,
				},
				992 : {
					items: 3
				}
			}
		});


    });


    jQuery(window).load(function(){


    });


}(jQuery));
