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

	<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	
	<?php wp_head(); ?>
	</head>
	
	<body <?php body_class(); ?>>
	<div id="page" class="hfeed">
		<header id="branding" role="banner">
			<hgroup>
				<h1 id="site-title"><span><a href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span></h1>
				<h2 id="site-description"><?php bloginfo( 'description' ); ?></h2>
			</hgroup>
			
			<nav id="access" role="article">
				<ul>
					<li><a href="<?php echo get_post_type_archive_link( 'artist' ); ?>">Artists</a>
						<ul class="artists-menu">
							<?php 
							$args = array('post_type' => 'artist' , 'posts_per_page' => '-1' , 'orderby' => 'title' , 'order' => 'ASC' , 'meta_key' => '_sr_present-past', 'meta_value' => 'current');
					
							$art_nav_query = new WP_Query($args);
							
							while ( $art_nav_query->have_posts() ) : $art_nav_query->the_post(); ?>
								<li><a href="<?php the_permalink(); ?>" class="art-nav-link" title="<?php echo get_the_title() . ' profile'; ?>" rel="bookmark"><?php the_title(); ?></a></li>
							<?php 
							endwhile;
							
							$args['meta_value'] = 'past';
							
							$art_nav_query = new WP_Query($args);
						
							while ( $art_nav_query->have_posts() ) : $art_nav_query->the_post(); ?>
							
								<li><a href="<?php the_permalink(); ?>" class="art-nav-link" title="<?php echo get_the_title() . ' profile'; ?>" rel="bookmark"><?php the_title(); ?></a></li> 
							<?php endwhile; wp_reset_query(); ?>
						</ul>
					</li>
					<li><a href="<?php echo get_post_type_archive_link( 'release' ); ?>">Releases</a></li>
					<li><a href="<?php echo get_post_type_archive_link( 'show' ); ?>">Shows</a></li>
					<?php
						//$showsarchive = get_page_by_title( 'Stolen Shows Archives' );
						$args = array('title_li' => '' , 'exclude' => '1249,1254');
						wp_list_pages( $args );
					?>
				</ul>
			</nav><!-- #access -->
			<?php sr_social_links(true, true); ?>
		</header><!-- #branding -->
	
	
		<div id="main">