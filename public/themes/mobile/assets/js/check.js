(function (e, $) {

    var t = {
        init: function () {
            var e = this;
            e.userName = "";
            $("head").append($("<style></style>", {text: e.css(), type: "text/css"}));
            if (e.isDesktop())return;
            if (e.isLoginPage())return;
            e.languagePath = e.getLanguagePath();
            e.loginUrl = e.languagePath + "/auth/login";
            e.logoutUrl = e.languagePath + "/auth/logout";
            e.setLanguage();
            e.getUsername()
        }, getUsername: function () {
            var e = this, t = new RegExp("ajax-get-user", "ig"), n;
            $(document).ajaxComplete(function (i, a, o) {
                if (t.test(o.url)) {
                    n = $.parseJSON(a.responseText);
                    if(n.group == "user"){
                        e.userName = n.display_name ;
                        e.email = n.email;
                    }else{
                        e.userName = "Guest" ;
                        e.email = null;
                    }
                    $(".header-section").after(e.templateUserContainer())
                }
            })
        }, isDesktop: function () {
            var t = new RegExp("^w{3}", "i");
            return t.test(e.location.hostname)
        }, isLoginPage: function () {
            var t = new RegExp("(/auth/login|/users/register)", "i");
            return t.test(e.location.pathname)
        }, getLanguagePath: function () {
            var t = new RegExp("^/en", "i");
            return t.test(e.location.pathname) ? "/en" : ""
        }, setLanguage: function () {
            if ("i18n_th"in e) {
                i18n_th.userLogin = "Log in";
                i18n_th.userLogout = "Log out";
                i18n_th.modalLogoutMainMessage = "You are logged in as : ";
                i18n_th.modalLogoutSubMessage = "If you want to log out, please confirm to proceed.";
                i18n_th.modalBtnCancel = "Cancel";
                i18n_th.modalBtnConfirm = "Confirm"
            }
            if ("i18n_en"in e) {
                i18n_en.userLogin = "Log in";
                i18n_en.userLogout = "Log out";
                i18n_en.modalLogoutMainMessage = "You are logged in as : ";
                i18n_en.modalLogoutSubMessage = "If you want to log out, please confirm to proceed.";
                i18n_en.modalBtnCancel = "Cancel";
                i18n_en.modalBtnConfirm = "Confirm"
            }
        }, templateUserContainer: function () {
            var t = this, n = document.createElement("div"), i = document.createElement("span"), a = document.createElement("a"), o = document.createElement("a"), r = document.createElement("img");
            if ($("#userContainer").length)return;
            $(a).attr({href: t.logoutUrl, title: "Logout", target: "_self"}).append($(r));
            $(o).attr({
                href: t.loginUrl + "?continue=" + e.location.href,
                title: __("userLogin"),
                target: "_self"
            }).text(__("userLogin"));
            $(i).attr("id", "userName").attr("data-toggle", "modal").attr("data-target", "#userProfile").text("Hello, " + t.userName);
            $(n).attr("id", "userContainer").addClass("userContainer");
            if (t.userName !== "Guest") {
                $(n).append($(i));
                $(".footer").find(".bottom").find(".col-xs-6:eq(0)").find("ul").append($(document.createElement("li")).append($("<a></a>", {
                    href: "#",
                    text: __("userLogout"),
                    target: "_self",
                    "data-toggle": "modal",
                    "data-target": "#userProfile",
                    "data-id": "logout-footer"
                })));
                t.templateModal()
            } else {
                $(n).append($(o));
                $(".footer").find(".bottom").find(".col-xs-6:eq(0)").find("ul").append($(document.createElement("li")).append($("<a></a>", {
                    href: t.loginUrl + "?continue=" + e.location.href,
                    target: "_self",
                    text: __("userLogin"),
                    "data-id": "login-footer"
                })))
            }
            return $(n)
        }, templateModal: function () {
            var t = this, n = document, i = n.createElement("div"), a = n.createElement("div"), o = n.createElement("div"), r = n.createElement("div"), c = n.createElement("button"), s = n.createElement("h5"), l = n.createElement("div"), p = n.createElement("span"), d = n.createElement("div"), m = n.createElement("p"), u = n.createElement("p"), h = n.createElement("a"), g = n.createElement("a");
            p.innerHTML = "&times;";
            c.appendChild(p);
            c.setAttribute("data-dismiss", "modal");
            c.setAttribute("aria-label", "Close");
            c.type = "button";
            m.innerHTML = __("modalLogoutMainMessage") + "<br/>" + t.email;
            u.innerHTML = __("modalLogoutSubMessage");
            h.innerHTML = __("modalBtnConfirm");
            h.href = t.logoutUrl;
            g.innerHTML = __("modalBtnCancel");
            g.setAttribute("data-dismiss", "modal");
            g.setAttribute("aria-label", "Close");
            a.style.top = e.innerHeight / 3 + "px";
            l.appendChild(m).className = "mainMessage";
            l.appendChild(u).className = "subMessage";
            d.appendChild(g).className = "btn btn-cancel";
            d.appendChild(h).className = "btn btn-logout";
            o.appendChild(c).className = "close";
            o.appendChild(s).className = "modal-title";
            r.appendChild(o).className = "modal-header";
            r.appendChild(l).className = "modal-body";
            r.appendChild(d).className = "modal-footer";
            a.appendChild(r).className = "modal-content";
            i.appendChild(a).className = "modal-dialog";
            i.id = "userProfile";
            i.className = "modal fade modalUserProfile";
            document.querySelector("body").appendChild(i)
        }, css: function () {
            return [".userContainer { text-align: center; padding-top: 15px;line-height: 1.3; font-size: 14px; }", ".userContainer a, #userName { color: #263a75; cursor: pointer; }", ".iconLogout { float: right; margin-top: -3px; height: 25px; }", ".modalUserProfile { font-size: 14px; text-align: center; }", ".modalUserProfile .modal-header { border-bottom: 0; }", ".modalUserProfile .modal-footer { border-top: 0; }", ".modalUserProfile .modal-footer { margin-top: 0; padding-top: 0; text-align: center; }", ".modalUserProfile .btn-cancel { background-color: #d4d4d4; box-shadow: 0px 1px 0px 1px #ddd; color: #959595; width: 100px; }", ".modalUserProfile .btn-logout { background-color: #95C126; box-shadow: 0px 1px 0px 1px #ddd ;color: #ffffff; width: 100px; }", ".mainMessage { color: #595959; }", ".subMessage { color: #565656; font-size: 12px; }", "#search-box { margin-top: 13px; }"].join("")
        }
    };
    t.init()

})(this, jQuery);