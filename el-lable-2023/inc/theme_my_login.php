<?php
/* Theme My Login */
add_action( 'init', 'modify_tml_forms' );
function modify_tml_forms() {
	/* add extra registration fields */
	tml_add_form_field( 'register', 'first_name', array(
		'type'     => 'text',
		'label'    => 'Имя',
		'value'    => tml_get_request_value( 'first_name', 'post' ),
		'id'       => 'first_name',
		'priority' => 15,
	) );
	tml_add_form_field( 'register', 'last_name', array(
		'type'     => 'text',
		'label'    => 'Фамилия',
		'value'    => tml_get_request_value( 'last_name', 'post' ),
		'id'       => 'last_name',
		'priority' => 15,
	) );
	tml_add_form_field( 'register', 'phone', array(
		'type'     => 'text',
		'label'    => 'Номер телефона',
		'value'    => tml_get_request_value( 'phone', 'post' ),
		'id'       => 'phone',
		'priority' => 15,
	) );
	$placeholders = [
		'first_name' => 'Имя',
		'last_name' => 'Фамилия',
		'user_email' => 'Email',
		'phone' => 'Телефон',
	];
	foreach ( tml_get_forms() as $form ) {
		foreach ( tml_get_form_fields( $form ) as $field ) {
			if ( 'hidden' == $field->get_type() ) {
				continue;
			}
			foreach( $placeholders as $label => $placeholder ) {
				if( $field->get_name() == $label ){
					$field->render_args['after'] = '<span class="placeholder">' . $placeholder . '</span></div>';
				}
			}
		}
	}
}
// validation new Theme My Login fields
add_filter( 'registration_errors', 'validate_tml_registration_form_fields' );
function validate_tml_registration_form_fields( $errors ) {
	if ( empty( $_POST['phone'] ) || strpos( $_POST['phone'], 'Х' ) !== false ) {
		$errors->add( 'empty_phone', __( '<strong>Error</strong>: Please enter the correct phone number.' ) );
	}
	if ( empty( $_POST['first_name'] ) || strlen( trim( $_POST['first_name'] ) ) < 1 ) {
		$errors->add( 'empty_first_name', __( '<strong>Error</strong>: Please type your First Name.' ) );
	}
	if ( empty( $_POST['last_name'] ) || strlen( trim( $_POST['last_name'] ) ) < 1 ) {
		$errors->add( 'empty_last_name', __( '<strong>Error</strong>: Please type your Last Name.' ) );
	}
	return $errors;
}
// Save new Theme My Login fields
add_action( 'user_register', 'save_tml_registration_form_fields' );
function save_tml_registration_form_fields( $user_id ) {
	if ( isset( $_POST['phone'] ) ) {
		update_field( 'phone', sanitize_text_field( preg_replace( '/(\s|\-)/i', '', $_POST['phone'] ) ), 'user_' . $user_id );
	}
	if ( isset( $_POST['first_name'] ) ) {
		update_user_meta( $user_id , 'first_name', sanitize_text_field( $_POST['first_name'] ) );
	}
	if ( isset( $_POST['last_name'] ) ) {
		update_user_meta( $user_id, 'last_name', sanitize_text_field( $_POST['last_name'] ) );
	}	
}