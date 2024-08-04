<?php get_header(); ?>

<section class="title">
	<div class="bg"><?php if( !empty( get_field( 'background',  'category_1' ) ) ) { ?><img src="<?php echo get_field( 'background', 'category_1' )['url']; ?>"><?php } ?></div>
	<?php if( !empty( get_field( 'breadcrumbs', 'category_1' ) ) ) { ?><div class="breadcrumbs"><?php echo bcn_display(); ?></div><?php } ?>
	<h1><?php the_search_query(); ?></h1>
</section><!-- /.title -->

<?php if ( have_posts() ) { ?>
	<?php /*the_widget( 'WP_Widget_Search' );*/ ?>
	<h1><?php _e( 'Search Results:' ); ?></h1>
	<section class="articles" data-search="<?php echo get_search_query(); ?>">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'inc/article' ); ?>
		<?php endwhile; ?>
	</section><!-- /.articles -->
<?php } else { ?>
	<h5><?php _e( 'Articles not found.' ); ?></h5>
<?php } ?>

<?php include( TEMPLATEPATH . '/inc/nav.php' ); ?>

<?php get_footer(); ?>