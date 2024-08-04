<?php if( function_exists( 'wp_pagenavi' ) ) { ?>
	<?php wp_pagenavi(); ?>
<?php } else { ?>
	<div class="buttons">
		<?php if( paginate_links() ) { ?>
			<a href="<?php echo get_next_posts_page_link(); ?>" class="button light"><?php echo file_get_contents( TEMPLATEPATH . '/svg/reload.svg' ); ?><?php _e( 'Load More Cases' ); ?></a>
		<?php } ?>
	</div>
<?php } ?>