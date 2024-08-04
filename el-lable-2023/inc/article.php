<article <?php post_class(); ?> data-post_type="<?php echo get_post_type() ?>">

	<?php if( has_post_thumbnail() ) { ?>
		
		<div class="thumb"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'post-thumbnail' ); ?></a></div>
		
	<?php } ?>

	<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	
	<div class="caption">
		by <b><?php the_author(); ?></b>&nbsp;&nbsp;&nbsp;&nbsp; <b>/</b> <?php echo get_the_date( 'F d, Y', get_the_ID() ); ?>
	</div>

	<span class="excerpt"><?php the_excerpt(); ?></span>
	
	<div class="links">
		<a class="link" href="<?php the_permalink(); ?>"><?php _e( 'Read full Article' ); ?><?php echo file_get_contents( TEMPLATEPATH . '/svg/arrow.svg' ); ?></a>
	</div>

</article>