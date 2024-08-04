<?php 
if( $block['mode'] == 'preview' ) return;

$field = get_field( 'cases' );

if( $field['view'] == 'All' ) {
	$case_ids = get_posts( [
		'post_status' => 'publish',
		'post_type' => 'case-study',
		'numberposts' => -1,
		'fields' => 'ids',
	] );
}
else if( $field['view'] == 'Custom Posts' ) {
	$case_ids = $field['custom_posts'];
}
else{
	$case_ids = [];
}
$post_ids = array_slice( $case_ids, 0, $field['count'] );
?>

<div id="cases" class="cases">
	<?php if( !empty( $field['label'] ) ) { ?><label><?php echo $field['label']; ?></label><?php } ?>
	<?php if( !empty( $field['title'] ) ) { ?><h2><?php echo $field['title']; ?></h2><?php } ?>
	<?php if( !empty( $field['description'] ) ) { ?><p><?php echo $field['description']; ?></p><?php } ?>
	<?php if( !empty( $post_ids ) ) { ?>
		<ul data-case_ids="<?php echo json_encode( $case_ids ); ?>" data-count="<?php echo $field['count']; ?>">
			<?php foreach( $post_ids as $post_id ) get_template_part( 'inc/case', null, ['post_id' => $post_id] ); ?>
		</ul>
	<?php } ?>
	<?php if( count( $case_ids ) > count( $post_ids ) ) { ?>
		<div class="buttons"><a class="button light" href="/page/2/"><?php echo file_get_contents( TEMPLATEPATH . '/svg/reload.svg' ); ?><?php echo $field['load_more_text'] ?></a></div>
	<?php } ?>
</div><!-- /.cases -->