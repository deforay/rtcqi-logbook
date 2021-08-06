/*!
 * Jasny Bootstrap v3.2.0 (http://jasny.github.io/bootstrap)
 * Copyright 2012-2019 Arnold Daniels
 * Licensed under  ()
 */
+
function(a) {
    "use strict";
    var b = "Microsoft Internet Explorer" == window.navigator.appName,
        c = function(b, d) { if (this.$element = a(b), this.options = a.extend({}, c.DEFAULTS, d), this.$input = this.$element.find(":file"), 0 !== this.$input.length) { this.name = this.$input.attr("name") || d.name, this.$hidden = this.$element.find('input[type=hidden][name="' + this.name + '"]'), 0 === this.$hidden.length && (this.$hidden = a('<input type="hidden">').insertBefore(this.$input)), this.$preview = this.$element.find(".fileinput-preview"); var e = this.$preview.css("height"); "inline" !== this.$preview.css("display") && "0px" !== e && "none" !== e && this.$preview.css("line-height", e), this.original = { exists: this.$element.hasClass("fileinput-exists"), preview: this.$preview.html(), hiddenVal: this.$hidden.val() }, this.listen(), this.reset() } };
    c.DEFAULTS = { clearName: !0 }, c.prototype.listen = function() { this.$input.on("change.bs.fileinput", a.proxy(this.change, this)), a(this.$input[0].form).on("reset.bs.fileinput", a.proxy(this.reset, this)), this.$element.find('[data-trigger="fileinput"]').on("click.bs.fileinput", a.proxy(this.trigger, this)), this.$element.find('[data-dismiss="fileinput"]').on("click.bs.fileinput", a.proxy(this.clear, this)) }, c.prototype.verifySizes = function(a) { if (void 0 === this.options.maxSize) return !0; var b = parseFloat(this.options.maxSize); if (b !== this.options.maxSize) return !0; for (var c = 0; c < a.length; c++) { var d = void 0 !== a[c].size ? a[c].size : null; if (null !== d && (d = d / 1e3 / 1e3) > b) return !1 } return !0 }, c.prototype.change = function(b) {
        var c = void 0 === b.target.files ? b.target && b.target.value ? [{ name: b.target.value.replace(/^.+\\/, "") }] : [] : b.target.files;
        if (b.stopPropagation(), 0 === c.length) return this.clear(), void this.$element.trigger("clear.bs.fileinput");
        if (!this.verifySizes(c)) return this.$element.trigger("max_size.bs.fileinput"), this.clear(), void this.$element.trigger("clear.bs.fileinput");
        this.$hidden.val(""), this.$hidden.attr("name", ""), this.$input.attr("name", this.name);
        var d = c[0];
        if (this.$preview.length > 0 && (void 0 !== d.type ? d.type.match(/^image\/(gif|png|jpeg|svg\+xml)$/) : d.name.match(/\.(gif|png|jpe?g|svg)$/i)) && "undefined" != typeof FileReader) {
            var e = this,
                f = new FileReader,
                g = this.$preview,
                h = this.$element;
            f.onload = function(b) {
                var f = a("<img>");
                if (f[0].src = b.target.result, c[0].result = b.target.result, h.find(".fileinput-filename").text(d.name), "none" != g.css("max-height")) {
                    var i = parseInt(g.css("max-height"), 10) || 0,
                        j = parseInt(g.css("padding-top"), 10) || 0,
                        k = parseInt(g.css("padding-bottom"), 10) || 0,
                        l = parseInt(g.css("border-top"), 10) || 0,
                        m = parseInt(g.css("border-bottom"), 10) || 0;
                    f.css("max-height", i - j - k - l - m)
                }
                g.html(f), e.options.exif && e.setImageTransform(f, d), h.addClass("fileinput-exists").removeClass("fileinput-new"), h.trigger("change.bs.fileinput", c)
            }, f.readAsDataURL(d)
        } else {
            var i = d.name,
                j = this.$element.find(".fileinput-filename");
            c.length > 1 && (i = a.map(c, function(a) { return a.name }).join(", ")), j.text(i), this.$preview.text(d.name), this.$element.addClass("fileinput-exists").removeClass("fileinput-new"), this.$element.trigger("change.bs.fileinput")
        }
    }, c.prototype.setImageTransform = function(a, b) {
        var c = this,
            d = new FileReader;
        d.onload = function(b) {
            var e = new DataView(d.result),
                f = c.getImageExif(e);
            f && c.resetOrientation(a, f)
        }, d.readAsArrayBuffer(b)
    }, c.prototype.getImageExif = function(a) {
        if (65496 != a.getUint16(0, !1)) return -2;
        for (var b = a.byteLength, c = 2; c < b;) {
            var d = a.getUint16(c, !1);
            if (c += 2, 65505 == d) {
                if (1165519206 != a.getUint32(c += 2, !1)) return -1;
                var e = 18761 == a.getUint16(c += 6, !1);
                c += a.getUint32(c + 4, e);
                var f = a.getUint16(c, e);
                c += 2;
                for (var g = 0; g < f; g++)
                    if (274 == a.getUint16(c + 12 * g, e)) return a.getUint16(c + 12 * g + 8, e)
            } else {
                if (65280 != (65280 & d)) break;
                c += a.getUint16(c, !1)
            }
        }
        return -1
    }, c.prototype.resetOrientation = function(a, b) {
        var c = new Image;
        c.onload = function() {
            var d = c.width,
                e = c.height,
                f = document.createElement("canvas"),
                g = f.getContext("2d");
            switch ([5, 6, 7, 8].indexOf(b) > -1 ? (f.width = e, f.height = d) : (f.width = d, f.height = e), b) {
                case 2:
                    g.transform(-1, 0, 0, 1, d, 0);
                    break;
                case 3:
                    g.transform(-1, 0, 0, -1, d, e);
                    break;
                case 4:
                    g.transform(1, 0, 0, -1, 0, e);
                    break;
                case 5:
                    g.transform(0, 1, 1, 0, 0, 0);
                    break;
                case 6:
                    g.transform(0, 1, -1, 0, e, 0);
                    break;
                case 7:
                    g.transform(0, -1, -1, 0, e, d);
                    break;
                case 8:
                    g.transform(0, -1, 1, 0, 0, d);
                    break;
                default:
                    g.transform(1, 0, 0, 1, 0, 0)
            }
            g.drawImage(c, 0, 0), a.attr("src", f.toDataURL())
        }, c.src = a.attr("src")
    }, c.prototype.clear = function(a) {
        if (a && a.preventDefault(), this.$hidden.val(""), this.$hidden.attr("name", this.name), this.options.clearName && this.$input.attr("name", ""), b) {
            var c = this.$input.clone(!0);
            this.$input.after(c), this.$input.remove(), this.$input = c
        } else this.$input.val("");
        this.$preview.html(""), this.$element.find(".fileinput-filename").text(""), this.$element.addClass("fileinput-new").removeClass("fileinput-exists"), void 0 !== a && (this.$input.trigger("change"), this.$element.trigger("clear.bs.fileinput"))
    }, c.prototype.reset = function() { this.clear(), this.$hidden.val(this.original.hiddenVal), this.$preview.html(this.original.preview), this.$element.find(".fileinput-filename").text(""), this.original.exists ? this.$element.addClass("fileinput-exists").removeClass("fileinput-new") : this.$element.addClass("fileinput-new").removeClass("fileinput-exists"), this.$element.trigger("reseted.bs.fileinput") }, c.prototype.trigger = function(a) { this.$input.trigger("click"), a.preventDefault() };
    var d = a.fn.fileinput;
    a.fn.fileinput = function(b) {
        return this.each(function() {
            var d = a(this),
                e = d.data("bs.fileinput");
            e || d.data("bs.fileinput", e = new c(this, b)), "string" == typeof b && e[b]()
        })
    }, a.fn.fileinput.Constructor = c, a.fn.fileinput.noConflict = function() { return a.fn.fileinput = d, this }, a(document).on("click.fileinput.data-api", '[data-provides="fileinput"]', function(b) {
        var c = a(this);
        if (!c.data("bs.fileinput")) {
            c.fileinput(c.data());
            var d = a(b.target).closest('[data-dismiss="fileinput"],[data-trigger="fileinput"]');
            d.length > 0 && (b.preventDefault(), d.trigger("click.bs.fileinput"))
        }
    })
}(window.jQuery);