(function($){

    window.SCRAPER = {};

    var SS = window.SCRAPER;

    SS.init = function(){
        SS.setElements();
        SS.basics();
        SS.scroll();
        SS.modals();
        SS.toggles();
        SS.hackerNews('http://api.ihackernews.com/page?format=jsonp&callback=hnJSON');
    }
    SS.setElements = function(){
        SS.elems = {};
        
    }
    
    SS.basics = function(){

    }

    SS.scroll = function(){
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
    
    SS.modals = function(){

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

    SS.menus = function(){

        
    }

    SS.toggles = function(){

        
    }

    SS.hackerNews = function(url){

        // http://api.thriftdb.com/api.hnsearch.com/items/_search?pretty_print=true&filter[fields][create_ts]=[NOW-5HOURS TO NOW]&filter[queries][]=points:[10+TO+*]&limit=5&start=0

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
        
        SS.init();

    });//close document ready

})(jQuery)