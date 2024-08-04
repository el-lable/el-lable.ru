<?php 
if( $block['mode'] == 'preview' ) return;

$field = get_field( 'carts' );
?>

<div id="<?php echo $block['id']; ?>" class="carts">
	<?php if( !empty( $field['title'] ) ) { ?><h2><?php echo $field['title']; ?></h2><?php } ?>
	<?php if( !empty( $field['caption'] ) ) { ?><figcaption><?php echo $field['caption']; ?></figcaption><?php } ?>
	<?php if( !empty( $field['button'] ) ) { ?>
		<div class="buttons">
			<a class="button" href="<?php echo $field['button']['url']; ?>" <?php if( $field['button']['target'] ) echo 'target="' . $field['button']['target'] . '"'; ?>>
				<?php echo $field['button']['title']; ?>
				<?php echo file_get_contents( TEMPLATEPATH . '/svg/arrow.svg' ); ?>
			</a>
		</div>
	<?php } ?>
	<?php if( !empty( $field['items'] ) ) { ?>
		<ul>
			<?php foreach( $field['items'] as $item ) { ?>
				<li>
					<?php if( !empty( $item['name'] ) ) { ?><h4><?php echo $item['name']; ?></h4><?php } ?>
					<?php if( !empty( $item['icon'] ) ) { ?><div class="icon"><?php echo get_icon( $item['icon']['url'] ); ?></div><?php } ?>
					<?php if( !empty( $item['description'] ) ) { ?><p><?php echo $item['description']; ?></p><?php } ?>
				</li>
			<?php } ?>
		</ul>
	<?php } ?>
</div><!-- /.carts -->