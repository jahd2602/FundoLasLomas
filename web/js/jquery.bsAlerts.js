/*! bsAlerts version: 0.1.1
 *  2013-04-19
 *  Author: Tim Nelson
 *  Website: http://eltimn.github.com/jquery-bs-alerts
 *  MIT License http://www.opensource.org/licenses/mit-license.php
 */
(function (t, n, r) {
    "use strict";
    function e(n) {
        return{errs: t.grep(n, function (t) {
            return"error" === t.priority || "danger" === t.priority
        }), warns: t.grep(n, function (t) {
            return"warning" === t.priority
        }), infos: t.grep(n, function (t) {
            return"notice" === t.priority || "info" === t.priority
        }), succs: t.grep(n, function (t) {
            return"success" === t.priority
        })}
    }

    function a(t) {
        return"notice" === t ? "info" : "danger" === t ? "danger" : t
    }

    var i = function (n, i) {
        var s, o = this;
        o.element = n, o.options = t.extend({}, t.fn.bsAlerts.defaults, i), t(r).on("add-alerts", function () {
            var t = Array.prototype.slice.call(arguments, 1);
            o.addAlerts(t)
        }), t(r).on("clear-alerts", function () {
            o.clearAlerts()
        }), t.each(this.options.ids.split(","), function (n, e) {
            var a = e.trim();
            if (a.length > 0) {
                var i = "set-alert-id-" + a;
                t(r).on(i, function () {
                    var t = Array.prototype.slice.call(arguments, 1);
                    o.addAlerts(t)
                })
            }
        }), o.clearAlerts = function () {
            t(this.element).html("")
        }, o.addAlerts = function (t) {
            var n = e([].concat(t));
            o.addAlertsToContainer(n.errs), o.addAlertsToContainer(n.warns), o.addAlertsToContainer(n.infos), o.addAlertsToContainer(n.succs);
            var r = parseInt(o.options.fade, 10);
            !isNaN(r) && r > 0 && (clearTimeout(s), s = setTimeout(o.fade, r))
        }, o.fade = function () {
            t("[data-alerts-container]").fadeOut("slow", function () {
                t(this).remove()
            })
        }, o.buildNoticeContainer = function (n) {
            if (n.length > 0) {
                var r = a(n[0].priority), e = t("<button/>", {type: "button", "class": "close", "data-dismiss": "alert"}).html("&times;"), i = t("<ul/>");
                o.attachLIs(i, n);
                var s = t("<div/>", {"data-alerts-container": r, "class": "alert alert-" + r});
                s.append(e);
                var l = this.options.titles[r];
                return l && l.length > 0 && s.append(t("<strong/>").html(l)), s.append(i), s
            }
            return null
        }, o.addAlertsToContainer = function (n) {
            if (n.length > 0) {
                var r = t(this.element), e = a(n[0].priority), i = t("[data-alerts-container='" + e + "']", r);
                if (i.length > 0) {
                    var s = i.find("ul");
                    o.attachLIs(s, n)
                } else i = o.buildNoticeContainer(n), r.append(i)
            }
        }, o.attachLIs = function (n, r) {
            t.each(r, function (r, e) {
                n.append(t("<li/>").html(e.message))
            })
        }
    }, s = t.fn.bsAlerts;
    t.fn.bsAlerts = function (n) {
        return this.each(function () {
            var r = t(this), e = r.data("bsAlerts"), a = "object" == typeof n && n;
            e || r.data("bsAlerts", e = new i(this, a)), "string" == typeof n && e[n]()
        })
    }, t.fn.bsAlerts.Constructor = i, t.fn.bsAlerts.defaults = {titles: {}, ids: "", fade: "0"}, t.fn.bsAlerts.noConflict = function () {
        return t.fn.bsAlerts = s, this
    }, t(r).ready(function () {
        t('[data-alerts="alerts"]').each(function () {
            var n = t(this);
            n.bsAlerts(n.data())
        })
    })
})(jQuery, window, document);