(function($) {
    /**
     * @file
     * Javascript support files.
     *
     */
    Drupal.behaviors.blueimp = {
        attach: function(context, settings) {
            // Read URL paramters
            var urlParams = blueimp_readURLparams();
            // Create modal
            blueimp_create_modal('blueimp-gallery', drupalSettings.blueimp);
            //blueimp_create_modal();
            var trigger = drupalSettings.blueimp.trigger;
            var module_path = drupalSettings.blueimp.module_path;
            $(trigger).find("a").attr("data-gallery", "#blueimp-gallery");
        }
    }

    function blueimp_readURLparams() {
        (window.onpopstate = function() {
            var match,
                pl = /\+/g, // Regex for replacing addition symbol with a space
                search = /([^&=]+)=?([^&]*)/g,
                decode = function(s) {
                    return decodeURIComponent(s.replace(pl, " "));
                },
                query = window.location.search.substring(1);
            urlParams = {};
            while (match = search.exec(query)) urlParams[decode(match[1])] = decode(match[2]);
        })();
        return urlParams;
    }

    function blueimp_create_modal(id, p) {
        $('body').append('<div id="blueimp-gallery" class="blueimp-gallery">');
        $('#blueimp-gallery').addClass("blueimp-gallery-controls");
        $('#blueimp-gallery').attr("data-carousel", "false");
        $('#blueimp-gallery').attr("data-hidePageScrollbars", "true");
        $('#blueimp-gallery').attr("data-startSlideshow", "true");
        $('#blueimp-gallery').append('<div class="slides" />');
        $('#blueimp-gallery').append('<h3 class="title" />');
        $('#blueimp-gallery').append('<a class="prev">‹</a>');
        $('#blueimp-gallery').append('<a class="next">›</a>');
        $('#blueimp-gallery').append('<a class="close">x</a>');
        $('#blueimp-gallery').append('<a class="play-pause">›</a>');
        $('#blueimp-gallery').append('<div id="indicator-container"></div>');
        $('#indicator-container').append('<ol class="indicator"></ol>');
    }
}(jQuery));
