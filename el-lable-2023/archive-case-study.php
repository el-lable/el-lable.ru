<?php get_header(); ?>
<?php
global $wp_query;
$cat_obj = $wp_query->get_queried_object();
?>

<section class="title">
	<div class="bg"><img src="/wp-content/uploads/2023/02/blog-news.jpg"></div>
	<div class="breadcrumbs"><?php echo bcn_display(); ?></div>
	<h1><?php echo $cat_obj->label; ?></h1>
</section><!-- /.title -->

<div class="cases">
	<?php if ( have_posts() ) { ?>
			<ul data-post_type="<?php echo $cat_obj->name; ?>">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'inc/case' ); ?>
				<?php endwhile; ?>
			</ul>
	<?php } else { ?>
		<h5><?php _e( 'Cases not found.' ); ?></h5>
	<?php } ?>

	<?php include( TEMPLATEPATH . '/inc/nav-cases.php' ); ?>
</div><!-- /.cases -->


<?php get_footer(); ?>