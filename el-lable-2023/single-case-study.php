<?php get_header(); ?>

<div class="header">
	<div class="bg"><img src="<?php if( has_post_thumbnail() ) { ?><?php the_post_thumbnail( 'fullsize' ); ?><?php } ?>"></div>
	<header>
		<div class="breadcrumbs"><?php echo bcn_display(); ?></div>
		<h1><?php echo the_title(); ?></h1>
		<?php /*<div class="caption">by <?php the_author_meta( 'display_name', get_post_field( 'post_author', get_queried_object_id() ) ); ?> / <?php echo get_the_date( 'F d, Y', get_the_ID() ); ?></div>*/ ?>
	</header>
	
</div><!-- /.title -->

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<article <?php post_class(); ?>>
		<?php echo get_the_category_list(); ?>
		<h1><?php the_title(); ?></h1>
		<?php the_content(); ?>
		
	</article>
	
<?php endwhile; endif; ?>

<?php get_footer(); ?>
