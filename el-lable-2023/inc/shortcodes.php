<?php
/** 
 *	Theme's shortcodes 
 */

add_shortcode( 'logo', 'show_logo' );
add_shortcode( 'date', 'show_date' );
add_shortcode( 'work-time', 'show_worktime' );
add_shortcode( 'worktime', 'show_worktime' );
add_shortcode( 'phone', 'show_phone' );
add_shortcode( 'fax', 'show_fax' );
add_shortcode( 'address', 'show_address' );

// [logo]
function show_logo() {
	if( !has_custom_logo() ) return;
	ob_start();
?>
<div class="logo">
	<a href="<?php echo get_site_url(); ?>" class="custom-logo-link" rel="home"><?php echo get_icon( get_theme_mod( 'custom_logo' ) ); ?></a>
</div>
<?php
	return ob_get_clean();
}

// [date]
function show_date( $attr ) {
	return date( isset( $attr['format'] ) ? $attr['format'] : 'Y:d:m' );
}

// [worktime]
function show_worktime() {
	
	$field = get_field( 'worktime', 'options' );
	if( empty( $field ) ) return;
	
	ob_start();
?>
<span class="worktime"><?php echo $field; ?></span>
<?php
	return ob_get_clean();
}
// [phone]
function show_phone() {
	
	$field = get_field( 'phone', 'options' );
	if( empty( $field ) ) return;
	
	ob_start();
?>
<a href="<?php echo $field['url'] ?>"<?php if( $field['target'] ) echo ' target="' . $field['target'] . '"' ?>><?php echo $field['title'] ?></a>
<?php
	return ob_get_clean();
}
// [fax]
function show_fax() {
	
	$field = get_field( 'fax', 'options' );
	if( empty( $field ) ) return;
	
	ob_start();
?>
<a href="<?php echo $field['url'] ?>"<?php if( $field['target'] ) echo ' target="' . $field['target'] . '"' ?>><?php echo $field['title'] ?></a>
<?php
	return ob_get_clean();
}

// [address]
function show_address() {
	
	$field = get_field( 'address', 'options' );
	if( empty( $field ) ) return;
	
	ob_start();
?>
<span class="address"><?php echo $field; ?></span>
<?php
	return ob_get_clean();
}



?>