(window.webpackWcBlocksJsonp=window.webpackWcBlocksJsonp||[]).push([[11],{135:function(t,e,n){"use strict";var c=n(0),r=n(95),o=n(79),a=function(t){var e=t.indexOf("</p>");return-1===e?t:t.substr(0,e+4)},u=function(t){return t.replace(/<\/?[a-z][^>]*?>/gi,"")},s=function(t,e){return t.replace(/[\s|\.\,]+$/i,"")+e},i=function(t,e){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"&hellip;",c=u(t),r=c.split(" ").splice(0,e).join(" ");return Object(o.autop)(s(r,n))},l=function(t,e){var n=!(arguments.length>2&&void 0!==arguments[2])||arguments[2],c=arguments.length>3&&void 0!==arguments[3]?arguments[3]:"&hellip;",r=u(t),a=r.slice(0,e);if(n)return Object(o.autop)(s(a,c));var i=a.match(/([\s]+)/g),l=i?i.length:0,p=r.slice(0,e+l);return Object(o.autop)(s(p,c))};e.a=function(t){var e=t.source,n=t.maxLength,u=void 0===n?15:n,s=t.countType,p=void 0===s?"words":s,d=t.className,m=void 0===d?"":d,v=Object(c.useMemo)((function(){return function(t){var e=arguments.length>1&&void 0!==arguments[1]?arguments[1]:15,n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:"words",c=Object(o.autop)(t),u=Object(r.count)(c,n);if(u<=e)return c;var s=a(c),p=Object(r.count)(s,n);return p<=e?s:"words"===n?i(s,e):l(s,e,"characters_including_spaces"===n)}(e,u,p)}),[e,u,p]);return React.createElement(c.RawHTML,{className:m},v)}},290:function(t,e){},300:function(t,e,n){"use strict";n.r(e);var c=n(6),r=n.n(c),o=(n(4),n(5)),a=n.n(o),u=n(135),s=n(2),i=n(69),l=n(191);n(290);e.default=Object(l.withProductDataContext)((function(t){var e=t.className,n=Object(i.useInnerBlockLayoutContext)().parentClassName,c=Object(i.useProductDataContext)().product;if(!c)return React.createElement("div",{className:a()(e,"wc-block-components-product-summary",r()({},"".concat(n,"__product-summary"),n))});var o=c.short_description?c.short_description:c.description;if(!o)return null;var l=Object(s.getSetting)("wordCountType","words");return React.createElement(u.a,{className:a()(e,"wc-block-components-product-summary",r()({},"".concat(n,"__product-summary"),n)),source:o,maxLength:150,countType:l})}))}}]);