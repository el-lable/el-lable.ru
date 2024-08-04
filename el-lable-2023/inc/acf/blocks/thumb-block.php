<?php 
if( $block['mode'] == 'preview' ) return;

$field = get_field( 'thumb_block' );
?>

<div id="<?php echo $block['id']; ?>" class="thumb-block">
	<?php if( !empty( $field['thumb'] ) ) { ?><div class="thumb"><?php echo get_icon( $field['thumb']['url'] ); ?></div><?php } ?>
	<div class="content">
		<header>
			<?php if( !empty( $field['icon'] ) ) { ?><div class="icon"><?php echo get_icon( $field['icon']['url'] ); ?></div><?php } ?>
			<?php if( !empty( $field['title'] ) ) { ?><h2><?php echo $field['title']; ?></h2><?php } ?>
			<?php if( !empty( $field['caption'] ) ) { ?><figcaption><?php echo $field['caption']; ?></figcaption><?php } ?>
		</header>
		<hr>
		<?php if( !empty( $field['content'] ) ) { ?><p><?php echo $field['content']; ?></p><?php } ?>
		<?php if( !empty( $field['button'] ) ) { ?>
			<div class="buttons">
				<a class="button" href="<?php echo $field['button']['url']; ?>" <?php if( $field['button']['target'] ) echo 'target="' . $field['button']['target'] . '"'; ?>><?php echo $field['button']['title']; ?></a>
			</div>
		<?php } ?>
	</div>
</div><!-- /.thumb-block -->