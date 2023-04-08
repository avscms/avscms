(function (e) {
    jQuery.fn.extend({
        slimScroll: function (n) {
            var r = e.extend({
                width: "auto",
                height: "250px",
                size: "7px",
                color: "#000",
                position: "right",
                distance: "1px",
                start: "top",
                opacity: .4,
                alwaysVisible: !1,
                disableFadeOut: !1,
                railVisible: !1,
                railColor: "#333",
                railOpacity: .2,
                railDraggable: !0,
                railClass: "slimScrollRail",
                barClass: "slimScrollBar",
                wrapperClass: "slimScrollDiv",
                allowPageScroll: !1,
                wheelStep: 20,
                touchScrollStep: 200,
                borderRadius: "7px",
                railBorderRadius: "7px"
            }, n);
            this.each(function () {
                function i(t) {
                    if (l) {
                        t = t || window.event;
                        var n = 0;
                        t.wheelDelta && (n = -t.wheelDelta / 120);
                        t.detail && (n = t.detail / 3);
                        e(t.target || t.srcTarget || t.srcElement).closest("." + r.wrapperClass).is(w.parent()) && s(n, !0);
                        t.preventDefault && !b && t.preventDefault();
                        b || (t.returnValue = !1)
                    }
                }

                function s(e, t, n) {
                    b = !1;
                    var i = e,
                        s = w.outerHeight() - S.outerHeight();
                    t && (i = parseInt(S.css("top")) + e * parseInt(r.wheelStep) / 100 * S.outerHeight(), i = Math.min(Math.max(i, 0), s), i = 0 < e ? Math.ceil(i) : Math.floor(i), S.css({
                        top: i + "px"
                    }));
                    m = parseInt(S.css("top")) / (w.outerHeight() - S.outerHeight());
                    i = m * (w[0].scrollHeight - w.outerHeight());
                    n && (i = e, e = i / w[0].scrollHeight * w.outerHeight(), e = Math.min(Math.max(e, 0), s), S.css({
                        top: e + "px"
                    }));
                    w.scrollTop(i);
                    w.trigger("slimscrolling", ~~i);
                    a();
                    f()
                }

                function o() {
                    window.addEventListener ? (this.addEventListener("DOMMouseScroll", i, !1), this.addEventListener("mousewheel", i, !1)) : document.attachEvent("onmousewheel", i)
                }

                function u() {
                    v = Math.max(w.outerHeight() / w[0].scrollHeight * w.outerHeight(), y);
                    S.css({
                        height: v + "px"
                    });
                    var e = v == w.outerHeight() ? "none" : "block";
                    S.css({
                        display: e
                    })
                }

                function a() {
                    u();
                    clearTimeout(p);
                    m == ~~m ? (b = r.allowPageScroll, g != m && w.trigger("slimscroll", 0 == ~~m ? "top" : "bottom")) : b = !1;
                    g = m;
                    v >= w.outerHeight() ? b = !0 : (S.stop(!0, !0).fadeIn("fast"), r.railVisible && x.stop(!0, !0).fadeIn("fast"))
                }

                function f() {
                    r.alwaysVisible || (p = setTimeout(function () {
                        r.disableFadeOut && l || c || h || (S.fadeOut("slow"), x.fadeOut("slow"))
                    }, 1e3))
                }
                var l, c, h, p, d, v, m, g, y = 30,
                    b = !1,
                    w = e(this);
                if (w.parent().hasClass(r.wrapperClass)) {
                    var E = w.scrollTop(),
                        S = w.parent().find("." + r.barClass),
                        x = w.parent().find("." + r.railClass);
                    u();
                    if (e.isPlainObject(n)) {
                        if ("height" in n && "auto" == n.height) {
                            w.parent().css("height", "auto");
                            w.css("height", "auto");
                            var T = w.parent().parent().height();
                            w.parent().css("height", T);
                            w.css("height", T)
                        }
                        if ("scrollTo" in n) E = parseInt(r.scrollTo);
                        else if ("scrollBy" in n) E += parseInt(r.scrollBy);
                        else if ("destroy" in n) {
                            S.remove();
                            x.remove();
                            w.unwrap();                           
                            return
                        } else if ("resize" in n) {
                            w.parent().css("height", "auto");
                            w.css("height", "auto");
                            var T = w.parent().parent().height();
                            w.parent().css("height", T);
                            w.css("height", T)
                        }
                        s(E, !1, !0)
                    }
                } else {
                    r.height = "auto" == r.height ? w.parent().height() : r.height;
                    E = e("<div></div>").addClass(r.wrapperClass).css({
                        position: "relative",
                        overflow: "hidden",
                        width: r.width,
                        height: r.height
                    });
                    w.css({
                        overflow: "hidden",
                        width: r.width,
                        height: r.height
                    });
                    var x = e("<div></div>").addClass(r.railClass).css({
                        width: r.size,
                        height: "100%",
                        position: "absolute",
                        top: 0,
                        display: r.alwaysVisible && r.railVisible ? "block" : "none",
                        "border-radius": r.railBorderRadius,
                        background: r.railColor,
                        opacity: r.railOpacity,
                        zIndex: 90
                    }),
                        S = e("<div></div>").addClass(r.barClass).css({
                            background: r.color,
                            width: r.size,
                            position: "absolute",
                            top: 0,
                            opacity: r.opacity,
                            display: r.alwaysVisible ? "block" : "none",
                            "border-radius": r.borderRadius,
                            BorderRadius: r.borderRadius,
                            MozBorderRadius: r.borderRadius,
                            WebkitBorderRadius: r.borderRadius,
                            zIndex: 99
                        }),
                        T = "right" == r.position ? {
                            right: r.distance
                        } : {
                            left: r.distance
                        };
                    x.css(T);
                    S.css(T);
                    w.wrap(E);
                    w.parent().append(S);
                    w.parent().append(x);
                    r.railDraggable && S.bind("mousedown", function (n) {
                        var r = e(document);
                        h = !0;
                        t = parseFloat(S.css("top"));
                        pageY = n.pageY;
                        r.bind("mousemove.slimscroll", function (e) {
                            currTop = t + e.pageY - pageY;
                            S.css("top", currTop);
                            s(0, S.position().top, !1)
                        });
                        r.bind("mouseup.slimscroll", function (e) {
                            h = !1;
                            f();
                            r.unbind(".slimscroll")
                        });
                        return !1
                    }).bind("selectstart.slimscroll", function (e) {
                        e.stopPropagation();
                        e.preventDefault();
                        return !1
                    });
                    x.hover(function () {
                        a()
                    }, function () {
                        f()
                    });
                    S.hover(function () {
                        c = !0
                    }, function () {
                        c = !1
                    });
                    w.hover(function () {
                        l = !0;
                        a();
                        f()
                    }, function () {
                        l = !1;
                        f()
                    });
                    w.bind("touchstart", function (e, t) {
                        e.originalEvent.touches.length && (d = e.originalEvent.touches[0].pageY)
                    });
                    w.bind("touchmove", function (e) {
                        b || e.originalEvent.preventDefault();
                        e.originalEvent.touches.length && (s((d - e.originalEvent.touches[0].pageY) / r.touchScrollStep, !0), d = e.originalEvent.touches[0].pageY)
                    });
                    u();
                    "bottom" === r.start ? (S.css({
                        top: w.outerHeight() - S.outerHeight()
                    }), s(0, !0)) : "top" !== r.start && (s(e(r.start).position().top, null, !0), r.alwaysVisible || S.hide());
                    o()
                }
            });
            return this
        }
    });
    jQuery.fn.extend({
        slimscroll: jQuery.fn.slimScroll
    })
})(jQuery)