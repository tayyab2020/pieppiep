        


            var url = window.location.pathname,
            urlRegExp = new RegExp(url.replace(/\/$/,'') + "$"); 

                // create regexp to match current
                //url pathname and remove trailing slash if present as it could collide with the link in
                //navigation in case trailing slash wasn't present there

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

   
