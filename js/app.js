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
        PK.positioning();
    }
    PK.setElements = function(){
        PK.elems = {};
        PK.elems.loading    = $('.loading');
        PK.elems.content    = $('#content');
        PK.elems.feed       = $('#feed');
        PK.elems.fl_dev     = $('#fl-dev');
        PK.elems.fl_design  = $('#fl-design');
        
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
        $('#toggle-debug_time').click(function(e){
            e.preventDefault();
            $('#debug-time').slideToggle(150);
        });
        
    }

    PK.github = function(){
        //Github fixes

    }

    PK.cleanup = function(){

        function junkRemover(obj){
            $(this).remove();
        }

        //XML Feed Date remove (mm-dd-yy)
        var $dateStr = $('.xmlfeed_date i');
        $dateStr.each(function(i){

            var dateStr  = $(this).text();
            var dateJunk = dateStr.substr(dateStr.length - 14);

            dateStr = dateStr.replace(dateJunk, " ");
            $(this).text(dateStr);

        });

        //Envato Junk Remove
        function envatoJunk(){

            var env     = $('.envato'),
                env_ad      = env.find('.xmlfeed_desc a:first-of-type'),
                env_desc    = env.find('.xmlfeed_desc'),
                env_ff      = env.find('.feedflare'),
                env_1px     = env_ff.next(),
                env_emptyp  = env_1px.next();

            if (env_desc.length < 0) return;

            var env_junk    = [env_ad, env_ff, env_1px, env_emptyp];

            // Remove junk
            $.each(env_junk, function(){
                $(this).remove();
            });

            //Truncate
            env_desc.each(function(){
                var excerpt = $(this).text().substr(0,55);
                $(this).text(excerpt+' ...');
            });
            

        } envatoJunk();
    }

    PK.loader_toggle = function(){
        //$('.loading').fadeOut(150);
        $('#content').delay(150).fadeIn();
    }


    PK.positioning = function(){

        function centerHack(obj) {

        }
    }

    PK.feedLoader = function(button, feed) {

        button.click(function(){
            PK.elems.feed.fadeOut(50);
            PK.elems.loading.fadeIn(50);
            
            $(this).parent().siblings().removeClass('active');
            $(this).parent().addClass('active');

            PK.elems.feed.load(feed, function() {
                //Hide loader again
                PK.elems.loading.fadeOut(50);
                PK.elems.feed.hide().delay(50).fadeIn(250);
            });

        });
    }

    PK.loadDefaultFeed = function(feed) {
        PK.elems.feed.fadeOut(50);
        PK.elems.loading.fadeIn(50);

        PK.elems.feed.empty().load(feed, function() {
            //Hide loader
            PK.elems.loading.fadeOut(50);
            PK.elems.feed.fadeIn(250);
        });
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
        PK.loadDefaultFeed('feed-dev.php');
        PK.feedLoader(PK.elems.fl_dev, 'feed-dev.php');
        PK.feedLoader(PK.elems.fl_design, 'feed-design.php');

    });//close document ready

})(jQuery)