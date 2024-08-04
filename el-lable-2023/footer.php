			<?php if ( is_active_sidebar( 'after-content' ) ) { ?><section class="after_content"><?php dynamic_sidebar( 'after-content' ); ?></section><?php } ?>
			
			<?php
			$field = get_field( 'delimiter', 'options' );
			if( !empty( $field ) && ( !empty( $field['title'] ) || !empty( $field['caption'] ) ) ) {
			?>
				<div class="delimiter">
					<?php if( !empty( $field['image'] ) ) { ?><div class="image"><?php echo get_icon( $field['image']['id'] ); ?></div><?php } ?>
					<?php if( !empty( $field['title'] ) ) { ?><h2><?php echo $field['title']; ?></h2><?php } ?>
					<?php if( !empty( $field['caption'] ) ) { ?><p><?php echo $field['caption']; ?></p><?php } ?>
					<?php if( !empty( $field['buttons'] ) ) { ?>
						<div class="buttons">
							<?php foreach( $field['buttons'] as $button ) { ?>
								<a class="button light" href="<?php echo $button['button']['url']; ?>" <?php if( $button['button']['target'] ) echo 'target="' . $button['button']['target'] . '"'; ?>>
									<?php echo file_get_contents( TEMPLATEPATH . '/svg/download-icon.svg' ); ?>
									<?php echo $button['button']['title']; ?>
								</a>
							<?php } ?>
						</div>
					<?php } ?>
				</div><!-- /.delimiter -->
			<?php } ?>
		</section><!-- /#content -->

		<section id="footer">
			<?php if ( is_active_sidebar( 'footer' ) ) { ?><?php dynamic_sidebar( 'footer' ); ?><?php } ?>
		</section><!-- /#footer -->
		<section id="copyright">
			<?php if( !empty( get_field( 'copyright', 'options' ) ) ) { ?><div><?php the_field( 'copyright', 'options' ); ?></div><?php } ?>
			<?php if( !empty( get_field( 'special_links', 'options' ) ) ) { ?>
				<ul>
					<?php foreach( get_field( 'special_links', 'options' ) as $item ) { ?>
						<li>
							<a href="<?php echo $item['link']['url'] ?>"<?php if( $item['link']['target'] ) echo ' target="' . $item['link']['target'] . '"'; ?>><?php echo $item['link']['title'] ?></a>
						</li>
					<?php } ?>
				</ul>
			<?php } ?>
			<?php if( !empty( get_field( 'socials', 'options' ) ) ) { ?>
				<div class="socials">
					<?php foreach( get_field( 'socials', 'options' ) as $item ) { ?>
						<a href="<?php echo $item['link']['url'] ?>"<?php if( $item['link']['target'] ) echo ' target="' . $item['link']['target'] . '"'; ?>>
							<?php echo get_icon( $item['icon']['url'] ); ?>
							<?php echo $item['link']['title'] ?>
						</a>
					<?php } ?>
				</div>
			<?php } ?>
		</section><!-- /#copyright -->
	</div><!-- /#wrap -->
</div><!-- /#wrap_outer -->

<?php wp_footer(); ?>

<section id="accept_message">
	<a class="close"></a>
	<div>
		<h4></h4>
		<p></p>
	</div>
</section>

<div id="mobile_menu_overlay"></div>
<div id="mobile_menu"></div>

<!-- Счетчики и прочее -->
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter43550224 = new Ya.Metrika({
                    id:43550224,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/43550224" style="position:absolute; left:-9999px; top:0;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<!-- Rating@Mail.ru counter -->
<?php /*<script type="text/javascript">
var _tmr = window._tmr || (window._tmr = []);
_tmr.push({id: "2882633", type: "pageView", start: (new Date()).getTime()});
(function (d, w, id) {
  if (d.getElementById(id)) return;
  var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true; ts.id = id;
  ts.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//top-fwz1.mail.ru/js/code.js";
  var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
  if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
})(document, window, "topmailru-code");
</script><noscript><div>
<img src="//top-fwz1.mail.ru/counter?id=2882633;js=na" style="border:0;position:absolute;left:-9999px; top:0;" alt="" />
</div></noscript>
<!-- //Rating@Mail.ru counter -->*/ ?>

</body>
</html>