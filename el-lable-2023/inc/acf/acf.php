<?php
/**
 *  ACF Pro
 */

if( function_exists( 'acf_add_options_sub_page' ) ) {
    acf_add_options_sub_page(array(
		'page_title'  => __( 'Site Options' ),
		'menu_title'  => __( 'Site Options' ),
		'parent_slug' => 'options-general.php',
	));
}

add_filter('acf/format_value/type=text', 'root_acf_format_value', 10, 3);
add_filter('acf/format_value/type=textarea', 'root_acf_format_value', 10, 3);
function root_acf_format_value( $value, $post_id, $field ) {
	return do_shortcode($value);
}

/* Functions */
function get_acf_field_key_by_names( $group_name, $field_name ) {
	$acf_field_id = false;
	$post_ids = get_posts( [
		'post_type' => 'acf-field-group',
		'post_status' => 'publish',
		'numberposts' => 1,
		'title' => $group_name,
		'fields' => 'ids',
	] );
	if( !empty( $post_ids ) ) {
		$acf_fields = acf_get_fields( $post_ids[0] );
		foreach( $acf_fields as $acf_field ) {
			if( $acf_field['label'] == $field_name || $acf_field['name'] == $field_name ) {
				$acf_field_id = $acf_field['key'];
				break;
			}
		}
	}
	return $acf_field_id;
}
