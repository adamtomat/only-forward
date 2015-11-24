<?php

namespace Rareloop;

class FontFout
{
    public static $fontsLoaded = false;

    public static $fontFamilies;
    public static $cookieName;
    public static $cookieDuration;

    /**
     * Instantiates the plugin
     */
    public static function init($fontFamilies = [], $cookieName = 'fonts-loaded', $cookieDuration = 86400)
    {
        // Setup the static variables we need
        static::$fontFamilies = $fontFamilies;
        static::$cookieName = $cookieName;

        // Google Font's serves fonts with an expiration of 1 day (our default)
        static::$cookieDuration = $cookieDuration;

        // Hook into the footer action so that we can inject some custom JavaScript
        add_action('wp_footer', [static::class, 'echoFooterJavaScript'], 100);

        add_shortcode('fontfout-htmlclass', [static::class, 'shortcodeHandler']);
    }

    /**
     * If the fonts are already loaded returns a class to add to the HTML element
     *
     * @return String
     */
    public static function htmlClass()
    {
        if (isset($_COOKIE[static::$cookieName])) {
            // static::$fontsLoaded = true;
            return 'fonts-loaded';
        } else {
            return '';
        }
    }

    /**
     * Outputs the JavaScript code needed to monitor the font loading
     *
     * @return null
     */
    public static function echoFooterJavaScript()
    {
        // If we don't have any font families then exit early
        if (empty(static::$fontFamilies)) {
            return;
        }

        // If the cookie is set then don't add any extra payload
        if (static::$fontsLoaded) {
            return;
        }

        ?>
        <script>
            /* FontFaceObserver is licensed under the BSD License. Copyright 2014-2015 Bram Stein. All rights reserved. */
            (function(){'use strict';var f=[];function g(a){f.push(a);1===f.length&&l()}function m(){for(;f.length;)f[0](),f.shift()}if(window.MutationObserver){var n=document.createElement("div");(new MutationObserver(m)).observe(n,{attributes:!0});var l=function(){n.setAttribute("x",0)}}else l=function(){setTimeout(m)};function p(a){this.a=q;this.b=void 0;this.f=[];var b=this;try{a(function(a){r(b,a)},function(a){t(b,a)})}catch(c){t(b,c)}}var q=2;function u(a){return new p(function(b,c){c(a)})}function v(a){return new p(function(b){b(a)})}
            function r(a,b){if(a.a===q){if(b===a)throw new TypeError("Promise settled with itself.");var c=!1;try{var d=b&&b.then;if(null!==b&&"object"===typeof b&&"function"===typeof d){d.call(b,function(b){c||r(a,b);c=!0},function(b){c||t(a,b);c=!0});return}}catch(e){c||t(a,e);return}a.a=0;a.b=b;w(a)}}function t(a,b){if(a.a===q){if(b===a)throw new TypeError("Promise settled with itself.");a.a=1;a.b=b;w(a)}}
            function w(a){g(function(){if(a.a!==q)for(;a.f.length;){var b=a.f.shift(),c=b[0],d=b[1],e=b[2],b=b[3];try{0===a.a?"function"===typeof c?e(c.call(void 0,a.b)):e(a.b):1===a.a&&("function"===typeof d?e(d.call(void 0,a.b)):b(a.b))}catch(h){b(h)}}})}p.prototype.g=function(a){return this.c(void 0,a)};p.prototype.c=function(a,b){var c=this;return new p(function(d,e){c.f.push([a,b,d,e]);w(c)})};
            function x(a){return new p(function(b,c){function d(c){return function(d){h[c]=d;e+=1;e===a.length&&b(h)}}var e=0,h=[];0===a.length&&b(h);for(var k=0;k<a.length;k+=1)v(a[k]).c(d(k),c)})}function y(a){return new p(function(b,c){for(var d=0;d<a.length;d+=1)v(a[d]).c(b,c)})};window.Promise||(window.Promise=p,window.Promise.resolve=v,window.Promise.reject=u,window.Promise.race=y,window.Promise.all=x,window.Promise.prototype.then=p.prototype.c,window.Promise.prototype["catch"]=p.prototype.g);}());

            (function(){'use strict';function h(a){document.body?a():document.addEventListener("DOMContentLoaded",a)};function v(a){this.a=document.createElement("div");this.a.setAttribute("aria-hidden","true");this.a.appendChild(document.createTextNode(a));this.b=document.createElement("span");this.c=document.createElement("span");this.h=document.createElement("span");this.g=document.createElement("span");this.f=-1;this.b.style.cssText="display:inline-block;position:absolute;height:100%;width:100%;overflow:scroll;font-size:16px;";this.c.style.cssText="display:inline-block;position:absolute;height:100%;width:100%;overflow:scroll;font-size:16px;";
            this.g.style.cssText="display:inline-block;position:absolute;height:100%;width:100%;overflow:scroll;font-size:16px;";this.h.style.cssText="display:inline-block;width:200%;height:200%;font-size:16px;";this.b.appendChild(this.h);this.c.appendChild(this.g);this.a.appendChild(this.b);this.a.appendChild(this.c)}
            function w(a,c,b){a.a.style.cssText="min-width:20px;min-height:20px;display:inline-block;overflow:hidden;position:absolute;width:auto;margin:0;padding:0;top:-999px;left:-999px;white-space:nowrap;font-size:100px;font-family:"+c+";"+b}function x(a){var c=a.a.offsetWidth,b=c+100;a.g.style.width=b+"px";a.c.scrollLeft=b;a.b.scrollLeft=a.b.scrollWidth+100;return a.f!==c?(a.f=c,!0):!1}
            function y(a,c){a.b.addEventListener("scroll",function(){x(a)&&null!==a.a.parentNode&&c(a.f)},!1);a.c.addEventListener("scroll",function(){x(a)&&null!==a.a.parentNode&&c(a.f)},!1);x(a)};function z(a,c){var b=c||{};this.family=a;this.style=b.style||"normal";this.variant=b.variant||"normal";this.weight=b.weight||"normal";this.stretch=b.stretch||"normal";this.featureSettings=b.featureSettings||"normal"}var B=null;
            z.prototype.a=function(a,c){var b=a||"BESbswy",C=c||3E3,k="font-style:"+this.style+";font-variant:"+this.variant+";font-weight:"+this.weight+";font-stretch:"+this.stretch+";font-feature-settings:"+this.featureSettings+";-moz-font-feature-settings:"+this.featureSettings+";-webkit-font-feature-settings:"+this.featureSettings+";",g=document.createElement("div"),l=new v(b),m=new v(b),n=new v(b),d=-1,e=-1,f=-1,q=-1,r=-1,t=-1,p=this;return new Promise(function(a,b){function c(){null!==g.parentNode&&g.parentNode.removeChild(g)}
            function u(){if(-1!==d&&-1!==e||-1!==d&&-1!==f||-1!==e&&-1!==f)if(d===e||d===f||e===f){if(null===B){var b=/AppleWebKit\/([0-9]+)(?:\.([0-9]+))/.exec(window.navigator.userAgent);B=!!b&&(536>parseInt(b[1],10)||536===parseInt(b[1],10)&&11>=parseInt(b[2],10))}B?d===q&&e===q&&f===q||d===r&&e===r&&f===r||d===t&&e===t&&f===t||(c(),a(p)):(c(),a(p))}}h(function(){function a(){if(Date.now()-D>=C)c(),b(p);else{var A=document.hidden;if(!0===A||void 0===A)d=l.a.offsetWidth,e=m.a.offsetWidth,f=n.a.offsetWidth,
            u();setTimeout(a,50)}}var D=Date.now();w(l,"sans-serif",k);w(m,"serif",k);w(n,"monospace",k);g.appendChild(l.a);g.appendChild(m.a);g.appendChild(n.a);document.body.appendChild(g);q=l.a.offsetWidth;r=m.a.offsetWidth;t=n.a.offsetWidth;a();y(l,function(a){d=a;u()});w(l,'"'+p.family+'",sans-serif',k);y(m,function(a){e=a;u()});w(m,'"'+p.family+'",serif',k);y(n,function(a){f=a;u()});w(n,'"'+p.family+'",monospace',k)})})};window.FontFaceObserver=z;window.FontFaceObserver.prototype.check=z.prototype.a;}());
        <?php

        // Work out which version of the JS we need to output
        if (count(static::$fontFamilies) === 1) {
            static::echoSingleFamilyCheck();
        } else {
            static::echoMultiFamilyCheck();
        }

        ?>
</script>
        <?php
    }

    /**
     * Outputs the JavaScript for checking a single font family
     *
     * @return null
     */
    public static function echoSingleFamilyCheck()
    {
        ?>
            
            var o = new FontFaceObserver('<?php echo static::$fontFamilies[0]?>');
            o.check().then(function() {
        <?php
            static::echoFontLoadedCode();
        ?>
    });
        <?php
    }

    /**
     * Outputs the JavaScript for checking multiple font families
     *
     * @return null
     */
    public static function echoMultiFamilyCheck()
    {
        $observers = [];

        // Shortern the output
        ?>

            var _f = FontFaceObserver;
        <?php

        // Get an observer for each font family
        for ($i = 0; $i < count(static::$fontFamilies); $i++) :
            $family = static::$fontFamilies[$i];
            $observers[] = "o$i.check()";
        ?>
    var o<?php echo $i ?> = new _f('<?php echo $family ?>');
        <?php
        endfor;

        // Create a promise that resolves when all fonts are loaded
        ?>

            Promise.all([<?php echo implode($observers, ', ') ?>]).then(function() {
        <?php
            static::echoFontLoadedCode();
        ?>
    });
        <?php
    }

    /**
     * Outputs the JavaScript code that runs once all fonts are loaded
     *
     * @return null
     */
    public static function echoFontLoadedCode()
    {
        ?>
        document.documentElement.className += ' fonts-loaded';
                var t = new Date();
                t.setSeconds(t.getSeconds() + <?php echo static::$cookieDuration; ?>);
                document.cookie = '<?php echo static::$cookieName; ?>=1; expires=' + t + '; path=<?php echo home_url('/', 'relative'); ?>';
        <?php
    }

    /**
     * Handler for the `fontfout-htmlclass` shortcode
     */
    public static function shortcodeHandler($attr, $content = null)
    {
        return static::htmlClass();
    }
}
