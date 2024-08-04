<?php 
add_filter( 'block_categories_all', function( $block_categories, $editor_context ) {
    if ( ! empty( $editor_context->post ) ) {
        array_push( $block_categories, [
			'slug'  => 'el-lable',
			'title' => __( 'EL-Lable Template', 'el-lable-template' ),
			'icon'  => null,
        ] );
    }
    return $block_categories;
}, 10, 2 );


add_action( 'acf/init', function() {

    if( function_exists( 'acf_register_block_type' ) ) {
		
		$icon = file_get_contents( get_stylesheet_directory() . '/svg/logo.svg' );
		
		acf_register_block_type( [
			'name'              => 'contact-form',
			'title'             => __( 'Contact Form Block' ),
			'description'       => __( 'Contact Form Block with style Elements' ),
			'render_template'   => 'inc/acf/blocks/contact-form.php',
			'category'          => 'el-lable',
			'icon'              => $icon,
			'keywords'          => ['title', 'form', 'call', 'phone', 'mail', 'background', 'caption'],
		] );
		
		acf_register_block_type( [
			'name'              => 'title',
			'title'             => __( 'Title' ),
			'description'       => __( 'Title block for Pages and Posts' ),
			'render_template'   => 'inc/acf/blocks/title.php',
			'category'          => 'el-lable',
			'icon'              => $icon,
			'keywords'          => ['header', 'title', 'breadcrumbs'],
		] );
		
		acf_register_block_type( [
			'name'              => 'delimiter',
			'title'             => __( 'Delimiter' ),
			'description'       => __( 'The Delimiter Block' ),
			'render_template'   => 'inc/acf/blocks/delimiter.php',
			'category'          => 'el-lable',
			'icon'              => $icon,
			'keywords'          => ['image', 'title', 'caption', 'button'],
		] );
		
		acf_register_block_type( [
			'name'              => 'articles',
			'title'             => __( 'Articles' ),
			'description'       => __( 'Article\'s block' ),
			'render_template'   => 'inc/acf/blocks/articles.php',
			'category'          => 'el-lable',
			'icon'              => $icon,
			'keywords'          => ['filter', 'articles', 'button', 'search'],
		] );
		
		acf_register_block_type( [
			'name'              => 'thumb-block',
			'title'             => __( 'Thumb Block' ),
			'description'       => __( 'The Block with Icon, Thumbnail and Button' ),
			'render_template'   => 'inc/acf/blocks/thumb-block.php',
			'category'          => 'el-lable',
			'icon'              => $icon,
			'keywords'          => ['icon', 'title', 'description', 'thumb', 'button'],
		] );
		
		acf_register_block_type( [
			'name'              => 'cases',
			'title'             => __( 'Cases Block' ),
			'description'       => __( 'Cases Block with Label, Title, Description and Button' ),
			'render_template'   => 'inc/acf/blocks/cases.php',
			'category'          => 'el-lable',
			'icon'              => $icon,
			'keywords'          => ['label', 'title', 'description', 'button'],
		] );
		
		acf_register_block_type( [
			'name'              => 'intro',
			'title'             => __( 'Intro' ),
			'description'       => __( 'Intro Block with Slider-Carousel' ),
			'render_template'   => 'inc/acf/blocks/intro.php',
			'category'          => 'el-lable',
			'icon'              => $icon,
			'keywords'          => ['title', 'description', 'button', 'slide', 'light', 'dark', 'mode'],
		] );
		
		acf_register_block_type( [
			'name'              => 'carts',
			'title'             => __( 'Carts' ),
			'description'       => __( 'The Carts' ),
			'render_template'   => 'inc/acf/blocks/carts.php',
			'category'          => 'el-lable',
			'icon'              => $icon,
			'keywords'          => ['title', 'caption', 'description', 'button', 'icon', 'name'],
		] );
		
		acf_register_block_type( [
			'name'              => 'testimonials',
			'title'             => __( 'Testimonials' ),
			'description'       => __( 'The Testimonials' ),
			'render_template'   => 'inc/acf/blocks/testimonials.php',
			'category'          => 'el-lable',
			'icon'              => $icon,
			'keywords'          => ['title', 'caption', 'testimonials'],
		] );
		
		acf_register_block_type( [
			'name'              => 'subscribe-news',
			'title'             => __( 'Subscribe & News' ),
			'description'       => __( 'The Subscribe & News' ),
			'render_template'   => 'inc/acf/blocks/subscribe-news.php',
			'category'          => 'el-lable',
			'icon'              => $icon,
			'keywords'          => ['title', 'caption', 'form', 'post', 'news', 'article'],
		] );
		
		acf_register_block_type( [
			'name'              => 'subheader',
			'title'             => __( 'Subheader' ),
			'description'       => __( 'The Subheader' ),
			'render_template'   => 'inc/acf/blocks/subheader.php',
			'category'          => 'el-lable',
			'icon'              => $icon,
			'keywords'          => ['label', 'title', 'description'],
		] );
		
		acf_register_block_type( [
			'name'              => 'icon-list',
			'title'             => __( 'Icon-List' ),
			'description'       => __( 'The Icon-List' ),
			'render_template'   => 'inc/acf/blocks/icon-list.php',
			'category'          => 'el-lable',
			'icon'              => $icon,
			'keywords'          => ['title', 'icon', 'name', 'caption'],
		] );
		
		/*
		acf_register_block_type( [
			'name'              => 'header',
			'title'             => __( 'Header' ),
			'description'       => __( 'Header block for Pages and Posts' ),
			'render_template'   => 'inc/acf/blocks/header.php',
			'category'          => 'el-lable',
			'icon'              => $icon,
			'keywords'          => ['header', 'title', 'description'],
		] );
		*/
		
		acf_register_block_type( [
			'name'              => 'chat-gpt',
			'title'             => __( 'ChatGPT' ),
			'description'       => __( 'The ChatGPT' ),
			'render_template'   => 'inc/acf/blocks/chat-gpt.php',
			'category'          => 'el-lable',
			'icon'              => $icon,
			'keywords'          => ['chat', 'gpt'],
		] );
		
    }

} );