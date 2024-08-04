<?php 
if( $block['mode'] == 'preview' ) return;

$field = get_field( 'subheader' );

?>

<div id="<?php echo $block['id']; ?>" class="subheader">
	<?php if( !empty( $field['label'] ) ) { ?><label><?php echo $field['label']; ?></label><?php } ?>
	<?php if( !empty( $field['title'] ) ) { ?><h2><?php echo $field['title']; ?></h2><?php } ?>
	<?php if( !empty( $field['description'] ) ) { ?><p><?php echo $field['description']; ?></p><?php } ?>
</div><!-- /.subheader -->