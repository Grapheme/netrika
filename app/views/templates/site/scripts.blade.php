<?
/**
 * TEMPLATE_IS_NOT_SETTABLE
 */
?>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="{{ asset("theme/js/vendor/jquery-1.10.2.min.js") }}"><\/script>')</script>

        {{ HTML::script("theme/js/vendor/jquery.mask.js") }}
        {{ HTML::script("theme/js/main.js") }}
        {{ HTML::script("theme/js/plugins.js") }}
        {{ HTML::script("js/vendor/jquery.validate.min.js") }}
        {{ HTML::script("js/vendor/jquery-form.min.js") }}

        <script>
            $('.solution-select').solutionSelect({{ (isset($solution4form) && is_object($solution4form) && $solution4form->id) ? $solution4form->id : '' }});
        </script>

        <!-- Yandex.Metrika counter -->
		<script type="text/javascript">
		  /*(function (d, w, c) {
		    (w[c] = w[c] || []).push(function() {
		      try {
		        w.yaCounter22991605 = new Ya.Metrika({id:22991605,
		          webvisor:true,
		          clickmap:true,
		          trackLinks:true,
		          accurateTrackBounce:true});
		      } catch(e) { }
		    });

		    var n = d.getElementsByTagName("script")[0],
		        s = d.createElement("script"),
		        f = function () { n.parentNode.insertBefore(s, n); };
		    s.type = "text/javascript";
		    s.async = true;
		    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

		    if (w.opera == "[object Opera]") {
		      d.addEventListener("DOMContentLoaded", f, false);
		    } else { f(); }
		  })(document, window, "yandex_metrika_callbacks");*/
		</script>
		<noscript><div><img src="//mc.yandex.ru/watch/22991605" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->
		<script type="text/javascript">

		  /*var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-33007056-1']);
		  _gaq.push(['_trackPageview']);

		  (function () {
		    var ga = document.createElement('script');
		    ga.type = 'text/javascript';
		    ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0];
		    s.parentNode.insertBefore(ga, s);
		  })();*/
		</script>