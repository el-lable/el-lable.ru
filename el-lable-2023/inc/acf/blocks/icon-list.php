<?php 
if( $block['mode'] == 'preview' ) return;

$field = get_field( 'icon-list' );

?>

<div id="<?php echo $block['id']; ?>" class="icon-list">
	<?php if( !empty( $field['title'] ) ) { ?><h2><?php echo $field['title']; ?></h2><?php } ?>
	<hr>
	<?php if( !empty( $field['bullets'] ) ) { ?>
		<ul>
			<?php foreach( $field['bullets'] as $item ) { ?>
				<li>
					<div class="icon"><?php echo get_icon( $item['icon']['url'] ); ?></div>
					<figcaption>
						<?php if( !empty( $item ['name'] ) ) { ?>
							<b>
								<?php echo $item ['name']; ?>
								<?php if( !empty( $item ['caption'] ) ) { ?> - <?php } ?>
							</b>
						<?php } ?>
						<?php if( !empty( $item ['caption'] ) ) { ?><span><?php echo $item ['caption']; ?></span><?php } ?>
					</figcaption>
				</li>
			<?php }?>
		</ul>
	<?php }?>
</div><!-- /.icon-list -->