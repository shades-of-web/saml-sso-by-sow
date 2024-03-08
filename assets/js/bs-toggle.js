/* Copyright Notice
 * bootstrap5-toggle v5.0.4
 * https://palcarazm.github.io/bootstrap5-toggle/
 * @author 2011-2014 Min Hur (https://github.com/minhur)
 * @author 2018-2019 Brent Ely (https://github.com/gitbrent)
 * @author 2022 Pablo Alcaraz Martínez (https://github.com/palcarazm)
 * @funding GitHub Sponsors
 * @see https://github.com/sponsors/palcarazm
 * @license MIT
 * @see https://github.com/palcarazm/bootstrap5-toggle/blob/master/LICENSE
 */

"use strict";
!(function () {
  class s {
    constructor(e, t) {
      const i = "BOOTSTRAP TOGGLE DEPRECATION CHECK -- a0Jhux0QySypjjs4tLtEo8xT2kx0AbYaq9K6mgNjWSs0HF0L8T8J0M0o3Kr7zkm7 --",
        s = "attribute",
        n = "option",
        l = function (e, t, i) {
          console.warn(`Bootstrap Toggle deprecation warning: Using ${t} ${e} is deprected. Use ${i} instead.`);
        },
        o = "On",
        a = "primary",
        h = null,
        d = null,
        r = "Off",
        m = "secondary",
        g = null,
        b = null,
        c = "",
        u = "",
        f = null,
        p = null,
        v = 0,
        A = !1,
        y = null;
      (t = t || {}),
        (this.element = e),
        (this.options = {
          onlabel: this.element.getAttribute("data-onlabel") || t.onlabel || i || o,
          onstyle: this.element.getAttribute("data-onstyle") || t.onstyle || a,
          onvalue: this.element.getAttribute("value") || this.element.getAttribute("data-onvalue") || t.onvalue || h,
          ontitle: this.element.getAttribute("data-ontitle") || t.ontitle || this.element.getAttribute("title") || d,
          offlabel: this.element.getAttribute("data-offlabel") || t.offlabel || i || r,
          offstyle: this.element.getAttribute("data-offstyle") || t.offstyle || m,
          offvalue: this.element.getAttribute("data-offvalue") || t.offvalue || g,
          offtitle: this.element.getAttribute("data-offtitle") || t.offtitle || this.element.getAttribute("title") || b,
          size: this.element.getAttribute("data-size") || t.size || c,
          style: this.element.getAttribute("data-style") || t.style || u,
          width: this.element.getAttribute("data-width") || t.width || f,
          height: this.element.getAttribute("data-height") || t.height || p,
          tabindex: this.element.getAttribute("tabindex") || t.tabindex || v,
          tristate: this.element.hasAttribute("tristate") || t.tristate || A,
          name: this.element.getAttribute("name") || t.name || y,
        }),
        this.options.onlabel === i &&
          (this.element.getAttribute("data-on")
            ? (l(s, "data-on", "data-onlabel"), (this.options.onlabel = this.element.getAttribute("data-on")))
            : t.on
            ? (l(n, "on", "onlabel"), (this.options.onlabel = t.on))
            : (this.options.onlabel = o)),
        this.options.offlabel === i &&
          (this.element.getAttribute("data-off")
            ? (l(s, "data-off", "data-offlabel"), (this.options.offlabel = this.element.getAttribute("data-off")))
            : t.off
            ? (l(n, "off", "offlabel"), (this.options.offlabel = t.off))
            : (this.options.offlabel = r)),
        this.render();
    }
    render() {
      function e(e) {
        var t = window.getComputedStyle(e),
          e = e.offsetHeight,
          i = parseFloat(t.borderTopWidth);
        return e - parseFloat(t.borderBottomWidth) - i - parseFloat(t.paddingTop) - parseFloat(t.paddingBottom);
      }
      let t;
      switch (this.options.size) {
        case "large":
        case "lg":
          t = "btn-lg";
          break;
        case "small":
        case "sm":
          t = "btn-sm";
          break;
        case "mini":
        case "xs":
          t = "btn-xs";
          break;
        default:
          t = "";
      }
      var i = document.createElement("span"),
        s =
          (i.setAttribute("class", "btn btn-" + this.options.onstyle + " " + t),
          (i.innerHTML = this.options.onlabel),
          this.options.ontitle && i.setAttribute("title", this.options.ontitle),
          document.createElement("span")),
        n =
          (s.setAttribute("class", "btn btn-" + this.options.offstyle + " " + t),
          (s.innerHTML = this.options.offlabel),
          this.options.offtitle && s.setAttribute("title", this.options.offtitle),
          document.createElement("span")),
        l = (n.setAttribute("class", "toggle-handle btn " + t), document.createElement("div"));
      l.setAttribute("class", "toggle-group"), l.appendChild(i), l.appendChild(s), l.appendChild(n);
      let o = document.createElement("div"),
        a =
          (o.setAttribute("class", "toggle btn"),
          o.classList.add(this.element.checked ? "btn-" + this.options.onstyle : "btn-" + this.options.offstyle),
          o.setAttribute("tabindex", this.options.tabindex),
          this.element.checked || o.classList.add("off"),
          this.options.size && o.classList.add(t),
          this.options.style &&
            this.options.style.split(" ").forEach((e) => {
              o.classList.add(e);
            }),
          (this.element.disabled || this.element.readOnly) && (o.classList.add("disabled"), o.setAttribute("disabled", "disabled")),
          this.options.onvalue && this.element.setAttribute("value", this.options.onvalue),
          null);
      this.options.offvalue &&
        ((a = this.element.cloneNode()).setAttribute("value", this.options.offvalue),
        a.setAttribute("data-toggle", "invert-toggle"),
        a.removeAttribute("id"),
        (a.checked = !this.element.checked)),
        this.element.parentElement.insertBefore(o, this.element),
        o.appendChild(this.element),
        a && o.appendChild(a),
        o.appendChild(l),
        (o.style.width =
          (this.options.width || Math.max(i.getBoundingClientRect().width, s.getBoundingClientRect().width) + n.getBoundingClientRect().width / 2) + "px"),
        (o.style.height = (this.options.height || Math.max(i.getBoundingClientRect().height, s.getBoundingClientRect().height)) + "px"),
        i.classList.add("toggle-on"),
        s.classList.add("toggle-off"),
        this.options.height && ((i.style.lineHeight = e(i) + "px"), (s.style.lineHeight = e(s) + "px")),
        o.addEventListener("touchstart", (e) => {
          this.#toggleActionPerformed(e);
        }),
        o.addEventListener("click", (e) => {
          this.#toggleActionPerformed(e);
        }),
        o.addEventListener("keypress", (e) => {
          " " == e.key && this.#toggleActionPerformed(e);
        }),
        this.element.id &&
          document.querySelectorAll('label[for="' + this.element.id + '"]').forEach((e) => {
            e.addEventListener("touchstart", (e) => {
              this.toggle(), o.focus();
            }),
              e.addEventListener("click", (e) => {
                this.toggle(), o.focus();
              });
          }),
        (this.ecmasToggle = o),
        (this.invElement = a),
        (this.element.bsToggle = this);
    }
    #toggleActionPerformed(e) {
      this.options.tristate
        ? this.ecmasToggle.classList.contains("indeterminate")
          ? (this.determinate(!0), this.toggle())
          : this.indeterminate()
        : this.toggle(),
        e.preventDefault();
    }
    toggle(e = !1) {
      this.element.checked ? this.off(e) : this.on(e);
    }
    on(e = !1) {
      if (this.element.disabled || this.element.readOnly) return !1;
      this.ecmasToggle.classList.remove("btn-" + this.options.offstyle),
        this.ecmasToggle.classList.add("btn-" + this.options.onstyle),
        this.ecmasToggle.classList.remove("off"),
        (this.element.checked = !0),
        this.invElement && (this.invElement.checked = !1),
        e || this.trigger();
    }
    off(e = !1) {
      if (this.element.disabled || this.element.readOnly) return !1;
      this.ecmasToggle.classList.remove("btn-" + this.options.onstyle),
        this.ecmasToggle.classList.add("btn-" + this.options.offstyle),
        this.ecmasToggle.classList.add("off"),
        (this.element.checked = !1),
        this.invElement && (this.invElement.checked = !0),
        e || this.trigger();
    }
    indeterminate(e = !1) {
      if (!this.options.tristate || this.element.disabled || this.element.readOnly) return !1;
      this.ecmasToggle.classList.add("indeterminate"),
        (this.element.indeterminate = !0),
        this.element.removeAttribute("name"),
        this.invElement && (this.invElement.indeterminate = !0),
        this.invElement && this.invElement.removeAttribute("name"),
        e || this.trigger();
    }
    determinate(e = !1) {
      if (!this.options.tristate || this.element.disabled || this.element.readOnly) return !1;
      this.ecmasToggle.classList.remove("indeterminate"),
        (this.element.indeterminate = !1),
        this.options.name && this.element.setAttribute("name", this.options.name),
        this.invElement && (this.invElement.indeterminate = !1),
        this.invElement && this.options.name && this.invElement.setAttribute("name", this.options.name),
        e || this.trigger();
    }
    enable() {
      this.ecmasToggle.classList.remove("disabled"),
        this.ecmasToggle.removeAttribute("disabled"),
        this.element.removeAttribute("disabled"),
        this.element.removeAttribute("readonly"),
        this.invElement && (this.invElement.removeAttribute("disabled"), this.invElement.removeAttribute("readonly"));
    }
    disable() {
      this.ecmasToggle.classList.add("disabled"),
        this.ecmasToggle.setAttribute("disabled", ""),
        this.element.setAttribute("disabled", ""),
        this.element.removeAttribute("readonly"),
        this.invElement && (this.invElement.setAttribute("disabled", ""), this.invElement.removeAttribute("readonly"));
    }
    readonly() {
      this.ecmasToggle.classList.add("disabled"),
        this.ecmasToggle.setAttribute("disabled", ""),
        this.element.removeAttribute("disabled"),
        this.element.setAttribute("readonly", ""),
        this.invElement && (this.invElement.removeAttribute("disabled"), this.invElement.setAttribute("readonly", ""));
    }
    update(e) {
      this.element.disabled ? this.disable() : this.element.readOnly ? this.readonly() : this.enable(), this.element.checked ? this.on(e) : this.off(e);
    }
    trigger(e) {
      e || this.element.dispatchEvent(new Event("change", { bubbles: !0 }));
    }
    destroy() {
      this.ecmasToggle.parentNode.insertBefore(this.element, this.ecmasToggle),
        this.ecmasToggle.parentNode.removeChild(this.ecmasToggle),
        delete this.element.bsToggle,
        delete this.ecmasToggle;
    }
  }
  (Element.prototype.bootstrapToggle = function (e, t) {
    var i = this.bsToggle || new s(this, e);
    e &&
      "string" == typeof e &&
      ("toggle" == e.toLowerCase()
        ? i.toggle(t)
        : "on" == e.toLowerCase()
        ? i.on(t)
        : "off" == e.toLowerCase()
        ? i.off(t)
        : "indeterminate" == e.toLowerCase()
        ? i.indeterminate(t)
        : "determinate" == e.toLowerCase()
        ? i.determinate(t)
        : "enable" == e.toLowerCase()
        ? i.enable()
        : "disable" == e.toLowerCase()
        ? i.disable()
        : "readonly" == e.toLowerCase()
        ? i.readonly()
        : "destroy" == e.toLowerCase() && i.destroy());
  }),
    "undefined" != typeof window &&
      (window.onload = function () {
        document.querySelectorAll('input[type=checkbox][data-toggle="toggle"]').forEach(function (e) {
          e.bootstrapToggle();
        });
      }),
    "undefined" != typeof module && module.exports && (module.exports = s);
})();
//# sourceMappingURL=bootstrap5-toggle.ecmas.min.js.map
