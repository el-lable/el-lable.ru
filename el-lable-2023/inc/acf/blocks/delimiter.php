<?php 
if( $block['mode'] == 'preview' ) return;

$field = get_field( 'delimiter' );
?>

<div id="<?php echo $block['id']; ?>" class="delimiter">
	<?php if( !empty( $field['image'] ) ) { ?><div class="image"><?php echo get_icon( $field['image']['id'] ); ?></div><?php } ?>
	<?php if( !empty( $field['title'] ) ) { ?><h2><?php echo $field['title']; ?></h2><?php } ?>
	<?php if( !empty( $field['caption'] ) ) { ?><p><?php echo $field['caption']; ?></p><?php } ?>
	<?php if( !empty( $field['buttons'] ) ) { ?>
		<div class="buttons">
			<?php foreach( $field['buttons'] as $button ) { ?>
				<a class="button light" href="<?php echo $button['button']['url']; ?>" <?php if( $button['button']['target'] ) echo 'target="' . $button['button']['target'] . '"'; ?>>
					<?php echo file_get_contents( TEMPLATEPATH . '/svg/download-icon.svg' ); ?>
					<?php echo $button['button']['title']; ?>
				</a>
			<?php } ?>
		</div>
	<?php } ?>
</div><!-- /.delimiter -->