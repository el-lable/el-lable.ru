<?php get_header(); ?>

<div class="header">
	<div class="bg"><img src="<?php if( has_post_thumbnail() ) { ?><?php the_post_thumbnail( 'fullsize' ); ?><?php } ?>"></div>
	<header>
		<div class="breadcrumbs"><?php echo bcn_display(); ?></div>
		<h1><?php echo the_title(); ?></h1>
		<div class="caption">by <?php the_author_meta( 'display_name', get_post_field( 'post_author', get_queried_object_id() ) ); ?> / <?php echo get_the_date( 'F d, Y', get_the_ID() ); ?></div>
	</header>
	
</div><!-- /.title -->

<section id="content-aside">
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<article <?php post_class(); ?>>
			<?php echo get_the_category_list(); ?>
			<h1><?php the_title(); ?></h1>
			<?php the_content(); ?>
			
		</article>
		
	<?php endwhile; endif; ?>
	
	<?php 
	$args = [
		'post_type' => 'post',
		'posts_per_page' => 2,
		'date_query' => [
			'before' => get_the_date(  'Y-m-d H:i:s', get_the_ID() ),
		],
		'order' => 'DESC',
		'orderby' => 'date',
		'fields' => 'ids',
	];
	new wp_query( $args );
	?>
	<aside>
		<h2><?php _e( 'Related Articles' ); ?></h2>
		<?php if ( have_posts() ) { ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'inc/article' ); ?>
			<?php endwhile; ?>
		<?php } else { ?>
			<h5><?php _e( 'No Previous Articles' ); ?></h5>
		<?php } ?>
	</aside>
	
	<?php 
	the_post_navigation( [
		'prev_text' => file_get_contents( TEMPLATEPATH . '/svg/arrow.svg' ) . __( 'Previous Article' ),
		'next_text' => __( 'Next Article' ) . file_get_contents( TEMPLATEPATH . '/svg/arrow.svg' ),
	] );
	?>
	
	<?php
	$field = get_field( 'subscribe', 'options' );
	if( !empty( $field ) ) {
	?>
		<div class="subscribe">
			<?php if( !empty( $field['title'] ) ) { ?><h2><?php echo $field['title']; ?></h2><?php } ?>
			<?php if( !empty( $field['caption'] ) ) { ?><p><?php echo $field['caption']; ?></p><?php } ?>
			<?php if( !empty( $field['form'] ) ) echo do_shortcode( '[contact-form-7 id="' . $field['form'] . '"]' ); ?>
		</div><!-- /.subscribe -->
	<?php } ?>
</section><!-- /#content-aside -->

<?php get_footer(); ?>
