<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
<?php if ( is_search() ) { ?>
	<meta name="robots" content="noindex, nofollow" /> 
<?php } ?>
	<meta name="format-detection" content="telephone=no" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
	
	<meta name="zen-verification" content="TiQJaTozhZvAMKDfMqTNiCg4DoSwEL3FyP9osXng340yf7eWmnbmg9DyTdv6MKZ3" />
</head>

<body <?php body_class(); ?>>

<div id="wrap_outer">
	<div id="wrap">
		<section id="header">
			<?php if( has_custom_logo() ) { ?>
				<div class="logo">
					<a href="<?php echo get_site_url(); ?>" class="custom-logo-link" rel="home"><?php echo get_icon( get_theme_mod( 'custom_logo' ) ); ?></a>
				</div>
			<?php } ?>
			<?php if ( is_active_sidebar( 'header' ) ) { ?><?php dynamic_sidebar( 'header' ); ?><?php } ?>
			<a href="#mobile_menu" class="burger">
				<span></span>
				<span></span>
				<span></span>
			</a>
		</section><!-- /#header -->
		
		<section id="content">
			<?php if( !is_single() ) { ?>
				<?php if( is_active_sidebar( 'before-content' ) ) { ?><section class="before_content"><?php dynamic_sidebar( 'before-content' ); ?></section><?php } ?><!-- /.before_content -->
			<?php } ?>