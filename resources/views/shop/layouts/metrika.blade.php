<!-- Yandex.Metrika counter -->
@if (false)
<script>
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function () {
            try {
                w.yaCounter48404660 = new Ya.Metrika2({
                    id: 48404660,
                    clickmap: true,
                    trackLinks: true,
                    accurateTrackBounce: true,
                    webvisor: true
                });
            } catch (e) {
            }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () {
                n.parentNode.insertBefore(s, n);
            };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/tag.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else {
            f();
        }
    })(document, window, "yandex_metrika_callbacks2");
</script>

<script>
    !function(f,b,e,v,n,t,s) {


        t=b.createElement(e);
        t.async=!0;
        t.src=v;
        s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)
    }(window, document,'script','https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '154209688288946');
    fbq('track', 'PageView');
</script>
@endif

<noscript>
    <div><img src="https://mc.yandex.ru/watch/48404660" style="position:absolute; left:-9999px;" alt=""/></div>
</noscript>
<!-- /Yandex.Metrika counter -->

<!-- Facebook Pixel Code -->
<noscript>
    <img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=154209688288946&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->

<!-- Rating@Mail.ru counter -->
<script type="text/javascript">
    var _tmr = window._tmr || (window._tmr = []);
    _tmr.push({id: "3069777", type: "pageView", start: (new Date()).getTime()});
    (function (d, w, id) {
        if (d.getElementById(id)) return;
        var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
        ts.src = "https://top-fwz1.mail.ru/js/code.js";
        var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
        if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
    })(document, window, "topmailru-code");
</script><noscript><div>
        <img src="https://top-fwz1.mail.ru/counter?id=3069777;js=na" style="border:0;position:absolute;left:-9999px;" alt="Top.Mail.Ru" />
    </div></noscript>
<!-- //Rating@Mail.ru counter -->


{{--<script async src="https://usocial.pro/usocial/usocial.js?v=6.1.4" data-script="usocial" charset="utf-8"></script>--}}

@if(Route::currentRouteName() === 'home')
    <script type="text/javascript" src="https://vk.com/js/api/openapi.js?159" defer></script>

    <script type="text/javascript" defer>
        window.addEventListener('DOMContentLoaded', function() {
            VK.Widgets.Group("vk_groups", {mode: 3, no_cover: 1, width: "340", height: "222"}, 76599685);

            !function (d, id, did, st) {
                var js = d.createElement("script");
                js.src = "https://connect.ok.ru/connect.js";
                js.onload = js.onreadystatechange = function () {
                    if (!this.readyState || this.readyState == "loaded" || this.readyState == "complete") {
                        if (!this.executed) {
                            this.executed = true;
                            setTimeout(function () {
                                OK.CONNECT.insertGroupWidget(id,did,st);
                            }, 0);
                        }
                    }};
                d.documentElement.appendChild(js);
            }(document,"ok_group_widget","53291776606394",'{"width":340,"height":222}');
        })
    </script>
@endif
