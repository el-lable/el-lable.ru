<?php 
if( $block['mode'] == 'preview' ) return;

$field = get_field( 'title' );

?>
<section id="<?php echo $block['id']; ?>" class="title">
	<div class="bg"><img src="<?php if( !empty( $field['background'] ) ) { ?><?php echo $field['background']['url']; ?>"><?php } ?></div>
	<?php if( !empty( $field['breadcrumbs'] ) ) { ?><div class="breadcrumbs"><?php echo bcn_display(); ?></div><?php } ?>
	<h1><?php echo $field['title']; ?></h1>
</section><!-- /.title -->


