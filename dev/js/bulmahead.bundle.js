!function(t){var e={};function n(r){if(e[r])return e[r].exports;var o=e[r]={i:r,l:!1,exports:{}};return t[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=t,n.c=e,n.d=function(t,e,r){n.o(t,e)||Object.defineProperty(t,e,{enumerable:!0,get:r})},n.r=function(t){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(t,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(t,"__esModule",{value:!0})},n.t=function(t,e){if(1&e&&(t=n(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var o in t)n.d(r,o,function(e){return t[e]}.bind(null,o));return r},n.n=function(t){var e=t&&t.__esModule?function(){return t.default}:function(){return t};return n.d(e,"a",e),e},n.o=function(t,e){return Object.prototype.hasOwnProperty.call(t,e)},n.p="",n(n.s=4)}([function(t,e){t.exports=function(t){var e=typeof t;return null!=t&&("object"==e||"function"==e)}},function(t,e,n){var r=n(6),o="object"==typeof self&&self&&self.Object===Object&&self,i=r||o||Function("return this")();t.exports=i},function(t,e,n){var r=n(1).Symbol;t.exports=r},function(t,e,n){var r=n(0),o=n(5),i=n(8),u=Math.max,a=Math.min;t.exports=function(t,e,n){var c,l,f,s,d,p,v=0,y=!1,b=!1,m=!0;if("function"!=typeof t)throw new TypeError("Expected a function");function g(e){var n=c,r=l;return c=l=void 0,v=e,s=t.apply(r,n)}function x(t){return v=t,d=setTimeout(h,e),y?g(t):s}function j(t){var n=t-p;return void 0===p||n>=e||n<0||b&&t-v>=f}function h(){var t=o();if(j(t))return O(t);d=setTimeout(h,function(t){var n=e-(t-p);return b?a(n,f-(t-v)):n}(t))}function O(t){return d=void 0,m&&c?g(t):(c=l=void 0,s)}function w(){var t=o(),n=j(t);if(c=arguments,l=this,p=t,n){if(void 0===d)return x(p);if(b)return clearTimeout(d),d=setTimeout(h,e),g(p)}return void 0===d&&(d=setTimeout(h,e)),s}return e=i(e)||0,r(n)&&(y=!!n.leading,f=(b="maxWait"in n)?u(i(n.maxWait)||0,e):f,m="trailing"in n?!!n.trailing:m),w.cancel=function(){void 0!==d&&clearTimeout(d),v=0,c=p=l=d=void 0},w.flush=function(){return void 0===d?s:O(o())},w}},function(t,e,n){"use strict";n.r(e);var r=n(3),o=n.n(r);const i=(t,e,n,r,i,u=2)=>{const a=document.getElementById(t),c=document.getElementById(e);c.innerHTML='<div class="dropdown-content"></div>';const l=t=>{t.preventDefault();var e=t.target.text,n=t.target.dataset.value;return a.value=e,c.style.display="none",r&&r({label:e,value:n}),!1},f=t=>{const e=t.target.value;c.style.display="none",c.innerHTML='<div class="dropdown-content"></div>',e.length<=u||n(e).then(t=>{t.map(({label:t,value:e})=>{const n=document.createElement("a");return n.href="#",n.classList.add("dropdown-item"),n.innerHTML=t,n.dataset.value=e,n.addEventListener("click",l),n}).map(t=>{c.childNodes[0].appendChild(t)}),t.length>0&&(c.style.display="block")})};a.addEventListener("input",o()(f,i)),a.addEventListener("focusout",t=>{null!==t.relatedTarget&&t.relatedTarget.classList.contains("dropdown-item")||(c.style.display="none")}),a.addEventListener("focusin",f)};e.default=i,window.bulmahead=i},function(t,e,n){var r=n(1);t.exports=function(){return r.Date.now()}},function(t,e,n){(function(e){var n="object"==typeof e&&e&&e.Object===Object&&e;t.exports=n}).call(this,n(7))},function(t,e){var n;n=function(){return this}();try{n=n||new Function("return this")()}catch(t){"object"==typeof window&&(n=window)}t.exports=n},function(t,e,n){var r=n(0),o=n(9),i=/^\s+|\s+$/g,u=/^[-+]0x[0-9a-f]+$/i,a=/^0b[01]+$/i,c=/^0o[0-7]+$/i,l=parseInt;t.exports=function(t){if("number"==typeof t)return t;if(o(t))return NaN;if(r(t)){var e="function"==typeof t.valueOf?t.valueOf():t;t=r(e)?e+"":e}if("string"!=typeof t)return 0===t?t:+t;t=t.replace(i,"");var n=a.test(t);return n||c.test(t)?l(t.slice(2),n?2:8):u.test(t)?NaN:+t}},function(t,e,n){var r=n(10),o=n(13);t.exports=function(t){return"symbol"==typeof t||o(t)&&"[object Symbol]"==r(t)}},function(t,e,n){var r=n(2),o=n(11),i=n(12),u=r?r.toStringTag:void 0;t.exports=function(t){return null==t?void 0===t?"[object Undefined]":"[object Null]":u&&u in Object(t)?o(t):i(t)}},function(t,e,n){var r=n(2),o=Object.prototype,i=o.hasOwnProperty,u=o.toString,a=r?r.toStringTag:void 0;t.exports=function(t){var e=i.call(t,a),n=t[a];try{t[a]=void 0;var r=!0}catch(t){}var o=u.call(t);return r&&(e?t[a]=n:delete t[a]),o}},function(t,e){var n=Object.prototype.toString;t.exports=function(t){return n.call(t)}},function(t,e){t.exports=function(t){return null!=t&&"object"==typeof t}}]);
//# sourceMappingURL=bulmahead.bundle.js.map