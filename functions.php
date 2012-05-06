<?php
/**
 * @package WordPress
 * @subpackage themename
 */

/**
 * Make theme available for translation
 * Translations can be filed in the /languages/ directory
 */
load_theme_textdomain( 'themename', get_template_directory() . '/languages' );

$locale = get_locale();
$locale_file = get_template_directory() . "/languages/$locale.php";
if ( is_readable( $locale_file ) )
	require_once( $locale_file );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640;

/**
 * Remove code from the <head>
 */
//remove_action('wp_head', 'rsd_link'); // Might be necessary if you or other people on this site use remote editors.
//remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
//remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
//remove_action('wp_head', 'index_rel_link'); // Displays relations link for site index
//remove_action('wp_head', 'wlwmanifest_link'); // Might be necessary if you or other people on this site use Windows Live Writer.
//remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
//remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
//remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_filter( 'the_content', 'capital_P_dangit' ); // Get outta my Wordpress codez dangit!
remove_filter( 'the_title', 'capital_P_dangit' );
remove_filter( 'comment_text', 'capital_P_dangit' );
// Hide the version of WordPress you're running from source and RSS feed // Want to JUST remove it from the source? Try: remove_action('wp_head', 'wp_generator');
/*function hcwp_remove_version() {return '';}
add_filter('the_generator', 'hcwp_remove_version');*/
// This function removes the comment inline css
/*function twentyten_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'twentyten_remove_recent_comments_style' );*/

/**
 * Remove meta boxes from Post and Page Screens
 */
function customize_meta_boxes() {
   /* These remove meta boxes from POSTS */
  //remove_post_type_support("post","excerpt"); //Remove Excerpt Support
  //remove_post_type_support("post","author"); //Remove Author Support
  //remove_post_type_support("post","revisions"); //Remove Revision Support
  //remove_post_type_support("post","comments"); //Remove Comments Support
  //remove_post_type_support("post","trackbacks"); //Remove trackbacks Support
  //remove_post_type_support("post","editor"); //Remove Editor Support
  //remove_post_type_support("post","custom-fields"); //Remove custom-fields Support
  //remove_post_type_support("post","title"); //Remove Title Support

  
  /* These remove meta boxes from PAGES */
  //remove_post_type_support("page","revisions"); //Remove Revision Support
  //remove_post_type_support("page","comments"); //Remove Comments Support
  //remove_post_type_support("page","author"); //Remove Author Support
  //remove_post_type_support("page","trackbacks"); //Remove trackbacks Support
  //remove_post_type_support("page","custom-fields"); //Remove custom-fields Support
  
}
add_action('admin_init','customize_meta_boxes');

/**
 * This theme uses wp_nav_menus() for the header menu, utility menu and footer menu.
 */
register_nav_menus( array(
	'primary' => __( 'Primary Menu', 'themename' ),
	'footer' => __( 'Footer Menu', 'themename' ),
	'utility' => __( 'Utility Menu', 'themename' )
) );

/** 
 * Add default posts and comments RSS feed links to head
 */
add_theme_support( 'automatic-feed-links' );

/**
 * This theme uses post thumbnails
 */
add_theme_support( 'post-thumbnails' );

/**
 *	This theme supports editor styles
 */

//add_editor_style("/css/layout-style.css");

/**
 * Disable the admin bar in 3.1
 */
//show_admin_bar( false );

/**
 * This enables post formats. If you use this, make sure to delete any that you aren't going to use.
 */
//add_theme_support( 'post-formats', array( 'aside', 'audio', 'image', 'video', 'gallery', 'chat', 'link', 'quote', 'status' ) );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function handcraftedwp_widgets_init() {
	register_sidebar( array (
		'name' => __( 'Sidebar', 'themename' ),
		'id' => 'sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s" role="complementary">',
		'after_widget' => "</aside>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );
}
add_action( 'init', 'handcraftedwp_widgets_init' );

/*
 * Remove senseless dashboard widgets for non-admins. (Un)Comment or delete as you wish.
 */
function remove_dashboard_widgets() {
	global $wp_meta_boxes;

	//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']); // Plugins widget
	//unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']); // WordPress Blog widget
	//unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']); // Other WordPress News widget
	//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']); // Right Now widget
	//unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']); // Quick Press widget
	//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']); // Incoming Links widget
	//unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']); // Recent Drafts widget
	//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']); // Recent Comments widget
}

/**
 *	Hide Menu Items in Admin
 */
function themename_configure_dashboard_menu() {
	global $menu,$submenu;

	global $current_user;
	get_currentuserinfo();

		// $menu and $submenu will return all menu and submenu list in admin panel
		
		// $menu[2] = ""; // Dashboard
		// $menu[5] = ""; // Posts
		// $menu[15] = ""; // Links
		// $menu[25] = ""; // Comments
		// $menu[65] = ""; // Plugins

		// unset($submenu['themes.php'][5]); // Themes
		// unset($submenu['themes.php'][12]); // Editor
}


// For non-admins, add action to Hide Dashboard Widgets and Admin Menu Items you just set above
// Don't forget to comment out the admin check to see that changes :)
if (!current_user_can('manage_options')) {
	add_action('wp_dashboard_setup', 'remove_dashboard_widgets'); // Add action to hide dashboard widgets
	add_action('admin_head', 'themename_configure_dashboard_menu'); // Add action to hide admin menu items
}


?>
<?php // asynchronous google analytics: mathiasbynens.be/notes/async-analytics-snippet
//	 change the UA-XXXXX-X to be your site's ID
/*add_action('wp_footer', 'async_google_analytics');
function async_google_analytics() { ?>
	<script>
	var _gaq = [['_setAccount', 'UA-XXXXX-X'], ['_trackPageview']];
		(function(d, t) {
			var g = d.createElement(t),
				s = d.getElementsByTagName(t)[0];
			g.async = true;
			g.src = ('https:' == location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			s.parentNode.insertBefore(g, s);
		})(document, 'script');
	</script>
<?php }*/ 

//Read more link

function sr_excerpt_more($more) {
	global $post;
	return '...<span class="read-more"> <a href="'. get_permalink($post->ID) . '">read more</a></span>';
}
add_filter('excerpt_more', 'sr_excerpt_more');


function no_more_excerpt($postID, $class = '', $length = '250'){
	$excerpt = get_the_content($postID);
	$excerpt = sr_truncate($excerpt, $length, ' ');
	echo '<p class="' . $class . '">' . $excerpt . '</p>' ;
}

function sr_excerpt_length($length) {
	return 40;
}

add_filter('excerpt_length', 'sr_excerpt_length');

function sr_post_date() {
   global $post;
   if(get_post_type() == post){
		$d = 'j<\s\u\p>S</\s\u\p> F Y'; 
		$the_date = mysql2date($d, $post->post_date);
	}else{
		$d = 'l, j<\s\u\p>S</\s\u\p> F Y'; 
		$the_date = mysql2date($d, $post->post_date);
	}
	return $the_date;
}
add_filter('get_the_date', 'sr_post_date');


//Truncation

function sr_truncate($string, $limit, $break=0, $pad="...")
{	
	$string = strip_tags($string);
	// return with no change if string is shorter than $limit
	if(strlen($string) <= $limit) return $string;

	// is $break present between $limit and the end of the string?
	if(false !== ($breakpoint = strpos($string, $break, $limit))) {
		if($breakpoint < strlen($string) - 1) {
		  $string = substr($string, 0, $breakpoint) . $pad;
		}
	}
    
  return $string;
}

/*
=======================================================
POST TYPES
=======================================================
*/


add_action( 'init', 'type_taxon_init' );

function type_taxon_init() {

//Shows
  $labels = array(
    'name' => _x('Shows', 'post type general name'),
    'singular_name' => _x('Show', 'post type singular name'),
    'add_new' => _x('Add New', 'Show'),
    'add_new_item' => __('Add New Show'),
    'edit_item' => __('Edit Show'),
    'new_item' => __('New Show'),
    'all_items' => __('All Shows'),
    'view_item' => __('View Show'),
    'search_items' => __('Search Shows'),
    'not_found' =>  __('No shows found'),
    'not_found_in_trash' => __('No shows found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Shows'

  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => true,
    'menu_icon' => get_stylesheet_directory_uri() . '/css/menu-icons/calendar-list.png',
    'capability_type' => 'post',
    'has_archive' => true,
    'hierarchical' => false,
    'menu_position' => 6,
    'taxonomies' => array( 'artist' ),
    'supports' => array( 'title', 'editor', 'thumbnail')
  ); 
  register_post_type('show',$args);
  
// Artists
  $labels = array(
    'name' => _x('Artists', 'post type general name'),
    'singular_name' => _x('Artist', 'post type singular name'),
    'add_new' => _x('Add New', 'Artist'),
    'add_new_item' => __('Add New Artist'),
    'edit_item' => __('Edit Artist'),
    'new_item' => __('New Artist'),
    'all_items' => __('All Artists'),
    'view_item' => __('View Artist'),
    'search_items' => __('Search Artists'),
    'not_found' =>  __('No artists found'),
    'not_found_in_trash' => __('No artists found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Artists',
  );
  
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true,
    'menu_icon' => get_stylesheet_directory_uri() . '/css/menu-icons/cards-address.png',
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => 7,
    'supports' => array( 'title', 'editor', 'thumbnail' )
  ); 
  register_post_type('artist',$args);
  
// Releases
  $labels = array(
    'name' => _x('Releases', 'post type general name'),
    'singular_name' => _x('Release', 'post type singular name'),
    'add_new' => _x('Add New', 'Release'),
    'add_new_item' => __('Add New Release'),
    'edit_item' => __('Edit Release'),
    'new_item' => __('New Release'),
    'all_items' => __('All Releases'),
    'view_item' => __('View Release'),
    'search_items' => __('Search Releases'),
    'not_found' =>  __('No releases found'),
    'not_found_in_trash' => __('No releases found in Trash'), 
    'parent_item_colon' => '',
    'menu_name' => 'Releases',
  );
  
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'menu_icon' => get_stylesheet_directory_uri() . '/css/menu-icons/cassette.png',
    'rewrite' => true,
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => 8,
    'supports' => array( 'title', 'editor', 'thumbnail')
  ); 
  register_post_type('release',$args);
  
// Artist Taxonomy
  $labels = array(
    'name' => _x( 'Artist', 'taxonomy general name' ),
    'singular_name' => _x( 'Artist', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Artists' ),
    'all_items' => __( 'All Artists' ),
    'parent_item' => __( 'Parent Artists' ),
    'parent_item_colon' => __( 'Parent Artists:' ),
    'edit_item' => __( 'Edit Artist' ), 
    'update_item' => __( 'Update Artist' ),
    'add_new_item' => __( 'Add New Artist' ),
    'new_item_name' => __( 'New Genre Artist' ),
    'menu_name' => __( 'Artist' ),
  ); 	

  register_taxonomy('artist',array('post', 'release' , 'show'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'artist' ),
    'show_in_nav_menus' => false
  ));
}

/*
=======================================================
CUSTOM TYPE MANAGE PAGES
=======================================================
*/


/*
 * SHOWS
 */
 
add_filter("manage_edit-show_columns", "my_show_columns");
 
function my_show_columns($columns) //this function display the columns headings
{
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Title",
		"artists" => "Artist",
		"venue" => "Venue",
		"show_date" => "Show Date"
	);
	return $columns;
}
 
/*
 * Releases
 */

add_filter("manage_edit-release_columns", "my_release_columns");
 
function my_release_columns($columns) //this function display the columns headings
{
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Title",
		"artists" => "Artists",
		"release_date" => "Release Date"
	);
	return $columns;
}

/*
 * Artist
 */

add_filter("manage_edit-artist_columns", "my_artist_columns");
 
function my_artist_columns($columns) //this function display the columns headings
{
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Title",
		"status" => "Artist Status"
	);
	return $columns;
}

function my_custom_columns($column)
{
	global $post;
	switch ($column){
		case "ID": echo $post->ID; break;
		case "artists": echo get_the_term_list( $post->ID, 'artist', '', ', ', '' ); break;
		case "venue": echo get_post_meta($post->ID , '_sr_show-venue', true); break;
		case "show_date": echo get_post_meta($post->ID , '_sr_show-date', true); break;
		case "release_date" : echo get_post_meta($post->ID , '_sr_release-date', true); break;
		//case "releases" : echo sr_get_releases_list($post->ID); break;
		case "status" : sr_get_artist_status($post->ID); break;
	}
}

add_action("manage_posts_custom_column", "my_custom_columns");

//Get list of releases by artist

function sr_get_releases_list($post_id){
	$artist = basename(get_permalink($post_id));
	$args = array(
		'post_type' => 'release' ,
		'tax_query' => array(
			array(
				'taxonomy' => 'artist',
				'field' => 'slug',
				'terms' => $artist
			)
		)
	);

	$query = new WP_query($args);
	if( $query->have_posts() ): while ($query->have_posts() ): $query->the_post();
		echo '<a href="' . get_permalink() . '">' . get_the_title() . '</a></br>';
	endwhile; endif; wp_reset_postdata();
}

//Artist Status

function sr_get_artist_status($post_ID){
	$past = get_post_meta($post_ID , '_sr_present-past' , true); 
	if($past == 'past'){
		echo 'Past Artist</br>';
	};
	$publish = get_post_meta($post_ID, '_sr_publishing', true);
	if($publish == 'publishing'){
		echo 'Pusblished by Stolen';
	}
}

/*
=======================================================
AUTO ADD ARTIST TERM ON ARTIST TYPE PUBLISH
=======================================================
*/

//Create term on publish

function create_artist_term($post_ID) {
	$this_post = get_post($post_ID); 
	$title = $this_post->post_title;
	
	wp_insert_term($title, 'artist');
}

add_action('publish_artist', 'create_artist_term');

// Remove on delete Cannot get this to work

/*function delete_artist_term($post_ID) {
	
	$this_post = get_post($post_ID); 
	$title = $this_post->post_title;
	
	$term_Num = get_term_by('name' , $title , 'artist');
	
	echo $term_Num->term_id;
	//echo "Title: ".$term_Num['term_id'];
	//print_r ($term_Num);
	
	//wp_delete_term($term_Num->term_id, 'artist');
}

add_action('puslish_artist', 'delete_artist_term');*/

/*
=======================================================
IMAGE SIZES
=======================================================
*/

if ( function_exists( 'add_image_size' ) ) { 
	add_image_size( 'sr-twelvecol', 1217, 500, true );
	add_image_size( 'sr-eightcol', 801, 600, false );
	add_image_size( 'sr-sixcol', 592, 592, true );
	add_image_size( 'sr-show-sixcol', 592, 837, true );
	add_image_size( 'sr-fivecol', 487, 650, false );
	add_image_size( 'sr-art-fivecol', 487, 487, true );
	add_image_size( 'sr-fourcol', 384, 288, true );
	add_image_size( 'sr-media-fourcol', 384, 544, false );
	add_image_size( 'sr-art-fourcol', 384, 384, true );
	add_image_size( 'sr-show-fourcol', 384, 543, true );
	add_image_size( 'sr-show-fivecol', 487, 688, true );
	add_image_size( 'sr-twocol', 174, 174, true );
}

if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 100, 100, true );  
}



//END image sizes

/*
=======================================================
METABOXES	
=======================================================
*/

include_once WP_CONTENT_DIR . '/wpalchemy/MetaBox.php';
 
// global styles for the meta boxes
if (is_admin()) wp_enqueue_style('wpalchemy-metabox', get_stylesheet_directory_uri() . '/library/metaboxes/meta.css');


$featured_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_featured_post',
	'title' => 'Push to top of home page',
	'types' => array('post' , 'artist' , 'show' , 'release'),
	'context' => 'side',
	'priority' => 'low',
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'prefix' => '_sr_',
	'template' => get_stylesheet_directory() . '/library/metaboxes/featured-post-meta.php'
));

$artist_lnks_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_artist_lnks',
	'title' => 'Social Links',
	'types' => array('artist' , 'page'), 
	'context' => 'normal', 
	'priority' => 'high',
	'exclude_template' => array('page-publishing.php', 'page.php', 'page-front.php' , 'page-news.php', 'page-showsarchive.php' , 'page-media.php'),
	'template' => get_stylesheet_directory() . '/library/metaboxes/artist-links-meta.php'
));

$past_artist_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_past_artist',
	'title' => 'Artist Status',
	'types' => array('artist'),
	'context' => 'side',
	'priority' => 'low',
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'prefix' => '_sr_',
	'template' => get_stylesheet_directory() . '/library/metaboxes/past-artist-meta.php'
));

$show_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_show_details',
	'title' => 'Show Details',
	'types' => array('show'),
	'context' => 'normal',
	'priority' => 'high',
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'prefix' => '_sr_',
	'template' => get_stylesheet_directory() . '/library/metaboxes/shows-meta.php'
));

$release_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_release_details',
	'title' => 'Release Details',
	'types' => array('release'),
	'context' => 'normal',
	'priority' => 'high',
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'prefix' => '_sr_',
	'template' => get_stylesheet_directory() . '/library/metaboxes/release-meta.php'
));

$video_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_videos',
	'title' => 'Videos',
	'types' => array('release' , 'artist'),
	'context' => 'side',
	'priority' => 'low',
	'save_action' => 'video_save_action',
	'template' => get_stylesheet_directory() . '/library/metaboxes/videos-meta.php'
));

$tracks_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_tracks',
	'title' => 'Sample Tracks',
	'types' => array('release' , 'artist'),
	'context' => 'side',
	'priority' => 'low',
	'template' => get_stylesheet_directory() . '/library/metaboxes/tracks-meta.php'
));

$review_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_reviews',
	'title' => 'Reviews',
	'types' => array('artist' , 'release' , 'page'),
	'context' => 'normal',
	'priority' => 'low',
	'exclude_template' => array('page-publishing.php', 'page.php', 'page-front.php' , 'page-news.php', 'page-showsarchive.php' , 'page-media.php'),
	'template' => get_stylesheet_directory() . '/library/metaboxes/reviews-meta.php'
));

$thumb_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_thumbs_URL',
	'title' => 'Featured Video',
	'types' => array('post'),
	'context' => 'normal',
	'priority' => 'high',
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'prefix' => '_sr_',
	'template' => get_stylesheet_directory() . '/library/metaboxes/featured-video-meta.php'
));	

$playlist_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_stolen_playlist',
	'title' => 'Home Page Soundcloud',
	'context' => 'normal',
	'priority' => 'high',
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'prefix' => '_sr_',
	'include_template' => 'page-front.php',
	'template' => get_stylesheet_directory() . '/library/metaboxes/soundcloud-meta.php'
));

$footer_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_about_footer',
	'title' => 'HTML For Page Footer',
	'context' => 'normal',
	'priority' => 'high',
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'prefix' => '_sr_',
	'include_template' => 'page-about.php',
	'template' => get_stylesheet_directory() . '/library/metaboxes/footer-meta.php'
));

//jquery date-time picker on admin

function load_date_time_picker(){
	wp_register_script( 'datepicker', get_template_directory_uri() . '/js/jquery-ui-1.8.18.custom.min.js');
	wp_enqueue_script( 'datepicker' );
	
	wp_register_style('datepicker-css', get_template_directory_uri() . "/css/jquery-ui-1.8.18.custom.css");  
	wp_enqueue_style( 'datepicker-css');
	
	wp_register_script( 'timepicker', get_template_directory_uri() . '/js/jquery-ui-timepicker-addon.js');
	wp_enqueue_script( 'timepicker' );
	
	wp_register_style('timepicker-css', get_template_directory_uri() . "/css/jquery-ui-timepicker-addon.css");  
	wp_enqueue_style( 'timepicker-css'); 
	
	
}
add_action('admin_enqueue_scripts', 'load_date_time_picker');

//END metaboxes

/*
=======================================================
MARKUP	
=======================================================
*/


/*---------------------------------------------------
Releases + artists landing page
*/

function sr_relart_loop_markup(&$artists = array()){
	global $post;
	$sr_post_class = '';
	if('artist' == get_post_type()){
		$sr_post_class = get_post_meta(get_the_ID(),'_sr_present-past',TRUE);
		if ($sr_post_class == 'past'){
			$meta_blob = '<span class="artist-status">Past Artist</span>'; 
		}else{
			$artist_status = null;
			$meta_blob = null;
		}
	}else{
		$artist_tax = get_the_terms( $post->ID, 'artist' );
		foreach($artist_tax as $artist){
			$artist = array('title' => $artist->name , 'class' => $artist->slug);
			$sr_post_class .= $artist['class'] . ' ';
			if(!in_array($artist , $artists)){
				array_push($artists, $artist);	
			}
		}
		//$sr_post_class = $artists;
		/*$meta_blob = get_post_meta( $rel_id , '_sr_release-date', true);
		$meta_blob = date_create($meta_blob);
		$meta_blob = date_format($meta_blob, 'Y');
		$meta_blob = '<span class="artist-status">'. $meta_blob . '</span>';*/
		//$meta_blob = sr_get_rels_artist($post->ID);
	}
	$sr_post_class .= ' fourcol fancy-roll';
	?>
	
	<a href="<?php the_permalink(); ?>" <?php post_class($sr_post_class);?> title="<?php printf( esc_attr__( 'Permalink to %s', 'themename' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
		<?php sr_post_thumbnail('sr-art-fourcol' , false, 'null'); ?>
		<div class="info">
			<div class="wrap">
				<header class="entry-header">
					<h1 class="entry-title small-h"><?php the_title();?></h1>
					<?php if('artist' == get_post_type()){ echo $meta_blob; }else{sr_get_rels_artist($post->ID , false);} ?>
				</header><!-- .entry-header -->
				<div class="entry-summary">
					<?php
						$excerpt = get_the_content();
						if(strlen($excerpt) > 0):
							$excerpt = sr_truncate($excerpt, 250, ' ');
							echo '<p>' . $excerpt . '</p>';
							echo '<footer class="read-more button button-large">read more</footer>';
						else:
							global $review_mb;
							$meta = $review_mb->the_meta();
							$reviews = $meta['reviews'];
							if($reviews):
								$review_text = sr_truncate($reviews[0]['review-text'], 250, ' ');
								echo '<p>' . $review_text . '</p>';
								echo '<footer class="read-more button button-large">read more</footer>';
							endif;
						endif;
					?>
				</div>
			</div>
		</div>
	</a>
<?php }

/* END Releases + artists landing page
---------------------------------------------------*/


/*---------------------------------------------------
Shows
*/

function sr_shows_meta($post_ID){
	$datetime = get_post_meta($post_ID,'_sr_show-date',TRUE);
	$datetime = new DateTime($datetime);
	$date = $datetime->format('l, j<\s\u\p>S</\s\u\p> F Y');
	$time = $datetime->format('g:i<\s\u\p>A</\s\u\p> '); 
	$venue = get_post_meta($post_ID,'_sr_show-venue',TRUE);
	$venue_link = get_post_meta($post_ID,'_sr_show-venue-link',TRUE);
	$buy_tix = get_post_meta($post_ID,'_sr_buy-tickets-link',TRUE);
	$artist_terms = get_the_terms( $post_ID, 'artist' );
	$artists = array();
	foreach ($artist_terms as $artist_term)
	{
		$artist = get_page_by_title($artist_term->name , OBJECT, 'artist');
		$artist = array('ID' => $artist->ID , 'title' => $artist->post_title, 'guid' => $artist->guid);
		array_push($artists, $artist);
	}
	$artists_count = count($artists);
	$show_meta = array(
					'date' => $date ,
					'time' => $time ,
					'venue' => $venue ,
					'venue_link' => $venue_link ,
					'buy_tix' => $buy_tix ,
					'artists' => $artists ,
					'artist_count' => $artists_count);
					
	return $show_meta;
}

//Shows Page

function sr_shows_markup(){

	global $post;
	$show_meta = sr_shows_meta($post->ID);
	?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix contracted'); ?> role="article">
		<?php if($show_meta['buy_tix']): ?>
			<div class="show-img-gallery fivecol hide">
				<a href="<?php echo $show_meta['buy_tix']; ?>" title="Buy Tickets" rel="bookmark">
				<?php sr_shows_images($show_meta['artists']); ?>
				</a>
			</div><!--.show-img-gallery-->
		<?php else: ?>
			<div class="show-img-gallery fivecol hide">
			<?php sr_shows_images($show_meta['artists']); ?>
			</div><!--.show-img-gallery-->
		<?php endif; ?>
		<div class="info sevencol">
			<div>
				<header class="entry-header">
					<div class="entry-meta">
					<?php if($show_meta['venue_link'] && $show_meta['venue']):?>
						<span class="venue"><a href="<?php echo $show_meta['venue_link']; ?>" title="More info" rel="bookmark"><?php echo $show_meta['venue']; ?></a>:  </span>
					<?php elseif($show_meta['venue']): ?>
						<span class="venue"><?php echo $show_meta['venue']; ?>: </span>
					<?php elseif($show_meta['venue_link']):?>
						<span class="venue"><a href="<?php echo $show_meta['venue_link']; ?>" title="More info" rel="bookmark">
						<?php echo $show_meta['venue_link']; ?></a>: </span>
					<?php endif; ?>
					<time class="show-date">
						<?php echo $show_meta['date']; ?>
						<?php echo $show_meta['time']; ?>
					</time>
					</div>
					<h1 class="entry-title big-h">
						<?php 
						$artists = $show_meta['artists'];
						$artists_count = $show_meta['artist_count'];

						for ($i=0; $i < $artists_count; $i++):
							if($i < ($artists_count - 1)){ ?>
								<a href="<?php echo $artists[$i]['guid']; ?>" title="More about <?php echo $artists[$i]['title'];?>" rel="bookmark">
								<?php echo $artists[$i]['title'];?></a> + <?php
							} else{ ?>
								<a href="<?php echo $artists[$i]['guid']; ?>" title="More about <?php echo $artists[$i]['title'];?>" rel="bookmark">
								<?php echo $artists[$i]['title'];?></a>: <?php
							}
						endfor;
						
						the_title(); ?>
					</h1>
				</header><!-- .entry-header -->
			<div class="hide">	
				<div class="entry-summary">
					<?php no_more_excerpt($post->ID); ?>
				</div><!-- .entry-content -->
				
				<?php if($show_meta['buy_tix']): ?>
					<a class="button button-large buy-tickets" href="<?php echo $show_meta['buy_tix']; ?>" title="Buy Tickets" rel="bookmark">Buy Tickets</a>
				<?php endif; ?>
			</div>
		</div>
		</div><!--.info-->
	</article><!-- #post-<?php the_ID(); ?> -->
<?php }

//Shows Asides

function sr_show_aside_markup(){
	global $post;
	$show_meta = sr_shows_meta($post->ID);
	
	$h_tag = 'h3'; ?>
		<li id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
			<a href="<?php echo get_post_type_archive_link( 'show' ) . '#post-' . get_the_ID() ?>" class="block red-roll" title="Buy Tickets" rel="bookmark">
				<header class="entry-header">
					<div class="entry-meta">
					<?php if($show_meta['venue']): ?>
						<span class="venue faint"><?php echo $show_meta['venue']; ?>: </span>
					<?php endif; ?>
						<time class="show-date faint"><?php echo $show_meta['date']; ?></time>
					</div>
					<h3 class="entry-title">
						<?php 
						$artists = $show_meta['artists'];
						$artists_count = $show_meta['artist_count'];
						//print_r($artists);
						for ($i=0; $i < $artists_count; $i++):
							if($i < ($artists_count - 1)){ ?>
								<?php echo $artists[$i]['title'];?> + <?php
							} else{ ?>
								<?php echo $artists[$i]['title'];?>: <?php
							}
						endfor;
						the_title(); ?>
					</h3>
				</header><!-- .entry-header -->
			</a>
		</li><!-- #post-<?php the_ID(); ?> -->
<?php }


/* END Shows
---------------------------------------------------*/


/*---------------------------------------------------
Social links on artist page, about, nav
*/

function sr_social_links($stolen , $nav)
{	
	if($nav == false){
		global $artist_lnks_mb;
		$meta = $artist_lnks_mb->the_meta();
	}else{
		$meta = get_post_meta( 1614, _artist_lnks);
		$meta = $meta[0];
	}
	if($meta['artist_soc_links']){
		echo '<nav class="social-links">';
		echo '<ul>';
		if ($stolen == false){
			$artist_name = get_the_title();
		}else{
			$artist_name = 'Stolen';
		}
		foreach ($meta['artist_soc_links'] as $art_links_meta)
		{	
			$artist_link = $art_links_meta['art_social_a'];
			
			if(strpos($artist_link , 'facebook.com'))
			{
				$art_link_source = 'Facebook';
				
			}elseif (strpos($artist_link , 'twitter.com'))
			{	
				$art_link_source = 'Twitter';
				
			}elseif (strpos($artist_link , 'soundcloud.com'))
			{	
				$art_link_source = 'Soundcloud';
				
			}elseif (strpos($artist_link , 'bandcamp.com'))
			{	
				$art_link_source = 'Bandcamp';
				
			}elseif (strpos($artist_link , 'vimeo.com'))
			{	
				$art_link_source = 'Vimeo';
				
			}elseif (strpos($artist_link , 'youtu.be') || strpos($video_link , 'youtube.com'))
			{	
				$art_link_source = 'Youtube';
				
			}elseif (strpos($artist_link , 'myspace.com'))
			{	
				$art_link_source = 'Myspace';
				
			}elseif (strpos($artist_link , 'blogspot.com'))
			{	
				$art_link_source = 'Blogspot';
				
			}elseif (strpos($artist_link , 'tumblr.com'))
			{	
				$art_link_source = 'Tumblr';
				
			}elseif (strpos($artist_link , 'wordpress.com'))
			{	
				$art_link_source = 'Wordpress';
			}elseif (strpos($artist_link , 'flickr.com'))
			{	
				$art_link_source = 'Flickr';
			}else
			{
				$art_link_source = 'generic'; 
			}
			
			$art_link_class = strtolower($art_link_source);
			if($art_link_source != 'generic')
			{
				$art_link_title = $artist_name . ' on ' . $art_link_source;
			}else
			{
				$art_link_title = str_replace(array('http://' , 'www.' , '/') , '' , $artist_link);
			}
			echo '<li><a href="'. $artist_link .'" class="' . $art_link_class . '" title="' . $art_link_title . '" rel="bookmark" target="_blank">' . $art_link_title . '</a></li> ';  
		}
		echo '</ul>';
	echo '</nav><!--#social-links-->';
	}
}

/* END Social links
---------------------------------------------------*/


/*---------------------------------------------------
Pagination
*/


// loop page pagination
function sr_posts_navigation(){
	global $wp_query;
	if (  $wp_query->max_num_pages > 1 ) : ?>
		<nav id="nav-below" class="twelvecol" role="article">
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'themename' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'themename' ) ); ?></div>
		</nav><!-- #nav-below -->
	<?php endif; ?>
<?php }

// Single posts nav
function sr_single_post_navigation(){?>
	<nav id="nav-below" class="twelvecol" role="article">
		<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'themename' ) . '</span> %title' ); ?></div>
		<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'themename' ) . '</span>' ); ?></div>
	</nav><!-- #nav-below -->
<?php }


/* END Pagination
---------------------------------------------------*/


/*---------------------------------------------------
Post Header
*/

function _sr_post_header($tag = "h1" , $class = ''){
	global $post;?>
	<<?php echo $tag; ?>  class="entry-title <?php echo $class; ?> "><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'View %s', 'themename' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></<?php echo $tag; ?> >
<?php }

/* END Post Header
---------------------------------------------------*/



/*---------------------------------------------------
Asides
*/

//get artist releases

function sr_rels_by_artist($args = array() , $show_artist = false)
{	
	$defaults = array(
		'artist' => '',
		'thumb_size' => 'thumbnail',
		'limit' => '6',
		'buy_now' => true,
		'exclude' => '',
		'aside' => false,
		'title' => false,
	);
	
	$options = array_merge($defaults , $args);
	
	$query_args = array(
		'post_type' => 'release' ,
		'post_status' => 'publish',
		'posts_per_page' => $options['limit'] ,
		'post__not_in' => array($options['exclude']),
		'orderby' => 'meta_value',
		'meta_key' => '_sr_release-date'
	);
	if ($options['artist'] != ''){
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => 'artist',
				'field' => 'id',
				'terms' => $options['artist']
			)
		);
	}
	$rel_query = new WP_query($query_args);
	$aside = $options['aside'];
	if($aside == false)
	{
		if ($options['title'] == true){
			$wrapper_o = '<section id="releases" class="nested"><h2 class="section-header">Latest Releases</h2>';
		}else{
			$wrapper_o = '<section id="releases" class="clearfix">';
		}
		$wrapper_o .= '<div class="releases-wrap clearfix">';
		$wrapper_c = '</div><!--.releases-wrap--></section><!--#releases-->';
		$article_tag_o = '<article class="release twocol">';
		$article_tag_c = '</article>';
	}else{
		$wrapper_o = '<aside id="releases" class="fourcol"><h2 class="aside-header">More Releases</h2><ul class="artist-releases img-list">';
		$wrapper_c = '</ul></aside><!--#releases-->';
		$article_tag_o = '<li class="release">';
		$article_tag_c = '</li>';
		
	}
	if( $rel_query->have_posts() ):
		echo $wrapper_o;
		while ($rel_query->have_posts() ): $rel_query->the_post(); ?>
			<?php echo $article_tag_o;?>
				<?php $rel_id = get_the_ID(); ?>
				<a href="<?php the_permalink(); ?>" <?php if($aside == true){echo 'class="red-roll "'; }?>  title="<?php printf( esc_attr__( 'View %s', 'themename' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
				<div class="img-holder">
					<?php sr_post_thumbnail($options['thumb_size'] , false, 'null');?>
				</div>
				<?php //if($aside == true): ?>
				<div class="info">
				<?php //endif; ?>
					<h3 class="entry-title <?php echo $class; ?> "><?php the_title(); ?></h3> <?php
					if($show_artist == false):
						$release_date = get_post_meta( $rel_id , '_sr_release-date', true);						
						if ($release_date):
							$release_date = date_create($release_date);
							$release_date = date_format($release_date, 'Y');
							echo '<time class="release-date faint">' . $release_date . '</time>';
						endif;
					elseif($show_artist == true):	
							sr_get_rels_artist($post->ID, false, 'h3');
					endif; ?>
					<?php if($aside == true):?>
						<p class="faint">
						<?php
						$excerpt = get_the_content();
						$excerpt = sr_truncate($excerpt, 75, ' ');
						echo $excerpt; ?>
						</p>
					
					<?php endif; ?>
					</div><!--.info-->
					</a>
					<?php
					$buy_now_link = get_post_meta ( $rel_id , '_sr_release-buy-link' , true);
					
					if ($buy_now_link && $options['buy_now'])
					{
						$curr_date = date('Y-m-d');
						$release_date = get_post_meta( $rel_id , '_sr_release-date', true);
						if ($curr_date < $release_date)
						{
							echo '<a href="'.$buy_now_link .'" class="buy-link preorder button button-small">Preorder now</a>';
						}else
						{
							echo '<a href="'.$buy_now_link .'" class="buy-link buy-now button button-small">Buy Now</a>';
						}
					}?>
			<?php echo $article_tag_c; ?>
		<?php endwhile; 
		echo $wrapper_c;
		endif; wp_reset_query();
}

//Reviews

function sr_get_reivews($reviews)
{	
	/*$max_length = max(array_map('strlen', $reviews));
	print_r($max_length);*/
	
	/*foreach($reviews as $review)
	{
		$length = strlen($review['review-text']);
		if($length > $max_length){
			
	}*/
	function cmp($a, $b)
	{
		return strlen($b['review-text'])-strlen($a['review-text']);
	}
	usort($reviews, "cmp");
	
	foreach($reviews as $review)
	{	
		$review['review-text'] = sr_truncate($review['review-text'], 250, ' ');
		if($review['review-link']){
			$reviewlnk_o = '<a href="' . $review['review-link'] . '" rel="bookmark">';
			$reviewlnk_c = '</a>';
		}?>
		<div class="review">
			<div class="big-center">
				<blockquote><?php echo $review['review-text']; ?></blockquote>
				<cite> <?php echo $reviewlnk_o ?>
				<?php echo $review['review-attr']; ?>
				<?php echo $reviewlnk_c; ?></cite>
			</div>
		</div>
	<?php }
}

//Get 4 Shows by artist

function sr_aside_shows($artist, $home)
{
	$current_datetime = date('Y-m-d H:i');
	$meta_query_str = array(
		array(
			'key' => '_sr_show-date', 
			'compare' => '>=' ,
			'value' => $current_datetime
		)
	);
	
	$args = array(
		'posts_per_page' => '4' ,
		'post_type' => 'show' ,
		'artist' => $artist,
		'orderby' => 'meta_value',
		'meta_key' => '_sr_show-date' ,
		'order' => 'ASC' , 
		'meta_query' => $meta_query_str
	);
	
	$the_query = new WP_query($args);
	if($home == true){
		echo  '<aside id="shows"><h2 class="aside-header">Shows</h2><ul class="latest-shows txt-list ">';
	}else{
		echo '<aside id="shows" class="fourcol"><h2 class="aside-header">Shows</h2><ul class="txt-list red-roll">';
	}
	if ( $the_query->have_posts() ) :
		while ( $the_query->have_posts() ) : $the_query->the_post();?>
			<?php //sr_shows_markup(true);
				sr_show_aside_markup();
			?>
			
		<?php endwhile;
		$post_count = $the_query->found_posts;
		if($post_count > 4): ?>
			 <li>
				<a href="<?php echo get_post_type_archive_link( 'show' ); ?>" class="shows-page-link red-roll block" rel="bookmark" title="Stolen Records on Twitter">More Shows</a>
			</li>
		<?php endif;
	else: ?>
			
		<li id="no-shows" role="article">
			<a href="<?php echo get_twitter_link('false'); ?>" class="block red-roll" title="Follow us on twitter" rel="Bookmark">
				<header class="entry-header"><h3 class="entry-title">Sorry, no gigs coming up</h3></header>
				<p id="no-shows-msg" class="faint">Check back soon or follow us on Twitter for incessant updates</p>
			</a>
		</li>
		
	<?php endif; ?>
		</ul>
	</aside><!--#shows-->
	<?php wp_reset_query();
}

//Artist page sample tracks
function sr_artist_tracks($artist)
{	
	$tracks = array();
	global $tracks_mb;
	$meta = $tracks_mb->the_meta();
	$trackmeta = $meta['tracks'];
	
	if($trackmeta){
		foreach ($trackmeta as $track){
			$track = $track['track-link'];
			if (!in_array($track , $tracks)){
				array_push($tracks, $track);
			}
		}
	} 
	$args = $rel_args = array('post_type' => 'release' , 'artist' => $artist , 'posts_per_page' => '-1');
	$rel_query = new WP_query($rel_args);
		
	if(have_posts()): while ( $rel_query->have_posts() ) : $rel_query->the_post();
	
		$meta = $tracks_mb->the_meta();
		$trackmeta = $meta['tracks'];
	
		if($trackmeta){
			foreach ($trackmeta as $track){
				$track = $track['track-link'];
				if (!in_array($track , $tracks)){
					array_push($tracks, $track);
				}
			}
		} 
	
	endwhile; endif; wp_reset_query();
	
	$tracks_count = count($tracks);
	if($tracks_count > 7){
		$tracks = array_slice($tracks, 0, 7);
	}
	if(!empty($tracks)){
		echo '<aside id="tracks" class="fourcol"><h2 class="aside-header">Listen</h2>';
		echo '<div class="sc-player">';
		foreach ($tracks as $track)
		{	
			echo '<a href="' . $track . '" class="sample-track">' . $track . '</a>';
		}
		echo '</div></aside><!--#tracks-->';
	}
}

//Release page sample tracks

function sr_release_tracks()
{	
	$tracks = array();
	global $tracks_mb;
	$meta = $tracks_mb->the_meta();
	$trackmeta = $meta['tracks'];
	
	if($trackmeta){
		foreach ($trackmeta as $track){
			$track = $track['track-link'];
			if (!in_array($track , $tracks)){
				array_push($tracks, $track);
			}
		}
	} 
	$tracks_count = count($tracks);
	if($tracks_count > 7){
		$tracks = array_slice($tracks, 0, 7);
	}
	if(!empty($tracks)){
		echo '<aside id="tracks" class="fourcol"><h2 class="aside-header">Listen</h2>';
		echo '<div class="sc-player">';
		foreach ($tracks as $track)
		{	
			echo '<a href="' . $track . '" class="sample-track">' . $track . '</a>';
		}
		echo '</div></aside><!--#tracks-->';
	}
}

//Like button and facepile on home page
function sr_index_fb(){ ?>
	<div id="facebook">
		<iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FSTOLEN-RECORDINGS%2F66626039279&amp;width=292&amp;height=395&amp;colorscheme=light&amp;show_faces=false&amp;border_color=%23ffffff&amp;stream=true&amp;header=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:395px;" allowTransparency="true"></iframe>
	</div><!--#facebook-->
	<?php
}

// Get artist associated with release

function sr_get_rels_artist($postID , $link = true, $tag = 'h2'){

	$artist_terms = get_the_terms( $postID, 'artist' );
	$artists = array();
	foreach ($artist_terms as $artist_term)
	{	
		array_push($artists, $artist_term->term_id);
	}
	$artists_titles = array();
	foreach ($artist_terms as $artist_term)
	{	
		$artist_title = get_page_by_title($artist_term->name , OBJECT, 'artist');
		$artist_title = array('title' => $artist_title->post_title, 'guid' => $artist_title->guid);
		array_push($artists_titles, $artist_title);
	}
	
	$artists_titles_count = count($artists_titles);
	echo '<'. $tag .' class="entry-artists">';
	if($artists_titles_count <= 2):
		foreach($artists_titles as $artist_title): ?>
			<span class="entry-artist faint">
				<? if ($link == true): ?>
					<a href="<?php echo $artist_title['guid'];?>" title= "More about <?php echo 
					$artist_title['title']; ?>"><?php echo $artist_title['title']; ?></a>
				<? else:
					echo $artist_title['title'];
				endif; ?>
			</span> <?php
		endforeach;
	else: ?>
		<span class"entry-artist">Various Artists</span>
	<?php endif; //wp_reset_query();
	echo '</'. $tag .'>';
	return $artists;
}

/* END Asides
---------------------------------------------------*/
//END MARKUP


/*
=======================================================
VIDEO
=======================================================
*/


/*---------------------------------------------------
Home page latest videos
*/

function sr_latest_videos(){ ?>
	<div id="latest-videos">
			<!--<div id="embed"></div>-->
			<div id="thumbs">
				<ul class="img-list clearfix"></ul>
			</div>
	</div><!--#latest-videos-->
<?php }

/* END Home page latest videos
---------------------------------------------------*/

function vid_arr_constructor(&$videos, $artist){
	global $post;
	global $video_mb;
		$meta = $video_mb->the_meta();
		if($meta['videos']){
			$post_vids = $meta['videos'];
			//print_r($post_vids);
			foreach($post_vids as $video_link){
				$video = array('video_link' => $video_link['video-link'] , 'artist' => $artist);
				array_push($videos, $video);
			}
	}
}

/*---------------------------------------------------
Main video fetcher
*/

function sr_get_videos($videos){
	
	$i=0;
	$no_copy = array();
	$videos_count = count($videos);
	
	for($i = 0; $i < $videos_count; $i++)
	{	

		$video_link = $videos[$i]['video_link'];
		if(strpos($video_link , 'vimeo.com'))
		{	
			$video_id = substr($video_link , 17);
			if(!in_array($video_id , $no_copy)){
				$videos[$i]['id'] = $video_id;
				$videos[$i]['endpoint'] = 'http://vimeo.com/api/v2/video/' . $video_id  . '.xml';
				$videos[$i]['vendor'] = 'vimeo';
				$videos[$i]['embed'] = 'http://player.vimeo.com/video/' . $video_id . '?autoplay=1';
				$videos[$i]['is_valid'] = 'true';
				array_push($no_copy, $video_id);
			}else{
				//$videos[$i]['is_valid'] = 'false';
				unset($videos[$i]);
			}

		}elseif (strpos($video_link , 'youtu.be'))
		{	
			$video_id = substr($video_link , 16, 11);
			if(!in_array($video_id , $no_copy)){
				$videos[$i]['id'] = $video_id;
				$videos[$i]['endpoint'] = 'http://gdata.youtube.com/feeds/api/videos/' . $video_id;
				$videos[$i]['vendor'] = 'youtube';
				$videos[$i]['embed'] = 'http://www.youtube.com/embed/' . $video_id . '?autoplay=1&amp;wmode=transparent';
				$videos[$i]['is_valid'] = 'true';
				array_push($no_copy, $video_id);
			}else{
				//$videos[$i]['is_valid'] = 'false';
				unset($videos[$i]);
			}
		}elseif (strpos($video_link , 'youtube.com'))
		{
			$video_id = substr($video_link , 31 , 11);
			if(!in_array($video_id , $no_copy)){
				$videos[$i]['id'] = $video_id;
				$videos[$i]['endpoint'] = 'http://gdata.youtube.com/feeds/api/videos/' . $video_id ;
				$videos[$i]['vendor'] = 'youtube';
				$videos[$i]['embed'] = 'http://www.youtube.com/embed/' . $video_id . '?autoplay=1';
				$videos[$i]['is_valid'] = 'true';
				array_push($no_copy, $video_id);
			}else{
				//$videos[$i]['is_valid'] = 'false';
				unset($videos[$i]);
			}
		}else
		{
			//$videos[$i]['is_valid'] = 'false';
			unset($videos[$i]);
		}
	}
		
	$videos = array_values($videos);
	$videos_count = count($videos);
	
	//Fetching the data
	
	$curl_arr = array();
	$master = curl_multi_init();
	
	for($i = 0; $i < $videos_count; $i++)
	{
		$url = $videos[$i]['endpoint'];
		$curl_arr[$i] = curl_init($url);
		curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
		curl_multi_add_handle($master, $curl_arr[$i]);
	}
	
	do {
		curl_multi_exec($master,$running);
	} while($running > 0);
	
	//Poplulating results
	
	for($i = 0; $i < $videos_count; $i++)
	{	
		$vid_data = simplexml_load_string(curl_multi_getcontent  ( $curl_arr[$i]  ));
		//print_r($vid_data);
		if($videos[$i]['vendor'] == 'vimeo')
		{
			$vid_data = $vid_data->video;
			$videos[$i]['title'] = (string) $vid_data->title;
			$videos[$i]['thumbnail_large'] = (string) $vid_data->thumbnail_large;
			$videos[$i]['thumbnail_small'] = (string) $vid_data->thumbnail_small;
			if(strlen($vid_data->description) > 0){
				$videos[$i]['description'] = (string) strip_tags($vid_data->description);
				$videos[$i]['description'] = sr_truncate($videos[$i]['description'], 100, ' ');
			}else{
				$videos[$i]['description'] = '_empty_';
			}
		}elseif($videos[$i]['vendor'] == 'youtube')
		{
			$videos[$i]['title'] = (string) $vid_data->title;
			$videos[$i]['thumbnail_large'] = (string) 'http://img.youtube.com/vi/'. $videos[$i]['id'] .'/0.jpg';
			$videos[$i]['thumbnail_small'] = (string) 'http://img.youtube.com/vi/'. $videos[$i]['id'] .'/1.jpg';
			if(strlen($vid_data->content) > 0){
				$videos[$i]['description'] = (string) strip_tags($vid_data->content);
				$videos[$i]['description'] = sr_truncate($videos[$i]['description'], 100, ' ');
			}else{
				$videos[$i]['description'] = '_empty_';
			}
		}
	}
	return $videos;
}

/* END Main video fetcher
---------------------------------------------------*/


/*---------------------------------------------------
Media Page videos
*/

function sr_media_videos(&$dont_copy , $artist)
{
	global $post;
	global $video_mb;
	$meta = $video_mb->the_meta();
	if($meta['videos'])
	{	
		$videos = $meta['videos'];
		$videos_count = count($videos);
	
		for($i = 0; $i < $videos_count; $i++)
		{
			$videos[$i] = array('video_link' => $videos[$i] , 'artist' => $artist);
		}
		$videos = sr_get_videos($videos);
		//print_r($videos);
		foreach($videos as $video)
		{
			if($video['is_valid'] == 'true')
			{?>
					<a href="<?php echo $video['embed'] ?>" class="fancy-roll lightbox fancybox.iframe video <?php echo $video['vendor'] . ' ' . $artist; ?>" rel="gallery-media">
							<img src="<?php echo $video['thumbnail_large']?>" class="<?php echo $video['vendor'] ?>" />	
						<div class="info">
							<div class="wrap">
								<header class="entry-header">
									<h1 class="entry-title small-h"><?php echo $video['title'] ?></h1>
								</header>
								<?php if($video['description'] != '_empty_'):?>
									<div class="entry-summary">
										<p><?php echo $video['description'] ?></p>
									</div>
								<?php endif; ?>
								<div class="read-more button button-large">Click to watch</div>
							</div>
						</div>
					</a>
			<?php }
		}
		$video_count = count($videos);
		//var_dump($video_count);
		return $video_count;
	}else{
		return 0;
	}
}

/* END Media Page videos
---------------------------------------------------*/


/*---------------------------------------------------
Artist Page videos
*/

function sr_artist_videos($artist)
{
	$videos = array();
	$artist_title = get_the_title();
	$artist_class = basename(get_permalink());
	vid_arr_constructor($videos , $artist_class);
	
	$args = $rel_args = array('post_type' => 'release' , 'artist' => $artist , 'posts_per_page' => '-1');
	$rel_query = new WP_query($rel_args);
		
	if(have_posts()): while ( $rel_query->have_posts() ) : $rel_query->the_post();
		vid_arr_constructor($videos , $artist_class);
	endwhile; endif; wp_reset_query();
	
	$videos_count = count($videos);
	if($videos_count > 4){
		$videos = array_slice($videos, 0, 5);
	}
	if(!empty($videos)){
		echo '<aside id="videos" class="fourcol"><h2 class="aside-header">Videos</h2><ul class="img-list clearfix">';
		$videos = sr_get_videos($videos);
		video_aside_markup($videos);
		echo '</ul></aside><!--#videos-->';
	}
	
}

/* END Artist Page videos
---------------------------------------------------*/


/*---------------------------------------------------
Release videos
*/

function sr_release_videos()
{
	$videos = array();
	vid_arr_constructor($videos , $artist_class);
	
	$videos_count = count($videos);
	if($videos_count > 4){
		$videos = array_slice($videos, 0, 5);
		$more_vids = true;
	}else{
		$more_vids = false;
	}
	if(!empty($videos)){
		echo '<aside id="videos" class="fourcol"><h2 class="aside-header">Videos</h2><ul class="img-list clearfix">';
		$videos = sr_get_videos($videos);
		video_aside_markup($videos);
		if($more_vids == true): ?>
			<li>
				<a href="<?php echo home_url( 'videosphotos' ); ?>" class="shows-page-link red-roll block" rel="bookmark" title="Stolen Records on Twitter">More Videos</a>
			</li>
		<?php endif;
		echo '</ul></aside><!--#videos-->';
	}
	
}

/* END Release videos
---------------------------------------------------*/


/*---------------------------------------------------
Video Aside markup
*/
function video_aside_markup($videos)
{
	foreach($videos as $video)
	{
		if($video['is_valid'] == 'true')
		{?>
			<li class="<?php echo $video['vendor'] ?>">
				<a href="<?php echo $video['embed'] ?>" class="red-roll lightbox video fancybox.iframe <?php echo $video['vendor'] ?>" rel="gallery-vid-aside">
					<img src="<?php echo $video['thumbnail_small']?>" class="media-img" />
					<div class="info">
						<h3><?php echo $video['title'] ?></h3>
						<?php if($video['description'] != '_empty_'): ?>
						<p class="faint"><?php echo $video['description'] ?></p>
						<?php endif; ?>
					</div>
				</a>
			</li>
		<?php }
	}
}
/* END Video Aside markup
---------------------------------------------------*/
//END VIDEOS


/*
=======================================================
IMAGES
=======================================================
*/

/*---------------------------------------------------
Main attachtment fetcher
*/

function sr_get_images( $args = array() ) {
	
	global $post;
	
	$defaults = array(
		'size' => 'thumbnail', 
		'limit' => '0',
		'offset' => '0',
		'big' => 'large',
		'post_id' => $post->ID,
		'link' => 'self',
		'img_class' => 'attachment-image',
		'a_class' => 'lightbox fancy-roll',
		'a_rel' => '',
		'wrapper' => true,
		'wrapper_class' => 'attachment-image-wrapper',
		'include' => '',
		'exclude' => '',
		'lazy' => false
	);
	
	$options = array_merge( $defaults, $args );
	
	$size = $options['size'];
	$limit = $options['limit'];
	$offset = $options['offset'];
	$big = $options['big'];
	$link = $options['link'];
	$a_class = $options['a_class'];
	$a_rel = $options['a_rel'];
	$img_class = $options['img_class'];
	$wrapper = $options['wrapper'];
	$wrapper_class = $options['wrapper_class'];
	$lazy = $options['lazy'];
	
	$images = get_children( array(
		'post_parent' => $options['post_id'],
		'post_status' => 'inherit',
		'post_type' => 'attachment',
		'post_mime_type' => 'image',
		'order' => 'ASC',
		'orderby' => 'menu_order ID' ,
		'include' => $options['include'],
		'exclude' => $options['exclude']
	));
	
	//Adding parent title as class
	$parent_title = strtolower(get_the_title($options['post_id']));
	$parent_title_class = str_replace(' ', '-' , $parent_title);
	$img_class .= ' ' . $parent_title_class;
	$wrapper_class .= ' ' . $parent_title_class; 

	if ($images) {

		$num_of_images = count($images);
		
		if ($offset > 0) : $start = $offset--; else : $start = 0; endif;
		if ($limit > 0) : $stop = $limit+$start; else : $stop = $num_of_images; endif;

		$i = 0;
		foreach ($images as $attachment_id => $image) {
			if ($start <= $i and $i < $stop) {
			$img_title = $image->post_title;   // title.
			$img_description = $image->post_content; // description.
			$img_caption = $image->post_excerpt; // caption.
			//$img_page = get_permalink($image->ID); // The link to the attachment page.
			$img_alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
			if ($img_alt == '') {
			$img_alt = $img_title;
			}
				if ($big == 'large') {
				$big_array = image_downsize( $image->ID, $big );
 				$img_url = $big_array[0]; // large.
				} else {
				$img_url = wp_get_attachment_url($image->ID); // url of the full size image.
				}

			$img_src = wp_get_attachment_image_src($image->ID, $size);

			if($wrapper == true):?>
			<article class="<?php echo $wrapper_class ?>">
			<?php endif; ?>
			<?php if($link == 'self'):?>
			<a href="<?php echo $img_url; ?>" class="<?php echo $a_class; ?>" title="<?php echo $img_title; ?>" class="<?php echo $a_class; ?>" <?php if(!$a_rel == ''){echo 'rel="'. $a_rel .'"';}?>>
			<?php elseif($link == 'parent'):?>
			<a href="<?php the_permalink(); ?>" class="fancy-roll" title="<?php printf( esc_attr__( 'Permalink to %s', 'themename' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
			<?php endif; ?>
			<?php if(!$lazy): ?>
					<img class="<?php echo $img_class;?>" src="<?php echo $img_src[0]; ?>" alt="<?php echo $img_alt; ?>" title="<?php echo $img_title; ?>" />
			<?php else: ?>
				<div class="lazy-wrapper">
					<img class="<?php echo $img_class;?>" src="<?php echo get_template_directory_uri(); ?>/images/dark-grey.png" data-original="<?php echo $img_src[0]; ?>" width="<?php echo $img_src[1]; ?>" height="<?php echo $img_src[2]; ?>" alt="<?php echo $img_alt; ?>" title="<?php echo $img_title; ?>" />
				</div>
			<?php endif; ?>
			<?php if($link == 'self'):?>
				<div class="info">
					<div class="wrap">
						<span class="click-prompt zoom">Click to zoom</span>
					</div>
				</div>
				</a>
			<?php elseif($link == 'parent'): ?>
				<div class="info">
					<div class="wrap">
						<span class="click-prompt read"><?php echo get_the_title(); ?></span>
					</div>
				</div>
				</a>
			<?php endif; ?>
			<?php if($wrapper == true):?>
			</article>
			<?php endif; 
			// End custom image tag. Do not edit below here.
			///////////////////////////////////////////////////////////
			
			}
			$i++;
		}

	}else{
		return false;
	}
}

/* END Main attachtment fetcher
---------------------------------------------------*/

/*---------------------------------------------------
Image display
*/

// Default post thumbnail. Check for video, thumbnail, if not show first attachment
function sr_post_thumbnail($size , $show_video, $link, $wrapper = true)
{ 	
	global $post;
	if ($show_video == true && get_post_meta(get_the_ID(),'_sr_thumb-URL',TRUE)):
		$vid_link = get_post_meta(get_the_ID(),'_sr_thumb-URL',TRUE);
		$embed_code = wp_oembed_get($vid_link);
		echo '<div class="video">' . $embed_code . '</div>';	
	elseif (has_post_thumbnail()):
		$post_thumb = get_post_thumbnail_id();
		$options = array(	
			'size' => $size,
			'big' => 'full' ,
			'img_class' => 'post-thumb',
			'wrapper' => false ,
			'include' => $post_thumb,
			'link' => $link
		);
		sr_get_images($options);
	else:
		$options = array(
			'size' => $size,
			'big' => 'full' ,
			'img_class' => 'post-thumb',
			'wrapper' => false ,
			'limit' => '1',
			'link' => $link
		);
		sr_get_images($options);
	endif;
}

//Artist Page gallery. Thumbnail leads, if not set all images in menu order

function sr_artist_gallery($link = 'self'){
	global $post;
	$options = array(
			'size' => 'sr-twelvecol',
			//'a_class' => 'lightbox fancybox.image fancy-roll',
			'a_class' => 'lightbox fancy-roll photo',
			'img_class' => 'artist-header attachment-image',
			'wrapper' => false ,
			'a_rel' => 'gallery-artist',
			'link' => $link
	);
	if(has_post_thumbnail())
	{	
		$post_thumb = get_post_thumbnail_id();
	}else
	{
		$post_thumb = '';
	}
	$options['exclude'] = $post_thumb;
	sr_get_images($options);
	wp_reset_query();
}

//Shows image. Post thumb/flyer if not all artists
function sr_shows_images($artists)
{	
	$artist_count = count($artists);
	//$rand_artist = rand(1, $artist_count);
	$artist_id = $artists[0]['ID'];
	//echo '<p>' . $artist_id . '</p>';
	global $post;
	//echo '<div class="show-slider">';
		if (has_post_thumbnail()){
			the_post_thumbnail('sr-show-fivecol');
		}else{
			//$args = array('size' => 'sr-art-fivecol');
			//if(has_post_thumbnail($artist_id)){
				echo get_the_post_thumbnail( $artist_id, 'sr-art-fivecol' );
			/*}else{
				$options = array(
					'size' => 'sr-art-fivecol',
					'wrapper' => false ,
					'limit' => '1',
					'link' => 'none',
					'post_id' => $artist_id
				);
				sr_get_images($options);
			}*/
		}
	//echo '</div><!--.show-slider-->';
}
/*
End Image display
---------------------------------------------------*/

/*
=======================================================
Pages
=======================================================
*/

/*---------------------------------------------------
Global Nav
*/

function sr_global_nav()
{ ?>
	<nav id="access" role="article">
		<ul>
			<li><a href="<?php echo get_post_type_archive_link( 'artist' ); ?>" rel="address:<?php echo get_post_type_archive_link( 'artist' ); ?>">Artists</a>
				<ul class="artists-menu">
					<?php 
					$args = array('post_type' => 'artist' , 'posts_per_page' => '-1' , 'orderby' => 'title' , 'order' => 'ASC' , 'meta_key' => '_sr_present-past', 'meta_value' => 'current');
			
					$art_nav_query = new WP_Query($args);
					
					if ( $art_nav_query->have_posts() ) : while ( $art_nav_query->have_posts() ) : 
					$art_nav_query->the_post(); ?>
						<li><a href="<?php the_permalink(); ?>" class="art-nav-link" title="<?php echo get_the_title() . ' profile'; ?>" rel="address:<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
					<?php 
					endwhile;
					endif;?>
					</ul><ul><?php
					
					$args['meta_value'] = 'past';
					
					$art_nav_query = new WP_Query($args);
						
					if ( $art_nav_query->have_posts() ) : ?>
						<lh class="past-artist-header">past artists</lh>
					<?php while ( $art_nav_query->have_posts() ) : $art_nav_query->the_post(); ?>
						<li><a href="<?php the_permalink(); ?>" class="art-nav-link" title="<?php echo get_the_title() . ' profile'; ?>" rel="address:<?php the_permalink(); ?>"><?php the_title(); ?></a></li> 
					<?php endwhile;endif; wp_reset_query(); ?>
				</ul>
			</li>
			<li><a href="<?php echo get_post_type_archive_link( 'release' ); ?>" rel="address:/<?php echo get_post_type_archive_link( 'release' ); ?>">Releases</a></li>
			<li><a href="<?php echo get_post_type_archive_link( 'show' ); ?>" rel="address:<?php echo get_post_type_archive_link( 'show' ); ?>">Shows</a></li>
			<?php
				$args = array('meta_key' => '_sr_page', 'meta_value' => 'exclude');
				$exclude_pages = get_pages($args);
				foreach($exclude_pages as $page)
				{	
					$exclude_from_nav .= $page->ID . ',';
				}
				$args = array('exclude' => $exclude_from_nav, 'title_li' => '' , 'sort_column' => 'menu_order , post_title', 'echo' => false);
				$page_menu = get_pages($args);
				foreach ($page_menu as $page)
				{ ?>
					<li><a href="<?php echo $page->guid; ?>" title="Go to the <?php echo $page->post_title ?> Page" rel="address:<?php echo $page->guid; ?>"> 
					<?php echo $page->post_title; ?></a></li>
				<?php }
			?>
		</ul>
	</nav><!-- #access -->
<?php }

/* END Global Nav
---------------------------------------------------*/

/*---------------------------------------------------
Add pages on theme activation
*/

if (isset($_GET['activated']) && is_admin()){
	
	$sr_pages = array(
				array(
					'page_title' => 'Index',
					'page_template' => 'page-front.php',
					'menu_order' => 0,
					'exclude' => true),
				array(
					'page_title' => 'Stolen Shows Archive',
					'page_template' => 'page-showsarchive.php',
					'menu_order' => 0,
					'exclude' => true),
				array(
					'page_title' => 'News',
					'page_template' => 'page-news.php',
					'menu_order' => 2,
					'exclude' => false),
				array(
					'page_title' => 'Videos/Photos',
					'page_template' => 'page-media.php',
					'menu_order' => 4,
					'exclude' => false),
				array(
					'page_title' => 'Publishing',
					'page_template' => 'page-publishing.php',
					'menu_order' => 6,
					'exclude' => false),
				array(
					'page_title' => 'About',
					'page_template' => 'page-about.php',
					'menu_order' => 8,
					'exclude' => false),
		);
	$page_count = count($sr_pages);
	
	for($i=0; $i < $page_count; $i++)
	{
		$new_page = array(
			'post_type' => 'page',
			'post_title' => $sr_pages[$i]['page_title'],
			'post_content' => '',
			'post_status' => 'publish',
			'post_author' => 1,
			'menu_order' => $sr_pages[$i]['menu_order']
		);
		
		$new_page_id = wp_insert_post($new_page);
		update_post_meta($new_page_id, '_wp_page_template', $sr_pages[$i]['page_template']);
		
		if($sr_pages[$i]['exclude'] == true)
		{
			add_post_meta($new_page_id, '_sr_page', 'exclude', true);
		}else{
			add_post_meta($new_page_id, '_sr_page', 'include', true);
		}
		
		if($sr_pages[$i]['page_template'] == 'page-front.php')
		{
			update_option( 'page_on_front', $new_page_id );
			update_option( 'show_on_front', 'page' );
		}
		
		if($sr_pages[$i]['page_template'] == 'page-news.php')
		{
			update_option( 'page_for_posts', $new_page_id );
		}
	}
}

/* END Add pages on theme activation
---------------------------------------------------*/

//END PAGES

/*
=======================================================
MISC
=======================================================
*/

//Get twitter link
function get_twitter_link($echo = 'true'){
	$twitter_link = 'http://twitter.com/stolenrecs';
	if($echo == 'false'){
		return $twitter_link;
	}else{ ?>
	<a href="<?php echo $twitter_link ?>" title="Follow stolen on 	">Follow us on twitter</a>
	<?php }
}

// RSS shotcode
function sr_latest_tweets(){ ?>
	<div id="twitter"><?php
include_once(ABSPATH . WPINC . '/feed.php');

$rss = fetch_feed('http://twitter.com/statuses/user_timeline/20986653.rss');
if (!is_wp_error( $rss ) ) :
    $maxitems = $rss->get_item_quantity(4); 
    $rss_items = $rss->get_items(0, $maxitems); 
endif;
?>

<ul class="txt-list">
    <?php if ($maxitems == 0) echo '<li>No items.</li>';
    else
    foreach ( $rss_items as $item ) : 
    $time = $item->get_date('g:i A M jS');
    $time_rel = relativeTime($time, 86400 , 'l, j<\s\u\p>S</\s\u\p> F Y');
    $tweet_text = make_clickable( esc_html( $item->get_title() ) );
	?>
    <li class="tweet block">
    	<a href='<?php echo esc_url( $item->get_permalink() ); ?>'><time class="date tweet"><?php echo $time_rel; ?></time></a>
        <span class="tweet-text"><?php echo $tweet_text; ?></span>
    </li>
    <?php endforeach; ?>
    <li class="">
    	<a href="https://twitter.com/stolenrecs" class="twitter-link red-roll block" rel="bookmark" title="Stolen Records on Twitter">Follow @stolenrecs on Twitter</a>
    </li>
</ul>
	</div>
<?php }

//Relative Time
function relativeTime($time = false, $limit = 86400, $format = 'g:i A M jS') {
	if (empty($time) || (!is_string($time) && !is_numeric($time))) $time = time();
	elseif (is_string($time)) $time = strtotime($time);
	
		$now = time();
		$relative = '';
	
	if ($time === $now) $relative = 'now';
	elseif ($time > $now) $relative = 'in the future';
	else {
		$diff = $now - $time;
	
	if ($diff >= $limit) $relative = date($format, $time);
	elseif ($diff < 60) {
	$relative = 'less than one minute ago';
	} elseif (($minutes = ceil($diff/60)) < 60) {
		$relative = $minutes.' minute'.(((int)$minutes === 1) ? '' : 's').' ago';
	} else {
		$hours = ceil($diff/3600);
		$relative = 'about '.$hours.' hour'.(((int)$hours === 1) ? '' : 's').' ago';
	}
}

return $relative;
}

function sr_get_news_page_link(){
	$news_page = get_page_by_title( 'News' );
	sr_content_close($news_page->guid, 'News');	
}

//Tag Cloud

add_filter( 'widget_tag_cloud_args', 'my_widget_tag_cloud_args' );
function my_widget_tag_cloud_args( $args ) {
	$args['largest'] = 1;
	$args['smallest'] = 1;
	$args['number'] = 45;
	$args['unit'] = 'em';
	$args['format'] = 'list';
	return $args;
}

// Content close

function sr_content_close($link, $title){ ?>
	<a href="<?php echo $link; ?>" title="All <?php echo $title; ?>" class="content-close" rel="index"><span class="text"><span>All <?php echo $title; ?></span></span><span class="close-icon"></span></a>
<?php }

// String to CSS class name

function sr_make_class($string){
	//$string = "This is the string to be made SEO friendly!" 

	$class = preg_replace('/\%/',' percentage',$string); 
	$class = preg_replace('/\@/',' at ',$class); 
	$class = preg_replace('/\&/',' and ',$class); 
	$class = preg_replace('/\s[\s]+/','-',$class);    // Strip off multiple spaces 
	$class = preg_replace('/[\s\W]+/','-',$class);    // Strip off spaces and non-alpha-numeric 
	$class = preg_replace('/^[\-]+/','',$class); // Strip off the starting hyphens 
	$class = preg_replace('/[\-]+$/','',$class); // // Strip off the ending hyphens 
	$class = strtolower($class); 
	
	return $class; 
}


//jQuery

function my_scripts_method() {
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
    wp_enqueue_script( 'jquery' );
}    
 
add_action('wp_enqueue_scripts', 'my_scripts_method');

//END MISC
?>