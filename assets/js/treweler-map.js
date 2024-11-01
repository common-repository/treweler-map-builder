/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./node_modules/a-color-picker/dist/acolorpicker.js":
/*!**********************************************************!*\
  !*** ./node_modules/a-color-picker/dist/acolorpicker.js ***!
  \**********************************************************/
/***/ (function(module) {

/*!
 * a-color-picker (https://github.com/narsenico/a-color-picker)
 * 
 * Copyright (c) 2017-2018, Gianfranco Caldi.
 * Released under the MIT License.
 */
!function (e, t) {
   true ? module.exports = t() : 0;
}("undefined" != typeof self ? self : this, function () {
  return function (e) {
    var t = {};

    function r(i) {
      if (t[i]) return t[i].exports;
      var o = t[i] = {
        i: i,
        l: !1,
        exports: {}
      };
      return e[i].call(o.exports, o, o.exports, r), o.l = !0, o.exports;
    }

    return r.m = e, r.c = t, r.d = function (e, t, i) {
      r.o(e, t) || Object.defineProperty(e, t, {
        enumerable: !0,
        get: i
      });
    }, r.r = function (e) {
      "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, {
        value: "Module"
      }), Object.defineProperty(e, "__esModule", {
        value: !0
      });
    }, r.t = function (e, t) {
      if (1 & t && (e = r(e)), 8 & t) return e;
      if (4 & t && "object" == typeof e && e && e.__esModule) return e;
      var i = Object.create(null);
      if (r.r(i), Object.defineProperty(i, "default", {
        enumerable: !0,
        value: e
      }), 2 & t && "string" != typeof e) for (var o in e) r.d(i, o, function (t) {
        return e[t];
      }.bind(null, o));
      return i;
    }, r.n = function (e) {
      var t = e && e.__esModule ? function () {
        return e.default;
      } : function () {
        return e;
      };
      return r.d(t, "a", t), t;
    }, r.o = function (e, t) {
      return Object.prototype.hasOwnProperty.call(e, t);
    }, r.p = "", r(r.s = 1);
  }([function (e, t, r) {
    "use strict";
    /*!
     * is-plain-object <https://github.com/jonschlinkert/is-plain-object>
     *
     * Copyright (c) 2014-2017, Jon Schlinkert.
     * Released under the MIT License.
     */

    var i = r(3);

    function o(e) {
      return !0 === i(e) && "[object Object]" === Object.prototype.toString.call(e);
    }

    e.exports = function (e) {
      var t, r;
      return !1 !== o(e) && "function" == typeof (t = e.constructor) && !1 !== o(r = t.prototype) && !1 !== r.hasOwnProperty("isPrototypeOf");
    };
  }, function (e, t, r) {
    "use strict";

    Object.defineProperty(t, "__esModule", {
      value: !0
    }), t.VERSION = t.PALETTE_MATERIAL_CHROME = t.PALETTE_MATERIAL_500 = t.COLOR_NAMES = t.getLuminance = t.intToRgb = t.rgbToInt = t.rgbToHsv = t.rgbToHsl = t.hslToRgb = t.rgbToHex = t.parseColor = t.parseColorToHsla = t.parseColorToHsl = t.parseColorToRgba = t.parseColorToRgb = t.from = t.createPicker = void 0;

    var i = function () {
      function e(e, t) {
        for (var r = 0; r < t.length; r++) {
          var i = t[r];
          i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i);
        }
      }

      return function (t, r, i) {
        return r && e(t.prototype, r), i && e(t, i), t;
      };
    }(),
        o = function (e, t) {
      if (Array.isArray(e)) return e;
      if (Symbol.iterator in Object(e)) return function (e, t) {
        var r = [],
            i = !0,
            o = !1,
            n = void 0;

        try {
          for (var s, a = e[Symbol.iterator](); !(i = (s = a.next()).done) && (r.push(s.value), !t || r.length !== t); i = !0);
        } catch (e) {
          o = !0, n = e;
        } finally {
          try {
            !i && a.return && a.return();
          } finally {
            if (o) throw n;
          }
        }

        return r;
      }(e, t);
      throw new TypeError("Invalid attempt to destructure non-iterable instance");
    },
        n = r(2),
        s = l(r(0)),
        a = l(r(4));

    function l(e) {
      return e && e.__esModule ? e : {
        default: e
      };
    }

    function c(e, t) {
      if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
    }

    function u(e) {
      if (Array.isArray(e)) {
        for (var t = 0, r = Array(e.length); t < e.length; t++) r[t] = e[t];

        return r;
      }

      return Array.from(e);
    }
    /*!
     * a-color-picker
     * https://github.com/narsenico/a-color-picker
     *
     * Copyright (c) 2017-2019, Gianfranco Caldi.
     * Released under the MIT License.
     */


    var h = "undefined" != typeof window && window.navigator.userAgent.indexOf("Edge") > -1,
        p = "undefined" != typeof window && window.navigator.userAgent.indexOf("rv:") > -1,
        d = {
      id: null,
      attachTo: "body",
      showHSL: !0,
      showRGB: !0,
      showHEX: !0,
      showAlpha: !1,
      color: "#ff0000",
      palette: null,
      paletteEditable: !1,
      useAlphaInPalette: "auto",
      slBarSize: [232, 150],
      hueBarSize: [150, 11],
      alphaBarSize: [150, 11]
    },
        f = "COLOR",
        g = "RGBA_USER",
        b = "HSLA_USER";

    function v(e, t, r) {
      return e ? e instanceof HTMLElement ? e : e instanceof NodeList ? e[0] : "string" == typeof e ? document.querySelector(e) : e.jquery ? e.get(0) : r ? t : null : t;
    }

    function m(e) {
      var t = e.getContext("2d"),
          r = +e.width,
          i = +e.height,
          s = t.createLinearGradient(1, 1, 1, i - 1);
      return s.addColorStop(0, "white"), s.addColorStop(1, "black"), {
        setHue: function (e) {
          var o = t.createLinearGradient(1, 0, r - 1, 0);
          o.addColorStop(0, "hsla(" + e + ", 100%, 50%, 0)"), o.addColorStop(1, "hsla(" + e + ", 100%, 50%, 1)"), t.fillStyle = s, t.fillRect(0, 0, r, i), t.fillStyle = o, t.globalCompositeOperation = "multiply", t.fillRect(0, 0, r, i), t.globalCompositeOperation = "source-over";
        },
        grabColor: function (e, r) {
          return t.getImageData(e, r, 1, 1).data;
        },
        findColor: function (e, t, s) {
          var a = (0, n.rgbToHsv)(e, t, s),
              l = o(a, 3),
              c = l[1],
              u = l[2];
          return [c * r, i - u * i];
        }
      };
    }

    function A(e, t, r) {
      return null === e ? t : /^\s*$/.test(e) ? r : !!/true|yes|1/i.test(e) || !/false|no|0/i.test(e) && t;
    }

    function y(e, t, r) {
      if (null === e) return t;
      if (/^\s*$/.test(e)) return r;
      var i = e.split(",").map(Number);
      return 2 === i.length && i[0] && i[1] ? i : t;
    }

    var k = function () {
      function e(t, r) {
        if (c(this, e), r ? (t = v(t), this.options = Object.assign({}, d, r)) : t && (0, s.default)(t) ? (this.options = Object.assign({}, d, t), t = v(this.options.attachTo)) : (this.options = Object.assign({}, d), t = v((0, n.nvl)(t, this.options.attachTo))), !t) throw new Error("Container not found: " + this.options.attachTo);
        !function (e, t) {
          var r = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : "acp-";

          if (t.hasAttribute(r + "show-hsl") && (e.showHSL = A(t.getAttribute(r + "show-hsl"), d.showHSL, !0)), t.hasAttribute(r + "show-rgb") && (e.showRGB = A(t.getAttribute(r + "show-rgb"), d.showRGB, !0)), t.hasAttribute(r + "show-hex") && (e.showHEX = A(t.getAttribute(r + "show-hex"), d.showHEX, !0)), t.hasAttribute(r + "show-alpha") && (e.showAlpha = A(t.getAttribute(r + "show-alpha"), d.showAlpha, !0)), t.hasAttribute(r + "palette-editable") && (e.paletteEditable = A(t.getAttribute(r + "palette-editable"), d.paletteEditable, !0)), t.hasAttribute(r + "sl-bar-size") && (e.slBarSize = y(t.getAttribute(r + "sl-bar-size"), d.slBarSize, [232, 150])), t.hasAttribute(r + "hue-bar-size") && (e.hueBarSize = y(t.getAttribute(r + "hue-bar-size"), d.hueBarSize, [150, 11]), e.alphaBarSize = e.hueBarSize), t.hasAttribute(r + "palette")) {
            var i = t.getAttribute(r + "palette");

            switch (i) {
              case "PALETTE_MATERIAL_500":
                e.palette = n.PALETTE_MATERIAL_500;
                break;

              case "PALETTE_MATERIAL_CHROME":
              case "":
                e.palette = n.PALETTE_MATERIAL_CHROME;
                break;

              default:
                e.palette = i.split(/[;|]/);
            }
          }

          t.hasAttribute(r + "color") && (e.color = t.getAttribute(r + "color"));
        }(this.options, t), this.H = 0, this.S = 0, this.L = 0, this.R = 0, this.G = 0, this.B = 0, this.A = 1, this.palette = {}, this.element = document.createElement("div"), this.options.id && (this.element.id = this.options.id), this.element.className = "a-color-picker", this.element.innerHTML = a.default, t.appendChild(this.element);
        var i = this.element.querySelector(".a-color-picker-h");
        this.setupHueCanvas(i), this.hueBarHelper = m(i), this.huePointer = this.element.querySelector(".a-color-picker-h+.a-color-picker-dot");
        var o = this.element.querySelector(".a-color-picker-sl");
        this.setupSlCanvas(o), this.slBarHelper = m(o), this.slPointer = this.element.querySelector(".a-color-picker-sl+.a-color-picker-dot"), this.preview = this.element.querySelector(".a-color-picker-preview"), this.setupClipboard(this.preview.querySelector(".a-color-picker-clipbaord")), this.options.showHSL ? (this.setupInput(this.inputH = this.element.querySelector(".a-color-picker-hsl>input[nameref=H]")), this.setupInput(this.inputS = this.element.querySelector(".a-color-picker-hsl>input[nameref=S]")), this.setupInput(this.inputL = this.element.querySelector(".a-color-picker-hsl>input[nameref=L]"))) : this.element.querySelector(".a-color-picker-hsl").remove(), this.options.showRGB ? (this.setupInput(this.inputR = this.element.querySelector(".a-color-picker-rgb>input[nameref=R]")), this.setupInput(this.inputG = this.element.querySelector(".a-color-picker-rgb>input[nameref=G]")), this.setupInput(this.inputB = this.element.querySelector(".a-color-picker-rgb>input[nameref=B]"))) : this.element.querySelector(".a-color-picker-rgb").remove(), this.options.showHEX ? this.setupInput(this.inputRGBHEX = this.element.querySelector("input[nameref=RGBHEX]")) : this.element.querySelector(".a-color-picker-rgbhex").remove(), this.options.paletteEditable || this.options.palette && this.options.palette.length > 0 ? this.setPalette(this.paletteRow = this.element.querySelector(".a-color-picker-palette")) : (this.paletteRow = this.element.querySelector(".a-color-picker-palette"), this.paletteRow.remove()), this.options.showAlpha ? (this.setupAlphaCanvas(this.element.querySelector(".a-color-picker-a")), this.alphaPointer = this.element.querySelector(".a-color-picker-a+.a-color-picker-dot")) : this.element.querySelector(".a-color-picker-alpha").remove(), this.element.style.width = this.options.slBarSize[0] + "px", this.onValueChanged(f, this.options.color);
      }

      return i(e, [{
        key: "setupHueCanvas",
        value: function (e) {
          var t = this;
          e.width = this.options.hueBarSize[0], e.height = this.options.hueBarSize[1];

          for (var r = e.getContext("2d"), i = r.createLinearGradient(0, 0, this.options.hueBarSize[0], 0), o = 0; o <= 1; o += 1 / 360) i.addColorStop(o, "hsl(" + 360 * o + ", 100%, 50%)");

          r.fillStyle = i, r.fillRect(0, 0, this.options.hueBarSize[0], this.options.hueBarSize[1]);

          var s = function (r) {
            var i = (0, n.limit)(r.clientX - e.getBoundingClientRect().left, 0, t.options.hueBarSize[0]),
                o = Math.round(360 * i / t.options.hueBarSize[0]);
            t.huePointer.style.left = i - 7 + "px", t.onValueChanged("H", o);
          },
              a = function e() {
            document.removeEventListener("mousemove", s), document.removeEventListener("mouseup", e);
          };

          e.addEventListener("mousedown", function (e) {
            s(e), document.addEventListener("mousemove", s), document.addEventListener("mouseup", a);
          });
        }
      }, {
        key: "setupSlCanvas",
        value: function (e) {
          var t = this;
          e.width = this.options.slBarSize[0], e.height = this.options.slBarSize[1];

          var r = function (r) {
            var i = (0, n.limit)(r.clientX - e.getBoundingClientRect().left, 0, t.options.slBarSize[0] - 1),
                o = (0, n.limit)(r.clientY - e.getBoundingClientRect().top, 0, t.options.slBarSize[1] - 1),
                s = t.slBarHelper.grabColor(i, o);
            t.slPointer.style.left = i - 7 + "px", t.slPointer.style.top = o - 7 + "px", t.onValueChanged("RGB", s);
          },
              i = function e() {
            document.removeEventListener("mousemove", r), document.removeEventListener("mouseup", e);
          };

          e.addEventListener("mousedown", function (e) {
            r(e), document.addEventListener("mousemove", r), document.addEventListener("mouseup", i);
          });
        }
      }, {
        key: "setupAlphaCanvas",
        value: function (e) {
          var t = this;
          e.width = this.options.alphaBarSize[0], e.height = this.options.alphaBarSize[1];
          var r = e.getContext("2d"),
              i = r.createLinearGradient(0, 0, e.width - 1, 0);
          i.addColorStop(0, "hsla(0, 0%, 50%, 0)"), i.addColorStop(1, "hsla(0, 0%, 50%, 1)"), r.fillStyle = i, r.fillRect(0, 0, this.options.alphaBarSize[0], this.options.alphaBarSize[1]);

          var o = function (r) {
            var i = (0, n.limit)(r.clientX - e.getBoundingClientRect().left, 0, t.options.alphaBarSize[0]),
                o = +(i / t.options.alphaBarSize[0]).toFixed(2);
            t.alphaPointer.style.left = i - 7 + "px", t.onValueChanged("ALPHA", o);
          },
              s = function e() {
            document.removeEventListener("mousemove", o), document.removeEventListener("mouseup", e);
          };

          e.addEventListener("mousedown", function (e) {
            o(e), document.addEventListener("mousemove", o), document.addEventListener("mouseup", s);
          });
        }
      }, {
        key: "setupInput",
        value: function (e) {
          var t = this,
              r = +e.min,
              i = +e.max,
              o = e.getAttribute("nameref");
          e.hasAttribute("select-on-focus") && e.addEventListener("focus", function () {
            e.select();
          }), "text" === e.type ? e.addEventListener("change", function () {
            t.onValueChanged(o, e.value);
          }) : ((h || p) && e.addEventListener("keydown", function (s) {
            "Up" === s.key ? (e.value = (0, n.limit)(+e.value + 1, r, i), t.onValueChanged(o, e.value), s.returnValue = !1) : "Down" === s.key && (e.value = (0, n.limit)(+e.value - 1, r, i), t.onValueChanged(o, e.value), s.returnValue = !1);
          }), e.addEventListener("change", function () {
            var s = +e.value;
            t.onValueChanged(o, (0, n.limit)(s, r, i));
          }));
        }
      }, {
        key: "setupClipboard",
        value: function (e) {
          var t = this;
          e.title = "click to copy", e.addEventListener("click", function () {
            e.value = (0, n.parseColor)([t.R, t.G, t.B, t.A], "hexcss4"), e.select(), document.execCommand("copy");
          });
        }
      }, {
        key: "setPalette",
        value: function (e) {
          var t = this,
              r = "auto" === this.options.useAlphaInPalette ? this.options.showAlpha : this.options.useAlphaInPalette,
              i = null;

          switch (this.options.palette) {
            case "PALETTE_MATERIAL_500":
              i = n.PALETTE_MATERIAL_500;
              break;

            case "PALETTE_MATERIAL_CHROME":
              i = n.PALETTE_MATERIAL_CHROME;
              break;

            default:
              i = (0, n.ensureArray)(this.options.palette);
          }

          if (this.options.paletteEditable || i.length > 0) {
            var o = function (r, i, o) {
              var n = e.querySelector('.a-color-picker-palette-color[data-color="' + r + '"]') || document.createElement("div");
              n.className = "a-color-picker-palette-color", n.style.backgroundColor = r, n.setAttribute("data-color", r), n.title = r, e.insertBefore(n, i), t.palette[r] = !0, o && t.onPaletteColorAdd(r);
            },
                s = function (r, i) {
              r ? (e.removeChild(r), t.palette[r.getAttribute("data-color")] = !1, i && t.onPaletteColorRemove(r.getAttribute("data-color"))) : (e.querySelectorAll(".a-color-picker-palette-color[data-color]").forEach(function (t) {
                e.removeChild(t);
              }), Object.keys(t.palette).forEach(function (e) {
                t.palette[e] = !1;
              }), i && t.onPaletteColorRemove());
            };

            if (i.map(function (e) {
              return (0, n.parseColor)(e, r ? "rgbcss4" : "hex");
            }).filter(function (e) {
              return !!e;
            }).forEach(function (e) {
              return o(e);
            }), this.options.paletteEditable) {
              var a = document.createElement("div");
              a.className = "a-color-picker-palette-color a-color-picker-palette-add", a.innerHTML = "+", e.appendChild(a), e.addEventListener("click", function (e) {
                /a-color-picker-palette-add/.test(e.target.className) ? e.shiftKey ? s(null, !0) : o(r ? (0, n.parseColor)([t.R, t.G, t.B, t.A], "rgbcss4") : (0, n.rgbToHex)(t.R, t.G, t.B), e.target, !0) : /a-color-picker-palette-color/.test(e.target.className) && (e.shiftKey ? s(e.target, !0) : t.onValueChanged(f, e.target.getAttribute("data-color")));
              });
            } else e.addEventListener("click", function (e) {
              /a-color-picker-palette-color/.test(e.target.className) && t.onValueChanged(f, e.target.getAttribute("data-color"));
            });
          } else e.style.display = "none";
        }
      }, {
        key: "updatePalette",
        value: function (e) {
          this.paletteRow.innerHTML = "", this.palette = {}, this.paletteRow.parentElement || this.element.appendChild(this.paletteRow), this.options.palette = e, this.setPalette(this.paletteRow);
        }
      }, {
        key: "onValueChanged",
        value: function (e, t) {
          var r = arguments.length > 2 && void 0 !== arguments[2] ? arguments[2] : {
            silent: !1
          };

          switch (e) {
            case "H":
              this.H = t;
              var i = (0, n.hslToRgb)(this.H, this.S, this.L),
                  s = o(i, 3);
              this.R = s[0], this.G = s[1], this.B = s[2], this.slBarHelper.setHue(t), this.updatePointerH(this.H), this.updateInputHSL(this.H, this.S, this.L), this.updateInputRGB(this.R, this.G, this.B), this.updateInputRGBHEX(this.R, this.G, this.B);
              break;

            case "S":
              this.S = t;
              var a = (0, n.hslToRgb)(this.H, this.S, this.L),
                  l = o(a, 3);
              this.R = l[0], this.G = l[1], this.B = l[2], this.updatePointerSL(this.H, this.S, this.L), this.updateInputHSL(this.H, this.S, this.L), this.updateInputRGB(this.R, this.G, this.B), this.updateInputRGBHEX(this.R, this.G, this.B);
              break;

            case "L":
              this.L = t;
              var c = (0, n.hslToRgb)(this.H, this.S, this.L),
                  u = o(c, 3);
              this.R = u[0], this.G = u[1], this.B = u[2], this.updatePointerSL(this.H, this.S, this.L), this.updateInputHSL(this.H, this.S, this.L), this.updateInputRGB(this.R, this.G, this.B), this.updateInputRGBHEX(this.R, this.G, this.B);
              break;

            case "R":
              this.R = t;
              var h = (0, n.rgbToHsl)(this.R, this.G, this.B),
                  p = o(h, 3);
              this.H = p[0], this.S = p[1], this.L = p[2], this.slBarHelper.setHue(this.H), this.updatePointerH(this.H), this.updatePointerSL(this.H, this.S, this.L), this.updateInputHSL(this.H, this.S, this.L), this.updateInputRGBHEX(this.R, this.G, this.B);
              break;

            case "G":
              this.G = t;
              var d = (0, n.rgbToHsl)(this.R, this.G, this.B),
                  v = o(d, 3);
              this.H = v[0], this.S = v[1], this.L = v[2], this.slBarHelper.setHue(this.H), this.updatePointerH(this.H), this.updatePointerSL(this.H, this.S, this.L), this.updateInputHSL(this.H, this.S, this.L), this.updateInputRGBHEX(this.R, this.G, this.B);
              break;

            case "B":
              this.B = t;
              var m = (0, n.rgbToHsl)(this.R, this.G, this.B),
                  A = o(m, 3);
              this.H = A[0], this.S = A[1], this.L = A[2], this.slBarHelper.setHue(this.H), this.updatePointerH(this.H), this.updatePointerSL(this.H, this.S, this.L), this.updateInputHSL(this.H, this.S, this.L), this.updateInputRGBHEX(this.R, this.G, this.B);
              break;

            case "RGB":
              var y = o(t, 3);
              this.R = y[0], this.G = y[1], this.B = y[2];
              var k = (0, n.rgbToHsl)(this.R, this.G, this.B),
                  F = o(k, 3);
              this.H = F[0], this.S = F[1], this.L = F[2], this.updateInputHSL(this.H, this.S, this.L), this.updateInputRGB(this.R, this.G, this.B), this.updateInputRGBHEX(this.R, this.G, this.B);
              break;

            case g:
              var E = o(t, 4);
              this.R = E[0], this.G = E[1], this.B = E[2], this.A = E[3];
              var H = (0, n.rgbToHsl)(this.R, this.G, this.B),
                  B = o(H, 3);
              this.H = B[0], this.S = B[1], this.L = B[2], this.slBarHelper.setHue(this.H), this.updatePointerH(this.H), this.updatePointerSL(this.H, this.S, this.L), this.updateInputHSL(this.H, this.S, this.L), this.updateInputRGB(this.R, this.G, this.B), this.updateInputRGBHEX(this.R, this.G, this.B), this.updatePointerA(this.A);
              break;

            case b:
              var R = o(t, 4);
              this.H = R[0], this.S = R[1], this.L = R[2], this.A = R[3];
              var C = (0, n.hslToRgb)(this.H, this.S, this.L),
                  S = o(C, 3);
              this.R = S[0], this.G = S[1], this.B = S[2], this.slBarHelper.setHue(this.H), this.updatePointerH(this.H), this.updatePointerSL(this.H, this.S, this.L), this.updateInputHSL(this.H, this.S, this.L), this.updateInputRGB(this.R, this.G, this.B), this.updateInputRGBHEX(this.R, this.G, this.B), this.updatePointerA(this.A);
              break;

            case "RGBHEX":
              var L = (0, n.cssColorToRgb)(t) || [this.R, this.G, this.B],
                  w = o(L, 3);
              this.R = w[0], this.G = w[1], this.B = w[2];
              var T = (0, n.rgbToHsl)(this.R, this.G, this.B),
                  x = o(T, 3);
              this.H = x[0], this.S = x[1], this.L = x[2], this.slBarHelper.setHue(this.H), this.updatePointerH(this.H), this.updatePointerSL(this.H, this.S, this.L), this.updateInputHSL(this.H, this.S, this.L), this.updateInputRGB(this.R, this.G, this.B);
              break;

            case f:
              var G = (0, n.parseColor)(t, "rgba") || [0, 0, 0, 1],
                  I = o(G, 4);
              this.R = I[0], this.G = I[1], this.B = I[2], this.A = I[3];
              var P = (0, n.rgbToHsl)(this.R, this.G, this.B),
                  D = o(P, 3);
              this.H = D[0], this.S = D[1], this.L = D[2], this.slBarHelper.setHue(this.H), this.updatePointerH(this.H), this.updatePointerSL(this.H, this.S, this.L), this.updateInputHSL(this.H, this.S, this.L), this.updateInputRGB(this.R, this.G, this.B), this.updateInputRGBHEX(this.R, this.G, this.B), this.updatePointerA(this.A);
              break;

            case "ALPHA":
              this.A = t;
          }

          1 === this.A ? this.preview.style.backgroundColor = "rgb(" + this.R + "," + this.G + "," + this.B + ")" : this.preview.style.backgroundColor = "rgba(" + this.R + "," + this.G + "," + this.B + "," + this.A + ")", r && r.silent || this.onchange && this.onchange(this.preview.style.backgroundColor);
        }
      }, {
        key: "onPaletteColorAdd",
        value: function (e) {
          this.oncoloradd && this.oncoloradd(e);
        }
      }, {
        key: "onPaletteColorRemove",
        value: function (e) {
          this.oncolorremove && this.oncolorremove(e);
        }
      }, {
        key: "updateInputHSL",
        value: function (e, t, r) {
          this.options.showHSL && (this.inputH.value = e, this.inputS.value = t, this.inputL.value = r);
        }
      }, {
        key: "updateInputRGB",
        value: function (e, t, r) {
          this.options.showRGB && (this.inputR.value = e, this.inputG.value = t, this.inputB.value = r);
        }
      }, {
        key: "updateInputRGBHEX",
        value: function (e, t, r) {
          this.options.showHEX && (this.inputRGBHEX.value = (0, n.rgbToHex)(e, t, r));
        }
      }, {
        key: "updatePointerH",
        value: function (e) {
          var t = this.options.hueBarSize[0] * e / 360;
          this.huePointer.style.left = t - 7 + "px";
        }
      }, {
        key: "updatePointerSL",
        value: function (e, t, r) {
          var i = (0, n.hslToRgb)(e, t, r),
              s = o(i, 3),
              a = s[0],
              l = s[1],
              c = s[2],
              u = this.slBarHelper.findColor(a, l, c),
              h = o(u, 2),
              p = h[0],
              d = h[1];
          p >= 0 && (this.slPointer.style.left = p - 7 + "px", this.slPointer.style.top = d - 7 + "px");
        }
      }, {
        key: "updatePointerA",
        value: function (e) {
          if (this.options.showAlpha) {
            var t = this.options.alphaBarSize[0] * e;
            this.alphaPointer.style.left = t - 7 + "px";
          }
        }
      }]), e;
    }(),
        F = function () {
      function e(t) {
        c(this, e), this.name = t, this.listeners = [];
      }

      return i(e, [{
        key: "on",
        value: function (e) {
          e && this.listeners.push(e);
        }
      }, {
        key: "off",
        value: function (e) {
          this.listeners = e ? this.listeners.filter(function (t) {
            return t !== e;
          }) : [];
        }
      }, {
        key: "emit",
        value: function (e, t) {
          for (var r = this.listeners.slice(0), i = 0; i < r.length; i++) r[i].apply(t, e);
        }
      }]), e;
    }();

    function E(e, t) {
      var r = new k(e, t),
          i = {
        change: new F("change"),
        coloradd: new F("coloradd"),
        colorremove: new F("colorremove")
      },
          s = !0,
          a = {},
          l = {
        get element() {
          return r.element;
        },

        get rgb() {
          return [r.R, r.G, r.B];
        },

        set rgb(e) {
          var t = o(e, 3),
              i = t[0],
              s = t[1],
              a = t[2],
              l = [(0, n.limit)(i, 0, 255), (0, n.limit)(s, 0, 255), (0, n.limit)(a, 0, 255)];
          i = l[0], s = l[1], a = l[2], r.onValueChanged(g, [i, s, a, 1]);
        },

        get hsl() {
          return [r.H, r.S, r.L];
        },

        set hsl(e) {
          var t = o(e, 3),
              i = t[0],
              s = t[1],
              a = t[2],
              l = [(0, n.limit)(i, 0, 360), (0, n.limit)(s, 0, 100), (0, n.limit)(a, 0, 100)];
          i = l[0], s = l[1], a = l[2], r.onValueChanged(b, [i, s, a, 1]);
        },

        get rgbhex() {
          return this.all.hex;
        },

        get rgba() {
          return [r.R, r.G, r.B, r.A];
        },

        set rgba(e) {
          var t = o(e, 4),
              i = t[0],
              s = t[1],
              a = t[2],
              l = t[3],
              c = [(0, n.limit)(i, 0, 255), (0, n.limit)(s, 0, 255), (0, n.limit)(a, 0, 255), (0, n.limit)(l, 0, 1)];
          i = c[0], s = c[1], a = c[2], l = c[3], r.onValueChanged(g, [i, s, a, l]);
        },

        get hsla() {
          return [r.H, r.S, r.L, r.A];
        },

        set hsla(e) {
          var t = o(e, 4),
              i = t[0],
              s = t[1],
              a = t[2],
              l = t[3],
              c = [(0, n.limit)(i, 0, 360), (0, n.limit)(s, 0, 100), (0, n.limit)(a, 0, 100), (0, n.limit)(l, 0, 1)];
          i = c[0], s = c[1], a = c[2], l = c[3], r.onValueChanged(b, [i, s, a, l]);
        },

        get color() {
          return this.all.toString();
        },

        set color(e) {
          r.onValueChanged(f, e);
        },

        setColor: function (e) {
          var t = arguments.length > 1 && void 0 !== arguments[1] && arguments[1];
          r.onValueChanged(f, e, {
            silent: t
          });
        },

        get all() {
          if (s) {
            var e = [r.R, r.G, r.B, r.A],
                t = r.A < 1 ? "rgba(" + r.R + "," + r.G + "," + r.B + "," + r.A + ")" : n.rgbToHex.apply(void 0, e);
            (a = (0, n.parseColor)(e, a)).toString = function () {
              return t;
            }, s = !1;
          }

          return Object.assign({}, a);
        },

        get onchange() {
          return i.change && i.change.listeners[0];
        },

        set onchange(e) {
          this.off("change").on("change", e);
        },

        get oncoloradd() {
          return i.coloradd && i.coloradd.listeners[0];
        },

        set oncoloradd(e) {
          this.off("coloradd").on("coloradd", e);
        },

        get oncolorremove() {
          return i.colorremove && i.colorremove.listeners[0];
        },

        set oncolorremove(e) {
          this.off("colorremove").on("colorremove", e);
        },

        get palette() {
          return Object.keys(r.palette).filter(function (e) {
            return r.palette[e];
          });
        },

        set palette(e) {
          r.updatePalette(e);
        },

        show: function () {
          r.element.classList.remove("hidden");
        },
        hide: function () {
          r.element.classList.add("hidden");
        },
        toggle: function () {
          r.element.classList.toggle("hidden");
        },
        on: function (e, t) {
          return e && i[e] && i[e].on(t), this;
        },
        off: function (e, t) {
          return e && i[e] && i[e].off(t), this;
        },
        destroy: function () {
          i.change.off(), i.coloradd.off(), i.colorremove.off(), r.element.remove(), i = null, r = null;
        }
      };
      return r.onchange = function () {
        for (var e = arguments.length, t = Array(e), r = 0; r < e; r++) t[r] = arguments[r];

        s = !0, i.change.emit([l].concat(t), l);
      }, r.oncoloradd = function () {
        for (var e = arguments.length, t = Array(e), r = 0; r < e; r++) t[r] = arguments[r];

        i.coloradd.emit([l].concat(t), l);
      }, r.oncolorremove = function () {
        for (var e = arguments.length, t = Array(e), r = 0; r < e; r++) t[r] = arguments[r];

        i.colorremove.emit([l].concat(t), l);
      }, r.element.ctrl = l, l;
    }

    if ("undefined" != typeof window && !document.querySelector('head>style[data-source="a-color-picker"]')) {
      var H = r(5).toString(),
          B = document.createElement("style");
      B.setAttribute("type", "text/css"), B.setAttribute("data-source", "a-color-picker"), B.innerHTML = H, document.querySelector("head").appendChild(B);
    }

    t.createPicker = E, t.from = function (e, t) {
      var r = function (e) {
        return e ? Array.isArray(e) ? e : e instanceof HTMLElement ? [e] : e instanceof NodeList ? [].concat(u(e)) : "string" == typeof e ? [].concat(u(document.querySelectorAll(e))) : e.jquery ? e.get() : [] : [];
      }(e).map(function (e, r) {
        var i = E(e, t);
        return i.index = r, i;
      });

      return r.on = function (e, t) {
        return r.forEach(function (r) {
          return r.on(e, t);
        }), this;
      }, r.off = function (e) {
        return r.forEach(function (t) {
          return t.off(e);
        }), this;
      }, r;
    }, t.parseColorToRgb = n.parseColorToRgb, t.parseColorToRgba = n.parseColorToRgba, t.parseColorToHsl = n.parseColorToHsl, t.parseColorToHsla = n.parseColorToHsla, t.parseColor = n.parseColor, t.rgbToHex = n.rgbToHex, t.hslToRgb = n.hslToRgb, t.rgbToHsl = n.rgbToHsl, t.rgbToHsv = n.rgbToHsv, t.rgbToInt = n.rgbToInt, t.intToRgb = n.intToRgb, t.getLuminance = n.getLuminance, t.COLOR_NAMES = n.COLOR_NAMES, t.PALETTE_MATERIAL_500 = n.PALETTE_MATERIAL_500, t.PALETTE_MATERIAL_CHROME = n.PALETTE_MATERIAL_CHROME, t.VERSION = "1.2.1";
  }, function (e, t, r) {
    "use strict";

    Object.defineProperty(t, "__esModule", {
      value: !0
    }), t.nvl = t.ensureArray = t.limit = t.getLuminance = t.parseColor = t.parseColorToHsla = t.parseColorToHsl = t.cssHslaToHsla = t.cssHslToHsl = t.parseColorToRgba = t.parseColorToRgb = t.cssRgbaToRgba = t.cssRgbToRgb = t.cssColorToRgba = t.cssColorToRgb = t.intToRgb = t.rgbToInt = t.rgbToHsv = t.rgbToHsl = t.hslToRgb = t.rgbToHex = t.PALETTE_MATERIAL_CHROME = t.PALETTE_MATERIAL_500 = t.COLOR_NAMES = void 0;

    var i = function (e, t) {
      if (Array.isArray(e)) return e;
      if (Symbol.iterator in Object(e)) return function (e, t) {
        var r = [],
            i = !0,
            o = !1,
            n = void 0;

        try {
          for (var s, a = e[Symbol.iterator](); !(i = (s = a.next()).done) && (r.push(s.value), !t || r.length !== t); i = !0);
        } catch (e) {
          o = !0, n = e;
        } finally {
          try {
            !i && a.return && a.return();
          } finally {
            if (o) throw n;
          }
        }

        return r;
      }(e, t);
      throw new TypeError("Invalid attempt to destructure non-iterable instance");
    },
        o = function (e) {
      return e && e.__esModule ? e : {
        default: e
      };
    }(r(0));

    function n(e) {
      if (Array.isArray(e)) {
        for (var t = 0, r = Array(e.length); t < e.length; t++) r[t] = e[t];

        return r;
      }

      return Array.from(e);
    }

    var s = {
      aliceblue: "#F0F8FF",
      antiquewhite: "#FAEBD7",
      aqua: "#00FFFF",
      aquamarine: "#7FFFD4",
      azure: "#F0FFFF",
      beige: "#F5F5DC",
      bisque: "#FFE4C4",
      black: "#000000",
      blanchedalmond: "#FFEBCD",
      blue: "#0000FF",
      blueviolet: "#8A2BE2",
      brown: "#A52A2A",
      burlywood: "#DEB887",
      cadetblue: "#5F9EA0",
      chartreuse: "#7FFF00",
      chocolate: "#D2691E",
      coral: "#FF7F50",
      cornflowerblue: "#6495ED",
      cornsilk: "#FFF8DC",
      crimson: "#DC143C",
      cyan: "#00FFFF",
      darkblue: "#00008B",
      darkcyan: "#008B8B",
      darkgoldenrod: "#B8860B",
      darkgray: "#A9A9A9",
      darkgrey: "#A9A9A9",
      darkgreen: "#006400",
      darkkhaki: "#BDB76B",
      darkmagenta: "#8B008B",
      darkolivegreen: "#556B2F",
      darkorange: "#FF8C00",
      darkorchid: "#9932CC",
      darkred: "#8B0000",
      darksalmon: "#E9967A",
      darkseagreen: "#8FBC8F",
      darkslateblue: "#483D8B",
      darkslategray: "#2F4F4F",
      darkslategrey: "#2F4F4F",
      darkturquoise: "#00CED1",
      darkviolet: "#9400D3",
      deeppink: "#FF1493",
      deepskyblue: "#00BFFF",
      dimgray: "#696969",
      dimgrey: "#696969",
      dodgerblue: "#1E90FF",
      firebrick: "#B22222",
      floralwhite: "#FFFAF0",
      forestgreen: "#228B22",
      fuchsia: "#FF00FF",
      gainsboro: "#DCDCDC",
      ghostwhite: "#F8F8FF",
      gold: "#FFD700",
      goldenrod: "#DAA520",
      gray: "#808080",
      grey: "#808080",
      green: "#008000",
      greenyellow: "#ADFF2F",
      honeydew: "#F0FFF0",
      hotpink: "#FF69B4",
      "indianred ": "#CD5C5C",
      "indigo ": "#4B0082",
      ivory: "#FFFFF0",
      khaki: "#F0E68C",
      lavender: "#E6E6FA",
      lavenderblush: "#FFF0F5",
      lawngreen: "#7CFC00",
      lemonchiffon: "#FFFACD",
      lightblue: "#ADD8E6",
      lightcoral: "#F08080",
      lightcyan: "#E0FFFF",
      lightgoldenrodyellow: "#FAFAD2",
      lightgray: "#D3D3D3",
      lightgrey: "#D3D3D3",
      lightgreen: "#90EE90",
      lightpink: "#FFB6C1",
      lightsalmon: "#FFA07A",
      lightseagreen: "#20B2AA",
      lightskyblue: "#87CEFA",
      lightslategray: "#778899",
      lightslategrey: "#778899",
      lightsteelblue: "#B0C4DE",
      lightyellow: "#FFFFE0",
      lime: "#00FF00",
      limegreen: "#32CD32",
      linen: "#FAF0E6",
      magenta: "#FF00FF",
      maroon: "#800000",
      mediumaquamarine: "#66CDAA",
      mediumblue: "#0000CD",
      mediumorchid: "#BA55D3",
      mediumpurple: "#9370DB",
      mediumseagreen: "#3CB371",
      mediumslateblue: "#7B68EE",
      mediumspringgreen: "#00FA9A",
      mediumturquoise: "#48D1CC",
      mediumvioletred: "#C71585",
      midnightblue: "#191970",
      mintcream: "#F5FFFA",
      mistyrose: "#FFE4E1",
      moccasin: "#FFE4B5",
      navajowhite: "#FFDEAD",
      navy: "#000080",
      oldlace: "#FDF5E6",
      olive: "#808000",
      olivedrab: "#6B8E23",
      orange: "#FFA500",
      orangered: "#FF4500",
      orchid: "#DA70D6",
      palegoldenrod: "#EEE8AA",
      palegreen: "#98FB98",
      paleturquoise: "#AFEEEE",
      palevioletred: "#DB7093",
      papayawhip: "#FFEFD5",
      peachpuff: "#FFDAB9",
      peru: "#CD853F",
      pink: "#FFC0CB",
      plum: "#DDA0DD",
      powderblue: "#B0E0E6",
      purple: "#800080",
      rebeccapurple: "#663399",
      red: "#FF0000",
      rosybrown: "#BC8F8F",
      royalblue: "#4169E1",
      saddlebrown: "#8B4513",
      salmon: "#FA8072",
      sandybrown: "#F4A460",
      seagreen: "#2E8B57",
      seashell: "#FFF5EE",
      sienna: "#A0522D",
      silver: "#C0C0C0",
      skyblue: "#87CEEB",
      slateblue: "#6A5ACD",
      slategray: "#708090",
      slategrey: "#708090",
      snow: "#FFFAFA",
      springgreen: "#00FF7F",
      steelblue: "#4682B4",
      tan: "#D2B48C",
      teal: "#008080",
      thistle: "#D8BFD8",
      tomato: "#FF6347",
      turquoise: "#40E0D0",
      violet: "#EE82EE",
      wheat: "#F5DEB3",
      white: "#FFFFFF",
      whitesmoke: "#F5F5F5",
      yellow: "#FFFF00",
      yellowgreen: "#9ACD32"
    };

    function a(e, t, r) {
      return e = +e, isNaN(e) ? t : e < t ? t : e > r ? r : e;
    }

    function l(e, t) {
      return null == e ? t : e;
    }

    function c(e, t, r) {
      var i = [a(e, 0, 255), a(t, 0, 255), a(r, 0, 255)];
      return "#" + ("000000" + ((e = i[0]) << 16 | (t = i[1]) << 8 | (r = i[2])).toString(16)).slice(-6);
    }

    function u(e, t, r) {
      var i = void 0,
          o = void 0,
          n = void 0,
          s = [a(e, 0, 360) / 360, a(t, 0, 100) / 100, a(r, 0, 100) / 100];
      if (e = s[0], r = s[2], 0 == (t = s[1])) i = o = n = r;else {
        var l = function (e, t, r) {
          return r < 0 && (r += 1), r > 1 && (r -= 1), r < 1 / 6 ? e + 6 * (t - e) * r : r < .5 ? t : r < 2 / 3 ? e + (t - e) * (2 / 3 - r) * 6 : e;
        },
            c = r < .5 ? r * (1 + t) : r + t - r * t,
            u = 2 * r - c;

        i = l(u, c, e + 1 / 3), o = l(u, c, e), n = l(u, c, e - 1 / 3);
      }
      return [255 * i, 255 * o, 255 * n].map(Math.round);
    }

    function h(e, t, r) {
      var i = [a(e, 0, 255) / 255, a(t, 0, 255) / 255, a(r, 0, 255) / 255];
      e = i[0], t = i[1], r = i[2];
      var o = Math.max(e, t, r),
          n = Math.min(e, t, r),
          s = void 0,
          l = void 0,
          c = (o + n) / 2;
      if (o == n) s = l = 0;else {
        var u = o - n;

        switch (l = c > .5 ? u / (2 - o - n) : u / (o + n), o) {
          case e:
            s = (t - r) / u + (t < r ? 6 : 0);
            break;

          case t:
            s = (r - e) / u + 2;
            break;

          case r:
            s = (e - t) / u + 4;
        }

        s /= 6;
      }
      return [360 * s, 100 * l, 100 * c].map(Math.round);
    }

    function p(e, t, r) {
      return e << 16 | t << 8 | r;
    }

    function d(e) {
      if (e) {
        var t = s[e.toString().toLowerCase()],
            r = /^\s*#?((([0-9A-F])([0-9A-F])([0-9A-F]))|(([0-9A-F]{2})([0-9A-F]{2})([0-9A-F]{2})))\s*$/i.exec(t || e) || [],
            o = i(r, 10),
            n = o[3],
            a = o[4],
            l = o[5],
            c = o[7],
            u = o[8],
            h = o[9];
        if (void 0 !== n) return [parseInt(n + n, 16), parseInt(a + a, 16), parseInt(l + l, 16)];
        if (void 0 !== c) return [parseInt(c, 16), parseInt(u, 16), parseInt(h, 16)];
      }
    }

    function f(e) {
      if (e) {
        var t = s[e.toString().toLowerCase()],
            r = /^\s*#?((([0-9A-F])([0-9A-F])([0-9A-F])([0-9A-F])?)|(([0-9A-F]{2})([0-9A-F]{2})([0-9A-F]{2})([0-9A-F]{2})?))\s*$/i.exec(t || e) || [],
            o = i(r, 12),
            n = o[3],
            a = o[4],
            l = o[5],
            c = o[6],
            u = o[8],
            h = o[9],
            p = o[10],
            d = o[11];
        if (void 0 !== n) return [parseInt(n + n, 16), parseInt(a + a, 16), parseInt(l + l, 16), c ? +(parseInt(c + c, 16) / 255).toFixed(2) : 1];
        if (void 0 !== u) return [parseInt(u, 16), parseInt(h, 16), parseInt(p, 16), d ? +(parseInt(d, 16) / 255).toFixed(2) : 1];
      }
    }

    function g(e) {
      if (e) {
        var t = /^rgb\((\d+)[\s,](\d+)[\s,](\d+)\)/i.exec(e) || [],
            r = i(t, 4),
            o = r[0],
            n = r[1],
            s = r[2],
            l = r[3];
        return o ? [a(n, 0, 255), a(s, 0, 255), a(l, 0, 255)] : void 0;
      }
    }

    function b(e) {
      if (e) {
        var t = /^rgba?\((\d+)\s*[\s,]\s*(\d+)\s*[\s,]\s*(\d+)(\s*[\s,]\s*(\d*(.\d+)?))?\)/i.exec(e) || [],
            r = i(t, 6),
            o = r[0],
            n = r[1],
            s = r[2],
            c = r[3],
            u = r[5];
        return o ? [a(n, 0, 255), a(s, 0, 255), a(c, 0, 255), a(l(u, 1), 0, 1)] : void 0;
      }
    }

    function v(e) {
      if (Array.isArray(e)) return [a(e[0], 0, 255), a(e[1], 0, 255), a(e[2], 0, 255), a(l(e[3], 1), 0, 1)];
      var t = f(e) || b(e);
      return t && 3 === t.length && t.push(1), t;
    }

    function m(e) {
      if (e) {
        var t = /^hsl\((\d+)[\s,](\d+)[\s,](\d+)\)/i.exec(e) || [],
            r = i(t, 4),
            o = r[0],
            n = r[1],
            s = r[2],
            l = r[3];
        return o ? [a(n, 0, 360), a(s, 0, 100), a(l, 0, 100)] : void 0;
      }
    }

    function A(e) {
      if (e) {
        var t = /^hsla?\((\d+)\s*[\s,]\s*(\d+)\s*[\s,]\s*(\d+)(\s*[\s,]\s*(\d*(.\d+)?))?\)/i.exec(e) || [],
            r = i(t, 6),
            o = r[0],
            n = r[1],
            s = r[2],
            c = r[3],
            u = r[5];
        return o ? [a(n, 0, 255), a(s, 0, 255), a(c, 0, 255), a(l(u, 1), 0, 1)] : void 0;
      }
    }

    function y(e) {
      if (Array.isArray(e)) return [a(e[0], 0, 360), a(e[1], 0, 100), a(e[2], 0, 100), a(l(e[3], 1), 0, 1)];
      var t = A(e);
      return t && 3 === t.length && t.push(1), t;
    }

    function k(e, t) {
      switch (t) {
        case "rgb":
        default:
          return e.slice(0, 3);

        case "rgbcss":
          return "rgb(" + e[0] + ", " + e[1] + ", " + e[2] + ")";

        case "rgbcss4":
          return "rgb(" + e[0] + ", " + e[1] + ", " + e[2] + ", " + e[3] + ")";

        case "rgba":
          return e;

        case "rgbacss":
          return "rgba(" + e[0] + ", " + e[1] + ", " + e[2] + ", " + e[3] + ")";

        case "hsl":
          return h.apply(void 0, n(e));

        case "hslcss":
          return "hsl(" + (e = h.apply(void 0, n(e)))[0] + ", " + e[1] + ", " + e[2] + ")";

        case "hslcss4":
          var r = h.apply(void 0, n(e));
          return "hsl(" + r[0] + ", " + r[1] + ", " + r[2] + ", " + e[3] + ")";

        case "hsla":
          return [].concat(n(h.apply(void 0, n(e))), [e[3]]);

        case "hslacss":
          var i = h.apply(void 0, n(e));
          return "hsla(" + i[0] + ", " + i[1] + ", " + i[2] + ", " + e[3] + ")";

        case "hex":
          return c.apply(void 0, n(e));

        case "hexcss4":
          return c.apply(void 0, n(e)) + ("00" + parseInt(255 * e[3]).toString(16)).slice(-2);

        case "int":
          return p.apply(void 0, n(e));
      }
    }

    t.COLOR_NAMES = s, t.PALETTE_MATERIAL_500 = ["#F44336", "#E91E63", "#E91E63", "#9C27B0", "#9C27B0", "#673AB7", "#673AB7", "#3F51B5", "#3F51B5", "#2196F3", "#2196F3", "#03A9F4", "#03A9F4", "#00BCD4", "#00BCD4", "#009688", "#009688", "#4CAF50", "#4CAF50", "#8BC34A", "#8BC34A", "#CDDC39", "#CDDC39", "#FFEB3B", "#FFEB3B", "#FFC107", "#FFC107", "#FF9800", "#FF9800", "#FF5722", "#FF5722", "#795548", "#795548", "#9E9E9E", "#9E9E9E", "#607D8B", "#607D8B"], t.PALETTE_MATERIAL_CHROME = ["#f44336", "#e91e63", "#9c27b0", "#673ab7", "#3f51b5", "#2196f3", "#03a9f4", "#00bcd4", "#009688", "#4caf50", "#8bc34a", "#cddc39", "#ffeb3b", "#ffc107", "#ff9800", "#ff5722", "#795548", "#9e9e9e", "#607d8b"], t.rgbToHex = c, t.hslToRgb = u, t.rgbToHsl = h, t.rgbToHsv = function (e, t, r) {
      var i = [a(e, 0, 255) / 255, a(t, 0, 255) / 255, a(r, 0, 255) / 255];
      e = i[0], t = i[1], r = i[2];
      var o,
          n = Math.max(e, t, r),
          s = Math.min(e, t, r),
          l = void 0,
          c = n,
          u = n - s;
      if (o = 0 === n ? 0 : u / n, n == s) l = 0;else {
        switch (n) {
          case e:
            l = (t - r) / u + (t < r ? 6 : 0);
            break;

          case t:
            l = (r - e) / u + 2;
            break;

          case r:
            l = (e - t) / u + 4;
        }

        l /= 6;
      }
      return [l, o, c];
    }, t.rgbToInt = p, t.intToRgb = function (e) {
      return [e >> 16 & 255, e >> 8 & 255, 255 & e];
    }, t.cssColorToRgb = d, t.cssColorToRgba = f, t.cssRgbToRgb = g, t.cssRgbaToRgba = b, t.parseColorToRgb = function (e) {
      return Array.isArray(e) ? e = [a(e[0], 0, 255), a(e[1], 0, 255), a(e[2], 0, 255)] : d(e) || g(e);
    }, t.parseColorToRgba = v, t.cssHslToHsl = m, t.cssHslaToHsla = A, t.parseColorToHsl = function (e) {
      return Array.isArray(e) ? e = [a(e[0], 0, 360), a(e[1], 0, 100), a(e[2], 0, 100)] : m(e);
    }, t.parseColorToHsla = y, t.parseColor = function (e, t) {
      if (t = t || "rgb", null != e) {
        var r = void 0;
        if ((r = v(e)) || (r = y(e)) && (r = [].concat(n(u.apply(void 0, n(r))), [r[3]]))) return (0, o.default)(t) ? ["rgb", "rgbcss", "rgbcss4", "rgba", "rgbacss", "hsl", "hslcss", "hslcss4", "hsla", "hslacss", "hex", "hexcss4", "int"].reduce(function (e, t) {
          return e[t] = k(r, t), e;
        }, t || {}) : k(r, t.toString().toLowerCase());
      }
    }, t.getLuminance = function (e, t, r) {
      return .2126 * (e = (e /= 255) < .03928 ? e / 12.92 : Math.pow((e + .055) / 1.055, 2.4)) + .7152 * (t = (t /= 255) < .03928 ? t / 12.92 : Math.pow((t + .055) / 1.055, 2.4)) + .0722 * ((r /= 255) < .03928 ? r / 12.92 : Math.pow((r + .055) / 1.055, 2.4));
    }, t.limit = a, t.ensureArray = function (e) {
      return e ? Array.from(e) : [];
    }, t.nvl = l;
  }, function (e, t, r) {
    "use strict";
    /*!
     * isobject <https://github.com/jonschlinkert/isobject>
     *
     * Copyright (c) 2014-2017, Jon Schlinkert.
     * Released under the MIT License.
     */

    e.exports = function (e) {
      return null != e && "object" == typeof e && !1 === Array.isArray(e);
    };
  }, function (e, t) {
    e.exports = '<div class="a-color-picker-row a-color-picker-stack a-color-picker-row-top"> <canvas class="a-color-picker-sl a-color-picker-transparent"></canvas> <div class=a-color-picker-dot></div> </div> <div class=a-color-picker-row> <div class="a-color-picker-stack a-color-picker-transparent a-color-picker-circle"> <div class=a-color-picker-preview> <input class=a-color-picker-clipbaord type=text> </div> </div> <div class=a-color-picker-column> <div class="a-color-picker-cell a-color-picker-stack"> <canvas class=a-color-picker-h></canvas> <div class=a-color-picker-dot></div> </div> <div class="a-color-picker-cell a-color-picker-alpha a-color-picker-stack" show-on-alpha> <canvas class="a-color-picker-a a-color-picker-transparent"></canvas> <div class=a-color-picker-dot></div> </div> </div> </div> <div class="a-color-picker-row a-color-picker-hsl" show-on-hsl> <label>H</label> <input nameref=H type=number maxlength=3 min=0 max=360 value=0> <label>S</label> <input nameref=S type=number maxlength=3 min=0 max=100 value=0> <label>L</label> <input nameref=L type=number maxlength=3 min=0 max=100 value=0> </div> <div class="a-color-picker-row a-color-picker-rgb" show-on-rgb> <label>R</label> <input nameref=R type=number maxlength=3 min=0 max=255 value=0> <label>G</label> <input nameref=G type=number maxlength=3 min=0 max=255 value=0> <label>B</label> <input nameref=B type=number maxlength=3 min=0 max=255 value=0> </div> <div class="a-color-picker-row a-color-picker-rgbhex a-color-picker-single-input" show-on-single-input> <label>HEX</label> <input nameref=RGBHEX type=text select-on-focus> </div> <div class="a-color-picker-row a-color-picker-palette"></div>';
  }, function (e, t, r) {
    var i = r(6);
    e.exports = "string" == typeof i ? i : i.toString();
  }, function (e, t, r) {
    (e.exports = r(7)(!1)).push([e.i, "/*!\n * a-color-picker\n * https://github.com/narsenico/a-color-picker\n *\n * Copyright (c) 2017-2018, Gianfranco Caldi.\n * Released under the MIT License.\n */.a-color-picker{background-color:#fff;padding:0;display:inline-flex;flex-direction:column;user-select:none;width:232px;font:400 10px Helvetica,Arial,sans-serif;border-radius:3px;box-shadow:0 0 0 1px rgba(0,0,0,.05),0 2px 4px rgba(0,0,0,.25)}.a-color-picker,.a-color-picker-row,.a-color-picker input{box-sizing:border-box}.a-color-picker-row{padding:15px;display:flex;flex-direction:row;align-items:center;justify-content:space-between;user-select:none}.a-color-picker-row-top{padding:0}.a-color-picker-row:not(:first-child){border-top:1px solid #f5f5f5}.a-color-picker-column{display:flex;flex-direction:column}.a-color-picker-cell{flex:1 1 auto;margin-bottom:4px}.a-color-picker-cell:last-child{margin-bottom:0}.a-color-picker-stack{position:relative}.a-color-picker-dot{position:absolute;width:14px;height:14px;top:0;left:0;background:#fff;pointer-events:none;border-radius:50px;z-index:1000;box-shadow:0 1px 2px rgba(0,0,0,.75)}.a-color-picker-a,.a-color-picker-h,.a-color-picker-sl{cursor:cell}.a-color-picker-a+.a-color-picker-dot,.a-color-picker-h+.a-color-picker-dot{top:-2px}.a-color-picker-a,.a-color-picker-h{border-radius:2px}.a-color-picker-preview{box-sizing:border-box;width:30px;height:30px;user-select:none;border-radius:15px}.a-color-picker-circle{border-radius:50px;border:1px solid #eee}.a-color-picker-hsl,.a-color-picker-rgb,.a-color-picker-single-input{justify-content:space-evenly}.a-color-picker-hsl>label,.a-color-picker-rgb>label,.a-color-picker-single-input>label{padding:0 8px;flex:0 0 auto;color:#969696}.a-color-picker-hsl>input,.a-color-picker-rgb>input,.a-color-picker-single-input>input{text-align:center;padding:2px 0;width:0;flex:1 1 auto;border:1px solid #e0e0e0;line-height:20px}.a-color-picker-hsl>input::-webkit-inner-spin-button,.a-color-picker-rgb>input::-webkit-inner-spin-button,.a-color-picker-single-input>input::-webkit-inner-spin-button{-webkit-appearance:none;margin:0}.a-color-picker-hsl>input:focus,.a-color-picker-rgb>input:focus,.a-color-picker-single-input>input:focus{border-color:#04a9f4;outline:none}.a-color-picker-transparent{background-image:linear-gradient(-45deg,#cdcdcd 25%,transparent 0),linear-gradient(45deg,#cdcdcd 25%,transparent 0),linear-gradient(-45deg,transparent 75%,#cdcdcd 0),linear-gradient(45deg,transparent 75%,#cdcdcd 0);background-size:11px 11px;background-position:0 0,0 -5.5px,-5.5px 5.5px,5.5px 0}.a-color-picker-sl{border-radius:3px 3px 0 0}.a-color-picker.hide-alpha [show-on-alpha],.a-color-picker.hide-hsl [show-on-hsl],.a-color-picker.hide-rgb [show-on-rgb],.a-color-picker.hide-single-input [show-on-single-input]{display:none}.a-color-picker-clipbaord{width:100%;height:100%;opacity:0;cursor:pointer}.a-color-picker-palette{flex-flow:wrap;flex-direction:row;justify-content:flex-start;padding:10px}.a-color-picker-palette-color{width:15px;height:15px;flex:0 1 15px;margin:3px;box-sizing:border-box;cursor:pointer;border-radius:3px;box-shadow:inset 0 0 0 1px rgba(0,0,0,.1)}.a-color-picker-palette-add{text-align:center;line-height:13px;color:#607d8b}.a-color-picker.hidden{display:none}", ""]);
  }, function (e, t) {
    e.exports = function (e) {
      var t = [];
      return t.toString = function () {
        return this.map(function (t) {
          var r = function (e, t) {
            var r = e[1] || "",
                i = e[3];
            if (!i) return r;

            if (t && "function" == typeof btoa) {
              var o = function (e) {
                return "/*# sourceMappingURL=data:application/json;charset=utf-8;base64," + btoa(unescape(encodeURIComponent(JSON.stringify(e)))) + " */";
              }(i),
                  n = i.sources.map(function (e) {
                return "/*# sourceURL=" + i.sourceRoot + e + " */";
              });

              return [r].concat(n).concat([o]).join("\n");
            }

            return [r].join("\n");
          }(t, e);

          return t[2] ? "@media " + t[2] + "{" + r + "}" : r;
        }).join("");
      }, t.i = function (e, r) {
        "string" == typeof e && (e = [[null, e, ""]]);

        for (var i = {}, o = 0; o < this.length; o++) {
          var n = this[o][0];
          "number" == typeof n && (i[n] = !0);
        }

        for (o = 0; o < e.length; o++) {
          var s = e[o];
          "number" == typeof s[0] && i[s[0]] || (r && !s[2] ? s[2] = r : r && (s[2] = "(" + s[2] + ") and (" + r + ")"), t.push(s));
        }
      }, t;
    };
  }]);
});

/***/ }),

/***/ "./src/js/admin/modules/controls.js":
/*!******************************************!*\
  !*** ./src/js/admin/modules/controls.js ***!
  \******************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);


const {
  __
} = wp.i18n;
/**
 * Init All Controls Logic
 */

class TWER_CONTROLS {
  /**
   * Controls constructor
   *
   * @param props
   */
  constructor(props) {
    // Init JQuery
    this.$ = $ = props; // Toggle TR table row after controls change

    const toggleElements = document.querySelectorAll('.js-twer-tr-toggle');
    const toggleControls = []; // Load status show/hide

    toggleElements.forEach(element => {
      const $toggleControl = document.getElementById(element.getAttribute('id').replace('-toggle', ''));
      toggleControls.push($toggleControl);
      const toggleControlValue = $toggleControl.options[$toggleControl.selectedIndex].value;
      const triggerValue = element.dataset.trigger;

      if (toggleControlValue === triggerValue) {
        element.classList.add('twer-tr-toggle--show');
        element.classList.remove('twer-tr-toggle--hide');
      } else {
        element.classList.remove('twer-tr-toggle--show');
        element.classList.add('twer-tr-toggle--hide');
      }
    }); // Change status

    toggleControls.forEach(element => {
      element.addEventListener('change', event => {
        const $toggleElement = document.getElementById(event.target.getAttribute('id') + '-toggle');
        const toggleControlValue = event.target.value;
        const triggerValue = $toggleElement.dataset.trigger;

        if (toggleControlValue === triggerValue) {
          $toggleElement.classList.add('twer-tr-toggle--show');
          $toggleElement.classList.remove('twer-tr-toggle--hide');
        } else {
          $toggleElement.classList.remove('twer-tr-toggle--show');
          $toggleElement.classList.add('twer-tr-toggle--hide');
        }
      });
    });
  }

}

/* harmony default export */ __webpack_exports__["default"] = (TWER_CONTROLS);

/***/ }),

/***/ "./src/js/admin/modules/layers.js":
/*!****************************************!*\
  !*** ./src/js/admin/modules/layers.js ***!
  \****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/helpers/defineProperty */ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js");




class TwerLayers {
  constructor() {
    (0,_babel_runtime_helpers_defineProperty__WEBPACK_IMPORTED_MODULE_0__["default"])(this, "layerMappings", {
      place_labels: 'showPlaceLabels',
      road_labels: 'showRoadLabels',
      points_of_interest: 'showPointOfInterestLabels',
      transit_labels: 'showTransitLabels'
    });

    this.mapStylesElement = document.getElementById('map_styles');
    this.layersTypes = ['showPlaceLabels', 'showRoadLabels', 'showPointOfInterestLabels', 'showTransitLabels'];
    TWER.map.on('style.load', () => {
      this.handleStyleLoad();
    });
    this.mapStylesElement.addEventListener('change', event => {
      this.toggleLayerSettings();
    });
    document.addEventListener('change', event => {
      if (!event.target.name.startsWith('_treweler_map_layers')) return;
      this.handleStyleLoad();
    });
    this.toggleLayerSettings();
  }

  toggleLayerSettings() {
    const mapStyle = this.mapStylesElement.value;
    const checkedBoxes = document.querySelectorAll('input[name^="_treweler_map_layers"]');
    const layersTab = document.getElementById('twer-nav-layers-tab');

    if (mapStyle === 'mapbox://styles/mapbox/navigation-guidance-day-v4' || mapStyle === 'mapbox://styles/mapbox/navigation-guidance-night-v4' || jQuery('#custom_style').val().trim() !== '') {
      layersTab.classList.add('d-none');
      jQuery('#twer-nav-general-tab').tab('show');
    } else {
      layersTab.classList.remove('d-none');
    }

    [...checkedBoxes].map(element => {
      if (mapStyle === 'mapbox://styles/mapbox/standard-beta') {
        if (this.layerMappings[element.value]) {
          if (element.value === 'place_labels') {
            element.closest('.section-treweler-map-layers').classList.add('is-first-row');
          }

          element.closest('.section-treweler-map-layers').classList.remove('d-none');
        } else {
          element.closest('.section-treweler-map-layers').classList.add('d-none');
        }
      } else if (mapStyle === 'mapbox://styles/mapbox/navigation-guidance-day-v4' || mapStyle === 'mapbox://styles/mapbox/navigation-guidance-night-v4') {
        element.checked = true;
      } else {
        element.closest('.section-treweler-map-layers').classList.remove('is-first-row');
        element.closest('.section-treweler-map-layers').classList.remove('d-none');
      }
    });
  }

  getCheckboxValues() {
    const checkedBoxes = document.querySelectorAll('input[name^="_treweler_map_layers"]:checked');
    return [...checkedBoxes].map(element => this.layerMappings[element.value] || element.value);
  }

  setLayerVisibility(layerId, visibility) {
    TWER.map.setLayoutProperty(layerId, 'visibility', visibility ? 'visible' : 'none');
  }

  updateLayerVisibility(layers, activeLayers, layerType) {
    layers.forEach(layerId => {
      this.setLayerVisibility(layerId, activeLayers.includes(layerType));
    });
  }

  handleStyleLoad() {
    const activeLayers = this.getCheckboxValues();

    if (this.mapStylesElement.value === 'mapbox://styles/mapbox/standard-beta') {
      this.layersTypes.forEach(item => {
        TWER.map.setConfigProperty('basemap', item, activeLayers.includes(item));
      });
    } else {
      if (jQuery('#custom_style').val().trim() === '') {
        this.updateMapLayers();
      }
    }
  }

  updateMapLayers() {
    const activeLayers = this.getCheckboxValues();
    const layerGroups = {
      showPlaceLabels: ['continent-label', 'country-label', 'state-label', 'settlement-major-label', 'settlement-minor-label', 'settlement-subdivision-label'],
      showRoadLabels: ['road-exit-shield', 'road-label-simple', 'road-exit-shield-navigation', 'road-number-shield', 'road-number-shield-navigation', 'road-label-navigation', 'road-label', 'road-intersection'],
      showPointOfInterestLabels: ['poi-label'],
      showTransitLabels: ['airport-label', 'transit-label', 'ferry-aerialway-label'],
      boundaries: ['admin-0-boundary-disputed', 'admin-0-boundary', 'admin-1-boundary', 'admin-0-boundary-bg', 'admin-1-boundary-bg'],
      building_labels: ['block-number-label', 'building-number-label', 'building-entrance'],
      buildings: ['building', 'building-underground', 'building-outline'],
      natural_features: ['water-point-label', 'water-line-label', 'natural-point-label', 'natural-line-label', 'waterway-label'],
      pedestrian_labels: ['golf-hole-label', 'path-pedestrian-label'],
      pedestrian_roads: ['bridge-pedestrian', 'bridge-steps', 'bridge-path', 'bridge-pedestrian-case', 'bridge-steps-bg', 'bridge-path-bg', 'golf-hole-line', 'road-pedestrian', 'road-steps', 'road-path', 'road-pedestrian-case', 'road-steps-bg', 'road-path-bg', 'road-pedestrian-polygon-pattern', 'road-pedestrian-polygon-fill', 'tunnel-pedestrian', 'tunnel-steps', 'tunnel-path', 'gate-label', 'bridge-path-cycleway-piste', 'bridge-path-trail', 'road-path-cycleway-piste', 'road-path-trail', 'tunnel-path-cycleway-piste', 'tunnel-path-trail'],
      transit: ['aerialway', 'bridge-rail-tracks', 'bridge-rail', 'road-rail-tracks', 'road-rail', 'ferry-auto', 'ferry', 'aeroway-line', 'aeroway-polygon'],
      roads: ["bridge-oneway-arrow-white", "bridge-oneway-arrow-blue", "bridge-motorway-trunk-2", "bridge-major-link-2", "bridge-motorway-trunk-2-case", "bridge-major-link-2-case", "bridge-motorway-trunk", "bridge-primary", "bridge-secondary-tertiary", "bridge-street-low", "bridge-street", "bridge-major-link", "bridge-minor-link", "bridge-minor", "bridge-construction", "bridge-motorway-trunk-case", "bridge-major-link-case", "bridge-primary-case", "bridge-secondary-tertiary-case", "bridge-minor-link-case", "bridge-street-case", "bridge-minor-case", "crosswalks", "road-oneway-arrow-white", "road-oneway-arrow-blue", "level-crossing", "road-motorway-trunk", "road-primary", "road-secondary-tertiary", "road-street-low", "road-street", "road-major-link", "road-minor-link", "road-minor", "road-construction", "turning-feature", "road-motorway-trunk-case", "road-major-link-case", "road-primary-case", "road-secondary-tertiary-case", "road-minor-link-case", "road-street-case", "road-minor-case", "turning-feature-outline", "road-polygon", "tunnel-oneway-arrow-white", "tunnel-oneway-arrow-blue", "tunnel-motorway-trunk", "tunnel-primary", "tunnel-secondary-tertiary", "tunnel-street-low", "tunnel-street", "tunnel-major-link", "tunnel-minor-link", "tunnel-minor", "tunnel-construction", "tunnel-motorway-trunk-case", "tunnel-major-link-case", "tunnel-primary-case", "tunnel-secondary-tertiary-case", "tunnel-minor-link-case", "tunnel-street-case", "tunnel-minor-case", "bridge-simple", "bridge-case-simple", "road-simple", "tunnel-simple", "incident-startpoints-navigation", "incident-endpoints-navigation", "incident-closure-line-highlights-navigation", "incident-closure-lines-navigation", "traffic-bridge-oneway-arrow-white-navigation", "traffic-bridge-oneway-arrow-blue-navigation", "traffic-road-oneway-arrow-white-navigation", "traffic-road-oneway-arrow-blue-navigation", "traffic-tunnel-oneway-arrow-white-navigation", "traffic-tunnel-oneway-arrow-blue-navigation", "traffic-level-crossing-navigation", "traffic-bridge-road-motorway-trunk-navigation", "traffic-bridge-road-motorway-trunk-case-navigation", "traffic-bridge-road-major-link-navigation", "traffic-bridge-road-primary-navigation", "traffic-bridge-road-secondary-tertiary-navigation", "traffic-bridge-road-street-navigation", "traffic-bridge-road-minor-navigation", "traffic-bridge-road-link-navigation", "bridge-motorway-trunk-2-navigation", "bridge-major-link-2-navigation", "bridge-motorway-trunk-2-case-navigation", "bridge-major-link-2-case-navigation", "bridge-motorway-trunk-navigation", "bridge-primary-navigation", "bridge-secondary-tertiary-navigation", "bridge-street-navigation", "bridge-minor-navigation", "bridge-major-link-navigation", "bridge-construction-navigation", "bridge-motorway-trunk-case-navigation", "bridge-major-link-case-navigation", "bridge-primary-case-navigation", "bridge-secondary-tertiary-case-navigation", "bridge-street-case-navigation", "bridge-street-low-navigation", "bridge-minor-case-navigation", "turning-feature-navigation", "level-crossing-navigation", "traffic-tunnel-motorway-trunk-navigation", "road-motorway-trunk-navigation", "traffic-tunnel-major-link-navigation", "road-motorway-trunk-case-low-navigation", "traffic-tunnel-primary-navigation", "road-primary-navigation", "traffic-tunnel-secondary-tertiary-navigation", "road-secondary-tertiary-navigation", "traffic-tunnel-street-navigation", "road-street-navigation", "traffic-tunnel-minor-navigation", "traffic-tunnel-link-navigation", "road-minor-navigation", "road-major-link-navigation", "road-construction-navigation", "road-motorway-trunk-case-navigation", "road-major-link-case-navigation", "road-primary-case-navigation", "road-secondary-tertiary-case-navigation", "road-street-case-navigation", "road-street-low-navigation", "road-minor-case-navigation", "turning-feature-outline-navigation", "tunnel-motorway-trunk-navigation", "tunnel-primary-navigation", "tunnel-secondary-tertiary-navigation", "tunnel-street-navigation", "tunnel-minor-navigation", "tunnel-major-link-navigation", "tunnel-construction-navigation", "tunnel-motorway-trunk-case-navigation", "tunnel-major-link-case-navigation", "tunnel-primary-case-navigation", "tunnel-secondary-tertiary-case-navigation", "tunnel-street-case-navigation", "tunnel-street-low-navigation", "tunnel-minor-case-navigation"],
      land_structure: ["land-structure-line", "land-structure-polygon", "pitch-outline", "landuse", "national-park", "landcover", "national-park_tint-band", "cliff", "wetland-pattern", "wetland"],
      hillshade: ['hillshade'],
      water_depth: ['water-depth'],
      contour_lines: ['contour-label', 'contour-line']
    };
    TWER.map.getStyle().layers.map(layer => {
      for (const [layerType, layerIds] of Object.entries(layerGroups)) {
        if (layerIds.includes(layer.id)) {
          this.setLayerVisibility(layer.id, activeLayers.includes(layerType));
          break;
        }
      }
    });
  }

}

/* harmony default export */ __webpack_exports__["default"] = (TwerLayers);

/***/ }),

/***/ "./src/js/admin/modules/uploads.js":
/*!*****************************************!*\
  !*** ./src/js/admin/modules/uploads.js ***!
  \*****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);


const {
  __
} = wp.i18n;

class TWER_UPLOADS {
  /**
   * Uploads constructor
   *
   * @param props
   */
  constructor(props) {
    // Init JQuery
    this.$ = $ = props;
    const $addAttach = document.querySelectorAll('.js-twer-attach-add');
    const $removeAttach = document.querySelectorAll('.js-twer-attach-remove'); // Click on Upload attach button in metabox

    $addAttach.forEach(element => {
      element.addEventListener('click', event => {
        var _$attachWrap$dataset, _$attachWrap$dataset2, _$attachWrap$dataset3, _$attachWrap$dataset4;

        event.preventDefault();
        const $btn = event.target;
        const $attachWrap = $btn.closest('.js-twer-attach-wrap');
        let xmlFrame;

        if (xmlFrame) {
          xmlFrame.open();
          return;
        }

        xmlFrame = wp.media({
          title: ($attachWrap === null || $attachWrap === void 0 ? void 0 : (_$attachWrap$dataset = $attachWrap.dataset) === null || _$attachWrap$dataset === void 0 ? void 0 : _$attachWrap$dataset.title) || __('Select image', 'treweler'),
          button: {
            text: ($attachWrap === null || $attachWrap === void 0 ? void 0 : (_$attachWrap$dataset2 = $attachWrap.dataset) === null || _$attachWrap$dataset2 === void 0 ? void 0 : _$attachWrap$dataset2.buttonText) || __('Upload image', 'treweler')
          },
          library: {
            type: ($attachWrap === null || $attachWrap === void 0 ? void 0 : (_$attachWrap$dataset3 = $attachWrap.dataset) === null || _$attachWrap$dataset3 === void 0 ? void 0 : (_$attachWrap$dataset4 = _$attachWrap$dataset3.libraryType) === null || _$attachWrap$dataset4 === void 0 ? void 0 : _$attachWrap$dataset4.split(',')) || ['image']
          },
          multiple: false
        });
        xmlFrame.on('select', () => {
          const xmlFrameFile = xmlFrame.state().get('selection').first().toJSON();
          const xmlUrl = xmlFrameFile.url;
          const xmlId = xmlFrameFile.id;
          const $thumbWrap = $attachWrap.getElementsByClassName('js-twer-attach-thumb')[0];

          if (xmlFrameFile.type === 'application') {
            var _$attachWrap$getEleme;

            const $div = document.createElement('div');
            $div.style.whiteSpace = 'nowrap';
            $div.className = 'twer-app-file';
            $div.innerText = xmlFrameFile.filename;
            (_$attachWrap$getEleme = $attachWrap.getElementsByClassName('twer-app-file')[0]) === null || _$attachWrap$getEleme === void 0 ? void 0 : _$attachWrap$getEleme.remove();
            $thumbWrap.appendChild($div);
          } else {
            var _$attachWrap$getEleme2;

            const $img = document.createElement('img');
            $img.setAttribute('src', xmlUrl);
            $img.setAttribute('alt', xmlFrameFile.title);
            (_$attachWrap$getEleme2 = $attachWrap.getElementsByTagName('img')[0]) === null || _$attachWrap$getEleme2 === void 0 ? void 0 : _$attachWrap$getEleme2.remove();
            $thumbWrap.appendChild($img);
          }

          if (!$btn.classList.contains('button')) {
            $btn.style.display = 'none';
          }

          $thumbWrap.nextElementSibling.style.display = 'block';
          $attachWrap.getElementsByTagName('input')[0].value = xmlId;
          $(document).trigger('twer-attach-add', [xmlFrame]);
        });
        xmlFrame.open();
      });
    }); // Click on Remove attach button in metabox

    $removeAttach.forEach(element => {
      element.addEventListener('click', event => {
        event.preventDefault();
        const $btn = event.target;
        const $attachWrap = $btn.closest('.js-twer-attach-wrap');
        const $thumbWrap = $attachWrap.getElementsByClassName('js-twer-attach-thumb')[0];

        if ($attachWrap.getElementsByClassName('twer-app-file')) {
          $attachWrap.getElementsByClassName('twer-app-file')[0].remove();
        } else {
          var _$attachWrap$getEleme3;

          (_$attachWrap$getEleme3 = $attachWrap.getElementsByTagName('img')[0]) === null || _$attachWrap$getEleme3 === void 0 ? void 0 : _$attachWrap$getEleme3.remove();
        }

        $attachWrap.getElementsByTagName('input')[0].value = '';
        $btn.closest('.js-twer-attach-actions').style.display = 'none';
        $thumbWrap.getElementsByClassName('js-twer-attach-add')[0].style.display = 'block';
        $(document).trigger('twer-attach-remove');
      });
    });
    const $addAttachGallery = document.querySelectorAll('.js-twer-attach-gallery-add');
    $('.js-twer-attach-gallery-wrap').each((index, element) => {
      const $sortableList = $(element);
      $sortableList.sortable({
        cursor: 'move',
        placeholder: 'twer-attach-gallery__thumb',
        forcePlaceholderSize: true,
        forceHelperSize: true,
        scroll: true,
        revert: false,
        tolerance: 'pointer',
        items: '> div',
        update: function (event, ui) {
          const $input = $sortableList.find('input');
          const ids = [];
          $sortableList.children('div').each(function (divIndex, div) {
            ids.push($(div).data('id'));
          });
          $input.val(ids.join(','));
        }
      }).disableSelection();
    });
    $(document).on('click', '.js-twer-attach-gallery-remove', function (e) {
      e.preventDefault();
      const $sortableList = $(this).closest('.js-twer-attach-gallery-wrap');
      const $input = $sortableList.find('input');
      const ids = [];
      $(this).closest('.twer-attach-gallery__thumb').remove();
      $sortableList.children('div').each(function (divIndex, div) {
        ids.push($(div).data('id'));
      });
      $input.val(ids.join(','));
    }); // Click on Upload attach gallery button in metabox

    $addAttachGallery.forEach(element => {
      element.addEventListener('click', event => {
        event.preventDefault();
        const $btn = event.target;
        let xmlFrame;

        if (xmlFrame) {
          xmlFrame.open();
          return;
        }

        xmlFrame = wp.media({
          title: __('Select images', 'treweler'),
          button: {
            text: __('Upload images', 'treweler')
          },
          library: {
            type: ['image']
          },
          multiple: 'add'
        });
        xmlFrame.on('open', () => {
          const $attachWrap = $btn.closest('.js-twer-attach-gallery-wrap');
          const attachIds = $attachWrap.getElementsByTagName('input')[0].value;
          let selection = xmlFrame.state().get('selection');

          if (attachIds.length > 0) {
            let ids = attachIds.split(',');
            ids.forEach(function (id) {
              let attachment = wp.media.attachment(id);
              attachment.fetch();
              selection.add(attachment ? [attachment] : []);
            });
          }
        });
        xmlFrame.on('select', () => {
          const selection = xmlFrame.state().get('selection');
          const $attachWrap = $btn.closest('.js-twer-attach-gallery-wrap');
          const attachIds = [];
          const elements = $attachWrap.getElementsByClassName('twer-attach-gallery__thumb');

          while (elements.length > 0) {
            elements[0].parentNode.removeChild(elements[0]);
          } //let index = 0;


          selection.map(function (attachment) {
            attachment = attachment.toJSON();
            let $divThumb = document.createElement('div');
            $divThumb.setAttribute('class', 'twer-attach-gallery__thumb');
            $divThumb.setAttribute('data-id', attachment.id); //$divThumb.setAttribute('data-index', index++);

            let $imgThumb = document.createElement('img');
            $imgThumb.setAttribute('src', attachment.url);
            $imgThumb.setAttribute('alt', attachment.title);
            let $close = document.createElement('a');
            $close.setAttribute('href', '#');
            $close.setAttribute('title', __('Remove', 'treweler'));
            $close.setAttribute('class', 'twer-attach-gallery__remove js-twer-attach-gallery-remove');
            $divThumb.appendChild($imgThumb);
            $divThumb.appendChild($close);
            $attachWrap.insertBefore($divThumb, $btn); //console.log($attachWrap, $divThumb, $btn);

            attachIds.push(attachment.id);
          });
          $attachWrap.getElementsByTagName('input')[0].value = attachIds.join(',');
        });
        xmlFrame.open();
      });
    });
  }

}

/* harmony default export */ __webpack_exports__["default"] = (TWER_UPLOADS);

/***/ }),

/***/ "./src/js/admin/modules/widgets-marker.js":
/*!************************************************!*\
  !*** ./src/js/admin/modules/widgets-marker.js ***!
  \************************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);

/**
 * Init All Widget Logic
 */

class TWER_WIDGETS_MARKER {
  /**
   * Widgets constructor
   *
   * @param props
   */
  constructor(props) {
    // Init JQuery
    this.$ = $ = props; // Init core constants/variables etc

    this.$widgets = $(['#treweler-widgets-tour-list'].join(', '));
    const $widgets_area = document.querySelectorAll('.js-twer-widgets'); // Init JQ UI sortable

    this.initSortable(); // Add dynamic events for inner widget elements

    $widgets_area.forEach(element => {
      element.addEventListener('click', event => {
        // Close/Open widget after click
        this.toggleWidget(event); // Click Add Widget button handler

        this.addWidget(event); // Click Remove Widget button handler

        this.removeWidget(event);
      });
      element.addEventListener('keyup', event => {
        // Change widget header after keyup handler on "value" input
        this.updateHeadWidget(event);
      });
    });
    this.triggerHelper();
  }
  /**
   * Init sortable method
   */


  initSortable() {
    this.$widgets.sortable({
      connectWith: '.js-twer-ui-repeater',
      handle: '.js-twer-widget-marker-ui-handle',
      cursor: 'move',
      receive: (event, ui) => this.updateAlienWidget(event, ui)
    }).disableSelection();
  }
  /**
   * Update widget head method
   *
   * @param event
   */


  updateHeadWidget(event) {
    const target = event.target;

    if (target.classList.contains('marker-picker')) {
      const $titleWidget = target.closest('.js-twer-widget-marker').getElementsByClassName('js-twer-title-widget')[0];

      if (target.options[target.selectedIndex].text) {
        $titleWidget.innerText = target.options[target.selectedIndex].text;
      } else {
        $titleWidget.innerHTML = '&nbsp;';
      }
    }
  }
  /**
   * Update alien widget after move from another list
   *
   * @param event
   * @param ui
   */


  updateAlienWidget(event, ui) {
    const $currentItem = ui.item[0];
    const $previousItem = ui.sender[0];
    const $repeater = $currentItem.parentNode;
    const currentPosition = $repeater.dataset.position;
    const previousPosition = $previousItem.dataset.position;
    const newIndex = $repeater.childElementCount.toString();
    let currentItemHtml = $currentItem.innerHTML;
    const regex_name = new RegExp(`${previousPosition}`, 'mg');
    const regex_id = new RegExp(`${previousPosition.replace('_', '-')}`, 'mg');
    currentItemHtml = currentItemHtml.replace(regex_name, currentPosition);
    currentItemHtml = currentItemHtml.replace(regex_id, currentPosition.replace('_', '-'));
    currentItemHtml = currentItemHtml.replace(/\]\[\d+\]\[/gm, `][${newIndex}][`);
    currentItemHtml = currentItemHtml.replace(/-\d+-/gm, `-${newIndex}-`);
    $currentItem.innerHTML = currentItemHtml;
    this.updateSortable();
  }
  /**
   * Update sortable elements after some actions
   */


  updateSortable() {
    this.$widgets.sortable('refresh');
    this.$widgets.sortable('refreshPositions');
    this.triggerHelper();
  }
  /**
   * Remove widget method
   *
   * @param event
   */


  removeWidget(event) {
    if (event.target.classList.contains('js-twer-remove-widget')) {
      event.preventDefault();
      event.target.closest('.js-twer-widget-marker').remove();
      this.updateSortable();
    }
  }
  /**
   * Toggle widget method
   *
   * @param event
   */


  toggleWidget(event) {
    const $widgetHandle = event.target.closest('.js-twer-widget-marker-handle');

    if (!!$widgetHandle) {
      event.preventDefault();
      $widgetHandle.closest('.js-twer-widget-marker').classList.toggle('open');
    }
  }
  /**
   * Add widget method
   *
   * @param event
   */


  addWidget(event) {
    if (event.target.classList.contains('js-twer-add-widget-marker')) {
      event.preventDefault();
      const $widget = event.target.closest('.widget-marker-container');
      const $template = $widget.getElementsByClassName('js-twer-repeater-template')[0];
      const $repeater = $widget.getElementsByClassName('js-twer-repeater')[0];
      const range = document.createRange();
      let selectedMarker = $widget.getElementsByClassName('tour-marker-picker')[0]; // check if select value are valid id

      if (parseInt(selectedMarker.value) <= 0) {
        return;
      }

      let templateHtml = $template.innerHTML;
      templateHtml = templateHtml.replace(/data-/mg, '');
      templateHtml = templateHtml.replace(/%index%/mg, $repeater.childElementCount.toString());
      templateHtml = templateHtml.replace(/%title%/mg, selectedMarker.options[selectedMarker.selectedIndex].text.toString());
      templateHtml = templateHtml.replace(/%idMarker%/mg, selectedMarker.value.toString());
      const documentFragment = range.createContextualFragment(templateHtml);
      $repeater.appendChild(documentFragment);
      event.target.blur();
      this.updateSortable();
    }
  }

  triggerHelper() {
    $('.js-zoom-range, .js-zoom-range-input').on('input', function () {
      let zoomCC = parseFloat($(this).val()).toFixed(2);

      if (zoomCC.trim() === '' || zoomCC.trim() === 'NaN' || zoomCC === 0.00 || zoomCC === 0.23) {
        zoomCC = 0;
      }

      if ($(this).data('id') === 'range-input') {
        $(this).closest('.js-twer-range').find('.js-zoom-range').val(zoomCC);
      } else {
        $(this).closest('.js-twer-range').find('.js-zoom-range-input').val(zoomCC);
      }
    });
    $('.twer-root').tooltip({
      selector: '.twer-help-tooltip'
    });
    $('.marker-picker').on('change', function () {
      let optionSelected = $("option:selected", this);
      let label = optionSelected.text();
      let pickerVal = parseInt(optionSelected.val());

      if (pickerVal > 0) {
        $(this).closest('.widget').find('.js-twer-title-widget').html(label);
      } else {
        $(this).closest('.widget').find('.js-twer-title-widget').html('&nbsp;');
      }
    });
    const $MainTourType = $('#treweler-tour-type');
    $('.js-adv-checkbox').on('change', function () {
      if ($(this).is(":checked")) {
        $(this).closest('.widget').find('.cogs').show();
        $(this).closest('.widget').find('.adv-settings').show();

        if ($MainTourType.val() !== 'fly') {
          $(this).closest('.widget').find('.adv-fly').hide();
        }
      } else {
        $(this).closest('.widget').find('.cogs').hide();
        $(this).closest('.widget').find('.adv-settings').hide();

        if ($MainTourType.val() !== 'fly') {
          $(this).closest('.widget').find('.adv-fly').hide();
        }
      }
    });
  }

}

/* harmony default export */ __webpack_exports__["default"] = (TWER_WIDGETS_MARKER);

/***/ }),

/***/ "./src/js/admin/modules/widgets.js":
/*!*****************************************!*\
  !*** ./src/js/admin/modules/widgets.js ***!
  \*****************************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);

/**
 * Init All Widget Logic
 */

class TWER_WIDGETS {
  /**
   * Widgets constructor
   *
   * @param props
   */
  constructor(props) {
    // Init JQuery
    this.$ = $ = props; // Init core constants/variables etc

    this.$widgets = $(['#treweler-widgets-top-left', '#treweler-widgets-middle-left', '#treweler-widgets-bottom-left', '#treweler-widgets-top-right', '#treweler-widgets-middle-right', '#treweler-widgets-bottom-right'].join(', '));
    const $widgets_area = document.querySelectorAll('.js-twer-widgets'); // Init JQ UI sortable

    this.initSortable(); // Add dynamic events for inner widget elements

    $widgets_area.forEach(element => {
      element.addEventListener('click', event => {
        // Close/Open widget after click
        this.toggleWidget(event); // Click Add Widget button handler

        this.addWidget(event); // Click Remove Widget button handler

        this.removeWidget(event);
      });
      element.addEventListener('keyup', event => {
        // Change widget header after keyup handler on "value" input
        this.updateHeadWidget(event);
      });
    });
  }
  /**
   * Init sortable method
   */


  initSortable() {
    this.$widgets.sortable({
      connectWith: '.js-twer-ui-repeater',
      handle: '.js-twer-widget-ui-handle',
      cursor: 'move',
      receive: (event, ui) => this.updateAlienWidget(event, ui)
    }).disableSelection();
  }
  /**
   * Update widget head method
   *
   * @param event
   */


  updateHeadWidget(event) {
    const target = event.target;

    if (target.classList.contains('js-twer-dynamic-description')) {
      const $titleWidget = target.closest('.js-twer-widget').getElementsByClassName('js-twer-title-widget')[0];

      if (target.value) {
        $titleWidget.innerText = target.value;
      } else {
        $titleWidget.innerHTML = '&nbsp;';
      }
    }
  }
  /**
   * Update alien widget after move from another list
   *
   * @param event
   * @param ui
   */


  updateAlienWidget(event, ui) {
    const $currentItem = ui.item[0];
    const $previousItem = ui.sender[0];
    const $repeater = $currentItem.parentNode;
    const currentPosition = $repeater.dataset.position;
    const previousPosition = $previousItem.dataset.position;
    const newIndex = $repeater.childElementCount.toString();
    let currentItemHtml = $currentItem.innerHTML;
    const regex_name = new RegExp(`${previousPosition}`, 'mg');
    const regex_id = new RegExp(`${previousPosition.replace('_', '-')}`, 'mg');
    currentItemHtml = currentItemHtml.replace(regex_name, currentPosition);
    currentItemHtml = currentItemHtml.replace(regex_id, currentPosition.replace('_', '-'));
    currentItemHtml = currentItemHtml.replace(/\]\[\d+\]\[/gm, `][${newIndex}][`);
    currentItemHtml = currentItemHtml.replace(/-\d+-/gm, `-${newIndex}-`);
    $currentItem.innerHTML = currentItemHtml;
    this.updateSortable();
  }
  /**
   * Update sortable elements after some actions
   */


  updateSortable() {
    this.$widgets.sortable('refresh');
    this.$widgets.sortable('refreshPositions');
  }
  /**
   * Remove widget method
   *
   * @param event
   */


  removeWidget(event) {
    if (event.target.classList.contains('js-twer-remove-widget')) {
      event.preventDefault();
      event.target.closest('.js-twer-widget').remove();
      this.updateSortable();
    }
  }
  /**
   * Toggle widget method
   *
   * @param event
   */


  toggleWidget(event) {
    const $widgetHandle = event.target.closest('.js-twer-widget-handle');

    if (!!$widgetHandle) {
      event.preventDefault();
      $widgetHandle.closest('.js-twer-widget').classList.toggle('open');
    }
  }
  /**
   * Add widget method
   *
   * @param event
   */


  addWidget(event) {
    if (event.target.classList.contains('js-twer-add-widget')) {
      event.preventDefault();
      const $widget = event.target.closest('.js-twer-widget');
      const $template = $widget.getElementsByClassName('js-twer-repeater-template')[0];
      const $repeater = $widget.getElementsByClassName('js-twer-repeater')[0];
      const range = document.createRange();
      let templateHtml = $template.innerHTML;
      templateHtml = templateHtml.replace(/data-/mg, '');
      templateHtml = templateHtml.replace(/%index%/mg, $repeater.childElementCount.toString());
      const documentFragment = range.createContextualFragment(templateHtml);
      $repeater.appendChild(documentFragment);
      event.target.blur();
      this.updateSortable();
    }
  }

}

/* harmony default export */ __webpack_exports__["default"] = (TWER_WIDGETS);

/***/ }),

/***/ "./node_modules/@babel/runtime/helpers/esm/defineProperty.js":
/*!*******************************************************************!*\
  !*** ./node_modules/@babel/runtime/helpers/esm/defineProperty.js ***!
  \*******************************************************************/
/***/ (function(__unused_webpack___webpack_module__, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": function() { return /* binding */ _defineProperty; }
/* harmony export */ });
function _defineProperty(obj, key, value) {
  if (key in obj) {
    Object.defineProperty(obj, key, {
      value: value,
      enumerable: true,
      configurable: true,
      writable: true
    });
  } else {
    obj[key] = value;
  }

  return obj;
}

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	!function() {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = function(module) {
/******/ 			var getter = module && module.__esModule ?
/******/ 				function() { return module['default']; } :
/******/ 				function() { return module; };
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	!function() {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = function(exports, definition) {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be in strict mode.
!function() {
"use strict";
/*!**************************************!*\
  !*** ./src/js/admin/treweler-map.js ***!
  \**************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _modules_layers__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./modules/layers */ "./src/js/admin/modules/layers.js");
/* harmony import */ var a_color_picker__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! a-color-picker */ "./node_modules/a-color-picker/dist/acolorpicker.js");
/* harmony import */ var a_color_picker__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(a_color_picker__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _modules_widgets__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./modules/widgets */ "./src/js/admin/modules/widgets.js");
/* harmony import */ var _modules_widgets_marker__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./modules/widgets-marker */ "./src/js/admin/modules/widgets-marker.js");
/* harmony import */ var _modules_uploads__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./modules/uploads */ "./src/js/admin/modules/uploads.js");
/* harmony import */ var _modules_controls__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./modules/controls */ "./src/js/admin/modules/controls.js");




const {
  __
} = wp.i18n;
window.TWER = {};
var geo;
let worldsList = {};
/**
 * Insert a string at a specific index
 */

if (!String.prototype.splice) {
  /**
   * {JSDoc}
   *
   * The splice() method changes the content of a string by removing a range of
   * characters and/or adding new characters.
   *
   * @this {String}
   * @param {number} start Index at which to start changing the string.
   * @param {number} delCount An integer indicating the number of old chars to remove.
   * @param {string} newSubStr The String that is spliced in.
   * @return {string} A new string with the spliced substring.
   */
  String.prototype.splice = function (start, delCount, newSubStr) {
    return this.slice(0, start) + newSubStr + this.slice(start + Math.abs(delCount));
  };
}

jQuery.noConflict();

(function ($) {
  $(function () {
    const $switchBearing = $('#treweler-camera-bearing');
    const $switchPitch = $('#treweler-camera-pitch');
    const $initialPitch = $('#treweler-camera-initial-pitch');
    const $initialPitchRange = $('#treweler-camera-initial-pitch-range');
    const $initialBearing = $('#treweler-camera-initial-bearing');
    const $initialBearingRange = $('#treweler-camera-initial-bearing-range');
    const $minPitchRange = $('#treweler-camera-min-pitch-range');
    const $minPitch = $('#range-treweler-camera-pitch-mr');
    const $maxPitchRange = $('#treweler-camera-max-pitch-range');
    const $maxPitch = $('#range-treweler-camera-pitch-mr-right');
    const mapGeolocateControl = new mapboxgl.GeolocateControl({
      positionOptions: {
        enableHighAccuracy: true
      },
      showAccuracyCircle: false,
      trackUserLocation: true,
      showUserHeading: true
    });
    /**
     * Initialize map
     */

    function init_map() {
      let lat = $('#latitude').val().trim() != '' ? $('#latitude').val().trim() : '0.1',
          lng = $('#longitude').val().trim() != '' ? $('#longitude').val().trim() : '0.1',
          zoom = $('#setZoom').val().trim() != '' ? $('#setZoom').val() : 0.00,
          minZ = parseFloat($('#setZoom_min_range').val()) != 0 ? parseFloat($('#setZoom_min_range').val()) : 0,
          maxZ = parseFloat($('#setZoom_max_range').val()) != 0 ? parseFloat($('#setZoom_max_range').val()) : 24,
          iniPitch = parseInt($initialPitch.val()) != 0 ? parseFloat($initialPitch.val()).toFixed(2) : 0,
          iniBearing = parseInt($initialBearing.val()) != 0 ? parseFloat($initialBearing.val()).toFixed(2) : 0,
          minPitch = $switchPitch.prop('checked') ? parseFloat($minPitch.val()).toFixed(2) : 0,
          maxPitch = $switchPitch.prop('checked') ? parseFloat($maxPitch.val()).toFixed(2) : 85,
          styleType = $('#custom_style').val().trim() != '' ? $('#custom_style').val() : $('#map_styles').val(),
          lightPreset = $('#map_light_preset').val();
      const wordmarkPosition = document.getElementById('twer-wordmark-position');
      const attributionPosition = document.getElementById('twer-attribution-position');
      const compactAttribution = document.getElementById('twer-compact-attribution');

      function prepare_regions(choosedRegion) {
        if (!choosedRegion) return false;
        const [column, value = '', adminArea = '', adminNum = ''] = choosedRegion.split('_');
        return {
          column: column.toUpperCase().replace(/ /g, '_'),
          value: value,
          admin: adminArea.toUpperCase().replace(/ /g, '_'),
          admin_num: parseInt(adminNum)
        };
      }

      const projectionInput = document.getElementById('treweler_map_projection');

      if (lng === '0') {
        lng = 0.1;
      }

      if (lat === '0') {
        lat = 0.1;
      }

      mapboxgl.accessToken = twer_ajax.api_key;
      TWER.map = new mapboxgl.Map({
        container: 'map',
        style: styleType,
        center: [lng, lat],
        minZoom: minZ,
        maxZoom: maxZ,
        zoom: zoom,
        bearing: iniBearing,
        pitch: iniPitch,
        maxPitch: maxPitch,
        minPitch: minPitch,
        attributionControl: false,
        logoPosition: wordmarkPosition.options[wordmarkPosition.selectedIndex].value,
        projection: {
          name: projectionInput.value
        }
      });
      new _modules_layers__WEBPACK_IMPORTED_MODULE_0__["default"]();
      TWER.map.on('style.load', () => {
        TWER.map.setFog({});

        if ($('#map_styles').val() === 'mapbox://styles/mapbox/standard-beta' && $('#custom_style').val().trim() === '') {
          TWER.map.setConfigProperty('basemap', 'lightPreset', lightPreset);
        }
      });
      projectionInput.addEventListener('change', e => {
        TWER.map.setProjection(e.target.value);
      });
      let selectStateIds = [];
      let selectStateIdsColors = [];
      let hiddenRegionsIds = new Set();

      function generateFeatureStateFilter() {
        let settings = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};
        const fillMain = 'main' in settings ? settings.main : $('#treweler-boundaries-fill-main .input-color').val();
        const fillHover = 'hover' in settings ? settings.hover : $('#treweler-boundaries-fill-hover .input-color').val();
        const fillSelect = 'select' in settings ? settings.select : $('#treweler-boundaries-fill-selected .input-color').val();
        selectStateIdsColors = selectStateIdsColors.length > 0 ? selectStateIdsColors : $('#treweler-boundaries-regions-custom-colors').val().trim();

        if (!Array.isArray(selectStateIdsColors)) {
          if (selectStateIdsColors === '') {
            selectStateIdsColors = '[]';
          }

          selectStateIdsColors = JSON.parse(selectStateIdsColors);
        }

        const filter = ['match', ['feature-state', 'action'], 'hover', fillHover, 'select', fillSelect, 'unselect', fillHover, 'unhover', fillMain, fillMain];

        if (selectStateIdsColors.length > 0) {
          let spliceCounter = 0;

          for (let i = 0; i < selectStateIdsColors.length; i++) {
            if (selectStateIdsColors[i].active) {
              let splice1 = 2 + spliceCounter;
              let splice2 = 3 + spliceCounter;
              filter.splice(splice1, 0, `customize_${selectStateIdsColors[i].id}`);
              filter.splice(splice2, 0, selectStateIdsColors[i].color);
              spliceCounter = spliceCounter + 2;
            }
          }
        }

        return filter;
      }

      function fillRegionColor(featureId) {
        let settings = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};
        const action = 'action' in settings ? settings.action : false;
        const filter = generateFeatureStateFilter(settings);

        for (let accuracy in worldsList) {
          TWER.map.setPaintProperty(`boundaries-${accuracy}-layer`, 'fill-color', filter);

          if (action) {
            let stateAction = action;

            switch (action) {
              case 'customize':
                stateAction = `customize_${featureId}`;
                break;
            }

            TWER.map.setFeatureState({
              source: accuracy,
              id: featureId
            }, {
              action: stateAction
            });
          }
        }
      }

      function selectRegions() {
        selectStateIds = selectStateIds.length > 0 ? selectStateIds : $('#treweler-boundaries-regions-selected').val().trim();

        if (!Array.isArray(selectStateIds)) {
          if (selectStateIds === '') {
            selectStateIds = '[]';
          }

          selectStateIds = JSON.parse(selectStateIds);
        }

        selectStateIdsColors = selectStateIdsColors.length > 0 ? selectStateIdsColors : $('#treweler-boundaries-regions-custom-colors').val().trim();

        if (!Array.isArray(selectStateIdsColors)) {
          if (selectStateIdsColors === '') {
            selectStateIdsColors = '[]';
          }

          selectStateIdsColors = JSON.parse(selectStateIdsColors);
        }

        if (selectStateIds.length > 0) {
          for (let i = 0; i < selectStateIds.length; i++) {
            fillRegionColor(selectStateIds[i], {
              action: 'select'
            });
          }
        }

        if (selectStateIdsColors.length > 0) {
          for (let i = 0; i < selectStateIdsColors.length; i++) {
            if (selectStateIdsColors[i].active && selectStateIds.includes(selectStateIdsColors[i].id)) {
              fillRegionColor(selectStateIdsColors[i].id, {
                action: 'customize'
              });
            }
          }
        }
      }

      function selectHiddenRegions() {
        hiddenRegionsIds = hiddenRegionsIds.size !== 0 ? hiddenRegionsIds : $('#treweler-boundaries-regions-hide').val().trim();

        if (typeof hiddenRegionsIds === 'string') {
          if (hiddenRegionsIds === '') {
            hiddenRegionsIds = '[]';
          }

          hiddenRegionsIds = new Set(JSON.parse(hiddenRegionsIds));
        }

        const regions = prepare_regions($('#treweler-boundaries-regions').val());
        let filter = ['all'];

        if ($('#treweler-boundaries-regions').val() !== 'world') {
          filter.push(['==', regions.column, regions.value]);

          if (regions.admin !== '') {
            filter.push(['==', regions.admin, regions.admin_num]);
          }
        } else {//filter.push(['!=', 'COUNTRY', 'France']);
        }

        if (hiddenRegionsIds.size !== 0) {
          hiddenRegionsIds.forEach(name => {
            filter.push(['!=', 'NAME', name]);
          });

          for (let key in worldsList) {
            TWER.map.setFilter(`boundaries-${key}-layer`, filter);
            TWER.map.setFilter(`boundaries-${key}-line-layer`, filter);
          }
        }
      }

      const wcv = $('#world_copy').prop('checked');
      TWER.map.setRenderWorldCopies(wcv);
      $('#world_copy').on('change', function () {
        TWER.map.setRenderWorldCopies($(this).prop('checked'));
      });
      TWER.map.on('load', async () => {
        let coloroverlay = $('#overlay-style-map').val();
        TWER.map.addLayer({
          id: 'bg-layer',
          type: 'background',
          paint: {
            'background-color': coloroverlay
          }
        });
      });

      function forEachLayer(text, cb) {
        TWER.map.getStyle().layers.forEach(layer => {
          if (!layer.id.includes(text)) return;
          cb(layer);
        });
      }

      function changeStyle(style) {
        const savedLayers = [];
        const savedSources = {};
        const layerGroups = ['bg-layer', 'boundaries-very_high-layer', 'boundaries-high-layer', 'boundaries-low-layer', 'boundaries-very_low-layer', 'boundaries-medium-layer', 'boundaries-very_high-line-layer', 'boundaries-high-line-layer', 'boundaries-low-line-layer', 'boundaries-very_low-line-layer', 'boundaries-medium-line-layer'];
        layerGroups.forEach(layerGroup => {
          forEachLayer(layerGroup, layer => {
            if (layer.source) {
              savedSources[layer.source] = TWER.map.getSource(layer.source).serialize();
            }

            savedLayers.push(layer);
          });
        });
        TWER.map.setStyle(style);
        setTimeout(() => {
          Object.entries(savedSources).forEach(_ref => {
            let [id, source] = _ref;
            TWER.map.addSource(id, source);
          });

          if (savedLayers.length > 0) {
            savedLayers.forEach(layer => {
              //console.log(layer);
              if (!TWER.map.getLayer(layer.id)) {
                TWER.map.addLayer(layer);
              }
            });
          }

          if (selectStateIds.length > 0) {
            for (let i = 0; i < selectStateIds.length; i++) {
              for (let key in worldsList) {
                TWER.map.setFeatureState({
                  source: key,
                  id: selectStateIds[i]
                }, {
                  action: 'select'
                });
              }
            }
          } else {
            if ($('#treweler-boundaries').prop('checked')) {
              selectRegions();
              selectHiddenRegions();
            }
          }
        }, 1000);
      }
      /**
       * Change center point
       */


      $('#map_styles').on('change', function () {
        if ($('#custom_style').val().trim() !== '') return;
        let styleType = $(this).val();
        changeStyle(styleType);

        if ($('#map_styles').val() === 'mapbox://styles/mapbox/standard-beta') {
          $('#map_light_preset').closest('.js-twer-row').removeClass('d-none');
        } else {
          $('#map_light_preset').closest('.js-twer-row').addClass('d-none');
        }

        if ($('#map_styles').val() === 'mapbox://styles/mapbox/standard-beta') {
          TWER.map.setConfigProperty('basemap', 'lightPreset', $('#map_light_preset').val());
        }
      });
      $('#custom_style').on('change', function () {
        let styleType = $(this).val();

        if (styleType.trim() === '') {
          styleType = $('#map_styles').val();
          $('#twer-nav-layers-tab').removeClass('d-none');
        } else {
          $('#twer-nav-layers-tab').addClass('d-none');
          $('#twer-nav-general-tab').tab('show'); //$("input[type='checkbox'][name^='_treweler_map_layers']").prop('checked', true);
        }

        changeStyle(styleType);
        $('#map_light_preset').closest('.js-twer-row').addClass('d-none');
      });
      $('#map_light_preset').on('change', function () {
        if ($('#map_styles').val() === 'mapbox://styles/mapbox/standard-beta' && $('#custom_style').val().trim() === '') {
          TWER.map.setConfigProperty('basemap', 'lightPreset', $('#map_light_preset').val());
        }
      });

      function toggleRestrictFields(value) {
        if (typeof value === 'undefined') {
          value = $('#treweler-restrict-panning').prop('checked');
        }

        if (value) {
          $('.section-treweler-restrict-panning-southwest, .section-treweler-restrict-panning-northeast').css('display', 'table-row');
        } else {
          $('.section-treweler-restrict-panning-southwest, .section-treweler-restrict-panning-northeast').css('display', 'none');
        }
      }

      $(document).on('change', '#treweler-restrict-panning', e => {
        toggleRestrictFields(e.target.checked);
      });
      toggleRestrictFields();
      /**
       * Get Lat/Lng, zoom value on zoom
       */

      TWER.map.on('zoom', function () {
        /* If latlng preview is checked */
        if ($('#latlng_map_prev').prop('checked')) {
          let llZ = TWER.map.getCenter();
          $('#longitude').val(llZ.lng);
          $('#latitude').val(llZ.lat);
        }
        /* If zoom preview is checked */


        if ($('#zoom_map_prev').prop('checked')) {
          let zoomZ = parseFloat(TWER.map.getZoom()).toFixed(2);

          if (zoomZ.trim() == '' || zoomZ.trim() == 'NaN' || zoomZ == 0.00 || zoomZ == 0.23) {
            zoomZ = 0;
          }

          $('#setZoom_range').val(zoomZ);
          $('#setZoom').val(zoomZ);
        }
      });
      /**
       * Add Map DCompact attribution
       */

      TWER.map.addControl(new mapboxgl.AttributionControl({
        compact: compactAttribution.checked
      }), attributionPosition.options[attributionPosition.selectedIndex].value);
      /**
       * Add Map Diststance Scale Control
       */

      if ($('#treweler-map-controls-distance-scale').length && $('#treweler-map-controls-distance-scale').prop('checked')) {
        const unit = $('#treweler-map-controls-distance-unit').val();
        TWER.map.addControl(new mapboxgl.ScaleControl({
          maxWidth: 100,
          unit: unit ? unit : 'imperial'
        }), $('#treweler-map-controls-distance-position').val());
      }
      /**
       * Add Map Fullscreen Control
       */


      if ($('#treweler-map-controls-fullscreen').length && $('#treweler-map-controls-fullscreen').prop('checked')) {
        TWER.map.addControl(new mapboxgl.FullscreenControl(), $('#treweler-map-controls-fullscreen-position').val()); //$(TWER.map._container).find('.mapboxgl-ctrl-fullscreen').parent('.mapboxgl-ctrl-group').addClass('treweler-fs-ctrl');
      }
      /**
       * Add Map Search Control
       */


      if ($('#treweler-map-controls-search').length && $('#treweler-map-controls-search').prop('checked')) {
        TWER.map.addControl(geo = new MapboxGeocoder({
          accessToken: mapboxgl.accessToken,
          zoom: 14,
          placeholder: 'Enter search...',
          mapboxgl: mapboxgl,
          marker: false
        }), $('#treweler-map-controls-search-position').val());
        geo.on('result', function (res) {
          let latlng = res.result.center;
          $('#latitude').val(latlng[1]);
          $('#longitude').val(latlng[0]);
        });
      }
      /**
       * Add Map Zoom Pan Control
       */


      if ($('#treweler-map-controls-zoom-pan').length && $('#treweler-map-controls-zoom-pan').prop('checked')) {
        TWER.map.addControl(new mapboxgl.NavigationControl(), $('#treweler-map-controls-zoom-pan-position').val()); //top-left , top-right , bottom-left , bottom-right
        //$(TWER.map._container).find('.mapboxgl-ctrl-zoom-in').parent('.mapboxgl-ctrl-group').addClass('treweler-zp-ctrl');
      }
      /**
       * Add Map Geolocate Control
       */


      if ($('#treweler-map-controls-geolocate').length && $('#treweler-map-controls-geolocate').prop('checked')) {
        TWER.map.addControl(mapGeolocateControl, $('#treweler-map-controls-geolocate-position').val());

        if ($('#treweler-map-controls-geolocate-style').val() === 'treweler-style') {
          mapGeolocateControl._container.classList.add('twer-geolocation-control');
        } else {
          mapGeolocateControl._container.classList.remove('twer-geolocation-control');
        }
      }
      /**
       * If 'Use the map preview' is checked for latlng
       */


      if ($('#latlng_map_prev').length && $('#latlng_map_prev').prop('checked')) {
        $('#latitude').attr('readonly', 'readonly');
        $('#longitude').attr('readonly', 'readonly');
        /* Enable Map Drag */

        TWER.map.dragPan.enable();
        TWER.map.dragRotate.enable();
        TWER.map.on('drag', function () {
          let lnglatC = TWER.map.getCenter();
          $('#longitude').val(lnglatC.lng);
          $('#latitude').val(lnglatC.lat);
        });
      } else {
        $('#latitude').removeAttr('readonly');
        $('#longitude').removeAttr('readonly');
        /* Disable Map Drag */

        TWER.map.dragPan.disable();
        TWER.map.dragRotate.disable();
      }
      /**
       * If 'Use the map preview' is checked for zoom
       */


      if ($('#zoom_map_prev').length && $('#zoom_map_prev').prop('checked')) {
        $('#setZoom_range').attr('disabled', 'disabled');
        $('#setZoom').attr('readonly', 'readonly');
        /* Enable Map Zoom on click/scroll */

        TWER.map.doubleClickZoom.enable();
        TWER.map.scrollZoom.enable();

        if (!$('#latlng_map_prev').prop('checked') && $('#zoom_map_prev').prop('checked')) {
          TWER.map.on('wheel', function (e) {
            let mZoom = parseFloat(TWER.map.getZoom()).toFixed(2),
                latW = parseFloat($('#latitude').val()),
                lngW = parseFloat($('#longitude').val());
            TWER.map.scrollZoom.setWheelZoomRate(1);
            TWER.map.zoomTo(mZoom, {
              center: [lngW, latW]
            });
          });
          TWER.map.on('dblclick', function (e) {
            if (!$('#latlng_map_prev').prop('checked') && $('#zoom_map_prev').prop('checked')) {
              e.preventDefault();
              let dcZoom = parseInt(TWER.map.getZoom()),
                  latDC = parseFloat($('#latitude').val()),
                  lngDC = parseFloat($('#longitude').val());
              $('#setZoom').val(dcZoom);
              $('#setZoom_range').val(dcZoom);
              e.lngLat.lng = lngDC;
              e.lngLat.lat = latDC;
              e._defaultPrevented = false;
              TWER.map.doubleClickZoom.enable();
              TWER.map.zoomTo(dcZoom, {
                center: [lngDC, latDC]
              });
            }
          });
        }
      } else {
        $('#setZoom_range').removeAttr('disabled');
        $('#setZoom').removeAttr('readonly');
        /* Disable Map Zoom on click/scroll */

        TWER.map.doubleClickZoom.disable();
        TWER.map.scrollZoom.disable();
      }
    }

    if ($('#map').length) {
      init_map();
      $('.section-treweler-map-controls select').on('change', function () {
        const position = $(this).val();
        const id = $(this).attr('id');

        switch (id) {
          case 'treweler-map-controls-distance-position':
            if ($('#treweler-map-controls-distance-scale').prop('checked')) {
              TWER.map._controls.forEach((value, index) => {
                if (value.constructor.name === 'ScaleControl') {
                  $(TWER.map._container).find('.mapboxgl-ctrl-scale').remove();
                  const unit = $('#treweler-map-controls-distance-unit').val();
                  console.log(unit);
                  TWER.map.addControl(new mapboxgl.ScaleControl({
                    maxWidth: 100,
                    unit: unit ? unit : 'imperial'
                  }), position);
                }
              });
            }

            break;

          case 'treweler-map-controls-fullscreen-position':
            if ($('#treweler-map-controls-fullscreen').prop('checked')) {
              TWER.map._controls.forEach((value, index) => {
                if (value.constructor.name === 'FullscreenControl') {
                  $(TWER.map._container).find('.mapboxgl-ctrl-fullscreen').parent('.mapboxgl-ctrl-group').remove();
                  TWER.map.addControl(new mapboxgl.FullscreenControl(), position);
                }
              });
            }

            break;

          case 'treweler-map-controls-search-position':
            if ($('#treweler-map-controls-search').prop('checked')) {
              $(TWER.map._container).find('.mapboxgl-ctrl-geocoder').remove();
              var geo = new MapboxGeocoder({
                accessToken: mapboxgl.accessToken,
                zoom: 14,
                placeholder: 'Enter search...',
                mapboxgl: mapboxgl,
                marker: false
              });
              TWER.map.addControl(geo, position);
              geo.on('result', function (res) {
                let latlng = res.result.center;
                $('#latitude').val(latlng[1]);
                $('#longitude').val(latlng[0]);
              });
            }

            break;

          case 'treweler-map-controls-zoom-pan-position':
            if ($('#treweler-map-controls-zoom-pan').prop('checked')) {
              TWER.map._controls.forEach((value, index) => {
                if (value.constructor.name === 'NavigationControl') {
                  $(TWER.map._container).find('.mapboxgl-ctrl-zoom-in').parent('.mapboxgl-ctrl-group').remove();
                  TWER.map.addControl(new mapboxgl.NavigationControl(), position);
                }
              });
            }

            break;

          case 'treweler-map-controls-geolocate-position':
            if ($('#treweler-map-controls-geolocate').prop('checked')) {
              TWER.map.removeControl(mapGeolocateControl);
              TWER.map.addControl(mapGeolocateControl, position);

              if ($('#treweler-map-controls-geolocate-style').val() === 'treweler-style') {
                mapGeolocateControl._container.classList.add('twer-geolocation-control');
              } else {
                mapGeolocateControl._container.classList.remove('twer-geolocation-control');
              }
            }

            break;

          case 'treweler-map-controls-geolocate-style':
            if ($('#treweler-map-controls-geolocate').prop('checked')) {
              const currentStyles = $('#treweler-map-controls-geolocate-style').val();

              if (currentStyles === 'treweler-style') {
                $('.mapboxgl-ctrl-geolocate').parent().addClass('twer-geolocation-control');
              } else {
                $('.mapboxgl-ctrl-geolocate').parent().removeClass('twer-geolocation-control');
              }
            }

            break;
        }
      });
      $('#treweler-map-controls-distance-unit').on('change', function () {
        const unit = $(this).val();

        if ($('#treweler-map-controls-distance-scale').prop('checked')) {
          TWER.map._controls.forEach((value, index) => {
            if (value.constructor.name === 'ScaleControl') {
              $(TWER.map._container).find('.mapboxgl-ctrl-scale').remove();
              TWER.map.addControl(new mapboxgl.ScaleControl({
                maxWidth: 100,
                unit: unit ? unit : 'imperial'
              }), $('#treweler-map-controls-distance-position').val());
            }
          });
        }
      });
      /* Controls */

      $('input[type="checkbox"]').on('change', function () {
        /* Distance Scale Control */
        if ($(this).val() === 'distance_scale') {
          const unit = $('#treweler-map-controls-distance-unit').val();
          console.log(unit);
          var ds = new mapboxgl.ScaleControl({
            maxWidth: 100,
            unit: unit ? unit : 'imperial'
          });

          if ($(this).prop('checked')) {
            TWER.map.addControl(ds, $('#treweler-map-controls-distance-position').val());
          } else {
            $(TWER.map._container).find('.mapboxgl-ctrl-scale').remove();
          }
        }
        /* Fullscreen control */


        if ($(this).val() === 'fullscreen') {
          var fs = new mapboxgl.FullscreenControl();

          if ($(this).prop('checked')) {
            TWER.map.addControl(fs, $('#treweler-map-controls-fullscreen-position').val()); //$(TWER.map._container).find('.mapboxgl-ctrl-fullscreen').parent('.mapboxgl-ctrl-group').addClass('treweler-fs-ctrl');
          } else {
            $(TWER.map._container).find('.mapboxgl-ctrl-fullscreen').parent('.mapboxgl-ctrl-group').remove();
          }
        }
        /* Search Control */


        if ($(this).val() === 'search') {
          if ($(this).prop('checked')) {
            var geo = new MapboxGeocoder({
              accessToken: mapboxgl.accessToken,
              zoom: 14,
              placeholder: 'Enter search...',
              mapboxgl: mapboxgl,
              marker: false
            });
            TWER.map.addControl(geo, $('#treweler-map-controls-search-position').val());
            geo.on('result', function (res) {
              let latlng = res.result.center;
              $('#latitude').val(latlng[1]);
              $('#longitude').val(latlng[0]);
            });
          } else {
            $(TWER.map._container).find('.mapboxgl-ctrl-geocoder').remove();
          }
        }
        /* Zoom & Pan Control */


        if ($(this).val() === 'zoom_pan') {
          var zp = new mapboxgl.NavigationControl();

          if ($(this).prop('checked')) {
            TWER.map.addControl(zp, $('#treweler-map-controls-zoom-pan-position').val()); //$(TWER.map._container).find('.mapboxgl-ctrl-zoom-in').parent('.mapboxgl-ctrl-group').addClass('treweler-zp-ctrl');
          } else {
            $(TWER.map._container).find('.mapboxgl-ctrl-zoom-in').parent('.mapboxgl-ctrl-group').remove();
          }
        }
        /*Geolocate control*/


        if ($(this).val() === 'geolocate') {
          if ($(this).prop('checked')) {
            TWER.map.addControl(mapGeolocateControl, $('#treweler-map-controls-geolocate-position').val()); //$(TWER.map._container).find('.mapboxgl-ctrl-geolocate').parent('.mapboxgl-ctrl-group').addClass('treweler-go-ctrl');

            if ($('#treweler-map-controls-geolocate-style').val() === 'treweler-style') {
              mapGeolocateControl._container.classList.add('twer-geolocation-control');
            } else {
              mapGeolocateControl._container.classList.remove('twer-geolocation-control');
            }
          } else {
            TWER.map.removeControl(mapGeolocateControl);
          }
        }
      });
      /**
       * Enable Map Pan If "Use the map preview" is checked
       */

      $('input[type="checkbox"]#latlng_map_prev, input[type="checkbox"]#zoom_map_prev').on('change', function () {
        /* Map View Point Control Preview */
        if ($(this).attr('id') == 'latlng_map_prev') {
          if ($(this).prop('checked')) {
            $('#latitude').attr('readonly', 'readonly');
            $('#longitude').attr('readonly', 'readonly');
            /* Enable Map Drag */

            TWER.map.dragPan.enable();
            TWER.map.dragRotate.enable();
            TWER.map.on('drag', function () {
              let lnglatC = TWER.map.getCenter();
              $('#longitude').val(lnglatC.lng);
              $('#latitude').val(lnglatC.lat);
            });
          } else {
            $('#latitude').removeAttr('readonly');
            $('#longitude').removeAttr('readonly');
            /* Disable Map Drag */

            TWER.map.dragPan.disable();
            TWER.map.dragRotate.disable();
          }
        }
        /* Map Zoom Control Preview */


        if ($(this).attr('id') == 'zoom_map_prev') {
          if ($(this).prop('checked')) {
            $('#setZoom_range').attr('disabled', 'disabled');
            $('#setZoom').attr('readonly', 'readonly');
            /* Enable Map Zoom on click/scroll */

            TWER.map.doubleClickZoom.enable();
            TWER.map.scrollZoom.enable();
            TWER.map.dragRotate.enable();
          } else {
            $('#setZoom_range').removeAttr('disabled');
            $('#setZoom').removeAttr('readonly');
            /* Disable Map Zoom on click/scroll */

            TWER.map.doubleClickZoom.disable();
            TWER.map.scrollZoom.disable();
            TWER.map.dragRotate.disable();
          }
        }
        /* Map Latlng prev checkbox unchecked & zoom prev checked */


        if (!$('#latlng_map_prev').prop('checked') && $('#zoom_map_prev').prop('checked')) {
          TWER.map.on('wheel', function (e) {
            if (!$('#latlng_map_prev').prop('checked') && $('#zoom_map_prev').prop('checked')) {
              TWER.map.scrollZoom.setWheelZoomRate(1);
              let mZoom = parseFloat(TWER.map.getZoom()).toFixed(2),
                  latW = parseFloat($('#latitude').val()),
                  lngW = parseFloat($('#longitude').val());
              TWER.map.zoomTo(mZoom, {
                center: [lngW, latW]
              });
            }
          });
          TWER.map.on('dblclick', function (e) {
            if (!$('#latlng_map_prev').prop('checked') && $('#zoom_map_prev').prop('checked')) {
              e.preventDefault();
              let dcZoom = parseInt(TWER.map.getZoom()),
                  latDC = parseFloat($('#latitude').val()),
                  lngDC = parseFloat($('#longitude').val());
              $('#setZoom').val(dcZoom);
              $('#setZoom_range').val(dcZoom);
              e.lngLat.lng = lngDC;
              e.lngLat.lat = latDC;
              e._defaultPrevented = false;
              TWER.map.doubleClickZoom.enable();
              TWER.map.zoomTo(dcZoom, {
                center: [lngDC, latDC]
              });
            }
          });
        }
      });
      /**
       * Change zoom level based on control value
       */

      $('#latitude, #longitude').on('change keyup', function () {
        if ($('#latitude').val().trim() != '' && $('#longitude').val().trim() != '') {
          TWER.map.setCenter([$('#longitude').val(), $('#latitude').val()]);
        }
      });
      /**
       * Change zoom level based on control value
       */

      $('#setZoom, #setZoom_range').on('input', function () {
        let zoomCC = parseFloat($(this).val()).toFixed(2),
            latN = parseFloat($('#latitude').val()),
            lngN = parseFloat($('#longitude').val());

        if (zoomCC.trim() == '' || zoomCC.trim() == 'NaN' || zoomCC == 0.00 || zoomCC == 0.23) {
          zoomCC = 0;
        }

        TWER.map.zoomTo(zoomCC, {
          center: [lngN, latN],
          duration: 2000
        });

        if ($(this).attr('id') == 'setZoom') {
          $('#setZoom_range').val(zoomCC);
        } else {
          $('#setZoom').val(zoomCC);
        }
      });
      /**
       * Change zoom level based on control value
       */

      $('.js-zoom-range, .js-zoom-range-input').on('input', function () {
        let zoomCC = parseFloat($(this).val()).toFixed(2);

        if (zoomCC.trim() == '' || zoomCC.trim() == 'NaN' || zoomCC == 0.00 || zoomCC == 0.23) {
          zoomCC = 0;
        }

        if ($(this).data('id') == 'range-input') {
          $(this).closest('.js-twer-range').find('.js-zoom-range').val(zoomCC);
        } else {
          $(this).closest('.js-twer-range').find('.js-zoom-range-input').val(zoomCC);
        }
      });
      $('.twer-root').each(function () {
        $(this).find('[data-toggle="tooltip"]').tooltip({
          container: $(this).closest('.twer-root')
        });
      });
      /**
       * Set zoom min/max level
       */

      $('#setZoom_min_range, #setZoom_max_range').on('input', function () {
        let lR = parseFloat($('#setZoom_min_range').val());
        let uR = parseFloat($('#setZoom_max_range').val());

        if ($(this).hasClass('lower-slider')) {
          if (!$(this).hasClass('active')) {
            $(this).addClass('active');
            $('.upper-slider').removeClass('active');
          }

          if (uR <= lR + 1) {
            $('#setZoom_max_range').val(lR + 2);

            if (uR == lR) {
              $('#setZoom_max_range').val(lR + 2);
            }
          }
        } else if ($(this).hasClass('upper-slider')) {
          if (!$(this).hasClass('active')) {
            $(this).addClass('active');
            $('.lower-slider').removeClass('active');
          }

          if (lR >= uR - 1) {
            $('#setZoom_min_range').val(uR - 2);

            if (uR == lR) {
              $('#setZoom_min_range').val(uR - 2);
            }
          }
        }

        let min = parseFloat($('#setZoom_min_range').val()),
            max = parseFloat($('#setZoom_max_range').val());
        $('#default_min_zoom').val(min);
        $('#default_max_zoom').val(max);
        $('#setZoom_range').attr({
          'min': min,
          'max': max
        });
        $('#setZoom').attr({
          'min': min,
          'max': max
        });

        if (min >= parseFloat($('#setZoom').val())) {
          $('#setZoom').val(min);
          $('#setZoom_range').val(min).trigger('input');
        } else if (max <= parseFloat($('#setZoom').val())) {
          $('#setZoom').val(max);
          $('#setZoom_range').val(max).trigger('input');
        }

        TWER.map.setMinZoom(min);
        TWER.map.setMaxZoom(max);
      });
      /**
       * Set zoom min/max level from input box
       */

      $('#default_min_zoom, #default_max_zoom').on('input', function () {
        let minI = parseFloat($('#default_min_zoom').val()),
            maxI = parseFloat($('#default_max_zoom').val());
        $('#setZoom_min_range').val(minI);
        $('#setZoom_max_range').val(maxI);
        $('#setZoom_range').attr({
          'min': minI,
          'max': maxI
        });
        $('#setZoom').attr({
          'min': minI,
          'max': maxI
        });

        if (minI >= parseFloat($('#setZoom').val())) {
          $('#setZoom').val(minI);
          $('#setZoom_range').val(minI).trigger('input');
        } else if (maxI <= parseFloat($('#setZoom').val())) {
          $('#setZoom').val(maxI);
          $('#setZoom_range').val(maxI).trigger('input');
        }

        TWER.map.setMinZoom(minI);
        TWER.map.setMaxZoom(maxI);
      });
    }
    /**
     * Color picker for map clusters
     */


    $('#color-picker-btn, .clr-picker span').on('click', function () {
      if ($('.color-picker').find('.a-color-picker').length === 0) {
        TWER_HELPERS.AColorPicker.from('.color-picker').on('change', (picker, color) => {
          $('.clr-picker span').css('background-color', picker.color);
          $('#clusterColor').val(picker.color);
          $('.color-picker').attr('acp-color', picker.color);
        }).on('coloradd', (picker, color) => {
          let cca = $('#addCustomColor');

          if (cca.val().indexOf('|' + color) === -1) {
            cca.val(cca.val() + '|' + color);
            jQuery.ajax({
              url: twer_ajax.url,
              type: 'POST',
              data: {
                action: 'treweler_add_colorpicker_custom_color',
                cust_color: cca.val()
              },
              success: function (response) {
                let eleCP = $('.color-picker'),
                    defaultCP = eleCP.attr('default-palette');
                eleCP.attr('acp-palette', defaultCP + '' + response);
                $('.color-picker-text-name').attr('acp-palette', defaultCP + '' + response);
                $('.color-picker-text-descr').attr('acp-palette', defaultCP + '' + response);
              }
            });
          }
        }).on('colorremove', (picker, color) => {
          let ccr = $('#addCustomColor');

          if (ccr.val().indexOf('|' + color) != -1) {
            let sc = ccr.val().replace('|' + color, '');
            ccr.val(sc);
            jQuery.ajax({
              url: twer_ajax.url,
              type: 'POST',
              data: {
                action: 'treweler_add_colorpicker_custom_color',
                cust_color: ccr.val()
              },
              success: function (response) {
                let eleCP = $('.color-picker'),
                    defaultCP = eleCP.attr('default-palette');
                eleCP.attr('acp-palette', defaultCP + '' + response);
                $('.color-picker-text-name').attr('acp-palette', defaultCP + '' + response);
                $('.color-picker-text-descr').attr('acp-palette', defaultCP + '' + response);
              }
            });
          }
        });
      } else {
        $('.color-picker').find('.a-color-picker').remove();
      }
    });
    $(window).on('click', function (event) {
      if (!$(event.target).hasClass('a-color-picker') && $(event.target).parents('.a-color-picker').length == 0 && $(event.target).attr('id') != 'color-picker-btn' && !$(event.target).hasClass('color-holder') && !$(event.target).hasClass('a-color-picker-palette-color')) {
        $('.color-picker').find('.a-color-picker').remove();
      }
    });
    $('#text-name-color-picker-btn, #map-text-color-name span').on('click', function () {
      if ($('.color-picker-text-name').find('.a-color-picker').length === 0) {
        TWER_HELPERS.AColorPicker.from('.color-picker-text-name').on('change', (picker, color) => {
          $('#map-text-color-name span').css('background-color', picker.color);
          $('#map_name_color').val(picker.color);
          $('.color-picker-text-name').attr('acp-color', picker.color);
        }).on('coloradd', (picker, color) => {
          let cca = $('#addCustomColor');

          if (cca.val().indexOf('|' + color) === -1) {
            cca.val(cca.val() + '|' + color);
            jQuery.ajax({
              url: twer_ajax.url,
              type: 'POST',
              data: {
                action: 'treweler_add_colorpicker_custom_color',
                cust_color: cca.val()
              },
              success: function (response) {
                let eleCP = $('.color-picker-text-name'),
                    defaultCP = eleCP.attr('default-palette');
                eleCP.attr('acp-palette', defaultCP + '' + response);
                $('.color-picker-text-descr').attr('acp-palette', defaultCP + '' + response);
                $('.color-picker').attr('acp-palette', defaultCP + '' + response);
              }
            });
          }
        }).on('colorremove', (picker, color) => {
          let ccr = $('#addCustomColor');

          if (ccr.val().indexOf('|' + color) != -1) {
            let sc = ccr.val().replace('|' + color, '');
            ccr.val(sc);
            jQuery.ajax({
              url: twer_ajax.url,
              type: 'POST',
              data: {
                action: 'treweler_add_colorpicker_custom_color',
                cust_color: ccr.val()
              },
              success: function (response) {
                let eleCP = $('.color-picker-text-name'),
                    defaultCP = eleCP.attr('default-palette');
                eleCP.attr('acp-palette', defaultCP + '' + response);
                $('.color-picker-text-descr').attr('acp-palette', defaultCP + '' + response);
                $('.color-picker').attr('acp-palette', defaultCP + '' + response);
              }
            });
          }
        });
      } else {
        $('.color-picker-text-name').find('.a-color-picker').remove();
      }
    });
    $(window).on('click', function (event) {
      if (!$(event.target).hasClass('a-color-picker') && $(event.target).parents('.a-color-picker').length == 0 && $(event.target).attr('id') != 'text-name-color-picker-btn' && !$(event.target).hasClass('color-holder') && !$(event.target).hasClass('a-color-picker-palette-color')) {
        $('.color-picker-text-name').find('.a-color-picker').remove();
      }
    });
    $('#text-descr-color-picker-btn, #map-text-color-descr span').on('click', function () {
      if ($('.color-picker-text-descr').find('.a-color-picker').length === 0) {
        TWER_HELPERS.AColorPicker.from('.color-picker-text-descr').on('change', (picker, color) => {
          $('#map-text-color-descr span').css('background-color', picker.color);
          $('#map_description_color').val(picker.color);
          $('.color-picker-text-descr').attr('acp-color', picker.color);
        }).on('coloradd', (picker, color) => {
          let cca = $('#addCustomColor');

          if (cca.val().indexOf('|' + color) === -1) {
            cca.val(cca.val() + '|' + color);
            jQuery.ajax({
              url: twer_ajax.url,
              type: 'POST',
              data: {
                action: 'treweler_add_colorpicker_custom_color',
                cust_color: cca.val()
              },
              success: function (response) {
                let eleCP = $('.color-picker-text-descr'),
                    defaultCP = eleCP.attr('default-palette');
                eleCP.attr('acp-palette', defaultCP + '' + response);
                $('.color-picker-text-name').attr('acp-palette', defaultCP + '' + response);
                $('.color-picker').attr('acp-palette', defaultCP + '' + response);
              }
            });
          }
        }).on('colorremove', (picker, color) => {
          let ccr = $('#addCustomColor');

          if (ccr.val().indexOf('|' + color) != -1) {
            let sc = ccr.val().replace('|' + color, '');
            ccr.val(sc);
            jQuery.ajax({
              url: twer_ajax.url,
              type: 'POST',
              data: {
                action: 'treweler_add_colorpicker_custom_color',
                cust_color: ccr.val()
              },
              success: function (response) {
                let eleCP = $('.color-picker-text-descr'),
                    defaultCP = eleCP.attr('default-palette');
                eleCP.attr('acp-palette', defaultCP + '' + response);
                $('.color-picker-text-name').attr('acp-palette', defaultCP + '' + response);
                $('.color-picker').attr('acp-palette', defaultCP + '' + response);
              }
            });
          }
        });
      } else {
        $('.color-picker-text-descr').find('.a-color-picker').remove();
      }
    });
    $(window).on('click', function (event) {
      if (!$(event.target).hasClass('a-color-picker') && $(event.target).parents('.a-color-picker').length == 0 && $(event.target).attr('id') != 'text-descr-color-picker-btn' && !$(event.target).hasClass('color-holder') && !$(event.target).hasClass('a-color-picker-palette-color')) {
        $('.color-picker-text-descr').find('.a-color-picker').remove();
      }
    }); // Universal init color pickers

    $('.js-twer-color-picker').on('click', function (event) {
      event.stopPropagation();
      var $colorPicker = $(this);
      var $colorPickerCell = $colorPicker.children('span');
      var $colorPickerWrap = $colorPicker.closest('.js-twer-color-picker-wrap');
      var $palette = $colorPickerWrap.find('.js-twer-color-picker-palette');
      var $colorInput = $colorPickerWrap.find('input[type="hidden"]');

      if ($palette.find('.a-color-picker').length === 0) {
        TWER_HELPERS.AColorPicker.from($palette[0]).on('change', (picker, color) => {
          $colorPickerCell.css('background-color', picker.color);
          $colorInput.val(picker.color);
          $palette.attr('acp-color', picker.color);
        }).on('coloradd', (picker, color) => {
          let cca = $('#addCustomColor');

          if (cca.val().indexOf('|' + color) === -1) {
            cca.val(cca.val() + '|' + color);
            jQuery.ajax({
              url: twer_ajax.url,
              type: 'POST',
              data: {
                action: 'treweler_add_colorpicker_custom_color',
                cust_color: cca.val()
              },
              success: function (response) {
                let defaultCP = $palette.attr('default-palette');
                $palette.attr('acp-palette', defaultCP + '' + response);
                $palette.attr('acp-palette', defaultCP + '' + response);
                $('.color-picker').attr('acp-palette', defaultCP + '' + response);
              }
            });
          }
        }).on('colorremove', (picker, color) => {
          let ccr = $('#addCustomColor');

          if (ccr.val().indexOf('|' + color) != -1) {
            let sc = ccr.val().replace('|' + color, '');
            ccr.val(sc);
            jQuery.ajax({
              url: twer_ajax.url,
              type: 'POST',
              data: {
                action: 'treweler_add_colorpicker_custom_color',
                cust_color: ccr.val()
              },
              success: function (response) {
                let defaultCP = $palette.attr('default-palette');
                $palette.attr('acp-palette', defaultCP + '' + response);
              }
            });
          }
        });
      } else {
        $palette.find('.a-color-picker').remove();
      }
    });
    $('.js-twer-color-picker-palette').on('click', function (event) {
      event.stopPropagation();
    });
    $(window).on('click', function () {
      $('.js-twer-color-picker-palette').find('.a-color-picker').remove();
    });
    /**
     * `shortcode` generation dynamic events
     */

    if ($('#sc_shortcode').length) {
      $('#sc_isFullwidth').on('change', function () {
        let sc = $('#sc_shortcode').val(),
            fw = 'type="fullwidth"';

        if ($(this).prop('checked') && sc.indexOf(fw) === -1) {
          sc = sc.splice(-1, 0, ' ' + fw);
          $('#sc_shortcode').val(sc);
        } else {
          sc = sc.replace(' ' + fw, '');
          $('#sc_shortcode').val(sc);
        }
      });
      $('#sc_isScrollZoom').on('change', function () {
        let sc = $('#sc_shortcode').val(),
            sz = 'scrollzoom="no"';

        if ($(this).prop('checked') && sc.indexOf(sz) === -1) {
          sc = sc.splice(-1, 0, ' ' + sz);
          $('#sc_shortcode').val(sc);
        } else {
          sc = sc.replace(' ' + sz, '');
          $('#sc_shortcode').val(sc);
        }
      });
      $('#sc_width, #sc_height').on('input', function () {
        let sc = $('#sc_shortcode').val();

        if ($(this).attr('id') === 'sc_width') {
          let w = 'width="' + $(this).val() + $('#sc_width_unit').val() + '"';

          if (sc.indexOf('width=') === -1) {
            sc = sc.splice(-1, 0, ' ' + w);
            $('#sc_shortcode').val(sc);
          } else {
            let lastIdx = sc.indexOf('"', sc.indexOf('width="') + 'width="'.length);
            sc = sc.replace(sc.substring(sc.indexOf(' width="'), lastIdx + 1), '');

            if ($(this).val().trim() != '' && !isNaN($(this).val())) {
              sc = sc.splice(-1, 0, ' ' + w);
            }

            $('#sc_shortcode').val(sc);
          }
        } else if ($(this).attr('id') === 'sc_height') {
          let h = 'height="' + $(this).val() + $('#sc_height_unit').val() + '"';

          if (sc.indexOf('height=') === -1) {
            sc = sc.splice(-1, 0, ' ' + h);
            $('#sc_shortcode').val(sc);
          } else {
            let lastIdx = sc.indexOf('"', sc.indexOf('height="') + 'height="'.length);
            sc = sc.replace(sc.substring(sc.indexOf(' height="'), lastIdx + 1), '');

            if ($(this).val().trim() != '' && !isNaN($(this).val())) {
              sc = sc.splice(-1, 0, ' ' + h);
            }

            $('#sc_shortcode').val(sc);
          }
        }
      });
      $('#sc_width_unit, #sc_height_unit').on('input', function () {
        let sc = $('#sc_shortcode').val();

        if ($(this).attr('id') === 'sc_width_unit') {
          let w = 'width="' + $('#sc_width').val() + $('#sc_width_unit').val() + '"';

          if (sc.indexOf('width=') === -1) {
            sc = sc.splice(-1, 0, ' ' + w);
            $('#sc_shortcode').val(sc);
          } else {
            let lastIdx = sc.indexOf('"', sc.indexOf('width="') + 'width="'.length);
            sc = sc.replace(sc.substring(sc.indexOf(' width="'), lastIdx + 1), '');

            if ($('#sc_width').val().trim() != '' && !isNaN($('#sc_width').val())) {
              sc = sc.splice(-1, 0, ' ' + w);
            }

            $('#sc_shortcode').val(sc);
          }
        } else if ($(this).attr('id') === 'sc_height_unit') {
          let h = 'height="' + $('#sc_height').val() + $('#sc_height_unit').val() + '"';

          if (sc.indexOf('height=') === -1) {
            sc = sc.splice(-1, 0, ' ' + h);
            $('#sc_shortcode').val(sc);
          } else {
            let lastIdx = sc.indexOf('"', sc.indexOf('height="') + 'height="'.length);
            sc = sc.replace(sc.substring(sc.indexOf(' height="'), lastIdx + 1), '');

            if ($('#sc_height').val().trim() != '' && !isNaN($('#sc_height').val())) {
              sc = sc.splice(-1, 0, ' ' + h);
            }

            $('#sc_shortcode').val(sc);
          }
        }
      });
      $('#copy_shortcode_btn').on('click', function () {
        document.getElementById('sc_shortcode').select();
        document.execCommand('copy');
      });
    }
    /**
     * Pitch & Bearing Options
     */


    const $sectionMultiRange = $('.section-treweler-camera-pitch-mr');
    /**
     * Pitch On Off Switch Trigger
     */

    if (!$switchBearing.is(':checked')) {
      $sectionMultiRange.hide();
    }

    $switchBearing.click(function () {
      if ($(this).prop('checked')) {
        $sectionMultiRange.show();
      } else {
        $sectionMultiRange.hide();
      }
    });
    window.addEventListener('click', function (event) {
      TWER.map.on('pitch', function () {
        let pitchData = parseFloat(TWER.map.getPitch()).toFixed(2);
        let bearingData = parseFloat(TWER.map.getBearing()).toFixed(2); // Set Pitch

        $initialPitch.val(pitchData);
        $initialPitchRange.val(pitchData); // Set Bearing

        $initialBearing.val(bearingData);
        $initialBearingRange.val(bearingData);
      });
    });

    function setInitialBearing(bearing) {
      let vB = parseFloat(bearing).toFixed(2);
      $initialBearing.val(vB);
      $initialBearingRange.val(vB);
      TWER.map.setBearing(vB);
    }

    function setInitialPitch(pitch) {
      let vP = parseFloat(pitch).toFixed(2);
      $initialPitch.val(vP);
      $initialPitchRange.val(vP);
      TWER.map.setPitch(vP);
    }
    /**
     * Change Pitch & Bearing level based on range value, input value
     *
     */


    $initialBearing.add($initialBearingRange).on('input', function () {
      setInitialBearing($initialBearing.val());
    });
    $initialPitch.add($initialPitchRange).on('input', function () {
      setInitialPitch($initialPitch.val());
    });
    /** Multirange **/

    /**
     * Set zoom min/max level
     */

    $('#range-treweler-camera-pitch-mr, #range-treweler-camera-pitch-mr-right').on('input', function () {
      let lR = parseFloat($('#range-treweler-camera-pitch-mr').val());
      let uR = parseFloat($('#range-treweler-camera-pitch-mr-right').val());

      if ($(this).hasClass('lower-slider')) {
        if (!$(this).hasClass('active')) {
          $(this).addClass('active');
          $('.upper-slider').removeClass('active');
        }

        if (uR <= lR + 1) {
          $('#range-treweler-camera-pitch-mr-right').val(lR + 2);

          if (uR == lR) {
            $('#range-treweler-camera-pitch-mr-right').val(lR + 2);
          }
        }
      } else if ($(this).hasClass('upper-slider')) {
        if (!$(this).hasClass('active')) {
          $(this).addClass('active');
          $('.lower-slider').removeClass('active');
        }

        if (lR >= uR - 1) {
          $('#range-treweler-camera-pitch-mr').val(uR - 2);

          if (uR == lR) {
            $('#range-treweler-camera-pitch-mr').val(uR - 2);
          }
        }
      }

      let min = parseFloat($('#range-treweler-camera-pitch-mr').val()),
          max = parseFloat($('#range-treweler-camera-pitch-mr-right').val());
      $('#num-treweler-camera-pitch-mr').val(min);
      $('#num-treweler-camera-pitch-mr-right').val(max);
      $initialPitchRange.attr({
        'min': min,
        'max': max
      });
      $initialPitch.attr({
        'min': min,
        'max': max
      });

      if (min >= parseFloat($initialPitch.val())) {
        $initialPitch.val(min);
        $initialPitchRange.val(min).trigger('input');
      } else if (max <= parseFloat($initialPitch.val())) {
        $initialPitch.val(max);
        $initialPitchRange.val(max).trigger('input');
      }

      TWER.map.setMinPitch(min);
      TWER.map.setMaxPitch(max);
    });
    /**
     * Set zoom min/max level from input box
     */

    $('#num-treweler-camera-pitch-mr, #num-treweler-camera-pitch-mr-right').on('input', function () {
      let minI = parseFloat($('#num-treweler-camera-pitch-mr').val()),
          maxI = parseFloat($('#num-treweler-camera-pitch-mr-right').val());
      $('#range-treweler-camera-pitch-mr').val(minI);
      $('#range-treweler-camera-pitch-mr-right').val(maxI);
      $initialPitchRange.attr({
        'min': minI,
        'max': maxI
      });
      $initialPitch.attr({
        'min': minI,
        'max': maxI
      });

      if (minI >= parseFloat($initialPitch.val())) {
        $initialPitch.val(minI);
        $initialPitchRange.val(minI).trigger('input');
      } else if (maxI <= parseFloat($initialPitch.val())) {
        $initialPitch.val(maxI);
        $initialPitchRange.val(maxI).trigger('input');
      }

      TWER.map.setMinPitch(minI);
      TWER.map.setMaxPitch(maxI);
    });
    /**
     * Tour Fly
     */

    const $TourType = $('#treweler-tour-type');
    const $TourSectionSpeed = $('.section-treweler-tour-fly-speed');
    const $TourSectionCurve = $('.section-treweler-tour-fly-curve');

    if ($TourType.val() !== 'fly') {
      $TourSectionSpeed.hide();
      $TourSectionCurve.hide();
    }

    $TourType.change(function () {
      if ($(this).val() === 'fly') {
        $TourSectionSpeed.show();
        $TourSectionCurve.show();
      } else {
        $TourSectionSpeed.hide();
        $TourSectionCurve.hide();
      }

      $('.js-adv-checkbox').trigger('change');
    });
  });
})(jQuery);





jQuery(document).ready(function ($) {
  new _modules_uploads__WEBPACK_IMPORTED_MODULE_4__["default"]($);
  new _modules_widgets__WEBPACK_IMPORTED_MODULE_2__["default"]($);
  new _modules_widgets_marker__WEBPACK_IMPORTED_MODULE_3__["default"]($);
  new _modules_controls__WEBPACK_IMPORTED_MODULE_5__["default"]($);
});
}();
/******/ })()
;