<?php 
if( $block['mode'] == 'preview' ) return;

$field = get_field( 'testimonials' );

if( $field['items'] == 'All' ) {
	$testimonial_ids = get_posts( [
		'post_type' => 'testimonial',
		'post_status' => 'publish',
		'numberposts' => -1,
	] );
}
if( $field['items'] == 'Custom' ) {
	$testimonial_ids = !empty( $field['testimonials'] ) ? $field['testimonials'] : [];
}
?>

<div id="<?php echo $block['id']; ?>" class="testimonials">	
	<?php if( !empty( $field['title'] ) ) { ?><h2><?php echo $field['title'] ?></h2><?php } ?>
	<?php if( !empty( $field['caption'] ) ) { ?><figcaption><?php echo $field['caption'] ?></figcaption><?php } ?>
	<?php if( !empty( $testimonial_ids ) ) { ?>
		<ul>
			<?php
			foreach( $testimonial_ids as $testimonial_id ) {
				$fields = get_fields( $testimonial_id );
			?>
				<li>
					<div class="cart">
						<div class="photo"><?php if( get_the_post_thumbnail( $testimonial_id ) ) { ?><img src="<?php echo get_the_post_thumbnail_url( $testimonial_id, 'photo-thumbnail' ); ?>"><?php } ?></div>
						<?php if( !empty( $fields['name'] ) ) { ?>
							<div class="name">
								<?php if( !empty( $fields['name']['first'] ) ) { ?><span><?php echo $fields['name']['first'] ?></span><?php } ?>
								&nbsp;
								<?php if( !empty( $fields['name']['last'] ) ) { ?><span><?php echo $fields['name']['last'] ?></span><?php } ?>
							</div>
						<?php } ?>
						<?php if( !empty( $fields['post'] ) ) { ?><div class="post"><?php echo $fields['post']; ?></div><?php } ?>
					</div>
					<div class="content">
						<?php echo file_get_contents( TEMPLATEPATH . '/svg/quotes.svg' ); ?>
						<h4><?php echo get_the_title( $testimonial_id ); ?></h4>
						<p><?php echo get_the_content( '', '', $testimonial_id  ); ?></p>
						<?php if( !empty( $fields['case'] ) ) { ?>
							<div class="links"><a class="link" href="<?php echo get_permalink( $fields['case'] ); ?>"><?php _e( 'Read the Case Study' ); ?></a></div>
						<?php } ?>
					</div>
				</li>
			<?php } ?>
		</ul>
	<?php } ?>
</div><!-- /.testimonials -->