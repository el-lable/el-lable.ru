<?php 
if( $block['mode'] == 'preview' ) return;

$field = get_field( 'contact_form' );

$elements = [
	'Call us' => [
		'icon' => 'telephone-icon.svg',
		'shortcode' => '[phone]'
	],
	'Write Us' => [
		'icon' => 'fax-icon.svg',
		'shortcode' => '[fax]'
	],
	'Mail to us' => [
		'icon' => 'map-marker-icon.svg',
		'shortcode' => '[address]'
	],
];
?>
<div id="<?php echo $block['id']; ?>" class="contact-form">
	<aside class="elements"<?php if( !empty( $field['background'] ) ) { ?> style="background-image:url(<?php echo $field['background']['url']; ?>);"<?php } ?>>
		<?php if( !empty( $field['elements'] ) ) { ?>
			<ul>
				<?php
				foreach( $field['elements'] as $title => $element ) {
					if( !isset( $elements[$element] ) ) continue;
				?>
					<li>
						<h4><?php _e( $element ); ?></h4>
						<div class="icon"><?php echo get_icon( get_template_directory_uri() . '/svg/' . $elements[$element]['icon'] ); ?></div>
						<?php echo do_shortcode( $elements[$element]['shortcode'] ); ?>
					</li>
				<?php } ?>
			</ul>
		<?php } ?>
	</aside>
	<aside class="form">
		<?php if( !empty( $field['form']['title'] ) ) { ?><h2><?php echo $field['form']['title']; ?></h2><?php } ?>
		<?php if( !empty( $field['form']['caption'] ) ) { ?><figcaption><?php echo $field['form']['caption']; ?></figcaption><?php } ?>
		<?php if( !empty( $field['form']['form'] ) ) echo do_shortcode( '[contact-form-7 id="' . $field['form']['form'] . '"]' ); ?>
	</aside>
</div><!-- /.contact-form -->