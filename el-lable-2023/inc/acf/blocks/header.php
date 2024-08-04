<?php 
if( $block['mode'] == 'preview' ) return;

$field = get_field( 'header' );
?>
<div id="<?php echo $block['id']; ?>" class="header">
	<?php if( !empty( $field['title'] ) ) { ?><h1 data-aos="zoom-in" data-aos-delay="0" data-aos-anchor="#<?php echo $block['id']; ?>"><?php echo slicing_text( $field['title'] ); ?></h1><?php } ?>
	<?php if( !empty( $field['description'] ) ) { ?><figcaption data-aos="zoom-in" data-aos-delay="0" data-aos-anchor="#<?php echo $block['id']; ?>"><?php echo $field['description']; ?></figcaption><?php } ?>
</div><!-- /.header -->