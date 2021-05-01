(function ($) {
	"use strict";

    jQuery(document).ready(function($){

        $(function(){

            var url = window.location.pathname,
                urlRegExp = new RegExp(url.replace(/\/$/,'') + "$"); // create regexp to match current url pathname and remove trailing slash if present as it could collide with the link in navigation in case trailing slash wasn't present there
            // now grab every link from the navigation
            $('.components li a').each(function(){
                // and test its normalized href against the url pathname regexp
                if(urlRegExp.test(this.href.replace(/\/$/,''))){
                    $(this).addClass('active');
                    //$(this).parent('a').removeClass('collapsed');
                    $(this).closest('ul').addClass("in");
                    $(this).closest('ul').attr("aria-expanded","true");
                    $(this).parents('li').parents('li').find('.submenu').attr("aria-expanded","true");
                }
            });

        });

        /*  Counter area  */
        $('.number').each(function () {
            $(this).prop('Counter',0).animate({
                Counter: $(this).text()
            }, {
                duration: 1000,
                easing: 'swing',
                step: function (now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });
        /*  /Counter area  */

    	$('#sidebarCollapse').on('click', function () {
	        $('.dashboard-sidebar-area').toggleClass('active');
	        $(this).toggleClass('active');
	    });

    	$('#sidebar-menu').perfectScrollbar();

        /*  Product Size Check area  */
        $('.productSizeCheck').click(function(){
            $('.form-group-hidden').toggle();
        });



         $('#product-table_wrapper').dataTable({
               "language": {
                "search": "",
                "searchPlaceholder": "Search records"
              }
        });
         
        $('.wrapper_deposite').dataTable({
               "language": {
                "search": "",
                "searchPlaceholder": "Search records"
              }
        });

        $('.wrapper_login').dataTable({
               "language": {
                "search": "",
                "searchPlaceholder": "Search records"
              }
        });

        $('.wrapper_withdraw').dataTable({
               "language": {
                "search": "",
                "searchPlaceholder": "Search records"
              }
        });




    });


    jQuery(window).load(function(){
        var options = {
            exportEnabled: true,
            animationEnabled: true,
            title: {
                text: "Porducts Sold in Last 30 Days",
                horizontalAlign: "left",
                    padding: {
                        top: 20,
                        bottom: 20,
                        left: 20
                        },
            },
            data: [
            {
                type: "splineArea", //change it to line, area, bar, pie, etc
                dataPoints: [
                    { y: 10 },
                    { y: 6 },
                    { y: 14 },
                    { y: 12 },
                    { y: 19 },
                    { y: 14 },
                    { y: 26 },
                    { y: 10 },
                    { y: 22 }
                ]
            }
            ]
        };

                
    });

}(jQuery));	