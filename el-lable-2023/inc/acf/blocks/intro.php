<?php 
if( $block['mode'] == 'preview' ) return;

$field = get_field( 'intro' );
?>
 
<section id="<?php echo $block['id']; ?>" class="intro">
	<?php if( !empty( $field ) ) { ?>
		<div class="wrap">
			<ul>
				<?php foreach( $field as $slide ) { ?>
					<li
						<?php if( !empty( $slide['mode'] ) ) { ?> data-mode="<?php echo $slide['mode']; ?>"<?php } ?>
						<?php if( !empty( $slide['background'] ) ) { ?> style="background-image:url(<?php echo $slide['background']['url']; ?>);"<?php } ?>
					>
						<div class="inner">
							<?php if( !empty( $slide['title'] ) ) { ?><h1><?php echo $slide['title']; ?></h1><?php } ?>
							<?php if( !empty( $slide['text'] ) ) { ?><p><?php echo $slide['text']; ?></p><?php } ?>
							<div class="footer">
								<?php if( !empty( $slide['buttons'] ) ) { ?>
									<div class="buttons">
										<?php foreach( $slide['buttons'] as $button ) { ?>
											<a class="button" href="<?php echo $button['button']['url']; ?>" <?php if( $button['button']['target'] ) echo 'target="' . $button['button']['target'] . '"'; ?>>
												<?php echo $button['button']['title']; ?>
												<?php echo file_get_contents( TEMPLATEPATH . '/svg/arrow.svg' ); ?>
											</a>
										<?php } ?>
									</div>
									<?php if( $slide['notice'] ) { ?><i><?php echo $slide['notice']; ?></i><?php } ?>
								<?php } ?>
							</div>
						</div>
					</li>
				<?php } ?>
			</ul>
		</div>
	<?php } ?>
	<div class="bg"></div>
</section><!-- /.intro -->