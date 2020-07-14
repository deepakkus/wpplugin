var xhr, skinny, resize_grid_heights, setup_item_modal, set_tab, today = new Date,
    item_dates = {},
    search_dates = {},
    check_size = function() {
        skinny = 600 >= $(window).width()
    };
today.setHours(0, 0, 0, 0);
$(document).ready(function() {
    

    function f(a, b, c) {
        var l = $("#cf-query").serializeArray(),
            g = {};
        a = new Date(a, b, 1);
        c = new Date(a.getFullYear(), a.getMonth() + (c || 1), 0);
        b = new Date(today.getFullYear(), today.getMonth(), 1);
        a < b || ($.map(l, function(a) {
            a.value && (g[a.name] = a.value)
        }), "I" === g.category_id ? search_dates = {} : (g.start_date = $.datepicker.formatDate("yy-mm-dd", a), g.end_date = $.datepicker.formatDate("yy-mm-dd",
            c), $.ajax({
            type: "GET",
            data: g,
            url: $("#cf-query").attr("action") + "/api/?call=calendar_days",
            dataType: "json",
            success: function(a, g) {
                search_dates && $.extend(search_dates, a)
            }
        })))
    }

    function d(a, b) {
        var c, l, g;
        a ? (l = a.find(".fa"), g = l.prop("class"), l.removeAttr("class"), l.addClass("fa fa-refresh fa-spin"), c = a.prop("hash").replace("#", "").split("@")) : c = b.replace("#", "").split("@");
        xhr && 4 != xhr.readystate && xhr.abort();
        xhr = $.ajax({
            type: "GET",
            data: $("#cf-query").serialize() + "&item_id=" + c[0],
            url: $("#cf-query").attr("action") +
                "/item/",
            success: function(a, b) {
                l && (l.removeAttr("class"), l.addClass(g));
                $("#dialog-data").html(a);
                setup_item_modal();
                set_tab(".cf-item-" + c[1])
            }
        })
    }

    function u() {
        $("#cf-cal a").click(function() {
            $(this).addClass("L");
            $(".cf-cal-sm").addClass("load");
            var a = $.datepicker.parseDate("yymmdd", this.hash.replace("#D", "")),
                a = $.datepicker.formatDate("yy-mm-dd", a);
            $("#date").val(a);
            m();
            return !1
        });
        $("#date").val("");
        $("#cf-month").change(function() {
            $("#date").val($(this).val());
            m();
            return !1
        })
    }

    function r() {
        var a = [];
        $(".cf-param").bind("keyup", function(b) {
            b = parseInt($(this).val());
            var c = $(this).prop("id");
            return /[0-9]+/.test(b) ? ($(this).val(b), a[c] = b, h(), !0) : !1
        });
        $(".cf-item-book").find(".hdate").change(function(a) {
            h();
            e()
        });
        $(".cf-param").change(function(b) {
            b = parseInt($(this).val());
            var c = $(this).prop("id");
            a[c] != b && (a[c] = b, h())
        })
    }

    function v(a) {
        function b() {
            return "undefined" !== typeof a ? a : $("#cf-item-set").find("input[name=item_id]").val()
        }
        check_size();
        var c = {
            firstDay: parseInt($("#start_dow").val(), 10),
            constrainInput: !0,
            numberOfMonths: skinny ? 1 : 2,
            showButtonPanel: !0,
            dateFormat: $("#date_format").val(),
            altFormat: "yy-mm-dd",
            beforeShow: function(a, g) {
                var c = b(),
                    e = getDateJS(a.id),
                    d = skinny ? 1 : 2;
                g.lastMonth = e.getMonth();
                getItemAvail(c, e, d, $("#line_id").val());
                item_dates[c].start_date = getDateYMD("start_date");
                item_dates[c].end_date = getDateYMD("end_date", "N" === $("#item_unit").val() ? -1 : 0);
                item_dates[c].end_date || (item_dates[c].end_date = item_dates[c].start_date);
                return {
                    numberOfMonths: d
                }
            },
            beforeShowDay: function(a) {
                var g = b(),
                    c = format_YMD(a);
                a = 0 < (a < today ? 0 : item_dates[g][c]) ? "A" : "X";
                c == item_dates[g].start_date && (a += " start");
                c == item_dates[g].end_date && (a += " end");
                c >= item_dates[g].start_date && c <= item_dates[g].end_date && (a += " sel");
                return [1, a]
            },
            onChangeMonthYear: function(a, g, b) {
                g = b.drawMonth;
                var c = 1;
                1 !== b.settings.numberOfMonths && (c = 11 === b.lastMonth && 0 === b.drawMonth || 0 === b.lastMonth && 11 === b.drawMonth ? 1 : 1 < Math.abs(b.lastMonth - b.drawMonth) ? 2 : 1, 1 === c && (11 === b.lastMonth && 0 === b.drawMonth ? g = 1 : b.drawMonth > b.lastMonth && (0 !== b.lastMonth || 11 !== b.drawMonth) &&
                    (g += 1)));
                b.lastMonth = b.drawMonth;
                getItemAvail($("#cf-item-set").find("input[name=item_id]").val(), new Date(a, g, 1), c, $("#line_id").val())
            },
            onSelect: function() {
                $("#timeslot").val(-1);
                $("#cf-timeslots").find("input").prop("checked", !1);
                $(this).datepicker("option", "altField") || $(this).datepicker("option", "altField", $(this).data("alt"));
                h();
                e()
            }
        };
        $(".date").each(function() {
            if (!$(this).datepicker("option", "altField") && $(this).data("alt")) {
                var a = $(this).data("alt");
                if (a = $(a).val()) $(this).datepicker($.extend($(this).data("datepicker"),
                    c)), a = $.datepicker.parseDate("yy-mm-dd", a), $(this).datepicker("setDate", a)
            }
        });
        $(".date-plain").datepicker();
        A();
        B();
        cf_bind_date_events()
    }

    function C() {
        var a = $("#date_format").val(),
            b = $("#delivery_date").val();
        $("#delivery_date").datepicker("option", {
            dateFormat: a,
            altFormat: "yymmdd",
            altField: "#delivery_alt"
        }).datepicker("setDate", b);
        $("#delivery_date").change(function() {
            var a = $("#gc_expiry"),
                b = $("#gc_start_date");
            a.attr("data-fixed") && ($("#delivery_alt").val() >= $("#expiry_fixed").val() ? (a.addClass("alert-danger form-control"),
                $(this).addClass("alert-danger"), $("#delivery_date").datepicker("setDate", b.html()).blur()) : (a.removeClass("alert-danger form-control"), $(this).removeClass("alert-danger")));
            b.html($(this).val());
            a.attr("data-duration") && a.html(a.attr("data-duration"))
        })
    }

    function B() {
        var a = $("#timeslot");
        a.length && a.selectpicker({
            container: "body",
            iconBase: "fa",
            tickIcon: "fa-hand-o-left",
            template: {
                caret: '<span class="btn_icon"><i class="fa fa-clock-o"></i></span>'
            },
            size: 600 >= $(window).width() ? 6 : 10,
            showIcon: !1
        }).change(function() {
            h()
        });
        $("#cf-timeslots").on("change", "input", function() {
            if ($(this).parent().hasClass("disabled")) return !1;
            h()
        }).find(".cf-timeslot-avail.active :first").prop("checked", !0).parent().addClass("active")
    }

    function A() {
        var a = $("select.cf-time-val");
        a.length && ($(".cf-item-continue").hide(), a.selectpicker({
            container: "body",
            iconBase: "fa",
            tickIcon: "fa-hand-o-left",
            template: {
                caret: '<span class="btn_icon"><i class="fa fa-clock-o"></i></span>'
            },
            size: 600 >= $(window).width() ? 6 : 10,
            showIcon: !1
        }).change(function() {
            h()
        }))
    }

    function D() {
        r();
        $(".cf-add-discount").click(function() {
            $("#promo").fadeIn();
            $("#discount_code").focus();
            $(".cf-add-discount").hide();
            $(".cf-item-continue").hide();
            return !1
        });
        $(".cf-item-book .date").change(function() {
            h()
        });
        $(".cf-item-update").click(function() {
            h();
            return !1
        });
        $(".cf-tab a").click(function() {
            var a = "." + $(this).parent("li").attr("id");
            set_tab(a);
            E();
            ".cf-item-video" == a ? $("#vplay").attr("src", $("#vplay_url").val()) : $("#vplay").attr("src", "");
            $(this).blur();
            return !1
        })
    }

    function E() {
        $(".cf-item-cal a").click(function() {
            $(this).addClass("load");
            h();
            return !1
        })
    }

    function x(a) {
        var b = $("#cf-query").attr("action") + "/calendar/";
        a && (b += "?" + a);
        $.ajax({
            type: "GET",
            data: $(".cf-item-form").serialize(),
            url: b,
            success: function(a, b) {
                $(".cf-item-cal-contents").html(a);
                $(".cf-item-cal tbody a").click(function() {
                    var a = this.hash.replace("#D", ""),
                        a = $.datepicker.parseDate("yymmdd", a),
                        a = $.datepicker.formatDate("yy-mm-dd", a),
                        b = $("#start_date");
                    b.hasClass("hdate") || !b.hasClass("hasDatepicker") ? b.val(a) : $("#alt_start_date").val(a);
                    set_tab(".cf-item-book");
                    h();
                    e();
                    return !1
                });
                $(".cf-item-cal thead a").click(function() {
                    var a = this.hash.replace("#D", "");
                    x("D=" + a)
                });
                set_pipe()
            }
        })
    }

    function h(a, b, c) {
        $(".cf-item-continue").hide();
        $(".cf-item-msg").html("");
        $(".cf-item-load").show();
        var e = $(".cf-item-form").serialize();
        a = a ? e + "&" + $.param(a) : e;
        alert_msg("", ".cf-rate-info");
        $.ajax({
            type: "POST",
            dataType: "json",
            data: a,
            url: $("#cf-query").attr("action") + "/api/?call=rate",
            success: function(a, e) {
                $(".cf-item-load").hide();
                a.request.error && alert_msg('<p class="alert alert-danger"><i class="fa fa-warning"></i> ' +
                    a.request.error.details + "</p>", ".cf-rate-info");
                if (a.item) {
                    a.ui.date && ($("#cf-ui-date").html(a.ui.date), v());
                    a.ui.param ? ($("#cf-ui-param").html(a.ui.param), r()) : 0 == a.item.rated && a.item.param && a.item.param.qty && a.item.param.qty.qty && $("#cf-qty").val(a.item.param.qty.qty);
                    $(".cf-item-slip").val(a.item.rate.slip);
                    $(".cf-item-date").html(a.item.rate.summary.date);
                    if (a.item.rate.start_date) {
                        var d = $.datepicker.parseDate("yymmdd", a.item.rate.start_date),
                            f = $("#start_date");
                        f.hasClass("hdate") || !f.hasClass("hasDatepicker") ?
                            f.val($.datepicker.formatDate("yy-mm-dd", d)) : f.datepicker("setDate", d)
                    }
                    a.item.rate.end_date && (d = $.datepicker.parseDate("yymmdd", a.item.rate.end_date), f = $("#end_date"), "N" == a.item.unit && d.setDate(d.getDate() + 1), f.hasClass("hdate") || !f.hasClass("hasDatepicker") ? f.val($.datepicker.formatDate("yy-mm-dd", d)) : f.datepicker("setDate", d));
                    if ("TS" === a.item.unit) $("#timeslot").html(a.ui.times.timeslots).selectpicker("refresh").selectpicker("val", a.item.timeslot), $("#cf-timeslots").html(a.ui.times.timeslots).find('input[value="' +
                        a.item.timeslot + '"]').prop("checked", !0).parent().addClass("active"), a.item.rate.slip || a.item.rate.error || c || null !== $("#timeslot").val() || h({
                        ui_date: 1,
                        ui_param: 1
                    }, function() {
                        $("#cf-ui-date, #cf-ui-param").fadeIn()
                    }, !0);
                    else if (a.ui.times && ($("#cf-start_time").html(a.ui.times.start), $("#cf-end_time").html(a.ui.times.end), $("select.cf-time-val").selectpicker("refresh"), $(".cf-time").find("input[name=end_time]").val(a.item.end_time).end().find("input[name=start_time]").val(a.item.start_time), !(a.item.rate.slip ||
                            a.query.start_time || a.item.rate.error || c))) {
                        h({
                            ui_date: 1,
                            ui_param: 1
                        }, function() {
                            $("#cf-ui-date, #cf-ui-param").fadeIn()
                        }, !0);
                        return
                    }
                    $(".cf-item-form #date_id").val("");
                    d = "AVAILABLE" == a.item.rate.status ? "check" : "calendar-o";
                    $(".cf-item-available").html('<span class="' + a.item.rate.status + '"><i class="fa fa-' + d + '"></i> ' + a.item.rate.summary.title + "</span>");
                    a.item.rate.summary.span_desc ? $("#event_span").html(a.item.rate.summary.span_desc) : $("#event_span").html();
                    if ("AVAILABLE" != a.item.rate.status) {
                        $("#sub_btn").prop("disabled", !0);
                        f = $(".children.selectpicker").selectpicker("val");
                        if (f == a.item.item_id || null == f) $(".child.selectpicker option:selected").selectpicker("val", a.item.item_id), $("#child_label").html("<span class='child-danger label label-danger'><i class='fa fa-" + d + "'></i> " + a.item.rate.summary.title + "</span>"), $("select.child").selectpicker("setStyle", "btn-success", "remove").selectpicker("setStyle", "btn-danger").selectpicker("refresh");
                        a.item.rate.error && alert_msg('<p class="alert alert-danger"><i class="fa fa-warning"></i> ' +
                            a.item.rate.error.title + "</p>", ".cf-rate-info")
                    } else a.item.rate.slip && $("#sub_btn").prop("disabled", !1), $(".child.selectpicker option:selected").selectpicker("val", a.item.item_id), $("#child_label").html("<span class='child-success label label-success'><i class='fa fa-" + d + "'></i> " + a.item.rate.summary.title + "</span>"), $("select.child").selectpicker("setStyle", "btn-danger", "remove").selectpicker("setStyle", "btn-success").selectpicker("refresh"), a.item.rate && (d = "", a.item.rate.summary.date && (d += a.item.rate.summary.date +
                        ":"), 0 < parseFloat(a.item.rate.summary.price.total.replace(/[^0-9\-\.]/g, "")) && (d += "<b>" + a.item.rate.summary.price.total + "</b>"), a.item.rate.summary.details && (d = d + ' <span class="cf-more"><i class="fa fa-question-circle"></i></span>' + ('<div class="cf-more-pop">' + a.item.rate.summary.details + "</div>")), alert_msg(d, ".cf-rate-info"), $(".cf-param-price").html(""), $.each(a.item.rate.summary.price.param, function(b, c) {
                        $("#cf-param-price_" + b).html((a.item.gprice[b] ? " @ " : " x ") + c)
                    })), cf_more_hoverize();
                    $("#cf-item-book").hasClass("active") ||
                        $(".cf-rate-info").hide();
                    $(".cf-item-load").hide();
                    $("#discount_code");
                    $("#discount_code").val() ? a.item.discount && a.item.discount.code ? ("B" == a.item.discount.type && $("#discount_status_flat").show(), $("#promo").prop("class", "discount-ok"), $("#discount_apply").hide(), $("#discount_status_error").hide(), $(".cf-item-continue").show(), $("#discount_code").blur()) : ($("#discount_status_flat").hide(), $("#discount_status_error").show(), $("#promo").prop("class", "discount-err form-group"), $(".cf-item-continue").show()) :
                        ($("#promo").hide(), $(".cf-add-discount").show());
                    "function" == typeof b && b();
                    set_pipe()
                } else $("#cf-item-action .conf").hide()
            }
        })
    }

    function m() {
        var a = $(".jumbotron"),
            b = $("#cf-category-grid");
        b.length && ($("#cf-items").html(""), $(".back-to-categories-btn").fadeIn());
        1 == t.inline || a.hasClass("view-full") || (a = $("#content").offset().top, $(window).scrollTop() > a && window.scrollTo(0, Math.max(0, a - 60)));
        $(".cf-info").hide();
        $("#cf_title").hide();
        $("#pload").show().css("top", "-10px");
        $(".cf-items").addClass("load");
        $(".cf-item-list").css("opacity", .3);
        xhr && 4 != xhr.readyState && xhr.abort();
        xhr = $.ajax({
            type: "GET",
            data: $("#cf-query").serialize(),
            url: $("#cf-query").attr("action") + "/inventory/",
            error: function(a, b) {
                "abort" != b && ($(".cf-items").removeClass("load"), $("#pload").html('<p class="alert alert-warning"><i class="fa fa-warning"></i> Error - please <a href="#" onclick="javascript:window.document.location.reload(true); return false;">try again</a> shortly</p>'))
            },
            success: function(a, e) {
                $("#pload").hide().css("top",
                    "13px");
                $("#cf-date").html(a.date_str);
                $("#cf_title").show();
                $("#cf-items").html(a.inventory).trigger("inventory_loaded");
                var g = $("#cf-query-keyword").val(),
                    h = $(".grid.cf-item-data"),
                    k = h.find(".grid-description, .grid-title-only"),
                    n = h.first().children(".row");
                resize_grid_heights = function() {
                    if (730 > $(window).width()) h.css("min-height", "initial");
                    else {
                        var a = 0;
                        k.each(function() {
                            $(this).outerHeight(!0) > a && (a = $(this).outerHeight(!0))
                        });
                        h.css("min-height", a + n.height())
                    }
                };
                b.length && g && g.length && b.fadeOut(function() {
                    $("#cf-items").fadeIn("slow",
                        function() {
                            resize_grid_heights();
                            set_pipe()
                        });
                    $("#cf-show-category").fadeIn("slow")
                });
                a.calendar && $("#cf-cal").html(a.calendar);
                $(".udate").click(function(a) {
                    if ($(a.target) == $(this) || !$(a.target).is("a")) return $("#cf-show-upcoming").show().attr("data-start_date", $("#alt_cf-query-start_date").val()).attr("data-end_date", $("#alt_cf-query-end_date").val()), $(".cf-cal-sm").addClass("load"), $("#date").val($(this).data("date")), m(), !1
                });
                $("#cat_back").click(function() {
                    $("#category_id").val("I");
                    m();
                    return !1
                });
                u();
                $("#cf-items").find(".set_category_id").click(function() {
                    this.hash.replace("#", "");
                    $("#category_id").val(this.hash.replace("#", ""));
                    $(this).blur();
                    m();
                    return !1
                });
                if (a.start_date) {
                    var g = $.datepicker.parseDate("yy-mm-dd", a.start_date),
                        p = $("#cf-query-start_date");
                    p.hasClass("hdate") || !p.hasClass("hasDatepicker") ? p.val(a.start_date) : p.datepicker("setDate", g)
                }
                a.end_date && (g = $.datepicker.parseDate("yy-mm-dd", a.end_date), p = $("#cf-query-end_date"), p.hasClass("hdate") || !p.hasClass("hasDatepicker") ? p.val(a.end_date) :
                    p.datepicker("setDate", g));
                g = getDateJS("cf-query-start_date");
                f(g.getFullYear(), g.getMonth(), 2);
                $(".cf-item-data").click(function(a) {
                    skinny && d($(this).find(".cf-item-info .cf-item-action a:first"))
                });
                $(window).resize(resize_grid_heights);
                resize_grid_heights();
                $(".cf-item-action a").click(function(a) {
                    d($(this));
                    return !1
                });
                $("#cf-items").removeClass("dim load");
                set_pipe()
            }
        })
    }
    var k = $(".end_date"),
        y = $(".start_date"),
        n = $(".search-input"),
        q = $(".cat-dropdown");
    k.length || q.length || n.length || (y.css("width",
        "100%"), $(".start_date #cf-query-start_date").css("border-top-right-radius", "4px").css("border-bottom-right-radius", "4px"));
    (k.length || q.length || n.length) && $("#cf-query-start_date").css("border-top-right-radius", "0").css("border-bottom-right-radius", "0");
    k.length && q.length && $("#cf-query-keyword").length && ($(".cat-dropdown button").css("border-top-left-radius", "4px").css("border-bottom-left-radius", "4px"), $(".cat-dropdown button").css("border-top-right-radius", "0px").css("border-bottom-right-radius",
        "0px"), n.css("width", "50%"));
    k.length || q.length || !n.length || (y.css("width", "50%"), $(".start_date #cf-query-start_date").css("border-top-right-radius", "0").css("border-bottom-right-radius", "0"));
    k.length && !$("#cf-query-keyword").length && (q.css("width", "100%"), $(".cat-dropdown button").css("border-top-right-radius", "4px").css("border-bottom-right-radius", "4px"));
    $(".hdate").length && ((!k.length && !q.length || !k.length && $("#cf-query-keyword").length) && $("#cf-query-keyword").css("border-top-left-radius",
        "0").css("border-bottom-left-radius", "0"), !k.length && q.length && n.length && n.css("width", "100%"), k.length || q.length || !n.length || n.css("width", "50%"));
    $(".end_date #cf-query-end_date").css("border-top-left-radius", "0").css("border-bottom-left-radius", "0");
    $("#dialog").on("hidden.bs.modal", function() {
        $(".cf-time-val").remove()
    });
    $(window).scroll(function() {
        var a = $("#sidebar-wrapper");
        $(window).scrollTop() >= $(".main-navigation").height() + $("#booking_intro").outerHeight() ? a.addClass("dock") : a.removeClass("dock")
    });
    $(".view-full").hasClass("video") && setTimeout(function() {
        $(".imageOverlay").fadeOut("slow")
    }, 4500);
    var t = function() {
        for (var a = location.href, a = a.substring(a.indexOf("?") + 1).split("&"), b = 0, c = {}; b < a.length; b++) a[b] = a[b].split("="), c[a[b][0]] = decodeURIComponent(a[b][1]);
        return c
    }();
    if (1 != t.inline) {
        var w = $("#cf-query"),
            z = $(".mobi"),
            F = w.position() || [];
        $(window).scroll(function() {
            $(window).scrollTop() >= F.top ? (w.addClass("stick"), z.addClass("mobi-stick"), $(".sticky-show").show()) : (w.removeClass("stick"),
                z.removeClass("mobi-stick"), $(".sticky-show").hide())
        })
    }
    $("#is_new_booking").val() && sessionStorage_is_allowed() && sessionStorage_clear_prefix("bf-");
    if (0 < t.popup) {
        var G = t.item_id ? t.item_id : t.popup;
        $("body").one("inventory_loaded", "#cf-items", function() {
            d(!1, "#" + G + "@book@", !0)
        })
    }
    $(".sticky-show").hide();
    $(window).resize(check_size).trigger("resize");
    $("#cf-query").submit(function() {
        m();
        return !1
    });
    u();
    $("#cf-tabs a").click(function() {
        var a = this.hash.replace("#", "");
        $(".cf-tab").removeClass("active");
        $("#cf-tab" + a).addClass("active");
        $("#category_id").val(this.hash.replace("#", ""));
        $(this).blur();
        m();
        return !1
    });
    0 < $("#cf-category-grid").length && $("#cf-items").hide();
    $("#cf-show-category").hide();
    $("#cf-category-grid a").click(function() {
        this.hash.replace("#", "");
        $("#category_id").val(this.hash.replace("#", ""));
        m();
        $("#cf-category-grid").fadeOut(function() {
            $("#cf-items").fadeIn("slow", function() {
                "function" === typeof resize_grid_heights && resize_grid_heights();
                set_pipe()
            });
            $("#cf-show-category").fadeIn("slow");
            $(window).scrollTop($("#cf-show-category").offset().top - 100)
        });
        return !1
    });
    $("figure").bind("touchstart", function() {});
    $("#cf-show-category").click(function() {
        $("#category_id").val(0);
        $("#cf-items").fadeOut(function() {
            $("#cf-category-grid").fadeIn("slow", set_pipe);
            $("#cf-show-category").fadeOut("slow")
        });
        return !1
    });
    $("#cf-query-keyword").focus(function() {
        $(".cf-query-keyword").addClass("fa fa-level-down fa-rotate-90")
    }).blur(function() {
        $(".cf-query-keyword").removeClass("fa-level-down")
    });
    $("#cf-query :input").change(function() {
        if ("cf-query-start_date" ==
            $(this).prop("id") && $("#cf-query-end_date").length) {
            var a = $("#alt_cf-query-start_date"),
                b = $("#alt_cf-query-end_date"),
                c = $("#cf-query-end_date");
            void 0 === b.val() && "hidden" === c.attr("type") && c.val(a.val());
            b.val() < a.val() && (c.hasClass("hdate") ? c.val(a.val()) : (a = $.datepicker.parseDate("yy-mm-dd", a.val()), c.datepicker("setDate", a).datepicker("refresh")))
        }
        m()
    });
    $(".date").datepicker({
        firstDay: parseInt($("#start_dow").val(), 10),
        numberOfMonths: skinny ? 1 : 2,
        showButtonPanel: !0,
        dateFormat: $("#date_format").val(),
        altFormat: "yy-mm-dd",
        beforeShow: function(a, b) {
            var c = skinny ? 1 : 2,
                d = getDateJS(a.id);
            f(d.getFullYear(), d.getMonth() + c, c);
            return {
                numberOfMonths: c
            }
        },
        beforeShowDay: function(a) {
            var b = format_YMD(a);
            a = a < today ? 0 : search_dates[b];
            b = "";
            void 0 !== a && (b = 0 < a ? "A" : "X");
            return [1, b]
        },
        onChangeMonthYear: function(a, b, c) {
            b = 0 === c.lastMonth && 11 === c.drawMonth && 12 === b ? b - 2 : 11 == c.lastMonth && 0 === c.drawMonth && 1 === b ? b + 1 : b > c.lastMonth ? b + 1 : b - 2;
            c.lastMonth = c.drawMonth;
            f(a, b, 1)
        }
    }).each(function() {
        if ($(this).data("alt")) {
            var a = $(this).data("alt"),
                b = $.datepicker.parseDate("yy-mm-dd", $(a).val());
            $(this).datepicker("setDate", b).datepicker("option", "altField", a).datepicker("refresh")
        }
    });
    $(".cf-view").click(function() {
        var a = this.hash.replace("#", "");
        $(this).css("opacity");
        $("#cf-query-view").val(a);
        $(".cf-view").removeClass("active");
        $(this).addClass("active");
        $("#cf-query").submit();
        return !1
    });
    "item" == $("#cf-init").val() ? (d(0, "#" + $("#item_id").val() + "@book"), $("#dialog").modal({
            backdrop: "static",
            keyboard: !1
        })) : 0 < $("#cf-items").length && !$("#force_login").val() &&
        (0 < $("#cf-category-grid").length ? (k = getDateJS("cf-query-start_date"), f(k.getFullYear(), k.getMonth(), 2)) : m());
    setup_item_modal = function() {
        var a;
        $("#child_item_id").length && (a = $("#child_item_id").val(), $(".children-cal.selectpicker, .children.selectpicker").selectpicker("val", a), $("#cf-ui-date, #cf-ui-param").hide(), h({
            ui_date: 1,
            ui_param: 1
        }, function() {
            $("#cf-ui-date, #cf-ui-param").fadeIn()
        }), $(".children.selectpicker").selectpicker().change(function(b) {
            a = $(this).selectpicker("val");
            $(".children-cal.selectpicker").selectpicker("val",
                a);
            $("#child_item_id").val(a);
            $("#timeslot").val(0);
            $("#cf-timeslots").find('input[value="0"]').prop("checked", !0).parent().addClass("active");
            h({
                ui_date: 1,
                ui_param: 1
            })
        }), $(".children-cal.selectpicker").selectpicker().change(function(b) {
            a = $(this).selectpicker("val");
            $(".children.selectpicker").selectpicker("val", a);
            $("#child_item_id").val(a);
            set_tab(".cf-item-cal");
            h({
                ui_date: 1,
                ui_param: 1
            })
        }));
        v(a);
        $("#delivery_date") && C();
        $(".cf-item-photo-action a").click(function() {
            var a = this.hash.replace("#",
                "");
            $(".cf-item-thumbs a").removeClass("active");
            $("#item-photo").css("background-image", "url('/media/L" + a + ".jpg')");
            $(".cf-item-photo-action a").removeClass("active");
            $(this).addClass("active");
            (a = $(this).prop("title")) ? $("#photo-title").html(a).show(): $("#photo-title").hide();
            return !1
        });
        $(".cf-action, .cf-item-action").find("a").removeClass("load");
        D();
        $("#dialog").modal("show").removeClass("customer-login-modal");
        2 == $("#cf-start_time, #cf-end_time").length && h();
        $("#cf-item-set").submit(function() {
            return submit_item_modal($(this))
        });
        cf_more_hoverize()
    };
    $("#cf-show-upcoming").on("click", function() {
        var a = $.datepicker.parseDate("yy-mm-dd", $(this).data("start_date")),
            b = $("#cf-query-start_date");
        b.hasClass("hdate") ? b.val($(this).data("start_date")) : b.datepicker("setDate", a).datepicker("refresh");
        $(this).data("end_date") ? (a = $.datepicker.parseDate("yy-mm-dd", $(this).data("end_date")), b = $("#cf-query-end_date"), b.hasClass("hdate") ? b.val($(this).data("end_date")) : b.datepicker("setDate", a).datepicker("refresh")) : $("#cf-query-end_date").val("");
        $(this).hide();
        m()
    });
    set_tab = function(a) {
        $(".cf-item-panel").hide();
        $(".cf-item-continue").show();
        $(".child-select").hide();
        $(".cf-tab li").removeClass("active");
        var b = a.replace(".", "#"),
            c = $(a);
        $(b).addClass("active");
        0 < $("#child_item_id").length && $(".cf-item h2").addClass("col-sm-12").removeClass("col-sm-6");
        ".cf-item-cal" == a && ($(".child-select").show(), 0 < $("#child_item_id").length && $(".cf-item h2").addClass("col-sm-6").removeClass("col-sm-12"), x());
        ".cf-item-map" == a && ("undefined" == typeof google ?
            $.getScript("https://maps.googleapis.com/maps/api/js?sensor=false&callback=initMap&async=2&key=" + $("#map").data("key")) : $("#map").data("set") || initMap());
        ".cf-item-book" == a ? ($(".cf-rate-info").show(), 0 < $("#child_item_id").length && $(".cf-item h2").addClass("col-sm-12").removeClass("col-sm-6"), "out" == $("#opt").val() ? $("#sub_btn").text($("#sub_btn").data("text-add")) : $("#line_id").val() ? $("#sub_btn").text($("#sub_btn").data("text-update")) : $("#sub_btn").text($("#sub_btn").data("text-continue"))) : ($(".cf-rate-info").hide(),
            $(".cf-time-val.open").removeClass("open"), $("#sub_btn").text($("#sub_btn").data("text-continue")));
        c.fadeIn("fast");
        $(".panel-action").hide();
        $(a + "-action").fadeIn("fast");
        set_pipe()
    };
    gc_template_selection()
});



function getDateJS(e) {
    var f = $("#alt_" + e),
        d = "";
    if (d = 0 < f.length ? f.val() : $("#" + e).val()) return $.datepicker.parseDate("yy-mm-dd", d)
}

function getDateYMD(e, f) {
    var d = getDateJS(e);
    if (!d) return "";
    f && d.setDate(d.getDate() + f);
    return $.datepicker.formatDate("yymmdd", d)
};