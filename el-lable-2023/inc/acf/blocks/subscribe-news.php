<?php 
if( $block['mode'] == 'preview' ) return;

$field = get_field( 'subscribe_news' );

if( $field['items'] == 'Last' ) {
	$args = [
		'post_type' => 'post',
		'posts_per_page' => 4,
		'order' => 'DESC',
		'orderby' => 'date',
	];
	$query = new WP_Query( $args );
}
if( $field['items'] == 'Custom' ) {
	$args = [
		'post_type' => 'post',
		'post__in' => $field['articles'],
		'posts_per_page' => 4,
	];
	print_r( $args );
	$query = new WP_Query( $args );
}
wp_reset_postdata();

?>

<div id="<?php echo $block['id']; ?>" class="subscribe-news ">	
	<?php if( !empty( $field['title'] ) ) { ?><h2><?php echo $field['title'] ?></h2><?php } ?>
	<?php if( !empty( $field['caption'] ) ) { ?><figcaption><?php echo $field['caption'] ?></figcaption><?php } ?>
	<?php if( !empty( $field['form'] ) ) echo do_shortcode( '[contact-form-7 id="' . $field['form'] . '"]' ); ?>
	<?php if ( $query->have_posts() ) { ?>
		<div class="articles">
			<?php while ( $query->have_posts() ) {
				$query->the_post();
			?>
				<?php get_template_part( 'inc/article' ); ?>
			<?php } ?>
		</div>
	<?php } ?>
	
</div><!-- /.subscribe-news -->