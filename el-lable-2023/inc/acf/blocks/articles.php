<?php 
if( $block['mode'] == 'preview' ) return;

$field = get_field( 'articles' );

if( !empty( $field['filter'] ) ) {
	$terms = get_terms( [
		'taxonomy' => 'category',
		'hide_empty' => true,
	] );
}

global $wp_query;
$query = new WP_Query( [
	'post_type' => 'post',
	'posts_per_page' => get_option( 'posts_per_page' ),
] );

?>

<div id="<?php echo $block['id']; ?>" class="articles">
	<form>
		<?php if( !empty( $terms ) ) { ?>
			<ul class="filter">
				<li><label><input type="radio" name="type" value="" autocomplete="off"><a><?php _e( 'All' ); ?></a></label></li>
				<?php foreach( $terms as $choice ) { ?>
					<li><label><input type="radio" name="type" value="<?php echo $choice->term_id; ?>" autocomplete="off"><a><?php echo $choice->name; ?></a></label></li>
				<?php } ?>
			</ul>
		<?php } ?>
		
		<?php if( !empty( $field['search'] ) ) { ?>
			<div class="search">
				<input type="text" name="s" placeholder="<?php _e( 'Search Articles' ); ?>">
			</div>
		<?php } ?>
	</form>
	
	<?php if ( $query->have_posts() ) { ?>
		<section class="articles">
			<?php while ( $query->have_posts() ) : $query->the_post(); ?>
				<?php get_template_part( 'inc/article' ); ?>
			<?php endwhile; ?>
		</section>
	<?php } ?>
	
	<?php if( !empty( $field['button_label'] ) && $query->post_count > get_option( 'posts_per_page' ) ) { ?>
		<div class="buttons">
			<a href="<?php echo get_next_posts_page_link(); ?>" class="button light"><?php echo file_get_contents( TEMPLATEPATH . '/svg/reload.svg' ); ?><?php echo $field['button_label']; ?></a>
		</div>
	<?php } ?>
	
	<?php wp_reset_postdata(); ?>
</div><!-- /.articles -->