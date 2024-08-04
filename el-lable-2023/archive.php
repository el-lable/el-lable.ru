<?php get_header(); ?>
<?php
global $wp_query;
$cat_obj = $wp_query->get_queried_object();
?>

<section class="title">
	<div class="bg"><?php if( !empty( get_field( 'background', $cat_obj->taxonomy . '_' . $cat_obj->term_id ) ) ) { ?><img src="<?php echo get_field( 'background', $cat_obj->taxonomy . '_' . $cat_obj->term_id )['url']; ?>"><?php } ?></div>
	<?php if( !empty( get_field( 'breadcrumbs', $cat_obj->taxonomy . '_' . $cat_obj->term_id ) ) ) { ?><div class="breadcrumbs"><?php echo bcn_display(); ?></div><?php } ?>
	<h1><?php single_cat_title(); ?></h1>
</section><!-- /.title -->

<?php if ( have_posts() ) { ?>
	<section class="articles" data-category_id="<?php echo $cat_obj->term_id; ?>">
		<?php while( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'inc/article' ); ?>
		<?php endwhile; ?>
	</section><!-- /.articles -->
<?php } else { ?>
	<h5><?php _e( 'Articles not found.' ); ?></h5>
<?php } ?>

<?php include( TEMPLATEPATH . '/inc/nav.php' ); ?>

<?php get_footer(); ?>