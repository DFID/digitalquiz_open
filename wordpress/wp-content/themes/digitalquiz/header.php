<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package DFID
 */
?>
<!DOCTYPE html>
<!--[if IE 9]>    <html <?php language_attributes( 'html' ); ?> class="lt-ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes( 'html' ); ?>> <!--<![endif]-->
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
	<header id="masthead" class="site-header" role="banner">
		<div class="feedback-cta">Email <a href="mailto:digitalfordevelopment@dfid.gov.uk">digitalfordevelopment@dfid.gov.uk</a> with any feedback</div>	
		<a class="home-icon light" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">Home</a>
 		<a href="#" onclick="window.print();" class="print-button">Print this page</a>
		<h1><?php the_title(); ?> <span class="title-pipe">|</span></h1>
	</header><!-- #masthead -->

	<div class="">
		<div class="small-10 large-6 columns small-centered">
			<div id="content" class="site-content">


