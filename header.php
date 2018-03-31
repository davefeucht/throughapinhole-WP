<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php echo(get_bloginfo('name')); ?></title>
	<link href='http://fonts.googleapis.com/css?family=Special+Elite' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Rajdhani:400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css">
	<?php wp_head(); ?>
</head>
<body>
<div id="site">
<div id="header" class="full_header_div">
	<div id="header_title" class="header_title_div">
		<h1><a href="<?php echo(get_site_url());?>"><?php echo(get_bloginfo('name')); ?></a></h1>
	</div>
	<!--
	<span id="header_menu" class="header_menu_span">
	-->
		<?php wp_nav_menu( array( 'theme_location' => 'header-nav-menu' ) ); ?>
	<!--
	</span>
	-->
</div>
<div id="content">
