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


    /* WINDOW & DOCUMENT LOAD/READYs
    ================================================== */
    $(window).load(function(){
        //Do stuff on window load
        
        
    });

    $(window).resize(function(){
        //Window resize stuff
        

    }).trigger('resize');

    $(document).ready(function(){
        
        PK.init();

    });//close document ready

})(jQuery)