(function($){

    window.PEAK = {};

    var PK = window.PEAK;

    PK.init = function(){
        PK.setElements();
        PK.basics();
        PK.scroll();
        PK.modals();
        PK.toggles();
        PK.github();
    }
    PK.setElements = function(){
        PK.elems = {};
        
    }
    
    PK.basics = function(){

    }

    PK.scroll = function(){
        $('a[href^="#"]').click(function(e){
            var $self = $(this);
            var destination = $($self.attr('href'));
            e.preventDefault();
            // if destination is valid, scroll to
            if(destination && destination.offset()){
                $('html, body').animate({
                    scrollTop: $(destination).offset().top
                }, 650, 'swing');
            }
        });
    }
    
    PK.modals = function(){

        $('a[href^="#"].modal-link').bind('click',function(e){
            var $self = $(this);
            var destination = $self.attr('href');
            e.preventDefault();
            $(destination).fadeIn(500,'easeInOutQuint');
            $('.close').bind('click',function(){
                $(destination).fadeOut(500,'easeInOutQuint');
            });
        });

    }

    PK.menus = function(){

        
    }

    PK.toggles = function(){

        
    }

    PK.github = function(){
        //Github fixes

    }

    PK.cleanup = function(){
        //XML Feed Date remove (mm-dd-yy)
        var $dateStr = $('.xmlfeed_date i');
        $dateStr.each(function(i){

            var dateStr  = $(this).text();
            var dateJunk = dateStr.substr(dateStr.length - 14);

            dateStr = dateStr.replace(dateJunk, " ");
            $(this).text(dateStr);

        });

        //XML Feed 'feedflare' (social stuff) remove
        $('.xmlfeed_desc .feedflare').remove();
    }

    PK.loader_toggle = function(){
        $('.loading').fadeOut(200);
        $('#content').delay(200).fadeIn();
    }


    /* WINDOW & DOCUMENT LOAD/READYs
    ================================================== */
    $(window).load(function(){
        //Do stuff on window load
        PK.cleanup();
        PK.loader_toggle();
    });

    $(window).resize(function(){
        //Window resize stuff
        

    }).trigger('resize');

    $(document).ready(function(){
        
        PK.init();

    });//close document ready

})(jQuery)