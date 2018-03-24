(function (lib) {

    lib(window.jQuery, window, document);

}(function ($, win, doc) {

        var uiSurvey = (function () {
            var ui = this;

            ui.cookie = (function () {
                return {

                    get: function (cName) {
                        var name = cName,
                            cA = doc.cookie.split(';'),
                            c, i;

                        for (i = 0, len = cA.length; i < len; i++) {
                            c = cA[i];
                            while (c.charAt(0) == '')  c = c.substring(1);
                            if (c.indexOf(name) != -1) return c.split('=')[1];
                        }
                    },

                    set: function (cName, cValue, exDays) {
                        var d = new Date(),
                            expires, millisecondsFormat = 24 * 60 * 60 * 1000;
                        
                        if (!isNaN(exDays)) {
                            d.setTime(d.getTime() + exDays * millisecondsFormat);
                            expires = 'expires=' + d.toUTCString();
                        }

                        doc.cookie = cName + '=' + cValue + '; ' + expires;
                    },

                    delete: function (cName) {
                        ui.set(cName, '', -1);
                    }
                }
            }());

            ui.displayModal = function () {
                    //alert('ok');
            }

            ui.hideModal = function () {

            }

            ui.init = function (settings) {
                var defaults = {
                        minute: 1
                    },
                    options;

                options = $.extend({}, defaults, settings);
                setTimeout(ui.displayModal, options.minute * 60 * 1000);
            }

            return ui;
        }());

        window.uiSurvey = uiSurvey;

        $(function () {
            uiSurvey.init();
        });
    }
));

