<?php
extract( $args );
$bullets = get_field( 'bullets', $post_id );
$content = trim( get_the_content( '', '', $post_id ) );
?>
<li class="case">
	<?php if( has_post_thumbnail( $post_id ) ) { ?>
		<div class="thumb"><?php echo get_the_post_thumbnail( $post_id, 'case-thumbnail' ); ?></div>
	<?php } ?>
	<figcaption>
		<h3><?php echo get_the_title( $post_id ); ?></h3>
		<?php if( get_the_excerpt( $post_id ) ) { ?><p><?php echo get_the_excerpt( $post_id ); ?></p><?php } ?>
		<?php if( !empty( $bullets ) ) { ?>
			<ul>
				<?php foreach( $bullets as $item ) { ?>
					<li>
						<div class="icon"><?php /*echo file_get_contents( TEMPLATEPATH . '/svg/ok-circle-icon.svg' );*/ ?></div>
						<?php echo $item['bullet']; ?>
					</li>
				<?php } ?>
			</ul>
		<?php } ?>
		<?php if( !empty( $content ) ) { ?>
			<div class="content"><?php echo $content; ?></div>
			<div class="links"><a href="<?php echo get_permalink( $post_id  ); ?>" class="more" data-alternative="<?php _e( 'Read less' ); ?>"><?php _e( 'Read more' ); ?></a></div>
		<?php } ?>
	</figcaption>
</li>