<?php

// custom code
if( !is_admin() ) {
	require_once( TEMPLATEPATH . '/inc/shortcodes.php' );	
}
require_once( TEMPLATEPATH . '/inc/acf/acf.php' );
require_once( TEMPLATEPATH . '/inc/acf/blocks-registration.php' );
require_once( TEMPLATEPATH . '/inc/theme_my_login.php' );

// Add RSS links to <head> section
add_theme_support( 'automatic-feed-links' );

// Correct insert Meta, Title
add_action( 'after_setup_theme', 'biq_slug_setup' );
function biq_slug_setup() {
    add_theme_support( 'title-tag' );
}

// logo
add_theme_support( 'custom-logo', [
	'height'      => 9999,
	'width'       => 9999,
	'flex-width'  => true,
	'flex-height' => true,
	'header-text' => '',
] );

/**
 * Enqueue scripts and styles.
 *
 * @since Bank IQ 1.0
 */
add_action( 'wp_default_scripts', 'el_print_jquery_in_footer' );
function el_print_jquery_in_footer( &$scripts) {
	if ( ! is_admin() ) $scripts->add_data( 'jquery', 'group', 1 );
}
add_action( 'wp_enqueue_scripts', 'biq_scripts' );
function biq_scripts() {
    // styles
	wp_enqueue_style( 'owl', get_template_directory_uri() . "/css/owl.carousel.css" );
	wp_enqueue_style( 'fancybox', get_template_directory_uri() . '/css/jquery.fancybox.min.css' );
	//wp_enqueue_style( 'aos', get_template_directory_uri() . '/css/aos.css' );
    wp_enqueue_style( 'style', get_stylesheet_uri() );
    
	// scripts
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'owl', get_template_directory_uri() . "/js/owl.carousel.min.js", [], null, "in_footer" );
	wp_enqueue_script( 'fancybox', get_template_directory_uri() . "/js//jquery.fancybox.min.js", [], null, "in_footer" );
	wp_enqueue_script( 'inputmask', get_template_directory_uri() . "/js/inputmask/jquery.inputmask.js", [], null, "in_footer" );
	//wp_enqueue_script( 'aos', get_template_directory_uri() . '/js/aos.js' );
	wp_enqueue_script( 'scripts', get_template_directory_uri() . "/js/scripts.js", [], null, "in_footer" );
	wp_localize_script( 'scripts', 'ajax', 
		array(
			'url' => admin_url( 'admin-ajax.php' ),
		)
	);
	
	// Vue.js - scripts
	if( is_page_template( ['page-credentials.php'] ) ) {
		if( is_user_logged_in() && in_array( 'administrator', wp_get_current_user()->roles ) ) {
			wp_enqueue_script( 'vue-dev', "https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js", [], null, "in_footer" );
		}
		else{
			wp_enqueue_script( 'vue-prod', "https://cdn.jsdelivr.net/npm/vue@2", [], null, "in_footer" );
		}
		wp_enqueue_script( 'vue-scripts', get_template_directory_uri() . "/js/vue-scripts.js", [], null, "in_footer" );

		wp_deregister_script( 'inputmask' );
	}
}

// Clean up the <head>
add_action('init', 'removeHeadLinks');
function removeHeadLinks() {
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
}
remove_action( 'wp_head', 'wp_generator' );

// Declare widget zones
if( function_exists( 'register_sidebar' ) ) {
	register_sidebar(array(
        'name' => 'Header',
        'id' => 'header',
        'description' => 'Header',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>'
    ));
	register_sidebar(array(
        'name' => 'Before Content',
        'id' => 'before-content',
        'description' => 'Before Content',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>'
    ));
	register_sidebar(array(
        'name' => 'After Content',
        'id' => 'after-content',
        'description' => 'After Content',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>'
    ));
    register_sidebar(array(
        'name' => 'Footer',
        'id' => 'footer',
        'description' => 'Footer',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2>',
        'after_title' => '</h2>'
    ));
}
// add working shortcodes in text widgets
add_filter('widget_text', 'do_shortcode');
add_theme_support('html5', array('comment-list', 'comment-form', 'search-form', 'gallery', 'caption'));
add_filter('use_default_gallery_style', '__return_false');

// remove autoformat
remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );
remove_filter( 'comment_text', 'wpautop' );

/* add custom image sizes */
add_theme_support( 'post-thumbnails' );
if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'post-thumbnail', 360, 200, true );
	add_image_size( 'vetical-thumbnail', 420, 99999, true );
	add_image_size( 'case-thumbnail', 500, 500, true );
	add_image_size( 'photo-thumbnail', 260, 260, true );
}

/* Add SVG */
add_filter( 'upload_mimes', 'svg_upload_allow' );
add_filter( 'wp_check_filetype_and_ext', 'fix_svg_mime_type', 10, 5 );
add_filter( 'wp_prepare_attachment_for_js', 'show_svg_in_media_library' );
function svg_upload_allow( $mimes ) {
	$mimes['svg']  = 'image/svg+xml';
	return $mimes;
}
function fix_svg_mime_type( $data, $file, $filename, $mimes, $real_mime = '' ){
	if( version_compare( $GLOBALS['wp_version'], '5.1.0', '>=' ) )
		$dosvg = in_array( $real_mime, [ 'image/svg', 'image/svg+xml' ] );
	else
		$dosvg = ( '.svg' === strtolower( substr($filename, -4) ) );
	if( $dosvg ){
		if( current_user_can('manage_options') ){
			$data['ext']  = 'svg';
			$data['type'] = 'image/svg+xml';
		}
		else {
			$data['ext'] = $type_and_ext['type'] = false;
		}
	}
	return $data;
}
function show_svg_in_media_library( $response ) {
	if ( $response['mime'] === 'image/svg+xml' ) {
		$response['image'] = [
			'src' => $response['url'],
		];
	}
	return $response;
}

if( !'disable_gutenberg' ){
	add_filter( 'use_block_editor_for_post_type', '__return_false', 100 );
	remove_action( 'wp_enqueue_scripts', 'wp_common_block_scripts_and_styles' );
	add_action( 'admin_init', function(){
		remove_action( 'admin_notices', [ 'WP_Privacy_Policy_Content', 'notice' ] );
		add_action( 'edit_form_after_title', [ 'WP_Privacy_Policy_Content', 'notice' ] );
	} );
}
// Disables the block editor from managing widgets in the Gutenberg plugin.
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
// Disables the block editor from managing widgets.
add_filter( 'use_widgets_block_editor', '__return_false' );

/* Disable updating a plugins */
add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );
function filter_plugin_updates( $value ) {
	if( isset( $value->response ) ) {
		unset( $value->response['advanced-custom-fields-pro/acf.php'] );
		unset( $value->response['visitors-traffic-real-time-statistics-pro/visitors-traffic-real-time-statistics-pro.php'] );
		unset( $value->response['wp-mail-smtp-pro/wp_mail_smtp.php'] );
		unset( $value->response['admin-columns-pro/admin-columns-pro.php'] );
		unset( $value->response['wpdatatables/wpdatatables.php'] );
	}
	return $value;
}

add_post_type( 'case-study', __( 'Case Studies', 'default' ), array(
	'labels' => ['add_new' => 'Add new', 'new_item' => 'Add new Case', 'add_new_item' => 'Add new Case'],
	'supports'   => ['title', 'editor', 'thumbnail', 'excerpt'],
	'taxonomies' => [],
	'menu_icon' => 'dashicons-book',
	'exclude_from_search' => true,
	'capability_type' => 'post',
) );
add_post_type( 'testimonial', __( 'Testimonials', 'default' ), array(
	'labels' => ['add_new' => 'Add new', 'new_item' => 'Add new Testimonial', 'add_new_item' => 'Add new Testimonial'],
	'supports'   => ['title', 'editor', 'thumbnail'],
	'taxonomies' => [],
	'menu_icon' => 'dashicons-editor-quote',
	'exclude_from_search' => true,
	'capability_type' => 'post',
) );
add_post_type( 'credential', __( 'Credentials', 'default' ), array(
	'labels' => ['add_new' => 'Add new', 'new_item' => 'Add new Credential', 'add_new_item' => 'Add new Credential'],
	'supports'   => ['title', 'editor', 'thumbnail'],
	'taxonomies' => [],
	'menu_icon' => 'dashicons-admin-network',
	'public' => false,
	'exclude_from_search' => true,
	'publicly_queryable' => false,
	'capability_type' => 'post',
) );
function add_post_type( $name, $label, $args = [] ) {
	add_action( 'init', function() use( $name, $label, $args ) {
		$upper = ucwords( $name );
		$name = strtolower( str_replace( ' ', '_', $name ) );
		$args = array_merge( [
			'public' => true,
			'label' => "$label",
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'capability_type' => 'post',
			'has_archive' => true,
			'labels' => ['add_new_item' => 'Add new item'],
			'supports' => ['title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'],
			'taxonomies' => ['post_tag', 'category'],
			'show_in_rest' => true,
			'menu_position' => 11,
			'menu_icon' => 'dashicons-format-aside'
		], $args );
		register_post_type( $name, $args );
	});
}

/* Disable Gutenberg for Custom Post Types */
add_filter( 'use_block_editor_for_post_type', function( $current_status, $post_type ) {
	return ! in_array( $post_type, ['case-study', 'testimonial', 'credential'], true );
}, 10, 2 );

/* Remove 'category' from URL */
/*add_filter( 'category_link' , function( $a ) {
	return str_replace( 'category/', '', $a );
}, 99 );*/

// Ajax load for posts
add_action( 'wp_ajax_load_posts', 'ajax_load_posts' );
add_action( 'wp_ajax_nopriv_load_posts', 'ajax_load_posts' );
function ajax_load_posts() {
	if( !isset( $_POST['data'] ) || !isset( $_POST['pager'] ) ) wp_send_json( ['error' => __( 'Error input data' )] );
	$data = $_POST['data'];
	
	$args = [
		'post_status' => 'publish',
		'posts_per_page' => get_option( 'posts_per_page' ),
		'paged' => $_POST['pager'],
	];
	
	if( !empty( $data['category_id'] ) ) {
		$args = array_merge( $args, [
			'cat' => $data['category_id'],
		] );
	}
	if( !empty( $data['search'] ) ) {
		$args = array_merge( $args, [
			's' => trim( $data['search'] ),
		] );
	}
	query_posts( $args );
	
	ob_start();
?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	
	<?php get_template_part( 'inc/article' ); ?>

<?php endwhile; endif; ?>

<?php
	$posts = ob_get_clean();
	
	$args['posts_per_page'] = -1;
	$args['fields'] = 'ids';
	unset( $args['paged'] );
	$page_count = count( query_posts( $args ) );
	
	wp_send_json( [
		'posts' => $posts,
		'all' => $page_count,
		'remaining' => $page_count - get_option( 'posts_per_page' ) * $_POST['pager'],
	] );
}

// Ajax load for Cases
add_action( 'wp_ajax_load_cases', 'ajax_load_cases' );
add_action( 'wp_ajax_nopriv_load_cases', 'ajax_load_cases' );
function ajax_load_cases() {
	if( !isset( $_POST['data'] ) || !isset( $_POST['pager'] ) ) wp_send_json( ['error' => __( 'Error input data' )] );
	$data = $_POST['data'];
	
	$args = [
		'post_status' => 'publish',
		'posts_per_page' => get_option( 'posts_per_page' ),
		'paged' => $_POST['pager'],
		'fields' => 'ids',
	];
	if( !empty( $data['case_ids'] ) ) {
		$args = array_merge( $args, [
			'post_type' => 'case-study',
			'post__in' => $data['case_ids'],
			'posts_per_page' => $data['count'],
			'orderby' => 'post__in',
		] );
	}
	if( !empty( $data['post_type'] ) ) {
		$args = array_merge( $args, [
			'post_type' => $data['post_type'],
		] );
		$data['count'] = get_option( 'posts_per_page' );
	}
	$case_ids = get_posts( $args );
	
	ob_start();
	
	foreach( $case_ids as $case_id ) get_template_part( 'inc/case', null, ['post_id' => $case_id] );
	
	$cases = ob_get_clean();
	
	$args['posts_per_page'] = -1;
	unset( $args['paged'] );
	$page_count = count( get_posts( $args ) );
	
	
	wp_send_json( [
		'cases' => $cases,
		'all' => $page_count,
		'remaining' => $page_count - $data['count'] * $_POST['pager'],
	] );
}

// Ajax Add a Credential
add_action( 'wp_ajax_' . 'add_credential', function() {
	$user_id = get_current_user_id();
	$credential_id = wp_insert_post(  wp_slash( [
		'post_title'    => !empty( $_POST['title'] ) ? trim( $_POST['title'] ) : '',
		'post_content'  => !empty( $_POST['description'] ) ? trim( $_POST['description'] ) : '',
		'post_status'   => 'publish',
		'post_type'     => 'credential',
		'post_author'   => $user_id,
		'ping_status'   => get_option( 'default_ping_status' ),
		'meta_input'   => [
			'url' => !empty( $_POST['url'] ) ? trim( $_POST['url'] ) : '',
		],
	] ) );
	if( is_wp_error( $credential_id ) ) wp_send_json( ['error' => $credential_id->get_error_message()] );
	
	wp_send_json( [
		'id' => $credential_id,
		'title' => get_the_title( $credential_id ),
		'description' => get_the_content( '', '', $credential_id ),
		'fields' => get_fields( $credential_id ),
	] );
} );

// Ajax Remove a Credential
add_action( 'wp_ajax_' . 'remove_credential', function() {
	$user_id = get_current_user_id();
	if( empty( $_POST['id'] ) || $user_id != get_post_field( 'post_author', (int)$_POST['id'] ) ) wp_send_json( ['error' => 'You don\'t have permissions to edit this Credential.'] );
	
	$deleted = wp_delete_post( (int)$_POST['id'], true );

	if( !$deleted ) wp_send_json( ['error' => 'Error removing the Credential.'] );

	wp_send_json( [
		'id' => $deleted->ID,
	] );
} );

// Ajax Update Credential Entry
add_action( 'wp_ajax_' . 'update_credential_entry', function() {
	$user_id = get_current_user_id();
	if( empty( $_POST['id'] ) || $user_id != get_post_field( 'post_author', (int)$_POST['id'] ) ) wp_send_json( ['error' => 'You don\'t have permissions to edit this Credential.'] );
	
	$credential_id = (int)$_POST['id'];
	//$credential_entry = !empty( $_POST['credential-entry'] ) ? $_POST['credential-entry'] : null;
	if( !empty( $_POST['credential-entry'] ) ) {
		$credentials = !empty( get_field( 'credentials', $credential_id ) ) ? get_field( 'credentials', $credential_id ) : [];
		$credential_entry = json_decode( urldecode( $_POST['credential-entry'] ), true );
		$keys_notices = [];
		if( !empty( $credential_entry['keys-notices'] ) ) foreach( $credential_entry['keys-notices'] as $item ) {
			if( $item == '' ) continue;
			$keys_notices[] = ['item' => $item];
		}
		$credentials[] = [
			'auth' => $credential_entry['auth'],
			'password' => $credential_entry['password'],
			'keys-notices' => !empty( $keys_notices ) ? $keys_notices : null,
		];
		update_field( 'credentials', $credentials, $credential_id );
	}
	
	wp_send_json( [
		'id' => $credential_id,
		'credentials' => get_field( 'credentials', $credential_id ),
	] );
} );

/* Antispam CF7 */
add_filter( 'wpcf7_validate', function( $result, $tags ) {
	$form = WPCF7_Submission::get_instance();
	$label = $form->get_posted_data( 'boulder' );
	if ( empty( $label ) || $label != 'dash' ) die( 'Spamers must die!' );
	return $result;
}, 10, 2 );

// перевод недостающих слов без затрагивания файлов темы и перевода
add_filter( 'gettext', function( $translation, $text, $domain ) {
	
	if( $domain == 'default' ) {
		if( $text == 'Call us' ) $translation = 'Позвонить';
		if( $text == 'Write Us' ) $translation = 'Отправить Fax';
		if( $text == 'Mail to us' ) $translation = 'Написать Письмо';
		if( $text == 'Search Articles' ) $translation = 'Поиск Статей';
		if( $text == 'Read full Article' ) $translation = 'Читать полностью';
		if( $text == 'Related Articles' ) $translation = 'Недавние статьи';
		if( $text == 'No Previous Articles' ) $translation = 'Нет предыдущих статей';
		if( $text == 'Previous Article' ) $translation = 'Предыдущая статья';
		if( $text == 'Next Article' ) $translation = 'Следующая статья';
		if( $text == 'Required Fields' ) $translation = 'Обязательные поля';
		if( $text == 'Sorting' ) $translation = 'Сортировка';
		if( $text == 'Login' ) $translation = 'Логин';
		if( $text == 'Email' ) $translation = 'Имейл';
		if( $text == 'Phone' ) $translation = 'Телефон';
		if( $text == 'User: <b>%s %s</b>' ) $translation = 'Пользователь: <b>%s %s</b>';
		if( $text == 'Keys/Notices' ) $translation = 'Ключи/Нотации';
		if( $text == 'Add new credential' ) $translation = 'Добавить новый доступ';
		if( $text == '+ Add Credential' ) $translation = '+ Добавить Доступ';
		if( $text == 'Add Credential Entry' ) $translation = 'Добавить Запись доступа';
		if( $text == 'Save Changes' ) $translation = 'Сохранить изменения';
		if( $text == 'Remove the Entry' ) $translation = 'Добавить запись';
		if( $text == 'Add the Entry' ) $translation = 'Удалить запись';
	}
	if( $domain == 'theme-my-login' || $domain == 'default' ) {
		if( $text == '<strong>Error</strong>: Please enter the correct phone number.' ) $translation = '<strong>Ошибка</strong>: Пожалуста введите корректный номер телефона.';
		if( $text == '<strong>Error</strong>: Please type your First Name.' ) $translation = '<strong>Ошибка</strong>: Пожалуста введите ваше имя.';
		if( $text == '<strong>Error</strong>: Please type your Last Name.' ) $translation = '<strong>Ошибка</strong>: Пожалуста введите вашу фамилию.';
	}

	return $translation;
}, 10, 3 );

add_filter( 'wp_nav_menu_objects', function ( $sorted_menu_items, $args ) {
	if( is_user_logged_in() && ($args->menu->slug == 'main-menu' || $args->menu->name == 'Main menu') ) {
		foreach( $sorted_menu_items as $n => $menu_item ) {
			if( $menu_item->title == 'Вход' ) {
				$sorted_menu_items[$n]->title = 'Личные доступы';
				$sorted_menu_items[$n]->url = '/credentials/';
			}
		}
	}
	return $sorted_menu_items;
}, 10, 2 );



/* Functions */
function el( $data ) {
	error_log( print_r( $data, true ) );
}
/* Get icon */
function get_icon( $src ) {
	if( empty( $src ) ) return '';
	if( is_numeric( $src ) ) $src = wp_get_attachment_url( $src );
	if( preg_match( '/\.svg$/', $src ) ) {
		preg_match( '/(?<=\.ru)\S+/', $src, $result );
		$src = $_SERVER['DOCUMENT_ROOT'] . $result[0];
		return file_get_contents( $src );
	}
	else{
		return '<img src="'. $src .'">';
	}
}
function slicing_text( $text ) {
	return sprintf( '<span>%s</span>', str_replace( '<br />', '</span> <span>', $text ) );
}
function get_video_URL( $html ) {
	preg_match( '/(?<=")\S+\/\/\S+(?=")/', $html, $url );
	return $url ? $url[0] : null;
}
function get_video_ID( $url ) {
	$video_id = explode( 'embed/', $url );
	$video_id = explode( '?', $video_id[1] );
	return !empty( $video_id ) ? $video_id [0] : null;
}