
<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package DFID
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,300' rel='stylesheet' type='text/css'>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<!-- <a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'dfid' ); ?></a> -->

	<header id="masthead" class="home-header" role="banner">
		<!-- <div class="row"> -->
			<div class="small-12 large-6 large-offset-3 columns large-text-left">
				<div class="site-title">
					<h1><?php bloginfo( 'name' ); ?></h1>
				</div>
			</div>
			<div class="small-12 large-3 columns">
				<div class="logos small-text-center large-text-right">
					<!-- <img src="dist/images/d4d.svg" onerror="this.onerror=null; this.src='image.png'"> -->
					<img src="<?php echo get_template_directory_uri(); ?>/dist/images/logos-top.jpg" alt="Digital4Dev | Department for International Development">
				</div>
			</div>
		<!-- </div> -->


		<!-- <nav id="site-navigation" class="main-navigation" role="navigation">
			<button class="menu-toggle"><?php _e( 'Primary Menu', 'dfid' ); ?></button>
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav> -->

	</header><!-- #masthead -->

	<div class="quiz-page-controls">
		<a class="home-icon light" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">Home</a>
		<div class="progress-meter">
			<p class="percent">0%</p>
			<p>completed</p>
		</div>
	</div>

	<div class="">
		<div class="small-10 large-6 columns small-centered">
			<div id="content" class="site-content">

			
