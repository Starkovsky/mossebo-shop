<!-- Yandex.Metrika counter -->
<script type="text/javascript">
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

<noscript>
    <div><img src="https://mc.yandex.ru/watch/48404660" style="position:absolute; left:-9999px;" alt=""/></div>
</noscript>
<!-- /Yandex.Metrika counter -->
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
