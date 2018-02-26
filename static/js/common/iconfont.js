;(function(window) {

  var svgSprite = '<svg>' +
    '' +
    '<symbol id="icon-yuan" viewBox="0 0 1024 1024">' +
    '' +
    '<path d="M512 85.333333C276.266667 85.333333 85.333333 276.266667 85.333333 512s190.933333 426.666667 426.666667 426.666667 426.666667-190.933333 426.666667-426.666667S747.733333 85.333333 512 85.333333zM512 853.333333c-188.586667 0-341.333333-152.746667-341.333333-341.333333S323.413333 170.666667 512 170.666667s341.333333 152.746667 341.333333 341.333333S700.586667 853.333333 512 853.333333z"  ></path>' +
    '' +
    '</symbol>' +
    '' +
    '<symbol id="icon-02" viewBox="0 0 1024 1024">' +
    '' +
    '<path d="M530.329 850.768c-193.509 0-350.931-157.428-350.931-350.931s157.428-350.931 350.931-350.931 350.931 157.428 350.931 350.931-157.428 350.931-350.931 350.931zM530.329 195.703c-167.695 0-304.145 136.45-304.145 304.145s136.45 304.145 304.145 304.145c167.71 0 304.145-136.45 304.145-304.145s-136.435-304.145-304.145-304.145z"  ></path>' +
    '' +
    '</symbol>' +
    '' +
    '<symbol id="icon-yuan1" viewBox="0 0 1024 1024">' +
    '' +
    '<path d="M512 56.32c-233.472 0-422.7072 189.2352-422.7072 422.7072 0 233.472 189.2352 422.7072 422.7072 422.7072s422.7072-189.2352 422.7072-422.7072C934.7072 245.5552 745.472 56.32 512 56.32zM512 863.8464c-212.5824 0-384.8192-172.2368-384.8192-384.8192S299.4176 94.208 512 94.208s384.8192 172.2368 384.8192 384.8192S724.5824 863.8464 512 863.8464z"  ></path>' +
    '' +
    '<path d="M512 479.0272m-239.8208 0a117.1 117.1 0 1 0 479.6416 0 117.1 117.1 0 1 0-479.6416 0Z"  ></path>' +
    '' +
    '</symbol>' +
    '' +
    '</svg>'
  var script = function() {
    var scripts = document.getElementsByTagName('script')
    return scripts[scripts.length - 1]
  }()
  var shouldInjectCss = script.getAttribute("data-injectcss")

  /**
   * document ready
   */
  var ready = function(fn) {
    if (document.addEventListener) {
      if (~["complete", "loaded", "interactive"].indexOf(document.readyState)) {
        setTimeout(fn, 0)
      } else {
        var loadFn = function() {
          document.removeEventListener("DOMContentLoaded", loadFn, false)
          fn()
        }
        document.addEventListener("DOMContentLoaded", loadFn, false)
      }
    } else if (document.attachEvent) {
      IEContentLoaded(window, fn)
    }

    function IEContentLoaded(w, fn) {
      var d = w.document,
        done = false,
        // only fire once
        init = function() {
          if (!done) {
            done = true
            fn()
          }
        }
        // polling for no errors
      var polling = function() {
        try {
          // throws errors until after ondocumentready
          d.documentElement.doScroll('left')
        } catch (e) {
          setTimeout(polling, 50)
          return
        }
        // no errors, fire

        init()
      };

      polling()
        // trying to always fire before onload
      d.onreadystatechange = function() {
        if (d.readyState == 'complete') {
          d.onreadystatechange = null
          init()
        }
      }
    }
  }

  /**
   * Insert el before target
   *
   * @param {Element} el
   * @param {Element} target
   */

  var before = function(el, target) {
    target.parentNode.insertBefore(el, target)
  }

  /**
   * Prepend el to target
   *
   * @param {Element} el
   * @param {Element} target
   */

  var prepend = function(el, target) {
    if (target.firstChild) {
      before(el, target.firstChild)
    } else {
      target.appendChild(el)
    }
  }

  function appendSvg() {
    var div, svg

    div = document.createElement('div')
    div.innerHTML = svgSprite
    svgSprite = null
    svg = div.getElementsByTagName('svg')[0]
    if (svg) {
      svg.setAttribute('aria-hidden', 'true')
      svg.style.position = 'absolute'
      svg.style.width = 0
      svg.style.height = 0
      svg.style.overflow = 'hidden'
      prepend(svg, document.body)
    }
  }

  if (shouldInjectCss && !window.__iconfont__svg__cssinject__) {
    window.__iconfont__svg__cssinject__ = true
    try {
      document.write("<style>.svgfont {display: inline-block;width: 1em;height: 1em;fill: currentColor;vertical-align: -0.1em;font-size:16px;}</style>");
    } catch (e) {
      console && console.log(e)
    }
  }

  ready(appendSvg)


})(window)