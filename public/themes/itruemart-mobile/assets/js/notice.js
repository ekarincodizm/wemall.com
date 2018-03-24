(function($) {
    $.fn.notice = function(options) {
        var defaults = {
            modalID: 'notice-modal',
            btnText: 'OK',
            topic: ''
        };

        var settings = $.extend({}, defaults, options);

        var loader = {
            append: function() {
                var agrs = arguments;

                for (var i = 0; i < agrs.length; i++) {
                    console.log(agrs[i]);
                    var link = document.createElement('link');
                    link.setAttribute('rel', 'stylesheet');
                    link.setAttribute('type', 'text/css');
                    link.setAttribute('href', agrs[i]);
                    document.getElementsByTagName('head')[0].appendChild(link);
                }
            }
        };

        var modal = {
            box: '<div id="' + settings.modalID + '" class="reveal-modal" style="top: 50%; margin-top: -50px;">'
                    + '<div id="popup_content" class="basket_put font2">'
                    + '<div id="popup_message" style="padding: 10px 0; text-align: left; font-size: 15px;">'
                    + '<h3>' + settings.topic + '</h3>'
                    + '<hr style="border-top: solid 1px #dddddd;"/>'
                    + '<div id="popup_desc">'
                    + $('#' + settings.msg).html()
                    + '</div>'
                    + '</div>'
                    + '<div id="popup_panel" style="text-align: right; border-top: solid 1px rgb(221, 221, 221); padding-top: 5px;">'
                    + '<input type="button" class="popup_ok btn btn-success" value="' + settings.btnText + '"></div>'
                    + '</div>'
                    + '</div>',
            bg: '<div class="reveal-modal-bg" style="cursor: pointer; display: block;"></div>'
        };


        return this.each(function() {
            $(this).on('click', function() {
                loader.append('js/plugins/reveal/reveal.css', 'js/plugins/reveal/addon.css');
                $('body').append(modal.box + modal.bg);
                $("#" + settings.modalID).reveal({
                    animation: "fade",
                    animationspeed: 300,
                    dismissmodalclass: "popup_ok"
                });
            });
        });
    };
})(jQuery);