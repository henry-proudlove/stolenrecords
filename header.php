<?php
/**
 * @package WordPress
 * @subpackage themename
 */
?><!DOCTYPE html>
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="ie6"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="ie8"> <![endif]-->
<!--[if IE 9 ]>    <html <?php language_attributes(); ?> class="ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="chrome=1">

<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'themename' ), max( $paged, $page ) );

	?></title>
	<meta name="description" content="">
	<meta name="author" content="">
	<!--  Mobile Viewport Fix -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    
	<!-- Place favicon.ico and apple-touch-icon.png in the images folder -->
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico">
	<link rel="apple-touch-icon" href="<?php echo get_template_directory_uri(); ?>/images/apple-touch-icon.png"><!--60X60-->
	
	<link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); echo '?' . filemtime( get_stylesheet_directory() . '/style.css'); ?>" type="text/css" media="screen, projection" />
    
    <link rel="stylesheet" href="<?php echo get_template_directory_uri() . '/css/jquery-ui-1.8.18.custom.css'; ?>" type="text/css" media="screen" />
<!--<link rel="stylesheet" href="css/print.css" type="text/css" media="print" />-->

	<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	
	<?php wp_head(); ?>
	</head>
	
	<body <?php body_class(); ?>>
	<div id="page" class="hfeed clearfix">
		<header id="branding" role="banner">
			<hgroup>
				<a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
					<h1 id="site-title"><span><?php bloginfo( 'name' ); ?></span></h1>
					<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
				</a>
			</hgroup>
			
			<?php sr_global_nav(); ?>
			<?php sr_social_links(true, true); ?>
			<!-- Subscibe form -->
			
			<script type="text/javascript">
			function clearMe(formfield) {formfield.value = "";}
			</script>
			<div id="subscribe-form">
				<h3>Subscribe</h3>
				<form action="http://stolen.greedbag.com/subscribe/" method="post">
					<fieldset>
						<input type="hidden" name="form_action" value="create_account_minimal" />
						<input type="hidden" name="mailservice_identifier" value="stolen-recording" />
						<input type="hidden" name="add_free_gifts" value="1" /><input type="hidden" name="on_success" value="thanks.html" />
						<input type="text" id="signup_email" name="email" value="Your email" size="25" maxlength="64" onfocus="clearMe(this)" />
						<input type="submit" class="submit" name="send" value="Go" />
					</fieldset>
				</form>
			</div><!-- #subscribe-form -->
		</header><!-- #branding -->
		<div id="main" class="clearfix">